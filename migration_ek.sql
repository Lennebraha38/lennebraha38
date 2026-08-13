-- ============================================
-- Quantro — EKSIK PARCALAR (seed + bucket + politikalar)
-- SQL Editor'a yapistir, Run de
-- ============================================

INSERT INTO etkinlikler (tarih, baslik, detay, renk, tur)
SELECT * FROM (VALUES
('2026-01-01','Yilbasi 🎆','Resmi Tatil','#ef4444','tatil'),
('2026-04-23','23 Nisan 🎈','Resmi Tatil - TBMM acilisi 1920','#ef4444','tatil'),
('2026-05-01','Emek ve Dayanisma Gunu 👷','Resmi Tatil','#ef4444','tatil'),
('2026-05-19','Ataturk u Anma Genclik ve Spor Bayrami 🏅','Resmi Tatil - 19 Mayis 1919','#ef4444','tatil'),
('2026-07-15','Demokrasi ve Milli Birlik Gunu 🇹🇷','Resmi Tatil - 15 Temmuz 2016','#ef4444','tatil'),
('2026-08-30','Zafer Bayrami 🏆','Resmi Tatil - 30 Agustos 1922','#ef4444','tatil'),
('2026-10-29','Cumhuriyet Bayrami 🎉','Resmi Tatil - 29 Ekim 1923','#ef4444','tatil'),
('2026-05-29','Istanbul un Fethi 🏰','29 Mayis 1453 - Fatih Sultan Mehmet','#3b82f6','tarih'),
('2026-07-20','Ay a Ilk Insan Ayak Basti 🌕','20 Temmuz 1969 - Apollo 11','#3b82f6','tarih'),
('2026-07-24','Lozan Baris Antlasmasi 🕊️','24 Temmuz 1923','#3b82f6','tarih')
) AS v(tarih,baslik,detay,renk,tur)
WHERE NOT EXISTS (SELECT 1 FROM etkinlikler);

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

INSERT INTO storage.buckets (id, name, public, file_size_limit)
VALUES ('avatarlar', 'avatarlar', true, 5242880)
ON CONFLICT (id) DO NOTHING;

DROP POLICY IF EXISTS "public_read_avatarlar" ON storage.objects;
DROP POLICY IF EXISTS "auth_insert_avatarlar" ON storage.objects;
DROP POLICY IF EXISTS "owner_update_avatarlar" ON storage.objects;
DROP POLICY IF EXISTS "owner_delete_avatarlar" ON storage.objects;
CREATE POLICY "public_read_avatarlar" ON storage.objects FOR SELECT USING (bucket_id = 'avatarlar');
CREATE POLICY "auth_insert_avatarlar" ON storage.objects FOR INSERT WITH CHECK (bucket_id = 'avatarlar' AND auth.role() = 'authenticated');
CREATE POLICY "owner_update_avatarlar" ON storage.objects FOR UPDATE USING (bucket_id = 'avatarlar' AND auth.uid()::text = (storage.foldername(name))[1]);
CREATE POLICY "owner_delete_avatarlar" ON storage.objects FOR DELETE USING (bucket_id = 'avatarlar' AND auth.uid()::text = (storage.foldername(name))[1]);

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

ALTER TABLE ekip_uyeleri DROP CONSTRAINT IF EXISTS ekip_uyeleri_tekil;
ALTER TABLE ekip_uyeleri ADD CONSTRAINT ekip_uyeleri_tekil UNIQUE (ekip_id, kullanici_email);
