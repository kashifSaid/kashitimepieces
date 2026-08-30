<?php
require __DIR__ . "/../includes/db.php";
header("Content-Type: application/json; charset=utf-8");
$stmt = $pdo->query("SELECT id,name,description,price,image,category,type,stock_quantity,created_at FROM products WHERE is_active=1 ORDER BY id DESC");
echo json_encode(["success"=>true,"products"=>$stmt->fetchAll()]);
