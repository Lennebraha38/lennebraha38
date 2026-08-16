<?php include __DIR__ . "/templates/shared/head.php"; ?>
<?php include __DIR__ . "/templates/shared/header.php"; ?>
  <section id="dogrula">
    <div class="container">
      <div class="section-header reveal">
        <div class="badge-pill">Doğrulama</div>
        <h2>Sertifika Doğrula</h2>
        <p>Token ile sertifikanın geçerliliğini kontrol et</p>
      </div>

      <div class="reveal" style="max-width:560px;margin:0 auto;margin-bottom:1.4rem;">
        <div class="forum-cevap-form" style="margin-top:0;">
          <input type="text" id="dogrula-token" placeholder="Sertifika token'ını yapıştır..." onkeydown="if(event.key==='Enter')dogrulaTokenKontrol()">
          <button class="btn btn-primary" onclick="dogrulaTokenKontrol()">Doğrula</button>
        </div>
      </div>

      <div id="sertifika-dogrulama" class="reveal"></div>
    </div>
  </section>

<?php include __DIR__ . "/templates/shared/footer.php"; ?>
<script>
function dogrulaTokenKontrol() {
  const token = document.getElementById('dogrula-token')?.value?.trim();
  if (!token) { showToast('⚠️ Token girin!'); return; }
  sertifikaDogrula(token);
}
window.dogrulaTokenKontrol = dogrulaTokenKontrol;
initPage = async function() {
  const params = new URLSearchParams(window.location.search);
  const token = params.get('token');
  if (token) {
    document.getElementById('dogrula-token').value = token;
    sertifikaDogrula(token);
  }
};
</script>
<?php include __DIR__ . "/templates/shared/shared-js.php"; ?>
</body></html>
