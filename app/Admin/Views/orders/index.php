<style>
    .page-header{
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap:16px;
        flex-wrap:wrap;
        margin-bottom:24px;
    }

    .page-title{
        font-size:24px;
        font-weight:800;
        margin:0 0 6px;
        color:#111827;
    }

    .page-subtitle{
        margin:0;
        color:#7b8595;
        font-size:14px;
    }

    .orders-toolbar{
        display:flex;
        gap:12px;
        flex-wrap:wrap;
        margin-bottom:18px;
    }

    .orders-filter{
        min-width:180px;
        background:#fff;
        border:1px solid #e8edf3;
        border-radius:14px;
        padding:10px 14px;
        font-size:14px;
        outline:none;
    }

    .orders-table-wrap{
        background:#fff;
        border:1px solid #eef1f5;
        border-radius:22px;
        overflow:hidden;
        box-shadow:0 10px 25px rgba(15,23,42,.04);
    }

    .orders-table{
        width:100%;
        border-collapse:collapse;
    }

    .orders-table th,
    .orders-table td{
        padding:16px 14px;
        text-align:right;
        border-bottom:1px solid #eef1f5;
        font-size:14px;
        vertical-align:middle;
    }

    .orders-table th{
        background:#fafbfc;
        color:#98a2b3;
        font-size:12px;
        font-weight:800;
    }

    .orders-table tr:last-child td{
        border-bottom:none;
    }

    .status-badge{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        padding:7px 12px;
        border-radius:999px;
        font-size:12px;
        font-weight:800;
    }

    .status-pending{
        background:#fff3e8;
        color:#ff6a00;
    }

    .status-approved{
        background:#e8f7ee;
        color:#198754;
    }

    .status-out{
        background:#eaf3ff;
        color:#0d6efd;
    }

    .status-delivered{
        background:#e9fbef;
        color:#20a05a;
    }

    .status-cancelled{
        background:#ffe5e5;
        color:#dc3545;
    }

    .action-btn{
        border:none;
        background:#f4f6fa;
        color:#1f2937;
        border-radius:12px;
        padding:8px 12px;
        font-size:13px;
        font-weight:700;
        cursor:pointer;
    }

    @media (max-width: 991.98px){
        .orders-table-wrap{
            overflow:auto;
        }

        .orders-table{
            min-width:900px;
        }
    }

    .order-modal-overlay{
    position:fixed;
    inset:0;
    background:rgba(15,23,42,.45);
    display:none;
    align-items:center;
    justify-content:center;
    padding:20px;
    z-index:2000;
}

.order-modal-overlay.show{
    display:flex;
}

.order-modal-box{
    width:min(900px, 100%);
    max-height:90vh;
    overflow:auto;
    background:#fff;
    border-radius:24px;
    box-shadow:0 20px 60px rgba(15,23,42,.18);
    border:1px solid #eef1f5;
}

.order-modal-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;
    padding:20px 22px;
    border-bottom:1px solid #eef1f5;
}

.order-modal-title{
    margin:0 0 6px;
    font-size:22px;
    font-weight:800;
    color:#111827;
}

.order-modal-subtitle{
    margin:0;
    color:#7b8595;
    font-size:14px;
}

.order-modal-close{
    width:42px;
    height:42px;
    border:none;
    border-radius:14px;
    background:#f4f6fa;
    color:#111827;
    font-size:26px;
    line-height:1;
    cursor:pointer;
}

.order-modal-close:hover{
    background:#ffe9e9;
    color:#dc3545;
}

.order-modal-body{
    padding:22px;
}
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">الطلبات</h1>
        <p class="page-subtitle">إدارة الطلبات، متابعة الحالات، والفرز حسب التاريخ أو الحالة لاحقًا.</p>
    </div>
</div>

<div class="orders-toolbar">
<form method="GET" class="orders-toolbar">
    <select name="status" class="orders-filter" onchange="this.form.submit()">
        <option value="all" <?= (($currentStatus ?? 'all') === 'all') ? 'selected' : '' ?>>كل الحالات</option>
        <option value="pending" <?= (($currentStatus ?? '') === 'pending') ? 'selected' : '' ?>>بانتظار الموافقة</option>
        <option value="approved" <?= (($currentStatus ?? '') === 'approved') ? 'selected' : '' ?>>تمت الموافقة</option>
        <option value="out_for_delivery" <?= (($currentStatus ?? '') === 'out_for_delivery') ? 'selected' : '' ?>>مع المندوب</option>
        <option value="delivered" <?= (($currentStatus ?? '') === 'delivered') ? 'selected' : '' ?>>تم التوصيل</option>
        <option value="cancelled" <?= (($currentStatus ?? '') === 'cancelled') ? 'selected' : '' ?>>ملغاة</option>
    </select>

    <input
        type="date"
        name="date_from"
        class="orders-filter"
        value="<?= htmlspecialchars($currentDateFrom ?? '') ?>"
    >

    <input
        type="date"
        name="date_to"
        class="orders-filter"
        value="<?= htmlspecialchars($currentDateTo ?? '') ?>"
    >

    <button type="submit" class="action-btn">تصفية</button>

    <a href="<?= htmlspecialchars(\App\Admin\Helpers\AdminUrl::path('/admin/orders')) ?>"
       class="action-btn text-decoration-none d-inline-flex align-items-center">
        إعادة ضبط
    </a>
</form>

</div>

<div class="orders-table-wrap">
    <table class="orders-table">
        <thead>
            <tr>
                <th>#</th>
                <th>اسم الزبون</th>
                <th>الهاتف</th>
                <th>الإجمالي</th>
                <th>الحالة</th>
                <th>تاريخ الطلب</th>
                <th>إجراء</th>
            </tr>
        </thead>
<tbody>
<?php if (!empty($orders)): ?>
    <?php foreach ($orders as $order): ?>
        <?php
            $status = $order['status'] ?? 'pending';

            $statusClass = match ($status) {
                'pending' => 'status-pending',
                'approved' => 'status-approved',
                'out_for_delivery' => 'status-out',
                'delivered' => 'status-delivered',
                'cancelled' => 'status-cancelled',
                default => 'status-pending',
            };

            $statusText = match ($status) {
                'pending' => 'بانتظار الموافقة',
                'approved' => 'تمت الموافقة',
                'out_for_delivery' => 'مع المندوب',
                'delivered' => 'تم التوصيل',
                'cancelled' => 'ملغاة',
                default => $status,
            };
        ?>
        <tr id="order-row-<?= (int)($order['id'] ?? 0) ?>">
            <td><?= (int)($order['id'] ?? 0) ?></td>
            <td><?= htmlspecialchars($order['customer_name'] ?? '') ?></td>
            <td><?= htmlspecialchars($order['customer_phone'] ?? '') ?></td>
            <td><?= number_format((float)($order['total'] ?? 0), 2) ?></td>
            <td class="order-status-cell">
                <span class="status-badge <?= $statusClass ?>">
                    <?= htmlspecialchars($statusText) ?>
                </span>
            </td>
            <td><?= htmlspecialchars($order['created_at'] ?? '') ?></td>
            <td>
                <button
                    type="button"
                    class="action-btn js-open-order-modal"
                    data-order-id="<?= (int)($order['id'] ?? 0) ?>">
                    عرض
                </button>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="7" class="text-center">لا توجد طلبات حاليًا</td>
    </tr>
<?php endif; ?>
</tbody>
    </table>

    <div class="order-modal-overlay" id="orderModalOverlay">
    <div class="order-modal-box">
        <div class="order-modal-header">
            <div>
                <h3 class="order-modal-title">تفاصيل الطلب</h3>
                <p class="order-modal-subtitle">عرض التفاصيل وتحديث الحالة</p>
            </div>

            <button type="button" class="order-modal-close" id="orderModalClose">×</button>
        </div>

        <div class="order-modal-body" id="orderModalBody">
            <div class="text-center text-muted py-4">سيتم تحميل بيانات الطلب هنا...</div>
        </div>
    </div>
</div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalOverlay = document.getElementById('orderModalOverlay');
    const modalClose = document.getElementById('orderModalClose');
    const modalBody = document.getElementById('orderModalBody');
    const openButtons = document.querySelectorAll('.js-open-order-modal');

    function openModal() {
        modalOverlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modalOverlay.classList.remove('show');
        document.body.style.overflow = '';
    }

    function escapeHtml(value) {
        return String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function getStatusText(status) {
        switch (status) {
            case 'pending': return 'بانتظار الموافقة';
            case 'approved': return 'تمت الموافقة';
            case 'out_for_delivery': return 'مع المندوب';
            case 'delivered': return 'تم التوصيل';
            case 'cancelled': return 'ملغاة';
            default: return status || '';
        }
    }


    function getStatusClass(status) {
    switch (status) {
        case 'pending': return 'status-pending';
        case 'approved': return 'status-approved';
        case 'out_for_delivery': return 'status-out';
        case 'delivered': return 'status-delivered';
        case 'cancelled': return 'status-cancelled';
        default: return 'status-pending';
    }
}

function updateOrderRowStatus(orderId, status) {
    const row = document.getElementById(`order-row-${orderId}`);
    if (!row) return;

    const statusCell = row.querySelector('.order-status-cell');
    if (!statusCell) return;

    statusCell.innerHTML = `
        <span class="status-badge ${getStatusClass(status)}">
            ${escapeHtml(getStatusText(status))}
        </span>
    `;
}

    function renderOrderDetails(data) {
        const order = data.order || {};
        const items = Array.isArray(data.items) ? data.items : [];

        let itemsRows = '';

        if (items.length > 0) {
            items.forEach(item => {
                const qty = Number(item.qty || 0);
                const unitPrice = Number(item.unit_price || 0);
                const lineTotal = qty * unitPrice;

                itemsRows += `
                    <tr>
                        <td>${escapeHtml(item.product_name || '')}</td>
                        <td>${qty}</td>
                        <td>${unitPrice.toFixed(2)}</td>
                        <td>${lineTotal.toFixed(2)}</td>
                    </tr>
                `;
            });
        } else {
            itemsRows = `
                <tr>
                    <td colspan="4" class="text-center text-muted">لا توجد عناصر داخل هذا الطلب</td>
                </tr>
            `;
        }

        modalBody.innerHTML = `
            <div class="row g-3 mb-4">
                <div class="col-12 col-md-6">
                    <div class="border rounded-4 p-3 bg-light h-100">
                        <h6 class="fw-bold mb-3">بيانات الطلب</h6>
                        <div class="mb-2"><strong>رقم الطلب:</strong> ${escapeHtml(order.id || '')}</div>
                        <div class="mb-2"><strong>الحالة الحالية:</strong> ${escapeHtml(getStatusText(order.status || ''))}</div>
                        <div class="mb-2"><strong>الإجمالي:</strong> ${Number(order.total || 0).toFixed(2)}</div>
                        <div class="mb-0"><strong>تاريخ الطلب:</strong> ${escapeHtml(order.created_at || '')}</div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="border rounded-4 p-3 bg-light h-100">
                        <h6 class="fw-bold mb-3">بيانات الزبون</h6>
                        <div class="mb-2"><strong>الاسم:</strong> ${escapeHtml(order.customer_name || '')}</div>
                        <div class="mb-2"><strong>الهاتف:</strong> ${escapeHtml(order.customer_phone || '')}</div>
                        <div class="mb-2"><strong>العنوان:</strong>${escapeHtml(order.address || '—')}</div>
                        <div class="mb-0"><strong>ملاحظات:</strong> ${escapeHtml(order.notes || '—')}</div>
                    </div>
                </div>
            </div>

            <div class="border rounded-4 overflow-hidden mb-4">
                <div class="p-3 border-bottom bg-light fw-bold">عناصر الطلب</div>

                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>المنتج</th>
                                <th>الكمية</th>
                                <th>سعر الوحدة</th>
                                <th>الإجمالي</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${itemsRows}
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="border rounded-4 p-3 bg-light">
                <h6 class="fw-bold mb-3">تغيير الحالة</h6>

                <div class="row g-3 align-items-end">
                    <div class="col-12 col-md-8">
                        <label class="form-label">الحالة الجديدة</label>
                        <select class="form-select" id="orderStatusSelect">
                            <option value="pending" ${order.status === 'pending' ? 'selected' : ''}>بانتظار الموافقة</option>
                            <option value="approved" ${order.status === 'approved' ? 'selected' : ''}>تمت الموافقة</option>
                            <option value="out_for_delivery" ${order.status === 'out_for_delivery' ? 'selected' : ''}>مع المندوب</option>
                            <option value="delivered" ${order.status === 'delivered' ? 'selected' : ''}>تم التوصيل</option>
                            <option value="cancelled" ${order.status === 'cancelled' ? 'selected' : ''}>ملغاة</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
<button
    type="button"
    class="btn btn-primary w-100"
    id="saveOrderStatusBtn"
    data-order-id="${order.id}">
    حفظ الحالة
</button>
                    </div>
                </div>
                <div id="orderStatusMessage" class="mt-3"></div>
            </div>
        `;


        const saveBtn = document.getElementById('saveOrderStatusBtn');
const statusSelect = document.getElementById('orderStatusSelect');
const statusMessage = document.getElementById('orderStatusMessage');

if (saveBtn && statusSelect) {
    saveBtn.addEventListener('click', async function () {
        const orderId = this.dataset.orderId;
        const newStatus = statusSelect.value;

        this.disabled = true;
        this.textContent = 'جاري الحفظ...';
        statusMessage.innerHTML = '';

        try {
            const formData = new URLSearchParams();
            formData.append('id', orderId);
            formData.append('status', newStatus);

            const response = await fetch(`/shop_mvc/public/admin/api/orders/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData.toString()
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                throw new Error(result.message || 'تعذر تحديث الحالة');
            }

            statusMessage.innerHTML = `
                <div class="alert alert-success mb-0">
                    ${escapeHtml(result.message || 'تم تحديث الحالة بنجاح')}
                </div>
            `;
            updateOrderRowStatus(orderId, newStatus);
        } catch (error) {
            statusMessage.innerHTML = `
                <div class="alert alert-danger mb-0">
                    ${escapeHtml(error.message || 'حدث خطأ أثناء تحديث الحالة')}
                </div>
            `;
        } finally {
            this.disabled = false;
            this.textContent = 'حفظ الحالة';
        }
    });
}




    }

    openButtons.forEach(button => {
        button.addEventListener('click', async function () {
            const orderId = this.dataset.orderId || '';

            modalBody.innerHTML = `
                <div class="text-center text-muted py-4">
                    جاري تحميل بيانات الطلب...
                </div>
            `;

            openModal();

            try {
                const response = await fetch(`/shop_mvc/public/admin/api/orders/show?id=${encodeURIComponent(orderId)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error(data.message || 'تعذر تحميل تفاصيل الطلب');
                }

                renderOrderDetails(data);
            } catch (error) {
                modalBody.innerHTML = `
                    <div class="alert alert-danger mb-0">
                        ${escapeHtml(error.message || 'حدث خطأ أثناء تحميل تفاصيل الطلب')}
                    </div>
                `;
            }
        });
    });

    modalClose.addEventListener('click', closeModal);

    modalOverlay.addEventListener('click', function (e) {
        if (e.target === modalOverlay) {
            closeModal();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
});
</script>