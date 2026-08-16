  <!-- ===== AUTH OVERLAY ===== -->
  <div id="auth-overlay">

    <!-- LEFT PANEL: Branding -->
    <div class="auth-panel-left">
      <div class="auth-left-top">
        <div class="auth-left-logo">
          <img src="logo-beyaz.png" class="theme-logo" alt="Quantro" style="height:40px;width:auto;">
        </div>
        <div class="auth-left-headline">
          Yarışmada<br><span class="hl-blue">Kazanmaya</span><br>Hazır mısın?
        </div>
        <p class="auth-left-desc">Teknofest'ten ICPC'ye, TÜBİTAK'tan Kaggle'a — Türkiye'nin en yetenekli zihinleri burada buluşuyor.</p>
        <div class="auth-left-features">
          <div class="auth-feature-row">
            <div class="auth-feature-icon" style="background:rgba(59,130,246,0.12);">🏆</div>
            <div class="auth-feature-text">
              <div class="auth-feature-title">500+ Yarışma</div>
              <div class="auth-feature-sub">Teknofest, TÜBİTAK, ICPC ve daha fazlası</div>
            </div>
          </div>
          <div class="auth-feature-row">
            <div class="auth-feature-icon" style="background:rgba(6,182,212,0.12);">👥</div>
            <div class="auth-feature-text">
              <div class="auth-feature-title">Takım Kurma</div>
              <div class="auth-feature-sub">Alanında uzman ekip arkadaşları bul</div>
            </div>
          </div>
          <div class="auth-feature-row">
            <div class="auth-feature-icon" style="background:rgba(139,92,246,0.12);">🤖</div>
            <div class="auth-feature-text">
              <div class="auth-feature-title">AI Destekli</div>
              <div class="auth-feature-sub">Sana özel yarışma ve profil önerileri</div>
            </div>
          </div>
        </div>
      </div>
      <div class="auth-left-bottom">
        © 2026 Quantro · <a href="#">Gizlilik Politikası</a> · <a href="#">Şartlar</a>
      </div>
    </div>

    <!-- RIGHT PANEL: Form -->
    <div class="auth-panel-right">
      <div class="auth-card">
        <div class="auth-logo">
          <img src="logo-beyaz.png" class="theme-logo" alt="Quantro" style="height:40px;width:auto;">
        </div>
        <p class="auth-subtitle">Hesabınıza giriş yapın veya yeni hesap oluşturun 🏆</p>

        <div class="auth-tabs">
          <button class="auth-tab active" id="tab-login" onclick="switchAuthTab('login')">Giriş Yap</button>
          <button class="auth-tab" id="tab-register" onclick="switchAuthTab('register')">Kayıt Ol</button>
        </div>

        <div class="auth-error" id="auth-error"></div>

        <!-- LOGIN FORM -->
        <div id="auth-login-form" class="auth-form">
          <div>
            <label style="font-size:0.75rem;font-weight:700;color:var(--text-dim);display:block;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.5px;">Kullanıcı Adı veya E-posta</label>
            <input type="text" class="auth-input" id="login-username" placeholder="kullanici@email.com" autocomplete="username">
          </div>
          <div>
            <label style="font-size:0.75rem;font-weight:700;color:var(--text-dim);display:block;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.5px;">Şifre</label>
            <div class="pw-wrap">
              <input type="password" class="auth-input" id="login-password" placeholder="••••••••" autocomplete="current-password" onkeydown="if(event.key==='Enter') doLogin()">
              <button type="button" class="pw-toggle" onclick="togglePw('login-password',this)" tabindex="-1" title="Şifreyi göster/gizle">
                <svg id="login-password-eye" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
          </div>
          <button class="auth-btn" onclick="doLogin()">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
            Giriş Yap
          </button>
        </div>

        <!-- REGISTER FORM -->
        <div id="auth-register-form" class="auth-form" style="display:none;">
          <div>
            <label style="font-size:0.75rem;font-weight:700;color:var(--text-dim);display:block;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.5px;">Ad Soyad <span style="color:#ef4444">*</span></label>
            <input type="text" class="auth-input" id="reg-name" placeholder="Adınız Soyadınız" autocomplete="name">
          </div>
          <div>
            <label style="font-size:0.75rem;font-weight:700;color:var(--text-dim);display:block;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.5px;">Kullanıcı Adı <span style="color:#ef4444">*</span></label>
            <input type="text" class="auth-input" id="reg-username" placeholder="kullaniciadi" autocomplete="username">
          </div>
          <div>
            <label style="font-size:0.75rem;font-weight:700;color:var(--text-dim);display:block;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.5px;">E-posta <span style="color:#ef4444">*</span></label>
            <input type="email" class="auth-input" id="reg-email" placeholder="ornek@email.com" autocomplete="email">
          </div>
          <div>
            <label style="font-size:0.75rem;font-weight:700;color:var(--text-dim);display:block;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.5px;">Şifre <span style="color:#ef4444">*</span></label>
            <div class="pw-wrap">
              <input type="password" class="auth-input" id="reg-password" placeholder="En az 6 karakter" autocomplete="new-password">
              <button type="button" class="pw-toggle" onclick="togglePw('reg-password',this)" tabindex="-1" title="Şifreyi göster/gizle">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
          </div>
          <div>
            <label style="font-size:0.75rem;font-weight:700;color:var(--text-dim);display:block;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.5px;">Şifre Tekrar <span style="color:#ef4444">*</span></label>
            <div class="pw-wrap">
              <input type="password" class="auth-input" id="reg-password2" placeholder="Şifrenizi tekrar girin" autocomplete="new-password" onkeydown="if(event.key==='Enter') doRegister()">
              <button type="button" class="pw-toggle" onclick="togglePw('reg-password2',this)" tabindex="-1" title="Şifreyi göster/gizle">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
          </div>
          <button class="auth-btn" onclick="doRegister()">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
            Hesap Oluştur
          </button>
        </div>
      </div>
    </div>

  </div>

  <script>
  /* Sayfa gecislerinde giris ekrani flash'ini onle: oturum varsa overlay'i ilk boyamada gosterme */
  try {
    var k = Object.keys(localStorage).find(function(x) { return x.indexOf('sb-') === 0 && x.indexOf('-auth-token') > 0; });
    if (k && (localStorage.getItem(k) || '').indexOf('access_token') > -1) {
      var ao = document.getElementById('auth-overlay');
      if (ao) ao.style.display = 'none';
    }
  } catch (e) {}
  </script>

  <!-- PARTICLE CANVAS + CURSOR -->
  <canvas id="v-bg-canvas"></canvas>
  <div id="v-cursor"></div>
  <div id="v-cursor-ring"></div>

  <!-- BG -->
  <div class="bg-scene">
    <div class="bg-grid"></div>
    <div class="bg-orb bg-orb-1"></div>
    <div class="bg-orb bg-orb-2"></div>
    <div class="bg-orb bg-orb-3"></div>
  </div>
  <div class="noise-overlay"></div>

  <!-- ===== NAV ===== -->
  <nav id="main-nav">
    <div class="container">
      <div class="nav-content">
        <a href="index.php" class="logo" style="display:flex;align-items:center;gap:0;">
          <img class="theme-logo" src="logo-beyaz.png" alt="Quantro" style="height:36px;width:auto;">
        </a>
        <div class="nav-links">
          <a href="yarismalar.php">Yarışmalar</a>
          <a href="ilanlar.php">İlanlar</a>
          <a href="profiller.php">Profiller</a>
          <a href="gorevler.php">Ekipler</a>
          <a href="forum.php">Forum</a>
          <a href="liderlik.php">Liderlik</a>
          <a href="projeler.php">Projeler</a>
          <a href="mentorlar.php">Mentorlar</a>
          <a href="takvim.php">Takvim</a>
          <a href="iletisim.php">İletişim</a>
          <div class="nav-user-wrap" id="nav-user-wrap">
            <div class="nav-user-badge" id="nav-user-badge" onclick="toggleUserDropdown()" title="Profil Menüsü">
              <div class="nav-user-avatar" id="nav-user-avatar">?</div>
              <span id="nav-user-name">Kullanıcı</span>
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="opacity:0.6;transition:transform 0.2s" id="nav-chevron"><path d="m6 9 6 6 6-6"/></svg>
            </div>
            <div class="nav-user-dropdown" id="nav-user-dropdown">
              <div class="dropdown-header">
                <div class="dropdown-header-name" id="dd-name">Kullanıcı</div>
                <div class="dropdown-header-email" id="dd-email">—</div>
              </div>
              <button class="dropdown-item" onclick="closeUserDropdown(); openSettingsModal()">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                Ayarlar
              </button>
              <button class="dropdown-item" onclick="closeUserDropdown(); openProfilForm()">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Profili Düzelt
              </button>
              <button class="dropdown-item" onclick="closeUserDropdown(); openDmModal('','')">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                Mesajlar
                <span class="nav-icon-wrap"><span class="dm-bildirim-rozet" id="dm-bildirim-rozet"></span></span>
              </button>
              <div class="dropdown-divider"></div>
              <button class="dropdown-item danger" onclick="closeUserDropdown(); doLogout()">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Çıkış Yap
              </button>
            </div>
          </div>
        </div>
        <button class="hamburger" id="hamburger" onclick="toggleMenu()" aria-label="Menü">
          <span></span><span></span><span></span>
        </button>
      </div>
    </div>
  </nav>

  <!-- ===== MOBILE MENU ===== -->
  <div class="mobile-menu" id="mobile-menu">
    <a href="yarismalar.php" onclick="closeMenu()">Yarışmalar</a>
    <a href="ilanlar.php" onclick="closeMenu()">İlanlar</a>
    <a href="profiller.php" onclick="closeMenu()">Profiller</a>
    <a href="gorevler.php" onclick="closeMenu()">Ekipler</a>
    <a href="forum.php" onclick="closeMenu()">Forum</a>
    <a href="liderlik.php" onclick="closeMenu()">Liderlik</a>
    <a href="projeler.php" onclick="closeMenu()">Projeler</a>
    <a href="mentorlar.php" onclick="closeMenu()">Mentorlar</a>
    <a href="takvim.php" onclick="closeMenu()">Takvim</a>
    <a href="iletisim.php" onclick="closeMenu()">İletişim</a>
    <a href="sss.php" onclick="closeMenu()">SSS</a>

  </div>
