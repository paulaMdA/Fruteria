<?php
session_start();
include 'functiones.php'; 

// Variable para almacenar el mensaje de éxito o error
$mensaje = "";

// Verificar si se envió el formulario de agregar al carrito
if(isset($_POST['agregar_carrito']) && isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] == 'comprador') {
    // Conectar a la base de datos
    $conexion = conectar();
    
    // Iterar sobre los productos para agregar al carrito
    foreach ($_POST['producto_id'] as $producto_id) {
        $cantidad = (int)$_POST['cantidad_' . $producto_id];

        // Verificar si la cantidad es mayor que cero para agregar al carrito
        if ($cantidad > 0) {
            // Insertar el producto en el carrito
            $query_insert = "INSERT INTO carrito (usuario_id, producto_id, cantidad, total) VALUES ({$_SESSION['usuario']['id_usr']}, $producto_id, $cantidad, (SELECT precio * $cantidad FROM productos WHERE id = $producto_id))";
            $result_insert = mysqli_query($conexion, $query_insert);
            if (!$result_insert) {
                die("Error al agregar producto al carrito: " . mysqli_error($conexion));
            }
            // Mostrar mensaje de éxito
            $mensaje = "Productos agregados al carrito exitosamente.";
        }
    }
}

?>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./css/productos.css">
    <title>Agregar Producto</title>
</head>
<body>

    <h1> Nuestros Productos</h1>

    <div class="productos" >
        <?php
        // Conectar a la base de datos
        $conexion = conectar();
        
        // Ejecutar la consulta para obtener los productos
        $query = "SELECT * FROM productos";
        $result = mysqli_query($conexion, $query);

        if (!$result) {
            die("Error al obtener los productos: " . mysqli_error($conexion));
        }


        
        // Ejecutar la consulta para obtener los productos
        $query = "SELECT * FROM productos";
        $result = mysqli_query($conexion, $query);

        if (!$result) {
            die("Error al obtener los productos: " . mysqli_error($conexion));
        }
         
        // Mostrar los productos en la tabla
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="producto">';
            echo '<h3>' . $row['nombre'] . '</h3>';
            echo '<p>' . $row['descripcion'] . '</p>';
            echo '<p>Precio: ' . $row['precio'] . '</p>';
            echo '<img src="' . $row['fotos'] . '" alt="' . $row['nombre'] . '">';
            
            // Mostrar el campo de cantidad y botón para agregar al carrito solo para el comprador
            if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] == 'comprador') {
                echo '<form action="" method="post">';
                echo '<input type="number" name="cantidad_' . $row['id'] . '" value="0" min="0">';
                echo '<input type="hidden" name="producto_id[]" value="' . $row['id'] . '">';
                echo '<input type="submit" name="agregar_carrito" value="Comprar">';
                echo '</form>';
            }
            
            echo '</div>';
        }
        ?>

    </div>
      <div class="form"> 
       <?php if(isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] == 'vendedor'): ?>
        <form action="agregarProducto.php" method="post">
            <input type="submit" name="agregar_productos" value="Agregar mas productos ">
        </form>
        <?php endif; ?>
        
        <!-- Botón para volver -->
        <form action="menu.php" method="post">
            <input type="submit" name="volver" value="Volver">
        </form>
    </div>
   
 
</body>
</html>