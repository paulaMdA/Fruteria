<!DOCTYPE html>
<html>
<head>
    <title>Administrar roles</title>
    <link rel="stylesheet" type="text/css" href="./css/administrar.css">
</head>
<body>
<?php
include 'functiones.php';
session_start();

if(isset($_SESSION['usuario'])) {
    echo "<h1>Administrar roles</h1>";

    if(isset($_REQUEST['actualizar'])) {
        $usuario = $_REQUEST['usuario'];
        $rol = $_REQUEST['rol'];       
        if($usuario == null) {
            print ("<h3>No hay usuario para cambiar</h3>");
        } else {
            $instrucciones = "UPDATE usuarios SET rol = '$rol' WHERE nombre = '$usuario'";
            $consultando = mysqli_query(conectar(), $instrucciones) or die ("No se puede realizar la operación");
            echo "<h3>Rol actualizado correctamente</h3>";
        }
    }

    if(isset($_REQUEST['search'])) {
        $usBuscado = $_REQUEST['keywords'];

        $instruccionBusqueda = "SELECT nombre, email, rol FROM usuarios WHERE nombre LIKE '$usBuscado%' AND rol = 'invitado'";
        $consultaBusqueda = mysqli_query(conectar(), $instruccionBusqueda) or die ("Fallo en la consulta");

        echo "<table border='1' class='tablaA'>";
        echo "<tr><th colspan='4'>Buscar usuario: <form action='administrar.php' method='POST'><input type='text' id='keywords' name='keywords' size='30' maxlength='30'><input type='submit' name='search' id='search' value='Buscar'></form></th></tr>";
        echo "<tr><th>Nombre</th><th>Correo</th><th>Rol</th><th>Actualizar</th></tr>";

        while($row = mysqli_fetch_assoc($consultaBusqueda)) {
            echo "<tr>";
            echo "<td>" . $row['nombre'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['rol'] . "</td>";
            echo "<td>";
            echo "<form action='administrar.php' method='post'>";
            echo "<input type='hidden' name='usuario' value='" . $row['nombre'] . "' >";
            echo "<select name='rol'>";
            echo "<option value='comprador'>Comprador</option>";
            echo "<option value='invitado' selected>Invitado</option>"; // Rol actual del usuario
            echo "</select>";
            echo "<input type='submit' name='actualizar' value='Actualizar'/>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<table border='1' class='tablaA'>";
        echo "<tr><th colspan='4'>Buscar usuario: <form action='administrar.php' method='POST'><input type='text' id='keywords' name='keywords' size='30' maxlength='30'><input type='submit' name='search' id='search' value='Buscar'></form></th></tr>";
        echo "<tr><th>Nombre</th><th>Correo</th><th>Rol</th><th>Actualizar</th></tr>";

        $instruccion = "SELECT nombre, email, rol FROM usuarios WHERE rol = 'invitado'";
        $consulta = mysqli_query(conectar(), $instruccion) or die ("Fallo en la consulta");

        while($row = mysqli_fetch_assoc($consulta)) {
            echo "<tr>";
            echo "<td>" . $row['nombre'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['rol'] . "</td>";
            echo "<td>";
            echo "<form action='administrar.php' method='post'>";
            echo "<input type='hidden' name='usuario' value='" . $row['nombre'] . "' >";
            echo "<select name='rol'>";
            echo "<option value='comprador'>Comprador</option>";
            echo "<option value='invitado' selected>Invitado</option>"; // Rol actual del usuario
            echo "</select>";
            echo "<input type='submit' name='actualizar' value='Actualizar'/>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    }
?>
<form action="menu.php" method="post">
    <input type="submit" name="volverMenu" value="Volver al menú"/>
</form>
<?php
} else {
    echo('Acceso denegado');
    echo '<a href ="login.php"><button>Volver</button></a>';
    session_destroy();
}
?>
</body>
</html>