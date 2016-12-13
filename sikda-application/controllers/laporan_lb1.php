<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Laporan_lb1 extends CI_Controller {
	public function index()
	{
		$this->load->view('t_pelayanan/v_pelayanan');
	}
	
	public function createexcel()
	{
		require_once dirname(__FILE__) . '/../libraries/PHPExcel/Classes/PHPExcel.php';
		
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("SIKDA")->setTitle("LB1")->setSubject("LB1")->setDescription("LB1");		
		
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Column Title 1')
					->setCellValue('B1', 'Column Title 2')
					->setCellValue('C1', 'Column Title 3')
					->setCellValue('D1', 'Column Title 4');

		$objPHPExcel->getActiveSheet()->setTitle('Laporan Bulanan 1');

		$objPHPExcel->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="LaporanBulanan1'.date('Ymdhis').'.xls"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}
	
	public function createpdf()
	{
		require_once dirname(__FILE__) . '/../libraries/tcpdf/config/lang/eng.php';
		require_once dirname(__FILE__) . '/../libraries/tcpdf/tcpdf.php';
		
		$html ='';
		$html .='
		<table width="100%" align="left">  
			<tr>
			<td width="13%"><strong>Puskesmas</strong></td>
			<td width="2%"><strong>:</strong></td>
			<td width="85%" colspan="14">&nbsp;</td>
			</tr>
			<tr>
			<td><strong>Periode </strong></td>
			<td><strong>:</strong></td>
			<td colspan="14">&nbsp;</td>
			</tr>
		</table>';
		$html .='
			<table width="100%" border="1">
			<tr align="center">
				<th rowspan="3">No</th>
				<th rowspan="3">Kode</th>
				<th rowspan="3">Penyakit</th>
				<th colspan="4">0-7 Hr </th>
				<th colspan="4">8-28 Hr </th>
				<th colspan="4">1Bl-&lt;1Th</th>
				<th colspan="4">1 - 4 Th </th>
				<th colspan="4">5 - 9Th </th>
				<th colspan="4">10 - 14Th </th>
				<th colspan="4">15 - 19Th </th>
				<th colspan="4">20-44Th </th>
				<th colspan="4">45-44Th</th>
				<th colspan="4">55-59Th</th>
				<th colspan="4">60-69Th</th>
				<th colspan="4">&gt;70Th</th>
				<th colspan="5">Total</th>
			</tr>
			<tr align="center">
				<td colspan="2">Baru</td>
				<td colspan="2">Lama</td>
				<td colspan="2">Baru</td>
				<td colspan="2">Lama</td>
				<td colspan="2">Baru</td>
				<td colspan="2">Lama</td>
				<td colspan="2">Baru</td>
				<td colspan="2">Lama</td>
				<td colspan="2">Baru</td>
				<td colspan="2">Lama</td>
				<td colspan="2">Baru</td>
				<td colspan="2">Lama</td>
				<td colspan="2">Baru</td>
				<td colspan="2">Lama</td>
				<td colspan="2">Baru</td>
				<td colspan="2">Lama</td>
				<td colspan="2">Baru</td>
				<td colspan="2">Lama</td>
				<td colspan="2">Baru</td>
				<td colspan="2">Lama</td>
				<td colspan="2">Baru</td>
				<td colspan="2">Lama</td>
				<td colspan="2">Baru</td>
				<td colspan="2">Lama</td>
				<td colspan="2">Baru</td>
				<td colspan="2">Lama</td>
				<td rowspan="2">JML</td>
			</tr>
			<tr align="center">
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
			</tr>';
		
		$html .='
			<tr align="center">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>';
			
		$html .='
			<tr align="center">
			<td colspan="3" align="right"><strong>JUMLAH</strong></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			</tr>
			</table>

			<br/><br/><br/>	
			<table width="100%" align="left">
			<tr>
			<td><strong>Kepala Puskesmas</strong></td>
			</tr>
			<tr>
			<br/><br/>
			<td><strong>(Nama)</strong></td>
			</tr>
			</table>
		';

		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->setLanguageArray($l);
		$pdf->AddPage('L', 'A4');
		$pdf->SetFont('helvetica','',7);
		$pdf->writeHTML($html, true, false, false, false, '');		
		$rand = rand(1000,9999);
		$pdf->Output('Laporan_Bulanan_1_'.$rand.'.pdf', 'I');

	}
	
	public function createpdf2()
	{
		require_once dirname(__FILE__) . '/../libraries/dompdf/dompdf_config.inc.php';
		
		$html ='';
		$html .='
		<table width="100%" align="left">  
			<tr>
			<td width="13%"><strong>Puskesmas</strong></td>
			<td width="2%"><strong>:</strong></td>
			<td width="85%" colspan="14">&nbsp;</td>
			</tr>
			<tr>
			<td><strong>Periode </strong></td>
			<td><strong>:</strong></td>
			<td colspan="14">&nbsp;</td>
			</tr>
		</table>';
		$html .='
			<table width="100%" border="1">
			<tr align="center">
				<th width="5%" rowspan="3">No</th>
				<th width="7%" rowspan="3">Kode</th>
				<th width="8%" rowspan="3">Penyakit</th>
				<th colspan="4">0-7 Hr </th>
				<th colspan="4">8-28 Hr </th>
				<th colspan="4">1Bl-&lt;1Th</th>
				<th colspan="4">1 - 4 Th </th>
				<th colspan="4">5 - 9Th </th>
				<th colspan="4">10 - 14Th </th>
				<th colspan="4">15 - 19Th </th>
				<th colspan="4">20-44Th </th>
				<th colspan="4">45-44Th</th>
				<th colspan="4">55-59Th</th>
				<th colspan="4">60-69Th</th>
				<th colspan="4">&gt;70Th</th>
				<th colspan="5">Total</th>
			</tr>
			<tr align="center">
				<td colspan="2">Baru</td>
				<td colspan="2">Lama</td>
				<td colspan="2">Baru</td>
				<td colspan="2">Lama</td>
				<td colspan="2">Baru</td>
				<td colspan="2">Lama</td>
				<td colspan="2">Baru</td>
				<td colspan="2">Lama</td>
				<td colspan="2">Baru</td>
				<td colspan="2">Lama</td>
				<td colspan="2">Baru</td>
				<td colspan="2">Lama</td>
				<td colspan="2">Baru</td>
				<td colspan="2">Lama</td>
				<td colspan="2">Baru</td>
				<td colspan="2">Lama</td>
				<td colspan="2">Baru</td>
				<td colspan="2">Lama</td>
				<td colspan="2">Baru</td>
				<td colspan="2">Lama</td>
				<td colspan="2">Baru</td>
				<td colspan="2">Lama</td>
				<td colspan="2">Baru</td>
				<td colspan="2">Lama</td>
				<td colspan="2">Baru</td>
				<td colspan="2">Lama</td>
				<td rowspan="2">JML</td>
			</tr>
			<tr align="center">
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
				<td>L</td>
				<td>P</td>
			</tr>';
		
		$html .='
			<tr align="center">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>';
			
		$html .='
			<tr align="center">
			<td colspan="3" align="right"><strong>JUMLAH</strong></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			</tr>
			</table>

			<br/><br/><br/>	
			<table width="100%" align="left">
			<tr>
			<td><strong>Kepala Puskesmas</strong></td>
			</tr>
			<tr>
			<br/><br/>
			<td><strong>(Nama)</strong></td>
			</tr>
			</table>
		';

		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->render();
		$dompdf->stream("sample.pdf");

	}
	
	function downloadexcel(){
		require_once dirname(__FILE__) . '/../libraries/PHPExcel/Classes/PHPExcel.php';

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("SIK")
									 ->setTitle("Rekap Hibah Bansos")
									 ->setSubject("Rekap Hibah Bansos")
									 ->setDescription("Rekap Hibah Bansos");
		
		$this->load->model('hibahbansos_model');
		$result = $this->hibahbansos_model->getHibahbansosAll();
		
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Nama PT')
					->setCellValue('B1', 'Alamat PT')
					->setCellValue('C1', 'KOPWIL')
					->setCellValue('D1', 'Nama Yayasan');
		$i=2;
		foreach($result as $data){			
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$i, $data['nama_pt'])
					->setCellValue('B'.$i, $data['alamat'])
					->setCellValue('C'.$i, $data['kopwil'])
					->setCellValue('D'.$i, $data['nama_yayasan']);
			$i++;
		}

		$objPHPExcel->getActiveSheet()->setTitle('Rekap Hibah Bansos');

		$objPHPExcel->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="RekapHibahBansos'.date('Ymdhis').'.xls"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}
}