<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title ?? 'Shop', ENT_QUOTES, 'UTF-8') ?></title>

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
    <a class="navbar-brand fw-bold" href="<?= htmlspecialchars(\App\Helpers\Url::to('/'), ENT_QUOTES, 'UTF-8') ?>">🛒 FirstClass</a>


    <?php
  $return = $_SERVER['REQUEST_URI'] ?? \App\Helpers\Url::to('/');
  $loginUrl = \App\Helpers\Url::to('/login?return=' . urlencode($return));
  $regUrl   = \App\Helpers\Url::to('/register?return=' . urlencode($return));
  $ordersUrl = \App\Helpers\Url::to('/orders');
?>
<div class="ms-auto d-flex gap-2 align-items-center">
    <div class="ms-auto d-flex gap-2 align-items-center">
      <button class="btn btn-outline-dark position-relative"
              type="button"
              data-bs-toggle="offcanvas" data-bs-target="#cartCanvas"
              aria-controls="cartCanvas">
        🧺 السلة
        <span id="cartBadge" class="position-absolute top-0 start-0 translate-middle badge rounded-pill text-bg-danger">0</span>
      </button>
    </div>

    <?php
$ordersUrl = \App\Helpers\Url::to('/my-orders');
$loginUrl  = \App\Helpers\Url::to('/login?return=' . urlencode(\App\Helpers\Url::to($_SERVER['REQUEST_URI'] ?? '/')));
$regUrl    = \App\Helpers\Url::to('/register?return=' . urlencode(\App\Helpers\Url::to($_SERVER['REQUEST_URI'] ?? '/')));
?>

  <?php if (\App\Helpers\Auth::check()): ?>
    <a class="btn btn-outline-primary"
       href="<?= htmlspecialchars($ordersUrl, ENT_QUOTES, 'UTF-8') ?>">
      طلباتي
    </a>

    <form method="POST" action="<?= htmlspecialchars(\App\Helpers\Url::to('/logout'), ENT_QUOTES, 'UTF-8') ?>" class="d-inline">
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

  </div>
</nav>

<main class="container py-4">

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
            <span class="badge text-bg-dark price-badge">$<?= number_format((float)$p['price'], 2) ?></span>
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
        <div class="fw-bold">$<span id="cartTotal">0.00</span></div>
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
      <strong class="me-auto">FirstClass</strong>
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
          <span class="badge text-bg-dark price-badge">$${Number(p.price).toFixed(2)}</span>
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