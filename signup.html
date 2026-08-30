<?php
require __DIR__ . "/includes/db.php";
require __DIR__ . "/includes/auth.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") jsonResponse(["success"=>false,"message"=>"Invalid request."], 405);

$name = trim($_POST["name"] ?? "");
$email = strtolower(trim($_POST["email"] ?? ""));
$password = $_POST["password"] ?? "";
$confirm = $_POST["confirm_password"] ?? "";

if ($name === "" || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6)
    jsonResponse(["success"=>false,"message"=>"Please enter valid account details. Password must be at least 6 characters."], 422);
if ($password !== $confirm)
    jsonResponse(["success"=>false,"message"=>"Passwords do not match."], 422);

$check = $pdo->prepare("SELECT id FROM users WHERE email=? LIMIT 1");
$check->execute([$email]);
if ($check->fetch()) jsonResponse(["success"=>false,"message"=>"This email is already registered. Please sign in."], 409);

$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
$stmt->execute([$name,$email,$hash]);

$_SESSION["user_id"] = (int)$pdo->lastInsertId();
$_SESSION["user_name"] = $name;
jsonResponse(["success"=>true,"message"=>"Account created successfully.","user"=>["name"=>$name]]);
