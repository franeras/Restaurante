<?php
// login.php
session_start();
include('Conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conex, $_POST['email']);
    $contrasena = mysqli_real_escape_string($conex, $_POST['contrasena']);

    // Consulta para verificar las credenciales del usuario
    $consulta = "SELECT idUsuario, nombre, rol FROM usuarios WHERE email = '$email' AND contrasena = '$contrasena'";
    $resultado = mysqli_query($conex, $consulta);

    if (mysqli_num_rows($resultado) == 1) {
        $usuario = mysqli_fetch_assoc($resultado);
        $_SESSION['idUsuario'] = $usuario['idUsuario'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['rol'] = $usuario['rol'];

        // Redirigir según el rol
        if ($usuario['rol'] == 'camarero') {
            header('Location: camarero_dashboard.php'); // Ruta simplificada
        } elseif ($usuario['rol'] == 'encargado') {
            header('Location: encargado_dashboard.php'); // Ruta simplificada
        }
        exit();
    } else {
        echo "Credenciales incorrectas. Inténtelo nuevamente.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión</title>
</head>
<body>
    <h1>Bienvenido al Sistema de Pedidos</h1>
    <form method="POST" action="login.php">
        <input type="email" name="email" placeholder="Correo electrónico" required>
        <input type="password" name="contrasena" placeholder="Contraseña" required>
        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>