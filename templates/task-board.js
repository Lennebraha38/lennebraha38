// ============================================
// Quantro — Gorev & Ekip Yonetim Sistemi
// Trello tarzi Kanban Board + Ekip Olusturma
// Supabase Realtime entegrasyonlu
// ============================================

// Kanban board state
let currentEkipFilter = null;
let allGorevler = [];
let allEkipler = [];
let gorevEkipMap = {};
let allUyeler = {};          // ekip_id -> [{kullanici_email, rol}]
let currentUserEmail = null; // oturumdaki kullanicinin e-postasi
let pendingDavetToken = null;

// XSS korumasi: kullanici verisini guvenli hale getir
function escapeHtml(str) {
  return String(str == null ? '' : str)
    .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
}

const EKIP_EMOJILER = {
  'genel': '👥', 'teknofest': '🚀', 'tubitak': '🔬',
  'yazilim': '💻', 'siber': '🔐', 'tasarim': '🎨'
};
const ekipEmoji = (k) => EKIP_EMOJILER[k] || '👥';

// ===== EKIP CRUD =====
async function loadEkipler() {
  const session = (await supabase.auth.getSession()).data.session;
  if (!session) {
    allEkipler = []; allUyeler = {};
    renderEkipList(); renderEkipFilter();
    return;
  }
  currentUserEmail = session.user.email;
  allEkipler = []; allUyeler = {};

  const { data, error } = await supabase.from('ekipler').select('*').order('id', { ascending: false });
  if (error) { console.error(error.message); return; }
  allEkipler = data || [];

  const ekipIds = allEkipler.map(e => e.id);
  if (ekipIds.length) {
    const { data: uyeler } = await supabase.from('ekip_uyeleri')
      .select('ekip_id, kullanici_email, rol')
      .in('ekip_id', ekipIds);
    (uyeler || []).forEach(u => {
      if (!allUyeler[u.ekip_id]) allUyeler[u.ekip_id] = [];
      allUyeler[u.ekip_id].push(u);
    });
  }

  renderEkipList();
  renderEkipFilter();
}

const isEkipLider = (e) => currentUserEmail && e.olusturan_email && e.olusturan_email.toLowerCase() === currentUserEmail.toLowerCase();

function renderEkipList() {
  const grid = document.getElementById('ekip-grid');
  if (!grid) return;

  if (!currentUserEmail) {
    grid.innerHTML = '<div style="grid-column:1/-1;text-align:center;color:var(--text-dim);padding:2rem;">Görev ve ekip yönetimi için giriş yapmalısın. 👆</div>';
    return;
  }

  if (allEkipler.length === 0) {
    grid.innerHTML = '<div style="grid-column:1/-1;text-align:center;color:var(--text-dim);padding:2rem;">Henüz ekip oluşturmadın. İlk ekibi sen kur, üyeleri e-posta ile davet et!</div>';
    return;
  }

  grid.innerHTML = allEkipler.map(e => {
    const uyeler = allUyeler[e.id] || [];
    const liderRozeti = isEkipLider(e) ? ' <span class="ekip-lider-badge" title="Takım lideri">👑</span>' : '';
    const uyeCipleri = [
      `<span class="ekip-uye-chip lider-chip" title="${escapeHtml(e.olusturan_email)}">${escapeHtml((e.olusturan_email || 'Lider').substring(0, 2).toUpperCase())}</span>`,
      ...uyeler.slice(0, 2).map(u => `<span class="ekip-uye-chip" title="${escapeHtml(u.kullanici_email)}">${escapeHtml(u.kullanici_email.substring(0, 2).toUpperCase())}</span>`)
    ];
    if (uyeler.length > 2) uyeCipleri.push(`<span class="ekip-uye-chip">+${uyeler.length - 2}</span>`);
    return `
    <div class="ekip-card" onclick="openEkipDetail(${e.id})">
      <div class="ekip-card-header">
        <span class="ekip-emoji">${ekipEmoji(e.kategori)}</span>
        <span class="ekip-badge">${escapeHtml(e.durum || 'Açık')}</span>
      </div>
      <h4>${escapeHtml(e.isim)}${liderRozeti}</h4>
      <p>${escapeHtml((e.aciklama || '').substring(0, 80))}</p>
      <div class="ekip-meta">
        <span>${1 + uyeler.length}/${e.max_uye || 10} üye</span>
        <span>${escapeHtml(e.kategori || 'Genel')}</span>
      </div>
      <div class="ekip-uye-list">${uyeCipleri.join('')}</div>
      <div style="margin-top:0.8rem;display:flex;gap:0.5rem;">
        ${isEkipLider(e) ? `<button class="btn btn-primary btn-sm" onclick="event.stopPropagation();openDavetModal(${e.id})" style="flex:1">✉️ Davet Et</button>` : '<button class="btn btn-ghost btn-sm" onclick="event.stopPropagation();openEkipDetail(' + e.id + ')" style="flex:1">Detay</button>'}
        <button class="btn btn-ghost btn-sm" onclick="event.stopPropagation();filterByEkip(${e.id})" style="flex:1">Görevler</button>
      </div>
    </div>
  `;
  }).join('');
}

function openEkipDetail(ekipId) {
  const e = allEkipler.find(x => x.id === ekipId);
  if (!e) return;
  const modal = document.getElementById('ekip-detay-modal');
  const content = document.getElementById('ekip-detay-content');
  if (!modal || !content) return;

  const uyeler = allUyeler[e.id] || [];
  const lider = isEkipLider(e);

  content.innerHTML = `
    <div class="gd-header">
      <h3>${ekipEmoji(e.kategori)} ${escapeHtml(e.isim)} ${lider ? '👑' : ''}</h3>
      <span class="ekip-badge">${escapeHtml(e.durum || 'Açık')}</span>
    </div>
    <div class="gd-meta">
      <span>${escapeHtml(e.kategori || 'Genel')}</span>
      <span>${1 + uyeler.length}/${e.max_uye || 10} üye</span>
      <span>${escapeHtml(e.olusturan_email || '')}</span>
    </div>
    <div class="gd-aciklama">${escapeHtml(e.aciklama) || '<em>Açıklama yok</em>'}</div>
    <div style="margin:1rem 0 0.5rem;font-size:0.8rem;font-weight:700;color:var(--text-dim);">ÜYELER</div>
    <div class="ekip-detay-uyeler">
      <div class="ekip-detay-uye"><span class="ekip-avatar">👑</span><span>${escapeHtml(e.olusturan_email)}</span><span class="ekip-rol">Lider</span></div>
      ${uyeler.map(u => `
        <div class="ekip-detay-uye"><span class="ekip-avatar">${escapeHtml(u.kullanici_email.substring(0, 2).toUpperCase())}</span><span>${escapeHtml(u.kullanici_email)}</span><span class="ekip-rol">Üye</span></div>
      `).join('')}
      ${uyeler.length === 0 ? '<div style="color:var(--text-dim);font-size:0.85rem;">Henüz üye yok. Üyeleri davet etmeye başla!</div>' : ''}
    </div>
    ${lider ? '<div style="margin:1rem 0 0.5rem;font-size:0.8rem;font-weight:700;color:var(--text-dim);" id="davetler-baslik">BEKLEYEN DAVETLER</div><div id="ekip-davetler-listesi" style="display:flex;flex-direction:column;gap:0.4rem;margin-bottom:1rem;"><div style="color:var(--text-dim);font-size:0.85rem;">Yükleniyor...</div></div>' : ''}
    <div class="gd-actions">
      ${lider ? `<button class="btn btn-primary" style="flex:1" onclick="closeModal('ekip-detay-modal');openDavetModal(${e.id})">✉️ Üye Davet Et</button>` : ''}
      <button class="btn btn-ghost" style="flex:1" onclick="filterByEkip(${e.id});closeModal('ekip-detay-modal')">Görevleri Gör</button>
    </div>
  `;
  modal.classList.add('open');
  if (lider) renderEkipDavetleri(e.id);
}

async function renderEkipDavetleri(ekipId) {
  const liste = document.getElementById('ekip-davetler-listesi');
  const baslik = document.getElementById('davetler-baslik');
  if (!liste) return;
  const { data, error } = await supabase.from('ekip_davetleri')
    .select('email, durum, token')
    .eq('ekip_id', ekipId)
    .order('olusturulma_tarihi', { ascending: false });
  if (error) { liste.innerHTML = '<div style="color:var(--text-dim);font-size:0.85rem;">Davetler yüklenemedi.</div>'; return; }
  const bekleyen = (data || []).filter(d => d.durum === 'bekliyor');
  if (!bekleyen.length) { liste.innerHTML = '<div style="color:var(--text-dim);font-size:0.85rem;">Bekleyen davet yok.</div>'; if (baslik) baslik.style.display = 'none'; return; }
  if (baslik) baslik.style.display = '';
  liste.innerHTML = bekleyen.map(d => `
    <div class="ekip-detay-uye">
      <span class="ekip-avatar">✉️</span>
      <span style="flex:1">${escapeHtml(d.email)}</span>
      <span class="ekip-rol">Bekliyor</span>
      <button class="btn btn-ghost btn-sm" title="Linki kopyala" onclick="event.stopPropagation();kopyalaDavetLinkiBasit('${window.location.origin + window.location.pathname}?davet=${d.token}')">📋</button>
    </div>
  `).join('');
}

function kopyalaDavetLinkiBasit(link) {
  const done = () => showToast('📋 Davet linki kopyalandı!');
  if (navigator.clipboard?.writeText) navigator.clipboard.writeText(link).then(done).catch(() => fallbackCopy(link, done));
  else fallbackCopy(link, done);
}

function openDavetModal(ekipId) {
  const modal = document.getElementById('ekip-davet-modal');
  if (!modal) return;
  const davetEkipId = document.getElementById('davet-ekip-id');
  if (davetEkipId) davetEkipId.value = ekipId;
  const input = document.getElementById('davet-email');
  if (input) input.value = '';
  const form = document.getElementById('davet-form');
  const sonuc = document.getElementById('davet-sonuc');
  if (form) form.style.display = '';
  if (sonuc) sonuc.style.display = 'none';
  modal.classList.add('open');
}

// ===== OTOMATIK EPOSTA (EmailJS) =====
// EmailJS (emailjs.com) ucretsiz: 200 e-posta/ay. Kurulum:
// 1) emailjs.com -> hesap ac -> Email Services -> Gmail bagla -> Service ID
// 2) Email Templates -> yeni sablon: To Email: {{to_email}}, Subject: "[Quantro] {{takim_adi}} takimina davet edildin 🚀",
//    Icerik: "Merhaba {{to_name}},\n\n\"{{takim_adi}}\" takimina davet edildin!\n\nEkibe katilmak icin tikla: {{davet_linki}}\n\n— {{davet_eden}}"
// 3) Account -> API Keys -> Public Key
const EMAILJS_SERVICE_ID = '';
const EMAILJS_TEMPLATE_ID = '';
const EMAILJS_PUBLIC_KEY = '';

let davetMailtoUrl = null;
let sonGonderimEmail = null;

function kopyalaDavetLinki() {
  const link = document.getElementById('davet-link')?.value;
  if (!link) return;
  const done = () => showToast('📋 Davet linki kopyalandı!');
  if (navigator.clipboard?.writeText) {
    navigator.clipboard.writeText(link).then(done).catch(() => fallbackCopy(link, done));
  } else fallbackCopy(link, done);
}
function fallbackCopy(text, done) {
  const ta = document.createElement('textarea');
  ta.value = text;
  ta.style.position = 'fixed'; ta.style.opacity = '0';
  document.body.appendChild(ta);
  ta.select();
  try { document.execCommand('copy'); } catch (e) {}
  ta.remove();
  done();
}
function acMailto() {
  if (davetMailtoUrl) window.open(davetMailtoUrl, '_blank');
}
function yeniDavet() {
  const form = document.getElementById('davet-form');
  const sonuc = document.getElementById('davet-sonuc');
  const input = document.getElementById('davet-email');
  if (form) form.style.display = '';
  if (sonuc) sonuc.style.display = 'none';
  if (input) { input.value = ''; input.focus(); }
}

async function sendDavet() {
  const ekipId = parseInt(document.getElementById('davet-ekip-id')?.value);
  const email = document.getElementById('davet-email')?.value?.trim();
  const ekip = allEkipler.find(e => e.id === ekipId);
  if (!ekip) { showToast('Ekip bulunamadı!'); return; }
  if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { showToast('Geçerli bir e-posta girin!'); return; }

  const session = (await supabase.auth.getSession()).data.session;
  if (!session) { showToast('Önce giriş yap!'); return; }
  if (!isEkipLider(ekip)) { showToast('Sadece takım lideri davet gönderebilir!'); return; }

  const uyeler = allUyeler[ekipId] || [];
  if (1 + uyeler.length >= ekip.max_uye) { showToast('Ekip kontenjanı dolu!'); return; }
  if (ekip.olusturan_email?.toLowerCase() === email.toLowerCase() || uyeler.some(u => u.kullanici_email?.toLowerCase() === email.toLowerCase())) {
    showToast('Bu kişi zaten ekibin üyesi!'); return;
  }

  const token = (crypto.randomUUID ? crypto.randomUUID() : Date.now() + '-' + Math.random().toString(36).slice(2));
  const davet = { ekip_id: ekipId, email, token, davet_eden_email: session.user.email, durum: 'bekliyor' };

  const { error } = await supabase.from('ekip_davetleri').insert(davet);
  if (error) {
    if (error.code === '23505') {
      const { data: eski, error: selErr } = await supabase.from('ekip_davetleri')
        .select('id').eq('ekip_id', ekipId).eq('email', email).single();
      if (selErr || !eski) { showToast('Davet oluşturulamadı!'); return; }
      const { error: upErr } = await supabase.from('ekip_davetleri')
        .update({ token, durum: 'bekliyor' }).eq('id', eski.id);
      if (upErr) { console.error(upErr.message); showToast('Davet oluşturulamadı!'); return; }
    } else { console.error(error.message); showToast('Davet oluşturulamadı!'); return; }
  }

  const link = window.location.origin + window.location.pathname + '?davet=' + token;
  const subject = encodeURIComponent(`[Quantro] "${ekip.isim}" takımına davet edildin 🚀`);
  const body = encodeURIComponent(
    `Merhaba,\n\n"${ekip.isim}" takımına davet edildin!\n\nEkibe katılmak için aşağıdaki linke tıkla:\n${link}\n\nBu link sadece senin e-postan için geçerlidir.\n\n— ${session.user.email}`
  );
  davetMailtoUrl = `mailto:${email}?subject=${subject}&body=${body}`;
  sonGonderimEmail = email;

  // Otomatik e-posta (EmailJS) — basarisiz olursa link/kopyala ekranina dus
  let otomatikGitti = false;
  try {
    if (EMAILJS_SERVICE_ID && EMAILJS_TEMPLATE_ID && EMAILJS_PUBLIC_KEY && window.emailjs) {
      emailjs.init({ publicKey: EMAILJS_PUBLIC_KEY });
      await emailjs.send(EMAILJS_SERVICE_ID, EMAILJS_TEMPLATE_ID, {
        to_email: email,
        to_name: email.split('@')[0],
        takim_adi: ekip.isim,
        davet_eden: session.user.email,
        davet_linki: link
      });
      otomatikGitti = true;
    }
  } catch (e) { console.error('Otomatik e-posta gönderilemedi:', e); }

  // Sonuc ekranini goster
  const form = document.getElementById('davet-form');
  const sonuc = document.getElementById('davet-sonuc');
  const linkEl = document.getElementById('davet-link');
  const durumEl = document.getElementById('davet-durum-msg');
  if (form) form.style.display = 'none';
  if (sonuc) sonuc.style.display = 'block';
  if (linkEl) linkEl.value = link;
  if (durumEl) {
    durumEl.textContent = otomatikGitti
      ? `📧 Davet e-postası ${email} adresine gönderildi!`
      : (EMAILJS_SERVICE_ID ? '⚠️ E-posta gönderilemedi — linki kopyalayıp elle gönder.' : 'Davet hazır — linki kopyalayıp gönder (otomatik e-posta için EmailJS kurulumu gerekli).');
  }

  showToast(otomatikGitti ? '📧 Davet e-postası gönderildi!' : 'Davet oluşturuldu — linki üyene gönder!');
}

// ===== DAVET KABUL AKISI =====
async function handleDavetLink() {
  const params = new URLSearchParams(window.location.search);
  const token = params.get('davet');
  if (!token) return;
  pendingDavetToken = token;
  history.replaceState(null, '', window.location.pathname);

  const session = (await supabase.auth.getSession()).data.session;
  if (!session) {
    showToast('Bu daveti kabul etmek için önce giriş yapmalısın!');
    showAuthOverlay();
    return;
  }
  await showDavetKabulModal(token);
}

async function showDavetKabulModal(token) {
  const { data: davet, error } = await supabase.from('ekip_davetleri')
    .select('*, ekipler(isim)').eq('token', token).single();
  if (error || !davet) { showToast('Davet bulunamadı, süresi doldu veya başka bir e-postaya ait.'); pendingDavetToken = null; return; }

  const modal = document.getElementById('davet-kabul-modal');
  const content = document.getElementById('davet-kabul-content');
  if (!modal || !content) return;
  content.innerHTML = `
    <div style="text-align:center;padding:0.5rem 0;">
      <div style="font-size:2.5rem;margin-bottom:0.5rem;">🤝</div>
      <h3 style="font-size:1.1rem;font-weight:800;margin-bottom:0.5rem;">${escapeHtml(davet.ekipler?.isim || 'Takım')} takımına davetlisin!</h3>
      <p style="color:var(--text-dim);font-size:0.9rem;">${escapeHtml(davet.davet_eden_email || 'Takım lideri')} seni ekibine davet etti. Kabul ederek ${escapeHtml(davet.ekipler?.isim || '')} panosundaki görevleri görebilirsin.</p>
      <p style="color:var(--text-dim);font-size:0.8rem;margin-top:0.5rem;">Davet: <strong>${escapeHtml(davet.email)}</strong> — giriş yaptığın hesabın e-postasıyla aynı olmalı.</p>
    </div>
  `;
  modal.classList.add('open');
  showToast('Davetin geldi! Kabul ediyor musun?');
}

async function acceptDavet() {
  if (!pendingDavetToken) return;
  const token = pendingDavetToken;

  const session = (await supabase.auth.getSession()).data.session;
  if (!session) { showToast('Önce giriş yapmalısın!'); showAuthOverlay(); return; }

  try {
    const { data, error } = await supabase.rpc('ekip_daveti_kabul', { p_token: token });
    if (error) throw error;
    pendingDavetToken = null;
    closeModal('davet-kabul-modal');
    showToast(data === 'zaten_uye' ? 'Zaten bu ekiptesin!' : '🎉 Takıma katıldın!');
    await loadEkipler();
    await loadGorevler(currentEkipFilter);
  } catch (err) {
    const msg = err.message || '';
    if (msg.includes('DAVET_BULUNAMADI')) showToast('Davet bulunamadı veya süresi doldu.');
    else if (msg.includes('EPOSTA_ESLESMIYOR')) showToast('Bu davet, giriş yaptığın e-postayla eşleşmiyor! Davet edilen adresle giriş yap.');
    else if (msg.includes('EKIP_DOLU')) showToast('Ekip kontenjanı dolu, katılamazsın.');
    else { console.error(err); showToast('Davet kabul edilemedi!'); }
  }
}

function declineDavet() {
  pendingDavetToken = null;
  closeModal('davet-kabul-modal');
  showToast('Davet reddedildi.');
}

function showAuthOverlay() {
  const overlay = document.getElementById('auth-overlay');
  if (overlay) {
    overlay.style.display = 'flex';
    overlay.classList.remove('hiding');
    const tab = document.getElementById('tab-login');
    if (tab && typeof switchAuthTab === 'function') switchAuthTab('login');
  } else {
    window.location.href = 'index.html';
  }
}

function renderEkipFilter() {
  const sel = document.getElementById('gorev-ekip-filter');
  if (sel) {
    sel.innerHTML = '<option value="">Tüm Ekipler</option>' +
      allEkipler.map(e => `<option value="${e.id}">${escapeHtml(e.isim)}</option>`).join('');
  }
  const sel2 = document.getElementById('gorev-ekip-select');
  if (sel2) {
    sel2.innerHTML = '<option value="">Ekip seç (opsiyonel)</option>' +
      allEkipler.map(e => `<option value="${e.id}">${escapeHtml(e.isim)}</option>`).join('');
  }
}

async function createEkip() {
  const isim = document.getElementById('ekip-isim')?.value?.trim();
  const aciklama = document.getElementById('ekip-aciklama')?.value?.trim();
  const kategori = document.getElementById('ekip-kategori')?.value;
  const maxUye = parseInt(document.getElementById('ekip-max')?.value || '10');

  if (!isim) { showToast('Ekip ismi zorunlu!'); return; }

  const session = (await supabase.auth.getSession()).data.session;
  if (!session) { showToast('Önce giriş yapmalısın!'); return; }

  const { error } = await supabase.from('ekipler').insert({
    isim, aciklama, kategori,
    olusturan_email: session.user.email,
    olusturan_id: session.user.id,
    max_uye: maxUye,
    uye_sayisi: 1,
    durum: 'Açık'
  });

  if (error) { console.error(error.message); showToast('Ekip oluşturulamadı!'); return; }

  document.getElementById('ekip-isim').value = '';
  document.getElementById('ekip-aciklama').value = '';
  closeModal('ekip-form-modal');
  await loadEkipler();
  showToast('Ekip oluşturuldu!');
}

async function joinEkip(ekipId) {
  showToast('Ekiplere katılım artık davet ile. Liderden davet linki iste!');
}

// ===== GOREV CRUD =====
async function loadGorevler(ekipId) {
  let query = supabase.from('gorevler').select('*').order('sira', { ascending: true });
  if (ekipId) query = query.eq('ekip_id', ekipId);
  const { data, error } = await query;

  if (error) { console.error(error.message); return; }
  allGorevler = data || [];
  renderKanbanBoard();
}

function renderKanbanBoard() {
  const columns = {
    'yapilacak': { title: 'Yapilacak', id: 'col-yapilacak' },
    'devam': { title: 'Devam Ediyor', id: 'col-devam' },
    'kontrol': { title: 'Kontrolde', id: 'col-kontrol' },
    'tamamlandi': { title: 'Tamamlandi', id: 'col-tamamlandi' }
  };

  Object.entries(columns).forEach(([durum, col]) => {
    const el = document.getElementById(col.id);
    if (!el) return;
    const gorevler = allGorevler.filter(g => g.durum === durum);
    const countEl = document.getElementById('count-' + durum);
    if (countEl) countEl.textContent = gorevler.length;
    el.innerHTML = gorevler.map(g => `
      <div class="gorev-card" draggable="true" data-id="${g.id}"
           ondragstart="dragStart(event)" ondragend="dragEnd(event)"
           onclick="openGorevDetail(${g.id})">
        <div class="gorev-card-header">
          <span class="gorev-oncelik oncelik-${g.oncelik || 'orta'}">${oncelikEmoji(g.oncelik)} ${oncelikText(g.oncelik)}</span>
          ${g.son_tarih ? `<span class="gorev-tarih">${new Date(g.son_tarih).toLocaleDateString('tr-TR')}</span>` : ''}
        </div>
        <h5>${escapeHtml(g.baslik)}</h5>
        ${g.aciklama ? `<p>${escapeHtml(g.aciklama.substring(0, 100))}</p>` : ''}
        <div class="gorev-card-footer">
          <div class="gorev-etiketler">
            ${(g.etiketler || '').split(',').filter(Boolean).map(t => `<span class="gorev-etiket">${escapeHtml(t.trim())}</span>`).join('')}
          </div>
          ${g.atanan_email ? `<span class="gorev-avatar" title="${escapeHtml(g.atanan_email)}">${escapeHtml(g.atanan_email.substring(0,2).toUpperCase())}</span>` : ''}
        </div>
      </div>
    `).join('');
    el.innerHTML += `<div class="gorev-count">${gorevler.length} görev</div>`;
  });
}

function oncelikEmoji(p) { return { acil: '🚨', yuksek: '🔴', orta: '🟡', dusuk: '🟢' }[p] || '🟡'; }
function oncelikText(p) { return { acil: 'Acil', yuksek: 'Yüksek', orta: 'Orta', dusuk: 'Düşük' }[p] || 'Orta'; }

// Drag & Drop
function dragStart(e) {
  e.dataTransfer.setData('text/plain', e.target.closest('.gorev-card')?.dataset?.id || '');
  e.target.closest('.gorev-card')?.classList.add('dragging');
}
function dragEnd(e) {
  e.target.closest('.gorev-card')?.classList.remove('dragging');
}

async function allowDrop(e) {
  e.preventDefault();
  const col = e.target.closest('.kanban-col');
  if (col) col.classList.add('drag-over');
}
function leaveDrop(e) {
  const col = e.target.closest('.kanban-col');
  if (col) col.classList.remove('drag-over');
}
async function dropGorev(e) {
  e.preventDefault();
  const col = e.target.closest('.kanban-col');
  if (col) col.classList.remove('drag-over');
  const gorevId = e.dataTransfer.getData('text/plain');
  const newDurum = col?.dataset?.durum;
  if (!gorevId || !newDurum) return;

  const { error } = await supabase.from('gorevler').update({ durum: newDurum }).eq('id', gorevId);
  if (error) { console.error(error.message); return; }
  await loadGorevler(currentEkipFilter);
}

async function createGorev() {
  const baslik = document.getElementById('gorev-baslik')?.value?.trim();
  const aciklama = document.getElementById('gorev-aciklama')?.value?.trim();
  const oncelik = document.getElementById('gorev-oncelik')?.value || 'orta';
  const etiketler = document.getElementById('gorev-etiketler')?.value?.trim();
  const sonTarih = document.getElementById('gorev-tarih')?.value;
  const ekipId = document.getElementById('gorev-ekip-select')?.value ||
                 currentEkipFilter ||
                 document.getElementById('gorev-ekip-filter')?.value || null;

  if (!baslik) { showToast('Görev başlığı zorunlu!'); return; }

  const session = (await supabase.auth.getSession()).data.session;
  if (!session) { showToast('Önce giriş yap!'); return; }

  const { error } = await supabase.from('gorevler').insert({
    baslik, aciklama, oncelik, etiketler,
    son_tarih: sonTarih || null,
    ekip_id: ekipId || null,
    olusturan_email: session.user.email,
    olusturan_id: session.user.id,
    durum: 'yapilacak',
    sira: allGorevler.length
  });

  if (error) { console.error(error.message); showToast('Görev oluşturulamadı!'); return; }

  ['gorev-baslik','gorev-aciklama','gorev-etiketler','gorev-tarih'].forEach(id => {
    const el = document.getElementById(id); if (el) el.value = '';
  });
  closeModal('gorev-form-modal');
  await loadGorevler(currentEkipFilter);
  showToast('Görev eklendi!');
}

async function deleteGorev(id) {
  if (!confirm('Bu görevi silmek istediğinize emin misiniz?')) return;
  const { error } = await supabase.from('gorevler').delete().eq('id', id);
  if (error) { console.error(error.message); return; }
  await loadGorevler(currentEkipFilter);
  showToast('Görev silindi.');
}

async function openGorevDetail(id) {
  const g = allGorevler.find(x => x.id === id);
  if (!g) return;
  const modal = document.getElementById('gorev-detay-modal');
  const content = document.getElementById('gorev-detay-content');
  if (!modal || !content) return;

  const ekip = allEkipler.find(e => e.id === g.ekip_id);

  content.innerHTML = `
    <div class="gd-header">
      <h3>${escapeHtml(g.baslik)}</h3>
      <span class="gd-oncelik oncelik-${g.oncelik}">${oncelikEmoji(g.oncelik)} ${oncelikText(g.oncelik)}</span>
    </div>
    <div class="gd-meta">
      <span>${g.son_tarih ? new Date(g.son_tarih).toLocaleDateString('tr-TR') : 'Tarih yok'}</span>
      <span>${escapeHtml(ekip?.isim || 'Ekip yok')}</span>
      <span>${escapeHtml(g.atanan_email || 'Atanmamış')}</span>
    </div>
    <div class="gd-aciklama">${escapeHtml(g.aciklama) || '<em>Açıklama yok</em>'}</div>
    <div class="gd-etiketler">
      ${(g.etiketler || '').split(',').filter(Boolean).map(t => `<span class="gorev-etiket">${escapeHtml(t.trim())}</span>`).join('')}
    </div>
    <div class="gd-actions">
      <select id="gd-durum" onchange="updateGorevDurum(${g.id}, this.value)" class="form-control" style="flex:1">
        <option value="yapilacak" ${g.durum==='yapilacak'?'selected':''}>Yapılacak</option>
        <option value="devam" ${g.durum==='devam'?'selected':''}>Devam Ediyor</option>
        <option value="kontrol" ${g.durum==='kontrol'?'selected':''}>Kontrolde</option>
        <option value="tamamlandi" ${g.durum==='tamamlandi'?'selected':''}>Tamamlandı</option>
      </select>
      <button class="btn btn-ghost btn-sm" style="color:#f87171" onclick="deleteGorev(${g.id});closeModal('gorev-detay-modal')">Sil</button>
    </div>
  `;

  modal.classList.add('open');
}

async function updateGorevDurum(id, durum) {
  await supabase.from('gorevler').update({ durum }).eq('id', id);
  await loadGorevler(currentEkipFilter);
  showToast('Görev güncellendi!');
}

function filterByEkip(ekipId) {
  currentEkipFilter = ekipId ? parseInt(ekipId) : null;
  document.querySelectorAll('.ekip-card').forEach(c => c.classList.remove('active'));
  if (ekipId) {
    const card = document.querySelector(`.ekip-card[onclick*="${parseInt(ekipId)}"]`);
    if (card) card.classList.add('active');
  }
  const sel = document.getElementById('gorev-ekip-filter');
  if (sel && currentEkipFilter !== null) sel.value = currentEkipFilter;
  if (sel && currentEkipFilter === null) sel.value = '';
  loadGorevler(currentEkipFilter);
}

// Modal helpers
function openModal(id) { const el = document.getElementById(id); if (el) el.classList.add('open'); document.body.style.overflow = 'hidden'; }
function closeModal(id) { const el = document.getElementById(id); if (el) el.classList.remove('open'); document.body.style.overflow = ''; }

// Realtime subscription
function setupGorevRealtime() {
  supabase.channel('gorevler-rt')
    .on('postgres_changes', { event: '*', schema: 'public', table: 'gorevler' }, () => { loadGorevler(currentEkipFilter); })
    .subscribe();
  supabase.channel('ekipler-rt')
    .on('postgres_changes', { event: '*', schema: 'public', table: 'ekipler' }, () => { loadEkipler(); })
    .subscribe();
  supabase.channel('ekip_uyeleri-rt')
    .on('postgres_changes', { event: '*', schema: 'public', table: 'ekip_uyeleri' }, () => { loadEkipler(); })
    .subscribe();
}

// Init
async function initTaskBoard() {
  await loadEkipler();
  await loadGorevler(null);
  setupGorevRealtime();
  await handleDavetLink();

  supabase.auth.onAuthStateChange((event) => {
    if (event === 'SIGNED_IN') {
      currentUserEmail = null;
      loadEkipler();
      loadGorevler(null);
      if (pendingDavetToken) showDavetKabulModal(pendingDavetToken);
    }
  });

  console.log('Gorev & Ekip sistemi hazir!');
}

// initTaskBoard is called via initPage on gorevler.html
