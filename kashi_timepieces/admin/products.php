<?php
$title="Product Management"; require "_top.php";
$msg="";
if($_SERVER["REQUEST_METHOD"]==="POST"){
 $action=$_POST["action"]??""; $id=(int)($_POST["id"]??0);
 if($action==="delete"){ $pdo->prepare("UPDATE products SET is_active=0 WHERE id=?")->execute([$id]); $msg="Product deleted."; }
 else{
  $name=trim($_POST["name"]??"");$desc=trim($_POST["description"]??"");$price=(float)($_POST["price"]??0);$cat=trim($_POST["category"]??"");$type=trim($_POST["type"]??"");$stock=(int)($_POST["stock_quantity"]??0);$image=trim($_POST["image"]??"");
  if($name!==""&&$price>=0){
   if($action==="add")$pdo->prepare("INSERT INTO products(name,description,price,image,category,type,stock_quantity) VALUES(?,?,?,?,?,?,?)")->execute([$name,$desc,$price,$image,$cat,$type,$stock]);
   if($action==="edit")$pdo->prepare("UPDATE products SET name=?,description=?,price=?,image=?,category=?,type=?,stock_quantity=? WHERE id=?")->execute([$name,$desc,$price,$image,$cat,$type,$stock,$id]);
   $msg="Product saved.";
  }
 }
}
$edit=null;if(isset($_GET["edit"])){$s=$pdo->prepare("SELECT * FROM products WHERE id=?");$s->execute([(int)$_GET["edit"]]);$edit=$s->fetch();}
$products=$pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
?>
<?php if($msg):?><div class="success"><?=$msg?></div><?php endif;?>
<section class="panel"><h2><?=$edit?"Edit Product":"Add Product"?></h2><form method="post" class="form-grid">
<input type="hidden" name="action" value="<?=$edit?"edit":"add"?>"><input type="hidden" name="id" value="<?=$edit["id"]??""?>">
<input name="name" placeholder="Product Name" required value="<?=htmlspecialchars($edit["name"]??"")?>">
<input name="price" type="number" step="0.01" placeholder="Price" required value="<?=$edit["price"]??""?>">
<input name="category" placeholder="Category (men/women)" value="<?=htmlspecialchars($edit["category"]??"men")?>">
<input name="type" placeholder="Type (classic/sport)" value="<?=htmlspecialchars($edit["type"]??"classic")?>">
<input name="stock_quantity" type="number" min="0" placeholder="Stock" value="<?=$edit["stock_quantity"]??0?>">
<input name="image" placeholder="Image URL" value="<?=htmlspecialchars($edit["image"]??"")?>">
<textarea name="description" placeholder="Description"><?=htmlspecialchars($edit["description"]??"")?></textarea><button>Save Product</button></form></section>
<section class="panel"><h2>All Products</h2><table><tr><th>ID</th><th>Name</th><th>Price</th><th>Stock</th><th>Status</th><th>Actions</th></tr>
<?php foreach($products as $p):?><tr><td><?=$p["id"]?></td><td><?=htmlspecialchars($p["name"])?></td><td>Rs. <?=number_format($p["price"])?></td><td><?=$p["stock_quantity"]?></td><td><?=$p["is_active"]?"Active":"Deleted"?></td><td><a class="btn" href="?edit=<?=$p["id"]?>">Edit</a><form class="inline" method="post"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?=$p["id"]?>"><button class="danger" onclick="return confirm('Delete this product?')">Delete</button></form></td></tr><?php endforeach;?></table></section>
<?php require "_bottom.php"; ?>
