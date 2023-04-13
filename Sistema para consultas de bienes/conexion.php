<?php
if(!isset($_SESSION))
{ 
session_start();
}
    /*$nombreServidor = "JHONPC\PELILEO";
    $conexion = array("Database"=>"dbame", "UID" => "sa", "PWD" => "bdpelileo21");*/
    $nombreServidor = "192.168.69.3, 1433";
    $conexion = array("Database"=>"dbame", "UID" => "sa", "PWD" => "sql123*");
    $conn = sqlsrv_connect($nombreServidor, $conexion);

    if(!$conn){
        echo "La conexión falló";
    die(print_r(sqlsrv_errors(), true));
    }
?>