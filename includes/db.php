<?php
// Configuración de conexión
$host = "localhost";
$db = "foro";       // Nombre de la base de datos que creaste
$user = "root";     // Usuario por defecto Laragon
$pass = "";         // Contraseña por defecto Laragon (vacía)

try {
    // Crear instancia PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
