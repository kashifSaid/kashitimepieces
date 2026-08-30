<?php
require __DIR__ . "/../includes/db.php";
require __DIR__ . "/../includes/auth.php";
$data=json_decode(file_get_contents("php://input"),true) ?: $_POST;
$name=trim($data["name"]??""); $email=trim($data["email"]??"");
$subject=trim($data["subject"]??""); $message=trim($data["message"]??"");
if($name===""||!filter_var($email,FILTER_VALIDATE_EMAIL)||$subject===""||$message==="")
 jsonResponse(["success"=>false,"message"=>"Please fill all complaint fields."],422);
$uid=$_SESSION["user_id"]??null;
$pdo->prepare("INSERT INTO complaints (user_id,name,email,subject,message) VALUES (?,?,?,?,?)")->execute([$uid,$name,$email,$subject,$message]);
jsonResponse(["success"=>true,"message"=>"Your complaint has been submitted."]);
