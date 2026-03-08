<?php
$settings = $settings ?? [];
?>

<style>
    .settings-page{
        display:flex;
        flex-direction:column;
        gap:24px;
    }

    .settings-form{
        display:flex;
        flex-direction:column;
        gap:24px;
    }

    .settings-grid{
        display:grid;
        grid-template-columns:repeat(2, minmax(0,1fr));
        gap:22px;
    }

    .settings-card{
        background:#fff;
        border:1px solid #eef1f5;
        border-radius:24px;
        box-shadow:0 10px 30px rgba(15,23,42,.04);
        overflow:hidden;
    }

    .settings-card.full-width{
        grid-column:1 / -1;
    }

    .settings-tab-panel .settings-card{
    grid-column: 1 / -1;
    }

    .settings-card-header{
        padding:18px 22px;
        border-bottom:1px solid #eef1f5;
    }

    .settings-card-title{
        margin:0;
        font-size:20px;
        font-weight:800;
        color:#111827;
    }

    .settings-card-subtitle{
        margin:6px 0 0;
        color:#8a94a6;
        font-size:14px;
    }

    .settings-card-body{
        padding:22px;
    }

    .form-grid{
        display:grid;
        grid-template-columns:repeat(2, minmax(0,1fr));
        gap:18px;
    }

    .form-group{
        display:flex;
        flex-direction:column;
        gap:8px;
    }

    .form-group.full-width{
        grid-column:1 / -1;
    }

    .form-label{
        font-size:14px;
        font-weight:800;
        color:#374151;
    }

    .form-control,
    .form-select,
    .form-textarea{
        width:100%;
        border:1px solid #dbe3ee;
        border-radius:16px;
        padding:12px 14px;
        font-size:14px;
        outline:none;
        background:#fff;
        transition:.2s ease;
    }

    .form-control:focus,
    .form-select:focus,
    .form-textarea:focus{
        border-color:#3b82f6;
        box-shadow:0 0 0 4px rgba(59,130,246,.10);
    }

    .form-textarea{
        min-height:120px;
        resize:vertical;
    }

    .switches-grid{
        display:grid;
        grid-template-columns:repeat(3, minmax(0,1fr));
        gap:14px;
        margin-top:8px;
    }

    .switch-box{
        border:1px solid #e5e7eb;
        border-radius:18px;
        padding:14px;
        background:#fafafa;
    }

    .switch-box label{
        display:flex;
        align-items:center;
        gap:10px;
        font-weight:700;
        color:#111827;
        cursor:pointer;
    }

    .switch-box input[type="checkbox"]{
        width:18px;
        height:18px;
    }

    .alert{
        border-radius:18px;
        padding:14px 16px;
        font-weight:700;
    }

    .alert-success{
        background:#ecfdf3;
        color:#027a48;
        border:1px solid #abefc6;
    }

    .alert-error{
        background:#fef3f2;
        color:#b42318;
        border:1px solid #fecdca;
    }

    .actions-bar{
        display:flex;
        justify-content:flex-end;
        gap:12px;
    }

    .btn-save{
        border:none;
        background:#111827;
        color:#fff;
        border-radius:16px;
        padding:13px 22px;
        font-size:14px;
        font-weight:800;
        cursor:pointer;
    }

    .btn-save:hover{
        opacity:.92;
    }

    .btn-save:disabled{
        opacity:.7;
        cursor:not-allowed;
    }

    .inline-note{
        font-size:13px;
        color:#8a94a6;
        margin-top:4px;
    }

    .settings-tabs{
    display:flex;
    flex-wrap:wrap;
    gap:12px;
    margin-bottom:4px;
    }

    .settings-tab-btn{
        border:1px solid #e5e7eb;
        background:#fff;
        color:#111827;
        border-radius:16px;
        padding:12px 18px;
        font-size:14px;
        font-weight:800;
        cursor:pointer;
        transition:.2s ease;
    }

    .settings-tab-btn.active{
        background:#ff7a1a;
        color:#fff;
        border-color:#ff7a1a;
        box-shadow:0 10px 25px rgba(255,122,26,.18);
    }

    .settings-tab-panel{
        display:none;
    }

    .settings-tab-panel.active{
        display:block;
    }

    .settings-tab-panel + .settings-tab-panel{
        margin-top:0;
    }

    @media (max-width: 991px){
        .settings-grid,
        .form-grid,
        .switches-grid{
            grid-template-columns:1fr;
        }
    }

    .image-upload-box{
    display:flex;
    flex-direction:column;
    gap:10px;
}

.image-preview{
    width:120px;
    height:120px;
    border-radius:18px;
    border:1px solid #e5e7eb;
    object-fit:cover;
    background:#f8fafc;
}

.image-preview.small{
    width:64px;
    height:64px;
    border-radius:14px;
}
</style>

<div class="settings-page">
    <div class="page-header">
        <div>
            <h1 class="page-title">الإعدادات</h1>
            <p class="page-subtitle">إدارة بيانات الموقع، معلومات التواصل، وقيم الطباعة والوصل.</p>
        </div>
    </div>

    <div id="settingsMessage"></div>

    <div class="settings-tabs">
    <button type="button" class="settings-tab-btn active" data-tab="generalTab">عام</button>
    <button type="button" class="settings-tab-btn" data-tab="aboutTab">من نحن</button>
    <button type="button" class="settings-tab-btn" data-tab="contactTab">تواصل معنا</button>
    <button type="button" class="settings-tab-btn" data-tab="receiptTab">الطباعة</button>
    </div>

    <form id="settingsForm" class="settings-form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= (int)($settings['id'] ?? 0) ?>">

        <div class="settings-tab-panel active" id="generalTab">
            <div class="settings-grid">

            <div class="settings-card">
                <div class="settings-card-header">
                    <h3 class="settings-card-title">الإعدادات العامة</h3>
                    <p class="settings-card-subtitle">بيانات الموقع الأساسية التي سنربطها لاحقًا مع الواجهة.</p>
                </div>
                <div class="settings-card-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">اسم الموقع بالعربي</label>
                            <input type="text" class="form-control" name="site_name_ar" value="<?= htmlspecialchars($settings['site_name_ar'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label">اسم الموقع بالإنجليزي</label>
                            <input type="text" class="form-control" name="site_name_en" value="<?= htmlspecialchars($settings['site_name_en'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">وصف مختصر للموقع</label>
                            <textarea class="form-textarea" name="site_description"><?= htmlspecialchars($settings['site_description'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                        </div>

                        <div class="form-group">
                        <label class="form-label">الشعار</label>
                        <div class="image-upload-box">
                            <?php if (!empty($settings['logo'])): ?>
                                <img src="<?= htmlspecialchars($settings['logo'], ENT_QUOTES, 'UTF-8') ?>" alt="Logo" class="image-preview" id="logoPreview">
                            <?php else: ?>
                                <img src="" alt="Logo" class="image-preview" id="logoPreview" style="display:none;">
                            <?php endif; ?>
                            <input type="file" class="form-control" name="logo" id="logoInput" accept=".jpg,.jpeg,.png,.webp,.svg">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Favicon</label>
                        <div class="image-upload-box">
                            <?php if (!empty($settings['favicon'])): ?>
                                <img src="<?= htmlspecialchars($settings['favicon'], ENT_QUOTES, 'UTF-8') ?>" alt="Favicon" class="image-preview small" id="faviconPreview">
                            <?php else: ?>
                                <img src="" alt="Favicon" class="image-preview small" id="faviconPreview" style="display:none;">
                            <?php endif; ?>
                            <input type="file" class="form-control" name="favicon" id="faviconInput" accept=".jpg,.jpeg,.png,.webp,.svg,.ico">
                        </div>
                    </div>

                        <div class="form-group">
                            <label class="form-label">حد انخفاض المخزون</label>
                            <input type="number" min="0" class="form-control" name="low_stock_threshold" value="<?= (int)($settings['low_stock_threshold'] ?? 3) ?>">
                            <div class="inline-note">هذا الرقم سيُستخدم لاحقًا في تنبيهات المنتجات القليلة.</div>
                        </div>
                    </div>
                </div>
            </div>

                </div>
</div>

<div class="settings-tab-panel" id="aboutTab">
    <div class="settings-grid">


            
            <div class="settings-card">
                <div class="settings-card-header">
                    <h3 class="settings-card-title">من نحن</h3>
                    <p class="settings-card-subtitle">محتوى قسم التعريف بالنشاط أو المتجر.</p>
                </div>
                <div class="settings-card-body">
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label class="form-label">عنوان قسم من نحن</label>
                            <input type="text" class="form-control" name="about_title" value="<?= htmlspecialchars($settings['about_title'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">النص</label>
                            <textarea class="form-textarea" name="about_text"><?= htmlspecialchars($settings['about_text'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                        </div>

                        <div class="form-group full-width">
                    <label class="form-label">صورة من نحن</label>
                    <div class="image-upload-box">
                        <?php if (!empty($settings['about_image'])): ?>
                            <img src="<?= htmlspecialchars($settings['about_image'], ENT_QUOTES, 'UTF-8') ?>" alt="About" class="image-preview" id="aboutImagePreview">
                        <?php else: ?>
                            <img src="" alt="About" class="image-preview" id="aboutImagePreview" style="display:none;">
                        <?php endif; ?>
                        <input type="file" class="form-control" name="about_image" id="aboutImageInput" accept=".jpg,.jpeg,.png,.webp,.svg">
                    </div>
                </div>
                    </div>
                </div>
            </div>


                </div>
</div>

<div class="settings-tab-panel" id="contactTab">
    <div class="settings-grid">

            <div class="settings-card">
                <div class="settings-card-header">
                    <h3 class="settings-card-title">تواصل معنا</h3>
                    <p class="settings-card-subtitle">بيانات الاتصال والعنوان وروابط المنصات.</p>
                </div>
                <div class="settings-card-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">الهاتف الأول</label>
                            <input type="text" class="form-control" name="contact_phone_1" value="<?= htmlspecialchars($settings['contact_phone_1'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label">الهاتف الثاني</label>
                            <input type="text" class="form-control" name="contact_phone_2" value="<?= htmlspecialchars($settings['contact_phone_2'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label">واتساب</label>
                            <input type="text" class="form-control" name="contact_whatsapp" value="<?= htmlspecialchars($settings['contact_whatsapp'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="text" class="form-control" name="contact_email" value="<?= htmlspecialchars($settings['contact_email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">العنوان</label>
                            <textarea class="form-textarea" name="contact_address"><?= htmlspecialchars($settings['contact_address'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">رابط Google Maps</label>
                            <input type="text" class="form-control" name="contact_map_url" value="<?= htmlspecialchars($settings['contact_map_url'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label">فيسبوك</label>
                            <input type="text" class="form-control" name="facebook_url" value="<?= htmlspecialchars($settings['facebook_url'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label">إنستغرام</label>
                            <input type="text" class="form-control" name="instagram_url" value="<?= htmlspecialchars($settings['instagram_url'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label">تيليجرام</label>
                            <input type="text" class="form-control" name="telegram_url" value="<?= htmlspecialchars($settings['telegram_url'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label">تيك توك</label>
                            <input type="text" class="form-control" name="tiktok_url" value="<?= htmlspecialchars($settings['tiktok_url'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        </div>
                    </div>
                </div>
            </div>


                </div>
</div>

<div class="settings-tab-panel" id="receiptTab">
    <div class="settings-grid">


            <div class="settings-card">
                <div class="settings-card-header">
                    <h3 class="settings-card-title">إعدادات الوصل والطباعة</h3>
                    <p class="settings-card-subtitle">البيانات التي ستظهر لاحقًا في طباعة الطلبات والوصل.</p>
                </div>
                <div class="settings-card-body">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">اسم المتجر في الوصل</label>
                            <input type="text" class="form-control" name="receipt_store_name" value="<?= htmlspecialchars($settings['receipt_store_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label">نوع الكود</label>
                            <select class="form-select" name="receipt_barcode_type">
                                <option value="qr" <?= (($settings['receipt_barcode_type'] ?? '') === 'qr') ? 'selected' : '' ?>>QR</option>
                                <option value="barcode" <?= (($settings['receipt_barcode_type'] ?? '') === 'barcode') ? 'selected' : '' ?>>Barcode</option>
                            </select>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">نص أعلى الوصل</label>
                            <input type="text" class="form-control" name="receipt_header_text" value="<?= htmlspecialchars($settings['receipt_header_text'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">نص أسفل الوصل</label>
                            <input type="text" class="form-control" name="receipt_footer_text" value="<?= htmlspecialchars($settings['receipt_footer_text'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label">قيمة الباركود / QR</label>
                            <input type="text" class="form-control" name="receipt_barcode_value" value="<?= htmlspecialchars($settings['receipt_barcode_value'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            <div class="inline-note">يمكنك وضع نص ثابت أو رابط موقع أو رابط واتساب أو أي قيمة تريدها.</div>
                        </div>
                    </div>

                    <div class="switches-grid">
                        <div class="switch-box">
                            <label>
                                <input type="checkbox" name="receipt_show_logo" value="1" <?= !empty($settings['receipt_show_logo']) ? 'checked' : '' ?>>
                                <span>إظهار الشعار</span>
                            </label>
                        </div>

                        <div class="switch-box">
                            <label>
                                <input type="checkbox" name="receipt_show_address" value="1" <?= !empty($settings['receipt_show_address']) ? 'checked' : '' ?>>
                                <span>إظهار العنوان</span>
                            </label>
                        </div>

                        <div class="switch-box">
                            <label>
                                <input type="checkbox" name="receipt_show_contacts" value="1" <?= !empty($settings['receipt_show_contacts']) ? 'checked' : '' ?>>
                                <span>إظهار أرقام التواصل</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

        </div>
            </div>
</div>

        <div class="actions-bar">
            <button type="submit" class="btn-save" id="settingsSubmitBtn">حفظ الإعدادات</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('settingsForm');
    const submitBtn = document.getElementById('settingsSubmitBtn');
    const messageBox = document.getElementById('settingsMessage');
    const logoInput = document.getElementById('logoInput');
    const faviconInput = document.getElementById('faviconInput');
    const aboutImageInput = document.getElementById('aboutImageInput');

    const logoPreview = document.getElementById('logoPreview');
    const faviconPreview = document.getElementById('faviconPreview');
    const aboutImagePreview = document.getElementById('aboutImagePreview');

    function bindImagePreview(input, preview) {
        if (!input || !preview) {
            return;
        }

        input.addEventListener('change', function () {
            const file = this.files && this.files[0];
            if (!file) {
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    }




    if (!form || !submitBtn || !messageBox) {
        return;
    }


    bindImagePreview(logoInput, logoPreview);
    bindImagePreview(faviconInput, faviconPreview);
    bindImagePreview(aboutImageInput, aboutImagePreview);

    function showMessage(type, text) {
        messageBox.innerHTML = `
            <div class="alert ${type === 'success' ? 'alert-success' : 'alert-error'}">
                ${text}
            </div>
        `;
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        messageBox.innerHTML = '';
        submitBtn.disabled = true;
        submitBtn.textContent = 'جاري الحفظ...';

        try {
            const formData = new FormData(form);

            const response = await fetch('<?= htmlspecialchars(\App\Admin\Helpers\AdminUrl::path('/admin/api/settings/update'), ENT_QUOTES, 'UTF-8') ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            let result = null;

            try {
                result = await response.json();
            } catch (jsonError) {
                showMessage('error', 'الخادم لم يرجع JSON صحيح');
                return;
            }

            if (!response.ok || !result.success) {
                showMessage('error', result.message || 'حدث خطأ أثناء حفظ الإعدادات');
                return;
            }

            showMessage('success', result.message || 'تم تحديث الإعدادات بنجاح');
        } catch (error) {
            showMessage('error', 'تعذر الاتصال بالخادم');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'حفظ الإعدادات';
        }
    });
});

const tabButtons = document.querySelectorAll('.settings-tab-btn');
const tabPanels = document.querySelectorAll('.settings-tab-panel');

tabButtons.forEach(function (button) {
    button.addEventListener('click', function () {
        const targetId = this.getAttribute('data-tab');

        tabButtons.forEach(function (btn) {
            btn.classList.remove('active');
        });

        tabPanels.forEach(function (panel) {
            panel.classList.remove('active');
        });

        this.classList.add('active');

        const targetPanel = document.getElementById(targetId);
        if (targetPanel) {
            targetPanel.classList.add('active');
        }
    });
});

</script>