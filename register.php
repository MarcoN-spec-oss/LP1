<?php session_start(); ?>
<?php include 'includes/header.php'; ?>

<div class="login-container">
    <form action="register_process.php" method="POST" class="login-form">
        <h2>Registro de Usuario</h2>

        <?php if(isset($_GET['error'])): ?>
            <p class="error-msg"><?= $_GET['error']; ?></p>
        <?php endif; ?>

        <?php if(isset($_GET['success'])): ?>
            <p class="success-msg"><?= $_GET['success']; ?></p>
        <?php endif; ?>

        <label>Nombre de usuario:</label>
        <input type="text" name="username" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Contraseña:</label>
        <input type="password" name="password" required>

        <button type="submit">Registrarse</button>

        <p class="login-note">
            ¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí.</a>
        </p>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
