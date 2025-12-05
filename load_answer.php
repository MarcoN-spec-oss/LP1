<?php
include "includes/db.php";

$idPregunta = $_GET['id'];

$sql = "
SELECT a.*, u.username
FROM answers a
JOIN users u ON a.user_id = u.id
WHERE question_id = $idPregunta
ORDER BY a.created_at ASC
";

$res = $conn->query($sql);

echo "<h4>Respuestas:</h4>";

while ($row = $res->fetch_assoc()):
?>

<div style='margin-left:20px; border-left:2px solid #aaa; padding-left:10px; margin-bottom:10px;'>
    <p><?= $row['answer'] ?></p>
    <small>Por: <?= $row['username'] ?> | Fecha: <?= $row['created_at'] ?></small>
</div>

<?php endwhile; ?>

<?php
if (isset($_SESSION['user_id'])) {

echo "
<form method='POST' action='create_answer.php'>
    <input type='hidden' name='question_id' value='$idPregunta'>
    <textarea name='texto' placeholder='Responder...' required></textarea><br>
    <button type='submit'>Enviar respuesta</button>
</form>
";

} else {
    echo "<p>Inicia sesión para responder.</p>";
}
?>
