<?php
$siteSettings = \App\Models\SiteSetting::first();

$siteName = trim((string)($siteSettings['site_name_ar'] ?? ''));
if ($siteName === '') {
    $siteName = trim((string)($siteSettings['site_name_en'] ?? ''));
}
if ($siteName === '') {
    $siteName = 'Store';
}

$siteLogo = trim((string)($siteSettings['logo'] ?? ''));
$siteFavicon = trim((string)($siteSettings['favicon'] ?? ''));
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars(($title ?? 'Product') . ' | ' . $siteName, ENT_QUOTES, 'UTF-8') ?></title>

  <?php if ($siteFavicon !== ''): ?>
    <link rel="icon" href="<?= htmlspecialchars(\App\Helpers\Url::file($siteFavicon), ENT_QUOTES, 'UTF-8') ?>">
  <?php endif; ?>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body{font-family:'Cairo',system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;background:#f6f7fb}
    .cardx{border:0;box-shadow:0 10px 30px rgba(16,24,40,.10);border-radius:16px}
    .chip{display:inline-flex;align-items:center;gap:.35rem;padding:.25rem .6rem;border-radius:999px;background:#fff;border:1px solid rgba(0,0,0,.08)}
    .muted{color:#667085}

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
      font-size:24px;
      line-height:1.1;
    }

    /* Gallery */
    .hero-wrap{border-radius:16px;border:1px solid rgba(0,0,0,.08);background:#fff;overflow:hidden}
    .hero-img{width:100%;height:420px;object-fit:cover;display:block}
    .thumbBtn{width:72px;height:72px;border-radius:12px;border:1px solid rgba(0,0,0,.10);overflow:hidden;background:#fff;padding:0}
    .thumbBtn img{width:100%;height:100%;object-fit:cover;display:block}
    .thumbBtn.active{outline:3px solid rgba(255,77,79,.55);border-color: rgba(255,77,79,.45)}
    .thumbRow{
      display:flex;
      gap:.5rem;
      overflow:auto;
      padding:6px 2px 2px;
      scroll-snap-type:x mandatory;
      justify-content:flex-start;
      align-items:center;
    }
    .thumbRow > *{scroll-snap-align:start}

    /* Skeleton */
    .skeleton{
      background: linear-gradient(90deg, rgba(0,0,0,.06) 25%, rgba(0,0,0,.11) 37%, rgba(0,0,0,.06) 63%);
      background-size: 400% 100%;
      animation: shimmer 1.2s ease-in-out infinite;
      border-radius: 12px;
    }
    @keyframes shimmer{0%{background-position:100% 0}100%{background-position:0 0}}
    .sk-hero{width:100%;height:420px;border-radius:16px;border:1px solid rgba(0,0,0,.08)}
    .sk-thumb{width:72px;height:72px;border-radius:12px;border:1px solid rgba(0,0,0,.10)}

    /* Toast */
    .toast-container{z-index: 2000}
  </style>
</head>
<body>

<nav class="navbar bg-white border-bottom sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold site-brand-link" href="<?= htmlspecialchars(\App\Helpers\Url::to('/'), ENT_QUOTES, 'UTF-8') ?>">
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

    <div class="d-flex gap-2">
      <a class="btn btn-outline-dark" href="<?= htmlspecialchars(\App\Helpers\Url::to('/cart'), ENT_QUOTES, 'UTF-8') ?>">
        السلة
      </a>
      <a class="btn btn-success" href="<?= htmlspecialchars(\App\Helpers\Url::to('/checkout'), ENT_QUOTES, 'UTF-8') ?>">إتمام الطلب</a>
    </div>
  </div>
</nav>

<!-- Toasts -->
<div class="toast-container position-fixed top-0 start-0 p-3"></div>

<main class="container py-4" style="max-width:1100px">
  <div class="row g-3">

    <!-- Gallery -->
    <div class="col-12 col-lg-6">
      <div class="cardx bg-white p-3">

        <?php
          $imgs = $images ?? [];
          $base = \App\Helpers\Url::to('/uploads/products/');
          $mainFile = $imgs[0]['file_name'] ?? '';
          $mainUrl = $mainFile ? ($base . $mainFile) : '';
        ?>

        <?php if ($mainUrl): ?>
          <div class="hero-wrap">
            <img id="mainImg"
                 class="hero-img"
                 src="<?= htmlspecialchars($mainUrl, ENT_QUOTES, 'UTF-8') ?>"
                 alt="product"
                 onerror="this.onerror=null; this.outerHTML='<div class=&quot;skeleton sk-hero&quot;></div>';">
          </div>
        <?php else: ?>
          <div class="skeleton sk-hero"></div>
        <?php endif; ?>

        <div class="mt-3">
          <?php if (!empty($imgs) && count($imgs) > 1): ?>
            <div class="thumbRow">
              <?php foreach ($imgs as $idx => $im): ?>
                <?php
                  $u = $base . $im['file_name'];
                  $active = ($idx === 0) ? 'active' : '';
                ?>
                <button type="button"
                        class="thumbBtn <?= $active ?>"
                        data-thumb
                        data-src="<?= htmlspecialchars($u, ENT_QUOTES, 'UTF-8') ?>">
                  <img src="<?= htmlspecialchars($u, ENT_QUOTES, 'UTF-8') ?>"
                       alt=""
                       onerror="this.onerror=null; this.outerHTML='<div class=&quot;skeleton sk-thumb&quot;></div>';">
                </button>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <div class="muted">لا توجد صور بعد</div>
          <?php endif; ?>
        </div>

      </div>
    </div>

    <!-- Info -->
    <div class="col-12 col-lg-6">
      <div class="cardx bg-white p-4 h-100">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <h1 class="h4 fw-bold mb-1"><?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?></h1>
            <div class="muted">
              <?= htmlspecialchars($product['brand_name'] ?? '—', ENT_QUOTES, 'UTF-8') ?> •
              <?= htmlspecialchars($product['category_name'] ?? '—', ENT_QUOTES, 'UTF-8') ?>
            </div>
          </div>
          <span class="badge text-bg-dark fs-6"> د.ع <?= number_format((float)$product['price'], 0) ?></span>
        </div>

        <div class="d-flex gap-2 mt-3 flex-wrap">
          <span class="chip">⭐ <?= htmlspecialchars((string)$product['rating'], ENT_QUOTES, 'UTF-8') ?></span>
          <?php if ((int)$product['qty'] > 0): ?>
            <span class="badge text-bg-success">متوفر (<?= (int)$product['qty'] ?>)</span>
          <?php else: ?>
            <span class="badge text-bg-danger">نفذ المخزون</span>
          <?php endif; ?>
        </div>

        <?php if (!empty($product['description'])): ?>
          <p class="mt-3 mb-4"><?= nl2br(htmlspecialchars((string)$product['description'], ENT_QUOTES, 'UTF-8')) ?></p>
        <?php else: ?>
          <p class="mt-3 mb-4 muted">لا يوجد وصف بعد.</p>
        <?php endif; ?>

        <div class="d-flex gap-2 align-items-center">
          <input id="qtyInput" type="number" class="form-control" style="max-width:140px"
                 min="1" max="99" value="1" <?= ((int)$product['qty'] <= 0) ? 'disabled' : '' ?>>
          <button class="btn btn-primary flex-grow-1"
                  onclick="addToCart(<?= (int)$product['id'] ?>)"
                  <?= ((int)$product['qty'] <= 0) ? 'disabled' : '' ?>>
            إضافة للسلة
          </button>
        </div>

        <div class="mt-3">
          <a class="btn btn-outline-success w-100"
             href="<?= htmlspecialchars(\App\Helpers\Url::to('/checkout'), ENT_QUOTES, 'UTF-8') ?>">
            الذهاب لإتمام الطلب
          </a>
        </div>
      </div>
    </div>

  </div>

  <?php if (!empty($related)): ?>
    <div class="mt-4">
      <h2 class="h5 fw-bold mb-3">منتجات مشابهة</h2>
      <div class="row g-3">
        <?php foreach ($related as $r): ?>
          <div class="col-12 col-sm-6 col-lg-3">
            <a class="text-decoration-none text-dark"
               href="<?= htmlspecialchars(\App\Helpers\Url::to('/product?slug=' . $r['slug']), ENT_QUOTES, 'UTF-8') ?>">
              <div class="cardx bg-white p-3 h-100">
                <div class="d-flex justify-content-between">
                  <div class="chip"><?= htmlspecialchars($r['brand_name'] ?? '—', ENT_QUOTES, 'UTF-8') ?></div>
                  <span class="badge text-bg-dark">د.ع <?= number_format((float)$r['price'], 0) ?></span>
                </div>
                <div class="fw-bold mt-3"><?= htmlspecialchars($r['name'], ENT_QUOTES, 'UTF-8') ?></div>
                <div class="d-flex gap-2 mt-2">
                  <span class="chip">⭐ <?= htmlspecialchars((string)$r['rating'], ENT_QUOTES, 'UTF-8') ?></span>
                  <?php if ((int)$r['qty'] > 0): ?>
                    <span class="badge text-bg-success">متوفر</span>
                  <?php else: ?>
                    <span class="badge text-bg-danger">نفذ</span>
                  <?php endif; ?>
                </div>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  const CSRF = "<?= htmlspecialchars(\App\Helpers\Csrf::token(), ENT_QUOTES, 'UTF-8') ?>";

  // ✅ تبديل الصور (Gallery)
  const mainImg = document.getElementById('mainImg');
  const thumbBtns = document.querySelectorAll('[data-thumb]');

  function setActive(btn){
    thumbBtns.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
  }

  thumbBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const src = btn.getAttribute('data-src');
      if (mainImg && src) {
        mainImg.src = src;
        setActive(btn);
      }
    });
  });

  // ✅ Toast helper
  function toast(message, type='success'){
    const container = document.querySelector('.toast-container');
    const el = document.createElement('div');
    el.className = 'toast align-items-center text-bg-' + (type === 'success' ? 'success' : (type === 'danger' ? 'danger' : 'dark')) + ' border-0';
    el.setAttribute('role','alert');
    el.setAttribute('aria-live','assertive');
    el.setAttribute('aria-atomic','true');
    el.innerHTML = `
      <div class="d-flex">
        <div class="toast-body">${message}</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>`;
    container.appendChild(el);
    const t = new bootstrap.Toast(el, {delay: 1800});
    t.show();
    el.addEventListener('hidden.bs.toast', ()=> el.remove());
  }

  async function addToCart(productId){
    const qty = parseInt(document.getElementById('qtyInput').value, 10) || 1;

    const url = new URL("<?= htmlspecialchars(\App\Helpers\Url::to('/api/cart/add'), ENT_QUOTES, 'UTF-8') ?>", window.location.origin);
    const fd = new FormData();
    fd.append('_csrf', CSRF);
    fd.append('product_id', String(productId));
    fd.append('qty', String(qty));

    const res = await fetch(url, {method:'POST', body: fd, headers:{'X-Requested-With':'XMLHttpRequest'}});
    const data = await res.json();

    if(!data.ok){
      toast(data.message || 'فشل الإضافة', 'danger');
      return;
    }

    const badge = document.getElementById('cartBadge');
    if (badge && typeof data.cart_count !== 'undefined') {
      badge.textContent = String(data.cart_count);
    }

    toast('تمت الإضافة للسلة ✅', 'success');
  }
</script>
</body>
</html>