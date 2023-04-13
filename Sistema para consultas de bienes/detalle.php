
<?php

include("conexion.php");
//include("Plantilla.php");

//$cod = "<script>document.write(localStorage.getItem('codigo'))</script>";
$code = $_GET['co'];


//Detalle ROl Pagos
$select = sqlsrv_query($conn,"SELECT 'SUELDO' TIPO,'REMUNERACION UNIFICADA' DETALLE, c.rol_sueldo_cargo FROM co_fun_rol c
WHERE c.rol_codigo='$code'
UNION ALL
select C.rol_ru_tipo TIPO,C.rol_ru_nombre DETALLE,C.rol_ru_monto from co_fun_rol_detallle C
where rol_codigo='$code'
ORDER BY 3 DESC");

//Cabecera Detalle Rol
$pdf->SetFont('Arial','B',9);
$pdf->Cell(15);
$pdf->Cell(30,10,utf8_decode('Tipo'),'B',0,'C',0);
$pdf->Cell(90,10,'Detalle','B',0,'C',0);
$pdf->Cell(40,10,'Sueldo','B',1,'R',0);

$pdf->SetFont('Arial','',9);
while($fila = sqlsrv_fetch_array($select)){
    $pdf->Cell(15);
    $pdf->Cell(30,10, $fila['TIPO'],1,0,'C',0);
    $pdf->Cell(90,10, $fila['DETALLE'],1,0,'C',0);
    $pdf->Cell(40,10, $fila['rol_sueldo_cargo'],1,1,'R',0);
}

?>