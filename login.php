<?php
session_start();
include "includes/db.php";

// Si no enviaron el formulario, mostrar el login
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

<h2>Iniciar Sesión</h2>

<form action="login.php" method="POST">
    <input type="email" name="email" placeholder="Correo" required><br><br>
    <input type="password" name="password" placeholder="Contraseña" required><br><br>
    <button type="submit">Entrar</button>
</form>

<p><a href="register.php">Crear una cuenta</a></p>

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
