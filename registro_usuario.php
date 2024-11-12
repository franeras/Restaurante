<?php
// registro_usuario.php
session_start();
include('Conexion.php');
include('security.php');
verificarRol('encargado'); // Solo encargados pueden registrar usuarios

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener y limpiar los datos del formulario
    $nombre = mysqli_real_escape_string($conex, $_POST['nombre']);
    $apellidos = mysqli_real_escape_string($conex, $_POST['apellidos']);
    $edad = (int)$_POST['edad'];
    $dni = mysqli_real_escape_string($conex, $_POST['dni']);
    $email = mysqli_real_escape_string($conex, $_POST['email']);
    $contrasena = mysqli_real_escape_string($conex, $_POST['contrasena']);
    $rol = mysqli_real_escape_string($conex, $_POST['rol']);

    // Consulta para insertar el nuevo usuario
    $consulta = "INSERT INTO usuarios (nombre, apellidos, edad, dni, email, contrasena, rol)
                 VALUES ('$nombre', '$apellidos', '$edad', '$dni', '$email', '$contrasena', '$rol')";

    if (mysqli_query($conex, $consulta)) {
        echo "Usuario registrado exitosamente. <a href='encargado_dashboard.php'>Volver</a>";
    } else {
        echo "Error al registrar el usuario: " . mysqli_error($conex);
    }
} else {
    header("Location: encargado_dashboard.php"); // Redirigir si se accede directamente
    exit();
}
?>