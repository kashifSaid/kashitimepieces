<?php
require __DIR__ . "/../includes/db.php";
require __DIR__ . "/../includes/auth.php";
$data=json_decode(file_get_contents("php://input"),true) ?: $_POST;
$email=strtolower(trim($data["email"]??""));
if(!filter_var($email,FILTER_VALIDATE_EMAIL)) jsonResponse(["success"=>false,"message"=>"Enter a valid email."],422);
$stmt=$pdo->prepare("INSERT INTO newsletter_subscribers (email) VALUES (?) ON DUPLICATE KEY UPDATE subscribed_at=NOW()");
$stmt->execute([$email]);
jsonResponse(["success"=>true,"message"=>"Thank you for subscribing."]);
