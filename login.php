<?php
session_start();

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Escapar las entradas para prevenir inyección SQL
    $username = $conn->real_escape_string($username);

    // Verificar el usuario
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verificar la contraseña
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role'];
            if ($row['role'] == 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: gallery.php");
            }
            exit();
        } else {
            echo "Nombre de usuario o contraseña incorrectos";
        }
    } else {
        echo "Nombre de usuario o contraseña incorrectos";
    }
}
?>
