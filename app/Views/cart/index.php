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
  <title><?= htmlspecialchars(($title ?? 'السلة') . ' | ' . $siteName, ENT_QUOTES, 'UTF-8') ?></title>

  <?php if ($siteFavicon !== ''): ?>
    <link rel="icon" href="<?= htmlspecialchars(\App\Helpers\Url::file($siteFavicon), ENT_QUOTES, 'UTF-8') ?>">
  <?php endif; ?>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body{font-family:'Cairo',system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;background:#f6f7fb}
    .cardx{border:0;box-shadow:0 10px 30px rgba(16,24,40,.10);border-radius:16px}
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
      <a class="btn btn-outline-dark" href="<?= htmlspecialchars(\App\Helpers\Url::to('/'), ENT_QUOTES, 'UTF-8') ?>">متابعة التسوق</a>
      <a class="btn btn-success" href="<?= htmlspecialchars(\App\Helpers\Url::to('/checkout'), ENT_QUOTES, 'UTF-8') ?>">إتمام الطلب</a>
    </div>
  </div>
</nav>

<main class="container py-4" style="max-width: 980px;">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h1 class="h4 fw-bold mb-0">سلة المشتريات</h1>
      <div class="muted small">تعديل الكميات مباشرة بدون تحديث الصفحة</div>
    </div>
    <button class="btn btn-outline-danger btn-sm" id="clearBtn">تفريغ السلة</button>
  </div>

  <div class="row g-3">
    <div class="col-12 col-lg-8">
      <div id="cartList" class="vstack gap-2"></div>
      <div id="emptyBox" class="cardx bg-white p-4 d-none">
        <b>السلة فارغة.</b>
        <div class="muted">ارجع للرئيسية وأضف منتجات.</div>
      </div>
    </div>

    <div class="col-12 col-lg-4">
      <div class="cardx bg-white p-3">
        <div class="d-flex justify-content-between">
          <span class="muted">عدد العناصر</span>
          <b id="itemsCount">0</b>
        </div>
        <hr>
        <div class="d-flex justify-content-between">
          <span class="muted">الإجمالي</span>
          <b> د.ع <span id="total">0.00</span></b>
        </div>
        <div class="d-grid gap-2 mt-3">
          <a class="btn btn-success" id="checkoutBtn" href="<?= htmlspecialchars(\App\Helpers\Url::to('/checkout'), ENT_QUOTES, 'UTF-8') ?>">إتمام الطلب</a>
          <a class="btn btn-outline-dark" href="<?= htmlspecialchars(\App\Helpers\Url::to('/'), ENT_QUOTES, 'UTF-8') ?>">متابعة التسوق</a>
        </div>
      </div>
    </div>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  const CSRF = "<?= htmlspecialchars(\App\Helpers\Csrf::token(), ENT_QUOTES, 'UTF-8') ?>";

  const listEl = document.getElementById('cartList');
  const emptyBox = document.getElementById('emptyBox');
  const totalEl = document.getElementById('total');
  const countEl = document.getElementById('itemsCount');
  const clearBtn = document.getElementById('clearBtn');
  const checkoutBtn = document.getElementById('checkoutBtn');

  function escapeHtml(s){
    return String(s ?? '').replace(/[&<>"']/g, m => ({
      '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'
    }[m]));
  }

  async function apiGetCart(){
    const url = new URL("<?= htmlspecialchars(\App\Helpers\Url::to('/api/cart'), ENT_QUOTES, 'UTF-8') ?>", window.location.origin);
    const res = await fetch(url, {headers:{'X-Requested-With':'XMLHttpRequest'}});
    return await res.json();
  }

  async function apiUpdate(pid, qty){
    const url = new URL("<?= htmlspecialchars(\App\Helpers\Url::to('/api/cart/update'), ENT_QUOTES, 'UTF-8') ?>", window.location.origin);
    const fd = new FormData();
    fd.append('_csrf', CSRF);
    fd.append('product_id', String(pid));
    fd.append('qty', String(qty));
    await fetch(url, {method:'POST', body: fd, headers:{'X-Requested-With':'XMLHttpRequest'}});
  }

  async function apiClear(){
    const url = new URL("<?= htmlspecialchars(\App\Helpers\Url::to('/api/cart/clear'), ENT_QUOTES, 'UTF-8') ?>", window.location.origin);
    const fd = new FormData();
    fd.append('_csrf', CSRF);
    await fetch(url, {method:'POST', body: fd, headers:{'X-Requested-With':'XMLHttpRequest'}});
  }

  function render(data){
    const items = data.items || [];
    const total = Number(data.total ?? 0).toFixed(2);

    totalEl.textContent = total;
    countEl.textContent = data.count ?? 0;

    if(items.length === 0){
      listEl.innerHTML = '';
      emptyBox.classList.remove('d-none');
      checkoutBtn.classList.add('disabled');
      return;
    }

    emptyBox.classList.add('d-none');
    checkoutBtn.classList.remove('disabled');

    listEl.innerHTML = items.map(i => `
      <div class="cardx bg-white p-3">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="fw-bold">${escapeHtml(i.name)}</div>
            <div class="muted small">${escapeHtml(i.brand || '')}</div>
          </div>
          <div class="text-end">
            <div class="fw-bold">$${Number(i.price).toFixed(2)}</div>
            <div class="muted small">متوفر: ${i.stock}</div>
          </div>
        </div>

        <div class="d-flex gap-2 align-items-center mt-3">
          <label class="muted small">الكمية</label>
          <input class="form-control form-control-sm" style="width:110px"
                 type="number" min="0" max="99" value="${i.qty}"
                 data-qty-input data-id="${i.id}">
          <button class="btn btn-outline-danger btn-sm ms-auto" data-remove data-id="${i.id}">حذف</button>
          <div class="fw-bold">$${Number(i.line_total).toFixed(2)}</div>
        </div>
      </div>
    `).join('');
  }

  let debounce = null;

  document.addEventListener('input', (e) => {
    const inp = e.target.closest('[data-qty-input]');
    if(!inp) return;

    clearTimeout(debounce);
    debounce = setTimeout(async () => {
      const pid = parseInt(inp.getAttribute('data-id'), 10);
      const qty = parseInt(inp.value, 10) || 0;
      await apiUpdate(pid, qty);
      const data = await apiGetCart();
      render(data);
    }, 250);
  });

  document.addEventListener('click', async (e) => {
    const rm = e.target.closest('[data-remove]');
    if(rm){
      const pid = parseInt(rm.getAttribute('data-id'), 10);
      await apiUpdate(pid, 0);
      const data = await apiGetCart();
      render(data);
      return;
    }
  });

  clearBtn.addEventListener('click', async () => {
    await apiClear();
    const data = await apiGetCart();
    render(data);
  });

  (async () => {
    const data = await apiGetCart();
    render(data);
  })();
</script>
</body>
</html>