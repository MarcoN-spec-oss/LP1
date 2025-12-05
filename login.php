<?php
session_start();
include "includes/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<div class="login-container">

    <h2>Iniciar Sesión</h2>

    <form action="login.php" method="POST" class="form-auth">
        <input type="email" name="email" placeholder="Correo" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Entrar</button>
    </form>

    <p class="auth-link"><a href="register.php">Crear una cuenta</a></p>

</div>

</body>
</html>
<?php
exit();
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
$res = $conn->query($sql);

if ($res->num_rows == 1) {
    $user = $res->fetch_assoc();

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];

    header("Location: index.php");
    exit();
} else {
    echo "Correo o contraseña incorrectos <br><br>";
    echo "<a href='login.php'>Intentar de nuevo</a>";
}
?>
