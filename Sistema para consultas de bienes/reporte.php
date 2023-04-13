<?php
    
    include("conexion.php");
    include("Plantilla.php");

    $usuario = $_SESSION['txtUsuario'];
    $mes = $_GET['m'];
    $anio = $_GET['a'];
    $texto = $_GET['t'];
    //$string = fullname($mes);
    //$celWidth = $pdf->GetStringWidth($mes);

    $select = sqlsrv_query($conn, "SELECT f.ent_identificacion ,f.ent_nombre,f.ent_apellido,c.rol_cargo
    FROM funcionario f,departamento d,co_fun_rol c
    WHERE
    f.dep_codigo = d.dep_codigo and
    f.ent_identificacion=c.ent_identificacion
    and f.ent_identificacion='$usuario' and c.rol_codigo in (SELECT max(c.rol_codigo) FROM co_fun_rol c WHERE c.ent_identificacion='$usuario' 
    AND YEAR(c.rol_elaborado)= '$anio'
    AND MONTH(c.rol_elaborado)='$mes')
    group by f.ent_identificacion,f.ent_nombre,f.ent_apellido,c.rol_cargo
    order by 4 asc" );

    
    $pdf = new PDF();
    $pdf-> AliasNbPages();
    $pdf->AddPage();
    //$pdf->SetFont('Arial','',9);
    
    //Cabecera Datos Persona
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(20,10,utf8_decode('Cédula'), 'B',0,'C',0);
    $pdf->Cell(40,10,'Nombre','B',0,'C',0);
    $pdf->Cell(45,10,'Apellido','B',0,'C',0);
    //$pdf->Cell(40,10, $fila['dep_nombre'], 0,1,'C',0);
    $pdf->Cell(85,10,'Cargo','B',1,'C',0);

    $pdf->SetFont('Arial','',9);
    while($fila = sqlsrv_fetch_array($select)){
        $pdf->Cell(20,10, $fila['ent_identificacion'],'B',0,'C',0);
        $pdf->Cell(40,10, $fila['ent_nombre'],'B',0,'C',0);
        $pdf->Cell(45,10, $fila['ent_apellido'],'B',0,'C',0);
        //$pdf->Cell(40,10, $fila['dep_nombre'], 0,1,'C',0);
        $pdf->Cell(85,10, $fila['rol_cargo'],'B',0,'C',0);
    }

    $pdf->Ln(15);

    //Titulo
    $pdf->Rect(10,55,190,233,'D');
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(50);
    $pdf->Cell(40,10,'Rol de Pagos',0,0,'C');
    //$pdf->Cell(10,10,' - ',0,0,'C',0);
    $pdf->Cell(40,10,$texto,0,0,'C');
    //$pdf->Cell(10,10,' - ',0,0,'C',0);
    $pdf->Cell(15,10,$anio,0,1,'C');

    $pdf->Ln(2);
    //Detalle del Rol
    include("detalleIngresos.php");
    $pdf->Ln(2);
    //Detalle Ingresos
    include("totalIngreso.php");
    $pdf->Ln(12);
    //Detalle Egresos
    include("detalleEgreso.php");
    //Suma Egresos
    include("totalEgreso.php");
    $pdf->Ln(12);
    //Valor Neto Ganancia
    include("sueldoFinal.php");
    $pdf->Output();
?>
