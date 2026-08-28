<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check_email = "SELECT id FROM user WHERE email = '$email'";
    $res = mysqli_query($conn, $check_email);

    if (mysqli_num_rows($res) > 0) {
        echo "<script>alert('Email already exists!'); window.location.href='index.php';</script>";
    } else {
        $sql = "INSERT INTO user (name, email, password) VALUES ('$name', '$email', '$password')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Account created successfully!'); window.location.href='index.php';</script>";
        } else {
            echo "Database Error: " . mysqli_error($conn);
        }
    }
} else {
    header("Location: index.php");
}
?>