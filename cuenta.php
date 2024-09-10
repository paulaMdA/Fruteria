<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cuenta</title>
    <link href="./css/cuenta.css" rel="stylesheet" type="text/css">
</head>
<?php
    
    include 'functiones.php';
    session_start();
    if(isset($_SESSION['usuario']))
    { 
        if(isset($_REQUEST['cambioCorreo']))
        {
            $correo = $_REQUEST['nuevoCorreo'];
            $confirmacion = $_REQUEST['confirmCorreo'];
            
            if($correo === $confirmacion)
            {
                $instruccion = "UPDATE `usuarios` SET `email`='$correo' WHERE id_usr='". $_SESSION['usuario']['id_usr'] . "'";
                $consulta = mysqli_query(conectar(), $instruccion) or die("NO");
            }
        }
        if(isset($_REQUEST['cambioNom']))
        {
            $nombre = $_REQUEST['nuevoNom'];
            $confirmacion = $_REQUEST['confirmNom'];
            
            if($nombre === $confirmacion)
            {
                $instruccion = "UPDATE `usuarios` SET `nombre`='$nombre' WHERE id_usr='". $_SESSION['usuario']['id_usr'] . "'";
                $consulta = mysqli_query(conectar(), $instruccion) or die("NO");
            }
            else
            {
                print "La confirmación del nombre ha de ser idéntica para poder realizar la operación..";
            }
        }
        if(isset($_REQUEST['cambioapellidos']))
        {
            $nuevoApellidos= $_REQUEST['nuevoApellidos'];
            $confirmacion = $_REQUEST['confirmApelellidos'];
            
            if($nuevoTlf === $confirmacion)
            {
                $instruccion = "UPDATE `usuarios` SET `apellidos`='$nuevoApellidos' WHERE id_usr='". $_SESSION['usuario']['id_usr'] . "'";
                $consulta = mysqli_query(conectar(), $instruccion) or die("NO");
            }
            else
            {
                echo "Los teléfonos han de ser idénticos para realizar el cambio.";
            }
        }
        if(isset($_REQUEST['cambioCon']))
        {
            $contraAntigua = $_REQUEST['conAnt'];
            $contraNueva = $_REQUEST['conNuev'];
            $confirmacion = $_REQUEST['confirmCon'];
            
            $instruccion = "select contrasena from usuarios where id_usr='". $_SESSION['usuario']['id_usr'] . "'";
            $consulta = mysqli_query(conectar(), $instruccion) or die("Fallo en la consulta");
            $row = mysqli_fetch_array($consulta);
            //echo "ROW: " . $row['contrasena'];
            if($contraAntigua === $row['contrasena'])
            {
                //echo "ENTRE1";
                if($contraNueva === $confirmacion)
                {
                    //echo "ENTR2";
                    $instruccion = "UPDATE `usuarios` SET `contrasena`='$contraNueva' WHERE id_usr='". $_SESSION['usuario']['id_usr'] . "'";
                    $consulta = mysqli_query(conectar(), $instruccion) or die("NO");
                }
                else
                {
                    
                    echo "AVISO: Las contraseñas han de ser idénticas para realizar el cambio.";
                }
            }
            else
            {
                echo "AVISO: La contraseña introducida no es la correcta.";
            }   
        }

?>
<div class="cosas">
    <div class="forms">
        <form action="cuenta.php">
            <table>
                <tr>
                    <th>Cambiar correo</th>
                </tr>
                <tr>
                    <td>
                        <input type="email" name="nuevoCorreo" placeholder="Nuevo correo"><br/><br/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="email" name="confirmCorreo" placeholder="Confirmar correo"><br/><br/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" name="cambioCorreo" value="Confirmar"/>
                    </td>
                </tr>
            </table>
        </form>

        <form action="cuenta.php">
            <table>
                <tr>
                    <th>Cambiar nombre</th>
                </tr>
                <tr>
                    <td><input type="text" name="nuevoNom" placeholder="Nuevo nombre"><br/><br/></td>
                </tr>
                <tr>
                    <td><input type="text" name="confirmNom" placeholder="Confirmar nombre"><br/><br/></td>
                </tr>
                <tr>
                    <td><input type="submit" name="cambioNom" value="Confirmar"/></TD>
                </tr>
            </table>
        </form>


        <form action="cuenta.php">
            <table>
                <tr>
                    <th>Cambiar apellidos</th>
                </tr>
                <tr>
                    <td><input type="text" name="nuevoApellidos" placeholder="Nuevos apellidos"><br/><br/></td>
                </tr>
                <tr>
                    <td><input type="text" name="confirmApellidos" placeholder="Confirmar apellidos"><br/><br/></td>
                </tr>
                <tr>
                    <td><input type="submit" name="cambioApellidos" value="Confirmar"/></td>
                </tr>
            </table>  
        </form>


        <form action="cuenta.php">
            <table>
                <tr>
                    <th>Cambiar contraseña</th>
                </tr>
                <tr>
                    <td><input type="text" name="conAnt" placeholder="Contraseña actual"><br/><br/></td>
                </tr>
                <tr>
                    <td><input type="text" name="conNuev" placeholder="Nueva contraseña"><br/><br/></td>
                </tr>
                <tr>
                    <td><input type="text" name="confirmCon" placeholder="Repetir nueva contraseña"><br/><br/></td>
                </tr>
                <tr>
                    <td><input type="submit" name="cambioCon" value="Confirmar"/></td>
                </tr>
            </table>
        </form>
    </div>
    <div class="vuelta">
        <form action="menu.php" method="post">
            <input type="submit" name="volverReg" value="Volver"/>
        </form>
    </div>
</div>
<?php
    }
    else
    {
        echo('Acceso denegado');
        print '<a href ="javascript:history.back()"><button>Volver</button></a>';
        session_destroy();
    }

?>