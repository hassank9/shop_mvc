CREATE DATABASE IF NOT EXISTS firstclass_shop
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE firstclass_shop;

-- categories
CREATE TABLE IF NOT EXISTS categories (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_categories_name (name)
) ENGINE=InnoDB;

-- brands
CREATE TABLE IF NOT EXISTS brands (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_brands_name (name)
) ENGINE=InnoDB;

-- products
CREATE TABLE IF NOT EXISTS products (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  category_id INT UNSIGNED NULL,
  brand_id INT UNSIGNED NULL,
  name VARCHAR(200) NOT NULL,
  slug VARCHAR(220) NOT NULL,
  description TEXT NULL,
  rating DECIMAL(2,1) NOT NULL DEFAULT 0.0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL,
  UNIQUE KEY uq_products_slug (slug),
  KEY idx_products_name (name),
  CONSTRAINT fk_products_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
  CONSTRAINT fk_products_brand FOREIGN KEY (brand_id) REFERENCES brands(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- inventory (سجل واحد لكل منتج)
CREATE TABLE IF NOT EXISTS inventory (
  product_id INT UNSIGNED PRIMARY KEY,
  price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  qty INT NOT NULL DEFAULT 0,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_inventory_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Trigger: عند إضافة منتج ينشئ inventory تلقائياً
DROP TRIGGER IF EXISTS trg_products_after_insert_inventory;
DELIMITER $$
CREATE TRIGGER trg_products_after_insert_inventory
AFTER INSERT ON products
FOR EACH ROW
BEGIN
  INSERT INTO inventory(product_id, price, qty) VALUES (NEW.id, 0.00, 0);
END$$
DELIMITER ;