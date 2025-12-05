<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']); // SIN HASH

    // Validar si existe usuario
    $check = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
    $check->execute([
        ':username' => $username,
        ':email'    => $email
    ]);

    if ($check->rowCount() > 0) {
        header("Location: register.php?error=El usuario o email ya existe");
        exit();
    }

    // Insertar usuario nuevo
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role, created_at) 
                           VALUES (:username, :email, :password, 'user', NOW())");

    $stmt->execute([
        ':username' => $username,
        ':email'    => $email,
        ':password' => $password  // SIN HASH
    ]);

    header("Location: register.php?success=Usuario registrado correctamente. Ahora puedes iniciar sesión.");
    exit();
}
