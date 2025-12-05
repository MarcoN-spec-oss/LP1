<?php

require_once __DIR__ . '/../includes/db_connect.php';

function create_question($user_id, $title, $description) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO questions (user_id, title, description) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $title, $description]);
    return $pdo->lastInsertId();
}

function create_answer($question_id, $user_id, $answer) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO answers (question_id, user_id, answer) VALUES (?, ?, ?)");
    $stmt->execute([$question_id, $user_id, $answer]);
    return $pdo->lastInsertId();
}


function list_questions($limit = 50) {
    global $pdo;
    $stmt = $pdo->query("
        SELECT q.id, q.title, q.description, q.created_at, u.username,
            (SELECT COUNT(*) FROM answers a WHERE a.question_id = q.id) AS answers_count
        FROM questions q
        JOIN users u ON u.id = q.user_id
        ORDER BY q.created_at DESC
        LIMIT " . intval($limit));
    return $stmt->fetchAll();
}

function list_answers_by_question($question_id) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT a.id, a.answer, a.created_at, u.username,
          COALESCE((SELECT SUM(CASE WHEN v.vote=1 THEN 1 WHEN v.vote=0 THEN -1 ELSE 0 END) FROM votes v WHERE v.answer_id = a.id),0) as score
        FROM answers a
        JOIN users u ON u.id = a.user_id
        WHERE a.question_id = ?
        ORDER BY score DESC, a.created_at ASC
    ");
    $stmt->execute([$question_id]);
    return $stmt->fetchAll();
}
