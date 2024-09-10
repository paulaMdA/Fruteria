<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menu</title>
    <link href="./css/menu.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
include 'functiones.php';
session_start();

if(isset($_REQUEST['enviar'])) {
    @$usu = $_REQUEST['usu'];
    @$password = $_REQUEST['con'];

    if(empty($usu) || empty($password)) {
        echo "Has dejado algún campo sin rellenar.";
        $vacio = true;
        ?>
        <div>
            <form action="registro.php" method="post">
                <input type="submit" name="volverReg" value="Volver al registro"/>
            </form>
            <form action="login.php" method="post">
                <input type="submit" name="volverLog" value="Volver al login"/>
            </form>
        </div>
        <?php
    } else {
        $instruccion = "select * from usuarios where email = '$usu' AND password= '$password'";

        $consulta = mysqli_query(conectar(), $instruccion)
            or die ("Fallo en la consulta");
        $resultado = mysqli_fetch_array($consulta);
        
        if($resultado) {
            $_SESSION['usuario'] = $resultado;
            $vacio = false;
        } else {
            echo "Usuario o contraseña incorrectos.";
            exit;
        }
    }
}

if(@$vacio == false) {
    if(isset($_SESSION['usuario'])) {
        $nom= $_SESSION['usuario']['email'];
        $rol = $_SESSION['usuario']['rol'];
        echo "<h1>Usuario actual:$nom</h1>";
        
        if($rol == 'vendedor') {
            ?>
            <div class="menu-container">
                <form action="administrar.php" method="post">
                    <input type="submit" name="enviar" value="Administrar"/>
                </form>
                <form action="productos.php" method="post">
                    <input type="submit" name="enviar" value="Ver Productos"/>
                </form>
                <form action="carrito.php" method="post">
                    <input type="submit" name="enviar" value="Ver Carrito"/>
                </form>
                <form action="agregarProducto.php" method="post">
                    <input type="submit" name="enviar" value="Añadir Productos"/>
                </form>
                <form action="modificarProductos.php" method="post">
                    <input type="submit" name="enviar" value="Modificar Productos"/>
                </form>
                <form action="eliminarProductos.php" method="post">
                    <input type="submit" name="enviar" value="Eliminar Productos"/>
                </form>
            </div>
            <?php
        } elseif ($rol == 'comprador') {
            ?>
            <div class="menu-container">
                <form action="productos.php" method="post">
                    <input type="submit" name="enviar" value="Ver Productos"/>
                </form>
                <form action="carrito.php" method="post">
                    <input type="submit" name="enviar" value="Ver Carrito"/>
                </form>
                <form action="micompra.php" method="post">
                    <input type="submit" name="enviar" value="Mis Compras"/>
                </form>
            </div>
            <?php
        } elseif ($rol == 'invitado') {
            ?>
            <div class="menu-container">
                <form action="productos.php" method="post">
                    <input type="submit" name="enviar" value="Ver Productos"/>
                </form>
            </div>
            <?php
        }
        ?>
        <div class="menu-container">
            <form action="cuenta.php" method="post">
                <input type="submit" name="config" value="Cuenta"/>
            </form>
            <form action="login.php" method="post">
                <input type="submit" name="cerrSes" value="Cerrar Sesión"/>
            </form>
        </div>
        <img src="./img/tienda2.jpeg">
        <?php
    } else {
        echo('Acceso denegado');
        print '<br>';
        print '<a href ="login.php"><button class="back">Volver</button></a>';
        session_destroy();
    }
}
?>
</body>
</html>