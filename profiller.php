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

      <div style="text-align:center;margin-top:2.5rem;display:none;" id="profil-empty-msg"></div>
    </div>
  </section>

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
