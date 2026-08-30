<?php
$title="Dashboard"; require "_top.php";
$stats=[];
$stats["users"]=(int)$pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$stats["products"]=(int)$pdo->query("SELECT COUNT(*) FROM products WHERE is_active=1")->fetchColumn();
$stats["orders"]=(int)$pdo->query("SELECT COUNT(*) FROM orders WHERE status IN ('placed','confirmed','completed')")->fetchColumn();
$stats["revenue"]=(float)$pdo->query("SELECT COALESCE(SUM(total_amount),0) FROM orders WHERE status IN ('placed','confirmed','completed')")->fetchColumn();
$stats["today"]=(float)$pdo->query("SELECT COALESCE(SUM(total_amount),0) FROM orders WHERE status IN ('placed','confirmed','completed') AND DATE(created_at)=CURDATE()")->fetchColumn();
$stats["month"]=(float)$pdo->query("SELECT COALESCE(SUM(total_amount),0) FROM orders WHERE status IN ('placed','confirmed','completed') AND YEAR(created_at)=YEAR(CURDATE()) AND MONTH(created_at)=MONTH(CURDATE())")->fetchColumn();
$recent=$pdo->query("SELECT o.*,u.name FROM orders o JOIN users u ON u.id=o.user_id ORDER BY o.created_at DESC LIMIT 8")->fetchAll();
$best=$pdo->query("SELECT product_name,SUM(quantity) qty FROM order_items oi JOIN orders o ON o.id=oi.order_id WHERE o.status IN ('placed','confirmed','completed') GROUP BY product_name ORDER BY qty DESC LIMIT 5")->fetchAll();
?>
<div class="stats">
<?php foreach(["Total Users"=>$stats["users"],"Total Products"=>$stats["products"],"Total Orders"=>$stats["orders"],"Total Revenue"=>"Rs. ".number_format($stats["revenue"]),"Today's Revenue"=>"Rs. ".number_format($stats["today"]),"Monthly Revenue"=>"Rs. ".number_format($stats["month"])] as $k=>$v):?><div class="stat"><small><?=$k?></small><strong><?=$v?></strong></div><?php endforeach;?></div>
<div class="grid2"><section class="panel"><h2>Recent Orders</h2><table><tr><th>ID</th><th>Customer</th><th>Total</th><th>Status</th></tr><?php foreach($recent as $o):?><tr><td>#<?=$o["id"]?></td><td><?=htmlspecialchars($o["name"])?></td><td>Rs. <?=number_format($o["total_amount"])?></td><td><span class="badge"><?=$o["status"]?></span></td></tr><?php endforeach;?></table></section>
<section class="panel"><h2>Best Selling Products</h2><table><tr><th>Product</th><th>Sold</th></tr><?php foreach($best as $b):?><tr><td><?=htmlspecialchars($b["product_name"])?></td><td><?=$b["qty"]?></td></tr><?php endforeach;?></table></section></div>
<?php require "_bottom.php"; ?>
