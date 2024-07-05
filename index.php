<?php
session_start();
include('php/Conexion.php'); 

if (isset($_SESSION['username'])) {
    header('Location: inicio.html');
    exit();
}

$error_message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Consulta segura con sentencias preparadas
        $query = $conn->prepare("SELECT * FROM usuario WHERE nombre = ? AND paswoord = ?");
        $query->bind_param("ss", $username, $password);
        $query->execute();
        $result = $query->get_result();

        // Verificar si se encontró un registro
        if ($result && $result->num_rows > 0) {
            $_SESSION['username'] = $username;
            header('Location: inicio.html');
            exit();
        } else {
            $error_message = 'Nombre de usuario o contraseña incorrectos.';
        }
    }
}

$success_message = '';
if (isset($_GET['success'])) {
    $success_message = 'Usuario registrado correctamente.';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Futuro</title>
    <link rel="stylesheet" href="LoginCs.css">
</head>
<body>
    <div class="formulario">
        <h1>Inicio de sesión</h1>
        <?php if ($success_message): ?>
            <p style="color: green;"><?php echo $success_message; ?></p>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <div class="Username">
                <input type="text" name="username" required>
                <label>Nombre de usuario</label>
            </div>
            <div class="contraseña">
                <input type="password" name="password" required>
                <label>Contraseña</label>
            </div>
            <div class="Recordar">¿Olvidó su contraseña?</div>
            <input type="submit" value="Iniciar sesión">
            <div class="registrarse">
                ¿Quieres registrarte? <a href="register.php">¡Haz clic aquí!</a>
            </div>
        </form>
    </div>
</body>
</html>
