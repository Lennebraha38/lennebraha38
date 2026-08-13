<?php include __DIR__ . "/templates/shared/head.php"; ?>
<?php include __DIR__ . "/templates/shared/header.php"; ?>
  <section id="gorevler">
    <div class="container">
      <div class="section-header">
        <h2>Görev <span>&amp; Ekip</span> Yönetimi</h2>
        <p>Trello tarzı görev panosu ile projeni yönet, ekibini kur, görevleri dağıt.</p>
      </div>

      <!-- Ekip Grid -->
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;flex-wrap:wrap;gap:1rem;">
        <h3 style="font-size:1rem;font-weight:700;">Ekiplerim</h3>
        <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
          <button class="btn btn-primary btn-sm" onclick="openModal('ekip-form-modal')">+ Yeni Ekip</button>
        </div>
      </div>
      <p style="font-size:0.8rem;color:var(--text-dim);margin-bottom:1rem;">Ekiplerin yalnızca sana ve üyelerine görünür. Üyelerini ✉️ e-posta davetiyle ekleyebilirsin.</p>
      <div class="ekip-grid" id="ekip-grid"></div>

      <!-- Kanban Board -->
      <div style="display:flex;justify-content:space-between;align-items:center;margin:2rem 0 1rem;flex-wrap:wrap;gap:1rem;">
        <h3 style="font-size:1rem;font-weight:700;">Görev Panosu</h3>
        <div style="display:flex;gap:0.5rem;flex-wrap:wrap;align-items:center;">
          <select id="gorev-ekip-filter" class="form-control" style="width:180px;padding:0.4rem 0.8rem;font-size:0.8rem;" onchange="filterByEkip(this.value || null)">
            <option value="">Tüm Ekipler</option>
          </select>
          <button class="btn btn-primary btn-sm" onclick="openModal('gorev-form-modal')">+ Yeni Görev</button>
        </div>
      </div>
      <div class="kanban-board">
        <div class="kanban-col" data-durum="yapilacak" ondragover="allowDrop(event)" ondragleave="leaveDrop(event)" ondrop="dropGorev(event)">
          <div class="kanban-col-title">Yapılacak <span class="col-count" id="count-yapilacak">0</span></div>
          <div id="col-yapilacak"></div>
        </div>
        <div class="kanban-col" data-durum="devam" ondragover="allowDrop(event)" ondragleave="leaveDrop(event)" ondrop="dropGorev(event)">
          <div class="kanban-col-title">Devam Ediyor <span class="col-count" id="count-devam">0</span></div>
          <div id="col-devam"></div>
        </div>
        <div class="kanban-col" data-durum="kontrol" ondragover="allowDrop(event)" ondragleave="leaveDrop(event)" ondrop="dropGorev(event)">
          <div class="kanban-col-title">Kontrolde <span class="col-count" id="count-kontrol">0</span></div>
          <div id="col-kontrol"></div>
        </div>
        <div class="kanban-col" data-durum="tamamlandi" ondragover="allowDrop(event)" ondragleave="leaveDrop(event)" ondrop="dropGorev(event)">
          <div class="kanban-col-title">Tamamlandı <span class="col-count" id="count-tamamlandi">0</span></div>
          <div id="col-tamamlandi"></div>
        </div>
      </div>
    </div>
  </section>

  <div id="ekip-form-modal" style="position:fixed;inset:0;z-index:5000;background:rgba(5,5,8,0.85);backdrop-filter:blur(10px);display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity 0.3s;">
    <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:var(--radius-xl);padding:2rem;max-width:480px;width:90%;">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
        <h3 style="font-size:1.1rem;font-weight:800;">Yeni Ekip Oluştur</h3>
        <button onclick="closeModal('ekip-form-modal')" aria-label="Kapat" style="background:none;border:none;color:var(--text-dim);cursor:pointer;font-size:1.2rem;">✕</button>
      </div>
      <input type="text" id="ekip-isim" class="form-control" placeholder="Ekip Adı" style="margin-bottom:0.8rem;width:100%;">
      <textarea id="ekip-aciklama" class="form-control" placeholder="Ekip açıklaması..." rows="3" style="margin-bottom:0.8rem;width:100%;"></textarea>
      <div style="display:flex;gap:0.8rem;margin-bottom:0.8rem;">
        <select id="ekip-kategori" class="form-control" style="flex:1;">
          <option value="genel">Genel</option>
          <option value="teknofest">Teknofest</option>
          <option value="tubitak">TÜBİTAK</option>
          <option value="yazilim">Yazılım</option>
          <option value="siber">Siber Güvenlik</option>
          <option value="tasarim">Tasarım</option>
        </select>
        <input type="number" id="ekip-max" class="form-control" value="10" min="2" max="50" style="width:80px;" title="Max üye">
      </div>
      <button class="btn btn-primary" style="width:100%;" onclick="createEkip()">Ekip Oluştur</button>
    </div>
  </div>

  <div id="gorev-form-modal" style="position:fixed;inset:0;z-index:5000;background:rgba(5,5,8,0.85);backdrop-filter:blur(10px);display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity 0.3s;">
    <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:var(--radius-xl);padding:2rem;max-width:500px;width:90%;">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
        <h3 style="font-size:1.1rem;font-weight:800;">Yeni Görev</h3>
        <button onclick="closeModal('gorev-form-modal')" aria-label="Kapat" style="background:none;border:none;color:var(--text-dim);cursor:pointer;font-size:1.2rem;">✕</button>
      </div>
      <input type="text" id="gorev-baslik" class="form-control" placeholder="Görev başlığı..." style="margin-bottom:0.8rem;width:100%;">
      <textarea id="gorev-aciklama" class="form-control" placeholder="Görev açıklaması..." rows="3" style="margin-bottom:0.8rem;width:100%;"></textarea>
      <div style="display:flex;gap:0.8rem;margin-bottom:0.8rem;flex-wrap:wrap;">
        <select id="gorev-ekip-select" class="form-control" style="flex:1;min-width:140px;">
          <option value="">Ekip seç (opsiyonel)</option>
        </select>
        <select id="gorev-oncelik" class="form-control" style="flex:1;min-width:120px;">
          <option value="dusuk">Düşük</option>
          <option value="orta" selected>Orta</option>
          <option value="yuksek">Yüksek</option>
          <option value="acil">Acil</option>
        </select>
        <input type="date" id="gorev-tarih" class="form-control" style="flex:1;min-width:140px;">
      </div>
      <input type="text" id="gorev-etiketler" class="form-control" placeholder="Etiketler (virgülle ayır)" style="margin-bottom:0.8rem;width:100%;">
      <button class="btn btn-primary" style="width:100%;" onclick="createGorev()">Görev Ekle</button>
    </div>
  </div>

  <div id="gorev-detay-modal" onclick="if(event.target===this)closeModal('gorev-detay-modal')">
    <div class="gd-card" id="gorev-detay-content"></div>
  </div>

  <div id="ekip-detay-modal" style="position:fixed;inset:0;z-index:5000;background:rgba(5,5,8,0.85);backdrop-filter:blur(10px);display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity 0.3s;" onclick="if(event.target===this)closeModal('ekip-detay-modal')">
    <div class="gd-card" id="ekip-detay-content"></div>
  </div>

  <div id="ekip-davet-modal" style="position:fixed;inset:0;z-index:5000;background:rgba(5,5,8,0.85);backdrop-filter:blur(10px);display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity 0.3s;">
    <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:var(--radius-xl);padding:2rem;max-width:460px;width:90%;">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
        <h3 style="font-size:1.1rem;font-weight:800;">✉️ Üye Davet Et</h3>
        <button onclick="closeModal('ekip-davet-modal')" aria-label="Kapat" style="background:none;border:none;color:var(--text-dim);cursor:pointer;font-size:1.2rem;">✕</button>
      </div>
      <div id="davet-form">
        <input type="email" id="davet-email" class="form-control" placeholder="Üyenin e-posta adresi" style="margin-bottom:0.8rem;width:100%;">
        <p style="font-size:0.8rem;color:var(--text-dim);margin-bottom:1.2rem;">
          ✅ Davet linki oluşturulur, <strong>Gmail ile Gönder</strong>'e bastığında Gmail'in açılır (adres ve mesaj dolu).<br>
          🔗 Üye linke tıklayıp aynı e-postayla giriş yaparsa ekibe katılır.<br>
          📱 Gmail açılmıyorsa linki <strong>Kopyala</strong> ile alıp elle gönderebilirsin.
        </p>
        <button class="btn btn-primary" style="width:100%;" onclick="sendDavet()">Daveti Oluştur</button>
      </div>
      <div id="davet-sonuc" style="display:none;text-align:center;">
        <div style="font-size:2rem;margin-bottom:0.5rem;">✅</div>
        <h4 style="font-weight:800;margin-bottom:0.4rem;">Davet oluşturuldu!</h4>
        <p style="font-size:0.85rem;font-weight:600;color:var(--primary);margin-bottom:0.6rem;" id="davet-durum-msg"></p>
        <p style="font-size:0.8rem;color:var(--text-dim);margin-bottom:0.8rem;">Bu linki üyene gönder — sadece davet ettiğin e-posta ile çalışır:</p>
        <div style="display:flex;gap:0.5rem;margin-bottom:0.8rem;">
          <input type="text" id="davet-link" readonly style="flex:1;padding:0.6rem 0.8rem;border:1px solid var(--border);border-radius:var(--radius-md);background:var(--bg-surface);color:var(--text);font-size:0.75rem;">
          <button class="btn btn-primary btn-sm" onclick="kopyalaDavetLinki()" style="white-space:nowrap;">📋 Kopyala</button>
        </div>
        <div style="display:flex;gap:0.5rem;">
          <button class="btn btn-primary" style="flex:1;" onclick="gmailIleGonder()">📧 Gmail ile Gönder</button>
          <button class="btn btn-ghost btn-sm" style="flex:1;" onclick="yeniDavet()">+ Yeni Davet</button>
        </div>
      </div>
      <input type="hidden" id="davet-ekip-id">
    </div>
  </div>

  <div id="davet-kabul-modal" style="position:fixed;inset:0;z-index:5000;background:rgba(5,5,8,0.85);backdrop-filter:blur(10px);display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity 0.3s;">
    <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:var(--radius-xl);padding:2rem;max-width:440px;width:90%;">
      <div id="davet-kabul-content"></div>
      <div style="display:flex;gap:0.8rem;margin-top:1.2rem;">
        <button class="btn btn-primary" style="flex:1;" onclick="acceptDavet()">Kabul Et 🎉</button>
        <button class="btn btn-ghost" style="flex:1;" onclick="declineDavet()">Reddet</button>
      </div>
    </div>
  </div>

<?php include __DIR__ . "/templates/shared/footer.php"; ?>
<script src="templates/task-board.js"></script>
<script>
// Gorevler page - Kanban board
initPage = async function() { if (typeof initTaskBoard === "function") await initTaskBoard(); };
</script>
<?php include __DIR__ . "/templates/shared/shared-js.php"; ?>
</body></html>
