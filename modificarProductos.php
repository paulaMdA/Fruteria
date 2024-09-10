
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/modificar.css">
    <title>Modificar Productos</title>
</head>
<body>
<?php
session_start();
include 'functiones.php';

// Verificar si el usuario está conectado
if(isset($_SESSION['usuario'])) {
    $nom = $_SESSION['usuario']['email'];
    $rol = $_SESSION['usuario']['rol'];
    echo "<h1>Modificar Productos </h1>";

    // Conectar a la base de datos
    $conexion = conectar();
    
    // Verificar si se ha enviado el formulario para modificar el producto
    if(isset($_POST['modificar_producto'])) {
        // Verificar si se proporcionó la clave "productos" en $_POST
        if(isset($_POST['productos'])) {
            // Iterar sobre cada producto para verificar si se proporcionaron datos de modificación
            foreach ($_POST['productos'] as $id_producto) {
                // Verificar si se proporcionó el ID del producto actual
                if(isset($_POST['nombre_'.$id_producto])) {
                    // Obtener los datos del formulario
                    $nombre = $_POST['nombre_'.$id_producto];
                    $descripcion = $_POST['descripcion_'.$id_producto];
                    $precio = $_POST['precio_'.$id_producto];
                    
                    // Definir $ruta_destino
                    $ruta_destino = '';

                    // Verificar si se ha subido una nueva imagen
                    if(isset($_FILES['imagen_'.$id_producto]) && $_FILES['imagen_'.$id_producto]['error'] === UPLOAD_ERR_OK) {
                        $ruta_destino = 'img/' . $_FILES['imagen_'.$id_producto]['name'];
                        move_uploaded_file($_FILES['imagen_'.$id_producto]['tmp_name'], $ruta_destino);
                    }

                    // Query para actualizar el producto
                    $query = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio='$precio'";
                    if (!empty($ruta_destino)) {
                        $query .= ", fotos='$ruta_destino'";
                    }
                    $query .= " WHERE id='$id_producto'";
                    
                    // Ejecutar la consulta
                    if(mysqli_query($conexion, $query)) {
                        $mensaje = "Productos modificados correctamente.";
                    } else {
                        $mensaje = "Error al modificar los productos: " . mysqli_error($conexion);
                    }
                }
            }
        }
    }

    // Ejecutar la consulta para obtener los productos
    $query = "SELECT * FROM productos";
    $result = mysqli_query($conexion, $query);

    if (!$result) {
        die("Error al obtener los productos: " . mysqli_error($conexion));
    }
?>
  
   
    <form action="modificarProductos.php" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Foto</th>
                <th>Modificar</th>
            </tr>
            <?php
            // Mostrar los productos en el formulario
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><input type="text" name="nombre_<?php echo $row['id']; ?>" value="<?php echo $row['nombre']; ?>"></td>
                    <td><textarea name="descripcion_<?php echo $row['id']; ?>"><?php echo $row['descripcion']; ?></textarea></td>
                    <td><input type="text" name="precio_<?php echo $row['id']; ?>" value="<?php echo $row['precio']; ?>"></td>
                    <td><img src="<?php echo $row['fotos']; ?>" alt="<?php echo $row['nombre']; ?>" style="width: 100px;"></td>
                    <td>
                        <input type="file" name="imagen_<?php echo $row['id']; ?>" accept="image/*">
                        <input type="hidden" name="productos[]" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="modificar_producto" value="modificar_<?php echo $row['id']; ?>">Modificar</button>
                    </td>
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
        echo('Acceso denegado');
        // Destruir la sesión
        session_destroy();
    }
    ?>
</body>
</html>