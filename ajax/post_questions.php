<?php

require_once __DIR__ . '/../functions/auth.php';
require_once __DIR__ . '/../functions/post.php';

header('Content-Type: application/json');
if (!is_logged()) { echo json_encode(['ok'=>false,'msg'=>'No autorizado']); exit; }

$input = json_decode(file_get_contents('php://input'), true);
$title = trim($input['title'] ?? '');
$description = trim($input['description'] ?? '');
if ($title === '' || $description === '') {
    echo json_encode(['ok'=>false,'msg'=>'Faltan campos']); exit;
}
$user = current_user();
$id = create_question($user['id'], $title, $description);
echo json_encode(['ok'=>true,'id'=>$id]);
