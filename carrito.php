
<?php
session_start();
include 'functiones.php'; 

// Verificar si el usuario está conectado
if(isset($_SESSION['usuario'])) {
    $nom = $_SESSION['usuario']['email'];
    $rol = $_SESSION['usuario']['rol'];
    echo "<h1>Carrito de:  $nom</h1>";

    // Conectar a la base de datos
    $conexion = conectar();
    
    // Acción: Comprar producto
    if(isset($_POST['comprar'])) {
        if(isset($_POST['id_carrito'])) {
            $id_carrito = $_POST['id_carrito'];
            $query_comprar = "UPDATE carrito SET estado = 'comprado' WHERE id = $id_carrito";
            $result_comprar = mysqli_query($conexion, $query_comprar);
            if (!$result_comprar) {
                die("Error al comprar producto: " . mysqli_error($conexion));
            }
        } 
    }

    // Acción: Eliminar producto del carrito
    if(isset($_POST['eliminar'])) {
        if(isset($_POST['id_carrito'])) {
            $id_carrito = $_POST['id_carrito'];
            $query_eliminar = "DELETE FROM carrito WHERE id = $id_carrito";
            $result_eliminar = mysqli_query($conexion, $query_eliminar);
            if (!$result_eliminar) {
                die("Error al eliminar producto del carrito: " . mysqli_error($conexion));
            }
        } 
    }

    // Acción: Enviar compra (solo para vendedor)
    if(isset($_POST['enviar'])) {
        if(isset($_POST['id_carrito'])) {
            $id_carrito = $_POST['id_carrito'];
            $query_enviar = "UPDATE carrito SET estado = 'enviado' WHERE id = $id_carrito";
            $result_enviar = mysqli_query($conexion, $query_enviar);
            if (!$result_enviar) {
                die("Error al enviar compra: " . mysqli_error($conexion));
            }
        } 
    }

    // Acción: Entregar compra (solo para vendedor)
    if(isset($_POST['entregar'])) {
        if(isset($_POST['id_carrito'])) {
            $id_carrito = $_POST['id_carrito'];
            $query_entregar = "UPDATE carrito SET estado = 'entregado' WHERE id = $id_carrito";
            $result_entregar = mysqli_query($conexion, $query_entregar);
            if (!$result_entregar) {
                die("Error al entregar compra: " . mysqli_error($conexion));
            }
        } 
    }

    // Acción: Rechazar compra (solo para vendedor)
    if(isset($_POST['rechazar'])) {
        if(isset($_POST['id_carrito'])) {
            $id_carrito = $_POST['id_carrito'];
            $query_rechazar = "UPDATE carrito SET estado = 'pendiente' WHERE id = $id_carrito";
            $result_rechazar = mysqli_query($conexion, $query_rechazar);
            if (!$result_rechazar) {
                die("Error al rechazar compra: " . mysqli_error($conexion));
            }
            if ($rol == 'comprador') {
                echo "<p>La compra ha sido rechazada. Por favor, vuelva a intentarlo.</p>";
            }
        } 
    }
    
    // Consultar los detalles del carrito
    if ($rol == 'comprador') {
        $id_usuario = $_SESSION['usuario']['id_usr'];
        $query = "SELECT c.id, u.nombre AS nombre_usuario, u.apellidos AS apellidos_usuario, p.nombre AS nombre_producto, c.cantidad, c.total, c.estado, c.fecha
                  FROM carrito c
                  INNER JOIN usuarios u ON c.usuario_id = u.id_usr
                  INNER JOIN productos p ON c.producto_id = p.id
                  WHERE c.estado IN ('pendiente', 'comprado', 'enviado', 'entregado') AND c.usuario_id = $id_usuario";
    } elseif ($rol == 'vendedor') {
        $query = "SELECT c.id, u.nombre AS nombre_usuario, u.apellidos AS apellidos_usuario, p.nombre AS nombre_producto, c.cantidad, c.total, c.estado, c.fecha
                  FROM carrito c
                  INNER JOIN usuarios u ON c.usuario_id = u.id_usr
                  INNER JOIN productos p ON c.producto_id = p.id
                  WHERE c.estado IN ('comprado', 'enviado', 'entregado')";
    }

    $result = mysqli_query($conexion, $query);

    if (!$result) {
        die("Error al obtener los detalles del carrito: " . mysqli_error($conexion));
    }
    ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./css/carrito.css">
    <title>Carrito de Compras</title>
</head>
<body>
    
   
      <?php
    // Verificar si el carrito está vacío
    if (mysqli_num_rows($result) == 0) {
        echo "<p>Su carrito está vacío. ¡Por favor, agregue productos o realice una compra!</p>";
    } else {
        // Mostrar  carrito en la tabla
        echo "<table>";
        echo "<tr>";
        echo "<th>Usuario</th>";
        echo "<th>Apellidos</th>";
        echo "<th>Producto</th>";
        echo "<th>Cantidad</th>";
        echo "<th>Total</th>";
        echo "<th>Estado</th>";
        echo "<th>Fecha</th>";
        if($rol == 'vendedor') {
         
        }
        echo "</tr>";

      
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['nombre_usuario'] . '</td>';
            echo '<td>' . $row['apellidos_usuario'] . '</td>';
            echo '<td>' . $row['nombre_producto'] . '</td>';
            echo '<td>' . $row['cantidad'] . '</td>';
            echo '<td>' . $row['total'] . '</td>';
            echo '<td>' . $row['estado'] . '</td>';
            echo '<td>' . $row['fecha'] . '</td>';
            
            // Botones de acción según el rol del usuario
            echo '<td>';
            if($rol == 'comprador') {
                echo '<form action="" method="post">';
                echo '<input type="hidden" name="id_carrito" value="' . $row['id'] . '">';
                echo '<input type="submit" name="eliminar" value="Eliminar">';
                echo '<input type="submit" name="comprar" value="Comprar">';
                echo '</form>';
            }
            
            // Botones de acción según el rol del usuario
            if($rol == 'vendedor') {
                echo '<td>';
                if ($row['estado'] == 'comprado') {
                    echo '<form action="" method="post">';
                    echo '<input type="hidden" name="id_carrito" value="' . $row['id'] . '">';
                    echo '<input type="submit" name="enviar" value="Enviar">';
                    echo '<input type="submit" name="rechazar" value="Rechazar">';
                    echo '</form>';
                } elseif ($row['estado'] == 'enviado') {
                    echo '<form action="" method="post">';
                    echo '<input type="hidden" name="id_carrito" value="' . $row['id'] . '">';
                    echo '<input type="submit" name="entregar" value="Entregar">';
                    echo '</form>';
                }
                echo '</td>';
            }
            echo '</tr>';
        }
        echo "</table>";
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