<?php
session_start();
include "includes/db.php";

if (!isset($_SESSION['user_id'])) {
    die("Debes iniciar sesión.");
}

$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$user_id = $_SESSION['user_id'];

$sql = "INSERT INTO questions (user_id, title, description)
        VALUES ($user_id, '$titulo', '$descripcion')";

if ($conn->query($sql)) {
    echo "Pregunta publicada correctamente.";
} else {
    echo "Error: " . $conn->error;
}
?>
