<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

include 'config.php';

$image_id = $_POST['image_id'];
$username = $_SESSION['username'];

// Obtener la ruta del archivo
$sql = "SELECT filename FROM images WHERE id='$image_id' AND username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $file_path = $row['filename'];

    // Eliminar el archivo físico
    if (file_exists($file_path)) {
        unlink($file_path);
    }

    // Eliminar la referencia en la base de datos
    $sql = "DELETE FROM images WHERE id='$image_id' AND username='$username'";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['delete_success'] = "Imagen eliminada correctamente.";
    } else {
        $_SESSION['delete_error'] = "Error al eliminar la imagen de la base de datos.";
    }
} else {
    $_SESSION['delete_error'] = "Imagen no encontrada.";
}

header("Location: gallery.php");
exit();
?>
