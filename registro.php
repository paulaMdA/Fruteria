<!DOCTYPE html>
<?php
    session_start();
?>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="./css/registro.css">
        <title></title>
    </head>
    <body>
        <?php
        if(isset($_REQUEST['registro']) || isset($_REQUEST['volverReg']))
        {
        ?>
        <div class="form"> 
            <form action="login.php" method="post">
                <label>Nombre de usuario</label><br>
                <input type="text" name="usu"/><br/>
                  <label>Apellidos</label><br>
                <input type="text" name="apellidos"/><br/>
                <label>Correo electronico</label><br>
                <input type="email" name="email"/><br/>
                <label>Contraseña</label><br>
                <input type="password" name="password"/><br/>
                <label>Repite la contraseña</label><br>
                <input type="password" name="passwordMatchInput"/><br/>
                <input type="submit" name="enviarReg" value="Registrarse"/>
                <form action="menu.php" method="post">
                    <input type="submit" name="volverReg" value="Volver"/>
            </form>            
        </div>
        <div class="loader">
            <div class="semi-circle"></div>
            <div class="bolas"></div>
            <div class="bolas bolas2"></div>                    
        </div>                   
        <?php
        }
        ?>
    </body>
</html>
