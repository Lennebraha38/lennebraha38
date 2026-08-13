-- ============================================
-- Quantro — TUM MIGRATIONLAR (eksiksiz, guvenli tekrar)
-- SQL Editor'a yapistir, Run de. Birden fazla kez
-- calistirilsa bile hata vermez.
-- ============================================

-- 1. ILANLAR
CREATE TABLE IF NOT EXISTS ilanlar (
  id SERIAL PRIMARY KEY,
  baslik VARCHAR(255) NOT NULL,
  aciklama TEXT,
  kategori VARCHAR(50),
  sehir VARCHAR(100),
  etiketler VARCHAR(255),
  kisi VARCHAR(50),
  olusturulma_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
ALTER TABLE ilanlar ADD COLUMN IF NOT EXISTS durum VARCHAR(20) DEFAULT 'Acik';
ALTER TABLE ilanlar ADD COLUMN IF NOT EXISTS iletisim_email VARCHAR(120);
ALTER TABLE ilanlar ADD COLUMN IF NOT EXISTS ilan_tipi VARCHAR(50);
ALTER TABLE ilanlar ADD COLUMN IF NOT EXISTS emoji VARCHAR(5);
ALTER TABLE ilanlar ADD COLUMN IF NOT EXISTS kullanici_email VARCHAR(120);

-- 2. PROFILLER
CREATE TABLE IF NOT EXISTS profiller (
  id SERIAL PRIMARY KEY,
  user_id UUID REFERENCES auth.users(id),
  isim VARCHAR(160) NOT NULL,
  eposta VARCHAR(120),
  bio TEXT,
  yetenekler VARCHAR(255),
  sehir VARCHAR(100),
  musaitlik VARCHAR(50) DEFAULT 'Musait',
  avatar_url VARCHAR(500),
  iletisim VARCHAR(255),
  universite VARCHAR(255),
  alan VARCHAR(100),
  saat VARCHAR(50),
  olusturulma_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. MESAJLAR
CREATE TABLE IF NOT EXISTS mesajlar (
  id SERIAL PRIMARY KEY,
  gonderen_ad VARCHAR(160),
  gonderen_email VARCHAR(120),
  konu VARCHAR(100),
  mesaj TEXT,
  universite VARCHAR(255),
  bolum VARCHAR(100),
  proje VARCHAR(255),
  olusturulma_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. ETKINLIKLER
CREATE TABLE IF NOT EXISTS etkinlikler (
  id SERIAL PRIMARY KEY,
  tarih DATE NOT NULL,
  baslik VARCHAR(255) NOT NULL,
  detay TEXT,
  renk VARCHAR(20) DEFAULT '#3b82f6',
  tur VARCHAR(50) DEFAULT 'genel'
);

-- 5. KATEGORILER
CREATE TABLE IF NOT EXISTS kategoriler (
  id SERIAL PRIMARY KEY,
  anahtar VARCHAR(50) NOT NULL,
  emoji VARCHAR(10),
  baslik VARCHAR(255) NOT NULL,
  alt_baslik VARCHAR(255),
  url VARCHAR(500),
  isim VARCHAR(255) NOT NULL,
  aciklama TEXT,
  alt_emoji VARCHAR(10) DEFAULT '📌',
  durum VARCHAR(20) DEFAULT 'Acik',
  renk_sinifi VARCHAR(50)
);

-- 6. EKIPLER
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

-- 7. EKIP UYELERI
CREATE TABLE IF NOT EXISTS ekip_uyeleri (
  id SERIAL PRIMARY KEY,
  ekip_id INT REFERENCES ekipler(id) ON DELETE CASCADE,
  kullanici_email VARCHAR(120),
  kullanici_id UUID REFERENCES auth.users(id),
  rol VARCHAR(30) DEFAULT 'uye',
  katilma_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 8. GOREVLER
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

-- 9. GOREV YORUMLARI
CREATE TABLE IF NOT EXISTS gorev_yorumlari (
  id SERIAL PRIMARY KEY,
  gorev_id INT REFERENCES gorevler(id) ON DELETE CASCADE,
  kullanici_email VARCHAR(120),
  kullanici_id UUID REFERENCES auth.users(id),
  yorum TEXT NOT NULL,
  olusturulma_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 10. TAKVIM TATILLERI (seed)
INSERT INTO etkinlikler (tarih, baslik, detay, renk, tur)
SELECT * FROM (VALUES
('2026-01-01'::date,'Yilbasi 🎆','Resmi Tatil','#ef4444','tatil'),
('2026-04-23'::date,'23 Nisan 🎈','Resmi Tatil - TBMM acilisi 1920','#ef4444','tatil'),
('2026-05-01'::date,'Emek ve Dayanisma Gunu 👷','Resmi Tatil','#ef4444','tatil'),
('2026-05-19'::date,'Ataturk u Anma Genclik ve Spor Bayrami 🏅','Resmi Tatil - 19 Mayis 1919','#ef4444','tatil'),
('2026-07-15'::date,'Demokrasi ve Milli Birlik Gunu 🇹🇷','Resmi Tatil - 15 Temmuz 2016','#ef4444','tatil'),
('2026-08-30'::date,'Zafer Bayrami 🏆','Resmi Tatil - 30 Agustos 1922','#ef4444','tatil'),
('2026-10-29'::date,'Cumhuriyet Bayrami 🎉','Resmi Tatil - 29 Ekim 1923','#ef4444','tatil'),
('2026-05-29'::date,'Istanbul un Fethi 🏰','29 Mayis 1453 - Fatih Sultan Mehmet','#3b82f6','tarih'),
('2026-07-20'::date,'Ay a Ilk Insan Ayak Basti 🌕','20 Temmuz 1969 - Apollo 11','#3b82f6','tarih'),
('2026-07-24'::date,'Lozan Baris Antlasmasi 🕊️','24 Temmuz 1923','#3b82f6','tarih')
) AS v(tarih,baslik,detay,renk,tur)
WHERE NOT EXISTS (SELECT 1 FROM etkinlikler);

-- 11. KATEGORI SEED
INSERT INTO kategoriler (anahtar, emoji, baslik, alt_baslik, url, isim, aciklama, alt_emoji, durum, renk_sinifi)
SELECT * FROM (VALUES
('teknofest','🚀','Teknofest 2026','50+ kategori - Ankara','https://teknofest.org','Insansiz Hava Araci (IHA)','Sabit/doner kanatli ve multirotor','✈️','Acik',null),
('teknofest','🚀','Teknofest 2026','50+ kategori - Ankara','https://teknofest.org','Yapay Zeka','Goruntu isleme, NLP ve otonomi','🤖','Acik',null),
('teknofest','🚀','Teknofest 2026','50+ kategori - Ankara','https://teknofest.org','Siber Guvenlik','Saldiri tespiti ve guvenli yazilim','🔐','Acik',null),
('teknofest','🚀','Teknofest 2026','50+ kategori - Ankara','https://teknofest.org','Model Roket','Yuksek irtifa ve hassas inis','🚀','Acik',null),
('teknofest','🚀','Teknofest 2026','50+ kategori - Ankara','https://teknofest.org','Elektrikli Arac','Formul-E tipi arac tasarimi','🏎️','Acik',null),
('tubitak','🔬','TUBITAK Programlar','Projeler ve olimpiyatlar 2026','https://tubitak.gov.tr','2204-A Lise Proje','Lise ogrencileri ulusal proje yarismasi','🏫','Acik','green'),
('tubitak','🔬','TUBITAK Programlar','Projeler ve olimpiyatlar 2026','https://tubitak.gov.tr','2209-A Universite','Lisans ogrencileri arastirma destegi','🎓','Acik','green'),
('tubitak','🔬','TUBITAK Programlar','Projeler ve olimpiyatlar 2026','https://tubitak.gov.tr','Matematik Olimpiyati','Ulusal yarisma ve IMO secmesi','🔢','Acik',null),
('yazilim','💻','Yazilim & Algoritma','Kuresel ve ulusal yarismalar','https://icpc.global','ACM-ICPC','Universiteler arasi programlama sampiyonasi','🏆','Acik',null),
('yazilim','💻','Yazilim & Algoritma','Kuresel ve ulusal yarismalar','https://icpc.global','Codeforces Rounds','Div 1-4 seviyeli yarismalar','🔥','Surekli','green'),
('yazilim','💻','Yazilim & Algoritma','Kuresel ve ulusal yarismalar','https://icpc.global','LeetCode Contest','Haftalik yarismalar','💡','Haftalik','green'),
('siber','🔐','Siber Guvenlik','CTF ve guvenlik arastirmalari 2026','https://ctftime.org','CTF - Jeopardy','Web, crypto, pwn, forensics, RE','🏴','Acik',null),
('siber','🔐','Siber Guvenlik','CTF ve guvenlik arastirmalari 2026','https://ctftime.org','Attack & Defense CTF','Gercek zamanli takim savasi','⚔️','Acik',null),
('siber','🔐','Siber Guvenlik','CTF ve guvenlik arastirmalari 2026','https://ctftime.org','Web Guvenligi','XSS, SQLi, SSRF, OWASP Top 10','🕸️','Acik',null)
) AS v(anahtar,emoji,baslik,alt_baslik,url,isim,aciklama,alt_emoji,durum,renk_sinifi)
WHERE NOT EXISTS (SELECT 1 FROM kategoriler);

-- 12. AVATAR DEPOLAMA (bucket)
INSERT INTO storage.buckets (id, name, public, file_size_limit)
VALUES ('avatarlar', 'avatarlar', true, 5242880)
ON CONFLICT (id) DO NOTHING;

-- 13. RLS
ALTER TABLE ilanlar ENABLE ROW LEVEL SECURITY;
ALTER TABLE profiller ENABLE ROW LEVEL SECURITY;
ALTER TABLE mesajlar ENABLE ROW LEVEL SECURITY;
ALTER TABLE ekipler ENABLE ROW LEVEL SECURITY;
ALTER TABLE ekip_uyeleri ENABLE ROW LEVEL SECURITY;
ALTER TABLE gorevler ENABLE ROW LEVEL SECURITY;
ALTER TABLE gorev_yorumlari ENABLE ROW LEVEL SECURITY;

-- 14. POLITIKALAR
DROP POLICY IF EXISTS "public_read_ilanlar" ON ilanlar;
DROP POLICY IF EXISTS "auth_insert_ilanlar" ON ilanlar;
DROP POLICY IF EXISTS "owner_delete_ilanlar" ON ilanlar;
CREATE POLICY "public_read_ilanlar" ON ilanlar FOR SELECT USING (true);
CREATE POLICY "auth_insert_ilanlar" ON ilanlar FOR INSERT WITH CHECK (auth.role() = 'authenticated');
CREATE POLICY "owner_delete_ilanlar" ON ilanlar FOR DELETE USING (auth.role() = 'authenticated' AND kullanici_email = auth.email());

DROP POLICY IF EXISTS "public_read_profiller" ON profiller;
DROP POLICY IF EXISTS "auth_insert_profiller" ON profiller;
DROP POLICY IF EXISTS "owner_update_profiller" ON profiller;
DROP POLICY IF EXISTS "owner_delete_profiller" ON profiller;
CREATE POLICY "public_read_profiller" ON profiller FOR SELECT USING (true);
CREATE POLICY "auth_insert_profiller" ON profiller FOR INSERT WITH CHECK (auth.role() = 'authenticated');
CREATE POLICY "owner_update_profiller" ON profiller FOR UPDATE USING (auth.role() = 'authenticated' AND user_id = auth.uid());
CREATE POLICY "owner_delete_profiller" ON profiller FOR DELETE USING (auth.role() = 'authenticated' AND user_id = auth.uid());

DROP POLICY IF EXISTS "public_insert_mesajlar" ON mesajlar;
CREATE POLICY "public_insert_mesajlar" ON mesajlar FOR INSERT WITH CHECK (true);

DROP POLICY IF EXISTS "public_read_ekipler" ON ekipler;
DROP POLICY IF EXISTS "auth_insert_ekipler" ON ekipler;
DROP POLICY IF EXISTS "owner_update_ekipler" ON ekipler;
DROP POLICY IF EXISTS "owner_delete_ekipler" ON ekipler;
CREATE POLICY "public_read_ekipler" ON ekipler FOR SELECT USING (true);
CREATE POLICY "auth_insert_ekipler" ON ekipler FOR INSERT WITH CHECK (auth.role() = 'authenticated');
CREATE POLICY "owner_update_ekipler" ON ekipler FOR UPDATE USING (auth.role() = 'authenticated' AND olusturan_id = auth.uid());
CREATE POLICY "owner_delete_ekipler" ON ekipler FOR DELETE USING (auth.role() = 'authenticated' AND olusturan_id = auth.uid());

DROP POLICY IF EXISTS "public_read_ekip_uyeleri" ON ekip_uyeleri;
DROP POLICY IF EXISTS "auth_insert_ekip_uyeleri" ON ekip_uyeleri;
CREATE POLICY "public_read_ekip_uyeleri" ON ekip_uyeleri FOR SELECT USING (true);
CREATE POLICY "auth_insert_ekip_uyeleri" ON ekip_uyeleri FOR INSERT WITH CHECK (auth.role() = 'authenticated');

DROP POLICY IF EXISTS "public_read_gorevler" ON gorevler;
DROP POLICY IF EXISTS "auth_insert_gorevler" ON gorevler;
DROP POLICY IF EXISTS "owner_update_gorevler" ON gorevler;
DROP POLICY IF EXISTS "owner_delete_gorevler" ON gorevler;
CREATE POLICY "public_read_gorevler" ON gorevler FOR SELECT USING (true);
CREATE POLICY "auth_insert_gorevler" ON gorevler FOR INSERT WITH CHECK (auth.role() = 'authenticated');
CREATE POLICY "owner_update_gorevler" ON gorevler FOR UPDATE USING (auth.role() = 'authenticated');
CREATE POLICY "owner_delete_gorevler" ON gorevler FOR DELETE USING (auth.role() = 'authenticated' AND olusturan_id = auth.uid());

DROP POLICY IF EXISTS "public_read_gorev_yorumlari" ON gorev_yorumlari;
DROP POLICY IF EXISTS "auth_insert_gorev_yorumlari" ON gorev_yorumlari;
CREATE POLICY "public_read_gorev_yorumlari" ON gorev_yorumlari FOR SELECT USING (true);
CREATE POLICY "auth_insert_gorev_yorumlari" ON gorev_yorumlari FOR INSERT WITH CHECK (auth.role() = 'authenticated');

DROP POLICY IF EXISTS "public_read_avatarlar" ON storage.objects;
DROP POLICY IF EXISTS "auth_insert_avatarlar" ON storage.objects;
DROP POLICY IF EXISTS "owner_update_avatarlar" ON storage.objects;
DROP POLICY IF EXISTS "owner_delete_avatarlar" ON storage.objects;
CREATE POLICY "public_read_avatarlar" ON storage.objects FOR SELECT USING (bucket_id = 'avatarlar');
CREATE POLICY "auth_insert_avatarlar" ON storage.objects FOR INSERT WITH CHECK (bucket_id = 'avatarlar' AND auth.role() = 'authenticated');
CREATE POLICY "owner_update_avatarlar" ON storage.objects FOR UPDATE USING (bucket_id = 'avatarlar' AND auth.uid()::text = (storage.foldername(name))[1]);
CREATE POLICY "owner_delete_avatarlar" ON storage.objects FOR DELETE USING (bucket_id = 'avatarlar' AND auth.uid()::text = (storage.foldername(name))[1]);

-- 15. REALTIME (zaten ekliyse hata vermez)
DO $$ BEGIN
  ALTER PUBLICATION supabase_realtime ADD TABLE ilanlar;
EXCEPTION WHEN duplicate_object THEN NULL; END $$;
DO $$ BEGIN
  ALTER PUBLICATION supabase_realtime ADD TABLE profiller;
EXCEPTION WHEN duplicate_object THEN NULL; END $$;
DO $$ BEGIN
  ALTER PUBLICATION supabase_realtime ADD TABLE ekipler;
EXCEPTION WHEN duplicate_object THEN NULL; END $$;
DO $$ BEGIN
  ALTER PUBLICATION supabase_realtime ADD TABLE gorevler;
EXCEPTION WHEN duplicate_object THEN NULL; END $$;
DO $$ BEGIN
  ALTER PUBLICATION supabase_realtime ADD TABLE gorev_yorumlari;
EXCEPTION WHEN duplicate_object THEN NULL; END $$;

-- 16. AYNI KULLANICI AYNI EKIPE BIR KEZ KATILABILIR
ALTER TABLE ekip_uyeleri DROP CONSTRAINT IF EXISTS ekip_uyeleri_tekil;
ALTER TABLE ekip_uyeleri ADD CONSTRAINT ekip_uyeleri_tekil UNIQUE (ekip_id, kullanici_email);
