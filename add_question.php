<?php
session_start();
include __DIR__ . '/includes/db.php';

if (!isset($_SESSION["user_id"])) {
    echo "ERROR: No estás logueado";
    exit;
}

if (isset($_POST['title'], $_POST['description'])) {

    $user_id = $_SESSION['user_id']; // ← AHORA VIENE DE LA SESIÓN

    echo "Datos recibidos:<br>";
    var_dump($_POST);
    echo "<br>USER ID de sesión: " . $user_id . "<br>";

    $stmt = $pdo->prepare("
        INSERT INTO questions (title, description, user_id, created_at)
        VALUES (?, ?, ?, NOW())
    ");

    $result = $stmt->execute([
        $_POST['title'],
        $_POST['description'],
        $user_id
    ]);

    echo $result ? "INSERT OK" : "INSERT FAIL";
    exit;
}

exit;
