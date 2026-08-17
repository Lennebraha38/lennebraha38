<?php include __DIR__ . "/templates/shared/head.php"; ?>
<?php include __DIR__ . "/templates/shared/header.php"; ?>
  <section id="mentorlar">
    <div class="container">
      <div class="section-header reveal">
        <div class="badge-pill">Mentorluk</div>
        <h2>Mentorlar</h2>
        <p>Deneyimli üyelerden mentorluk al veya mentor ol</p>
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
