<?php

require_once __DIR__ . '/../functions/post.php';
header('Content-Type: application/json');
$question_id = intval($_GET['question_id'] ?? 0);
if ($question_id <= 0) { echo json_encode(['ok'=>false,'msg'=>'question_id required']); exit; }
$rows = list_answers_by_question($question_id);
echo json_encode(['ok'=>true,'data'=>$rows]);
