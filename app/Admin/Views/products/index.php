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

    .section-card{
        background:#fff;
        border:1px solid #eef1f5;
        border-radius:22px;
        padding:20px;
        box-shadow:0 10px 25px rgba(15,23,42,.04);
    }

    .toolbar{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:12px;
        flex-wrap:wrap;
        margin-bottom:18px;
    }

    .toolbar-actions{
        display:flex;
        gap:10px;
        flex-wrap:wrap;
    }

    .search-input{
        min-width:260px;
        background:#fff;
        border:1px solid #e8edf3;
        border-radius:14px;
        padding:10px 14px;
        font-size:14px;
        outline:none;
    }

    .primary-btn{
        border:none;
        background:#ff6a00;
        color:#fff;
        border-radius:14px;
        padding:10px 16px;
        font-size:14px;
        font-weight:700;
        cursor:pointer;
    }

    .primary-btn:hover{
        background:#e55f00;
    }

    .products-table-wrap{
        background:#fff;
        border:1px solid #eef1f5;
        border-radius:22px;
        overflow:hidden;
    }

    .products-table{
        width:100%;
        border-collapse:collapse;
    }

    .products-table th,
    .products-table td{
        padding:16px 14px;
        text-align:right;
        border-bottom:1px solid #eef1f5;
        font-size:14px;
        vertical-align:middle;
    }

    .products-table th{
        background:#fafbfc;
        color:#98a2b3;
        font-size:12px;
        font-weight:800;
    }

    .products-table tr:last-child td{
        border-bottom:none;
    }

    .product-cell{
        display:flex;
        align-items:center;
        gap:12px;
        min-width:220px;
    }

    .product-thumb{
        width:58px;
        height:58px;
        border-radius:14px;
        background:#f4f6fa;
        border:1px solid #eef1f5;
        display:flex;
        align-items:center;
        justify-content:center;
        overflow:hidden;
        flex-shrink:0;
        color:#98a2b3;
        font-size:12px;
        font-weight:700;
    }

    .product-thumb img{
        width:100%;
        height:100%;
        object-fit:cover;
        display:block;
    }

    .product-name{
        font-weight:800;
        color:#111827;
        margin-bottom:4px;
    }

    .product-slug{
        color:#7b8595;
        font-size:12px;
        direction:ltr;
        text-align:right;
    }

    .badge-soft{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        padding:6px 10px;
        border-radius:999px;
        font-size:12px;
        font-weight:800;
    }

    .badge-active{
        background:#e9fbef;
        color:#20a05a;
    }

    .badge-inactive{
        background:#ffe8e8;
        color:#dc3545;
    }

    .badge-stock-ok{
        background:#e9fbef;
        color:#20a05a;
    }

    .badge-stock-low{
        background:#fff3e8;
        color:#ff6a00;
    }

    .badge-stock-out{
        background:#ffe8e8;
        color:#dc3545;
    }

    .rating-stars{
        color:#f59e0b;
        font-size:15px;
        letter-spacing:1px;
        white-space:nowrap;
    }

    .table-actions{
        display:flex;
        gap:8px;
        flex-wrap:wrap;
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

    .action-btn.edit{
        background:#fff3e8;
        color:#ff6a00;
    }

    .action-btn.delete{
        background:#ffe8e8;
        color:#dc3545;
    }

    .product-modal-overlay{
        position:fixed;
        inset:0;
        background:rgba(15,23,42,.45);
        display:none;
        align-items:center;
        justify-content:center;
        padding:20px;
        z-index:2000;
    }

    .product-modal-overlay.show{
        display:flex;
    }

.product-modal-box{
    width:min(900px, 100%);
    max-height:92vh;
    background:#fff;
    border-radius:24px;
    box-shadow:0 20px 60px rgba(15,23,42,.18);
    border:1px solid #eef1f5;
    display:flex;
    flex-direction:column;
    overflow:hidden;
}

.product-modal-body{
    padding:22px;
    overflow-y:auto;
    max-height:calc(92vh - 90px);
}

    .product-modal-header{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:16px;
        padding:20px 22px;
        border-bottom:1px solid #eef1f5;
    }

    .product-modal-title{
        margin:0 0 6px;
        font-size:22px;
        font-weight:800;
        color:#111827;
    }

    .product-modal-subtitle{
        margin:0;
        color:#7b8595;
        font-size:14px;
    }

    .product-modal-close{
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

    .product-modal-close:hover{
        background:#ffe9e9;
        color:#dc3545;
    }

.product-modal-box{
    width:min(900px, 100%);
    max-height:92vh;
    background:#fff;
    border-radius:24px;
    box-shadow:0 20px 60px rgba(15,23,42,.18);
    border:1px solid #eef1f5;
    display:flex;
    flex-direction:column;
    overflow:hidden;
}

.product-modal-body{
    padding:22px;
    overflow-y:auto;
    max-height:calc(92vh - 90px);
}

    @media (max-width: 1200px){
        .products-table-wrap{
            overflow:auto;
        }

        .products-table{
            min-width:1200px;
        }
    }

    .products-pagination{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    flex-wrap:wrap;
    margin-top:18px;
}

.products-pagination-info{
    color:#7b8595;
    font-size:14px;
    font-weight:700;
}

.products-pagination-links{
    display:flex;
    gap:8px;
    flex-wrap:wrap;
}

.products-page-link{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:40px;
    height:40px;
    padding:0 14px;
    border-radius:12px;
    border:1px solid #e8edf3;
    background:#fff;
    color:#1f2937;
    text-decoration:none;
    font-size:13px;
    font-weight:700;
    transition:.2s ease;
}

.products-page-link:hover{
    background:#fff3e8;
    color:#ff6a00;
    border-color:#ffd9bf;
}

.products-page-link.active{
    background:#ff6a00;
    color:#fff;
    border-color:#ff6a00;
}

.products-page-link.disabled{
    opacity:.5;
    pointer-events:none;
}

</style>

<div class="page-header">
    <div>
        <h1 class="page-title">المنتجات</h1>
        <p class="page-subtitle">إدارة المنتجات وربطها بالبراندات والأصناف والمخزون والصور.</p>
    </div>
</div>

<div class="section-card">
<div class="toolbar">
    <div class="toolbar-actions">
        <button type="button" class="primary-btn" id="openAddProductModal">إضافة منتج جديد</button>
    </div>

<form method="GET" class="d-flex gap-2 flex-wrap">
    <input
        type="text"
        name="search"
        class="search-input"
        placeholder="ابحث عن منتج..."
        value="<?= htmlspecialchars($currentSearch ?? '') ?>"
    >

    <select name="status" class="search-input" style="min-width:180px;">
        <option value="all" <?= (($currentStatus ?? 'all') === 'all') ? 'selected' : '' ?>>كل الحالات</option>
        <option value="active" <?= (($currentStatus ?? '') === 'active') ? 'selected' : '' ?>>نشط</option>
        <option value="inactive" <?= (($currentStatus ?? '') === 'inactive') ? 'selected' : '' ?>>غير نشط</option>
    </select>

    <button type="submit" class="action-btn">بحث</button>

    <a href="<?= htmlspecialchars(\App\Admin\Helpers\AdminUrl::path('/admin/products')) ?>"
       class="action-btn text-decoration-none d-inline-flex align-items-center">
        إعادة ضبط
    </a>
</form>
</div>

    <div class="products-table-wrap">
        <table class="products-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>المنتج</th>
                    <th>البراند</th>
                    <th>الصنف</th>
                    <th>سعر البيع</th>
                    <th>كلفة الشراء</th>
                    <th>الكمية</th>
                    <th>التقييم</th>
                    <th>الحالة</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <?php
                        $qty = (int)($product['qty'] ?? 0);
                        $isActive = (int)($product['is_active'] ?? 0) === 1;
                        $rating = (float)($product['rating'] ?? 0);

                        $stockClass = $qty <= 0
                            ? 'badge-stock-out'
                            : ($qty <= 3 ? 'badge-stock-low' : 'badge-stock-ok');

                        $stockText = $qty <= 0
                            ? 'نافد'
                            : ($qty <= 3 ? 'منخفض' : 'متوفر');

                        $imageFile = trim((string)($product['main_image'] ?? ''));
                    ?>
                    <tr>
                        <td><?= (int)($product['id'] ?? 0) ?></td>

                        <td>
                            <div class="product-cell">
                                <div class="product-thumb">
                                    <?php if ($imageFile !== ''): ?>
                                        <img src="<?= htmlspecialchars(\App\Admin\Helpers\AdminUrl::file('/uploads/products/' . ltrim($imageFile, '/')), ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($product['name'] ?? '') ?>">
                                    <?php else: ?>
                                        No Image
                                    <?php endif; ?>
                                </div>

                                <div>
                                    <div class="product-name"><?= htmlspecialchars($product['name'] ?? '') ?></div>
                                    <div class="product-slug"><?= htmlspecialchars($product['slug'] ?? '') ?></div>
                                </div>
                            </div>
                        </td>

                        <td><?= htmlspecialchars($product['brand_name'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($product['category_name'] ?? '—') ?></td>
                        <td><?= number_format((float)($product['price'] ?? 0), 2) ?></td>
                        <td><?= number_format((float)($product['cost_price'] ?? 0), 2) ?></td>

                        <td>
                            <span class="badge-soft <?= $stockClass ?>">
                                <?= $qty ?> - <?= $stockText ?>
                            </span>
                        </td>

                        <td>
                            <span class="rating-stars">
                                <?= htmlspecialchars(number_format($rating, 1)) ?> ★
                            </span>
                        </td>

                        <td>
                            <span class="badge-soft <?= $isActive ? 'badge-active' : 'badge-inactive' ?>">
                                <?= $isActive ? 'نشط' : 'غير نشط' ?>
                            </span>
                        </td>

                        <td>
                            <div class="table-actions">
                                <button
                                    type="button"
                                    class="action-btn edit js-edit-product-btn"
                                    data-product-id="<?= (int)($product['id'] ?? 0) ?>">
                                    تعديل
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10" class="text-center">لا توجد منتجات حاليًا</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>


    <?php
$queryBase = [
    'search' => $currentSearch ?? '',
    'status' => $currentStatus ?? 'all',
];
$prevPage = max(1, (int)($currentPage ?? 1) - 1);
$nextPage = min((int)($productsTotalPages ?? 1), (int)($currentPage ?? 1) + 1);
?>

<div class="products-pagination">
    <div class="products-pagination-info">
        إجمالي المنتجات: <?= (int)($productsTotalCount ?? 0) ?> —
        الصفحة <?= (int)($currentPage ?? 1) ?> من <?= (int)($productsTotalPages ?? 1) ?>
    </div>

    <?php if (($productsTotalPages ?? 1) > 1): ?>
        <div class="products-pagination-links">
            <a
                class="products-page-link <?= (($currentPage ?? 1) <= 1) ? 'disabled' : '' ?>"
                href="<?= htmlspecialchars(\App\Admin\Helpers\AdminUrl::path('/admin/products') . '?' . http_build_query(array_merge($queryBase, ['page' => $prevPage]))) ?>">
                السابق
            </a>

            <?php for ($i = 1; $i <= (int)($productsTotalPages ?? 1); $i++): ?>
                <a
                    class="products-page-link <?= (($currentPage ?? 1) === $i) ? 'active' : '' ?>"
                    href="<?= htmlspecialchars(\App\Admin\Helpers\AdminUrl::path('/admin/products') . '?' . http_build_query(array_merge($queryBase, ['page' => $i]))) ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <a
                class="products-page-link <?= (($currentPage ?? 1) >= ($productsTotalPages ?? 1)) ? 'disabled' : '' ?>"
                href="<?= htmlspecialchars(\App\Admin\Helpers\AdminUrl::path('/admin/products') . '?' . http_build_query(array_merge($queryBase, ['page' => $nextPage]))) ?>">
                التالي
            </a>
        </div>
    <?php endif; ?>
</div>

</div>

<div class="product-modal-overlay" id="productModalOverlay">
    <div class="product-modal-box">
        <div class="product-modal-header">
            <div>
                <h3 class="product-modal-title" id="productModalTitle">إضافة منتج جديد</h3>
                <p class="product-modal-subtitle" id="productModalSubtitle">أدخل بيانات المنتج ثم احفظ</p>
            </div>

            <button type="button" class="product-modal-close" id="productModalClose">×</button>
        </div>

        <div class="product-modal-body">
            <input type="hidden" id="productIdInput" value="">

            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label class="form-label">اسم المنتج</label>
                    <input type="text" class="form-control" id="productNameInput" placeholder="مثال: ساعة يد فاخرة">
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label">الاسم اللاتيني (Slug)</label>
                    <input type="text" class="form-control" id="productSlugInput" placeholder="luxury-watch">
                </div>

                <div class="col-12">
                    <label class="form-label">الوصف</label>
                    <textarea class="form-control" id="productDescriptionInput" rows="3" placeholder="وصف مختصر للمنتج"></textarea>
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label">البراند</label>
                    <select class="form-select" id="productBrandSelect">
                        <option value="">اختر البراند</option>
                        <?php if (!empty($brands)): ?>
                            <?php foreach ($brands as $brand): ?>
                                <option value="<?= (int)($brand['id'] ?? 0) ?>">
                                    <?= htmlspecialchars($brand['name'] ?? '') ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label">الصنف</label>
                    <select class="form-select" id="productCategorySelect">
                        <option value="">اختر الصنف</option>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= (int)($category['id'] ?? 0) ?>">
                                    <?= htmlspecialchars($category['name'] ?? '') ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label">سعر البيع</label>
                    <input type="number" step="0.01" class="form-control" id="productPriceInput" placeholder="0.00">
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label">كلفة الشراء</label>
                    <input type="number" step="0.01" class="form-control" id="productCostPriceInput" placeholder="0.00">
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label">الكمية</label>
                    <input type="number" class="form-control" id="productQtyInput" placeholder="0">
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label">التقييم</label>
                    <input type="number" step="0.1" min="0" max="5" class="form-control" id="productRatingInput" placeholder="4.5">
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label">الحالة</label>
                    <select class="form-select" id="productIsActiveSelect">
                        <option value="1">نشط</option>
                        <option value="0">غير نشط</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">الصورة الرئيسية</label>
                    <input type="file" class="form-control" id="productMainImageInput" accept="image/*">
                    <div class="form-text">اختر صورة المنتج الرئيسية.</div>
                    <div id="productCurrentImageNote" class="form-text mt-1"></div>
                </div>
                <div class="mt-3">
                    <label class="form-label">صور إضافية</label>
                    <input type="file" class="form-control" id="productGalleryImagesInput" accept="image/*" multiple>
                    <div class="form-text">يمكنك اختيار أكثر من صورة إضافية للمنتج.</div>
                    <div id="productGalleryImagesNote" class="form-text mt-1"></div>
                    <div id="productCurrentGallery" class="mt-3 d-flex flex-wrap gap-2"></div>
                </div>
            </div>

            <div id="productModalMessage" class="mt-3"></div>

            <div class="d-flex justify-content-end gap-2 flex-wrap mt-4">
                <button type="button" class="action-btn" id="productModalCancel">إلغاء</button>
                <button type="button" class="primary-btn" id="saveProductBtn">حفظ المنتج</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalOverlay = document.getElementById('productModalOverlay');
    const openBtn = document.getElementById('openAddProductModal');
    const closeBtn = document.getElementById('productModalClose');
    const cancelBtn = document.getElementById('productModalCancel');
    const saveBtn = document.getElementById('saveProductBtn');
    const messageBox = document.getElementById('productModalMessage');

    const modalTitle = document.getElementById('productModalTitle');
    const modalSubtitle = document.getElementById('productModalSubtitle');

    const productIdInput = document.getElementById('productIdInput');
    const productNameInput = document.getElementById('productNameInput');
    const productSlugInput = document.getElementById('productSlugInput');
    const productDescriptionInput = document.getElementById('productDescriptionInput');
    const productBrandSelect = document.getElementById('productBrandSelect');
    const productCategorySelect = document.getElementById('productCategorySelect');
    const productPriceInput = document.getElementById('productPriceInput');
    const productCostPriceInput = document.getElementById('productCostPriceInput');
    const productQtyInput = document.getElementById('productQtyInput');
    const productRatingInput = document.getElementById('productRatingInput');
    const productIsActiveSelect = document.getElementById('productIsActiveSelect');
    const productMainImageInput = document.getElementById('productMainImageInput');
    const productCurrentImageNote = document.getElementById('productCurrentImageNote');
    const productGalleryImagesInput = document.getElementById('productGalleryImagesInput');
    const productGalleryImagesNote = document.getElementById('productGalleryImagesNote');
    const productCurrentGallery = document.getElementById('productCurrentGallery');

    const editButtons = document.querySelectorAll('.js-edit-product-btn');


    if (productGalleryImagesInput) {
    productGalleryImagesInput.addEventListener('change', function () {
        const count = this.files ? this.files.length : 0;
        productGalleryImagesNote.textContent = count > 0
            ? `تم اختيار ${count} صورة إضافية`
            : '';
    });
    }


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

    function resetForm() {
        productIdInput.value = '';
        productNameInput.value = '';
        productSlugInput.value = '';
        productDescriptionInput.value = '';
        productBrandSelect.value = '';
        productCategorySelect.value = '';
        productPriceInput.value = '';
        productCostPriceInput.value = '';
        productQtyInput.value = '';
        productRatingInput.value = '';
        productIsActiveSelect.value = '1';
        productMainImageInput.value = '';
        messageBox.innerHTML = '';
        productMainImageInput.value = '';
        productCurrentImageNote.textContent = '';
        productGalleryImagesInput.value = '';
        productGalleryImagesNote.textContent = '';
        productCurrentGallery.innerHTML = '';
    }

    function setAddMode() {
        resetForm();
        modalTitle.textContent = 'إضافة منتج جديد';
        modalSubtitle.textContent = 'أدخل بيانات المنتج ثم احفظ';
        saveBtn.textContent = 'حفظ المنتج';
    }

    function setEditMode(product) {
        resetForm();
        productIdInput.value = product.id || '';
        productNameInput.value = product.name || '';
        productSlugInput.value = product.slug || '';
        productDescriptionInput.value = product.description || '';
        productBrandSelect.value = product.brand_id || '';
        productCategorySelect.value = product.category_id || '';
        productPriceInput.value = product.price || '';
        productCostPriceInput.value = product.cost_price || '';
        productQtyInput.value = product.qty || '';
        productRatingInput.value = product.rating || '';
        productIsActiveSelect.value = String(product.is_active ?? '1');
        productMainImageInput.value = '';
        productCurrentImageNote.textContent = product.main_image
        ? `الصورة الحالية: ${product.main_image}`
        : 'لا توجد صورة رئيسية حالية';

        modalTitle.textContent = 'تعديل المنتج';
        modalSubtitle.textContent = 'عدّل بيانات المنتج ثم احفظ التغييرات';
        saveBtn.textContent = 'حفظ التعديل';

                if (Array.isArray(product.gallery_images) && product.gallery_images.length > 0) {
            productCurrentGallery.innerHTML = product.gallery_images.map(fileName => `
                <div style="width:70px;height:70px;border:1px solid #eef1f5;border-radius:12px;overflow:hidden;background:#f8fafc;">
                    <img
                        src="${window.APP_BASE_PATH}/uploads/products/${encodeURIComponent(fileName)}"
                        alt=""
                        style="width:100%;height:100%;object-fit:cover;display:block;"
                    >
                </div>
            `).join('');
        } else {
            productCurrentGallery.innerHTML = '<div class="form-text">لا توجد صور إضافية حالية</div>';
        }
    }

    

    if (openBtn) {
        openBtn.addEventListener('click', function () {
            setAddMode();
            openModal();
            setTimeout(() => productNameInput.focus(), 100);
        });
    }

    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

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

    editButtons.forEach(button => {
        button.addEventListener('click', async function () {
            const productId = this.dataset.productId || '';

            setAddMode();
            openModal();

            modalTitle.textContent = 'جاري تحميل بيانات المنتج...';
            modalSubtitle.textContent = 'يرجى الانتظار';

            try {
                const response = await fetch(`${window.APP_BASE_PATH}/admin/api/products/show?id=${encodeURIComponent(productId)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(result.message || 'تعذر تحميل بيانات المنتج');
                }

                setEditMode(result.product || {});
                setTimeout(() => productNameInput.focus(), 100);
            } catch (error) {
                messageBox.innerHTML = `
                    <div class="alert alert-danger mb-0">
                        ${escapeHtml(error.message || 'حدث خطأ أثناء تحميل بيانات المنتج')}
                    </div>
                `;
                modalTitle.textContent = 'تعديل المنتج';
                modalSubtitle.textContent = 'تعذر تحميل البيانات';
            }
        });
    });


  if (saveBtn) {
    saveBtn.addEventListener('click', async function () {
        const id = (productIdInput.value || '').trim();

        const payload = {
            id: id,
            name: (productNameInput.value || '').trim(),
            slug: (productSlugInput.value || '').trim(),
            description: (productDescriptionInput.value || '').trim(),
            brand_id: (productBrandSelect.value || '').trim(),
            category_id: (productCategorySelect.value || '').trim(),
            price: (productPriceInput.value || '').trim(),
            cost_price: (productCostPriceInput.value || '').trim(),
            qty: (productQtyInput.value || '').trim(),
            rating: (productRatingInput.value || '').trim(),
            is_active: (productIsActiveSelect.value || '1').trim()
        };

        const mainImageFile = productMainImageInput.files[0] || null;
        const galleryFiles = Array.from(productGalleryImagesInput.files || []);

        messageBox.innerHTML = '';

        if (!payload.name || !payload.slug || !payload.brand_id || !payload.category_id) {
            messageBox.innerHTML = `
                <div class="alert alert-danger mb-0">
                    يرجى تعبئة الحقول المطلوبة: الاسم، الرابط، البراند، الصنف
                </div>
            `;
            return;
        }

        const isEditMode = id !== '';
        const endpoint = isEditMode
            ? `${window.APP_BASE_PATH}/admin/api/products/update`
            : `${window.APP_BASE_PATH}/admin/api/products/store`;

        this.disabled = true;
        this.textContent = isEditMode ? 'جاري حفظ التعديل...' : 'جاري الحفظ...';

        try {
            const formData = new FormData();

            if (isEditMode) {
                formData.append('id', payload.id);
            }

            formData.append('name', payload.name);
            formData.append('slug', payload.slug);
            formData.append('description', payload.description);
            formData.append('brand_id', payload.brand_id);
            formData.append('category_id', payload.category_id);
            formData.append('price', payload.price);
            formData.append('cost_price', payload.cost_price);
            formData.append('qty', payload.qty);
            formData.append('rating', payload.rating);
            formData.append('is_active', payload.is_active);

            if (mainImageFile) {
                formData.append('main_image', mainImageFile);
            }

            galleryFiles.forEach(file => {
                formData.append('gallery_images[]', file);
            });

            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                throw new Error(result.message || (isEditMode ? 'تعذر تعديل المنتج' : 'تعذر حفظ المنتج'));
            }

            messageBox.innerHTML = `
                <div class="alert alert-success mb-0">
                    ${escapeHtml(result.message || (isEditMode ? 'تم تعديل المنتج بنجاح' : 'تم إضافة المنتج بنجاح'))}
                </div>
            `;

            setTimeout(() => window.location.reload(), 700);
        } catch (error) {
            messageBox.innerHTML = `
                <div class="alert alert-danger mb-0">
                    ${escapeHtml(error.message || 'حدث خطأ أثناء الحفظ')}
                </div>
            `;
        } finally {
            this.disabled = false;
            this.textContent = productIdInput.value ? 'حفظ التعديل' : 'حفظ المنتج';
        }
    });
}
});
</script>