CREATE DATABASE IF NOT EXISTS login_db;
USE login_db;

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP VIEW IF EXISTS products;
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS admin;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS all_products;

CREATE TABLE users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(191) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_users_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE admin (
    admin_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    admin_name VARCHAR(100) NOT NULL,
    admin_email VARCHAR(191) NOT NULL,
    admin_password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (admin_id),
    UNIQUE KEY uniq_admin_email (admin_email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE all_products (
    pid INT UNSIGNED NOT NULL AUTO_INCREMENT,
    product_name VARCHAR(150) NOT NULL,
    product_cat VARCHAR(50) NOT NULL,
    price INT NOT NULL,
    description TEXT NOT NULL,
    product_image VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (pid),
    KEY idx_product_cat (product_cat)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE orders (
    order_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    order_price INT NOT NULL,
    order_status VARCHAR(50) NOT NULL DEFAULT 'pending',
    uid INT UNSIGNED NOT NULL,
    u_phone VARCHAR(20) NOT NULL,
    user_address VARCHAR(255) NOT NULL,
    order_date DATETIME NOT NULL,
    PRIMARY KEY (order_id),
    KEY idx_orders_uid (uid),
    CONSTRAINT fk_orders_user
        FOREIGN KEY (uid) REFERENCES users(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE order_items (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    order_id INT UNSIGNED NOT NULL,
    product_name VARCHAR(150) NOT NULL,
    product_image VARCHAR(255) NOT NULL,
    price INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    uid INT UNSIGNED NOT NULL,
    order_date DATETIME NOT NULL,
    PRIMARY KEY (id),
    KEY idx_order_items_order_id (order_id),
    KEY idx_order_items_uid (uid),
    CONSTRAINT fk_order_items_order
        FOREIGN KEY (order_id) REFERENCES orders(order_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_order_items_user
        FOREIGN KEY (uid) REFERENCES users(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (id, name, phone, email, password) VALUES
    (1, 'Demo User', '9812345678', 'user@example.com', '$2y$10$QUaVkrNmdroOBOT7lCm3PeUnAEZbgNJVHhJm1INtc1LcO6Lv71OZe');

INSERT INTO admin (admin_id, admin_name, admin_email, admin_password) VALUES
    (1, 'Admin', 'admin@gmail.com', MD5('admin@12'));

INSERT INTO all_products (pid, product_name, product_cat, price, description, product_image) VALUES
    (1, 'Sleeveless Gown', 'spring collection', 3000, 'Elegant sleeveless gown designed for spring occasions and evening outings.', 'fr.png'),
    (2, 'Party Wear Frock', 'spring collection', 4000, 'Stylish party frock with a flattering silhouette for festive events.', 'f2.jpg'),
    (3, 'Skirt Sets', 'spring collection', 1500, 'Comfortable coordinated skirt set ideal for casual and semi-formal wear.', 'a8.jpg'),
    (4, 'Beads Prom Dress', 'spring collection', 2500, 'Prom-inspired dress with bead detailing and a soft flowing finish.', 'gown.jpg'),

    (5, 'Cargo Pant', 'new_arrival', 1800, 'Modern cargo pant with practical pockets and a relaxed streetwear fit.', 'Cargo Pant.jpeg'),
    (6, 'White Suit', 'new_arrival', 3500, 'Clean tailored white suit for a polished and confident look.', 'WhiteSuit.jpeg'),
    (7, 'Floral Top', 'new_arrival', 1200, 'Fresh floral top that pairs well with jeans, skirts, or trousers.', 'Top.jpg'),
    (8, 'Evening Gown', 'new_arrival', 4200, 'Graceful evening gown suitable for receptions, parties, and celebrations.', 'Gown.jpeg'),

    (9, 'One-piece with strap', 'summer_wear', 1500, 'Lightweight one-piece summer outfit with straps for day-long comfort.', 'a6.jpg'),
    (10, 'Frock', 'summer_wear', 1400, 'Simple breezy frock made for warm weather and everyday styling.', 'a7.jpg'),
    (11, 'Skater Pink Dress', 'summer_wear', 2000, 'Pink skater dress with a playful cut and seasonal appeal.', 'a9.jpg'),
    (12, 'Blue Flare Dress', 'summer_wear', 1200, 'Affordable blue flare dress with a soft and airy silhouette.', 'a10.jpg'),

    (13, 'Crop Laces Top', 'trendy_dress', 1000, 'Trendy cropped lace-style top for layered and modern outfits.', 'd8.jpg'),
    (14, 'Hoodie', 'trendy_dress', 2500, 'Casual hoodie with a cozy fit for everyday streetwear looks.', 'hoodie.jpg'),
    (15, 'Suspender Skirt', 'trendy_dress', 1500, 'Fashionable suspender skirt that adds a playful touch to your wardrobe.', 'a2.jpg'),
    (16, 'Crop Jacket', 'trendy_dress', 2500, 'Cropped jacket with a sharp silhouette for trendy layered styling.', 'a3.jpg'),
    (17, 'T-shirt', 'trendy_dress', 1500, 'Versatile t-shirt for casual everyday wear and easy pairing.', 'a4.jpg'),
    (18, 'Cardigan', 'trendy_dress', 1500, 'Soft cardigan perfect for layering in transitional weather.', 'e2.jpg');

CREATE OR REPLACE VIEW products AS
SELECT
    pid,
    product_name,
    product_cat,
    price,
    description,
    product_image,
    created_at
FROM all_products;

SET FOREIGN_KEY_CHECKS = 1;
