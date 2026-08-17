<?php include __DIR__ . "/templates/shared/head.php"; ?>
<?php include __DIR__ . "/templates/shared/header.php"; ?>
  <section id="mentorlar">
    <div class="container">
      <div class="section-header reveal">
        <div class="badge-pill">Mentorluk</div>
        <h2>Mentorlar</h2>
        <p>Deneyimli üyelerden mentorluk al veya mentor ol</p>
      </div>

      <div class="reveal" style="display:flex;justify-content:flex-end;margin-bottom:1.2rem;">
        <button class="btn btn-primary" onclick="toggleMentorForm()">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
          Mentor Ol
        </button>
      </div>

      <div class="page-form-area reveal" id="mentor-form-alani">
        <h3>🎓 Mentor Profili Oluştur</h3>
        <p class="pfa-sub">Deneyimlerini paylaş, gelecek nesillere rehberlik et.</p>
        <div class="form-group">
          <label class="form-label">Ad Soyad</label>
          <input type="text" class="form-control" id="mentor-ad" placeholder="Adınız Soyadınız">
        </div>
        <div class="form-group">
          <label class="form-label">Unvan</label>
          <input type="text" class="form-control" id="mentor-unvan" placeholder="Örn: ML Mühendisi, Startup Kurucu">
        </div>
        <div class="form-group">
          <label class="form-label">Uzmanlık Alanları</label>
          <input type="text" class="form-control" id="mentor-alanlar" placeholder="Python, TensorFlow, Strateji">
        </div>
        <div class="form-group">
          <label class="form-label">Deneyim (yıl)</label>
          <input type="text" class="form-control" id="mentor-deneyim" placeholder="Örn: 5">
        </div>
        <div class="form-group">
          <label class="form-label">Müsaitlik</label>
          <input type="text" class="form-control" id="mentor-musait" placeholder="Haftada 2 saat">
        </div>
        <div class="form-group">
          <label class="form-label">Tanıtım</label>
          <textarea class="form-control" id="mentor-tanitim" rows="3" placeholder="Kendinizi ve mentorluk yaklaşımınızı tanıtın..."></textarea>
        </div>
        <button class="btn btn-primary" style="width:100%;justify-content:center;" onclick="mentorKaydet()">Mentor Ol</button>
      </div>

      <div id="mentor-listesi" class="reveal"></div>

      <div class="page-form-area" id="mentor-talep-form" style="max-width:500px;margin:1.4rem auto 0;">
        <h3>🎓 Mentorluk Talebi</h3>
        <p class="pfa-sub">Mentoruna mesaj gönder, rehberlik al.</p>
        <input type="hidden" id="mentor-talep-id">
        <div class="dm-alici">Mentor: <b id="mentor-talep-ad">—</b></div>
        <div class="form-group">
          <label class="form-label">Mesajın</label>
          <textarea class="form-control" id="mentor-talep-mesaj" rows="4" placeholder="Neyde yardım istiyorsun? Hangi yarışmaya hazırlanıyorsun?"></textarea>
        </div>
        <button class="btn btn-primary" style="width:100%;justify-content:center;" onclick="mentorTalepGonder()">Talebi Gönder</button>
      </div>
    </div>
  </section>

<?php include __DIR__ . "/templates/shared/footer.php"; ?>
<script>
initPage = async function() {
  mentorYukle();
};
</script>
<?php include __DIR__ . "/templates/shared/shared-js.php"; ?>
</body></html>
