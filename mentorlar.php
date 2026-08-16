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
        <button class="btn btn-primary" onclick="mentorYeniModal()">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
          Mentor Ol
        </button>
      </div>

      <div id="mentor-listesi" class="reveal"></div>
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
