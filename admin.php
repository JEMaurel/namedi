<?php
session_start();
// Verificar si el usuario está autenticado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php"); // Redirigir a una página de login si no está autenticado
    exit();
}

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

// Procesar la adición de un nuevo nombre si se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_name'])) {
    $new_name = $conn->real_escape_string($_POST['new_name']);
    $sql = "INSERT INTO nombres (nombre, fecha) VALUES ('$new_name', NOW())";
    if ($conn->query($sql) === TRUE) {
        // Redirigir después de agregar el nombre para evitar el reenvío del formulario
        header("Location: admin.php?status=success");
        exit();
    } else {
        echo "Error al agregar el nombre: " . $conn->error . "<br>";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Portal de Administración</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; text-align: center; }
        h1 { color: #333; }
        ul { list-style-type: none; padding: 0; }
        li { margin: 10px 0; }
        a { text-decoration: none; color: #007bff; }
        a:hover { text-decoration: underline; }
        img { width: 300px; height: auto; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>Bienvenido al Portal de Administración</h1>

    <!-- Aquí agregamos la imagen del caballo -->
    <img src="caballo.png"     style="max-width: 100%; height: auto;">


    <p>Elija una opción:</p>
    <ul>
        <li><a href="view_names.php">Ver Nombres Almacenados</a></li>
        <li><a href="edit_names.php">Modificar Nombres Almacenados</a></li>
        <li><a href="logout.php">Cerrar Sesión</a></li>
    </ul>

    <!-- Mostrar un mensaje de éxito si el nombre fue agregado -->
    <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <p style="color:green;">Nombre agregado correctamente.</p>
    <?php endif; ?>

    <h2>Agregar Nuevo Nombre:</h2>
    <form method="post" action="admin.php">
        <label for="new_name">Nombre:</label>
        <input type="text" id="new_name" name="new_name" required>
        <button type="submit">Agregar</button>
    </form>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
