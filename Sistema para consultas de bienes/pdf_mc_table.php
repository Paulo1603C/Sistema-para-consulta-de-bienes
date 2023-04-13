<?php
//call main fpdf file
require('fpdf/fpdf.php');

//create new class extending fpdf class  
class PDF_MC_Table extends FPDF {

    //codigo de la plantilla de reportes

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
        $this->SetY(-22);
        $this->Cell(5);
        $this->SetFont('Arial','',9);
        $this->MultiCell(180,3,utf8_decode('Todos los bienes indicados en este documnento se encuentra ingresados en los inventarios de activos fijos, cualquier bien que no conste a su nombre favor acercarse a la unidad de activos fijos para su verificación.'),0,'C',false);
        //Establecer Fecha
        $this->SetY(-13);
        $this->Cell(10);
        $this->SetFont('Arial','',10);
        date_default_timezone_set('America/Guayaquil');
        $this->Cell(40,5,'Fecha: '. date("d/m/y h:i:s a", time()),0,0,'C');
        // Posición: a 1,5 cm del final
        $this->SetY(-9);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10, utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
    }

// variable to store widths and aligns of cells, and line height
var $widths;
var $aligns;
var $lineHeight;

//Set the array of column widths
function SetWidths($w){
    $this->widths=$w;
}

//Set the array of column alignments
function SetAligns($a){
    $this->aligns=$a;
}

//Set line height
function SetLineHeight($h){
    $this->lineHeight=$h;
}

//Calculate the height of the row
function Row($data)
{
    // number of line
    $nb=0;

    // loop each data to find out greatest line number in a row.
    for($i=0;$i<count($data);$i++){
        // NbLines will calculate how many lines needed to display text wrapped in specified width.
        // then max function will compare the result with current $nb. Returning the greatest one. And reassign the $nb.
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    }
    
    //multiply number of line with line height. This will be the height of current row
    $h=$this->lineHeight * $nb;

    //Issue a page break first if needed
    $this->CheckPageBreak($h);

    //Draw the cells of current row
    for($i=0;$i<count($data);$i++)
    {
        // width of the current col
        $w=$this->widths[$i];
        // alignment of the current col. if unset, make it left.
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //calculate the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
}
?>