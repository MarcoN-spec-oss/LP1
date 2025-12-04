<?php
include __DIR__ . '/includes/db.php';

if(isset($_POST['title'], $_POST['description'])){
    $stmt = $pdo->prepare("INSERT INTO questions (title, description, created_at) VALUES (?, ?, NOW())");
    $stmt->execute([$_POST['title'], $_POST['description']]);
    echo json_encode(['success'=>true]);
} else {
    echo json_encode(['success'=>false]);
}
