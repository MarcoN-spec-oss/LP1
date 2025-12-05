<!DOCTYPE html>
<html>
<head>
    <title>Mi Foro</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<?php if (isset($_SESSION['user_id'])): ?>
    <div class="user-box">
        <span>Hola, <?php echo $_SESSION['username']; ?></span>
        <a href="logout.php">Cerrar sesión</a>
    </div>
<?php else: ?>
    <a href="login.php">Iniciar sesión</a>
    <p><a href="register.php">Registrarse</a></p>
<?php endif; ?>

<?php if(isset($_SESSION['user_id'])): ?>
<div class="user-menu">
    <img src="assets/img/default-avatar.png" class="avatar">

    <div class="user-dropdown">
        <p class="username"><?= $_SESSION['username']; ?></p>
        <a href="profile.php">Mi perfil</a>
        <a href="logout.php">Cerrar sesión</a>
    </div>
</div>
<?php endif; ?>


<body>
