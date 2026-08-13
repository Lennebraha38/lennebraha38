<?php include __DIR__ . "/templates/shared/head.php"; ?>
<?php include __DIR__ . "/templates/shared/header.php"; ?>
  <section id="sss">
    <div class="container">
      <div class="section-header reveal">
        <div class="badge-pill">SSS</div>
        <h2>Sıkça Sorulan Sorular</h2>
        <p>Aklındaki soruların cevapları burada — bulamazsan bize yaz</p>
      </div>
      <div class="sss-grid reveal">

        <div class="sss-item">
          <button class="sss-q" onclick="toggleSSS(this)">
            <span>Platforma üye olmak ücretli mi?</span>
            <svg class="sss-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
          </button>
          <div class="sss-a">
            <p>Hayır, Quantro tamamen ücretsizdir. İlan açmak, takım aramak, profil oluşturmak ve mentörlerle iletişime geçmek için herhangi bir ücret talep etmiyoruz. Platform, Türkiye'deki yarışma ekosistemini güçlendirme misyonuyla tamamen ücretsiz olarak sunulmaktadır.</p>
          </div>
        </div>

        <div class="sss-item">
          <button class="sss-q" onclick="toggleSSS(this)">
            <span>Hangi yarışma kategorileri destekleniyor?</span>
            <svg class="sss-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
          </button>
          <div class="sss-a">
            <p>Şu an Teknofest (İHA, Roket, YZ, Akıllı Ulaşım vb.), TÜBİTAK (2204-A, 2209-A/B, Olimpiyatlar), Yazılım & Algoritma (ACM-ICPC, Codeforces, LeetCode), Yapay Zeka & Veri (Kaggle), Siber Güvenlik (CTF) ve Tasarım & İnovasyon (Hackathon, UI/UX) kategorilerini destekliyoruz. Yeni platformlar sürekli eklenmektedir.</p>
          </div>
        </div>

        <div class="sss-item">
          <button class="sss-q" onclick="toggleSSS(this)">
            <span>Takım kurmak için ne yapmalıyım?</span>
            <svg class="sss-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
          </button>
          <div class="sss-a">
            <p>İki yol var: İlk olarak "İlan Aç" butonuyla aradığın rolü, beceri setini ve yarışma kategorini belirterek ilan yayınlayabilirsin. İkinci olarak mevcut ilanları tarayarak sana uygun bir ekibe katılabilirsin. Ortalama eşleşme süresi 48 saatin altındadır.</p>
          </div>
        </div>

        <div class="sss-item">
          <button class="sss-q" onclick="toggleSSS(this)">
            <span>Daha önce hiç yarışmaya katılmadım, başlayabilir miyim?</span>
            <svg class="sss-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
          </button>
          <div class="sss-a">
            <p>Kesinlikle! Platform her seviyeye açık. Deneyimli yarışmacılardan oluşan ekiplere katılarak hem öğrenebilir hem de katkı sağlayabilirsin. Profil oluştururken deneyim seviyeni belirtmen, sana uygun ekip önerilerini iyileştirir. Mentörlük talebi de açabilirsin.</p>
          </div>
        </div>

        <div class="sss-item">
          <button class="sss-q" onclick="toggleSSS(this)">
            <span>Mentör olmak veya mentör bulmak nasıl işliyor?</span>
            <svg class="sss-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
          </button>
          <div class="sss-a">
            <p>İletişim formundan "Mentörlük Talebi" konusunu seçerek bize ulaşabilirsin. Geçmiş yarışma başarıları ve uzmanlık alanına göre seni uygun bir mentörle eşleştiriyoruz. Mentör olmak isteyenler de aynı form üzerinden başvurabilir — platform üzerinde kendinizi tanıtma imkânı sunuyoruz.</p>
          </div>
        </div>

        <div class="sss-item">
          <button class="sss-q" onclick="toggleSSS(this)">
            <span>İlan açtıktan sonra ne kadar sürede yanıt alırım?</span>
            <svg class="sss-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
          </button>
          <div class="sss-a">
            <p>Bu tamamen ilanın içeriğine ve yarışma dönemine göre değişmekle birlikte, Teknofest ve TÜBİTAK başvuru dönemlerinde ilanlar genellikle 24–48 saat içinde başvuru alıyor. İlanına net bir açıklama, gerekli beceriler ve iletişim bilgisi eklersen dönüş süresi önemli ölçüde kısalıyor.</p>
          </div>
        </div>

        <div class="sss-item">
          <button class="sss-q" onclick="toggleSSS(this)">
            <span>Verilerim güvende mi?</span>
            <svg class="sss-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
          </button>
          <div class="sss-a">
            <p>Platforma girdiğin bilgiler yalnızca eşleşme ve iletişim süreçleri için kullanılır, üçüncü taraflarla paylaşılmaz. İletişim formundaki mesajlar doğrudan şifreli bağlantı üzerinden gönderilir. Hesabını istediğin zaman Ayarlar menüsünden tamamen silebilirsin.</p>
          </div>
        </div>

        <div class="sss-item">
          <button class="sss-q" onclick="toggleSSS(this)">
            <span>Platforma nasıl katkı sağlayabilirim?</span>
            <svg class="sss-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
          </button>
          <div class="sss-a">
            <p>En değerli katkı, platformu çevrene tavsiye etmen. Bunun yanı sıra yarışma deneyimlerini ve önerilerini iletişim formu üzerinden bizimle paylaşabilirsin. Yeni yarışma kategorisi önerisi, hata bildirimi veya iş birliği teklifleri için her zaman açığız.</p>
          </div>
        </div>

      </div>
    </div>
  </section>

<?php include __DIR__ . "/templates/shared/footer.php"; ?>
<script>
// SSS page - static content
initPage = async function() {};
</script>
<?php include __DIR__ . "/templates/shared/shared-js.php"; ?>
</body></html>
