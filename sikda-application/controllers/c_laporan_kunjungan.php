<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_Laporan_Kunjungan extends CI_Controller {
	public function index(){
		echo "a";
	}
	public function cetak(){
		include_once("./assets/tcpdf/tcpdf_6.2.0.php");

		$from = $this->input->get('from',true); //yyyy-mm-dd
		$to = $this->input->get('to',true);
		$pid = $this->input->get('pid',true);	//puskesmas id
		$jenis = $this->input->get('jenis',true); //jenis will be rpt_hrj or rpt_hrj_kb

		$this->load->library('tcpdf_lap_kunjungan');
		$pdf = $this->tcpdf_lap_kunjungan;
		$pdf->publish($from, $to, $pid, $jenis);
	}
	public function cetak_excel(){

		$from = $this->input->get('from');	//print_r($from);die;
		$to = $this->input->get('to'); //print_r($to);die;
		$pid = $this->input->get('pid');
		$jenis = $this->input->get('jenis');

		$this->db = $this->load->database('sikda', TRUE);
		$this->load->library('Excel');

		if($jenis=='rpt_hrj'){
			$kode_puskesmas = $pid;
			$nama_puskesmas = $this->session->userdata('puskesmas');
			$text_puskesmas = 'Puskesmas';
			$from_date = Date('d-m-Y',strtotime($from));
			$to_date = Date('d-m-Y',strtotime($to));
			$where = "(TGL_PELAYANAN BETWEEN '$from' AND '$to') AND p.KD_PUSKESMAS = '$pid'";
			$kbp=false;
		}else{
			$kode_puskesmas = $pid;
			$nama_puskesmas = $this->session->userdata('nama_kabupaten');
			$text_puskesmas = 'Kabupaten';
			$from_date = Date('d-m-Y',strtotime($from));
			$to_date = Date('d-m-Y',strtotime($to));
			$where = "(TGL_PELAYANAN BETWEEN '$from' AND '$to') AND SUBSTR(p.KD_PUSKESMAS,2,4) = '$pid'";
			$kbp=true;
		}

		$units = $this->db->select('p.KD_UNIT, u.UNIT')->from('pelayanan p')
				->join('mst_unit u','u.KD_UNIT=p.KD_UNIT')
				->where($where,NULL,FALSE)->group_by('p.KD_UNIT')->order_by('p.KD_UNIT asc')->get()->result();
		if(empty($units)) die('Tidak ada data');

		$cara_bayars =  $this->db->select()->from('mst_kel_pasien')->get()->result();

		$this->load->library('Excel');
		$this->excel->getActiveSheet()->setTitle('Laporan Kunjungan');
		$this->excel->getProperties()->setTitle('export')->setDescription('none');

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getDefaultStyle()
						->applyFromArray(
								array(
									'font'=>array('bold'=>false,'name'=>'Arial','size'=>9),
									'alignment'=>array('vertical'=>'center','horizontal'=>'center')
								)
							)
						->getAlignment()->setWrapText(true);


		//nama puskesmas
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->getColumnDimension('C')->setWidth(24);
		$sheet->getColumnDimension('D')->setWidth(2);
		$sheet->getStyle('C3:O4')->applyFromArray(array('font'=>array('size'=>11),'alignment'=>array('horizontal'=>'left')));
		$sheet->setCellValue('C3',$text_puskesmas)->setCellValue('D3',':')->setCellValue('E3',$kode_puskesmas.'     '.$nama_puskesmas);
		$sheet->mergeCells('E3:O3');

		//dari tanggal berapa sampai berapa
		$sheet->setCellValue('C4','Periode')->setCellValue('D4',':')
				->setCellValue('E4',Date('d-m-Y',strtotime($from)).'   s/d   '.Date('d-m-Y',strtotime($to)));
		$sheet->mergeCells('E4:O4');

		//Column Header
		$sheet->setCellValue('A6','No.')
				->setCellValue('B6','Kode')
				->setCellValue('C6','Nama Unit');
		$sheet->mergeCells('A6:A7');
		$sheet->getStyle('A6:C7')
					->applyFromArray(
						array(
							'font'=>array('bold'=>true,'size'=>11,'name'=>'Arial')
						)
					);
		$sheet->mergeCells('B6:B7');
		$sheet->mergeCells('C6:D7'); //end with column 2 (C)
		$sheet->getRowDimension('6')->setRowHeight(28);

		//column number start from 0 which means A
		$columns = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG');
		$column_number = 4;
		$row_number	   = 6;
		$cara_bayar_width = 2; //4 column
		foreach($cara_bayars as $cb){
			$sheet->setCellValueByColumnAndRow($column_number, $row_number, strtolower($cb->CUSTOMER));
			$merged_cells = $columns[$column_number].$row_number.':'.$columns[$column_number+$cara_bayar_width-1].$row_number;
			$sheet->mergeCells($merged_cells);
			$sheet->setCellValueByColumnAndRow($column_number, $row_number+1, 'L');
			$sheet->setCellValueByColumnAndRow($column_number+1, $row_number+1, 'P');
			$column_number+=$cara_bayar_width;
		}

		//total header column
		$sheet->setCellValueByColumnAndRow($column_number, $row_number, 'Total');
		$sheet->setCellValueByColumnAndRow($column_number, $row_number+1, 'L');
		$sheet->setCellValueByColumnAndRow($column_number+1, $row_number+1, 'P');
		$sheet->setCellValueByColumnAndRow($column_number+2, $row_number+1, 'JML');
		$cells = $columns[$column_number].$row_number.':'.$columns[$column_number+2].$row_number;
		$sheet->mergeCells($cells);
		$column_number+=2;

		//apply style to column header
		$last_column = $columns[$column_number];
		$first_column = $columns[4];
		$cells = $first_column.$row_number.':'.$last_column.($row_number+1);
		$sheet->getStyle($cells)->applyFromArray(
				array(
					'font'=>array('bold'=>true)
				)
			);
		$body_row_number = $row_number+2;

		//set page title
		$cells = 'A1:'.$last_column.'1';
		$sheet->setCellValue('A1','LAPORAN KUNJUNGAN RAWAT JALAN');
		$sheet->mergeCells($cells);
		$sheet->getStyle($cells)->applyFromArray(array('font'=>array('bold'=>true,'size'=>14)));


		//table body content
 		$jumlah = array();

 		$condition = "pel.KD_PUSKESMAS = '$pid'";
 		if($kbp){
 			$condition = "SUBSTR(pel.KD_PUSKESMAS,2,4) = '$pid'";
 		}

 		$row_num = $body_row_number;
		foreach($units as $index=>$u){
			$total_pria = 0;
			$total_wanita = 0;

			$sheet->setCellValue('A'.$row_num,$index+1);
			$sheet->setCellValue('B'.$row_num,$u->KD_UNIT);
			$sheet->setCellValue('C'.$row_num,$u->UNIT);
			$cells = 'C'.$row_num.':D'.$row_num;
			$sheet->mergeCells($cells);
			$sheet->getStyle($cells)->applyFromArray(array('alignment'=>array('horizontal'=>'left')));

			$dynamic_col_number = 4;
			foreach($cara_bayars as $b){

				$query = "SELECT 
							( 		
									SELECT COUNT(pel.KD_PASIEN) AS KUNJUNGAN_PRIA
									FROM pelayanan pel
									INNER JOIN pasien p ON pel.KD_PASIEN=p.KD_PASIEN AND p.KD_JENIS_KELAMIN='L'
									WHERE (pel.TGL_PELAYANAN BETWEEN '$from' AND '$to')
									AND $condition
									AND pel.KD_UNIT = '$u->KD_UNIT'
									AND pel.JENIS_PASIEN = '$b->KD_CUSTOMER'
							) AS KUNJUNGAN_PRIA,
							( 		
									SELECT COUNT(pel.KD_PASIEN) AS KUNJUNGAN_WANITA
									FROM pelayanan pel
									INNER JOIN pasien p ON pel.KD_PASIEN=p.KD_PASIEN AND p.KD_JENIS_KELAMIN='P'
									WHERE (pel.TGL_PELAYANAN BETWEEN '$from' AND '$to')
									AND $condition
									AND pel.KD_UNIT = '$u->KD_UNIT'
									AND pel.JENIS_PASIEN = '$b->KD_CUSTOMER'
							) AS KUNJUNGAN_WANITA";

				$result = $this->db->query($query)->row();
				$kunj_pria = 0;
				$kunj_wanita = 0;
				if(!empty($result)){
					if(!empty($result->KUNJUNGAN_PRIA)) $kunj_pria = $result->KUNJUNGAN_PRIA;
					if(!empty($result->KUNJUNGAN_WANITA)) $kunj_wanita = $result->KUNJUNGAN_WANITA;
				}

				$sheet->setCellValueByColumnAndRow($dynamic_col_number++,$row_num,$kunj_pria);
				$sheet->setCellValueByColumnAndRow($dynamic_col_number++,$row_num,$kunj_wanita);


				if(!isset($jumlah[$b->KD_CUSTOMER])){
					$jumlah[$b->KD_CUSTOMER] = array(
							'L'=>$kunj_pria,
							'P'=>$kunj_wanita
						);
				}else{
					$jumlah[$b->KD_CUSTOMER]['L']+=$kunj_pria;
					$jumlah[$b->KD_CUSTOMER]['P']+=$kunj_wanita;
				}

				$total_pria += $kunj_pria;
				$total_wanita += $kunj_wanita;
			}	


			$sheet->setCellValueByColumnAndRow($dynamic_col_number++,$row_num,$total_pria);
			$sheet->setCellValueByColumnAndRow($dynamic_col_number++,$row_num,$total_wanita);
			$sheet->setCellValueByColumnAndRow($dynamic_col_number++,$row_num,$total_wanita+$total_pria);

			$row_num++;
		}

		//jumlah keseluruhan
		$sheet->setCellValueByColumnAndRow(0,$row_num,'Jumlah');
		$sheet->mergeCells('A'.$row_num.':D'.$row_num);
		$sheet->getStyle('A'.$row_num)->applyFromArray(
			array(
				'alignment'=>array('horizontal'=>'right'),
				'font'=>array('bold'=>true,'size'=>11)
			)
		);
		$sheet->getRowDimension($row_num)->setRowHeight(21);

		$dynamic_col_number=4;
		$total_seluruh_pria = 0;
		$total_seluruh_wanita = 0;
		foreach($jumlah as $j){
			$sheet->setCellValueByColumnAndRow($dynamic_col_number++, $row_num, $j['L']);
			$sheet->setCellValueByColumnAndRow($dynamic_col_number++, $row_num, $j['P']);
			$total_seluruh_pria += $j['L'];
			$total_seluruh_wanita += $j['P'];
		}
		$sheet->setCellValueByColumnAndRow($dynamic_col_number++, $row_num, $total_seluruh_pria);
		$sheet->setCellValueByColumnAndRow($dynamic_col_number++, $row_num, $total_seluruh_wanita);
		$sheet->setCellValueByColumnAndRow($dynamic_col_number++, $row_num, $total_seluruh_wanita+$total_seluruh_pria);
		

		//set border
		$cells = 'A6:'.$columns[$dynamic_col_number-1].$row_num;
		$sheet->getStyle($cells)->applyFromArray(
				array(
						'borders'=>array(
							'allborders'=>array(
									'style'=>PHPExcel_Style_Border::BORDER_THIN
								)
							)
					)
			);

		//set column width
		$cells = 'E:'.$columns[$dynamic_col_number-1];
		foreach(range('E',$columns[$dynamic_col_number-1]) as $column_id){
			$sheet->getColumnDimension($column_id)->setWidth(7);	
		}

		//output and save
		$filename='laporan_kunjungan.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
}