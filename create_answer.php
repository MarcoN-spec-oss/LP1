<?php
session_start();
include "includes/db.php";

if (!isset($_SESSION['user_id'])) {
    die("Debes iniciar sesión.");
}

$texto = $_POST['respuesta'];
$question_id = $_POST['question_id'];
$user_id = $_SESSION['user_id'];

$sql = "INSERT INTO answers (question_id, user_id, answer)
        VALUES ($question_id, $user_id, '$texto')";

if ($conn->query($sql)) {
    echo "Respuesta enviada.";
} else {
    echo "Error: " . $conn->error;
}
?>
