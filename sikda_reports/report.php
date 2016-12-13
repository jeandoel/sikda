<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

//include_once("class/PHPExcel/Classes/PHPExcel.php");
//include_once("class/PHPExcel/Classes/PHPExcel/IOFactory.php");
include_once("class/fpdf/fpdf.php");
include_once("class/PHPJasperXML.inc.php");
include_once("setting.php");

$date1 = $_GET['from'];
$date2 = $_GET['to'];
$pid   = $_GET['pid'];
$jenis = $_GET['jenis'];
$idd   = isset($_GET['idd'])?$_GET['idd']:'';

$PHPJasperXML = new PHPJasperXML();
#$PHPJasperXML->debugsql=true;

set_time_limit(0);
switch ($jenis){
	case 'rpt_lb1': // LB1
		$xml =  simplexml_load_file("rm/rpt_lb1.jrxml");
		$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
		break;
	case 'rpt_lb1_kb': // LB1
		$xml =  simplexml_load_file("rm/rpt_lb1_kb.jrxml");
		$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
		break;
	case 'rpt_lb2': // LB2
		$xml =  simplexml_load_file("rm/rpt_lb2.jrxml");
		$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
		break;	
	case 'rpt_lb2_kb': // LB2 kb
		$xml =  simplexml_load_file("rm/rpt_lb2_kb.jrxml");
		$kdkabupaten = $_GET['kdkabupaten'];
		$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'", "kdkabupaten"=>"'".$kdkabupaten."'");
		break;	
	case 'rpt_lb3': // LB3
		$xml =  simplexml_load_file("rm/rpt_lb3test.jrxml");
		//$xml =  simplexml_load_file("rm/rpt_lb3.jrxml");
		$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
		break;	
	case 'rpt_lb3_kb': // LB3
		$xml =  simplexml_load_file("rm/rpt_lb3_kb.jrxml");
		//$xml =  simplexml_load_file("rm/rpt_lb3.jrxml");
		$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
		break;	
	case 'rpt_lb4': // LB4
		$xml =  simplexml_load_file("rm/rpt_lb4.jrxml");
		$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
		break;
	case 'rpt_lb4_kb': // LB4
		$xml =  simplexml_load_file("rm/rpt_lb4_kb.jrxml");
		$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'", "parameter1"=>"'". $pid . "'");
		break;
	case 'rpt_hrj':	
		$xml = simplexml_load_file("rd/rpt_kunjungan_RJ.jrxml");
		$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'",  "parameter1"=>"'". $pid . "'");
		break;
	case 'rpt_hrj_kb':	
		$xml = simplexml_load_file("rd/rpt_kunjungan_RJ_KB.jrxml");
		$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'",  "parameter1"=>"'". $pid . "'");
		break;
	case 'rpt_odontogram':	
		$xml = simplexml_load_file("odontogram/gigi.jrxml");
		$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'",  "parameter1"=>"'". $pid . "'");
		break;
	case 'rpt_odontogram_kb':	
		$xml = simplexml_load_file("odontogram/gigi_kb.jrxml");
		$PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'",  "parameter1"=>"'". $pid . "'");
		break;
    case 'rpt_tindakan_odontogram':
        $xml = simplexml_load_file("odontogram/gigi_tindakan.jrxml");
        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'",  "parameter1"=>"'". $pid . "'");
        break;
    case 'rpt_tindakan_odontogram_kb':
        $xml = simplexml_load_file("odontogram/gigi_tindakan_kb.jrxml");
        $PHPJasperXML->arrayParameter=array("date1"=>"'" . $date1 . "'", "date2"=>"'". $date2 . "'",  "parameter1"=>"'". $pid . "'");
        break;
}


$PHPJasperXML->xml_dismantle($xml);
$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
#print_r($PHPJasperXML->sql);die;

if($idd=='excel'){
	/*header('Content-Type: application/vnd.ms-excel'); //mime type
	header('Content-Disposition: attachment;filename=test.xls'); //tell browser what's the file name*/
	$konek = mysql_connect('localhost','root','root');
	$db = mysql_select_db('sikda_puskesmas',$konek);
	$result = mysql_query($PHPJasperXML->sql);
	$jmldata = mysql_num_rows($result);
	for($j=0;$j<$jmldata;$j++){
		$data[] = mysql_fetch_object($result);
	}
	#print_r($data);die;
	
	if($jenis=='rpt_lb1'){
		$objReader = PHPExcel_IOFactory::createReader('Excel5');  
		$objPHPExcel = $objReader->load("tmp/laporan_lb1.xls");
		$objPHPExcel->getActiveSheet()->setTitle('LB1');
		$objPHPExcel->setActiveSheetIndex(0);
		$rw=9;
		$no=1;
		$total=0;
		foreach($data as $value)
		{
			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
					),
				),
			);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':BD'.$rw)->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			//$objPHPExcel->getActiveSheet()->getStyle('C'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->setTitle('Data')
				->setCellValue('A'.$rw, $value->$no)
				->setCellValue('B'.$rw, $value->KD_PENYAKIT)
				->setCellValue('C'.$rw, $value->PENYAKIT)
				->setCellValue('D'.$rw, $value->COL1_L_B)
				->setCellValue('E'.$rw, $value->COL1_P_B)
				->setCellValue('F'.$rw, $value->COL1_L_L)
				->setCellValue('G'.$rw, $value->COL1_P_L)
				->setCellValue('H'.$rw, $value->COL2_L_B)
				->setCellValue('I'.$rw, $value->COL2_P_B)
				->setCellValue('J'.$rw, $value->COL2_L_L)
				->setCellValue('K'.$rw, $value->COL2_P_L)
				->setCellValue('L'.$rw, $value->COL3_L_B)
				->setCellValue('M'.$rw, $value->COL3_P_B)
				->setCellValue('N'.$rw, $value->COL3_L_L)
				->setCellValue('O'.$rw, $value->COL3_P_L)
				->setCellValue('P'.$rw, $value->COL4_L_B)
				->setCellValue('Q'.$rw, $value->COL4_P_B)
				->setCellValue('R'.$rw, $value->COL4_L_L)
				->setCellValue('S'.$rw, $value->COL4_P_L)
				->setCellValue('T'.$rw, $value->COL5_L_B)
				->setCellValue('U'.$rw, $value->COL5_P_B)
				->setCellValue('V'.$rw, $value->COL5_L_L)
				->setCellValue('W'.$rw, $value->COL5_P_L)
				->setCellValue('X'.$rw, $value->COL6_L_B)
				->setCellValue('Y'.$rw, $value->COL6_P_B)
				->setCellValue('Z'.$rw, $value->COL6_L_L)
				->setCellValue('AA'.$rw, $value->COL6_P_L)
				->setCellValue('AB'.$rw, $value->COL7_L_B)
				->setCellValue('AC'.$rw, $value->COL7_P_B)
				->setCellValue('AD'.$rw, $value->COL7_L_L)
				->setCellValue('AE'.$rw, $value->COL7_P_L)
				->setCellValue('AF'.$rw, $value->COL8_L_B)
				->setCellValue('AG'.$rw, $value->COL8_P_B)
				->setCellValue('AH'.$rw, $value->COL8_L_L)
				->setCellValue('AI'.$rw, $value->COL8_P_L)
				->setCellValue('AJ'.$rw, $value->COL9_L_B)
				->setCellValue('AK'.$rw, $value->COL9_P_B)
				->setCellValue('AL'.$rw, $value->COL9_L_L)
				->setCellValue('AM'.$rw, $value->COL9_P_L)
				->setCellValue('AN'.$rw, $value->COL10_L_B)
				->setCellValue('AO'.$rw, $value->COL10_P_B)
				->setCellValue('AP'.$rw, $value->COL10_L_L)
				->setCellValue('AQ'.$rw, $value->COL10_P_L)
				->setCellValue('AR'.$rw, $value->COL11_L_B)
				->setCellValue('AS'.$rw, $value->COL11_P_B)
				->setCellValue('AT'.$rw, $value->COL11_L_L)
				->setCellValue('AU'.$rw, $value->COL11_P_L)
				->setCellValue('AV'.$rw, $value->COL12_L_B)
				->setCellValue('AW'.$rw, $value->COL12_P_B)
				->setCellValue('AX'.$rw, $value->COL12_L_L)
				->setCellValue('AY'.$rw, $value->COL12_P_L)
				->setCellValue('AZ'.$rw, $value->TOTAL_L_B)
				->setCellValue('BA'.$rw, $value->TOTAL_P_B)
				->setCellValue('BB'.$rw, $value->TOTAL_L_L)
				->setCellValue('BC'.$rw, $value->TOTAL_P_L)
				->setCellValue('BD'.$rw, $value->TOTAL);
			$rw++;
			$no++;
		}
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()
			->setCellValue('E5', $value[0]->NAMA_PUSKESMAS)
			->setCellValue('E5', ($value[0]->dt1).' s/d '.$value[0]->dt1);
		$filename=date('dmY_his_').'laporan_lb1.xlsx'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
	}
	
}else{
	//echo '<div>'.$PHPJasperXML->sql.'</div>';
	$PHPJasperXML->outpage("I"); //page output method I:standard output  D:Download file    F:Save to Local File
}

?>
