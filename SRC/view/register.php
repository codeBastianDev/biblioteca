<?php
include('php/Conexion.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $password = $_POST['password'];

    // Consulta segura con sentencias preparadas
    $query = $conn->prepare("INSERT INTO usuario (nombre, apellido, email, telefono, direccion, paswoord) VALUES (?, ?, ?, ?, ?, ?)");
    $query->bind_param("ssssss", $nombre, $apellido, $email, $telefono, $direccion, $password);

    if ($query->execute()) {
        
        header('Location: index.php?success=1');
        exit();
    } else {
        echo "Error al registrar el usuario: " . $conn;
    } 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Biblioteca Futuro</title>
    <link rel="stylesheet" href="RegisterCs.css">
</head>
<body>
    <div class="formulario">
        <h1>Registro</h1>
        <form method="post" action="">
            <div class="Username">
                <input type="text" name="username" required>
                <label>Nombre de usuario</label>
            </div>
            <div class="Nombre">
                <input type="text" name="nombre" required>
                <label>Nombre</label>
            </div>
            <div class="Apellido">
                <input type="text" name="apellido" required>
                <label>Apellido</label>
            </div>
            <div class="Email">
                <input type="email" name="email" required>
                <label>Email</label>
            </div>
            <div class="Telefono">
                <input type="tel" name="telefono" required>
                <label>Teléfono</label>
            </div>
            <div class="Direccion">
                <input type="text" name="direccion" required>
                <label>Dirección</label>
            </div>
            <div class="Contraseña">
                <input type="password" name="password" required>
                <label>Contraseña</label>
            </div>
            <input type="submit" value="Registrarse">
        </form>
    </div>
</body>
</html>
