<?php session_start(); ?>
<?php include 'includes/header.php'; ?>

<div class="login-container">
    <form action="login_process.php" method="POST" class="login-form">
        <h2>Iniciar sesión</h2>

        <?php if(isset($_GET['error'])): ?>
            <p class="error-msg"><?php echo $_GET['error']; ?></p>
        <?php endif; ?>

        <label>Usuario o Email:</label>
        <input type="text" name="username" required>

        <label>Contraseña:</label>
        <input type="password" name="password" required>

        <button type="submit">Ingresar</button>

        <p class="login-note">¿No tienes cuenta? Solicita el acceso al administrador.</p>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
