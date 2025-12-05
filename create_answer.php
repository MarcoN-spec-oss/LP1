<?php
session_start();
include "includes/db.php";

if (!isset($_SESSION['user_id'])) {
    die("Debes iniciar sesión.");
}

$texto = $_POST['texto'];
$idP = $_POST['question_id'];
$user_id = $_SESSION['user_id'];

$sql = "INSERT INTO answers (question_id, user_id, answer)
        VALUES ($idP, $user_id, '$texto')";

$conn->query($sql);

header("Location: index.php");
?>
