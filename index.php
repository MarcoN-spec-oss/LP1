<?php
session_start();
include "includes/db.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Foro de Preguntas</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<?php include "includes/header.php"; ?>

<div class="page-container">

<?php if (isset($_SESSION['user_id'])): ?>
<section>
    <h2 class="center-title">Crear Pregunta</h2>

    <form id="formPregunta">
        <input type="text" name="titulo" placeholder="Título" required><br><br>
        <textarea name="descripcion" placeholder="Descripción..." required></textarea><br><br>
        <button type="submit">Publicar Pregunta</button>
    </form>

    <p id="msg"></p>
</section>
<?php endif; ?>

<h2 class="center-title">Preguntas Recientes</h2>

<?php
$sql = "
    SELECT q.id, q.title, q.description, q.created_at,
           u.username
    FROM questions q
    JOIN users u ON q.user_id = u.id
    ORDER BY q.created_at DESC
";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()):
?>

<div class="pregunta-card">

    <h3><?= $row['title'] ?></h3>
    <p><?= $row['description'] ?></p>

    <small>Por: <?= $row['username'] ?> | Fecha: <?= $row['created_at'] ?></small>

    <br><br>

    <button class="verRespuestas" data-id="<?= $row['id'] ?>">Ver respuestas</button>

    <br><br>

    <?php if (isset($_SESSION['user_id'])): ?>
        <button class="btnMostrarForm" data-id="<?= $row['id'] ?>">Responder a esta pregunta</button>

        <div class="form-respuesta" id="formResp-<?= $row['id'] ?>">
            <textarea id="respuesta-<?= $row['id'] ?>" placeholder="Escribe tu respuesta..." class="textarea-respuesta"></textarea>
            <button class="btnEnviarRespuesta" data-id="<?= $row['id'] ?>">Enviar respuesta</button>
            <p id="msgResp-<?= $row['id'] ?>"></p>
        </div>
    <?php endif; ?>

    <div class="contenedor-respuestas" id="respuestas-<?= $row['id'] ?>"></div>

</div>

<?php endwhile; ?>

</div>

<?php include "includes/footer.php"; ?>

<script>
$("#formPregunta").on("submit", function(e){
    e.preventDefault();
    $.post("create_question.php", $(this).serialize(), function(res){
        $("#msg").html(res);
        setTimeout(()=>{ location.reload(); }, 1500);
    });
});

$(".verRespuestas").on("click", function(){
    let id = $(this).data("id");
    $("#respuestas-"+id).load("load_answer.php?id=" + id);
});

$(".btnMostrarForm").on("click", function(){
    let id = $(this).data("id");
    $("#formResp-"+id).toggle();
});

$(".btnEnviarRespuesta").on("click", function(){
    let qid = $(this).data("id");
    let texto = $("#respuesta-"+qid).val();

    if (texto.trim() === "") {
        $("#msgResp-"+qid).html("Debes escribir una respuesta.");
        return;
    }

    $.post("create_answer.php", {
        question_id: qid,
        respuesta: texto
    }, function(res){
        $("#msgResp-"+qid).html(res);
        $("#respuesta-"+qid).val("");
        $("#respuestas-"+qid).load("load_answer.php?id=" + qid);
    });
});
</script>

</body>
</html>
