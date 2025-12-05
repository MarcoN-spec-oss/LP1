<?php
session_start();
include "includes/db.php";

if (!isset($_SESSION['user_id'])) {
    die("Debes iniciar sesiÃ³n para votar.");
}

if (!isset($_POST['answer_id']) || !isset($_POST['vote'])) {
    die("Datos incompletos.");
}

$user_id = intval($_SESSION['user_id']);
$answer_id = intval($_POST['answer_id']);
$vote = intval($_POST['vote']);

$sql = "SELECT id FROM votes WHERE user_id = $user_id AND answer_id = $answer_id";
$res = $conn->query($sql);

if ($res->num_rows > 0) {

    $sql2 = "UPDATE votes SET vote = $vote, created_at = NOW()
             WHERE user_id = $user_id AND answer_id = $answer_id";

    if ($conn->query($sql2)) {
        echo "Voto actualizado";
    } else {
        echo "Error: " . $conn->error;
    }

} else {

    $sql3 = "INSERT INTO votes (answer_id, user_id, vote)
             VALUES ($answer_id, $user_id, $vote)";

    if ($conn->query($sql3)) {
        echo "Voto registrado";
    } else {
        echo "Error: " . $conn->error;
    }
}

?>