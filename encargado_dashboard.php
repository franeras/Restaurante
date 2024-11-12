<?php
// encargado_dashboard.php
session_start();
include('Conexion.php');
include('security.php');
verificarRol('encargado'); // Solo permite acceso a encargados

echo "<h1>Bienvenido, " . htmlspecialchars($_SESSION['nombre']) . "</h1>";
echo "<p>Esta es la página principal para encargados. Desde aquí podrás gestionar el restaurante y el personal.</p>";

echo "<ul>";
echo "<li><a href='#'>Gestión de Productos</a></li>";
echo "<li><a href='#'>Reportes e Informes</a></li>";
echo "<li><a href='logout.php'>Cerrar sesión</a></li>";
echo "</ul>";

// Formulario para registrar nuevos usuarios
?>
<h2>Registrar nuevo usuario</h2>
<form action="registro_usuario.php" method="POST">
    <label>Nombre:</label>
    <input type="text" name="nombre" required><br>
    
    <label>Apellidos:</label>
    <input type="text" name="apellidos" required><br>
    
    <label>Edad:</label>
    <input type="number" name="edad" min="18" required><br>
    
    <label>DNI:</label>
    <input type="text" name="dni" required><br>
    
    <label>Email:</label>
    <input type="email" name="email" required><br>
    
    <label>Contraseña:</label>
    <input type="password" name="contrasena" required><br>
    
    <label>Rol:</label>
    <select name="rol" required>
        <option value="camarero">Camarero</option>
        <option value="encargado">Encargado</option>
    </select><br>
    
    <button type="submit">Registrar Usuario</button>
</form>