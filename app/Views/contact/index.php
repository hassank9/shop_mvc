<?php
$siteSettings = $siteSettings ?? [];
$siteName = $siteName ?? 'Store';

$contactPhone1 = trim((string)($siteSettings['contact_phone_1'] ?? ''));
$contactPhone2 = trim((string)($siteSettings['contact_phone_2'] ?? ''));
$contactWhatsapp = trim((string)($siteSettings['contact_whatsapp'] ?? ''));
$contactEmail = trim((string)($siteSettings['contact_email'] ?? ''));
$contactAddress = trim((string)($siteSettings['contact_address'] ?? ''));
$contactMapUrl = trim((string)($siteSettings['contact_map_url'] ?? ''));

$facebookUrl = trim((string)($siteSettings['facebook_url'] ?? ''));
$instagramUrl = trim((string)($siteSettings['instagram_url'] ?? ''));
$telegramUrl = trim((string)($siteSettings['telegram_url'] ?? ''));
$tiktokUrl = trim((string)($siteSettings['tiktok_url'] ?? ''));

$siteLogo = trim((string)($siteSettings['logo'] ?? ''));
$siteFavicon = trim((string)($siteSettings['favicon'] ?? ''));
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars('تواصل معنا | ' . $siteName, ENT_QUOTES, 'UTF-8') ?></title>

  <?php if ($siteFavicon !== ''): ?>
    <link rel="icon" href="<?= htmlspecialchars(\App\Helpers\Url::file($siteFavicon), ENT_QUOTES, 'UTF-8') ?>">
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

    .contact-wrap{
      padding:40px 0 24px;
    }

    .contact-header{
      margin-bottom:22px;
    }

    .contact-badge{
      display:inline-flex;
      width:fit-content;
      padding:8px 14px;
      border-radius:999px;
      background:#fff7ed;
      color:#ea580c;
      font-size:13px;
      font-weight:800;
      border:1px solid rgba(249,115,22,.15);
      margin-bottom:14px;
    }

    .contact-title{
      margin:0 0 10px;
      font-size:clamp(28px, 4vw, 46px);
      line-height:1.15;
      font-weight:900;
      color:#0f172a;
    }

    .contact-subtitle{
      margin:0;
      color:#64748b;
      font-size:16px;
      line-height:1.9;
    }

    .contact-grid{
      display:grid;
      grid-template-columns:1fr 1fr;
      gap:22px;
    }

    .contact-card{
      background:#fff;
      border:1px solid #eef1f5;
      border-radius:28px;
      box-shadow:0 20px 45px rgba(15,23,42,.06);
      padding:26px;
      height:100%;
    }

    .contact-card-title{
      margin:0 0 18px;
      font-size:24px;
      font-weight:900;
      color:#111827;
    }

    .contact-list{
      display:flex;
      flex-direction:column;
      gap:14px;
    }

    .contact-item{
      padding:14px 16px;
      border:1px solid #eef1f5;
      border-radius:18px;
      background:#fafafa;
    }

    .contact-label{
      display:block;
      font-size:13px;
      font-weight:800;
      color:#ea580c;
      margin-bottom:6px;
    }

    .contact-value,
    .contact-value a{
      color:#111827;
      text-decoration:none;
      font-weight:700;
      line-height:1.8;
      word-break:break-word;
    }

    .contact-value a:hover{
      color:#ea580c;
    }

    .contact-socials{
      display:flex;
      flex-wrap:wrap;
      gap:10px;
      margin-top:18px;
    }

    .contact-social{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      min-height:44px;
      padding:0 18px;
      border-radius:14px;
      background:#fff;
      border:1px solid #e5e7eb;
      color:#111827;
      text-decoration:none;
      font-weight:800;
      transition:.2s ease;
    }

    .contact-social:hover{
      color:#ea580c;
      border-color:#fdba74;
      background:#fff7ed;
    }

    .map-frame-wrap{
      margin-top:18px;
      border-radius:22px;
      overflow:hidden;
      border:1px solid #eef1f5;
      min-height:320px;
      background:#fff;
    }

    .map-frame{
      width:100%;
      min-height:320px;
      border:0;
      display:block;
    }

    .contact-actions{
      display:flex;
      gap:12px;
      flex-wrap:wrap;
      margin-top:18px;
    }

    .contact-btn{
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

    .contact-btn-primary{
      background:linear-gradient(135deg, #ff7a1a, #ea580c);
      color:#fff;
      box-shadow:0 14px 30px rgba(249,115,22,.24);
    }

    .contact-btn-primary:hover{
      color:#fff;
      transform:translateY(-1px);
    }

    .contact-btn-secondary{
      background:#fff;
      color:#111827;
      border-color:#e5e7eb;
    }

    .contact-btn-secondary:hover{
      color:#111827;
      background:#f8fafc;
    }

    @media (max-width: 991px){
      .contact-grid{
        grid-template-columns:1fr;
      }

      .site-brand-text{
        font-size:18px;
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
      <a class="btn btn-outline-dark" href="<?= htmlspecialchars(\App\Helpers\Url::to('/'), ENT_QUOTES, 'UTF-8') ?>">الرئيسية</a>
      <a class="btn btn-warning" href="<?= htmlspecialchars(\App\Helpers\Url::to('/about'), ENT_QUOTES, 'UTF-8') ?>">من نحن</a>
    </div>
  </div>
</nav>

<main class="contact-wrap">
  <div class="container">
    <div class="contact-header">
      <span class="contact-badge">نحن هنا لخدمتك</span>
      <h1 class="contact-title">تواصل معنا</h1>
      <p class="contact-subtitle">يمكنك الوصول إلينا عبر الهاتف أو الواتساب أو البريد الإلكتروني، كما يمكنك الاطلاع على العنوان وروابط المنصات الخاصة بنا.</p>
    </div>

    <div class="contact-grid">
      <div class="contact-card">
        <h2 class="contact-card-title">بيانات التواصل</h2>

        <div class="contact-list">
          <?php if ($contactPhone1 !== ''): ?>
            <div class="contact-item">
              <span class="contact-label">الهاتف الأول</span>
              <div class="contact-value">
                <a href="tel:<?= htmlspecialchars($contactPhone1, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($contactPhone1, ENT_QUOTES, 'UTF-8') ?></a>
              </div>
            </div>
          <?php endif; ?>

          <?php if ($contactPhone2 !== ''): ?>
            <div class="contact-item">
              <span class="contact-label">الهاتف الثاني</span>
              <div class="contact-value">
                <a href="tel:<?= htmlspecialchars($contactPhone2, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($contactPhone2, ENT_QUOTES, 'UTF-8') ?></a>
              </div>
            </div>
          <?php endif; ?>

          <?php if ($contactWhatsapp !== ''): ?>
            <div class="contact-item">
              <span class="contact-label">واتساب</span>
              <div class="contact-value">
                <a href="https://wa.me/<?= htmlspecialchars(preg_replace('/\D+/', '', $contactWhatsapp), ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener">
                  <?= htmlspecialchars($contactWhatsapp, ENT_QUOTES, 'UTF-8') ?>
                </a>
              </div>
            </div>
          <?php endif; ?>

          <?php if ($contactEmail !== ''): ?>
            <div class="contact-item">
              <span class="contact-label">البريد الإلكتروني</span>
              <div class="contact-value">
                <a href="mailto:<?= htmlspecialchars($contactEmail, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($contactEmail, ENT_QUOTES, 'UTF-8') ?></a>
              </div>
            </div>
          <?php endif; ?>

          <?php if ($contactAddress !== ''): ?>
            <div class="contact-item">
              <span class="contact-label">العنوان</span>
              <div class="contact-value"><?= nl2br(htmlspecialchars($contactAddress, ENT_QUOTES, 'UTF-8')) ?></div>
            </div>
          <?php endif; ?>
        </div>

        <div class="contact-socials">
          <?php if ($facebookUrl !== ''): ?>
            <a class="contact-social" href="<?= htmlspecialchars($facebookUrl, ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener">Facebook</a>
          <?php endif; ?>

          <?php if ($instagramUrl !== ''): ?>
            <a class="contact-social" href="<?= htmlspecialchars($instagramUrl, ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener">Instagram</a>
          <?php endif; ?>

          <?php if ($telegramUrl !== ''): ?>
            <a class="contact-social" href="<?= htmlspecialchars($telegramUrl, ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener">Telegram</a>
          <?php endif; ?>

          <?php if ($tiktokUrl !== ''): ?>
            <a class="contact-social" href="<?= htmlspecialchars($tiktokUrl, ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener">TikTok</a>
          <?php endif; ?>
        </div>

        <div class="contact-actions">
          <?php if ($contactWhatsapp !== ''): ?>
            <a class="contact-btn contact-btn-primary"
               target="_blank"
               rel="noopener"
               href="https://wa.me/<?= htmlspecialchars(preg_replace('/\D+/', '', $contactWhatsapp), ENT_QUOTES, 'UTF-8') ?>">
              تواصل عبر واتساب
            </a>
          <?php endif; ?>

          <a class="contact-btn contact-btn-secondary" href="<?= htmlspecialchars(\App\Helpers\Url::to('/'), ENT_QUOTES, 'UTF-8') ?>">
            العودة للرئيسية
          </a>
        </div>
      </div>

      <div class="contact-card">
        <h2 class="contact-card-title">الموقع والخريطة</h2>

        <?php if ($contactMapUrl !== ''): ?>
          <div class="map-frame-wrap">
            <iframe
              class="map-frame"
              src="<?= htmlspecialchars($contactMapUrl, ENT_QUOTES, 'UTF-8') ?>"
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
              allowfullscreen>
            </iframe>
          </div>

          <div class="contact-actions">
            <a class="contact-btn contact-btn-primary"
               href="<?= htmlspecialchars($contactMapUrl, ENT_QUOTES, 'UTF-8') ?>"
               target="_blank"
               rel="noopener">
              فتح الخريطة
            </a>
          </div>
        <?php else: ?>
          <div class="contact-item">
            <span class="contact-label">الخريطة</span>
            <div class="contact-value">لم يتم إضافة رابط الخريطة بعد.</div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</main>

</body>
</html>