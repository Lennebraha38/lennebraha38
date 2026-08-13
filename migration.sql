-- ============================================
-- Quantro — Supabase Realtime Migration
-- Bu SQL'i Supabase SQL Editor'da calistirin
-- ============================================

-- 0. Temel ilanlar tablosu (yatirim duzeltmesi: eski projede mevcuttu,
--    yeni projelerde de sorunsuz kurulum icin CREATE eklenir)
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

-- 1. Mevcut ilanlar tablosuna ek sutunlar
ALTER TABLE ilanlar ADD COLUMN IF NOT EXISTS durum VARCHAR(20) DEFAULT 'Acik';
ALTER TABLE ilanlar ADD COLUMN IF NOT EXISTS iletisim_email VARCHAR(120);
ALTER TABLE ilanlar ADD COLUMN IF NOT EXISTS ilan_tipi VARCHAR(50);
ALTER TABLE ilanlar ADD COLUMN IF NOT EXISTS emoji VARCHAR(5);
ALTER TABLE ilanlar ADD COLUMN IF NOT EXISTS kullanici_email VARCHAR(120);

-- 2. Profiller tablosu
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

-- 3. Mesajlar tablosu
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

-- 4. Etkinlikler tablosu
CREATE TABLE IF NOT EXISTS etkinlikler (
  id SERIAL PRIMARY KEY,
  tarih DATE NOT NULL,
  baslik VARCHAR(255) NOT NULL,
  detay TEXT,
  renk VARCHAR(20) DEFAULT '#3b82f6',
  tur VARCHAR(50) DEFAULT 'genel'
);

-- 5. Kategoriler tablosu
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

-- 6. Seed: Etkinlikler
INSERT INTO etkinlikler (tarih, baslik, detay, renk, tur) VALUES
('2026-01-01', 'Yilbasi 🎆', 'Resmi Tatil', '#ef4444', 'tatil'),
('2026-04-23', '23 Nisan 🎈', 'Resmi Tatil - TBMM acilisi 1920', '#ef4444', 'tatil'),
('2026-05-01', 'Emek ve Dayanisma Gunu 👷', 'Resmi Tatil', '#ef4444', 'tatil'),
('2026-05-19', 'Ataturk u Anma Genclik ve Spor Bayrami 🏅', 'Resmi Tatil - 19 Mayis 1919', '#ef4444', 'tatil'),
('2026-07-15', 'Demokrasi ve Milli Birlik Gunu 🇹🇷', 'Resmi Tatil - 15 Temmuz 2016', '#ef4444', 'tatil'),
('2026-08-30', 'Zafer Bayrami 🏆', 'Resmi Tatil - 30 Agustos 1922', '#ef4444', 'tatil'),
('2026-10-29', 'Cumhuriyet Bayrami 🎉', 'Resmi Tatil - 29 Ekim 1923', '#ef4444', 'tatil'),
('2026-05-29', 'Istanbul un Fethi 🏰', '29 Mayis 1453 - Fatih Sultan Mehmet', '#3b82f6', 'tarih'),
('2026-07-20', 'Ay a Ilk Insan Ayak Basti 🌕', '20 Temmuz 1969 - Apollo 11', '#3b82f6', 'tarih'),
('2026-07-24', 'Lozan Baris Antlasmasi 🕊️', '24 Temmuz 1923', '#3b82f6', 'tarih');

-- 7. Seed: Kategoriler
INSERT INTO kategoriler (anahtar, emoji, baslik, alt_baslik, url, isim, aciklama, alt_emoji, durum, renk_sinifi) VALUES
('teknofest', '🚀', 'Teknofest 2026', '50+ kategori - Ankara', 'https://teknofest.org', 'Insansiz Hava Araci (IHA)', 'Sabit/doner kanatli ve multirotor', '✈️', 'Acik', null),
('teknofest', '🚀', 'Teknofest 2026', '50+ kategori - Ankara', 'https://teknofest.org', 'Yapay Zeka', 'Goruntu isleme, NLP ve otonomi', '🤖', 'Acik', null),
('teknofest', '🚀', 'Teknofest 2026', '50+ kategori - Ankara', 'https://teknofest.org', 'Siber Guvenlik', 'Saldiri tespiti ve guvenli yazilim', '🔐', 'Acik', null),
('teknofest', '🚀', 'Teknofest 2026', '50+ kategori - Ankara', 'https://teknofest.org', 'Model Roket', 'Yuksek irtifa ve hassas inis', '🚀', 'Acik', null),
('teknofest', '🚀', 'Teknofest 2026', '50+ kategori - Ankara', 'https://teknofest.org', 'Elektrikli Arac', 'Formul-E tipi arac tasarimi', '🏎️', 'Acik', null),
('tubitak', '🔬', 'TUBITAK Programlar', 'Projeler ve olimpiyatlar 2026', 'https://tubitak.gov.tr', '2204-A Lise Proje', 'Lise ogrencileri ulusal proje yarismasi', '🏫', 'Acik', 'green'),
('tubitak', '🔬', 'TUBITAK Programlar', 'Projeler ve olimpiyatlar 2026', 'https://tubitak.gov.tr', '2209-A Universite', 'Lisans ogrencileri arastirma destegi', '🎓', 'Acik', 'green'),
('tubitak', '🔬', 'TUBITAK Programlar', 'Projeler ve olimpiyatlar 2026', 'https://tubitak.gov.tr', 'Matematik Olimpiyati', 'Ulusal yarisma ve IMO secmesi', '🔢', 'Acik', null),
('yazilim', '💻', 'Yazilim & Algoritma', 'Kuresel ve ulusal yarismalar', 'https://icpc.global', 'ACM-ICPC', 'Universiteler arasi programlama sampiyonasi', '🏆', 'Acik', null),
('yazilim', '💻', 'Yazilim & Algoritma', 'Kuresel ve ulusal yarismalar', 'https://icpc.global', 'Codeforces Rounds', 'Div 1-4 seviyeli yarismalar', '🔥', 'Surekli', 'green'),
('yazilim', '💻', 'Yazilim & Algoritma', 'Kuresel ve ulusal yarismalar', 'https://icpc.global', 'LeetCode Contest', 'Haftalik yarismalar', '💡', 'Haftalik', 'green'),
('siber', '🔐', 'Siber Guvenlik', 'CTF ve guvenlik arastirmalari 2026', 'https://ctftime.org', 'CTF - Jeopardy', 'Web, crypto, pwn, forensics, RE', '🏴', 'Acik', null),
('siber', '🔐', 'Siber Guvenlik', 'CTF ve guvenlik arastirmalari 2026', 'https://ctftime.org', 'Attack & Defense CTF', 'Gercek zamanli takim savasi', '⚔️', 'Acik', null),
('siber', '🔐', 'Siber Guvenlik', 'CTF ve guvenlik arastirmalari 2026', 'https://ctftime.org', 'Web Guvenligi', 'XSS, SQLi, SSRF, OWASP Top 10', '🕸️', 'Acik', null);

-- 8. Realtime etkinlestir
ALTER PUBLICATION supabase_realtime ADD TABLE ilanlar;
ALTER PUBLICATION supabase_realtime ADD TABLE profiller;

-- 9. Row Level Security (temel politikalar)
ALTER TABLE ilanlar ENABLE ROW LEVEL SECURITY;
ALTER TABLE profiller ENABLE ROW LEVEL SECURITY;
ALTER TABLE mesajlar ENABLE ROW LEVEL SECURITY;

CREATE POLICY "public_read_ilanlar" ON ilanlar FOR SELECT USING (true);
CREATE POLICY "public_read_profiller" ON profiller FOR SELECT USING (true);
CREATE POLICY "auth_insert_ilanlar" ON ilanlar FOR INSERT WITH CHECK (auth.role() = 'authenticated');
CREATE POLICY "auth_insert_profiller" ON profiller FOR INSERT WITH CHECK (auth.role() = 'authenticated');
CREATE POLICY "owner_update_profiller" ON profiller FOR UPDATE USING (auth.role() = 'authenticated' AND user_id = auth.uid());
CREATE POLICY "public_insert_mesajlar" ON mesajlar FOR INSERT WITH CHECK (true);
CREATE POLICY "owner_delete_ilanlar" ON ilanlar FOR DELETE USING (auth.role() = 'authenticated' AND kullanici_email = auth.email());
CREATE POLICY "owner_delete_profiller" ON profiller FOR DELETE USING (auth.role() = 'authenticated' AND user_id = auth.uid());

-- 10. Avatar depolama (storage bucket + politikalar)
INSERT INTO storage.buckets (id, name, public, file_size_limit)
VALUES ('avatarlar', 'avatarlar', true, 5242880)
ON CONFLICT (id) DO NOTHING;

CREATE POLICY "public_read_avatarlar" ON storage.objects FOR SELECT USING (bucket_id = 'avatarlar');
CREATE POLICY "auth_insert_avatarlar" ON storage.objects FOR INSERT WITH CHECK (bucket_id = 'avatarlar' AND auth.role() = 'authenticated');
CREATE POLICY "owner_update_avatarlar" ON storage.objects FOR UPDATE USING (bucket_id = 'avatarlar' AND auth.uid()::text = (storage.foldername(name))[1]);
CREATE POLICY "owner_delete_avatarlar" ON storage.objects FOR DELETE USING (bucket_id = 'avatarlar' AND auth.uid()::text = (storage.foldername(name))[1]);
