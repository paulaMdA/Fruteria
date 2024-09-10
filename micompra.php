<?php
session_start();
include 'functiones.php'; 

// Verificar si el usuario está conectado
if(isset($_SESSION['usuario'])) {
    $nom = $_SESSION['usuario']['email'];
    $rol = $_SESSION['usuario']['rol'];
    echo "<h1>Historial de compras de: $nom</h1>";

    // Conectar a la base de datos
    $conexion = conectar();
    
    // Consultar las compras entregadas del usuario conectado
    $id_usuario = $_SESSION['usuario']['id_usr'];
    $query = "SELECT p.nombre AS nombre_producto, p.descripcion, p.precio, p.fotos, c.cantidad, c.total, c.estado, c.fecha
              FROM carrito c
              INNER JOIN productos p ON c.producto_id = p.id
              WHERE c.estado = 'entregado' AND c.usuario_id = $id_usuario";
    
    $result = mysqli_query($conexion, $query);

    if (!$result) {
        die("Error al obtener las compras entregadas: " . mysqli_error($conexion));
    }
       ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./css/miCompra.css">
    <title>Carrito de Compras</title>
</head>
<body>
    
   
      <?php
    if (mysqli_num_rows($result) > 0) {
        // Mostrar las compras en una tabla
      
        echo "<table>";
        echo "<tr>";
        echo "<th>Producto</th>";
        echo "<th>Descripción</th>";
        echo "<th>Precio</th>";
        echo "<th>Fotos</th>";
        echo "<th>Cantidad</th>";
        echo "<th>Total</th>";
        echo "<th>Fecha de Pedido</th>";
        echo "</tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['nombre_producto'] . '</td>';
            echo '<td>' . $row['descripcion'] . '</td>';
            echo '<td>' . $row['precio'] . '</td>';
            echo '<td><img src="' . $row['fotos'] . '" alt="Imagen del producto"></td>';
            echo '<td>' . $row['cantidad'] . '</td>';
            echo '<td>' . $row['total'] . '</td>';
            echo '<td>' . $row['fecha'] . '</td>';
            echo '</tr>';
        }
        echo "</table>";
    } else {
        echo "<p>No hay compras entregadas.</p>";
    }
?>
    <div class="buttons-container">
        <form action="menu.php" method="post">
            <input type="submit" name="volver" value="Volver"/>
        </form>
        <form action="login.php" method="post">
            <input type="submit" name="cerrarSesion" value="Cerrar Sesión"/>
        </form>
    </div>
    <?php
} else {
    // Si no hay usuario conectado, mostrar mensaje de acceso denegado
    echo('Acceso denegado');
    
    // Destruir la sesión
    session_destroy();
}
?>
</body>
</html>
