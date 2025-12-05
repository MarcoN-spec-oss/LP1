<?php
session_start();
include "includes/db.php";

if (!isset($_SESSION['user_id'])) {
    die("Debes iniciar sesión para votar.");
}

$user_id = $_SESSION['user_id'];
$answer_id = $_POST['answer_id'];
$vote = $_POST['vote'];

$sql = "SELECT * FROM votes WHERE user_id=$user_id AND answer_id=$answer_id";
$res = $conn->query($sql);

if ($res->num_rows > 0) {
    $sql2 = "UPDATE votes SET vote=$vote WHERE user_id=$user_id AND answer_id=$answer_id";
    $conn->query($sql2);
    echo "Voto actualizado.";
} else {
    $sql3 = "INSERT INTO votes (answer_id, user_id, vote)
             VALUES ($answer_id, $user_id, $vote)";
    $conn->query($sql3);
    echo "Voto registrado.";
}
?>
