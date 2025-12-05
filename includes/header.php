<?php
require_once __DIR__ . '/../functions/auth.php';
$user = current_user();
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Foro preguntas</title>
<link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>

<header class="main-header">
    <div class="header-logo">
        <a href="index.php">ForoPreguntas</a>
    </div>

    <nav class="header-nav">
        <?php if ($user): ?>
            <div class="user-menu-container">
                <button id="userBtn" class="user-btn">
                    <?= htmlspecialchars($user['username']) ?>
                </button>

                <div id="userMenu" class="user-menu">
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
        btn.addEventListener('click', () => {
            menu.classList.toggle('visible');
        });

        document.addEventListener('click', e => {
            if (!btn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.remove('visible');
            }
        });
    }
});
</script>
