USE firstclass_shop;

INSERT IGNORE INTO categories(name) VALUES
('هدايا'),('عطور'),('اكسسوارات');

INSERT IGNORE INTO brands(name) VALUES
('FirstClass'),('Premium'),('SaaSStyle');

-- Products
INSERT INTO products(category_id, brand_id, name, slug, description, rating, is_active)
VALUES
(1, 1, 'ساعة يد فاخرة', 'luxury-watch', 'ساعة أنيقة مناسبة للهدايا.', 4.6, 1),
(2, 2, 'عطر شرقي', 'oriental-perfume', 'رائحة ثابتة وفاخرة.', 4.3, 1),
(3, 3, 'محفظة جلد', 'leather-wallet', 'جلد طبيعي مع تصميم مودرن.', 4.8, 1);

-- حدّث inventory (الـ trigger أنشأ السجلات تلقائياً)
UPDATE inventory SET price=79.99, qty=12 WHERE product_id=1;
UPDATE inventory SET price=39.50, qty=8  WHERE product_id=2;
UPDATE inventory SET price=24.00, qty=0  WHERE product_id=3;