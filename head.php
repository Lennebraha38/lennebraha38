<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Quantro · Türkiye'nin 3D Nesil Yarışma Platformu. Teknofest, TÜBİTAK ve daha fazlası için profesyonel çözüm ortağınız.">
  <title>Quantro · Türkiye Yarışma Platformu</title>
  <link rel="icon" type="image/png" href="favicon.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Syne:wght@700;800&display=swap" rel="stylesheet">
  <!-- Supabase JS SDK -->
  <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2/dist/umd/supabase.min.js"></script>

  <style>
    /* ===== DESIGN TOKENS — Quantro Brand System ($10K Checklist) ===== */
    /* Logo brand color: #152238 — Deep Navy Blue */
    /* Principle: 3-5 colors, restrained palette, premium through subtlety */
    :root {
      /* Brand Core */
      --brand: #152238;
      --brand-light: #1E3A5F;
      --brand-glow: rgba(21,34,56,0.6);

      /* Surfaces (dark gradient from brand) */
      --bg-deep: #060D18;
      --bg-surface: #0A1628;
      --bg-card: #0F1C33;
      --bg-card-hover: #132244;

      /* Accent — single pop color, used sparingly */
      --primary: #2E6FCF;
      --primary-glow: rgba(46,111,207,0.35);
      --accent: #22D3EE;
      --accent-glow: rgba(34,211,238,0.25);

      /* Semantic */
      --success: #10B981;
      --success-glow: rgba(16,185,129,0.2);
      --warning: #F59E0B;
      --danger: #EF4444;

      /* Text */
      --text-main: #F0F4F8;
      --text-dim: #7B8DA8;
      --text-muted: #4A5E7A;

      /* Borders & Effects */
      --border: rgba(46,111,207,0.12);
      --border-hover: rgba(46,111,207,0.3);
      --border-active: rgba(34,211,238,0.4);
      --glass: rgba(10,22,40,0.85);

      /* Shadows */
      --shadow-sm: 0 2px 8px rgba(0,0,0,0.4);
      --shadow-md: 0 8px 32px rgba(0,0,0,0.5);
      --shadow-lg: 0 20px 60px -15px rgba(0,0,0,0.7), 0 0 40px -10px var(--brand-glow);
      --shadow-glow: 0 0 30px var(--brand-glow);

      /* Transitions */
      --transition-fast: all 0.15s cubic-bezier(0.4,0,0.2,1);
      --transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
      --transition-slow: all 0.5s cubic-bezier(0.4,0,0.2,1);

      /* Radii */
      --radius-sm: 8px;
      --radius-md: 12px;
      --radius-lg: 20px;
      --radius-xl: 28px;
      --radius-2xl: 36px;
    }

    /* ===== LIGHT THEME ===== */
    html[data-theme="light"] {
      /* Brand Core */
      --brand: #152238;
      --brand-light: #1E3A5F;
      --brand-glow: rgba(21,34,56,0.15);

      /* Surfaces — light */
      --bg-deep: #F4F6F9;
      --bg-surface: #FFFFFF;
      --bg-card: #FFFFFF;
      --bg-card-hover: #F0F3F8;

      /* Accent */
      --primary: #2563EB;
      --primary-glow: rgba(37,99,235,0.15);
      --accent: #0891B2;
      --accent-glow: rgba(8,145,178,0.12);

      /* Semantic */
      --success: #059669;
      --success-glow: rgba(5,150,105,0.12);
      --warning: #D97706;
      --danger: #DC2626;

      /* Text */
      --text-main: #152238;
      --text-dim: #5A6F85;
      --text-muted: #8A9BB5;

      /* Borders & Effects */
      --border: rgba(21,34,56,0.10);
      --border-hover: rgba(37,99,235,0.25);
      --border-active: rgba(8,145,178,0.35);
      --glass: rgba(255,255,255,0.88);

      /* Shadows */
      --shadow-sm: 0 2px 8px rgba(0,0,0,0.06);
      --shadow-md: 0 8px 24px rgba(0,0,0,0.08);
      --shadow-lg: 0 16px 48px -12px rgba(0,0,0,0.12), 0 0 30px -8px var(--brand-glow);
      --shadow-glow: 0 0 20px var(--brand-glow);

      /* Light-specific overrides */
      .bg-scene { opacity: 0.25; }
      .noise-overlay { opacity: 0.12; }
      .nav-content { background: rgba(255,255,255,0.92) !important; border-bottom-color: rgba(21,34,56,0.06) !important; }
      #main-nav { background: rgba(255,255,255,0.92); border-bottom-color: rgba(21,34,56,0.06); }
      .section-header h2 { color: #152238; }
      .kanban-col { background: #F4F6F9; border-color: rgba(21,34,56,0.06); }
      .gorev-card { background: #FFFFFF; border-color: rgba(21,34,56,0.08); }
      .gorev-card:hover { border-color: rgba(37,99,235,0.25); }
      .ekip-card { background: #FFFFFF; border-color: rgba(21,34,56,0.08); }
      .ekip-card:hover { border-color: rgba(37,99,235,0.2); }
      .form-control { background: #FFFFFF; color: #152238; border-color: rgba(21,34,56,0.12); }
      .btn-primary { box-shadow: 0 4px 12px rgba(37,99,235,0.2); }
      footer { background: #FFFFFF; border-top-color: rgba(21,34,56,0.06); }
      footer .footer-bottom { border-top-color: rgba(21,34,56,0.06); }
      #gorev-detay-modal { background: rgba(0,0,0,0.3) !important; }
      .mobile-menu { background: rgba(255,255,255,0.98); }
      .mobile-menu a { color: #152238; }
      .auth-panel-left { background: linear-gradient(135deg, #152238 0%, #1a3a5c 100%); }
    }

    /* ===== RESET ===== */
    *, *::before, *::after {
      margin: 0; padding: 0;
      box-sizing: border-box;
      -webkit-tap-highlight-color: transparent;
    }

    html {
      scroll-behavior: smooth;
      scrollbar-width: thin;
      scrollbar-color: var(--primary) var(--bg-deep);
    }

    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: var(--bg-deep); }
    ::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 3px; }

    body {
      background: var(--bg-deep);
      color: var(--text-main);
      font-family: 'Plus Jakarta Sans', sans-serif;
      line-height: 1.6;
      overflow-x: hidden;
    }

    /* ===== 3D ANIMATED BACKGROUND ===== */
    .bg-scene {
      position: fixed;
      inset: 0;
      z-index: -2;
      overflow: hidden;
    }

    .bg-grid {
      position: absolute;
      inset: 0;
      background-image:
        linear-gradient(rgba(46,111,207,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(46,111,207,0.04) 1px, transparent 1px);
      background-size: 64px 64px;
      mask-image: radial-gradient(ellipse 80% 60% at 50% 40%, black 35%, transparent 100%);
    }

    .bg-orb {
      position: absolute;
      border-radius: 50%;
      filter: blur(120px);
      opacity: 0.2;
      animation: orbFloat 30s infinite alternate ease-in-out;
    }

    .bg-orb-1 { width: 700px; height: 700px; top: -200px; right: -200px; background: radial-gradient(circle, #1E3A5F, transparent 70%); }
    .bg-orb-2 { width: 500px; height: 500px; bottom: -150px; left: -150px; background: radial-gradient(circle, #152238, transparent 70%); animation-delay: -10s; }
    .bg-orb-3 { width: 400px; height: 400px; top: 50%; left: 40%; background: radial-gradient(circle, rgba(34,211,238,0.3), transparent 70%); animation-delay: -20s; opacity: 0.1; }

    @keyframes orbFloat {
      0%   { transform: translate(0,0) scale(1); }
      33%  { transform: translate(40px,30px) scale(1.05); }
      66%  { transform: translate(-30px,60px) scale(0.97); }
      100% { transform: translate(20px,20px) scale(1.02); }
    }

    /* ===== NOISE TEXTURE OVERLAY ===== */
    .noise-overlay {
      position: fixed;
      inset: 0;
      z-index: -1;
      opacity: 0.03;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='1'/%3E%3C/svg%3E");
      pointer-events: none;
    }

    /* ===== NAVIGATION ===== */
    nav {
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1000;
      padding: 1.4rem 0;
      transition: var(--transition);
    }

    nav.scrolled {
      background: rgba(10,22,40,0.9);
      backdrop-filter: blur(24px) saturate(180%);
      -webkit-backdrop-filter: blur(24px) saturate(180%);
      padding: 0.8rem 0;
      border-bottom: 1px solid var(--border);
      box-shadow: 0 4px 30px rgba(0,0,0,0.5);
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 2rem;
    }

    .nav-content {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 1rem;
    }

    .logo {
      font-size: 1.5rem;
      font-weight: 800;
      letter-spacing: -1px;
      color: var(--text-main);
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 0.4rem;
      flex-shrink: 0;
    }

    .logo span { color: var(--primary); }

    .logo-dot {
      width: 8px; height: 8px;
      background: var(--accent);
      border-radius: 50%;
      box-shadow: 0 0 12px var(--accent);
      animation: pulse-dot 2s infinite;
    }

    @keyframes pulse-dot {
      0%,100% { opacity: 1; transform: scale(1); }
      50%      { opacity: 0.5; transform: scale(0.7); }
    }

    .nav-links {
      display: flex;
      gap: 2rem;
      align-items: center;
    }

    .nav-links a {
      text-decoration: none;
      color: var(--text-dim);
      font-weight: 600;
      font-size: 0.88rem;
      transition: var(--transition);
      position: relative;
    }

    .nav-links a:hover { color: var(--text-main); }

    .nav-links a::after {
      content: '';
      position: absolute;
      bottom: -4px; left: 0;
      width: 0; height: 2px;
      background: linear-gradient(90deg, var(--primary), var(--accent));
      border-radius: 2px;
      transition: var(--transition);
    }

    .nav-links a:hover::after { width: 100%; }

    /* ===== HAMBURGER ===== */
    .hamburger {
      display: none;
      flex-direction: column;
      gap: 5px;
      cursor: pointer;
      padding: 8px;
      border: none;
      background: transparent;
      z-index: 1100;
    }

    .hamburger span {
      display: block;
      width: 24px; height: 2px;
      background: var(--text-main);
      border-radius: 2px;
      transition: var(--transition);
      transform-origin: center;
    }

    .hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
    .hamburger.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
    .hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

    /* ===== MOBILE MENU ===== */
    .mobile-menu {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(5,5,8,0.98);
      backdrop-filter: blur(20px);
      z-index: 1050;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 2.5rem;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.3s ease;
    }

    .mobile-menu.open {
      display: flex;
      opacity: 1;
      pointer-events: all;
    }

    .mobile-menu a {
      text-decoration: none;
      color: var(--text-main);
      font-size: 2rem;
      font-weight: 800;
      letter-spacing: -1px;
      transition: var(--transition);
      opacity: 0;
      transform: translateY(20px);
    }

    .mobile-menu.open a {
      opacity: 1;
      transform: translateY(0);
    }

    .mobile-menu.open a:nth-child(1) { transition-delay: 0.05s; }
    .mobile-menu.open a:nth-child(2) { transition-delay: 0.1s; }
    .mobile-menu.open a:nth-child(3) { transition-delay: 0.15s; }
    .mobile-menu.open a:nth-child(4) { transition-delay: 0.2s; }
    .mobile-menu.open a:nth-child(5) { transition-delay: 0.25s; }

    .mobile-menu a:hover { color: var(--primary); }

    /* ===== BUTTONS ===== */
    .btn {
      padding: 0.8rem 1.8rem;
      border-radius: 12px;
      font-weight: 700;
      font-size: 0.9rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      cursor: pointer;
      transition: all 0.2s cubic-bezier(0.175,0.885,0.32,1.275);
      border: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      position: relative;
      overflow: hidden;
      text-decoration: none;
      letter-spacing: 0.01em;
      white-space: nowrap;
      -webkit-user-select: none;
      user-select: none;
    }

    .btn-primary {
      background: linear-gradient(135deg, #2E6FCF 0%, #1E3A5F 100%);
      color: white;
      box-shadow: 0 4px 15px rgba(46,111,207,0.3), inset 0 1px 0 rgba(255,255,255,0.1);
    }

    .btn-primary:hover {
      transform: translateY(-2px) scale(1.01);
      box-shadow: 0 8px 30px rgba(46,111,207,0.45), inset 0 1px 0 rgba(255,255,255,0.15);
    }

    .btn-primary:active { transform: translateY(0) scale(0.97); }

    .btn-secondary {
      background: rgba(255,255,255,0.05);
      color: var(--text-main);
      border: 1px solid var(--border);
      backdrop-filter: blur(8px);
    }

    .btn-secondary:hover {
      background: rgba(59,130,246,0.1);
      border-color: rgba(59,130,246,0.4);
      transform: translateY(-3px);
      color: var(--primary);
    }

    .btn-secondary:active { transform: translateY(0); }

    .btn-ghost {
      background: transparent;
      color: var(--text-dim);
      border: 1px solid var(--border);
    }

    .btn-ghost:hover {
      color: var(--text-main);
      border-color: var(--border-hover);
      transform: translateY(-2px);
    }

    .btn-sm {
      padding: 0.55rem 1.1rem;
      font-size: 0.8rem;
      border-radius: 10px;
    }

    /* Ripple */
    .btn .ripple-wave {
      position: absolute;
      border-radius: 50%;
      background: rgba(255,255,255,0.3);
      width: 10px; height: 10px;
      transform: scale(0);
      animation: ripple-anim 0.6s linear;
      pointer-events: none;
    }

    @keyframes ripple-anim { to { transform: scale(40); opacity: 0; } }

    /* ===== HERO ===== */
    .hero {
      min-height: 100vh;
      display: flex;
      align-items: center;
      padding: 7rem 0 4rem;
      position: relative;
      overflow: hidden;
    }

    .hero-content {
      max-width: 820px;
      margin: 0 auto;
      text-align: center;
      position: relative;
      z-index: 2;
    }

    .hero-eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      background: rgba(59,130,246,0.1);
      color: var(--primary);
      padding: 0.45rem 1.1rem;
      border-radius: 100px;
      font-size: 0.75rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 2px;
      border: 1px solid rgba(59,130,246,0.2);
      margin-bottom: 2.5rem;
    }

    .hero-eyebrow::before {
      content: '';
      width: 6px; height: 6px;
      background: var(--primary);
      border-radius: 50%;
      box-shadow: 0 0 8px var(--primary);
      animation: pulse-dot 2s infinite;
    }

    h1 {
      font-size: clamp(2.8rem, 6vw, 5.5rem);
      font-weight: 800;
      line-height: 1.08;
      margin-bottom: 1.8rem;
      letter-spacing: -3px;
      background: linear-gradient(160deg, #ffffff 30%, #64748b 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .hero p {
      font-size: clamp(1rem,2vw,1.2rem);
      color: var(--text-dim);
      margin-bottom: 3rem;
      max-width: 580px;
      margin-left: auto;
      margin-right: auto;
      line-height: 1.8;
    }

    .hero-actions {
      display: flex;
      gap: 1rem;
      justify-content: center;
      flex-wrap: wrap;
    }

    .hero-stats {
      display: flex;
      justify-content: center;
      gap: 3rem;
      margin-top: 5rem;
      flex-wrap: wrap;
    }

    .stat {
      text-align: center;
    }

    .stat-num {
      font-size: 2rem;
      font-weight: 800;
      letter-spacing: -1px;
      background: linear-gradient(135deg, var(--primary), var(--accent));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .stat-label {
      font-size: 0.78rem;
      color: var(--text-dim);
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-top: 0.2rem;
    }

    .stat-divider {
      width: 1px;
      background: var(--border);
      align-self: stretch;
    }

    /* ===== SECTION COMMON ===== */
    section {
      padding: 6rem 0;
    }

    .section-header {
      text-align: center;
      margin-bottom: 4rem;
    }

    .badge-pill {
      display: inline-block;
      background: rgba(59,130,246,0.08);
      color: var(--primary);
      padding: 0.4rem 1rem;
      border-radius: 100px;
      font-size: 0.72rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 2px;
      border: 1px solid rgba(59,130,246,0.18);
      margin-bottom: 1.2rem;
    }

    .section-header h2 {
      font-size: clamp(1.8rem,3.5vw,2.8rem);
      font-weight: 800;
      letter-spacing: -1.5px;
    }

    .section-header p {
      color: var(--text-dim);
      margin-top: 0.8rem;
      font-size: 1rem;
      max-width: 500px;
      margin-left: auto;
      margin-right: auto;
    }

    /* ===== 3D CARDS ===== */
    .cards-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
    }

    .card-3d {
      background: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: var(--radius-xl);
      padding: 2.5rem;
      transition: var(--transition);
      position: relative;
      overflow: hidden;
      transform-style: preserve-3d;
      cursor: default;
    }

    .card-3d::before {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at var(--mx,50%) var(--my,50%), rgba(59,130,246,0.12), transparent 55%);
      opacity: 0;
      transition: opacity 0.3s;
      pointer-events: none;
    }

    .card-3d:hover { border-color: var(--border-hover); box-shadow: var(--shadow-3d); }
    .card-3d:hover::before { opacity: 1; }

    .card-icon {
      width: 56px; height: 56px;
      background: rgba(59,130,246,0.1);
      border: 1px solid rgba(59,130,246,0.2);
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      margin-bottom: 1.5rem;
    }

    .card-3d h3 { font-size: 1.4rem; font-weight: 800; margin-bottom: 0.8rem; letter-spacing: -0.5px; }
    .card-3d p { color: var(--text-dim); font-size: 0.92rem; line-height: 1.7; }

    .card-link {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      color: var(--primary);
      font-weight: 700;
      font-size: 0.85rem;
      margin-top: 1.5rem;
      text-decoration: none;
      cursor: pointer;
      transition: var(--transition);
    }

    .card-link:hover { gap: 0.7rem; }

    .card-link svg { transition: var(--transition); }
    .card-link:hover svg { transform: translateX(3px); }

    /* ===== İLANLAR ===== */
    .ilanlar-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
      gap: 1.5rem;
    }

    .ilan-card {
      background: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: var(--radius-lg);
      padding: 1.5rem;
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
      transition: var(--transition);
      position: relative;
      overflow: hidden;
      height: 310px;
    }

    .ilan-card::after {
      content: '';
      position: absolute;
      top: 0; left: 0;
      width: 4px; height: 100%;
      background: linear-gradient(to bottom, var(--primary), var(--accent));
      transform: scaleY(0);
      transform-origin: top;
      transition: transform 0.35s cubic-bezier(0.4,0,0.2,1);
      border-radius: var(--radius-lg) 0 0 var(--radius-lg);
    }

    .ilan-card:hover {
      border-color: var(--border-hover);
      transform: translateY(-5px);
      box-shadow: var(--shadow-3d);
    }

    .ilan-card:hover::after { transform: scaleY(1); }

    .ilan-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.3rem;
      padding: 0.28rem 0.75rem;
      border-radius: 100px;
      font-size: 0.7rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      width: fit-content;
    }

    .ilan-badge::before {
      content: '';
      width: 5px; height: 5px;
      border-radius: 50%;
      background: currentColor;
    }

    .badge-acik   { background: rgba(16,185,129,0.12); color: #10b981; border: 1px solid rgba(16,185,129,0.25); }
    .badge-yakin  { background: rgba(245,158,11,0.12); color: #f59e0b; border: 1px solid rgba(245,158,11,0.25); }
    .badge-yeni   { background: rgba(59,130,246,0.12); color: var(--primary); border: 1px solid rgba(59,130,246,0.25); }
    .badge-dolu   { background: rgba(239,68,68,0.12); color: #ef4444; border: 1px solid rgba(239,68,68,0.25); }

    .ilan-card h4 { font-size: 1rem; font-weight: 700; letter-spacing: -0.3px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; flex-shrink: 0; }
    .ilan-card p  { font-size: 0.84rem; color: var(--text-dim); line-height: 1.6; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; word-break: break-word; flex-shrink: 0; }
    .ilan-card > .btn, .ilan-card > button { margin-top: auto; flex-shrink: 0; }

    .ilan-tags {
      display: flex;
      flex-wrap: nowrap;
      gap: 0.4rem;
      margin: 0.2rem 0;
      overflow: hidden;
      flex-shrink: 0;
    }

    .ilan-tag {
      background: rgba(255,255,255,0.05);
      border: 1px solid var(--border);
      color: var(--text-dim);
      padding: 0.2rem 0.6rem;
      border-radius: 6px;
      font-size: 0.72rem;
      font-weight: 600;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 120px;
    }

    .ilan-meta {
      display: flex;
      gap: 1rem;
      font-size: 0.78rem;
      color: var(--text-dim);
      flex-wrap: wrap;
      overflow: hidden;
      flex-shrink: 0;
    }

    .ilan-meta span {
      display: flex;
      align-items: center;
      gap: 0.3rem;
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
    }

    /* ===== STATS BAND ===== */
    .stats-band {
      background: var(--bg-surface);
      border-top: 1px solid var(--border);
      border-bottom: 1px solid var(--border);
      padding: 3.5rem 0;
    }

    .stats-row {
      display: flex;
      justify-content: space-around;
      align-items: center;
      flex-wrap: wrap;
      gap: 2rem;
    }

    .stat-item { text-align: center; }
    .stat-big-num {
      font-size: 3rem;
      font-weight: 800;
      letter-spacing: -2px;
      background: linear-gradient(135deg, var(--primary), var(--accent));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .stat-big-label {
      font-size: 0.82rem;
      color: var(--text-dim);
      font-weight: 600;
      letter-spacing: 0.5px;
      margin-top: 0.3rem;
    }

    /* ===== CALENDAR ===== */
    .calendar-wrap {
      background: var(--bg-surface);
      border: 1px solid var(--border);
      border-radius: 40px;
      padding: 4rem;
      display: grid;
      grid-template-columns: 1fr 1.6fr;
      gap: 5rem;
      align-items: start;
      box-shadow: var(--shadow-3d);
    }

    .cal-info h2 {
      font-size: 2.2rem;
      font-weight: 800;
      letter-spacing: -1.5px;
      margin-bottom: 1rem;
    }

    .cal-info p { color: var(--text-dim); margin-bottom: 2rem; line-height: 1.8; }

    .upcoming-list { display: flex; flex-direction: column; gap: 0.8rem; }

    .upcoming-item {
      display: flex;
      align-items: center;
      gap: 1rem;
      background: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 1rem 1.2rem;
      transition: var(--transition);
      cursor: pointer;
    }

    .upcoming-item:hover {
      border-color: var(--border-hover);
      transform: translateX(5px);
    }

    .upcoming-dot {
      width: 10px; height: 10px;
      border-radius: 50%;
      flex-shrink: 0;
    }

    .dot-blue  { background: var(--primary); box-shadow: 0 0 8px var(--primary-glow); }
    .dot-green { background: var(--success); box-shadow: 0 0 8px rgba(16,185,129,0.5); }
    .dot-warn  { background: var(--warning); box-shadow: 0 0 8px rgba(245,158,11,0.5); }
    .dot-purple{ background: var(--secondary); box-shadow: 0 0 8px rgba(139,92,246,0.5); }

    .upcoming-text { flex: 1; }
    .upcoming-text strong { font-size: 0.88rem; font-weight: 700; display: block; }
    .upcoming-text span { font-size: 0.78rem; color: var(--text-dim); }

    .upcoming-date {
      font-size: 0.72rem;
      font-weight: 700;
      color: var(--text-dim);
      font-family: 'JetBrains Mono', monospace;
    }

    .cal-3d-widget {
      background: var(--bg-card);
      border-radius: 28px;
      padding: 2rem;
      border: 1px solid var(--border);
      transform: perspective(1200px) rotateY(-12deg) rotateX(6deg);
      box-shadow: 30px 30px 80px rgba(0,0,0,0.6), 0 0 40px rgba(59,130,246,0.08);
      transition: transform 0.6s cubic-bezier(0.4,0,0.2,1), box-shadow 0.6s;
    }

    .cal-3d-widget:hover {
      transform: perspective(1200px) rotateY(0) rotateX(0);
      box-shadow: 0 10px 40px rgba(0,0,0,0.4), 0 0 30px rgba(59,130,246,0.12);
    }

    .cal-head {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.8rem;
    }

    .cal-head h3 { font-size: 1.1rem; font-weight: 700; }

    .cal-nav-btn {
      background: rgba(255,255,255,0.05);
      border: 1px solid var(--border);
      border-radius: 8px;
      width: 30px; height: 30px;
      color: var(--text-dim);
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: var(--transition);
      font-size: 0.85rem;
    }

    .cal-nav-btn:hover { background: rgba(59,130,246,0.15); color: var(--primary); border-color: rgba(59,130,246,0.3); }

    .cal-days-head {
      display: grid;
      grid-template-columns: repeat(7,1fr);
      text-align: center;
      margin-bottom: 0.8rem;
    }

    .cal-days-head span {
      font-size: 0.65rem;
      font-weight: 700;
      color: var(--text-dim);
      text-transform: uppercase;
      padding: 0.4rem 0;
    }

    .cal-days {
      display: grid;
      grid-template-columns: repeat(7,1fr);
      gap: 4px;
    }

    .cal-day {
      aspect-ratio: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 8px;
      font-size: 0.78rem;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      color: var(--text-dim);
      position: relative;
    }

    .cal-day:hover { background: rgba(59,130,246,0.15); color: var(--primary); }
    .cal-day.today { background: var(--primary); color: white !important; box-shadow: 0 0 15px var(--primary-glow); font-weight: 800; }
    .cal-day.selected:not(.today) { background: rgba(6,182,212,0.18); color: var(--accent); border: 1.5px solid rgba(6,182,212,0.5); font-weight: 800; }
    .cal-day.has-event::after {
      content: '';
      position: absolute;
      bottom: 3px; left: 50%;
      transform: translateX(-50%);
      width: 4px; height: 4px;
      border-radius: 50%;
      background: var(--accent);
    }
    .cal-day.faded { opacity: 0.3; cursor: default; }
    .cal-day.current-month { color: var(--text-main); }

    /* ===== CAL EVENT PANEL ===== */
    .cal-event-panel {
      margin-top: 1.2rem;
      background: var(--bg-surface);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 1rem 1.2rem;
      min-height: 60px;
      transition: var(--transition);
      font-size: 0.82rem;
    }
    .cal-event-panel-date {
      font-size: 0.72rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      color: var(--accent);
      margin-bottom: 0.6rem;
    }
    .cal-event-item {
      display: flex;
      align-items: flex-start;
      gap: 0.6rem;
      padding: 0.55rem 0;
      border-bottom: 1px solid var(--border);
    }
    .cal-event-item:last-child { border-bottom: none; }
    .cal-event-dot {
      width: 8px; height: 8px;
      border-radius: 50%;
      flex-shrink: 0;
      margin-top: 4px;
    }
    .cal-event-item strong { display: block; font-weight: 700; color: var(--text-main); margin-bottom: 0.15rem; }
    .cal-event-item span { color: var(--text-dim); font-size: 0.76rem; line-height: 1.4; }
    .cal-no-event { color: var(--text-dim); text-align: center; padding: 0.5rem 0; }

    /* ===== CONTACT — YENİ GÜÇLENDİRİLMİŞ ===== */
    #iletisim {
      padding: 8rem 0;
      background: linear-gradient(to bottom, transparent, var(--bg-surface) 40%);
      position: relative;
      overflow: hidden;
    }
    #iletisim::before {
      content: '';
      position: absolute;
      top: -200px; left: 50%; transform: translateX(-50%);
      width: 900px; height: 600px;
      background: radial-gradient(ellipse, rgba(59,130,246,0.05) 0%, transparent 70%);
      pointer-events: none;
    }

    .contact-layout {
      display: grid;
      grid-template-columns: 1fr 1.4fr;
      gap: 3rem;
      align-items: start;
    }

    /* LEFT SIDE */
    .contact-left { display: flex; flex-direction: column; gap: 1.5rem; }

    .contact-intro-card {
      background: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: 28px;
      padding: 2rem;
      position: relative; overflow: hidden;
    }
    .contact-intro-card::before {
      content: '';
      position: absolute; top: 0; left: 0; right: 0; height: 3px;
      background: linear-gradient(90deg, var(--primary), var(--accent), var(--secondary));
    }
    .contact-intro-card h3 {
      font-size: 1.5rem; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 0.6rem;
    }
    .contact-intro-card > p {
      color: var(--text-dim); font-size: 0.88rem; line-height: 1.75; margin-bottom: 1.5rem;
    }

    .contact-stat-row {
      display: grid; grid-template-columns: 1fr 1fr; gap: 0.8rem; margin-bottom: 1.5rem;
    }
    .contact-stat-chip {
      background: var(--bg-surface); border: 1px solid var(--border);
      border-radius: 14px; padding: 0.9rem 1rem;
      text-align: center;
    }
    .contact-stat-chip .csn {
      font-size: 1.5rem; font-weight: 800;
      background: linear-gradient(135deg, var(--primary), var(--accent));
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .contact-stat-chip .csl {
      font-size: 0.68rem; color: var(--text-dim); font-weight: 600;
      text-transform: uppercase; letter-spacing: 0.5px; margin-top: 0.15rem;
    }

    /* Channel buttons */
    .contact-channels { display: flex; flex-direction: column; gap: 0.7rem; }
    .contact-channel-btn {
      display: flex; align-items: center; gap: 1rem;
      background: var(--bg-card); border: 1px solid var(--border);
      border-radius: 16px; padding: 1rem 1.2rem;
      text-decoration: none; color: var(--text-main);
      transition: var(--transition); cursor: pointer;
    }
    .contact-channel-btn:hover {
      border-color: var(--border-hover);
      transform: translateX(6px);
      box-shadow: 0 8px 24px rgba(0,0,0,0.3);
    }
    .contact-channel-icon {
      width: 40px; height: 40px; border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.1rem; flex-shrink: 0;
    }
    .contact-channel-info { flex: 1; }
    .contact-channel-name { font-size: 0.88rem; font-weight: 700; }
    .contact-channel-desc { font-size: 0.72rem; color: var(--text-dim); margin-top: 0.1rem; }
    .contact-channel-arrow {
      color: var(--text-dim); font-size: 0.9rem;
      transition: var(--transition);
    }
    .contact-channel-btn:hover .contact-channel-arrow { color: var(--primary); transform: translateX(3px); }

    /* FAQ chips */
    .contact-faq-card {
      background: var(--bg-card); border: 1px solid var(--border);
      border-radius: 24px; padding: 1.6rem;
    }
    .contact-faq-card h4 {
      font-size: 0.82rem; font-weight: 700; color: var(--text-dim);
      text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1rem;
    }
    .faq-chips { display: flex; flex-direction: column; gap: 0.5rem; }
    .faq-chip {
      display: flex; align-items: center; gap: 0.7rem;
      background: var(--bg-surface); border: 1px solid var(--border);
      border-radius: 10px; padding: 0.65rem 0.9rem;
      font-size: 0.82rem; color: var(--text-dim); cursor: pointer;
      transition: var(--transition);
    }
    .faq-chip:hover {
      border-color: rgba(59,130,246,0.3); color: var(--text-main);
      background: rgba(59,130,246,0.05);
    }
    .faq-chip span { font-size: 1rem; }

    /* RIGHT SIDE — Form */
    .contact-form-card {
      background: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: 32px;
      padding: 3rem;
      box-shadow: var(--shadow-3d);
      position: relative; overflow: hidden;
    }
    .contact-form-card::after {
      content: '';
      position: absolute; bottom: -80px; right: -80px;
      width: 250px; height: 250px;
      background: radial-gradient(circle, rgba(139,92,246,0.08), transparent 60%);
      pointer-events: none;
    }

    .contact-form-header {
      display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;
    }
    .contact-form-header-icon {
      width: 48px; height: 48px;
      background: linear-gradient(135deg, var(--primary), var(--accent));
      border-radius: 14px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.3rem;
      box-shadow: 0 0 20px rgba(59,130,246,0.35);
    }
    .contact-form-header h3 { font-size: 1.4rem; font-weight: 800; letter-spacing: -0.5px; }
    .contact-form-header p { font-size: 0.78rem; color: var(--text-dim); margin-top: 0.2rem; }

    /* AI suggestion bar */
    .ai-suggest-bar {
      background: linear-gradient(135deg, rgba(59,130,246,0.08), rgba(6,182,212,0.06));
      border: 1px solid rgba(59,130,246,0.2);
      border-radius: 14px; padding: 0.9rem 1.1rem;
      margin-bottom: 1.5rem;
      display: flex; align-items: center; gap: 0.8rem;
      cursor: pointer; transition: var(--transition);
    }
    .ai-suggest-bar:hover { border-color: rgba(59,130,246,0.4); background: rgba(59,130,246,0.12); }
    .ai-suggest-bar .ai-icon { font-size: 1.1rem; }
    .ai-suggest-bar-text { flex: 1; font-size: 0.82rem; color: var(--text-dim); }
    .ai-suggest-bar-text strong { color: var(--primary); }
    .ai-suggest-bar-cta {
      font-size: 0.72rem; font-weight: 700; color: var(--primary);
      background: rgba(59,130,246,0.12); border: 1px solid rgba(59,130,246,0.25);
      border-radius: 100px; padding: 0.25rem 0.7rem; white-space: nowrap;
    }

    /* Step indicator */
    .form-steps {
      display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.8rem;
    }
    .form-step {
      display: flex; align-items: center; gap: 0.4rem;
      font-size: 0.72rem; font-weight: 700; color: var(--text-dim);
    }
    .form-step.active { color: var(--primary); }
    .form-step-num {
      width: 22px; height: 22px; border-radius: 50%;
      background: var(--bg-surface); border: 1px solid var(--border);
      display: flex; align-items: center; justify-content: center;
      font-size: 0.65rem; font-weight: 800;
    }
    .form-step.active .form-step-num {
      background: var(--primary); border-color: var(--primary); color: white;
    }
    .form-step.done .form-step-num {
      background: var(--success); border-color: var(--success); color: white;
    }
    .form-step.done { color: var(--success); }
    .form-step-line { flex: 1; height: 1px; background: var(--border); }

    /* Character counter */
    .form-group-wrap { position: relative; }
    .char-counter {
      position: absolute; bottom: 0.75rem; right: 0.9rem;
      font-size: 0.68rem; color: var(--text-dim); pointer-events: none;
    }

    /* Send button with gradient pulse */
    .contact-send-btn {
      width: 100%; justify-content: center;
      background: linear-gradient(135deg, #3b82f6 0%, #2563eb 60%, #7c3aed 100%);
      color: white; font-size: 1rem; padding: 1rem;
      border-radius: 14px; border: none; cursor: pointer;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 800; letter-spacing: 0.02em;
      display: flex; align-items: center; gap: 0.6rem;
      transition: all 0.25s cubic-bezier(0.175,0.885,0.32,1.275);
      box-shadow: 0 6px 20px rgba(59,130,246,0.4), inset 0 1px 0 rgba(255,255,255,0.15);
      position: relative; overflow: hidden;
    }
    .contact-send-btn:hover {
      transform: translateY(-3px) scale(1.01);
      box-shadow: 0 14px 36px rgba(59,130,246,0.55);
    }
    .contact-send-btn:active { transform: translateY(0) scale(0.98); }
    .contact-send-btn::before {
      content: '';
      position: absolute; inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
      pointer-events: none;
    }

    .contact-footnote {
      display: flex; align-items: center; justify-content: center; gap: 1.5rem;
      margin-top: 1rem; flex-wrap: wrap;
    }
    .contact-footnote span {
      display: flex; align-items: center; gap: 0.4rem;
      font-size: 0.72rem; color: var(--text-dim);
    }

    @media (max-width: 900px) {
      .contact-layout { grid-template-columns: 1fr; }
      .contact-form-card { padding: 2rem 1.5rem; border-radius: 24px; }
    }

    .form-label {
      display: block;
      font-size: 0.82rem;
      font-weight: 700;
      color: var(--text-dim);
      margin-bottom: 0.5rem;
      letter-spacing: 0.3px;
    }

    .form-control {
      width: 100%;
      background: rgba(255,255,255,0.04);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 0.85rem 1.1rem;
      color: var(--text-main);
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 0.9rem;
      transition: var(--transition);
      outline: none;
    }

    .form-control:focus {
      border-color: var(--primary);
      background: rgba(59,130,246,0.06);
      box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
    }

    .form-control::placeholder { color: rgba(148,163,184,0.5); }
    textarea.form-control { resize: vertical; min-height: 120px; }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

    .form-group { margin-bottom: 1.2rem; }

    .form-label {
      display: block;
      font-size: 0.82rem;
      font-weight: 700;
      color: var(--text-dim);
      margin-bottom: 0.5rem;
      letter-spacing: 0.3px;
    }

    .form-control {
      width: 100%;
      background: rgba(255,255,255,0.04);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 0.85rem 1.1rem;
      color: var(--text-main);
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 0.9rem;
      transition: var(--transition);
      outline: none;
    }

    .form-control:focus {
      border-color: var(--primary);
      background: rgba(59,130,246,0.06);
      box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
    }

    .form-control::placeholder { color: rgba(148,163,184,0.5); }
    textarea.form-control { resize: vertical; min-height: 120px; }

    select.form-control {
      appearance: none; -webkit-appearance: none;
      background-color: #1a1a2e;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
      background-repeat: no-repeat; background-position: right 1rem center;
      padding-right: 2.5rem; color: #f8fafc !important; cursor: pointer;
    }
    select.form-control option { background-color: #1a1a2e; color: #f8fafc; }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

    /* ===== FOOTER ===== */
    footer {
      padding: 4rem 0 3rem;
      border-top: 1px solid var(--border);
    }

    .footer-inner {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 2rem;
    }

    .footer-brand { display: flex; flex-direction: column; gap: 0.5rem; }
    .footer-brand .logo { font-size: 1.3rem; }
    .footer-brand p { font-size: 0.82rem; color: var(--text-dim); max-width: 280px; }

    .footer-links {
      display: flex;
      gap: 2rem;
      flex-wrap: wrap;
    }

    .footer-links a {
      text-decoration: none;
      color: var(--text-dim);
      font-size: 0.85rem;
      font-weight: 600;
      transition: var(--transition);
    }

    .footer-links a:hover { color: var(--text-main); }

    .footer-bottom {
      margin-top: 3rem;
      padding-top: 2rem;
      border-top: 1px solid var(--border);
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 1rem;
      font-size: 0.8rem;
      color: var(--text-dim);
    }

    /* ===== TOAST ===== */
    #toast {
      position: fixed;
      bottom: 2.5rem;
      left: 50%;
      transform: translateX(-50%) translateY(120px);
      background: linear-gradient(135deg, #1e3a5f, #1e293b);
      color: white;
      padding: 0.9rem 2rem;
      border-radius: 100px;
      font-weight: 700;
      font-size: 0.875rem;
      z-index: 3000;
      border: 1px solid rgba(59,130,246,0.3);
      box-shadow: 0 10px 40px rgba(0,0,0,0.5), 0 0 20px rgba(59,130,246,0.2);
      transition: transform 0.5s cubic-bezier(0.175,0.885,0.32,1.275), opacity 0.5s;
      pointer-events: none;
      white-space: nowrap;
      display: flex;
      align-items: center;
      gap: 0.6rem;
    }

    #toast.show { transform: translateX(-50%) translateY(0); }

    /* ===== SCROLL REVEAL ===== */
    .reveal {
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.7s ease, transform 0.7s ease;
    }

    .reveal.visible { opacity: 1; transform: translateY(0); }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
      .container { padding: 0 1.25rem; }
      section { padding: 4rem 0; }

      .nav-links { display: none; }
      .hamburger { display: flex; }

      h1 { letter-spacing: -2px; }

      .cards-grid { grid-template-columns: 1fr; gap: 1.2rem; }
      .ilanlar-grid { grid-template-columns: 1fr; }

      .calendar-wrap { grid-template-columns: 1fr; padding: 2rem; gap: 2.5rem; }
      .cal-3d-widget { transform: none; box-shadow: 0 10px 40px rgba(0,0,0,0.4); }

      .contact-card { padding: 2.5rem 1.5rem; border-radius: 28px; }
      .form-row { grid-template-columns: 1fr; }

      .hero-stats { gap: 1.5rem; }
      .stat-divider { display: none; }

      .stats-row { gap: 1.5rem; }

      .footer-inner { flex-direction: column; align-items: flex-start; }
      .footer-bottom { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
    }

    @media (max-width: 480px) {
      .hero { padding: 6rem 0 3rem; }
      .hero-actions { flex-direction: column; align-items: center; }
      .hero-actions .btn { width: 100%; max-width: 300px; }
    }

    /* ===== CUSTOM CURSOR ===== */
    #v-cursor {
      position: fixed; width: 12px; height: 12px;
      background: var(--accent); border-radius: 50%;
      pointer-events: none; z-index: 9999;
      left: 0; top: 0;
      box-shadow: 0 0 18px var(--accent), 0 0 35px rgba(6,182,212,.4);
      transition: width .15s, height .15s, opacity .2s;
      mix-blend-mode: screen;
      will-change: transform;
    }
    #v-cursor-ring {
      position: fixed; width: 36px; height: 36px;
      border: 1px solid rgba(6,182,212,.35);
      border-radius: 50%; pointer-events: none; z-index: 9998;
      left: 0; top: 0;
      transition: width .15s, height .15s, border-color .15s;
      will-change: transform;
    }

    /* ===== PARTICLE CANVAS ===== */
    #v-bg-canvas {
      position: fixed; inset: 0; z-index: -3;
      pointer-events: none; opacity: .65;
    }

    /* ===== HERO 2-COLUMN LAYOUT ===== */
    .hero-layout {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 4rem;
      align-items: center;
      width: 100%;
    }
    /* Center-only layout goes away when we use 2-col */
    .hero-content {
      max-width: none !important;
      text-align: left !important;
      margin: 0 !important;
    }
    .hero-eyebrow {
      display: inline-flex !important;
      align-items: center;
      gap: .6rem;
      font-family: 'JetBrains Mono', monospace;
      font-size: .72rem !important;
      letter-spacing: .15em !important;
      color: var(--accent) !important;
      background: rgba(6,182,212,.08) !important;
      border-color: rgba(6,182,212,.2) !important;
    }
    .hero-eyebrow::before {
      content: '';
      flex-shrink: 0;
      width: 24px; height: 1px;
      background: linear-gradient(90deg, transparent, var(--accent));
    }
    .hero-eyebrow::after {
      content: '';
      flex-shrink: 0;
      width: 24px; height: 1px;
      background: linear-gradient(90deg, var(--accent), transparent);
    }
    /* visionary h1 lines */
    .hero h1 {
      font-family: 'Syne', sans-serif !important;
      font-size: clamp(2.8rem, 5.5vw, 5.8rem) !important;
      letter-spacing: -3px !important;
    }
    .h1-l1, .h1-l2 {
      display: block;
      background: linear-gradient(135deg,#fff 30%,#94a3b8 100%);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .h1-l3 {
      display: block;
      background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 60%, #a5f3fc 100%);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
      background-clip: text;
      filter: drop-shadow(0 0 28px rgba(6,182,212,.3));
    }
    /* hero actions left-align */
    .hero .hero-actions { justify-content: flex-start; }
    .hero .hero-stats  { justify-content: flex-start; }
    .hero p { margin-left: 0 !important; margin-right: 0 !important; max-width: 480px !important; }

    /* ===== HERO VISUAL (sphere side) ===== */
    .hero-visual {
      position: relative;
      display: flex; align-items: center; justify-content: center;
    }
    #v-sphere-canvas {
      display: block; width: 100%; max-width: 500px;
      position: relative; z-index: 2;
      filter: drop-shadow(0 0 50px rgba(59,130,246,.18));
    }
    .sphere-glow {
      position: absolute; width: 60%; padding-top: 60%;
      top: 50%; left: 50%; transform: translate(-50%,-50%);
      background: radial-gradient(circle,rgba(59,130,246,.15),rgba(6,182,212,.08) 40%,transparent 70%);
      border-radius: 50%; pointer-events: none; z-index: 1;
      animation: v-glow-pulse 4s ease infinite;
    }
    .sphere-orbit {
      position: absolute; border-radius: 50%;
      border: 1px solid rgba(59,130,246,.1);
      animation: v-orbit-spin 9s linear infinite;
    }
    .sphere-orbit:nth-child(1) { width:110%; padding-top:110%; top:50%; left:50%; transform:translate(-50%,-50%) rotateX(60deg); }
    .sphere-orbit:nth-child(2) { width:130%; padding-top:130%; top:50%; left:50%; transform:translate(-50%,-50%) rotateX(60deg); animation-direction:reverse; animation-duration:13s; border-color:rgba(6,182,212,.07); }
    @keyframes v-glow-pulse { 0%,100%{opacity:.8;transform:translate(-50%,-50%) scale(1)} 50%{opacity:1;transform:translate(-50%,-50%) scale(1.1)} }
    @keyframes v-orbit-spin  { to{transform:translate(-50%,-50%) rotateX(60deg) rotate(360deg)} }

    /* ===== FLOOR GRID ===== */
    .floor-grid {
      position: absolute;
      bottom: -60px; left: -25%; width: 150%; height: 55%;
      background-image:
        linear-gradient(rgba(59,130,246,.1) 1px, transparent 1px),
        linear-gradient(90deg, rgba(59,130,246,.1) 1px, transparent 1px);
      background-size: 70px 70px;
      transform: perspective(700px) rotateX(72deg);
      transform-origin: center bottom;
      mask-image: radial-gradient(ellipse 75% 80% at 50% 100%, black 20%, transparent 75%);
      -webkit-mask-image: radial-gradient(ellipse 75% 80% at 50% 100%, black 20%, transparent 75%);
      pointer-events: none; z-index: 0;
    }

    /* ===== FLOATING CUBES ===== */
    .f-cube {
      position: absolute; transform-style: preserve-3d;
      pointer-events: none; z-index: 0;
      animation: v-cube-float 22s linear infinite;
    }
    .f-cube.c1 { width:70px; height:70px; top:18%; left:5%;  --hs:35px; animation-duration:22s; }
    .f-cube.c2 { width:45px; height:45px; top:65%; left:2%;  --hs:22px; animation-duration:17s; animation-delay:-5s; }
    .f-cube.c3 { width:85px; height:85px; top:22%; right:4%; --hs:42px; animation-duration:26s; animation-delay:-11s; }
    .f-cube.c4 { width:50px; height:50px; top:68%; right:7%; --hs:25px; animation-duration:19s; animation-delay:-4s; }
    .cf {
      position: absolute; width:100%; height:100%;
      border: 1px solid rgba(59,130,246,.18);
      background: rgba(59,130,246,.02); border-radius: 2px;
    }
    .cf:nth-child(1){ transform: translateZ(var(--hs)); }
    .cf:nth-child(2){ transform: rotateY(180deg) translateZ(var(--hs)); }
    .cf:nth-child(3){ transform: rotateY(-90deg) translateZ(var(--hs)); }
    .cf:nth-child(4){ transform: rotateY(90deg)  translateZ(var(--hs)); }
    .cf:nth-child(5){ transform: rotateX(90deg)  translateZ(var(--hs)); }
    .cf:nth-child(6){ transform: rotateX(-90deg) translateZ(var(--hs)); }
    @keyframes v-cube-float {
      0%   { transform: rotateX(0deg)   rotateY(0deg)   rotateZ(0deg)   translateY(0px); }
      25%  { transform: rotateX(90deg)  rotateY(45deg)  rotateZ(30deg)  translateY(-22px); }
      50%  { transform: rotateX(180deg) rotateY(90deg)  rotateZ(60deg)  translateY(0px); }
      75%  { transform: rotateX(270deg) rotateY(135deg) rotateZ(90deg)  translateY(-16px); }
      100% { transform: rotateX(360deg) rotateY(180deg) rotateZ(120deg) translateY(0px); }
    }

    /* ===== SCROLL HINT ===== */
    .scroll-hint {
      position: absolute; bottom: 2rem; left: 50%;
      transform: translateX(-50%);
      display: flex; flex-direction: column; align-items: center; gap: .4rem;
      color: var(--text-dim); font-size: .68rem; font-weight: 600;
      letter-spacing: .1em; text-transform: uppercase; z-index: 5;
      animation: v-fade-in 1s 2s both;
    }
    .scroll-line {
      width: 1px; height: 38px;
      background: linear-gradient(to bottom, var(--primary), transparent);
      animation: v-scroll-line 1.8s ease infinite;
    }
    @keyframes v-fade-in    { from{opacity:0} to{opacity:1} }
    @keyframes v-scroll-line {
      0%   { transform: scaleY(0); transform-origin: top; }
      50%  { transform: scaleY(1); transform-origin: top; }
      51%  { transform: scaleY(1); transform-origin: bottom; }
      100% { transform: scaleY(0); transform-origin: bottom; }
    }

    /* ===== SECTION HEADINGS — Syne font ===== */
    .section-header h2, .cal-info h2,
    .contact-card h2, footer .logo {
      font-family: 'Syne', sans-serif;
    }

    /* ===== HERO SLIDE-IN ANIMATIONS ===== */
    @keyframes v-slide-up { from{opacity:0;transform:translateY(35px)} to{opacity:1;transform:none} }
    .hero-eyebrow   { animation: v-slide-up .7s .2s both; }
    .hero h1        { animation: v-slide-up .7s .4s both; }
    .hero p         { animation: v-slide-up .7s .6s both; }
    .hero-actions   { animation: v-slide-up .7s .75s both; }
    .hero-stats     { animation: v-slide-up .7s .9s both; }
    .hero-visual    { animation: v-sphere-in 1.1s .5s both; }
    @keyframes v-sphere-in { from{opacity:0;transform:translateX(45px) scale(.9)} to{opacity:1;transform:none} }

    /* ===== BAŞVURU MODAL ===== */
    .basvur-overlay {
      position: fixed; inset: 0; z-index: 8000;
      background: rgba(0,0,0,0.82); backdrop-filter: blur(14px);
      display: flex; align-items: center; justify-content: center; padding: 1.5rem;
      opacity: 0; pointer-events: none;
      transition: opacity 0.25s ease;
    }
    .basvur-overlay.open { opacity: 1; pointer-events: all; }

    .basvur-modal {
      background: var(--bg-card); border: 1px solid var(--border-hover);
      border-radius: 24px; width: 100%; max-width: 540px;
      padding: 2rem 2.2rem;
      box-shadow: 0 40px 100px rgba(0,0,0,0.7);
      transform: translateY(30px);
      transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
      max-height: 90vh; overflow-y: auto;
    }
    .basvur-overlay.open .basvur-modal { transform: none; }
    .basvur-modal-header {
      display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 1.5rem;
    }
    .basvur-modal-header h3 { font-size: 1.2rem; font-weight: 800; }
    .basvur-modal-header p { font-size: 0.8rem; color: var(--text-dim); margin-top: 0.3rem; }
    .basvur-method-tabs {
      display: flex; gap: 0.5rem; margin-bottom: 1.5rem;
    }
    .basvur-tab {
      flex: 1; padding: 0.6rem; border-radius: 10px; border: 1px solid var(--border);
      background: var(--bg-surface); color: var(--text-dim); font-weight: 700; font-size: 0.8rem;
      cursor: pointer; transition: var(--transition); text-align: center;
    }
    .basvur-tab.active { background: rgba(59,130,246,0.15); border-color: rgba(59,130,246,0.4); color: var(--primary); }

    /* ===== PROFİLLER SECTION ===== */
    #profiller { background: var(--bg-deep); }

    .profil-search-bar {
      display: flex; gap: 0.75rem; margin-bottom: 2rem; flex-wrap: wrap;
    }
    .profil-search-input {
      flex: 1; min-width: 220px;
      background: var(--bg-card); border: 1px solid var(--border);
      border-radius: 12px; padding: 0.8rem 1.1rem;
      color: var(--text-main); font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 0.9rem; outline: none; transition: var(--transition);
    }
    .profil-search-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(59,130,246,0.12); }
    .profil-filter-select {
      background: #1a1a2e; border: 1px solid var(--border);
      border-radius: 12px; padding: 0.8rem 2.4rem 0.8rem 1.1rem;
      color: #f8fafc; font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 0.87rem; outline: none; cursor: pointer; transition: var(--transition);
      appearance: none; -webkit-appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
      background-repeat: no-repeat; background-position: right 0.9rem center;
    }
    .profil-filter-select option { background-color: #1a1a2e; color: #f8fafc; }
    .profil-filter-select:focus { border-color: var(--primary); }

    .profiller-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 1.5rem;
    }

    .profil-card {
      background: var(--bg-card); border: 1px solid var(--border);
      border-radius: var(--radius-xl); padding: 1.8rem;
      display: flex; flex-direction: column; gap: 1rem;
      transition: var(--transition); position: relative; overflow: hidden;
    }
    .profil-card::before {
      content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
      background: linear-gradient(90deg, var(--primary), var(--accent));
      transform: scaleX(0); transform-origin: left;
      transition: transform 0.35s cubic-bezier(0.4,0,0.2,1);
      border-radius: var(--radius-xl) var(--radius-xl) 0 0;
    }
    .profil-card:hover { border-color: var(--border-hover); transform: translateY(-4px); box-shadow: var(--shadow-3d); }
    .profil-card:hover::before { transform: scaleX(1); }

    .profil-top {
      display: flex; align-items: center; gap: 1.1rem;
    }
    .profil-top > div:not(.profil-available) {
      flex: 1; min-width: 0;
    }
    .profil-info-name { font-size: 1rem; font-weight: 800; letter-spacing: -0.3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .profil-info-role { font-size: 0.75rem; color: var(--text-dim); margin-top: 0.15rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .profil-avatar {
      width: 72px; height: 72px; border-radius: 18px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.6rem; font-weight: 800; flex-shrink: 0;
      border: 1.5px solid rgba(255,255,255,0.1);
      box-shadow: 0 4px 16px rgba(0,0,0,0.35), inset 0 1px 0 rgba(255,255,255,0.08);
      transition: var(--transition);
      position: relative;
      overflow: hidden;
    }
    .profil-avatar::after {
      content: '';
      position: absolute; inset: 0;
      background: linear-gradient(160deg, rgba(255,255,255,0.08) 0%, transparent 60%);
      pointer-events: none;
    }
    .profil-card:hover .profil-avatar {
      border-color: rgba(59,130,246,0.4);
      box-shadow: 0 6px 22px rgba(0,0,0,0.45), 0 0 16px rgba(59,130,246,0.18);
      transform: scale(1.04);
    }
    .profil-available {
      margin-left: auto; display: flex; align-items: center; gap: 0.35rem;
      font-size: 0.68rem; font-weight: 700; color: var(--success); flex-shrink: 0;
    }
    .profil-available span { width: 6px; height: 6px; background: var(--success); border-radius: 50%; box-shadow: 0 0 6px var(--success); }

    .profil-bio { font-size: 0.83rem; color: var(--text-dim); line-height: 1.65; }

    .profil-skills { display: flex; flex-wrap: wrap; gap: 0.4rem; }
    .profil-skill {
      background: rgba(59,130,246,0.08); border: 1px solid rgba(59,130,246,0.18);
      color: var(--primary); padding: 0.2rem 0.6rem; border-radius: 6px;
      font-size: 0.7rem; font-weight: 700;
    }

    .profil-meta {
      display: flex; gap: 1rem; font-size: 0.75rem; color: var(--text-dim);
      flex-wrap: wrap;
    }
    .profil-meta span { display: flex; align-items: center; gap: 0.3rem; }

    .profil-actions { display: flex; gap: 0.6rem; margin-top: 0.25rem; }
    .profil-actions .btn { flex: 1; font-size: 0.78rem; padding: 0.5rem 0.8rem; }

    .profil-card[data-hidden="true"] { display: none; }

    /* ===== İLAN DETAY MODAL ===== */
    .ilan-detail-overlay {
      position: fixed; inset: 0; z-index: 9000;
      background: rgba(0,0,0,0.88); backdrop-filter: blur(18px);
      display: flex; align-items: center; justify-content: center; padding: 1.5rem;
      opacity: 0; pointer-events: none; transition: opacity 0.25s ease;
    }
    .ilan-detail-overlay.open { opacity: 1; pointer-events: all; }
    .ilan-detail-modal {
      background: var(--bg-card); border: 1px solid var(--border-hover);
      border-radius: 28px; width: 100%; max-width: 520px;
      box-shadow: 0 40px 120px rgba(0,0,0,0.75), 0 0 60px rgba(59,130,246,0.1);
      transform: scale(0.93) translateY(20px);
      transition: transform 0.35s cubic-bezier(0.34,1.4,0.64,1);
      max-height: 90vh; overflow-y: auto; position: relative;
    }
    .ilan-detail-overlay.open .ilan-detail-modal { transform: none; }
    .ilan-detail-modal::before {
      content: '';
      position: absolute; top: 0; left: 0; right: 0; height: 3px;
      background: linear-gradient(90deg, var(--primary), var(--accent), var(--secondary));
      border-radius: 28px 28px 0 0;
    }
    .idm-header {
      padding: 2rem 2rem 1.2rem;
      display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem;
    }
    .idm-close-btn {
      width: 32px; height: 32px; border-radius: 50%; flex-shrink: 0;
      background: rgba(255,255,255,0.05); border: 1px solid var(--border);
      color: var(--text-dim); cursor: pointer; display: flex; align-items: center;
      justify-content: center; font-size: 1.1rem; transition: var(--transition);
    }
    .idm-close-btn:hover { background: rgba(239,68,68,0.2); color: #f87171; border-color: rgba(239,68,68,0.3); }
    .idm-body { padding: 0 2rem 2rem; display: flex; flex-direction: column; gap: 1.2rem; }
    .idm-title { font-size: 1.4rem; font-weight: 800; letter-spacing: -0.5px; line-height: 1.3; }
    .idm-desc {
      font-size: 0.9rem; color: var(--text-dim); line-height: 1.8;
      background: var(--bg-surface); border: 1px solid var(--border);
      border-radius: 14px; padding: 1rem 1.2rem;
    }
    .idm-section-title {
      font-size: 0.68rem; font-weight: 700; text-transform: uppercase;
      letter-spacing: 1.5px; color: var(--text-dim); margin-bottom: 0.6rem;
    }
    .idm-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.7rem; }
    .idm-info-chip {
      background: var(--bg-surface); border: 1px solid var(--border);
      border-radius: 12px; padding: 0.75rem 1rem;
      display: flex; align-items: center; gap: 0.6rem;
    }
    .idm-info-chip .chip-icon { font-size: 1rem; flex-shrink: 0; }
    .idm-info-chip .chip-label { font-size: 0.65rem; color: var(--text-dim); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    .idm-info-chip .chip-val { font-size: 0.82rem; font-weight: 700; color: var(--text-main); margin-top: 0.1rem; }
    .idm-tags { display: flex; flex-wrap: wrap; gap: 0.4rem; }
    .idm-tag {
      background: rgba(59,130,246,0.1); border: 1px solid rgba(59,130,246,0.2);
      color: var(--primary); padding: 0.3rem 0.7rem;
      border-radius: 8px; font-size: 0.75rem; font-weight: 600;
    }
    .idm-apply-btn {
      width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.6rem;
      background: linear-gradient(135deg, #3b82f6, #2563eb);
      color: white; border: none; border-radius: 14px; padding: 0.95rem;
      font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: 0.95rem;
      cursor: pointer; transition: all 0.2s cubic-bezier(0.175,0.885,0.32,1.275);
      box-shadow: 0 4px 15px rgba(59,130,246,0.4);
    }
    .idm-apply-btn:hover { transform: translateY(-2px) scale(1.01); box-shadow: 0 10px 28px rgba(59,130,246,0.55); }
    .idm-apply-btn:disabled { opacity: 0.55; cursor: default; transform: none; box-shadow: none; background: rgba(255,255,255,0.08); }

    /* ===== PROFİL DETAY MODAL ===== */
    .profil-detail-overlay {
      position: fixed; inset: 0; z-index: 9000;
      background: rgba(0,0,0,0.88); backdrop-filter: blur(18px);
      display: flex; align-items: center; justify-content: center; padding: 1.5rem;
      opacity: 0; pointer-events: none; transition: opacity 0.25s ease;
    }
    .profil-detail-overlay.open { opacity: 1; pointer-events: all; }
    .profil-detail-modal {
      background: var(--bg-card); border: 1px solid var(--border-hover);
      border-radius: 28px; width: 100%; max-width: 500px;
      padding: 0;
      box-shadow: 0 40px 120px rgba(0,0,0,0.75), 0 0 60px rgba(59,130,246,0.1);
      transform: scale(0.93) translateY(20px);
      transition: transform 0.35s cubic-bezier(0.34,1.4,0.64,1);
      max-height: 92vh; overflow-y: auto;
      position: relative;
    }
    .profil-detail-overlay.open .profil-detail-modal { transform: none; }
    .profil-detail-modal::before {
      content: '';
      position: absolute; top: 0; left: 0; right: 0; height: 3px;
      background: linear-gradient(90deg, var(--primary), var(--accent), var(--secondary));
      border-radius: 28px 28px 0 0;
    }
    .pdm-cover {
      height: 110px;
      background: linear-gradient(135deg, rgba(59,130,246,0.18), rgba(139,92,246,0.18), rgba(6,182,212,0.12));
      border-radius: 28px 28px 0 0;
      position: relative;
    }
    .pdm-close-btn {
      position: absolute; top: 1rem; right: 1rem;
      width: 32px; height: 32px; border-radius: 50%;
      background: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.1);
      color: var(--text-dim); cursor: pointer; display: flex; align-items: center;
      justify-content: center; font-size: 1.1rem;
      transition: var(--transition); line-height:1;
    }
    .pdm-close-btn:hover { background: rgba(239,68,68,0.3); color: #f87171; border-color: rgba(239,68,68,0.4); }
    .pdm-avatar-wrap {
      position: absolute; bottom: -32px; left: 2rem;
    }
    .pdm-avatar {
      width: 72px; height: 72px; border-radius: 18px;
      border: 3px solid var(--bg-card);
      display: flex; align-items: center; justify-content: center;
      font-size: 1.6rem; font-weight: 800; color: white; overflow: hidden;
      box-shadow: 0 8px 20px rgba(0,0,0,0.4);
    }
    .pdm-avatar img { width:100%; height:100%; object-fit:cover; border-radius:15px; display:block; }
    .pdm-body { padding: 3rem 2rem 2rem; }
    .pdm-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; }
    .pdm-name { font-size: 1.35rem; font-weight: 800; letter-spacing: -0.5px; }
    .pdm-uni { font-size: 0.8rem; color: var(--text-dim); margin-top: 0.25rem; }
    .pdm-available-badge {
      display: inline-flex; align-items: center; gap: 0.4rem;
      background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.25);
      color: var(--success); border-radius: 100px; padding: 0.28rem 0.75rem;
      font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;
      flex-shrink: 0;
    }
    .pdm-available-badge::before { content:''; width:6px; height:6px; border-radius:50%; background:var(--success); box-shadow:0 0 6px var(--success); }
    .pdm-bio {
      font-size: 0.88rem; color: var(--text-dim); line-height: 1.75;
      padding: 1rem; background: var(--bg-surface); border-radius: 12px;
      border: 1px solid var(--border); margin-bottom: 1.2rem;
    }
    .pdm-section-title {
      font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px;
      color: var(--text-dim); margin-bottom: 0.65rem;
    }
    .pdm-skills { display: flex; flex-wrap: wrap; gap: 0.4rem; margin-bottom: 1.2rem; }
    .pdm-skill {
      background: rgba(59,130,246,0.1); border: 1px solid rgba(59,130,246,0.2);
      color: var(--primary); padding: 0.3rem 0.7rem; border-radius: 8px;
      font-size: 0.75rem; font-weight: 600;
    }
    .pdm-info-grid {
      display: grid; grid-template-columns: 1fr 1fr; gap: 0.7rem; margin-bottom: 1.4rem;
    }
    .pdm-info-chip {
      background: var(--bg-surface); border: 1px solid var(--border);
      border-radius: 12px; padding: 0.75rem 1rem;
      display: flex; align-items: center; gap: 0.6rem;
    }
    .pdm-info-chip .chip-icon { font-size: 1rem; flex-shrink:0; }
    .pdm-info-chip .chip-label { font-size: 0.65rem; color: var(--text-dim); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    .pdm-info-chip .chip-val { font-size: 0.82rem; font-weight: 700; color: var(--text-main); margin-top: 0.1rem; }
    .pdm-contact-btn {
      width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.6rem;
      background: linear-gradient(135deg, #3b82f6, #2563eb);
      color: white; border: none; border-radius: 14px; padding: 0.9rem;
      font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: 0.9rem;
      cursor: pointer; transition: all 0.2s cubic-bezier(0.175,0.885,0.32,1.275);
      box-shadow: 0 4px 15px rgba(59,130,246,0.4);
    }
    .pdm-contact-btn:hover { transform: translateY(-2px) scale(1.01); box-shadow: 0 10px 28px rgba(59,130,246,0.55); }
    .pdm-contact-copied {
      width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.6rem;
      background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.3);
      color: var(--success); border-radius: 14px; padding: 0.9rem;
      font-weight: 800; font-size: 0.9rem; margin-top: 0.6rem; cursor: default;
    }

    /* ===== PROFIL EKLEME FORMU ===== */
    .profil-add-btn-wrap {
      text-align: center; margin-bottom: 1rem;
    }
    .profil-form-overlay {
      position: fixed; inset: 0; z-index: 8500;
      background: rgba(0,0,0,0.88); backdrop-filter: blur(16px);
      display: flex; align-items: center; justify-content: center; padding: 1.5rem;
      opacity: 0; pointer-events: none; transition: opacity 0.25s ease;
    }
    .profil-form-overlay.open { opacity: 1; pointer-events: all; }
    .profil-form-modal {
      background: var(--bg-card); border: 1px solid var(--border-hover);
      border-radius: 24px; width: 100%; max-width: 560px;
      padding: 2rem 2.4rem;
      box-shadow: 0 40px 100px rgba(0,0,0,0.7);
      transform: scale(0.95);
      transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
      max-height: 92vh; overflow-y: auto;
    }
    .profil-form-overlay.open .profil-form-modal { transform: none; }
    .profil-form-modal h3 { font-size: 1.3rem; font-weight: 800; margin-bottom: 0.4rem; }
    .profil-form-modal p { font-size: 0.82rem; color: var(--text-dim); margin-bottom: 1.5rem; }

    /* ===== İLAN EKLEME MODAL ===== */
    .ilan-add-btn-wrap {
      text-align: center; margin-bottom: 2rem; margin-top: -2rem;
    }
    .ilan-form-overlay {
      position: fixed; inset: 0; z-index: 8500;
      background: rgba(0,0,0,0.88); backdrop-filter: blur(18px);
      display: flex; align-items: center; justify-content: center; padding: 1.5rem;
      opacity: 0; pointer-events: none; transition: opacity 0.25s ease;
    }
    .ilan-form-overlay.open { opacity: 1; pointer-events: all; }
    .ilan-form-modal {
      background: var(--bg-card); border: 1px solid var(--border-hover);
      border-radius: 28px; width: 100%; max-width: 600px;
      padding: 2.2rem 2.6rem;
      box-shadow: 0 40px 120px rgba(0,0,0,0.8), 0 0 60px rgba(59,130,246,0.12);
      transform: scale(0.95) translateY(24px);
      transition: transform 0.35s cubic-bezier(0.34,1.56,0.64,1);
      max-height: 92vh; overflow-y: auto;
      position: relative;
      scrollbar-width: thin; scrollbar-color: var(--primary) transparent;
    }
    .ilan-form-overlay.open .ilan-form-modal { transform: none; }
    .ilan-form-modal::before {
      content: '';
      position: absolute; top: 0; left: 0; right: 0; height: 3px;
      background: linear-gradient(90deg, var(--primary), var(--accent), var(--secondary));
      border-radius: 28px 28px 0 0;
    }
    .ilan-form-modal::after {
      content: '';
      position: absolute; bottom: -80px; right: -60px;
      width: 220px; height: 220px;
      background: radial-gradient(circle, rgba(59,130,246,0.07), transparent 65%);
      pointer-events: none;
    }
    .ilan-form-modal h3 {
      font-size: 1.4rem; font-weight: 800; margin-bottom: 0.3rem;
      font-family: 'Syne', sans-serif;
      background: linear-gradient(135deg, var(--text-main) 40%, var(--primary));
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .ilan-form-modal > .modal-subtitle { font-size: 0.82rem; color: var(--text-dim); margin-bottom: 1.8rem; }

    /* ===== ENHANCED 3D CARD DEPTH ===== */
    .card-3d {
      box-shadow: 0 4px 24px rgba(0,0,0,0.45), inset 0 1px 0 rgba(255,255,255,0.04);
      transform-style: preserve-3d;
    }
    .card-3d:hover {
      box-shadow: 0 24px 70px rgba(0,0,0,0.65), 0 0 35px rgba(59,130,246,0.14), inset 0 1px 0 rgba(255,255,255,0.06);
    }
    .ilan-card {
      box-shadow: 0 4px 18px rgba(0,0,0,0.38), inset 0 1px 0 rgba(255,255,255,0.03);
      transform-style: preserve-3d;
    }
    .ilan-card:hover {
      box-shadow: 0 22px 60px rgba(0,0,0,0.6), 0 0 30px rgba(59,130,246,0.13), inset 0 1px 0 rgba(255,255,255,0.05);
    }
    .profil-card {
      box-shadow: 0 4px 20px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.03);
    }
    .profil-card:hover {
      box-shadow: 0 24px 65px rgba(0,0,0,0.62), 0 0 30px rgba(59,130,246,0.12) !important;
    }

    /* ===== 3D PERSPECTIVE WRAPPERS ===== */
    .ilanlar-grid {
      perspective: 1800px;
    }
    .cards-grid {
      perspective: 2000px;
    }
    #ilanlar {
      position: relative; overflow: hidden;
    }
    #ilanlar::before {
      content: '';
      position: absolute; top: -100px; left: 50%; transform: translateX(-50%);
      width: 800px; height: 400px;
      background: radial-gradient(ellipse, rgba(59,130,246,0.04), transparent 65%);
      pointer-events: none; z-index: 0;
    }

    /* ===== 3D STATS BAND POP ===== */
    .stat-item {
      position: relative;
      padding: 1.5rem 2.5rem;
      background: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: 20px;
      transition: var(--transition);
      transform: perspective(500px) translateZ(0);
      box-shadow: 0 4px 20px rgba(0,0,0,0.3), inset 0 1px 0 rgba(255,255,255,0.04);
    }
    .stat-item:hover {
      transform: perspective(500px) translateZ(16px) translateY(-4px);
      box-shadow: 0 20px 55px rgba(0,0,0,0.55), 0 0 25px rgba(59,130,246,0.1);
      border-color: var(--border-hover);
    }

    /* ===== 3D FLOATING BADGE ON SECTION HEADERS ===== */
    .badge-pill {
      transform: perspective(300px) rotateX(8deg);
      box-shadow: 0 4px 20px rgba(59,130,246,0.2), 0 0 0 1px rgba(59,130,246,0.15);
      transition: var(--transition);
    }
    .badge-pill:hover {
      transform: perspective(300px) rotateX(0deg) scale(1.05);
    }

    /* ===== GLOWING SEPARATOR LINE ===== */
    .glow-divider {
      height: 1px;
      background: linear-gradient(90deg, transparent 0%, var(--primary) 30%, var(--accent) 70%, transparent 100%);
      opacity: 0.35; margin: 0;
      position: relative;
    }
    .glow-divider::after {
      content: '';
      position: absolute; top: -3px; left: 50%; transform: translateX(-50%);
      width: 120px; height: 7px;
      background: radial-gradient(ellipse, rgba(59,130,246,0.45), transparent 65%);
      filter: blur(3px);
    }

    /* ===== RESPONSIVE 3D ADDITIONS ===== */
    @media (max-width: 1024px) {
      .hero-layout { grid-template-columns: 1fr; gap: 3rem; }
      .hero-visual  { order: -1; max-width: 380px; margin: 0 auto; }
      .hero-content { text-align: center !important; }
      .hero .hero-actions { justify-content: center; }
      .hero .hero-stats   { justify-content: center; }
      .hero p { margin-left: auto !important; margin-right: auto !important; }
    }
    @media (max-width: 768px) {
      .f-cube.c1, .f-cube.c3 { display: none; }
      #v-cursor, #v-cursor-ring { display: none; }
    }

    /* ===== AUTH OVERLAY — PROFESSIONAL ===== */
    #auth-overlay {
      position: fixed; inset: 0; z-index: 99999;
      background: var(--bg-deep);
      display: flex; align-items: stretch;
      transition: opacity 0.5s ease;
      overflow: hidden;
    }
    #auth-overlay.hiding {
      opacity: 0; pointer-events: none;
    }

    /* Left panel — branding */
    .auth-panel-left {
      flex: 1; display: flex; flex-direction: column;
      justify-content: space-between; padding: 3rem;
      background: linear-gradient(145deg, #050508 0%, #0c0c18 60%, #0d1228 100%);
      border-right: 1px solid var(--border);
      position: relative; overflow: hidden;
    }
    .auth-panel-left::before {
      content: '';
      position: absolute; top: -150px; right: -100px;
      width: 500px; height: 500px;
      background: radial-gradient(circle, rgba(59,130,246,0.12) 0%, transparent 60%);
      pointer-events: none;
    }
    .auth-panel-left::after {
      content: '';
      position: absolute; bottom: -100px; left: -80px;
      width: 400px; height: 400px;
      background: radial-gradient(circle, rgba(139,92,246,0.1) 0%, transparent 60%);
      pointer-events: none;
    }
    .auth-left-top { position: relative; z-index: 2; }
    .auth-left-logo {
      display: flex; align-items: center; gap: 0.5rem;
      font-size: 1.5rem; font-weight: 800; letter-spacing: -0.5px;
      color: var(--text-main); margin-bottom: 3rem;
    }
    .auth-left-logo span { color: var(--primary); }
    .auth-left-logo-dot {
      width: 9px; height: 9px; background: var(--primary);
      border-radius: 50%; box-shadow: 0 0 12px var(--primary);
      animation: pulse-dot 2s infinite;
    }
    .auth-left-headline {
      font-family: 'Syne', sans-serif;
      font-size: clamp(2rem, 3.5vw, 3.2rem);
      font-weight: 800; letter-spacing: -2px;
      line-height: 1.1; margin-bottom: 1.2rem;
    }
    .auth-left-headline .hl-blue {
      background: linear-gradient(135deg, var(--primary), var(--accent));
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .auth-left-desc {
      font-size: 0.9rem; color: var(--text-dim); line-height: 1.8;
      max-width: 340px; margin-bottom: 2.5rem;
    }
    .auth-left-features { display: flex; flex-direction: column; gap: 0.85rem; position: relative; z-index: 2; }
    .auth-feature-row {
      display: flex; align-items: center; gap: 0.85rem;
      padding: 0.8rem 1rem;
      background: rgba(255,255,255,0.03);
      border: 1px solid var(--border);
      border-radius: 14px;
      transition: var(--transition);
    }
    .auth-feature-row:hover { border-color: var(--border-hover); background: rgba(59,130,246,0.05); }
    .auth-feature-icon {
      width: 36px; height: 36px; border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1rem; flex-shrink: 0;
    }
    .auth-feature-text { flex: 1; }
    .auth-feature-title { font-size: 0.83rem; font-weight: 700; margin-bottom: 0.1rem; }
    .auth-feature-sub { font-size: 0.72rem; color: var(--text-dim); }
    .auth-left-bottom {
      font-size: 0.72rem; color: var(--text-dim);
      position: relative; z-index: 2;
    }
    .auth-left-bottom a { color: var(--primary); text-decoration: none; }
    .auth-left-bottom a:hover { text-decoration: underline; }

    /* Right panel — form */
    .auth-panel-right {
      width: 480px; flex-shrink: 0;
      display: flex; align-items: center; justify-content: center;
      padding: 2.5rem 2rem;
      overflow-y: auto;
    }

    .auth-card {
      background: transparent;
      border: none;
      border-radius: 0;
      padding: 0;
      width: 100%; max-width: 380px;
      position: relative;
      box-shadow: none;
      animation: auth-in 0.5s cubic-bezier(0.34,1.56,0.64,1);
    }
    .auth-card::before { display: none; }
    @keyframes auth-in {
      from { opacity:0; transform: translateY(18px); }
      to   { opacity:1; transform: none; }
    }

    .auth-logo {
      display: flex; align-items: center; gap: 0.5rem;
      font-size: 1.3rem; font-weight: 800; letter-spacing: -0.5px;
      margin-bottom: 0.3rem;
    }
    .auth-logo span { color: var(--primary); }
    .auth-logo-dot {
      width: 8px; height: 8px; background: var(--primary);
      border-radius: 50%; box-shadow: 0 0 10px var(--primary);
      animation: pulse-dot 2s infinite;
    }
    .auth-subtitle {
      font-size: 0.82rem; color: var(--text-dim); margin-bottom: 2rem;
    }

    .auth-tabs {
      display: flex; gap: 0.4rem; margin-bottom: 1.8rem;
      background: rgba(255,255,255,0.03);
      border: 1px solid var(--border); border-radius: 14px; padding: 0.35rem;
    }
    .auth-tab {
      flex: 1; padding: 0.55rem; border-radius: 10px; border: none;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 700; font-size: 0.83rem; cursor: pointer;
      transition: all 0.2s; background: transparent; color: var(--text-dim);
    }
    .auth-tab.active {
      background: var(--primary); color: white;
      box-shadow: 0 4px 12px rgba(59,130,246,0.35);
    }

    .auth-form { display: flex; flex-direction: column; gap: 1rem; }
    .auth-input {
      background: var(--bg-surface); border: 1px solid var(--border);
      border-radius: 12px; padding: 0.85rem 1.1rem;
      color: var(--text-main); font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 0.9rem; outline: none; transition: var(--transition);
      width: 100%;
    }
    .auth-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(59,130,246,0.12); background: rgba(59,130,246,0.04); }
    .auth-input::placeholder { color: rgba(148,163,184,0.5); }

    .auth-btn {
      width: 100%; padding: 0.9rem;
      background: linear-gradient(135deg, #3b82f6, #2563eb);
      color: white; border: none; border-radius: 12px;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 700; font-size: 0.95rem; cursor: pointer;
      transition: all 0.2s cubic-bezier(0.175,0.885,0.32,1.275);
      box-shadow: 0 4px 15px rgba(59,130,246,0.4);
    }
    .auth-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(59,130,246,0.55); }
    .auth-btn:active { transform: translateY(0); }

    .auth-divider {
      display: flex; align-items: center; gap: 0.75rem;
      color: var(--text-dim); font-size: 0.75rem; font-weight: 600; margin: 0.2rem 0;
    }
    .auth-divider::before, .auth-divider::after {
      content: ''; flex: 1; height: 1px; background: var(--border);
    }

    .auth-google-btn {
      width: 100%; padding: 0.85rem;
      background: rgba(255,255,255,0.04); border: 1px solid var(--border);
      border-radius: 12px; color: var(--text-main);
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 700; font-size: 0.88rem; cursor: pointer;
      display: flex; align-items: center; justify-content: center; gap: 0.7rem;
      transition: all 0.2s;
    }
    .auth-google-btn:hover {
      background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.2);
      transform: translateY(-1px);
    }

    .auth-error {
      background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.25);
      color: #f87171; border-radius: 10px; padding: 0.65rem 0.9rem;
      font-size: 0.82rem; font-weight: 600; display: none;
    }
    .auth-error.show { display: block; }

    /* Auth label */
    .auth-section-title {
      font-size: 1.6rem; font-weight: 800; letter-spacing: -0.8px;
      margin-bottom: 0.4rem;
    }

    /* Responsive: hide left panel on narrow screens */
    @media (max-width: 900px) {
      .auth-panel-left { display: none; }
      .auth-panel-right { width: 100%; }
    }

    /* Nav kullanıcı badge */
    .nav-user-badge {
      display: flex; align-items: center; gap: 0.5rem;
      background: rgba(59,130,246,0.1); border: 1px solid rgba(59,130,246,0.2);
      border-radius: 100px; padding: 0.3rem 0.75rem 0.3rem 0.4rem;
      font-size: 0.78rem; font-weight: 700; color: var(--primary);
      cursor: pointer; transition: var(--transition);
    }
    .nav-user-badge:hover { background: rgba(59,130,246,0.18); }
    .nav-user-avatar {
      width: 24px; height: 24px; border-radius: 50%;
      background: linear-gradient(135deg, var(--primary), var(--accent));
      display: flex; align-items: center; justify-content: center;
      font-size: 0.65rem; font-weight: 800; color: white;
    }

    /* ===== THEME TOGGLE ===== */
    .theme-toggle {
      background: rgba(59,130,246,0.08); border: 1px solid rgba(59,130,246,0.15);
      border-radius: 100px; width: 38px; height: 38px;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; transition: var(--transition); color: var(--text-dim);
      flex-shrink: 0;
    }
    .theme-toggle:hover { background: rgba(59,130,246,0.18); color: var(--primary); }
    .theme-toggle .theme-icon-sun { display: none; }
    .theme-toggle .theme-icon-moon { display: block; }
    html[data-theme="light"] .theme-toggle .theme-icon-sun { display: block; }
    html[data-theme="light"] .theme-toggle .theme-icon-moon { display: none; }

    /* ===== NAV USER DROPDOWN ===== */
    .nav-user-wrap {
      position: relative;
    }
    .nav-user-badge {
      display: flex; align-items: center; gap: 0.5rem;
      background: rgba(59,130,246,0.1); border: 1px solid rgba(59,130,246,0.2);
      border-radius: 100px; padding: 0.3rem 0.75rem 0.3rem 0.4rem;
      font-size: 0.78rem; font-weight: 700; color: var(--primary);
      cursor: pointer; transition: var(--transition);
      user-select: none;
    }
    .nav-user-badge:hover { background: rgba(59,130,246,0.18); }
    .nav-user-dropdown {
      position: absolute; top: calc(100% + 10px); right: 0;
      background: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: 16px;
      min-width: 200px;
      padding: 0.5rem;
      box-shadow: 0 20px 60px rgba(0,0,0,0.6), 0 0 30px rgba(59,130,246,0.08);
      opacity: 0; pointer-events: none;
      transform: translateY(-8px) scale(0.97);
      transition: opacity 0.2s ease, transform 0.2s cubic-bezier(0.34,1.56,0.64,1);
      z-index: 5000;
    }
    .nav-user-dropdown.open {
      opacity: 1; pointer-events: all;
      transform: translateY(0) scale(1);
    }
    .dropdown-header {
      padding: 0.75rem 0.9rem 0.6rem;
      border-bottom: 1px solid var(--border);
      margin-bottom: 0.4rem;
    }
    .dropdown-header-name {
      font-size: 0.9rem; font-weight: 800; color: var(--text-main);
    }
    .dropdown-header-email {
      font-size: 0.72rem; color: var(--text-dim); margin-top: 0.1rem;
      overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    .dropdown-item {
      display: flex; align-items: center; gap: 0.7rem;
      padding: 0.6rem 0.9rem;
      border-radius: 10px;
      font-size: 0.83rem; font-weight: 600; color: var(--text-dim);
      cursor: pointer; transition: var(--transition);
      border: none; background: transparent;
      width: 100%; text-align: left;
      font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .dropdown-item:hover {
      background: rgba(59,130,246,0.1); color: var(--text-main);
    }
    .dropdown-item.danger:hover {
      background: rgba(239,68,68,0.12); color: #f87171;
    }
    .dropdown-item svg { flex-shrink: 0; opacity: 0.7; }
    .dropdown-divider {
      height: 1px; background: var(--border); margin: 0.4rem 0;
    }

    /* ===== GOOGLE MOCK MODAL ===== */
    /* ===== GOOGLE ACCOUNT CHOOSER ===== */
    #google-mock-overlay {
      position: fixed; inset: 0; z-index: 999999;
      background: rgba(0,0,0,0.65); backdrop-filter: blur(6px);
      display: flex; align-items: center; justify-content: center;
      padding: 1.5rem;
      opacity: 0; pointer-events: none;
      transition: opacity 0.2s ease;
    }
    #google-mock-overlay.open { opacity: 1; pointer-events: all; }

    /* Outer wrapper mimics the Google popup shadow box */
    .google-mock-card {
      background: #202124;
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 14px;
      width: 100%; max-width: 460px;
      box-shadow: 0 8px 40px rgba(0,0,0,0.9);
      transform: scale(0.96) translateY(16px);
      transition: transform 0.28s cubic-bezier(0.34,1.46,0.64,1);
      overflow: hidden;
      font-family: 'Google Sans', 'Plus Jakarta Sans', sans-serif;
    }
    #google-mock-overlay.open .google-mock-card { transform: none; }

    /* ---- TOP BAR ---- */
    .gac-topbar {
      display: flex; align-items: center; justify-content: space-between;
      padding: 0.9rem 1.2rem 0.9rem 1.4rem;
      border-bottom: 1px solid rgba(255,255,255,0.07);
    }
    .gac-topbar-left { display: flex; align-items: center; gap: 0.6rem; }
    .gac-topbar-left span { font-size: 0.88rem; font-weight: 500; color: #e8eaed; }
    .gac-close-btn {
      background: none; border: none; cursor: pointer;
      color: #9aa0a6; font-size: 1.3rem; line-height: 1;
      padding: 4px; border-radius: 50%;
      transition: background 0.15s;
      display: flex; align-items: center; justify-content: center;
      width: 32px; height: 32px;
    }
    .gac-close-btn:hover { background: rgba(255,255,255,0.08); color: #e8eaed; }

    /* ---- STEP 0: ACCOUNT CHOOSER ---- */
    #google-step-0 { padding: 1.2rem 0 0.8rem; }
    .gac-heading { padding: 0 1.4rem 0.2rem; }
    .gac-heading h2 { font-size: 1.35rem; font-weight: 400; color: #e8eaed; margin: 0 0 0.2rem; }
    .gac-heading p { font-size: 0.8rem; color: #9aa0a6; margin: 0; }
    .gac-heading p a { color: #8ab4f8; text-decoration: none; }
    .gac-heading p a:hover { text-decoration: underline; }

    .gac-accounts { margin-top: 0.8rem; }
    .gac-account-row {
      display: flex; align-items: center; gap: 1rem;
      padding: 0.75rem 1.4rem; cursor: pointer;
      transition: background 0.15s;
      position: relative;
    }
    .gac-account-row:hover { background: rgba(255,255,255,0.06); }
    .gac-account-row:active { background: rgba(255,255,255,0.1); }
    .gac-avatar {
      width: 40px; height: 40px; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: 1rem; font-weight: 600; color: white;
      flex-shrink: 0; overflow: hidden;
      background: #5f6368;
    }
    .gac-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .gac-account-info { flex: 1; min-width: 0; }
    .gac-account-name { font-size: 0.9rem; font-weight: 500; color: #e8eaed; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .gac-account-email { font-size: 0.78rem; color: #9aa0a6; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .gac-account-badge {
      font-size: 0.7rem; color: #9aa0a6; white-space: nowrap; flex-shrink: 0;
    }
    .gac-divider { height: 1px; background: rgba(255,255,255,0.07); margin: 0.4rem 0; }
    .gac-other-row {
      display: flex; align-items: center; gap: 1rem;
      padding: 0.75rem 1.4rem; cursor: pointer;
      transition: background 0.15s; color: #9aa0a6;
    }
    .gac-other-row:hover { background: rgba(255,255,255,0.06); color: #e8eaed; }
    .gac-other-row svg { flex-shrink: 0; }
    .gac-other-row span { font-size: 0.88rem; }

    .gac-footer {
      padding: 0.8rem 1.4rem 1rem;
      font-size: 0.72rem; color: #9aa0a6;
      border-top: 1px solid rgba(255,255,255,0.07);
      line-height: 1.6; margin-top: 0.4rem;
    }
    .gac-footer a { color: #8ab4f8; text-decoration: none; }
    .gac-footer a:hover { text-decoration: underline; }

    /* ---- STEP 1: EMAIL INPUT ---- */
    #google-step-1 { padding: 1.5rem 1.8rem 1.5rem; }
    .gac-logo-center {
      display: flex; align-items: center; gap: 0.55rem;
      margin-bottom: 1.5rem;
    }
    .gac-logo-center span { font-size: 1.1rem; font-weight: 600; color: #e8eaed; }

    /* ---- STEP 2: PASSWORD ---- */
    #google-step-2 { padding: 1.5rem 1.8rem 1.5rem; }

    .gac-title { font-size: 1.5rem; font-weight: 400; color: #e8eaed; margin-bottom: 0.35rem; letter-spacing: -0.2px; }
    .gac-sub { font-size: 0.83rem; color: #9aa0a6; margin-bottom: 1.4rem; line-height: 1.55; }

    .gac-account-chip {
      display: inline-flex; align-items: center; gap: 0.5rem;
      background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.12);
      border-radius: 100px; padding: 0.3rem 0.7rem 0.3rem 0.45rem;
      font-size: 0.78rem; color: #9aa0a6; margin-bottom: 1.2rem;
      cursor: pointer; transition: background 0.15s;
    }
    .gac-account-chip:hover { background: rgba(255,255,255,0.09); }
    .gac-account-chip .chip-avatar {
      width: 22px; height: 22px; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: 0.65rem; font-weight: 600; color: white; flex-shrink: 0;
    }

    .gac-input-wrap { position: relative; margin-bottom: 0.6rem; }
    .gac-input {
      width: 100%; background: transparent;
      border: 1px solid rgba(255,255,255,0.25);
      border-radius: 4px; padding: 1rem 1rem 0.4rem;
      color: #e8eaed;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 0.95rem; outline: none;
      transition: border-color 0.18s;
    }
    .gac-input:focus { border-color: #8ab4f8; border-width: 2px; }
    .gac-input-label {
      position: absolute; left: 1rem; top: 50%;
      transform: translateY(-50%);
      font-size: 0.88rem; color: #9aa0a6;
      pointer-events: none; transition: all 0.15s ease;
    }
    .gac-input:focus ~ .gac-input-label,
    .gac-input:not(:placeholder-shown) ~ .gac-input-label {
      top: 0.45rem; transform: none; font-size: 0.68rem; color: #8ab4f8;
    }
    .gac-input:not(:focus):not(:placeholder-shown) ~ .gac-input-label { color: #9aa0a6; }
    .gac-pw-toggle {
      position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%);
      background: none; border: none; cursor: pointer; color: #9aa0a6;
      display: flex; align-items: center; padding: 4px;
      transition: color 0.15s;
    }
    .gac-pw-toggle:hover { color: #e8eaed; }

    .gac-error {
      background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3);
      color: #f28b82; border-radius: 6px; padding: 0.5rem 0.8rem;
      font-size: 0.78rem; margin-bottom: 0.8rem; display: none;
    }
    .gac-error.show { display: block; }

    .gac-hint { font-size: 0.72rem; color: #9aa0a6; margin-bottom: 1.6rem; line-height: 1.5; }

    .gac-actions {
      display: flex; align-items: center; justify-content: space-between;
      margin-top: 0.8rem;
    }
    .gac-link { color: #8ab4f8; font-size: 0.82rem; font-weight: 500; text-decoration: none; cursor: pointer; background: none; border: none; font-family: inherit; }
    .gac-link:hover { text-decoration: underline; }
    .gac-next-btn {
      background: #8ab4f8; color: #202124;
      border: none; border-radius: 4px;
      padding: 0.65rem 1.5rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 700; font-size: 0.88rem; cursor: pointer;
      transition: background 0.15s, box-shadow 0.15s;
    }
    .gac-next-btn:hover { background: #aecbfa; box-shadow: 0 2px 10px rgba(138,180,248,0.35); }
    .gac-next-btn:active { background: #8ab4f8; }

    /* ===== AYARLAR MODAL ===== */
    #settings-overlay {
      position: fixed; inset: 0; z-index: 99998;
      background: rgba(0,0,0,0.75); backdrop-filter: blur(12px);
      display: flex; align-items: center; justify-content: center;
      padding: 1.5rem;
      opacity: 0; pointer-events: none;
      transition: opacity 0.25s ease;
    }
    #settings-overlay.open { opacity: 1; pointer-events: all; }
    .settings-card {
      background: var(--bg-card); border: 1px solid var(--border);
      border-radius: 28px; width: 100%; max-width: 480px;
      padding: 2.2rem 2.4rem;
      box-shadow: 0 40px 100px rgba(0,0,0,0.7);
      transform: scale(0.96) translateY(16px);
      transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1);
      position: relative; overflow: hidden;
    }
    #settings-overlay.open .settings-card { transform: none; }
    .settings-card::before {
      content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
      background: linear-gradient(90deg, var(--primary), var(--accent), var(--secondary));
      border-radius: 28px 28px 0 0;
    }
    .settings-header {
      display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.8rem;
    }
    .settings-header h3 { font-size: 1.3rem; font-weight: 800; }
    .settings-section { margin-bottom: 1.5rem; }
    .settings-section-title {
      font-size: 0.72rem; font-weight: 700; color: var(--text-dim);
      text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.8rem;
    }
    .settings-row {
      display: flex; align-items: center; justify-content: space-between;
      padding: 0.75rem 1rem;
      background: var(--bg-surface); border: 1px solid var(--border);
      border-radius: 12px; margin-bottom: 0.5rem;
    }
    .settings-row-label { font-size: 0.88rem; font-weight: 600; }
    .settings-row-sub { font-size: 0.72rem; color: var(--text-dim); margin-top: 0.1rem; }
    .settings-toggle {
      width: 44px; height: 24px; border-radius: 100px;
      background: rgba(255,255,255,0.1); border: 1px solid var(--border);
      cursor: pointer; position: relative; transition: background 0.2s;
      flex-shrink: 0; border: none;
    }
    .settings-toggle::after {
      content: ''; position: absolute;
      width: 18px; height: 18px; border-radius: 50%;
      background: white; top: 3px; left: 3px;
      transition: transform 0.2s cubic-bezier(0.34,1.56,0.64,1);
      box-shadow: 0 1px 4px rgba(0,0,0,0.3);
    }
    .settings-toggle.on { background: var(--primary); }
    .settings-toggle.on::after { transform: translateX(20px); }

    /* ===== ŞİFRE GÖSTER/GİZLE ===== */
    .pw-wrap {
      position: relative;
      width: 100%;
    }
    .pw-wrap .auth-input {
      padding-right: 3rem;
    }
    .pw-toggle {
      position: absolute;
      right: 0.9rem;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      color: var(--text-dim);
      padding: 0.25rem;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: color 0.2s;
      border-radius: 6px;
    }
    .pw-toggle:hover { color: var(--primary); }
    .pw-toggle svg { pointer-events: none; display: block; }

    /* ===== PROFİL FOTOĞRAFI YÜKLEME ===== */
    .avatar-upload-wrap {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.9rem;
      margin-bottom: 1.4rem;
    }
    .avatar-upload-circle {
      width: 88px; height: 88px;
      border-radius: 50%;
      background: linear-gradient(135deg, rgba(59,130,246,0.15), rgba(6,182,212,0.1));
      border: 2px dashed rgba(59,130,246,0.35);
      display: flex; align-items: center; justify-content: center;
      cursor: pointer;
      position: relative;
      overflow: hidden;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .avatar-upload-circle:hover {
      border-color: var(--primary);
      box-shadow: 0 0 0 4px rgba(59,130,246,0.12);
    }
    .avatar-upload-circle img {
      width: 100%; height: 100%;
      object-fit: cover;
      border-radius: 50%;
      position: absolute; inset: 0;
      display: none;
    }
    .avatar-upload-circle img.loaded { display: block; }
    .avatar-upload-placeholder {
      display: flex; flex-direction: column; align-items: center; gap: 0.3rem;
      color: var(--text-dim); font-size: 0.7rem; font-weight: 600;
      text-align: center; pointer-events: none;
      transition: opacity 0.2s;
    }
    .avatar-upload-placeholder svg { opacity: 0.6; }
    .avatar-upload-overlay {
      position: absolute; inset: 0;
      background: rgba(0,0,0,0.55);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      opacity: 0; transition: opacity 0.2s;
      color: white; font-size: 0.7rem; font-weight: 700;
      flex-direction: column; gap: 0.2rem;
    }
    .avatar-upload-circle:hover .avatar-upload-overlay { opacity: 1; }
    .avatar-upload-hint {
      font-size: 0.72rem; color: var(--text-dim); text-align: center; line-height: 1.5;
    }
    #pf-photo-input { display: none; }

    /* Nav avatar fotoğraflı hali */
    .nav-user-avatar img {
      width: 100%; height: 100%;
      object-fit: cover;
      border-radius: 50%;
    }

    /* Boş grid mesajları */
    .empty-grid-msg {
      grid-column: 1/-1; text-align: center; padding: 4rem 2rem;
      color: var(--text-dim);
    }
    .empty-grid-msg .empty-icon { font-size: 3rem; margin-bottom: 1rem; opacity: 0.5; }
    .empty-grid-msg h4 { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--text-main); }
    .empty-grid-msg p { font-size: 0.88rem; }

    /* ===== GOREV & EKIP BOARD (Trello tarzi) ===== */
    #gorevler { padding: 5rem 0; position: relative; }
    .section-header { text-align: center; margin-bottom: 2.5rem; }
    .section-header h2 { font-size: 2.2rem; font-weight: 800; letter-spacing: -1px; }
    .section-header h2 span { color: var(--primary); }
    .section-header p { color: var(--text-dim); margin-top: 0.5rem; }

    .ekip-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
    .ekip-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 1.2rem; cursor: pointer; transition: var(--transition); }
    .ekip-card:hover { border-color: var(--border-hover); transform: translateY(-2px); box-shadow: var(--shadow-3d); }
    .ekip-card.active { border-color: var(--primary); box-shadow: 0 0 20px rgba(59,130,246,0.2); }
    .ekip-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; }
    .ekip-emoji { font-size: 1.5rem; }
    .ekip-badge { font-size: 0.7rem; padding: 0.2rem 0.6rem; border-radius: 20px; background: rgba(16,185,129,0.15); color: #10b981; font-weight: 600; }
    .ekip-card h4 { font-size: 1rem; font-weight: 700; margin-bottom: 0.3rem; }
    .ekip-card p { font-size: 0.8rem; color: var(--text-dim); margin-bottom: 0.8rem; line-height: 1.4; }
    .ekip-meta { display: flex; gap: 1rem; font-size: 0.75rem; color: var(--text-dim); }

    .kanban-board { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-top: 1.5rem; }
    @media (max-width: 1024px) { .kanban-board { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 640px) { .kanban-board { grid-template-columns: 1fr; } }
    .kanban-col { background: var(--bg-surface); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 1rem; min-height: 300px; transition: border-color 0.2s; }
    .kanban-col.drag-over { border-color: var(--primary); background: rgba(59,130,246,0.05); }
    .kanban-col-title { font-size: 0.85rem; font-weight: 700; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
    .kanban-col-title .col-count { font-size: 0.7rem; color: var(--text-dim); background: var(--bg-card); padding: 0.15rem 0.5rem; border-radius: 10px; }

    .gorev-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 12px; padding: 0.8rem 1rem; margin-bottom: 0.7rem; cursor: grab; transition: all 0.2s; }
    .gorev-card:hover { border-color: var(--border-hover); box-shadow: 0 4px 12px rgba(0,0,0,0.3); }
    .gorev-card.dragging { opacity: 0.5; transform: rotate(2deg); }
    .gorev-card h5 { font-size: 0.85rem; font-weight: 700; margin: 0.4rem 0; }
    .gorev-card p { font-size: 0.75rem; color: var(--text-dim); line-height: 1.4; margin-bottom: 0.5rem; }
    .gorev-card-header { display: flex; justify-content: space-between; align-items: center; gap: 0.5rem; }
    .gorev-oncelik { font-size: 0.65rem; font-weight: 700; padding: 0.15rem 0.5rem; border-radius: 10px; }
    .oncelik-acil { background: rgba(239,68,68,0.15); color: #ef4444; }
    .oncelik-yuksek { background: rgba(245,158,11,0.15); color: #f59e0b; }
    .oncelik-orta { background: rgba(59,130,246,0.15); color: #3b82f6; }
    .oncelik-dusuk { background: rgba(16,185,129,0.15); color: #10b981; }
    .gorev-tarih { font-size: 0.65rem; color: var(--text-dim); }
    .gorev-card-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem; }
    .gorev-etiketler { display: flex; gap: 0.3rem; flex-wrap: wrap; }
    .gorev-etiket { font-size: 0.6rem; padding: 0.15rem 0.5rem; border-radius: 8px; background: rgba(139,92,246,0.15); color: #8b5cf6; font-weight: 600; }
    .gorev-avatar { width: 22px; height: 22px; border-radius: 50%; background: var(--primary); font-size: 0.55rem; font-weight: 800; display: flex; align-items: center; justify-content: center; color: white; }
    .gorev-count { font-size: 0.7rem; color: var(--text-dim); text-align: center; padding-top: 0.5rem; }

    /* Gorev Detay Modal */
    #gorev-detay-modal { position: fixed; inset: 0; z-index: 5000; background: rgba(5,5,8,0.85); backdrop-filter: blur(10px); display: flex; align-items: center; justify-content: center; opacity: 0; pointer-events: none; transition: opacity 0.3s; }
    #gorev-detay-modal.open { opacity: 1; pointer-events: all; }
    .gd-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-xl); padding: 2rem; max-width: 550px; width: 90%; max-height: 80vh; overflow-y: auto; }
    .gd-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; margin-bottom: 1rem; }
    .gd-header h3 { font-size: 1.2rem; font-weight: 800; }
    .gd-meta { display: flex; gap: 1rem; font-size: 0.78rem; color: var(--text-dim); margin-bottom: 1rem; flex-wrap: wrap; }
    .gd-aciklama { font-size: 0.9rem; color: var(--text-main); line-height: 1.6; margin-bottom: 1rem; padding: 1rem; background: var(--bg-surface); border-radius: 12px; }
    .gd-etiketler { margin-bottom: 1rem; display: flex; gap: 0.4rem; flex-wrap: wrap; }
    .gd-actions { display: flex; gap: 0.5rem; align-items: center; }
    .gd-oncelik { font-size: 0.7rem; padding: 0.2rem 0.6rem; border-radius: 10px; font-weight: 700; }
    #km-overlay {
      display: none;
      position: fixed;
      inset: 0;
      z-index: 9999;
      background: rgba(5,5,8,0.88);
      backdrop-filter: blur(18px);
      -webkit-backdrop-filter: blur(18px);
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
      overflow-y: auto;
    }
    #km-overlay.km-open { display: flex; }
    #km-box {
      background: #12121f;
      border: 1px solid rgba(59,130,246,0.2);
      border-radius: 28px;
      width: 100%;
      max-width: 760px;
      padding: 2.5rem;
      position: relative;
      box-shadow: 0 40px 100px rgba(0,0,0,0.8), 0 0 0 1px rgba(59,130,246,0.1);
      margin: auto;
    }
    #km-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 0.5rem;
    }
    #km-header-left { display: flex; align-items: center; gap: 1rem; }
    #km-emoji-box {
      width: 54px; height: 54px;
      border-radius: 14px;
      background: rgba(59,130,246,0.12);
      border: 1px solid rgba(59,130,246,0.22);
      display: flex; align-items: center; justify-content: center;
      font-size: 1.6rem; flex-shrink: 0;
    }
    #km-title { font-size: 1.35rem; font-weight: 800; letter-spacing: -0.5px; color: #f8fafc; }
    #km-subtitle { font-size: 0.8rem; color: #64748b; margin-top: 0.2rem; }
    #km-close-btn {
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 10px;
      width: 36px; height: 36px;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; color: #94a3b8;
      font-size: 1.1rem; transition: all 0.2s; flex-shrink: 0;
    }
    #km-close-btn:hover { background: rgba(239,68,68,0.18); color: #ef4444; }
    #km-count-bar {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      margin: 1.2rem 0 1.6rem;
      padding: 0.7rem 1rem;
      background: rgba(59,130,246,0.06);
      border: 1px solid rgba(59,130,246,0.14);
      border-radius: 12px;
      font-size: 0.82rem;
      color: #94a3b8;
    }
    #km-count-bar strong { color: #3b82f6; font-size: 1rem; }
    #km-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(195px, 1fr));
      gap: 0.85rem;
    }
    .km-card {
      background: #0c0c14;
      border: 1px solid rgba(255,255,255,0.07);
      border-radius: 14px;
      padding: 1rem 1.1rem 1.1rem;
      position: relative;
      overflow: hidden;
      transition: border-color 0.22s, transform 0.22s, box-shadow 0.22s, background 0.22s;
      cursor: default;
    }
    .km-card:hover {
      border-color: rgba(59,130,246,0.4);
      transform: translateY(-3px);
      background: #0e0e1c;
      box-shadow: 0 10px 28px rgba(0,0,0,0.45);
    }
    .km-card::after {
      content: '';
      position: absolute;
      top: 0; left: 0;
      width: 3px; height: 100%;
      background: linear-gradient(to bottom, #3b82f6, #06b6d4);
      border-radius: 3px 0 0 3px;
      transform: scaleY(0);
      transform-origin: top;
      transition: transform 0.25s;
    }
    .km-card:hover::after { transform: scaleY(1); }
    .km-card-emoji { font-size: 1.5rem; display: block; margin-bottom: 0.55rem; }
    .km-card-name { font-size: 0.88rem; font-weight: 700; color: #f1f5f9; letter-spacing: -0.2px; margin-bottom: 0.3rem; }
    .km-card-desc { font-size: 0.73rem; color: #64748b; line-height: 1.55; }
    .km-card-tag {
      display: inline-block;
      margin-top: 0.55rem;
      padding: 0.12rem 0.5rem;
      border-radius: 6px;
      font-size: 0.67rem;
      font-weight: 700;
      background: rgba(59,130,246,0.1);
      color: #3b82f6;
      border: 1px solid rgba(59,130,246,0.2);
    }
    .km-card-tag.tag-green { background: rgba(16,185,129,0.1); color: #10b981; border-color: rgba(16,185,129,0.2); }
    .km-card-tag.tag-warn  { background: rgba(245,158,11,0.1); color: #f59e0b; border-color: rgba(245,158,11,0.2); }
    .km-card-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: 0.6rem;
      gap: 0.4rem;
    }
    .km-basvur-btn {
      display: inline-flex;
      align-items: center;
      gap: 0.28rem;
      background: linear-gradient(135deg, rgba(59,130,246,0.14), rgba(37,99,235,0.18));
      color: #3b82f6;
      border: 1px solid rgba(59,130,246,0.28);
      border-radius: 7px;
      padding: 0.25rem 0.6rem;
      font-size: 0.66rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.18s ease;
      font-family: 'Plus Jakarta Sans', sans-serif;
      white-space: nowrap;
      flex-shrink: 0;
      text-decoration: none;
      line-height: 1.4;
    }
    .km-basvur-btn:hover {
      background: linear-gradient(135deg, rgba(59,130,246,0.28), rgba(37,99,235,0.32));
      border-color: rgba(59,130,246,0.55);
      transform: translateY(-1px);
      box-shadow: 0 4px 10px rgba(59,130,246,0.22);
      color: #93c5fd;
    }
    #km-footer {
      margin-top: 1.8rem;
      padding-top: 1.4rem;
      border-top: 1px solid rgba(255,255,255,0.07);
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 0.8rem;
    }
    #km-footer-text { font-size: 0.79rem; color: #64748b; }


    /* ===== SSS ===== */
    #sss { padding: 6rem 0; }
    .sss-grid {
      max-width: 780px;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
    }
    .sss-item {
      background: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: 16px;
      overflow: hidden;
      transition: border-color 0.25s, box-shadow 0.25s;
    }
    .sss-item:hover { border-color: var(--border-hover); }
    .sss-item.open {
      border-color: rgba(59,130,246,0.35);
      box-shadow: 0 8px 30px rgba(59,130,246,0.08);
    }
    .sss-q {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
      padding: 1.3rem 1.6rem;
      background: transparent;
      border: none;
      cursor: pointer;
      color: var(--text-main);
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 0.97rem;
      font-weight: 700;
      text-align: left;
      letter-spacing: -0.2px;
      transition: color 0.2s;
    }
    .sss-q:hover { color: var(--primary); }
    .sss-item.open .sss-q { color: var(--primary); }
    .sss-icon {
      width: 18px; height: 18px;
      flex-shrink: 0;
      color: var(--text-dim);
      transition: transform 0.3s cubic-bezier(0.4,0,0.2,1), color 0.2s;
    }
    .sss-item.open .sss-icon {
      transform: rotate(180deg);
      color: var(--primary);
    }
    .sss-a {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.4s cubic-bezier(0.4,0,0.2,1), padding 0.3s;
      padding: 0 1.6rem;
    }
    .sss-item.open .sss-a {
      max-height: 300px;
      padding: 0 1.6rem 1.4rem;
    }
    .sss-a p {
      color: var(--text-dim);
      font-size: 0.9rem;
      line-height: 1.8;
      border-left: 2px solid rgba(59,130,246,0.3);
      padding-left: 1rem;
      margin: 0;
    }
    .km-info-text {
      font-size: 0.72rem;
      color: var(--text-dim);
      display: inline-flex;
      align-items: center;
      gap: 3px;
      background: rgba(59,130,246,0.07);
      border: 1px solid rgba(59,130,246,0.15);
      border-radius: 8px;
      padding: 0.28rem 0.6rem;
      font-weight: 500;
      line-height: 1.4;
    }
    .km-info-text svg { flex-shrink: 0; color: var(--primary); }

  </style>
</head>
<body>
