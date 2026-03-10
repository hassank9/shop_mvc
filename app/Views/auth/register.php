<?php
declare(strict_types=1);

use App\Helpers\Url;
use App\Helpers\Csrf;

$title = $title ?? 'إنشاء حساب';
$return = $return ?? Url::to('/');   // أو '/' حسب ما تحب
$error = $error ?? '';
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    :root{
      --bg:#f6f7fb;
      --card:#fff;
      --muted:#667085;
      --shadow:0 14px 40px rgba(16,24,40,.12);
      --radius:18px;
    }
    body{font-family:'Cairo',system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;background:var(--bg)}
    .cardx{background:var(--card);border:0;border-radius:var(--radius);box-shadow:var(--shadow)}
    .chip{display:inline-flex;align-items:center;gap:.4rem;padding:.25rem .65rem;border-radius:999px;background:#fff;border:1px solid rgba(0,0,0,.08);font-size:.85rem}
    .muted{color:var(--muted)}
    .brand{letter-spacing:.3px}
    .inputx{border-radius:14px;padding:.75rem .9rem}
    .btnx{border-radius:14px;padding:.75rem .9rem}
    .hero{
      background: radial-gradient(1200px 600px at 80% 20%, rgba(13,110,253,.16), transparent 60%),
                  radial-gradient(900px 500px at 10% 60%, rgba(25,135,84,.12), transparent 55%);
    }
    .divider{height:1px;background:linear-gradient(90deg, transparent, rgba(0,0,0,.12), transparent)}
  </style>
</head>
<body class="hero">

<nav class="navbar bg-transparent">
  <div class="container py-2">
<br>
<br>
  </div>
</nav>

<main class="container py-4">
  <div class="row justify-content-center">
    <div class="col-12 col-md-9 col-lg-6">

      <div class="cardx p-4 p-md-5">
        <div class="d-flex align-items-start justify-content-between gap-2">
          <div>
            <h1 class="h4 fw-bold mb-1">إنشاء حساب جديد</h1>
          </div>
          <span class="badge text-bg-success rounded-pill px-3 py-2">New</span>
        </div>

        <div class="divider my-4"></div>

        <?php if (!empty($error)): ?>
          <div class="alert alert-danger">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
          </div>
        <?php endif; ?>

        <form method="POST" action="<?= htmlspecialchars(Url::to('/register'), ENT_QUOTES, 'UTF-8') ?>" novalidate>
          <?= Csrf::input() ?>
          <input type="hidden" name="return" value="<?= htmlspecialchars($return, ENT_QUOTES, 'UTF-8') ?>">

          <div class="row g-3">
            <div class="col-12">
              <label class="form-label fw-semibold">الاسم الكامل</label>
              <input name="full_name" class="form-control inputx" placeholder="مثال: حسن كريم " required autocomplete="name">
            </div>

            <div class="col-12 col-md-6">
              <label class="form-label fw-semibold">رقم الهاتف</label>
              <input name="phone" class="form-control inputx" placeholder="077xxxxxxxx" required autocomplete="tel">
            </div>

            <div class="col-12 col-md-6">
              <label class="form-label fw-semibold">كلمة المرور</label>
              <input name="password" type="password" class="form-control inputx" minlength="6" placeholder="6 أحرف أو أكثر" required autocomplete="new-password">
              <div class="form-text muted">سيتم حفظها بشكل آمن .</div>
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">العنوان الكامل</label>
              <textarea name="address" class="form-control inputx" rows="3" placeholder="المحافظة / المدينة / الشارع / أقرب نقطة..." required></textarea>
            </div>
          </div>

          <button class="btn btn-primary w-100 btnx fw-bold mt-4">إنشاء الحساب</button>

          <div class="d-flex align-items-center justify-content-between mt-3 flex-wrap gap-2">
            <a class="text-decoration-none" href="<?= htmlspecialchars(Url::to('/login?return=' . urlencode($return)), ENT_QUOTES, 'UTF-8') ?>">
              لدي حساب بالفعل
            </a>

            <a class="text-decoration-none muted" href="<?= htmlspecialchars(Url::to('/'), ENT_QUOTES, 'UTF-8') ?>">
              رجوع للمتجر
            </a>
          </div>
        </form>
      </div>

      <div class="text-center mt-3 muted small">
        ملاحظة: التوصيل غير متوفر، العنوان للتوثيق فقط.
      </div>

    </div>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>