<?php

require('fpdf/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
    function Header()
    {
        $this->Ln(5);
        $this->Rect(10,10,190,40,'D');
        // Logo
        $this->Image('img/menu.png',25,15,33);
        // Arial bold 15
        $this->SetFont('Arial','B',12);
        // Movernos a la derecha
        $this->Cell(60);
        // Título
        $this->Cell(120,10, utf8_decode('GOBIERNO AUTÓNOMO DESCENTRALIZADO MUNICIPAL'),0,0,'C');
        $this->Ln(7);
        $this->Cell(80);
        $this->Cell(80,10, utf8_decode('DEL CANTÓN SAN PEDRO DE PELILEO'),0,0,'C');
        $this->Ln(7);
        $this->Cell(70);
        $this->Cell(100,10, utf8_decode('Dirección: Av. 22 de Julio s/n y Padre Chacón'),0,0,'C');
        $this->Ln(7);
        $this->Cell(80);
        $this->Cell(80,10, utf8_decode('Telf.:(03) 2996700 - R.U.C 1860000640001'),0,0,'C');
        $this->Ln(15);
        
        $this->Ln(5);

    }

    // Pie de página
    function Footer()
    {

        //Mensaje
        $this->SetY(-35);
        $this->Cell(5);
        $this->SetFont('Arial','',9);
        $this->MultiCell(180,3,utf8_decode('Todos los bienes indicados en este documnento se encuentra ingresados en los inventarios de activos fijos, cualquier bien que no conste a su nombre favor acercarse a la unidad de activos fijos para su verificación.'),0,'C',false);
        //Establecer Fecha
        $this->SetY(-18);
        $this->Cell(10);
        $this->SetFont('Arial','',10);
        date_default_timezone_set('America/Guayaquil');
        $this->Cell(40,5,'Fecha: '. date("d/m/y h:i:s a", time()),0,0,'C');
        // Posición: a 1,5 cm del final
        $this->SetY(-10);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10, utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
    }
}

?>