<?php include __DIR__ . "/templates/shared/head.php"; ?>
<?php include __DIR__ . "/templates/shared/header.php"; ?>
  <section id="ilanlar" style="background: var(--bg-surface); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
    <div class="container">
      <div class="section-header reveal">
        <div class="badge-pill">Fırsatlar</div>
        <h2>Aktif İlanlar</h2>
        <p>Takımına katılacak, proje ortağı veya mentör arayan ilanları keşfet</p>
      </div>

      <!-- İlan Ekle Button -->
      <div class="ilan-add-btn-wrap reveal">
        <button class="btn btn-primary" onclick="openIlanForm()" style="font-size:0.95rem;padding:0.9rem 2rem;box-shadow:0 6px 24px rgba(59,130,246,0.45),0 0 0 1px rgba(59,130,246,0.2);">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
          İlan Ekle
        </button>
      </div>

      <div style="display:flex;gap:0.6rem;flex-wrap:wrap;justify-content:center;margin-bottom:2.5rem;margin-top:2rem;" class="reveal filter-btns">
        <button class="btn btn-primary btn-sm" data-tag="all" onclick="filterIlanlar('all',this)">Tümü</button>
        <button class="btn btn-ghost btn-sm" data-tag="yeni" onclick="filterIlanlar('yeni',this)">Yeni</button>
        <button class="btn btn-ghost btn-sm" data-tag="acik" onclick="filterIlanlar('acik',this)">Açık</button>
        <button class="btn btn-ghost btn-sm" data-tag="yakin" onclick="filterIlanlar('yakin',this)">Son Gün</button>
        <button class="btn btn-ghost btn-sm" data-tag="online" onclick="filterIlanlar('online',this)">Online</button>
      </div>

      <div class="ilanlar-grid reveal" id="ilanlar-grid">

        <div class="empty-grid-msg" id="ilanlar-empty-msg">
          <div class="empty-icon">📋</div>
          <h4>Henüz ilan yok</h4>
          <p>İlk ilanı sen ekle! Yukarıdaki "İlan Ekle" butonuna tıkla.</p>
        </div>

      </div>

      <div style="text-align:center;margin-top:3rem;" class="reveal">
        <button id="show-all-ilanlar-btn" class="btn btn-secondary" onclick="toggleShowAllIlanlar()" style="display:none;">
          Tüm İlanları Gör
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </button>
      </div>
    </div>
  </section>

  <div class="ilan-form-overlay" id="ilan-form-overlay" onclick="closeIlanForm(event)">
    <div class="ilan-form-modal">
      <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:0.6rem;">
        <div>
          <h3>📋 İlan Ekle</h3>
          <p class="modal-subtitle">Aradığın takım üyesini veya proje ortağını yayınla</p>
        </div>
        <button class="ai-modal-close" onclick="closeIlanForm()" style="margin-top:0.2rem;">✕</button>
      </div>

      <!-- Tür seçici tabs -->
      <div style="display:flex;gap:0.5rem;margin-bottom:1.8rem;background:rgba(255,255,255,0.03);border:1px solid var(--border);border-radius:14px;padding:0.4rem;">
        <button id="ilan-tab-takim" onclick="setIlanTab('takim')" style="flex:1;padding:0.55rem;border-radius:10px;border:none;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:0.82rem;cursor:pointer;background:var(--primary);color:white;transition:all 0.2s;">👥 Takım Üyesi</button>
        <button id="ilan-tab-mentor" onclick="setIlanTab('mentor')" style="flex:1;padding:0.55rem;border-radius:10px;border:none;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:0.82rem;cursor:pointer;background:transparent;color:var(--text-dim);transition:all 0.2s;">🎓 Mentör</button>
        <button id="ilan-tab-ortak" onclick="setIlanTab('ortak')" style="flex:1;padding:0.55rem;border-radius:10px;border:none;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:0.82rem;cursor:pointer;background:transparent;color:var(--text-dim);transition:all 0.2s;">🤝 Proje Ortağı</button>
      </div>

      <div class="form-group">
        <label class="form-label">İlan Başlığı *</label>
        <input type="text" class="form-control" id="if-baslik" placeholder="Örn: Teknofest 2026 için Python / ML geliştiricisi aranıyor">
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Durum</label>
          <select class="form-control" id="if-kategori">
            <option value="yeni">🟦 Yeni</option>
            <option value="acik">🟢 Açık</option>
            <option value="yakin">🟡 Son Gün</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Şehir / Konum</label>
          <select class="form-control" id="if-sehir">
            <option value="online">Uzaktan / Online</option>
            <option value="adana">Adana</option>
            <option value="adiyaman">Adıyaman</option>
            <option value="afyonkarahisar">Afyonkarahisar</option>
            <option value="agri">Ağrı</option>
            <option value="aksaray">Aksaray</option>
            <option value="amasya">Amasya</option>
            <option value="ankara">Ankara</option>
            <option value="antalya">Antalya</option>
            <option value="ardahan">Ardahan</option>
            <option value="artvin">Artvin</option>
            <option value="aydin">Aydın</option>
            <option value="balikesir">Balıkesir</option>
            <option value="bartin">Bartın</option>
            <option value="batman">Batman</option>
            <option value="bayburt">Bayburt</option>
            <option value="bilecik">Bilecik</option>
            <option value="bingol">Bingöl</option>
            <option value="bitlis">Bitlis</option>
            <option value="bolu">Bolu</option>
            <option value="burdur">Burdur</option>
            <option value="bursa">Bursa</option>
            <option value="canakkale">Çanakkale</option>
            <option value="cankiri">Çankırı</option>
            <option value="corum">Çorum</option>
            <option value="denizli">Denizli</option>
            <option value="diyarbakir">Diyarbakır</option>
            <option value="duzce">Düzce</option>
            <option value="edirne">Edirne</option>
            <option value="elazig">Elazığ</option>
            <option value="erzincan">Erzincan</option>
            <option value="erzurum">Erzurum</option>
            <option value="eskisehir">Eskişehir</option>
            <option value="gaziantep">Gaziantep</option>
            <option value="giresun">Giresun</option>
            <option value="gumushane">Gümüşhane</option>
            <option value="hakkari">Hakkari</option>
            <option value="hatay">Hatay</option>
            <option value="igdir">Iğdır</option>
            <option value="isparta">Isparta</option>
            <option value="istanbul">İstanbul</option>
            <option value="izmir">İzmir</option>
            <option value="kahramanmaras">Kahramanmaraş</option>
            <option value="karabuk">Karabük</option>
            <option value="karaman">Karaman</option>
            <option value="kars">Kars</option>
            <option value="kastamonu">Kastamonu</option>
            <option value="kayseri">Kayseri</option>
            <option value="kilis">Kilis</option>
            <option value="kirikkale">Kırıkkale</option>
            <option value="kirklareli">Kırklareli</option>
            <option value="kirsehir">Kırşehir</option>
            <option value="kocaeli">Kocaeli</option>
            <option value="konya">Konya</option>
            <option value="kutahya">Kütahya</option>
            <option value="malatya">Malatya</option>
            <option value="manisa">Manisa</option>
            <option value="mardin">Mardin</option>
            <option value="mersin">Mersin</option>
            <option value="mugla">Muğla</option>
            <option value="mus">Muş</option>
            <option value="nevsehir">Nevşehir</option>
            <option value="nigde">Niğde</option>
            <option value="ordu">Ordu</option>
            <option value="osmaniye">Osmaniye</option>
            <option value="rize">Rize</option>
            <option value="sakarya">Sakarya</option>
            <option value="samsun">Samsun</option>
            <option value="sanliurfa">Şanlıurfa</option>
            <option value="siirt">Siirt</option>
            <option value="sinop">Sinop</option>
            <option value="sirnak">Şırnak</option>
            <option value="sivas">Sivas</option>
            <option value="tekirdag">Tekirdağ</option>
            <option value="tokat">Tokat</option>
            <option value="trabzon">Trabzon</option>
            <option value="tunceli">Tunceli</option>
            <option value="usak">Uşak</option>
            <option value="van">Van</option>
            <option value="yalova">Yalova</option>
            <option value="yozgat">Yozgat</option>
            <option value="zonguldak">Zonguldak</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">İlan Açıklaması *</label>
        <textarea class="form-control" id="if-aciklama" rows="4" placeholder="Projenizi, aradığınız kişinin özelliklerini ve beklentilerinizi kısaca açıklayın..."></textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Etiketler / Beceriler <span style="color:var(--text-dim);font-weight:400;">(virgülle ayır)</span></label>
        <input type="text" class="form-control" id="if-etiketler" placeholder="Örn: Python, PyTorch, Teknofest, YOLO">
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Kişi Sayısı</label>
          <input type="text" class="form-control" id="if-kisi" placeholder="Örn: 1 Kişi">
        </div>
        <div class="form-group">
          <label class="form-label">İletişim (e-posta)</label>
          <input type="text" class="form-control" id="if-iletisim" placeholder="email@ornek.com">
        </div>
      </div>

      <!-- AI Yardımcı Bar -->
      <div class="ai-suggest-bar" onclick="fillIlanWithAI()" style="margin-bottom:1.2rem;">
        <span class="ai-icon">✨</span>
        <div class="ai-suggest-bar-text"><strong>AI Asistan</strong> — Projeyi kısaca anlat, açıklamayı otomatik oluşturalım</div>
        <span class="ai-suggest-bar-cta">Dene →</span>
      </div>

      <button class="contact-send-btn" onclick="submitIlanForm()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2 11 13"/><path d="M22 2 15 22 11 13 2 9l20-7z"/></svg>
        İlanı Yayınla
      </button>
      <div class="contact-footnote" style="margin-top:0.9rem;">
        <span>📋 İlan anında yayınlanır</span>
        <span>✅ Tamamen ücretsiz</span>
        <span>🔒 Veriler güvende</span>
      </div>
    </div>
  </div>

<?php include __DIR__ . "/templates/shared/footer.php"; ?>
<script>
// Ilanlar page - load ilanlar and override form handlers
initPage = async function() {
  if (typeof loadIlanlar === "function") await loadIlanlar();
  if (typeof overrideIlanFunctions === "function") overrideIlanFunctions();
};
</script>
<?php include __DIR__ . "/templates/shared/shared-js.php"; ?>
</body></html>
