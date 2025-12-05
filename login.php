<?php
session_start();
include "includes/db.php";

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
$res = $conn->query($sql);

if ($res->num_rows == 1) {
    $user = $res->fetch_assoc();

    $_SESSION['user_id'] = $user['id'];       
    $_SESSION['username'] = $user['username'];

    header("Location: index.php");
} else {
    echo "Correo o contraseña incorrectos";
}
?>
