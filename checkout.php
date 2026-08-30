<?php
require __DIR__ . "/../includes/db.php";
require __DIR__ . "/../includes/auth.php";
$userId = requireLoginJson();

try {
    $pdo->beginTransaction();
    $stmt=$pdo->prepare("SELECT ci.product_id,ci.quantity,p.name,p.price,p.stock_quantity
                         FROM cart_items ci JOIN products p ON p.id=ci.product_id
                         WHERE ci.user_id=? FOR UPDATE");
    $stmt->execute([$userId]); $items=$stmt->fetchAll();
    if(!$items) throw new Exception("Your cart is empty.");

    $total=0;
    foreach($items as $item){
        if((int)$item["stock_quantity"] < (int)$item["quantity"])
            throw new Exception($item["name"]." no longer has enough stock.");
        $total += (float)$item["price"]*(int)$item["quantity"];
    }

    $pdo->prepare("INSERT INTO orders (user_id,total_amount,status) VALUES (?,?,'placed')")->execute([$userId,$total]);
    $orderId=(int)$pdo->lastInsertId();

    $itemInsert=$pdo->prepare("INSERT INTO order_items (order_id,product_id,product_name,product_price,quantity,subtotal) VALUES (?,?,?,?,?,?)");
    $stockUpdate=$pdo->prepare("UPDATE products SET stock_quantity=stock_quantity-? WHERE id=?");
    foreach($items as $item){
        $subtotal=(float)$item["price"]*(int)$item["quantity"];
        $itemInsert->execute([$orderId,$item["product_id"],$item["name"],$item["price"],$item["quantity"],$subtotal]);
        $stockUpdate->execute([$item["quantity"],$item["product_id"]]);
    }
    $pdo->prepare("DELETE FROM cart_items WHERE user_id=?")->execute([$userId]);
    $pdo->commit();
    jsonResponse(["success"=>true,"message"=>"Order placed successfully!","order_id"=>$orderId]);
} catch(Throwable $e){
    if($pdo->inTransaction()) $pdo->rollBack();
    jsonResponse(["success"=>false,"message"=>$e->getMessage()],422);
}
