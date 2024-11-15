<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit();
}

include 'config.php';

// Obtener todos los usuarios
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Usuarios</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Administración de Usuarios</h1>
    <a href="logout.php">Cerrar Sesión</a>
    <table border="1">
        <tr>
            <th>Username</th>
            <th>Role</th>
            <th>Acciones</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["username"] . "</td>
                        <td>" . $row["role"] . "</td>
                        <td>
                            <form action='delete_user.php' method='post' class='delete-form'>
                                <input type='hidden' name='user_id' value='" . $row["id"] . "'>
                                <button type='submit'>Eliminar</button>
                            </form>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No hay usuarios.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
<?php $conn->close(); ?>
