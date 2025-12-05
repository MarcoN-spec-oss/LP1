<?php

require_once __DIR__ . '/../includes/db_connect.php';
session_start();

function register_user($username, $email, $password) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->fetch()) {
        return ['ok' => false, 'msg' => 'Usuario o email ya existe'];
    }

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $password]);
    return ['ok' => true, 'id' => $pdo->lastInsertId()];
}

function login_user($email, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if (!$user) return ['ok' => false, 'msg' => 'Credenciales inválidas'];
    if ($password === $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        return ['ok' => true];
    } else {
        return ['ok' => false, 'msg' => 'Credenciales inválidas'];
    }
}

function is_logged() {
    return isset($_SESSION['user_id']);
}

function current_user() {
    if (!is_logged()) return null;
    return ['id' => $_SESSION['user_id'], 'username' => $_SESSION['username']];
}

function logout() {
    session_start();
    session_unset();
    session_destroy();
}
