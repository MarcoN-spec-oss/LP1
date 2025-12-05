<?php
session_start();
include "includes/db.php";

if (!isset($_GET['id'])) {
    die("Error: no se recibió el ID de la pregunta.");
}

$question_id = intval($_GET['id']);

$sql = "
SELECT a.*, u.username,
    (SELECT COALESCE(SUM(CASE WHEN vote = 1 THEN 1 WHEN vote = 0 THEN -1 END),0)
     FROM votes WHERE answer_id = a.id) AS votos
FROM answers a
JOIN users u ON a.user_id = u.id
WHERE a.question_id = $question_id
ORDER BY a.created_at ASC
";

$result = $conn->query($sql);

echo "<h4>Respuestas:</h4>";

if ($result->num_rows == 0) {
    echo "<p>No hay respuestas todavía.</p>";
}

while ($row = $result->fetch_assoc()):
?>
<div class="answer-box">

    <p><?= $row['answer'] ?></p>

    <small class="answer-meta">
        Por <?= $row['username'] ?> | <?= $row['created_at'] ?>
    </small><br><br>

    <?php if (isset($_SESSION['user_id'])): ?>
        <button class="btn-like" onclick="votar(<?= $row['id'] ?>, 1)">👍 Like</button>
        <button class="btn-dislike" onclick="votar(<?= $row['id'] ?>, 0)">👎 Dislike</button>
        <b class="vote-count"><?= $row['votos'] ?> votos</b>
    <?php else: ?>
        <p>Inicia sesión para votar.</p>
    <?php endif; ?>

</div>
<?php endwhile; ?>

<script>
function votar(idRespuesta, tipoVoto){
    $.post("vote.php", {
        answer_id: idRespuesta,
        vote: tipoVoto
    }, function(r){
        alert(r);
        $("#respuestas-<?= $question_id ?>").load("load_answer.php?id=<?= $question_id ?>");
    });
}
</script>
