<?php
// index.php
include __DIR__ . '/includes/header.php';
require_once __DIR__ . '/functions/auth.php';
$user = current_user();
?>
<main style="padding:20px; display:flex; gap:20px;">
  <section style="flex:1; max-width:700px;">
    <?php if ($user): ?>
      <div style="margin-bottom:20px; border:1px solid #ddd; padding:10px;">
        <h3>Crear pregunta</h3>
        <form id="createQuestionForm">
          <input name="title" placeholder="Título" style="width:100%; padding:6px"><br><br>
          <textarea name="description" placeholder="Descripción" style="width:100%; padding:6px" rows="4"></textarea><br><br>
          <button type="submit">Publicar pregunta</button>
        </form>
      </div>
    <?php else: ?>
      <div style="margin-bottom:20px; padding:10px; border:1px solid #ddd;">
        <p>Inicia sesión para poder publicar preguntas y respuestas.</p>
        <a href="login.php">Login</a> o <a href="register.php">Registrar</a>
      </div>
    <?php endif; ?>

    <div id="questionsContainer"></div>
  </section>

  <aside style="width:300px;">
    <div style="border:1px solid #ddd; padding:10px;">
      <h4>Sugerencias</h4>
      <p>Este panel puede usarse para filtros, categorías, o actividades recientes.</p>
    </div>
  </aside>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
