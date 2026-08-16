  <!-- ===== FOOTER ===== -->
  <footer>
    <div class="container">
      <div class="footer-inner">
        <div class="footer-brand">
          <a href="index.php" class="logo" style="display:flex;align-items:center;">
            <img src="logo-beyaz.png" class="theme-logo" alt="Quantro" style="height:36px;width:auto;">
          </a>
          <p>Türkiye'nin yarışma odaklı profesyonel bağlantı platformu. Takımını bul, yarışmanı kazan.</p>
        </div>
        <div class="footer-links">
          <a href="yarismalar.php">Yarışmalar</a>
          <a href="ilanlar.php">İlanlar</a>
          <a href="takvim.php">Takvim</a>
          <a href="gorevler.php">Ekipler</a>
          <a href="forum.php">Forum</a>
          <a href="liderlik.php">Liderlik</a>
          <a href="projeler.php">Projeler</a>
          <a href="mentorlar.php">Mentorlar</a>
          <a href="iletisim.php">İletişim</a>
          <a href="profiller.php">Profiller</a>
          <a href="sss.php">SSS</a>
          <a href="dogrula.php">Sertifika Doğrula</a>
        </div>
      </div>
      <div class="footer-bottom">
        <span>© 2026 Quantro. Tüm hakları saklıdır.</span>
        <span style="display:flex;align-items:center;gap:0.4rem;">
          <span style="width:6px;height:6px;background:#10b981;border-radius:50%;box-shadow:0 0 6px #10b981;"></span>
          Tüm sistemler çalışıyor
        </span>
      </div>
    </div>
  </footer>


  <!-- ===== TOAST ===== -->
  <div id="toast"></div>

  <div id="settings-overlay" onclick="if(event.target===this) closeSettingsModal()">
    <div class="settings-card">
      <div class="settings-header">
        <h3>⚙️ Ayarlar</h3>
        <button class="ai-modal-close" onclick="closeSettingsModal()" aria-label="Ayarları kapat"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
      </div>
      <div class="settings-section">
        <div class="settings-section-title">Bildirimler</div>
        <div class="settings-row">
          <div>
            <div class="settings-row-label">Yarışma Hatırlatıcıları</div>
            <div class="settings-row-sub">Son başvuru tarihlerinde bildirim al</div>
          </div>
          <button class="settings-toggle on" id="n-yarisma" onclick="toggleAyar('n-yarisma')"></button>
        </div>
        <div class="settings-row">
          <div>
            <div class="settings-row-label">Yeni İlan Bildirimleri</div>
            <div class="settings-row-sub">İlgi alanına uygun ilanlar gelince bildir</div>
          </div>
          <button class="settings-toggle on" id="n-ilan" onclick="toggleAyar('n-ilan')"></button>
        </div>
        <div class="settings-row">
          <div>
            <div class="settings-row-label">Takım Davet Bildirimleri</div>
            <div class="settings-row-sub">Sana takım daveti geldiğinde bildir</div>
          </div>
          <button class="settings-toggle" id="n-davet" onclick="toggleAyar('n-davet')"></button>
        </div>
      </div>
      <div class="settings-section">
        <div class="settings-section-title">Görünüm</div>
        <div class="settings-row">
          <div>
            <div class="settings-row-label">Özel İmleç</div>
            <div class="settings-row-sub">Animasyonlu özel imleci etkinleştir</div>
          </div>
          <button class="settings-toggle on" id="cursor-toggle" onclick="toggleAyar('cursor-toggle')"></button>
        </div>
        <div class="settings-row">
          <div>
            <div class="settings-row-label">Parçacık Arka Planı</div>
            <div class="settings-row-sub">Hareketli parçacık efektini göster</div>
          </div>
          <button class="settings-toggle on" id="particle-toggle" onclick="toggleAyar('particle-toggle')"></button>
        </div>
      </div>
      <div class="settings-section">
        <div class="settings-section-title">Hesap</div>
        <div class="settings-row" style="cursor:pointer;" onclick="closeSettingsModal();openProfilForm()">
          <div>
            <div class="settings-row-label">Profil Bilgileri</div>
            <div class="settings-row-sub">Ad, biyografi ve becerilerini düzenle</div>
          </div>
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--text-dim);flex-shrink:0"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </div>
        <div class="settings-row" style="cursor:pointer;" onclick="closeSettingsModal();if(confirm('Hesabı silmek istediğinden emin misin? Bu işlem geri alınamaz!')) { doLogout(); location.reload(); }">
          <div>
            <div class="settings-row-label danger-text">Hesabı Sil</div>
            <div class="settings-row-sub">Tüm verilerini kalıcı olarak sil</div>
          </div>
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f87171" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0"><polyline points="3 6 5 6 21 6"/><path d="m19 6-.867 14.142A2 2 0 0 1 16.138 22H7.862a2 2 0 0 1-1.995-1.858L5 6m5 0V4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2"/></svg>
        </div>
      </div>
      <button class="btn btn-primary" style="width:100%" onclick="kaydetAyarlar()">Kaydet</button>
    </div>
  </div>

  <!-- ===== BAŞVURU MODAL ===== -->
  <div class="basvur-overlay" id="basvur-overlay" onclick="closeBasvurModal(event)">
    <div class="basvur-modal">
      <div class="basvur-modal-header">
        <div>
          <h3 id="basvur-title">Takıma Davet Et</h3>
          <p id="basvur-subtitle">İletişim yöntemini seç ve mesajını gönder</p>
        </div>
        <button class="ai-modal-close" onclick="closeBasvurModal()" aria-label="Kapat"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
      </div>

      <div class="basvur-method-tabs">
        <div class="basvur-tab active" onclick="setBasvurTab('email',this)">📧 E-posta</div>
      </div>

      <div id="basvur-email-form">
        <div class="form-group" style="margin-bottom:1rem;">
          <label class="form-label">Adın</label>
          <input type="text" class="form-control" id="b-adi" placeholder="Adın Soyadın" autocomplete="given-name">
        </div>
        <div class="form-group" style="margin-bottom:1rem;">
          <label class="form-label">E-postanız</label>
          <input type="email" class="form-control" id="b-email" placeholder="senin@email.com" autocomplete="email">
        </div>
        <div class="form-group" style="margin-bottom:1.2rem;">
          <label class="form-label">Mesajın</label>
          <textarea class="form-control" id="b-mesaj" rows="4" placeholder="Projeni, rolü ve beklentilerini kısaca anlat..."></textarea>
        </div>
        <button class="btn btn-primary" style="width:100%;justify-content:center;" onclick="sendBasvurEmail()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"/><rect x="2" y="4" width="20" height="16" rx="2"/></svg>
          Gmail ile Gönder
        </button>
      </div>


    </div>
  </div>

  <div id="google-mock-overlay" onclick="if(event.target===this) closeGoogleMock()">
    <div class="google-mock-card">

      <!-- TOP BAR (shown on all steps) -->
      <div class="gac-topbar">
        <div class="gac-topbar-left">
          <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="20" height="20">
            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
          </svg>
          <span>Google ile Giriş Yap</span>
        </div>
        <button class="gac-close-btn" onclick="closeGoogleMock()">✕</button>
      </div>

      <!-- STEP 0: Account Chooser -->
      <div id="google-step-0">
        <div class="gac-heading">
          <h2>Hesap seçin</h2>
          <p>Devam etmek için: <a href="#" onclick="return false;">Quantro</a></p>
        </div>
        <div class="gac-accounts" id="gac-accounts-list">
          <!-- Kayıtlı hesaplar JS ile doldurulacak -->
        </div>
        <div class="gac-divider"></div>
        <div class="gac-other-row" onclick="googleShowEmailStep()">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/><path d="M12 14v7m3.5-3.5L12 21l-3.5-3.5"/></svg>
          <span>Başka bir hesap kullan</span>
        </div>
        <div class="gac-footer">
          Bu uygulamayı kullanmadan önce <a href="#" onclick="return false;">Gizlilik Politikası</a> ve <a href="#" onclick="return false;">Hizmet Şartları</a>'nı inceleyebilirsiniz.
        </div>
      </div>

      <!-- STEP 1: Email Input -->
      <div id="google-step-1" style="display:none;">
        <div class="gac-logo-center">
          <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="22" height="22">
            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
          </svg>
          <span>Google</span>
        </div>
        <div class="gac-title">Oturum açın</div>
        <div class="gac-sub">Quantro'e devam edin</div>
        <div class="gac-error" id="google-error-1"></div>
        <div class="gac-input-wrap">
          <input type="email" class="gac-input" id="google-email-input" placeholder=" " autocomplete="email" onkeydown="if(event.key==='Enter') googleNextStep()">
          <label class="gac-input-label">E-posta veya telefon</label>
        </div>
        <div class="gac-hint">E-postanızı unuttunuz mu? <a class="gac-link" href="#" onclick="return false;">E-postayı bul</a></div>
        <div class="gac-actions">
          <button class="gac-link" onclick="closeGoogleMock()">İptal</button>
          <button class="gac-next-btn" onclick="googleNextStep()">İleri</button>
        </div>
      </div>

      <!-- STEP 2: Password -->
      <div id="google-step-2" style="display:none;">
        <div class="gac-logo-center">
          <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="22" height="22">
            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
          </svg>
          <span>Google</span>
        </div>
        <div class="gac-account-chip" onclick="googleBackStep()">
          <div class="chip-avatar" id="gac-chip-avatar" style="background:#5f6368;">·</div>
          <span id="google-chip-email">email</span>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
        </div>
        <div class="gac-title">Hoş geldiniz</div>
        <div class="gac-sub" id="google-mock-sub-2">Devam etmek için şifrenizi girin.</div>
        <div class="gac-error" id="google-error-2"></div>
        <div class="gac-input-wrap">
          <input type="password" class="gac-input" id="google-pass-input" placeholder=" " autocomplete="current-password" style="padding-right:2.8rem;" onkeydown="if(event.key==='Enter') confirmGoogleLogin()">
          <label class="gac-input-label">Şifrenizi girin</label>
          <button type="button" class="gac-pw-toggle" onclick="toggleGacPw()" title="Şifreyi göster/gizle">
            <svg id="gac-eye-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
        <div class="gac-hint" id="gac-hint-text">Kayıtlı hesaplar için önceki şifreniz geçerlidir. Yeni hesaplar için belirleyeceğiniz şifre ile kaydolursunuz.</div>
        <div class="gac-actions">
          <button class="gac-link" onclick="googleBackStep()">Geri</button>
          <button class="gac-next-btn" onclick="confirmGoogleLogin()">İleri</button>
        </div>
      </div>

    </div>
  </div>

  <!-- ===== PROFİL EKLEME FORMU (tüm sayfalarda ortak) ===== -->
  <div class="profil-form-overlay" id="profil-form-overlay" onclick="closeProfilForm(event)">
    <div class="profil-form-modal">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.2rem;">
        <div>
          <h3>Profilini Ekle</h3>
          <p>Yeteneklerini paylaş, takımını bul</p>
        </div>
        <button class="ai-modal-close" onclick="closeProfilFormBtn()" aria-label="Kapat"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
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
        <label class="form-label">Takımda Arıyorum <span style="color:var(--text-dim);font-weight:400;">(eşleştirme için önemli)</span></label>
        <input type="text" class="form-control" id="pf-ariyorum" placeholder="Örn: Python bilen, YOLO tecrübeli, robotik donanım">
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

  <!-- ===== İLAN DETAY MODAL ===== -->
  <div class="ilan-detail-overlay" id="ilan-detail-overlay" onclick="if(event.target===this)closeIlanDetail()">
  </div>

  <!-- ===== PROFİL DETAY MODAL ===== -->
  <div class="profil-detail-overlay" id="profil-detail-overlay" onclick="if(event.target===this)closeProfilDetail()">
    <!-- İçerik JS ile doldurulur -->
  </div>

  <!-- ===== DM MODAL ===== -->
  <div class="vz-overlay" id="dm-modal" onclick="if(event.target===this)closeDmModal()">
    <div class="vz-modal" style="max-width:520px;">
      <div class="vz-modal-head">
        <h3>💬 Mesajlar</h3>
        <button class="ai-modal-close" onclick="closeDmModal()" aria-label="Kapat"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
      </div>
      <div class="dm-tablar" style="display:flex;gap:.4rem;margin-bottom:1rem;">
        <button class="dm-tab active" id="dm-tab-gelen" onclick="dmTab('gelen')">✉️ Gelen</button>
        <button class="dm-tab" id="dm-tab-yeni" onclick="dmTab('yeni')">➤ Yeni Mesaj</button>
      </div>
      <div id="dm-gelen-kutusu">
        <div class="forum-bos">Yükleniyor...</div>
      </div>
      <div id="dm-yeni-form" style="display:none;">
        <div class="dm-alici">Kime: <b id="dm-alici-ad"></b></div>
        <input type="hidden" id="dm-alici">
        <div class="form-group" style="margin-bottom:1rem;">
          <label class="form-label">Mesajın</label>
          <textarea class="form-control" id="dm-icerik" rows="4" placeholder="Merhaba, takımına katılmak istiyorum..."></textarea>
        </div>
        <button class="btn btn-primary" style="width:100%;justify-content:center;" onclick="gonderDm()">Gönder</button>
      </div>
    </div>
  </div>

  <!-- ===== FORUM YENİ KONU MODAL ===== -->
  <div class="vz-overlay" id="forum-yeni-modal" onclick="if(event.target===this)forumYeniModalKapat()">
    <div class="vz-modal">
      <div class="vz-modal-head">
        <h3>💬 Yeni Konu Aç</h3>
        <button class="ai-modal-close" onclick="forumYeniModalKapat()" aria-label="Kapat"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
      </div>
      <div class="form-group" style="margin-bottom:.8rem;">
        <label class="form-label">Başlık</label>
        <input type="text" class="form-control" id="forum-baslik" placeholder="Konu başlığı...">
      </div>
      <div class="form-group" style="margin-bottom:.8rem;">
        <label class="form-label">Etiket</label>
        <select class="form-control" id="forum-etiket">
          <option value="genel">Genel</option>
          <option value="yarisma">Yarışma</option>
          <option value="takim">Takım</option>
          <option value="mentorluk">Mentorluk</option>
          <option value="duyuru">Duyuru</option>
        </select>
      </div>
      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label">İçerik</label>
        <textarea class="form-control" id="forum-icerik" rows="4" placeholder="Konunuzu anlatın..."></textarea>
      </div>
      <button class="btn btn-primary" style="width:100%;justify-content:center;" onclick="forumKonuEkle()">Yayınla</button>
    </div>
  </div>

  <!-- ===== PROJE YENİ MODAL ===== -->
  <div class="vz-overlay" id="proje-yeni-modal" onclick="if(event.target===this)projeYeniModalKapat()">
    <div class="vz-modal">
      <div class="vz-modal-head">
        <h3>🚀 Yeni Proje</h3>
        <button class="ai-modal-close" onclick="projeYeniModalKapat()" aria-label="Kapat"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
      </div>
      <div class="form-group" style="margin-bottom:.8rem;">
        <label class="form-label">Proje Adı</label>
        <input type="text" class="form-control" id="proje-ad" placeholder="Örn: Yapay Zeka Destekli Trafik Analizi">
      </div>
      <div class="form-group" style="margin-bottom:.8rem;">
        <label class="form-label">Etiketler <span style="color:var(--text-dim);font-weight:400;">(virgülle ayır)</span></label>
        <input type="text" class="form-control" id="proje-etiketler" placeholder="AI, Görüntü İşleme, Python">
      </div>
      <div class="form-group" style="margin-bottom:.8rem;">
        <label class="form-label">Demo URL <span style="color:var(--text-dim);font-weight:400;">(opsiyonel)</span></label>
        <input type="text" class="form-control" id="proje-demo" placeholder="https://...">
      </div>
      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label">Açıklama</label>
        <textarea class="form-control" id="proje-aciklama" rows="3" placeholder="Projenizi ve hedefinizi anlatın..."></textarea>
      </div>
      <button class="btn btn-primary" style="width:100%;justify-content:center;" onclick="projeKaydet()">Projeyi Ekle</button>
    </div>
  </div>

  <!-- ===== MENTOR YENİ MODAL ===== -->
  <div class="vz-overlay" id="mentor-yeni-modal" onclick="if(event.target===this)mentorYeniModalKapat()">
    <div class="vz-modal">
      <div class="vz-modal-head">
        <h3>🎓 Mentor Profili Oluştur</h3>
        <button class="ai-modal-close" onclick="mentorYeniModalKapat()" aria-label="Kapat"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
      </div>
      <div class="form-group" style="margin-bottom:.8rem;">
        <label class="form-label">Ad Soyad</label>
        <input type="text" class="form-control" id="mentor-ad" placeholder="Adın Soyadın">
      </div>
      <div class="form-group" style="margin-bottom:.8rem;">
        <label class="form-label">Unvan</label>
        <input type="text" class="form-control" id="mentor-unvan" placeholder="Örn: Yapay Zeka Mühendisi @ Roketsan">
      </div>
      <div class="form-group" style="margin-bottom:.8rem;">
        <label class="form-label">Uzmanlık Alanları <span style="color:var(--text-dim);font-weight:400;">(virgülle ayır)</span></label>
        <input type="text" class="form-control" id="mentor-alanlar" placeholder="Yapay Zeka, Görüntü İşleme, Gömülü Sistem">
      </div>
      <div class="form-group" style="margin-bottom:.8rem;">
        <label class="form-label">Deneyim</label>
        <input type="text" class="form-control" id="mentor-deneyim" placeholder="5 yıl · TEKNOFEST jüri üyeliği · 3 takım şampiyonluğu">
      </div>
      <div class="form-group" style="margin-bottom:.8rem;">
        <label class="form-label">Müsaitlik</label>
        <input type="text" class="form-control" id="mentor-musait" placeholder="Haftada 2 saat · Çevrimiçi">
      </div>
      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label">Tanıtım</label>
        <textarea class="form-control" id="mentor-tanitim" rows="3" placeholder="Nelerde yardımcı olabilirsiniz?"></textarea>
      </div>
      <button class="btn btn-primary" style="width:100%;justify-content:center;" onclick="mentorKaydet()">Mentor Ol</button>
    </div>
  </div>

  <!-- ===== MENTOR TALEP MODAL ===== -->
  <div class="vz-overlay" id="mentor-talep-modal" onclick="if(event.target===this)mentorTalepKapat()">
    <div class="vz-modal">
      <div class="vz-modal-head">
        <h3>🎓 Mentorluk Talebi</h3>
        <button class="ai-modal-close" onclick="mentorTalepKapat()" aria-label="Kapat"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
      </div>
      <input type="hidden" id="mentor-talep-id">
      <div class="dm-alici">Mentor: <b id="mentor-talep-ad"></b></div>
      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label">Mesajın</label>
        <textarea class="form-control" id="mentor-talep-mesaj" rows="4" placeholder="Neyde yardım istiyorsun? Hangi yarışmaya hazırlanıyorsun?"></textarea>
      </div>
      <button class="btn btn-primary" style="width:100%;justify-content:center;" onclick="mentorTalepGonder()">Talebi Gönder</button>
    </div>
  </div>

  <!-- ===== BAŞVURU YENİ MODAL ===== -->
  <div class="vz-overlay" id="basvuru-yeni-modal" onclick="if(event.target===this)basvuruYeniModalKapat()">
    <div class="vz-modal">
      <div class="vz-modal-head">
        <h3>📋 Yarışma Başvuru Kaydı</h3>
        <button class="ai-modal-close" onclick="basvuruYeniModalKapat()" aria-label="Kapat"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
      </div>
      <div class="form-group" style="margin-bottom:.8rem;">
        <label class="form-label">Yarışma Adı</label>
        <input type="text" class="form-control" id="basvuru-yarisma" placeholder="Örn: TEKNOFEST 2026">
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Kategori</label>
          <input type="text" class="form-control" id="basvuru-kategori" placeholder="Örn: İnsansız Hava Aracı">
        </div>
        <div class="form-group">
          <label class="form-label">Takım Adı</label>
          <input type="text" class="form-control" id="basvuru-takim" placeholder="Örn: KartalTakımı">
        </div>
      </div>
      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label">Rapor Tarihi</label>
        <input type="date" class="form-control" id="basvuru-rapor">
      </div>
      <button class="btn btn-primary" style="width:100%;justify-content:center;" onclick="basvuruKaydet()">Kaydet</button>
    </div>
  </div>

  <!-- ===== İLAN BAŞVURU MODAL ===== -->
  <div class="vz-overlay" id="ilan-basvuru-modal" onclick="if(event.target===this)ilanBasvuruKapat()">
    <div class="vz-modal">
      <div class="vz-modal-head">
        <h3>📮 İlana Başvur</h3>
        <button class="ai-modal-close" onclick="ilanBasvuruKapat()" aria-label="Kapat"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
      </div>
      <input type="hidden" id="ib-iland-id">
      <div class="dm-alici">İlan: <b id="ib-iland-ad"></b></div>
      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label">Neden sen? <span style="color:var(--text-dim);font-weight:400;">(opsiyonel)</span></label>
        <textarea class="form-control" id="ib-mesaj" rows="4" placeholder="Becerilerini ve deneyimini kısaca anlat..."></textarea>
      </div>
      <button class="btn btn-primary" style="width:100%;justify-content:center;" onclick="ilanBasvuruGonder()">Başvur</button>
    </div>
  </div>

  <!-- ===== VİZYON XP TOAST ===== -->
  <div id="vizyon-toast"></div>

  <!-- ===== VIZYON MODALLARI ===== -->
  <div id="vizyon-toast" aria-live="polite"></div>

  <!-- DM MESAJ MODAL -->
  <div class="vizyon-overlay" id="dm-modal" onclick="if(event.target===this)window.closeDmModal()">
    <div class="vizyon-card">
      <div class="vizyon-card-baslik">
        <h3>💬 Mesaj Gönder</h3>
        <button class="ai-modal-close" onclick="window.closeDmModal()" aria-label="Kapat"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
      </div>
      <p class="vizyon-alici">Kime: <b id="dm-alici-ad"></b></p>
      <input type="hidden" id="dm-alici">
      <div class="form-group" style="margin-bottom:1rem;">
        <textarea class="form-control" id="dm-icerik" rows="4" placeholder="Mesajını yaz... (Gmail üzerinden alıcıya iletilecektir)"></textarea>
      </div>
      <button class="btn btn-primary" style="width:100%;justify-content:center;" onclick="window.gonderDm()">Gönder</button>
    </div>
  </div>

  <!-- FORUM YENİ KONU MODAL -->
  <div class="vizyon-overlay" id="forum-yeni-modal" onclick="if(event.target===this)window.forumYeniModalKapat()">
    <div class="vizyon-card">
      <div class="vizyon-card-baslik">
        <h3>💬 Yeni Konu</h3>
        <button class="ai-modal-close" onclick="window.forumYeniModalKapat()" aria-label="Kapat"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
      </div>
      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label">Başlık</label>
        <input type="text" class="form-control" id="forum-baslik" placeholder="Konu başlığı...">
      </div>
      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label">Etiket</label>
        <select class="form-control" id="forum-etiket">
          <option value="genel">Genel</option>
          <option value="yarisma">Yarışma</option>
          <option value="takim">Takım</option>
          <option value="mentorluk">Mentorluk</option>
          <option value="duyuru">Duyuru</option>
        </select>
      </div>
      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label">İçerik</label>
        <textarea class="form-control" id="forum-icerik" rows="4" placeholder="Sorunu, deneyimini ya da duyurunu paylaş..."></textarea>
      </div>
      <button class="btn btn-primary" style="width:100%;justify-content:center;" onclick="window.forumKonuEkle()">Yayınla (+10 XP)</button>
    </div>
  </div>

  <!-- PROJE YENİ MODAL -->
  <div class="vizyon-overlay" id="proje-yeni-modal" onclick="if(event.target===this)window.projeYeniModalKapat()">
    <div class="vizyon-card">
      <div class="vizyon-card-baslik">
        <h3>🚀 Yeni Proje</h3>
        <button class="ai-modal-close" onclick="window.projeYeniModalKapat()" aria-label="Kapat"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
      </div>
      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label">Proje Adı</label>
        <input type="text" class="form-control" id="proje-ad" placeholder="Örn: Otonom Tarım Robotu">
      </div>
      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label">Açıklama</label>
        <textarea class="form-control" id="proje-aciklama" rows="3" placeholder="Projeni ve hedefini anlat..."></textarea>
      </div>
      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label">Etiketler <span style="color:var(--text-dim);font-weight:400;">(virgülle)</span></label>
        <input type="text" class="form-control" id="proje-etiketler" placeholder="robotik, python, tarım">
      </div>
      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label">Demo / Video Linki</label>
        <input type="text" class="form-control" id="proje-demo" placeholder="https://...">
      </div>
      <button class="btn btn-primary" style="width:100%;justify-content:center;" onclick="window.projeKaydet()">Kaydet (+20 XP)</button>
    </div>
  </div>

  <!-- MENTOR YENİ MODAL -->
  <div class="vizyon-overlay" id="mentor-yeni-modal" onclick="if(event.target===this)window.mentorYeniModalKapat()">
    <div class="vizyon-card">
      <div class="vizyon-card-baslik">
        <h3>🎓 Mentor Ol</h3>
        <button class="ai-modal-close" onclick="window.mentorYeniModalKapat()" aria-label="Kapat"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
      </div>
      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label">Ad Soyad</label>
        <input type="text" class="form-control" id="mentor-ad" placeholder="Adın Soyadın">
      </div>
      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label">Unvan</label>
        <input type="text" class="form-control" id="mentor-unvan" placeholder="Örn: Kıdemli Makine Öğrenmesi Mühendisi">
      </div>
      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label">Alanlar <span style="color:var(--text-dim);font-weight:400;">(virgülle)</span></label>
        <input type="text" class="form-control" id="mentor-alanlar" placeholder="yapay zeka, robotik, girişimcilik">
      </div>
      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label">Deneyim</label>
        <input type="text" class="form-control" id="mentor-deneyim" placeholder="5+ yıl, 3 yarışma birinciliği...">
      </div>
      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label">Müsaitlik</label>
        <input type="text" class="form-control" id="mentor-musait" placeholder="Hafta içi akşam, 2 saat">
      </div>
      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label">Tanıtım</label>
        <textarea class="form-control" id="mentor-tanitim" rows="3" placeholder="Kimlere nasıl yardım edebilirsin?"></textarea>
      </div>
      <button class="btn btn-primary" style="width:100%;justify-content:center;" onclick="window.mentorKaydet()">Kaydet (+25 XP)</button>
    </div>
  </div>

  <!-- MENTOR TALEP MODAL -->
  <div class="vizyon-overlay" id="mentor-talep-modal" onclick="if(event.target===this)window.mentorTalepKapat()">
    <div class="vizyon-card">
      <div class="vizyon-card-baslik">
        <h3>🎓 Mentorluk İste</h3>
        <button class="ai-modal-close" onclick="window.mentorTalepKapat()" aria-label="Kapat"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
      </div>
      <p class="vizyon-alici">Mentor: <b id="mentor-talep-ad"></b></p>
      <input type="hidden" id="mentor-talep-id">
      <div class="form-group" style="margin-bottom:1rem;">
        <textarea class="form-control" id="mentor-talep-mesaj" rows="4" placeholder="Projeni ve neden mentorluk istediğini anlat..."></textarea>
      </div>
      <button class="btn btn-primary" style="width:100%;justify-content:center;" onclick="window.mentorTalepGonder()">Talebi Gönder</button>
    </div>
  </div>

  <!-- YARISMA BASVURU TAKIP MODAL -->
  <div class="vizyon-overlay" id="basvuru-yeni-modal" onclick="if(event.target===this)window.basvuruYeniModalKapat()">
    <div class="vizyon-card">
      <div class="vizyon-card-baslik">
        <h3>📋 Yarışma Kaydı Ekle</h3>
        <button class="ai-modal-close" onclick="window.basvuruYeniModalKapat()" aria-label="Kapat"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
      </div>
      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label">Yarışma Adı</label>
        <input type="text" class="form-control" id="basvuru-yarisma" placeholder="Örn: TEKNOFEST İnsansız Su Altı Sistemleri">
      </div>
      <div class="form-row">
        <div class="form-group" style="margin-bottom:1rem;">
          <label class="form-label">Kategori</label>
          <input type="text" class="form-control" id="basvuru-kategori" placeholder="Takım Kaptanı">
        </div>
        <div class="form-group" style="margin-bottom:1rem;">
          <label class="form-label">Takım Adı</label>
          <input type="text" class="form-control" id="basvuru-takim" placeholder="Takımın">
        </div>
      </div>
      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label">Rapor Tarihi</label>
        <input type="date" class="form-control" id="basvuru-rapor">
      </div>
      <button class="btn btn-primary" style="width:100%;justify-content:center;" onclick="window.basvuruKaydet()">Kaydet (+40 XP)</button>
    </div>
  </div>

  <!-- ILAN BASVURU MODAL -->
  <div class="vizyon-overlay" id="ilan-basvuru-modal" onclick="if(event.target===this)window.ilanBasvuruKapat()">
    <div class="vizyon-card">
      <div class="vizyon-card-baslik">
        <h3>📮 İlana Başvur</h3>
        <button class="ai-modal-close" onclick="window.ilanBasvuruKapat()" aria-label="Kapat"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
      </div>
      <p class="vizyon-alici">İlan: <b id="ib-iland-ad"></b></p>
      <input type="hidden" id="ib-iland-id">
      <div class="form-group" style="margin-bottom:1rem;">
        <textarea class="form-control" id="ib-mesaj" rows="4" placeholder="Neden bu ilana başvuruyorsun? Deneyimini anlat..."></textarea>
      </div>
      <button class="btn btn-primary" style="width:100%;justify-content:center;" onclick="window.ilanBasvuruGonder()">Başvur (+15 XP)</button>
    </div>
  </div>
