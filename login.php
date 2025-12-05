<?php
// login.php
require_once __DIR__ . '/functions/auth.php';
if (is_logged()) header('Location: index.php');

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    if ($email === '' || $password === '') {
        $msg = "Completa todos los campos.";
    } else {
        $res = login_user($email, $password);
        if ($res['ok']) {
            header('Location: index.php');
            exit;
        } else {
            $msg = $res['msg'];
        }
    }
}
include __DIR__ . '/includes/header.php';
?>
<main style="padding:20px;">
  <h2>Iniciar sesión</h2>
  <?php if ($msg): ?><p style="color:red"><?=htmlspecialchars($msg)?></p><?php endif; ?>
  <form method="post">
    <label>Email<br><input name="email" type="email"></label><br><br>
    <label>Password<br><input name="password" type="password"></label><br><br>
    <button type="submit">Entrar</button>
  </form>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
