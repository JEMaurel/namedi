<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Código para mostrar y modificar los nombres si ya estás autenticado

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

// Procesar la eliminación de un nombre si se solicita
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    $sql = "DELETE FROM nombres WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Nombre eliminado correctamente.<br>";
    } else {
        echo "Error al eliminar el nombre: " . $conn->error . "<br>";
    }
}

// Consulta para obtener los nombres almacenados
$sql = "SELECT id, nombre, fecha FROM nombres";
$result = $conn->query($sql);

// Mostrar los nombres con opción de eliminación
if ($result->num_rows > 0) {
    echo "<h1>Modificar Nombres Almacenados:</h1>";
    echo "<ul>";
    while($row = $result->fetch_assoc()) {
        echo "<li>" . $row["nombre"] . " - " . $row["fecha"] .
             " <form method='post' style='display:inline;'>
                <input type='hidden' name='delete_id' value='" . $row['id'] . "'>
                <button type='submit'>Eliminar</button>
               </form></li>";
    }
    echo "</ul>";
} else {
    echo "No se han almacenado nombres aún.";
}

// Cerrar la conexión
$conn->close();
?>
