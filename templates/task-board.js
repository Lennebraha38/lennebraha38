// ============================================
// Lennebraha38 — Gorev & Ekip Yonetim Sistemi
// Trello tarzi Kanban Board + Ekip Olusturma
// Supabase Realtime entegrasyonlu
// ============================================

// Kanban board state
let currentEkipFilter = null;
let allGorevler = [];
let allEkipler = [];
let gorevEkipMap = {};

// ===== EKIP CRUD =====
async function loadEkipler() {
  const { data, error } = await supabase.from('ekipler').select('*').order('id', { ascending: false });
  if (error) { console.error(error.message); return; }
  allEkipler = data || [];
  renderEkipList();
  renderEkipFilter();
}

function renderEkipList() {
  const grid = document.getElementById('ekip-grid');
  if (!grid) return;
  if (allEkipler.length === 0) {
    grid.innerHTML = '<div style="grid-column:1/-1;text-align:center;color:var(--text-dim);padding:2rem;">Henuz ekip olusturulmadi. Ilk ekibi sen kur!</div>';
    return;
  }
  grid.innerHTML = allEkipler.map(e => `
    <div class="ekip-card" onclick="filterByEkip('${e.id}')">
      <div class="ekip-card-header">
        <span class="ekip-emoji">👥</span>
        <span class="ekip-badge">${e.durum || 'Acik'}</span>
      </div>
      <h4>${e.isim}</h4>
      <p>${(e.aciklama||'').substring(0,80)}</p>
      <div class="ekip-meta">
        <span>👤 ${e.uye_sayisi || 1}/${e.max_uye || 10}</span>
        <span>📂 ${e.kategori || 'Genel'}</span>
      </div>
    </div>
  `).join('');
}

function renderEkipFilter() {
  const sel = document.getElementById('gorev-ekip-filter');
  if (!sel) return;
  sel.innerHTML = '<option value="">Tum Ekipler</option>' +
    allEkipler.map(e => `<option value="${e.id}">${e.isim}</option>`).join('');
}

async function createEkip() {
  const isim = document.getElementById('ekip-isim')?.value?.trim();
  const aciklama = document.getElementById('ekip-aciklama')?.value?.trim();
  const kategori = document.getElementById('ekip-kategori')?.value;
  const maxUye = parseInt(document.getElementById('ekip-max')?.value || '10');

  if (!isim) { showToast('⚠️ Ekip ismi zorunlu!'); return; }

  const session = (await supabase.auth.getSession()).data.session;
  if (!session) { showToast('⚠️ Once giris yapmalisin!'); return; }

  const { error } = await supabase.from('ekipler').insert({
    isim, aciklama, kategori,
    olusturan_email: session.user.email,
    olusturan_id: session.user.id,
    max_uye: maxUye,
    uye_sayisi: 1
  });

  if (error) { console.error(error.message); showToast('⚠️ Ekip olusturulamadi!'); return; }

  document.getElementById('ekip-isim').value = '';
  document.getElementById('ekip-aciklama').value = '';
  closeModal('ekip-form-modal');
  await loadEkipler();
  showToast('✅ Ekip olusturuldu!');
}

async function joinEkip(ekipId) {
  const session = (await supabase.auth.getSession()).data.session;
  if (!session) { showToast('⚠️ Once giris yap!'); return; }

  const { error } = await supabase.from('ekip_uyeleri').insert({
    ekip_id: ekipId,
    kullanici_email: session.user.email,
    kullanici_id: session.user.id,
    rol: 'uye'
  });

  if (error) {
    if (error.code === '23505') { showToast('⚠️ Zaten bu ekiptesin!'); }
    else { showToast('⚠️ Katilim basarisiz!'); }
    return;
  }

  await supabase.rpc('increment_uye_sayisi', { ekip_id: ekipId });
  await loadEkipler();
  showToast('✅ Ekibe katildin!');
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
    'yapilacak': { title: '📋 Yapilacak', id: 'col-yapilacak' },
    'devam': { title: '🔄 Devam Ediyor', id: 'col-devam' },
    'kontrol': { title: '👀 Kontrolde', id: 'col-kontrol' },
    'tamamlandi': { title: '✅ Tamamlandi', id: 'col-tamamlandi' }
  };

  Object.entries(columns).forEach(([durum, col]) => {
    const el = document.getElementById(col.id);
    if (!el) return;
    const gorevler = allGorevler.filter(g => g.durum === durum);
    el.innerHTML = gorevler.map(g => `
      <div class="gorev-card" draggable="true" data-id="${g.id}"
           ondragstart="dragStart(event)" ondragend="dragEnd(event)"
           onclick="openGorevDetail(${g.id})">
        <div class="gorev-card-header">
          <span class="gorev-oncelik oncelik-${g.oncelik || 'orta'}">${oncelikEmoji(g.oncelik)} ${oncelikText(g.oncelik)}</span>
          ${g.son_tarih ? `<span class="gorev-tarih">📅 ${new Date(g.son_tarih).toLocaleDateString('tr-TR')}</span>` : ''}
        </div>
        <h5>${g.baslik}</h5>
        ${g.aciklama ? `<p>${g.aciklama.substring(0, 100)}</p>` : ''}
        <div class="gorev-card-footer">
          <div class="gorev-etiketler">
            ${(g.etiketler || '').split(',').filter(Boolean).map(t => `<span class="gorev-etiket">${t.trim()}</span>`).join('')}
          </div>
          ${g.atanan_email ? `<span class="gorev-avatar" title="${g.atanan_email}">${g.atanan_email.substring(0,2).toUpperCase()}</span>` : ''}
        </div>
      </div>
    `).join('');
    el.innerHTML += `<div class="gorev-count">${gorevler.length} gorev</div>`;
  });
}

function oncelikEmoji(p) { return { acil: '🔴', yuksek: '🟠', orta: '🟡', dusuk: '🟢' }[p] || '🟡'; }
function oncelikText(p) { return { acil: 'Acil', yuksek: 'Yuksek', orta: 'Orta', dusuk: 'Dusuk' }[p] || 'Orta'; }

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
  const ekipId = currentEkipFilter || document.getElementById('gorev-ekip-filter')?.value || null;

  if (!baslik) { showToast('⚠️ Gorev basligi zorunlu!'); return; }

  const session = (await supabase.auth.getSession()).data.session;
  if (!session) { showToast('⚠️ Once giris yap!'); return; }

  const { error } = await supabase.from('gorevler').insert({
    baslik, aciklama, oncelik, etiketler,
    son_tarih: sonTarih || null,
    ekip_id: ekipId || null,
    olusturan_email: session.user.email,
    olusturan_id: session.user.id,
    durum: 'yapilacak',
    sira: allGorevler.length
  });

  if (error) { console.error(error.message); showToast('⚠️ Gorev olusturulamadi!'); return; }

  ['gorev-baslik','gorev-aciklama','gorev-etiketler','gorev-tarih'].forEach(id => {
    const el = document.getElementById(id); if (el) el.value = '';
  });
  closeModal('gorev-form-modal');
  await loadGorevler(currentEkipFilter);
  showToast('✅ Gorev eklendi!');
}

async function deleteGorev(id) {
  if (!confirm('Bu gorevi silmek istediginize emin misiniz?')) return;
  const { error } = await supabase.from('gorevler').delete().eq('id', id);
  if (error) { console.error(error.message); return; }
  await loadGorevler(currentEkipFilter);
  showToast('🗑️ Gorev silindi.');
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
      <h3>${g.baslik}</h3>
      <span class="gd-oncelik oncelik-${g.oncelik}">${oncelikEmoji(g.oncelik)} ${oncelikText(g.oncelik)}</span>
    </div>
    <div class="gd-meta">
      <span>📅 ${g.son_tarih ? new Date(g.son_tarih).toLocaleDateString('tr-TR') : 'Tarih yok'}</span>
      <span>📂 ${ekip?.isim || 'Ekip yok'}</span>
      <span>👤 ${g.atanan_email || 'Atanmamis'}</span>
    </div>
    <div class="gd-aciklama">${g.aciklama || '<em>Aciklama yok</em>'}</div>
    <div class="gd-etiketler">
      ${(g.etiketler || '').split(',').filter(Boolean).map(t => `<span class="gorev-etiket">${t.trim()}</span>`).join('')}
    </div>
    <div class="gd-actions">
      <select id="gd-durum" onchange="updateGorevDurum(${g.id}, this.value)" class="form-control" style="flex:1">
        <option value="yapilacak" ${g.durum==='yapilacak'?'selected':''}>📋 Yapilacak</option>
        <option value="devam" ${g.durum==='devam'?'selected':''}>🔄 Devam Ediyor</option>
        <option value="kontrol" ${g.durum==='kontrol'?'selected':''}>👀 Kontrolde</option>
        <option value="tamamlandi" ${g.durum==='tamamlandi'?'selected':''}>✅ Tamamlandi</option>
      </select>
      <button class="btn btn-ghost btn-sm" style="color:#f87171" onclick="deleteGorev(${g.id});closeModal('gorev-detay-modal')">🗑️ Sil</button>
    </div>
  `;

  modal.classList.add('open');
}

async function updateGorevDurum(id, durum) {
  await supabase.from('gorevler').update({ durum }).eq('id', id);
  await loadGorevler(currentEkipFilter);
  showToast('✅ Gorev guncellendi!');
}

function filterByEkip(ekipId) {
  currentEkipFilter = ekipId ? parseInt(ekipId) : null;
  document.querySelectorAll('.ekip-card').forEach(c => c.classList.remove('active'));
  if (ekipId) {
    const card = document.querySelector(`.ekip-card[onclick*="${ekipId}"]`);
    if (card) card.classList.add('active');
  }
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
}

// Init
async function initTaskBoard() {
  await loadEkipler();
  await loadGorevler(null);
  setupGorevRealtime();
  console.log('✅ Gorev & Ekip sistemi hazir!');
}

// Extend main init
const _origInitApp = initApp;
initApp = async function() {
  await _origInitApp();
  await initTaskBoard();
};
