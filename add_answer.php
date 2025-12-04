<?php
include __DIR__ . '/includes/db.php';

if(isset($_POST['question_id'], $_POST['content'])){
    $stmt = $pdo->prepare("INSERT INTO answers (question_id, content, votes, created_at) VALUES (?, ?, 0, NOW())");
    $stmt->execute([$_POST['question_id'], $_POST['content']]);
    echo json_encode(['success'=>true]);
}else{
    echo json_encode(['success'=>false]);
}
