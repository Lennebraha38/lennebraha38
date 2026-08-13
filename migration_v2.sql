-- ============================================
-- Quantro v2 — Gorev & Ekip Yonetim Sistemi
-- Bu SQL'i Supabase SQL Editor'da calistirin
-- ============================================

-- 1. Ekipler tablosu
CREATE TABLE IF NOT EXISTS ekipler (
  id SERIAL PRIMARY KEY,
  isim VARCHAR(255) NOT NULL,
  aciklama TEXT,
  kategori VARCHAR(50),
  olusturan_email VARCHAR(120),
  olusturan_id UUID REFERENCES auth.users(id),
  durum VARCHAR(20) DEFAULT 'Acik',
  uye_sayisi INT DEFAULT 1,
  max_uye INT DEFAULT 10,
  olusturulma_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Ekip uyeleri
CREATE TABLE IF NOT EXISTS ekip_uyeleri (
  id SERIAL PRIMARY KEY,
  ekip_id INT REFERENCES ekipler(id) ON DELETE CASCADE,
  kullanici_email VARCHAR(120),
  kullanici_id UUID REFERENCES auth.users(id),
  rol VARCHAR(30) DEFAULT 'uye',
  katilma_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Gorevler (tasks)
CREATE TABLE IF NOT EXISTS gorevler (
  id SERIAL PRIMARY KEY,
  baslik VARCHAR(255) NOT NULL,
  aciklama TEXT,
  durum VARCHAR(30) DEFAULT 'yapilacak',
  oncelik VARCHAR(20) DEFAULT 'orta',
  ekip_id INT REFERENCES ekipler(id) ON DELETE SET NULL,
  atanan_email VARCHAR(120),
  atanan_id UUID REFERENCES auth.users(id),
  olusturan_email VARCHAR(120),
  olusturan_id UUID REFERENCES auth.users(id),
  etiketler VARCHAR(255),
  son_tarih DATE,
  sira INT DEFAULT 0,
  olusturulma_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Gorev yorumlari
CREATE TABLE IF NOT EXISTS gorev_yorumlari (
  id SERIAL PRIMARY KEY,
  gorev_id INT REFERENCES gorevler(id) ON DELETE CASCADE,
  kullanici_email VARCHAR(120),
  kullanici_id UUID REFERENCES auth.users(id),
  yorum TEXT NOT NULL,
  olusturulma_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 5. RLS politikaları
ALTER TABLE ekipler ENABLE ROW LEVEL SECURITY;
ALTER TABLE ekip_uyeleri ENABLE ROW LEVEL SECURITY;
ALTER TABLE gorevler ENABLE ROW LEVEL SECURITY;
ALTER TABLE gorev_yorumlari ENABLE ROW LEVEL SECURITY;

-- Herkes okuyabilir
CREATE POLICY "public_read_ekipler" ON ekipler FOR SELECT USING (true);
CREATE POLICY "public_read_ekip_uyeleri" ON ekip_uyeleri FOR SELECT USING (true);
CREATE POLICY "public_read_gorevler" ON gorevler FOR SELECT USING (true);
CREATE POLICY "public_read_gorev_yorumlari" ON gorev_yorumlari FOR SELECT USING (true);

-- Auth kullanicilar yazabilir
CREATE POLICY "auth_insert_ekipler" ON ekipler FOR INSERT WITH CHECK (auth.role() = 'authenticated');
CREATE POLICY "auth_insert_ekip_uyeleri" ON ekip_uyeleri FOR INSERT WITH CHECK (auth.role() = 'authenticated');
CREATE POLICY "auth_insert_gorevler" ON gorevler FOR INSERT WITH CHECK (auth.role() = 'authenticated');
CREATE POLICY "auth_insert_gorev_yorumlari" ON gorev_yorumlari FOR INSERT WITH CHECK (auth.role() = 'authenticated');

-- Sahibi guncelleyebilir/silebilir
CREATE POLICY "owner_update_ekipler" ON ekipler FOR UPDATE USING (auth.role() = 'authenticated' AND olusturan_id = auth.uid());
CREATE POLICY "owner_delete_ekipler" ON ekipler FOR DELETE USING (auth.role() = 'authenticated' AND olusturan_id = auth.uid());
CREATE POLICY "owner_update_gorevler" ON gorevler FOR UPDATE USING (auth.role() = 'authenticated');
CREATE POLICY "owner_delete_gorevler" ON gorevler FOR DELETE USING (auth.role() = 'authenticated' AND olusturan_id = auth.uid());

-- Realtime
ALTER PUBLICATION supabase_realtime ADD TABLE ekipler;
ALTER PUBLICATION supabase_realtime ADD TABLE gorevler;
ALTER PUBLICATION supabase_realtime ADD TABLE gorev_yorumlari;

-- 6. Ayni kullanicinin ayni ekibe tekrar katilmasini engelle
ALTER TABLE ekip_uyeleri ADD CONSTRAINT ekip_uyeleri_tekil UNIQUE (ekip_id, kullanici_email);
