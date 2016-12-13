<?php 
require_once('jasper/class/tcpdf/config/lang/eng.php');
require_once('jasper/class/tcpdf/tcpdf.php');


class MYPDF extends TCPDF {
	
	public function Header() {
		// Logo
		//$image_file = K_PATH_IMAGES.'logo_example.jpg';
		//$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('times', '', 14);
		// Title
		$this->Cell(0, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('times', 'B', 8);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
	
	

}
