<?php include __DIR__ . "/templates/shared/head.php"; ?>
<?php include __DIR__ . "/templates/shared/header.php"; ?>
  <!-- ===== HERO ===== -->
  <header class="hero">
    <div class="floor-grid"></div>

    <!-- floating 3D wireframe cubes -->
    <div class="f-cube c1"><div class="cf"></div><div class="cf"></div><div class="cf"></div><div class="cf"></div><div class="cf"></div><div class="cf"></div></div>
    <div class="f-cube c2"><div class="cf"></div><div class="cf"></div><div class="cf"></div><div class="cf"></div><div class="cf"></div><div class="cf"></div></div>
    <div class="f-cube c3"><div class="cf"></div><div class="cf"></div><div class="cf"></div><div class="cf"></div><div class="cf"></div><div class="cf"></div></div>
    <div class="f-cube c4"><div class="cf"></div><div class="cf"></div><div class="cf"></div><div class="cf"></div><div class="cf"></div><div class="cf"></div></div>

    <div class="container">
      <div class="hero-layout">

        <!-- LEFT: Visionary Text -->
        <div class="hero-content reveal">
          <div class="hero-eyebrow">YARIŞMA PLATFORMU</div>
          <h1>
            <span class="h1-l1">Fikir Senden,</span>
            <span class="h1-l2">Takımını Bulması</span>
            <span class="h1-l3">Bizden.</span>
          </h1>
          <p>Teknofest'ten ICPC'ye, TÜBİTAK'tan Kaggle'a — Türkiye'nin en yetenekli zihinleri burada buluşuyor. Ekibini kur, mentörünü seç, projenle dünyayı değiştir.</p>

          <!-- Platform Nasıl Çalışır -->
          <div style="display:flex;flex-direction:column;gap:0.75rem;margin-bottom:2.5rem;text-align:left;">
            <div style="display:flex;align-items:flex-start;gap:0.85rem;">
              <div style="width:32px;height:32px;min-width:32px;background:rgba(59,130,246,0.12);border:1px solid rgba(59,130,246,0.25);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:0.9rem;">📋</div>
              <div>
                <div style="font-weight:700;font-size:0.88rem;margin-bottom:0.1rem;">İlan Aç veya Keşfet</div>
                <div style="font-size:0.8rem;color:var(--text-dim);">Aradığın rolü veya projeyi saniyeler içinde yayınla ya da mevcut ilanları filtrele.</div>
              </div>
            </div>
            <div style="display:flex;align-items:flex-start;gap:0.85rem;">
              <div style="width:32px;height:32px;min-width:32px;background:rgba(139,92,246,0.12);border:1px solid rgba(139,92,246,0.25);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:0.9rem;">🤝</div>
              <div>
                <div style="font-weight:700;font-size:0.88rem;margin-bottom:0.1rem;">Eşleş & İletişime Geç</div>
                <div style="font-size:0.8rem;color:var(--text-dim);">Profilleri incele, başvur ve ortalama 48 saniyede eşleşme sağla.</div>
              </div>
            </div>
            <div style="display:flex;align-items:flex-start;gap:0.85rem;">
              <div style="width:32px;height:32px;min-width:32px;background:rgba(6,182,212,0.12);border:1px solid rgba(6,182,212,0.25);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:0.9rem;">🏆</div>
              <div>
                <div style="font-weight:700;font-size:0.88rem;margin-bottom:0.1rem;">Yarış & Kazan</div>
                <div style="font-size:0.8rem;color:var(--text-dim);">Takımınla yarışmaya katıl, mentör desteği al, ödülünü topla.</div>
              </div>
            </div>
          </div>
          <div class="hero-actions">
            <a href="ilanlar.php" class="btn btn-primary">
              <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
              İlanları Keşfet
            </a>
            <a href="yarismalar.php" class="btn btn-secondary">
              Yarışmaları Gör
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
          </div>

        </div>

        <!-- RIGHT: 3D Sphere -->
        <div class="hero-visual">
          <div class="sphere-orbit"></div>
          <div class="sphere-orbit"></div>
          <div class="sphere-glow"></div>
          <canvas id="v-sphere-canvas" width="500" height="500"></canvas>
        </div>

      </div>
    </div>


  </header>

  <section id="topluluk" style="padding:5rem 0;">
    <div class="container">
      <div class="section-header reveal">
        <div class="badge-pill">Topluluk</div>
        <h2>Topluluğa Katıl</h2>
        <p>XP kazan, takım kur, projeni büyüt</p>
      </div>
      <div class="cards-grid reveal">
        <div class="card-3d" style="cursor:pointer;" onclick="location.href='liderlik.php'">
          <div class="card-icon">🏆</div>
          <h3>Liderlik</h3>
          <p>Aktivitelerden XP kazan, seviye atla ve rozetlerini topla. Topluluğun en aktif üyesi ol.</p>
          <div class="liderlik-onizleme" id="liderlik-onizleme" style="margin:.6rem 0;font-size:.8rem;color:var(--text-dim);">Yükleniyor...</div>
          <span class="card-link">Sıralamayı Gör <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg></span>
        </div>
        <div class="card-3d" style="cursor:pointer;" onclick="location.href='forum.php'">
          <div class="card-icon">💬</div>
          <h3>Forum</h3>
          <p>Yarışmalar, takımlar ve mentorluk üzerine tartış. Sorularına topluluktan cevap al.</p>
          <span class="card-link">Forum'a Git <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg></span>
        </div>
        <div class="card-3d" style="cursor:pointer;" onclick="location.href='projeler.php'">
          <div class="card-icon">🚀</div>
          <h3>Projeler</h3>
          <p>Yarışma sonrası projeni kuluçkada büyüt: fikir → spec → MVP → yayın → yatırımcı.</p>
          <span class="card-link">Projelerime Git <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg></span>
        </div>
        <div class="card-3d" style="cursor:pointer;" onclick="location.href='mentorlar.php'">
          <div class="card-icon">🎓</div>
          <h3>Mentorlar</h3>
          <p>Deneyimli üyelerden mentorluk al veya sen mentor ol. Tecrübelerini paylaş.</p>
          <span class="card-link">Mentorları Gör <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg></span>
        </div>
      </div>
    </div>
  </section>

<?php include __DIR__ . "/templates/shared/footer.php"; ?>
<script>
async function liderlikOnizlemeYukle() {
  try {
    const { data } = await supabase.from('xp_toplam').select('kullanici_id, xp').order('xp', { ascending: false }).limit(3);
    const el = document.getElementById('liderlik-onizleme');
    if (!el) return;
    if (!data || !data.length) { el.textContent = 'Henüz XP toplanmadı — ilk sen başla! ⚡'; return; }
    const medals = ['🥇', '🥈', '🥉'];
    el.innerHTML = data.map((k, i) => '<div style="display:flex;justify-content:space-between;gap:.5rem;padding:.15rem 0;"><span>'+medals[i]+' '+(k.kullanici_id === (window._qtUserId) ? 'Sen' : '#'+k.kullanici_id.slice(0,6))+'</span><b>'+k.xp+' XP</b></div>').join('');
  } catch (e) {}
}
async function onizlemeKullaniciId() {
  try { const s = (await supabase.auth.getSession()).data.session; window._qtUserId = s?.user?.id; } catch (e) {}
}
initPage = async function() {
  onizlemeKullaniciId();
  liderlikOnizlemeYukle();
};
</script>
<?php include __DIR__ . "/templates/shared/shared-js.php"; ?>
</body></html>
