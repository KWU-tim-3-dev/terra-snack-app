    -- USERS --
    INSERT INTO users (id, name, email, phone, role, password, created_at, updated_at) VALUES
    (1, 'Admin', 'admin@example.com', '081234567890', 'admin', '$2y$12$DSjiAFAyOILLiNwSruV3kuGRzUH3KS62USi.9hCR7hk6a.MnwDZv.', NOW(), NOW()),
    (2, 'David', 'david@example.com', '085604733012', 'customer', '$2y$12$DSjiAFAyOILLiNwSruV3kuGRzUH3KS62USi.9hCR7hk6a.MnwDZv.', NOW(), NOW()),
    (3, 'Adit', 'adit@example.com', '08111222333', 'customer', '$2y$12$DSjiAFAyOILLiNwSruV3kuGRzUH3KS62USi.9hCR7hk6a.MnwDZv.', NOW(), NOW()),
    (4, 'Rina', 'rina@example.com', '08133445566', 'customer', '$2y$12$DSjiAFAyOILLiNwSruV3kuGRzUH3KS62USi.9hCR7hk6a.MnwDZv.', NOW(), NOW()),
    (5, 'Dewi', 'dewi@example.com', '082233445566', 'customer', '$2y$12$DSjiAFAyOILLiNwSruV3kuGRzUH3KS62USi.9hCR7hk6a.MnwDZv.', NOW(), NOW()),
    (6, 'Rafli', 'rafli@example.com', '089999111222', 'customer', '$2y$12$DSjiAFAyOILLiNwSruV3kuGRzUH3KS62USi.9hCR7hk6a.MnwDZv.', NOW(), NOW()),
    (7, 'Bima', 'bima@example.com', '087788899900', 'customer', '$2y$12$DSjiAFAyOILLiNwSruV3kuGRzUH3KS62USi.9hCR7hk6a.MnwDZv.', NOW(), NOW()),
    (8, 'Lia', 'lia@example.com', '085500112233', 'customer', '$2y$12$DSjiAFAyOILLiNwSruV3kuGRzUH3KS62USi.9hCR7hk6a.MnwDZv.', NOW(), NOW()),
    (9, 'Hana', 'hana@example.com', '082244556677', 'customer', '$2y$12$DSjiAFAyOILLiNwSruV3kuGRzUH3KS62USi.9hCR7hk6a.MnwDZv.', NOW(), NOW()),
    (10, 'Tono', 'tono@example.com', '085533322211', 'customer', '$2y$12$DSjiAFAyOILLiNwSruV3kuGRzUH3KS62USi.9hCR7hk6a.MnwDZv.', NOW(), NOW()),
    (11, 'Gilang', 'gilang@example.com', '081355577799', 'customer', '$2y$12$DSjiAFAyOILLiNwSruV3kuGRzUH3KS62USi.9hCR7hk6a.MnwDZv.', NOW(), NOW());

    -- CATEGORIES --
    INSERT INTO categories (id, name, slug, created_at, updated_at) VALUES
    (1, 'Snack', 'snack', NOW(), NOW()),
    (2, 'Minuman', 'minuman', NOW(), NOW()),
    (3, 'Rice Bowl', 'rice-bowl', NOW(), NOW());

    -- PRODUCTS --
    INSERT INTO products (id, category_id, name, slug, price, image_url, created_at, updated_at) VALUES
    -- Snack Category Products
    (1, 1, 'Babi Crispy', 'babi-crispy', 12000, 'babi1.jpg', NOW(), NOW()),
    (2, 1, 'Sosis Bakar', 'sosis-bakar', 10000, 'sosis1.jpg', NOW(), NOW()),
    (3, 1, 'Kentang Spiral', 'kentang-spiral', 15000, 'spiral1.jpg', NOW(), NOW()),
    (4, 1, 'Tempura Roll', 'tempura-roll', 13000, 'tempura1.jpg', NOW(), NOW()),
    (5, 1, 'Crispy Chicken Skin', 'crispy-chicken-skin', 11000, 'skin1.jpg', NOW(), NOW()),

    -- Minuman Category Products
    (6, 2, 'Es Cendol', 'es-cendol', 8000, 'cendol.jpg', NOW(), NOW()),
    (7, 2, 'Thai Tea', 'thai-tea', 10000, 'thaitea.jpg', NOW(), NOW()),
    (8, 2, 'Matcha Latte', 'matcha-latte', 13000, 'matcha.jpg', NOW(), NOW()),
    (9, 2, 'Chocolate Ice', 'choco-ice', 12000, 'choco.jpg', NOW(), NOW()),
    (10, 2, 'Jus Alpukat', 'jus-alpukat', 14000, 'alpukat.jpg', NOW(), NOW()),

    -- Rice Bowl Category Products
    (11, 3, 'Rice Bowl Chicken Teriyaki', 'chicken-teriyaki', 21000, 'teriyaki.jpg', NOW(), NOW()),
    (12, 3, 'Rice Bowl Beef Blackpepper', 'beef-blackpepper', 24000, 'beefpepper.jpg', NOW(), NOW()),
    (13, 3, 'Rice Bowl Ayam Geprek', 'ayam-geprek', 19000, 'geprek.jpg', NOW(), NOW());

    -- CUSTOMIZATION_OPTIONS --
    INSERT INTO customization_options (id, name, type, created_at, updated_at) VALUES
    (1, 'Saus', 'radio', NOW(), NOW()),
    (2, 'Topping', 'checkbox', NOW(), NOW()),
    (3, 'Level Pedas', 'radio', NOW(), NOW()),
    (4, 'Porsi', 'radio', NOW(), NOW()),
    (5, 'Extra Daging', 'checkbox', NOW(), NOW());

    -- OPTION_VALUES --
    INSERT INTO option_values (id, customization_option_id, name, price_modifier) VALUES
    -- Saus Options
    (1, 1, 'Saus Pedas', 1000),
    (2, 1, 'Saus Keju', 1500),
    (3, 1, 'Saus BBQ', 2000),
    (4, 1, 'Saus Blackpepper', 2500),
    (5, 1, 'Saus Garlic Mayo', 2000);

    -- Topping Options
    INSERT INTO option_values (id, customization_option_id, name, price_modifier) VALUES
    (6, 2, 'Keju Lebih', 3000),
    (7, 2, 'Sosis Mini', 4000),
    (8, 2, 'Crispy Onion', 2000),
    (9, 2, 'Chicken Bites', 5000),
    (10, 2, 'Extra Crunchy', 1500);

    -- Level Pedas Options
    INSERT INTO option_values (id, customization_option_id, name, price_modifier) VALUES
    (11, 3, 'Level 0 (Tidak Pedas)', 0),
    (12, 3, 'Level 1', 0),
    (13, 3, 'Level 2', 0),
    (14, 3, 'Level 3', 0),
    (15, 3, 'Level 4', 0);

    -- Porsi Options
    INSERT INTO option_values (id, customization_option_id, name, price_modifier) VALUES
    (16, 4, 'Regular', 0),
    (17, 4, 'Large', 4000),
    (18, 4, 'Jumbo', 7000);

    -- Extra Daging Options
    INSERT INTO option_values (id, customization_option_id, name, price_modifier) VALUES
    (19, 5, 'Ayam Extra', 5000),
    (20, 5, 'Beef Extra', 7000),
    (21, 5, 'Pork Extra', 8000),
    (22, 5, 'Udang Extra', 9000),
    (23, 5, 'Bakso Extra', 4000);

    -- PRODUCT_CUSTOMIZABLE_OPTIONS --
    INSERT INTO product_customizable_options (product_id, customization_option_id) VALUES
    -- Babi Crispy
    (1, 1), (1, 2), (1, 3),

    -- Sosis Bakar
    (2, 1), (2, 3),

    -- Kentang Spiral
    (3, 1), (3, 2),

    -- Tempura Roll
    (4, 1), (4, 2), (4, 3),

    -- Crispy Skin
    (5, 1), (5, 3),

    -- Rice Bowl Chicken Teriyaki
    (11, 4), (11, 5),

    -- Rice Bowl Beef Pepper
    (12, 4), (12, 5),

    -- Rice Bowl Geprek
    (13, 3), (13, 4), (13, 5);

    -- CARTS --
    INSERT INTO carts (id, user_id, created_at, updated_at) VALUES
    (1, 1, NOW(), NOW()),
    (2, 2, NOW(), NOW()),
    (3, 3, NOW(), NOW()),
    (4, 4, NOW(), NOW()),
    (5, 5, NOW(), NOW()),
    (6, 6, NOW(), NOW()),
    (7, 7, NOW(), NOW()),
    (8, 8, NOW(), NOW()),
    (9, 9, NOW(), NOW()),
    (10, 10, NOW(), NOW());

    -- CART_ITEMS --
    INSERT INTO cart_items (id, cart_id, product_id, quantity, unit_price, subtotal) VALUES
    (1, 1, 1, 1, 16000, 16000),
    (2, 1, 3, 2, 17000, 34000),
    (3, 1, 11, 1, 25000, 25000);

    -- CART_ITEM_OPTION_VALUES --
    INSERT INTO cart_item_option_values (id, cart_item_id, option_value_id) VALUES
    (1, 1, 1), (2, 1, 6),
    (3, 2, 2), (4, 2, 8),
    (5, 3, 14), (6, 3, 16);

    -- ORDERS --
    INSERT INTO orders (id, user_id, total_price, payment_status, status, packaging_fee_total, created_at, updated_at)
    VALUES
    (1, 1, 76000, 'unpaid', 'pending', 2000, NOW(), NOW());

    -- ORDER_ITEMS --
    INSERT INTO order_items (id, order_id, product_id, product_name, quantity, unit_price, subtotal, created_at)
    VALUES
    (1, 1, 1, 'Babi Crispy', 1, 16000, 16000, NOW()),
    (2, 1, 3, 'Kentang Spiral', 2, 17000, 34000, NOW()),
    (3, 1, 11, 'Rice Bowl Teriyaki', 1, 25000, 25000, NOW());

    -- ORDER_ITEM_OPTION_VALUES --
    INSERT INTO order_item_option_values (order_item_id, option_value_id) VALUES
    (1, 1), (1, 6),
    (2, 2), (2, 8),
    (3, 14), (3, 16);