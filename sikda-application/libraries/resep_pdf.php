<?php
/**
 * @see http://www.fpdf.org
 */
class Resep_PDF extends FPDF
{
	var $page_width= 240, $page_height=280;
	function Header(){
	    $this->SetFont('Arial','B',24);
	    $this->Cell(0,26,"RESEP OBAT",0,1,'C');
	    // Title
	    // Line break
	   	$this->fullLine(30);
	}
	function Footer(){
		$this->fullLine($this->page_height);
	}
	function fullLine($y){
	    $this->Line(10,$y,$this->page_width-40,$y);
	}
	function keyValue($key, $value, $next=1){
		$height=9;
		$l_space = 50;
		$this->Cell($l_space, $height, $key,0,0);
		$this->Cell(0,$height,": ".$value,0,$next);
	}
	function tabValue($no, $obat, $dosis, $qty, $obat_align="L", $next=1){
		$height = 12;
		$this->Cell(13,$height,"  ".$no,0,0,"C");
		$this->Cell(5,$height," ");
		$this->Cell(115,$height,$obat,0,0,$obat_align);
		$this->Cell(30,$height,$dosis,0,0,"C");
		$this->Cell(30,$height,$qty,0,$next,"C");
	}
}