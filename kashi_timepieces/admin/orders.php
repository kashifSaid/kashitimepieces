<?php
$title="Orders"; require "_top.php";
if($_SERVER["REQUEST_METHOD"]==="POST"){ $pdo->prepare("UPDATE orders SET status=? WHERE id=?")->execute([$_POST["status"],(int)$_POST["id"]]); }
$orders=$pdo->query("SELECT o.*,u.name,u.email FROM orders o JOIN users u ON u.id=o.user_id ORDER BY o.created_at DESC")->fetchAll();
?>
<section class="panel"><h2>Customer Orders</h2><table><tr><th>Order</th><th>Customer</th><th>Products</th><th>Total</th><th>Date</th><th>Status</th></tr>
<?php foreach($orders as $o):$it=$pdo->prepare("SELECT product_name,quantity FROM order_items WHERE order_id=?");$it->execute([$o["id"]]);$items=$it->fetchAll();?><tr><td>#<?=$o["id"]?></td><td><?=htmlspecialchars($o["name"])?><br><small><?=htmlspecialchars($o["email"])?></small></td><td><?php foreach($items as $x)echo htmlspecialchars($x["product_name"])." × ".$x["quantity"]."<br>";?></td><td>Rs. <?=number_format($o["total_amount"])?></td><td><?=$o["created_at"]?></td><td><form method="post"><input type="hidden" name="id" value="<?=$o["id"]?>"><select name="status"><?php foreach(["placed","confirmed","completed","cancelled"] as $s):?><option <?=$o["status"]===$s?"selected":""?>><?=$s?></option><?php endforeach;?></select><button>Update</button></form></td></tr><?php endforeach;?></table></section>
<?php require "_bottom.php"; ?>
