<?php
require_once __DIR__ . '/functions/auth.php';
if (is_logged()) header('Location: index.php');

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    if ($username === '' || $email === '' || $password === '') {
        $msg = "Completa todos los campos.";
    } else {
        $res = register_user($username, $email, $password);
        if ($res['ok']) {
            $_SESSION['user_id'] = $res['id'];
            $_SESSION['username'] = $username;
            header('Location: index.php');
            exit;
        } else {
            $msg = $res['msg'];
        }
    }
}

include __DIR__ . '/includes/header.php';
?>
<link rel="stylesheet" href="assets/css/styles.css">

<main class="register-container">
    <h2>Registro</h2>

    <?php if ($msg): ?>
        <p class="error-msg"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <form method="post" class="form-auth">
        <label>Usuario<br><input name="username"></label>
        <label>Email<br><input name="email" type="email"></label>
        <label>Contraseña<br><input name="password" type="password"></label>
        <button type="submit">Registrarme</button>
    </form>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
