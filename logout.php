<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logging Out</title>
</head>
<body>
    <script>
        localStorage.clear();
        sessionStorage.clear();
        alert('Logged out successfully!');
        window.location.href = 'index.php';
    </script>
</body>
</html>