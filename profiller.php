<?php include __DIR__ . "/templates/shared/head.php"; ?>
<?php include __DIR__ . "/templates/shared/header.php"; ?>
  <section id="profiller">
    <div class="container">
      <div class="section-header reveal">
        <div class="badge-pill">Topluluk</div>
        <h2>Üye Profilleri</h2>
        <p>Takımına katılacak yetenekleri keşfet veya kendi profilini oluştur</p>
      </div>

      <div class="profil-add-btn-wrap reveal">
        <button class="btn btn-primary" onclick="openProfilForm()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
          Profilimi Ekle
        </button>
      </div>

      <div class="profil-search-bar reveal">
        <input type="text" class="profil-search-input" id="profil-search" placeholder="🔍  İsim, beceri veya şehir ara..." oninput="filterProfiller()">
        <select class="profil-filter-select" id="profil-alan" onchange="filterProfiller()">
          <option value="">Tüm Alanlar</option>
          <option value="yazilim">Yazılım</option>
          <option value="yapay-zeka">Yapay Zeka</option>
          <option value="donanim">Donanım / Elektronik</option>
          <option value="tasarim">Tasarım</option>
          <option value="siber">Siber Güvenlik</option>
          <option value="mekanik">Mekanik</option>
        </select>
        <select class="profil-filter-select" id="profil-sehir" onchange="filterProfiller()">
          <option value="">Tüm Şehirler</option>
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
          <option value="online">Online / Uzaktan</option>
        </select>
      </div>

      <div class="profiller-grid reveal" id="profiller-grid">

        <div class="empty-grid-msg" id="profiller-empty-msg-initial">
          <div class="empty-icon">👤</div>
          <h4>Henüz profil yok</h4>
          <p>İlk profili sen ekle! Yukarıdaki "Profilimi Ekle" butonuna tıkla.</p>
        </div>

      </div>

      <div style="text-align:center;margin-top:2.5rem;" class="reveal" id="profil-empty-msg" style="display:none;"></div>
    </div>
  </section>

  <div class="profil-form-overlay" id="profil-form-overlay" onclick="closeProfilForm(event)">
    <div class="profil-form-modal">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.2rem;">
        <div>
          <h3>Profilini Ekle</h3>
          <p>Yeteneklerini paylaş, takımını bul</p>
        </div>
        <button class="ai-modal-close" onclick="closeProfilFormBtn()">✕</button>
      </div>

      <!-- PROFİL FOTOĞRAFI -->
      <div class="avatar-upload-wrap">
        <input type="file" id="pf-photo-input" accept="image/*" onchange="handleAvatarUpload(event)">
        <div class="avatar-upload-circle" onclick="document.getElementById('pf-photo-input').click()" id="avatar-circle">
          <img id="avatar-preview" alt="Profil fotoğrafı">
          <div class="avatar-upload-placeholder" id="avatar-placeholder">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Fotoğraf Ekle
          </div>
          <div class="avatar-upload-overlay">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
            Değiştir
          </div>
        </div>
        <div class="avatar-upload-hint">JPG, PNG veya GIF · Maks 5 MB<br><span style="color:var(--text-dim);font-size:0.68rem;">Fotoğraf eklenmezse baş harfleriniz gösterilir</span></div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Ad</label>
          <input type="text" class="form-control" id="pf-ad" placeholder="Adın">
        </div>
        <div class="form-group">
          <label class="form-label">Soyad</label>
          <input type="text" class="form-control" id="pf-soyad" placeholder="Soyadın">
        </div>
      </div>
      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label">Üniversite / Okul</label>
        <input type="text" class="form-control" id="pf-uni" placeholder="Örn: ODTÜ, İTÜ, Boğaziçi...">
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Alan</label>
          <select class="form-control" id="pf-alan">
            <option value="yazilim">Yazılım</option>
            <option value="yapay-zeka">Yapay Zeka</option>
            <option value="donanim">Donanım / Elektronik</option>
            <option value="tasarim">Tasarım</option>
            <option value="siber">Siber Güvenlik</option>
            <option value="mekanik">Mekanik</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Şehir</label>
          <select class="form-control" id="pf-sehir">
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
            <option value="online">Online / Uzaktan</option>
          </select>
        </div>
      </div>
      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label">Beceriler <span style="color:var(--text-dim);font-weight:400;">(virgülle ayır)</span></label>
        <input type="text" class="form-control" id="pf-skills" placeholder="Örn: Python, PyTorch, Teknofest, YOLO">
      </div>
      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label">Kısa Biyografi</label>
        <textarea class="form-control" id="pf-bio" rows="3" placeholder="Deneyimini, yarışma geçmişini ve aradığını kısaca anlat..."></textarea>
      </div>
      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label">İletişim (e-posta veya Discord)</label>
        <input type="text" class="form-control" id="pf-iletisim" placeholder="ornek@email.com veya discord#1234">
      </div>
      <div class="form-group" style="margin-bottom:1.5rem;">
        <label class="form-label">Haftalık müsait saat</label>
        <select class="form-control" id="pf-saat">
          <option>5–10 saat</option>
          <option>10–15 saat</option>
          <option>15–20 saat</option>
          <option>20+ saat</option>
        </select>
      </div>
      <button class="btn btn-primary" style="width:100%;justify-content:center;" onclick="submitProfilForm()">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
        Profili Yayınla
      </button>
    </div>
  </div>


<?php include __DIR__ . "/templates/shared/footer.php"; ?>
<script>
// Profiller page - load profiles and override form handlers
initPage = async function() {
  if (typeof loadProfiller === "function") await loadProfiller();
  if (typeof overrideProfilFunctions === "function") overrideProfilFunctions();
};
</script>
<?php include __DIR__ . "/templates/shared/shared-js.php"; ?>
</body></html>
