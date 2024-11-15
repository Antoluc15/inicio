<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
            $_SESSION['upload_error'] = "El archivo no es una imagen.";
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
        $_SESSION['upload_error'] = "Lo siento, el archivo ya existe.";
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        $uploadOk = 0;
        $_SESSION['upload_error'] = "Lo siento, el archivo es demasiado grande.";
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $uploadOk = 0;
        $_SESSION['upload_error'] = "Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF.";
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $_SESSION['upload_error'] = isset($_SESSION['upload_error']) ? $_SESSION['upload_error'] : "Lo siento, tu archivo no fue subido.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $username = $_SESSION['username'];
            $stmt = $conn->prepare("INSERT INTO images (username, filename) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $target_file);
            $stmt->execute();
            $stmt->close();
            $_SESSION['upload_success'] = "La imagen ". basename( $_FILES["image"]["name"]). " ha sido subida.";
        } else {
            $_SESSION['upload_error'] = "Lo siento, hubo un error subiendo tu archivo.";
        }
    }

    header("Location: gallery.php");
    exit();
}
?>
