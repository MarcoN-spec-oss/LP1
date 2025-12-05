<?php

require_once __DIR__ . '/../functions/auth.php';
require_once __DIR__ . '/../functions/post.php';
header('Content-Type: application/json');
if (!is_logged()) { echo json_encode(['ok'=>false,'msg'=>'No autorizado']); exit; }

$input = json_decode(file_get_contents('php://input'), true);
$question_id = intval($input['question_id'] ?? 0);
$answer = trim($input['answer'] ?? '');
if ($question_id <= 0 || $answer === '') {
    echo json_encode(['ok'=>false,'msg'=>'Faltan campos']); exit;
}
$user = current_user();
$id = create_answer($question_id, $user['id'], $answer);
echo json_encode(['ok'=>true,'id'=>$id]);
