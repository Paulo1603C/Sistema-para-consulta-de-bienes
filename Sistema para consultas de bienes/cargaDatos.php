<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Document</title>
</head>
<body>
    
</body>
</html>
<?php  

include("conexion.php");




if(isset($_POST['selec'])){
    $usuario = $_POST['txtUsuario'];
    //$fecha = $_POST['txtfecha'];
    //echo "$fecha";

    $select = sqlsrv_query($conn,"SELECT * FROM funcionario WHERE ent_identificacion = '$usuario'");
    $row = sqlsrv_fetch_array($select);

    if(is_array($row)){
        $_SESSION["txtUsuario"] = $row['ent_identificacion'];
        //$fecha = $row['f.ent_nacimiento'];
    } else {
        echo "<script>
        Swal.fire({
          title: 'Cédula incorrecta',
          text: 'Operación inválida, revice la la cédula este ingresada correctamente',  
          icon: 'warning'
          }).then(function(){
              location.href='index.php';
          });
        </script>"; 
    }
}

if(isset($_SESSION["txtUsuario"])){
    header("Location:rolPagos.php");
}
?>

