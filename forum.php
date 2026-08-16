<?php include __DIR__ . "/templates/shared/head.php"; ?>
<?php include __DIR__ . "/templates/shared/header.php"; ?>
  <section id="forum">
    <div class="container">
      <div class="section-header reveal">
        <div class="badge-pill">Topluluk</div>
        <h2>Forum</h2>
        <p>Yarışmalar, takımlar ve mentorluk üzerine tartış</p>
      </div>

      <div class="reveal" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.8rem;margin-bottom:1.2rem;">
        <div class="forum-tablar" style="margin-bottom:0;">
          <div class="forum-tab active" onclick="forumEtiketSec(this,'')">Tümü</div>
          <div class="forum-tab" onclick="forumEtiketSec(this,'genel')">Genel</div>
          <div class="forum-tab" onclick="forumEtiketSec(this,'yarisma')">Yarışma</div>
          <div class="forum-tab" onclick="forumEtiketSec(this,'takim')">Takım</div>
          <div class="forum-tab" onclick="forumEtiketSec(this,'mentorluk')">Mentorluk</div>
        </div>
        <button class="btn btn-primary" onclick="forumYeniKonuModal()">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
          Yeni Konu
        </button>
      </div>

      <div id="forum-konu-listesi" class="reveal"></div>
    </div>
  </section>

<?php include __DIR__ . "/templates/shared/footer.php"; ?>
<script>
initPage = async function() {
  forumYukle('');
};
</script>
<?php include __DIR__ . "/templates/shared/shared-js.php"; ?>
</body></html>
