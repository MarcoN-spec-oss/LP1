<?php
// ajax/fetch_questions.php
require_once __DIR__ . '/../functions/post.php';
header('Content-Type: application/json');

$rows = list_questions(100);
echo json_encode(['ok'=>true,'data'=>$rows]);
