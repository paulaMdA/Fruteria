<!DOCTYPE html>
<?php
    include 'functiones.php';
    session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="./css/login.css" rel="stylesheet" type="text/css">
        <title>Inicio de Sesion</title>
      
    </head>
    <body>
        <h1>LOG IN</h1>
        <?php
        if(isset($_REQUEST['cerrSes']))
        {
            session_destroy();
        ?>
        <div class="box">     
            <div class="form">                
                <form action="menu.php" method="post">
                    <div class="inputBox">
                        <input type="text" name="usu"/>
                        <span>Correo</span>
                        <i></i>
                    </div>
                    <div class="inputBox">
                        <input type="password" name="con"/>
                        <span>Contraseña</span>
                        <i></i>
                    </div>
                    <input type="submit" name="enviar" value="Entrar"/>
                </form>
                <form action="registro.php" method="post" class="links">
                    <input type="submit" name="registro" value="Registrarse"/>
                </form>
            </div>            
        </div>
        <div></div>
        <?php  
        }
        else 
        {
            if(isset($_REQUEST['enviarReg']))
            {
                @$nombre = $_REQUEST['usu'];
                @$apellidos = $_REQUEST['apellidos'];
                @$email = $_REQUEST['email'];
                @$password = $_REQUEST['password'];
                @$passwordRepeat = $_REQUEST['passwordMatchInput'];
                
              
                
                if(empty($nombre) || empty($apellidos)|| empty($email) || empty($password) || empty($passwordRepeat) )
                {
                   echo "HAS DEJADO ALGÚN CAMPO INCOMPLETO";
                       
        ?>
        <div>
            <form action="registro.php" method="post" style="scale: 1.5;display: flex;justify-content: center;">
                <input type="submit" name="volverReg" value="Volver al registro" style="color: #45f3ff;width: 100%;border: none;cursor: pointer;background: #333;margin-bottom: 5px;">
            </form>
            <form action="login.php" method="post" style="scale: 1.5;display: flex;justify-content: center;">
                <input type="submit" name="volverLog" value="Volver al login" style="color: #45f3ff;width: 100%;border: none;cursor: pointer;background: #333;margin-top: 5px;">
            </form>
        </div>
        <?php
                }
                else
                {
                    if($password !== $passwordRepeat)
                    {
                        echo "LAS PASSWORDS NO SON IGUALES";
                        
        ?>
        <div>
            <form action="registro.php" method="post" style="scale: 1.5;display: flex;justify-content: center;">
                <input type="submit" name="volverReg" value="Volver al registro" style="color: #45f3ff;width: 100%;border: none;cursor: pointer;background: #333;margin-bottom: 5px;">
            </form>
            <form action="login.php" method="post" style="scale: 1.5;display: flex;justify-content: center;">
                <input type="submit" name="volverLog" value="Volver al login" style="color: #45f3ff;width: 100%;border: none;cursor: pointer;background: #333;margin-top: 5px;">
            </form>
        </div>
        <?php
                   }
                   else
                   {
                        ?>
                        <div class="box">     
                            <div class="form">                
                                <form action="menu.php" method="post">
                                    <div class="inputBox">
                                        <input type="text" name="usu"/>
                                        <span>Correo</span>
                                        <i></i>
                                    </div>
                                    <div class="inputBox">
                                        <input type="password" name="password"/>
                                        <span>Contraseña</span>
                                        <i></i>
                                    </div>
                                    <input type="submit" name="enviar" value="Entrar"/>
                                </form>
                                <form action="registro.php" method="post" class="links">
                                    <input type="submit" name="registro" value="Registrarse"/>
                                </form>
                            </div>            
                            </div>
                        <div></div>
                        <?php
                        $instruccion = "SELECT `id_usr`, `nombre`,`apellidos`,`email`,`password`,`rol` FROM `usuarios` WHERE email = '".$email."';";
                        $consulta = mysqli_query(conectar(), $instruccion);
                        $nfilasBusqueda = mysqli_num_rows($consulta);
                        if ($nfilasBusqueda > 0) {
                            echo "<h5>LO SENTIMOS PERO EL CORREO INTRODUCIDO YA EXISTE, VUELVA A REGISTRARSE</h5>";
                        } else {
                            $instruccion = "INSERT INTO usuarios VALUES (DEFAULT, '$nombre', '$apellidos', '$email', '$password', DEFAULT)";
                            $consulta = mysqli_query(conectar(), $instruccion);

                            if ($consulta) {
                                echo "<h2>Se ha registrado correctamente</h2>";
                            } else {
                                echo "Error al registrar el usuario: " . mysqli_error(conectar());
                            }
                        }
                    }
                }
            }
            else
            {
         ?>
        <div class="box">     
            <div class="form">                
                <form action="menu.php" method="post">
                    <div class="inputBox">
                        <input type="text" name="usu"/>
                        <span>Correo</span>
                        <i></i>
                    </div>
                    <div class="inputBox">
                        <input type="password" name="con"/>
                        <span>Contraseña</span>
                        <i></i>
                    </div>
                    <input type="submit" name="enviar" value="Entrar"/>
                </form>
                <form action="registro.php" method="post" class="links">
                    <input type="submit" name="registro" value="Registrarse"/>
                </form>
            </div>            
        </div>
        <div></div>
        <?php
            }
        }
        ?>       
    </body>
</html>