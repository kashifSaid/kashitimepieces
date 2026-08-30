-- ============================================
-- KASHI TIMEPIECES DATABASE - FINAL VERSION
-- ============================================

CREATE DATABASE IF NOT EXISTS kashi_timepieces
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE kashi_timepieces;


-- ============================================
-- USERS TABLE
-- ============================================

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


-- ============================================
-- ADMINS TABLE
-- ============================================

CREATE TABLE admins (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


-- ============================================
-- PRODUCTS TABLE
-- ============================================

CREATE TABLE products (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(500) DEFAULT NULL,
    category VARCHAR(100) DEFAULT NULL,
    type VARCHAR(100) DEFAULT NULL,
    stock_quantity INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;


-- ============================================
-- CART ITEMS TABLE
-- ============================================

CREATE TABLE cart_items (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    user_id INT UNSIGNED NOT NULL,
    product_id INT UNSIGNED NOT NULL,

    quantity INT UNSIGNED NOT NULL DEFAULT 1,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY unique_user_product (user_id, product_id),

    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE,

    FOREIGN KEY (product_id)
        REFERENCES products(id)
        ON DELETE CASCADE

) ENGINE=InnoDB;


-- ============================================
-- ORDERS TABLE
-- ============================================

CREATE TABLE orders (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    user_id INT UNSIGNED NOT NULL,

    total_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,

    status ENUM(
        'placed',
        'confirmed',
        'completed',
        'cancelled'
    ) NOT NULL DEFAULT 'placed',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE

) ENGINE=InnoDB;


-- ============================================
-- ORDER ITEMS TABLE
-- ============================================

CREATE TABLE order_items (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    order_id INT UNSIGNED NOT NULL,

    product_id INT UNSIGNED NOT NULL,

    product_name VARCHAR(200) NOT NULL,

    product_price DECIMAL(10,2) NOT NULL,

    quantity INT UNSIGNED NOT NULL,

    subtotal DECIMAL(10,2) NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (order_id)
        REFERENCES orders(id)
        ON DELETE CASCADE,

    FOREIGN KEY (product_id)
        REFERENCES products(id)
        ON DELETE CASCADE

) ENGINE=InnoDB;


-- ============================================
-- COMPLAINTS TABLE
-- ============================================

CREATE TABLE complaints (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    user_id INT UNSIGNED DEFAULT NULL,

    name VARCHAR(100) NOT NULL,

    email VARCHAR(150) NOT NULL,

    subject VARCHAR(200) NOT NULL,

    message TEXT NOT NULL,

    status ENUM(
        'pending',
        'reviewed',
        'resolved'
    ) NOT NULL DEFAULT 'pending',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE SET NULL

) ENGINE=InnoDB;


-- ============================================
-- NEWSLETTER TABLE
-- ============================================

CREATE TABLE newsletter_subscribers (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    email VARCHAR(150) NOT NULL UNIQUE,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


-- ============================================
-- DEFAULT ADMIN
-- ============================================

INSERT INTO admins (name, email, password)
VALUES (
    'Administrator',
    'admin@kashitimepieces.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/6DgN.D2uFY0pO'
);


-- ============================================
-- DEFAULT PRODUCTS
-- ============================================

INSERT INTO products
(name, description, price, image, category, type, stock_quantity)
VALUES

(
    'Royal Classic',
    'A timeless luxury watch crafted for elegance and everyday sophistication.',
    25000.00,
    'https://images.unsplash.com/photo-1524805444758-089113d48a6d?auto=format&fit=crop&w=800&q=80',
    'Men',
    'Classic',
    10
),

(
    'Midnight Gold',
    'A premium black and gold timepiece with a bold luxury appearance.',
    32000.00,
    'https://images.unsplash.com/photo-1523170335258-f5ed11844a49?auto=format&fit=crop&w=800&q=80',
    'Men',
    'Luxury',
    8
),

(
    'Elegant Rose',
    'A beautiful rose gold watch designed with elegance and sophistication.',
    28000.00,
    'https://images.unsplash.com/photo-1547996160-81dfa63595aa?auto=format&fit=crop&w=800&q=80',
    'Women',
    'Luxury',
    12
),

(
    'Ocean Blue',
    'A stylish blue watch inspired by the depth and beauty of the ocean.',
    22000.00,
    'https://images.unsplash.com/photo-1524592094714-0f0654e20314?auto=format&fit=crop&w=800&q=80',
    'Men',
    'Sport',
    15
),

(
    'Golden Heritage',
    'A classic golden luxury watch with a premium heritage design.',
    45000.00,
    'https://images.unsplash.com/photo-1508057198894-247b23fe5ade?auto=format&fit=crop&w=800&q=80',
    'Men',
    'Classic',
    5
),

(
    'Silver Elegance',
    'A clean and modern silver watch suitable for every occasion.',
    20000.00,
    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=800&q=80',
    'Women',
    'Classic',
    10
),

(
    'Black Phantom',
    'A bold black luxury watch with a modern and powerful design.',
    35000.00,
    'https://images.unsplash.com/photo-1518131672697-613becd4fab5?auto=format&fit=crop&w=800&q=80',
    'Men',
    'Luxury',
    7
),

(
    'Minimal White',
    'A minimalist modern watch with a clean and elegant white design.',
    18000.00,
    'https://images.unsplash.com/photo-1495856458515-0637185db551?auto=format&fit=crop&w=800&q=80',
    'Women',
    'Minimal',
    20
),

(
    'Active Rose',
    'A lightweight women''s sport watch built for an active, on-the-go lifestyle.',
    19500.00,
    'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?auto=format&fit=crop&w=800&q=80',
    'Women',
    'Sport',
    14
),

(
    'Pulse Pink',
    'A durable, water-resistant women''s sport watch with a bold pink accent dial.',
    21000.00,
    'https://images.unsplash.com/photo-1434493907317-a46b5bbe7834?auto=format&fit=crop&w=800&q=80',
    'Women',
    'Sport',
    9
),

(
    'Trail Blazer',
    'A rugged men''s sport watch designed for outdoor adventure and daily durability.',
    24500.00,
    'https://images.unsplash.com/photo-1533139502658-0198f920d8e8?auto=format&fit=crop&w=800&q=80',
    'Men',
    'Sport',
    11
),

(
    'Marathon Steel',
    'A performance-focused men''s sport chronograph built for endurance athletes.',
    27000.00,
    'https://images.unsplash.com/photo-1533139502658-0198f920d8e8?auto=format&fit=crop&w=800&q=80',
    'Men',
    'Sport',
    0
),

(
    'Pearl Whisper',
    'An elegant women''s classic watch with a delicate pearl-finish dial.',
    23000.00,
    'https://images.unsplash.com/photo-1548171915-e79a380a2a4b?auto=format&fit=crop&w=800&q=80',
    'Women',
    'Classic',
    6
),

(
    'Titan Forge',
    'A rugged, premium men''s luxury watch with a bold titanium-inspired case.',
    38000.00,
    'https://images.unsplash.com/photo-1509048191080-d2984bad6ae5?auto=format&fit=crop&w=800&q=80',
    'Men',
    'Luxury',
    4
);