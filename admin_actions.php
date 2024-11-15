<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

include 'config.php';

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action === 'delete_user') {
        $user_id = $_GET['id'];

        // Eliminar el usuario
        $sql = "DELETE FROM users WHERE id='$user_id'";
        if ($conn->query($sql) === TRUE) {
            header("Location: admin.php");
        } else {
            echo "Error: " . $conn->error;
        }
    } elseif ($action === 'delete_image') {
        $image_id = $_GET['id'];

        // Obtener el nombre del archivo para eliminarlo del servidor
        $sql = "SELECT filename FROM images WHERE id='$image_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $filename = $row['filename'];
            $target_file = "uploads/" . $filename;

            // Eliminar la imagen de la base de datos
            $sql = "DELETE FROM images WHERE id='$image_id'";
            if ($conn->query($sql) === TRUE) {
                // Eliminar el archivo del servidor
                if (file_exists($target_file)) {
                    unlink($target_file);
                }
                header("Location: admin.php");
            } else {
                echo "Error: " . $conn->error;
            }
        }
    }
}

$conn->close();
?>
