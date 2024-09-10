<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Productos</title>
    <link rel="stylesheet" href="./css/eliminar.css">
</head>
<body>

    <div class="container">
        <?php
        session_start();
        include 'functiones.php'; 

        // Verificar si se ha enviado el formulario para eliminar el producto
        if(isset($_POST['eliminar_producto'])) {
            // Verificar si se ha proporcionado el ID del producto a eliminar
            if(isset($_POST['eliminar_producto'])) {
                // Obtener el ID del producto a eliminar
                $id_producto = $_POST['eliminar_producto'];
                
                // Conectar a la base de datos
                $conexion = conectar();

                // Query para eliminar el producto
                $query = "DELETE FROM productos WHERE id = '$id_producto'";
                
                // Ejecutar la consulta
                $resultado = mysqli_query($conexion, $query);

                // Verificar si se eliminó el producto correctamente
                if($resultado) {
                    echo "<p>Producto eliminado correctamente.</p>";
                } else {
                    echo "<p>Error al eliminar el producto.</p>";
                }
            } else {
                echo "Error: No se proporcionó el ID del producto a eliminar.";
            }
        }


        // Verificar si el usuario está conectado
        if(isset($_SESSION['usuario'])) {
            $nom = $_SESSION['usuario']['email'];
            $rol = $_SESSION['usuario']['rol'];
            echo "<h1>Bienvenido $nom</h1>";

            // Conectar a la base de datos
            $conexion = conectar();
            
            // Ejecutar la consulta para obtener los productos
            $query = "SELECT * FROM productos";
            $result = mysqli_query($conexion, $query);

            if (!$result) {
                die("Error al obtener los productos: " . mysqli_error($conexion));
            }
        ?>
            
            <form action="eliminarProductos.php" method="post">
                <table>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Foto</th>
                        <th>Eliminar</th>
                    </tr>
        <?php
            // Mostrar los productos en el formulario
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
                    <tr>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['descripcion']; ?></td>
                        <td><?php echo $row['precio']; ?></td>
                        <td><img src="<?php echo $row['fotos']; ?>" alt="<?php echo $row['nombre']; ?>" style="width: 100px;"></td>
                        <td><button type="submit" name="eliminar_producto" value="<?php echo $row['id']; ?>">Eliminar</button></td>
                    </tr>
        <?php
            }
        ?>
                </table>
            </form>

            <!-- Botones -->
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
            echo('<p>Acceso denegado</p>');
            // Destruir la sesión
            session_destroy();
        }
        ?>
    </div>

</body>
</html>