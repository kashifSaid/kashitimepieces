KASHI TIMEPIECES - XAMPP INSTALLATION

1. Put the complete folder "kashi_timepieces" inside:
   C:\xampp\htdocs\

2. Start Apache and MySQL from XAMPP Control Panel.

3. Open:
   http://localhost/phpmyadmin

4. Click Import > Choose File > select database.sql from this project.

5. Click Import/Go.

6. Open:
   http://localhost/kashi_timepieces/

ADMIN LOGIN
URL:
http://localhost/kashi_timepieces/admin/login.php

Default credentials:
Email: admin@kashitimepieces.com
Password: Admin@123

To change admin credentials, edit:
includes/admin_config.php

DATABASE CONNECTION
Edit includes/db.php if your MySQL username/password are different.

IMPORTANT
The frontend keeps the original CSS/design. Products are now loaded dynamically from MySQL.
Cart belongs to the logged-in user and is stored in MySQL.
Checkout creates orders and order_items and reduces stock.

============================================
UPDATE - LATEST CHANGES
============================================
1. An "Admin" link is now visible on the main site navbar (top right) that
   opens the admin login page (admin/login.php). Admin login already
   required a fixed email + password (see includes/admin_config.php) -
   this was already secure, it just wasn't linked from the homepage.

2. Every product card on the homepage now shows a live stock badge:
   "In Stock" (green), "Only X left" (yellow, when stock <= 5), or
   "Out of Stock" (red). This comes directly from stock_quantity in the
   database, which the admin controls from admin/products.php. The
   "Add to Cart" button is automatically disabled when stock is 0.

3. The Search button/overlay has been removed from the site completely
   (navbar button, search box, and related JavaScript).

4. Fixed a bug in the category/type filters (Men/Women/Classic/Sport) -
   they were not matching because of uppercase/lowercase mismatch. This
   is now fixed and filtering works correctly.

5. Fixed a checkout bug where placing an order would fail because the
   code was inserting into a column named "price" that does not exist
   in order_items (the real column is "product_price").

6. Added 6 new watches to the catalog, including dedicated Women's
   Sport and Men's Sport watches (Active Rose, Pulse Pink, Trail
   Blazer, Marathon Steel, Pearl Whisper, Titan Forge).

IF YOU ALREADY HAVE THE DATABASE SET UP:
Do not re-import database.sql (it will error out on existing tables).
Instead, open phpMyAdmin > kashi_timepieces > SQL tab, and run the file
add_new_watches.sql to add only the new watches.

IF YOU ARE SETTING UP FRESH:
Just import database.sql as before - it already includes the new
watches.
