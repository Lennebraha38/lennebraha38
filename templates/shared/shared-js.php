  <!-- ===== SHARED SCRIPTS ===== -->
  <script>
// Quantro Supabase Integration + Shared Utilities
// Quantro Supabase Integration Module
// Bu modül localStorage/DOM tabanlı sahte sistemi Supabase ile değiştirir

const SUPABASE_URL = 'https://shvdsyclykgflyzgpdsi.supabase.co';
const SUPABASE_ANON_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InNodmRzeWNseWtnZmx5emdwZHNpIiwicm9sZSI6ImFub24iLCJpYXQiOjE3ODA2NzU2NjMsImV4cCI6MjA5NjI1MTY2M30.aO9yuXS8uH5YFwYumWIWsjBikQ0SHQJ0n3mGMl7GGXU';
// supabase UMD script'i 'var supabase' globali tanimlar — burada yeniden
// 'let supabase' TANIMLANAMAZ (SyntaxError: already been declared).
// 'var' yeniden tanimlamaya izin verir; initSupabase() window.supabase'i kullanir.
var supabase;

function escapeHtml(str) {
  return String(str == null ? '' : str)
    .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
}

const SEHIR_MAP = { online:'Uzaktan', adana:'Adana', adiyaman:'Adıyaman', afyonkarahisar:'Afyonkarahisar', agri:'Ağrı', aksaray:'Aksaray', amasya:'Amasya', ankara:'Ankara', antalya:'Antalya', ardahan:'Ardahan', artvin:'Artvin', aydin:'Aydın', balikesir:'Balıkesir', bartin:'Bartın', batman:'Batman', bayburt:'Bayburt', bilecik:'Bilecik', bingol:'Bingöl', bitlis:'Bitlis', bolu:'Bolu', burdur:'Burdur', bursa:'Bursa', canakkale:'Çanakkale', cankiri:'Çankırı', corum:'Çorum', denizli:'Denizli', diyarbakir:'Diyarbakır', duzce:'Düzce', edirne:'Edirne', elazig:'Elazığ', erzincan:'Erzincan', erzurum:'Erzurum', eskisehir:'Eskişehir', gaziantep:'Gaziantep', giresun:'Giresun', gumushane:'Gümüşhane', hakkari:'Hakkari', hatay:'Hatay', igdir:'Iğdır', isparta:'Isparta', istanbul:'İstanbul', izmir:'İzmir', kahramanmaras:'Kahramanmaraş', karabuk:'Karabük', karaman:'Karaman', kars:'Kars', kastamonu:'Kastamonu', kayseri:'Kayseri', kilis:'Kilis', kirikkale:'Kırıkkale', kirklareli:'Kırklareli', kirsehir:'Kırşehir', kocaeli:'Kocaeli', konya:'Konya', kutahya:'Kütahya', malatya:'Malatya', manisa:'Manisa', mardin:'Mardin', mersin:'Mersin', mugla:'Muğla', mus:'Muş', nevsehir:'Nevşehir', nigde:'Niğde', ordu:'Ordu', osmaniye:'Osmaniye', rize:'Rize', sakarya:'Sakarya', samsun:'Samsun', sanliurfa:'Şanlıurfa', siirt:'Siirt', sinop:'Sinop', sirnak:'Şırnak', sivas:'Sivas', tekirdag:'Tekirdağ', tokat:'Tokat', trabzon:'Trabzon', tunceli:'Tunceli', usak:'Uşak', van:'Van', yalova:'Yalova', yozgat:'Yozgat', zonguldak:'Zonguldak' };
const sehirLabel = (s) => SEHIR_MAP[s] || s || '—';

function initSupabase() {
  if (typeof window.supabase === 'undefined') { console.error('Supabase SDK yüklenemedi!'); return false; }
  supabase = window.supabase.createClient(SUPABASE_URL, SUPABASE_ANON_KEY);
  return true;
}

async function initAuth() {
  const { data: { session } } = await supabase.auth.getSession();
  if (session) enterSiteWithUser(session.user);
  supabase.auth.onAuthStateChange((event, session) => {
    if (event === 'SIGNED_IN' && session) enterSiteWithUser(session.user);
    else if (event === 'SIGNED_OUT') exitSite();
  });
}

function enterSiteWithUser(user) {
  const overlay = document.getElementById('auth-overlay');
  if (overlay) { overlay.classList.add('hiding'); setTimeout(() => { overlay.style.display = 'none'; }, 500); }
  const name = user.user_metadata?.full_name || user.email?.split('@')[0] || 'Kullanıcı';
  const initials = name.split(' ').map(p => p[0] || '').join('').toUpperCase().slice(0,2) || 'U';
  const firstName = name.split(' ')[0];
  const navAvatar = document.getElementById('nav-user-avatar');
  const navName = document.getElementById('nav-user-name');
  const ddName = document.getElementById('dd-name');
  const ddEmail = document.getElementById('dd-email');
  if (navAvatar) navAvatar.textContent = initials;
  if (navName) navName.textContent = firstName;
  if (ddName) ddName.textContent = name;
  if (ddEmail) ddEmail.textContent = user.email || '—';
  if (typeof showToast === 'function') showToast('👋 Hoş geldin, ' + firstName + '!');
}

function exitSite() {
  const overlay = document.getElementById('auth-overlay');
  if (overlay) { overlay.style.display = 'flex'; overlay.classList.remove('hiding'); }
  ['login-username','login-password'].forEach(id => { const el = document.getElementById(id); if (el) el.value = ''; });
  if (typeof showToast === 'function') showToast('👋 Çıkış yapıldı.');
}

async function supabaseLogin(email, password) {
  const { error } = await supabase.auth.signInWithPassword({ email, password });
  if (error) { const e = document.getElementById('auth-error'); if (e) { e.textContent = error.message; e.classList.add('show'); setTimeout(() => e.classList.remove('show'), 3500); } return false; }
  return true;
}

async function supabaseRegister(name, email, password) {
  const { error } = await supabase.auth.signUp({ email, password, options: { data: { full_name: name } } });
  if (error) { const e = document.getElementById('auth-error'); if (e) { e.textContent = error.message; e.classList.add('show'); setTimeout(() => e.classList.remove('show'), 3500); } return false; }
  if (typeof showToast === 'function') showToast('✅ Kayıt tamamlandı!');
  return true;
}

async function supabaseGoogleLogin() {
  await supabase.auth.signInWithOAuth({ provider: 'google', options: { redirectTo: window.location.origin + window.location.pathname } });
}

async function supabaseLogout() { await supabase.auth.signOut(); }

async function loadIlanlar() {
  const { data, error } = await supabase.from('ilanlar').select('*').order('id', { ascending: false });
  if (error) { console.error('İlanlar yüklenemedi:', error.message); return; }
  const grid = document.getElementById('ilanlar-grid'); if (!grid) return;
  grid.innerHTML = '';
  const emptyMsg = document.getElementById('ilanlar-empty-msg');
  if (!data.length) { if (emptyMsg) emptyMsg.style.display = ''; return; }
  if (emptyMsg) emptyMsg.style.display = 'none';
  const session = (await supabase.auth.getSession()).data.session;
  const currentUserEmail = session?.user?.email;
  data.forEach(ilan => { grid.appendChild(createIlanCardElement(ilan, currentUserEmail)); });
  if (typeof renderIlanlarWithLimit === 'function') renderIlanlarWithLimit();
}

function createIlanCardElement(ilan, currentUserEmail) {
  const isOwner = currentUserEmail && ilan.kullanici_email === currentUserEmail;
  const badgeClass = { 'Açık': 'badge-acik', 'Yeni': 'badge-yeni', 'Son Gün': 'badge-yakin' }[ilan.durum] || 'badge-yakin';
  const tipEmoji = ilan.emoji || { 'takim': '🤝', 'proje': '🚀', 'mentor': '🎓' }[ilan.ilan_tipi] || '📌';
  const card = document.createElement('div');
  card.className = 'ilan-card';
  const sehir = sehirLabel(ilan.sehir);
  card.dataset.baslik = ilan.baslik || ''; card.dataset.aciklama = ilan.aciklama || '';
  card.dataset.sehir = sehir; card.dataset.kisi = ilan.kisi || '';
  card.dataset.tip = ilan.ilan_tipi || ''; card.dataset.tipEmoji = tipEmoji;
  card.dataset.etiketler = ilan.etiketler || ''; card.dataset.badge = ilan.durum || 'Açık';
  card.dataset.badgeClass = badgeClass; card.dataset.owner = isOwner ? 'true' : 'false';
  card.dataset.tags = (ilan.kategori||'') + ' ' + (ilan.sehir||'') + ' ' + (ilan.etiketler||'');
  card.dataset.id = ilan.id;
  card.setAttribute('onmousemove', 'tiltCard(event, this)');
  card.setAttribute('onmouseleave', 'resetTilt(this)');
  card.setAttribute('onclick', 'openIlanDetail(this)');
  const tags = (ilan.etiketler || '').split(',').filter(Boolean).map(t => '<span class="ilan-tag">'+escapeHtml(t.trim())+'</span>').join('');
  card.innerHTML = '<div class="ilan-badge '+badgeClass+'">'+(ilan.durum||'Açık')+'</div>'+
    '<div class="ilan-tip-emoji">'+tipEmoji+'</div>'+
    '<h3 class="ilan-card-title">'+escapeHtml(ilan.baslik||'Başlıksız')+'</h3>'+
    '<p class="ilan-card-desc">'+escapeHtml((ilan.aciklama||'').substring(0,150))+((ilan.aciklama||'').length>150?'...':'')+'</p>'+
    '<div class="ilan-card-tags">'+tags+'</div>'+
    '<div class="ilan-card-meta"><span>📍 '+escapeHtml(sehir)+'</span><span>👥 '+escapeHtml(ilan.kisi||'1 Kişi')+'</span></div>'+
    (isOwner ? '<button class="btn btn-ghost btn-sm" style="color:#f87171;border-color:rgba(239,68,68,0.2);margin-top:0.3rem" onclick="event.stopPropagation();deleteIlanCard(this)" title="İlanı sil"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="m19 6-.867 14.142A2 2 0 0 1 16.138 22H7.862a2 2 0 0 1-1.995-1.858L5 6m5 0V4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2"/></svg>Sil</button>'
      : '<button class="btn btn-ghost btn-sm" style="margin-top:0.3rem" data-ilan-adi="'+escapeHtml(ilan.baslik||'')+'" onclick="event.stopPropagation();handleBasvur(this, this.dataset.ilanAdi)" title="Bu ilana başvur">Başvur →</button>');
  return card;
}

async function supabaseCreateIlan(fd) {
  const session = (await supabase.auth.getSession()).data.session;
  const { data, error } = await supabase.from('ilanlar').insert({
    baslik: fd.baslik, aciklama: fd.aciklama, kategori: fd.kategori, sehir: fd.sehir,
    etiketler: fd.etiketler, kisi: fd.kisi, ilan_tipi: fd.tip, durum: fd.durum || 'Açık',
    emoji: fd.tipEmoji, kullanici_email: session?.user?.email || '', iletisim_email: fd.iletisim
  }).select().single();
  if (error) { console.error(error.message); if (typeof showToast==='function') showToast('⚠️ İlan oluşturulamadı!'); return null; }
  return data;
}

async function supabaseDeleteIlan(id) {
  const { error } = await supabase.from('ilanlar').delete().eq('id', id);
  return !error;
}

function overrideIlanFunctions() {
  window.submitIlanForm = async function() {
    const baslik = document.getElementById('if-baslik')?.value?.trim();
    const kategori = document.getElementById('if-kategori')?.value;
    const sehir = document.getElementById('if-sehir')?.value;
    const aciklama = document.getElementById('if-aciklama')?.value?.trim();
    const etiketler = document.getElementById('if-etiketler')?.value?.trim();
    const kisi = document.getElementById('if-kisi')?.value?.trim() || '1 Kişi';
    const iletisim = document.getElementById('if-iletisim')?.value?.trim() || '';
    if (!baslik || !kategori || !aciklama) { if (typeof showToast==='function') showToast('⚠️ Zorunlu alanları doldurun!'); return; }
    const session = (await supabase.auth.getSession()).data.session;
    if (!session) { if (typeof showToast==='function') showToast('⚠️ İlan yayınlamak için önce giriş yapmalısın!'); return; }
    const tipKey = window._ilanTip || 'takim';
    const tipLabel = { 'takim': 'Takım Üyesi', 'mentor': 'Mentör', 'ortak': 'Proje Ortağı' }[tipKey] || 'Takım Üyesi';
    const tipEmoji = { 'takim': '🤝', 'mentor': '🎓', 'ortak': '🚀' }[tipKey] || '📌';
    const durumLabel = { 'yeni': 'Yeni', 'acik': 'Açık', 'yakin': 'Son Gün' }[kategori] || 'Açık';
    const r = await supabaseCreateIlan({ baslik, aciklama, kategori, sehir, etiketler, kisi, tip: tipLabel, tipEmoji, iletisim, durum: durumLabel });
    if (r) {
      await loadIlanlar();
      ['if-baslik','if-aciklama','if-etiketler','if-kisi','if-iletisim'].forEach(id => { const el = document.getElementById(id); if (el) el.value = ''; });
      if (typeof closeIlanForm==='function') closeIlanForm();
      if (typeof showToast==='function') showToast('✅ İlan yayınlandı!');
    }
  };
  window.deleteIlanCard = async function(btn) {
    const card = btn.closest('.ilan-card');
    const id = parseInt(card?.dataset?.id);
    if (!id) return;
    const baslik = card.querySelector('.ilan-card-title')?.textContent?.trim() || 'bu ilan';
    if (!confirm('"'+baslik+'" ilanını silmek istediğine emin misin?')) return;
    if (await supabaseDeleteIlan(id)) {
      card.style.opacity = '0'; card.style.transform = 'scale(0.95)';
      setTimeout(() => { card.remove(); if (typeof showToast==='function') showToast('🗑️ İlan silindi.'); }, 300);
    }
  };
}

async function loadProfiller() {
  const { data, error } = await supabase.from('profiller').select('*').order('id', { ascending: false });
  if (error) { console.error(error.message); return; }
  const grid = document.getElementById('profiller-grid'); if (!grid) return;
  grid.innerHTML = '';
  const emptyEl = document.getElementById('profiller-empty-msg-initial');
  if (!data.length) { if (emptyEl) emptyEl.style.display = ''; return; }
  if (emptyEl) emptyEl.style.display = 'none';
  data.forEach(p => { grid.appendChild(createProfilCardElement(p)); });
}

function createProfilCardElement(p) {
  const fullName = p.isim || '';
  const initials = fullName.split(' ').map(w=>w[0]).join('').toUpperCase().slice(0,2);
  const color = p.avatar_url ? 'transparent' : 'linear-gradient(135deg,#3b82f6,#06b6d4)';
  const skillTags = (p.yetenekler||'').split(',').filter(Boolean).map(s => '<span class="profil-skill">'+s.trim()+'</span>').join('');
  const card = document.createElement('div');
  card.className = 'profil-card';
  card.dataset.name = fullName; card.dataset.alan = p.alan||''; card.dataset.sehir = p.sehir||'';
  card.dataset.iletisim = p.iletisim||''; card.dataset.saat = p.saat||''; card.dataset.uni = p.universite||'';
  card.dataset.avatar = p.avatar_url||''; card.dataset.color = color; card.dataset.initials = initials; card.dataset.id = p.id;
  card.innerHTML = (p.avatar_url
    ? '<div class="profil-avatar"><img src="'+p.avatar_url+'" alt="'+fullName+'"></div>'
    : '<div class="profil-avatar" style="background:'+color+';">'+initials+'</div>')+
    '<div class="profil-info"><div class="profil-info-name">'+fullName+'</div><div class="profil-info-role">'+(p.universite||'')+'</div></div>'+
    '<div class="profil-available"><span></span>'+(p.musaitlik||'Müsait')+'</div>'+
    '<div class="profil-bio">'+(p.bio||'')+'</div><div class="profil-skills">'+skillTags+'</div>'+
    '<div class="profil-meta"><span>📍 '+(p.sehir||'—')+'</span><span>⏰ '+(p.saat||'—')+'</span></div>'+
    '<div class="profil-actions"><button class="btn btn-primary btn-sm" onclick="openProfilDetail(this.closest(\'.profil-card\'))" style="flex:1.4">Profili Gör</button>'+
    '<button class="btn btn-secondary btn-sm" onclick="editProfilCard(this)">Düzenle</button>'+
    '<button class="btn btn-ghost btn-sm" onclick="deleteProfilCard(this)" style="color:#f87171;border-color:rgba(239,68,68,0.2)">Sil</button></div>';
  return card;
}

let _currentAvatarFile = null;
window.handleAvatarUpload = function(input) {
  if (input.files && input.files[0]) {
    window._pfAvatarFile = input.files[0];
    const reader = new FileReader();
    reader.onload = function(e) {
      const img = document.getElementById('avatar-preview');
      const ph = document.getElementById('avatar-placeholder');
      if (img) { img.src = e.target.result; img.style.display = ''; }
      if (ph) ph.style.opacity = '0';
    };
    reader.readAsDataURL(input.files[0]);
  }
};

window.resetAvatar = function() {
  _currentAvatarFile = null;
  const img = document.getElementById('avatar-preview');
  const ph = document.getElementById('avatar-placeholder');
  if (img) { img.src = ''; img.style.display = 'none'; }
  if (ph) ph.style.opacity = '1';
  const fi = document.getElementById('pf-photo-input'); if (fi) fi.value = '';
};

async function supabaseCreateProfil(fd, avatarFile) {
  const session = (await supabase.auth.getSession()).data.session;
  let avatarUrl = '';
  if (avatarFile) {
    const ext = avatarFile.name.split('.').pop();
    const fn = (session?.user?.id||'anon')+'_'+Date.now()+'.'+ext;
    const { error: upErr } = await supabase.storage.from('avatarlar').upload(fn, avatarFile);
    if (!upErr) { const { data: urlData } = supabase.storage.from('avatarlar').getPublicUrl(fn); avatarUrl = urlData?.publicUrl || ''; }
  }
  const { data, error } = await supabase.from('profiller').insert({
    user_id: session?.user?.id, isim: fd.isim, eposta: session?.user?.email, bio: fd.bio,
    yetenekler: fd.yetenekler, sehir: fd.sehir, musaitlik: 'Müsait', avatar_url: avatarUrl,
    iletisim: fd.iletisim, universite: fd.universite, alan: fd.alan, saat: fd.saat
  }).select().single();
  if (error) { console.error(error.message); if (typeof showToast==='function') showToast('⚠️ Profil oluşturulamadı!'); return null; }
  return data;
}

async function supabaseDeleteProfil(id) { const { error } = await supabase.from('profiller').delete().eq('id',id); return !error; }

async function supabaseUpdateProfil(id, fd, avatarFile) {
  const session = (await supabase.auth.getSession()).data.session;
  let avatarUrl = fd.avatar_url || '';
  if (avatarFile) {
    const ext = avatarFile.name.split('.').pop();
    const fn = (session?.user?.id||'anon')+'_'+Date.now()+'.'+ext;
    const { error: upErr } = await supabase.storage.from('avatarlar').upload(fn, avatarFile);
    if (!upErr) { const { data: urlData } = supabase.storage.from('avatarlar').getPublicUrl(fn); avatarUrl = urlData?.publicUrl || ''; }
  }
  const { error } = await supabase.from('profiller').update({
    isim: fd.isim, bio: fd.bio, yetenekler: fd.yetenekler, sehir: fd.sehir,
    avatar_url: avatarUrl, iletisim: fd.iletisim, universite: fd.universite, alan: fd.alan, saat: fd.saat
  }).eq('id', id);
  if (error) { console.error(error.message); if (typeof showToast==='function') showToast('⚠️ Profil güncellenemedi!'); return null; }
  return { id };
}

function overrideProfilFunctions() {
  window.submitProfilForm = async function() {
    const ad = document.getElementById('pf-ad')?.value?.trim();
    const soyad = document.getElementById('pf-soyad')?.value?.trim();
    const uni = document.getElementById('pf-uni')?.value?.trim();
    const alan = document.getElementById('pf-alan')?.value;
    const sehir = document.getElementById('pf-sehir')?.value;
    const skills = document.getElementById('pf-skills')?.value?.trim();
    const bio = document.getElementById('pf-bio')?.value?.trim();
    const iletisim = document.getElementById('pf-iletisim')?.value?.trim();
    const saat = document.getElementById('pf-saat')?.value;
    const isim = ad+' '+soyad;
    if (!ad || !soyad || !bio || !skills || !iletisim) { if (typeof showToast==='function') showToast('⚠️ Zorunlu alanları doldurun!'); return; }
    const session = (await supabase.auth.getSession()).data.session;
    if (!session) { if (typeof showToast==='function') showToast('⚠️ Profil eklemek için önce giriş yapmalısın!'); return; }
    const editId = window._editProfilId || null;
    const avatarFile = window._pfAvatarFile || null;
    const r = editId
      ? await supabaseUpdateProfil(editId, { isim, bio, yetenekler: skills, sehir, iletisim, universite: uni, alan, saat: saat||'Esnek', avatar_url: (document.getElementById('avatar-preview')?.src || '') }, avatarFile)
      : await supabaseCreateProfil({ isim, bio, yetenekler: skills, sehir, iletisim, universite: uni, alan, saat: saat||'Esnek' }, avatarFile);
    if (r) {
      window._pfAvatarFile = null;
      window._editProfilId = null;
      await loadProfiller();
      if (typeof closeProfilForm==='function') closeProfilForm();
      if (typeof showToast==='function') showToast('✅ '+isim+' profili ' + (editId ? 'güncellendi!' : 'eklendi!'));
    }
  };
  window.deleteProfilCard = async function(btn) {
    const card = btn.closest('.profil-card');
    const id = parseInt(card?.dataset?.id);
    const name = card?.querySelector('.profil-info-name')?.textContent?.trim() || 'bu profil';
    if (!confirm('"'+name+'" profilini silmek istediğine emin misin?')) return;
    if (id) await supabaseDeleteProfil(id);
    card.style.opacity = '0'; card.style.transform = 'scale(0.95)';
    setTimeout(() => { card.remove(); if (typeof showToast==='function') showToast('🗑️ Profil silindi.'); }, 300);
  };
}

function overrideContactForm() {
  window.sendGmail = async function() {
    const ad = document.getElementById('field-ad')?.value?.trim();
    const soyad = document.getElementById('field-soyad')?.value?.trim();
    const email = document.getElementById('field-email')?.value?.trim();
    const konu = document.getElementById('field-konu')?.value;
    const mesaj = document.getElementById('field-mesaj')?.value?.trim();
    const uni = document.getElementById('field-universite')?.value?.trim()||'';
    const bolum = document.getElementById('field-bolum')?.value?.trim()||'';
    const proje = document.getElementById('field-proje')?.value?.trim()||'';
    if (!ad || !email || !mesaj) { if (typeof showToast==='function') showToast('⚠️ Zorunlu alanları doldurun!'); return; }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { if (typeof showToast==='function') showToast('⚠️ Geçerli e-posta girin!'); return; }
    const { error } = await supabase.from('mesajlar').insert({
      gonderen_ad: ad+' '+soyad, gonderen_email: email, konu, mesaj, universite: uni, bolum, proje
    });
    if (!error) {
      if (typeof showToast==='function') showToast('✅ Mesajınız iletildi!');
      ['field-ad','field-soyad','field-email','field-mesaj','field-universite','field-bolum','field-proje'].forEach(id => { const el = document.getElementById(id); if (el) el.value = ''; });
    } else { if (typeof showToast==='function') showToast('⚠️ Mesaj gönderilemedi.'); }
  };
}

function setupRealtime() {
  supabase.channel('ilanlar-rt').on('postgres_changes', { event: '*', schema: 'public', table: 'ilanlar' }, () => { loadIlanlar(); }).subscribe();
  supabase.channel('profiller-rt').on('postgres_changes', { event: '*', schema: 'public', table: 'profiller' }, () => { loadProfiller(); }).subscribe();
}

async function loadEtkinlikler() {
  const { data } = await supabase.from('etkinlikler').select('*');
  if (data && data.length) {
    const events = {};
    data.forEach(e => { const d = new Date(e.tarih); const k = d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate(); if (!events[k]) events[k] = []; events[k].push({ color: e.renk||'#3b82f6', title: e.baslik, detail: e.detay||'' }); });
    window._dynamicEvents = { ...(typeof EVENTS !== 'undefined' ? EVENTS : {}), ...events };
    if (typeof renderCalendar === 'function') setTimeout(() => renderCalendar(), 100);
  }
}

async function loadKategoriler() {
  const { data } = await supabase.from('kategoriler').select('*');
  if (data && data.length) {
    const kd = {};
    data.forEach(kat => {
      if (!kd[kat.anahtar]) kd[kat.anahtar] = { emoji: kat.emoji, title: kat.baslik, subtitle: kat.alt_baslik||'', url: kat.url||'#', cats: [] };
      kd[kat.anahtar].cats.push({ e: kat.alt_emoji||'📌', n: kat.isim, d: kat.aciklama||'', t: kat.durum||'Açık', c: kat.renk_sinifi||'' });
    });
    window._dynamicKD = kd;
  }
}

function overrideAuthFunctions() {
  window.doGoogleLogin = function() { supabaseGoogleLogin(); };
  window.doLogout = async function() { if (!confirm('Çıkış yapmak istiyor musun?')) return; await supabaseLogout(); };
  window.doLogin = async function() {
    const email = document.getElementById('login-username')?.value?.trim();
    const pass = document.getElementById('login-password')?.value;
    if (!email || !pass) { const e = document.getElementById('auth-error'); if (e) { e.textContent = 'Lütfen tüm alanları doldurun.'; e.classList.add('show'); } return; }
    await supabaseLogin(email, pass);
  };
  window.doRegister = async function() {
    const name = document.getElementById('reg-name')?.value?.trim();
    const email = document.getElementById('reg-email')?.value?.trim();
    const pass = document.getElementById('reg-password')?.value;
    const pass2 = document.getElementById('reg-password2')?.value;
    if (!name || !email || !pass) { const e = document.getElementById('auth-error'); if (e) { e.textContent = 'Tüm alanları doldurun.'; e.classList.add('show'); } return; }
    if (pass.length < 6) { const e = document.getElementById('auth-error'); if (e) { e.textContent = 'Şifre en az 6 karakter olmalı.'; e.classList.add('show'); } return; }
    if (pass !== pass2) { const e = document.getElementById('auth-error'); if (e) { e.textContent = 'Şifreler eşleşmiyor.'; e.classList.add('show'); } return; }
    await supabaseRegister(name, email, pass);
  };
  // Mock fonksiyonları devre dışı bırak
  ['closeGoogleMock','gacSelectAccount','googleShowEmailStep','googleNextStep','googleBackStep','toggleGacPw','confirmGoogleLogin'].forEach(fn => { window[fn] = function(){}; });
}

// ===== HATA IZLEME (gizli, ?debug=1 ile panel) =====
window.__QT_HATALAR = [];
try { window.__QT_HATALAR = JSON.parse(localStorage.getItem('quantro-hatalar') || '[]'); } catch (e) {}
function __qtHataKaydet(kayit) {
  window.__QT_HATALAR.push(kayit);
  if (window.__QT_HATALAR.length > 40) window.__QT_HATALAR.shift();
  try { localStorage.setItem('quantro-hatalar', JSON.stringify(window.__QT_HATALAR)); } catch (e) {}
}
window.addEventListener('error', function (e) {
  __qtHataKaydet({ t: new Date().toISOString(), tip: 'error', msg: String(e.message || '').slice(0, 220), yer: String(e.filename || '').split('/').pop() + ':' + (e.lineno || '') });
});
window.addEventListener('unhandledrejection', function (e) {
  __qtHataKaydet({ t: new Date().toISOString(), tip: 'promise', msg: String(e.reason).slice(0, 220), yer: '' });
});
window.qtDebugPanel = function () {
  let panel = document.getElementById('qt-debug-panel');
  if (!panel) {
    panel = document.createElement('div');
    panel.id = 'qt-debug-panel';
    panel.style.cssText = 'position:fixed;bottom:1rem;right:1rem;z-index:99999;width:340px;max-height:60vh;overflow:auto;background:#0b0f17;border:1px solid #2a3a55;border-radius:14px;padding:1rem;font-family:monospace !important;font-size:11px;color:#c7d3e8;box-shadow:0 12px 40px rgba(0,0,0,.5);';
    document.body.appendChild(panel);
  }
  const list = window.__QT_HATALAR.length ? window.__QT_HATALAR.slice().reverse().map(h =>
    `<div style="border-bottom:1px solid #22304a;padding:.4rem 0;"><b style="color:#f87171">[${h.tip}]</b> ${h.msg.replace(/[<>&]/g, c => ({ '<': '&lt;', '>': '&gt;', '&': '&amp;' }[c]))}<br><span style="color:#64748b">${h.t} ${h.yer}</span></div>`
  ).join('') : '<div style="color:#34d399">Sıfır hata kaydı 🎉</div>';
  panel.innerHTML = `<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.5rem;"><b style="color:#93c5fd">🧪 Quantro Hata Kaydı</b><span><button id="qt-debug-temiz" style="background:#1e293b;border:1px solid #334155;color:#cbd5e1;border-radius:8px;padding:.2rem .6rem;cursor:pointer;font-size:10px;margin-right:.3rem;">Temizle</button><button id="qt-debug-kapat" style="background:none;border:none;color:#94a3b8;cursor:pointer;font-size:14px;">✕</button></span></div>${list}`;
  document.getElementById('qt-debug-kapat').onclick = () => panel.remove();
  document.getElementById('qt-debug-temiz').onclick = () => { window.__QT_HATALAR = []; localStorage.removeItem('quantro-hatalar'); qtDebugPanel(); };
};
if (new URLSearchParams(location.search).has('debug')) {
  window.addEventListener('load', () => setTimeout(window.qtDebugPanel, 800));
}

// ===== TEMA YONETIMI =====
let currentTheme = localStorage.getItem('quantro-theme') || 'dark';
function applyTheme(theme) {
  // Gecis animasyonlarini kapat (renkler ~1 sn "erimesin")
  document.documentElement.classList.add('theme-switching');
  document.documentElement.setAttribute('data-theme', theme);
  const logos = document.querySelectorAll('.theme-logo');
  logos.forEach(img => { img.src = theme === 'light' ? 'logo.png' : 'logo-beyaz.png'; });
  localStorage.setItem('quantro-theme', theme);
  currentTheme = theme;
  requestAnimationFrame(() => requestAnimationFrame(() => {
    document.documentElement.classList.remove('theme-switching');
  }));
}
function toggleTheme() {
  const next = currentTheme === 'dark' ? 'light' : 'dark';
  applyTheme(next);
}
// Ilk yuklemede temayi uygula
applyTheme(currentTheme);

async function initApp() {
  if (!initSupabase()) return;
  await initAuth();
  overrideAuthFunctions();
  setupRealtime();
  // Sayfaya ozel init fonksiyonu varsa cagir
  if (typeof initPage === 'function') await initPage();
  console.log('✅ Quantro hazir!');
}

if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', initApp); }
else { initApp(); }
  </script>

  <script>
// Quantro UI Utilities
    /* ---- SSS TOGGLE ---- */
    function toggleSSS(btn) {
      const item = btn.closest('.sss-item');
      const isOpen = item.classList.contains('open');
      document.querySelectorAll('.sss-item.open').forEach(el => el.classList.remove('open'));
      if (!isOpen) item.classList.add('open');
    }

    /* ---- NAV SCROLL ---- */
    const nav = document.getElementById('main-nav');
    window.addEventListener('scroll', () => {
      nav.classList.toggle('scrolled', window.scrollY > 40);
    });

    /* ---- MOBILE MENU ---- */
    function toggleMenu() {
      const menu = document.getElementById('mobile-menu');
      const burger = document.getElementById('hamburger');
      menu.classList.toggle('open');
      burger.classList.toggle('open');
      document.body.style.overflow = menu.classList.contains('open') ? 'hidden' : '';
    }

    function closeMenu() {
      const menu = document.getElementById('mobile-menu');
      const burger = document.getElementById('hamburger');
      menu.classList.remove('open');
      burger.classList.remove('open');
      document.body.style.overflow = '';
    }

    /* ---- SMOOTH SCROLL ---- */
    function scrollToSection(id) {
      const el = document.getElementById(id);
      if (el) {
        const offset = 80;
        const top = el.getBoundingClientRect().top + window.scrollY - offset;
        window.scrollTo({ top, behavior: 'smooth' });
      }
    }

    function scrollToContact() {
      window.location.href = 'iletisim.php';
    }

    /* ---- RIPPLE ---- */
    document.querySelectorAll('.btn').forEach(btn => {
      btn.addEventListener('click', function(e) {
        const r = document.createElement('span');
        r.className = 'ripple-wave';
        const rect = this.getBoundingClientRect();
        r.style.left = (e.clientX - rect.left - 5) + 'px';
        r.style.top  = (e.clientY - rect.top  - 5) + 'px';
        this.appendChild(r);
        setTimeout(() => r.remove(), 700);
      });
    });

    /* ---- TOAST ---- */
    let toastTimer;
    function showToast(msg, icon = '') {
      const t = document.getElementById('toast');
      t.textContent = msg;
      t.classList.add('show');
      clearTimeout(toastTimer);
      toastTimer = setTimeout(() => t.classList.remove('show'), 3000);
    }

    /* ---- CARD TILT ---- */
    function tiltCard(e, card) {
      const r = card.getBoundingClientRect();
      const x = e.clientX - r.left;
      const y = e.clientY - r.top;
      const cx = r.width / 2;
      const cy = r.height / 2;
      const rx = ((y - cy) / cy) * 8;
      const ry = ((x - cx) / cx) * -8;
      card.style.transform = `perspective(1000px) rotateX(${rx}deg) rotateY(${ry}deg) translateZ(8px)`;
      card.style.setProperty('--mx', `${(x / r.width) * 100}%`);
      card.style.setProperty('--my', `${(y / r.height) * 100}%`);
    }

    function resetTilt(card) {
      card.style.transform = '';
    }

    /* ---- İLAN FILTER ---- */
    let activeIlanFilters = new Set();
    let showAllIlanlar    = false;
    const ILAN_LIMIT      = 6;

    function filterIlanlar(tag, btn) {
      if (tag === 'all') {
        // Tümü'ne basılınca tüm seçimleri temizle
        activeIlanFilters.clear();
      } else {
        // Toggle: seçiliyse kaldır, değilse ekle
        if (activeIlanFilters.has(tag)) {
          activeIlanFilters.delete(tag);
        } else {
          activeIlanFilters.add(tag);
        }
      }
      showAllIlanlar = false;

      // Buton görünümlerini güncelle
      document.querySelectorAll('#ilanlar .filter-btns .btn').forEach(b => {
        const t = b.dataset.tag;
        if (t === 'all') {
          const isAll = activeIlanFilters.size === 0;
          b.classList.toggle('btn-primary', isAll);
          b.classList.toggle('btn-ghost', !isAll);
        } else {
          const active = activeIlanFilters.has(t);
          b.classList.toggle('btn-primary', active);
          b.classList.toggle('btn-ghost', !active);
        }
      });

      renderIlanlarWithLimit();
    }

    function renderIlanlarWithLimit() {
      const cards = Array.from(document.querySelectorAll('.ilan-card'));
      const matched = cards.filter(card => {
        if (activeIlanFilters.size === 0) return true;
        const tags = card.dataset.tags || '';
        return [...activeIlanFilters].every(f => tags.includes(f));
      });

      cards.forEach(card => card.style.display = 'none');

      // Boş durum: filtreler aktif ama eşleşen yok
      const emptyMsg = document.getElementById('ilanlar-empty-msg');
      if (emptyMsg) {
        if (matched.length === 0 && activeIlanFilters.size > 0) {
          emptyMsg.style.display = 'block';
          emptyMsg.innerHTML = '<div class="empty-icon">🔍</div><h4>Eşleşen ilan yok</h4><p>Seçili filtrelerle eşleşen ilan bulunamadı.</p><button class="btn btn-primary btn-sm" style="margin-top:0.7rem;" onclick="resetIlanFilter()">Filtreleri Temizle</button>';
        } else if (matched.length > 0) {
          emptyMsg.style.display = 'none';
        }
      }

      const visible = showAllIlanlar ? matched : matched.slice(0, ILAN_LIMIT);
      visible.forEach(card => {
        card.style.display   = 'flex';
        card.style.opacity   = '0';
        card.style.transform = 'translateY(20px)';
        requestAnimationFrame(() => {
          card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
          card.style.opacity    = '1';
          card.style.transform  = '';
        });
      });

      // "Tüm İlanları Gör" butonunu güncelle
      const showMoreBtn = document.getElementById('show-all-ilanlar-btn');
      if (showMoreBtn) {
        if (!showAllIlanlar && matched.length > ILAN_LIMIT) {
          showMoreBtn.style.display = 'inline-flex';
          showMoreBtn.innerHTML = `Tüm İlanları Gör (${matched.length})
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>`;
        } else {
          showMoreBtn.style.display = matched.length > ILAN_LIMIT ? 'inline-flex' : 'none';
          if (matched.length > ILAN_LIMIT) {
            showMoreBtn.innerHTML = `Daha Az Göster
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 19-7-7 7-7"/></svg>`;
          }
        }
      }
    }

    function toggleShowAllIlanlar() {
      showAllIlanlar = !showAllIlanlar;
      renderIlanlarWithLimit();
    }

    function resetIlanFilter() {
      activeIlanFilters.clear();
      showAllIlanlar = false;
      document.querySelectorAll('#ilanlar .filter-btns .btn').forEach(b => {
        const isAll = b.dataset.tag === 'all';
        b.classList.toggle('btn-primary', isAll);
        b.classList.toggle('btn-ghost', !isAll);
      });
      renderIlanlarWithLimit();
    }

    async function deleteIlanCard(btn) {
      const card = btn.closest('.ilan-card');
      const baslik = card.dataset.baslik || card.querySelector('h4')?.textContent.trim() || 'bu ilan';
      if (!confirm(`"${baslik}" ilanını silmek istediğine emin misin?`)) return;
      const ok = await supabaseDeleteIlan(card.dataset.id);
      if (!ok) { showToast('⚠️ İlan silinemedi!'); return; }
      card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
      card.style.opacity = '0';
      card.style.transform = 'scale(0.95)';
      setTimeout(() => {
        card.remove();
        renderIlanlarWithLimit();
        showToast('🗑️ İlan silindi.');
      }, 300);
    }

    function openIlanDetail(card) {
      const baslik    = card.dataset.baslik    || card.querySelector('h4')?.textContent.trim() || '';
      const aciklama  = card.dataset.aciklama  || card.querySelector('p')?.textContent.trim()  || '';
      const sehir     = card.dataset.sehir     || '';
      const kisi      = card.dataset.kisi      || '';
      const tip       = card.dataset.tip       || '';
      const tipEmoji  = card.dataset.tipEmoji  || '📋';
      const etiketler = card.dataset.etiketler || '';
      const badge     = card.dataset.badge     || 'Yeni';
      const badgeClass= card.dataset.badgeClass|| 'badge-yeni';
      const isOwner   = card.dataset.owner === 'true';

      const tagHTML = etiketler.split(',').map(t => t.trim()).filter(Boolean)
        .map(t => `<span class="idm-tag">${escapeHtml(t)}</span>`).join('');

      const overlay = document.getElementById('ilan-detail-overlay');
      overlay.innerHTML = `
        <div class="ilan-detail-modal">
          <div class="idm-header">
            <div>
              <span class="ilan-badge ${badgeClass}" style="margin-bottom:0.8rem;display:inline-flex;">${escapeHtml(badge)}</span>
              <div class="idm-title">${escapeHtml(baslik)}</div>
            </div>
            <button class="idm-close-btn" onclick="closeIlanDetail()">✕</button>
          </div>
          <div class="idm-body">
            <div>
              <div class="idm-section-title">Açıklama</div>
              <div class="idm-desc">${escapeHtml(aciklama) || '<span style="color:var(--text-dim);font-style:italic;">Açıklama eklenmemiş.</span>'}</div>
            </div>
            <div>
              <div class="idm-section-title">Detaylar</div>
              <div class="idm-info-grid">
                <div class="idm-info-chip">
                  <div class="chip-icon">📍</div>
                  <div><div class="chip-label">Konum</div><div class="chip-val">${escapeHtml(sehir) || '—'}</div></div>
                </div>
                <div class="idm-info-chip">
                  <div class="chip-icon">${tipEmoji}</div>
                  <div><div class="chip-label">Tür</div><div class="chip-val">${escapeHtml(tip) || '—'}</div></div>
                </div>
                <div class="idm-info-chip" style="grid-column:1/-1;">
                  <div class="chip-icon">👥</div>
                  <div><div class="chip-label">Aranan Kişi</div><div class="chip-val">${escapeHtml(kisi) || '—'}</div></div>
                </div>
              </div>
            </div>
            ${tagHTML ? `<div>
              <div class="idm-section-title">Etiketler</div>
              <div class="idm-tags">${tagHTML}</div>
            </div>` : ''}
            ${isOwner
              ? `<button class="idm-apply-btn" disabled>
                  <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/></svg>
                  Kendi İlanın
                </button>`
              : `<button class="idm-apply-btn" id="idm-apply-btn" onclick="applyFromDetail(this.dataset.ilanAdi)" data-ilan-adi="${escapeHtml(baslik)}">
                  Başvur →
                </button>`
            }
          </div>
        </div>`;
      overlay.classList.add('open');
      document.body.style.overflow = 'hidden';
    }

    function closeIlanDetail() {
      document.getElementById('ilan-detail-overlay').classList.remove('open');
      document.body.style.overflow = '';
    }

    async function applyFromDetail(ilanAdi) {
      const btn = document.getElementById('idm-apply-btn');
      const session = (await supabase.auth.getSession()).data.session;
      if (!session) { showToast('⚠️ Başvuru için önce giriş yapmalısın!'); return; }
      const email = session.user.email;
      const { data: existing } = await supabase.from('mesajlar')
        .select('id').eq('gonderen_email', email).eq('konu', 'İlan Başvurusu').eq('proje', ilanAdi).limit(1);
      if (existing && existing.length) {
        if (btn) { btn.textContent = '✓ Başvuruldu'; btn.disabled = true; btn.style.boxShadow = 'none'; }
        showToast('ℹ️ Bu ilana zaten başvurdun.');
        return;
      }
      const { error } = await supabase.from('mesajlar').insert({
        gonderen_ad: session?.user?.user_metadata?.full_name || 'Kullanıcı',
        gonderen_email: session?.user?.email || '',
        konu: 'İlan Başvurusu',
        mesaj: `"${ilanAdi}" ilanına başvuru yapıldı.`,
        proje: ilanAdi
      });
      if (error) { console.error(error.message); showToast('⚠️ Başvuru gönderilemedi!'); return; }
      if (btn) {
        btn.textContent = '✓ Başvuruldu';
        btn.disabled = true;
        btn.style.background = 'rgba(16,185,129,0.15)';
        btn.style.border = '1px solid rgba(16,185,129,0.3)';
        btn.style.color = 'var(--success)';
        btn.style.boxShadow = 'none';
      }
      showToast(`✅ "${ilanAdi}" ilanına başvurunuz alındı!`);
    }

    /* ---- BAŞVUR HANDLER ---- */
    async function handleBasvur(btn, ilanAdi) {
      if (btn.disabled) return;
      const session = (await supabase.auth.getSession()).data.session;
      if (!session) { showToast('⚠️ Başvuru için önce giriş yapmalısın!'); return; }
      const email = session.user.email;
      const { data: existing } = await supabase.from('mesajlar')
        .select('id').eq('gonderen_email', email).eq('konu', 'İlan Başvurusu').eq('proje', ilanAdi).limit(1);
      if (existing && existing.length) {
        btn.textContent = '✓ Başvuruldu';
        btn.disabled = true;
        btn.style.background = 'rgba(16,185,129,0.2)';
        btn.style.color = '#10b981';
        btn.style.borderColor = 'rgba(16,185,129,0.3)';
        showToast('ℹ️ Bu ilana zaten başvurdun.');
        return;
      }
      const { error } = await supabase.from('mesajlar').insert({
        gonderen_ad: session.user.user_metadata?.full_name || 'Kullanıcı',
        gonderen_email: email,
        konu: 'İlan Başvurusu',
        mesaj: `"${ilanAdi}" ilanına başvuru yapıldı.`,
        proje: ilanAdi
      });
      if (error) { console.error(error.message); showToast('⚠️ Başvuru gönderilemedi!'); return; }
      btn.textContent = '✓ Başvuruldu';
      btn.disabled = true;
      btn.style.background = 'rgba(16,185,129,0.2)';
      btn.style.color = '#10b981';
      btn.style.borderColor = 'rgba(16,185,129,0.3)';
      showToast(`✅ "${ilanAdi}" ilanına başvurunuz alındı!`);
    }

    /* ---- GMAIL CONTACT ---- */
    function sendGmail() {
      const ad     = document.getElementById('field-ad').value.trim();
      const soyad  = document.getElementById('field-soyad').value.trim();
      const email  = document.getElementById('field-email').value.trim();
      const konu   = document.getElementById('field-konu').value;
      const mesaj  = document.getElementById('field-mesaj').value.trim();
      const uni    = document.getElementById('field-universite') ? document.getElementById('field-universite').value.trim() : '';
      const bolum  = document.getElementById('field-bolum')      ? document.getElementById('field-bolum').value.trim()      : '';
      const proje  = document.getElementById('field-proje')      ? document.getElementById('field-proje').value.trim()      : '';

      if (!ad || !email || !mesaj) {
        showToast('⚠️ Lütfen zorunlu alanları doldurun!');
        return;
      }

      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        showToast('⚠️ Geçerli bir e-posta adresi girin!');
        return;
      }

      const konuMap = {
        takim: 'Takım Kurma / Üye Arama',
        mentor: 'Mentörlük Talebi',
        proje: 'Proje Ortaklığı',
        teknofest: 'Teknofest Başvurusu',
        tubitak: 'TÜBİTAK Projesi',
        platform: 'Platform Hakkında',
        diger: 'Diğer',
        '': 'Genel İletişim'
      };

      const subject = encodeURIComponent(`[Quantro] ${konuMap[konu] || 'Mesaj'} — ${ad} ${soyad}`);
      const body    = encodeURIComponent(
        `Gönderen: ${ad} ${soyad}\nE-posta: ${email}\nÜniversite/Okul: ${uni || '—'}\nBölüm/Sınıf: ${bolum || '—'}\nProje/Yarışma: ${proje || '—'}\nKonu: ${konuMap[konu] || '-'}\n\n${mesaj}`
      );

      window.open(`https://mail.google.com/mail/?view=cm&fs=1&to=quantro@gmail.com&su=${subject}&body=${body}`, '_blank');
      showToast('📧 Gmail açılıyor...');
    }

    /* ---- CALENDAR ---- */
    const MONTHS_TR = ['Ocak','Şubat','Mart','Nisan','Mayıs','Haziran',
                       'Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık'];

    const EVENTS = {
      /* ===== OCAK ===== */
      '2026-1-1': [
        { color:'#ef4444', title:'Yılbaşı 🎆', detail:'Resmi Tatil · Yeni yılın ilk günü · Tüm Türkiye\'de tatil' },
      ],
      '2026-1-20': [
        { color:'#3b82f6', title:'Avrupa İnsan Hakları Mahkemesi Kuruldu 🏛️', detail:'20 Ocak 1959 — AİHM resmen faaliyete geçti · Avrupa\'da insan haklarının güvencesi' },
      ],

      /* ===== ŞUBAT ===== */
      '2026-2-6': [
        { color:'#3b82f6', title:'Kahramanmaraş Depremleri Yıl Dönümü 🕯️', detail:'6 Şubat 2023 — 7.7 ve 7.6 büyüklüğündeki depremler · 11 ilde büyük yıkım · 50.000+ hayat kaybı' },
      ],
      '2026-2-14': [
        { color:'#8b5cf6', title:'Sevgililer Günü 💙', detail:'14 Şubat — Dünya genelinde sevgi ve dostluk günü' },
      ],

      /* ===== MART ===== */
      '2026-3-8': [
        { color:'#8b5cf6', title:'Dünya Kadınlar Günü 👩', detail:'8 Mart — BM tarafından 1975\'te kabul edildi · Kadın hakları ve eşitlik günü' },
      ],
      '2026-3-18': [
        { color:'#ef4444', title:'Çanakkale Zaferi 🏆', detail:'18 Mart 1915 — Çanakkale Deniz Zaferi · Türk kuvvetleri İtilaf donanmasını geri çevirdi · "Çanakkale geçilmez!"' },
      ],
      '2026-3-20': [
        { color:'#10b981', title:'Ramazan Bayramı 1. Günü 🌙', detail:'Dini Tatil · Şeker Bayramı · Ramazan ayının sona ermesiyle kutlanan mübarek bayram' },
      ],
      '2026-3-21': [
        { color:'#10b981', title:'Ramazan Bayramı 2. Günü 🌙', detail:'Dini Tatil · Aile ziyaretleri, şeker ve çikolata ikramları · Bayramlaşma günü' },
        { color:'#f59e0b', title:'Nevruz 🌸', detail:'21 Mart — Baharın gelişini kutlayan Orta Asya kökenli bayram · Birçok ülkede kutlanır' },
      ],
      '2026-3-22': [
        { color:'#10b981', title:'Ramazan Bayramı 3. Günü 🌙', detail:'Dini Tatil · Şeker Bayramı\'nın son günü · Mezarlık ziyaretleri' },
      ],

      /* ===== NİSAN ===== */
      '2026-4-23': [
        { color:'#ef4444', title:'Ulusal Egemenlik ve Çocuk Bayramı 🎈', detail:'Resmi Tatil · 23 Nisan 1920 — TBMM kuruldu · Dünyanın çocuklara armağan edilen ilk ve tek bayramı' },
      ],
      '2026-4-24': [
        { color:'#3b82f6', title:'1915 Olayları Anma Günü', detail:'24 Nisan — Ermeni toplumunun 1915 olaylarını andığı gün · Tarihsel tartışmaların güncelliğini koruduğu önemli tarih' },
      ],

      /* ===== MAYIS ===== */
      '2026-5-1': [
        { color:'#ef4444', title:'İşçi ve Emekçi Bayramı 🔨', detail:'Resmi Tatil · Emek ve Dayanışma Günü · 1886 Şikago işçi eylemlerinin anısına her yıl kutlanır' },
      ],
      '2026-5-19': [
        { color:'#ef4444', title:'Gençlik ve Spor Bayramı 🏅', detail:'Resmi Tatil · 19 Mayıs 1919 — Atatürk Samsun\'a ayak bastı · Kurtuluş Savaşı\'nın sembolik başlangıcı' },
      ],
      '2026-5-25': [
        { color:'#10b981', title:'Kurban Bayramı Arifesi 🐑', detail:'Dini Tatil (Yarım Gün) · Arife günü · Kurban hazırlıkları, dua ve ibadet' },
      ],
      '2026-5-26': [
        { color:'#10b981', title:'Kurban Bayramı 1. Günü 🐑', detail:'Dini Tatil · Hz. İbrahim\'in Allah\'a olan bağlılığının anısı · Kurban kesilir, etler dağıtılır' },
      ],
      '2026-5-27': [
        { color:'#10b981', title:'Kurban Bayramı 2. Günü 🐑', detail:'Dini Tatil · 27 Mayıs 1960 — Türkiye\'nin ilk askeri darbesi de bu gün yaşandı' },
      ],
      '2026-5-28': [
        { color:'#10b981', title:'Kurban Bayramı 3. Günü 🐑', detail:'Dini Tatil · Aile ziyaretleri ve bayramlaşma · Mezarlık ziyaretleri' },
      ],
      '2026-5-29': [
        { color:'#10b981', title:'Kurban Bayramı 4. Günü 🐑', detail:'Dini Tatil · Kurban Bayramı\'nın son günü' },
        { color:'#3b82f6', title:'İstanbul\'un Fethi 🏰', detail:'29 Mayıs 1453 — Fatih Sultan Mehmet İstanbul\'u fethetti · Bizans İmparatorluğu sona erdi · Orta Çağ kapandı' },
      ],

      /* ===== HAZİRAN ===== */
      '2026-6-5': [
        { color:'#f59e0b', title:'Dünya Çevre Günü 🌍', detail:'5 Haziran — BM tarafından 1972\'de ilan edildi · Doğa ve çevre koruma farkındalığı günü' },
      ],
      '2026-6-25': [
        { color:'#3b82f6', title:'Kore Savaşı Başladı (1950) ⚔️', detail:'25 Haziran 1950 — Kore Savaşı başladı · Türk ordusu BM bünyesinde savaşa katıldı · Koreye "Kuzey Yıldızı" dediler' },
      ],

      /* ===== TEMMUZ ===== */
      '2026-7-15': [
        { color:'#ef4444', title:'Demokrasi ve Millî Birlik Günü 🇹🇷', detail:'Resmi Tatil · 15 Temmuz 2016 — Darbe girişimi · Millet meydanlara inerek demokrasiye sahip çıktı' },
      ],
      '2026-7-20': [
        { color:'#3b82f6', title:'Ay\'a İlk İnsan Ayak Bastı 🌕', detail:'20 Temmuz 1969 — Apollo 11 · Neil Armstrong "Bu benim için küçük bir adım, insanlık için büyük bir sıçrayış" dedi' },
      ],
      '2026-7-24': [
        { color:'#3b82f6', title:'Lozan Barış Antlaşması 🕊️', detail:'24 Temmuz 1923 — Türkiye Cumhuriyeti uluslararası arenada tanındı · Kapitülasyonlar sona erdi' },
      ],

      /* ===== AĞUSTOS ===== */
      '2026-8-26': [
        { color:'#3b82f6', title:'Büyük Taarruz Başladı 🏆', detail:'26 Ağustos 1922 — Kurtuluş Savaşı\'nın son büyük hücumu · Türk ordusu Yunan cephesini yardı' },
      ],
      '2026-8-30': [
        { color:'#ef4444', title:'Zafer Bayramı 🏆', detail:'Resmi Tatil · 30 Ağustos 1922 — Büyük Taarruz zaferle sonuçlandı · Kurtuluş Savaşı\'nın dönüm noktası' },
      ],

      /* ===== EYLÜL ===== */
      '2026-9-2': [
        { color:'#3b82f6', title:'II. Dünya Savaşı Sona Erdi ✌️', detail:'2 Eylül 1945 — Japonya\'nın teslim belgesi imzalandı · 6 yıl süren savaş resmen bitti · 70 milyon+ hayat kaybı' },
      ],
      '2026-9-12': [
        { color:'#3b82f6', title:'1980 Askeri Darbesi Yıl Dönümü', detail:'12 Eylül 1980 — Türkiye\'nin en kapsamlı askeri darbesi · Anayasa askıya alındı · Siyasi partiler kapatıldı' },
      ],

      /* ===== EKİM ===== */
      '2026-10-28': [
        { color:'#ef4444', title:'Cumhuriyet Bayramı Arifesi 🇹🇷', detail:'28 Ekim yarım gün resmi tatil · Bayram kutlamalarının başladığı gün' },
      ],
      '2026-10-29': [
        { color:'#ef4444', title:'Cumhuriyet Bayramı 🇹🇷', detail:'Resmi Tatil · 29 Ekim 1923 — Türkiye Cumhuriyeti ilan edildi · Atatürk ilk cumhurbaşkanı seçildi · "Ne mutlu Türk\'üm diyene!"' },
      ],

      /* ===== KASIM ===== */
      '2026-11-10': [
        { color:'#3b82f6', title:'Atatürk\'ü Anma 🎗️', detail:'10 Kasım 1938, saat 09:05 — Mustafa Kemal Atatürk hayatını kaybetti · Tüm Türkiye saygı duruşunda bulunur · Sirenlerin çaldığı an' },
      ],

      /* ===== ARALIK ===== */
      '2026-12-10': [
        { color:'#8b5cf6', title:'Dünya İnsan Hakları Günü ⚖️', detail:'10 Aralık 1948 — BM İnsan Hakları Evrensel Beyannamesi ilan edildi · Her insanın temel haklarını güvence altına alır' },
      ],
    };

    let calYear   = 2026;
    let calMonth  = 4; // 0-indexed → Mayıs
    let selectedDay = null; // { y, m, d }

    function getEventKey(y, m, d) { return `${y}-${m+1}-${d}`; }

    function renderCalendar() {
      const title = document.getElementById('cal-title');
      const grid  = document.getElementById('cal-days');
      if (!title || !grid) return; // takvim yalnizca takvim.php sayfasinda var
      title.textContent = `${MONTHS_TR[calMonth]} ${calYear}`;
      grid.innerHTML = '';

      const firstDay   = new Date(calYear, calMonth, 1).getDay();
      const offset     = (firstDay === 0) ? 6 : firstDay - 1;
      const daysInMonth = new Date(calYear, calMonth + 1, 0).getDate();
      const today      = new Date();

      for (let i = 0; i < offset; i++) {
        const d = document.createElement('div');
        d.className = 'cal-day faded';
        grid.appendChild(d);
      }

      for (let d = 1; d <= daysInMonth; d++) {
        const cell = document.createElement('div');
        cell.className = 'cal-day current-month';
        cell.textContent = d;

        const isToday = d === today.getDate() && calMonth === today.getMonth() && calYear === today.getFullYear();
        if (isToday) cell.classList.add('today');

        const key = getEventKey(calYear, calMonth, d);
        const SRC = window._dynamicEvents || EVENTS;
        if (SRC[key]) cell.classList.add('has-event');

        const isSelected = selectedDay && selectedDay.y === calYear && selectedDay.m === calMonth && selectedDay.d === d;
        if (isSelected) cell.classList.add('selected');

        cell.onclick = () => selectDay(calYear, calMonth, d);
        grid.appendChild(cell);
      }
    }

    function selectDay(y, m, d) {
      selectedDay = { y, m, d };
      renderCalendar();
      renderEventPanel(y, m, d);
    }

    function renderEventPanel(y, m, d) {
      const panel = document.getElementById('cal-event-panel');
      const key   = getEventKey(y, m, d);
      const SRC   = window._dynamicEvents || EVENTS;
      const evs   = SRC[key];

      const dateStr = `${d} ${MONTHS_TR[m]} ${y}`;
      let html = `<div class="cal-event-panel-date">📅 ${dateStr}</div>`;

      if (evs && evs.length > 0) {
        evs.forEach(ev => {
          html += `<div class="cal-event-item">
            <div class="cal-event-dot" style="background:${ev.color};box-shadow:0 0 6px ${ev.color}88;"></div>
            <div><strong>${ev.title}</strong><span>${ev.detail}</span></div>
          </div>`;
        });
      } else {
        html += `<div class="cal-no-event">Bu tarihte kayıtlı olay yok</div>`;
      }

      panel.innerHTML = html;
    }

    function changeMonth(dir) {
      calMonth += dir;
      if (calMonth < 0)  { calMonth = 11; calYear--; }
      if (calMonth > 11) { calMonth = 0;  calYear++; }
      renderCalendar();
    }

    renderCalendar();

    /* ---- SCROLL REVEAL ---- */
    const observer = new IntersectionObserver(entries => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          e.target.classList.add('visible');
          observer.unobserve(e.target);
        }
      });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    /* ---- COUNTER ANIMATION ---- */
    function animateCounters() {
      document.querySelectorAll('.stat-num[data-target]').forEach(el => {
        const target = parseInt(el.dataset.target);
        let current = 0;
        const step = Math.ceil(target / 40);
        const interval = setInterval(() => {
          current = Math.min(current + step, target);
          el.textContent = current + '+';
          if (current >= target) clearInterval(interval);
        }, 30);
      });
    }

    const heroObserver = new IntersectionObserver(entries => {
      if (entries[0].isIntersecting) { animateCounters(); heroObserver.disconnect(); }
    }, { threshold: 0.3 });

    const heroEl = document.querySelector('.hero-stats');
    if (heroEl) heroObserver.observe(heroEl);

    /* ════════════════════════════════════════════════════════
       PARTICLE BACKGROUND CANVAS
    ════════════════════════════════════════════════════════ */
    (function(){
      const canvas = document.getElementById('v-bg-canvas');
      if (!canvas) return;
      const ctx    = canvas.getContext('2d');
      let W, H, N;
      const LINK2 = 135 * 135;
      let particles = [];
      const mouse = { x: -9999, y: -9999 };
      let running = true;
      let lastPaint = 0;

      function resize(){
        W = canvas.width = window.innerWidth;
        H = canvas.height = window.innerHeight;
        N = Math.max(10, Math.min(75, Math.round((W * H) / 22000)));
        particles = Array.from({length: N}, () => new Particle());
      }

      function Particle(){
        this.x  = Math.random() * (W || 100);
        this.y  = Math.random() * (H || 100);
        this.vx = (Math.random() - .5) * .38;
        this.vy = (Math.random() - .5) * .38;
        this.r  = Math.random() * 1.4 + .5;
        this.a  = Math.random() * .45 + .18;
      }
      Particle.prototype.update = function(){
        this.x += this.vx; this.y += this.vy;
        if(this.x < 0 || this.x > W) this.vx *= -1;
        if(this.y < 0 || this.y > H) this.vy *= -1;
      };

      function draw(){
        if (!running) return;
        requestAnimationFrame(draw);
        const now = performance.now();
        if (now - lastPaint < 33) return;
        lastPaint = now;
        ctx.clearRect(0, 0, W, H);
        for(let i = 0; i < N; i++){
          const p = particles[i];
          for(let j = i+1; j < N; j++){
            const q  = particles[j];
            const dx = p.x-q.x, dy = p.y-q.y;
            const d2 = dx*dx+dy*dy;
            if(d2 < LINK2){
              ctx.strokeStyle = `rgba(59,130,246,${(1-d2/LINK2)*.22})`;
              ctx.lineWidth   = .55;
              ctx.beginPath(); ctx.moveTo(p.x,p.y); ctx.lineTo(q.x,q.y); ctx.stroke();
            }
          }
          const mdx = p.x-mouse.x, mdy = p.y-mouse.y;
          const md2 = mdx*mdx+mdy*mdy;
          if(md2 < 190*190){
            ctx.strokeStyle = `rgba(6,182,212,${(1-md2/(190*190))*.38})`;
            ctx.lineWidth   = .7;
            ctx.beginPath(); ctx.moveTo(p.x,p.y); ctx.lineTo(mouse.x,mouse.y); ctx.stroke();
          }
          ctx.beginPath(); ctx.arc(p.x,p.y,p.r,0,Math.PI*2);
          ctx.fillStyle = `rgba(59,130,246,${p.a})`; ctx.fill();
          p.update();
        }
      }
      document.addEventListener('visibilitychange', () => {
        running = !document.hidden;
        if (running) requestAnimationFrame(draw);
      });
      window.addEventListener('resize', resize);
      window.addEventListener('mousemove', e => { mouse.x = e.clientX; mouse.y = e.clientY; }, { passive: true });
      resize(); draw();
    })();

    /* ════════════════════════════════════════════════════════
       3D WIREFRAME SPHERE
    ════════════════════════════════════════════════════════ */
    (function(){
      const canvas = document.getElementById('v-sphere-canvas');
      if(!canvas) return;
      const ctx = canvas.getContext('2d');
      const W = 500, H = 500;
      canvas.width = W; canvas.height = H;
      const RINGS = 11, SEGS = 18, R = 175, FOV = 620;
      let rotY = 0, rotX = .28, mx = 0, my = 0;

      function rot(px,py,pz){
        const cy=Math.cos(rotY),sy=Math.sin(rotY);
        const x2=px*cy-pz*sy, z2=px*sy+pz*cy;
        const cx=Math.cos(rotX),sx=Math.sin(rotX);
        return [x2, py*cx-z2*sx, py*sx+z2*cx];
      }
      function proj(px,py,pz){
        const s = FOV/(FOV+pz*R+R*3);
        return [W/2+px*R*s, H/2+py*R*s, pz];
      }
      function drawLine(pts, color, lw){
        ctx.beginPath(); ctx.strokeStyle=color; ctx.lineWidth=lw;
        pts.forEach(([px,py,pz],i)=>{
          const [rx,ry,rz]=rot(px,py,pz);
          const [sx,sy]=proj(rx,ry,rz);
          i===0?ctx.moveTo(sx,sy):ctx.lineTo(sx,sy);
        }); ctx.stroke();
      }
      function render(){
        ctx.clearRect(0,0,W,H);
        // glow
        const g=ctx.createRadialGradient(W/2,H/2,0,W/2,H/2,190);
        g.addColorStop(0,'rgba(59,130,246,.05)'); g.addColorStop(1,'transparent');
        ctx.beginPath(); ctx.arc(W/2,H/2,190,0,Math.PI*2); ctx.fillStyle=g; ctx.fill();
        // latitude
        for(let i=0;i<=RINGS;i++){
          const lat=i/RINGS*Math.PI, ry=-Math.cos(lat), r=Math.sin(lat);
          const pts=[];
          for(let j=0;j<=SEGS;j++) pts.push([r*Math.cos(j/SEGS*Math.PI*2),ry,r*Math.sin(j/SEGS*Math.PI*2)]);
          const [,,mz]=rot(pts[Math.floor(SEGS/2)][0],pts[Math.floor(SEGS/2)][1],pts[Math.floor(SEGS/2)][2]);
          drawLine(pts, `rgba(59,130,246,${Math.max(.04,.04+.42*((mz+1)/2))})`, .75);
        }
        // longitude
        for(let j=0;j<SEGS;j++){
          const lon=j/SEGS*Math.PI*2, co=Math.cos(lon), si=Math.sin(lon);
          const pts=[];
          for(let i=0;i<=RINGS*2;i++) pts.push([Math.sin(i/(RINGS*2)*Math.PI)*co,-Math.cos(i/(RINGS*2)*Math.PI),Math.sin(i/(RINGS*2)*Math.PI)*si]);
          const [,,mz]=rot(co,0,si);
          drawLine(pts, `rgba(59,130,246,${Math.max(.04,.04+.42*((mz+1)/2))})`, .75);
        }
        // glowing nodes
        for(let i=0;i<=RINGS;i+=2){
          const lat=i/RINGS*Math.PI, ry=-Math.cos(lat), r=Math.sin(lat);
          for(let j=0;j<SEGS;j+=2){
            const lon=j/SEGS*Math.PI*2;
            const [rx2,ry2,rz]=rot(r*Math.cos(lon),ry,r*Math.sin(lon));
            if(rz>.1){
              const [sx,sy]=proj(rx2,ry2,rz);
              const a=.3+.7*((rz+1)/2);
              const ng=ctx.createRadialGradient(sx,sy,0,sx,sy,5);
              ng.addColorStop(0,`rgba(6,182,212,${a*.9})`); ng.addColorStop(1,'transparent');
              ctx.beginPath(); ctx.arc(sx,sy,5,0,Math.PI*2); ctx.fillStyle=ng; ctx.fill();
              ctx.beginPath(); ctx.arc(sx,sy,1.8,0,Math.PI*2);
              ctx.fillStyle=`rgba(6,182,212,${a})`; ctx.fill();
            }
          }
        }
        // equator highlight
        const ep=[];
        for(let j=0;j<=SEGS*2;j++) ep.push([Math.cos(j/(SEGS*2)*Math.PI*2),0,Math.sin(j/(SEGS*2)*Math.PI*2)]);
        drawLine(ep,'rgba(6,182,212,.38)',1.2);
      }
      let lastFrame = 0;
      function loop(ts){
        if (document.hidden) return;
        if (ts - lastFrame >= 33) {
          lastFrame = ts;
          rotY += .0038 + mx*.0009;
          rotX  = Math.max(-.5, Math.min(.8, rotX + my*.00025));
          render();
        }
        requestAnimationFrame(loop);
      }
      window.addEventListener('mousemove', e=>{
        mx = (e.clientX/window.innerWidth -.5)*2;
        my = (e.clientY/window.innerHeight-.5)*2;
      }, { passive: true });
      requestAnimationFrame(loop);
    })();

    /* ════════════════════════════════════════════════════════
       CUSTOM CURSOR — 120fps optimized, RAF timestamp-driven
    ════════════════════════════════════════════════════════ */
    (function(){
      if('ontouchstart' in window) return;
      const dot  = document.getElementById('v-cursor');
      const ring = document.getElementById('v-cursor-ring');
      if (!dot || !ring) return;

      let mx = 0, my = 0;
      let rx = 0, ry = 0;
      let dx = 0, dy = 0;

      // Use time-based lerp so speed is FPS-independent (120fps smooth)
      const RING_SPEED = 14;   // degrees/sec feel
      const DOT_SPEED  = 38;

      let lastTime = 0;
      let isHovering = false;
      let wasHovering = null;

      document.addEventListener('mousemove', e => { mx = e.clientX; my = e.clientY; }, { passive: true });

      document.addEventListener('mouseover', e => {
        if (e.target.closest('a,button,.card-link,.ilan-card,.card-3d,.profil-card,.nav-user-badge,.dropdown-item')) {
          isHovering = true;
        }
      });
      document.addEventListener('mouseout', e => {
        if (e.target.closest('a,button,.card-link,.ilan-card,.card-3d,.profil-card,.nav-user-badge,.dropdown-item')) {
          isHovering = false;
        }
      });

      function loop(ts) {
        const dt = Math.min((ts - lastTime) / 1000, 0.05); // cap at 50ms to avoid jumps
        lastTime = ts;

        // Time-based exponential lerp: pos += (target - pos) * (1 - e^(-speed * dt))
        const df = 1 - Math.exp(-DOT_SPEED  * dt);
        const rf = 1 - Math.exp(-RING_SPEED * dt);

        dx += (mx - dx) * df;
        dy += (my - dy) * df;
        rx += (mx - rx) * rf;
        ry += (my - ry) * rf;

        // Use transform instead of left/top for GPU acceleration
        dot.style.transform  = `translate(calc(${dx}px - 50%), calc(${dy}px - 50%))`;
        ring.style.transform = `translate(calc(${rx}px - 50%), calc(${ry}px - 50%))`;

        // Sadece durum degistiginde stil yaz (her karede degil)
        if (isHovering !== wasHovering) {
          wasHovering = isHovering;
          if (isHovering) {
            dot.style.width = dot.style.height = '6px';
            ring.style.width = ring.style.height = '54px';
            ring.style.borderColor = 'rgba(6,182,212,.65)';
            ring.style.borderWidth = '1.5px';
          } else {
            dot.style.width = dot.style.height = '12px';
            ring.style.width = ring.style.height = '36px';
            ring.style.borderColor = 'rgba(6,182,212,.35)';
            ring.style.borderWidth = '1px';
          }
        }

        requestAnimationFrame(loop);
      }

      // Override position-based to transform-based
      dot.style.left = '0'; dot.style.top = '0';
      ring.style.left = '0'; ring.style.top = '0';
      dot.style.willChange = 'transform, width, height';
      ring.style.willChange = 'transform, width, height';

      requestAnimationFrame(ts => { lastTime = ts; requestAnimationFrame(loop); });
    })();
    /* ════════════════════════════════════════════════════════
       PROFİL FİLTRELEME
    ════════════════════════════════════════════════════════ */
    function filterProfiller() {
      const q    = (document.getElementById('profil-search').value || '').toLowerCase().trim();
      const alan = document.getElementById('profil-alan').value;
      const sehir= document.getElementById('profil-sehir').value;
      let visible = 0;
      document.querySelectorAll('.profil-card').forEach(card => {
        const name  = (card.dataset.name  || '').toLowerCase();
        const alanD = (card.dataset.alan  || '').toLowerCase();
        const sehirD= (card.dataset.sehir || '').toLowerCase();
        const skillsText = card.querySelector('.profil-skills')?.textContent.toLowerCase() || '';
        const bioText    = card.querySelector('.profil-bio')?.textContent.toLowerCase()    || '';

        const matchQ     = !q     || name.includes(q) || skillsText.includes(q) || bioText.includes(q) || sehirD.includes(q);
        const matchAlan  = !alan  || alanD.includes(alan);
        const matchSehir = !sehir || sehirD.includes(sehir);

        const show = matchQ && matchAlan && matchSehir;
        card.dataset.hidden = show ? 'false' : 'true';
        card.style.display = show ? '' : 'none';
        if (show) visible++;
      });
      const cards = document.querySelectorAll('.profil-card');
      const emptyEl = document.getElementById('profil-empty-msg');
      if (!cards.length) { if (emptyEl) emptyEl.style.display = 'none'; return; }
      if (visible === 0) {
        emptyEl.innerHTML = '<p style="color:var(--text-dim);font-size:0.95rem;">🔍 Aramanızla eşleşen profil bulunamadı. <button class="btn btn-ghost btn-sm" onclick="resetProfilFilter()">Filtreleri Temizle</button></p>';
        emptyEl.style.display = 'block';
      } else {
        emptyEl.style.display = 'none';
      }
    }

    function resetProfilFilter() {
      document.getElementById('profil-search').value = '';
      document.getElementById('profil-alan').value = '';
      document.getElementById('profil-sehir').value = '';
      filterProfiller();
    }

    /* ════════════════════════════════════════════════════════
       AI SEARCH MODAL
    ════════════════════════════════════════════════════════ */
    /* ════════════════════════════════════════════════════════
       BAŞVURU MODAL
    ════════════════════════════════════════════════════════ */
    let basvurTarget = { name: '', email: '', discord: '' };

    function openBasvurModal(name, email, discord) {
      basvurTarget = { name, email, discord };
      document.getElementById('basvur-title').textContent = name + ' — Davet Gönder';
      document.getElementById('basvur-subtitle').textContent = 'İletişim yöntemini seç ve mesajını gönder';
      document.getElementById('basvur-overlay').classList.add('open');
      document.body.style.overflow = 'hidden';
    }
    function closeBasvurModal(e) {
      if (e && e.target !== document.getElementById('basvur-overlay')) return;
      document.getElementById('basvur-overlay').classList.remove('open');
      document.body.style.overflow = '';
    }
    function setBasvurTab(tab, el) {
      document.querySelectorAll('.basvur-tab').forEach(t => t.classList.remove('active'));
      el.classList.add('active');
      document.getElementById('basvur-email-form').style.display = tab === 'email' ? '' : 'none';
    }
    function sendBasvurEmail() {
      const adi    = document.getElementById('b-adi').value.trim();
      const email  = document.getElementById('b-email').value.trim();
      const mesaj  = document.getElementById('b-mesaj').value.trim();
      if (!adi || !email || !mesaj) { showToast('❗ Lütfen tüm alanları doldurun.'); return; }
      const subject = encodeURIComponent(`Quantro — Takım Daveti: ${basvurTarget.name}`);
      const body    = encodeURIComponent(`Merhaba ${basvurTarget.name},\n\nQuantro platformu üzerinden seni takımımıza davet etmek istiyorum.\n\n${mesaj}\n\nGönderen: ${adi}\nE-posta: ${email}`);
      window.open(`https://mail.google.com/mail/?view=cm&to=${basvurTarget.email}&su=${subject}&body=${body}`, '_blank');
      closeBasvurModal();
      showToast('✅ Gmail açıldı — mesajınızı gönderin!');
    }


    /* ════════════════════════════════════════════════════════
       PROFİL EKLEME FORMU
    ════════════════════════════════════════════════════════ */

    // Şifre göster/gizle
    function togglePw(inputId, btn) {
      const input = document.getElementById(inputId);
      const isHidden = input.type === 'password';
      input.type = isHidden ? 'text' : 'password';
      btn.innerHTML = isHidden
        ? `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
        : `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>`;
      btn.style.color = isHidden ? 'var(--primary)' : '';
    }

    // Profil fotoğrafı yükleme
    let currentAvatarDataUrl = null;

    function handleAvatarUpload(event) {
      const file = event.target.files[0];
      if (!file) return;
      if (file.size > 5 * 1024 * 1024) {
        showToast('❗ Fotoğraf 5 MB\'dan küçük olmalı.'); return;
      }
      window._pfAvatarFile = file;
      const reader = new FileReader();
      reader.onload = function(e) {
        currentAvatarDataUrl = e.target.result;
        const img = document.getElementById('avatar-preview');
        const placeholder = document.getElementById('avatar-placeholder');
        img.src = currentAvatarDataUrl;
        img.classList.add('loaded');
        placeholder.style.opacity = '0';
        showToast('✅ Fotoğraf yüklendi!');
      };
      reader.readAsDataURL(file);
    }

    function openProfilForm() {
      // Reset avatar state
      window._editProfilId = null;
      currentAvatarDataUrl = null;
      const img = document.getElementById('avatar-preview');
      const placeholder = document.getElementById('avatar-placeholder');
      if (img) { img.src = ''; img.classList.remove('loaded'); }
      if (placeholder) placeholder.style.opacity = '1';
      const fileInput = document.getElementById('pf-photo-input');
      if (fileInput) fileInput.value = '';

      document.getElementById('profil-form-overlay').classList.add('open');
      document.body.style.overflow = 'hidden';
    }
    function closeProfilForm(e) {
      if (e && e.target !== document.getElementById('profil-form-overlay')) return;
      document.getElementById('profil-form-overlay').classList.remove('open');
      document.body.style.overflow = '';
    }
    function closeProfilFormBtn() {
      document.getElementById('profil-form-overlay').classList.remove('open');
      document.body.style.overflow = '';
    }
    function submitProfilForm() {
      const ad    = document.getElementById('pf-ad').value.trim();
      const soyad = document.getElementById('pf-soyad').value.trim();
      const uni   = document.getElementById('pf-uni').value.trim();
      const alan  = document.getElementById('pf-alan').value;
      const sehir = document.getElementById('pf-sehir').value;
      const skills= document.getElementById('pf-skills').value.trim();
      const bio   = document.getElementById('pf-bio').value.trim();
      const ilet  = document.getElementById('pf-iletisim').value.trim();
      const saat  = document.getElementById('pf-saat').value;

      if (!ad || !soyad || !bio || !skills || !ilet) {
        showToast('❗ Lütfen tüm zorunlu alanları doldurun.'); return;
      }

      const fullName = `${ad} ${soyad}`;
      const initials = (ad[0] + soyad[0]).toUpperCase();
      const colors   = [
        'linear-gradient(135deg,#3b82f6,#06b6d4)',
        'linear-gradient(135deg,#8b5cf6,#ec4899)',
        'linear-gradient(135deg,#10b981,#3b82f6)',
        'linear-gradient(135deg,#f59e0b,#ef4444)',
      ];
      const color = colors[Math.floor(Math.random() * colors.length)];
      const sehirLabel = {istanbul:'İstanbul',ankara:'Ankara',izmir:'İzmir',bursa:'Bursa',kayseri:'Kayseri',online:'Online'}[sehir] || sehir;

      const skillTags = skills.split(',').map(s => `<span class="profil-skill">${s.trim()}</span>`).join('');

      // Avatar HTML: fotoğraf varsa img, yoksa initials
      const avatarHTML = currentAvatarDataUrl
        ? `<div class="profil-avatar" style="background:transparent;padding:0;overflow:hidden;"><img src="${currentAvatarDataUrl}" alt="${fullName}" style="width:100%;height:100%;object-fit:cover;border-radius:16px;display:block;"></div>`
        : `<div class="profil-avatar" style="background:${color};">${initials}</div>`;

      const card = document.createElement('div');
      card.className = 'profil-card';
      card.dataset.alan  = alan;
      card.dataset.sehir = sehir;
      card.dataset.name  = fullName.toLowerCase();
      card.dataset.iletisim = ilet;
      card.dataset.saat  = saat;
      card.dataset.uni   = uni;
      card.dataset.avatar = currentAvatarDataUrl || '';
      card.dataset.color  = color;
      card.dataset.initials = initials;
      card.setAttribute('onmousemove','tiltCard(event,this)');
      card.setAttribute('onmouseleave','resetTilt(this)');
      card.innerHTML = `
        <div class="profil-top">
          ${avatarHTML}
          <div>
            <div class="profil-info-name">${fullName}</div>
            <div class="profil-info-role">${uni}</div>
          </div>
          <div class="profil-available"><span></span>Yeni</div>
        </div>
        <div class="profil-bio">${bio}</div>
        <div class="profil-skills">${skillTags}</div>
        <div class="profil-meta">
          <span>📍 ${sehirLabel}</span>
          <span>⏰ ${saat}</span>
        </div>
        <div class="profil-actions">
          <button class="btn btn-primary btn-sm" onclick="openProfilDetail(this.closest('.profil-card'))" title="Profil detaylarını gör" style="flex:1.4;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            Profili Gör
          </button>
          <button class="btn btn-secondary btn-sm" onclick="editProfilCard(this)" title="Profili düzenle">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Düzenle
          </button>
          <button class="btn btn-ghost btn-sm" onclick="deleteProfilCard(this)" style="color:#f87171;border-color:rgba(239,68,68,0.2);" title="Profili sil">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="m19 6-.867 14.142A2 2 0 0 1 16.138 22H7.862a2 2 0 0 1-1.995-1.858L5 6m5 0V4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2"/></svg>
            Sil
          </button>
        </div>`;

      const grid = document.getElementById('profiller-grid');
      grid.insertBefore(card, grid.firstChild);

      // Ayrıca nav avatar'ı da güncelle (ilk profil eklenmişse)
      if (currentAvatarDataUrl) {
        const navAvatar = document.getElementById('nav-user-avatar');
        if (navAvatar) {
          navAvatar.innerHTML = `<img src="${currentAvatarDataUrl}" alt="${fullName}">`;
          navAvatar.style.background = 'transparent';
          navAvatar.style.padding = '0';
          navAvatar.style.overflow = 'hidden';
        }
      }

      // Hide empty state
      const emptyInit = document.getElementById('profiller-empty-msg-initial');
      if (emptyInit) emptyInit.style.display = 'none';

      closeProfilForm();
      showToast(`✅ ${fullName} profili eklendi!`);

      // Scroll to new card
      setTimeout(() => {
        card.scrollIntoView({ behavior: 'smooth', block: 'center' });
        card.style.boxShadow = '0 0 0 2px var(--primary), var(--shadow-3d)';
        setTimeout(() => card.style.boxShadow = '', 2000);
      }, 300);
    }

    function editProfilCard(btn) {
      const card = btn.closest('.profil-card');
      // Form'u aç ve mevcut değerleri doldur
      openProfilForm();
      window._editProfilId = parseInt(card.dataset.id) || null;
      setTimeout(() => {
        const bioEl   = card.querySelector('.profil-bio');
        const nameEl  = card.querySelector('.profil-info-name');
        const roleEl  = card.querySelector('.profil-info-role');
        const metaEls = card.querySelectorAll('.profil-meta span');
        if (nameEl) {
          const parts = nameEl.textContent.trim().split(' ');
          document.getElementById('pf-ad').value    = parts[0] || '';
          document.getElementById('pf-soyad').value = parts.slice(1).join(' ') || '';
        }
        if (roleEl)  document.getElementById('pf-uni').value = roleEl.textContent.trim();
        if (bioEl)   document.getElementById('pf-bio').value = bioEl.textContent.trim();
        const skills = Array.from(card.querySelectorAll('.profil-skill')).map(s => s.textContent.trim()).join(', ');
        document.getElementById('pf-skills').value = skills;
        // Eski kartı kaydet, kaydet butonunu "Güncelle" moduna al
        document.getElementById('profil-form-overlay').dataset.editCard = '';
        const submitBtn = document.querySelector('#profil-form-overlay .btn-primary');
        if (submitBtn) {
          submitBtn._oldCard = card;
          submitBtn.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg> Profili Güncelle`;
          submitBtn.onclick = function() {
            const oldCard = this._oldCard;
            submitProfilForm();
            // submitProfilForm yeni kart ekler, eskiyi sil
            if (oldCard && oldCard.parentNode) oldCard.remove();
            // Butonu eski haline getir
            this.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg> Profili Yayınla`;
            this.onclick = submitProfilForm;
            this._oldCard = null;
          };
        }
      }, 100);
    }

    function deleteProfilCard(btn) {
      const card = btn.closest('.profil-card');
      const nameEl = card.querySelector('.profil-info-name');
      const name = nameEl ? nameEl.textContent.trim() : 'bu profil';
      if (!confirm(`"${name}" profilini silmek istediğine emin misin?`)) return;
      card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
      card.style.opacity = '0';
      card.style.transform = 'scale(0.95)';
      setTimeout(() => {
        card.remove();
        showToast('🗑️ Profil silindi.');
      }, 300);
    }


    function openProfilDetail(card) {
      const name     = card.querySelector('.profil-info-name')?.textContent.trim() || '';
      const uni      = card.dataset.uni || card.querySelector('.profil-info-role')?.textContent.trim() || '';
      const bio      = card.querySelector('.profil-bio')?.textContent.trim() || '';
      const sehirRaw = card.querySelector('.profil-meta span:first-child')?.textContent.trim() || '';
      const saat     = card.dataset.saat || card.querySelector('.profil-meta span:last-child')?.textContent.replace('⏰','').trim() || '';
      const iletisim = card.dataset.iletisim || '';
      const avatarSrc= card.dataset.avatar || '';
      const color    = card.dataset.color || 'linear-gradient(135deg,#3b82f6,#06b6d4)';
      const initials = card.dataset.initials || name.split(' ').map(w=>w[0]).join('').toUpperCase().slice(0,2);
      const alan     = card.dataset.alan || '';
      const alanLabel= {yazilim:'Yazılım',  'yapay-zeka':'Yapay Zeka', donanim:'Donanım / Elektronik', tasarim:'Tasarım', siber:'Siber Güvenlik', mekanik:'Mekanik'}[alan] || alan;

      const skills = Array.from(card.querySelectorAll('.profil-skill')).map(s => s.textContent.trim());
      const skillHTML = skills.map(s => `<span class="pdm-skill">${escapeHtml(s)}</span>`).join('');

      const avatarHTML = avatarSrc
        ? `<div class="pdm-avatar"><img src="${escapeHtml(avatarSrc)}" alt="${escapeHtml(name)}"></div>`
        : `<div class="pdm-avatar" style="background:${color};">${escapeHtml(initials)}</div>`;

      const overlay = document.getElementById('profil-detail-overlay');
      overlay.innerHTML = `
        <div class="profil-detail-modal">
          <div class="pdm-cover">
            <button class="pdm-close-btn" onclick="closeProfilDetail()">✕</button>
            <div class="pdm-avatar-wrap">${avatarHTML}</div>
          </div>
          <div class="pdm-body">
            <div class="pdm-header">
              <div>
                <div class="pdm-name">${escapeHtml(name)}</div>
                <div class="pdm-uni">${escapeHtml(uni)}</div>
              </div>
              <div class="pdm-available-badge">Müsait</div>
            </div>
            <div class="pdm-bio">${escapeHtml(bio) || '<span style="color:var(--text-dim);font-style:italic;">Biyografi eklenmemiş.</span>'}</div>
            ${skills.length ? `
            <div class="pdm-section-title">Beceriler & Uzmanlıklar</div>
            <div class="pdm-skills">${skillHTML}</div>` : ''}
            <div class="pdm-section-title">Detaylar</div>
            <div class="pdm-info-grid">
              <div class="pdm-info-chip">
                <div class="chip-icon">📍</div>
                <div><div class="chip-label">Şehir</div><div class="chip-val">${escapeHtml(sehirRaw.replace('📍','').trim()) || '—'}</div></div>
              </div>
              <div class="pdm-info-chip">
                <div class="chip-icon">⏰</div>
                <div><div class="chip-label">Haftalık Süre</div><div class="chip-val">${escapeHtml(saat) || '—'}</div></div>
              </div>
              ${alanLabel ? `<div class="pdm-info-chip" style="grid-column:1/-1;">
                <div class="chip-icon">🎯</div>
                <div><div class="chip-label">Alan</div><div class="chip-val">${escapeHtml(alanLabel)}</div></div>
              </div>` : ''}
            </div>
            ${iletisim ? `<button class="idm-apply-btn" id="pdm-contact-copy" onclick="copyContactInfo(this.dataset.info)" data-info="${escapeHtml(iletisim)}">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
              İletişimi Kopyala
            </button>` : ''}

          </div>
        </div>`;
      overlay.classList.add('open');
      document.body.style.overflow = 'hidden';
    }

    function closeProfilDetail() {
      const overlay = document.getElementById('profil-detail-overlay');
      overlay.classList.remove('open');
      document.body.style.overflow = '';
    }

    function copyContactInfo(info) {
      navigator.clipboard.writeText(info).then(() => {
        const btn = document.getElementById('pdm-contact-copy');
        if (btn) {
          btn.innerHTML = `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Kopyalandı!`;
          btn.style.background = 'rgba(16,185,129,0.15)';
          btn.style.border = '1px solid rgba(16,185,129,0.35)';
          btn.style.color = 'var(--success)';
          btn.style.boxShadow = '0 4px 15px rgba(16,185,129,0.2)';
          setTimeout(() => { closeProfilDetail(); }, 1500);
        }
        showToast('✅ İletişim bilgisi kopyalandı!');
      }).catch(() => {
        showToast('📋 ' + info);
      });
    }

    function autoFillForm(konu, mesaj) {
      document.getElementById('field-konu').value = konu;
      document.getElementById('field-mesaj').value = mesaj;
      updateCharCount(document.getElementById('field-mesaj'));
      updateFormSteps();
      scrollToSection('iletisim');
      setTimeout(() => document.getElementById('field-ad').focus(), 400);
      showToast('✅ Form otomatik dolduruldu!');
    }

    function updateCharCount(ta) {
      const el = document.getElementById('char-count');
      if (el) el.textContent = ta.value.length + ' / 800';
    }

    function updateFormSteps() {
      const ad    = document.getElementById('field-ad')?.value.trim();
      const email = document.getElementById('field-email')?.value.trim();
      const konu  = document.getElementById('field-konu')?.value;
      const s1 = document.getElementById('step-1');
      const s2 = document.getElementById('step-2');
      const s3 = document.getElementById('step-3');
      if (!s1) return;
      if (ad && email) {
        s1.classList.add('done'); s1.classList.remove('active');
        s2.classList.add('active');
      }
      if (ad && email && konu) {
        s2.classList.add('done'); s2.classList.remove('active');
        s3.classList.add('active');
      }
    }

    function copyToClipboard(text, msg) {
      navigator.clipboard.writeText(text).then(() => showToast('📋 ' + msg)).catch(() => showToast('📋 ' + text));
    }

    function copyFormContact() {
      const ad    = document.getElementById('field-ad')?.value || '';
      const email = document.getElementById('field-email')?.value || '';
      const mesaj = document.getElementById('field-mesaj')?.value || '';
      const text  = `Ad: ${ad}\nE-posta: ${email}\nMesaj: ${mesaj}`;
      navigator.clipboard.writeText(text).then(() => showToast('📋 Bilgiler panoya kopyalandı!')).catch(() => showToast('❗ Kopyalama başarısız.'));
    }

    async function fillWithAI() {
      const prompt = window.prompt('Ne arıyorsun? Kısaca anlat (Türkçe):');
      if (!prompt || !prompt.trim()) return;

      showToast('✨ AI mesajı hazırlıyor...');
      try {
        const res = await fetch('https://api.anthropic.com/v1/messages', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            model: 'claude-sonnet-4-20250514',
            max_tokens: 1000,
            system: `Sen Quantro Teknofest/TÜBİTAK yarışma platformunun yardımcı asistanısın. Kullanıcının kısa açıklamasından bir iletişim formu mesajı yaz. Sadece mesaj metnini döndür — başlık, selamlama veya açıklama ekleme. Türkçe, profesyonel, 3-4 cümle. Maksimum 300 karakter.`,
            messages: [{ role: 'user', content: prompt }]
          })
        });
        const data = await res.json();
        const text = data.content?.map(b => b.text || '').join('').trim() || '';
        if (text) {
          document.getElementById('field-mesaj').value = text;
          updateCharCount(document.getElementById('field-mesaj'));
          showToast('✅ AI mesajı hazırladı!');
        }
      } catch {
        showToast('⚠️ AI bağlantı hatası. Manuel yazabilirsin.');
      }
    }

    /* ════════════════════════════════════════════════════════
       İLAN EKLEME FORMU
    ════════════════════════════════════════════════════════ */
    let ilanTip = 'takim';

    function setIlanTab(tab) {
      ilanTip = tab;
      window._ilanTip = tab;
      ['takim','mentor','ortak'].forEach(t => {
        const btn = document.getElementById('ilan-tab-' + t);
        if (t === tab) {
          btn.style.background = 'var(--primary)';
          btn.style.color = 'white';
        } else {
          btn.style.background = 'transparent';
          btn.style.color = 'var(--text-dim)';
        }
      });
      // Update placeholder contextually
      const placeholders = {
        takim: 'Örn: Teknofest 2026 için Python / ML geliştiricisi aranıyor',
        mentor: 'Örn: TÜBİTAK 2209-B projesi için veri bilimi mentörü aranıyor',
        ortak: 'Örn: Roket tasarımı için Makine Mühendisliği öğrencisi aranıyor',
      };
      document.getElementById('if-baslik').placeholder = placeholders[tab];
    }

    function openIlanForm() {
      document.getElementById('ilan-form-overlay').classList.add('open');
      document.body.style.overflow = 'hidden';
    }
    function closeIlanForm(e) {
      if (e && e.target !== document.getElementById('ilan-form-overlay')) return;
      document.getElementById('ilan-form-overlay').classList.remove('open');
      document.body.style.overflow = '';
    }

    async function fillIlanWithAI() {
      const prompt = window.prompt('İlanı kısaca anlat (Türkçe) — AI senin için açıklama yazsın:');
      if (!prompt || !prompt.trim()) return;
      showToast('✨ AI açıklama hazırlıyor...');
      try {
        const res = await fetch('https://api.anthropic.com/v1/messages', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            model: 'claude-sonnet-4-20250514',
            max_tokens: 1000,
            system: `Sen Quantro Teknofest/TÜBİTAK yarışma platformunun yardımcı asistanısın. Kullanıcının kısa açıklamasından bir ilan metni oluştur. Sadece ilan açıklama paragrafını döndür — başlık veya selamlama ekleme. Türkçe, profesyonel ve ikna edici, 3-5 cümle. Maksimum 350 karakter.`,
            messages: [{ role: 'user', content: prompt }]
          })
        });
        const data = await res.json();
        const text = data.content?.map(b => b.text || '').join('').trim() || '';
        if (text) {
          document.getElementById('if-aciklama').value = text;
          showToast('✅ AI açıklama oluşturdu!');
        }
      } catch {
        showToast('⚠️ AI bağlantı hatası. Manuel yazabilirsin.');
      }
    }

    function submitIlanForm() {
      const baslik   = document.getElementById('if-baslik').value.trim();
      const kategori = document.getElementById('if-kategori').value;
      const sehir    = document.getElementById('if-sehir').value;
      const aciklama = document.getElementById('if-aciklama').value.trim();
      const etiketler= document.getElementById('if-etiketler').value.trim();
      const kisi     = document.getElementById('if-kisi').value.trim() || '1 Kişi';

      if (!baslik || !aciklama) {
        showToast('❗ Lütfen başlık ve açıklamayı doldurun.'); return;
      }

      const badgeMap  = { yeni: 'badge-yeni', acik: 'badge-acik', yakin: 'badge-yakin' };
      const badgeLabel= { yeni: 'Yeni', acik: 'Açık', yakin: 'Son Gün' };
      const sehirMap  = { online:'Uzaktan', adana:'Adana', adiyaman:'Adıyaman', afyonkarahisar:'Afyonkarahisar', agri:'Ağrı', aksaray:'Aksaray', amasya:'Amasya', ankara:'Ankara', antalya:'Antalya', ardahan:'Ardahan', artvin:'Artvin', aydin:'Aydın', balikesir:'Balıkesir', bartin:'Bartın', batman:'Batman', bayburt:'Bayburt', bilecik:'Bilecik', bingol:'Bingöl', bitlis:'Bitlis', bolu:'Bolu', burdur:'Burdur', bursa:'Bursa', canakkale:'Çanakkale', cankiri:'Çankırı', corum:'Çorum', denizli:'Denizli', diyarbakir:'Diyarbakır', duzce:'Düzce', edirne:'Edirne', elazig:'Elazığ', erzincan:'Erzincan', erzurum:'Erzurum', eskisehir:'Eskişehir', gaziantep:'Gaziantep', giresun:'Giresun', gumushane:'Gümüşhane', hakkari:'Hakkari', hatay:'Hatay', igdir:'Iğdır', isparta:'Isparta', istanbul:'İstanbul', izmir:'İzmir', kahramanmaras:'Kahramanmaraş', karabuk:'Karabük', karaman:'Karaman', kars:'Kars', kastamonu:'Kastamonu', kayseri:'Kayseri', kilis:'Kilis', kirikkale:'Kırıkkale', kirklareli:'Kırklareli', kirsehir:'Kırşehir', kocaeli:'Kocaeli', konya:'Konya', kutahya:'Kütahya', malatya:'Malatya', manisa:'Manisa', mardin:'Mardin', mersin:'Mersin', mugla:'Muğla', mus:'Muş', nevsehir:'Nevşehir', nigde:'Niğde', ordu:'Ordu', osmaniye:'Osmaniye', rize:'Rize', sakarya:'Sakarya', samsun:'Samsun', sanliurfa:'Şanlıurfa', siirt:'Siirt', sinop:'Sinop', sirnak:'Şırnak', sivas:'Sivas', tekirdag:'Tekirdağ', tokat:'Tokat', trabzon:'Trabzon', tunceli:'Tunceli', usak:'Uşak', van:'Van', yalova:'Yalova', yozgat:'Yozgat', zonguldak:'Zonguldak' };
      const sehirLabel= sehirMap[sehir] || sehir;

      const tagHTML = etiketler.split(',').map(t => t.trim()).filter(Boolean)
        .map(t => `<span class="ilan-tag">${t}</span>`).join('');

      const tipEmoji = { takim:'👥', mentor:'🎓', ortak:'🤝' }[ilanTip] || '📋';
      const tipLabel = { takim:'Takım Üyesi', mentor:'Mentör', ortak:'Proje Ortağı' }[ilanTip] || '';

      const card = document.createElement('div');
      card.className = 'ilan-card';
      card.style.cursor = 'pointer';
      card.dataset.tags     = `${kategori} ${sehir}`;
      card.dataset.baslik   = baslik;
      card.dataset.aciklama = aciklama;
      card.dataset.sehir    = sehirLabel;
      card.dataset.kisi     = kisi;
      card.dataset.tip      = tipLabel;
      card.dataset.tipEmoji = tipEmoji;
      card.dataset.etiketler= etiketler;
      card.dataset.badge    = badgeLabel[kategori] || 'Yeni';
      card.dataset.badgeClass = badgeMap[kategori] || 'badge-yeni';
      card.dataset.owner    = 'true';
      card.setAttribute('onmousemove', 'tiltCard(event,this)');
      card.setAttribute('onmouseleave', 'resetTilt(this)');
      card.setAttribute('onclick', 'openIlanDetail(this)');
      card.innerHTML = `
        <span class="ilan-badge ${badgeMap[kategori]}">${badgeLabel[kategori]}</span>
        <h4>${baslik}</h4>
        <p>${aciklama}</p>
        <div class="ilan-tags">${tagHTML}</div>
        <div class="ilan-meta">
          <span>📍 ${sehirLabel}</span>
          <span>${tipEmoji} ${kisi}</span>
          <span>🕐 Şimdi yayınlandı</span>
        </div>
        <button class="btn btn-ghost btn-sm" disabled style="cursor:default;opacity:0.55;border-color:rgba(255,255,255,0.1);" onclick="event.stopPropagation()">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/></svg>
          Kendi İlanın
        </button>
        <button class="btn btn-ghost btn-sm" style="color:#f87171;border-color:rgba(239,68,68,0.2);margin-top:0.3rem;" onclick="event.stopPropagation();deleteIlanCard(this)" title="İlanı sil">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="m19 6-.867 14.142A2 2 0 0 1 16.138 22H7.862a2 2 0 0 1-1.995-1.858L5 6m5 0V4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2"/></svg>
          Sil
        </button>
      `;

      const grid = document.getElementById('ilanlar-grid');
      grid.insertBefore(card, grid.firstChild);

      // Hide empty state
      const emptyMsg = document.getElementById('ilanlar-empty-msg');
      if (emptyMsg) emptyMsg.style.display = 'none';

      // Limit'e göre yeniden render et
      renderIlanlarWithLimit();

      // Reset form
      ['if-baslik','if-aciklama','if-etiketler','if-kisi','if-iletisim'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.value = '';
      });

      closeIlanForm();
      showToast(`✅ İlanınız yayınlandı! (${tipLabel})`);

      setTimeout(() => {
        card.scrollIntoView({ behavior: 'smooth', block: 'center' });
        card.style.boxShadow = '0 0 0 2px var(--primary), var(--shadow-3d)';
        setTimeout(() => card.style.boxShadow = '', 2200);
      }, 350);
    }

    /* ESC key closes all modals */
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') {
        closeBasvurModal();
        closeProfilForm();
        closeProfilDetail();
        closeIlanDetail();
        closeGoogleMock();
        closeSettingsModal();
        closeUserDropdown();
        const ilanOverlay = document.getElementById('ilan-form-overlay');
        if (ilanOverlay) { ilanOverlay.classList.remove('open'); }
        document.body.style.overflow = '';
      }
    });

    /* ════════════════════════════════════════════════════════
       AUTH SYSTEM
    ════════════════════════════════════════════════════════ */
    (function() {
      function getUsers() {
        try { return JSON.parse(localStorage.getItem('lb38_users') || '[]'); } catch { return []; }
      }
      function saveUsers(arr) { localStorage.setItem('lb38_users', JSON.stringify(arr)); }
      function getSession() {
        try { return JSON.parse(sessionStorage.getItem('lb38_session') || 'null'); } catch { return null; }
      }
      function saveSession(user) { sessionStorage.setItem('lb38_session', JSON.stringify(user)); }
      window.clearSession = function() { sessionStorage.removeItem('lb38_session'); };

      function showAuthError(msg) {
        const el = document.getElementById('auth-error');
        el.textContent = msg; el.classList.add('show');
        setTimeout(() => el.classList.remove('show'), 3500);
      }

      function enterSite(user) {
        const overlay = document.getElementById('auth-overlay');
        overlay.classList.add('hiding');
        setTimeout(() => { overlay.style.display = 'none'; }, 500);
        const initials = (user.name || 'U').split(' ').map(p => p[0] || '').join('').toUpperCase().slice(0,2) || 'U';
        document.getElementById('nav-user-avatar').textContent = initials;
        const firstName = (user.name || 'Kullanıcı').split(' ')[0];
        document.getElementById('nav-user-name').textContent = firstName;
        document.getElementById('dd-name').textContent = user.name || 'Kullanıcı';
        document.getElementById('dd-email').textContent = user.email || '—';
        showToast('👋 Hoş geldin, ' + firstName + '!');
      }

      // [SUPABASE] Eski localStorage auto-login devre dışı — Supabase Auth kullanılıyor
      // const existingSession = getSession();
      // if (existingSession) {
      //   enterSite(existingSession);
      // }

      window.switchAuthTab = function(tab) {
        document.getElementById('tab-login').classList.toggle('active', tab === 'login');
        document.getElementById('tab-register').classList.toggle('active', tab === 'register');
        document.getElementById('auth-login-form').style.display = tab === 'login' ? 'flex' : 'none';
        document.getElementById('auth-register-form').style.display = tab === 'register' ? 'flex' : 'none';
        document.getElementById('auth-error').classList.remove('show');
      };

      window.doLogin = function() {
        const raw  = document.getElementById('login-username').value.trim();
        const pass = document.getElementById('login-password').value;
        if (!raw || !pass) { showAuthError('Lütfen kullanıcı adı ve şifreyi girin.'); return; }
        const users = getUsers();
        const user  = users.find(u => (u.username === raw || u.email === raw) && u.password === pass);
        if (!user) { showAuthError('Kullanıcı adı/e-posta veya şifre hatalı.'); return; }
        saveSession(user);
        enterSite(user);
      };

      window.doRegister = function() {
        const name  = document.getElementById('reg-name').value.trim();
        const uname = document.getElementById('reg-username').value.trim();
        const email = document.getElementById('reg-email').value.trim();
        const pass  = document.getElementById('reg-password').value;
        const pass2 = document.getElementById('reg-password2').value;
        if (!name || !uname || !email || !pass) { showAuthError('Lütfen tüm alanları doldurun.'); return; }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { showAuthError('Geçerli bir e-posta girin.'); return; }
        if (pass.length < 6) { showAuthError('Şifre en az 6 karakter olmalı.'); return; }
        if (pass !== pass2) { showAuthError('Şifreler eşleşmiyor.'); return; }
        const users = getUsers();
        if (users.find(u => u.username === uname)) { showAuthError('Bu kullanıcı adı zaten alınmış.'); return; }
        if (users.find(u => u.email === email)) { showAuthError('Bu e-posta zaten kayıtlı.'); return; }
        const newUser = { name, username: uname, email, password: pass };
        users.push(newUser);
        saveUsers(users);
        saveSession(newUser);
        enterSite(newUser);
      };

      // ── Helper: avatar color from email
      function gacAvatarColor(email) {
        const colors = ['#4285F4','#EA4335','#34A853','#FBBC05','#9C27B0','#FF5722','#009688','#3F51B5'];
        let h = 0; for (let i = 0; i < email.length; i++) h = (h * 31 + email.charCodeAt(i)) & 0xffffffff;
        return colors[Math.abs(h) % colors.length];
      }
      function gacInitials(name) {
        const p = name.trim().split(/\s+/);
        return p.length >= 2 ? (p[0][0] + p[p.length-1][0]).toUpperCase() : name.slice(0,2).toUpperCase();
      }

      // ── Open Google Login: show account chooser if saved accounts exist
      window.doGoogleLogin = function() {
        // Reset all steps
        document.getElementById('google-step-0').style.display = '';
        document.getElementById('google-step-1').style.display = 'none';
        document.getElementById('google-step-2').style.display = 'none';
        document.getElementById('google-email-input').value = '';
        document.getElementById('google-pass-input').value = '';
        var e1 = document.getElementById('google-error-1');
        var e2 = document.getElementById('google-error-2');
        if (e1) e1.classList.remove('show');
        if (e2) e2.classList.remove('show');

        // Build saved accounts list
        const users = getUsers().filter(u => u.google || u.email);
        const listEl = document.getElementById('gac-accounts-list');
        if (users.length === 0) {
          // No saved accounts → go straight to email step
          document.getElementById('google-step-0').style.display = 'none';
          document.getElementById('google-step-1').style.display = '';
          setTimeout(() => document.getElementById('google-email-input').focus(), 200);
        } else {
          let html = '';
          users.slice(0, 5).forEach((u, i) => {
            const color = gacAvatarColor(u.email);
            const initials = gacInitials(u.name || u.email.split('@')[0]);
            const isSignedIn = getSession() && getSession().email === u.email;
            html += `<div class="gac-account-row" onclick="gacSelectAccount('${u.email}')">
              <div class="gac-avatar" style="background:${color}">${initials}</div>
              <div class="gac-account-info">
                <div class="gac-account-name">${u.name || u.email.split('@')[0]}</div>
                <div class="gac-account-email">${u.email}</div>
              </div>
              ${isSignedIn ? '<span class="gac-account-badge">Oturum açık</span>' : '<span class="gac-account-badge">Oturum kapalı</span>'}
            </div>`;
          });
          listEl.innerHTML = html;
        }

        document.getElementById('google-mock-overlay').classList.add('open');
      };

      // ── Select a saved account → go to password step directly
      window.gacSelectAccount = function(email) {
        document.getElementById('google-email-input').value = email;
        document.getElementById('google-chip-email').textContent = email;
        // Set chip avatar
        const users = getUsers();
        const u = users.find(x => x.email === email);
        const chipAv = document.getElementById('gac-chip-avatar');
        if (chipAv && u) {
          chipAv.style.background = gacAvatarColor(email);
          chipAv.textContent = gacInitials(u.name || email.split('@')[0]);
        }
        // Subtitle
        const subEl = document.getElementById('google-mock-sub-2');
        if (subEl) subEl.textContent = 'Bu hesaba ait şifrenizi girin.';
        // Show password step
        document.getElementById('google-step-0').style.display = 'none';
        document.getElementById('google-step-2').style.display = '';
        document.getElementById('google-error-2').classList.remove('show');
        setTimeout(() => document.getElementById('google-pass-input').focus(), 100);
      };

      // ── "Use another account" → email input step
      window.googleShowEmailStep = function() {
        document.getElementById('google-step-0').style.display = 'none';
        document.getElementById('google-step-1').style.display = '';
        document.getElementById('google-error-1').classList.remove('show');
        setTimeout(() => document.getElementById('google-email-input').focus(), 100);
      };

      // ── Step 1 → Step 2 (email → password)
      window.googleNextStep = function() {
        const email = document.getElementById('google-email-input').value.trim();
        const errEl = document.getElementById('google-error-1');
        if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
          errEl.textContent = 'Lütfen geçerli bir e-posta adresi girin.';
          errEl.classList.add('show');
          return;
        }
        errEl.classList.remove('show');
        document.getElementById('google-chip-email').textContent = email;

        // Chip avatar
        const chipAv = document.getElementById('gac-chip-avatar');
        if (chipAv) {
          chipAv.style.background = gacAvatarColor(email);
          chipAv.textContent = email.slice(0,2).toUpperCase();
        }

        // Subtitle based on registration status
        const users = getUsers();
        const isRegistered = users.some(u => u.email === email);
        const subEl = document.getElementById('google-mock-sub-2');
        if (subEl) {
          subEl.textContent = isRegistered
            ? 'Bu hesaba ait şifrenizi girin.'
            : 'Bu Gmail ile ilk girişiniz. Kullanmak istediğiniz şifreyi belirleyin (en az 6 karakter).';
        }

        document.getElementById('google-step-1').style.display = 'none';
        document.getElementById('google-step-2').style.display = '';
        document.getElementById('google-error-2').classList.remove('show');
        setTimeout(() => document.getElementById('google-pass-input').focus(), 100);
      };

      // ── Step 2 → back
      window.googleBackStep = function() {
        document.getElementById('google-step-2').style.display = 'none';
        document.getElementById('google-error-2').classList.remove('show');
        // Go back to chooser if there are accounts, else email step
        const users = getUsers().filter(u => u.google || u.email);
        if (users.length > 0) {
          document.getElementById('google-step-0').style.display = '';
        } else {
          document.getElementById('google-step-1').style.display = '';
          setTimeout(() => document.getElementById('google-email-input').focus(), 100);
        }
      };

      // ── Toggle password visibility
      window.toggleGacPw = function() {
        const inp = document.getElementById('google-pass-input');
        const icon = document.getElementById('gac-eye-icon');
        if (inp.type === 'password') {
          inp.type = 'text';
          icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>';
        } else {
          inp.type = 'password';
          icon.innerHTML = '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/>';
        }
      };

      window.confirmGoogleLogin = function() {
        const email = document.getElementById('google-email-input').value.trim();
        const pass  = document.getElementById('google-pass-input').value;
        const errEl = document.getElementById('google-error-2');

        if (!pass || pass.length < 1) {
          errEl.textContent = 'Lütfen şifrenizi girin.';
          errEl.classList.add('show');
          return;
        }
        if (pass.length < 6) {
          errEl.textContent = 'Şifre en az 6 karakter olmalıdır.';
          errEl.classList.add('show');
          return;
        }

        const users = getUsers();
        const existingUser = users.find(u => u.email === email);

        if (existingUser) {
          if (existingUser.password !== pass) {
            errEl.textContent = 'Hatalı şifre. Lütfen bu Gmail hesabına ait şifreyi girin.';
            errEl.classList.add('show');
            return;
          }
          errEl.classList.remove('show');
          closeGoogleMock();
          saveSession(existingUser);
          const overlay = document.getElementById('auth-overlay');
          if (overlay.style.display !== 'none') {
            overlay.classList.add('hiding');
            setTimeout(() => { overlay.style.display = 'none'; }, 500);
          }
          enterSite(existingUser);
        } else {
          errEl.classList.remove('show');
          closeGoogleMock();
          const namePart = email.split('@')[0];
          const name = namePart.charAt(0).toUpperCase() + namePart.slice(1).replace(/[._]/g, ' ');
          const newUser = {
            name,
            username: namePart.replace(/[^a-zA-Z0-9]/g, ''),
            email,
            password: pass,
            google: true
          };
          users.push(newUser);
          saveUsers(users);
          saveSession(newUser);
          const overlay = document.getElementById('auth-overlay');
          if (overlay.style.display !== 'none') {
            overlay.classList.add('hiding');
            setTimeout(() => { overlay.style.display = 'none'; }, 500);
          }
          showToast('✅ Google hesabı ile kayıt tamamlandı!');
          enterSite(newUser);
        }
      };

      window.closeGoogleMock = function() {
        document.getElementById('google-mock-overlay').classList.remove('open');
      };

      window.doLogout = function() {
        if (!confirm('Çıkış yapmak istiyor musun?')) return;
        clearSession();
        const overlay = document.getElementById('auth-overlay');
        overlay.style.display = 'flex';
        overlay.classList.remove('hiding');
        document.getElementById('login-username').value = '';
        document.getElementById('login-password').value = '';
        showToast('👋 Çıkış yapıldı.');
      };
    })();

    /* ════════════════════════════════════════════════════════
       NAV USER DROPDOWN
    ════════════════════════════════════════════════════════ */
    function toggleUserDropdown() {
      const dd = document.getElementById('nav-user-dropdown');
      const chevron = document.getElementById('nav-chevron');
      const isOpen = dd.classList.contains('open');
      if (isOpen) {
        dd.classList.remove('open');
        chevron.style.transform = 'rotate(0deg)';
      } else {
        dd.classList.add('open');
        chevron.style.transform = 'rotate(180deg)';
      }
    }

    function closeUserDropdown() {
      document.getElementById('nav-user-dropdown').classList.remove('open');
      document.getElementById('nav-chevron').style.transform = 'rotate(0deg)';
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
      const wrap = document.getElementById('nav-user-wrap');
      if (wrap && !wrap.contains(e.target)) {
        closeUserDropdown();
      }
    });

    /* ════════════════════════════════════════════════════════
       AYARLAR MODAL
    ════════════════════════════════════════════════════════ */
    function openSettingsModal() {
      document.getElementById('settings-overlay').classList.add('open');
      document.body.style.overflow = 'hidden';
    }
    function closeSettingsModal() {
      document.getElementById('settings-overlay').classList.remove('open');
      document.body.style.overflow = '';
    }
    function toggleCursorSetting(btn) {
      btn.classList.toggle('on');
      const on = btn.classList.contains('on');
      const cur  = document.getElementById('v-cursor');
      const ring = document.getElementById('v-cursor-ring');
      if (cur)  cur.style.display  = on ? '' : 'none';
      if (ring) ring.style.display = on ? '' : 'none';
    }
    function toggleParticleSetting(btn) {
      btn.classList.toggle('on');
      const on = btn.classList.contains('on');
      const canvas = document.getElementById('v-bg-canvas');
      if (canvas) canvas.style.opacity = on ? '.65' : '0';
    }
    function qtAyarlarOku() {
      try { return JSON.parse(localStorage.getItem('quantro-ayarlar') || '{}'); } catch (e) { return {}; }
    }
    function qtAyarYaz(id, on) {
      const a = qtAyarlarOku(); a[id] = on;
      localStorage.setItem('quantro-ayarlar', JSON.stringify(a));
    }
    function uygulaAyarlar() {
      const a = qtAyarlarOku();
      ['n-yarisma', 'n-ilan', 'n-davet', 'cursor-toggle', 'particle-toggle'].forEach(id => {
        const el = document.getElementById(id);
        if (el && a[id] !== undefined) el.classList.toggle('on', !!a[id]);
      });
      const cur = document.getElementById('v-cursor');
      const ring = document.getElementById('v-cursor-ring');
      if (a['cursor-toggle'] === false) { if (cur) cur.style.display = 'none'; if (ring) ring.style.display = 'none'; }
      const canvas = document.getElementById('v-bg-canvas');
      if (canvas && a['particle-toggle'] === false) canvas.style.opacity = '0';
    }
    function toggleAyar(id) {
      const el = document.getElementById(id);
      if (!el) return;
      el.classList.toggle('on');
      qtAyarYaz(id, el.classList.contains('on'));
      if (id === 'cursor-toggle' || id === 'particle-toggle') {
        const cur = document.getElementById('v-cursor');
        const ring = document.getElementById('v-cursor-ring');
        const canvas = document.getElementById('v-bg-canvas');
        const on = el.classList.contains('on');
        if (id === 'cursor-toggle') { if (cur) cur.style.display = on ? '' : 'none'; if (ring) ring.style.display = on ? '' : 'none'; }
        if (id === 'particle-toggle' && canvas) canvas.style.opacity = on ? '.65' : '0';
      }
    }
    function kaydetAyarlar() {
      ['n-yarisma', 'n-ilan', 'n-davet', 'cursor-toggle', 'particle-toggle'].forEach(id => {
        const el = document.getElementById(id);
        if (el) qtAyarYaz(id, el.classList.contains('on'));
      });
      uygulaAyarlar();
      closeSettingsModal();
      showToast('✅ Ayarlar kaydedildi!');
    }
    uygulaAyarlar();
  </script>
