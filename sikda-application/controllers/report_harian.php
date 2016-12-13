<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Report_harian extends CI_Controller {

	public function index()
	{	
		$this->load->view('reports/harian_rawatjalan');
	}
	
	public function diagnosarj()
	{	
		$this->load->view('reports/harian_diagnosa');
	}
	public function poliharian()
	{	
		$this->load->view('reports/poliharian');
	}
	public function diagnosaharian()
	{	
		$this->load->view('reports/diagnosaharian');
	}
	
	public function lap_poli()
	{	
		$tgl = $this->input->get('tgl')?date("Y-m-d", strtotime(str_replace('/', '-',$this->input->get('tgl')))):date('Y-m-d');
		$from = $this->input->get('from')?date("Y-m-d", strtotime(str_replace('/', '-',$this->input->get('from')))):date('Y-m-d');
		$to = $this->input->get('to')?date("Y-m-d", strtotime(str_replace('/', '-',$this->input->get('to')))):date('Y-m-d');
		$jns = $this->input->get('jenis')?$this->input->get('jenis'):'';
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?"AND SUBSTRING(a.KD_PUSKESMAS,2,4) = '".$pid."' ":"AND a.KD_PUSKESMAS = '".$pid."' ";
		$whr = $jns=='lap2'?"(TGL_MASUK BETWEEN '$from' AND '$to')":"TGL_MASUK = '$tgl'";
		$tanggalan = $jns!=='lap2'?$this->input->get('tgl'):$this->input->get('from').' s.d '.$this->input->get('to');
		$db = $this->load->database('sikda', TRUE);
		$query = $db->query("SELECT v.KD_PUSKESMAS,m.PUSKESMAS, v.KD_PASIEN, v.NAMA_PASIEN, v.NAMA_UNIT, v.KD_UNIT, p.KD_JENIS_KELAMIN, v.TGL_MASUK, p.CMLAMA
		FROM vw_lst_antrian v join pasien p on p.KD_PASIEN=v.KD_PASIEN join mst_puskesmas m on m.KD_PUSKESMAS=v.KD_PUSKESMAS
		WHERE ".$whr."
		AND PARENT = 2
		AND v.KD_PUSKESMAS = '$pid'
		ORDER BY KD_UNIT asc
		");
		
		$data = $query->result(); //print_r($data);die;
		//die($db->last_query());
        if(!$data)
            die('Tidak ada kunjungan pada tanggal '.$this->input->get('tgl'));
			
		 // Starting the PHPExcel library
        $this->load->library('Excel');
		$this->excel->getActiveSheet()->setTitle('Laporan Pasien POLI Harian');
        $this->excel->getProperties()->setTitle("export")->setDescription("none");
		
		$objReader = PHPExcel_IOFactory::createReader('Excel5');  
		$objPHPExcel = $objReader->load("tmp/laporan_harian_poli.xls");
		
		$objPHPExcel->setActiveSheetIndex(0);
			// Fetching the table data for SDMI
		$rw=8;
		$no=1;
		$bb='';
        foreach($data as $value)
        {	
			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						
					),
				),
			);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':E'.$rw)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle("A".$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle("C".$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':E'.$rw)->getFont()->setBold(true);	
		
			$objPHPExcel->getActiveSheet()->setTitle('Laporan Pasien POLI Harian')
            ->setCellValue('A'.$rw, $no)
            ->setCellValue('B'.$rw, $value->NAMA_PASIEN)
            ->setCellValue('C'.$rw, $value->KD_JENIS_KELAMIN)
            ->setCellValue('D'.$rw, $value->CMLAMA)
            ->setCellValue('E'.$rw, $value->NAMA_UNIT)
			;
		$rw++;
		$no++;
        }
		
		$objPHPExcel->getActiveSheet()->setTitle('Laporan Pasien POLI Harian')
            ->setCellValue('E4', $value->PUSKESMAS)
            ->setCellValue('E5', $tanggalan);		
			
		$filename="laporan_harian_poli_".date('dmY-his').".xls"; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
	}
	
	public function lap_diagnosa()
	{	
		$tgl = $this->input->get('tgl')?date("Y-m-d", strtotime(str_replace('/', '-',$this->input->get('tgl')))):date('Y-m-d');
		$from = $this->input->get('from')?date("Y-m-d", strtotime(str_replace('/', '-',$this->input->get('from')))):date('Y-m-d');
		$to = $this->input->get('to')?date("Y-m-d", strtotime(str_replace('/', '-',$this->input->get('to')))):date('Y-m-d');
		$jns = $this->input->get('jenis')?$this->input->get('jenis'):'';
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?"AND SUBSTRING(a.KD_PUSKESMAS,2,4) = '".$pid."' ":"AND a.KD_PUSKESMAS = '".$pid."' ";
		$whr = $jns=='lap2'?"(TANGGAL BETWEEN '$from' AND '$to')":"TANGGAL = '$tgl'";
		$tanggalan = $jns!=='lap2'?$this->input->get('tgl'):$this->input->get('from').' s.d '.$this->input->get('to');
		$db = $this->load->database('sikda', TRUE);
		$query = $db->query("SELECT v.KD_PUSKESMAS,m.PUSKESMAS,REPLACE(REPLACE(REPLACE(Get_Age(p.TGL_LAHIR),'m',' Bln'),'y',' Th'),'d','Hr') AS USIA, p.KD_PASIEN, p.NAMA_LENGKAP, GROUP_CONCAT(DISTINCT i.PENYAKIT SEPARATOR '; ') AS PENYAKIT, p.KD_JENIS_KELAMIN, v.TANGGAL, p.CMLAMA
		FROM pel_diagnosa v join pelayanan a on a.KD_PELAYANAN=v.KD_PELAYANAN join pasien p on p.KD_PASIEN=a.KD_PASIEN join mst_puskesmas m on m.KD_PUSKESMAS=v.KD_PUSKESMAS left join mst_icd i on i.KD_PENYAKIT=v.KD_PENYAKIT 
		WHERE ".$whr."
		AND v.KD_PUSKESMAS = '$pid'
		AND p.KD_PASIEN LIKE '$pid%'
		GROUP BY p.KD_PASIEN
		ORDER BY p.KD_PASIEN asc
		");
		
		$data = $query->result(); //print_r($data);die;
		//die($db->last_query());
        //if(!$data)
            // die('Tidak ada kunjungan pada tanggal '.$this->input->get('tgl'));
			
		 // Starting the PHPExcel library
        $this->load->library('Excel');
		$this->excel->getActiveSheet()->setTitle('Laporan Diagnosa Pasien Harian');
        $this->excel->getProperties()->setTitle("export")->setDescription("none");
		
		$objReader = PHPExcel_IOFactory::createReader('Excel5');  
		$objPHPExcel = $objReader->load("tmp/laporan_harian_diagnosa.xls");
		
		$objPHPExcel->setActiveSheetIndex(0);
			// Fetching the table data for SDMI
		$rw=8;
		$no=1;
		$bb='';
		if($data){
			foreach($data as $value)
			{	
				$styleArray = array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							
						),
					),
				);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':F'.$rw)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getStyle("A".$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle("C".$rw.":E".$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					
				$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':F'.$rw)->getFont()->setBold(true);	
			
				$objPHPExcel->getActiveSheet()->setTitle('Laporan Diagnosa Pasien Harian')
				->setCellValue('A'.$rw, $no)
				->setCellValue('B'.$rw, $value->NAMA_LENGKAP)
				->setCellValue('C'.$rw, $value->KD_JENIS_KELAMIN)
				->setCellValue('D'.$rw, $value->CMLAMA)
				->setCellValue('E'.$rw, $value->USIA)
				->setCellValue('F'.$rw, $value->PENYAKIT)
				;
			$rw++;
			$no++;
			}
		
			$objPHPExcel->getActiveSheet()->setTitle('Laporan Diagnosa Pasien Harian')
				->setCellValue('C4', $value->PUSKESMAS)
				->setCellValue('C5', $tanggalan);		
		}else{
			$objPHPExcel->getActiveSheet()->setTitle('Laporan Diagnosa Pasien Harian')
				->setCellValue('C4', $this->session->userdata('puskesmas'))
				->setCellValue('C5', $this->input->get('tgl'));	
		}
		$objPHPExcel->getActiveSheet()->getStyle("F8:F".$rw)->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getStyle("A8:F".$rw)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		foreach($objPHPExcel->getActiveSheet()->getRowDimensions() as $rd) { $rd->setRowHeight(-1); }
		
		$filename="laporan_harian_diagnosa_".date('dmY-his').".xls"; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
	}
	
	
	public function harian_diagnosa_excel(){
		
		$from = $this->input->get('from')?date("Y-m-d", strtotime(str_replace('/', '-',$this->input->get('from')))):date('Y-m-d');;	//print_r($from);die;
		$to = $this->input->get('to')?date("Y-m-d", strtotime(str_replace('/', '-',$this->input->get('to')))):date('Y-m-d');; //print_r($to);die;
		$rc = $this->input->get('rc');
		$pid = $this->input->get('pid');
		$jenis = $this->input->get('jenis');
		$db = $this->load->database('sikda', TRUE);
		$limit = '';
		if($rc){
			$limit = " LIMIT ".$rc;
		}
		//$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_uks a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'")->row();//print_r($data);die;
		$query = $db->query("SELECT DATE_FORMAT('$from','%d-%m-%Y') as dt1,DATE_FORMAT('$to','%d-%m-%Y') as dt2, V.KD_PUSKESMAS, (SELECT S.KEY_VALUE FROM sys_setting AS S WHERE S.KEY_DATA = 'NAMA_PUSKESMAS' AND PUSKESMAS='$pid' LIMIT 1) AS NAMA_PUSKESMAS, (SELECT S.KEY_VALUE FROM sys_setting AS S WHERE S.KEY_DATA = 'NAMA_PIMPINAN' AND PUSKESMAS='$pid' LIMIT 1) AS KEPALA_PUSKESMAS, I.KD_PENYAKIT, I.PENYAKIT, COL1_L_B, COL1_P_B, COL2_L_B, COL2_P_B, COL3_L_B, COL3_P_B, COL4_L_B, COL4_P_B, COL5_L_B, COL5_P_B, COL6_L_B, COL6_P_B, COL1_L_L, COL1_P_L, COL2_L_L, COL2_P_L, COL3_L_L, COL3_P_L, COL4_L_L, COL4_P_L, COL5_L_L, COL5_P_L, COL6_L_L, COL6_P_L, COL7_L_B, COL7_P_B, COL8_L_B, COL8_P_B, COL9_L_B, COL9_P_B, COL10_L_B, COL10_P_B, COL11_L_B, COL11_P_B, COL12_L_B, COL12_P_B, COL7_L_L, COL7_P_L, COL8_L_L, COL8_P_L, COL9_L_L, COL9_P_L, COL10_L_L, COL10_P_L, COL11_L_L, COL11_P_L, COL12_L_L, COL12_P_L, (COL1_L_B + COL2_L_B + COL3_L_B + COL4_L_B + COL5_L_B + COL6_L_B + COL7_L_B + COL8_L_B + COL9_L_B + COL10_L_B + COL11_L_B + COL12_L_B) AS TOTAL_L_B, (COL1_L_L + COL2_L_L + COL3_L_L + COL4_L_L + COL5_L_L + COL6_L_L + COL7_L_L + COL8_L_L + COL9_L_L + COL10_L_L + COL11_L_L + COL12_L_L) AS TOTAL_L_L, (COL1_P_B + COL2_P_B + COL3_P_B + COL4_P_B + COL5_P_B + COL6_P_B + COL7_P_B + COL8_P_B + COL9_P_B + COL10_P_B + COL11_P_B + COL12_P_B) AS TOTAL_P_B, (COL1_P_L + COL2_P_L + COL3_P_L + COL4_P_L + COL5_P_L + COL6_P_L + COL7_P_L + COL8_P_L + COL9_P_L + COL10_P_L + COL11_P_L + COL12_P_L) AS TOTAL_P_L, (COL1_L_B + COL2_L_B + COL3_L_B + COL4_L_B + COL5_L_B + COL6_L_B + COL7_L_B + COL8_L_B + COL9_L_B + COL10_L_B + COL11_L_B + COL12_L_B + COL1_L_L + COL2_L_L + COL3_L_L + COL4_L_L + COL5_L_L + COL6_L_L + COL7_L_L + COL8_L_L + COL9_L_L + COL10_L_L + COL11_L_L + COL12_L_L + COL1_P_B + COL2_P_B + COL3_P_B + COL4_P_B + COL5_P_B + COL6_P_B + COL7_P_B + COL8_P_B + COL9_P_B + COL10_P_B + COL11_P_B + COL12_P_B + COL1_P_L + COL2_P_L + COL3_P_L + COL4_P_L + COL5_P_L + COL6_P_L + COL7_P_L + COL8_P_L + COL9_P_L + COL10_P_L + COL11_P_L + COL12_P_L) AS TOTAL FROM ( SELECT V.KD_PUSKESMAS, V.NAMA_PUSKESMAS, V.KD_PENYAKIT, SUM(IF(UMURINDAYS>=0 AND UMURINDAYS<=7 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS COL1_L_B, SUM(IF(UMURINDAYS>=0 AND UMURINDAYS<=7 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS COL1_P_B, SUM(IF(UMURINDAYS>=8 AND UMURINDAYS<=28 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS COL2_L_B, SUM(IF(UMURINDAYS>=8 AND UMURINDAYS<=28 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS COL2_P_B, SUM(IF(UMURINDAYS>=29 AND UMURINDAYS<=365 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS COL3_L_B, SUM(IF(UMURINDAYS>=29 AND UMURINDAYS<=365 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS COL3_P_B, SUM(IF(UMURINDAYS>=366 AND UMURINDAYS<=1460 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS COL4_L_B, SUM(IF(UMURINDAYS>=366 AND UMURINDAYS<=1460 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS COL4_P_B, SUM(IF(UMURINDAYS>=1461 AND UMURINDAYS<=3285 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS COL5_L_B, SUM(IF(UMURINDAYS>=1461 AND UMURINDAYS<=3285 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS COL5_P_B, SUM(IF(UMURINDAYS>=3286 AND UMURINDAYS<=5110 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS COL6_L_B, SUM(IF(UMURINDAYS>=3286 AND UMURINDAYS<=5110 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS COL6_P_B, SUM(IF(UMURINDAYS>=5111 AND UMURINDAYS<=6935 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS COL7_L_B, SUM(IF(UMURINDAYS>=5111 AND UMURINDAYS<=6935 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS COL7_P_B, SUM(IF(UMURINDAYS>=6936 AND UMURINDAYS<=16060 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS COL8_L_B, SUM(IF(UMURINDAYS>=6936 AND UMURINDAYS<=16060 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS COL8_P_B, SUM(IF(UMURINDAYS>=16061 AND UMURINDAYS<=19710 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS COL9_L_B, SUM(IF(UMURINDAYS>=16061 AND UMURINDAYS<=19710 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS COL9_P_B, SUM(IF(UMURINDAYS>=19711 AND UMURINDAYS<=21535 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS COL10_L_B, SUM(IF(UMURINDAYS>=19711 AND UMURINDAYS<=21535 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS COL10_P_B, SUM(IF(UMURINDAYS>=21900 AND UMURINDAYS<=25185 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS COL11_L_B, SUM(IF(UMURINDAYS>=21900 AND UMURINDAYS<=25185 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS COL11_P_B, SUM(IF(UMURINDAYS>=25186 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS COL12_L_B, SUM(IF(UMURINDAYS>=25186 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS COL12_P_B, SUM(IF(UMURINDAYS>=0 AND UMURINDAYS<=7 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS COL1_L_L, SUM(IF(UMURINDAYS>=0 AND UMURINDAYS<=7 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS COL1_P_L, SUM(IF(UMURINDAYS>=8 AND UMURINDAYS<=28 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS COL2_L_L, SUM(IF(UMURINDAYS>=8 AND UMURINDAYS<=28 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS COL2_P_L, SUM(IF(UMURINDAYS>=29 AND UMURINDAYS<=365 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS COL3_L_L, SUM(IF(UMURINDAYS>=29 AND UMURINDAYS<=365 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS COL3_P_L, SUM(IF(UMURINDAYS>=366 AND UMURINDAYS<=1460 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS COL4_L_L, SUM(IF(UMURINDAYS>=366 AND UMURINDAYS<=1460 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS COL4_P_L, SUM(IF(UMURINDAYS>=1461 AND UMURINDAYS<=3285 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS COL5_L_L, SUM(IF(UMURINDAYS>=1461 AND UMURINDAYS<=3285 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS COL5_P_L, SUM(IF(UMURINDAYS>=3286 AND UMURINDAYS<=5110 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS COL6_L_L, SUM(IF(UMURINDAYS>=3286 AND UMURINDAYS<=5110 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS COL6_P_L, SUM(IF(UMURINDAYS>=5111 AND UMURINDAYS<=6935 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS COL7_L_L, SUM(IF(UMURINDAYS>=5111 AND UMURINDAYS<=6935 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS COL7_P_L, SUM(IF(UMURINDAYS>=6936 AND UMURINDAYS<=16060 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS COL8_L_L, SUM(IF(UMURINDAYS>=6936 AND UMURINDAYS<=16060 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS COL8_P_L, SUM(IF(UMURINDAYS>=16061 AND UMURINDAYS<=19710 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS COL9_L_L, SUM(IF(UMURINDAYS>=16061 AND UMURINDAYS<=19710 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS COL9_P_L, SUM(IF(UMURINDAYS>=19711 AND UMURINDAYS<=21535 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS COL10_L_L, SUM(IF(UMURINDAYS>=19711 AND UMURINDAYS<=21535 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS COL10_P_L, SUM(IF(UMURINDAYS>=21900 AND UMURINDAYS<=25185 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS COL11_L_L, SUM(IF(UMURINDAYS>=21900 AND UMURINDAYS<=25185 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS COL11_P_L, SUM(IF(UMURINDAYS>=25186 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS COL12_L_L, SUM(IF(UMURINDAYS>=25186 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS COL12_P_L FROM vw_rpt_penyakitpasien_grp_old AS V WHERE (TGL_PELAYANAN BETWEEN '$from' AND '$to') AND KD_PUSKESMAS='$pid' GROUP BY V.KD_PUSKESMAS, V.NAMA_PUSKESMAS, V.KD_PENYAKIT ) V INNER JOIN mst_icd I ON I.KD_PENYAKIT=V.KD_PENYAKIT ORDER BY TOTAL DESC".$limit.";");//print_r($query);die;
			if($query->num_rows>0){
			$data = $query->result(); //print_r($data);die;
			
			if(!$data)
				return false;
	 
			// Starting the PHPExcel library
			$this->load->library('Excel');
			$this->excel->getActiveSheet()->setTitle('Peringkat Diagnosa');
			$this->excel->getProperties()->setTitle("export")->setDescription("none");
			
			$objReader = PHPExcel_IOFactory::createReader('Excel5');
			$objPHPExcel = $objReader->load("tmp/laporan_diagnosa_harian.xls");
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
				$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':D'.($rw+1))->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				//$objPHPExcel->getActiveSheet()->getStyle('C'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->setTitle('Data')
					->setCellValue('A'.$rw, $no)
					->setCellValue('B'.$rw, $value->KD_PENYAKIT)
					->setCellValue('C'.$rw, $value->PENYAKIT)
					->setCellValue('D'.$rw, $value->TOTAL);
				$rw++;
				$no++;
			}
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A'.($rw+2).':A'.($rw+4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objPHPExcel->getActiveSheet()->getStyle('C4'.':C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':C'.$rw);
			$objPHPExcel->getActiveSheet()
				->setCellValue('C4', ': '.$value->KD_PUSKESMAS.'   '.$value->NAMA_PUSKESMAS)
				->setCellValue('C5', ': '.($value->dt1).' s/d '.$value->dt2)
				->setCellValue('A'.$rw, 'TOTAL')
				->setCellValue('A'.($rw+2), 'Kepala Puskesmas')
				->setCellValue('A'.($rw+4), $value->KEPALA_PUSKESMAS)
				->setCellValue('D'.$rw, '=SUM(D9:D'.($rw-1).')');
			$filename='laporan_peringkat_diagnosa_harian'.date('_dmY_his').'.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			}else{
				die('Tidak Ada Dalam Database');
			}
	}
	
}

/* End of file dashboard.php */
/* Location: ./sikdaapplication/controllers/login.php */