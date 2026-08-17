<?php include __DIR__ . "/templates/shared/head.php"; ?>
<?php include __DIR__ . "/templates/shared/header.php"; ?>
  <section id="projeler">
    <div class="container">
      <div class="section-header reveal">
        <div class="badge-pill">Kuluçka</div>
        <h2>Projelerim</h2>
        <p>Yarışma sonrası projelerini büyüt: fikirden yatırımcıya</p>
      </div>

      <div class="reveal" style="display:flex;justify-content:flex-end;margin-bottom:1.2rem;">
        <button class="btn btn-primary" onclick="toggleProjeForm()">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
          Yeni Proje
        </button>
      </div>

      <div class="page-form-area reveal" id="proje-form-alani">
        <h3>🚀 Yeni Proje</h3>
        <p class="pfa-sub">Fikrini projeye dönüştür, ilk adımı at.</p>
        <div class="form-group">
          <label class="form-label">Proje Adı</label>
          <input type="text" class="form-control" id="proje-ad" placeholder="Örn: Yapay Zeka Destekli Trafik Analizi">
        </div>
        <div class="form-group">
          <label class="form-label">Etiketler <span style="color:var(--text-dim);font-weight:400;">(virgülle ayır)</span></label>
          <input type="text" class="form-control" id="proje-etiketler" placeholder="AI, Görüntü İşleme, Python">
        </div>
        <div class="form-group">
          <label class="form-label">Açıklama</label>
          <textarea class="form-control" id="proje-aciklama" rows="3" placeholder="Projenizi ve hedefinizi anlatın..."></textarea>
        </div>
        <button class="btn btn-primary" style="width:100%;justify-content:center;" onclick="projeKaydet()">Projeyi Ekle</button>
      </div>

      <div id="proje-listesi" class="reveal"></div>

      <div class="icerik-dolu reveal" style="background:var(--card-bg);border:1px solid var(--border);border-radius:16px;padding:1.3rem;margin-top:1.2rem;">
        <h3>🚀 Aşamalar</h3>
        <ul>
          <li><b>Fikir</b> — Projeyi tanımla, hedefi netleştir</li>
          <li><b>Spec / Tasarım</b> — Gereksinimler ve mimari</li>
          <li><b>MVP</b> — Çalışan ilk sürüm</li>
          <li><b>Yayında</b> — Gerçek kullanıcıya açık</li>
          <li><b>Yatırımcı</b> — Büyüme ve yatırım arayışı</li>
        </ul>
        <p style="margin-top:.6rem;color:var(--text-dim);font-size:.85rem;">Her aşama ilerletmede +15 XP kazanırsın. Projen yayına çıktığında mentörlerden geri bildirim isteyebilirsin.</p>
      </div>
    </div>
  </section>

<?php include __DIR__ . "/templates/shared/footer.php"; ?>
<script>
initPage = async function() {
  projeYukle();
};
</script>
<?php include __DIR__ . "/templates/shared/shared-js.php"; ?>
</body></html>
