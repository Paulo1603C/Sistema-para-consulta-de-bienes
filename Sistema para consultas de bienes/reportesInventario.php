<?php

//include('plantillaInventario.php');
include("conexion.php");
include("pdf_mc_table.php");
$usuario = $_SESSION['txtUsuario'];

//DATOS PERSONLES 
$select = sqlsrv_query($conn, "SELECT  f.ent_identificacion ,f.ent_nombre,f.ent_apellido, c.rol_cargo
FROM funcionario f,departamento d,co_fun_rol c
WHERE
f.dep_codigo = d.dep_codigo and
f.ent_identificacion=c.ent_identificacion
and f.ent_identificacion='$usuario' and c.rol_codigo in (SELECT max(c.rol_codigo) FROM co_fun_rol c WHERE c.ent_identificacion='$usuario')
group by f.ent_identificacion,f.ent_nombre,f.ent_apellido,c.rol_cargo
order by 4 asc");

// Creación del objeto de la clase heredada
$pdf = new PDF_MC_Table();
$pdf->AddPage();
$pdf->SetFont( 'Arial','', 14 );
$pdf->SetWidths(Array(10,12,50,35,50,33));
$pdf->SetLineHeight(5);

$pdf->SetFont('Times','',12);

    //Cabecera Datos Persona
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(20,10,utf8_decode('Cédula'), 'B',0,'C',0);
    $pdf->Cell(40,10,'Nombre','B',0,'C',0);
    $pdf->Cell(45,10,'Apellido','B',0,'C',0);
    $pdf->Cell(85,10,'Cargo','B',1,'C',0);

    //CARGA DE DATOS
    $pdf->SetFont('Arial','',8);
    while($fila = sqlsrv_fetch_array($select)){
        $pdf->Cell(20,10, $fila['ent_identificacion'],'B',0,'C',0);
        $pdf->Cell(40,10, $fila['ent_nombre'],'B',0,'C',0);
        $pdf->Cell(45,10, $fila['ent_apellido'],'B',0,'C',0);
        $pdf->Cell(85,10, $fila['rol_cargo'],'B',0,'C',0);
    }

    $pdf->Ln(12);

    //CARGA DE DATOS DE INVENTARIO
    $cosulta = "SELECT
      i.act_fi_identificador codigo,
      i.act_fi_nombre nombre,
      i.act_fi_marca marca,
      i.act_fi_modelo modelo,
      i.act_fi_serie serie,
      i.cta_co_codigo cuenta 
      FROM  activo_fijo_asignacion a, actfi_det_asignacion b,inv_activo_fijo i
      WHERE a.ent_identificacion='$usuario'
      AND a.asig_identificador = b.asig_identificador
      AND b.act_fi_identificador = i.act_fi_identificador
      order by nombre";

    $selectInventario = sqlsrv_query($conn, $cosulta);

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(20,10,utf8_decode('BIENES'), 'B',0,'C',0);

    $pdf->Ln(10);

    //Cabecera Datos Persona
    $pdf->SetFont( 'Arial','B', 11 );
    $pdf->Row(Array(
        "ID",
        "COD",
        "NOMBRE",
        "MARCA",
        "MODELO",
        "SERIE",
    ));

    //CARGA DE DATOS
    $i=1;
    $pdf->SetFont('Arial','',10);
    while($fila = sqlsrv_fetch_array($selectInventario)){
        $pdf->Row(Array(
            $i,
            $fila['codigo'],
            $fila['nombre'],
            $fila['marca'],
            $fila['modelo'],
            $fila['serie'],
        ));  
    $i++;
    }


$pdf->Output();
 
?>