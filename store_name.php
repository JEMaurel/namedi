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

// Verificar si el nombre está presente en $_POST
if (isset($_POST['name'])) {
    $nombre = $_POST['name'];

    // Insertar el nombre en la base de datos
    $sql = "INSERT INTO nombres (nombre) VALUES ('$nombre')";

    if ($conn->query($sql) === TRUE) {
        echo "Nombre almacenado correctamente. ¡Gracias!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "No se recibió ningún nombre.";
}

// Cerrar la conexión
$conn->close();
?>
