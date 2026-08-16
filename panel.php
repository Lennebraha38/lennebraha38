<?php include __DIR__ . "/templates/shared/head.php"; ?>
<?php include __DIR__ . "/templates/shared/header.php"; ?>
  <section id="panel">
    <div class="container">
      <div class="section-header reveal">
        <div class="badge-pill">Panel</div>
        <h2>Topluluk Paneli</h2>
        <p>Platformdaki aktiviteye genel bakış</p>
      </div>

      <div id="analitik-panel" class="reveal"></div>

      <div class="icerik-dolu reveal" style="background:var(--card-bg);border:1px solid var(--border);border-radius:16px;padding:1.3rem;margin-top:1.4rem;">
        <h3>📌 Hızlı Erişim</h3>
        <ul>
          <li><a href="projeler.php">Projelerim — fikirden yatırımcıya büyüt</a></li>
          <li><a href="yarismalar.php">Yarışmalar — başvuru takibi ve geri sayım</a></li>
          <li><a href="liderlik.php">Liderlik — XP ve rozetler</a></li>
          <li><a href="mentorlar.php">Mentorlar — deneyimlerden yararlan</a></li>
        </ul>
      </div>
    </div>
  </section>

<?php include __DIR__ . "/templates/shared/footer.php"; ?>
<script>
initPage = async function() {
  analitikYukle();
};
</script>
<?php include __DIR__ . "/templates/shared/shared-js.php"; ?>
</body></html>
