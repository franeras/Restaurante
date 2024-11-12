<?php
// camarero_dashboard.php
session_start();
include('Conexion.php');
include('security.php');
verificarRol('camarero');

// Abrir una mesa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['abrir_mesa'])) {
    $numeroMesa = (int)$_POST['numeroMesa'];
    $capacidad = (int)$_POST['capacidad'];

    // Comprobar si la mesa ya está en uso
    $consultaMesa = "SELECT * FROM mesas WHERE numeroMesa = $numeroMesa";
    $resultadoMesa = mysqli_query($conex, $consultaMesa);

    if (mysqli_num_rows($resultadoMesa) > 0) {
        echo "La mesa ya está registrada.";
    } else {
        // Insertar la nueva mesa en estado 'ocupada'
        $consulta = "INSERT INTO mesas (numeroMesa, estado, capacidad) VALUES ($numeroMesa, 'ocupada', $capacidad)";
        if (mysqli_query($conex, $consulta)) {
            echo "Mesa abierta correctamente.";
        } else {
            echo "Error al abrir la mesa: " . mysqli_error($conex);
        }
    }
}
?>

<!-- Formulario para abrir una mesa -->
<h2>Abrir Mesa</h2>
<form method="POST" action="camarero_dashboard.php">
    <label>Número de Mesa:</label>
    <input type="number" name="numeroMesa" required><br>

    <label>Capacidad:</label>
    <input type="number" name="capacidad" required><br>

    <button type="submit" name="abrir_mesa">Abrir Mesa</button>
</form>

<!-- Listado de mesas activas -->
<h2>Mesas Activas</h2>
<ul>
<?php
// Consultar mesas en estado 'ocupada'
$consultaMesas = "SELECT * FROM mesas WHERE estado = 'ocupada'";
$resultadoMesas = mysqli_query($conex, $consultaMesas);

while ($mesa = mysqli_fetch_assoc($resultadoMesas)) {
    echo "<li>Mesa " . $mesa['numeroMesa'] . " - Capacidad: " . $mesa['capacidad'] . "</li>";
}
?>
</ul>

<?php
// Código anterior...

// Tomar un pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tomar_pedido'])) {
    $idMesa = (int)$_POST['idMesa'];
    $idCamarero = $_SESSION['idUsuario']; // ID del camarero actual

    // Crear un nuevo pedido
    $consultaPedido = "INSERT INTO pedidos (idMesa, idCamarero, estado) VALUES ($idMesa, $idCamarero, 'pendiente')";
    if (mysqli_query($conex, $consultaPedido)) {
        $idPedido = mysqli_insert_id($conex); // Obtener el ID del pedido recién creado

        // Insertar cada producto en detallepedidos
        foreach ($_POST['productos'] as $producto) {
            $idProducto = (int)$producto['idProducto'];
            $cantidad = (int)$producto['cantidad'];
            $nota = mysqli_real_escape_string($conex, $producto['nota']);

            $consultaDetalle = "INSERT INTO detallepedidos (idPedido, idProducto, cantidad, nota) 
                                VALUES ($idPedido, $idProducto, $cantidad, '$nota')";

            if (!mysqli_query($conex, $consultaDetalle)) {
                echo "Error al registrar el detalle del pedido: " . mysqli_error($conex);
            }
        }
        echo "Pedido registrado correctamente.";
    } else {
        echo "Error al crear el pedido: " . mysqli_error($conex);
    }
}
?>

<!-- Formulario para tomar un pedido -->
<h2>Tomar Pedido</h2>
<form method="POST" action="camarero_dashboard.php">
    <label>Selecciona Mesa:</label>
    <select name="idMesa">
        <?php
        // Cargar mesas ocupadas para seleccionar
        $consultaMesasOcupadas = "SELECT * FROM mesas WHERE estado = 'ocupada'";
        $resultadoMesasOcupadas = mysqli_query($conex, $consultaMesasOcupadas);

        while ($mesa = mysqli_fetch_assoc($resultadoMesasOcupadas)) {
            echo "<option value='" . $mesa['idMesa'] . "'>Mesa " . $mesa['numeroMesa'] . "</option>";
        }
        ?>
    </select><br>

    <!-- Agregar productos al pedido -->
    <h3>Productos</h3>
    <div id="productos">
        <div class="producto">
            <label>Producto:</label>
            <select name="productos[0][idProducto]">
                <?php
                // Cargar lista de productos
                $consultaProductos = "SELECT * FROM productos";
                $resultadoProductos = mysqli_query($conex, $consultaProductos);

                while ($producto = mysqli_fetch_assoc($resultadoProductos)) {
                    echo "<option value='" . $producto['idProducto'] . "'>" . $producto['nombre'] . "</option>";
                }
                ?>
            </select><br>

            <label>Cantidad:</label>
            <input type="number" name="productos[0][cantidad]" required><br>

            <label>Nota:</label>
            <input type="text" name="productos[0][nota]"><br>
        </div>
    </div>

    <button type="submit" name="tomar_pedido">Registrar Pedido</button>
</form>

<?php
// Código previo ...

// Actualizar estado del pedido: Enviar a cocina o marcar como servido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar_estado'])) {
    $idPedido = (int)$_POST['idPedido'];
    $nuevoEstado = $_POST['estado'];

    // Actualizar el estado del pedido en la base de datos
    $consultaActualizar = "UPDATE pedidos SET estado = '$nuevoEstado' WHERE idPedido = $idPedido";
    if (mysqli_query($conex, $consultaActualizar)) {
        echo "El estado del pedido ha sido actualizado a $nuevoEstado.";
    } else {
        echo "Error al actualizar el estado del pedido: " . mysqli_error($conex);
    }
}
?>

<!-- Visualización de pedidos pendientes o enviados -->
<h2>Pedidos Pendientes y Enviados</h2>
<ul>
<?php
// Consultar pedidos en estado 'pendiente' o 'enviado' para actualización
$consultaPedidos = "SELECT * FROM pedidos WHERE estado IN ('pendiente', 'enviado')";
$resultadoPedidos = mysqli_query($conex, $consultaPedidos);

while ($pedido = mysqli_fetch_assoc($resultadoPedidos)) {
    echo "<li>Pedido #" . $pedido['idPedido'] . " - Mesa " . $pedido['idMesa'] . " - Estado: " . $pedido['estado'] . "</li>";

    // Formulario para actualizar el estado del pedido
    echo "<form method='POST' action='camarero_dashboard.php'>";
    echo "<input type='hidden' name='idPedido' value='" . $pedido['idPedido'] . "'>";

    if ($pedido['estado'] === 'pendiente') {
        echo "<button type='submit' name='estado' value='enviado'>Enviar a Cocina</button>";
    } elseif ($pedido['estado'] === 'enviado') {
        echo "<button type='submit' name='estado' value='servido'>Marcar como Servido</button>";
    }

    echo "<input type='hidden' name='actualizar_estado' value='1'>";
    echo "</form>";
}
?>
</ul>