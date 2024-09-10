<?php
session_start();
include 'functiones.php'; 

// Variable para almacenar el mensaje de éxito o error
$mensaje = "";

// Verificar si se envió el formulario de agregar producto
if(isset($_POST['agregar_producto'])) {
  
    if(isset($_POST['nombre'], $_POST['descripcion'], $_POST['precio'], $_FILES['imagen'])) {
        // Obtener los datos del formulario
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];

        // Procesar la imagen
        $imagen = $_FILES['imagen'];
        $ruta_destino = './img/' . $imagen['name']; 
        move_uploaded_file($imagen['tmp_name'], $ruta_destino);

        // Insertar el producto en la base de datos
        $conexion = conectar();
        $query = "INSERT INTO productos (nombre, descripcion, precio, fotos) VALUES ('$nombre', '$descripcion', '$precio', '$ruta_destino')";
        if(mysqli_query($conexion, $query)) {
         
        } else {
            // Si hay un error en la consulta, mostrar mensaje de error
            $mensaje = "Error al agregar el producto: " . mysqli_error($conexion);
        }
    } else {
        $mensaje = "Error: Los datos del formulario no fueron enviados correctamente.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./css/agregarProducto.css">
    <title>Agregar Producto</title>
</head>
<body>
     <h1>Agregar Más Productos </h1>
    <div class="container">
        <!-- Formulario -->
        <div class="form-container"> 
           
            <?php echo $mensaje; ?>
            <?php if ($_SESSION['usuario']['rol'] == 'vendedor' ): ?>
                <form action="agregarProducto.php" method="post" enctype="multipart/form-data" class="form">
                    <label for="nombre">Nombre del producto:</label><br>
                    <input type="text" name="nombre" required><br>
                    
                    <label for="descripcion">Descripción:</label><br>
                    <textarea name="descripcion" required></textarea><br>
                    
                    <label for="precio">Precio:</label><br>
                    <input type="text" name="precio" required><br>
                    
                    <label for="imagen">Imagen:</label><br>
                    <input type="file" name="imagen" accept="image/*" required><br>
                    
                    <input type="submit" name="agregar_producto" value="Agregar Producto">
                </form>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] == 'comprador'): ?>
                <form action="" method="post" class="form">
                    <input type="number" name="cantidad_<?php echo $row['id']; ?>" value="0" min="0">
                    <input type="hidden" name="producto_id[]" value="<?php echo $row['id']; ?>">
                    <input type="submit" name="agregar_carrito" value="Agregar al carrito" class="comprador">
                </form>
            <?php endif; ?>
            
            <!-- Botón para volver -->
            <form action="menu.php" method="post" class="form">
                <input type="submit" name="volver" value="Volver">
            </form>
        </div>

        <!-- Imagen -->
        <div class="image-container">
            <img src="./img/tienda3.jpeg" alt="tienda">
        </div>
    </div>
</body>
</html>