<?php require __DIR__ . "/../includes/db.php"; require __DIR__ . "/../includes/auth.php"; requireAdmin(); ?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= htmlspecialchars($title ?? "KASHI Admin") ?></title><link rel="stylesheet" href="admin.css"></head><body>
<aside><h2>KASHI<span> ADMIN</span></h2><a href="index.php">Dashboard</a><a href="products.php">Products</a><a href="users.php">Users</a><a href="orders.php">Orders</a><a href="../index.php">View Store</a><a href="logout.php">Logout</a></aside><main><header><h1><?= htmlspecialchars($title ?? "Dashboard") ?></h1><span><?= htmlspecialchars($_SESSION["admin_email"] ?? "") ?></span></header>
