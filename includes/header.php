<?php
// includes/header.php
require_once __DIR__ . '/../functions/auth.php';
$user = current_user();
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Foro preguntas</title>
<link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<header style="padding:10px;border-bottom:1px solid #ddd;display:flex;justify-content:space-between;align-items:center">
  <div><a href="index.php">ForoPreguntas</a></div>
  <nav>
    <?php if ($user): ?>
      <div style="display:inline-block; position:relative;">
        <button id="userBtn"><?=htmlspecialchars($user['username'])?></button>
        <div id="userMenu" style="display:none; position:absolute; right:0; background:#fff; border:1px solid #ccc; padding:5px;">
          <a href="logout.php">Cerrar sesión</a>
        </div>
      </div>
    <?php else: ?>
      <a href="login.php">Login</a> |
      <a href="register.php">Register</a>
    <?php endif; ?>
  </nav>
</header>

<script>
document.addEventListener('DOMContentLoaded', function(){
  const btn = document.getElementById('userBtn');
  const menu = document.getElementById('userMenu');
  if (btn && menu) {
    btn.addEventListener('click', () => menu.style.display = menu.style.display === 'none' ? 'block' : 'none');
    document.addEventListener('click', e => {
      if (!btn.contains(e.target) && !menu.contains(e.target)) menu.style.display = 'none';
    });
  }
});
</script>
