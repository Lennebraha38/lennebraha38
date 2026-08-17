<?php include __DIR__ . "/templates/shared/head.php"; ?>
<?php include __DIR__ . "/templates/shared/header.php"; ?>
  <section id="yarismalar">
    <div class="container">
      <div class="section-header reveal">
        <div class="badge-pill">Kategoriler</div>
        <h2>Popüler Yarışmalar</h2>
        <p>Alanınıza uygun yarışmayı bulun ve takımınızı şimdi oluşturun</p>
      </div>
      <div class="cards-grid reveal">

        <div class="card-3d" onmousemove="tiltCard(event,this)" onmouseleave="resetTilt(this)">
          <div class="card-icon">🚀</div>
          <h3>Teknofest</h3>
          <p>Havacılık, Uzay ve Teknoloji Festivali kapsamındaki 50+ yarışma kategorisinde takımınızla yer alın. İHA, roket, yapay zeka, akıllı ulaşım ve daha fazlası.</p>
          <div style="display:flex;flex-wrap:wrap;gap:0.4rem;margin:0.8rem 0;">
            <span class="ilan-tag">İHA / Drone</span>
            <span class="ilan-tag">Roket</span>
            <span class="ilan-tag">Yapay Zeka</span>
            <span class="ilan-tag">Akıllı Ulaşım</span>
            <span class="ilan-tag">Siber Güvenlik</span>
          </div>
          <span class="card-link" onclick="openKategoriModal('teknofest')">
            Kategorileri Gör
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </span>
        </div>

        <div class="card-3d" onmousemove="tiltCard(event,this)" onmouseleave="resetTilt(this)">
          <div class="card-icon">🔬</div>
          <h3>TÜBİTAK</h3>
          <p>Bilimsel araştırma projeleri, olimpiyatlar ve burslarla akademik kariyerinize güçlü bir başlangıç yapın. Lise ve üniversite kategorilerinde ulusal finale çıkın.</p>
          <div style="display:flex;flex-wrap:wrap;gap:0.4rem;margin:0.8rem 0;">
            <span class="ilan-tag">2204-A (Lise)</span>
            <span class="ilan-tag">2209-A (Üniversite)</span>
            <span class="ilan-tag">2209-B (Sanayi)</span>
            <span class="ilan-tag">Olimpiyat</span>
          </div>
          <span class="card-link" onclick="openKategoriModal('tubitak')">
            Kategorileri Gör
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </span>
        </div>

        <div class="card-3d" onmousemove="tiltCard(event,this)" onmouseleave="resetTilt(this)">
          <div class="card-icon">💻</div>
          <h3>Yazılım & Algoritma</h3>
          <p>ACM-ICPC, Google Hash Code, Codeforces ve Kaggle gibi küresel platformlarda yeteneklerinizi dünya çapında kanıtlayın. Takım oluştur, yarış, kazan.</p>
          <div style="display:flex;flex-wrap:wrap;gap:0.4rem;margin:0.8rem 0;">
            <span class="ilan-tag">ACM-ICPC</span>
            <span class="ilan-tag">Google Hash Code</span>
            <span class="ilan-tag">Codeforces</span>
            <span class="ilan-tag">LeetCode Contest</span>
          </div>
          <span class="card-link" onclick="openKategoriModal('yazilim')">
            Kategorileri Gör
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </span>
        </div>

        <div class="card-3d" onmousemove="tiltCard(event,this)" onmouseleave="resetTilt(this)">
          <div class="card-icon">🤖</div>
          <h3>Yapay Zeka & Veri</h3>
          <p>Makine öğrenimi, derin öğrenme ve doğal dil işleme projelerinde ekip kurun. Kaggle Grand Master'lardan mentörlük alın, gerçek veri setleriyle çalışın.</p>
          <div style="display:flex;flex-wrap:wrap;gap:0.4rem;margin:0.8rem 0;">
            <span class="ilan-tag">Kaggle</span>
            <span class="ilan-tag">Makine Öğrenimi</span>
            <span class="ilan-tag">Derin Öğrenme</span>
            <span class="ilan-tag">NLP</span>
            <span class="ilan-tag">Bilgisayarlı Görü</span>
          </div>
          <span class="card-link" onclick="openKategoriModal('yapay-zeka')">
            Kategorileri Gör
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </span>
        </div>

        <div class="card-3d" onmousemove="tiltCard(event,this)" onmouseleave="resetTilt(this)">
          <div class="card-icon">🔐</div>
          <h3>Siber Güvenlik</h3>
          <p>CTF yarışmaları, penetrasyon testi ve güvenlik araştırmalarında uzmanlaşmış ekipler kurun. Ulusal CTF Şampiyonası ve Teknofest Siber Güvenlik kategorisine hazırlanın.</p>
          <div style="display:flex;flex-wrap:wrap;gap:0.4rem;margin:0.8rem 0;">
            <span class="ilan-tag">CTF</span>
            <span class="ilan-tag">Web Güvenliği</span>
            <span class="ilan-tag">Pentest</span>
            <span class="ilan-tag">Binary Exploit</span>
            <span class="ilan-tag">Kriptografi</span>
          </div>
          <span class="card-link" onclick="openKategoriModal('siber')">
            Kategorileri Gör
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </span>
        </div>

        <div class="card-3d" onmousemove="tiltCard(event,this)" onmouseleave="resetTilt(this)">
          <div class="card-icon">🎨</div>
          <h3>Tasarım & İnovasyon</h3>
          <p>UI/UX tasarım yarışmaları, sosyal girişimcilik projeleri ve inovasyon hackathonlarında yaratıcı fikirlerinizi hayata geçirin. Ürününüzü gerçek kullanıcılara sunun.</p>
          <div style="display:flex;flex-wrap:wrap;gap:0.4rem;margin:0.8rem 0;">
            <span class="ilan-tag">UI/UX</span>
            <span class="ilan-tag">Hackathon</span>
            <span class="ilan-tag">Sosyal Girişim</span>
            <span class="ilan-tag">Prototip</span>
          </div>
          <span class="card-link" onclick="openKategoriModal('tasarim')">
            Kategorileri Gör
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </span>
        </div>

      </div>
    </div>
  </section>

  <section id="basvuru-takip" style="padding:5rem 0 2rem;">
    <div class="container">
      <div class="section-header reveal">
        <div class="badge-pill">Başvuru Takibi</div>
        <h2>Yarışma Kayıtlarım</h2>
        <p>Başvurduğun yarışmaları takip et, rapor tarihini kaçırma</p>
      </div>

      <div class="reveal" style="display:flex;justify-content:flex-end;margin-bottom:1.2rem;">
        <button class="btn btn-primary" onclick="toggleBasvuruForm()">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
          Başvuru Ekle
        </button>
      </div>

      <div class="page-form-area reveal" id="basvuru-form-alani">
        <h3>📋 Yarışma Başvuru Kaydı</h3>
        <p class="pfa-sub">Başvurunu kaydet, tarihleri kaçırma.</p>
        <div class="form-group">
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
        <div class="form-group">
          <label class="form-label">Rapor Tarihi</label>
          <input type="date" class="form-control" id="basvuru-rapor">
        </div>
        <button class="btn btn-primary" style="width:100%;justify-content:center;" onclick="basvuruKaydet()">Kaydet</button>
      </div>

      <div id="basvuru-listesi" class="reveal"></div>
    </div>
  </section>

  <section id="halk-oyu" style="padding:3rem 0;">
    <div class="container">
      <div class="section-header reveal">
        <div class="badge-pill">Topluluk</div>
        <h2>Halkın Seçimi Oylaması</h2>
        <p>Takımına en iyi projeyi seçtir — demokratik yarışma</p>
      </div>

      <div class="reveal" style="max-width:520px;margin:0 auto 1.2rem;text-align:center;">
        <div class="oy-form">
          <input type="text" id="oy-yarisma" placeholder="Yarışma adı (örn: TEKNOFEST)">
          <input type="text" id="oy-proje" placeholder="Proje adı">
          <button class="btn btn-primary" onclick="oyFormVer()">🗳️ Oy Ver</button>
        </div>
        <div class="forum-bos" style="padding:1rem 0 0;font-size:.8rem;">Yarışma adı girince canlı sonuçlar yüklenir</div>
      </div>

      <div id="oy-sonuclari" class="reveal" style="max-width:520px;margin:0 auto;"></div>
    </div>
  </section>
    <div id="km-box">
      <div id="km-header">
        <div id="km-header-left">
          <div id="km-emoji-box"></div>
          <div>
            <div id="km-title"></div>
            <div id="km-subtitle"></div>
          </div>
        </div>
        <button id="km-close-btn" onclick="closeKM()" aria-label="Kapat"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
      </div>
      <div id="km-count-bar">
        <strong id="km-count">0</strong> kategori — her biri hakkında detaylı bilgi
      </div>
      <div id="km-grid"></div>
      <div id="km-footer">
        <span id="km-footer-text"></span>
      </div>
    </div>
  </div>

<?php include __DIR__ . "/templates/shared/footer.php"; ?>
<script>
// Yarismalar page - kategori modal data + JS
    var KD = {
      teknofest: {
        emoji:'🚀', title:'Teknofest 2026 — Kategoriler', subtitle:'50+ yarışma kategorisi · Ankara',
        url:'https://teknofest.org',
        cats:[
          {e:'✈️', n:'İnsansız Hava Aracı (İHA)', d:'Sabit kanatlı, döner kanatlı ve multirotor kategorileri', t:'Açık'},
          {e:'🚁', n:'İHA Sürü Sistemi', d:'Çoklu otonom araç koordinasyonu ve görev tamamlama', t:'Açık'},
          {e:'🚀', n:'Model Roket', d:'Yüksek irtifa, hassas iniş ve yük taşıma kategorileri', t:'Açık'},
          {e:'🤖', n:'Yapay Zeka', d:'Görüntü işleme, NLP ve otonom sistem projeleri', t:'Açık'},
          {e:'🏥', n:'Sağlıkta Yapay Zeka', d:'Tıbbi görüntüleme, teşhis ve hasta takip sistemleri', t:'Açık'},
          {e:'🚗', n:'Akıllı Ulaşım', d:'Otonom araç ve trafik yönetim sistemleri', t:'Açık'},
          {e:'🔐', n:'Siber Güvenlik', d:'Saldırı tespiti ve güvenli yazılım geliştirme', t:'Açık'},
          {e:'🌊', n:'İnsansız Deniz Aracı', d:'Su üstü ve su altı otonom araçlar', t:'Açık'},
          {e:'🛰️', n:'Uydu Teknolojileri', d:'CubeSat tasarımı ve uzay sistemleri', t:'Açık'},
          {e:'♻️', n:'Çevre & Enerji', d:'Yenilenebilir enerji ve çevre izleme projeleri', t:'Açık'},
          {e:'🌾', n:'Tarım Teknolojileri', d:'Akıllı tarım, sulama ve ürün izleme sistemleri', t:'Açık'},
          {e:'🏗️', n:'Akıllı Şehir', d:'IoT tabanlı kentsel yönetim çözümleri', t:'Açık'},
          {e:'🔬', n:'Malzeme Bilimi', d:'İleri malzeme tasarımı ve üretim teknolojileri', t:'Açık'},
          {e:'💊', n:'Biyomedikal', d:'Protez, implant ve rehabilitasyon cihazları', t:'Açık'},
          {e:'🏎️', n:'Elektrikli Araç', d:'Formul-E tipi elektrikli araç tasarımı', t:'Açık'},
        ]
      },
      tubitak: {
        emoji:'🔬', title:'TÜBİTAK — Programlar & Olimpiyatlar', subtitle:'Araştırma projeleri ve olimpiyatlar · 2026',
        url:'https://tubitak.gov.tr',
        cats:[
          {e:'🏫', n:'2204-A Lise Proje', d:'Lise öğrencileri ulusal proje yarışması', t:'Açık', c:'green'},
          {e:'🎓', n:'2209-A Üniversite', d:'Lisans öğrencileri araştırma proje desteği', t:'Açık', c:'green'},
          {e:'🏭', n:'2209-B Sanayi', d:'Sanayi iş birliği ile lisans proje desteği', t:'Açık', c:'green'},
          {e:'🧪', n:'Kimya Olimpiyatı', d:'Ulusal kimya yarışması ve IChO seçmesi', t:'Açık'},
          {e:'🔢', n:'Matematik Olimpiyatı', d:'Ulusal yarışma ve IMO seçmesi', t:'Açık'},
          {e:'⚛️', n:'Fizik Olimpiyatı', d:'IPhO seçmeleri ve ulusal final', t:'Açık'},
          {e:'💻', n:'Bilgisayar Olimpiyatı', d:'IOI seçmeleri ve algoritmik problem çözme', t:'Açık'},
          {e:'🌱', n:'Biyoloji Olimpiyatı', d:'IBO seçmeleri ve ulusal final', t:'Açık'},
          {e:'🌍', n:'Coğrafya Olimpiyatı', d:'iGEO seçmeleri ve ulusal yarışma', t:'Açık'},
          {e:'🔭', n:'Astronomi Olimpiyatı', d:'IOAA seçmeleri ve gözlemevi projeleri', t:'Açık'},
          {e:'🧬', n:'Bilim Fuarı (ISEF)', d:'Intel ISEF seçmeleri için ulusal proje yarışması', t:'Açık'},
          {e:'📐', n:'Teknoloji Yarışması', d:'Ortaokul düzeyinde teknoloji tasarım yarışması', t:'Açık'},
        ]
      },
      yazilim: {
        emoji:'💻', title:'Yazılım & Algoritma Yarışmaları', subtitle:'Küresel platformlar ve ulusal yarışmalar · 2026',
        url:'https://icpc.global',
        cats:[
          {e:'🏆', n:'ACM-ICPC', d:'Uluslararası üniversiteler arası programlama şampiyonası', t:'Açık'},
          {e:'🔥', n:'Codeforces Rounds', d:'Div 1–4 seviyeli yarışmalar, küresel rating sistemi', t:'Sürekli', c:'green'},
          {e:'💡', n:'LeetCode Contest', d:'Haftalık ve iki haftada bir gerçekleşen yarışmalar', t:'Haftalık', c:'green'},
          {e:'🌐', n:'Google Hash Code', d:'Mühendislik optimizasyon problemi, takım formatı', t:'Yıllık', c:'warn'},
          {e:'🎯', n:'Google Code Jam', d:'Bireysel global programlama yarışması', t:'Yıllık', c:'warn'},
          {e:'🐍', n:'AtCoder', d:'Japonya kökenli uluslararası yarışma platformu', t:'Haftalık', c:'green'},
          {e:'📊', n:'Meta Hacker Cup', d:"Meta'nın yıllık küresel programlama yarışması", t:'Yıllık', c:'warn'},
          {e:'🧩', n:'Advent of Code', d:'Aralık ayı her gün yeni bulmaca — 25 gün', t:'Yıllık', c:'warn'},
        ]
      },
      'yapay-zeka': {
        emoji:'🤖', title:'Yapay Zeka & Veri Yarışmaları', subtitle:'ML, DL, NLP, Bilgisayarlı Görü · 2026',
        url:'https://kaggle.com/competitions',
        cats:[
          {e:'🏅', n:'Kaggle Competitions', d:'Featured, research ve playground yarışma kategorileri', t:'Sürekli', c:'green'},
          {e:'👁️', n:'Bilgisayarlı Görü', d:'Nesne tespiti, segmentasyon, görüntü sınıflandırma', t:'Açık'},
          {e:'🗣️', n:'Doğal Dil İşleme', d:'Metin sınıflandırma, soru-cevap, çeviri sistemleri', t:'Açık'},
          {e:'📈', n:'Zaman Serisi Analizi', d:'Tahminleme modelleri ve anomali tespiti', t:'Açık'},
          {e:'🎮', n:'Pekiştirmeli Öğrenme', d:'Oyun ve simülasyon ortamlarında ajan eğitimi', t:'Açık'},
          {e:'🧬', n:'Biyoinformatik YZ', d:'Protein yapısı tahmini ve genomik analiz', t:'Açık'},
          {e:'📡', n:'Öneri Sistemleri', d:'Collaborative ve content-based filtering projeleri', t:'Açık'},
          {e:'🔍', n:'Bilgi Grafı & RAG', d:'Varlık ilişkisi çıkarımı ve RAG sistemleri', t:'Açık'},
        ]
      },
      siber: {
        emoji:'🔐', title:'Siber Güvenlik Yarışmaları', subtitle:'CTF, penetrasyon testi ve güvenlik araştırmaları · 2026',
        url:'https://ctftime.org',
        cats:[
          {e:'🏴', n:'CTF — Jeopardy', d:'Web, crypto, pwn, forensics, reverse engineering soruları', t:'Açık'},
          {e:'⚔️', n:'Attack & Defense CTF', d:'Gerçek zamanlı takımlar arası saldırı-savunma formatı', t:'Açık'},
          {e:'🕸️', n:'Web Güvenliği', d:'XSS, SQLi, SSRF ve OWASP Top 10 güvenlik açıkları', t:'Açık'},
          {e:'💥', n:'Binary Exploitation', d:'Buffer overflow, ROP chain ve heap exploit teknikleri', t:'Açık'},
          {e:'🔑', n:'Kriptografi', d:'RSA, AES, eliptik eğri kriptografi ve protokol açıkları', t:'Açık'},
          {e:'🕵️', n:'Dijital Adli Bilişim', d:'Memory dump, disk imajı ve log analizi', t:'Açık'},
          {e:'📡', n:'Ağ Güvenliği', d:'Paket analizi, MITM saldırıları ve ağ savunması', t:'Açık'},
          {e:'📱', n:'Mobil Güvenlik', d:'Android / iOS uygulama güvenlik analizi', t:'Açık'},
          {e:'⚙️', n:'Tersine Mühendislik', d:'Statik ve dinamik malware analizi teknikleri', t:'Açık'},
        ]
      },
      tasarim: {
        emoji:'🎨', title:'Tasarım & İnovasyon Yarışmaları', subtitle:'UI/UX, Hackathon, Girişimcilik · 2026',
        url:'https://behance.net',
        cats:[
          {e:'🖥️', n:'UI/UX Tasarım', d:'Kullanıcı arayüzü ve deneyim tasarım yarışmaları', t:'Açık'},
          {e:'⚡', n:'Hackathon', d:'24–72 saatlik yoğun ürün geliştirme yarışmaları', t:'Sürekli', c:'green'},
          {e:'🌍', n:'Sosyal Girişim', d:'Sosyal etki odaklı inovasyon ve girişimcilik projeleri', t:'Açık'},
          {e:'🛠️', n:'Prototip & Makerspace', d:'Donanım prototipleme ve Fab Lab yarışmaları', t:'Açık'},
          {e:'📱', n:'Mobil Uygulama', d:'iOS ve Android uygulama tasarım yarışmaları', t:'Açık'},
          {e:'🎬', n:'Motion Design', d:'Animasyon ve görsel efekt yarışmaları', t:'Açık'},
          {e:'🏛️', n:'Mimarlık & Kentsel', d:'Konsept tasarım ve kentsel dönüşüm projeleri', t:'Açık'},
          {e:'♻️', n:'Sürdürülebilir Tasarım', d:'Çevre dostu ürün ve sistem tasarımı yarışmaları', t:'Açık'},
        ]
      }
    };

    window.openKategoriModal = function(key) {
      var d = KD[key];
      if (!d) return;
      document.getElementById('km-emoji-box').textContent = d.emoji;
      document.getElementById('km-title').textContent = d.title;
      document.getElementById('km-subtitle').textContent = d.subtitle;
      document.getElementById('km-count').textContent = d.cats.length;
      document.getElementById('km-footer-text').textContent = '';

      var html = '';
      for (var i = 0; i < d.cats.length; i++) {
        var c = d.cats[i];
        var tagClass = c.c === 'green' ? 'tag-green' : c.c === 'warn' ? 'tag-warn' : '';
        html += '<div class="km-card">' +
          '<span class="km-card-emoji">' + c.e + '</span>' +
          '<div class="km-card-name">' + c.n + '</div>' +
          '<div class="km-card-desc">' + c.d + '</div>' +
          '<div class="km-card-footer">' +
          '</div>' +
          '</div>';
      }
      document.getElementById('km-grid').innerHTML = html;

      var ov = document.getElementById('km-overlay');
      ov.classList.add('km-open');
      document.body.style.overflow = 'hidden';
    };

    window.closeKM = function() {
      document.getElementById('km-overlay').classList.remove('km-open');
      document.body.style.overflow = '';
    };

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') window.closeKM();
    });
  </script>
<script>
window.oyFormVer = function() {
  const yarisma = document.getElementById('oy-yarisma')?.value?.trim();
  const proje = document.getElementById('oy-proje')?.value?.trim();
  if (!yarisma || !proje) { showToast('⚠️ Yarışma ve proje adını doldur!'); return; }
  oyVer(yarisma, proje);
  setTimeout(() => oylarYukle(yarisma), 400);
};
function oyYukleDinle() {
  const yarisma = document.getElementById('oy-yarisma')?.value?.trim();
  if (yarisma) oylarYukle(yarisma);
}
document.addEventListener('DOMContentLoaded', function() {
  const input = document.getElementById('oy-yarisma');
  if (input) input.addEventListener('change', oyYukleDinle);
});
initPage = async function() { if (typeof loadKategoriler === "function") await loadKategoriler(); };
initVizyonPage = async function() { if (typeof basvuruYukle === "function") basvuruYukle(); };
</script>
<?php include __DIR__ . "/templates/shared/shared-js.php"; ?>
</body></html>
