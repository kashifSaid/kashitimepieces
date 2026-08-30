<?php
if (session_status() === PHP_SESSION_NONE) session_start();

function jsonResponse(array $data, int $code = 200): never {
    http_response_code($code);
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode($data);
    exit;
}
function requireLoginJson(): int {
    if (empty($_SESSION["user_id"])) jsonResponse(["success"=>false,"message"=>"Please sign in first."], 401);
    return (int)$_SESSION["user_id"];
}
function requireAdmin(): void {
    if (empty($_SESSION["admin_logged_in"])) {
        header("Location: login.php");
        exit;
    }
}
function redirectWithMessage(string $url, string $message): never {
    $_SESSION["flash"] = $message;
    header("Location: $url");
    exit;
}
