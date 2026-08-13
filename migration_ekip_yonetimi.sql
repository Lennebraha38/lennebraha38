-- ============================================
-- Quantro — Ekip Yonetimi v2
-- 1) Ekipler artik gizli: yalnizca lider ve davetli uyeler gorebilir
-- 2) E-posta ile davet sistemi (ekip_davetleri + token linki)
-- 3) Katilim yalnizca davet linki ile (acik "Katil" kaldirildi)
-- ============================================

-- 1. EKIP DAVETLERI
CREATE TABLE IF NOT EXISTS ekip_davetleri (
  id SERIAL PRIMARY KEY,
  ekip_id INT REFERENCES ekipler(id) ON DELETE CASCADE,
  email VARCHAR(120) NOT NULL,
  token VARCHAR(100) NOT NULL UNIQUE,
  davet_eden_email VARCHAR(120),
  durum VARCHAR(20) DEFAULT 'bekliyor', -- bekliyor | kabul
  olusturulma_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  kabul_tarihi TIMESTAMP
);

ALTER TABLE ekip_davetleri DROP CONSTRAINT IF EXISTS ekip_davetleri_tekil;
ALTER TABLE ekip_davetleri ADD CONSTRAINT ekip_davetleri_tekil UNIQUE (ekip_id, email);

CREATE INDEX IF NOT EXISTS ekip_davetleri_token_idx ON ekip_davetleri (token);

ALTER TABLE ekip_davetleri ENABLE ROW LEVEL SECURITY;

-- 2. RLS — EKIPLER (gizli: lider veya uye)
DROP POLICY IF EXISTS "public_read_ekipler" ON ekipler;
DROP POLICY IF EXISTS "member_read_ekipler" ON ekipler;
CREATE POLICY "member_read_ekipler" ON ekipler FOR SELECT USING (
  auth.role() = 'authenticated' AND (
    olusturan_id = auth.uid()
    OR EXISTS (SELECT 1 FROM ekip_uyeleri u WHERE u.ekip_id = ekipler.id AND u.kullanici_id = auth.uid())
  )
);

-- 3. RLS — EKIP UYELERI (gizli: lider veya kendi kaydi)
DROP POLICY IF EXISTS "public_read_ekip_uyeleri" ON ekip_uyeleri;
DROP POLICY IF EXISTS "member_read_ekip_uyeleri" ON ekip_uyeleri;
CREATE POLICY "member_read_ekip_uyeleri" ON ekip_uyeleri FOR SELECT USING (
  auth.role() = 'authenticated' AND (
    kullanici_id = auth.uid()
    OR ekip_id IN (SELECT id FROM ekipler WHERE olusturan_id = auth.uid())
  )
);

-- Katilim yalnizca davet ile (RPC uzerinden SECURITY DEFINER ekler),
-- lider kendi ekibine elle uye ekleyebilir
DROP POLICY IF EXISTS "auth_insert_ekip_uyeleri" ON ekip_uyeleri;
DROP POLICY IF EXISTS "invite_insert_ekip_uyeleri" ON ekip_uyeleri;
CREATE POLICY "invite_insert_ekip_uyeleri" ON ekip_uyeleri FOR INSERT WITH CHECK (
  auth.role() = 'authenticated' AND (
    ekip_id IN (SELECT id FROM ekipler WHERE olusturan_id = auth.uid())
    OR ekip_id IN (SELECT ekip_id FROM ekip_davetleri WHERE lower(email) = lower(auth.email()) AND durum = 'bekliyor')
  )
);

-- 4. RLS — GOREVLER (gizli: yalnizca ekibin lideri/uyeleri veya sahibi)
DROP POLICY IF EXISTS "public_read_gorevler" ON gorevler;
DROP POLICY IF EXISTS "member_read_gorevler" ON gorevler;
CREATE POLICY "member_read_gorevler" ON gorevler FOR SELECT USING (
  auth.role() = 'authenticated' AND (
    ekip_id IN (SELECT e.id FROM ekipler e WHERE e.olusturan_id = auth.uid())
    OR ekip_id IN (SELECT e.id FROM ekipler e JOIN ekip_uyeleri u ON u.ekip_id = e.id WHERE u.kullanici_id = auth.uid())
    OR (ekip_id IS NULL AND (olusturan_id = auth.uid() OR olusturan_id IS NULL))
  )
);

DROP POLICY IF EXISTS "auth_insert_gorevler" ON gorevler;
DROP POLICY IF EXISTS "member_insert_gorevler" ON gorevler;
CREATE POLICY "member_insert_gorevler" ON gorevler FOR INSERT WITH CHECK (
  auth.role() = 'authenticated' AND (
    ekip_id IS NULL
    OR ekip_id IN (SELECT e.id FROM ekipler e WHERE e.olusturan_id = auth.uid())
    OR ekip_id IN (SELECT e.id FROM ekipler e JOIN ekip_uyeleri u ON u.ekip_id = e.id WHERE u.kullanici_id = auth.uid())
  )
);

DROP POLICY IF EXISTS "owner_update_gorevler" ON gorevler;
DROP POLICY IF EXISTS "member_update_gorevler" ON gorevler;
CREATE POLICY "member_update_gorevler" ON gorevler FOR UPDATE USING (
  auth.role() = 'authenticated' AND (
    ekip_id IN (SELECT e.id FROM ekipler e WHERE e.olusturan_id = auth.uid())
    OR ekip_id IN (SELECT e.id FROM ekipler e JOIN ekip_uyeleri u ON u.ekip_id = e.id WHERE u.kullanici_id = auth.uid())
    OR (ekip_id IS NULL AND olusturan_id = auth.uid())
  )
);

DROP POLICY IF EXISTS "owner_delete_gorevler" ON gorevler;
DROP POLICY IF EXISTS "member_delete_gorevler" ON gorevler;
CREATE POLICY "member_delete_gorevler" ON gorevler FOR DELETE USING (
  auth.role() = 'authenticated' AND (
    ekip_id IN (SELECT e.id FROM ekipler e WHERE e.olusturan_id = auth.uid())
    OR ekip_id IN (SELECT e.id FROM ekipler e JOIN ekip_uyeleri u ON u.ekip_id = e.id WHERE u.kullanici_id = auth.uid())
    OR (ekip_id IS NULL AND olusturan_id = auth.uid())
  )
);

-- 5. RLS — EKIP DAVETLERI
DROP POLICY IF EXISTS "owner_read_ekip_davetleri" ON ekip_davetleri;
DROP POLICY IF EXISTS "leader_insert_ekip_davetleri" ON ekip_davetleri;
DROP POLICY IF EXISTS "leader_update_ekip_davetleri" ON ekip_davetleri;
DROP POLICY IF EXISTS "leader_delete_ekip_davetleri" ON ekip_davetleri;
CREATE POLICY "owner_read_ekip_davetleri" ON ekip_davetleri FOR SELECT USING (
  auth.role() = 'authenticated' AND (
    davet_eden_email = auth.email()
    OR lower(email) = lower(auth.email())
  )
);
CREATE POLICY "leader_insert_ekip_davetleri" ON ekip_davetleri FOR INSERT WITH CHECK (
  auth.role() = 'authenticated' AND davet_eden_email = auth.email()
  AND ekip_id IN (SELECT id FROM ekipler WHERE olusturan_id = auth.uid())
);
CREATE POLICY "leader_update_ekip_davetleri" ON ekip_davetleri FOR UPDATE USING (
  auth.role() = 'authenticated' AND davet_eden_email = auth.email()
  AND ekip_id IN (SELECT id FROM ekipler WHERE olusturan_id = auth.uid())
);
CREATE POLICY "leader_delete_ekip_davetleri" ON ekip_davetleri FOR DELETE USING (
  auth.role() = 'authenticated' AND davet_eden_email = auth.email()
  AND ekip_id IN (SELECT id FROM ekipler WHERE olusturan_id = auth.uid())
);

-- 6. DAVET KABUL RPC (SECURITY DEFINER: RLS'yi baypas eder, ama kontroller siki)
-- Cagiran: supabase.rpc('ekip_daveti_kabul', { p_token })
-- Sonuclar: 'kabul' | 'zaten_uye' | hatalar:
--   DAVET_BULUNAMADI, EPOSTA_ESLESMIYOR, EKIP_DOLU
CREATE OR REPLACE FUNCTION ekip_daveti_kabul(p_token TEXT)
RETURNS TEXT
LANGUAGE plpgsql SECURITY DEFINER SET search_path = public
AS $$
DECLARE
  v_invite ekip_davetleri%ROWTYPE;
  v_ekip ekipler%ROWTYPE;
BEGIN
  IF p_token IS NULL OR p_token = '' THEN
    RAISE EXCEPTION 'DAVET_BULUNAMADI';
  END IF;

  SELECT * INTO v_invite FROM ekip_davetleri WHERE token = p_token;
  IF NOT FOUND OR v_invite.durum <> 'bekliyor' THEN
    RAISE EXCEPTION 'DAVET_BULUNAMADI';
  END IF;

  IF lower(v_invite.email) <> lower(auth.email()) THEN
    RAISE EXCEPTION 'EPOSTA_ESLESMIYOR';
  END IF;

  SELECT * INTO v_ekip FROM ekipler WHERE id = v_invite.ekip_id;
  IF NOT FOUND THEN
    RAISE EXCEPTION 'DAVET_BULUNAMADI';
  END IF;

  -- Zaten uye mi?
  IF EXISTS (SELECT 1 FROM ekip_uyeleri WHERE ekip_id = v_invite.ekip_id AND lower(kullanici_email) = lower(auth.email())) THEN
    UPDATE ekip_davetleri SET durum = 'kabul', kabul_tarihi = now() WHERE id = v_invite.id;
    RETURN 'zaten_uye';
  END IF;

  -- Kontenjan dolu mu?
  IF v_ekip.uye_sayisi >= v_ekip.max_uye THEN
    RAISE EXCEPTION 'EKIP_DOLU';
  END IF;

  INSERT INTO ekip_uyeleri (ekip_id, kullanici_email, kullanici_id, rol)
  VALUES (v_invite.ekip_id, auth.email(), auth.uid(), 'uye');

  UPDATE ekipler SET uye_sayisi = uye_sayisi + 1 WHERE id = v_invite.ekip_id;
  UPDATE ekip_davetleri SET durum = 'kabul', kabul_tarihi = now() WHERE id = v_invite.id;

  RETURN 'kabul';
END;
$$;

GRANT EXECUTE ON FUNCTION ekip_daveti_kabul(TEXT) TO authenticated;

-- 7. REALTIME (ekip_uyeleri anlik uye listesi icin)
DO $$ BEGIN
  ALTER PUBLICATION supabase_realtime ADD TABLE ekip_uyeleri;
EXCEPTION WHEN duplicate_object THEN NULL; END $$;
