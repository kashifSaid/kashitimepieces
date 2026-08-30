<?php
require __DIR__ . "/includes/db.php";
require __DIR__ . "/includes/auth.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") jsonResponse(["success"=>false,"message"=>"Invalid request."], 405);

$email = strtolower(trim($_POST["email"] ?? ""));
$password = $_POST["password"] ?? "";

$stmt = $pdo->prepare("SELECT id,name,email,password FROM users WHERE email=? LIMIT 1");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user) jsonResponse(["success"=>false,"message"=>"Account not found. Please create an account first."], 404);
if (!password_verify($password, $user["password"]))
    jsonResponse(["success"=>false,"message"=>"Invalid email or password."], 401);

$_SESSION["user_id"] = (int)$user["id"];
$_SESSION["user_name"] = $user["name"];
jsonResponse(["success"=>true,"message"=>"Welcome back, ".$user["name"]."!", "user"=>["name"=>$user["name"]]]);
