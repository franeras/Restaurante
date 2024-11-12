<?php
// security.php
//comentario
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['idUsuario'])) {
    header("Location: index.php"); 
    exit();
}

// Verificar rol del usuario, si se especifica en la página
function verificarRol($rolRequerido) {
    if ($_SESSION['rol'] !== $rolRequerido) {
        header("Location: no_autorizado.php"); // Redirigir a una página de "No autorizado"
        exit();
    }
}
?>