<!doctype html>
<html lang="ar" dir="rtl">
<head>

<?php
$siteSettings = $siteSettings ?? [];

$siteName = trim((string)($siteSettings['site_name_ar'] ?? ''));
if ($siteName === '') {
    $siteName = trim((string)($siteSettings['site_name_en'] ?? ''));
}
if ($siteName === '') {
    $siteName = ' ';
}

$siteLogo = trim((string)($siteSettings['logo'] ?? ''));
$siteFavicon = trim((string)($siteSettings['favicon'] ?? ''));
?>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8') ?></title>
<?php if ($siteFavicon !== ''): ?>
  <link rel="icon" href="<?= htmlspecialchars(\App\Helpers\Url::file($siteFavicon), ENT_QUOTES, 'UTF-8') ?>">
<?php endif; ?>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body{font-family:'Cairo',system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;background:#f6f7fb}
    .cardx{border:0;box-shadow:0 10px 30px rgba(16,24,40,.10);border-radius:16px}
    .chip{display:inline-flex;align-items:center;gap:.35rem;padding:.25rem .6rem;border-radius:999px;background:#fff;border:1px solid rgba(0,0,0,.08)}
    .price-badge{font-weight:800}
    .muted{color:#667085}
    .skeleton{
      background: linear-gradient(90deg, rgba(0,0,0,.06) 25%, rgba(0,0,0,.11) 37%, rgba(0,0,0,.06) 63%);
      background-size: 400% 100%;
      animation: shimmer 1.2s ease-in-out infinite;
      border-radius: 12px;
    }
    @keyframes shimmer{0%{background-position:100% 0}100%{background-position:0 0}}
    .sk-line{height:12px}
    .sk-btn{height:38px}
    .filter-bar .form-select,.filter-bar .form-control{border-radius:12px}
    .page-link{border-radius:12px !important}
    .page-item:not(:first-child) .page-link{margin-right:6px}
  </style>
</head>
<body>




<nav class="navbar navbar-expand-lg bg-white sticky-top border-bottom">
  <div class="container">

    <a class="navbar-brand fw-bold site-brand-link"
       href="<?= htmlspecialchars(\App\Helpers\Url::to('/'), ENT_QUOTES, 'UTF-8') ?>">
      <?php if ($siteLogo !== ''): ?>
        <img
          src="<?= htmlspecialchars(\App\Helpers\Url::file($siteLogo), ENT_QUOTES, 'UTF-8') ?>"
          alt="<?= htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8') ?>"
          class="site-brand-logo"
        >
      <?php else: ?>
        <span class="site-brand-emoji">🛒</span>
      <?php endif; ?>

      <span class="site-brand-text"><?= htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8') ?></span>
    </a>

    <div class="nav-main-links">
      <a class="nav-main-link is-active"
         href="<?= htmlspecialchars(\App\Helpers\Url::to('/'), ENT_QUOTES, 'UTF-8') ?>">
        الرئيسية
      </a>

      <a class="nav-main-link"
         href="<?= htmlspecialchars(\App\Helpers\Url::to('/about'), ENT_QUOTES, 'UTF-8') ?>">
        من نحن
      </a>

      <a class="nav-main-link"
         href="<?= htmlspecialchars(\App\Helpers\Url::to('/contact'), ENT_QUOTES, 'UTF-8') ?>">
        تواصل معنا
      </a>
    </div>

    <?php
      $return = $_SERVER['REQUEST_URI'] ?? \App\Helpers\Url::to('/');
      $loginUrl = \App\Helpers\Url::to('/login?return=' . urlencode($return));
      $regUrl   = \App\Helpers\Url::to('/register?return=' . urlencode($return));
      $ordersUrl = \App\Helpers\Url::to('/my-orders');
    ?>

    <div class="nav-actions-wrap">
      <button class="btn btn-outline-dark position-relative"
              type="button"
              data-bs-toggle="offcanvas"
              data-bs-target="#cartCanvas"
              aria-controls="cartCanvas">
        🧺 السلة
        <span id="cartBadge"
              class="position-absolute top-0 start-0 translate-middle badge rounded-pill text-bg-danger">0</span>
      </button>

      <?php if (\App\Helpers\Auth::check()): ?>
        <a class="btn btn-outline-primary"
           href="<?= htmlspecialchars($ordersUrl, ENT_QUOTES, 'UTF-8') ?>">
          طلباتي
        </a>

        <form method="POST"
              action="<?= htmlspecialchars(\App\Helpers\Url::to('/logout'), ENT_QUOTES, 'UTF-8') ?>"
              class="d-inline">
          <?= \App\Helpers\Csrf::input() ?>
          <button class="btn btn-danger">خروج</button>
        </form>
      <?php else: ?>
        <a class="btn btn-outline-primary"
           href="<?= htmlspecialchars($loginUrl, ENT_QUOTES, 'UTF-8') ?>">
          دخول
        </a>

        <a class="btn btn-primary"
           href="<?= htmlspecialchars($regUrl, ENT_QUOTES, 'UTF-8') ?>">
          إنشاء حساب
        </a>
      <?php endif; ?>
    </div>


    <div class="mobile-nav-links">
  <div class="mobile-nav-links-wrap">
    <a class="mobile-nav-link is-active"
       href="<?= htmlspecialchars(\App\Helpers\Url::to('/'), ENT_QUOTES, 'UTF-8') ?>">
      الرئيسية
    </a>

    <a class="mobile-nav-link"
       href="<?= htmlspecialchars(\App\Helpers\Url::to('/about'), ENT_QUOTES, 'UTF-8') ?>">
      من نحن
    </a>

    <a class="mobile-nav-link"
       href="<?= htmlspecialchars(\App\Helpers\Url::to('/contact'), ENT_QUOTES, 'UTF-8') ?>">
      تواصل معنا
    </a>
  </div>
</div>

  </div>
</nav>



<main class="container py-4">




<?php $heroSlides = $heroSlides ?? []; ?>

<style>
  .hero-main{
    margin: 18px 0 28px;
  }

.hero-slider{
  position: relative;
  overflow: hidden;
  border-radius: 32px;
  background:
    radial-gradient(circle at top right, rgba(249,115,22,.12), transparent 28%),
    radial-gradient(circle at bottom left, rgba(251,191,36,.10), transparent 24%),
    linear-gradient(135deg, #fff7ed 0%, #ffffff 48%, #fff1e6 100%);
  border: 1px solid rgba(251, 146, 60, .16);
  box-shadow: 0 24px 60px rgba(15, 23, 42, .10);
}

  .hero-track{
    display: flex;
    transition: transform .45s ease;
    will-change: transform;
    direction: ltr;
  }

.hero-slide{
  min-width: 100%;
  display: grid;
  grid-template-columns: .95fr 1.05fr;
  align-items: center;
  gap: 34px;
  padding: 42px;
  direction: rtl;
  min-height: 430px;
}

.hero-copy{
    padding-inline-start: 10px;
  display: flex;
  flex-direction: column;
  gap: 16px;
  animation: heroFadeUp .55s ease;
}

.hero-badge{
  display: inline-flex;
  align-items: center;
  width: fit-content;
  padding: 9px 16px;
  border-radius: 999px;
  background: rgba(255,255,255,.86);
  border: 1px solid rgba(249,115,22,.16);
  color: #ea580c;
  font-size: 13px;
  font-weight: 900;
  box-shadow: 0 10px 24px rgba(249,115,22,.08);
}

.hero-title{
  margin: 0;
  font-size: clamp(30px, 4vw, 52px);
  line-height: 1.12;
  font-weight: 900;
  color: #0f172a;
  letter-spacing: -.02em;
}

.hero-subtitle{
  margin: 0;
  color: #667085;
  font-size: 16px;
  line-height: 2;
  max-width: 620px;
}
  .hero-actions{
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-top: 8px;
  }

  .hero-btn{
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 48px;
    padding: 0 20px;
    border-radius: 16px;
    text-decoration: none;
    font-weight: 800;
    transition: .2s ease;
    border: 1px solid transparent;
  }

.hero-btn-primary{
  background: linear-gradient(135deg, #ff7a1a, #ea580c);
  color: #fff;
  box-shadow: 0 14px 30px rgba(249,115,22,.30);
}

.hero-btn-primary:hover{
  transform: translateY(-2px);
  color: #fff;
  box-shadow: 0 18px 34px rgba(249,115,22,.34);
}

.hero-btn-secondary{
  background: rgba(255,255,255,.84);
  border-color: rgba(17,24,39,.08);
  color: #111827;
  backdrop-filter: blur(8px);
}

  .hero-btn-secondary:hover{
    background: #fff;
    color: #111827;
  }

  .hero-media{
    position: relative;
    min-height: 320px;
  }

.hero-media-card{
  position: relative;
  height: 100%;
  min-height: 360px;
  border-radius: 28px;
  overflow: hidden;
  background: #fff;
  border: 1px solid rgba(255,255,255,.55);
  box-shadow: 0 24px 50px rgba(15,23,42,.12);
}

  .hero-image{
    width: 100%;
    height: 100%;
    min-height: 320px;
    object-fit: cover;
    display: block;
  }

  .hero-no-image{
    width: 100%;
    height: 100%;
    min-height: 320px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    background:
      radial-gradient(circle at top right, rgba(251,146,60,.18), transparent 30%),
      linear-gradient(135deg, #fff, #fff7ed);
    font-weight: 800;
  }

  .hero-nav{
    position: absolute;
    inset-inline: 16px;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    justify-content: space-between;
    pointer-events: none;
  }

.hero-nav button{
  pointer-events: auto;
  width: 48px;
  height: 48px;
  border: none;
  border-radius: 16px;
  background: rgba(255,255,255,.92);
  box-shadow: 0 14px 28px rgba(15,23,42,.12);
  cursor: pointer;
  font-size: 22px;
  font-weight: 900;
  color: #111827;
  transition: .2s ease;
}

.hero-dot{
  width: 10px;
  height: 10px;
  border-radius: 999px;
  border: none;
  background: rgba(17,24,39,.16);
  cursor: pointer;
  transition: .25s ease;
}

  .hero-dot{
    width: 10px;
    height: 10px;
    border-radius: 999px;
    border: none;
    background: rgba(17,24,39,.18);
    cursor: pointer;
    transition: .2s ease;
  }

.hero-dot.active{
  width: 30px;
  background: linear-gradient(135deg, #ff7a1a, #ea580c);
}


  @keyframes heroFadeUp{
  from{
    opacity: 0;
    transform: translateY(18px);
  }
  to{
    opacity: 1;
    transform: translateY(0);
  }
}

.hero-media-card::after{
  content: "";
  position: absolute;
  inset: 0;
  background: linear-gradient(
    180deg,
    rgba(255,255,255,0.02) 0%,
    rgba(15,23,42,0.04) 100%
  );
  pointer-events: none;
}


.hero-nav button:hover{
  transform: translateY(-2px);
  background: #fff;
}


@media (max-width: 991px){
  .hero-slide{
grid-template-columns: 1fr;
    padding: 22px;
    min-height: auto;
  }

    .hero-copy{
    padding-inline-start: 0;
  }

  .hero-title{
    font-size: 34px;
  }

  .hero-subtitle{
    font-size: 15px;
    line-height: 1.9;
  }

  .hero-media,
  .hero-media-card,
  .hero-image,
  .hero-no-image{
    min-height: 240px;
  }

  .hero-nav{
    inset-inline: 18px;
  }
  .hero-dots{
  bottom: 22px;
}
}

.site-brand-link{
  display:inline-flex;
  align-items:center;
  gap:10px;
  text-decoration:none !important;
  color:#111827 !important;
  font-weight:900;
}

.site-brand-link:hover,
.site-brand-link:focus,
.site-brand-link:active,
.site-brand-link:visited{
  text-decoration:none !important;
  color:#111827 !important;
}

.site-brand-logo{
  width:34px;
  height:34px;
  object-fit:cover;
  border-radius:10px;
  display:block;
}

.site-brand-emoji{
  font-size:22px;
  line-height:1;
}

.site-brand-text{
  color:#111827;
  font-weight:900;
  font-size:18px;
  line-height:1.1;
}

.nav-main-links{
  display:flex;
  align-items:center;
  gap:22px;
  margin-inline-start:28px;
  flex-wrap:wrap;
}

.nav-main-link{
  text-decoration:none;
  color:#334155;
  font-weight:800;
  font-size:15px;
  transition:.2s ease;
  position:relative;
}

.nav-main-link:hover,
.nav-main-link:focus{
  color:#ea580c;
}

.nav-main-link::after{
  content:"";
  position:absolute;
  inset-inline-start:0;
  bottom:-8px;
  width:0;
  height:2px;
  background:linear-gradient(135deg, #ff7a1a, #ea580c);
  border-radius:999px;
  transition:.25s ease;
}

.nav-main-link:hover::after,
.nav-main-link.is-active::after{
  width:100%;
}

.nav-main-link.is-active{
  color:#ea580c;
}

.nav-actions-wrap{
  display:flex;
  align-items:center;
  gap:10px;
  margin-inline-start:auto;
  flex-wrap:wrap;
}

@media (max-width: 991px){
  .site-brand-text{
    font-size:16px;
  }

  .nav-main-links{
    display:none;
  }

  .nav-actions-wrap{
    gap:8px;
  }

  .nav-actions-wrap .btn{
    padding-inline:10px;
    font-size:14px;
  }
}

.mobile-nav-links{
  display:none;
  padding:10px 0 0;
}

.mobile-nav-links-wrap{
  display:flex;
  gap:10px;
  flex-wrap:wrap;
}

.mobile-nav-link{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  min-height:40px;
  padding:0 14px;
  border-radius:12px;
  background:#fff;
  border:1px solid #e5e7eb;
  color:#111827;
  text-decoration:none;
  font-size:14px;
  font-weight:800;
}

.mobile-nav-link:hover,
.mobile-nav-link:focus{
  color:#ea580c;
  border-color:#fdba74;
  background:#fff7ed;
}

.mobile-nav-link.is-active{
  background:#fff7ed;
  color:#ea580c;
  border-color:#fdba74;
}

@media (max-width: 991px){
  .mobile-nav-links{
    display:block;
  }
}
</style>

<?php if (!empty($heroSlides)): ?>
<section class="hero-main" aria-label="Hero">
  <div class="hero-slider" id="heroSlider">
    <div class="hero-track" id="heroTrack">
      <?php foreach ($heroSlides as $slide): ?>
        <div class="hero-slide">
          <div class="hero-copy">
            <span class="hero-badge">مختارات مميزة</span>

            <h1 class="hero-title">
              <?= htmlspecialchars($slide['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>
            </h1>

            <?php if (!empty($slide['subtitle'])): ?>
              <p class="hero-subtitle">
                <?= nl2br(htmlspecialchars($slide['subtitle'], ENT_QUOTES, 'UTF-8')) ?>
              </p>
            <?php endif; ?>

            <div class="hero-actions">
              <?php if (!empty($slide['button_text_1']) && !empty($slide['button_link_1'])): ?>
                <a class="hero-btn hero-btn-primary" href="<?= htmlspecialchars($slide['button_link_1'], ENT_QUOTES, 'UTF-8') ?>">
                  <?= htmlspecialchars($slide['button_text_1'], ENT_QUOTES, 'UTF-8') ?>
                </a>
              <?php endif; ?>

              <?php if (!empty($slide['button_text_2']) && !empty($slide['button_link_2'])): ?>
                <a class="hero-btn hero-btn-secondary" href="<?= htmlspecialchars($slide['button_link_2'], ENT_QUOTES, 'UTF-8') ?>">
                  <?= htmlspecialchars($slide['button_text_2'], ENT_QUOTES, 'UTF-8') ?>
                </a>
              <?php endif; ?>
            </div>
          </div>

          <div class="hero-media">
            <div class="hero-media-card">
              <?php if (!empty($slide['image'])): ?>
                <img
                  class="hero-image"
                  src="<?= htmlspecialchars(\App\Helpers\Url::file($slide['image'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                  alt="<?= htmlspecialchars($slide['title'] ?? 'Hero', ENT_QUOTES, 'UTF-8') ?>"
                >
              <?php else: ?>
                <div class="hero-no-image">لا توجد صورة لهذا السلايد</div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <?php if (count($heroSlides) > 1): ?>
      <div class="hero-nav">
        <button type="button" id="heroPrevBtn" aria-label="السابق">‹</button>
        <button type="button" id="heroNextBtn" aria-label="التالي">›</button>
      </div>

      <div class="hero-dots" id="heroDots">
        <?php foreach ($heroSlides as $index => $slide): ?>
          <button
            type="button"
            class="hero-dot <?= $index === 0 ? 'active' : '' ?>"
            data-slide="<?= (int)$index ?>"
            aria-label="اذهب إلى السلايد <?= (int)$index + 1 ?>"
          ></button>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php if (count($heroSlides) > 1): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const slider = document.getElementById('heroSlider');
  const track = document.getElementById('heroTrack');
  const prevBtn = document.getElementById('heroPrevBtn');
  const nextBtn = document.getElementById('heroNextBtn');
  const dots = Array.from(document.querySelectorAll('#heroDots .hero-dot'));

  if (!slider || !track || dots.length === 0) return;

  let currentIndex = 0;
  const total = dots.length;
  let autoPlay = null;

  function renderSlider() {
    track.style.transform = `translateX(${currentIndex * -100}%)`;
    dots.forEach((dot, index) => {
      dot.classList.toggle('active', index === currentIndex);
    });
  }

  function goTo(index) {
    currentIndex = (index + total) % total;
    renderSlider();
  }

  function next() {
    goTo(currentIndex + 1);
  }

  function prev() {
    goTo(currentIndex - 1);
  }

  function startAutoPlay() {
    stopAutoPlay();
    autoPlay = setInterval(next, 5000);
  }

  function stopAutoPlay() {
    if (autoPlay) {
      clearInterval(autoPlay);
      autoPlay = null;
    }
  }

  if (nextBtn) nextBtn.addEventListener('click', function () {
    next();
    startAutoPlay();
  });

  if (prevBtn) prevBtn.addEventListener('click', function () {
    prev();
    startAutoPlay();
  });

  dots.forEach((dot, index) => {
    dot.addEventListener('click', function () {
      goTo(index);
      startAutoPlay();
    });
  });

  slider.addEventListener('mouseenter', stopAutoPlay);
  slider.addEventListener('mouseleave', startAutoPlay);

  renderSlider();
  startAutoPlay();
});
</script>
<?php endif; ?>
<?php endif; ?>




<?php if (!empty($best ?? [])): ?>
  <section class="mb-4">
    <div class="cardx bg-white p-3">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="d-flex align-items-center gap-2">
          <span class="badge text-bg-danger">🔥</span>
          <h2 class="h6 fw-bold mb-0">الأكثر مبيعًا</h2>
        </div>
        <span class="chip">آخر 30 يوم</span>
      </div>

      <div class="d-flex gap-3 overflow-auto pb-2" style="scroll-snap-type:x mandatory">
<?php foreach (($best ?? []) as $p): ?>
  <?php
    $url = \App\Helpers\Url::to('/product?slug=' . $p['slug']);

    // ✅ صورة من DB (main_image) بدل picsum
    $img = (!empty($p['main_image']))
      ? \App\Helpers\Url::to('/uploads/products/' . $p['main_image'])
      : '';
  ?>
  <a href="<?= htmlspecialchars($url, ENT_QUOTES, 'UTF-8') ?>"
     class="text-decoration-none text-dark"
     style="min-width:110px;max-width:110px;scroll-snap-align:start">
    <div class="text-center">
      <div class="position-relative mx-auto"
           style="width:92px;height:92px;border-radius:999px;padding:3px;background:linear-gradient(135deg,#ff4d4f,#ffb020)">

        <?php if ($img !== ''): ?>
          <img src="<?= htmlspecialchars($img, ENT_QUOTES, 'UTF-8') ?>"
               alt=""
               onerror="this.onerror=null; this.outerHTML='<div class=&quot;skeleton&quot; style=&quot;width:100%;height:100%;border-radius:999px&quot;></div>';"
               style="width:100%;height:100%;object-fit:cover;border-radius:999px;border:3px solid #fff;background:#fff">
        <?php else: ?>
          <div class="skeleton" style="width:100%;height:100%;border-radius:999px"></div>
        <?php endif; ?>

      </div>

      <div class="fw-bold mt-2"
           style="font-size:.85rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
        <?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?>
      </div>

      <div class="d-flex justify-content-center gap-1 mt-1 flex-wrap">
        <span class="badge text-bg-primary" style="font-size:.70rem">مباع: <?= (int)$p['sold_qty'] ?></span>
        <?php if ((int)$p['qty'] > 0): ?>
          <span class="badge text-bg-success" style="font-size:.70rem">متوفر</span>
        <?php else: ?>
          <span class="badge text-bg-danger" style="font-size:.70rem">نفذ</span>
        <?php endif; ?>
      </div>
    </div>
  </a>
<?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>


  <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
    <div>
      <h1 class="h4 fw-bold mb-0">أحدث المنتجات</h1>
      <div class="muted small">بحث + فلترة + ترتيب + صفحات (AJAX) بدون تحديث الصفحة</div>
    </div>

    <div class="d-flex gap-2 align-items-center" style="min-width: 320px;">
      <input id="searchBox" class="form-control" placeholder="ابحث: اسم المنتج / البراند / التصنيف...">
      <span class="chip" id="resultCount"><?= count($products ?? []) ?></span>
    </div>
  </div>

  <!-- Filters -->
  <div class="cardx bg-white p-3 mb-3 filter-bar">
    <div class="row g-2 align-items-end">
      <div class="col-12 col-md-4">
        <label class="form-label muted small mb-1">التصنيف</label>
        <select id="categorySelect" class="form-select">
          <option value="0">الكل</option>
          <?php foreach (($categories ?? []) as $c): ?>
            <option value="<?= (int)$c['id'] ?>"><?= htmlspecialchars($c['name'], ENT_QUOTES, 'UTF-8') ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-12 col-md-4">
        <label class="form-label muted small mb-1">البراند</label>
        <select id="brandSelect" class="form-select">
          <option value="0">الكل</option>
          <?php foreach (($brands ?? []) as $b): ?>
            <option value="<?= (int)$b['id'] ?>"><?= htmlspecialchars($b['name'], ENT_QUOTES, 'UTF-8') ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-12 col-md-4">
        <label class="form-label muted small mb-1">الترتيب</label>
        <select id="sortSelect" class="form-select">
          <option value="new">الأحدث</option>
          <option value="price_asc">السعر: الأقل → الأعلى</option>
          <option value="price_desc">السعر: الأعلى → الأقل</option>
          <option value="rating">الأعلى تقييمًا</option>
        </select>
      </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
      <div class="muted small">
        الصفحة: <b id="pageInfo">1</b> •
        إجمالي النتائج: <b id="totalInfo"><?= count($products ?? []) ?></b>
      </div>
      <div class="d-flex gap-2">
        <button id="resetBtn" class="btn btn-outline-secondary btn-sm">إعادة ضبط</button>
      </div>
    </div>
  </div>

  <div id="productsGrid" class="row g-3">
    <?php
      $productBase = htmlspecialchars(\App\Helpers\Url::to('/product?slug='), ENT_QUOTES, 'UTF-8');
    ?>
    <?php foreach (($products ?? []) as $p): ?>
      <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
        <div class="cardx bg-white p-3 h-100">
          <div class="d-flex justify-content-between align-items-start">
            <div class="chip"><?= htmlspecialchars($p['brand_name'] ?? '—', ENT_QUOTES, 'UTF-8') ?></div>
            <span class="badge text-bg-dark price-badge"> د.ع <?= number_format((float)$p['price'], 0) ?></span>
          </div>

          <a class="text-decoration-none text-dark" href="<?= $productBase . urlencode((string)$p['slug']) ?>">
            <h3 class="h6 fw-bold mt-3 mb-2"><?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?></h3>
          </a>

          <div class="d-flex flex-wrap gap-2 mb-3">
            <span class="chip">⭐ <?= htmlspecialchars((string)$p['rating'], ENT_QUOTES, 'UTF-8') ?></span>
            <span class="chip"><?= htmlspecialchars($p['category_name'] ?? '—', ENT_QUOTES, 'UTF-8') ?></span>

            <?php if ((int)$p['qty'] > 0): ?>
              <span class="badge text-bg-success">متوفر (<?= (int)$p['qty'] ?>)</span>
            <?php else: ?>
              <span class="badge text-bg-danger">نفذ المخزون</span>
            <?php endif; ?>
          </div>

          <button class="btn btn-primary w-100"
                  data-add-to-cart
                  data-product-id="<?= (int)$p['id'] ?>"
                  <?= ((int)$p['qty'] <= 0) ? 'disabled' : '' ?>>
            إضافة للسلة
          </button>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div id="emptyState" class="cardx bg-white p-4 mt-3 d-none">
    <b>لا توجد نتائج.</b>
    <div class="muted">جرّب كلمات بحث مختلفة أو عدّل الفلاتر.</div>
  </div>

  <!-- Pagination -->
  <div class="mt-3 d-flex justify-content-center">
    <nav aria-label="pagination">
      <ul id="pagination" class="pagination mb-0"></ul>
    </nav>
  </div>
</main>

<!-- Offcanvas Cart -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="cartCanvas" aria-labelledby="cartCanvasLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title fw-bold" id="cartCanvasLabel">🧺 سلة المشتريات</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>

  <div class="offcanvas-body">
    <div id="cartItems" class="vstack gap-2"></div>

    <div class="border-top pt-3 mt-3 d-flex justify-content-between align-items-center">
      <div>
        <div class="muted small">الإجمالي</div>
        <div class="fw-bold"> د.ع <span id="cartTotal">0</span></div>
      </div>
      <button class="btn btn-outline-danger btn-sm" id="clearCartBtn">تفريغ</button>
    </div>

    <a class="btn btn-success w-100 mt-2" href="<?= htmlspecialchars(\App\Helpers\Url::to('/checkout'), ENT_QUOTES, 'UTF-8') ?>">إتمام الطلب</a>
    <a class="btn btn-outline-dark w-100 mt-2" href="<?= htmlspecialchars(\App\Helpers\Url::to('/cart'), ENT_QUOTES, 'UTF-8') ?>">عرض السلة كاملة</a>
  </div>
</div>

<!-- Toast -->
<div class="toast-container position-fixed top-0 start-0 p-3" style="z-index: 2000">
  <div id="appToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <strong class="me-auto"><?= htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8') ?></strong>
      <small class="text-muted">الآن</small>
      <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
    </div>
    <div class="toast-body" id="toastBody">...</div>
  </div>
</div>

<!-- Bootstrap JS قبل سكربتنا -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // ===================== CONSTANTS =====================
  const CSRF = "<?= htmlspecialchars(\App\Helpers\Csrf::token(), ENT_QUOTES, 'UTF-8') ?>";
  const productBase = "<?= htmlspecialchars(\App\Helpers\Url::to('/product?slug='), ENT_QUOTES, 'UTF-8') ?>";

  // Browse API endpoint
  const browseEndpoint = "<?= htmlspecialchars(\App\Helpers\Url::to('/api/products/browse'), ENT_QUOTES, 'UTF-8') ?>";

  // ===================== ELEMENTS =====================
  const searchBox = document.getElementById('searchBox');
  const categorySelect = document.getElementById('categorySelect');
  const brandSelect = document.getElementById('brandSelect');
  const sortSelect = document.getElementById('sortSelect');
  const resetBtn = document.getElementById('resetBtn');

  const grid = document.getElementById('productsGrid');
  const emptyState = document.getElementById('emptyState');
  const resultCount = document.getElementById('resultCount');
  const pageInfo = document.getElementById('pageInfo');
  const totalInfo = document.getElementById('totalInfo');
  const pagination = document.getElementById('pagination');

  // Cart
  const cartBadge = document.getElementById('cartBadge');
  const cartItems = document.getElementById('cartItems');
  const cartTotal = document.getElementById('cartTotal');
  const clearCartBtn = document.getElementById('clearCartBtn');

  // Toast
  const toastEl = document.getElementById('appToast');
  const toastBody = document.getElementById('toastBody');
  let toast = null;
  if (window.bootstrap && bootstrap.Toast && toastEl) {
    toast = new bootstrap.Toast(toastEl, {delay: 2200});
  }
  function showToast(msg){ toastBody.textContent = msg; if(toast) toast.show(); }

  // ===================== HELPERS =====================
  function escapeHtml(s){
    return String(s ?? '').replace(/[&<>"']/g, m => ({
      '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'
    }[m]));
  }

  function skeletonCard() {
    return `
      <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
        <div class="cardx bg-white p-3 h-100">
          <div class="d-flex justify-content-between align-items-start">
            <div class="skeleton" style="width:90px;height:28px;border-radius:999px"></div>
            <div class="skeleton" style="width:64px;height:22px;border-radius:999px"></div>
          </div>
          <div class="skeleton sk-line mt-3" style="width:80%"></div>
          <div class="skeleton sk-line mt-2" style="width:60%"></div>
          <div class="d-flex gap-2 mt-3">
            <div class="skeleton" style="width:56px;height:26px;border-radius:999px"></div>
            <div class="skeleton" style="width:70px;height:26px;border-radius:999px"></div>
            <div class="skeleton" style="width:90px;height:26px;border-radius:999px"></div>
          </div>
          <div class="skeleton sk-btn mt-3"></div>
        </div>
      </div>
    `;
  }

  function renderSkeleton() {
    emptyState.classList.add('d-none');
    grid.innerHTML = Array.from({length: 8}).map(skeletonCard).join('');
  }

function card(p){
  console.log("CARD RUNNING", p);
  console.log("MAIN_IMAGE =", p.main_image);
  const qty = parseInt(p.qty, 10) || 0;
  const disabled = qty <= 0 ? 'disabled' : '';
  const stockBadge = qty > 0
    ? `<span class="badge text-bg-success">متوفر (${qty})</span>`
    : `<span class="badge text-bg-danger">نفذ المخزون</span>`;

  const productUrl = `${productBase}${encodeURIComponent(p.slug)}`;

  // ✅ صورة حقيقية فقط، بدون أي صور خارجية
  const imgUrl = (p.main_image && String(p.main_image).trim() !== '')
    ? `<?= htmlspecialchars(\App\Helpers\Url::to('/uploads/products/'), ENT_QUOTES, 'UTF-8') ?>${encodeURIComponent(p.main_image)}`
    : '';

  const imageHtml = imgUrl
    ? `<a class="text-decoration-none text-dark" href="${productUrl}">
         <img src="${imgUrl}" alt=""
              style="width:100%;height:150px;object-fit:cover;border-radius:14px;border:1px solid rgba(0,0,0,.06);background:#fff">
       </a>`
    : `<div class="skeleton" style="width:100%;height:150px;border-radius:14px"></div>`;

  return `
    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
      <div class="cardx bg-white p-3 h-100">

        ${imageHtml}

        <div class="d-flex justify-content-between align-items-start mt-3">
          <div class="chip">${escapeHtml(p.brand_name || '—')}</div>
          <span class="badge text-bg-dark price-badge"> د.ع ${Number(p.price).toFixed(0)}</span>
        </div>

        <a class="text-decoration-none text-dark" href="${productUrl}">
          <h3 class="h6 fw-bold mt-3 mb-2">${escapeHtml(p.name)}</h3>
        </a>

        <div class="d-flex flex-wrap gap-2 mb-3">
          <span class="chip">⭐ ${escapeHtml(p.rating)}</span>
          <span class="chip">${escapeHtml(p.category_name || '—')}</span>
          ${stockBadge}
        </div>

        <button class="btn btn-primary w-100" data-add-to-cart data-product-id="${p.id}" ${disabled}>
          إضافة للسلة
        </button>
      </div>
    </div>
  `;
}

  // ===================== STATE =====================
  const state = {
    q: '',
    category_id: 0,
    brand_id: 0,
    sort: 'new',
    page: 1,
    per_page: 12,
  };

  let debounce = null;
  let lastAbort = null;

  function updateControlsFromState(){
    searchBox.value = state.q;
    categorySelect.value = String(state.category_id);
    brandSelect.value = String(state.brand_id);
    sortSelect.value = String(state.sort);
  }

  function buildPagination(pages, current){
    if (!pages || pages <= 1){
      pagination.innerHTML = '';
      return;
    }

    const maxButtons = 7;
    let start = Math.max(1, current - 3);
    let end = Math.min(pages, start + maxButtons - 1);
    start = Math.max(1, end - maxButtons + 1);

    let html = '';

    const prevDisabled = current <= 1 ? 'disabled' : '';
    html += `<li class="page-item ${prevDisabled}"><a class="page-link" href="#" data-page="${current-1}">السابق</a></li>`;

    for(let p = start; p <= end; p++){
      const active = p === current ? 'active' : '';
      html += `<li class="page-item ${active}"><a class="page-link" href="#" data-page="${p}">${p}</a></li>`;
    }

    const nextDisabled = current >= pages ? 'disabled' : '';
    html += `<li class="page-item ${nextDisabled}"><a class="page-link" href="#" data-page="${current+1}">التالي</a></li>`;

    pagination.innerHTML = html;
  }

  async function browse(){
    if (lastAbort) lastAbort.abort();
    lastAbort = new AbortController();

    renderSkeleton();

    try {
      const url = new URL(browseEndpoint, window.location.origin);
      url.searchParams.set('q', state.q);
      url.searchParams.set('category_id', String(state.category_id));
      url.searchParams.set('brand_id', String(state.brand_id));
      url.searchParams.set('sort', String(state.sort));
      url.searchParams.set('page', String(state.page));
      url.searchParams.set('per_page', String(state.per_page));

      const res = await fetch(url.toString(), {
        signal: lastAbort.signal,
        headers: {'X-Requested-With':'XMLHttpRequest'}
      });

      if (!res.ok) throw new Error('HTTP ' + res.status);
      const data = await res.json();

      const items = data.items || [];
      const total = data.total ?? 0;
      const pages = data.pages ?? 1;
      const page = data.page ?? state.page;

      resultCount.textContent = items.length;
      totalInfo.textContent = total;
      pageInfo.textContent = page;

      if(items.length === 0){
        grid.innerHTML = '';
        emptyState.classList.remove('d-none');
        buildPagination(0, 1);
        return;
      }

      emptyState.classList.add('d-none');
      grid.innerHTML = items.map(card).join('');
      buildPagination(pages, page);

    } catch (e) {
      console.error('browse failed', e);
      resultCount.textContent = '0';
      grid.innerHTML = '';
      emptyState.classList.remove('d-none');
      buildPagination(0, 1);
    }
  }

  // ===================== EVENTS =====================
  function triggerBrowse(resetPage = true){
    if (resetPage) state.page = 1;
    clearTimeout(debounce);
    debounce = setTimeout(browse, 250);
  }

  searchBox.addEventListener('input', () => {
    state.q = searchBox.value;
    triggerBrowse(true);
  });

  categorySelect.addEventListener('change', () => {
    state.category_id = parseInt(categorySelect.value, 10) || 0;
    triggerBrowse(true);
  });

  brandSelect.addEventListener('change', () => {
    state.brand_id = parseInt(brandSelect.value, 10) || 0;
    triggerBrowse(true);
  });

  sortSelect.addEventListener('change', () => {
    state.sort = sortSelect.value;
    triggerBrowse(true);
  });

  resetBtn.addEventListener('click', () => {
    state.q = '';
    state.category_id = 0;
    state.brand_id = 0;
    state.sort = 'new';
    state.page = 1;
    updateControlsFromState();
    browse();
  });

  pagination.addEventListener('click', (e) => {
    const a = e.target.closest('a[data-page]');
    if (!a) return;
    e.preventDefault();
    const p = parseInt(a.getAttribute('data-page'), 10);
    if (!p || p < 1) return;
    state.page = p;
    browse();
  });

  // ===================== CART API =====================
  async function cartFetch(){
    const url = new URL("<?= htmlspecialchars(\App\Helpers\Url::to('/api/cart'), ENT_QUOTES, 'UTF-8') ?>", window.location.origin);
    const res = await fetch(url, {headers: {'X-Requested-With':'XMLHttpRequest'}});
    const data = await res.json();

    cartBadge.textContent = data.count ?? 0;
    cartTotal.textContent = Number(data.total ?? 0).toFixed(2);

    const items = data.items || [];
    if(items.length === 0){
      cartItems.innerHTML = `<div class="text-center muted">السلة فارغة</div>`;
      return;
    }

    cartItems.innerHTML = items.map(i => `
      <div class="cardx bg-white p-2">
        <div class="d-flex justify-content-between">
          <div>
            <div class="fw-bold">${escapeHtml(i.name)}</div>
            <div class="muted small">${escapeHtml(i.brand || '')}</div>
          </div>
          <div class="text-end">
            <div class="fw-bold">$${Number(i.price).toFixed(2)}</div>
            <div class="muted small">متوفر: ${i.stock}</div>
          </div>
        </div>

        <div class="d-flex gap-2 align-items-center mt-2">
          <input class="form-control form-control-sm" style="width: 90px"
                 type="number" min="0" max="99" value="${i.qty}"
                 onchange="cartUpdate(${i.id}, this.value)">
          <div class="ms-auto fw-bold">$${Number(i.line_total).toFixed(2)}</div>
        </div>
      </div>
    `).join('');
  }

  async function cartAdd(productId){
    const url = new URL("<?= htmlspecialchars(\App\Helpers\Url::to('/api/cart/add'), ENT_QUOTES, 'UTF-8') ?>", window.location.origin);
    const fd = new FormData();
    fd.append('_csrf', CSRF);
    fd.append('product_id', String(productId));
    fd.append('qty', '1');

    const res = await fetch(url, {method:'POST', body: fd, headers:{'X-Requested-With':'XMLHttpRequest'}});
    const data = await res.json();

    if(!data.ok){
      showToast(data.message || 'فشل الإضافة');
      return;
    }

    showToast('تمت الإضافة للسلة ✅');
    await cartFetch();
  }

  async function cartUpdate(productId, qty){
    const url = new URL("<?= htmlspecialchars(\App\Helpers\Url::to('/api/cart/update'), ENT_QUOTES, 'UTF-8') ?>", window.location.origin);
    const fd = new FormData();
    fd.append('_csrf', CSRF);
    fd.append('product_id', String(productId));
    fd.append('qty', String(qty));

    await fetch(url, {method:'POST', body: fd, headers:{'X-Requested-With':'XMLHttpRequest'}});
    await cartFetch();
  }

  clearCartBtn?.addEventListener('click', async () => {
    const url = new URL("<?= htmlspecialchars(\App\Helpers\Url::to('/api/cart/clear'), ENT_QUOTES, 'UTF-8') ?>", window.location.origin);
    const fd = new FormData();
    fd.append('_csrf', CSRF);

    await fetch(url, {method:'POST', body: fd, headers:{'X-Requested-With':'XMLHttpRequest'}});
    showToast('تم تفريغ السلة');
    await cartFetch();
  });

  // event delegation for add-to-cart (initial + ajax)
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-add-to-cart]');
    if(!btn) return;
    const pid = parseInt(btn.getAttribute('data-product-id'), 10);
    if(pid) cartAdd(pid);
  });

  // ===================== INIT =====================
  cartFetch();
  // أول تحميل الفلاتر/الصفحات يكون عبر browse حتى تتوحّد النتائج
  // خليها عندك إن تحب: إذا تريد الصفحة تبدأ نفس منتجات PHP initial، علّق هذا السطر
  browse();
</script>

</body>
</html>