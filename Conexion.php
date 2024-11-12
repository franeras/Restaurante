<?php 
// Conexion.php
$conex = mysqli_connect('localhost', 'root', '', 'restaurante');

// Verificación de conexión
if (!$conex) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Establecemos el juego de caracteres para la conexión
mysqli_set_charset($conex, "utf8");
?>