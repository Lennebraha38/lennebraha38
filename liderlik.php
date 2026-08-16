<?php include __DIR__ . "/templates/shared/head.php"; ?>
<?php include __DIR__ . "/templates/shared/header.php"; ?>
  <section id="liderlik">
    <div class="container">
      <div class="section-header reveal">
        <div class="badge-pill">Oyunlaştırma</div>
        <h2>Liderlik Tablosu</h2>
        <p>Aktivitelerden XP kazan, seviye atla, rozetleri topla</p>
      </div>

      <div class="reveal" style="margin-bottom:1.4rem;">
        <div style="display:flex;gap:.8rem;flex-wrap:wrap;margin-bottom:1.2rem;">
          <button class="btn btn-primary" onclick="liderlikYukle()">Sıralama</button>
          <button class="btn btn-ghost" onclick="rozetlerimGoster()">Rozetlerim</button>
        </div>
        <div id="liderlik-listesi"></div>
        <div id="rozetlerim-listesi" style="display:none;"></div>
      </div>

      <div class="icerik-dolu reveal" style="background:var(--card-bg);border:1px solid var(--border);border-radius:16px;padding:1.3rem;">
        <h3>⚡ XP Nasıl Kazanılır?</h3>
        <ul>
          <li>Günlük giriş — 5 XP</li>
          <li>Profil oluşturma — 50 XP</li>
          <li>Yarışma kaydı ekleme — 40 XP</li>
          <li>Ekip kurma / davet — 30 XP</li>
          <li>Proje ekleme — 20 XP · Aşama ilerletme — 15 XP</li>
          <li>Forum konusu — 10 XP · Forum cevabı — 5 XP</li>
          <li>İlan başvurusu — 15 XP · Mentor olma — 25 XP</li>
        </ul>
        <h3>🎖️ Rozetler</h3>
        <ul>
          <li>👤 Profilini Tamamla · 📝 İlk Yarışma Kaydı · 🤝 İlk Ekip</li>
          <li>💬 Forum Yazarı · 🚀 Proje Sahibi · 🎓 Mentor</li>
          <li>🔥 7 Gün Seri · ⚡ Aktif Üye</li>
        </ul>
      </div>
    </div>
  </section>

<?php include __DIR__ . "/templates/shared/footer.php"; ?>
<script>
initPage = async function() {
  liderlikYukle();
};
</script>
<?php include __DIR__ . "/templates/shared/shared-js.php"; ?>
</body></html>
