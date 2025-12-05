<?php
session_start();
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $query = "SELECT * FROM users WHERE username = :username OR email = :username LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {

        if ($password === $user['password']) {

            // ¡CORREGIDO!
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["role"] = $user["role"];

            header("Location: /ta4/LP1/index.php");
            exit();

        } else {

            header("Location: /ta4/LP1/login.php?error=Contraseña incorrecta");
            exit();
        }

    } else {
        header("Location: /ta4/LP1/login.php?error=Usuario no encontrado");
        exit();
    }
}
