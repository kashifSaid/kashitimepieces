<?php
require __DIR__ . "/../includes/db.php";
require __DIR__ . "/../includes/auth.php";

$method = $_SERVER["REQUEST_METHOD"];
$userId = requireLoginJson();

function cartData(PDO $pdo, int $userId): array {
    $stmt = $pdo->prepare("SELECT ci.product_id, ci.quantity, p.name,p.price,p.image,p.stock_quantity
                           FROM cart_items ci JOIN products p ON p.id=ci.product_id
                           WHERE ci.user_id=? AND p.is_active=1 ORDER BY ci.created_at DESC");
    $stmt->execute([$userId]);
    $items = $stmt->fetchAll();
    $total=0; $count=0;
    foreach($items as &$i){ $i["subtotal"]=(float)$i["price"]*(int)$i["quantity"]; $total+=$i["subtotal"]; $count+=(int)$i["quantity"]; }
    return ["items"=>$items,"total"=>$total,"count"=>$count];
}

if ($method === "GET") jsonResponse(["success"=>true,"cart"=>cartData($pdo,$userId)]);

$input = json_decode(file_get_contents("php://input"), true) ?: $_POST;
$action = $input["action"] ?? "";
$productId = (int)($input["product_id"] ?? 0);

if ($action === "add") {
    $p=$pdo->prepare("SELECT id,stock_quantity FROM products WHERE id=? AND is_active=1");
    $p->execute([$productId]); $product=$p->fetch();
    if(!$product) jsonResponse(["success"=>false,"message"=>"Product not found."],404);
    if((int)$product["stock_quantity"] < 1) jsonResponse(["success"=>false,"message"=>"This product is out of stock."],422);

    $q=$pdo->prepare("SELECT id,quantity FROM cart_items WHERE user_id=? AND product_id=?");
    $q->execute([$userId,$productId]); $existing=$q->fetch();
    if($existing){
        if((int)$existing["quantity"] >= (int)$product["stock_quantity"]) jsonResponse(["success"=>false,"message"=>"Maximum available stock reached."],422);
        $pdo->prepare("UPDATE cart_items SET quantity=quantity+1, updated_at=NOW() WHERE id=?")->execute([$existing["id"]]);
    } else {
        $pdo->prepare("INSERT INTO cart_items (user_id,product_id,quantity) VALUES (?,?,1)")->execute([$userId,$productId]);
    }
}
elseif ($action === "update") {
    $qty=max(0,(int)($input["quantity"]??0));
    if($qty<=0) $pdo->prepare("DELETE FROM cart_items WHERE user_id=? AND product_id=?")->execute([$userId,$productId]);
    else {
        $stock=$pdo->prepare("SELECT stock_quantity FROM products WHERE id=?"); $stock->execute([$productId]);
        $available=(int)($stock->fetchColumn()?:0);
        if($available < $qty) jsonResponse(["success"=>false,"message"=>"Requested quantity exceeds available stock."],422);
        $pdo->prepare("UPDATE cart_items SET quantity=?,updated_at=NOW() WHERE user_id=? AND product_id=?")->execute([$qty,$userId,$productId]);
    }
}
elseif ($action === "remove") {
    $pdo->prepare("DELETE FROM cart_items WHERE user_id=? AND product_id=?")->execute([$userId,$productId]);
} else jsonResponse(["success"=>false,"message"=>"Invalid action."],400);

jsonResponse(["success"=>true,"message"=>"Cart updated.","cart"=>cartData($pdo,$userId)]);
