<?php
require_once __DIR__ . "/includes/db.php";

header('Content-Type: application/json');

if (!isset($_POST['content'], $_POST['question_id'])) {
    echo json_encode(["success" => false, "msg" => "Faltan parámetros"]);
    exit;
}

$content = trim($_POST['content']);
$question_id = intval($_POST['question_id']);
$user_id = 1; // usuario fijo temporal

// Verificar que la pregunta exista
$stmt = $pdo->prepare("SELECT id FROM questions WHERE id = ?");
$stmt->execute([$question_id]);

if (!$stmt->fetch()) {
    echo json_encode(["success" => false, "msg" => "Pregunta no existe"]);
    exit;
}

// Insertar respuesta
$stmt = $pdo->prepare("INSERT INTO answers (question_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())");
$ok = $stmt->execute([$question_id, $user_id, $content]);

echo json_encode(["success" => $ok, "error" => $stmt->errorInfo()]);

exit;
?>
