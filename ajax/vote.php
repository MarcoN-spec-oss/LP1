<?php
// ajax/vote.php
require_once __DIR__ . '/../functions/auth.php';
require_once __DIR__ . '/../functions/vote.php';
header('Content-Type: application/json');
if (!is_logged()) { echo json_encode(['ok'=>false,'msg'=>'No autorizado']); exit; }

$input = json_decode(file_get_contents('php://input'), true);
$answer_id = intval($input['answer_id'] ?? 0);
$vote = isset($input['vote']) ? intval($input['vote']) : null;
if ($answer_id <= 0 || ($vote !== 0 && $vote !== 1)) {
    echo json_encode(['ok'=>false,'msg'=>'Datos inválidos']); exit;
}
$user = current_user();
$res = cast_vote($answer_id, $user['id'], $vote);
echo json_encode($res);
