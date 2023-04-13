<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8_decode">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="img/menu.png">
  <script src="js/jquery.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="css/rolPagos.css">
  <!--Estilos del paginador-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"> 
  <!-- Estos estilos estan aqui por que no agarran desde la hoja externa rolPagos.css-->
  <style>
    .info td:hover{
      background:#ABB2B9;
      font-size: 17px;
    }
    .btn_imprimir{
      position: relative;
      top: 10px;
      left:94.5%;
    }
    @media all and (max-width: 1086px) {
    /*Enter code for responsive*/
      .btn_imprimir{
        position: relative;
        top: 10px;
        left:88%;
      }
    }
  </style>
  <title>Inicio</title>
</head>

<body>

  <nav class="navbar navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="img/logo.png" alt="" width="200" height="50" class="d-inline-block align-text-top">
      </a>
      <a class="btn btn-danger" href="logout.php">Salir</a>
    </div>
  </nav>
  <br>

  <section class="p-3 mb-2 bg-light text-dark" style="padding-left: 5%; padding-right: 5%;">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">

          <?php

          include("conexion.php");

          $user = $_SESSION['txtUsuario'];
          echo "<input id='usuario' name='usuario' type='hidden' value='$user'\>";

          $select = sqlsrv_query($conn, "SELECT  f.ent_identificacion ,f.ent_nombre,f.ent_apellido, c.rol_cargo
          FROM funcionario f,departamento d,co_fun_rol c
          WHERE
          f.dep_codigo = d.dep_codigo and
          f.ent_identificacion=c.ent_identificacion
          and f.ent_identificacion='$user' and c.rol_codigo in (SELECT max(c.rol_codigo) FROM co_fun_rol c WHERE c.ent_identificacion='$user')
          group by f.ent_identificacion,f.ent_nombre,f.ent_apellido,c.rol_cargo
          order by 4 asc");
          echo "<h2>Información</h2>";

          echo "<table class='table'> <tr>
                      <td>Identificación</td>
                      <td>Nombre</td>
                      <td>Apellido</td>
                      <td>Cargo</td>
                      </tr>";

          while ($fila = sqlsrv_fetch_array($select)) {
            /*$id = $fila['ent_identificacion'];*/
            $cargo = utf8_encode("". $fila['rol_cargo']);
            echo "<tr>";
            echo "<td>" . $fila['ent_identificacion'] . "</td>";
            echo "<td>" . $fila['ent_nombre'] . "</td>";
            echo "<td>" . $fila['ent_apellido'] . "</td>";
            //echo "<td>" . $fila['ent_actividades_a'] . "</td>";
            echo "<td>" . $cargo. "</td>";
            "</tr>";
          }

          echo "</table>";

          ?>
        </div>

        <br>
        <br>

        <!--QUERY PARA EL INVENTARIO */-->
    <?php

      include("conexion.php");

      $user = $_SESSION['txtUsuario'];
      echo "<input id='usuario' name='usuario' type='hidden' value='$user'\>";

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
      AND b.act_fi_identificador = i.act_fi_identificador
      order by nombre";

      $select = sqlsrv_query($conn, $cosulta);

      ?>



     <br>
      
      
     <h1>Inventario</h1>

      <table id="tablax" class="table table-striped table-bordered info" style="width:100%">
        <thead>
          <tr>
            <td><b>ID</b></td>
            <td><b>Código</b></td>
            <td><b>Nombre</b></td>
            <td><b>Marca</b></td>
            <td><b>Modelo</b></td>
            <td><b>Serie</b></td>
            <!--<td><b>Cuenta</b></td>-->
          </tr>
        </thead>

        <tbody>
        <?php
          header('Content-Type: text/html; charset=UTF-8');
          $i=1;
          while ($fila = sqlsrv_fetch_array($select)) {?>
              <tr>
                  <td><?php echo $i ?></td>
                  <td><?php echo utf8_encode($fila['codigo']) ?></td>
                  <td><?php echo utf8_encode($fila['nombre']) ?></td>
                  <td><?php echo utf8_encode($fila['marca']) ?></td>
                  <td><?php echo utf8_encode($fila['modelo']) ?></td>
                  <td><?php echo utf8_encode($fila['serie']) ?></td>
                  <!--<td><?php echo utf8_encode($fila['cuenta']) ?></td>-->
              </tr>
            
            <?php $i++; } ?>  
        </tbody>
        
      </table>

      <div class="btns" >
        <a class="btn btn-outline-primary btn_imprimir" href="reportesInventario.php" target="blank" >Imprimir</a>
      </div>

      </div>
    </div>
  </section>

</body>

</html>

<script type="text/javascript">
  $('#enviar').click(function() {
    var usuario = document.getElementById('usuario').value;
    var anio = document.getElementById('anio').value;
    var mes = document.getElementById('mes').value;
    var mest = document.getElementById('mes');
    var mestext = mest.options[mest.selectedIndex].text;

    var ruta = "usu=" + usuario + "&an=" + anio + "&me=" + mes + "&txt=" + mestext;

    $.ajax({
        url: 'buscarrol.php',
        type: 'POST',
        data: ruta,
      })
      .done(function(res) {
        $('#table').html(res)
      });
  });
0

  /*paginador */
  <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous">
        </script>
    <!-- DATATABLES -->
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js">
    </script>
    <!-- BOOTSTRAP -->
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js">
    </script>

    <script>
        $(document).ready( function () {
            $('#tablax').DataTable();
        });
    </script>

</script>