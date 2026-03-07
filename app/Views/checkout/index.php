<?php
/** @var array $user */
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title ?? 'Checkout', ENT_QUOTES, 'UTF-8') ?></title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body{font-family:'Cairo',system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;background:#f6f7fb}
    .cardx{border:0;box-shadow:0 10px 30px rgba(16,24,40,.10);border-radius:16px}
    .muted{color:#667085}
  </style>
</head>
<body class="p-3 p-md-4">

<div class="container" style="max-width:900px">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">إتمام الطلب</h3>
    <a class="btn btn-outline-secondary" href="<?= htmlspecialchars(\App\Helpers\Url::to('/'), ENT_QUOTES, 'UTF-8') ?>">رجوع للتسوق</a>
  </div>

  <div class="cardx bg-white p-4">
    <div class="alert alert-info mb-4">
      سنستخدم بيانات حسابك لإتمام الطلب:
      <div class="mt-2 small">
        <b>الاسم:</b> <?= htmlspecialchars((string)$user['full_name'], ENT_QUOTES, 'UTF-8') ?><br>
        <b>الهاتف:</b> <?= htmlspecialchars((string)$user['phone'], ENT_QUOTES, 'UTF-8') ?><br>
        <b>العنوان:</b> <?= htmlspecialchars((string)$user['address'], ENT_QUOTES, 'UTF-8') ?>
      </div>
    </div>

    <form method="POST" action="<?= htmlspecialchars(\App\Helpers\Url::to('/checkout'), ENT_QUOTES, 'UTF-8') ?>">
      <?= \App\Helpers\Csrf::input() ?>




      <?php
$cartLines = $cartLines ?? [];
$cartTotal = (float)($cartTotal ?? 0);
?>

<?php if (empty($cartLines)): ?>
  <div class="alert alert-warning mb-4">
    سلتك فارغة. <a href="<?= htmlspecialchars(\App\Helpers\Url::to('/'), ENT_QUOTES, 'UTF-8') ?>">رجوع للتسوق</a>
  </div>
<?php else: ?>
  <div class="cardx bg-white p-3 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <div class="fw-bold">مراجعة السلة قبل التأكيد</div>
      <a class="btn btn-sm btn-outline-secondary" href="<?= htmlspecialchars(\App\Helpers\Url::to('/cart'), ENT_QUOTES, 'UTF-8') ?>">
        تعديل السلة
      </a>
    </div>

    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead>
          <tr>
            <th>المنتج</th>
            <th style="width:90px">العدد</th>
            <th style="width:140px">السعر</th>
            <th style="width:160px">الإجمالي</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($cartLines as $l): ?>
            <tr>
              <td class="fw-semibold">
                <?= htmlspecialchars($l['name'], ENT_QUOTES, 'UTF-8') ?>
                <?php if (!empty($l['brand_name'])): ?>
                  <div class="muted small"><?= htmlspecialchars($l['brand_name'], ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>
              </td>
              <td><?= (int)$l['qty'] ?></td>
              <td>$<?= number_format((float)$l['unit_price'], 2) ?></td>
              <td class="fw-bold">$<?= number_format((float)$l['line_total'], 2) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr>
            <th colspan="3" class="text-end">الإجمالي النهائي</th>
            <th class="fw-bold">$<?= number_format($cartTotal, 2) ?></th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
<?php endif; ?>





      <div class="mb-3">
        <label class="form-label">ملاحظات (اختياري)</label>
        <textarea name="notes" class="form-control" maxlength="500" rows="3" placeholder="مثال: رجاءً الاتصال قبل الحضور"></textarea>
        <div class="muted small mt-1">شكرا لكم .. يمكنكم تتبع حالة الطلب من صفحة طلباتي في الموقع</div>
      </div>

      <button class="btn btn-success w-100">تأكيد الطلب</button>
    </form>
  </div>
</div>

</body>
</html>