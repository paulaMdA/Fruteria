<?php

    function conectar()
    {
        //Dato 
        $host = "localhost";
        $basededatos = "pasarela";
        $usuariodb = "pau";
        $clavedb = "kk";
        
        // Conexion.
        $conexion = mysqli_connect($host, $usuariodb, $clavedb, $basededatos) 
                or die("No se puede conectar con el servidor");
        return $conexion;
    }

?>

