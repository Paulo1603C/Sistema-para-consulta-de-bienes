<?php
      
      include("conexion.php");

      $user = $_SESSION['txtUsuario'];

      $cosulta = "SELECT  
      i.act_fi_identificador codigo,
      i.act_fi_nombre nombre,
      i.act_fi_marca marca,
      i.act_fi_modelo modelo,
      i.act_fi_serie serie,
      i.cta_co_codigo cuenta 
      FROM  activo_fijo_asignacion a, actfi_det_asignacion b,inv_activo_fijo i
      WHERE a.ent_identificacion='$user'
      AND a.asig_identificador = b.asig_identificador
      AND b.act_fi_identificador = i.act_fi_identificador";

    $stmt = sqlsrv_query($conn, $cosulta);

    $result = array();

   
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
            //array_push($result,$row)
            $result[] = print_r($row); 
        }

    echo json_encode($result);

?>  