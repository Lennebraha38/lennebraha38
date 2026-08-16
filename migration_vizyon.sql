-- ============================================
-- Quantro — Vizyon Paketi Migration
-- Calistir: Supabase Dashboard -> SQL Editor -> Run
-- Idempotent: guvenle tekrar calistirilabilir
-- ============================================

-- ============ 1. XP / GAMIFICATION ============
CREATE TABLE IF NOT EXISTS kpuanlar (
  id SERIAL PRIMARY KEY,
  kullanici_id UUID REFERENCES auth.users(id) ON DELETE CASCADE,
  olay VARCHAR(60) NOT NULL,
  xp INTEGER NOT NULL,
  tarih TIMESTAMPTZ DEFAULT now()
);
CREATE INDEX IF NOT EXISTS kpuanlar_kullanici_idx ON kpuanlar (kullanici_id);
ALTER TABLE kpuanlar ENABLE ROW LEVEL SECURITY;
DROP POLICY IF EXISTS "kpuanlar_read" ON kpuanlar;
CREATE POLICY "kpuanlar_read" ON kpuanlar FOR SELECT USING (auth.role() = 'authenticated');
DROP POLICY IF EXISTS "kpuanlar_insert" ON kpuanlar;
CREATE POLICY "kpuanlar_insert" ON kpuanlar FOR INSERT WITH CHECK (auth.role() = 'authenticated' AND kullanici_id = auth.uid());

CREATE OR REPLACE VIEW xp_toplam AS
  SELECT kullanici_id, SUM(xp) AS xp, COUNT(DISTINCT olay) AS olay_sayisi, MAX(tarih) AS son_aktivite
  FROM kpuanlar GROUP BY kullanici_id;

-- Rozetler
CREATE TABLE IF NOT EXISTS rozetler (
  id SERIAL PRIMARY KEY,
  kullanici_id UUID REFERENCES auth.users(id) ON DELETE CASCADE,
  kod VARCHAR(40) NOT NULL,
  tarih TIMESTAMPTZ DEFAULT now(),
  CONSTRAINT rozetler_tekil UNIQUE (kullanici_id, kod)
);
ALTER TABLE rozetler ENABLE ROW LEVEL SECURITY;
DROP POLICY IF EXISTS "rozetler_read" ON rozetler;
CREATE POLICY "rozetler_read" ON rozetler FOR SELECT USING (auth.role() = 'authenticated');
DROP POLICY IF EXISTS "rozetler_insert" ON rozetler;
CREATE POLICY "rozetler_insert" ON rozetler FOR INSERT WITH CHECK (auth.role() = 'authenticated' AND kullanici_id = auth.uid());

-- ============ 2. YARISMA BASVURU TAKIP ============
CREATE TABLE IF NOT EXISTS yarisma_basvurulari (
  id SERIAL PRIMARY KEY,
  kullanici_id UUID REFERENCES auth.users(id) ON DELETE CASCADE,
  yarisma_ad VARCHAR(120) NOT NULL,
  kategori VARCHAR(80) DEFAULT '',
  takim_ad VARCHAR(120) DEFAULT '',
  durum VARCHAR(30) DEFAULT 'taslak', -- taslak | basvuruldu | on-eleme | final | elendi
  rapor_tarihi DATE,
  sonuc VARCHAR(80) DEFAULT '',
  notlar TEXT DEFAULT '',
  tarih TIMESTAMPTZ DEFAULT now()
);
ALTER TABLE yarisma_basvurulari ENABLE ROW LEVEL SECURITY;
DROP POLICY IF EXISTS "basvuru_select" ON yarisma_basvurulari;
CREATE POLICY "basvuru_select" ON yarisma_basvurulari FOR SELECT USING (auth.role() = 'authenticated');
DROP POLICY IF EXISTS "basvuru_insert" ON yarisma_basvurulari;
CREATE POLICY "basvuru_insert" ON yarisma_basvurulari FOR INSERT WITH CHECK (auth.role() = 'authenticated' AND kullanici_id = auth.uid());
DROP POLICY IF EXISTS "basvuru_update" ON yarisma_basvurulari;
CREATE POLICY "basvuru_update" ON yarisma_basvurulari FOR UPDATE USING (kullanici_id = auth.uid());
DROP POLICY IF EXISTS "basvuru_delete" ON yarisma_basvurulari;
CREATE POLICY "basvuru_delete" ON yarisma_basvurulari FOR DELETE USING (kullanici_id = auth.uid());

-- ============ 3. PROJELER (post-event) ============
CREATE TABLE IF NOT EXISTS projeler (
  id SERIAL PRIMARY KEY,
  kullanici_id UUID REFERENCES auth.users(id) ON DELETE CASCADE,
  ekip_id INTEGER REFERENCES ekipler(id) ON DELETE SET NULL,
  ad VARCHAR(140) NOT NULL,
  asama VARCHAR(20) DEFAULT 'fikir', -- fikir | spec | mvp | yayinda | yatirimci
  aciklama TEXT DEFAULT '',
  etiketler VARCHAR(160) DEFAULT '',
  demo_url VARCHAR(240) DEFAULT '',
  guncelleme TIMESTAMPTZ DEFAULT now(),
  tarih TIMESTAMPTZ DEFAULT now()
);
ALTER TABLE projeler ENABLE ROW LEVEL SECURITY;
DROP POLICY IF EXISTS "projeler_read" ON projeler;
CREATE POLICY "projeler_read" ON projeler FOR SELECT USING (auth.role() = 'authenticated');
DROP POLICY IF EXISTS "projeler_insert" ON projeler;
CREATE POLICY "projeler_insert" ON projeler FOR INSERT WITH CHECK (auth.role() = 'authenticated' AND kullanici_id = auth.uid());
DROP POLICY IF EXISTS "projeler_update" ON projeler;
CREATE POLICY "projeler_update" ON projeler FOR UPDATE USING (kullanici_id = auth.uid());
DROP POLICY IF EXISTS "projeler_delete" ON projeler;
CREATE POLICY "projeler_delete" ON projeler FOR DELETE USING (kullanici_id = auth.uid());

-- ============ 4. MENTORLAR ============
CREATE TABLE IF NOT EXISTS mentorlar (
  id SERIAL PRIMARY KEY,
  kullanici_id UUID REFERENCES auth.users(id) ON DELETE CASCADE,
  ad VARCHAR(120) NOT NULL,
  unvan VARCHAR(140) DEFAULT '',
  alanlar VARCHAR(200) DEFAULT '',
  deneyim VARCHAR(300) DEFAULT '',
  tanitim TEXT DEFAULT '',
  musait VARCHAR(120) DEFAULT '',
  onayli BOOLEAN DEFAULT false,
  tarih TIMESTAMPTZ DEFAULT now()
);
ALTER TABLE mentorlar ENABLE ROW LEVEL SECURITY;
DROP POLICY IF EXISTS "mentorlar_read" ON mentorlar;
CREATE POLICY "mentorlar_read" ON mentorlar FOR SELECT USING (auth.role() = 'authenticated');
DROP POLICY IF EXISTS "mentorlar_insert" ON mentorlar;
CREATE POLICY "mentorlar_insert" ON mentorlar FOR INSERT WITH CHECK (auth.role() = 'authenticated' AND kullanici_id = auth.uid());
DROP POLICY IF EXISTS "mentorlar_update" ON mentorlar;
CREATE POLICY "mentorlar_update" ON mentorlar FOR UPDATE USING (kullanici_id = auth.uid());
DROP POLICY IF EXISTS "mentorlar_delete" ON mentorlar;
CREATE POLICY "mentorlar_delete" ON mentorlar FOR DELETE USING (kullanici_id = auth.uid());

-- Mentor talep/eslesme
CREATE TABLE IF NOT EXISTS mentor_eslesmeleri (
  id SERIAL PRIMARY KEY,
  mentor_id INTEGER REFERENCES mentorlar(id) ON DELETE CASCADE,
  kullanici_id UUID REFERENCES auth.users(id) ON DELETE CASCADE,
  mesaj VARCHAR(400) DEFAULT '',
  durum VARCHAR(20) DEFAULT 'bekliyor', -- bekliyor | kabul | red
  tarih TIMESTAMPTZ DEFAULT now()
);
ALTER TABLE mentor_eslesmeleri ENABLE ROW LEVEL SECURITY;
DROP POLICY IF EXISTS "m_eslesme_select" ON mentor_eslesmeleri;
CREATE POLICY "m_eslesme_select" ON mentor_eslesmeleri FOR SELECT USING (auth.role() = 'authenticated');
DROP POLICY IF EXISTS "m_eslesme_insert" ON mentor_eslesmeleri;
CREATE POLICY "m_eslesme_insert" ON mentor_eslesmeleri FOR INSERT WITH CHECK (auth.role() = 'authenticated' AND kullanici_id = auth.uid());
DROP POLICY IF EXISTS "m_eslesme_update" ON mentor_eslesmeleri;
CREATE POLICY "m_eslesme_update" ON mentor_eslesmeleri FOR UPDATE USING (
  kullanici_id = auth.uid()
  OR mentor_id IN (SELECT id FROM mentorlar WHERE kullanici_id = auth.uid())
);

-- ============ 5. FORUM ============
CREATE TABLE IF NOT EXISTS forum_konulari (
  id SERIAL PRIMARY KEY,
  baslik VARCHAR(160) NOT NULL,
  icerik TEXT DEFAULT '',
  kullanici_id UUID REFERENCES auth.users(id) ON DELETE CASCADE,
  etiket VARCHAR(40) DEFAULT 'genel', -- genel | yarisma | takim | mentorluk | duyuru
  cevap_sayisi INTEGER DEFAULT 0,
  tarih TIMESTAMPTZ DEFAULT now()
);
ALTER TABLE forum_konulari ENABLE ROW LEVEL SECURITY;
DROP POLICY IF EXISTS "fkonu_select" ON forum_konulari;
CREATE POLICY "fkonu_select" ON forum_konulari FOR SELECT USING (auth.role() = 'authenticated');
DROP POLICY IF EXISTS "fkonu_insert" ON forum_konulari;
CREATE POLICY "fkonu_insert" ON forum_konulari FOR INSERT WITH CHECK (auth.role() = 'authenticated' AND kullanici_id = auth.uid());
DROP POLICY IF EXISTS "fkonu_delete" ON forum_konulari;
CREATE POLICY "fkonu_delete" ON forum_konulari FOR DELETE USING (kullanici_id = auth.uid());

CREATE TABLE IF NOT EXISTS forum_cevaplari (
  id SERIAL PRIMARY KEY,
  konu_id INTEGER REFERENCES forum_konulari(id) ON DELETE CASCADE,
  icerik TEXT NOT NULL,
  kullanici_id UUID REFERENCES auth.users(id) ON DELETE CASCADE,
  tarih TIMESTAMPTZ DEFAULT now()
);
ALTER TABLE forum_cevaplari ENABLE ROW LEVEL SECURITY;
DROP POLICY IF EXISTS "fcevap_select" ON forum_cevaplari;
CREATE POLICY "fcevap_select" ON forum_cevaplari FOR SELECT USING (auth.role() = 'authenticated');
DROP POLICY IF EXISTS "fcevap_insert" ON forum_cevaplari;
CREATE POLICY "fcevap_insert" ON forum_cevaplari FOR INSERT WITH CHECK (auth.role() = 'authenticated' AND kullanici_id = auth.uid());

-- ============ 6. DM (mesajlasma) ============
CREATE TABLE IF NOT EXISTS dm_mesajlari (
  id SERIAL PRIMARY KEY,
  gonderen_id UUID REFERENCES auth.users(id) ON DELETE CASCADE,
  alici_email VARCHAR(120) NOT NULL,
  icerik TEXT NOT NULL,
  okundu BOOLEAN DEFAULT false,
  tarih TIMESTAMPTZ DEFAULT now()
);
ALTER TABLE dm_mesajlari ENABLE ROW LEVEL SECURITY;
DROP POLICY IF EXISTS "dm_select" ON dm_mesajlari;
CREATE POLICY "dm_select" ON dm_mesajlari FOR SELECT USING (auth.role() = 'authenticated' AND (gonderen_id = auth.uid() OR alici_email = auth.email()));
DROP POLICY IF EXISTS "dm_insert" ON dm_mesajlari;
CREATE POLICY "dm_insert" ON dm_mesajlari FOR INSERT WITH CHECK (auth.role() = 'authenticated' AND gonderen_id = auth.uid());
DROP POLICY IF EXISTS "dm_update" ON dm_mesajlari;
CREATE POLICY "dm_update" ON dm_mesajlari FOR UPDATE USING (alici_email = auth.email());

-- ============ 7. HALK OYLAMASI ============
CREATE TABLE IF NOT EXISTS halk_oylari (
  id SERIAL PRIMARY KEY,
  kullanici_id UUID REFERENCES auth.users(id) ON DELETE CASCADE,
  yarisma_ad VARCHAR(120) NOT NULL,
  proje_ad VARCHAR(140) NOT NULL,
  tarih TIMESTAMPTZ DEFAULT now(),
  CONSTRAINT oy_tekil UNIQUE (kullanici_id, yarisma_ad, proje_ad)
);
ALTER TABLE halk_oylari ENABLE ROW LEVEL SECURITY;
DROP POLICY IF EXISTS "oy_select" ON halk_oylari;
CREATE POLICY "oy_select" ON halk_oylari FOR SELECT USING (auth.role() = 'authenticated');
DROP POLICY IF EXISTS "oy_insert" ON halk_oylari;
CREATE POLICY "oy_insert" ON halk_oylari FOR INSERT WITH CHECK (auth.role() = 'authenticated' AND kullanici_id = auth.uid());
DROP POLICY IF EXISTS "oy_delete" ON halk_oylari;
CREATE POLICY "oy_delete" ON halk_oylari FOR DELETE USING (kullanici_id = auth.uid());

-- ============ 8. SERTIFIKALAR ============
CREATE TABLE IF NOT EXISTS sertifikalar (
  id SERIAL PRIMARY KEY,
  kullanici_id UUID REFERENCES auth.users(id) ON DELETE CASCADE,
  kullanici_ad VARCHAR(120) DEFAULT '',
  baslik VARCHAR(200) NOT NULL,
  derece VARCHAR(60) DEFAULT '',
  token VARCHAR(80) NOT NULL UNIQUE,
  tarih TIMESTAMPTZ DEFAULT now()
);
ALTER TABLE sertifikalar ENABLE ROW LEVEL SECURITY;
DROP POLICY IF EXISTS "sertifika_select" ON sertifikalar;
CREATE POLICY "sertifika_select" ON sertifikalar FOR SELECT USING (auth.role() = 'authenticated');
DROP POLICY IF EXISTS "sertifika_insert" ON sertifikalar;
CREATE POLICY "sertifika_insert" ON sertifikalar FOR INSERT WITH CHECK (auth.role() = 'authenticated' AND kullanici_id = auth.uid());
DROP POLICY IF EXISTS "sertifika_update" ON sertifikalar;
CREATE POLICY "sertifika_update" ON sertifikalar FOR UPDATE USING (kullanici_id = auth.uid());

-- ============ 9. ILAN BASVURULARI ============
CREATE TABLE IF NOT EXISTS ilan_basvurulari (
  id SERIAL PRIMARY KEY,
  ilan_id INTEGER REFERENCES ilanlar(id) ON DELETE CASCADE,
  kullanici_email VARCHAR(120) NOT NULL,
  mesaj TEXT DEFAULT '',
  durum VARCHAR(20) DEFAULT 'yeni', -- yeni | goruldu | kabul | red
  tarih TIMESTAMPTZ DEFAULT now()
);
ALTER TABLE ilan_basvurulari ENABLE ROW LEVEL SECURITY;
DROP POLICY IF EXISTS "ib_select" ON ilan_basvurulari;
CREATE POLICY "ib_select" ON ilan_basvurulari FOR SELECT USING (auth.role() = 'authenticated' AND (kullanici_email = auth.email() OR ilan_id IN (SELECT id FROM ilanlar WHERE eposta = auth.email())));
DROP POLICY IF EXISTS "ib_insert" ON ilan_basvurulari;
CREATE POLICY "ib_insert" ON ilan_basvurulari FOR INSERT WITH CHECK (auth.role() = 'authenticated' AND kullanici_email = auth.email());
DROP POLICY IF EXISTS "ib_update" ON ilan_basvurulari;
CREATE POLICY "ib_update" ON ilan_basvurulari FOR UPDATE USING (ilan_id IN (SELECT id FROM ilanlar WHERE eposta = auth.email()));

-- ============ 10. PROFILLER 'ariyorum' + tamamlik ============
ALTER TABLE profiller ADD COLUMN IF NOT EXISTS ariyorum VARCHAR(200) DEFAULT '';
ALTER TABLE profiller ADD COLUMN IF NOT EXISTS github VARCHAR(160) DEFAULT '';
ALTER TABLE profiller ADD COLUMN IF NOT EXISTS linkedin VARCHAR(160) DEFAULT '';

-- ============ 11. GOREVLER duzeltme kolonlari ============
ALTER TABLE gorevler ADD COLUMN IF NOT EXISTS durum VARCHAR(20) DEFAULT 'acik';

-- ============ 12. REALTIME ============
DO $$ BEGIN
  ALTER PUBLICATION supabase_realtime ADD TABLE dm_mesajlari;
EXCEPTION WHEN duplicate_object THEN NULL; END $$;
DO $$ BEGIN
  ALTER PUBLICATION supabase_realtime ADD TABLE forum_cevaplari;
EXCEPTION WHEN duplicate_object THEN NULL; END $$;

-- ============ 13. XP EKLEME RPC (kullanicinin kendisi ekleyebilir, tekrari onler) ============
CREATE OR REPLACE FUNCTION xp_ekle(p_olay TEXT, p_xp INTEGER)
RETURNS TEXT
LANGUAGE plpgsql SECURITY DEFINER SET search_path = public
AS $$
BEGIN
  IF p_xp < 0 OR p_xp > 100 THEN RETURN 'PUAN_LIMIT'; END IF;
  IF EXISTS (SELECT 1 FROM kpuanlar WHERE kullanici_id = auth.uid() AND olay = p_olay AND tarih > now() - interval '12 hours') THEN
    RETURN 'TEKRAR';
  END IF;
  INSERT INTO kpuanlar (kullanici_id, olay, xp) VALUES (auth.uid(), p_olay, p_xp);
  RETURN 'OK';
END;
$$;
GRANT EXECUTE ON FUNCTION xp_ekle(TEXT, INTEGER) TO authenticated;

-- ============ 14. ROZET VERME RPC ============
CREATE OR REPLACE FUNCTION rozet_ver(p_kod TEXT)
RETURNS TEXT
LANGUAGE plpgsql SECURITY DEFINER SET search_path = public
AS $$
BEGIN
  INSERT INTO rozetler (kullanici_id, kod) VALUES (auth.uid(), p_kod)
  ON CONFLICT (kullanici_id, kod) DO NOTHING;
  RETURN 'OK';
END;
$$;
GRANT EXECUTE ON FUNCTION rozet_ver(TEXT) TO authenticated;
