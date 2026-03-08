<?php
$order = $order ?? [];
$items = $items ?? [];
$settings = $settings ?? [];

$storeName = trim((string)($settings['receipt_store_name'] ?? ''));
if ($storeName === '') {
    $storeName = trim((string)($settings['site_name_ar'] ?? ''));
}
if ($storeName === '') {
    $storeName = trim((string)($settings['site_name_en'] ?? ''));
}
if ($storeName === '') {
    $storeName = 'Store';
}

$receiptShowLogo     = !empty($settings['receipt_show_logo']);
$receiptShowAddress  = !empty($settings['receipt_show_address']);
$receiptShowContacts = !empty($settings['receipt_show_contacts']);

$logo      = trim((string)($settings['logo'] ?? ''));
$address   = trim((string)($settings['contact_address'] ?? ''));
$phone1    = trim((string)($settings['contact_phone_1'] ?? ''));
$phone2    = trim((string)($settings['contact_phone_2'] ?? ''));
$whatsapp  = trim((string)($settings['contact_whatsapp'] ?? ''));
$barcodeType  = strtolower(trim((string)($settings['receipt_barcode_type'] ?? 'qr')));
$barcodeValue = trim((string)($settings['receipt_barcode_value'] ?? ''));

$orderId            = (int)($order['id'] ?? 0);
$orderCustomerName  = trim((string)($order['customer_name'] ?? ''));
$orderCustomerPhone = trim((string)($order['customer_phone'] ?? ''));
$orderAddress       = trim((string)($order['address'] ?? ''));
$orderCreatedAt     = trim((string)($order['created_at'] ?? ''));
$orderTotal         = (float)($order['total'] ?? 0);

function e(?string $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>وصل الطلب #<?= $orderId ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root{
            --ink:#111827;
            --muted:#6b7280;
            --line:#d1d5db;
            --soft:#f9fafb;
        }

        *{
            box-sizing:border-box;
        }

        html,body{
            margin:0;
            padding:0;
            background:#eef2f7;
            color:var(--ink);
            font-family:Tahoma, Arial, sans-serif;
        }

        .print-toolbar{
            max-width:560px;
            margin:14px auto 0;
            padding:0 10px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:10px;
            flex-wrap:wrap;
        }

        .print-btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            min-height:38px;
            padding:0 14px;
            border:none;
            border-radius:10px;
            background:#111827;
            color:#fff;
            text-decoration:none;
            font-size:13px;
            font-weight:800;
            cursor:pointer;
        }

        .print-btn.secondary{
            background:#fff;
            color:#111827;
            border:1px solid #dbe3ee;
        }

        .receipt-wrap{
            width:148mm;
            min-height:210mm;
            margin:12px auto 18px;
            background:#fff;
            border:1px solid #e5e7eb;
            box-shadow:0 14px 35px rgba(15,23,42,.10);
        }

        .receipt{
            padding:9mm 8mm;
        }

        .center{
            text-align:center;
        }

        .logo-box{
            margin-bottom:6px;
        }

        .logo-box img{
            width:46px;
            height:46px;
            object-fit:cover;
            border-radius:8px;
            border:1px solid #e5e7eb;
            display:inline-block;
        }

        .store-name{
            margin:0;
            font-size:22px;
            font-weight:900;
            line-height:1.1;
        }

        .top-lines{
            margin-top:6px;
            font-size:12px;
            color:#374151;
            line-height:1.8;
        }

        .top-line{
            display:flex;
            justify-content:center;
            gap:18px;
            flex-wrap:wrap;
        }

        .divider{
            border-top:1px dashed var(--line);
            margin:8px 0;
        }

        .info-row{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:8px 12px;
            font-size:12px;
            line-height:1.7;
            margin-bottom:4px;
        }

        .info-cell{
            display:flex;
            align-items:center;
            gap:4px;
            min-width:0;
        }

        .info-label{
            color:var(--muted);
            font-weight:700;
            white-space:nowrap;
        }

        .info-value{
            color:var(--ink);
            font-weight:800;
            word-break:break-word;
        }

        .address-line{
            text-align:center;
            font-size:12px;
            line-height:1.8;
            font-weight:800;
            color:#111827;
            margin:4px 0;
            word-break:break-word;
        }

        .items-title{
            margin:0 0 6px;
            font-size:13px;
            font-weight:900;
            color:#111827;
        }

        .items-table{
            width:100%;
            border-collapse:collapse;
            font-size:12px;
        }

        .items-table th,
        .items-table td{
            padding:6px 4px;
            border-bottom:1px dashed #e5e7eb;
            text-align:right;
            vertical-align:top;
        }

        .items-table th{
            color:var(--muted);
            font-size:11px;
            font-weight:900;
        }

        .items-table tfoot td{
            padding-top:8px;
            border-bottom:none;
            font-size:13px;
            font-weight:900;
        }

        .items-table .total-row td{
            background:#f8fafc;
        }

        .barcode-section{
            margin-top:8px;
            text-align:center;
        }

        .barcode-image{
            width:100px;
            height:100px;
            object-fit:contain;
            padding:4px;
            background:#fff;
            border:1px solid #e5e7eb;
            border-radius:8px;
            display:inline-block;
        }

        .barcode-text-fallback{
            font-size:18px;
            letter-spacing:2px;
            font-weight:900;
            text-align:center;
            padding:8px;
            border:1px dashed var(--line);
            border-radius:8px;
            background:#fff;
            display:inline-block;
            min-width:180px;
        }

        .footer-note{
            margin-top:8px;
            text-align:center;
            font-size:11px;
            color:var(--muted);
            line-height:1.8;
        }

        @media (max-width: 768px){
            .receipt-wrap{
                width:100%;
                min-height:auto;
                margin:10px 8px 16px;
            }

            .receipt{
                padding:14px 12px;
            }

            .info-row{
                grid-template-columns:1fr;
            }

            .store-name{
                font-size:20px;
            }
        }

        @page{
            size:A5 portrait;
            margin:6mm;
        }

        @media print{
            html,body{
                background:#fff !important;
            }

            .print-toolbar{
                display:none !important;
            }

            .receipt-wrap{
                width:100%;
                min-height:auto;
                margin:0;
                border:none;
                box-shadow:none;
            }

            .receipt{
                padding:0;
            }
        }
    </style>
</head>
<body>

<div class="print-toolbar">
    <a href="<?= htmlspecialchars(\App\Admin\Helpers\AdminUrl::path('/admin/orders'), ENT_QUOTES, 'UTF-8') ?>" class="print-btn secondary">
        الرجوع للطلبات
    </a>

    <button type="button" class="print-btn" onclick="window.print()">
        طباعة الآن
    </button>
</div>

<div class="receipt-wrap">
    <div class="receipt">

        <div class="center">
            <?php if ($receiptShowLogo && $logo !== ''): ?>
                <div class="logo-box">
                    <img src="<?= e($logo) ?>" alt="<?= e($storeName) ?>">
                </div>
            <?php endif; ?>

            <h1 class="store-name"><?= e($storeName) ?></h1>

            <div class="top-lines">
                <?php if ($receiptShowContacts && ($phone1 !== '' || $phone2 !== '')): ?>
                    <div class="top-line">
                        <?php if ($phone1 !== ''): ?>
                            <span><?= e($phone1) ?></span>
                        <?php endif; ?>

                        <?php if ($phone2 !== ''): ?>
                            <span><?= e($phone2) ?></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if (($receiptShowContacts && $whatsapp !== '') || ($receiptShowAddress && $address !== '')): ?>
                    <div class="top-line">
                        <?php if ($receiptShowContacts && $whatsapp !== ''): ?>
                            <span>واتساب: <?= e($whatsapp) ?></span>
                        <?php endif; ?>

                        <?php if ($receiptShowAddress && $address !== ''): ?>
                            <span><?= e($address) ?></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="divider"></div>

        <div class="info-row">
            <div class="info-cell">
                <span class="info-label">رقم الطلب:</span>
                <span class="info-value">#<?= $orderId ?></span>
            </div>

            <div class="info-cell">
                <span class="info-label">التاريخ:</span>
                <span class="info-value"><?= e($orderCreatedAt !== '' ? $orderCreatedAt : '-') ?></span>
            </div>
        </div>

        <div class="info-row">
            <div class="info-cell">
                <span class="info-label">الزبون:</span>
                <span class="info-value"><?= e($orderCustomerName !== '' ? $orderCustomerName : '-') ?></span>
            </div>

            <div class="info-cell">
                <span class="info-label">الهاتف:</span>
                <span class="info-value"><?= e($orderCustomerPhone !== '' ? $orderCustomerPhone : '-') ?></span>
            </div>
        </div>

        <?php if ($orderAddress !== ''): ?>
            <div class="address-line"><?= e($orderAddress) ?></div>
        <?php endif; ?>

        <div class="divider"></div>

        <h3 class="items-title">تفاصيل الطلب</h3>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width:32px;">#</th>
                    <th>الصنف</th>
                    <th style="width:54px;">الكمية</th>
                    <th style="width:72px;">السعر</th>
                    <th style="width:78px;">الإجمالي</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $index => $item): ?>
                        <?php
                            $qty = (int)($item['quantity'] ?? 0);
                            $price = (float)($item['price'] ?? 0);
                            $lineTotal = $qty * $price;
                        ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= e((string)($item['product_name'] ?? '-')) ?></td>
                            <td><?= $qty ?></td>
                            <td><?= number_format($price, 0) ?></td>
                            <td><?= number_format($lineTotal, 0) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">لا توجد عناصر في هذا الطلب</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="4">المجموع الكلي</td>
                    <td><?= number_format($orderTotal, 0) ?></td>
                </tr>
            </tfoot>
        </table>

        <?php if ($barcodeValue !== ''): ?>
            <div class="divider"></div>

            <div class="barcode-section">
                <?php if ($barcodeType === 'qr'): ?>
                    <img
                        class="barcode-image"
                        src="https://api.qrserver.com/v1/create-qr-code/?size=140x140&data=<?= urlencode($barcodeValue) ?>"
                        alt="QR Code"
                    >
                <?php else: ?>
                    <div class="barcode-text-fallback">*<?= e($barcodeValue) ?>*</div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($settings['receipt_footer_text'] ?? ''): ?>
            <div class="footer-note"><?= e((string)$settings['receipt_footer_text']) ?></div>
        <?php endif; ?>

    </div>
</div>

</body>
</html>