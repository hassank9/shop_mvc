<?php
$pageTitle = $pageTitle ?? 'لوحة التحكم';
$contentView = $contentView ?? null;
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

    <style>
        :root{
            --bg:#f6f7fb;
            --card:#ffffff;
            --line:#e9edf3;
            --text:#1f2937;
            --muted:#6b7280;
            --primary:#ff6a00;
            --primary-dark:#e55f00;
            --shadow:0 10px 30px rgba(15,23,42,.06);
            --radius-xl:26px;
            --radius-lg:20px;
            --radius-md:16px;
            --sidebar-width:290px;
            --sidebar-collapsed-width:88px;
        }

        *{box-sizing:border-box}

        body{
            margin:0;
            background:var(--bg);
            font-family:Tahoma,Arial,sans-serif;
            color:var(--text);
        }

        .admin-app{
            min-height:100vh;
        }

        .admin-layout{
            display:flex;
            min-height:100vh;
        }

        .admin-sidebar{
            width:var(--sidebar-width);
            background:var(--card);
            border-left:1px solid var(--line);
            box-shadow:var(--shadow);
            padding:20px 16px;
            transition:width .25s ease, transform .25s ease;
            position:relative;
            z-index:1000;
        }

        .admin-main{
            flex:1;
            min-width:0;
            padding:22px;
            transition:.25s ease;
        }

        .topbar-wrap{
            margin-bottom:22px;
        }

        .content-card{
            background:var(--card);
            border-radius:var(--radius-xl);
            box-shadow:var(--shadow);
            border:1px solid #f0f2f6;
            padding:24px;
        }

        body.sidebar-collapsed .admin-sidebar{
            width:var(--sidebar-collapsed-width);
            padding-inline:10px;
        }

        body.sidebar-collapsed .sidebar-text,
        body.sidebar-collapsed .sidebar-title,
        body.sidebar-collapsed .sidebar-footer-text,
        body.sidebar-collapsed .brand-subtitle{
            display:none !important;
        }

        body.sidebar-collapsed .brand-title{
            font-size:0;
        }

        body.sidebar-collapsed .brand-title::after{
            content:"AI";
            font-size:22px;
            font-weight:800;
        }

        body.sidebar-collapsed .sidebar-link{
            justify-content:center;
            padding:14px 10px;
        }

        body.sidebar-collapsed .sidebar-icon{
            margin:0;
        }

        .mobile-sidebar-backdrop{
            display:none;
        }

        @media (max-width: 991.98px){
            .admin-main{
                padding:14px;
            }

            .admin-sidebar{
                position:fixed;
                top:0;
                right:0;
                height:100vh;
                transform:translateX(100%);
                width:var(--sidebar-width);
                max-width:88vw;
                overflow-y:auto;
            }

            body.sidebar-mobile-open .admin-sidebar{
                transform:translateX(0);
            }

            .mobile-sidebar-backdrop{
                position:fixed;
                inset:0;
                background:rgba(15,23,42,.35);
                z-index:999;
            }

            body.sidebar-mobile-open .mobile-sidebar-backdrop{
                display:block;
            }

            body.sidebar-collapsed .admin-sidebar{
                width:var(--sidebar-width);
                padding:20px 16px;
            }

            body.sidebar-collapsed .sidebar-text,
            body.sidebar-collapsed .sidebar-title,
            body.sidebar-collapsed .sidebar-footer-text,
            body.sidebar-collapsed .brand-subtitle{
                display:block !important;
            }

            body.sidebar-collapsed .brand-title{
                font-size:28px;
            }

            body.sidebar-collapsed .brand-title::after{
                content:"";
                font-size:0;
            }

            body.sidebar-collapsed .sidebar-link{
                justify-content:space-between;
                padding:14px 16px;
            }
        }
    </style>
</head>
<body>

<div class="admin-app">
    <div class="mobile-sidebar-backdrop" onclick="closeMobileSidebar()"></div>

    <div class="admin-layout">
        <aside class="admin-sidebar" id="adminSidebar">
            <?php require dirname(__DIR__) . '/partials/sidebar.php'; ?>
        </aside>

        <main class="admin-main">
            <div class="topbar-wrap">
                <?php require dirname(__DIR__) . '/partials/topbar.php'; ?>
            </div>

            <div class="content-card">
                <?php
                if ($contentView && file_exists($contentView)) {
                    require $contentView;
                } else {
                    echo '<div class="alert alert-danger">لم يتم العثور على ملف المحتوى.</div>';
                }
                ?>
            </div>
        </main>
    </div>
</div>

<script>
    (function () {
        const saved = localStorage.getItem('admin_sidebar_collapsed');
        if (saved === '1' && window.innerWidth > 991) {
            document.body.classList.add('sidebar-collapsed');
        }
    })();

    function toggleSidebar() {
        if (window.innerWidth <= 991) {
            document.body.classList.toggle('sidebar-mobile-open');
            return;
        }

        document.body.classList.toggle('sidebar-collapsed');
        const collapsed = document.body.classList.contains('sidebar-collapsed') ? '1' : '0';
        localStorage.setItem('admin_sidebar_collapsed', collapsed);
    }

    function closeMobileSidebar() {
        document.body.classList.remove('sidebar-mobile-open');
    }
</script>

</body>
</html>