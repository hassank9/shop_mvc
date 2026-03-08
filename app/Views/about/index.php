<?php
$siteSettings = $siteSettings ?? [];
$siteName = $siteName ?? 'FirstClass';

$aboutTitle = trim((string)($siteSettings['about_title'] ?? ''));
if ($aboutTitle === '') {
    $aboutTitle = 'من نحن';
}

$aboutText = trim((string)($siteSettings['about_text'] ?? ''));
$aboutImage = trim((string)($siteSettings['about_image'] ?? ''));
$siteLogo = trim((string)($siteSettings['logo'] ?? ''));
$siteFavicon = trim((string)($siteSettings['favicon'] ?? ''));
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($aboutTitle . ' | ' . $siteName, ENT_QUOTES, 'UTF-8') ?></title>

  <?php if ($siteFavicon !== ''): ?>
    <link rel="icon" href="<?= htmlspecialchars($siteFavicon, ENT_QUOTES, 'UTF-8') ?>">
  <?php endif; ?>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

  <style>
    body{
      background:#f8fafc;
      color:#111827;
      font-family:Tahoma, Arial, sans-serif;
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
      font-size:28px;
      line-height:1.1;
    }

    .about-hero{
      padding:40px 0 24px;
    }

    .about-card{
      background:#fff;
      border:1px solid #eef1f5;
      border-radius:28px;
      box-shadow:0 20px 45px rgba(15,23,42,.06);
      overflow:hidden;
    }

    .about-grid{
      display:grid;
      grid-template-columns:1fr 1fr;
      gap:0;
      align-items:stretch;
    }

    .about-copy{
      padding:40px;
      display:flex;
      flex-direction:column;
      justify-content:center;
      gap:18px;
    }

    .about-badge{
      display:inline-flex;
      width:fit-content;
      padding:8px 14px;
      border-radius:999px;
      background:#fff7ed;
      color:#ea580c;
      font-size:13px;
      font-weight:800;
      border:1px solid rgba(249,115,22,.15);
    }

    .about-title{
      margin:0;
      font-size:clamp(28px, 4vw, 46px);
      line-height:1.15;
      font-weight:900;
      color:#0f172a;
    }

    .about-text{
      margin:0;
      color:#64748b;
      font-size:16px;
      line-height:2;
      white-space:pre-line;
    }

    .about-image-wrap{
      min-height:420px;
      background:linear-gradient(135deg, #fff7ed, #ffffff);
      display:flex;
      align-items:center;
      justify-content:center;
      padding:20px;
    }

    .about-image{
      width:100%;
      height:100%;
      min-height:380px;
      max-height:520px;
      object-fit:cover;
      border-radius:24px;
      display:block;
      box-shadow:0 18px 40px rgba(15,23,42,.10);
    }

    .about-no-image{
      width:100%;
      min-height:380px;
      border-radius:24px;
      display:flex;
      align-items:center;
      justify-content:center;
      background:
        radial-gradient(circle at top right, rgba(249,115,22,.12), transparent 30%),
        linear-gradient(135deg, #fff, #fff7ed);
      color:#94a3b8;
      font-size:20px;
      font-weight:800;
      border:1px solid #f1f5f9;
    }

    .about-actions{
      display:flex;
      gap:12px;
      flex-wrap:wrap;
      margin-top:8px;
    }

    .about-btn{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      min-height:46px;
      padding:0 20px;
      border-radius:16px;
      text-decoration:none;
      font-weight:800;
      transition:.2s ease;
      border:1px solid transparent;
    }

    .about-btn-primary{
      background:linear-gradient(135deg, #ff7a1a, #ea580c);
      color:#fff;
      box-shadow:0 14px 30px rgba(249,115,22,.24);
    }

    .about-btn-primary:hover{
      color:#fff;
      transform:translateY(-1px);
    }

    .about-btn-secondary{
      background:#fff;
      color:#111827;
      border-color:#e5e7eb;
    }

    .about-btn-secondary:hover{
      color:#111827;
      background:#f8fafc;
    }

    @media (max-width: 991px){
      .about-grid{
        grid-template-columns:1fr;
      }

      .about-copy{
        padding:24px;
      }

      .about-image-wrap{
        min-height:auto;
      }

      .about-image,
      .about-no-image{
        min-height:240px;
      }
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold site-brand-link" href="<?= htmlspecialchars(\App\Helpers\Url::to('/'), ENT_QUOTES, 'UTF-8') ?>">
      <?php if ($siteLogo !== ''): ?>
        <img
          src="<?= htmlspecialchars($siteLogo, ENT_QUOTES, 'UTF-8') ?>"
          alt="<?= htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8') ?>"
          class="site-brand-logo"
        >
      <?php else: ?>
        <span class="site-brand-emoji">🛒</span>
      <?php endif; ?>

      <span class="site-brand-text"><?= htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8') ?></span>
    </a>

    <div class="d-flex gap-2">
      <a class="btn btn-outline-dark" href="<?= htmlspecialchars(\App\Helpers\Url::to('/'), ENT_QUOTES, 'UTF-8') ?>">الرئيسية</a>
      <a class="btn btn-warning" href="<?= htmlspecialchars(\App\Helpers\Url::to('/contact'), ENT_QUOTES, 'UTF-8') ?>">تواصل معنا</a>
    </div>
  </div>
</nav>

<main class="about-hero">
  <div class="container">
    <div class="about-card">
      <div class="about-grid">
        <div class="about-copy">
          <span class="about-badge">تعرف علينا</span>
          <h1 class="about-title"><?= htmlspecialchars($aboutTitle, ENT_QUOTES, 'UTF-8') ?></h1>

          <p class="about-text"><?= htmlspecialchars($aboutText !== '' ? $aboutText : 'سيتم إضافة نبذة تعريفية عن المتجر قريبًا.', ENT_QUOTES, 'UTF-8') ?></p>

          <div class="about-actions">
            <a class="about-btn about-btn-primary" href="<?= htmlspecialchars(\App\Helpers\Url::to('/'), ENT_QUOTES, 'UTF-8') ?>">العودة للرئيسية</a>
            <a class="about-btn about-btn-secondary" href="<?= htmlspecialchars(\App\Helpers\Url::to('/contact'), ENT_QUOTES, 'UTF-8') ?>">تواصل معنا</a>
          </div>
        </div>

        <div class="about-image-wrap">
          <?php if ($aboutImage !== ''): ?>
            <img
              src="<?= htmlspecialchars($aboutImage, ENT_QUOTES, 'UTF-8') ?>"
              alt="<?= htmlspecialchars($aboutTitle, ENT_QUOTES, 'UTF-8') ?>"
              class="about-image"
            >
          <?php else: ?>
            <div class="about-no-image">لا توجد صورة حالياً</div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</main>

</body>
</html>