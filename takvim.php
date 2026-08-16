<?php include __DIR__ . "/templates/shared/head.php"; ?>
<?php include __DIR__ . "/templates/shared/header.php"; ?>
  <section id="takvim">
    <div class="container">
      <div class="section-header reveal">
        <div class="badge-pill">Takvim</div>
        <h2>Yaklaşan Etkinlikler</h2>
        <p>Son başvuru tarihlerini kaçırma, zamanında hazırlan</p>
      </div>
      <div class="reveal" style="display:flex;justify-content:flex-end;margin-bottom:1.2rem;">
        <button class="btn btn-primary" onclick="takvimExportICS()">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
          Takvimi İndir (.ics)
        </button>
      </div>
      <div class="calendar-wrap reveal">

        <div class="cal-info">
          <h2>Tarih Takvimi</h2>
          <p>Resmi tatiller, dini bayramlar ve tarihin önemli günlerini keşfet. Takvimde bir güne tıklayarak o tarihteki olayları gör.</p>
          <div class="upcoming-list">
            <div class="upcoming-item" onclick="showToast('🏅 19 Mayıs 1919 — Atatürk Samsun\'a çıkarak Kurtuluş Savaşı\'nı başlattı. Gençlik ve Spor Bayramı resmi tatildir.')">
              <div class="upcoming-dot dot-blue"></div>
              <div class="upcoming-text">
                <strong>Gençlik ve Spor Bayramı 🏅</strong>
                <span>Resmi Tatil · 1919'da Kurtuluş Savaşı başladı</span>
              </div>
              <div class="upcoming-date">19 MAY</div>
            </div>
            <div class="upcoming-item" onclick="showToast('🐑 Kurban Bayramı 2026 — Hz. İbrahim\'in Allah\'a olan bağlılığının anısına kutlanan dini bayram. 4 gün + arife tatil.')">
              <div class="upcoming-dot dot-green"></div>
              <div class="upcoming-text">
                <strong>Kurban Bayramı 🐑</strong>
                <span>Dini Tatil · 4 gün · Arife 25 Mayıs</span>
              </div>
              <div class="upcoming-date">26 MAY</div>
            </div>
            <div class="upcoming-item" onclick="showToast('🏰 29 Mayıs 1453 — Fatih Sultan Mehmet İstanbul\'u fethetti. Bizans İmparatorluğu sona erdi, Orta Çağ kapandı.')">
              <div class="upcoming-dot" style="background:#f59e0b;box-shadow:0 0 8px rgba(245,158,11,0.5)"></div>
              <div class="upcoming-text">
                <strong>İstanbul'un Fethi 🏰</strong>
                <span>29 Mayıs 1453 · Fatih Sultan Mehmet</span>
              </div>
              <div class="upcoming-date">29 MAY</div>
            </div>
            <div class="upcoming-item" onclick="showToast('🌍 5 Haziran Dünya Çevre Günü — BM tarafından 1972\'de ilan edildi. Doğayı korumak için farkındalık günü.')">
              <div class="upcoming-dot dot-warn"></div>
              <div class="upcoming-text">
                <strong>Dünya Çevre Günü 🌍</strong>
                <span>BM · 1972'den beri kutlanıyor</span>
              </div>
              <div class="upcoming-date">5 HAZ</div>
            </div>
            <div class="upcoming-item" onclick="showToast('🇹🇷 15 Temmuz 2016 — Türkiye\'de darbe girişimi yaşandı. Millet demokrasiye sahip çıktı. Resmi tatil ilan edildi.')">
              <div class="upcoming-dot dot-blue"></div>
              <div class="upcoming-text">
                <strong>Demokrasi ve Millî Birlik Günü 🇹🇷</strong>
                <span>Resmi Tatil · 15 Temmuz 2016 anısına</span>
              </div>
              <div class="upcoming-date">15 TEM</div>
            </div>
            <div class="upcoming-item" onclick="showToast('🕊️ 24 Temmuz 1923 — Lozan Barış Antlaşması imzalandı. Türkiye Cumhuriyeti uluslararası arenada tanındı.')">
              <div class="upcoming-dot dot-purple"></div>
              <div class="upcoming-text">
                <strong>Lozan Antlaşması 🕊️</strong>
                <span>24 Temmuz 1923 · Türkiye tanındı</span>
              </div>
              <div class="upcoming-date">24 TEM</div>
            </div>
          </div>
        </div>

        <div class="cal-3d-widget" id="cal-widget">
          <div class="cal-head">
            <button class="cal-nav-btn" onclick="changeMonth(-1)">‹</button>
            <h3 id="cal-title">Mayıs 2026</h3>
            <button class="cal-nav-btn" onclick="changeMonth(1)">›</button>
          </div>
          <div class="cal-days-head">
            <span>Pzt</span><span>Sal</span><span>Çar</span><span>Per</span>
            <span>Cum</span><span>Cmt</span><span>Paz</span>
          </div>
          <div class="cal-days" id="cal-days"></div>
          <div class="cal-event-panel" id="cal-event-panel">
            <div class="cal-no-event" style="color:var(--text-dim);font-size:0.8rem;">📅 Bir tarihe tıkla, tarihi ve tatilleri gör</div>
          </div>
        </div>

      </div>
    </div>
  </section>

<?php include __DIR__ . "/templates/shared/footer.php"; ?>
<script>
// Takvim page - load etkinlikler + render calendar
initPage = async function() {
  if (typeof loadEtkinlikler === "function") await loadEtkinlikler();
  if (typeof renderCalendar === "function") renderCalendar();
};
</script>
<?php include __DIR__ . "/templates/shared/shared-js.php"; ?>
</body></html>
