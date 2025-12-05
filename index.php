<?php
include __DIR__ . '/includes/db.php';
include __DIR__ . '/includes/header.php';

$stmt = $pdo->query("SELECT * FROM questions ORDER BY created_at DESC");
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Mi Foro de Preguntas</h1>

<h2>Agregar Pregunta</h2>
<form id="questionForm">
    <input type="hidden" name="user_id" value="1">
    <input type="text" name="title" placeholder="Titulo" required><br>
    <textarea name="description" placeholder="Descripcion" required></textarea><br>
    <button type="submit">Agregar Pregunta</button>
</form>

<hr>

<h2>Preguntas Recientes</h2>
<div id="questionsList">
    <?php foreach($questions as $q): ?>
        <div class="question">
            <a href="question.php?id=<?= $q['id'] ?>"><?= htmlspecialchars($q['title']) ?></a>
            <p><?= nl2br(htmlspecialchars($q['description'])) ?></p>
            <small>Fecha: <?= $q['created_at'] ?></small>
        </div>
    <?php endforeach; ?>
</div>

<script src="assets/js/main.js"></script>
<?php include __DIR__ . '/includes/footer.php'; ?>
