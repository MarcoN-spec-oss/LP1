<?php
// Cargar conexión a la base de datos
include "includes/db.php";

// Probar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

echo "<h2>conexion lista</h2>";

// CONSULTA DE PRUEBA – puedes cambiar 'users' por cualquier tabla
$sql = "SELECT * FROM users LIMIT 10";
$result = $conn->query($sql);

echo "<h3>Contenido de la tabla 'users':</h3>";

if ($result->num_rows > 0) {

    echo "<table border='1' cellpadding='5'>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Creación</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row['id']."</td>
                <td>".$row['username']."</td>
                <td>".$row['email']."</td>
                <td>".$row['created_at']."</td>
              </tr>";
    }

    echo "</table>";

} else {
    echo "La tabla está vacía.";
}

$conn->close();
?>
