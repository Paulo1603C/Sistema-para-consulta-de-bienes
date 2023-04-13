
<?php

    include("conexion.php");

      $usuario = $_POST["usu"];
      $anio = $_POST["an"];
      $mes = $_POST["me"];
      $texto = $_POST["txt"];

      //echo "<input id='usuario' name='usuario' type='text' value='$usuario'\>";

      $select = sqlsrv_query($conn, "SELECT c.rol_codigo,c.ent_identificacion,c.rol_cargo,c.rol_sueldo,c.rol_elaborado FROM co_fun_rol c
      WHERE c.ent_identificacion='$usuario'
      AND YEAR(c.rol_elaborado)= '$anio'
      AND MONTH(c.rol_elaborado)='$mes'");
          
      echo "<table class='table'> <tr>
      <td>Código</td>
      <td>Identificación</td>
      <td>Cargo</td>
      <td>Sueldo</td>
      <td>Fecha</td>
      <td>Rol de Pagos</td>
      </tr>";

      while($fila = sqlsrv_fetch_array($select)){
          /*$id = $fila['ent_identificacion'];*/
          $cod = "".$fila['rol_codigo'];
          $cargo = utf8_encode("".$fila['rol_cargo']);
          echo "<tr>";
          echo "<td>".$cod."</td>";
          echo "<td>".$fila['ent_identificacion']."</td>";
          echo "<td>".$cargo."</td>";
          echo "<td>".$fila['rol_sueldo']."</td>";
          echo "<td>".$fila['rol_elaborado']->format('d/m/Y')."</td>";
          echo "<td >".'<a class="btn btn-outline-primary" href="reporte.php?co='.$fila['rol_codigo'].' &a='.$anio.' &m='.$mes. '&t='.$texto.'">Imprimir</a>'."</td>";
          "</tr>";
      }

      echo "</table>";
?>

<script type=text/javascript>

      //function print(codigo){
            //localStorage.setItem("codigo", this.codigo);
            //alert(this.codigo);
            //location.assign("reporte.php");
      //}

</script>



