<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sitio_web";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener los nombres almacenados
$sql = "SELECT nombre, fecha FROM nombres";
$result = $conn->query($sql);

// Mostrar los nombres
if ($result->num_rows > 0) {
    echo "<h1>Nombres almacenados:</h1>";
    echo "<ul>";
    while($row = $result->fetch_assoc()) {
        echo "<li>" . $row["nombre"] . " - " . $row["fecha"] . "</li>";
    }
    echo "</ul>";
} else {
    echo "No se han almacenado nombres aún.";
}

// Cerrar la conexión
$conn->close();
?>
