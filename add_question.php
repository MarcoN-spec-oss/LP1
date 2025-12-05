<?php
include __DIR__ . '/includes/db.php';

if(isset($_POST['title'], $_POST['description'], $_POST['user_id'])){
    echo "Datos recibidos:<br>";
    var_dump($_POST);

    $stmt = $pdo->prepare("INSERT INTO questions (title, description, user_id, created_at) VALUES (?, ?, ?, NOW())");
    $result = $stmt->execute([$_POST['title'], $_POST['description'], $_POST['user_id']]);

    echo $result ? "INSERT OK" : "INSERT FAIL";
    exit;
}
exit; 
