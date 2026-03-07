<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">اسم المنتج</label>
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name'] ?? ''); ?>" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Slug</label>
        <input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($product['slug'] ?? ''); ?>">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Brand ID</label>
        <input type="number" name="brand_id" class="form-control" value="<?= htmlspecialchars($product['brand_id'] ?? ''); ?>" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Category ID</label>
        <input type="number" name="category_id" class="form-control" value="<?= htmlspecialchars($product['category_id'] ?? ''); ?>" required>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">التقييم</label>
        <input type="number" step="0.1" min="0" max="5" name="rating" class="form-control" value="<?= htmlspecialchars($product['rating'] ?? 0); ?>">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">سعر الشراء</label>
        <input type="number" step="0.01" name="cost_price" class="form-control" value="<?= htmlspecialchars($product['cost_price'] ?? 0); ?>">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">سعر البيع</label>
        <input type="number" step="0.01" name="price" class="form-control" value="<?= htmlspecialchars($product['price'] ?? 0); ?>">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">الكمية</label>
        <input type="number" name="qty" class="form-control" value="<?= htmlspecialchars($product['qty'] ?? 0); ?>">
    </div>

    <div class="col-md-4 mb-3 d-flex align-items-end">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                <?= !empty($product['is_active']) ? 'checked' : ''; ?>>
            <label class="form-check-label" for="is_active">نشط</label>
        </div>
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">الوصف</label>
        <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($product['description'] ?? ''); ?></textarea>
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">الصورة الرئيسية</label>
        <input type="file" name="main_image" class="form-control" accept=".jpg,.jpeg,.png,.webp">
    </div>
</div>