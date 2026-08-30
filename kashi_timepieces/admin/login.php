<?php
session_start();
require __DIR__ . "/../includes/admin_config.php";
$error="";
if($_SERVER["REQUEST_METHOD"]==="POST"){
 $email=strtolower(trim($_POST["email"]??"")); $password=$_POST["password"]??"";
 if($email===strtolower(ADMIN_EMAIL) && hash_equals(ADMIN_PASSWORD,$password)){
   session_regenerate_id(true); $_SESSION["admin_logged_in"]=true; $_SESSION["admin_email"]=ADMIN_EMAIL;
   header("Location: index.php"); exit;
 }
 $error="Invalid admin email or password.";
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Admin Login</title><link rel="stylesheet" href="admin.css"></head>
<body class="admin-login"><form method="post" class="login-card"><h1>KASHI Admin</h1><p>Secure administrator access</p>
<?php if($error): ?><div class="error"><?=htmlspecialchars($error)?></div><?php endif;?>
<input type="email" name="email" placeholder="Admin email" required><input type="password" name="password" placeholder="Password" required><button>Sign In</button><a href="../index.php">← Back to Store</a></form></body></html>
