<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title ?? 'طلباتي', ENT_QUOTES, 'UTF-8') ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body{font-family:'Cairo',system-ui;background:#f6f7fb}
    .cardx{border:0;box-shadow:0 10px 30px rgba(16,24,40,.10);border-radius:16px}
  </style>
</head>
<body>

<main class="container py-4" style="max-width:950px">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 fw-bold m-0">طلباتي</h1>

    <?php if (!empty($_SESSION['flash_success'])): ?>
  <div class="alert alert-success">
    <?= htmlspecialchars((string)$_SESSION['flash_success'], ENT_QUOTES, 'UTF-8') ?>
  </div>
  <?php unset($_SESSION['flash_success']); ?>
<?php endif; ?>

    <a class="btn btn-outline-secondary" href="<?= htmlspecialchars(\App\Helpers\Url::to('/'), ENT_QUOTES, 'UTF-8') ?>">رجوع للتسوق</a>
  </div>

  <?php if (empty($orders)): ?>
    <div class="cardx bg-white p-4">
      لا توجد طلبات بعد.
    </div>
  <?php else: ?>
    <div class="cardx bg-white p-3">
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th>#</th>
              <th>التاريخ</th>
              <th>الحالة</th>
              <th>الإجمالي</th>
              <th>تفاصيل</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            
<?php foreach ($orders as $o): ?>
  <?php
    $statusMap = [
      'pending' => 'بانتظار الموافقة',
      'approved' => 'تمت الموافقة - جار التجهيز',
      'out_for_delivery' => 'تم تسليمها الى المندوب',
      'delivered' => 'تم التوصيل',
      'cancelled' => 'ملغي',
    ];
    $statusKey = (string)($o['status'] ?? '');
    $label = $statusMap[$statusKey] ?? $statusKey;
  ?>
  <tr>
    <td class="fw-bold"><?= (int)$o['id'] ?></td>
    <td><?= htmlspecialchars((string)$o['created_at'], ENT_QUOTES, 'UTF-8') ?></td>

    <!-- ✅ هنا نطبع label مو status -->
    <td><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></td>

    <td> د.ع <?= number_format((float)$o['total'], 0) ?></td>

    <td class="text-end">
      <!-- ✅ الإلغاء فقط إذا pending -->
      <?php if ($statusKey === 'pending'): ?>
        <form method="post" action="<?= htmlspecialchars(\App\Helpers\Url::to('/order/cancel'), ENT_QUOTES, 'UTF-8') ?>" class="d-inline">
          <?= \App\Helpers\Csrf::input() ?>
          <input type="hidden" name="order_id" value="<?= (int)$o['id'] ?>">
          <button class="btn btn-sm btn-outline-danger" onclick="return confirm('إلغاء الطلب؟')">إلغاء</button>
        </form>
      <?php else: ?>
        <span class="text-muted">—</span>
      <?php endif; ?>
    </td>


    <td>
  <button class="btn btn-sm btn-outline-dark"
          type="button"
          onclick="openOrderDetails(<?= (int)$o['id'] ?>)">
    تفاصيل
  </button>
</td>

  </tr>
<?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  <?php endif; ?>
</main>

<div class="modal fade" id="orderModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:16px">
      <div class="modal-header">
        <h5 class="modal-title">تفاصيل الطلب</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="orderItemsBox" class="text-muted">...</div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const orderModal = new bootstrap.Modal(document.getElementById('orderModal'));
  const itemsBox = document.getElementById('orderItemsBox');

  async function openOrderDetails(orderId){
    itemsBox.innerHTML = 'جاري التحميل...';
    orderModal.show();

    const url = new URL("<?= htmlspecialchars(\App\Helpers\Url::to('/api/orders/items'), ENT_QUOTES, 'UTF-8') ?>", window.location.origin);
    url.searchParams.set('id', String(orderId));

    const res = await fetch(url, {headers:{'X-Requested-With':'XMLHttpRequest'}});
    const data = await res.json();

    if(!data.ok){
      itemsBox.innerHTML = `<div class="alert alert-danger mb-0">${data.message || 'خطأ'}</div>`;
      return;
    }

    if(!data.items || data.items.length === 0){
      itemsBox.innerHTML = `<div class="alert alert-warning mb-0">لا توجد تفاصيل.</div>`;
      return;
    }

    let html = `<div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead><tr>
          <th>المنتج</th><th>السعر</th><th>الكمية</th><th>المجموع</th>
        </tr></thead><tbody>`;

    for(const it of data.items){
      html += `<tr>
        <td>${escapeHtml(it.product_name || '')}</td>
        <td>$${Number(it.unit_price).toFixed(2)}</td>
        <td>${Number(it.qty)}</td>
        <td>$${Number(it.line_total).toFixed(2)}</td>
      </tr>`;
    }
    html += `</tbody></table></div>`;
    itemsBox.innerHTML = html;
  }

  function escapeHtml(s){
    return String(s).replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m]));
  }
</script>

</body>
</html>