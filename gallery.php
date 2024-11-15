<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

include 'config.php';
$username = $_SESSION['username'];

$sql = "SELECT * FROM images WHERE username='$username'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Galería</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Mi Galería</h1>

    <?php
    if (isset($_SESSION['upload_success'])) {
        echo "<p class='success-message'>" . $_SESSION['upload_success'] . "</p>";
        unset($_SESSION['upload_success']);
    }

    if (isset($_SESSION['upload_error'])) {
        echo "<p class='error-message'>" . $_SESSION['upload_error'] . "</p>";
        unset($_SESSION['upload_error']);
    }

    if (isset($_SESSION['delete_success'])) {
        echo "<p class='success-message'>" . $_SESSION['delete_success'] . "</p>";
        unset($_SESSION['delete_success']);
    }

    if (isset($_SESSION['delete_error'])) {
        echo "<p class='error-message'>" . $_SESSION['delete_error'] . "</p>";
        unset($_SESSION['delete_error']);
    }
    ?>

    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="image">Selecciona una imagen para subir:</label>
        <input type="file" name="image" id="image">
        <button type="submit" name="submit">Subir Imagen</button>
    </form>

    <ul class="image-gallery">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<li class='image'>
                        <img src='" . $row["filename"] . "' alt='Imagen'>
                        <form action='delete.php' method='post' class='delete-form'>
                            <input type='hidden' name='image_id' value='" . $row["id"] . "'>
                            <button type='submit'>Eliminar</button>
                        </form>
                      </li>";
            }
        } else {
            echo "<p>No hay imágenes subidas.</p>";
        }
        ?>
    </ul>

    <form action="logout.php" method="post" class="logout-form">
        <button type="submit">Cerrar Sesión</button>
    </form>

    <script src="script.js"></script>
</body>
</html>
<?php $conn->close(); ?>
