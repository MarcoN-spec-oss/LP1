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
</head>
<body>

<header>
    <?php if (!isset($_SESSION['user_id'])): ?>
        <a href="login.php">Login</a> |
        <a href="register.php">Register</a>
    <?php else: ?>
        Hola, <b><?= $_SESSION['username'] ?></b>
        | <a href="logout.php">Cerrar sesión</a>
    <?php endif; ?>
</header>

<hr>

<?php if (isset($_SESSION['user_id'])): ?>
<section>
    <h2>Crear Pregunta</h2>

    <form id="formPregunta">
        <input type="text" name="titulo" placeholder="Título" required><br><br>
        <textarea name="descripcion" placeholder="Descripción..." required></textarea><br><br>
        <button type="submit">Publicar Pregunta</button>
    </form>

    <p id="msg"></p>
</section>
<hr>
<?php endif; ?>

<section>
    <h2>Preguntas Recientes</h2>

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

    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">

        <h3><?= $row['title'] ?></h3>
        <p><?= $row['description'] ?></p>

        <small>
            Por: <?= $row['username'] ?> | Fecha: <?= $row['created_at'] ?>
        </small>

        <br><br>

        <button class="verRespuestas" data-id="<?= $row['id'] ?>">Ver respuestas</button>

        <br><br>

        <?php if (isset($_SESSION['user_id'])): ?>
            <button class="btnMostrarForm" data-id="<?= $row['id'] ?>">Responder a esta pregunta</button>

            <div id="formResp-<?= $row['id'] ?>" style="display:none; margin-top:10px;">
                <textarea id="respuesta-<?= $row['id'] ?>" placeholder="Escribe tu respuesta..." style="width:100%;"></textarea><br>
                <button class="btnEnviarRespuesta" data-id="<?= $row['id'] ?>">Enviar respuesta</button>
                <p id="msgResp-<?= $row['id'] ?>"></p>
            </div>
        <?php endif; ?>

        <div id="respuestas-<?= $row['id'] ?>" style="margin-top:15px;"></div>

    </div>

    <?php endwhile; ?>
</section>

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
