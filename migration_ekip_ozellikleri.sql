-- ============================================
-- Quantro — Ekip gelismis ozellikler
-- Calistir: Supabase Dashboard -> SQL Editor -> Run
-- ============================================

-- 1) Ekip gorunum alanlari: renk + slogan
ALTER TABLE ekipler ADD COLUMN IF NOT EXISTS renk TEXT DEFAULT '#7c5cff';
ALTER TABLE ekipler ADD COLUMN IF NOT EXISTS slogan TEXT DEFAULT '';

-- 2) Uye cikarma: sadece lider silebilir
DROP POLICY IF EXISTS "leader_delete_ekip_uyeleri" ON ekip_uyeleri;
CREATE POLICY "leader_delete_ekip_uyeleri" ON ekip_uyeleri FOR DELETE USING (
  ekip_id IN (SELECT e.id FROM ekipler e WHERE e.olusturan_id = auth.uid())
);

-- 3) Ekip duyurulari (aktiviteler)
CREATE TABLE IF NOT EXISTS ekip_duyurular (
  id SERIAL PRIMARY KEY,
  ekip_id INTEGER REFERENCES ekipler(id) ON DELETE CASCADE,
  baslik TEXT NOT NULL,
  icerik TEXT DEFAULT '',
  yazar_email TEXT,
  olusturulma_tarihi TIMESTAMPTZ DEFAULT now()
);

ALTER TABLE ekip_duyurular ENABLE ROW LEVEL SECURITY;

DROP POLICY IF EXISTS "member_read_ekip_duyurular" ON ekip_duyurular;
CREATE POLICY "member_read_ekip_duyurular" ON ekip_duyurular FOR SELECT USING (
  ekip_id IN (SELECT e.id FROM ekipler e WHERE e.olusturan_id = auth.uid())
  OR ekip_id IN (SELECT ekip_id FROM ekip_uyeleri WHERE kullanici_email = auth.jwt()->>'email')
);

DROP POLICY IF EXISTS "member_insert_ekip_duyurular" ON ekip_duyurular;
CREATE POLICY "member_insert_ekip_duyurular" ON ekip_duyurular FOR INSERT WITH CHECK (
  ekip_id IN (SELECT e.id FROM ekipler e WHERE e.olusturan_id = auth.uid())
  OR ekip_id IN (SELECT ekip_id FROM ekip_uyeleri WHERE kullanici_email = auth.jwt()->>'email')
);

DROP POLICY IF EXISTS "member_update_ekip_duyurular" ON ekip_duyurular;
CREATE POLICY "member_update_ekip_duyurular" ON ekip_duyurular FOR UPDATE USING (
  ekip_id IN (SELECT e.id FROM ekipler e WHERE e.olusturan_id = auth.uid())
  OR ekip_id IN (SELECT ekip_id FROM ekip_uyeleri WHERE kullanici_email = auth.jwt()->>'email')
);

DROP POLICY IF EXISTS "leader_delete_ekip_duyurular" ON ekip_duyurular;
CREATE POLICY "leader_delete_ekip_duyurular" ON ekip_duyurular FOR DELETE USING (
  ekip_id IN (SELECT e.id FROM ekipler e WHERE e.olusturan_id = auth.uid())
);
