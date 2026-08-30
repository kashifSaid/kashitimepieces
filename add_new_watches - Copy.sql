-- ============================================
-- ADD NEW WATCHES (Women / Men / Sport)
-- Run this in phpMyAdmin > SQL tab if your
-- database is already set up and you just
-- want to add the new watches without
-- re-importing the whole database.sql
-- ============================================

USE kashi_timepieces;

INSERT INTO products
(name, description, price, image, category, type, stock_quantity)
VALUES

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
