

<?php
require_once "includes/db.php"; 

$id = $_GET['id'] ?? 0;
$id = intval($id);

// Obtener pregunta
$stmt = $pdo->prepare("SELECT * FROM questions WHERE id = ?");
$stmt->execute([$id]);
$question = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$question) {
    echo "<h2>La pregunta no existe.</h2>";
    exit;
}

// Obtener respuestas
$stmt2 = $pdo->prepare("SELECT * FROM answers WHERE question_id = ? ORDER BY created_at ASC");
$stmt2->execute([$id]);
$answers = $stmt2->fetchAll(PDO::FETCH_ASSOC);

include "includes/header.php";
?>

<h1><?= htmlspecialchars($question['title']) ?></h1>
<p><?= nl2br(htmlspecialchars($question['description'])) ?></p>

<hr>

<h2>Respuestas</h2>
<div id="answersList">
    <?php foreach($answers as $a): ?>
        <div class="answer">
            <p><?= nl2br(htmlspecialchars($a['content'])) ?></p>
        </div>
    <?php endforeach; ?>
</div>

<h3>Agregar Respuesta</h3>

<form id="answerForm">
    <textarea name="content" placeholder="Escribe tu respuesta..." required></textarea><br>
    <input type="hidden" name="question_id" value="<?= $question['id'] ?>">
    <button type="submit">Responder</button>
</form>





<script src="assets/js/main.js"></script>
<?php include "includes/footer.php"; ?>
