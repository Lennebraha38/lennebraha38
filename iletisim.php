<?php include __DIR__ . "/templates/shared/head.php"; ?>
<?php include __DIR__ . "/templates/shared/header.php"; ?>
  <section id="iletisim">
    <div class="container">
      <div class="section-header reveal">
        <div class="badge-pill">İletişim</div>
        <h2>Bağlantı Kur</h2>
        <p>Takım kur, mentör bul, proje ortaklığı oluştur — hepsini buradan başlat</p>
      </div>

      <div class="contact-layout reveal">

        <!-- SOL: Bilgi & Kanallar -->
        <div class="contact-left">

          <div class="contact-intro-card">
            <h3>Merhaba, ben buradayım 👋</h3>
            <p>Teknofest, TÜBİTAK ve diğer yarışmalar için takım kurmak, mentor bulmak veya proje ortaklığı için iletişime geçmekten çekinme. Ortalama yanıt sürem 24 saatin altında.</p>

          </div>

          <!-- İletişim Kanalları -->


          <!-- Hızlı Konular -->
          <div class="contact-faq-card">
            <h4>Hızlı Konu Seçimi</h4>
            <div class="faq-chips">
              <div class="faq-chip" onclick="autoFillForm('takim','Teknofest için takım üyesi arıyorum. Projem hakkında bilgi vermek istiyorum.')">
                <span>🚀</span> Teknofest için takım üyesi arıyorum
              </div>
              <div class="faq-chip" onclick="autoFillForm('mentor','Mentörlük almak istiyorum. Hangi alanlarda destek alabileceğimi öğrenmek istiyorum.')">
                <span>🎓</span> Mentörlük almak istiyorum
              </div>
              <div class="faq-chip" onclick="autoFillForm('proje','TÜBİTAK projesi için proje ortağı arıyorum. Detayları paylaşmak istiyorum.')">
                <span>🔬</span> TÜBİTAK projesi için ortak arıyorum
              </div>
              <div class="faq-chip" onclick="autoFillForm('takim','ICPC / ACM yarışması için takım kuruyorum. Katılmak ister misin?')">
                <span>💻</span> Yazılım yarışması takımı kuruyorum
              </div>
              <div class="faq-chip" onclick="autoFillForm('platform','Platform hakkında öneri veya geri bildirimim var.')">
                <span>💡</span> Platform hakkında geri bildirim
              </div>
            </div>
          </div>

        </div>

        <!-- SAĞ: Akıllı Form -->
        <div class="contact-form-card">

          <div class="contact-form-header">
            <div class="contact-form-header-icon">✉️</div>
            <div>
              <h3>Mesaj Gönder</h3>
              <p>Formu doldur, mesajını gönder</p>
            </div>
          </div>

          <!-- Adım göstergesi -->
          <div class="form-steps">
            <div class="form-step active" id="step-1">
              <div class="form-step-num">1</div> Bilgiler
            </div>
            <div class="form-step-line"></div>
            <div class="form-step" id="step-2">
              <div class="form-step-num">2</div> Konu
            </div>
            <div class="form-step-line"></div>
            <div class="form-step" id="step-3">
              <div class="form-step-num">3</div> Gönder
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Ad</label>
              <input type="text" class="form-control" id="field-ad" placeholder="Adınız" autocomplete="given-name" oninput="updateFormSteps()">
            </div>
            <div class="form-group">
              <label class="form-label">Soyad</label>
              <input type="text" class="form-control" id="field-soyad" placeholder="Soyadınız" autocomplete="family-name">
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">E-posta</label>
            <input type="email" class="form-control" id="field-email" placeholder="ornek@gmail.com" autocomplete="email" oninput="updateFormSteps()">
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Üniversite / Okul</label>
              <input type="text" class="form-control" id="field-universite" placeholder="Örn: ODTÜ, İTÜ...">
            </div>
            <div class="form-group">
              <label class="form-label">Bölüm / Sınıf</label>
              <input type="text" class="form-control" id="field-bolum" placeholder="Bilgisayar Müh. 3.">
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Konu</label>
            <select class="form-control" id="field-konu" style="cursor:pointer;" onchange="updateFormSteps()">
              <option value="" disabled selected>Konu seçin...</option>
              <option value="takim">🚀 Takım Kurma / Üye Arama</option>
              <option value="mentor">🎓 Mentörlük Talebi</option>
              <option value="proje">🔬 Proje Ortaklığı</option>
              <option value="teknofest">⚡ Teknofest Başvurusu</option>
              <option value="tubitak">🏛️ TÜBİTAK Projesi</option>
              <option value="platform">💡 Platform Hakkında</option>
              <option value="diger">📝 Diğer</option>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label">Proje / Yarışma Adı <span style="color:var(--text-dim);font-weight:400;">(varsa)</span></label>
            <input type="text" class="form-control" id="field-proje" placeholder="Örn: Teknofest 2026 — YZ Kategorisi">
          </div>

          <div class="form-group form-group-wrap">
            <label class="form-label">Mesaj</label>
            <textarea class="form-control" id="field-mesaj" placeholder="Aradığınız profili, projenizin durumunu ve beklentilerinizi kısaca açıklayın..." rows="5" oninput="updateCharCount(this)" maxlength="800"></textarea>
            <span class="char-counter" id="char-count">0 / 800</span>
          </div>

          <!-- Discord seçeneği -->
          <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.5rem;">
            <div style="flex:1;height:1px;background:var(--border);"></div>
            <span style="font-size:0.72rem;color:var(--text-dim);font-weight:600;">veya hızlıca</span>
            <div style="flex:1;height:1px;background:var(--border);"></div>
          </div>
          <div style="display:flex;gap:0.75rem;margin-bottom:1.5rem;">
            <button class="btn btn-secondary" style="flex:1;font-size:0.82rem;" onclick="sendGmail()">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"/><rect x="2" y="4" width="20" height="16" rx="2"/></svg>
              Gmail
            </button>
            <button class="btn btn-secondary" style="flex:1;font-size:0.82rem;" onclick="copyFormContact()">
              📋 Kopyala
            </button>
          </div>

          <button class="contact-send-btn" onclick="sendGmail()">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2 11 13"/><path d="M22 2 15 22 11 13 2 9l20-7z"/></svg>
            Mesajı Gönder
          </button>

          <div class="contact-footnote">
            <span>🔒 Veriler paylaşılmaz</span>
            <span>⚡ Ort. 24s yanıt</span>
            <span>✅ Ücretsiz & hızlı</span>
          </div>

        </div>
      </div>
    </div>
  </section>

<?php include __DIR__ . "/templates/shared/footer.php"; ?>
<script>
// Iletisim page - contact form
initPage = async function() {
  if (typeof overrideContactForm === "function") overrideContactForm();
};
</script>
<?php include __DIR__ . "/templates/shared/shared-js.php"; ?>
</body></html>
