<?php
$slides = $slides ?? [];
?>

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

    .hero-table-wrap{
        background:#fff;
        border:1px solid #eef1f5;
        border-radius:22px;
        overflow:hidden;
    }

    .hero-table{
        width:100%;
        border-collapse:collapse;
    }

    .hero-table th,
    .hero-table td{
        padding:16px 14px;
        text-align:right;
        border-bottom:1px solid #eef1f5;
        font-size:14px;
        vertical-align:middle;
    }

    .hero-table th{
        background:#fafbfc;
        color:#98a2b3;
        font-size:12px;
        font-weight:800;
    }

    .hero-table tr:last-child td{
        border-bottom:none;
    }

    .hero-thumb{
        width:88px;
        height:60px;
        border-radius:14px;
        border:1px solid #e5e7eb;
        object-fit:cover;
        background:#f8fafc;
        display:block;
    }

    .hero-title-cell{
        display:flex;
        flex-direction:column;
        gap:6px;
    }

    .hero-title-main{
        font-weight:800;
        color:#111827;
    }

    .hero-sub-main{
        color:#8a94a6;
        font-size:12px;
        line-height:1.6;
        max-width:260px;
        display:-webkit-box;
        -webkit-line-clamp:2;
        line-clamp:2;
        -webkit-box-orient:vertical;
        overflow:hidden;
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

    .action-btn.toggle{
        background:#eef7ff;
        color:#0d6efd;
    }

    .status-badge{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        padding:6px 12px;
        border-radius:999px;
        font-size:12px;
        font-weight:800;
        white-space:nowrap;
    }

    .status-badge.active{
        background:#ecfdf3;
        color:#027a48;
    }

    .status-badge.inactive{
        background:#fef3f2;
        color:#b42318;
    }

    .hero-modal-overlay{
        position:fixed;
        inset:0;
        background:rgba(15,23,42,.45);
        display:none;
        align-items:center;
        justify-content:center;
        padding:20px;
        z-index:2000;
    }

    .hero-modal-overlay.show{
        display:flex;
    }

    .hero-modal-box{
        width:min(760px, 100%);
        background:#fff;
        border-radius:24px;
        box-shadow:0 20px 60px rgba(15,23,42,.18);
        border:1px solid #eef1f5;
        overflow:hidden;
    }

    .hero-modal-header{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:16px;
        padding:20px 22px;
        border-bottom:1px solid #eef1f5;
    }

    .hero-modal-title{
        margin:0 0 6px;
        font-size:22px;
        font-weight:800;
        color:#111827;
    }

    .hero-modal-subtitle{
        margin:0;
        color:#7b8595;
        font-size:14px;
    }

    .hero-modal-close{
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

    .hero-modal-close:hover{
        background:#ffe9e9;
        color:#dc3545;
    }

    .hero-modal-body{
        padding:22px;
    }

    .hero-form-grid{
        display:grid;
        grid-template-columns:repeat(2, minmax(0,1fr));
        gap:16px;
    }

    .hero-form-group{
        display:flex;
        flex-direction:column;
        gap:8px;
    }

    .hero-form-group.full{
        grid-column:1 / -1;
    }

    .hero-form-label{
        font-size:14px;
        font-weight:800;
        color:#374151;
    }

    .hero-form-control,
    .hero-form-textarea{
        width:100%;
        border:1px solid #dbe3ee;
        border-radius:16px;
        padding:12px 14px;
        font-size:14px;
        outline:none;
        background:#fff;
        transition:.2s ease;
    }

    .hero-form-control:focus,
    .hero-form-textarea:focus{
        border-color:#3b82f6;
        box-shadow:0 0 0 4px rgba(59,130,246,.10);
    }

    .hero-form-textarea{
        min-height:110px;
        resize:vertical;
    }

    .hero-image-preview{
        width:180px;
        height:120px;
        border-radius:18px;
        border:1px solid #e5e7eb;
        object-fit:cover;
        background:#f8fafc;
        display:block;
    }

    .hero-image-preview.hidden{
        display:none;
    }

    .hero-switch{
        display:flex;
        align-items:center;
        gap:10px;
        font-weight:700;
        color:#111827;
        margin-top:8px;
    }

    .hero-modal-footer{
        display:flex;
        justify-content:flex-end;
        gap:10px;
        margin-top:20px;
    }

    .secondary-btn{
        border:none;
        background:#f4f6fa;
        color:#111827;
        border-radius:14px;
        padding:10px 16px;
        font-size:14px;
        font-weight:700;
        cursor:pointer;
    }

    .secondary-btn:hover{
        background:#e8edf3;
    }

    .alert{
        border-radius:16px;
        padding:12px 14px;
        font-weight:700;
        margin-bottom:14px;
    }

    .alert-success{
        background:#ecfdf3;
        color:#027a48;
        border:1px solid #abefc6;
    }

    .alert-danger{
        background:#fef3f2;
        color:#b42318;
        border:1px solid #fecdca;
    }

    @media (max-width: 991.98px){
        .hero-table-wrap{
            overflow:auto;
        }

        .hero-table{
            min-width:980px;
        }

        .hero-form-grid{
            grid-template-columns:1fr;
        }
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">الهيرو</h1>
        <p class="page-subtitle">إدارة سلايدات الهيرو: عرض، إضافة، تعديل، حذف، وتفعيل أو تعطيل.</p>
    </div>
</div>

<div class="section-card">
    <div class="toolbar">
        <div class="toolbar-actions">
            <button type="button" class="primary-btn" id="openAddHeroModal">إضافة سلايد جديد</button>
        </div>

        <input type="text" class="search-input" id="heroSearchInput" placeholder="ابحث عن عنوان سلايد أو نص فرعي">
    </div>

    <div class="hero-table-wrap">
        <table class="hero-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الصورة</th>
                    <th>العنوان</th>
                    <th>الزر الأول</th>
                    <th>الزر الثاني</th>
                    <th>الترتيب</th>
                    <th>الحالة</th>
                    <th>الإنشاء</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody id="heroTableBody">
                <?php if (!empty($slides)): ?>
                    <?php foreach ($slides as $slide): ?>
                        <tr>
                            <td><?= (int)($slide['id'] ?? 0) ?></td>
                            <td>
                                <?php if (!empty($slide['image'])): ?>
                                    <img src="<?= htmlspecialchars(\App\Admin\Helpers\AdminUrl::file($slide['image'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" alt="Hero" class="hero-thumb">
                                <?php else: ?>
                                    <span style="color:#98a2b3;">بدون صورة</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="hero-title-cell">
                                    <span class="hero-title-main"><?= htmlspecialchars($slide['title'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
                                    <span class="hero-sub-main"><?= htmlspecialchars($slide['subtitle'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
                                </div>
                            </td>
                            <td>
                                <div><?= htmlspecialchars($slide['button_text_1'] ?? '', ENT_QUOTES, 'UTF-8') ?></div>
                                <small style="color:#98a2b3;"><?= htmlspecialchars($slide['button_link_1'] ?? '', ENT_QUOTES, 'UTF-8') ?></small>
                            </td>
                            <td>
                                <div><?= htmlspecialchars($slide['button_text_2'] ?? '', ENT_QUOTES, 'UTF-8') ?></div>
                                <small style="color:#98a2b3;"><?= htmlspecialchars($slide['button_link_2'] ?? '', ENT_QUOTES, 'UTF-8') ?></small>
                            </td>
                            <td><?= (int)($slide['sort_order'] ?? 0) ?></td>
                            <td>
                                <span class="status-badge <?= !empty($slide['is_active']) ? 'active' : 'inactive' ?>">
                                    <?= !empty($slide['is_active']) ? 'مفعل' : 'معطل' ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($slide['created_at'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <div class="table-actions">
                                    <button
                                        type="button"
                                        class="action-btn edit js-edit-hero-btn"
                                        data-hero-id="<?= (int)($slide['id'] ?? 0) ?>"
                                        data-title="<?= htmlspecialchars($slide['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                        data-subtitle="<?= htmlspecialchars($slide['subtitle'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                        data-button1-text="<?= htmlspecialchars($slide['button_text_1'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                        data-button1-link="<?= htmlspecialchars($slide['button_link_1'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                        data-button2-text="<?= htmlspecialchars($slide['button_text_2'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                        data-button2-link="<?= htmlspecialchars($slide['button_link_2'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                        data-sort-order="<?= (int)($slide['sort_order'] ?? 0) ?>"
                                        data-is-active="<?= !empty($slide['is_active']) ? '1' : '0' ?>"
                                        data-image="<?= htmlspecialchars(\App\Admin\Helpers\AdminUrl::file($slide['image'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                                        تعديل
                                    </button>

                                    <button
                                        type="button"
                                        class="action-btn toggle js-toggle-hero-btn"
                                        data-hero-id="<?= (int)($slide['id'] ?? 0) ?>">
                                        <?= !empty($slide['is_active']) ? 'تعطيل' : 'تفعيل' ?>
                                    </button>

                                    <button
                                        type="button"
                                        class="action-btn delete js-delete-hero-btn"
                                        data-hero-id="<?= (int)($slide['id'] ?? 0) ?>"
                                        data-hero-title="<?= htmlspecialchars($slide['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                        حذف
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">لا توجد سلايدات هيرو حاليًا</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="hero-modal-overlay" id="heroModalOverlay">
    <div class="hero-modal-box">
        <div class="hero-modal-header">
            <div>
                <h3 class="hero-modal-title" id="heroModalTitle">إضافة سلايد جديد</h3>
                <p class="hero-modal-subtitle" id="heroModalSubtitle">أدخل بيانات السلايد ثم احفظ</p>
            </div>

            <button type="button" class="hero-modal-close" id="heroModalClose">×</button>
        </div>

        <div class="hero-modal-body">
            <div id="heroFormMessage"></div>

            <input type="hidden" id="heroId">

            <div class="hero-form-grid">
                <div class="hero-form-group full">
                    <label class="hero-form-label">عنوان السلايد</label>
                    <input type="text" class="hero-form-control" id="heroTitle">
                </div>

                <div class="hero-form-group full">
                    <label class="hero-form-label">النص الفرعي</label>
                    <textarea class="hero-form-textarea" id="heroSubtitle"></textarea>
                </div>

                <div class="hero-form-group">
                    <label class="hero-form-label">نص الزر الأول</label>
                    <input type="text" class="hero-form-control" id="heroButtonText1">
                </div>

                <div class="hero-form-group">
                    <label class="hero-form-label">رابط الزر الأول</label>
                    <input type="text" class="hero-form-control" id="heroButtonLink1">
                </div>

                <div class="hero-form-group">
                    <label class="hero-form-label">نص الزر الثاني</label>
                    <input type="text" class="hero-form-control" id="heroButtonText2">
                </div>

                <div class="hero-form-group">
                    <label class="hero-form-label">رابط الزر الثاني</label>
                    <input type="text" class="hero-form-control" id="heroButtonLink2">
                </div>

                <div class="hero-form-group">
                    <label class="hero-form-label">الترتيب</label>
                    <input type="number" class="hero-form-control" id="heroSortOrder" value="0">
                </div>

                <div class="hero-form-group">
                    <label class="hero-form-label">صورة السلايد</label>
                    <input type="file" class="hero-form-control" id="heroImage" accept=".jpg,.jpeg,.png,.webp,.svg">
                </div>

                <div class="hero-form-group full">
                    <img src="" alt="Hero Preview" class="hero-image-preview hidden" id="heroImagePreview">
                </div>

                <div class="hero-form-group full">
                    <label class="hero-switch">
                        <input type="checkbox" id="heroIsActive" checked>
                        <span>السلايد مفعل</span>
                    </label>
                </div>
            </div>

            <div class="hero-modal-footer">
                <button type="button" class="secondary-btn" id="heroModalCancel">إلغاء</button>
                <button type="button" class="primary-btn" id="saveHeroBtn">حفظ السلايد</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalOverlay = document.getElementById('heroModalOverlay');
    const openAddBtn = document.getElementById('openAddHeroModal');
    const closeBtn = document.getElementById('heroModalClose');
    const cancelBtn = document.getElementById('heroModalCancel');
    const saveBtn = document.getElementById('saveHeroBtn');
    const searchInput = document.getElementById('heroSearchInput');
    const tableBody = document.getElementById('heroTableBody');
    const messageBox = document.getElementById('heroFormMessage');

    const heroIdInput = document.getElementById('heroId');
    const titleInput = document.getElementById('heroTitle');
    const subtitleInput = document.getElementById('heroSubtitle');
    const buttonText1Input = document.getElementById('heroButtonText1');
    const buttonLink1Input = document.getElementById('heroButtonLink1');
    const buttonText2Input = document.getElementById('heroButtonText2');
    const buttonLink2Input = document.getElementById('heroButtonLink2');
    const sortOrderInput = document.getElementById('heroSortOrder');
    const imageInput = document.getElementById('heroImage');
    const imagePreview = document.getElementById('heroImagePreview');
    const isActiveInput = document.getElementById('heroIsActive');

    const modalTitle = document.getElementById('heroModalTitle');
    const modalSubtitle = document.getElementById('heroModalSubtitle');

    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value ?? '';
        return div.innerHTML;
    }

    function openModal() {
        modalOverlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modalOverlay.classList.remove('show');
        document.body.style.overflow = '';
    }

    function resetForm() {
        heroIdInput.value = '';
        titleInput.value = '';
        subtitleInput.value = '';
        buttonText1Input.value = '';
        buttonLink1Input.value = '';
        buttonText2Input.value = '';
        buttonLink2Input.value = '';
        sortOrderInput.value = '0';
        imageInput.value = '';
        isActiveInput.checked = true;
        messageBox.innerHTML = '';
        imagePreview.src = '';
        imagePreview.classList.add('hidden');

        modalTitle.textContent = 'إضافة سلايد جديد';
        modalSubtitle.textContent = 'أدخل بيانات السلايد ثم احفظ';
        saveBtn.textContent = 'حفظ السلايد';
    }

    function fillEditForm(button) {
        heroIdInput.value = button.dataset.heroId || '';
        titleInput.value = button.dataset.title || '';
        subtitleInput.value = button.dataset.subtitle || '';
        buttonText1Input.value = button.dataset.button1Text || '';
        buttonLink1Input.value = button.dataset.button1Link || '';
        buttonText2Input.value = button.dataset.button2Text || '';
        buttonLink2Input.value = button.dataset.button2Link || '';
        sortOrderInput.value = button.dataset.sortOrder || '0';
        isActiveInput.checked = (button.dataset.isActive || '0') === '1';
        imageInput.value = '';
        messageBox.innerHTML = '';

        const image = button.dataset.image || '';
        if (image) {
            imagePreview.src = image;
            imagePreview.classList.remove('hidden');
        } else {
            imagePreview.src = '';
            imagePreview.classList.add('hidden');
        }

        modalTitle.textContent = 'تعديل السلايد';
        modalSubtitle.textContent = 'عدّل بيانات السلايد ثم احفظ';
        saveBtn.textContent = 'حفظ التعديل';
    }

    function bindImagePreview() {
        if (!imageInput || !imagePreview) return;

        imageInput.addEventListener('change', function () {
            const file = this.files && this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        });
    }

    if (openAddBtn) {
        openAddBtn.addEventListener('click', function () {
            resetForm();
            openModal();
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', closeModal);
    }

    if (modalOverlay) {
        modalOverlay.addEventListener('click', function (e) {
            if (e.target === modalOverlay) {
                closeModal();
            }
        });
    }

    bindImagePreview();

    document.querySelectorAll('.js-edit-hero-btn').forEach(button => {
        button.addEventListener('click', function () {
            fillEditForm(this);
            openModal();
        });
    });

    document.querySelectorAll('.js-delete-hero-btn').forEach(button => {
        button.addEventListener('click', async function () {
            const heroId = this.dataset.heroId || '';
            const heroTitle = this.dataset.heroTitle || '';
            const confirmed = confirm(`هل أنت متأكد من حذف السلايد: ${heroTitle} ؟`);

            if (!confirmed) return;

            this.disabled = true;
            const originalText = this.textContent;
            this.textContent = 'جاري الحذف...';

            try {
                const formData = new URLSearchParams();
                formData.append('id', heroId);

                const response = await fetch(`${window.APP_BASE_PATH}/admin/api/hero/delete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData.toString()
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(result.message || 'تعذر حذف السلايد');
                }

                window.location.reload();
            } catch (error) {
                alert(error.message || 'حدث خطأ أثناء الحذف');
                this.disabled = false;
                this.textContent = originalText;
            }
        });
    });

    document.querySelectorAll('.js-toggle-hero-btn').forEach(button => {
        button.addEventListener('click', async function () {
            const heroId = this.dataset.heroId || '';

            this.disabled = true;
            const originalText = this.textContent;
            this.textContent = 'جاري التحديث...';

            try {
                const formData = new URLSearchParams();
                formData.append('id', heroId);

                const response = await fetch(`${window.APP_BASE_PATH}/admin/api/hero/toggle`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData.toString()
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(result.message || 'تعذر تغيير الحالة');
                }

                window.location.reload();
            } catch (error) {
                alert(error.message || 'حدث خطأ أثناء تغيير الحالة');
                this.disabled = false;
                this.textContent = originalText;
            }
        });
    });

    if (saveBtn) {
        saveBtn.addEventListener('click', async function () {
            const id = (heroIdInput.value || '').trim();
            const title = (titleInput.value || '').trim();

            messageBox.innerHTML = '';

            if (!title) {
                messageBox.innerHTML = `<div class="alert alert-danger">يرجى إدخال عنوان السلايد</div>`;
                titleInput.focus();
                return;
            }

            const isEditMode = id !== '';
            const endpoint = isEditMode
                ? `${window.APP_BASE_PATH}/admin/api/hero/update`
                : `${window.APP_BASE_PATH}/admin/api/hero/store`;

            this.disabled = true;
            this.textContent = isEditMode ? 'جاري حفظ التعديل...' : 'جاري الحفظ...';

            try {
                const formData = new FormData();

                if (isEditMode) {
                    formData.append('id', id);
                }

                formData.append('title', title);
                formData.append('subtitle', subtitleInput.value || '');
                formData.append('button_text_1', buttonText1Input.value || '');
                formData.append('button_link_1', buttonLink1Input.value || '');
                formData.append('button_text_2', buttonText2Input.value || '');
                formData.append('button_link_2', buttonLink2Input.value || '');
                formData.append('sort_order', sortOrderInput.value || '0');

                if (isActiveInput.checked) {
                    formData.append('is_active', '1');
                }

                if (imageInput.files && imageInput.files[0]) {
                    formData.append('image', imageInput.files[0]);
                }

                const response = await fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(result.message || (isEditMode ? 'تعذر تعديل السلايد' : 'تعذر حفظ السلايد'));
                }

                messageBox.innerHTML = `
                    <div class="alert alert-success">
                        ${escapeHtml(result.message || (isEditMode ? 'تم تعديل السلايد بنجاح' : 'تمت إضافة السلايد بنجاح'))}
                    </div>
                `;

                setTimeout(() => window.location.reload(), 700);
            } catch (error) {
                messageBox.innerHTML = `
                    <div class="alert alert-danger">
                        ${escapeHtml(error.message || 'حدث خطأ أثناء الحفظ')}
                    </div>
                `;
            } finally {
                this.disabled = false;
                this.textContent = heroIdInput.value ? 'حفظ التعديل' : 'حفظ السلايد';
            }
        });
    }

    if (searchInput && tableBody) {
        searchInput.addEventListener('input', function () {
            const keyword = (this.value || '').trim().toLowerCase();
            const rows = tableBody.querySelectorAll('tr');

            rows.forEach(row => {
                const text = (row.textContent || '').toLowerCase();
                row.style.display = text.includes(keyword) ? '' : 'none';
            });
        });
    }
});
</script>