<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Report_bulanan extends CI_Controller {

	public function index()
	{			
		$this->load->view('reports/lb1');		
	}
	
	public function lb2()
	{	
		$this->load->view('reports/lb2');
	}
	
	public function lb3()
	{	
		$this->load->view('reports/lb3');
	}
	
	public function lb3a()
	{	
		$this->load->view('reports/lb3a');
	}
	
	public function lb3c()
	{	
		$this->load->view('reports/lb3c');
	}
	
	public function lb4()
	{	
		$this->load->view('reports/lb4');
	}
	
	public function lapkunjungan()
	{	
		$this->load->view('reports/harian_rawatjalan');
	}
	
	public function lapodontogram($laporan=NULL)
    {
        if(empty($laporan)){
            $this->load->view('reports/lap_odontogram');
        }else{
            $this->load->view('reports/lap_odontogram_tindakan');
        }
    }
	
	public function lapasuransi()
	{	
		$this->load->model("m_master_kel_pasien");
		$asuransi = $this->m_master_kel_pasien->getAll(array(
				'where'=>array(
						'KD_CUSTOMER !='=>'0000000001'
					)
			));
		$this->load->view('reports/lap_asuransi',array('all'=>$asuransi));		
	}
	
	public function temp_gizi()
	{	
		$this->load->view('reports/temp_gizi');
	}
	public function lapasuransi_temp()
	{	
		//require_once('././sikda_reports/phpjasperxml/class/tcpdf/config/lang/eng.php');
		//require_once('././sikda_reports/phpjasperxml/class/tcpdf/tcpdf.php');	
		
		$jenis = $this->input->get('jenis');
		$jns = $this->input->get('jenisasu');
		$jnspt = $this->input->get('jenispt');
		$from = $this->input->get('from');
		$to = $this->input->get('to');
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?"AND SUBSTRING(pl.`KD_PUSKESMAS`,2,4) = '".$pid."' ":"AND pl.`KD_PUSKESMAS` = '".$pid."' ";

		$this->load->model('m_master_kel_pasien');
		$asuransi = $this->m_master_kel_pasien->getByCustomer($jns);
		$kd_customer = $asuransi['KD_CUSTOMER'];
		$jenisasuransi = ucwords($asuransi['CUSTOMER']);

		$sql = "
		SELECT (SELECT S.KEY_VALUE FROM sys_setting AS S WHERE S.KEY_DATA = 'NAMA_PIMPINAN' AND PUSKESMAS='$pid' LIMIT 1) AS KEPALA_PUSKESMAS,(SELECT KABUPATEN FROM mst_kabupaten WHERE KD_KABUPATEN='".$pid."' LIMIT 1)AS KABUPATEN,(SELECT PUSKESMAS FROM mst_puskesmas WHERE kd_puskesmas = '".$pid."' LIMIT 1) AS NAMA_PUSKESMAS,DATE_FORMAT('".$from."','%d-%m-%Y') AS dt1,DATE_FORMAT('".$to."','%d-%m-%Y') AS dt2, ps.NAMA_LENGKAP,ps.`ALAMAT`,ps.`NO_ASURANSI`,ps.`KD_JENIS_KELAMIN`,DATE_FORMAT(pl.`TGL_PELAYANAN`,'%d-%m-%Y') AS TGL_PELAYANAN,
		GROUP_CONCAT(DISTINCT `q`.`PENYAKIT` SEPARATOR ', ') AS `PENYAKIT`,mu.`UNIT`, (pt.HRG_TINDAKAN * pt.`QTY`) AS HARGA, pel.JUMLAH_BAYAR
		FROM pelayanan pl JOIN pasien ps ON pl.`KD_PASIEN`=ps.`KD_PASIEN` 
		LEFT JOIN pel_diagnosa pd ON pd.KD_PELAYANAN = pl.KD_PELAYANAN AND pd.`KD_PUSKESMAS`=pl.`KD_PUSKESMAS`
		LEFT JOIN pel_tindakan pt ON pt.KD_PELAYANAN = pl.KD_PELAYANAN AND pt.`KD_PUSKESMAS`=pl.`KD_PUSKESMAS`
		LEFT JOIN pel_kasir_detail_bayar pel ON pel.KD_PEL_KASIR = pl.KD_KASIR AND pel.`KD_PUSKESMAS`=pl.`KD_PUSKESMAS`
		LEFT JOIN pel_kasir kas ON kas.KD_PEL_KASIR = pl.KD_KASIR AND kas.`KD_PUSKESMAS`=pl.`KD_PUSKESMAS`
		LEFT JOIN `mst_icd` q ON q.`KD_PENYAKIT`=pd.`KD_PENYAKIT` 
		JOIN `mst_unit`mu ON mu.`KD_UNIT`=pl.`KD_UNIT`
		WHERE pl.`JENIS_PASIEN`='".$kd_customer."' 
		AND kas.`STATUS_TX`='1' 
		AND (pl.`TGL_PELAYANAN` BETWEEN '".$from."' AND '".$to."') 
		".$dtsql."
		GROUP BY pl.`KD_PELAYANAN`,pl.`KD_PUSKESMAS`
		";
		//die($sql);
		$db = $this->load->database('sikda', TRUE);
		$query = $db->query($sql);
		$val = $db->query($sql)->result_array();
		if($jnspt=='exc'){
			if($query->num_rows>0){
			$data = $query->result(); //print_r($data);die;
			
			if(!$data)
				return false;
	 
			// Starting the PHPExcel library
			$this->load->library('Excel');
			if($jenis=='rpt_jmksms_kb'){
				$this->excel->getActiveSheet()->setTitle('Laporan Asuransi Kabupaten');
			}else{
				$this->excel->getActiveSheet()->setTitle('Laporan Asuransi');
			}
			$this->excel->getProperties()->setTitle("export")->setDescription("none");
			
			$objReader = PHPExcel_IOFactory::createReader('Excel5');
			if($jenis=='rpt_jmksms_kb'){
				$objPHPExcel = $objReader->load("tmp/laporan_asuransi_kab.xls");
			}else{
				$objPHPExcel = $objReader->load("tmp/laporan_asuransi.xls");
			}
			$objPHPExcel->setActiveSheetIndex(0);
			$rw=8;
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
				$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':I'.$rw)->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getRowDimension($rw)->setRowHeight(-1);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$rw)->getAlignment()->setWrapText(true); 
				$objPHPExcel->getActiveSheet()->getStyle('D'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$objPHPExcel->getActiveSheet()->getStyle('H'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':I'.$rw)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$rw.':F'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				//$objPHPExcel->getActiveSheet()->mergeCells('B'.$rw.':C'.$rw);
				$objPHPExcel->getActiveSheet()->setTitle('Data')
					->setCellValue('A'.$rw, $no)
					->setCellValue('B'.$rw, $value->NAMA_LENGKAP)
					->setCellValue('C'.$rw, $value->ALAMAT)
					->setCellValue('D'.$rw, $value->NO_ASURANSI)
					->setCellValue('E'.$rw, $value->KD_JENIS_KELAMIN)
					->setCellValue('F'.$rw, $value->TGL_PELAYANAN)
					->setCellValue('G'.$rw, $value->PENYAKIT)
					->setCellValue('H'.$rw, $value->UNIT)
					->setCellValue('I'.$rw, 'Rp '.str_replace(',','.',number_format($value->JUMLAH_BAYAR)).',-');
				$rw++;
				$no++;
			}
			
			
			$objPHPExcel->setActiveSheetIndex(0);
			//$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A'.($rw+2).':A'.($rw+4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objPHPExcel->getActiveSheet()->mergeCells('A'.($rw+2).':B'.($rw+2));
			$objPHPExcel->getActiveSheet()->mergeCells('A'.($rw+4).':B'.($rw+4));
			if($jenis=='rpt_jmksms'){
				$objPHPExcel->getActiveSheet()
				->setCellValue('A2',$jenisasuransi)
				->setCellValue('C4', ': '.$value->NAMA_PUSKESMAS)
				->setCellValue('C5', ': '.($value->dt1).' s/d '.$value->dt2)
				->setCellValue('A'.($rw+2), 'Kepala Puskesmas')
				->setCellValue('A'.($rw+4), $value->KEPALA_PUSKESMAS);
			}else{
				$objPHPExcel->getActiveSheet()
				->setCellValue('C4', ': '.$value->KABUPATEN)
				->setCellValue('C5', ': '.($value->dt1).' s/d '.$value->dt2);
			}
			if($jenis=='rpt_jmksms_kb'){
				$filename='laporan_asuransi_kab'.date('_dmY_his').'.xls'; //save our workbook as this file name
			}else{
				$filename='laporan_asuransi'.date('_dmY_his').'.xls'; //save our workbook as this file name
			}
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			}else{
				die('Tidak Ada Data Dalam Database');
			}
			
		}else{
			if($val){
				$str = '';
				$str .= '<style>
						html,body{font-family:helvetica;font-size:15px;width:100%}
						table, td
						{
						border: 1px solid #000;padding:3px;
						}
						table
						{
						font-family:helvetica;font-size:13px;
						width:95%;
						border-collapse: collapse;
						}
						</style>';
				$i=1;
				$str .="<div style='text-align:center;font-weight:bold'>Laporan Pasien Rawat Jalan ".$jenisasuransi."</div>";
				foreach($val as $key=>$data){
					$kab = $data['KABUPATEN'];
					$pus = $data['NAMA_PUSKESMAS'];
					$dt1 = $data['dt1'];
					$dt2 = $data['dt2'];
				}
				if($jenis=='rpt_jmksms_kb'){
					$str .='</br>Kabupaten: '.$data['KABUPATEN'];
				}else{
					$str .='</br>Puskesmas: '.$data['NAMA_PUSKESMAS'];
				}
				$str .='</br>Periode: '.$data['dt1'].' s/d '.$data['dt2'];
				$str .='</br></br><table >';
				$str .='<tr><td style="font-weight:bold" width="5">No</td><td width="255" style="font-weight:bold">Nama</td><td width="255" style="font-weight:bold">Alamat</td><td style="font-weight:bold">No. Asuransi</td><td style="font-weight:bold">L/P</td><td style="font-weight:bold">Tgl. Transaksi</td><td style="font-weight:bold">Diagnosa</td><td style="font-weight:bold">Poli</td><td style="font-weight:bold">Rupiah</td></tr>';
					
				foreach($val as $key=>$data){
					$str .='<tr><td>'.$i.'</td><td>'.$data['NAMA_LENGKAP'].'</td><td>'.$data['ALAMAT'].'</td><td>'.$data['NO_ASURANSI'].'</td><td>'.$data['KD_JENIS_KELAMIN'].'</td><td>'.$data['TGL_PELAYANAN'].'</td><td>'.$data['PENYAKIT'].'</td><td>'.$data['UNIT'].'</td><td align="right"><span style="float:left">Rp</span>'.str_replace(',','.',number_format($data['JUMLAH_BAYAR'])).',-</td></tr>';
					$i++;
				
				}
				$str .='</table>';
				
				/*$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 

				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor('Nicola Asuni');
				$pdf->SetTitle('TCPDF Example 006');
				$pdf->SetSubject('TCPDF Tutorial');
				$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
				$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
				$pdf->setLanguageArray($l); 
				$pdf->SetFont('dejavusans', '', 10);
				$pdf->AddPage();
				$pdf->writeHTML($str, true, 0, true, 0);
				$pdf->lastPage();
				$pdf->Output('laporan_jamkesmas'.date('His').'.pdf', 'I');*/
				die($str);
			}else{
				die('Tidak ada data');
			}
		}
	}
	
	public function lapkia()
	{			
		$this->load->view('reports/lap_kia');		
	}
	
	public function lapkia_temp()
	{	
		//require_once('././sikda_reports/phpjasperxml/class/tcpdf/config/lang/eng.php');
		//require_once('././sikda_reports/phpjasperxml/class/tcpdf/tcpdf.php');	
		
		$from = $this->input->get('from');	//print_r($from);die;
		$to = $this->input->get('to'); //print_r($to);die;
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?"AND SUBSTRING(pl.`KD_PUSKESMAS`,2,4) = '".$pid."' ":"AND pl.`KD_PUSKESMAS` = '".$pid."' ";
		$db = $this->load->database('sikda', TRUE);
		$data = array();
		$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_kia a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'")->row();//print_r($data);die;
		$data['kia'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_kia a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'")->result_array();//print_r($data);die;
		
				if(!empty($data['waktu'])){
					$this->load->view('reports/v_lap_kia_temp', $data);
				}else{
					echo 'No Data Found';die;
				}
		
	}
	
	
	public function lapkesling()
	{			
		$this->load->view('reports/lap_kesling');		
	}
	
	public function lapkesling_temp()
	{	
		//require_once('././sikda_reports/phpjasperxml/class/tcpdf/config/lang/eng.php');
		//require_once('././sikda_reports/phpjasperxml/class/tcpdf/tcpdf.php');	
		
		$from = $this->input->get('from');	//print_r($from);die;
		$to = $this->input->get('to'); //print_r($to);die;
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?"AND SUBSTRING(pl.`KD_PUSKESMAS`,2,4) = '".$pid."' ":"AND pl.`KD_PUSKESMAS` = '".$pid."' ";
		$db = $this->load->database('sikda', TRUE);
		$data = array();
		$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_kesling a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'")->row();//print_r($data);die;
		$data['kesling'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_kesling a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'")->result_array();//print_r($data);die;
		
				if(!empty($data['waktu'])){
					$this->load->view('reports/v_lap_kesling_temp', $data);
				}else{
					echo 'No Data Found';die;
				}
		
	}
	
	public function lappromkes()
	{			
		$this->load->view('reports/lap_promkes');		
	}
	
	public function lappromkes_temp()
	{	
		$from = $this->input->get('from');
		$to = $this->input->get('to');
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?" AND SUBSTRING(KD_PUSKESMAS,2,4) = '".$pid."' ":" AND KD_PUSKESMAS = '".$pid."' ";
		$db = $this->load->database('sikda', TRUE);
		$data = array();
		$data['waktu']=$db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KELURAHAN, c.KABUPATEN from t_ds_promkes a LEFT JOIN mst_kelurahan b ON b.KD_KELURAHAN=a.KD_KELURAHAN LEFT JOIN mst_kabupaten c on c.KD_KABUPATEN=a.KD_KABUPATEN where a.BULAN = '$from' and a.TAHUN='$to'")->row();//print_r($data);die;
		$data['promkes']=$db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KELURAHAN, c.KABUPATEN from t_ds_promkes a LEFT JOIN mst_kelurahan b ON b.KD_KELURAHAN=a.KD_KELURAHAN LEFT JOIN mst_kabupaten c on c.KD_KABUPATEN=a.KD_KABUPATEN where a.BULAN = '$from' and a.TAHUN='$to'")->result_array();//print_r($data);die;
		//print_r($data);die;
		if(!empty($data['waktu'])){
					$this->load->view('reports/v_lap_promkes_temp', $data);
				}else{
					echo 'No Data Found';die;
				}
	}
	
	public function lapukgs()
	{			
		$this->load->view('reports/lap_ukgs');		
	}
	
	public function lapukgs_temp()
	{	
		$from = $this->input->get('from');//print_r($from);die;
		$to = $this->input->get('to');//print_r($to);die;
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?"AND SUBSTRING(a.KD_PUSKESMAS,2,4) = '".$pid."' ":"AND KD_PUSKESMAS = '".$pid."' ";
		$db = $this->load->database('sikda', TRUE);
		$data = array();
		$data['waktu']=$db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS from t_ds_ukgs a LEFT JOIN mst_puskesmas c ON c.KD_PUSKESMAS=a.KD_PUSKESMAS LEFT JOIN mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN where a.BULAN = '$from' and a.TAHUN='$to'")->row();//print_r($data);die;
		$data['ukgs']=$db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS from t_ds_ukgs a LEFT JOIN mst_puskesmas c ON c.KD_PUSKESMAS=a.KD_PUSKESMAS LEFT JOIN mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN where a.BULAN = '$from' and a.TAHUN='$to'")->result_array();//print_r($data);die;
		//print_r($data);die;
		if(!empty($data['waktu'])){
					$this->load->view('reports/v_lap_ukgs_temp', $data);
				}else{
					echo 'No Data Found';die;
				}
	}
	
	public function lapgizi()
	{			
		$this->load->view('reports/lap_gizi');		
	}
	
	public function lapgizi_lihat()
	{	
		
		$from = $this->input->get('from');
		$to = $this->input->get('to');
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?"AND SUBSTRING(a.`KD_PUSKESMAS`,2,4) = '".$pid."' ":"AND a.`KD_PUSKESMAS` = '".$pid."' ";
		$db = $this->load->database('sikda', TRUE);
		
		$data = array();
		$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_gizi a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'".$dtsql."")->row();//print_r($data);die;
		$data['gizi'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_gizi a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'".$dtsql."")->result_array(); //print_r($db->last_query());die;
				
				if(!empty($data['waktu'])){
					$this->load->view('reports/v_lap_gizi', $data);
				}else{
					echo 'No data found';die;
				}
	
	}
	
	public function lapgizi_temp()
	{	
		
		$from = $this->input->get('from');
		$to = $this->input->get('to');
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?"AND SUBSTRING(a.`KD_PUSKESMAS`,2,4) = '".$pid."' ":"AND a.`KD_PUSKESMAS` = '".$pid."' ";
		$db = $this->load->database('sikda', TRUE);
		
		$query = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_gizi a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'");//print_r($query);die;
		if($query->num_rows>0){
		
		$data = $query->result(); //print_r($data);die;

		if(!$query)
            return false;
			
		$this->load->library('excel');
		$this->excel->getActiveSheet()->setTitle('Data Gizi');
        $this->excel->getProperties()->setTitle("export")->setDescription("none");	
		
		
		$objReader = PHPExcel_IOFactory::createReader('Excel5');  
		$objPHPExcel = $objReader->load("tmp/laporan_gizi.xls");  
		
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()
			->setCellValue('A1', 'LAPORAN  BULANAN  GIZI')
            ->setCellValue('A2', 'BULAN : '.$data[0]->bulan)
            ->setCellValue('A3', 'TAHUN : '.$data[0]->TAHUN)
            ->setCellValue('A4', 'DINAS KESEHATAN KAB/KOTA '.$data[0]->KABUPATEN);
		
		// Fetching the table data
		$rw=9;
		$no=1;
		$a = '';
		$b = '';
		$c = '';
		$d = '';
		$e = '';
		$f = '';
		$g = '';
		$h = '';
		$i = '';
		$j = '';
		$k = '';
		$l = '';
		$m = '';
		$n = '';
		$o = '';
		$p = '';
		$q = '';
		$r = '';
		$s = '';
		$t = '';
		$u = '';
		$v = '';
		$w = '';
		$x = '';
		$y = '';
		$z = '';
		$aa = '';
		$ab = '';
		$ac = '';
		$ad = '';
		$ae = '';
		$af = '';
		$ag = '';
		$ah = '';
		$ai = '';
		$aj = '';
		$ak = '';
		$al = '';
        foreach($data as $value)
        {	
		$styleArray = array(
						'borders' => array(
									'allborders' => array(
									'style' => PHPExcel_Style_Border::BORDER_THIN,
									),
							),
		);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AN'.$rw)->applyFromArray($styleArray);
		
			$a = 0; 
			$b = 0; 
			$c = 0; 
			$d = 0; 
			$e = 0; 
			$f = $value->BAYI_L_0_6_S + $value->BAYI_P_0_6_S + $value->BAYI_L_6_12_S + $value->BAYI_P_6_12_S; 
			$g = $value->ANAK_L_12_36_S + $value->ANAK_P_12_36_S; 
			$h = $value->ANAK_L_37_60_S + $value->ANAK_P_37_60_S; 
			$i = $value->BAYI_L_0_6_S + $value->BAYI_P_0_6_S + $value->BAYI_L_6_12_S + $value->BAYI_P_6_12_S + $value->ANAK_L_12_36_S + $value->ANAK_P_12_36_S + $value->ANAK_L_37_60_S + $value->ANAK_P_37_60_S; 
			$j = $value->BAYI_L_0_12_KMS_K + $value->BAYI_P_0_12_KMS_K; 
			$k = $value->ANAK_L_12_36_KMS_K + $value->ANAK_P_12_36_KMS_K; 
			$l = $value->ANAK_L_37_60_KMS_K + $value->ANAK_P_37_60_KMS_K; 
			$m = $value->BAYI_L_0_12_KMS_K + $value->BAYI_P_0_12_KMS_K + $value->ANAK_L_12_36_KMS_K + $value->ANAK_P_12_36_KMS_K + $value->ANAK_L_37_60_KMS_K + $value->ANAK_P_37_60_KMS_K; 
			$n = $value->BAYI_L_0_12_D + $value->BAYI_P_0_12_D; 
			$o = $value->ANAK_L_12_36_D + $value->ANAK_P_12_36_D; 
			$p = $value->ANAK_L_37_60_D + $value->ANAK_P_37_60_D; 
			$q = $value->BAYI_L_0_12_D + $value->BAYI_P_0_12_D + $value->ANAK_L_12_36_D + $value->ANAK_P_12_36_D + $value->ANAK_L_37_60_D + $value->ANAK_P_37_60_D; 
			$r = $value->BAYI_L_0_12_N + $value->BAYI_P_0_12_N; 
			$s = $value->ANAK_L_12_36_N + $value->ANAK_P_12_36_N; 
			$t = $value->ANAK_L_37_60_N + $value->ANAK_P_37_60_N; 
			$u = $value->BAYI_L_0_12_N + $value->BAYI_P_0_12_N + $value->ANAK_L_12_36_N + $value->ANAK_P_12_36_N + $value->ANAK_L_37_60_N + $value->ANAK_P_37_60_N; 
			$v = $value->BAYI_L_PK_MENIMBANG_B1 + $value->BAYI_P_PK_MENIMBANG_B1; 
			$w = $value->BAYI_L_KK_MENIMBANG_B6 + $value-> BAYI_P_KK_MENIMBANG_B6; 
			$x = 0; 
			$y = $value->BAYI_L_BGM_MP_ASI + $value->BAYI_P_BGM_MP_ASI; 
			$z = $value->BAYI_L_6_12_K_VIT_A + $value->BAYI_P_6_12_K_VIT_A; 
			$aa = $value->ANAK_L_12_60_K_VIT_A + $value->ANAK_P_12_60_K_VIT_A; 
			$ab = 0;
			$ac = $value->IBU_HAMIL_TTD_FE_30 + $value->IBU_HAMIL_TTD_FE_60 + $value->IBU_HAMIL_TTD_FE_90; 
			$ad = $value->IBU_HAMIL_TTD_FE_30; 
			$ae = $value->IBU_HAMIL_TTD_FE_60; 
			$af = $value->IBU_HAMIL_TTD_FE_90; 
			$ag = 0; 
			$ah = $value->VIT_A_100RB_IU + $value->VIT_A_200RB_IU; 
			$ai = $value->IBU_HAMIL_TTD_FE_30 + $value->IBU_HAMIL_TTD_FE_60 + $value->IBU_HAMIL_TTD_FE_90; 
			$aj = $value->BUMIL_KEK_BARU; 
			$ak = $value->BUMIL_KEK_LAMA; 
			$al = 0; 
            $objPHPExcel->getActiveSheet()->setTitle('Laporan Gizi')
            ->setCellValue('A'.$rw, $no)
            ->setCellValue('B'.$rw, $value->PUSKESMAS)
            ->setCellValue('C'.$rw, $a)
            ->setCellValue('D'.$rw, $b)
            ->setCellValue('E'.$rw, $c)
            ->setCellValue('F'.$rw, $d)
            ->setCellValue('G'.$rw, $e)
            ->setCellValue('H'.$rw, $f)
            ->setCellValue('I'.$rw, $g)
            ->setCellValue('J'.$rw, $h)
            ->setCellValue('K'.$rw, $i)
            ->setCellValue('L'.$rw, $j)
            ->setCellValue('M'.$rw, $k)
            ->setCellValue('N'.$rw, $l)
            ->setCellValue('O'.$rw, $m)
            ->setCellValue('P'.$rw, $n)
            ->setCellValue('Q'.$rw, $o)
            ->setCellValue('R'.$rw, $p)
            ->setCellValue('S'.$rw, $q)
            ->setCellValue('T'.$rw, $r)
            ->setCellValue('U'.$rw, $s)
            ->setCellValue('V'.$rw, $t)
            ->setCellValue('W'.$rw, $u)
            ->setCellValue('X'.$rw, $v)
            ->setCellValue('Y'.$rw, $w)
            ->setCellValue('Z'.$rw, $x)
            ->setCellValue('AA'.$rw, $y)
            ->setCellValue('AB'.$rw, $z)
            ->setCellValue('AC'.$rw, $aa)
            ->setCellValue('AD'.$rw, $ab)
            ->setCellValue('AE'.$rw, $ac)
            ->setCellValue('AF'.$rw, $ad)
            ->setCellValue('AG'.$rw, $ae)
            ->setCellValue('AH'.$rw, $af)
            ->setCellValue('AI'.$rw, $ag)
            ->setCellValue('AJ'.$rw, $ah)
            ->setCellValue('AK'.$rw, $ai)
            ->setCellValue('AL'.$rw, $aj)
            ->setCellValue('AM'.$rw, $ak)
            ->setCellValue('AN'.$rw, $al);
		$rw++;
		$no++;
        } //die('=SUM(C10:C'.$rw.')');
		$objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$rw, 'JUMLAH')
            ->setCellValue('C'.$rw, '=SUM(C9:C'.($rw-1).')')
            ->setCellValue('D'.$rw, '=SUM(D9:D'.($rw-1).')')
            ->setCellValue('E'.$rw, '=SUM(E9:E'.($rw-1).')')
            ->setCellValue('F'.$rw, '=SUM(F9:F'.($rw-1).')')
            ->setCellValue('G'.$rw, '=SUM(G9:G'.($rw-1).')')
            ->setCellValue('H'.$rw, '=SUM(H9:H'.($rw-1).')')
            ->setCellValue('I'.$rw, '=SUM(I9:I'.($rw-1).')')
            ->setCellValue('J'.$rw, '=SUM(J9:J'.($rw-1).')')
            ->setCellValue('K'.$rw, '=SUM(K9:K'.($rw-1).')')
            ->setCellValue('L'.$rw, '=SUM(L9:L'.($rw-1).')')
            ->setCellValue('M'.$rw, '=SUM(M9:M'.($rw-1).')')
            ->setCellValue('N'.$rw, '=SUM(N9:N'.($rw-1).')')
            ->setCellValue('O'.$rw, '=SUM(O9:O'.($rw-1).')')
            ->setCellValue('P'.$rw, '=SUM(P9:P'.($rw-1).')')
            ->setCellValue('Q'.$rw, '=SUM(Q9:Q'.($rw-1).')')
            ->setCellValue('R'.$rw, '=SUM(R9:R'.($rw-1).')')
            ->setCellValue('S'.$rw, '=SUM(S9:S'.($rw-1).')')
            ->setCellValue('T'.$rw, '=SUM(T9:T'.($rw-1).')')
            ->setCellValue('U'.$rw, '=SUM(U9:U'.($rw-1).')')
            ->setCellValue('V'.$rw, '=SUM(V9:V'.($rw-1).')')
            ->setCellValue('W'.$rw, '=SUM(W9:W'.($rw-1).')')
            ->setCellValue('X'.$rw, '=SUM(X9:X'.($rw-1).')')
            ->setCellValue('Y'.$rw, '=SUM(Y9:Y'.($rw-1).')')
            ->setCellValue('Z'.$rw, '=SUM(Z9:Z'.($rw-1).')')
            ->setCellValue('AA'.$rw, '=SUM(AA9:AA'.($rw-1).')')
            ->setCellValue('AB'.$rw, '=SUM(AB9:AB'.($rw-1).')')
            ->setCellValue('AC'.$rw, '=SUM(AC9:AC'.($rw-1).')')
            ->setCellValue('AD'.$rw, '=SUM(AD9:AD'.($rw-1).')')
            ->setCellValue('AE'.$rw, '=SUM(AE9:AE'.($rw-1).')')
            ->setCellValue('AF'.$rw, '=SUM(AF9:AF'.($rw-1).')')
            ->setCellValue('AG'.$rw, '=SUM(AG9:AG'.($rw-1).')')
            ->setCellValue('AH'.$rw, '=SUM(AH9:AH'.($rw-1).')')
            ->setCellValue('AI'.$rw, '=SUM(AI9:AI'.($rw-1).')')
            ->setCellValue('AJ'.$rw, '=SUM(AJ9:AJ'.($rw-1).')')
            ->setCellValue('AK'.$rw, '=SUM(AK9:AK'.($rw-1).')')
            ->setCellValue('AL'.$rw, '=SUM(AL9:AL'.($rw-1).')')
            ->setCellValue('AM'.$rw, '=SUM(AM9:AM'.($rw-1).')')
            ->setCellValue('AN'.$rw, '=SUM(AN9:AN'.($rw-1).')');
			
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':B'.$rw);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AN'.$rw)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AN'.$rw)->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('f1f1f1f1');
			
		$styleArray = array(
						'borders' => array(
									'allborders' => array(
									'style' => PHPExcel_Style_Border::BORDER_THIN,
									),
							),
		);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AN'.$rw)->applyFromArray($styleArray);
		
		$filename='Laporan_bulanan_gizi.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
		}else{die('No data found');}
	}
	
	public function lapkegiatanpuskesmas()
	{			
		$this->load->view('reports/lap_kegiatanpuskesmas');		
	}
	
	public function lapkegiatanpuskesmas_lihat()
	{	
		$from = $this->input->get('from'); //print_r($from);die;
		$to = $this->input->get('to');
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?"AND SUBSTRING(a.`KD_PUSKESMAS`,2,4) = '".$pid."' ":"AND a.`KD_PUSKESMAS` = '".$pid."' ";
		$db = $this->load->database('sikda', TRUE);
		
		$data = array();
		$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_kegiatanpuskesmas a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'")->row();//print_r($data);die;
		$data['kegiatanpuskesmas'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_kegiatanpuskesmas a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'")->result_array();//print_r($data);die;
				if(!empty($data['waktu'])){
					$this->load->view('reports/v_lap_kegiatanpuskesmas', $data);
				}else{
					echo 'No data found';die;
				}
	}
	
	public function lapkegiatanpuskesmas_temp()
	{	
		$from = $this->input->get('from'); //print_r($from);die;
		$to = $this->input->get('to');
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?"AND SUBSTRING(a.`KD_PUSKESMAS`,2,4) = '".$pid."' ":"AND a.`KD_PUSKESMAS` = '".$pid."' ";
		$db = $this->load->database('sikda', TRUE);
		
		$query = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_kegiatanpuskesmas a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'");//print_r($query);die;
		if($query->num_rows>0){
		$data = $query->result(); //print_r($data);die;
		
		if(!$query)
            return false;
			
		$this->load->library('excel');
		$this->excel->getActiveSheet()->setTitle('Data Kegiatan Puskesmas');
        $this->excel->getProperties()->setTitle("export")->setDescription("none");	
		
		
		$objReader = PHPExcel_IOFactory::createReader('Excel5');  
		$objPHPExcel = $objReader->load("tmp/laporan_kegiatan_puskesmas.xls");  
		
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()
			->setCellValue('A1', 'LAPORAN  BULANAN  KEGIATAN PUSKESMAS')
            ->setCellValue('A2', 'BULAN : '.$data[0]->bulan)
            ->setCellValue('A3', 'TAHUN : '.$data[0]->TAHUN)
            ->setCellValue('A4', 'DINAS KESEHATAN KAB/KOTA '.$data[0]->KABUPATEN);
		
		// Fetching the table data
		$rw=14;
		$no=1;
		$a = '';
		$b = '';
		$c = '';
		$d = '';
		$e = '';
		$f = '';
		$g = '';
		$h = '';
		$i = '';
		$j = '';
		$k = '';
		$l = '';
		$m = '';
		$n = '';
		$o = '';
		$p = '';
		$q = '';
		$r = '';
		$s = '';
		$t = '';
		$u = '';
		$v = '';
		$w = '';
		$x = '';
		$y = '';
		$z = '';
		$aa = '';
		$ab = '';
		$ac = '';
		$ad = '';
        foreach($data as $value)
        {	
		$styleArray = array(
						'borders' => array(
									'allborders' => array(
									'style' => PHPExcel_Style_Border::BORDER_THIN,
									),
							),
		);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AF'.$rw)->applyFromArray($styleArray);
		
			$a = $value->JML_KR_DARI_PUSKESMAS + $value->JML_KR_DARI_PUSKESMAS_P; 
			$b = $value->JML_KR_B_RUMAH_SAKIT + $value->JML_KR_B_RUMAH_SAKIT_P; 
			$c = $value->JML_KR_KA_PUSKESMAS + $value->JML_KR_KA_PUSKESMAS_P; 
			$d = $value->JML_KR_PO_PUSKESMAS + $value->JML_KR_PO_PUSKESMAS_P; 
			$e = $value->JML_KR_PU_PUSKESMAS + $value->JML_KR_PU_PUSKESMAS_P; 
			$f = $value->JML_KR_SE_PUSKESMAS + $value->JML_KR_SE_PUSKESMAS_P; 
			$g = $value->JML_KR_LAIN_PUSKESMAS + $value->JML_KR_LAIN_PUSKESMAS_P; 
			$h = $value->JML_KR_KE_PUSKESMAS + $value->JML_KR_KE_PUSKESMAS_P; 
			$i = $value->JML_KR_K_DOKTER_AHLI + $value->JML_KR_K_DOKTER_AHLI_P; 
			$j = $value->KL_PS_DARAH + $value->KL_PS_DARAH_P; 
			$k = $value->KL_PS_URINE + $value->KL_PS_URINE_P; 
			$l = $value->KL_PS_TINJA + $value->KL_PS_TINJA_P; 
			$m = $value->KL_PS_LAIN + $value->KL_PS_LAIN_P; 
			$n = $value->JML_PKR_PUSKESMAS + $value->JML_PKR_PUSKESMAS_P; 
			$o = $value->JML_PKR_DIBINA + $value->JML_PKR_DIBINA_P; 
			$p = $value->JML_PKR_KUNJUNGAN_DIBINA + $value->JML_PKR_KUNJUNGAN_DIBINA_P; 
			$q = $value->JML_KASUS_TLPSB + $value->JML_KASUS_TLPSB_P; 
			$r = $value->JML_KUNJ_TLPSB + $value->JML_KUNJ_TLPSB_P; 
			$s = $value->JML_PGR_BUMIL_PERAWATAN_P; 
			$t = $value->JML_PGR_BALITA_PERAWATAN + $value->JML_PGR_BALITA_PERAWATAN_P; 
			$u = $value->JML_PKKP_DIBINA + $value->JML_PKKP_DIBINA_P; 
			$v = $value->JML_KK_UMUM_BAYAR + $value->JML_KK_UMUM_BAYAR_P; 
			$w = $value->JML_KK_ASKES + $value->JML_KK_ASKES_P; 
			$x = $value->JML_KK_JPS_K_SEHAT + $value->JML_KK_JPS_K_SEHAT_P; 
			$y = $value->JML_RT_P_DIRAWAT + $value->JML_RT_P_DIRAWAT_P; 
			$z = $value->JML_RT_H_PERAWATAN + $value->JML_RT_H_PERAWATAN_P; 
			$aa = $value->JML_RT_T_TIDUR + $value->JML_RT_T_TIDUR_P; 
			$ab = $value->JML_RT_H_BUKA + $value->JML_RT_H_BUKA_P; 
			$ac = $value->JML_RT_PK_MENINGGAL_K_48 + $value->JML_RT_PK_MENINGGAL_K_48_P; 
			$ad = $value->JML_RT_PK_MENINGGAL_L_48 + $value->JML_RT_PK_MENINGGAL_L_48_P; 
            $objPHPExcel->getActiveSheet()->setTitle('Laporan Keg Puskesmas')
            ->setCellValue('A'.$rw, $no)
            ->setCellValue('B'.$rw, $value->PUSKESMAS)
            ->setCellValue('C'.$rw, $a)
            ->setCellValue('D'.$rw, $b)
            ->setCellValue('E'.$rw, $c)
            ->setCellValue('F'.$rw, $d)
            ->setCellValue('G'.$rw, $e)
            ->setCellValue('H'.$rw, $f)
            ->setCellValue('I'.$rw, $g)
            ->setCellValue('J'.$rw, $h)
            ->setCellValue('K'.$rw, $i)
            ->setCellValue('L'.$rw, $j)
            ->setCellValue('M'.$rw, $k)
            ->setCellValue('N'.$rw, $l)
            ->setCellValue('O'.$rw, $m)
            ->setCellValue('P'.$rw, $n)
            ->setCellValue('Q'.$rw, $o)
            ->setCellValue('R'.$rw, $p)
            ->setCellValue('S'.$rw, $q)
            ->setCellValue('T'.$rw, $r)
            ->setCellValue('U'.$rw, $s)
            ->setCellValue('V'.$rw, $t)
            ->setCellValue('W'.$rw, $u)
            ->setCellValue('X'.$rw, $v)
            ->setCellValue('Y'.$rw, $w)
            ->setCellValue('Z'.$rw, $x)
            ->setCellValue('AA'.$rw, $y)
            ->setCellValue('AB'.$rw, $z)
            ->setCellValue('AC'.$rw, $aa)
            ->setCellValue('AD'.$rw, $ab)
            ->setCellValue('AE'.$rw, $ac)
            ->setCellValue('AF'.$rw, $ad);
		$rw++;
		$no++;
        }
		$objPHPExcel->getActiveSheet()
			->setCellValue('A'.$rw, 'JUMLAH')
            ->setCellValue('C'.$rw, '=SUM(C14:C'.($rw-1).')')
            ->setCellValue('D'.$rw, '=SUM(D14:D'.($rw-1).')')
            ->setCellValue('E'.$rw, '=SUM(E14:E'.($rw-1).')')
            ->setCellValue('F'.$rw, '=SUM(F14:F'.($rw-1).')')
            ->setCellValue('G'.$rw, '=SUM(G14:G'.($rw-1).')')
            ->setCellValue('H'.$rw, '=SUM(H14:H'.($rw-1).')')
            ->setCellValue('I'.$rw, '=SUM(I14:I'.($rw-1).')')
            ->setCellValue('J'.$rw, '=SUM(J14:J'.($rw-1).')')
            ->setCellValue('K'.$rw, '=SUM(K14:K'.($rw-1).')')
            ->setCellValue('L'.$rw, '=SUM(L14:L'.($rw-1).')')
            ->setCellValue('M'.$rw, '=SUM(M14:M'.($rw-1).')')
            ->setCellValue('N'.$rw, '=SUM(N14:N'.($rw-1).')')
            ->setCellValue('O'.$rw, '=SUM(O14:O'.($rw-1).')')
            ->setCellValue('P'.$rw, '=SUM(P14:P'.($rw-1).')')
            ->setCellValue('Q'.$rw, '=SUM(Q14:Q'.($rw-1).')')
            ->setCellValue('R'.$rw, '=SUM(R14:R'.($rw-1).')')
            ->setCellValue('S'.$rw, '=SUM(S14:S'.($rw-1).')')
            ->setCellValue('T'.$rw, '=SUM(T14:T'.($rw-1).')')
            ->setCellValue('U'.$rw, '=SUM(U14:U'.($rw-1).')')
            ->setCellValue('V'.$rw, '=SUM(V14:V'.($rw-1).')')
            ->setCellValue('W'.$rw, '=SUM(W14:W'.($rw-1).')')
            ->setCellValue('X'.$rw, '=SUM(X14:X'.($rw-1).')')
            ->setCellValue('Y'.$rw, '=SUM(Y14:Y'.($rw-1).')')
            ->setCellValue('Z'.$rw, '=SUM(Z14:Z'.($rw-1).')')
            ->setCellValue('AA'.$rw, '=SUM(AA14:AA'.($rw-1).')')
            ->setCellValue('AB'.$rw, '=SUM(AB14:AB'.($rw-1).')')
            ->setCellValue('AC'.$rw, '=SUM(AC14:AC'.($rw-1).')')
            ->setCellValue('AD'.$rw, '=SUM(AD14:AD'.($rw-1).')')
            ->setCellValue('AE'.$rw, '=SUM(AE14:AE'.($rw-1).')')
            ->setCellValue('AF'.$rw, '=SUM(AF14:AF'.($rw-1).')');
			
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':B'.$rw);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AF'.$rw)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AF'.$rw)->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('f1f1f1f1');
			
		$styleArray = array(
						'borders' => array(
									'allborders' => array(
									'style' => PHPExcel_Style_Border::BORDER_THIN,
									),
							),
		);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AF'.$rw)->applyFromArray($styleArray);
		
		$filename='Laporan_bulanan_keg_puskesmas.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
		}else{die('No data found');}
	}
	
	public function lapkb()
	{			
		$this->load->view('reports/lap_kb');		
	}
	
	public function lapkb_temp()
	{
		$from = $this->input->get('from');
		$to = $this->input->get('to');
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?"AND SUBSTRING(a.`KD_PUSKESMAS`,2,4) = '".$pid."' ":"AND a.`KD_PUSKESMAS` = '".$pid."' ";
		$db = $this->load->database('sikda', TRUE);
		$data = array();
		$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as BULAN, b.KABUPATEN, c.PUSKESMAS  from t_ds_kb a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'")->row();//print_r($data);die;
		$data['kb'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as BULAN, b.KABUPATEN, c.PUSKESMAS  from t_ds_kb a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'")->result_array();//print_r($data);die;
				if(!empty($data['waktu'])){
					$this->load->view('reports/v_lap_kb', $data);
				}else{
					echo 'Data tidak ditemukan';die;
				}
	}
	
		public function lapkb_temp_excel()
	{
		
		$from = $this->input->get('from');
		$to = $this->input->get('to'); 
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?"AND SUBSTRING(pl.`KD_PUSKESMAS`,2,4) = '".$pid."' ":"AND pl.`KD_PUSKESMAS` = '".$pid."' ";
		$db = $this->load->database('sikda', TRUE);

		$query = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_kb a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'");//print_r($query);die;
		if($query->num_rows>0){
		$data = $query->result();
		
        if(!$data)
            return false;
 
        // Starting the PHPExcel library
        $this->load->library('Excel');
		$this->excel->getActiveSheet()->setTitle('Data Laporan KB');
        $this->excel->getProperties()->setTitle("export")->setDescription("none");
		
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objPHPExcel = $objReader->load("../sikda-puskesmas/tmp/Laporan KB.xls");
		
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()
            ->setCellValue('C3', ': '.$data[0]->bulan)
            ->setCellValue('C4', ': '.$data[0]->TAHUN)
            ->setCellValue('C5', ': '.$data[0]->KABUPATEN);
		$objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		
        // Fetching the table data for SDMI
		$rw=10;
		$no=1;
        foreach($data as $value)
        {			
			
			$TOTAL_JML_B_TEMP = $value->AKS_BDAK_IUD + $value->AKS_BDAK_MOW + $value->AKS_BDAK_MOP + $value->AKS_BDAK_IMPLANT + $value->AKS_BDAK_SUNTIK + $value->AKS_BDAK_PIL + $value->AKS_BDAK_KONDOM;
			$TOTAL_PERSEN_B_TEMP = $value->AKS_BDAK_IUD + $value->AKS_BDAK_MOW + $value->AKS_BDAK_MOP + $value->AKS_BDAK_IMPLANT + $value->AKS_BDAK_SUNTIK + $value->AKS_BDAK_PIL + $value->AKS_BDAK_KONDOM;
			$TOTAL_JML_A_TEMP = $value->AKS_ADA_IUD + $value->AKS_ADA_MOW + $value->AKS_ADA_MOP + $value->AKS_ADA_IMPLANT + $value->AKS_ADA_SUNTIK + $value->AKS_ADA_PIL + $value->AKS_ADA_KONDOM;
			$TOTAL_PERSEN_A_TEMP = $value->AKS_ADA_IUD + $value->AKS_ADA_MOW + $value->AKS_ADA_MOP + $value->AKS_ADA_IMPLANT + $value->AKS_ADA_SUNTIK + $value->AKS_ADA_PIL + $value->AKS_ADA_KONDOM;
			$TOTAL_JML_E_TEMP = $value->EFK_SMK_IUD + $value->EFK_SMK_MOW + $value->EFK_SMK_MOP + $value->EFK_SMK_IMPLANT + $value->EFK_SMK_SUNTIK + $value->EFK_SMK_PIL + $value->EFK_SMK_KONDOM;
			$TOTAL_PERSEN_E_TEMP = $value->EFK_SMK_IUD + $value->EFK_SMK_MOW + $value->EFK_SMK_MOP + $value->EFK_SMK_IMPLANT + $value->EFK_SMK_SUNTIK + $value->EFK_SMK_PIL + $value->EFK_SMK_KONDOM;
			$TOTAL_JML_G_TEMP = $value->KGL_MK_IUD + $value->KGL_MK_MOW + $value->KGL_MK_MOP + $value->KGL_MK_IMPLANT + $value->KGL_MK_SUNTIK + $value->KGL_MK_PIL + $value->KGL_MK_KONDOM;
			$TOTAL_PERSEN_G_TEMP = $value->KGL_MK_IUD + $value->KGL_MK_MOW + $value->KGL_MK_MOP + $value->KGL_MK_IMPLANT + $value->KGL_MK_SUNTIK + $value->KGL_MK_PIL + $value->KGL_MK_KONDOM;
			
			$styleArray = array(
				'borders' => array(
				'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
					),
				),
			);
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AQ'.$rw)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$rw.':AQ'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AQ'.$rw)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()->setARGB('F0F0F0F0');
			
            $objPHPExcel->getActiveSheet()->setTitle('SDMI')
            ->setCellValue('A'.$rw, $no)
            ->setCellValue('B'.$rw, $value->PUSKESMAS)
            ->setCellValue('C'.$rw, 0)
            ->setCellValue('D'.$rw, $value->AKS_BDAK_IUD)
            ->setCellValue('E'.$rw, $value->AKS_BDAK_MOW)
            ->setCellValue('F'.$rw, $value->AKS_BDAK_MOP)
            ->setCellValue('G'.$rw, $value->AKS_BDAK_IMPLANT)
            ->setCellValue('H'.$rw, $value->AKS_BDAK_SUNTIK)
            ->setCellValue('I'.$rw, $value->AKS_BDAK_PIL)
            ->setCellValue('J'.$rw, $value->AKS_BDAK_KONDOM)
            ->setCellValue('K'.$rw, $TOTAL_JML_B_TEMP)
            ->setCellValue('L'.$rw, $TOTAL_PERSEN_B_TEMP)
            ->setCellValue('M'.$rw, 0)
			->setCellValue('N'.$rw, $value->AKS_ADA_IUD)
            ->setCellValue('O'.$rw, $value->AKS_ADA_MOW)
            ->setCellValue('P'.$rw, $value->AKS_ADA_MOP)
            ->setCellValue('Q'.$rw, $value->AKS_ADA_IMPLANT)
            ->setCellValue('R'.$rw, $value->AKS_ADA_SUNTIK)
            ->setCellValue('S'.$rw, $value->AKS_ADA_PIL)
            ->setCellValue('T'.$rw, $value->AKS_ADA_KONDOM)
            ->setCellValue('U'.$rw, $TOTAL_JML_A_TEMP)
            ->setCellValue('V'.$rw, $TOTAL_PERSEN_A_TEMP)
			->setCellValue('W'.$rw, $value->EFK_SMK_IUD)
            ->setCellValue('X'.$rw, $value->EFK_SMK_MOW)
            ->setCellValue('Y'.$rw, $value->EFK_SMK_MOP)
            ->setCellValue('Z'.$rw, $value->EFK_SMK_IMPLANT)
            ->setCellValue('AA'.$rw, $value->EFK_SMK_SUNTIK)
            ->setCellValue('AB'.$rw, $value->EFK_SMK_PIL)
            ->setCellValue('AC'.$rw, $value->EFK_SMK_KONDOM)
            ->setCellValue('AD'.$rw, $TOTAL_JML_E_TEMP)
            ->setCellValue('AE'.$rw, $TOTAL_PERSEN_E_TEMP)
			->setCellValue('AF'.$rw, $value->KGL_MK_IUD)
            ->setCellValue('AG'.$rw, $value->KGL_MK_MOW)
            ->setCellValue('AH'.$rw, $value->KGL_MK_MOP)
            ->setCellValue('AI'.$rw, $value->KGL_MK_IMPLANT)
            ->setCellValue('AJ'.$rw, $value->KGL_MK_SUNTIK)
            ->setCellValue('AK'.$rw, $value->KGL_MK_PIL)
            ->setCellValue('AL'.$rw, $value->KGL_MK_KONDOM)
            ->setCellValue('AM'.$rw, $TOTAL_JML_G_TEMP)
            ->setCellValue('AN'.$rw, $TOTAL_PERSEN_G_TEMP)
			->setCellValue('AO'.$rw, $value->JML_RYMP_KRR)
            ->setCellValue('AP'.$rw, $value->JML_PK_REMAJA)
            ->setCellValue('AQ'.$rw, $value->JML_BRBY_DITANGANI);
            
		$rw++;
		$no++;
        } //die('=SUM(C10:C'.$rw.')');
		
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':B'.$rw);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':B'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$rw.':AQ'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AQ'.$rw)->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('F0F0F0F0');
			
		$styleArray = array(
			'borders' => array(
			'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
			),
		);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AQ'.$rw)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$rw, 'JUMLAH')
            ->setCellValue('C'.$rw, '=SUM(C10:C'.($rw-1).')')
            ->setCellValue('D'.$rw, '=SUM(D10:D'.($rw-1).')')
            ->setCellValue('E'.$rw, '=SUM(E10:E'.($rw-1).')')
            ->setCellValue('F'.$rw, '=SUM(F10:F'.($rw-1).')')
            ->setCellValue('G'.$rw, '=SUM(G10:G'.($rw-1).')')
            ->setCellValue('H'.$rw, '=SUM(H10:H'.($rw-1).')')
            ->setCellValue('I'.$rw, '=SUM(I10:I'.($rw-1).')')
            ->setCellValue('J'.$rw, '=SUM(J10:J'.($rw-1).')')
            ->setCellValue('K'.$rw, '=SUM(K10:K'.($rw-1).')')
            ->setCellValue('L'.$rw, '=SUM(L10:L'.($rw-1).')')
            ->setCellValue('M'.$rw, '=SUM(M10:M'.($rw-1).')')
			->setCellValue('N'.$rw, '=SUM(N10:N'.($rw-1).')')
            ->setCellValue('O'.$rw, '=SUM(O10:O'.($rw-1).')')
            ->setCellValue('P'.$rw, '=SUM(P10:P'.($rw-1).')')
            ->setCellValue('Q'.$rw, '=SUM(Q10:Q'.($rw-1).')')
            ->setCellValue('R'.$rw, '=SUM(R10:R'.($rw-1).')')
            ->setCellValue('S'.$rw, '=SUM(S10:S'.($rw-1).')')
            ->setCellValue('T'.$rw, '=SUM(T10:T'.($rw-1).')')
            ->setCellValue('U'.$rw, '=SUM(U10:U'.($rw-1).')')
            ->setCellValue('V'.$rw, '=SUM(V10:V'.($rw-1).')')
			->setCellValue('W'.$rw, '=SUM(W10:W'.($rw-1).')')
            ->setCellValue('X'.$rw, '=SUM(X10:X'.($rw-1).')')
            ->setCellValue('Y'.$rw, '=SUM(Y10:Y'.($rw-1).')')
            ->setCellValue('Z'.$rw, '=SUM(Z10:Z'.($rw-1).')')
            ->setCellValue('AA'.$rw, '=SUM(AA10:AA'.($rw-1).')')
            ->setCellValue('AB'.$rw, '=SUM(AB10:AB'.($rw-1).')')
            ->setCellValue('AC'.$rw, '=SUM(AC10:AC'.($rw-1).')')
            ->setCellValue('AD'.$rw, '=SUM(AD10:AD'.($rw-1).')')
            ->setCellValue('AE'.$rw, '=SUM(AE10:AE'.($rw-1).')')
			->setCellValue('AF'.$rw, '=SUM(AF10:AF'.($rw-1).')')
            ->setCellValue('AG'.$rw, '=SUM(AG10:AG'.($rw-1).')')
            ->setCellValue('AH'.$rw, '=SUM(AH10:AH'.($rw-1).')')
            ->setCellValue('AI'.$rw, '=SUM(AI10:AI'.($rw-1).')')
            ->setCellValue('AJ'.$rw, '=SUM(AJ10:AJ'.($rw-1).')')
            ->setCellValue('AK'.$rw, '=SUM(AK10:AK'.($rw-1).')')
            ->setCellValue('AL'.$rw, '=SUM(AL10:AL'.($rw-1).')')
            ->setCellValue('AM'.$rw, '=SUM(AM10:AM'.($rw-1).')')
            ->setCellValue('AN'.$rw, '=SUM(AN10:AN'.($rw-1).')')
			->setCellValue('AO'.$rw, '=SUM(AO10:AO'.($rw-1).')')
            ->setCellValue('AP'.$rw, '=SUM(AP10:AP'.($rw-1).')')
            ->setCellValue('AQ'.$rw, '=SUM(AQ10:AQ'.($rw-1).')');           
			
			
		$filename='Laporan KB.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
		}else{
			die('Data tidak ditemukan');
		}
		
    }
	
	public function lapimunisasi()
	{			
		$this->load->view('reports/lap_imunisasi');		
	}
	
	public function lapimunisasi_temp()
	{
		$from = $this->input->get('from');
		$to = $this->input->get('to');
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?"AND SUBSTRING(a.`KD_PUSKESMAS`,2,4) = '".$pid."' ":"AND a.`KD_PUSKESMAS` = '".$pid."' ";
		$db = $this->load->database('sikda', TRUE);
		$data = array();
		$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as BULAN, b.KABUPATEN, c.PUSKESMAS  from t_ds_imunisasi a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'".$dtsql."")->row();//print_r($data);die;
		$data['imun'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as BULAN, b.KABUPATEN, c.PUSKESMAS  from t_ds_imunisasi a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'".$dtsql."")->result_array();//print_r($data);die;
				if(!empty($data['waktu'])){
					$this->load->view('reports/v_lap_imunisasi', $data);
				}else{
					echo 'Data tidak ditemukan';die;
				}
	}
	
	public function lapuks()
	{			
		$this->load->view('reports/lap_uks');		
	}
	
	public function lapuks_temp(){
	//print_r($_POST);die;
	
		
		$from = $this->input->get('from');	//print_r($from);die;
		$to = $this->input->get('to'); //print_r($to);die;
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?"AND SUBSTRING(pl.`KD_PUSKESMAS`,2,4) = '".$pid."' ":"AND pl.`KD_PUSKESMAS` = '".$pid."' ";
		$db = $this->load->database('sikda', TRUE);
		$data = array();
		$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_uks a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'")->row();//print_r($data);die;
		$data['uks'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_uks a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'")->result_array();//print_r($data);die;
		//print_r($data);die;
		
				if(!empty($data['waktu'])){
					$this->load->view('reports/lap_uks_file', $data);
				}else{
					echo 'No Data Found';die;
				}
		
		
		
		
		
	
	}
	
	public function lap_datadasar()
	{			
		$this->load->view('reports/lap_datadasar');		
	}
	
	/*public function lap_datadasar_temp()
	{	
		$caritahun = $this->input->get('caritahun');
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?"AND SUBSTRING(pl.`KD_PUSKESMAS`,2,4) = '".$pid."' ":"AND pl.`KD_PUSKESMAS` = '".$pid."' ";
		$sql = "
		SELECT pl.*,a.KELURAHAN,b.PUSKESMAS,c.KABUPATEN FROM t_ds_datadasar pl left join mst_kabupaten c on c.KD_KABUPATEN=pl.KD_KABUPATEN left join mst_kelurahan a on a.KD_KELURAHAN=pl.KD_KELURAHAN left join mst_puskesmas b on b.KD_PUSKESMAS=pl.KD_PUSKESMAS 
		WHERE pl.TAHUN='".$caritahun."'  
		".$dtsql."
		GROUP BY pl.`KD_PUSKESMAS`
		";
		$db = $this->load->database('sikda', TRUE);
		$val[] = $db->query($sql)->result_array();
		$data['dita'] = $val;
		if(empty($val[0])){die("Tidak ada data!");}else{
		$this->load->view('reports/lap_datadasar_table',$data);
		}
	}
	*/
	
	public function lapimunisasi_temp_excel()
	{
				
		$from = $this->input->get('from');
		$to = $this->input->get('to'); 
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?"AND SUBSTRING(pl.`KD_PUSKESMAS`,2,4) = '".$pid."' ":"AND pl.`KD_PUSKESMAS` = '".$pid."' ";
		$db = $this->load->database('sikda', TRUE);

		$query = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as BULAN, b.KABUPATEN, c.PUSKESMAS  from t_ds_imunisasi a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'");//print_r($query);die;
		if($query->num_rows>0){
		$data = $query->result();
		
        if(!$data)
            return false;
 
        // Starting the PHPExcel library
        $this->load->library('Excel');
		$this->excel->getActiveSheet()->setTitle('Data Laporan Imunisasi');
        $this->excel->getProperties()->setTitle("export")->setDescription("none");
		
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objPHPExcel = $objReader->load("../sikda-puskesmas/tmp/Laporan Imunisasi.xls");
		
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()
            ->setCellValue('C3', ': '.$data[0]->BULAN)
            ->setCellValue('C4', ': '.$data[0]->TAHUN)
            ->setCellValue('C5', ': '.$data[0]->KABUPATEN);
       
        // Fetching the table data for SDMI
		$rw=10;
		$no=1;
		foreach($data as $value)
        {	
		
		$JML_BCG_TEMP = $value->JML_IMUN_BCG_L + $value->JML_IMUN_BCG_P;
		$JML_DPT1_TEMP = $value->JML_IMUN_DPT1_L + $value->JML_IMUN_DPT1_P;
		$JML_DPT2_TEMP = $value->JML_IMUN_DPT2_L + $value->JML_IMUN_DPT2_P;
		$JML_DPT3_TEMP = $value->JML_IMUN_DPT3_L + $value->JML_IMUN_DPT3_P;
		$JML_POLIO1_TEMP = $value->JML_IMUN_POLIO1_L + $value->JML_IMUN_POLIO1_P;
		$JML_POLIO2_TEMP = $value->JML_IMUN_POLIO2_L + $value->JML_IMUN_POLIO2_P;
		$JML_POLIO3_TEMP = $value->JML_IMUN_POLIO3_L + $value->JML_IMUN_POLIO3_P;
		$JML_POLIO4_TEMP = $value->JML_IMUN_POLIO4_L + $value->JML_IMUN_POLIO4_P;
		$JML_CAMPAK_TEMP = $value->JML_IMUN_CAMPAK_L + $value->JML_IMUN_CAMPAK_P;
		$JML_UNIJECT_M7_TEMP = $value->JML_IMUN_HBU_M7_L + $value->JML_IMUN_HBU_M7_P;
		$JML_UNIJECT_P7_TEMP = $value->JML_IMUN_HBU_P7_L + $value->JML_IMUN_HBU_P7_P;
		$JML_UNIJECT_2_TEMP = $value->JML_IMUN_HB_UNIJECT2_L + $value->JML_IMUN_HB_UNIJECT2_P;
		$JML_UNIJECT_3_TEMP = $value->JML_IMUN_HB_UNIJECT3_L + $value->JML_IMUN_HB_UNIJECT3_P;
		$JML_VIAL_1_TEMP = $value->JML_IMUN_HB_VIAL1_L + $value->JML_IMUN_HB_VIAL1_P;
		$JML_VIAL_2_TEMP = $value->JML_IMUN_HB_VIAL2_L + $value->JML_IMUN_HB_VIAL2_P;
		$JML_VIAL_3_TEMP = $value->JML_IMUN_HB_VIAL3_L + $value->JML_IMUN_HB_VIAL3_P;
			
		$styleArray = array(
			'borders' => array(
			'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
			),
		);
			
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AD'.$rw)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$rw.':AD'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AD'.$rw)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('F0F0F0F0');
		
		
		$objPHPExcel->getActiveSheet()->setTitle('SDMI')
            ->setCellValue('A'.$rw, $no)
            ->setCellValue('B'.$rw, $value->PUSKESMAS)
			->setCellValue('C'.$rw, $JML_BCG_TEMP)
            ->setCellValue('D'.$rw, $JML_DPT1_TEMP)
			->setCellValue('E'.$rw, $JML_DPT2_TEMP)
            ->setCellValue('F'.$rw, $JML_DPT3_TEMP)
            ->setCellValue('G'.$rw, $JML_POLIO1_TEMP)
            ->setCellValue('H'.$rw, $JML_POLIO2_TEMP)
            ->setCellValue('I'.$rw, $JML_POLIO3_TEMP)
            ->setCellValue('J'.$rw, $JML_POLIO4_TEMP)
            ->setCellValue('K'.$rw, $JML_CAMPAK_TEMP)
            ->setCellValue('L'.$rw, $JML_UNIJECT_M7_TEMP)
            ->setCellValue('M'.$rw, $JML_UNIJECT_P7_TEMP)
            ->setCellValue('N'.$rw, $JML_UNIJECT_2_TEMP)
            ->setCellValue('O'.$rw, $JML_UNIJECT_3_TEMP)
            ->setCellValue('P'.$rw, $JML_VIAL_1_TEMP)
            ->setCellValue('Q'.$rw, $JML_VIAL_2_TEMP)
            ->setCellValue('R'.$rw, $JML_VIAL_3_TEMP)
            ->setCellValue('S'.$rw, $value->JML_IMUN_TT1_HAMIL_P)
            ->setCellValue('T'.$rw, $value->JML_IMUN_TT2_HAMIL_P)
            ->setCellValue('U'.$rw, $value->JML_IMUN_TT3_HAMIL_P)
            ->setCellValue('V'.$rw, $value->JML_IMUN_TT4_HAMIL_P)
            ->setCellValue('W'.$rw, $value->JML_IMUN_TT5_HAMIL_P)
            ->setCellValue('X'.$rw, $value->JML_IMUN_TT1_WUS_P)
            ->setCellValue('Y'.$rw, $value->JML_IMUN_TT2_WUS_P)
            ->setCellValue('Z'.$rw, $value->JML_IMUN_TT3_WUS_P)
            ->setCellValue('AA'.$rw, $value->JML_IMUN_TT4_WUS_P)
            ->setCellValue('AB'.$rw, $value->JML_IMUN_TT5_WUS_P)
            ->setCellValue('AC'.$rw, $value->JML_VDT1_ANAKSEKOLAH)
            ->setCellValue('AD'.$rw, $value->JML_VDT2_ANAKSEKOLAH);			
		
		$rw++;
		$no++;		
		}
		
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':B'.$rw);
		$objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':B'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$rw.':AD'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AD'.$rw)->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('F0F0F0F0');
			
		$styleArray = array(
			'borders' => array(
			'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
			),
		);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AD'.$rw)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$rw, 'JUMLAH')
            ->setCellValue('C'.$rw, '=SUM(C10:C'.($rw-1).')')
            ->setCellValue('D'.$rw, '=SUM(D10:D'.($rw-1).')')
            ->setCellValue('E'.$rw, '=SUM(E10:E'.($rw-1).')')
            ->setCellValue('F'.$rw, '=SUM(F10:F'.($rw-1).')')
            ->setCellValue('G'.$rw, '=SUM(G10:G'.($rw-1).')')
            ->setCellValue('H'.$rw, '=SUM(H10:H'.($rw-1).')')
            ->setCellValue('I'.$rw, '=SUM(I10:I'.($rw-1).')')
            ->setCellValue('J'.$rw, '=SUM(J10:J'.($rw-1).')')
            ->setCellValue('K'.$rw, '=SUM(K10:K'.($rw-1).')')
            ->setCellValue('L'.$rw, '=SUM(L10:L'.($rw-1).')')
            ->setCellValue('M'.$rw, '=SUM(M10:M'.($rw-1).')')
            ->setCellValue('N'.$rw, '=SUM(N10:N'.($rw-1).')')
            ->setCellValue('O'.$rw, '=SUM(O10:O'.($rw-1).')')
            ->setCellValue('P'.$rw, '=SUM(P10:P'.($rw-1).')')
            ->setCellValue('Q'.$rw, '=SUM(Q10:Q'.($rw-1).')')
            ->setCellValue('R'.$rw, '=SUM(R10:R'.($rw-1).')')
            ->setCellValue('S'.$rw, '=SUM(S10:S'.($rw-1).')')
            ->setCellValue('T'.$rw, '=SUM(T10:T'.($rw-1).')')
            ->setCellValue('U'.$rw, '=SUM(U10:U'.($rw-1).')')
            ->setCellValue('V'.$rw, '=SUM(V10:V'.($rw-1).')')
            ->setCellValue('W'.$rw, '=SUM(W10:W'.($rw-1).')')
            ->setCellValue('X'.$rw, '=SUM(X10:X'.($rw-1).')')
            ->setCellValue('Y'.$rw, '=SUM(Y10:Y'.($rw-1).')')
            ->setCellValue('Z'.$rw, '=SUM(Z10:Z'.($rw-1).')')
            ->setCellValue('AA'.$rw, '=SUM(AA10:AA'.($rw-1).')')
            ->setCellValue('AB'.$rw, '=SUM(AB10:AB'.($rw-1).')')
            ->setCellValue('AC'.$rw, '=SUM(AC10:AC'.($rw-1).')')
            ->setCellValue('AD'.$rw, '=SUM(AD10:AD'.($rw-1).')');
			
		$filename='Laporan Imunisasi.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
		}else{
			die('Data tidak ditemukan');
		}	
		
	}
	
		public function lappromkes_temp_excel()
	{	
		//require_once('././sikda_reports/phpjasperxml/class/tcpdf/config/lang/eng.php');
		//require_once('././sikda_reports/phpjasperxml/class/tcpdf/tcpdf.php');	
		
		$from = $this->input->get('from');
		$to = $this->input->get('to');
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?" AND SUBSTRING(KD_PUSKESMAS,2,4) = '".$pid."' ":" AND KD_PUSKESMAS = '".$pid."' ";
		$db = $this->load->database('sikda', TRUE);
		
		//$data['waktu']=$db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KELURAHAN, c.KABUPATEN from t_ds_promkes a LEFT JOIN mst_kelurahan b ON b.KD_KELURAHAN=a.KD_KELURAHAN LEFT JOIN mst_kabupaten c on c.KD_KABUPATEN=a.KD_KABUPATEN where a.BULAN = '$from' and a.TAHUN='$to'")->row();//print_r($data);die;
		$query = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KELURAHAN, c.KABUPATEN from t_ds_promkes a LEFT JOIN mst_kelurahan b ON b.KD_KELURAHAN=a.KD_KELURAHAN LEFT JOIN mst_kabupaten c on c.KD_KABUPATEN=a.KD_KABUPATEN where a.BULAN = '$from' and a.TAHUN='$to'");//print_r($query);die;
		if($query->num_rows>0){
		$data = $query->result(); //print_r($data);die;
		
		if(!$data)
            return false;
				
		//Starting the PHPExcel library
        $this->load->library('Excel');
		$this->excel->getActiveSheet()->setTitle('Laporan Bulanan Promkes');
        $this->excel->getProperties()->setTitle("export")->setDescription("none");
		
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objPHPExcel = $objReader->load("tmp/Laporan_Bulanan_Promkes.xls");
		
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()
			->setCellValue('A1', 'Bulan')
			->setCellValue('C1', ':')
			->setCellValue('A2', 'Tahun')
			->setCellValue('C2', ':')
			->setCellValue('A3', 'Kabupaten/Kota')
			->setCellValue('C3', ':')
            ->setCellValue('D1', $data[0]->bulan)
            ->setCellValue('D2', $data[0]->TAHUN)
            ->setCellValue('D3', $data[0]->KABUPATEN);
			
		
		// Fetching the table data for Promkes
		$rw=9;
		$no=1;
        foreach($data as $value)
        {			
		$styleArray = array(
						'borders' => array(
									 'allborders' => array(
									 'style' => PHPExcel_Style_Border::BORDER_THIN,
									 ),
								),
		);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AL'.$rw)->applyFromArray($styleArray);
		
			$objPHPExcel->getActiveSheet()->setTitle('Laporan Bulanan Promkes')
            ->setCellValue('A'.$rw, $no)
            ->setCellValue('B'.$rw, $value->KELURAHAN)
            ->setCellValue('C'.$rw, $value->JML_P_AKTIF)
            ->setCellValue('D'.$rw, $value->JML_P_PRATAMA)
            ->setCellValue('E'.$rw, $value->JML_P_MADYA)
            ->setCellValue('F'.$rw, $value->JML_P_PURNAMA)
            ->setCellValue('G'.$rw, $value->JML_P_MANDIRI)
            ->setCellValue('H'.$rw, $value->JML_P_LANSIA)
            ->setCellValue('I'.$rw, '=SUM(D'.($rw).':H'.($rw).')')
            ->setCellValue('J'.$rw, $value->JML_LKP_LANSIA)
            ->setCellValue('K'.$rw, $value->JML_KADER_AKTIF)
            ->setCellValue('L'.$rw, $value->JML_PP_DIBINA)
            ->setCellValue('M'.$rw, $value->JML_FPP_PESANTREN)
            ->setCellValue('N'.$rw, $value->JML_SKSB_HUSADA)
            ->setCellValue('O'.$rw, $value->JML_PSB_HUSADA)
            ->setCellValue('P'.$rw, $value->JML_PENYULUHAN_DB)
            ->setCellValue('Q'.$rw, $value->JML_PENYULUHAN_KESLING)
            ->setCellValue('R'.$rw, $value->JML_PENYULUHAN_KIA)
            ->setCellValue('S'.$rw, $value->JML_PENYULUHAN_TBC)
            ->setCellValue('T'.$rw, $value->JML_PENYULUHAN_NAPZA)
            ->setCellValue('U'.$rw, $value->JML_PENYULUHAN_PTM)
            ->setCellValue('V'.$rw, $value->JML_PENYULUHAN_MALARIA)
            ->setCellValue('W'.$rw, $value->JML_PENYULUHAN_DIARE)
            ->setCellValue('X'.$rw, $value->JML_PENYULUHAN_GIZI)
            ->setCellValue('Y'.$rw, $value->JML_PENYULUHAN_PHBS)
            ->setCellValue('Z'.$rw, $value->JML_PD_PSN)
            ->setCellValue('AA'.$rw, $value->JML_RMH_BEBAS_JENTIK)
            ->setCellValue('AB'.$rw, $value->JML_RMH_DIPERIKSA)
            ->setCellValue('AC'.$rw, $value->JML_TTU_BEBAS_JENTIK)
            ->setCellValue('AD'.$rw, $value->JML_TTU_DIPERIKSA)
            ->setCellValue('AE'.$rw, $value->JML_TOGA)
            ->setCellValue('AF'.$rw, $value->JML_P_TOMAGA)
            ->setCellValue('AG'.$rw, $value->JML_P_UKK)
            ->setCellValue('AH'.$rw, $value->JML_PD_SIAGA)
            ->setCellValue('AI'.$rw, $value->JML_RT_PRATAMA)
            ->setCellValue('AJ'.$rw, $value->JML_RT_MADYA)
            ->setCellValue('AK'.$rw, $value->JML_RT_UTAMA)
            ->setCellValue('AL'.$rw, $value->JML_RT_PARIPURNA);
         $rw++;
		$no++;
        } //die('=SUM(C10:C'.$rw.')');
		
		$objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$rw, 'JUMLAH')
            ->setCellValue('C'.$rw, '=SUM(C9:C'.($rw-1).')')
            ->setCellValue('D'.$rw, '=SUM(D9:D'.($rw-1).')')
            ->setCellValue('E'.$rw, '=SUM(E9:E'.($rw-1).')')
            ->setCellValue('F'.$rw, '=SUM(F9:F'.($rw-1).')')
            ->setCellValue('G'.$rw, '=SUM(G9:G'.($rw-1).')')
            ->setCellValue('H'.$rw, '=SUM(H9:H'.($rw-1).')')
            ->setCellValue('I'.$rw, '=SUM(I9:I'.($rw-1).')')
            ->setCellValue('J'.$rw, '=SUM(J9:J'.($rw-1).')')
            ->setCellValue('K'.$rw, '=SUM(K9:K'.($rw-1).')')
            ->setCellValue('L'.$rw, '=SUM(L9:L'.($rw-1).')')
            ->setCellValue('M'.$rw, '=SUM(M9:M'.($rw-1).')')
            ->setCellValue('N'.$rw, '=SUM(N9:N'.($rw-1).')')
            ->setCellValue('O'.$rw, '=SUM(O9:O'.($rw-1).')')
            ->setCellValue('P'.$rw, '=SUM(P9:P'.($rw-1).')')
            ->setCellValue('Q'.$rw, '=SUM(Q9:Q'.($rw-1).')')
            ->setCellValue('R'.$rw, '=SUM(R9:R'.($rw-1).')')
            ->setCellValue('S'.$rw, '=SUM(S9:S'.($rw-1).')')
			->setCellValue('T'.$rw, '=SUM(T9:T'.($rw-1).')')
            ->setCellValue('U'.$rw, '=SUM(U9:U'.($rw-1).')')
            ->setCellValue('V'.$rw, '=SUM(V9:V'.($rw-1).')')
            ->setCellValue('W'.$rw, '=SUM(W9:W'.($rw-1).')')
            ->setCellValue('X'.$rw, '=SUM(X9:X'.($rw-1).')')
            ->setCellValue('Y'.$rw, '=SUM(Y9:Y'.($rw-1).')')
            ->setCellValue('Z'.$rw, '=SUM(Z9:Z'.($rw-1).')')
            ->setCellValue('AA'.$rw, '=SUM(AA9:AA'.($rw-1).')')
            ->setCellValue('AB'.$rw, '=SUM(AB9:AB'.($rw-1).')')
            ->setCellValue('AC'.$rw, '=SUM(AC9:AC'.($rw-1).')')
            ->setCellValue('AD'.$rw, '=SUM(AD9:AD'.($rw-1).')')
            ->setCellValue('AE'.$rw, '=SUM(AE9:AE'.($rw-1).')')
            ->setCellValue('AF'.$rw, '=SUM(AF9:AF'.($rw-1).')')
            ->setCellValue('AG'.$rw, '=SUM(AG9:AG'.($rw-1).')')
            ->setCellValue('AH'.$rw, '=SUM(AH9:AH'.($rw-1).')')
            ->setCellValue('AI'.$rw, '=SUM(AI9:AI'.($rw-1).')')
            ->setCellValue('AJ'.$rw, '=SUM(AJ9:AJ'.($rw-1).')')
            ->setCellValue('AK'.$rw, '=SUM(AK9:AK'.($rw-1).')')
            ->setCellValue('AL'.$rw, '=SUM(AL9:AL'.($rw-1).')');
		
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':B'.$rw);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AL'.$rw)->getFont()->setBold(true);
		$styleArray = array(
						'borders' => array(
									 'allborders' => array(
									 'style' => PHPExcel_Style_Border::BORDER_THIN,
									 ),
								),
		);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AL'.$rw)->applyFromArray($styleArray);	
		
		$filename='Laporan_Bulanan_Promkes.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWriter->save('php://output');
		//header('Content-Type: application/vnd.ms-excel'); //mime type
		//header('Content-Disposition: attachment;filename=report_promkes.xls'); //tell browser what's the file name
		//include 'excel/v_lap_promkes_temp.php';
		
	
		//$db = $this->load->database('sikda', TRUE);
		// $val = $db->query($sql)->result_array();
		// $data ['promkes']=$val;
		// $this->load->view('reports/v_lap_promkes_temp',$data);
		}else{die('No Data Found');}
	}
	
	public function lapukgs_temp_excel()
	{	
		//print_r($_POST);die;
		$from = $this->input->get('from');//print_r($from);die;
		$to = $this->input->get('to');//print_r($to);die;
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?" AND SUBSTRING(a.KD_PUSKESMAS,2,4) = '".$pid."' ":"AND KD_PUSKESMAS = '".$pid."' ";
		$db = $this->load->database('sikda', TRUE);
		
		//$data['waktu']=$db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS from t_ds_ukgs a LEFT JOIN mst_puskesmas c ON c.KD_PUSKESMAS=a.KD_PUSKESMAS LEFT JOIN mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN where a.BULAN = '$from' and a.TAHUN='$to'")->row();//print_r($data);die;
		$query = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS from t_ds_ukgs a LEFT JOIN mst_puskesmas c ON c.KD_PUSKESMAS=a.KD_PUSKESMAS LEFT JOIN mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN where a.BULAN = '$from' and a.TAHUN='$to'");//print_r($data);die;
		if($query->num_rows>0){
		$data = $query->result(); //print_r($data);die;
		
		if(!$data)
            return false;
				
		// Starting the PHPExcel library
        $this->load->library('Excel');
		$this->excel->getActiveSheet()->setTitle('Laporan Bulanan UKGS');
        $this->excel->getProperties()->setTitle("export")->setDescription("none");
		
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objPHPExcel = $objReader->load("tmp/Laporan_Bulanan_UKGS.xls");
		
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()
			->setCellValue('A1', 'Bulan')
			->setCellValue('C1', ':')
			->setCellValue('A2', 'Tahun')
			->setCellValue('C2', ':')
			->setCellValue('A3', 'Kabupaten/Kota')
			->setCellValue('C3', ':')
            ->setCellValue('D1', $data[0]->bulan)
            ->setCellValue('D2', $data[0]->TAHUN)
            ->setCellValue('D3', $data[0]->KABUPATEN);
			
		// Fetching the table data for UKGS
		$rw=10;
		$no=1;
        foreach($data as $value)
        {	

		$styleArray = array(
						'borders' => array(
									 'allborders' => array(
									 'style' => PHPExcel_Style_Border::BORDER_THIN,
									 ),
								),
		);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AC'.$rw)->applyFromArray($styleArray);
		
		
		$EE = $value->JML_PMDGU_L_SD_V_VI_UKGS_III + $value->JML_PMDGU_P_SD_V_VI_UKGS_III;
		$FF = $value->JML_PMDGU_L_SD_V_VI_UKGS_III_PERAWATAN + $value->JML_PMDGU_P_SD_V_VI_UKGS_III_PERAWATAN;
		$GG = $value->JML_PEMERIKSAAN_L_BARU + $value->JML_PEMERIKSAAN_P_BARU;
		$HH = $value->JML_PEMERIKSAAN_L_LAMA + $value->JML_PEMERIKSAAN_P_LAMA;
		$II = $value->JML_DIAGNOSA_L_C_DENTIS + $value->JML_DIAGNOSA_P_C_DENTIS;
		$JJ = $value->JML_DIAGNOSA_L_K_PULPA + $value->JML_DIAGNOSA_P_K_PULPA;
		$KK = $value->JML_DIAGNOSA_L_K_PERIODONTAL + $value->JML_DIAGNOSA_P_K_PERIODONTAL;
		$LL = $value->JML_DIAGNOSA_L_ABSES + $value->JML_DIAGNOSA_P_ABSES;
		$MM = $value->JML_DIAGNOSA_L_PERSISTENSI + $value->JML_DIAGNOSA_P_PERSISTENSI;
		$NN = $value->JML_DIAGNOSA_L_LAINLAIN + $value->JML_DIAGNOSA_P_LAINLAIN;
		
		
		
	  $objPHPExcel->getActiveSheet()->setTitle('Laporan Bulanan UKGS')
		->setCellValue('A'.$rw, $no)
		->setCellValue('B'.$rw, $value->PUSKESMAS)
		->setCellValue('C'.$rw, $value->JML_PMDGU_SD_UKGS_TAHAP_III)
		->setCellValue('D'.$rw, $value->JML_PMDGU_SD_UKGS_INTEGRASI)
		->setCellValue('E'.$rw, $EE)
		->setCellValue('F'.$rw, $FF)
		->setCellValue('G'.$rw, $GG)
		->setCellValue('H'.$rw, $HH)
		->setCellValue('I'.$rw, $II)
		->setCellValue('J'.$rw, $JJ)
		->setCellValue('K'.$rw, $KK)
		->setCellValue('L'.$rw, $LL)
		->setCellValue('M'.$rw, $MM)
		->setCellValue('N'.$rw, $NN)
		->setCellValue('O'.$rw, $value->JML_PERAWATAN_P_TTP_GIGITETAP)
		->setCellValue('P'.$rw, $value->JML_PERAWATAN_P_TTP_GIGISULUNG)
		->setCellValue('Q'.$rw, $value->JML_PERAWATAN_P_T_SEMENTARA)
		->setCellValue('R'.$rw, $value->JML_PERAWATAN_P_P_PULPA)
		->setCellValue('S'.$rw, $value->JML_PERAWATAN_P_P_PERIODENTAL)
		->setCellValue('T'.$rw, $value->JML_PERAWATAN_P_P_ABSES)
		->setCellValue('U'.$rw, $value->JML_PERAWATAN_P_T_SCALLING)
		->setCellValue('V'.$rw, $value->JML_PERAWATAN_P_P_GIGITETAP)
		->setCellValue('W'.$rw, $value->JML_PERAWATAN_P_P_GIGISULUNG)
		->setCellValue('X'.$rw, $value->JML_PERAWATAN_P_LAINLAIN)
		->setCellValue('Y'.$rw, $value->JML_PEMBINAAN_P_PKGM_KELAS)
		->setCellValue('Z'.$rw, $value->JML_PEMBINAAN_P_PKSD_UKGS)
		->setCellValue('AA'.$rw, $value->JML_PEMBINAAN_P_PKD_UKGM)
		->setCellValue('AB'.$rw, $value->JML_PEMBINAAN_P_PYMPGSO_KADER)
		->setCellValue('AC'.$rw, $value->JML_PEMBINAAN_P_PDK_GIGI);
          $rw++;
		$no++;
        } //die('=SUM(C10:C'.$rw.')');
		
		$objPHPExcel->getActiveSheet()
		->setCellValue('A'.$rw, 'JUMLAH')
		->setCellValue('C'.$rw, '=SUM(C10:C'.($rw-1).')')
		->setCellValue('D'.$rw, '=SUM(D10:D'.($rw-1).')')
		->setCellValue('E'.$rw, '=SUM(E10:E'.($rw-1).')')
		->setCellValue('F'.$rw, '=SUM(F10:F'.($rw-1).')')
		->setCellValue('G'.$rw, '=SUM(G10:G'.($rw-1).')')
		->setCellValue('H'.$rw, '=SUM(H10:H'.($rw-1).')')
		->setCellValue('I'.$rw, '=SUM(I10:I'.($rw-1).')')
		->setCellValue('J'.$rw, '=SUM(J10:J'.($rw-1).')')
		->setCellValue('K'.$rw, '=SUM(K10:K'.($rw-1).')')
		->setCellValue('L'.$rw, '=SUM(L10:L'.($rw-1).')')
		->setCellValue('M'.$rw, '=SUM(M10:M'.($rw-1).')')
		->setCellValue('N'.$rw, '=SUM(N10:N'.($rw-1).')')
		->setCellValue('O'.$rw, '=SUM(O10:O'.($rw-1).')')
		->setCellValue('P'.$rw, '=SUM(P10:P'.($rw-1).')')
		->setCellValue('Q'.$rw, '=SUM(Q10:Q'.($rw-1).')')
		->setCellValue('R'.$rw, '=SUM(R10:R'.($rw-1).')')
		->setCellValue('S'.$rw, '=SUM(S10:S'.($rw-1).')')
		->setCellValue('T'.$rw, '=SUM(T10:T'.($rw-1).')')
		->setCellValue('U'.$rw, '=SUM(U10:U'.($rw-1).')')
		->setCellValue('V'.$rw, '=SUM(V10:V'.($rw-1).')')
		->setCellValue('W'.$rw, '=SUM(W10:W'.($rw-1).')')
		->setCellValue('X'.$rw, '=SUM(X10:X'.($rw-1).')')
		->setCellValue('Y'.$rw, '=SUM(Y10:Y'.($rw-1).')')
		->setCellValue('Z'.$rw, '=SUM(Z10:Z'.($rw-1).')')
		->setCellValue('AA'.$rw, '=SUM(AA10:AA'.($rw-1).')')
		->setCellValue('AB'.$rw, '=SUM(AB10:AB'.($rw-1).')')
		->setCellValue('AC'.$rw, '=SUM(AC10:AC'.($rw-1).')');
		
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':B'.$rw);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AC'.$rw)->getFont()->setBold(true);
		$styleArray = array(
						'borders' => array(
									 'allborders' => array(
									 'style' => PHPExcel_Style_Border::BORDER_THIN,
									 ),
								),
		);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AC'.$rw)->applyFromArray($styleArray);	
		
		
		$filename='Laporan_Bulanan_UKGS.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWriter->save('php://output');
		}else{die('No Data Found');}
	}
	
	public function lapkia_temp_excel()
	{	
		//require_once('././sikda_reports/phpjasperxml/class/tcpdf/config/lang/eng.php');
		//require_once('././sikda_reports/phpjasperxml/class/tcpdf/tcpdf.php');	
		
		$from = $this->input->get('from');	//print_r($from);die;
		$to = $this->input->get('to'); //print_r($to);die;
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?"AND SUBSTRING(pl.`KD_PUSKESMAS`,2,4) = '".$pid."' ":"AND pl.`KD_PUSKESMAS` = '".$pid."' ";
		$db = $this->load->database('sikda', TRUE);
		
		//$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_kia a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'")->row();//print_r($data);die;
		$query = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_kia a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'");//print_r($data);die;
		
		$data = $query->result(); //print_r($data);die;
		$bulan = $data[0]->bulan;// print_r($bulan);die;
		$tahun = $data[0]->TAHUN;// print_r($bulan);die;
		$kab = $data[0]->KABUPATEN;// print_r($bulan);die;
		
       if(!$data)
			return false;
 
        // Starting the PHPExcel library
        $this->load->library('Excel');
		$this->excel->getActiveSheet()->setTitle('Laporan Kia');
        $this->excel->getProperties()->setTitle("export")->setDescription("none");
		
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objPHPExcel = $objReader->load("tmp/laporankia.xls");
		
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()
            ->setCellValue('E2', $data[0]->bulan)
            ->setCellValue('E3', $data[0]->TAHUN)
            ->setCellValue('E4', $data[0]->KABUPATEN);
		
		// Fetching the table data for SDMI
		$rw=9;
		$no=1;
        foreach($data as $value)
        {		

			$styleArray = array(
			'borders' => array(
			'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
			),
		);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AA'.$rw)->applyFromArray($styleArray);
		
			$B_N_L_MATI = $value->B_N_L_MATI+$value->B_N_L_MATI_p;
			$B_N_L_HIDUP = $value->B_N_L_HIDUP+$value->B_N_L_HIDUP_p;
			$JML_KJ_N_BR_0_7HARI_KN1 = $value->JML_KJ_N_BR_0_7HARI_KN1+$value->JML_KJ_N_BR_0_7HARI_KN1_p;
			$JML_KJ_N_BR_8_28HARI_KN2 = $value->JML_KJ_N_BR_8_28HARI_KN2+$value->JML_KJ_N_BR_8_28HARI_KN2_p;
			$K_B_N_UMR_8HR_1BL = $value->K_B_N_UMR_8HR_1BL+$value->K_B_N_UMR_8HR_1BL_p;
			$K_B_N_UMR_1BL_1THN = $value->K_B_N_UMR_1BL_1THN+$value->K_B_N_UMR_1BL_1THN_p;
			$K_B_N_UMR_0_7_HARI = $value->K_B_N_UMR_0_7_HARI+$value->K_B_N_UMR_0_7_HARI_p;

		   $objPHPExcel->getActiveSheet()->setTitle('KIA')
            ->setCellValue('A'.$rw, $no)
            ->setCellValue('B'.$rw, $value->PUSKESMAS)
			->setCellValue('C'.$rw, '-')
            ->setCellValue('D'.$rw, '-')
            ->setCellValue('E'.$rw, '-')
            ->setCellValue('F'.$rw, $value->JML_KJ_K1_BUMIL)
            ->setCellValue('G'.$rw, $value->JML_KJ_K4_BUMIL)
            ->setCellValue('H'.$rw, '-')
            ->setCellValue('I'.$rw, '-')
            ->setCellValue('J'.$rw, '-')
            ->setCellValue('K'.$rw, '-')
            ->setCellValue('L'.$rw, '-')
            ->setCellValue('M'.$rw, $value->JML_KJ_BR_R_MASYARAKAT)
            ->setCellValue('N'.$rw, $value->JML_KJ_BR_R_NAKES)
            ->setCellValue('O'.$rw, $value->JML_P_IB_T_DUKUN)
            ->setCellValue('P'.$rw, $value->JML_P_IB_T_KESEHATAN)
            ->setCellValue('Q'.$rw, $JML_KJ_N_BR_0_7HARI_KN1)
            ->setCellValue('R'.$rw, $JML_KJ_N_BR_8_28HARI_KN2)
            ->setCellValue('S'.$rw, $value->JML_K_BR_I_HAMIL)
            ->setCellValue('T'.$rw, $value->JML_K_I_NIFAS)
            ->setCellValue('U'.$rw, $value->JML_K_I_BERSALIN)
            ->setCellValue('V'.$rw, $B_N_L_MATI)
            ->setCellValue('W'.$rw, $B_N_L_HIDUP)
            ->setCellValue('X'.$rw, $K_B_N_UMR_0_7_HARI)
            ->setCellValue('Y'.$rw, $K_B_N_UMR_8HR_1BL)
            ->setCellValue('Z'.$rw, $K_B_N_UMR_1BL_1THN)
			->setCellValue('AA'.$rw, '-');
		$rw++;
		$no++;
        } //die('=SUM(C8:C'.$rw.')');
		
		$objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$rw, 'JUMLAH')
            ->setCellValue('C'.$rw, '=SUM(C9:C'.($rw-1).')')
            ->setCellValue('D'.$rw, '=SUM(D9:D'.($rw-1).')')
            ->setCellValue('E'.$rw, '=SUM(E9:E'.($rw-1).')')
            ->setCellValue('F'.$rw, '=SUM(F9:F'.($rw-1).')')
            ->setCellValue('G'.$rw, '=SUM(G9:G'.($rw-1).')')
            ->setCellValue('H'.$rw, '=SUM(H9:H'.($rw-1).')')
            ->setCellValue('I'.$rw, '=SUM(I9:I'.($rw-1).')')
            ->setCellValue('J'.$rw, '=SUM(J9:J'.($rw-1).')')
            ->setCellValue('K'.$rw, '=SUM(K9:K'.($rw-1).')')
            ->setCellValue('L'.$rw, '=SUM(L9:L'.($rw-1).')')
            ->setCellValue('M'.$rw, '=SUM(M9:M'.($rw-1).')')
            ->setCellValue('N'.$rw, '=SUM(N9:N'.($rw-1).')')
            ->setCellValue('O'.$rw, '=SUM(O9:O'.($rw-1).')')
            ->setCellValue('P'.$rw, '=SUM(P9:P'.($rw-1).')')
            ->setCellValue('Q'.$rw, '=SUM(Q9:Q'.($rw-1).')')
            ->setCellValue('R'.$rw, '=SUM(R9:R'.($rw-1).')')
            ->setCellValue('S'.$rw, '=SUM(S9:S'.($rw-1).')')
            ->setCellValue('T'.$rw, '=SUM(T9:T'.($rw-1).')')
            ->setCellValue('U'.$rw, '=SUM(U9:U'.($rw-1).')')
            ->setCellValue('V'.$rw, '=SUM(V9:V'.($rw-1).')')
            ->setCellValue('W'.$rw, '=SUM(W9:W'.($rw-1).')')
            ->setCellValue('X'.$rw, '=SUM(X9:X'.($rw-1).')')
            ->setCellValue('Y'.$rw, '=SUM(Y9:Y'.($rw-1).')')
            ->setCellValue('Z'.$rw, '=SUM(Z9:Z'.($rw-1).')')
            ->setCellValue('AA'.$rw, '=SUM(AA9:AA'.($rw-1).')');
		
		
		//style
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':B'.$rw);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AA'.$rw)->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('f1f1f1f1');
			
		$styleArray = array(
			'borders' => array(
			'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
			),
		);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AA'.$rw)->applyFromArray($styleArray);
		
		$objPHPExcel->setActiveSheetIndex(1);
		$objPHPExcel->getActiveSheet()
            ->setCellValue('E2', $data[0]->bulan)
            ->setCellValue('E3', $data[0]->TAHUN)
            ->setCellValue('E4', $data[0]->KABUPATEN);
		
		
		 // Fetching the table data for SLTP
		$rw=8;
		$no=1;
        foreach($data as $value)
        {			
			
			//border
			$styleArray = array(
			'borders' => array(
			'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					),
				),
			);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':S'.$rw)->applyFromArray($styleArray);
			
			$B_N_D_BBL_2500_3000GR = $value->B_N_D_BBL_2500_3000GR+$value->B_N_D_BBL_2500_3000GR_p;
			$JML_B_N_D_BBL_L_3000GR = $value->JML_B_N_D_BBL_L_3000GR+$value->JML_B_N_D_BBL_L_3000GR_p;
			$JML_B_N_BBL_K_2500GR = $value->JML_B_N_BBL_K_2500GR+$value->JML_B_N_BBL_K_2500GR_p;
			$JML_BBLR_N_D_T_KESEHATAN = $value->JML_BBLR_N_D_T_KESEHATAN+$value->JML_BBLR_N_D_T_KESEHATAN_p;
			$N_RESTI = $value->N_RESTI+$value->N_RESTI_p;
			$N_R_DRJ_PUSKESMAS = $value->N_R_DRJ_PUSKESMAS+$value->N_R_DRJ_PUSKESMAS_p;
			$N_R_DRJ_RS = $value->N_R_DRJ_RS+$value->N_R_DRJ_RS_p;
			$B_N_YG_DTK_TBH_KEMBANGNYA = $value->B_N_YG_DTK_TBH_KEMBANGNYA+$value->B_N_YG_DTK_TBH_KEMBANGNYA_p;
			$A_N_D_KLN_TBH_KEMBANG = $value->A_N_D_KLN_TBH_KEMBANG+$value->A_N_D_KLN_TBH_KEMBANG_p;
			$JML_KJ_TK_ADA = $value->JML_KJ_TK_ADA+$value->JML_KJ_TK_ADA_p;
			$JML_KJ_TK_DIKUNJUNGI = $value->JML_KJ_TK_DIKUNJUNGI+$value->JML_KJ_TK_DIKUNJUNGI_p;
			
            $objPHPExcel->getActiveSheet()->setTitle('KIA 2')
            ->setCellValue('A'.$rw, $no)
            ->setCellValue('B'.$rw, $value->PUSKESMAS)
            ->setCellValue('C'.$rw, $B_N_D_BBL_2500_3000GR)
            ->setCellValue('D'.$rw, $JML_B_N_D_BBL_L_3000GR)
            ->setCellValue('E'.$rw, $JML_B_N_BBL_K_2500GR)
            ->setCellValue('F'.$rw, $JML_BBLR_N_D_T_KESEHATAN)
            ->setCellValue('G'.$rw, $value->JML_I_B_DRJ_PUSKESMAS)
            ->setCellValue('H'.$rw, $value->JML_I_B_DRJ_RUMAH_SAKIT)
            ->setCellValue('I'.$rw, $N_RESTI)
            ->setCellValue('J'.$rw, $N_R_DRJ_PUSKESMAS)
            ->setCellValue('K'.$rw, $N_R_DRJ_RS)
            ->setCellValue('L'.$rw, $B_N_YG_DTK_TBH_KEMBANGNYA)
            ->setCellValue('M'.$rw, $A_N_D_KLN_TBH_KEMBANG)
            ->setCellValue('N'.$rw, $JML_KJ_TK_ADA)
            ->setCellValue('O'.$rw, $JML_KJ_TK_DIKUNJUNGI)
            ->setCellValue('P'.$rw, $value->M_KJ_TK_DIPERIKSA)
            ->setCellValue('Q'.$rw, $value->M_KJ_TK_DIRUJUK)
            ->setCellValue('R'.$rw, $value->JML_B_R_R_YD_PUSKESMAS)
            ->setCellValue('S'.$rw, $value->JML_B_R_R_YD_RUMAH_SAKIT);

		$rw++;
		$no++;
        } //die('=SUM(C8:C'.$rw.')');
		
		$objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$rw, 'JUMLAH')
            ->setCellValue('C'.$rw, '=SUM(C8:C'.($rw-1).')')
            ->setCellValue('D'.$rw, '=SUM(D8:D'.($rw-1).')')
            ->setCellValue('E'.$rw, '=SUM(E8:E'.($rw-1).')')
            ->setCellValue('F'.$rw, '=SUM(F8:F'.($rw-1).')')
            ->setCellValue('G'.$rw, '=SUM(G8:G'.($rw-1).')')
            ->setCellValue('H'.$rw, '=SUM(H8:H'.($rw-1).')')
            ->setCellValue('I'.$rw, '=SUM(I8:I'.($rw-1).')')
            ->setCellValue('J'.$rw, '=SUM(J8:J'.($rw-1).')')
            ->setCellValue('K'.$rw, '=SUM(K8:K'.($rw-1).')')
            ->setCellValue('L'.$rw, '=SUM(L8:L'.($rw-1).')')
            ->setCellValue('M'.$rw, '=SUM(M8:M'.($rw-1).')')
            ->setCellValue('N'.$rw, '=SUM(N8:N'.($rw-1).')')
            ->setCellValue('O'.$rw, '=SUM(O8:O'.($rw-1).')')
            ->setCellValue('P'.$rw, '=SUM(P8:P'.($rw-1).')')
            ->setCellValue('Q'.$rw, '=SUM(Q8:Q'.($rw-1).')')
            ->setCellValue('R'.$rw, '=SUM(R8:R'.($rw-1).')')
            ->setCellValue('S'.$rw, '=SUM(S8:S'.($rw-1).')');
          
		//style
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':B'.$rw);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':S'.$rw)->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('f1f1f1f1');
			
		$styleArray = array(
			'borders' => array(
			'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
			),
		);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':S'.$rw)->applyFromArray($styleArray);
		//end style
		
        $filename='laporan_kia.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
		
	}
	
	public function lapkesling_temp_excel()
	{	
		//require_once('././sikda_reports/phpjasperxml/class/tcpdf/config/lang/eng.php');
		//require_once('././sikda_reports/phpjasperxml/class/tcpdf/tcpdf.php');	
		
		$from = $this->input->get('from');	//print_r($from);die;
		$to = $this->input->get('to'); //print_r($to);die;
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?"AND SUBSTRING(pl.`KD_PUSKESMAS`,2,4) = '".$pid."' ":"AND pl.`KD_PUSKESMAS` = '".$pid."' ";
		$db = $this->load->database('sikda', TRUE);
		
		//$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_kesling a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'")->row();//print_r($data);die;
		$query = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_kesling a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'");//print_r($data);die;
		
		$data = $query->result(); //print_r($data);die;
		$bulan = $data[0]->bulan;// print_r($bulan);die;
		$tahun = $data[0]->TAHUN;// print_r($bulan);die;
		$kab = $data[0]->KABUPATEN;// print_r($bulan);die;
		
       if(!$data)
			return false;
		
		
 
        // Starting the PHPExcel library
        $this->load->library('Excel');
		$this->excel->getActiveSheet()->setTitle('Laporan Kesling');
        $this->excel->getProperties()->setTitle("export")->setDescription("none");
		
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objPHPExcel = $objReader->load("tmp/laporankesling.xls");

		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()
            ->setCellValue('E2', $data[0]->bulan)
            ->setCellValue('E3', $data[0]->TAHUN)
            ->setCellValue('E4', $data[0]->KABUPATEN);
		
		
		$rw=10;
		$no=1;
        foreach($data as $value)
        {		

				//border
			$styleArray = array(
			'borders' => array(
			'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					),
				),
			);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':L'.$rw)->applyFromArray($styleArray);	
				
		   $objPHPExcel->getActiveSheet()->setTitle('PKL')
            ->setCellValue('A'.$rw, $no)
            ->setCellValue('B'.$rw, $value->PUSKESMAS)
			->setCellValue('C'.$rw, $value->SD_MI)
            ->setCellValue('D'.$rw, $value->SD_MI_MS)
            ->setCellValue('E'.$rw, $value->SLTP_MTS)
            ->setCellValue('F'.$rw, $value->SLTP_MTS_MS)
            ->setCellValue('G'.$rw, $value->SLTA_MA)
            ->setCellValue('H'.$rw, $value->SLTA_MA_MS)
            ->setCellValue('I'.$rw, $value->PERGURUAN_TINGGI)
            ->setCellValue('J'.$rw, $value->PERGURUAN_TINGGI_MS)
            ->setCellValue('K'.$rw, $value->KIOS_KUD)
            ->setCellValue('L'.$rw, $value->KIOS_KUD_MS);

		$rw++;
		$no++;
        } //die('=SUM(C8:C'.$rw.')');
		
		
		
		$objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$rw, 'JUMLAH')
            ->setCellValue('C'.$rw, '=SUM(C10:C'.($rw-1).')')
            ->setCellValue('D'.$rw, '=SUM(D10:D'.($rw-1).')')
            ->setCellValue('E'.$rw, '=SUM(E10:E'.($rw-1).')')
            ->setCellValue('F'.$rw, '=SUM(F10:F'.($rw-1).')')
            ->setCellValue('G'.$rw, '=SUM(G10:G'.($rw-1).')')
            ->setCellValue('H'.$rw, '=SUM(H10:H'.($rw-1).')')
            ->setCellValue('I'.$rw, '=SUM(I10:I'.($rw-1).')')
            ->setCellValue('J'.$rw, '=SUM(J10:J'.($rw-1).')')
            ->setCellValue('K'.$rw, '=SUM(K10:K'.($rw-1).')')
            ->setCellValue('L'.$rw, '=SUM(L10:L'.($rw-1).')');
            
		
		//style
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':B'.$rw);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':L'.$rw)->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('f1f1f1f1');
			
		$styleArray = array(
			'borders' => array(
			'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
			),
		);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':L'.$rw)->applyFromArray($styleArray);
		//end style
		
		$objPHPExcel->setActiveSheetIndex(1);
		$objPHPExcel->getActiveSheet()
            ->setCellValue('E2', $data[0]->bulan)
            ->setCellValue('E3', $data[0]->TAHUN)
            ->setCellValue('E4', $data[0]->KABUPATEN);
			
		$rw=10;
		$no=1;
        foreach($data as $value)
        {			

					//border
			$styleArray = array(
			'borders' => array(
			'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					),
				),
			);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':L'.$rw)->applyFromArray($styleArray);
		
		   $objPHPExcel->getActiveSheet()->setTitle('TEMPAT UMUM')
            ->setCellValue('A'.$rw, $no)
            ->setCellValue('B'.$rw, $value->PUSKESMAS)
			->setCellValue('C'.$rw, $value->HOTEL_MELATI_LOSMEN)
            ->setCellValue('D'.$rw, $value->HOTEL_MELATI_LOSMEN_MS)
            ->setCellValue('E'.$rw, $value->SALON_KECNTIKAN_P_RAMBUT)
            ->setCellValue('F'.$rw, $value->SALON_KECNTIKAN_P_RAMBUT_MS)
            ->setCellValue('G'.$rw, $value->TEMPAT_REKREASI)
            ->setCellValue('H'.$rw, $value->TEMPAT_REKREASI_MS)
            ->setCellValue('I'.$rw, $value->GD_PERTEMUAN_GD_PERTUNJUKAN)
            ->setCellValue('J'.$rw, $value->GD_PERTEMUAN_GD_PERTUNJUKAN_MS)
            ->setCellValue('K'.$rw, $value->KOLAM_RENANG)
            ->setCellValue('L'.$rw, $value->KOLAM_RENANG_MS);

		$rw++;
		$no++;
        } //die('=SUM(C8:C'.$rw.')');
			
			
		
			
		$objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$rw, 'JUMLAH')
            ->setCellValue('C'.$rw, '=SUM(C10:C'.($rw-1).')')
            ->setCellValue('D'.$rw, '=SUM(D10:D'.($rw-1).')')
            ->setCellValue('E'.$rw, '=SUM(E10:E'.($rw-1).')')
            ->setCellValue('F'.$rw, '=SUM(F10:F'.($rw-1).')')
            ->setCellValue('G'.$rw, '=SUM(G10:G'.($rw-1).')')
            ->setCellValue('H'.$rw, '=SUM(H10:H'.($rw-1).')')
            ->setCellValue('I'.$rw, '=SUM(I10:I'.($rw-1).')')
            ->setCellValue('J'.$rw, '=SUM(J10:J'.($rw-1).')')
            ->setCellValue('K'.$rw, '=SUM(K10:K'.($rw-1).')')
            ->setCellValue('L'.$rw, '=SUM(L10:L'.($rw-1).')');	
		
		
			//style
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':B'.$rw);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':L'.$rw)->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('f1f1f1f1');
			
		$styleArray = array(
			'borders' => array(
			'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
			),
		);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':L'.$rw)->applyFromArray($styleArray);
		//end style
		
		$objPHPExcel->setActiveSheetIndex(2);
		$objPHPExcel->getActiveSheet()
            ->setCellValue('E2', $data[0]->bulan)
            ->setCellValue('E3', $data[0]->TAHUN)
            ->setCellValue('E4', $data[0]->KABUPATEN);
		
		$rw=10;
		$no=1;
        foreach($data as $value)
        {			

					//border
			$styleArray = array(
			'borders' => array(
			'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					),
				),
			);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':R'.$rw)->applyFromArray($styleArray);
		
		   $objPHPExcel->getActiveSheet()->setTitle('TEMPAT IBADAH')
            ->setCellValue('A'.$rw, $no)
            ->setCellValue('B'.$rw, $value->PUSKESMAS)
			->setCellValue('C'.$rw, $value->MASJID_MUSHOLA)
            ->setCellValue('D'.$rw, $value->MASJID_MUSHOLA_MS)
            ->setCellValue('E'.$rw, $value->GEREJA)
            ->setCellValue('F'.$rw, $value->GEREJA_MS)
            ->setCellValue('G'.$rw, $value->KELENTENG)
            ->setCellValue('H'.$rw, $value->KELENTENG_MS)
            ->setCellValue('I'.$rw, $value->PURA)
            ->setCellValue('J'.$rw, $value->PURA_MS)
            ->setCellValue('K'.$rw, $value->WIHARA)
            ->setCellValue('L'.$rw, $value->WIHARA_MS)
            ->setCellValue('M'.$rw, $value->STASIUN)
            ->setCellValue('N'.$rw, $value->STASIUN_MS)
            ->setCellValue('O'.$rw, $value->TERMINAL)
            ->setCellValue('P'.$rw, $value->TERMINAL_MS)
            ->setCellValue('Q'.$rw, $value->PELABUHAN_LAUT)
            ->setCellValue('R'.$rw, $value->PELABUHAN_LAUT_MS);

		$rw++;
		$no++;
        } //die('=SUM(C8:C'.$rw.')');
		
		
		
		
		$objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$rw, 'JUMLAH')
            ->setCellValue('C'.$rw, '=SUM(C10:C'.($rw-1).')')
            ->setCellValue('D'.$rw, '=SUM(D10:D'.($rw-1).')')
            ->setCellValue('E'.$rw, '=SUM(E10:E'.($rw-1).')')
            ->setCellValue('F'.$rw, '=SUM(F10:F'.($rw-1).')')
            ->setCellValue('G'.$rw, '=SUM(G10:G'.($rw-1).')')
            ->setCellValue('H'.$rw, '=SUM(H10:H'.($rw-1).')')
            ->setCellValue('I'.$rw, '=SUM(I10:I'.($rw-1).')')
            ->setCellValue('J'.$rw, '=SUM(J10:J'.($rw-1).')')
            ->setCellValue('K'.$rw, '=SUM(K10:K'.($rw-1).')')
            ->setCellValue('L'.$rw, '=SUM(L10:L'.($rw-1).')')
            ->setCellValue('M'.$rw, '=SUM(M10:M'.($rw-1).')')
            ->setCellValue('N'.$rw, '=SUM(N10:N'.($rw-1).')')
            ->setCellValue('O'.$rw, '=SUM(O10:O'.($rw-1).')')
            ->setCellValue('P'.$rw, '=SUM(P10:P'.($rw-1).')')
            ->setCellValue('Q'.$rw, '=SUM(Q10:Q'.($rw-1).')')
            ->setCellValue('R'.$rw, '=SUM(R10:R'.($rw-1).')');
			
			
				//style
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':B'.$rw);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':R'.$rw)->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('f1f1f1f1');
			
		$styleArray = array(
			'borders' => array(
			'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
			),
		);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':R'.$rw)->applyFromArray($styleArray);
		//end style
			
		$objPHPExcel->setActiveSheetIndex(3);
		$objPHPExcel->getActiveSheet()
            ->setCellValue('E2', $data[0]->bulan)
            ->setCellValue('E3', $data[0]->TAHUN)
            ->setCellValue('E4', $data[0]->KABUPATEN);
		
		$rw=10;
		$no=1;
        foreach($data as $value)
        {				

					//border
			$styleArray = array(
			'borders' => array(
			'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					),
				),
			);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':N'.$rw)->applyFromArray($styleArray);
		
		   $objPHPExcel->getActiveSheet()->setTitle('SARANA EKONOMI')
            ->setCellValue('A'.$rw, $no)
            ->setCellValue('B'.$rw, $value->PUSKESMAS)
			->setCellValue('C'.$rw, $value->PASAR)
            ->setCellValue('D'.$rw, $value->PASAR_MS)
            ->setCellValue('E'.$rw, $value->APOTIK)
            ->setCellValue('F'.$rw, $value->APOTIK_MS)
            ->setCellValue('G'.$rw, $value->TOKO_OBAT)
            ->setCellValue('H'.$rw, $value->TOKO_OBAT_MS)
            ->setCellValue('I'.$rw, $value->SARANA_PANTI_SOSIAL)
            ->setCellValue('J'.$rw, $value->SARANA_PANTI_SOSIAL_MS)
            ->setCellValue('K'.$rw, $value->SARANA_KESEHATAN)
            ->setCellValue('L'.$rw, $value->SARANA_KESEHATAN_MS)
            ->setCellValue('M'.$rw, $value->PONDOK_PESANTREN)
            ->setCellValue('N'.$rw, $value->PONDOK_PESANTREN_MS);

		$rw++;
		$no++;
        } //die('=SUM(C8:C'.$rw.')');
		
			
		
		$objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$rw, 'JUMLAH')
            ->setCellValue('C'.$rw, '=SUM(C10:C'.($rw-1).')')
            ->setCellValue('D'.$rw, '=SUM(D10:D'.($rw-1).')')
            ->setCellValue('E'.$rw, '=SUM(E10:E'.($rw-1).')')
            ->setCellValue('F'.$rw, '=SUM(F10:F'.($rw-1).')')
            ->setCellValue('G'.$rw, '=SUM(G10:G'.($rw-1).')')
            ->setCellValue('H'.$rw, '=SUM(H10:H'.($rw-1).')')
            ->setCellValue('I'.$rw, '=SUM(I10:I'.($rw-1).')')
            ->setCellValue('J'.$rw, '=SUM(J10:J'.($rw-1).')')
            ->setCellValue('K'.$rw, '=SUM(K10:K'.($rw-1).')')
            ->setCellValue('L'.$rw, '=SUM(L10:L'.($rw-1).')')
            ->setCellValue('M'.$rw, '=SUM(M10:M'.($rw-1).')')
            ->setCellValue('N'.$rw, '=SUM(N10:N'.($rw-1).')');
           
		   //style
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':B'.$rw);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':N'.$rw)->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('f1f1f1f1');
			
		$styleArray = array(
			'borders' => array(
			'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
			),
		);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':N'.$rw)->applyFromArray($styleArray);
		//end style
		   
		$objPHPExcel->setActiveSheetIndex(4);
		$objPHPExcel->getActiveSheet()
            ->setCellValue('E2', $data[0]->bulan)
            ->setCellValue('E3', $data[0]->TAHUN)
            ->setCellValue('E4', $data[0]->KABUPATEN);
		   
		$rw=10;
		$no=1;
        foreach($data as $value)
        {			

			
					//border
			$styleArray = array(
			'borders' => array(
			'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					),
				),
			);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':N'.$rw)->applyFromArray($styleArray);
		
		   $objPHPExcel->getActiveSheet()->setTitle('TMPT PENGOLAHAN MAKANAN')
            ->setCellValue('A'.$rw, $no)
            ->setCellValue('B'.$rw, $value->PUSKESMAS)
			->setCellValue('C'.$rw, $value->WARUNG_MAKAN)
            ->setCellValue('D'.$rw, $value->WARUNG_MAKAN_MS)
            ->setCellValue('E'.$rw, $value->RUMAH_MAKAN)
            ->setCellValue('F'.$rw, $value->RUMAH_MAKAN_MS)
            ->setCellValue('G'.$rw, $value->JASA_BOGA)
            ->setCellValue('H'.$rw, $value->JASA_BOGA_MS)
            ->setCellValue('I'.$rw, $value->INDSTRI_MKNAN_MNMAN)
            ->setCellValue('J'.$rw, $value->INDSTRI_MKNAN_MNMAN_MS)
            ->setCellValue('K'.$rw, $value->INDSTRI_KCL_R_TANGGA)
            ->setCellValue('L'.$rw, $value->INDSTRI_KCL_R_TANGGA_MS)
            ->setCellValue('M'.$rw, $value->INDUSTRI_BESAR)
            ->setCellValue('N'.$rw, $value->INDUSTRI_BESAR_MS);

		$rw++;
		$no++;
        } //die('=SUM(C8:C'.$rw.')');
		   
		   
		   
		   $objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$rw, 'JUMLAH')
            ->setCellValue('C'.$rw, '=SUM(C10:C'.($rw-1).')')
            ->setCellValue('D'.$rw, '=SUM(D10:D'.($rw-1).')')
            ->setCellValue('E'.$rw, '=SUM(E10:E'.($rw-1).')')
            ->setCellValue('F'.$rw, '=SUM(F10:F'.($rw-1).')')
            ->setCellValue('G'.$rw, '=SUM(G10:G'.($rw-1).')')
            ->setCellValue('H'.$rw, '=SUM(H10:H'.($rw-1).')')
            ->setCellValue('I'.$rw, '=SUM(I10:I'.($rw-1).')')
            ->setCellValue('J'.$rw, '=SUM(J10:J'.($rw-1).')')
            ->setCellValue('K'.$rw, '=SUM(K10:K'.($rw-1).')')
            ->setCellValue('L'.$rw, '=SUM(L10:L'.($rw-1).')')
            ->setCellValue('M'.$rw, '=SUM(M10:M'.($rw-1).')')
            ->setCellValue('N'.$rw, '=SUM(N10:N'.($rw-1).')');
		   
		   	//style
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':B'.$rw);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':N'.$rw)->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('f1f1f1f1');
			
		$styleArray = array(
			'borders' => array(
			'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
			),
		);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':N'.$rw)->applyFromArray($styleArray);
		//end style
		   
		$objPHPExcel->setActiveSheetIndex(5);
		$objPHPExcel->getActiveSheet()
            ->setCellValue('E2', $data[0]->bulan)
            ->setCellValue('E3', $data[0]->TAHUN)
            ->setCellValue('E4', $data[0]->KABUPATEN);
		   
		   
		$rw=10;
		$no=1;
        foreach($data as $value)
        {						
		
				//border
			$styleArray = array(
			'borders' => array(
			'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					),
				),
			);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':V'.$rw)->applyFromArray($styleArray);
		
		   $objPHPExcel->getActiveSheet()->setTitle('SAMIJAGA,SPAL & PMBNGAN SAMPAH')
            ->setCellValue('A'.$rw, $no)
            ->setCellValue('B'.$rw, $value->PUSKESMAS)
			->setCellValue('C'.$rw, $value->JML_RUMAH)
            ->setCellValue('D'.$rw, $value->JML_RUMAH_MS)
            ->setCellValue('E'.$rw, $value->SGL)
            ->setCellValue('F'.$rw, $value->SGL_MS)
            ->setCellValue('G'.$rw, $value->SPT)
            ->setCellValue('H'.$rw, $value->SPT_MS)
            ->setCellValue('I'.$rw, $value->SR_PDAM)
            ->setCellValue('J'.$rw, $value->SR_PDAM_MS)
            ->setCellValue('K'.$rw, $value->LAIN_LAIN_SAB)
            ->setCellValue('L'.$rw, $value->LAIN_LAIN_SAB_MS)
            ->setCellValue('M'.$rw, $value->JMBN_UMUM_MCK)
            ->setCellValue('N'.$rw, $value->JMBN_UMUM_MCK_MS)
            ->setCellValue('O'.$rw, $value->JMBN_KELUARGA)
            ->setCellValue('P'.$rw, $value->JMBN_KELUARGA_MS)
            ->setCellValue('Q'.$rw, $value->SPAL)
            ->setCellValue('R'.$rw, $value->SPAL_MS)
            ->setCellValue('S'.$rw, $value->TPS)
            ->setCellValue('T'.$rw, $value->TPS_MS)
            ->setCellValue('U'.$rw, $value->TPA)
            ->setCellValue('V'.$rw, $value->TPA_MS);

		$rw++;
		$no++;
        } //die('=SUM(C8:C'.$rw.')');
		
		  
		
		$objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$rw, 'JUMLAH')
            ->setCellValue('C'.$rw, '=SUM(C10:C'.($rw-1).')')
            ->setCellValue('D'.$rw, '=SUM(D10:D'.($rw-1).')')
            ->setCellValue('E'.$rw, '=SUM(E10:E'.($rw-1).')')
            ->setCellValue('F'.$rw, '=SUM(F10:F'.($rw-1).')')
            ->setCellValue('G'.$rw, '=SUM(G10:G'.($rw-1).')')
            ->setCellValue('H'.$rw, '=SUM(H10:H'.($rw-1).')')
            ->setCellValue('I'.$rw, '=SUM(I10:I'.($rw-1).')')
            ->setCellValue('J'.$rw, '=SUM(J10:J'.($rw-1).')')
            ->setCellValue('K'.$rw, '=SUM(K10:K'.($rw-1).')')
            ->setCellValue('L'.$rw, '=SUM(L10:L'.($rw-1).')')
            ->setCellValue('M'.$rw, '=SUM(M10:M'.($rw-1).')')
            ->setCellValue('N'.$rw, '=SUM(N10:N'.($rw-1).')')
            ->setCellValue('O'.$rw, '=SUM(O10:O'.($rw-1).')')
            ->setCellValue('P'.$rw, '=SUM(P10:P'.($rw-1).')')
            ->setCellValue('Q'.$rw, '=SUM(Q10:Q'.($rw-1).')')
            ->setCellValue('R'.$rw, '=SUM(R10:R'.($rw-1).')')
            ->setCellValue('S'.$rw, '=SUM(S10:S'.($rw-1).')')
            ->setCellValue('T'.$rw, '=SUM(T10:T'.($rw-1).')')
            ->setCellValue('U'.$rw, '=SUM(U10:U'.($rw-1).')')
            ->setCellValue('V'.$rw, '=SUM(V10:V'.($rw-1).')');
		   
		    	//style
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':B'.$rw);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':V'.$rw)->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('f1f1f1f1');
			
		$styleArray = array(
			'borders' => array(
			'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
			),
		);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':V'.$rw)->applyFromArray($styleArray);
		//end style
		   
        $filename='laporan_kesling.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
		
	}
	
	public function lap_kematian_bayi()
	{			
		$this->load->view('reports/lap_kematian_bayi');		
	}
	
	public function lap_kematian_bayi_temp_excel()
	{	
		
		$from = $this->input->get('from');
		$to = $this->input->get('to');
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?"AND SUBSTRING(a.`KD_PUSKESMAS`,2,4) = '".$pid."' ":"AND a.`KD_PUSKESMAS` = '".$pid."' ";
		$db = $this->load->database('sikda', TRUE);
		//$data = array();
		//$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_kematian_anak a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'".$dtsql."")->row();//print_r($data);die;
		//$data['kematianbayi'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_kematian_anak a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'".$dtsql."")->result_array();//print_r($data);die;
		$query= $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_kematian_anak a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'");//print_r($data);die;
		$data = $query->result(); //print_r($data);die;
		$bulan = $data[0]->bulan;// print_r($bulan);die;
		$tahun = $data[0]->TAHUN;// print_r($bulan);die;
		$kab = $data[0]->KABUPATEN;// print_r($bulan);die;
		
        if(!$data)
            return false;
			
		 // Starting the PHPExcel library
        $this->load->library('Excel');
		$this->excel->getActiveSheet()->setTitle('Data Kematian Bayi');
        $this->excel->getProperties()->setTitle("export")->setDescription("none");
		
		$objReader = PHPExcel_IOFactory::createReader('Excel5');  
		$objPHPExcel = $objReader->load("tmp/laporankematianbayi.xls");
		
		//$this->load->library('excel');
		//$this->excel->setActiveSheetIndex(0);
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()
            ->setCellValue('D2', ': '.$data[0]->bulan)
            ->setCellValue('D3', ': '.$data[0]->TAHUN)
            ->setCellValue('D4', ': '.$data[0]->KABUPATEN);
			
			// Fetching the table data for kematian bayi
		$rw=10;
		$no=1;
		$aa='';
		$ab='';
		$ac='';
		$ad='';
        foreach($data as $value)
        {	
			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						
					),
				),
			);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':Z'.$rw)->applyFromArray($styleArray);
			
			$aa = $value->JML_L_U_0_7_HARI + $value->JML_P_U_0_7_HARI ;
			$ab = $value->JML_L_U_8_30_HARI + $value->JML_P_U_8_30_HARI ;
			$ac = $value->JML_L_U_1_12_BULAN + $value->JML_P_U_1_12_BULAN ;
			$ad = $value->JML_L_U_1_5_TAHUN + $value->JML_P_U_1_5_TAHUN ;
			$ae = $value->JML_P_PA_KE_KSD_5 + $value->JML_P_PA_KE_KSD_5_L ;
			$af = $value->JML_P_PA_KE_L_5 + $value->JML_P_PA_KE_L_5_L ;
            $objPHPExcel->getActiveSheet()->setTitle('Kematian Bayi')
            ->setCellValue('A'.$rw, $no)
            ->setCellValue('B'.$rw, $value->PUSKESMAS)
            ->setCellValue('C'.$rw, '=SUM(D'.($rw).':G'.($rw).')')
            ->setCellValue('D'.$rw, $aa)
            ->setCellValue('E'.$rw, $ab)
            ->setCellValue('F'.$rw, $ac)
            ->setCellValue('G'.$rw, $ad)
            ->setCellValue('H'.$rw, $ae)
            ->setCellValue('I'.$rw, $af)
            ->setCellValue('J'.$rw, $value->JML_ANC_KSD_4)
            ->setCellValue('K'.$rw, $value->JML_ANC_L_4)
            ->setCellValue('L'.$rw, $value->JML_SI_BCG)
            ->setCellValue('M'.$rw, $value->JML_SI_DPT)
            ->setCellValue('N'.$rw, $value->JML_SI_POLIO)
            ->setCellValue('O'.$rw, $value->JML_SI_CAMPAK)
            ->setCellValue('P'.$rw, $value->JML_SI_HB)
            ->setCellValue('Q'.$rw, $value->JML_SK_TN)
            ->setCellValue('R'.$rw, $value->JML_SK_BBLR)
            ->setCellValue('S'.$rw, $value->JML_SK_ASFEKSIA)
            ->setCellValue('T'.$rw, $value->JML_SK_LAIN_LAIN)
            ->setCellValue('U'.$rw, $value->JML_TK_RUMAH)
            ->setCellValue('V'.$rw, $value->JML_TK_PUSKESMAS_RB)
            ->setCellValue('W'.$rw, $value->JML_TK_RS)
            ->setCellValue('X'.$rw, $value->JML_TK_PERJALANAN)
            ->setCellValue('Y'.$rw, $value->JML_PP_DUKUN)
            ->setCellValue('Z'.$rw, $value->JML_PP_BIDAN)
			;
		$rw++;
		$no++;
        } //die('=SUM(C10:C'.$rw.')');
		$objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$rw, 'JUMLAH')
            ->setCellValue('C'.$rw, '=SUM(C10:C'.($rw-1).')')
            ->setCellValue('D'.$rw, '=SUM(D10:D'.($rw-1).')')
            ->setCellValue('E'.$rw, '=SUM(E10:E'.($rw-1).')')
            ->setCellValue('F'.$rw, '=SUM(F10:F'.($rw-1).')')
            ->setCellValue('G'.$rw, '=SUM(G10:G'.($rw-1).')')
            ->setCellValue('H'.$rw, '=SUM(H10:H'.($rw-1).')')
            ->setCellValue('I'.$rw, '=SUM(I10:I'.($rw-1).')')
            ->setCellValue('J'.$rw, '=SUM(J10:J'.($rw-1).')')
            ->setCellValue('K'.$rw, '=SUM(K10:K'.($rw-1).')')
            ->setCellValue('L'.$rw, '=SUM(L10:L'.($rw-1).')')
            ->setCellValue('M'.$rw, '=SUM(M10:M'.($rw-1).')')
            ->setCellValue('N'.$rw, '=SUM(N10:N'.($rw-1).')')
            ->setCellValue('O'.$rw, '=SUM(O10:O'.($rw-1).')')
            ->setCellValue('P'.$rw, '=SUM(P10:P'.($rw-1).')')
            ->setCellValue('Q'.$rw, '=SUM(Q10:Q'.($rw-1).')')
            ->setCellValue('R'.$rw, '=SUM(R10:R'.($rw-1).')')
            ->setCellValue('S'.$rw, '=SUM(S10:S'.($rw-1).')')
            ->setCellValue('T'.$rw, '=SUM(T10:T'.($rw-1).')')
            ->setCellValue('U'.$rw, '=SUM(U10:U'.($rw-1).')')
            ->setCellValue('V'.$rw, '=SUM(V10:V'.($rw-1).')')
            ->setCellValue('W'.$rw, '=SUM(W10:W'.($rw-1).')')
            ->setCellValue('X'.$rw, '=SUM(X10:X'.($rw-1).')')
            ->setCellValue('Y'.$rw, '=SUM(Y10:Y'.($rw-1).')')
            ->setCellValue('Z'.$rw, '=SUM(Z10:Z'.($rw-1).')');
			
			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						
					),
				),
			);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':Z'.$rw)->applyFromArray($styleArray);
			
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':Z'.$rw)->getFont()->setBold(true);	
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':B'.$rw);
		$filename='data_kematian_bayi.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');	
		
	}
	public function lap_kematian_ibu_temp_excel()
	{	
		
		$from = $this->input->get('from');
		$to = $this->input->get('to');
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?"AND SUBSTRING(a.`KD_PUSKESMAS`,2,4) = '".$pid."' ":"AND a.`KD_PUSKESMAS` = '".$pid."' ";
		$db = $this->load->database('sikda', TRUE);
		//$data = array();
		//$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_kematian_ibu a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'".$dtsql."")->row();//print_r($data);die;
		//$data['kematianibu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_kematian_ibu a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'".$dtsql."")->result_array();//print_r($data);die;
		$query = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_kematian_ibu a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'");//print_r($data);die;
				//if(!empty($data['waktu'])){
					//$this->load->view('reports/v_lap_kematian_ibu', $data);
				//}else{
					//echo 'Data tidak ditemukan';die;
				//}
				
		$data = $query->result(); //print_r($data);die;
		$bulan = $data[0]->bulan;// print_r($bulan);die;
		$tahun = $data[0]->TAHUN;// print_r($bulan);die;
		$kab = $data[0]->KABUPATEN;// print_r($bulan);die;
		
        if(!$data)
            return false;
			
		 // Starting the PHPExcel library
        $this->load->library('Excel');
		$this->excel->getActiveSheet()->setTitle('Data Kematian Ibu');
        $this->excel->getProperties()->setTitle("export")->setDescription("none");
		
		$objReader = PHPExcel_IOFactory::createReader('Excel5');  
		$objPHPExcel = $objReader->load("tmp/laporankematianibu.xls");
		
		//$this->load->library('excel');
		//$this->excel->setActiveSheetIndex(0);
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()
            ->setCellValue('D2', $data[0]->bulan)
            ->setCellValue('D3', $data[0]->TAHUN)
            ->setCellValue('D4', $data[0]->KABUPATEN);
			
			// Fetching the table data for SDMI
		$rw=11;
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
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AD'.$rw)->applyFromArray($styleArray);

			//$bb = $value->JML_IIYM_UMUR_K_20 + $value->JML_IIYM_UMUR_20_30TH + $value->JML_IIYM_UMUR_L_30TH;
            $objPHPExcel->getActiveSheet()->setTitle('Kematian Ibu')
            ->setCellValue('A'.$rw, $no)
            ->setCellValue('B'.$rw, $value->PUSKESMAS)
            ->setCellValue('C'.$rw, '=SUM(D'.($rw).':F'.($rw).')')
            ->setCellValue('D'.$rw, $value->JML_IIYM_UMUR_K_20)
            ->setCellValue('E'.$rw, $value->JML_IIYM_UMUR_20_30TH)
            ->setCellValue('F'.$rw, $value->JML_IIYM_UMUR_L_30TH)
            ->setCellValue('G'.$rw, $value->JML_P_SD)
            ->setCellValue('H'.$rw, $value->JML_P_SLTP)
            ->setCellValue('I'.$rw, $value->JML_P_SLTA)
            ->setCellValue('J'.$rw, $value->JML_P_PA_KE_K_5)
            ->setCellValue('K'.$rw, $value->JML_P_PA_KE_L_5)
            ->setCellValue('L'.$rw, $value->JML_P_ANC_K_4)
            ->setCellValue('M'.$rw, $value->JML_P_ANC_L_4)
            ->setCellValue('N'.$rw, $value->JML_P_S_IMUNISASI_O)
            ->setCellValue('O'.$rw, $value->JML_P_S_IMUNISASI_TT1)
            ->setCellValue('P'.$rw, $value->JML_P_S_IMUNISASI_TT2)
            ->setCellValue('Q'.$rw, $value->JML_SK_PENDARAHAN)
            ->setCellValue('R'.$rw, $value->JML_SK_EKLAMSI)
            ->setCellValue('S'.$rw, $value->JML_SK_SEPSIS)
            ->setCellValue('T'.$rw, $value->JML_SK_LAIN_LAIN)
            ->setCellValue('U'.$rw, $value->JML_MS_HAMIL)
            ->setCellValue('V'.$rw, $value->JML_MS_NIFAS)
            ->setCellValue('W'.$rw, $value->JML_MS_BERSALIN)
            ->setCellValue('X'.$rw, $value->JML_TK_KI_RUMAH)
            ->setCellValue('Y'.$rw, $value->JML_TK_KI_PUSKESMAS_R_B)
            ->setCellValue('Z'.$rw, $value->JML_TK_KI_RS)
            ->setCellValue('AA'.$rw, $value->JML_TK_KI_PERJALANAN)
            ->setCellValue('AB'.$rw, $value->JML_KI_PP_DUKUN)
            ->setCellValue('AC'.$rw, $value->JML_KI_PP_BIDAN)
            ->setCellValue('AD'.$rw, $value->JML_KI_PP_DR)
			;
		$rw++;
		$no++;
        } //die('=SUM(C10:C'.$rw.')');
		$objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$rw, 'JUMLAH')
            ->setCellValue('C'.$rw, '=SUM(C11:C'.($rw-1).')')
            ->setCellValue('D'.$rw, '=SUM(D11:D'.($rw-1).')')
            ->setCellValue('E'.$rw, '=SUM(E11:E'.($rw-1).')')
            ->setCellValue('F'.$rw, '=SUM(F11:F'.($rw-1).')')
            ->setCellValue('G'.$rw, '=SUM(G11:G'.($rw-1).')')
            ->setCellValue('H'.$rw, '=SUM(H11:H'.($rw-1).')')
            ->setCellValue('I'.$rw, '=SUM(I11:I'.($rw-1).')')
            ->setCellValue('J'.$rw, '=SUM(J11:J'.($rw-1).')')
            ->setCellValue('K'.$rw, '=SUM(K11:K'.($rw-1).')')
            ->setCellValue('L'.$rw, '=SUM(L11:L'.($rw-1).')')
            ->setCellValue('M'.$rw, '=SUM(M11:M'.($rw-1).')')
            ->setCellValue('N'.$rw, '=SUM(N11:N'.($rw-1).')')
            ->setCellValue('O'.$rw, '=SUM(O11:O'.($rw-1).')')
            ->setCellValue('P'.$rw, '=SUM(P11:P'.($rw-1).')')
            ->setCellValue('Q'.$rw, '=SUM(Q11:Q'.($rw-1).')')
            ->setCellValue('R'.$rw, '=SUM(R11:R'.($rw-1).')')
            ->setCellValue('S'.$rw, '=SUM(S11:S'.($rw-1).')')
            ->setCellValue('T'.$rw, '=SUM(T11:T'.($rw-1).')')
            ->setCellValue('U'.$rw, '=SUM(U11:U'.($rw-1).')')
            ->setCellValue('V'.$rw, '=SUM(V11:V'.($rw-1).')')
            ->setCellValue('W'.$rw, '=SUM(W11:W'.($rw-1).')')
            ->setCellValue('X'.$rw, '=SUM(X11:X'.($rw-1).')')
            ->setCellValue('Y'.$rw, '=SUM(Y11:Y'.($rw-1).')')
            ->setCellValue('Z'.$rw, '=SUM(Z11:Z'.($rw-1).')')
            ->setCellValue('AA'.$rw, '=SUM(AA11:AA'.($rw-1).')')
            ->setCellValue('AB'.$rw, '=SUM(AB11:AB'.($rw-1).')')
            ->setCellValue('AC'.$rw, '=SUM(AC11:AC'.($rw-1).')')
            ->setCellValue('AD'.$rw, '=SUM(AD11:AD'.($rw-1).')');
			
			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						
					),
				),
			);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AD'.$rw)->applyFromArray($styleArray);
			
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':AD'.$rw)->getFont()->setBold(true);	
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':B'.$rw);	
		$filename='data_kematian_ibu.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
	}
	
	public function lap_kematian_bayi_temp()
	{	
		
		$from = $this->input->get('from');
		$to = $this->input->get('to');
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?"AND SUBSTRING(a.`KD_PUSKESMAS`,2,4) = '".$pid."' ":"AND a.`KD_PUSKESMAS` = '".$pid."' ";
		$db = $this->load->database('sikda', TRUE);
		$data = array();
		$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_kematian_anak a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'".$dtsql."")->row();//print_r($data);die;
		$data['kematianbayi'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_kematian_anak a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'".$dtsql."")->result_array();//print_r($data);die;
				if(!empty($data['waktu'])){
					$this->load->view('reports/v_lap_kematian_bayi', $data);
				}else{
					echo 'Data tidak ditemukan';die;
				}
	}
	
	public function lap_kematian_ibu()
	{			
		$this->load->view('reports/lap_kematian_ibu');		
	}
	
	public function lap_kematian_ibu_temp()
	{	
		
		$from = $this->input->get('from');
		$to = $this->input->get('to');
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?"AND SUBSTRING(a.`KD_PUSKESMAS`,2,4) = '".$pid."' ":"AND a.`KD_PUSKESMAS` = '".$pid."' ";
		$db = $this->load->database('sikda', TRUE);
		$data = array();
		$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_kematian_ibu a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'".$dtsql."")->row();//print_r($data);die;
		$data['kematianibu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_kematian_ibu a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'".$dtsql."")->result_array();//print_r($data);die;
				if(!empty($data['waktu'])){
					$this->load->view('reports/v_lap_kematian_ibu', $data);
				}else{
					echo 'Data tidak ditemukan';die;
				}
	}
	public function lap_datadasar_temp()
	{	
		$caritahun = $this->input->get('caritahun');
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?"AND pl.KD_KABUPATEN = '".$pid."' ":"AND pl.`KD_PUSKESMAS` = '".$pid."' ";
		$sql = "
		SELECT pl.*,a.KELURAHAN,b.PUSKESMAS,c.KABUPATEN FROM t_ds_datadasar pl left join mst_kabupaten c on c.KD_KABUPATEN=pl.KD_KABUPATEN left join mst_kelurahan a on a.KD_KELURAHAN=pl.KD_KELURAHAN left join mst_puskesmas b on b.KD_PUSKESMAS=pl.KD_PUSKESMAS 
		WHERE pl.TAHUN='".$caritahun."'  
		".$dtsql."
		GROUP BY pl.`KD_PUSKESMAS`
		";
		$db = $this->load->database('sikda', TRUE);
		$val[] = $db->query($sql)->result_array();
		$data['dita'] = $val;
		if(empty($val[0])){echo "Tidak ada data!";echo "<script language='javascript'>
														<!--
														setTimeout('self.close();',1500)
														//-->
														</script> ";die;
		}else{
			$this->load->view('reports/lap_datadasar_table',$data);
		}
	}
	public function lap_datadasar_temp1()
	{	
		$caritahun = $this->input->get('caritahun');
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?"AND pl.KD_KABUPATEN = '".$pid."' ":"AND pl.`KD_PUSKESMAS` = '".$pid."' ";
		$sql = "
		SELECT pl.*,a.KELURAHAN,b.PUSKESMAS,c.KABUPATEN FROM t_ds_datadasar pl left join mst_kabupaten c on c.KD_KABUPATEN=pl.KD_KABUPATEN left join mst_kelurahan a on a.KD_KELURAHAN=pl.KD_KELURAHAN left join mst_puskesmas b on b.KD_PUSKESMAS=pl.KD_PUSKESMAS 
		WHERE pl.TAHUN='".$caritahun."'  
		".$dtsql."
		GROUP BY pl.`KD_PUSKESMAS`
		";
		$db = $this->load->database('sikda', TRUE);
		$val[] = $db->query($sql)->result_array();
		$data['dita'] = $val;
		if(empty($val[0])){echo "Tidak ada data!";echo "<script language='javascript'>
														<!--
														setTimeout('self.close();',1500)
														//-->
														</script> ";die;
		}else{
			$this->load->library('Excel');
			$filename='laporan_datadasar_'.date('dmY').'.xls';
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			$objReader = PHPExcel_IOFactory::createReader('Excel5');
			$objPHPExcel = $objReader->load("tmp/lap_datadasar.xls");
		
		$fields = $db->query($sql)->list_fields();
       
        foreach($db->query($sql)->result() as $data)
        {
			$l_5_14 = $data->JML_L_5_9TH + $data->JML_L_10_14TH;
			$p_5_14 = $data->JML_P_5_9TH + $data->JML_P_10_14TH;
			$l_15_44 = $data->JML_L_15_19TH + $data->JML_L_20_24TH + $data->JML_L_25_29TH + $data->JML_L_30_34TH + $data->JML_L_35_39TH + $data->JML_L_40_44TH;
			$p_15_44 = $data->JML_P_15_19TH + $data->JML_P_20_24TH + $data->JML_P_25_29TH + $data->JML_P_30_34TH + $data->JML_P_35_39TH + $data->JML_P_40_44TH;
			$l_45_64 = $data->JML_L_45_49TH + $data->JML_L_50_54TH + $data->JML_L_55_59TH + $data->JML_L_60_64TH;
			$p_45_64 = $data->JML_P_45_49TH + $data->JML_P_50_54TH + $data->JML_P_55_59TH + $data->JML_P_60_64TH;
			$l_65 = $data->JML_L_65_69TH + $data->JML_L_70_74TH + $data->JML_L_L75TH;
			$p_65 = $data->JML_P_65_69TH + $data->JML_P_70_74TH + $data->JML_P_L75TH;
			$all_l = $l_5_14 + $l_15_44 + $l_45_64 + $l_65 + $data->JML_L_K1TH + $data->JML_L_1_4TH;
			$all_p = $p_5_14 + $p_15_44 + $p_45_64 + $p_65 + $data->JML_P_K1TH + $data->JML_P_1_4TH;
			$sasb = $data->JML_L_SASKIA_BAYI+$data->JML_P_SASKIA_BAYI;
			$sasba = $data->JML_L_SASKIA_BALITA+$data->JML_P_SASKIA_BALITA;
			$sasd = $data->JML_L_SAS_DD_MSD_KELAS1+$data->JML_P_SAS_DD_MSD_KELAS1;
		}	
		$n = 1;
		$row = 9;
        foreach($db->query($sql)->result() as $data)
        {
            $objPHPExcel->setActiveSheetIndex(2);
			$objPHPExcel->getActiveSheet()
				->setTitle('Data Dasar Sasaran Program')
				->setCellValue('A1', 'DATA DASAR SASARAN PROGRAM')
				->setCellValue('A3', 'TAHUN : '.$data->TAHUN)
				->setCellValue('A4', 'DINAS KESEHATAN KAB/KOTA '.$data->KABUPATEN);
			$col = 1;
            foreach ($fields as $field)
            {
                $objPHPExcel->getActiveSheet()->getStyle("A".$row.":K".$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle("A".$row.":K".$row)->applyFromArray(array(
					'borders' => array(
					'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
					)
					)
					));
				$objPHPExcel->getActiveSheet()
					->setCellValue('A'.$row, $n)
					->setCellValue('B'.$row, $data->PUSKESMAS)
					->setCellValue('C'.$row, $data->JML_SAB_RUMAH)
					->setCellValue('D'.$row, $data->JML_SAB_SGL)
					->setCellValue('E'.$row, $data->JML_SAB_SPT)
					->setCellValue('F'.$row, $data->JML_SAB_SR_PDAM)
					->setCellValue('G'.$row, $data->JML_SAB_LAINLAIN)
					->setCellValue('H'.$row, $data->JML_SAB_SPAL)
					->setCellValue('I'.$row, $data->JML_SAB_J_KELUARGA)
					->setCellValue('J'.$row, $data->JML_SAB_TPA)
					->setCellValue('K'.$row, $data->JML_SAB_TPS);
                $col++;
            }
			$n++;
            $row++;
        }
		$row_=$row-1;
		$objPHPExcel->getActiveSheet()->mergeCells("A".$row.":B".$row);
		$objPHPExcel->getActiveSheet()->getStyle("A".$row.":K".$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("A".$row.":K".$row)->applyFromArray(array(
			'borders' => array(
			'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
			)
			)
			));
		$objPHPExcel->getActiveSheet()->getStyle("A".$row.":K".$row)->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('F1F1F1F1');
		$objPHPExcel->getActiveSheet()
					->setCellValue('A'.$row, 'JUMLAH')
					->setCellValue('C'.$row, "=SUM(C9:C".$row_.")")
					->setCellValue('D'.$row, "=SUM(D9:D".$row_.")")
					->setCellValue('E'.$row, "=SUM(E9:E".$row_.")")
					->setCellValue('F'.$row, "=SUM(F9:F".$row_.")")
					->setCellValue('G'.$row, "=SUM(G9:G".$row_.")")
					->setCellValue('H'.$row, "=SUM(H9:H".$row_.")")
					->setCellValue('I'.$row, "=SUM(I9:I".$row_.")")
					->setCellValue('J'.$row, "=SUM(J9:J".$row_.")")
					->setCellValue('K'.$row, "=SUM(K9:K".$row_.")");
		$n = 1;
		$row1 = 9;
        foreach($db->query($sql)->result() as $data)
        {
			$objPHPExcel->setActiveSheetIndex(1);
			$objPHPExcel->getActiveSheet()
				->setTitle('Data Dasar Sarana Prasarana')
				->setCellValue('A1', 'DATA DASAR SARANA PRASARANA')
				->setCellValue('A3', 'TAHUN : '.$data->TAHUN)
				->setCellValue('A4', 'DINAS KESEHATAN KAB/KOTA '.$data->KABUPATEN);
			$col1 = 1;
            foreach ($fields as $field)
            {
                $objPHPExcel->getActiveSheet()->getStyle("A".$row1.":AB".$row1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle("A".$row1.":AB".$row1)->applyFromArray(array(
					'borders' => array(
					'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
					)
					)
					));
				$objPHPExcel->getActiveSheet()
					->setCellValue('A'.$row1, $n)
					->setCellValue('B'.$row1, $data->PUSKESMAS)
					->setCellValue('C'.$row1, $data->JML_SASKIA_PUS)
					->setCellValue('D'.$row1, $data->JML_SASKIA_WUS)
					->setCellValue('E'.$row1, $sasb)
					->setCellValue('F'.$row1, $sasba)
					->setCellValue('G'.$row1, $data->JML_SASKIA_BUMIL)
					->setCellValue('H'.$row1, $data->JML_SASKIA_BULIN)
					->setCellValue('I'.$row1, $data->JML_SASKIA_BUFAS)
					->setCellValue('J'.$row1, $data->JML_GA_GAKIN)
					->setCellValue('K'.$row1, $data->JML_SASKIA_K1)
					->setCellValue('L'.$row1, $data->JML_SASKIA_K4)
					->setCellValue('M'.$row1, $data->JML_SASKIA_KN1)
					->setCellValue('N'.$row1, $data->JML_SASKIA_KN2)
					->setCellValue('O'.$row1, $data->JML_SASKIA_P_NAKES)
					->setCellValue('P'.$row1, $data->JML_SASKIA_P_NON_NAKES)
					->setCellValue('Q'.$row1, $data->JML_SASKIA_RES_NAKES)
					->setCellValue('R'.$row1, $data->JML_SASKIA_RES_MASYARAKAT)
					->setCellValue('S'.$row1, $data->JML_SASKIA_PMPB)
					->setCellValue('T'.$row1, '0')
					->setCellValue('U'.$row1, '0')
					->setCellValue('V'.$row1, '0')
					->setCellValue('W'.$row1, '0')
					->setCellValue('X'.$row1, '0')
					->setCellValue('Y'.$row1, $data->JML_SASKIA_POSYANDU)
					->setCellValue('Z'.$row1, $data->JML_SASKIA_M_TK)
					->setCellValue('AA'.$row1, $data->JML_SASKIA_KADER)
					->setCellValue('AB'.$row1, $sasd);
                $col1++;
            }
			$n++;
            $row1++;
        }
		$row1_=$row1-1;
		$objPHPExcel->getActiveSheet()->mergeCells("A".$row1.":B".$row1);
		$objPHPExcel->getActiveSheet()->getStyle("A".$row1.":AB".$row1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("A".$row1.":AB".$row1)->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('F1F1F1F1');
		$objPHPExcel->getActiveSheet()->getStyle("A".$row1.":AB".$row1)->applyFromArray(array(
			'borders' => array(
			'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
			)
			)
			));
		$objPHPExcel->getActiveSheet()
					->setCellValue('A'.$row1, 'JUMLAH')
					->setCellValue('C'.$row1, "=SUM(C9:C".$row1_.")")
					->setCellValue('D'.$row1, "=SUM(D9:D".$row1_.")")
					->setCellValue('E'.$row1, "=SUM(E9:E".$row1_.")")
					->setCellValue('F'.$row1, "=SUM(F9:F".$row1_.")")
					->setCellValue('G'.$row1, "=SUM(G9:G".$row1_.")")
					->setCellValue('H'.$row1, "=SUM(H9:H".$row1_.")")
					->setCellValue('I'.$row1, "=SUM(I9:I".$row1_.")")
					->setCellValue('J'.$row1, "=SUM(J9:J".$row1_.")")
					->setCellValue('K'.$row1, "=SUM(K9:K".$row1_.")")
					->setCellValue('L'.$row1, "=SUM(L9:L".$row1_.")")
					->setCellValue('M'.$row1, "=SUM(M9:M".$row1_.")")
					->setCellValue('N'.$row1, "=SUM(N9:N".$row1_.")")
					->setCellValue('O'.$row1, "=SUM(O9:O".$row1_.")")
					->setCellValue('P'.$row1, "=SUM(P9:P".$row1_.")")
					->setCellValue('Q'.$row1, "=SUM(Q9:Q".$row1_.")")
					->setCellValue('R'.$row1, "=SUM(R9:R".$row1_.")")
					->setCellValue('S'.$row1, "=SUM(S9:S".$row1_.")")
					->setCellValue('T'.$row1, '0')
					->setCellValue('U'.$row1, '0')
					->setCellValue('V'.$row1, '0')
					->setCellValue('W'.$row1, '0')
					->setCellValue('X'.$row1, '0')
					->setCellValue('Y'.$row1, "=SUM(Y9:Y".$row1_.")")
					->setCellValue('Z'.$row1, "=SUM(Z9:Z".$row1_.")")
					->setCellValue('AA'.$row1, "=SUM(AA9:AA".$row1_.")")
					->setCellValue('AB'.$row1, "=SUM(AB9:AB".$row1_.")");
		$n = 1;
		$row2 = 9;
        foreach($db->query($sql)->result() as $data)
        {
            $objPHPExcel->setActiveSheetIndex(3);
			$objPHPExcel->getActiveSheet()
				->setTitle('Data Dasar Tempat Umum')
				->setCellValue('A1', 'DATA DASAR TEMPAT UMUM')
				->setCellValue('A3', 'TAHUN : '.$data->TAHUN)
				->setCellValue('A4', 'DINAS KESEHATAN KAB/KOTA '.$data->KABUPATEN);
			$col2 = 1;
            foreach ($fields as $field)
            {
                $objPHPExcel->getActiveSheet()->getStyle("A".$row2.":AI".$row2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle("A".$row2.":AI".$row2)->applyFromArray(array(
					'borders' => array(
					'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
					)
					)
					));
				$objPHPExcel->getActiveSheet()
					->setCellValue('A'.$row2, $n)
					->setCellValue('B'.$row2, $data->PUSKESMAS)
					->setCellValue('C'.$row2, $data->JML_TTU_TK)
					->setCellValue('D'.$row2, $data->JML_TTU_SD)
					->setCellValue('E'.$row2, $data->JML_TTU_MI)
					->setCellValue('F'.$row2, $data->JML_TTU_SLTP)
					->setCellValue('G'.$row2, $data->JML_TTU_MTS)
					->setCellValue('H'.$row2, $data->JML_TTU_SLTA)
					->setCellValue('I'.$row2, $data->JML_TTU_MA)
					->setCellValue('J'.$row2, $data->JML_TTU_P_TINGGI)
					->setCellValue('K'.$row2, $data->JML_TTU_KIOS)
					->setCellValue('L'.$row2, $data->JML_TTU_H_M_LOSMEN)
					->setCellValue('M'.$row2, $data->JML_TTU_SK_P_RAMBUT)
					->setCellValue('N'.$row2, $data->JML_TTU_T_REKREASI)
					->setCellValue('O'.$row2, $data->JML_TTU_GP_G_PERTUNJUKAN)
					->setCellValue('P'.$row2, $data->JML_TTU_K_RENANG)
					->setCellValue('Q'.$row2, $data->JML_SI_MAS_MUSHOLA)
					->setCellValue('R'.$row2, $data->JML_SI_GEREJA)
					->setCellValue('S'.$row2, $data->JML_SI_KLENTENG)
					->setCellValue('T'.$row2, $data->JML_SI_PURA)
					->setCellValue('U'.$row2, $data->JML_SI_VIHARA)
					->setCellValue('V'.$row2, $data->JML_STR_TERMINAL)
					->setCellValue('W'.$row2, $data->JML_STR_STASIUN)
					->setCellValue('X'.$row2, $data->JML_STR_P_LAUT)
					->setCellValue('Y'.$row2, $data->JML_SES_PASAR)
					->setCellValue('Z'.$row2, $data->JML_SES_APOTIK)
					->setCellValue('AA'.$row2, $data->JML_SES_T_OBAT)
					->setCellValue('AB'.$row2, $data->JML_SES_P_SOSIAL)
					->setCellValue('AC'.$row2, $data->JML_SES_S_KESEHATAN)
					->setCellValue('AD'.$row2, $data->JML_SES_PERKANTORAN)
					->setCellValue('AE'.$row2, $data->JML_SES_P_PESANTREN)
					->setCellValue('AF'.$row2, $data->JML_TPM_W_MAKAN)
					->setCellValue('AG'.$row2, $data->JML_TPM_R_MAKAN)
					->setCellValue('AH'.$row2, $data->JML_TPM_JB_CATERING)
					->setCellValue('AI'.$row2, $data->JML_TPM_IMD_MINUMAN);
                $col2++;
            }
			$n++;
            $row2++;
        }
		$row2_=$row2-1;
		$objPHPExcel->getActiveSheet()->mergeCells("A".$row2.":B".$row2);
		$objPHPExcel->getActiveSheet()->getStyle("A".$row2.":AI".$row2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("A".$row2.":AI".$row2)->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('F1F1F1F1');
		$objPHPExcel->getActiveSheet()->getStyle("A".$row2.":AI".$row2)->applyFromArray(array(
			'borders' => array(
			'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
			)
			)
			));
		$objPHPExcel->getActiveSheet()
					->setCellValue('A'.$row2, 'JUMLAH')
					->setCellValue('C'.$row2, "=SUM(C9:C".$row2_.")")
					->setCellValue('D'.$row2, "=SUM(D9:D".$row2_.")")
					->setCellValue('E'.$row2, "=SUM(E9:E".$row2_.")")
					->setCellValue('F'.$row2, "=SUM(F9:F".$row2_.")")
					->setCellValue('G'.$row2, "=SUM(G9:G".$row2_.")")
					->setCellValue('H'.$row2, "=SUM(H9:H".$row2_.")")
					->setCellValue('I'.$row2, "=SUM(I9:I".$row2_.")")
					->setCellValue('J'.$row2, "=SUM(J9:J".$row2_.")")
					->setCellValue('K'.$row2, "=SUM(K9:K".$row2_.")")
					->setCellValue('L'.$row2, "=SUM(L9:L".$row2_.")")
					->setCellValue('M'.$row2, "=SUM(M9:M".$row2_.")")
					->setCellValue('N'.$row2, "=SUM(N9:N".$row2_.")")
					->setCellValue('O'.$row2, "=SUM(O9:O".$row2_.")")
					->setCellValue('P'.$row2, "=SUM(P9:P".$row2_.")")
					->setCellValue('Q'.$row2, "=SUM(Q9:Q".$row2_.")")
					->setCellValue('R'.$row2, "=SUM(R9:R".$row2_.")")
					->setCellValue('S'.$row2, "=SUM(S9:S".$row2_.")")
					->setCellValue('T'.$row2, "=SUM(T9:T".$row2_.")")
					->setCellValue('U'.$row2, "=SUM(U9:U".$row2_.")")
					->setCellValue('V'.$row2, "=SUM(V9:V".$row2_.")")
					->setCellValue('W'.$row2, "=SUM(W9:W".$row2_.")")
					->setCellValue('X'.$row2, "=SUM(X9:X".$row2_.")")
					->setCellValue('Y'.$row2, "=SUM(Y9:Y".$row2_.")")
					->setCellValue('Z'.$row2, "=SUM(Z9:Z".$row2_.")")
					->setCellValue('AA'.$row2, "=SUM(AA9:AA".$row2_.")")
					->setCellValue('AB'.$row2, "=SUM(AB9:AB".$row2_.")")
					->setCellValue('AC'.$row2, "=SUM(AC9:AC".$row2_.")")
					->setCellValue('AD'.$row2, "=SUM(AD9:AD".$row2_.")")
					->setCellValue('AE'.$row2, "=SUM(AE9:AE".$row2_.")")
					->setCellValue('AF'.$row2, "=SUM(AF9:AF".$row2_.")")
					->setCellValue('AG'.$row2, "=SUM(AG9:AG".$row2_.")")
					->setCellValue('AH'.$row2, "=SUM(AH9:AH".$row2_.")")
					->setCellValue('AI'.$row2, "=SUM(AI9:AI".$row2_.")");
		$n = 1;
		$row3 = 9;
        foreach($db->query($sql)->result() as $data)
        {
            $objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()
				->setTitle('Data Dasar Penduduk')
				->setCellValue('A1', 'DATA DASAR PENDUDUK')
				->setCellValue('A3', 'TAHUN : '.$data->TAHUN)
				->setCellValue('A4', 'DINAS KESEHATAN KAB/KOTA '.$data->KABUPATEN);
			$col3 = 1;
            foreach ($fields as $field)
            {
                $objPHPExcel->getActiveSheet()->getStyle("A".$row3.":AB".$row3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle("A".$row3.":AB".$row3)->applyFromArray(array(
					'borders' => array(
					'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
					)
					)
					));
				$objPHPExcel->getActiveSheet()
					->setCellValue('A'.$row3, $n)
					->setCellValue('B'.$row3, $data->PUSKESMAS)
					->setCellValue('C'.$row3, $data->JML_SP_DESA)
					->setCellValue('D'.$row3, $data->JML_SP_RT)
					->setCellValue('E'.$row3, $data->JML_SP_RW)
					->setCellValue('F'.$row3, $data->JML_SP_KK)
					->setCellValue('G'.$row3, $data->JML_SP_L_WILAYAH)
					->setCellValue('H'.$row3, $data->JML_L_K1TH)
					->setCellValue('I'.$row3, $data->JML_P_K1TH)
					->setCellValue('J'.$row3, "=SUM(H".$row3.":I".$row3.")")
					->setCellValue('K'.$row3, $data->JML_L_1_4TH)
					->setCellValue('L'.$row3, $data->JML_P_1_4TH)
					->setCellValue('M'.$row3, "=SUM(K".$row3.":L".$row3.")")
					->setCellValue('N'.$row3, $l_5_14)
					->setCellValue('O'.$row3, $p_5_14)
					->setCellValue('P'.$row3, "=SUM(N".$row3.":O".$row3.")")
					->setCellValue('Q'.$row3, $l_15_44)
					->setCellValue('R'.$row3, $p_15_44)
					->setCellValue('S'.$row3, "=SUM(Q".$row3.":R".$row3.")")
					->setCellValue('T'.$row3, $l_45_64)
					->setCellValue('U'.$row3, $p_45_64)
					->setCellValue('V'.$row3, "=SUM(T".$row3.":U".$row3.")")
					->setCellValue('W'.$row3, $l_65)
					->setCellValue('X'.$row3, $p_65)
					->setCellValue('Y'.$row3, "=SUM(X".$row3.":W".$row3.")")
					->setCellValue('Z'.$row3, $all_l)
					->setCellValue('AA'.$row3, $all_p)
					->setCellValue('AB'.$row3, "=SUM(Z".$row3.":AA".$row3.")");
                $col3++;
            }
			$n++;
            $row3++;
        }
		$row3_=$row3-1;
		$objPHPExcel->getActiveSheet()->mergeCells("A".$row3.":B".$row3);
		$objPHPExcel->getActiveSheet()->getStyle("A".$row3.":AB".$row3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle("A".$row3.":AB".$row3)->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('F1F1F1F1');
		$objPHPExcel->getActiveSheet()->getStyle("A".$row3.":AB".$row3)->applyFromArray(array(
			'borders' => array(
			'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
			)
			)
			));
		$objPHPExcel->getActiveSheet()
					->setCellValue('A'.$row3, 'JUMLAH')
					->setCellValue('C'.$row2, "=SUM(C9:C".$row2_.")")
					->setCellValue('D'.$row2, "=SUM(D9:D".$row2_.")")
					->setCellValue('E'.$row2, "=SUM(E9:E".$row2_.")")
					->setCellValue('F'.$row2, "=SUM(F9:F".$row2_.")")
					->setCellValue('G'.$row2, "=SUM(G9:G".$row2_.")")
					->setCellValue('H'.$row2, "=SUM(H9:H".$row2_.")")
					->setCellValue('I'.$row2, "=SUM(I9:I".$row2_.")")
					->setCellValue('J'.$row2, "=SUM(J9:J".$row2_.")")
					->setCellValue('K'.$row2, "=SUM(K9:K".$row2_.")")
					->setCellValue('L'.$row2, "=SUM(L9:L".$row2_.")")
					->setCellValue('M'.$row2, "=SUM(M9:M".$row2_.")")
					->setCellValue('N'.$row2, "=SUM(N9:N".$row2_.")")
					->setCellValue('O'.$row2, "=SUM(O9:O".$row2_.")")
					->setCellValue('P'.$row2, "=SUM(P9:P".$row2_.")")
					->setCellValue('Q'.$row2, "=SUM(Q9:Q".$row2_.")")
					->setCellValue('R'.$row2, "=SUM(R9:R".$row2_.")")
					->setCellValue('S'.$row2, "=SUM(S9:S".$row2_.")")
					->setCellValue('T'.$row2, "=SUM(T9:T".$row2_.")")
					->setCellValue('U'.$row2, "=SUM(U9:U".$row2_.")")
					->setCellValue('V'.$row2, "=SUM(V9:V".$row2_.")")
					->setCellValue('W'.$row2, "=SUM(W9:W".$row2_.")")
					->setCellValue('X'.$row2, "=SUM(X9:X".$row2_.")")
					->setCellValue('Y'.$row2, "=SUM(Y9:Y".$row2_.")")
					->setCellValue('Z'.$row2, "=SUM(Z9:Z".$row2_.")")
					->setCellValue('AA'.$row2, "=SUM(AA9:AA".$row2_.")")
					->setCellValue('AB'.$row2, "=SUM(AB9:AB".$row2_.")");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
		$objWriter->save('php://output');
		}
	}
	
	
	public function lapuks_temp_excel(){
	//print_r($_POST);die;
	
		
		$from = $this->input->get('from');	//print_r($from);die;
		$to = $this->input->get('to'); //print_r($to);die;
		$pid = $this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->input->get('pid');
		$dtsql = $this->session->userdata('group_id')=='kabupaten'?"AND SUBSTRING(pl.`KD_PUSKESMAS`,2,4) = '".$pid."' ":"AND pl.`KD_PUSKESMAS` = '".$pid."' ";
		$db = $this->load->database('sikda', TRUE);
	
		//$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_uks a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'")->row();//print_r($data);die;
		$query = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_uks a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'");//print_r($query);die;
		if($query->num_rows>0){
		$data = $query->result(); //print_r($data);die;
		
        if(!$data)
            return false;
 
        // Starting the PHPExcel library
        $this->load->library('Excel');
		$this->excel->getActiveSheet()->setTitle('Data UKS');
        $this->excel->getProperties()->setTitle("export")->setDescription("none");
		
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objPHPExcel = $objReader->load("tmp/LaporanUKS.xls");
		//print_r(BASEPATH);die;
		
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()
            ->setCellValue('D1', $data[0]->bulan)
            ->setCellValue('D2', $data[0]->TAHUN)
            ->setCellValue('D3', $data[0]->KABUPATEN);
       
        // Fetching the table data for SDMI
		$rw=10;
		$no=1;
        foreach($data as $value)
        {			
			$styleArray = array(
			'borders' => array(
			'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
			),
		);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':Z'.$rw)->applyFromArray($styleArray);
		
            $objPHPExcel->getActiveSheet()->setTitle('SDMI')
            ->setCellValue('A'.$rw, $no)
            ->setCellValue('B'.$rw, $value->PUSKESMAS)
            ->setCellValue('C'.$rw, $value->JML_SDMI_UKS)
            ->setCellValue('D'.$rw, $value->JML_SKL_DIBINA_PUSKESMAS)
            ->setCellValue('E'.$rw, $value->JML_SKL_PENJARINGAN)
            ->setCellValue('F'.$rw, $value->JML_L_SD_BBTSTB)
            ->setCellValue('G'.$rw, $value->JML_L_SD_SKL_PUSKESMAS)
            ->setCellValue('H'.$rw, $value->JML_L_SD_SKL_DIRUJUK)
            ->setCellValue('I'.$rw, $value->JML_SD_SKL_MINIMAL)
            ->setCellValue('J'.$rw, $value->JML_SD_SKL_STANDAR)
            ->setCellValue('K'.$rw, $value->JML_SD_SKL_OPTIMAL)
            ->setCellValue('L'.$rw, $value->JML_SD_SKL_PARIPURNA)
            ->setCellValue('M'.$rw, $value->JML_SD_SKL_GR_UKS)
            ->setCellValue('N'.$rw, $value->JML_SD_SKL_DANA_SEHAT)
            ->setCellValue('O'.$rw, $value->JML_SD_SKL_DR_KECIL)
            ->setCellValue('P'.$rw, $value->JML_SD_AK_DR_KECIL)
            ->setCellValue('Q'.$rw, $value->JML_L_M_SD_PENGOBATAN)
            ->setCellValue('R'.$rw, $value->JML_L_M_SD_DIRUJUK)
            ->setCellValue('S'.$rw, $value->JML_L_M_SD_GZ_BURUK)
            ->setCellValue('T'.$rw, $value->JML_L_M_SD_GZ_KURANG)
            ->setCellValue('U'.$rw, $value->JML_L_M_SD_GZ_BAIK)
            ->setCellValue('V'.$rw, $value->JML_L_M_SD_GZ_LEBIH)
            ->setCellValue('W'.$rw, $value->JML_P_SLTP_KON_KESEHATAN)
            ->setCellValue('X'.$rw, $value->JML_L_ALB_SD_PUSKESMAS)
            ->setCellValue('Y'.$rw, $value->JML_L_ALB_SD_DIPERIKSA)
            ->setCellValue('Z'.$rw, $value->JML_L_ALB_SD_DIRUJUK);
		$rw++;
		$no++;
        } //die('=SUM(C10:C'.$rw.')');
		
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':B'.$rw);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':Z'.$rw)->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('f1f1f1f1');
			
		$styleArray = array(
			'borders' => array(
			'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
			),
		);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':Z'.$rw)->applyFromArray($styleArray);


		$objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$rw, 'JUMLAH')
            ->setCellValue('C'.$rw, '=SUM(C10:C'.($rw-1).')')
            ->setCellValue('D'.$rw, '=SUM(D10:D'.($rw-1).')')
            ->setCellValue('E'.$rw, '=SUM(E10:E'.($rw-1).')')
            ->setCellValue('F'.$rw, '=SUM(F10:F'.($rw-1).')')
            ->setCellValue('G'.$rw, '=SUM(G10:G'.($rw-1).')')
            ->setCellValue('H'.$rw, '=SUM(H10:H'.($rw-1).')')
            ->setCellValue('I'.$rw, '=SUM(I10:I'.($rw-1).')')
            ->setCellValue('J'.$rw, '=SUM(J10:J'.($rw-1).')')
            ->setCellValue('K'.$rw, '=SUM(K10:K'.($rw-1).')')
            ->setCellValue('L'.$rw, '=SUM(L10:L'.($rw-1).')')
            ->setCellValue('M'.$rw, '=SUM(M10:M'.($rw-1).')')
            ->setCellValue('N'.$rw, '=SUM(N10:N'.($rw-1).')')
            ->setCellValue('O'.$rw, '=SUM(O10:O'.($rw-1).')')
            ->setCellValue('P'.$rw, '=SUM(P10:P'.($rw-1).')')
            ->setCellValue('Q'.$rw, '=SUM(Q10:Q'.($rw-1).')')
            ->setCellValue('R'.$rw, '=SUM(R10:R'.($rw-1).')')
            ->setCellValue('S'.$rw, '=SUM(S10:S'.($rw-1).')')
            ->setCellValue('T'.$rw, '=SUM(T10:T'.($rw-1).')')
            ->setCellValue('U'.$rw, '=SUM(U10:U'.($rw-1).')')
            ->setCellValue('V'.$rw, '=SUM(V10:V'.($rw-1).')')
            ->setCellValue('W'.$rw, '=SUM(W10:W'.($rw-1).')')
            ->setCellValue('X'.$rw, '=SUM(X10:X'.($rw-1).')')
            ->setCellValue('Y'.$rw, '=SUM(Y10:Y'.($rw-1).')')
            ->setCellValue('Z'.$rw, '=SUM(Z10:Z'.($rw-1).')');
			
			
		$objPHPExcel->setActiveSheetIndex(1);
		$objPHPExcel->getActiveSheet()
            ->setCellValue('D1', $data[0]->bulan)
            ->setCellValue('D2', $data[0]->TAHUN)
            ->setCellValue('D3', $data[0]->KABUPATEN);
       
       // Fetching the table data for SLTP
		$rw=10;
		$no=1;
        foreach($data as $value)
        {					
			$styleArray = array(
			'borders' => array(
			'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
			),
		);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':Z'.$rw)->applyFromArray($styleArray);
		
            $objPHPExcel->getActiveSheet()->setTitle('SLTP')
            ->setCellValue('A'.$rw, $no)
            ->setCellValue('B'.$rw, $value->PUSKESMAS)
            ->setCellValue('C'.$rw, '-')
            ->setCellValue('D'.$rw, '-')
            ->setCellValue('E'.$rw, '-')
            ->setCellValue('F'.$rw, $value->JML_L_SLTP_BBTSTB)
            ->setCellValue('G'.$rw, $value->JML_L_SLTP_DP_PUS_SEKOLAH)
            ->setCellValue('H'.$rw, $value->JML_L_SLTP_DIRUJUK)
            ->setCellValue('I'.$rw, $value->JML_SLTP_SKL_MINIMAL)
            ->setCellValue('J'.$rw, $value->JML_SLTP_SKL_STANDAR)
            ->setCellValue('K'.$rw, $value->JML_SLTP_SKL_OPTIMAL)
            ->setCellValue('L'.$rw, $value->JML_SLTP_SKL_PARIPURNA)
            ->setCellValue('M'.$rw, $value->JML_SLTP_SKL_GR_UKS)
            ->setCellValue('N'.$rw, $value->JML_SLTP_SKL_DANA_SEHAT)
            ->setCellValue('O'.$rw, $value->JML_SLTP_SKL_KDR_KESEHATAN)
            ->setCellValue('P'.$rw, $value->JML_SLTP_SKL_KDR_AKTF)
            ->setCellValue('Q'.$rw, $value->JML_L_M_SLTP_PENGOBATAN)
            ->setCellValue('R'.$rw, $value->JML_L_M_SLTP_DIRUJUK)
            ->setCellValue('S'.$rw, $value->JML_L_M_SLTP_GZ_BURUK)
            ->setCellValue('T'.$rw, $value->JML_L_M_SLTP_GZ_KURANG)
            ->setCellValue('U'.$rw, $value->JML_L_M_SLTP_GZ_BAIK)
            ->setCellValue('V'.$rw, $value->JML_L_M_SLTP_GZ_LEBIH)
            ->setCellValue('W'.$rw, $value->JML_P_SLTP_KON_KESEHATAN)
            ->setCellValue('X'.$rw, $value->JML_L_SLTP_ALB_PUSKESMAS)
            ->setCellValue('Y'.$rw, $value->JML_L_SLTP_ALB_DIPERIKSA)
            ->setCellValue('Z'.$rw, $value->JML_L_SLTP_ALB_DIRUJUK);
		$rw++;
		$no++;
        } //die('=SUM(C10:C'.$rw.')');
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':B'.$rw);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':Z'.$rw)->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('f1f1f1f1');
		$styleArray = array(
			'borders' => array(
			'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
			),
		);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':Z'.$rw)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$rw, 'JUMLAH')
            ->setCellValue('C'.$rw, '=SUM(C10:C'.($rw-1).')')
            ->setCellValue('D'.$rw, '=SUM(D10:D'.($rw-1).')')
            ->setCellValue('E'.$rw, '=SUM(E10:E'.($rw-1).')')
            ->setCellValue('F'.$rw, '=SUM(F10:F'.($rw-1).')')
            ->setCellValue('G'.$rw, '=SUM(G10:G'.($rw-1).')')
            ->setCellValue('H'.$rw, '=SUM(H10:H'.($rw-1).')')
            ->setCellValue('I'.$rw, '=SUM(I10:I'.($rw-1).')')
            ->setCellValue('J'.$rw, '=SUM(J10:J'.($rw-1).')')
            ->setCellValue('K'.$rw, '=SUM(K10:K'.($rw-1).')')
            ->setCellValue('L'.$rw, '=SUM(L10:L'.($rw-1).')')
            ->setCellValue('M'.$rw, '=SUM(M10:M'.($rw-1).')')
            ->setCellValue('N'.$rw, '=SUM(N10:N'.($rw-1).')')
            ->setCellValue('O'.$rw, '=SUM(O10:O'.($rw-1).')')
            ->setCellValue('P'.$rw, '=SUM(P10:P'.($rw-1).')')
            ->setCellValue('Q'.$rw, '=SUM(Q10:Q'.($rw-1).')')
            ->setCellValue('R'.$rw, '=SUM(R10:R'.($rw-1).')')
            ->setCellValue('S'.$rw, '=SUM(S10:S'.($rw-1).')')
            ->setCellValue('T'.$rw, '=SUM(T10:T'.($rw-1).')')
            ->setCellValue('U'.$rw, '=SUM(U10:U'.($rw-1).')')
            ->setCellValue('V'.$rw, '=SUM(V10:V'.($rw-1).')')
            ->setCellValue('W'.$rw, '=SUM(W10:W'.($rw-1).')')
            ->setCellValue('X'.$rw, '=SUM(X10:X'.($rw-1).')')
            ->setCellValue('Y'.$rw, '=SUM(Y10:Y'.($rw-1).')')
            ->setCellValue('Z'.$rw, '=SUM(Z10:Z'.($rw-1).')');
			
		$objPHPExcel->setActiveSheetIndex(2);
		$objPHPExcel->getActiveSheet()
            ->setCellValue('D1', $data[0]->bulan)
            ->setCellValue('D2', $data[0]->TAHUN)
            ->setCellValue('D3', $data[0]->KABUPATEN);
			
			// Fetching the table data for SLTA
		$rw=10;
		$no=1;
        foreach($data as $value)
        {		
			//border
			$styleArray = array(
			'borders' => array(
			'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					),
				),
			);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':Z'.$rw)->applyFromArray($styleArray);
			//end border
            $objPHPExcel->getActiveSheet()->setTitle('SLTA')
            ->setCellValue('A'.$rw, $no)
            ->setCellValue('B'.$rw, $value->PUSKESMAS)
            ->setCellValue('C'.$rw, '-')
            ->setCellValue('D'.$rw, '-')
            ->setCellValue('E'.$rw, '-')
            ->setCellValue('F'.$rw, '-')
            ->setCellValue('G'.$rw, '-')
            ->setCellValue('H'.$rw, '-')
            ->setCellValue('I'.$rw, $value->JML_SLTA_SKL_MINIMAL)
            ->setCellValue('J'.$rw, $value->JML_SLTA_SKL_STANDAR)
            ->setCellValue('K'.$rw, $value->JML_SLTA_SKL_OPTIMAL)
            ->setCellValue('L'.$rw, $value->JML_SLTA_SKL_PARIPURNA)
            ->setCellValue('M'.$rw, $value->JML_SLTA_SKL_GR_UKS)
            ->setCellValue('N'.$rw, $value->JML_SLTA_SKL_DANA_SEHAT)
            ->setCellValue('O'.$rw, $value->JML_SLTA_SKL_KDR_KESEHATAN)
            ->setCellValue('P'.$rw, $value->JML_SLTA_SKL_AK_KDR_KESEHATAN)
            ->setCellValue('Q'.$rw, $value->JML_L_SLTA_PENGOBATAN)
            ->setCellValue('R'.$rw, $value->JML_L_SLTA_DIRUJUK)
            ->setCellValue('S'.$rw, $value->JML_L_SLTA_GZ_BURUK)
            ->setCellValue('T'.$rw, $value->JML_L_SLTA_GZ_KURANG)
            ->setCellValue('U'.$rw, $value->JML_L_SLTA_GZ_BAIK)
            ->setCellValue('V'.$rw, $value->JML_L_SLTA_GZ_LEBIH)
            ->setCellValue('W'.$rw, $value->JML_P_SLTA_KON_KESEHATAN)
            ->setCellValue('X'.$rw, $value->JML_L_SLTA_ALB_PUSKESMAS)
            ->setCellValue('Y'.$rw, $value->JML_L_SLTA_ALB_DIPERIKSA)
            ->setCellValue('Z'.$rw, $value->JML_L_SLTA_ALB_DIRUJUK);
		$rw++;
		$no++;
        } //die('=SUM(C10:C'.$rw.')');
		
		//style
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':B'.$rw);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':Z'.$rw)->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('f1f1f1f1');
			
		$styleArray = array(
			'borders' => array(
			'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
			),
		);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':Z'.$rw)->applyFromArray($styleArray);
		//end style
		$objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$rw, 'JUMLAH')
            ->setCellValue('C'.$rw, '=SUM(C10:C'.($rw-1).')')
            ->setCellValue('D'.$rw, '=SUM(D10:D'.($rw-1).')')
            ->setCellValue('E'.$rw, '=SUM(E10:E'.($rw-1).')')
            ->setCellValue('F'.$rw, '=SUM(F10:F'.($rw-1).')')
            ->setCellValue('G'.$rw, '=SUM(G10:G'.($rw-1).')')
            ->setCellValue('H'.$rw, '=SUM(H10:H'.($rw-1).')')
            ->setCellValue('I'.$rw, '=SUM(I10:I'.($rw-1).')')
            ->setCellValue('J'.$rw, '=SUM(J10:J'.($rw-1).')')
            ->setCellValue('K'.$rw, '=SUM(K10:K'.($rw-1).')')
            ->setCellValue('L'.$rw, '=SUM(L10:L'.($rw-1).')')
            ->setCellValue('M'.$rw, '=SUM(M10:M'.($rw-1).')')
            ->setCellValue('N'.$rw, '=SUM(N10:N'.($rw-1).')')
            ->setCellValue('O'.$rw, '=SUM(O10:O'.($rw-1).')')
            ->setCellValue('P'.$rw, '=SUM(P10:P'.($rw-1).')')
            ->setCellValue('Q'.$rw, '=SUM(Q10:Q'.($rw-1).')')
            ->setCellValue('R'.$rw, '=SUM(R10:R'.($rw-1).')')
            ->setCellValue('S'.$rw, '=SUM(S10:S'.($rw-1).')')
            ->setCellValue('T'.$rw, '=SUM(T10:T'.($rw-1).')')
            ->setCellValue('U'.$rw, '=SUM(U10:U'.($rw-1).')')
            ->setCellValue('V'.$rw, '=SUM(V10:V'.($rw-1).')')
            ->setCellValue('W'.$rw, '=SUM(W10:W'.($rw-1).')')
            ->setCellValue('X'.$rw, '=SUM(X10:X'.($rw-1).')')
            ->setCellValue('Y'.$rw, '=SUM(Y10:Y'.($rw-1).')')
            ->setCellValue('Z'.$rw, '=SUM(Z10:Z'.($rw-1).')');
		
		
        $filename='data_uks.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
		}else{
			die('Tidak Ada Dalam Database');
		}
		
    }
	
	public function lb1_excel(){
	//print_r($_POST);die;
	
		
		$from = $this->input->get('from');	//print_r($from);die;
		$to = $this->input->get('to'); //print_r($to);die;
		$pid = $this->input->get('pid');
		$jenis = $this->input->get('jenis');
		$db = $this->load->database('sikda', TRUE);
	
		//$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_uks a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'")->row();//print_r($data);die;
		if($jenis=='rpt_lb1_kb'){
			$query = $db->query("SELECT X.KABUPATEN,DATE_FORMAT('$from','%d-%m-%Y') as dt1, DATE_FORMAT('$to','%d-%m-%Y') as dt2, I.KD_PENYAKIT, I.PENYAKIT, COL1_L_B, COL1_P_B, COL2_L_B, COL2_P_B, COL3_L_B, COL3_P_B, COL4_L_B, COL4_P_B, COL5_L_B, COL5_P_B, COL6_L_B, COL6_P_B, COL1_L_L, COL1_P_L, COL2_L_L, COL2_P_L, COL3_L_L, COL3_P_L, COL4_L_L, COL4_P_L, COL5_L_L, COL5_P_L, COL6_L_L, COL6_P_L, COL7_L_B, COL7_P_B, COL8_L_B, COL8_P_B, COL9_L_B, COL9_P_B, COL10_L_B, COL10_P_B, COL11_L_B, COL11_P_B, COL12_L_B, COL12_P_B, COL7_L_L, COL7_P_L, COL8_L_L, COL8_P_L, COL9_L_L, COL9_P_L, COL10_L_L, COL10_P_L, COL11_L_L, COL11_P_L, COL12_L_L, COL12_P_L, (COL1_L_B + COL2_L_B + COL3_L_B + COL4_L_B + COL5_L_B + COL6_L_B + COL7_L_B + COL8_L_B + COL9_L_B + COL10_L_B + COL11_L_B + COL12_L_B) AS TOTAL_L_B, (COL1_L_L + COL2_L_L + COL3_L_L + COL4_L_L + COL5_L_L + COL6_L_L + COL7_L_L + COL8_L_L + COL9_L_L + COL10_L_L + COL11_L_L + COL12_L_L) AS TOTAL_L_L, (COL1_P_B + COL2_P_B + COL3_P_B + COL4_P_B + COL5_P_B + COL6_P_B + COL7_P_B + COL8_P_B + COL9_P_B + COL10_P_B + COL11_P_B + COL12_P_B) AS TOTAL_P_B, (COL1_P_L + COL2_P_L + COL3_P_L + COL4_P_L + COL5_P_L + COL6_P_L + COL7_P_L + COL8_P_L + COL9_P_L + COL10_P_L + COL11_P_L + COL12_P_L) AS TOTAL_P_L, (COL1_L_B + COL2_L_B + COL3_L_B + COL4_L_B + COL5_L_B + COL6_L_B + COL7_L_B + COL8_L_B + COL9_L_B + COL10_L_B + COL11_L_B + COL12_L_B + COL1_L_L + COL2_L_L + COL3_L_L + COL4_L_L + COL5_L_L + COL6_L_L + COL7_L_L + COL8_L_L + COL9_L_L + COL10_L_L + COL11_L_L + COL12_L_L + COL1_P_B + COL2_P_B + COL3_P_B + COL4_P_B + COL5_P_B + COL6_P_B + COL7_P_B + COL8_P_B + COL9_P_B + COL10_P_B + COL11_P_B + COL12_P_B + COL1_P_L + COL2_P_L + COL3_P_L + COL4_P_L + COL5_P_L + COL6_P_L + COL7_P_L + COL8_P_L + COL9_P_L + COL10_P_L + COL11_P_L + COL12_P_L) AS TOTAL FROM ( SELECT V.KD_PUSKESMAS, V.KD_PENYAKIT, SUM(IF(UMURINDAYS>=0 AND UMURINDAYS<=7 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL1_L_B`, SUM(IF(UMURINDAYS>=0 AND UMURINDAYS<=7 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL1_P_B`, SUM(IF(UMURINDAYS>=8 AND UMURINDAYS<=28 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL2_L_B`, SUM(IF(UMURINDAYS>=8 AND UMURINDAYS<=28 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL2_P_B`, SUM(IF(UMURINDAYS>=29 AND UMURINDAYS<=365 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL3_L_B`, SUM(IF(UMURINDAYS>=29 AND UMURINDAYS<=365 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL3_P_B`, SUM(IF(UMURINDAYS>=366 AND UMURINDAYS<=1460 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL4_L_B`, SUM(IF(UMURINDAYS>=366 AND UMURINDAYS<=1460 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL4_P_B`, SUM(IF(UMURINDAYS>=1461 AND UMURINDAYS<=3285 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL5_L_B`, SUM(IF(UMURINDAYS>=1461 AND UMURINDAYS<=3285 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL5_P_B`, SUM(IF(UMURINDAYS>=3286 AND UMURINDAYS<=5110 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL6_L_B`, SUM(IF(UMURINDAYS>=3286 AND UMURINDAYS<=5110 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL6_P_B`, SUM(IF(UMURINDAYS>=5111 AND UMURINDAYS<=6935 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL7_L_B`, SUM(IF(UMURINDAYS>=5111 AND UMURINDAYS<=6935 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL7_P_B`, SUM(IF(UMURINDAYS>=6936 AND UMURINDAYS<=16060 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL8_L_B`, SUM(IF(UMURINDAYS>=6936 AND UMURINDAYS<=16060 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL8_P_B`, SUM(IF(UMURINDAYS>=16061 AND UMURINDAYS<=19710 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL9_L_B`, SUM(IF(UMURINDAYS>=16061 AND UMURINDAYS<=19710 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL9_P_B`, SUM(IF(UMURINDAYS>=19711 AND UMURINDAYS<=215353 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL10_L_B`, SUM(IF(UMURINDAYS>=19711 AND UMURINDAYS<=215353 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL10_P_B`, SUM(IF(UMURINDAYS>=21536 AND UMURINDAYS<=25185 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL11_L_B`, SUM(IF(UMURINDAYS>=21536 AND UMURINDAYS<=25185 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL11_P_B`, SUM(IF(UMURINDAYS>=25186 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL12_L_B`, SUM(IF(UMURINDAYS>=25186 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL12_P_B`, SUM(IF(UMURINDAYS>=0 AND UMURINDAYS<=7 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL1_L_L`, SUM(IF(UMURINDAYS>=0 AND UMURINDAYS<=7 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL1_P_L`, SUM(IF(UMURINDAYS>=8 AND UMURINDAYS<=28 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL2_L_L`, SUM(IF(UMURINDAYS>=8 AND UMURINDAYS<=28 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL2_P_L`, SUM(IF(UMURINDAYS>=29 AND UMURINDAYS<=365 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL3_L_L`, SUM(IF(UMURINDAYS>=29 AND UMURINDAYS<=365 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL3_P_L`, SUM(IF(UMURINDAYS>=366 AND UMURINDAYS<=1460 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL4_L_L`, SUM(IF(UMURINDAYS>=366 AND UMURINDAYS<=1460 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL4_P_L`, SUM(IF(UMURINDAYS>=1461 AND UMURINDAYS<=3285 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL5_L_L`, SUM(IF(UMURINDAYS>=1461 AND UMURINDAYS<=3285 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL5_P_L`, SUM(IF(UMURINDAYS>=3286 AND UMURINDAYS<=5110 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL6_L_L`, SUM(IF(UMURINDAYS>=3286 AND UMURINDAYS<=5110 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL6_P_L`, SUM(IF(UMURINDAYS>=5111 AND UMURINDAYS<=6935 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL7_L_L`, SUM(IF(UMURINDAYS>=5111 AND UMURINDAYS<=6935 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL7_P_L`, SUM(IF(UMURINDAYS>=6936 AND UMURINDAYS<=16060 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL8_L_L`, SUM(IF(UMURINDAYS>=6936 AND UMURINDAYS<=16060 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL8_P_L`, SUM(IF(UMURINDAYS>=16061 AND UMURINDAYS<=19710 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL9_L_L`, SUM(IF(UMURINDAYS>=16061 AND UMURINDAYS<=19710 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL9_P_L`, SUM(IF(UMURINDAYS>=19711 AND UMURINDAYS<=215353 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL10_L_L`, SUM(IF(UMURINDAYS>=19711 AND UMURINDAYS<=215353 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL10_P_L`, SUM(IF(UMURINDAYS>=21536 AND UMURINDAYS<=25185 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL11_L_L`, SUM(IF(UMURINDAYS>=21536 AND UMURINDAYS<=25185 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL11_P_L`, SUM(IF(UMURINDAYS>=25186 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL12_L_L`, SUM(IF(UMURINDAYS>=25186 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL12_P_L` FROM vw_rpt_penyakitpasien_grp_old AS V WHERE (TGL_PELAYANAN BETWEEN '$from' AND '$to') AND SUBSTRING(KD_PUSKESMAS,2,4)='$pid' GROUP BY V.KD_PUSKESMAS, V.KD_PENYAKIT ) V INNER JOIN mst_icd I ON I.KD_PENYAKIT=V.KD_PENYAKIT LEFT JOIN mst_kabupaten X ON X.KD_KABUPATEN='$pid' ORDER BY I.KD_PENYAKIT, I.PENYAKIT;");
			
			if($query->num_rows>0){
			$data = $query->result(); //print_r($data);die;
			
			if(!$data)
				return false;
	 
			// Starting the PHPExcel library
			$this->load->library('Excel');
			$this->excel->getActiveSheet()->setTitle('LB1');
			$this->excel->getProperties()->setTitle("export")->setDescription("none");
			
			$objReader = PHPExcel_IOFactory::createReader('Excel5');
			$objPHPExcel = $objReader->load("tmp/laporan_lb1_kab.xls");
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
				$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':BD'.($rw+1))->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				//$objPHPExcel->getActiveSheet()->getStyle('C'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->setTitle('Data')
					->setCellValue('A'.$rw, $no)
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
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A'.($rw+2).':A'.($rw+4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':C'.$rw);
			$objPHPExcel->getActiveSheet()
				->setCellValue('E4', $value->KABUPATEN)
				->setCellValue('E5', ($value->dt1).' s/d '.$value->dt2)
				->setCellValue('A'.$rw, 'TOTAL')
				//->setCellValue('A'.($rw+2), 'Kepala Puskesmas')
				//->setCellValue('A'.($rw+4), $value->KEPALA_PUSKESMAS)
				->setCellValue('D'.$rw, '=SUM(D9:D'.($rw-1).')')
				->setCellValue('E'.$rw, '=SUM(E9:E'.($rw-1).')')
				->setCellValue('F'.$rw, '=SUM(F9:F'.($rw-1).')')
				->setCellValue('G'.$rw, '=SUM(G9:G'.($rw-1).')')
				->setCellValue('H'.$rw, '=SUM(H9:H'.($rw-1).')')
				->setCellValue('I'.$rw, '=SUM(I9:I'.($rw-1).')')
				->setCellValue('J'.$rw, '=SUM(J9:J'.($rw-1).')')
				->setCellValue('K'.$rw, '=SUM(K9:K'.($rw-1).')')
				->setCellValue('L'.$rw, '=SUM(L9:L'.($rw-1).')')
				->setCellValue('M'.$rw, '=SUM(M9:M'.($rw-1).')')
				->setCellValue('N'.$rw, '=SUM(N9:N'.($rw-1).')')
				->setCellValue('O'.$rw, '=SUM(O9:O'.($rw-1).')')
				->setCellValue('P'.$rw, '=SUM(P9:P'.($rw-1).')')
				->setCellValue('Q'.$rw, '=SUM(Q9:Q'.($rw-1).')')
				->setCellValue('R'.$rw, '=SUM(R9:R'.($rw-1).')')
				->setCellValue('S'.$rw, '=SUM(S9:S'.($rw-1).')')
				->setCellValue('T'.$rw, '=SUM(T9:T'.($rw-1).')')
				->setCellValue('U'.$rw, '=SUM(U9:U'.($rw-1).')')
				->setCellValue('V'.$rw, '=SUM(V9:V'.($rw-1).')')
				->setCellValue('W'.$rw, '=SUM(W9:W'.($rw-1).')')
				->setCellValue('X'.$rw, '=SUM(X9:X'.($rw-1).')')
				->setCellValue('Y'.$rw, '=SUM(Y9:Y'.($rw-1).')')
				->setCellValue('Z'.$rw, '=SUM(Z9:Z'.($rw-1).')')
				->setCellValue('AA'.$rw, '=SUM(AA9:AA'.($rw-1).')')
				->setCellValue('AB'.$rw, '=SUM(AB9:AB'.($rw-1).')')
				->setCellValue('AC'.$rw, '=SUM(AC9:AC'.($rw-1).')')
				->setCellValue('AD'.$rw, '=SUM(AD9:AD'.($rw-1).')')
				->setCellValue('AE'.$rw, '=SUM(AE9:AE'.($rw-1).')')
				->setCellValue('AF'.$rw, '=SUM(AF9:AF'.($rw-1).')')
				->setCellValue('AG'.$rw, '=SUM(AG9:AG'.($rw-1).')')
				->setCellValue('AH'.$rw, '=SUM(AH9:AH'.($rw-1).')')
				->setCellValue('AI'.$rw, '=SUM(AI9:AI'.($rw-1).')')
				->setCellValue('AJ'.$rw, '=SUM(AJ9:AJ'.($rw-1).')')
				->setCellValue('AK'.$rw, '=SUM(AK9:AK'.($rw-1).')')
				->setCellValue('AL'.$rw, '=SUM(AL9:AL'.($rw-1).')')
				->setCellValue('AM'.$rw, '=SUM(AM9:AM'.($rw-1).')')
				->setCellValue('AN'.$rw, '=SUM(AN9:AN'.($rw-1).')')
				->setCellValue('AO'.$rw, '=SUM(AO9:AO'.($rw-1).')')
				->setCellValue('AP'.$rw, '=SUM(AP9:AP'.($rw-1).')')
				->setCellValue('AQ'.$rw, '=SUM(AQ9:AQ'.($rw-1).')')
				->setCellValue('AR'.$rw, '=SUM(AR9:AR'.($rw-1).')')
				->setCellValue('AS'.$rw, '=SUM(AS9:AS'.($rw-1).')')
				->setCellValue('AT'.$rw, '=SUM(AT9:AT'.($rw-1).')')
				->setCellValue('AU'.$rw, '=SUM(AU9:AU'.($rw-1).')')
				->setCellValue('AV'.$rw, '=SUM(AV9:AV'.($rw-1).')')
				->setCellValue('AW'.$rw, '=SUM(AW9:AW'.($rw-1).')')
				->setCellValue('AX'.$rw, '=SUM(AX9:AX'.($rw-1).')')
				->setCellValue('AY'.$rw, '=SUM(AY9:AY'.($rw-1).')')
				->setCellValue('AZ'.$rw, '=SUM(AZ9:AZ'.($rw-1).')')
				->setCellValue('BA'.$rw, '=SUM(BA9:BA'.($rw-1).')')
				->setCellValue('BB'.$rw, '=SUM(BB9:BB'.($rw-1).')')
				->setCellValue('BC'.$rw, '=SUM(BC9:BC'.($rw-1).')')
				->setCellValue('BD'.$rw, '=SUM(BD9:BD'.($rw-1).')');
			$filename='laporan_lb1_kab'.date('_dmY_his').'.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			}else{
				die('Tidak Ada Dalam Database');
			}
		}else{
			$query = $db->query("SELECT DATE_FORMAT('$from','%d-%m-%Y') as dt1,DATE_FORMAT('$to','%d-%m-%Y') as dt2, V.KD_PUSKESMAS, (SELECT S.KEY_VALUE FROM sys_setting AS S WHERE S.KEY_DATA = 'NAMA_PUSKESMAS' AND PUSKESMAS='$pid' LIMIT 1) AS NAMA_PUSKESMAS, (SELECT S.KEY_VALUE FROM sys_setting AS S WHERE S.KEY_DATA = 'NAMA_PIMPINAN' AND PUSKESMAS='$pid' LIMIT 1) AS KEPALA_PUSKESMAS, I.KD_PENYAKIT, I.PENYAKIT, COL1_L_B, COL1_P_B, COL2_L_B, COL2_P_B, COL3_L_B, COL3_P_B, COL4_L_B, COL4_P_B, COL5_L_B, COL5_P_B, COL6_L_B, COL6_P_B, COL1_L_L, COL1_P_L, COL2_L_L, COL2_P_L, COL3_L_L, COL3_P_L, COL4_L_L, COL4_P_L, COL5_L_L, COL5_P_L, COL6_L_L, COL6_P_L, COL7_L_B, COL7_P_B, COL8_L_B, COL8_P_B, COL9_L_B, COL9_P_B, COL10_L_B, COL10_P_B, COL11_L_B, COL11_P_B, COL12_L_B, COL12_P_B, COL7_L_L, COL7_P_L, COL8_L_L, COL8_P_L, COL9_L_L, COL9_P_L, COL10_L_L, COL10_P_L, COL11_L_L, COL11_P_L, COL12_L_L, COL12_P_L, (COL1_L_B + COL2_L_B + COL3_L_B + COL4_L_B + COL5_L_B + COL6_L_B + COL7_L_B + COL8_L_B + COL9_L_B + COL10_L_B + COL11_L_B + COL12_L_B) AS TOTAL_L_B, (COL1_L_L + COL2_L_L + COL3_L_L + COL4_L_L + COL5_L_L + COL6_L_L + COL7_L_L + COL8_L_L + COL9_L_L + COL10_L_L + COL11_L_L + COL12_L_L) AS TOTAL_L_L, (COL1_P_B + COL2_P_B + COL3_P_B + COL4_P_B + COL5_P_B + COL6_P_B + COL7_P_B + COL8_P_B + COL9_P_B + COL10_P_B + COL11_P_B + COL12_P_B) AS TOTAL_P_B, (COL1_P_L + COL2_P_L + COL3_P_L + COL4_P_L + COL5_P_L + COL6_P_L + COL7_P_L + COL8_P_L + COL9_P_L + COL10_P_L + COL11_P_L + COL12_P_L) AS TOTAL_P_L, (COL1_L_B + COL2_L_B + COL3_L_B + COL4_L_B + COL5_L_B + COL6_L_B + COL7_L_B + COL8_L_B + COL9_L_B + COL10_L_B + COL11_L_B + COL12_L_B + COL1_L_L + COL2_L_L + COL3_L_L + COL4_L_L + COL5_L_L + COL6_L_L + COL7_L_L + COL8_L_L + COL9_L_L + COL10_L_L + COL11_L_L + COL12_L_L + COL1_P_B + COL2_P_B + COL3_P_B + COL4_P_B + COL5_P_B + COL6_P_B + COL7_P_B + COL8_P_B + COL9_P_B + COL10_P_B + COL11_P_B + COL12_P_B + COL1_P_L + COL2_P_L + COL3_P_L + COL4_P_L + COL5_P_L + COL6_P_L + COL7_P_L + COL8_P_L + COL9_P_L + COL10_P_L + COL11_P_L + COL12_P_L) AS TOTAL FROM ( SELECT V.KD_PUSKESMAS, V.NAMA_PUSKESMAS, V.KD_PENYAKIT, SUM(IF(UMURINDAYS>=0 AND UMURINDAYS<=7 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL1_L_B`, SUM(IF(UMURINDAYS>=0 AND UMURINDAYS<=7 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL1_P_B`, SUM(IF(UMURINDAYS>=8 AND UMURINDAYS<=28 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL2_L_B`, SUM(IF(UMURINDAYS>=8 AND UMURINDAYS<=28 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL2_P_B`, SUM(IF(UMURINDAYS>=29 AND UMURINDAYS<=365 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL3_L_B`, SUM(IF(UMURINDAYS>=29 AND UMURINDAYS<=365 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL3_P_B`, SUM(IF(UMURINDAYS>=366 AND UMURINDAYS<=1460 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL4_L_B`, SUM(IF(UMURINDAYS>=366 AND UMURINDAYS<=1460 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL4_P_B`, SUM(IF(UMURINDAYS>=1461 AND UMURINDAYS<=3285 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL5_L_B`, SUM(IF(UMURINDAYS>=1461 AND UMURINDAYS<=3285 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL5_P_B`, SUM(IF(UMURINDAYS>=3286 AND UMURINDAYS<=5110 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL6_L_B`, SUM(IF(UMURINDAYS>=3286 AND UMURINDAYS<=5110 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL6_P_B`, SUM(IF(UMURINDAYS>=5111 AND UMURINDAYS<=6935 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL7_L_B`, SUM(IF(UMURINDAYS>=5111 AND UMURINDAYS<=6935 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL7_P_B`, SUM(IF(UMURINDAYS>=6936 AND UMURINDAYS<=16060 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL8_L_B`, SUM(IF(UMURINDAYS>=6936 AND UMURINDAYS<=16060 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL8_P_B`, SUM(IF(UMURINDAYS>=16061 AND UMURINDAYS<=19710 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL9_L_B`, SUM(IF(UMURINDAYS>=16061 AND UMURINDAYS<=19710 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL9_P_B`, SUM(IF(UMURINDAYS>=19711 AND UMURINDAYS<=21535 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL10_L_B`, SUM(IF(UMURINDAYS>=19711 AND UMURINDAYS<=21535 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL10_P_B`, SUM(IF(UMURINDAYS>=21900 AND UMURINDAYS<=25185 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL11_L_B`, SUM(IF(UMURINDAYS>=21900 AND UMURINDAYS<=25185 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL11_P_B`, SUM(IF(UMURINDAYS>=25186 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL12_L_B`, SUM(IF(UMURINDAYS>=25186 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL12_P_B`, SUM(IF(UMURINDAYS>=0 AND UMURINDAYS<=7 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL1_L_L`, SUM(IF(UMURINDAYS>=0 AND UMURINDAYS<=7 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL1_P_L`, SUM(IF(UMURINDAYS>=8 AND UMURINDAYS<=28 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL2_L_L`, SUM(IF(UMURINDAYS>=8 AND UMURINDAYS<=28 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL2_P_L`, SUM(IF(UMURINDAYS>=29 AND UMURINDAYS<=365 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL3_L_L`, SUM(IF(UMURINDAYS>=29 AND UMURINDAYS<=365 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL3_P_L`, SUM(IF(UMURINDAYS>=366 AND UMURINDAYS<=1460 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL4_L_L`, SUM(IF(UMURINDAYS>=366 AND UMURINDAYS<=1460 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL4_P_L`, SUM(IF(UMURINDAYS>=1461 AND UMURINDAYS<=3285 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL5_L_L`, SUM(IF(UMURINDAYS>=1461 AND UMURINDAYS<=3285 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL5_P_L`, SUM(IF(UMURINDAYS>=3286 AND UMURINDAYS<=5110 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL6_L_L`, SUM(IF(UMURINDAYS>=3286 AND UMURINDAYS<=5110 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL6_P_L`, SUM(IF(UMURINDAYS>=5111 AND UMURINDAYS<=6935 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL7_L_L`, SUM(IF(UMURINDAYS>=5111 AND UMURINDAYS<=6935 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL7_P_L`, SUM(IF(UMURINDAYS>=6936 AND UMURINDAYS<=16060 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL8_L_L`, SUM(IF(UMURINDAYS>=6936 AND UMURINDAYS<=16060 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL8_P_L`, SUM(IF(UMURINDAYS>=16061 AND UMURINDAYS<=19710 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL9_L_L`, SUM(IF(UMURINDAYS>=16061 AND UMURINDAYS<=19710 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL9_P_L`, SUM(IF(UMURINDAYS>=19711 AND UMURINDAYS<=21535 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL10_L_L`, SUM(IF(UMURINDAYS>=19711 AND UMURINDAYS<=21535 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL10_P_L`, SUM(IF(UMURINDAYS>=21900 AND UMURINDAYS<=25185 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL11_L_L`, SUM(IF(UMURINDAYS>=21900 AND UMURINDAYS<=25185 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL11_P_L`, SUM(IF(UMURINDAYS>=25186 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL12_L_L`, SUM(IF(UMURINDAYS>=25186 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL12_P_L` FROM vw_rpt_penyakitpasien_grp_old AS V WHERE (TGL_PELAYANAN BETWEEN '$from' AND '$to') AND KD_PUSKESMAS='$pid' GROUP BY V.KD_PUSKESMAS, V.NAMA_PUSKESMAS, V.KD_PENYAKIT ) V INNER JOIN mst_icd I ON I.KD_PENYAKIT=V.KD_PENYAKIT ORDER BY I.KD_PENYAKIT, I.PENYAKIT;");//print_r($query);die;
			if($query->num_rows>0){
			$data = $query->result(); //print_r($data);die;
			
			if(!$data)
				return false;
	 
			// Starting the PHPExcel library
			$this->load->library('Excel');
			$this->excel->getActiveSheet()->setTitle('LB1');
			$this->excel->getProperties()->setTitle("export")->setDescription("none");
			
			$objReader = PHPExcel_IOFactory::createReader('Excel5');
			$objPHPExcel = $objReader->load("tmp/laporan_lb1.xls");
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
				$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':BD'.($rw+1))->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				//$objPHPExcel->getActiveSheet()->getStyle('C'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->setTitle('Data')
					->setCellValue('A'.$rw, $no)
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
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A'.($rw+2).':A'.($rw+4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':C'.$rw);
			$objPHPExcel->getActiveSheet()
				->setCellValue('E4', $value->KD_PUSKESMAS.'   '.$value->NAMA_PUSKESMAS)
				->setCellValue('E5', ($value->dt1).' s/d '.$value->dt2)
				->setCellValue('A'.$rw, 'TOTAL')
				->setCellValue('A'.($rw+2), 'Kepala Puskesmas')
				->setCellValue('A'.($rw+4), $value->KEPALA_PUSKESMAS)
				->setCellValue('D'.$rw, '=SUM(D9:D'.($rw-1).')')
				->setCellValue('E'.$rw, '=SUM(E9:E'.($rw-1).')')
				->setCellValue('F'.$rw, '=SUM(F9:F'.($rw-1).')')
				->setCellValue('G'.$rw, '=SUM(G9:G'.($rw-1).')')
				->setCellValue('H'.$rw, '=SUM(H9:H'.($rw-1).')')
				->setCellValue('I'.$rw, '=SUM(I9:I'.($rw-1).')')
				->setCellValue('J'.$rw, '=SUM(J9:J'.($rw-1).')')
				->setCellValue('K'.$rw, '=SUM(K9:K'.($rw-1).')')
				->setCellValue('L'.$rw, '=SUM(L9:L'.($rw-1).')')
				->setCellValue('M'.$rw, '=SUM(M9:M'.($rw-1).')')
				->setCellValue('N'.$rw, '=SUM(N9:N'.($rw-1).')')
				->setCellValue('O'.$rw, '=SUM(O9:O'.($rw-1).')')
				->setCellValue('P'.$rw, '=SUM(P9:P'.($rw-1).')')
				->setCellValue('Q'.$rw, '=SUM(Q9:Q'.($rw-1).')')
				->setCellValue('R'.$rw, '=SUM(R9:R'.($rw-1).')')
				->setCellValue('S'.$rw, '=SUM(S9:S'.($rw-1).')')
				->setCellValue('T'.$rw, '=SUM(T9:T'.($rw-1).')')
				->setCellValue('U'.$rw, '=SUM(U9:U'.($rw-1).')')
				->setCellValue('V'.$rw, '=SUM(V9:V'.($rw-1).')')
				->setCellValue('W'.$rw, '=SUM(W9:W'.($rw-1).')')
				->setCellValue('X'.$rw, '=SUM(X9:X'.($rw-1).')')
				->setCellValue('Y'.$rw, '=SUM(Y9:Y'.($rw-1).')')
				->setCellValue('Z'.$rw, '=SUM(Z9:Z'.($rw-1).')')
				->setCellValue('AA'.$rw, '=SUM(AA9:AA'.($rw-1).')')
				->setCellValue('AB'.$rw, '=SUM(AB9:AB'.($rw-1).')')
				->setCellValue('AC'.$rw, '=SUM(AC9:AC'.($rw-1).')')
				->setCellValue('AD'.$rw, '=SUM(AD9:AD'.($rw-1).')')
				->setCellValue('AE'.$rw, '=SUM(AE9:AE'.($rw-1).')')
				->setCellValue('AF'.$rw, '=SUM(AF9:AF'.($rw-1).')')
				->setCellValue('AG'.$rw, '=SUM(AG9:AG'.($rw-1).')')
				->setCellValue('AH'.$rw, '=SUM(AH9:AH'.($rw-1).')')
				->setCellValue('AI'.$rw, '=SUM(AI9:AI'.($rw-1).')')
				->setCellValue('AJ'.$rw, '=SUM(AJ9:AJ'.($rw-1).')')
				->setCellValue('AK'.$rw, '=SUM(AK9:AK'.($rw-1).')')
				->setCellValue('AL'.$rw, '=SUM(AL9:AL'.($rw-1).')')
				->setCellValue('AM'.$rw, '=SUM(AM9:AM'.($rw-1).')')
				->setCellValue('AN'.$rw, '=SUM(AN9:AN'.($rw-1).')')
				->setCellValue('AO'.$rw, '=SUM(AO9:AO'.($rw-1).')')
				->setCellValue('AP'.$rw, '=SUM(AP9:AP'.($rw-1).')')
				->setCellValue('AQ'.$rw, '=SUM(AQ9:AQ'.($rw-1).')')
				->setCellValue('AR'.$rw, '=SUM(AR9:AR'.($rw-1).')')
				->setCellValue('AS'.$rw, '=SUM(AS9:AS'.($rw-1).')')
				->setCellValue('AT'.$rw, '=SUM(AT9:AT'.($rw-1).')')
				->setCellValue('AU'.$rw, '=SUM(AU9:AU'.($rw-1).')')
				->setCellValue('AV'.$rw, '=SUM(AV9:AV'.($rw-1).')')
				->setCellValue('AW'.$rw, '=SUM(AW9:AW'.($rw-1).')')
				->setCellValue('AX'.$rw, '=SUM(AX9:AX'.($rw-1).')')
				->setCellValue('AY'.$rw, '=SUM(AY9:AY'.($rw-1).')')
				->setCellValue('AZ'.$rw, '=SUM(AZ9:AZ'.($rw-1).')')
				->setCellValue('BA'.$rw, '=SUM(BA9:BA'.($rw-1).')')
				->setCellValue('BB'.$rw, '=SUM(BB9:BB'.($rw-1).')')
				->setCellValue('BC'.$rw, '=SUM(BC9:BC'.($rw-1).')')
				->setCellValue('BD'.$rw, '=SUM(BD9:BD'.($rw-1).')');
			$filename='laporan_lb1'.date('_dmY_his').'.xls'; //save our workbook as this file name
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
	
	
    public function odontogram_excel(){


        $from = $this->input->get('from');	//print_r($from);die;
        $to = $this->input->get('to'); //print_r($to);die;
        $pid = $this->input->get('pid');
        $jenis = $this->input->get('jenis');
        $db = $this->load->database('sikda', TRUE);

        $level_aplikasi = $this->session->userdata('level_aplikasi'); //can be PUSKESMAS OR KABUPATEN
        $kd_kabupaten = $this->session->userdata('kd_kabupaten');

        if($level_aplikasi=='KABUPATEN'){
            $search = array('$P{date1}','$P{date2}','$P{parameter1}');
            $replace = array("'$from'","'$to'","'$kd_kabupaten'");
            $str_query = readFileContents('query/select/lb_gigi_kbp.sql');
        }else{
            $search = array('$P{date1}','$P{date2}','$P{parameter1}');
            $replace = array("'$from'","'$to'","'$pid'");
            $str_query = readFileContents('query/select/lb_gigi_pkm.sql');
        }
        $str_query = str_replace($search,$replace,$str_query);

        //DMF query
//        $read_sql = readFileContents('query/select/dmf.sql');
//        $str_dmf = str_replace($search,$replace,$read_sql);
//        $db_query_dmf = $db->query($str_dmf);
//        $dmf = $db_query_dmf->result(); //print_r($val);die;
        //--------------------//

        $query = $db->query($str_query);
        if($query->num_rows>0){

            $data = $query->result(); //print_r($data);die;

            if(!$data)
                return false;

            // Starting the PHPExcel library
            $this->load->library('Excel');
            $this->excel->getActiveSheet()->setTitle('LB2');
            $this->excel->getProperties()->setTitle("export")->setDescription("none");

            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            $objPHPExcel = $objReader->load("tmp/odontogram/laporan_gigi.xls");
            $objPHPExcel->setActiveSheetIndex(0);
            $rw=16;
            $rs=8;
            $no=1;
            $total=0;
            $total_status = 0;

            $DMF_D =0;
            $DMF_F=0;
            $DMF_M=0;
            $val_tmp = $data[0];
            if(!empty($val_tmp)){
                if(!empty($val_tmp->DMF_D)) $DMF_D = $val_tmp->DMF_D;
                if(!empty($val_tmp->DMF_F)) $DMF_F = $val_tmp->DMF_F;
                if(!empty($val_tmp->DMF_M)) $DMF_M = $val_tmp->DMF_M;
                if(!empty($val_tmp->JUMLAH_PASIEN)) $JML_PASIEN = $val_tmp->JUMLAH_PASIEN;
            }
            $total_DMF =  $DMF_D+$DMF_M+$DMF_F;
            $average_DMF = round($total_DMF/$JML_PASIEN, 2);

            $objPHPExcel->getActiveSheet()->setTitle('Data')
                ->setCellValue('D'.($rs), $DMF_D)
                ->setCellValue('D'.($rs+1), $DMF_M)
                ->setCellValue('D'.($rs+2), $DMF_F)
                ->setCellValue('D'.($rs+3), $total_DMF)
                ->setCellValue('D'.($rs+4), $average_DMF)
            ;

            foreach($data as $value)
            {
                $styleArray = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                        ),
                    ),
                );
                $objPHPExcel->getActiveSheet()->getStyle('A'.($rw).':D'.($rw))->applyFromArray($styleArray);

                $objPHPExcel->getActiveSheet()->getStyle('A'.($rw).':B'.($rw))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('D'.($rw))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                //$objPHPExcel->getActiveSheet()->getStyle('C'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()
                    ->setCellValue('A'.($rw), $no)
                    ->setCellValue('B'.($rw), $value->KD_STATUS_GIGI)
                    ->setCellValue('C'.($rw), $value->NAMA_STATUS_GIGI)
                    ->setCellValue('D'.($rw), $value->JUMLAH);
                $total_status += $value->JUMLAH;
                $rw++;
                $no++;
            }
            $objPHPExcel->getActiveSheet()
                ->setCellValue('A'.($rw), 'TOTAL')
                ->setCellValue('D'.($rw), $total_status);
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->getStyle('D'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A'.($rw+2).':A'.($rw+4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':C'.$rw);
            $objPHPExcel->getActiveSheet()->getStyle('A'.($rw).':D'.($rw))->applyFromArray($styleArray);

            if($level_aplikasi=="KABUPATEN"){
                $objPHPExcel->getActiveSheet()
                    ->setCellValue('B3','Kabupaten :')
                    ->setCellValue('C3',$data? $data[0]->NAMA_KABUPATEN: '')
                    ->setCellValue('C4', ($value->dt1).' s/d '.$value->dt2)
                    ->setCellValue('C5',$data? $data[0]->JUMLAH_PASIEN: '')
                ;
            }else{
                $objPHPExcel->getActiveSheet()
                    ->setCellValue('C3', $pid.'   '.$value->NAMA_PUSKESMAS)
                    ->setCellValue('C4', ($value->dt1).' s/d '.$value->dt2)
                    ->setCellValue('C5',$data? $data[0]->JUMLAH_PASIEN: '')
                    ->setCellValue('A'.($rw+2), 'Kepala Puskesmas')
                    ->setCellValue('A'.($rw+4), $value->KEPALA_PUSKESMAS);
            }
            $filename='laporan_gigi'.date('_dmY_his').'.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }else{
            die('Tidak Ada Dalam Database');
        }

    }

    public function odontogram_tindakan_excel(){


        $from = $this->input->get('from');	//print_r($from);die;
        $to = $this->input->get('to'); //print_r($to);die;
        $pid = $this->input->get('pid');
        $jenis = $this->input->get('jenis');
        $db = $this->load->database('sikda', TRUE);

        $level_aplikasi = $this->session->userdata('level_aplikasi'); //can be PUSKESMAS OR KABUPATEN
        $kd_kabupaten = $this->session->userdata('kd_kabupaten');

        if($level_aplikasi=='KABUPATEN'){
            $search = array('$P{date1}','$P{date2}','$P{parameter1}');
            $replace = array("'$from'","'$to'","'$kd_kabupaten'");
            $str_query = readFileContents('query/select/lb_tindakan_gigi_kbp.sql');
        }else{
            $search = array('$P{date1}','$P{date2}','$P{parameter1}');
            $replace = array("'$from'","'$to'","'$pid'");
            $str_query = readFileContents('query/select/lb_tindakan_gigi_pkm.sql');
        }
        $str_query = str_replace($search,$replace,$str_query);

        $query = $db->query($str_query);
        if($query->num_rows>0){
            $data = $query->result(); //print_r($data);die;

            if(!$data)
                return false;

            // Starting the PHPExcel library
            $this->load->library('Excel');
            $this->excel->getActiveSheet()->setTitle('LB2');
            $this->excel->getProperties()->setTitle("export")->setDescription("none");

            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            $objPHPExcel = $objReader->load("tmp/odontogram/laporan_tindakan_gigi.xls");
            $objPHPExcel->setActiveSheetIndex(0);
            $rw=8;
            $no=1;
            $total=0;
            $total_status = 0;

            foreach($data as $value)
            {
                $styleArray = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                        ),
                    ),
                );
                $objPHPExcel->getActiveSheet()->getStyle('A'.($rw).':D'.($rw))->applyFromArray($styleArray);

                $objPHPExcel->getActiveSheet()->getStyle('A'.($rw).':B'.($rw))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('D'.($rw))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()
                    ->setCellValue('A'.($rw), $no)
                    ->setCellValue('B'.($rw), $value->KD_PRODUK)
                    ->setCellValue('C'.($rw), $value->PRODUK)
                    ->setCellValue('D'.($rw), $value->JUMLAH);
                $total_status += $value->JUMLAH;
                $rw++;
                $no++;
            }
            $objPHPExcel->getActiveSheet()
                ->setCellValue('A'.($rw), 'TOTAL')
                ->setCellValue('D'.($rw), $total_status);
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->getStyle('D'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A'.($rw+2).':A'.($rw+4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':C'.$rw);
            $objPHPExcel->getActiveSheet()->getStyle('A'.($rw).':D'.($rw))->applyFromArray($styleArray);

            if($level_aplikasi=="KABUPATEN"){
                $objPHPExcel->getActiveSheet()
                    ->setCellValue('B3','Kabupaten :')
                    ->setCellValue('C3',$data? $data[0]->NAMA_KABUPATEN: '')
                    ->setCellValue('C4', ($value->dt1).' s/d '.$value->dt2)
                    ->setCellValue('C5',$data? $data[0]->JUMLAH_PASIEN: '');
            }else{
                $objPHPExcel->getActiveSheet()
                    ->setCellValue('C3', $pid.'   '.$value->NAMA_PUSKESMAS)
                    ->setCellValue('C4', ($value->dt1).' s/d '.$value->dt2)
                    ->setCellValue('C5',$data? $data[0]->JUMLAH_PASIEN: '')
                    ->setCellValue('A'.($rw+2), 'Kepala Puskesmas')
                    ->setCellValue('A'.($rw+4), $value->KEPALA_PUSKESMAS);
            }
            $filename='laporan_tindakan_gigi'.date('_dmY_his').'.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }else{
            die('Tidak Ada Dalam Database');
        }

    }



	
	public function lb2_excel(){
	//print_r($_POST);die;
	
		
		$from = $this->input->get('from');	//print_r($from);die;
		$to = $this->input->get('to'); //print_r($to);die;
		$pid = $this->input->get('pid');
		$jenis = $this->input->get('jenis');
		$db = $this->load->database('sikda', TRUE);
	
		//$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_uks a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'")->row();//print_r($data);die;
		$query = $db->query("SELECT DATE_FORMAT('$from','%d-%m-%Y') as dt1, DATE_FORMAT('$to','%d-%m-%Y') as dt2, '$pid' AS KD_PUSKESMAS,
		(SELECT S.KEY_VALUE FROM sys_setting AS S WHERE
		S.KEY_DATA = 'NAMA_PUSKESMAS' AND PUSKESMAS='$pid' LIMIT 1) AS NAMA_PUSKESMAS,
		(SELECT S.KEY_VALUE FROM sys_setting AS S WHERE
		S.KEY_DATA = 'NAMA_PIMPINAN' AND PUSKESMAS='$pid' LIMIT 1) AS KEPALA_PUSKESMAS,
		I.KD_OBAT, I.NAMA_OBAT,I.KD_SAT_KECIL,
		IFNULL(COL_STOKAWAL,IFNULL((SELECT SUM(JUMLAH_STOK_OBAT) FROM apt_stok_obat 
		WHERE KD_OBAT=Z.KD_OBAT AND KD_MILIK_OBAT='PKM' AND KD_PKM='$pid'),0)) AS COL_STOKAWAL,
		IFNULL(COL_PENERIMAAN_APBD,'0') AS COL_PENERIMAAN_APBD,
		IFNULL(COL_PERSEDIAAN_APBD,IFNULL((SELECT SUM(JUMLAH_STOK_OBAT) FROM apt_stok_obat 
		WHERE KD_OBAT=Z.KD_OBAT AND KD_MILIK_OBAT='PKM' AND KD_PKM='$pid'),0)) AS COL_PERSEDIAAN_APBD,
		IFNULL(COL_PEMAKAIAN_APBD,'0') AS COL_PEMAKAIAN_APBD,
		IFNULL(COL_STOKAKHIR_APBD,IFNULL((SELECT SUM(JUMLAH_STOK_OBAT) FROM apt_stok_obat 
		WHERE KD_OBAT=Z.KD_OBAT AND KD_MILIK_OBAT='PKM' AND KD_PKM='$pid'),0)) AS COL_STOKAKHIR_APBD, 
		IFNULL((SELECT R.HARGA_BELI FROM apt_mst_harga_obat R WHERE R.KD_OBAT=Z.KD_OBAT LIMIT 1),0) 
		AS HARGA_BELI,IFNULL((SELECT D.HARGA_JUAL FROM apt_mst_harga_obat D WHERE D.KD_OBAT=Z.KD_OBAT LIMIT 1),0) AS HARGA_JUAL
		FROM apt_stok_obat Z LEFT JOIN (

		SELECT

		A.KD_OBAT,  A.KD_MILIK_OBAT,
		SUM(IF(HEADER_STOKAWAL='STOKAWAL', A.QTY+IFNULL((SELECT SUM(JUMLAH_STOK_OBAT) FROM apt_stok_obat WHERE KD_OBAT=A.KD_OBAT AND KD_MILIK_OBAT='PKM' AND KD_PKM='$pid'),0)-IFNULL((SELECT SUM(DISTINCT c.JUMLAH_TERIMA) AS total FROM apt_obat_terima_detail c JOIN apt_obat_terima a ON a.`KD_TERIMA`=c.`KD_TERIMA` WHERE a.`UNIT_APT_FROM`='KABUPATEN' AND A.KD_OBAT=c.KD_OBAT AND (a.`TGL_TERIMA` BETWEEN '$from' AND '$to')),0),0)) AS `COL_STOKAWAL`,
		SUM(IF(HEADER='PENERIMAAN', IFNULL((SELECT SUM(DISTINCT c.JUMLAH_TERIMA) AS total FROM apt_obat_terima_detail c JOIN apt_obat_terima a ON a.`KD_TERIMA`=c.`KD_TERIMA` WHERE a.`UNIT_APT_FROM`='KABUPATEN' AND A.KD_OBAT=c.KD_OBAT AND (a.`TGL_TERIMA` BETWEEN '$from' AND '$to')),0),0)) AS `COL_PENERIMAAN_APBD`,
		SUM(IF(HEADER_PERSEDIAAN='PERSEDIAAN',  A.QTY+IFNULL((SELECT SUM(JUMLAH_STOK_OBAT) FROM apt_stok_obat WHERE KD_OBAT=A.KD_OBAT AND KD_MILIK_OBAT='PKM' AND KD_PKM='$pid'),0),0)) AS `COL_PERSEDIAAN_APBD`,
		SUM(IF(HEADER_PEMAKAIAN='PEMAKAIAN' , A.QTY,0)) AS `COL_PEMAKAIAN_APBD`,
		SUM(IF(HEADER_STOKAKHIR='STOKAKHIR' , (SELECT SUM(JUMLAH_STOK_OBAT) FROM apt_stok_obat WHERE KD_OBAT=A.KD_OBAT AND KD_MILIK_OBAT='PKM' AND KD_PKM='$pid'),0)) AS `COL_STOKAKHIR_APBD`
		FROM (
		SELECT V.KD_PUSKESMAS, V.KD_OBAT, V.NAMA_OBAT, V.KD_MILIK_OBAT
		,'STOKAWAL' AS `HEADER_STOKAWAL`
		,'PENERIMAAN' AS `HEADER`
		,'PERSEDIAAN' AS `HEADER_PERSEDIAAN`
		,'PEMAKAIAN' AS `HEADER_PEMAKAIAN`
		,'STOKAKHIR' AS `HEADER_STOKAKHIR`
		,SUM(QTY) AS `QTY` FROM vw_rpt_obat AS V WHERE (TGL_PELAYANAN BETWEEN '$from' AND '$to') AND V.KD_PUSKESMAS = '$pid'
		GROUP BY V.KD_PUSKESMAS, V.KD_OBAT, V.NAMA_OBAT, V.KD_MILIK_OBAT
		) A  GROUP BY
		A.KD_OBAT,  A.KD_MILIK_OBAT
		) P ON Z.`KD_OBAT`=P.KD_OBAT LEFT JOIN apt_mst_obat I ON I.KD_OBAT=Z.KD_OBAT WHERE Z.`KD_PKM` = '$pid' AND Z.`KD_MILIK_OBAT`='PKM' GROUP BY Z.`KD_OBAT`
		ORDER BY I.NAMA_OBAT;");//print_r($query);die;
		if($query->num_rows>0){
		$data = $query->result(); //print_r($data);die;
		
        if(!$data)
            return false;
 
        // Starting the PHPExcel library
        $this->load->library('Excel');
		$this->excel->getActiveSheet()->setTitle('LB2');
        $this->excel->getProperties()->setTitle("export")->setDescription("none");
		
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objPHPExcel = $objReader->load("tmp/laporan_lb2.xls");
		$objPHPExcel->setActiveSheetIndex(0);
		$rw=7;
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
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':J'.$rw)->applyFromArray($styleArray);

			$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$rw.':J'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			//$objPHPExcel->getActiveSheet()->getStyle('C'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->mergeCells('B'.$rw.':C'.$rw);
			$objPHPExcel->getActiveSheet()->setTitle('Data')
				->setCellValue('A'.$rw, $no)
				->setCellValue('B'.$rw, $value->NAMA_OBAT)
				->setCellValue('D'.$rw, $value->COL_STOKAWAL)
				->setCellValue('E'.$rw, $value->COL_PENERIMAAN_APBD)
				->setCellValue('F'.$rw, $value->COL_PERSEDIAAN_APBD)
				->setCellValue('G'.$rw, $value->COL_PEMAKAIAN_APBD)
				->setCellValue('H'.$rw, $value->COL_STOKAKHIR_APBD)
				->setCellValue('I'.$rw, $value->HARGA_BELI)
				->setCellValue('J'.$rw, $value->HARGA_JUAL);
			$rw++;
			$no++;
		}
		
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A'.($rw+2).':A'.($rw+4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':C'.$rw);
        $objPHPExcel->getActiveSheet()
			->setCellValue('C3', $value->KD_PUSKESMAS.'   '.$value->NAMA_PUSKESMAS)
			->setCellValue('C4', ($value->dt1).' s/d '.$value->dt2)
			->setCellValue('A'.($rw+2), 'Kepala Puskesmas')
			->setCellValue('A'.($rw+4), $value->KEPALA_PUSKESMAS);
		$filename='laporan_lb2'.date('_dmY_his').'.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
		}else{
			die('Tidak Ada Dalam Database');
		}
		
    }
	
	public function lb3_excel(){
	//print_r($_POST);die;
	
		
		$from = $this->input->get('from');	//print_r($from);die;
		$to = $this->input->get('to'); //print_r($to);die;
		$pid = $this->input->get('pid');
		$jenis = $this->input->get('jenis');
		$db = $this->load->database('sikda', TRUE);
		if($jenis=='rpt_lb3'){
			$query = array();
			//$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_uks a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'")->row();//print_r($data);die;
			$query[1] = $db->query("SELECT DATE_FORMAT('$from','%d-%m-%Y') as dt1, DATE_FORMAT('$to','%d-%m-%Y') as dt2, '$pid' AS KD_PUSKESMAS, (SELECT S.KEY_VALUE FROM sys_setting AS S WHERE S.KEY_DATA = 'NAMA_PUSKESMAS' AND PUSKESMAS='$pid' LIMIT 1) AS NAMA_PUSKESMAS, (SELECT S.KEY_VALUE FROM sys_setting AS S WHERE S.KEY_DATA = 'NAMA_PIMPINAN' AND PUSKESMAS='$pid' LIMIT 1) AS KEPALA_PUSKESMAS, (SELECT P.PROVINSI FROM sys_setting S INNER JOIN mst_provinsi P ON S.KEY_VALUE=P.KD_PROVINSI WHERE S.KEY_DATA = 'KD_PROV' AND S.PUSKESMAS='$pid' LIMIT 1) AS PROVINSI, (SELECT P.KABUPATEN FROM sys_setting S INNER JOIN mst_kabupaten P ON S.KEY_VALUE=P.KD_KABUPATEN WHERE S.KEY_DATA = 'KD_KABKOTA' AND S.PUSKESMAS='$pid' LIMIT 1) AS KABKOTA, (SELECT P.KECAMATAN FROM sys_setting S INNER JOIN mst_kecamatan P ON S.KEY_VALUE=P.KD_KECAMATAN WHERE S.KEY_DATA = 'KD_KEC' AND S.PUSKESMAS='$pid' LIMIT 1) AS KECAMATAN, '' AS 'PUSTU_YG_ADA', '' AS 'YANG_LAPOR', 'DARI PARAMETER PHP' AS 'TAHUN', '' AS 'NAMA_MENGETAHUI', '' AS 'NIP_MENGETAHUI', '' AS 'LOKASI', 'TANGGAL HARI INI' AS 'TANGGAL', '' AS 'NAMA_PELAPOR', '' AS 'NIP_PELAPOR', X.* FROM ( select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'A' as 'KELOMPOK', 'Gizi' as Program, 'Upaya Penanggulangan Kekurangan Vitamin A' as kegiatan, '' as Jumlah6, 1 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'A' as 'KELOMPOK','Gizi' as Program, 'Jumlah anak balita (1-5 th) dapat kapsul vit. A dosis tinggi (200.000 IU) bulan ini' as kegiatan, IFNULL ((SELECT COUNT( X.KD_PELAYANAN ) AS JUMLAH FROM (SELECT V.KD_PELAYANAN,V.KD_PUSKESMAS, V.KD_OBAT, l.KD_PASIEN FROM pel_ord_obat V INNER JOIN pelayanan l WHERE l.KD_PELAYANAN = V.KD_PELAYANAN) X INNER JOIN pasien p
			WHERE p.KD_PASIEN=X.KD_PASIEN AND X.KD_OBAT = '159' AND Get_Age(p.TGL_LAHIR) >= 1 AND Get_Age(p.TGL_LAHIR) < 6 AND X.KD_PUSKESMAS = '$pid'), IFNULL((SELECT SUM(ANAK_P_12_60_K_VIT_A)+SUM(ANAK_L_12_60_K_VIT_A) FROM t_ds_gizi WHERE BULAN=DATE_FORMAT('$from','%m') AND TAHUN=DATE_FORMAT('$from','%Y') AND kd_puskesmas='$pid'),0)) as Jumlah6, 2 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'A' as 'KELOMPOK','Gizi' as Program, 'Jumlah Ibu nifas (s/d 40 hr) dapat kapsul vit. A dosis tinggi (200.000 IU) bulan ini' as kegiatan, (SELECT
			COUNT(X.KD_PASIEN) as JML
			FROM (select V.KD_PASIEN, V.KD_PELAYANAN, V.KD_PUSKESMAS, V.VARIABEL_ID AS 'CL_CHILDVITA', '' AS 'CL_CHILDEXAMAGE',  V.HASIL  AS 'VITA' , '' AS AGE from pel_hasil_kia AS V
			WHERE V.KD_PUSKESMAS = '$pid'
			AND V.VARIABEL_ID = 'CL_PNCCAREVITA'
			AND V.HASIL = 'YA'
			 )X INNER JOIN pelayanan AS p
			WHERE p.KD_PELAYANAN = X.KD_PELAYANAN
			AND p.TGL_PELAYANAN BETWEEN '$from' AND '$to') as Jumlah6, 3 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'A' as 'KELOMPOK','Gizi' as Program, 'Jumlah bayi (6-11 th) dapat kapsul vit. A dosis tinggi (200.000 IU) bulan ini' as kegiatan, IFNULL ((SELECT COUNT( X.KD_PELAYANAN ) AS JUMLAH FROM (SELECT V.KD_PELAYANAN,V.KD_PUSKESMAS, V.KD_OBAT, l.KD_PASIEN FROM pel_ord_obat V INNER JOIN pelayanan l WHERE l.KD_PELAYANAN = V.KD_PELAYANAN) X INNER JOIN pasien p
			WHERE p.KD_PASIEN=X.KD_PASIEN AND X.KD_OBAT = '159' AND Get_Age(p.TGL_LAHIR) > 6 AND Get_Age(p.TGL_LAHIR) < 11 AND X.KD_PUSKESMAS = '$pid'),IFNULL((SELECT SUM(0)+SUM(0) FROM t_ds_gizi WHERE BULAN=DATE_FORMAT('$from','%m') AND TAHUN=DATE_FORMAT('$from','%Y') AND kd_puskesmas='$pid'),0)) as Jumlah6, 4 as iRow  ) X ");//print_r($query);die;
			
			$query[2] = $db->query("SELECT X.* FROM (select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Ibu hamil dapat tablet tambah darah (Fe) 30 tablet (Fe1) bulan ini' as kegiatan, IFNULL ((SELECT COUNT( X.KD_PELAYANAN ) AS Jumlah FROM (SELECT O.KD_PELAYANAN, O.KD_PUSKESMAS, O.KD_OBAT, O.JUMLAH, O.TANGGAL, L.KD_PASIEN FROM pel_ord_obat O INNER JOIN pelayanan L WHERE L.KD_PELAYANAN = O.KD_PELAYANAN )X
			INNER JOIN kunjungan_bumil K WHERE K.KD_PASIEN = X.KD_PASIEN AND X.KD_OBAT='541' AND X.JUMLAH='30' AND X.KD_PUSKESMAS='$pid' AND (K.TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')), IFNULL((SELECT SUM(IBU_HAMIL_TTD_FE_30) FROM t_ds_gizi WHERE BULAN=DATE_FORMAT('$from','%m') AND TAHUN=DATE_FORMAT('$from','%Y') AND kd_puskesmas='$pid'),0)) as Jumlah6, 1 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Ibu hamil dapat tablet tambah darah (Fe) 90 tablet (Fe2) bulan ini' as kegiatan, 
			IFNULL ((SELECT COUNT( X.KD_PELAYANAN ) AS Jumlah FROM (SELECT O.KD_PELAYANAN, O.KD_PUSKESMAS, O.KD_OBAT, O.JUMLAH, O.TANGGAL, L.KD_PASIEN FROM pel_ord_obat O INNER JOIN pelayanan L WHERE L.KD_PELAYANAN = O.KD_PELAYANAN )X
			INNER JOIN kunjungan_bumil K WHERE K.KD_PASIEN = X.KD_PASIEN AND X.KD_OBAT='541' AND X.JUMLAH='90' AND X.KD_PUSKESMAS='$pid' AND (K.TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')), IFNULL((SELECT SUM(IBU_HAMIL_TTD_FE_90) FROM t_ds_gizi WHERE BULAN=DATE_FORMAT('$from','%m') AND TAHUN=DATE_FORMAT('$from','%Y') AND kd_puskesmas='$pid'),0)) as Jumlah6, 2 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Balita diperiksa status anemia bulan ini' as kegiatan, '0'as Jumlah6, 3 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Balita yang diperiksa dengan status anemia < 11 gr % bulan ini' as kegiatan, '0'as Jumlah6, 4 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah WUS (15 - 45 th) diperiksa status anemia bulan ini' as kegiatan, IFNULL((SELECT COUNT(a.KD_PASIEN) AS total FROM vw_rpt_penyakitpasien_grp_old a WHERE a.SEX='P' AND (Get_Age(a.TGL_LAHIR) BETWEEN '15' AND '45') AND a.KD_PENYAKIT ='D64.9' AND (a.TGL_PELAYANAN BETWEEN '$from' AND '$to') GROUP BY a.KD_PASIEN),0) as Jumlah6, 5 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah WUS (15 - 45 th) yang diperiksa dengan status anemia < 11 gr % bulan ini' as kegiatan, IFNULL((SELECT COUNT(a.KD_PASIEN) AS total FROM vw_rpt_penyakitpasien_grp_old a WHERE a.SEX='P' AND (Get_Age(a.TGL_LAHIR) BETWEEN '15' AND '45') AND a.KD_PENYAKIT ='D64' AND (a.TGL_PELAYANAN BETWEEN '$from' AND '$to') GROUP BY a.KD_PASIEN),0) as Jumlah6, 6 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Remaja Putri (14 - 18 th) diperiksa status anemia bulan ini' as kegiatan, IFNULL((SELECT COUNT(a.KD_PASIEN) AS total FROM vw_rpt_penyakitpasien_grp_old a WHERE a.SEX='P' AND (Get_Age(a.TGL_LAHIR) BETWEEN '14' AND '18') AND a.KD_PENYAKIT ='D64.9' AND (a.TGL_PELAYANAN BETWEEN '$from' AND '$to') GROUP BY a.KD_PASIEN),0) as Jumlah6, 7 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Remaja Putri (14 - 18 th) yang diperiksa dengan status anemia < 11 gr % bulan ini' as kegiatan, IFNULL((SELECT COUNT(a.KD_PASIEN) AS total FROM vw_rpt_penyakitpasien_grp_old a WHERE a.SEX='P' AND (Get_Age(a.TGL_LAHIR) BETWEEN '14' AND '18') AND a.KD_PENYAKIT ='D64' AND (a.TGL_PELAYANAN BETWEEN '$from' AND '$to') GROUP BY a.KD_PASIEN),0) as Jumlah6, 8 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Tenaga Kerja Wanita (nakerwan) diperiksa status anemia bulan ini' as kegiatan, IFNULL((SELECT COUNT(a.KD_PASIEN) AS total FROM vw_rpt_penyakitpasien_grp_old a LEFT JOIN pasien b ON a.KD_PASIEN=b.KD_PASIEN WHERE a.SEX='P' AND (Get_Age(a.TGL_LAHIR) BETWEEN '15' AND '45') AND b.KD_PEKERJAAN NOT IN (NULL,'0','6','7','8','9','10') AND a.KD_PENYAKIT ='D64.9' AND (a.TGL_PELAYANAN BETWEEN '$from' AND '$to') GROUP BY a.KD_PASIEN),0) as Jumlah6, 9 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Tenaga Kerja Wanita (nakerwan) yang diperiksa dengan status anemia < 11 gr % bulan ini' as kegiatan, IFNULL((SELECT COUNT(a.KD_PASIEN) AS total FROM vw_rpt_penyakitpasien_grp_old a LEFT JOIN pasien b ON a.KD_PASIEN=b.KD_PASIEN WHERE a.SEX='P' AND (Get_Age(a.TGL_LAHIR) BETWEEN '15' AND '45') AND b.KD_PEKERJAAN NOT IN (NULL,'0','6','7','8','9','10') AND a.KD_PENYAKIT ='D64' AND (a.TGL_PELAYANAN BETWEEN '$from' AND '$to') GROUP BY a.KD_PASIEN),0) as Jumlah6, 10 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Ibu hamil diperiksa status anemia bulan ini' as kegiatan, IFNULL((SELECT COUNT(a.KD_PASIEN) AS total FROM vw_rpt_penyakitpasien_grp_old a LEFT JOIN pasien b ON a.KD_PASIEN=b.KD_PASIEN LEFT JOIN trans_kia z ON a.KD_PELAYANAN=z.KD_PELAYANAN WHERE a.SEX='P' AND z.KD_KATEGORI_KIA='1' AND z.KD_KUNJUNGAN_KIA='1' AND a.KD_PENYAKIT ='D64.9' AND (a.TGL_PELAYANAN BETWEEN '$from' AND '$to') GROUP BY a.KD_PASIEN),0) as Jumlah6, 11 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Ibu hamil yang diperiksa dengan status anemia < 11 gr % bulan ini' as kegiatan, IFNULL((SELECT COUNT(a.KD_PASIEN) AS total FROM vw_rpt_penyakitpasien_grp_old a LEFT JOIN pasien b ON a.KD_PASIEN=b.KD_PASIEN LEFT JOIN trans_kia z ON a.KD_PELAYANAN=z.KD_PELAYANAN WHERE a.SEX='P' AND z.KD_KATEGORI_KIA='1' AND z.KD_KUNJUNGAN_KIA='1' AND a.KD_PENYAKIT ='D64' AND (a.TGL_PELAYANAN BETWEEN '$from' AND '$to') GROUP BY a.KD_PASIEN),0) as Jumlah6, 12 as iRow) X");
			
			$query[3] = $db->query("SELECT X.* FROM (select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'C' as 'KELOMPOK',  'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita yang ada bulan ini' as kegiatan, IFNULL((SELECT SUM(r.BAYI_L_0_6_S)+SUM(r.BAYI_P_0_6_S)+SUM(r.BAYI_L_6_12_S)+SUM(r.BAYI_P_6_12_S)+SUM(r.ANAK_L_12_36_S)+SUM(r.ANAK_P_12_36_S)+SUM(r.ANAK_L_37_60_S)+SUM(r.ANAK_P_37_60_S) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 1 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'C' as 'KELOMPOK',  'Upaya Pemantauan Pertumbuhan Balita' as Program,  'Jumlah Balita yang mempunyai KMS bulan ini' as kegiatan, IFNULL((SELECT SUM(r.BAYI_L_0_12_KMS_K)+SUM(r.ANAK_L_12_36_KMS_K)+SUM(r.ANAK_L_37_60_KMS_K)+SUM(r.BAYI_P_0_12_KMS_K)+SUM(r.ANAK_P_12_36_KMS_K)+SUM(r.ANAK_P_37_60_KMS_K) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 2 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'C' as 'KELOMPOK',   'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita yang Naik berat badannya bulan ini' as kegiatan, IFNULL((SELECT SUM(r.BAYI_L_0_12_N)+SUM(r.ANAK_L_12_36_N)+SUM(r.ANAK_L_37_60_N)+SUM(r.BAYI_P_0_12_N)+SUM(r.ANAK_P_12_36_N)+SUM(r.ANAK_P_37_60_N) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 3 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'C' as 'KELOMPOK',  'Upaya Pemantauan Pertumbuhan Balita' as Program,  'Jumlah Balita yang Tidak naik/tetap berat badannya bulan ini' as kegiatan, IFNULL((SELECT (SUM(r.BAYI_L_0_12_D)+SUM(r.ANAK_L_12_36_D)+SUM(r.ANAK_L_37_60_D)+SUM(r.BAYI_P_0_12_D)+SUM(r.ANAK_P_12_36_D)+SUM(r.ANAK_P_37_60_D))-(SUM(r.BAYI_L_0_12_N)+SUM(r.ANAK_L_12_36_N)+SUM(r.ANAK_L_37_60_N)+SUM(r.BAYI_P_0_12_N)+SUM(r.ANAK_P_12_36_N)+SUM(r.ANAK_P_37_60_N)) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 4 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'C' as 'KELOMPOK',   'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita yang ditimbang bulan ini tetapi tidak ditimbang bulan lalu' as kegiatan, '0' as Jumlah6, 5 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'C' as 'KELOMPOK',  'Upaya Pemantauan Pertumbuhan Balita' as Program,  'Jumlah Balita yang Baru ditimbang bulan ini' as kegiatan, IFNULL((SELECT SUM(r.BAYI_L_PK_MENIMBANG_B1)+SUM(r.BAYI_P_PK_MENIMBANG_B1) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 6 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'C' as 'KELOMPOK',   'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita yang dapat ditimbang bulan ini' as kegiatan, IFNULL((SELECT SUM(r.BAYI_L_0_12_D)+SUM(r.ANAK_L_12_36_D)+SUM(r.ANAK_L_37_60_D)+SUM(r.BAYI_P_0_12_D)+SUM(r.ANAK_P_12_36_D)+SUM(r.ANAK_P_37_60_D) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 7 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'C' as 'KELOMPOK',   'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita yang tidak dapat ditimbang bulan ini' as kegiatan, '0' as Jumlah6, 8 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'C' as 'KELOMPOK',   'Upaya Pemantauan Pertumbuhan Balita' as Program, 'jumlah Balita dengan Berat badan di Bawah Garis Merah (BGM) bulan ini' as kegiatan, IFNULL((SELECT SUM(r.BAYI_L_BGM_MP_ASI)+SUM(r.BAYI_P_BGM_MP_ASI) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 9 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'C' as 'KELOMPOK',   'Upaya Pemantauan Pertumbuhan Balita' as Program,  'Jumlah Balita gizi buruk bulan ini' as kegiatan, IFNULL((SELECT SUM(r.BAYI_L_0_12_G_BURUK_WHO_NCS)+SUM(r.ANAK_L_12_36_G_BURUK)+SUM(r.BAYI_P_0_12_G_BURUK_WHO_NCS)+SUM(r.ANAK_P_12_36_G_BURUK) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 10 as iRow) X");
			
			$query[4] = $db->query("SELECT X.* FROM (select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'D' as 'KELOMPOK',   'Upaya Penanggulangan Gangguan Akibat Kekurangan Yodium (GAKY)' as Program,  'Jumlah penderita GAKY laki-laki bulan ini ' as kegiatan, '0'as Jumlah6, 1 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'D' as 'KELOMPOK',   'Upaya Penanggulangan Gangguan Akibat Kekurangan Yodium (GAKY)' as Program,  'Jumlah penderita GAKY perempuan bulan ini ' as kegiatan, IFNULL((SELECT SUM(r.P_GONDOK_P_G_0_WUS_BARU)+SUM(r.P_GONDOK_P_G_1_WUS_BARU)+SUM(r.P_GONDOK_P_G_2_WUS_BARU)+SUM(r.P_GONDOK_P_G_0_WUS_LAMA)+SUM(r.P_GONDOK_P_G_1_WUS_LAMA)+SUM(r.P_GONDOK_P_G_2_WUS_LAMA) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 2 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'D' as 'KELOMPOK',   'Upaya Penanggulangan Gangguan Akibat Kekurangan Yodium (GAKY)' as Program,  'Jumlah ibu hamil mendapat kapsul yodium ' as kegiatan, IFNULL((SELECT SUM(r.JML_WUS_KEL_ENDEMIS_SB_YODIUM) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 3 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'D' as 'KELOMPOK',   'Upaya Penanggulangan Gangguan Akibat Kekurangan Yodium (GAKY)' as Program,  'Jumlah penduduk lainnya mendapat kapsul yodium ' as kegiatan, '0'as Jumlah6, 4 as iRow) X");
			
			$query[5] = $db->query("SELECT X.* FROM (select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'E' as 'KELOMPOK',   'Upaya Penanggulangan Kekurangan Energi Kronis (KEK)' as Program,  'Jumlah Ibu hamil baru, diukur LILA (Lingkar Lengan Atas) bulan ini ' as kegiatan, '0'as Jumlah6, 1 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'E' as 'KELOMPOK',   'Upaya Penanggulangan Kekurangan Energi Kronis (KEK)' as Program,  'Jumlah Ibu hamil baru, dengan LILA < 23,5 cm bulan ini ' as kegiatan, '0'as Jumlah6, 2 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'E' as 'KELOMPOK',   'Upaya Penanggulangan Kekurangan Energi Kronis (KEK)' as Program,  'Jumlah WUS baru, yang diukur LILA (Lingkar Lengan Atas) bulan ini ' as kegiatan, '0'as Jumlah6, 3 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'E' as 'KELOMPOK',   'Upaya Penanggulangan Kekurangan Energi Kronis (KEK)' as Program,  'Jumlah WUS baru, dengan LILA < 23,5 cm bulan ini ' as kegiatan, '0'as Jumlah6,  4 as iRow) X");
			$query[6] = $db->query("SELECT X.* FROM (
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'Jumlah kunjungan K1 Bumil ' as kegiatan, IFNULL((SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil WHERE kunjungan_ke='K1' AND kd_puskesmas='$pid' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')),0)as Jumlah6,  1 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'Jumlah kunjungan Bumil lama ' as kegiatan, ''as Jumlah6,  2 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'K2' as kegiatan, IFNULL((SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil WHERE kunjungan_ke='K2' AND kd_puskesmas='$pid' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')),0)as Jumlah6,  3 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'K3' as kegiatan, IFNULL((SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil WHERE kunjungan_ke='K3' AND kd_puskesmas='$pid' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')),0)as Jumlah6,  4 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'K4' as kegiatan, IFNULL((SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil WHERE kunjungan_ke='K4' AND kd_puskesmas='$pid' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')),0)as Jumlah6,  5 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'Kunjungan Bumil dengan faktor risiko : ' as kegiatan, ''as Jumlah6,  6 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'a. < 20 th ' as kegiatan, IFNULL((SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil  w LEFT JOIN pasien e ON w.KD_PASIEN=e.KD_PASIEN WHERE Get_Age_Tahun(e.TGL_LAHIR) < 20 AND w.kd_puskesmas='$pid' AND (w.TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')),0)as Jumlah6,  7 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'b. > 35 th  ' as kegiatan, IFNULL((SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil  w LEFT JOIN pasien e ON w.KD_PASIEN=e.KD_PASIEN WHERE Get_Age_Tahun(e.TGL_LAHIR) > 35 AND w.kd_puskesmas='$pid' AND (w.TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')),0)as Jumlah6,  8 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'c. Spacing < 2 th  ' as kegiatan, IFNULL((SELECT COUNT(trans_imunisasi.KD_PASIEN) AS jumlah FROM trans_imunisasi WHERE trans_imunisasi.JARAK_KEHAMILAN != '' AND trans_imunisasi.JARAK_KEHAMILAN <2 AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='6' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6,  9 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'd. Paritas > 5 th ' as kegiatan, '0'as Jumlah6,  10 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'e. HB 11 gram %' as kegiatan, '0'as Jumlah6,  11 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'f. BB Kg Triwulan III < 45 Kg ' as kegiatan, IFNULL((SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil WHERE BERAT_BADAN<'45' AND UMUR_KEHAMILAN>'24' AND kd_puskesmas='$pid' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')),0) as Jumlah6,  12 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'g. TB < 145 cm' as kegiatan, IFNULL((SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil WHERE TINGGI_BADAN<'145' AND kd_puskesmas='$pid' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')),0) as Jumlah6,  13 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'Imunisasi TT Bumil (TT1, TT2) : ' as kegiatan, ''as Jumlah6,  14 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'a. TT1 ' as kegiatan, IFNULL((SELECT COUNT(trans_imunisasi.KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='9' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='6' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')), IFNULL((SELECT SUM(r.JML_P_S_IMUNISASI_TT1) AS jumlah FROM t_ds_kematian_ibu r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0)) as Jumlah6,  15 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'b. TT2  ' as kegiatan, IFNULL((SELECT COUNT(trans_imunisasi.KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='10' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='6' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')), IFNULL((SELECT SUM(r.JML_P_S_IMUNISASI_TT2) AS jumlah FROM t_ds_kematian_ibu r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0)) as Jumlah6,  16 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'Pemberian tablet Fe Bumil : ' as kegiatan, ''as Jumlah6,  17 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'a. Fe1 ' as kegiatan, IFNULL ((SELECT COUNT( X.KD_PELAYANAN ) AS Jumlah FROM (SELECT O.KD_PELAYANAN, O.KD_PUSKESMAS, O.KD_OBAT, O.JUMLAH, O.TANGGAL, L.KD_PASIEN FROM pel_ord_obat O INNER JOIN pelayanan L WHERE L.KD_PELAYANAN = O.KD_PELAYANAN )X
			INNER JOIN kunjungan_bumil K WHERE K.KD_PASIEN = X.KD_PASIEN AND X.KD_OBAT='541' AND X.JUMLAH='30' AND X.KD_PUSKESMAS='$pid' AND (K.TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')), IFNULL((SELECT SUM(IBU_HAMIL_TTD_FE_30) FROM t_ds_gizi WHERE BULAN=DATE_FORMAT('$from','%m') AND TAHUN=DATE_FORMAT('$from','%Y') AND kd_puskesmas='$pid'),0)) as Jumlah6,  18 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'b. Fe2  ' as kegiatan, IFNULL ((SELECT COUNT( X.KD_PELAYANAN ) AS Jumlah FROM (SELECT O.KD_PELAYANAN, O.KD_PUSKESMAS, O.KD_OBAT, O.JUMLAH, O.TANGGAL, L.KD_PASIEN FROM pel_ord_obat O INNER JOIN pelayanan L WHERE L.KD_PELAYANAN = O.KD_PELAYANAN )X
			INNER JOIN kunjungan_bumil K WHERE K.KD_PASIEN = X.KD_PASIEN AND X.KD_OBAT='541' AND X.JUMLAH='90' AND X.KD_PUSKESMAS='$pid' AND (K.TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')), IFNULL((SELECT SUM(IBU_HAMIL_TTD_FE_90) FROM t_ds_gizi WHERE BULAN=DATE_FORMAT('$from','%m') AND TAHUN=DATE_FORMAT('$from','%Y') AND kd_puskesmas='$pid'),0)) as Jumlah6,  19 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'c. Fe3' as kegiatan, '0'as Jumlah6,  20 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'Jumlah kesakitan dan kematian Bumil yang ditangani : ' as kegiatan, ''as Jumlah6,  21 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'a. Pendarahan  ' as kegiatan, IFNULL((SELECT SUM(r.JML_SK_PENDARAHAN) AS jumlah FROM t_ds_kematian_ibu r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6,  22 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'b. Infeksi jalan lahir  ' as kegiatan, '0'as Jumlah6,  23 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'c. Preeklamasi/Eklamsi  ' as kegiatan, IFNULL ((SELECT SUM((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN)X
					WHERE X.KD_PENYAKIT ='o15' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to'))+(SELECT COUNT(X.KD_PELAYANAN) as JML2
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN)X
					WHERE X.KD_PENYAKIT LIKE 'o14.%' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to'))+(SELECT COUNT(X.KD_PELAYANAN) as JML3
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN)X
					WHERE X.KD_PENYAKIT ='o13' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to'))) ), IFNULL((SELECT SUM(r.JML_SK_EKLAMSI) AS jumlah FROM t_ds_kematian_ibu r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0)) as Jumlah6,  24 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'd. Sebab lain  ' as kegiatan, IFNULL((SELECT SUM(r.JML_SK_LAIN_LAIN) AS jumlah FROM t_ds_kematian_ibu r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6,  25 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'Deteksi resti bumil oleh nakes ' as kegiatan, IFNULL((SELECT SUM(r.JML_KJ_BR_R_NAKES) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6,  26 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'Deteksi resti bumil oleh masyarakat ' as kegiatan, IFNULL((SELECT SUM(r.JML_KJ_BR_R_MASYARAKAT) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0)as Jumlah6,  27 as iRow) X");
			
			$query[7] = $db->query("SELECT X.* FROM (select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  'Persalinan ' as kegiatan, ''as Jumlah6,  1 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  'a. < 20 tahun ' as kegiatan, IFNULL((SELECT COUNT(*) AS TOTAL
			FROM kunjungan_bersalin w LEFT JOIN pasien e ON w.KD_PASIEN=e.KD_PASIEN WHERE Get_Age(e.TGL_LAHIR) < 20 AND e.kd_puskesmas='$pid' AND (w.TANGGAL_PERSALINAN BETWEEN '$from' AND '$to')),0) as Jumlah6,  2 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  'b.  20 - 24 tahun ' as kegiatan, IFNULL((SELECT COUNT(*) AS TOTAL
			FROM kunjungan_bersalin w LEFT JOIN pasien e ON w.KD_PASIEN=e.KD_PASIEN WHERE (Get_Age(e.TGL_LAHIR) BETWEEN '20' AND '24') AND e.kd_puskesmas='$pid' AND (w.TANGGAL_PERSALINAN BETWEEN '$from' AND '$to')),0) as Jumlah6,  3 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  'c. 25 - 29 tahun ' as kegiatan, IFNULL((SELECT COUNT(*) AS TOTAL
			FROM kunjungan_bersalin w LEFT JOIN pasien e ON w.KD_PASIEN=e.KD_PASIEN WHERE (Get_Age(e.TGL_LAHIR) BETWEEN '25' AND '29') AND e.kd_puskesmas='$pid' AND (w.TANGGAL_PERSALINAN BETWEEN '$from' AND '$to')),0) as Jumlah6,  4 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  'd. 30 - 34 tahun ' as kegiatan, IFNULL((SELECT COUNT(*) AS TOTAL
			FROM kunjungan_bersalin w LEFT JOIN pasien e ON w.KD_PASIEN=e.KD_PASIEN WHERE (Get_Age(e.TGL_LAHIR) BETWEEN '30' AND '34') AND e.kd_puskesmas='$pid' AND (w.TANGGAL_PERSALINAN BETWEEN '$from' AND '$to')),0) as Jumlah6,  5 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  'e. > 35 tahun ' as kegiatan, IFNULL((SELECT COUNT(*) AS TOTAL
			FROM kunjungan_bersalin w LEFT JOIN pasien e ON w.KD_PASIEN=e.KD_PASIEN WHERE Get_Age(e.TGL_LAHIR) > '35' AND e.kd_puskesmas='$pid' AND (w.TANGGAL_PERSALINAN BETWEEN '$from' AND '$to')),0) as Jumlah6,  6 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  'Jumlah persalinan ditolong oleh Nakes  ' as kegiatan, IFNULL((SELECT COUNT(KD_PASIEN) AS TOTAL
			FROM kunjungan_bersalin WHERE SUBSTR(KD_PASIEN,1,11)='$pid' AND (TANGGAL_PERSALINAN BETWEEN '$from' AND '$to')), IFNULL((SELECT SUM(r.JML_P_IB_T_KESEHATAN) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0)) as Jumlah6,  7 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  '- Lahir hidup ' as kegiatan, IFNULL((SELECT COUNT(KD_PASIEN) AS TOTAL
			FROM kunjungan_bersalin w LEFT JOIN detail_keadaan_bayi e ON w.KD_KUNJUNGAN_BERSALIN=e.KD_KUNJUNGAN_BERSALIN WHERE e.KD_KEADAAN_BAYI_LAHIR != '3' AND SUBSTR(w.KD_PASIEN,1,11)='$pid' AND (w.TANGGAL_PERSALINAN BETWEEN '$from' AND '$to')), IFNULL((SELECT SUM(r.B_N_L_HIDUP)+SUM(r.B_N_L_HIDUP_p) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0)) as Jumlah6,  8 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  '- Lahir mati ' as kegiatan, IFNULL((SELECT COUNT(KD_PASIEN) AS TOTAL
			FROM kunjungan_bersalin w LEFT JOIN detail_keadaan_bayi e ON w.KD_KUNJUNGAN_BERSALIN=e.KD_KUNJUNGAN_BERSALIN WHERE e.KD_KEADAAN_BAYI_LAHIR = '3' AND SUBSTR(w.KD_PASIEN,1,11)='$pid' AND (w.TANGGAL_PERSALINAN BETWEEN '$from' AND '$to')), IFNULL((SELECT SUM(r.B_N_L_MATI)+SUM(r.B_N_L_MATI_p) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0)) as Jumlah6,  9 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  '- BBLR (BB < 2500 gram) ' as kegiatan, IFNULL((SELECT COUNT(KD_PASIEN) AS TOTAL
			FROM kunjungan_bersalin WHERE BERAT_LAHIR < '2500' AND SUBSTR(KD_PASIEN,1,11)='$pid' AND (TANGGAL_PERSALINAN BETWEEN '$from' AND '$to')), IFNULL((SELECT SUM(r.JML_B_N_BBL_K_2500GR)+SUM(r.JML_B_N_BBL_K_2500GR_p) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0)) as Jumlah6,  10 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  'Jumlah persalinan dukun didampingi oleh Nakes : ' as kegiatan, ''as Jumlah6,  11 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  '- Lahir hidup ' as kegiatan, '0'as Jumlah6,  12 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  '- Lahir mati ' as kegiatan, '0'as Jumlah6,  13 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  '- BBLR (BB < 2500 gram) ' as kegiatan, '0'as Jumlah6,  14 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  'Jumlah persalinan ditolong oleh dukun terlatih/tidak telatih : ' as kegiatan, ''as Jumlah6,  15 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  '- Lahir hidup ' as kegiatan, '0'as Jumlah6,  16 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  '- Lahir mati ' as kegiatan, '0'as Jumlah6,  17 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  '- BBLR (BB < 2500 gram) ' as kegiatan, '0'as Jumlah6,  18 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  'Kunjungan Neonatus  ' as kegiatan, ''as Jumlah6,  19 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  '- 0 - 7 hari ' as kegiatan, IFNULL((SELECT COUNT(KD_PUSKESMAS) AS TOTAL
			FROM pemeriksaan_neonatus WHERE KUNJUNGAN_KE != 'KN3' AND KD_PUSKESMAS='$pid' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')), IFNULL((SELECT SUM(r.JML_KJ_N_BR_0_7HARI_KN1)+SUM(r.JML_KJ_N_BR_0_7HARI_KN1_p) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0)) as Jumlah6,  20 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  '- 7 - 28 hari ' as kegiatan, IFNULL((SELECT COUNT(KD_PUSKESMAS) AS TOTAL
			FROM pemeriksaan_neonatus WHERE KUNJUNGAN_KE = 'KN3' AND KD_PUSKESMAS='$pid' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')), IFNULL((SELECT SUM(r.JML_KJ_N_BR_8_28HARI_KN2)+SUM(r.JML_KJ_N_BR_8_28HARI_KN2_p) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0)) as Jumlah6,  21 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  'Jumlah kesakitan dan kematian ibu bersalin ditangani ' as kegiatan, ''as Jumlah6,  22 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  '- Pendarahan ' as kegiatan, '0'as Jumlah6,  23 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  '- Infeksi jalan lahir ' as kegiatan, '0'as Jumlah6,  24 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  '- Preeklamsi/Eklamsi ' as kegiatan, IFNULL ((SELECT SUM((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN)X
					WHERE X.KD_PENYAKIT ='o15' AND X.KD_KATEGORI_KIA='2' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to'))+(SELECT COUNT(X.KD_PELAYANAN) as JML2
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN)X
					WHERE X.KD_PENYAKIT LIKE 'o14.%' AND X.KD_KATEGORI_KIA='2' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to'))+(SELECT COUNT(X.KD_PELAYANAN) as JML3
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN)X
					WHERE X.KD_PENYAKIT ='o13' AND X.KD_KATEGORI_KIA='2' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to'))) ),0) as Jumlah6,  25 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  '- Sebab lain ' as kegiatan, '0'as Jumlah6,  26 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  'Jumlah kesakitan dan kematian ibu nifas ditangani ' as kegiatan, ''as Jumlah6,  27 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  '- Pendarahan ' as kegiatan, '0'as Jumlah6,  28 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  '- Infeksi jalan lahir ' as kegiatan, '0'as Jumlah6,  29 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  '- Preeklamsi/Eklamsi ' as kegiatan, IFNULL ((SELECT SUM((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN)X
					WHERE X.KD_PENYAKIT ='o15' AND X.KD_KATEGORI_KIA='3' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to'))+(SELECT COUNT(X.KD_PELAYANAN) as JML2
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN)X
					WHERE X.KD_PENYAKIT LIKE 'o14.%' AND X.KD_KATEGORI_KIA='3' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to'))+(SELECT COUNT(X.KD_PELAYANAN) as JML3
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN)X
					WHERE X.KD_PENYAKIT ='o13' AND X.KD_KATEGORI_KIA='3' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to'))) ),0) as Jumlah6,  30 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'G' as 'KELOMPOK',   'Pelayanan Persalinan' as Program,  '- Sebab lain ' as kegiatan, '0'as Jumlah6,  31 as iRow) X");
			
			$query[8] = $db->query("SELECT X.* FROM (select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'H' as 'KELOMPOK',   'Pelayanan Ibu Menyusui ' as Program,  'Kunjungan baru ' as kegiatan, '0'as Jumlah6,  1 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'H' as 'KELOMPOK',   'Pelayanan Ibu Menyusui ' as Program,  'Kunjungan lama ' as kegiatan, '0'as Jumlah6,  2 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'H' as 'KELOMPOK',   'Pelayanan Ibu Menyusui ' as Program,  'Akseptor baru Buteki ' as kegiatan, IFNULL((SELECT SUM(r.AKS_BDAK_MOP)+SUM(r.AKS_BDAK_MOW)+SUM(r.AKS_BDAK_IMPLANT)+SUM(r.AKS_BDAK_IUD)+SUM(r.AKS_BDAK_SUNTIK)+SUM(r.AKS_BDAK_PIL)+SUM(r.AKS_BDAK_KONDOM) AS jumlah FROM t_ds_kb r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6,  3 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'H' as 'KELOMPOK',   'Pelayanan Ibu Menyusui ' as Program,  'Akseptor aktif Buteki ' as kegiatan, IFNULL((SELECT SUM(r.AKS_UDAK_IMPLANT)+SUM(r.AKS_UDAK_IUD)+SUM(r.AKS_UDAK_SUNTIK)+SUM(r.AKS_UDAK_PIL)+SUM(r.AKS_UDAK_KONDOM) AS jumlah FROM t_ds_kb r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6,  4 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'H' as 'KELOMPOK',   'Pelayanan Ibu Menyusui ' as Program,  'Akseptor aktif seluruh (CU) ' as kegiatan, IFNULL((SELECT SUM(r.AKS_ADA_MOP)+SUM(r.AKS_ADA_MOW)+SUM(r.AKS_ADA_IMPLANT)+SUM(r.AKS_ADA_IUD)+SUM(r.AKS_ADA_SUNTIK)+SUM(r.AKS_ADA_PIL)+SUM(r.AKS_ADA_KONDOM) AS jumlah FROM t_ds_kb r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6,  5 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'H' as 'KELOMPOK',   'Pelayanan Ibu Menyusui ' as Program,  'Buteki dapat Fe ' as kegiatan, '0'as Jumlah6,  6 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'H' as 'KELOMPOK',   'Pelayanan Ibu Menyusui ' as Program,  'Buteki dapat Vitamin A dosis tinggi ' as kegiatan, '0'as Jumlah6,  7 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'H' as 'KELOMPOK',   'Pelayanan Ibu Menyusui ' as Program,  'ASI Eksklusif 0 - 6 bulan ' as kegiatan, '0'as Jumlah6,  8 as iRow) X");
			
			$query[9] = $db->query("SELECT X.* FROM (select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'I' as 'KELOMPOK',   'Pelayanan Bayi ' as Program,  'Kunjungan baru diperiksa ' as kegiatan, IFNULL((SELECT COUNT(*) AS jumlah FROM (SELECT pel.KD_PELAYANAN FROM pelayanan pel LEFT JOIN pel_diagnosa d ON pel.KD_PELAYANAN=d.KD_PELAYANAN JOIN trans_kia tk ON tk.KD_PELAYANAN=pel.KD_PELAYANAN WHERE d.JNS_KASUS='Baru' AND pel.KEADAAN_KELUAR='DILAYANI' AND (pel.TGL_PELAYANAN BETWEEN '$from' AND '$to') AND pel.KD_PUSKESMAS='$pid' AND tk.KD_KATEGORI_KIA='2' GROUP BY tk.KD_PELAYANAN) ss),0) as Jumlah6,  1 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'I' as 'KELOMPOK',   'Pelayanan Bayi ' as Program,  'Kunjungan baru dirujuk' as kegiatan, IFNULL((SELECT COUNT(*) AS jumlah FROM (SELECT pel.KD_PELAYANAN FROM pelayanan pel LEFT JOIN pel_diagnosa d ON pel.KD_PELAYANAN=d.KD_PELAYANAN JOIN trans_kia tk ON tk.KD_PELAYANAN=pel.KD_PELAYANAN WHERE d.JNS_KASUS='Baru' AND pel.KEADAAN_KELUAR='DIRUJUK' AND (pel.TGL_PELAYANAN BETWEEN '$from' AND '$to') AND pel.KD_PUSKESMAS='$pid' AND tk.KD_KATEGORI_KIA='2' GROUP BY tk.KD_PELAYANAN) ss),0) as Jumlah6,  2 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'I' as 'KELOMPOK',   'Pelayanan Bayi ' as Program,  'Kunjungan lama diperiksa' as kegiatan, IFNULL((SELECT COUNT(*) AS jumlah FROM (SELECT pel.KD_PELAYANAN FROM pelayanan pel LEFT JOIN pel_diagnosa d ON pel.KD_PELAYANAN=d.KD_PELAYANAN JOIN trans_kia tk ON tk.KD_PELAYANAN=pel.KD_PELAYANAN WHERE d.JNS_KASUS='Lama' AND pel.KEADAAN_KELUAR='DILAYANI' AND (pel.TGL_PELAYANAN BETWEEN '$from' AND '$to') AND pel.KD_PUSKESMAS='$pid' AND tk.KD_KATEGORI_KIA='2' GROUP BY tk.KD_PELAYANAN) ss),0) as Jumlah6,  3 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'I' as 'KELOMPOK',   'Pelayanan Bayi ' as Program,  'Kunjungan lama dirujuk' as kegiatan, IFNULL((SELECT COUNT(*) AS jumlah FROM (SELECT pel.KD_PELAYANAN FROM pelayanan pel LEFT JOIN pel_diagnosa d ON pel.KD_PELAYANAN=d.KD_PELAYANAN JOIN trans_kia tk ON tk.KD_PELAYANAN=pel.KD_PELAYANAN WHERE d.JNS_KASUS='Lama' AND pel.KEADAAN_KELUAR='DIRUJUK' AND (pel.TGL_PELAYANAN BETWEEN '$from' AND '$to') AND pel.KD_PUSKESMAS='$pid' AND tk.KD_KATEGORI_KIA='2' GROUP BY tk.KD_PELAYANAN) ss),0) as Jumlah6,  4 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'I' as 'KELOMPOK',   'Pelayanan Bayi ' as Program,  'Jumlah kesakitan dan kematian Perinatal (0 - 7 hari) ' as kegiatan, ''as Jumlah6,  5 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'I' as 'KELOMPOK',   'Pelayanan Bayi ' as Program,  '- BBLR ' as kegiatan, IFNULL((SELECT SUM(s.JML_B_N_BBL_K_2500GR+s.JML_B_N_BBL_K_2500GR_p) AS jumlah FROM t_ds_kia s WHERE s.BULAN=DATE_FORMAT('$from','%m') AND s.TAHUN=DATE_FORMAT('$from','%Y') AND s.KD_PUSKESMAS='$pid'),0) as Jumlah6,  6 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'I' as 'KELOMPOK',   'Pelayanan Bayi ' as Program,  '- Tetanus Neonatorum ' as kegiatan, IFNULL ((SELECT COUNT( X.KD_PELAYANAN ) AS JUMLAH FROM (SELECT V.KD_PELAYANAN,V.KD_PUSKESMAS, V.KD_PENYAKIT, l.KD_PASIEN FROM pel_diagnosa V INNER JOIN pelayanan l WHERE l.KD_PELAYANAN = V.KD_PELAYANAN) X INNER JOIN pasien p
			WHERE p.KD_PASIEN=X.KD_PASIEN AND X.KD_PENYAKIT = 'A33' AND Get_Age_hari(p.TGL_LAHIR) <8 AND X.KD_PUSKESMAS = '$pid'),0) as Jumlah6,  7 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'I' as 'KELOMPOK',   'Pelayanan Bayi ' as Program,  '- BBLR dirujuk ke RSU ' as kegiatan, IFNULL((SELECT (SUM(s.N_R_DRJ_RS)+SUM(s.N_R_DRJ_RS_p)) AS jumlah FROM t_ds_kia s WHERE s.BULAN=DATE_FORMAT('$from','%m') AND s.TAHUN=DATE_FORMAT('$from','%Y') AND s.KD_PUSKESMAS='$pid'),0) as Jumlah6,  8 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'I' as 'KELOMPOK',   'Pelayanan Bayi ' as Program,  '- Tetanus Neonatorum dirujuk ke RSU ' as kegiatan, '0'as Jumlah6,  9 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'I' as 'KELOMPOK',   'Pelayanan Bayi ' as Program,  '- Oleh sebab lain  ' as kegiatan, '0'as Jumlah6,  10 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'I' as 'KELOMPOK',   'Pelayanan Bayi ' as Program,  'Jumlah kesakitan dan kematian Perinatal (8 - 28 hari) ' as kegiatan, ''as Jumlah6,  11 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'I' as 'KELOMPOK',   'Pelayanan Bayi ' as Program,  '- BBLR ' as kegiatan, ''as Jumlah6,  12 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'I' as 'KELOMPOK',   'Pelayanan Bayi ' as Program,  '- Tetanus Neonatorum ' as kegiatan, IFNULL ((SELECT COUNT( X.KD_PELAYANAN ) AS JUMLAH FROM (SELECT V.KD_PELAYANAN,V.KD_PUSKESMAS, V.KD_PENYAKIT, l.KD_PASIEN FROM pel_diagnosa V INNER JOIN pelayanan l WHERE l.KD_PELAYANAN = V.KD_PELAYANAN) X INNER JOIN pasien p
			WHERE p.KD_PASIEN=X.KD_PASIEN AND X.KD_PENYAKIT = 'A33' AND Get_Age_hari(p.TGL_LAHIR) >7 AND Get_Age_hari(p.TGL_LAHIR) <29 AND X.KD_PUSKESMAS = '$pid'),0) as Jumlah6,  13 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'I' as 'KELOMPOK',   'Pelayanan Bayi ' as Program,  '- BBLR dirujuk ke RSU ' as kegiatan, '0'as Jumlah6,  14 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'I' as 'KELOMPOK',   'Pelayanan Bayi ' as Program,  '- Tetanus Neonatorum dirujuk ke RSU' as kegiatan, '0'as Jumlah6,  15 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'I' as 'KELOMPOK',   'Pelayanan Bayi ' as Program,  '- Oleh sebab lain ' as kegiatan, '0'as Jumlah6,  16 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'I' as 'KELOMPOK',   'Pelayanan Bayi ' as Program,  'Jumlah kesakitan dan kematian Perinatal (28 hari - 1 tahun) ' as kegiatan, ''as Jumlah6,  17 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'I' as 'KELOMPOK',   'Pelayanan Bayi ' as Program,  '- BBLR ' as kegiatan, '0'as Jumlah6,  18 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'I' as 'KELOMPOK',   'Pelayanan Bayi ' as Program,  '- Tetanus Neonatorum ' as kegiatan, IFNULL ((SELECT COUNT( X.KD_PELAYANAN ) AS JUMLAH FROM (SELECT V.KD_PELAYANAN,V.KD_PUSKESMAS, V.KD_PENYAKIT, l.KD_PASIEN FROM pel_diagnosa V INNER JOIN pelayanan l WHERE l.KD_PELAYANAN = V.KD_PELAYANAN) X INNER JOIN pasien p
			WHERE p.KD_PASIEN=X.KD_PASIEN AND X.KD_PENYAKIT = 'A33' AND Get_Age_hari(p.TGL_LAHIR) >28 AND Get_Age_Tahun(p.TGL_LAHIR) <1 AND X.KD_PUSKESMAS = '$pid'),0) as Jumlah6,  19 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'I' as 'KELOMPOK',   'Pelayanan Bayi ' as Program,  '- BBLR dirujuk ke RSU ' as kegiatan, '0'as Jumlah6,  20 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'I' as 'KELOMPOK',   'Pelayanan Bayi ' as Program,  '- Tetanus Neonatorum dirujuk ke RSU ' as kegiatan, '0'as Jumlah6,  21 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'I' as 'KELOMPOK',   'Pelayanan Bayi ' as Program,  '- Oleh sebab lain ' as kegiatan, '0'as Jumlah6,  22 as iRow) X");
			
			$query[10] = $db->query("SELECT X.* FROM (select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'J' as 'KELOMPOK',   'Pelayanan Anak Balita' as Program,  'Kunjungan baru diperiksa ' as kegiatan, '0'as Jumlah6,  1 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'J' as 'KELOMPOK',   'Pelayanan Anak Balita' as Program,  'Kunjungan baru drujuk ' as kegiatan, '0'as Jumlah6,  2 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'J' as 'KELOMPOK',   'Pelayanan Anak Balita' as Program,  'Kunjungan lama diperiksa ' as kegiatan, '0'as Jumlah6,  3 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'J' as 'KELOMPOK',   'Pelayanan Anak Balita' as Program,  'Kunjungan lama dirujuk ' as kegiatan, '0'as Jumlah6,  4 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'J' as 'KELOMPOK',   'Pelayanan Anak Balita' as Program,  'Jumlah kesakitan dan kematian anak balita ' as kegiatan, '0'as Jumlah6,  5 as iRow) X");
			
			$query[11] = $db->query("SELECT X.* FROM (select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'K' as 'KELOMPOK',   'IMUNISASI ' as Program,  'Jumlah bayi divaksinasi campak  ' as kegiatan, IFNULL((SELECT COUNT(trans_imunisasi.KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='10' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='3' AND trans_imunisasi.IMUNISASI_LUAR_GEDUNG='0' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),IFNULL((SELECT SUM(d.JML_IMUN_CAMPAK_L+d.JML_IMUN_CAMPAK_P) AS jumlah FROM t_ds_imunisasi d WHERE d.BULAN=DATE_FORMAT('$to','%m') AND d.TAHUN=DATE_FORMAT('$to','%Y') AND d.KD_PUSKESMAS='$pid'),0)) as Jumlah6,  1 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'K' as 'KELOMPOK',   'IMUNISASI ' as Program,  'Jumlah bayi divaksinasi DPT I ' as kegiatan, IFNULL((SELECT COUNT(trans_imunisasi.KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='5' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='3' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),IFNULL((SELECT SUM(d.JML_IMUN_DPT1_L+d.JML_IMUN_DPT1_P) AS jumlah FROM t_ds_imunisasi d WHERE d.BULAN=DATE_FORMAT('$to','%m') AND d.TAHUN=DATE_FORMAT('$to','%Y') AND d.KD_PUSKESMAS='$pid'),0)) as Jumlah6,  2 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'K' as 'KELOMPOK',   'IMUNISASI ' as Program,  'Jumlah bayi 0 - 7 hari divaksinasi hepatitis B ' as kegiatan, IFNULL((SELECT COUNT(trans_imunisasi.KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI JOIN pasien ON pasien.KD_PASIEN=trans_imunisasi.KD_PASIEN WHERE pel_imunisasi.KD_JENIS_IMUNISASI='8' AND trans_imunisasi.KD_JENIS_PASIEN='3' AND Get_Age_hari(pasien.TGL_LAHIR) <8 AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),IFNULL((SELECT SUM(d.JML_IMUN_HBU_M7_L+d.JML_IMUN_HBU_M7_P) AS jumlah FROM t_ds_imunisasi d WHERE d.BULAN=DATE_FORMAT('$to','%m') AND d.TAHUN=DATE_FORMAT('$to','%Y') AND d.KD_PUSKESMAS='$pid'),0)) as Jumlah6,  3 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'K' as 'KELOMPOK',   'IMUNISASI ' as Program,  'Jumlah bayi > 7 hari divaksinasi hepatitis B ' as kegiatan, IFNULL((SELECT COUNT(trans_imunisasi.KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI JOIN pasien ON pasien.KD_PASIEN=trans_imunisasi.KD_PASIEN WHERE pel_imunisasi.KD_JENIS_IMUNISASI='8' AND trans_imunisasi.KD_JENIS_PASIEN='3' AND Get_Age_hari(pasien.TGL_LAHIR) >7 AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),IFNULL((SELECT SUM(d.JML_IMUN_HBU_P7_L+d.JML_IMUN_HBU_P7_P) AS jumlah FROM t_ds_imunisasi d WHERE d.BULAN=DATE_FORMAT('$to','%m') AND d.TAHUN=DATE_FORMAT('$to','%Y') AND d.KD_PUSKESMAS='$pid'),0)) as Jumlah6,  4 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'K' as 'KELOMPOK',   'IMUNISASI ' as Program,  'Jumlah Ibu Hamil divaksinasi TT I ' as kegiatan, IFNULL((SELECT COUNT(trans_imunisasi.KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='9' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='6' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),IFNULL((SELECT SUM(d.JML_IMUN_TT1_HAMIL_P) AS jumlah FROM t_ds_imunisasi d WHERE d.BULAN=DATE_FORMAT('$to','%m') AND d.TAHUN=DATE_FORMAT('$to','%Y') AND d.KD_PUSKESMAS='$pid'),0)) as Jumlah6, 5 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'K' as 'KELOMPOK',   'IMUNISASI ' as Program,  'Jumlah Ibu Hamil divaksinasi TT II ' as kegiatan, IFNULL((SELECT COUNT(trans_imunisasi.KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='10' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='6' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),IFNULL((SELECT SUM(d.JML_IMUN_TT2_HAMIL_P) AS jumlah FROM t_ds_imunisasi d WHERE d.BULAN=DATE_FORMAT('$to','%m') AND d.TAHUN=DATE_FORMAT('$to','%Y') AND d.KD_PUSKESMAS='$pid'),0)) as Jumlah6, 6 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'K' as 'KELOMPOK',   'IMUNISASI ' as Program,  'Jumlah Ibu Hamil divaksinasi TT Boster ' as kegiatan, IFNULL((SELECT COUNT(trans_imunisasi.KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='11' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='6' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),IFNULL((SELECT SUM(d.JML_IMUN_TT3_HAMIL_P+d.JML_IMUN_TT4_HAMIL_P+d.JML_IMUN_TT5_HAMIL_P) AS jumlah FROM t_ds_imunisasi d WHERE d.BULAN=DATE_FORMAT('$to','%m') AND d.TAHUN=DATE_FORMAT('$to','%Y') AND d.KD_PUSKESMAS='$pid'),0)) as Jumlah6,  7 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'K' as 'KELOMPOK',   'IMUNISASI ' as Program,  'Jumlah wanita usia subur/calon pengantin (WUS), divaksinasi TT I ' as kegiatan, IFNULL((SELECT COUNT(trans_imunisasi.KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='9' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='5' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),IFNULL((SELECT SUM(d.JML_IMUN_TT1_WUS_P) AS jumlah FROM t_ds_imunisasi d WHERE d.BULAN=DATE_FORMAT('$to','%m') AND d.TAHUN=DATE_FORMAT('$to','%Y') AND d.KD_PUSKESMAS='$pid'),0)) as Jumlah6,  8 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'K' as 'KELOMPOK',   'IMUNISASI ' as Program,  'Jumlah murid SD kelas I divaksinasi DP ' as kegiatan, IFNULL((SELECT COUNT(trans_imunisasi.KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='15' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='1' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),IFNULL((SELECT SUM(d.JML_VDT1_ANAKSEKOLAH+d.JML_VDT2_ANAKSEKOLAH) AS jumlah FROM t_ds_imunisasi d WHERE d.BULAN=DATE_FORMAT('$to','%m') AND d.TAHUN=DATE_FORMAT('$to','%Y') AND d.KD_PUSKESMAS='$pid'),0)) as Jumlah6,  9 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'K' as 'KELOMPOK',   'IMUNISASI ' as Program,  'Jumlah murid SD kelas II dan III divaksinasi TT ' as kegiatan, IFNULL((SELECT COUNT(trans_imunisasi.KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='16' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='1' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),IFNULL((SELECT SUM(d.JML_VDT1_ANAKSEKOLAH+d.JML_VDT2_ANAKSEKOLAH) AS jumlah FROM t_ds_imunisasi d WHERE d.BULAN=DATE_FORMAT('$to','%m') AND d.TAHUN=DATE_FORMAT('$to','%Y') AND d.KD_PUSKESMAS='$pid'),0)) as Jumlah6,  10 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'K' as 'KELOMPOK',   'IMUNISASI ' as Program,  'Jumlah bayi divaksinasi BCG ' as kegiatan, IFNULL((SELECT COUNT(trans_imunisasi.KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='2' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='2' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),IFNULL((SELECT SUM(d.JML_IMUN_BCG_L+d.JML_IMUN_BCG_P) AS jumlah FROM t_ds_imunisasi d WHERE d.BULAN=DATE_FORMAT('$to','%m') AND d.TAHUN=DATE_FORMAT('$to','%Y') AND d.KD_PUSKESMAS='$pid'),0)) as Jumlah6,  11 as iRow) X");
			
			$query[12] = $db->query("SELECT X.* FROM (select  'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL',  'A' as 'KELOMPOK',   'Acute Flaccid Paralysis (AFP) ' as Program,  'Jumlah kasus AFP baru (0 - 15 tahun) ditemukan  ' as kegiatan, '0'as Jumlah6,  1 as iRow
			UNION ALL
			select  'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL',  'A' as 'KELOMPOK',   'Acute Flaccid Paralysis (AFP) ' as Program,  'Jumlah kasus tetanus neonatorum ditemukan ' as kegiatan, '0'as Jumlah6,  2 as iRow) X");
			
			$query[13] = $db->query("SELECT X.* FROM (select  'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL',  'B' as 'KELOMPOK',   'Tetanus Neonatorum ' as Program,  'Jumlah kasus tetanus neonatorum ditemukan  ' as kegiatan, '0'as Jumlah6,  1 as iRow
			UNION ALL
			select  'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL',  'B' as 'KELOMPOK',   'Tetanus Neonatorum ' as Program,  'Jumlah kasus tetanus neonatorum dilacak ' as kegiatan, '0'as Jumlah6,  2 as iRow) X");
			
			$query[14] = $db->query("SELECT X.* FROM (select  'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL',  'C' as 'KELOMPOK',   'Malaria ' as Program,  'Jumlah penderita malaria berat dan komplikasi  ' as kegiatan, '0'as Jumlah6,  1 as iRow
			UNION ALL
			select  'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL',  'C' as 'KELOMPOK',   'Malaria ' as Program,  'Jumlah Bumil yang memperoleh pengobatan profilaksis/pencegahan  ' as kegiatan, '0'as Jumlah6,  2 as iRow
			UNION ALL
			select  'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL',  'C' as 'KELOMPOK',   'Malaria ' as Program,  'Jumlah rumah yang disemprot  ' as kegiatan, '0'as Jumlah6,  3 as iRow
			UNION ALL
			select  'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL',  'C' as 'KELOMPOK',   'Malaria ' as Program,  'Jumlah penderita malaria klinis  ' as kegiatan, '0'as Jumlah6,  4 as iRow
			UNION ALL
			select  'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL',  'C' as 'KELOMPOK',   'Malaria ' as Program,  'Jumlah penderita pemeriksaan lab  ' as kegiatan, '0'as Jumlah6,  5 as iRow) X");
			
			$query[15] = $db->query("SELECT X.* FROM (select  'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL',  'D' as 'KELOMPOK',   'D B D (Demam Berdarah Dengue) ' as Program,  'Jumlah pelacakan penderita DBD  ' as kegiatan, '0'as Jumlah6,  1 as iRow
			UNION ALL
			select  'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL',  'D' as 'KELOMPOK',   'D B D (Demam Berdarah Dengue) ' as Program,  'Jumlah fogging fokus  ' as kegiatan, '0'as Jumlah6,  2 as iRow
			UNION ALL
			select  'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL',  'D' as 'KELOMPOK',   'D B D (Demam Berdarah Dengue) ' as Program,  'Jumlah desa/kelurahan diabatisasi selektif  ' as kegiatan, '0'as Jumlah6,  3 as iRow
			UNION ALL
			select  'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL',  'D' as 'KELOMPOK',   'D B D (Demam Berdarah Dengue) ' as Program,  'Jumlah desa/kelurahan dilakukan Pemberantasan Sarang Nyamuk  ' as kegiatan, '0'as Jumlah6,  4 as iRow
			UNION ALL
			select  'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL',  'D' as 'KELOMPOK',   'D B D (Demam Berdarah Dengue) ' as Program,  'Jumlah rumah yang dilakukan pemeriksaan jentik  ' as kegiatan, '0'as Jumlah6,  5 as iRow
			UNION ALL
			select  'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL',  'D' as 'KELOMPOK',   'D B D (Demam Berdarah Dengue) ' as Program,  'Jumlah rumah yang ada jentik  ' as kegiatan, '0'as Jumlah6,  6 as iRow) X");
			
			$query[16] = $db->query("SELECT X.* FROM (select  'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL',  'E' as 'KELOMPOK',   'R a b i e s ' as Program,  'Jumlah penderita digigit oleh hewan penular rabies  ' as kegiatan, '0'as Jumlah6,  1 as iRow
			UNION ALL
			select  'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL',  'E' as 'KELOMPOK',   'R a b i e s ' as Program,  'Jumlah penderita gigitan yg di Vaksin Anti Rabies (VAR) atau VAR (+) Serum Anti Rabies (SAR)  ' as kegiatan, '0'as Jumlah6,  2 as iRow) X");
			
			$query[17] = $db->query("SELECT X.* FROM (select  'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL',  'F' as 'KELOMPOK',   'Filaria ' as Program,  'Jumlah desa endemis  ' as kegiatan, '0'as Jumlah6,  1 as iRow
			UNION ALL
			select  'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL',  'F' as 'KELOMPOK',   'Filaria ' as Program,  'Jumlah desa dengan cakupan pengobatan massal > 80 %  ' as kegiatan, '0'as Jumlah6,  2 as iRow) X");
			
			$query[18] = $db->query("SELECT X.* FROM (select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'G' as 'KELOMPOK', 'PENYAKIT ZOONOSIS LAIN (Antraks)' as Program, 'Jumlah yang diobati ' as kegiatan, '0'as Jumlah6, 1 as iRow) X");
			
			$query[19] = $db->query("SELECT X.* FROM (select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'H' as 'KELOMPOK', 'Frambusia ' as Program, 'Jumlah penduduk 0 - 14 tahun yang diperiksa untuk Frambusia ' as kegiatan, '0'as Jumlah6, 1 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'H' as 'KELOMPOK', 'Frambusia ' as Program, 'Jumlah penderita Frambusia yang ditemukan ' as kegiatan, '0'as Jumlah6, 2 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'H' as 'KELOMPOK', 'Frambusia ' as Program, 'Jumlah penderita/kontak penderita yang diobati ' as kegiatan, '0'as Jumlah6, 3 as iRow) X");
			
			$query[20] = $db->query("SELECT X.* FROM (select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'I' as 'KELOMPOK', 'Diare ' as Program, 'Jumlah penderita diare (termasuk tersangka kolera & disentri) dapat oralit ' as kegiatan, '0'as Jumlah6, 1 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'I' as 'KELOMPOK', 'Diare ' as Program, 'Jumlah penderita diare (termasuk tersangka kolera & disentri) dapat infus ' as kegiatan, '0'as Jumlah6, 2 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'I' as 'KELOMPOK', 'Diare ' as Program, 'Jumlah penderita diare (termasuk tersangka kolera & disentri) dapat antibiotik ' as kegiatan, '0'as Jumlah6, 3 as iRow) X");
			
			$query[21] = $db->query("SELECT X.* FROM (select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'J' as 'KELOMPOK', 'ISPA ' as Program, 'Jumlah penderita Pneumonia ' as kegiatan, '0'as Jumlah6, 1 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'J' as 'KELOMPOK', 'ISPA ' as Program, 'Jumlah penderita Pneumonia balita dirujuk dokter ' as kegiatan, '0'as Jumlah6, 2 as iRow) X");
			
			$query[22] = $db->query("SELECT X.* FROM (select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'K' as 'KELOMPOK', 'TB Paru' as Program, 'Jumlah penderita BTA positif baru diobati ' as kegiatan, '0'as Jumlah6, 1 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'K' as 'KELOMPOK', 'TB Paru' as Program, 'Jumlah penderita BTA negatif dan dengan Ronsen (+) diobati ' as kegiatan, '0'as Jumlah6, 2 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'K' as 'KELOMPOK', 'TB Paru' as Program, 'Jumlah penderita mengikuti pengobatan lengkap ' as kegiatan, '0'as Jumlah6, 3 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'K' as 'KELOMPOK', 'TB Paru' as Program, 'Jumlah penderita TB Paru yang sembuh ' as kegiatan, '0'as Jumlah6, 4 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'K' as 'KELOMPOK', 'TB Paru' as Program, 'Jumlah penderita kambuh ' as kegiatan, '0'as Jumlah6, 5 as iRow) X");
			
			$query[23] = $db->query("SELECT X.* FROM (select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'L' as 'KELOMPOK', 'Kusta ' as Program, 'Jumlah penderita terdaftar (PB/Pausibasiler + MB/Multibasiler) ' as kegiatan, '0'as Jumlah6, 1 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'L' as 'KELOMPOK', 'Kusta ' as Program, 'Jumlah penderita baru yang ditemukan ' as kegiatan, '0'as Jumlah6, 2 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'L' as 'KELOMPOK', 'Kusta ' as Program, 'Jumlah penderita MB di antara kasus baru ' as kegiatan, '0'as Jumlah6, 3 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'L' as 'KELOMPOK', 'Kusta ' as Program, 'Jumlah penderita baru menurut cacat tingkat II ' as kegiatan, '0'as Jumlah6, 4 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'L' as 'KELOMPOK', 'Kusta ' as Program, 'Jumlah penderita MB yang mendapat pengobatan MDT ' as kegiatan, '0'as Jumlah6, 5 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'L' as 'KELOMPOK', 'Kusta ' as Program, 'Jumlah penderita PB yang mendapat pengobatan MDT ' as kegiatan, '0'as Jumlah6, 6 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'L' as 'KELOMPOK', 'Kusta ' as Program, 'Jumlah penderita MB yang mendapat pengobatan MDT komplit (RFT) ' as kegiatan, '0'as Jumlah6, 7 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'L' as 'KELOMPOK', 'Kusta ' as Program, 'Jumlah penderita PB yang mendapat pengobatan MDT komplit (RFT) ' as kegiatan, '0'as Jumlah6, 8 as iRow) X");
			
			if($query[1]->num_rows>0){
				//$data2 = $query2->result(); //print_r($data);die;
				
				/*if(!$data)
					return false;
				*/
				// Starting the PHPExcel library
				$this->load->library('Excel');
				$this->excel->getActiveSheet()->setTitle('LB3');
				$this->excel->getProperties()->setTitle("export")->setDescription("none");
				
				$objReader = PHPExcel_IOFactory::createReader('Excel5');
				$objPHPExcel = $objReader->load("tmp/laporan_lb3.xls");
				$objPHPExcel->setActiveSheetIndex(0);
					
				//$no=1;
				$total=0;
				for($no=1;$no<24;$no++){
				$data = $query[$no]->result();
				$rw=array('',10,16,30,42,48,54,83,116,126,150,157,170,174,178,185,193,197,201,204,209,214,218,225,235);
				$rw2=array('',9,15,29,41,47,53,82,115,125,149,156,169,173,177,184,192,196,200,203,208,213,217,224,234);
				foreach($data as $value)
				{
					$styleArray = array(
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
							),
						),
					);
					$objPHPExcel->getActiveSheet()->getStyle('A'.($rw[$no]-1).':E'.$rw[$no])->applyFromArray($styleArray);

					$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw[$no].':D'.$rw[$no]);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$rw[$no])->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					//$objPHPExcel->getActiveSheet()->getStyle('C'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->setTitle('Data')
						->setCellValue('A'.$rw[$no], '   '.$value->kegiatan)
						->setCellValue('E'.$rw[$no], $value->Jumlah6);
					//$rw++;
					$rw[$no]++;
				}
				$objPHPExcel->getActiveSheet()->getStyle('A'.($rw2[$no]).':E'.($rw2[$no]))->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->mergeCells('A'.($rw2[$no]).':D'.($rw2[$no]));
				$objPHPExcel->getActiveSheet()->getStyle('E'.($rw2[$no]))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()
					->setCellValue('A'.($rw2[$no]), $value->JUDUL.' :   '.$value->Program)
					->setCellValue('E'.($rw2[$no]), 'JUMLAH')
					;
					
				}
				$data1 = $query[1]->result();
				foreach($data1 as $value1){
					$objPHPExcel->getActiveSheet()->getStyle('E234:E237')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$objPHPExcel->getActiveSheet()
						->setCellValue('E234', 'KEPALA PUSKESMAS')
						->setCellValue('E237', $value1->KEPALA_PUSKESMAS)
						->setCellValue('C5', $pid)
						->setCellValue('C6', $value1->NAMA_PUSKESMAS)
						->setCellValue('C7', $value1->KABKOTA)
						->setCellValue('E6', $value1->dt1.' / '.$value1->dt2);
				}
				$filename='laporan_lb3_'.date('dmY_his_').'.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
				
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				$objWriter->save('php://output');
			}else{
				die('Tidak Ada Dalam Database');
			}
		}else{	
			$query = array();
			//$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_uks a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'")->row();//print_r($data);die;
			$query[1] = $db->query("SELECT DATE_FORMAT('$from','%d-%m-%Y') as dt1, DATE_FORMAT('$to','%d-%m-%Y') as dt2, '$pid' AS KD_KAB, (SELECT P.KABUPATEN FROM sys_setting S INNER JOIN mst_kabupaten P ON S.KEY_VALUE=P.KD_KABUPATEN WHERE S.KEY_DATA = 'KD_KABKOTA' AND SUBSTRING(S.PUSKESMAS,2,4)='$pid' LIMIT 1) AS KABKOTA, '' AS 'PUSTU_YG_ADA', '' AS 'YANG_LAPOR', 'DARI PARAMETER PHP' AS 'TAHUN', '' AS 'NAMA_MENGETAHUI', '' AS 'NIP_MENGETAHUI', '' AS 'LOKASI', 'TANGGAL HARI INI' AS 'TANGGAL', '' AS 'NAMA_PELAPOR', '' AS 'NIP_PELAPOR', X.* FROM ( select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'A' as 'KELOMPOK', 'Gizi' as Program, 'Upaya Penanggulangan Kekurangan Vitamin A' as kegiatan, '' as Jumlah6, 1 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'A' as 'KELOMPOK','Gizi' as Program, 'Jumlah anak balita (1-5 th) dapat kapsul vit. A dosis tinggi (200.000 IU) bulan ini' as kegiatan, (SELECT COUNT(X.KD_PASIEN) as JML FROM (SELECT * FROM ( select V.KD_PASIEN, V.KD_PELAYANAN, V.KD_PUSKESMAS, V.VARIABEL_ID AS 'CL_CHILDVITA', '' AS 'CL_CHILDEXAMAGE', V.HASIL AS 'VITA' , '' AS AGE from pel_hasil_kia AS V WHERE SUBSTRING(V.KD_PUSKESMAS,2,4)= '$pid' AND V.VARIABEL_ID = 'CL_CHILDVITA' AND V.HASIL = 'YA' UNION ALL select V.KD_PASIEN, V.KD_PELAYANAN, V.KD_PUSKESMAS, ''AS 'CL_CHILDVITA' ,V.VARIABEL_ID AS 'CL_CHILDEXAMAGE', '' AS 'VITA' , V.HASIL AS AGE from pel_hasil_kia AS V WHERE SUBSTRING(V.KD_PUSKESMAS,2,4)= '$pid' AND V.VARIABEL_ID = 'CL_CHILDEXAMAGE' AND V.HASIL BETWEEN '365' AND '1825' ) M )X INNER JOIN pelayanan AS p WHERE p.KD_PELAYANAN = X.KD_PELAYANAN AND p.TGL_PELAYANAN BETWEEN '$from' AND '$to' ) as Jumlah6, 2 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'A' as 'KELOMPOK','Gizi' as Program, 'Jumlah Ibu nifas (s/d 40 hr) dapat kapsul vit. A dosis tinggi (200.000 IU) bulan ini' as kegiatan, (SELECT COUNT(X.KD_PASIEN) as JML FROM (select V.KD_PASIEN, V.KD_PELAYANAN, V.KD_PUSKESMAS, V.VARIABEL_ID AS 'CL_CHILDVITA', '' AS 'CL_CHILDEXAMAGE', V.HASIL AS 'VITA' , '' AS AGE from pel_hasil_kia AS V WHERE SUBSTRING(V.KD_PUSKESMAS,2,4) = '$pid' AND V.VARIABEL_ID = 'CL_PNCCAREVITA' AND V.HASIL = 'YA' )X INNER JOIN pelayanan AS p WHERE p.KD_PELAYANAN = X.KD_PELAYANAN AND p.TGL_PELAYANAN BETWEEN '$from' AND '$to') as Jumlah6, 3 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'A' as 'KELOMPOK','Gizi' as Program, 'Jumlah bayi (6-11 th) dapat kapsul vit. A dosis tinggi (200.000 IU) bulan ini' as kegiatan, (SELECT COUNT(X.KD_PASIEN) as JML FROM (SELECT * FROM ( select V.KD_PASIEN, V.KD_PELAYANAN, V.KD_PUSKESMAS, V.VARIABEL_ID AS 'CL_CHILDVITA', '' AS 'CL_CHILDEXAMAGE', V.HASIL AS 'VITA' , '' AS AGE from pel_hasil_kia AS V WHERE SUBSTRING(V.KD_PUSKESMAS,2,4)= '$pid' AND V.VARIABEL_ID = 'CL_CHILDVITA' AND V.HASIL = 'YA' UNION ALL select V.KD_PASIEN, V.KD_PELAYANAN, V.KD_PUSKESMAS, ''AS 'CL_CHILDVITA' ,V.VARIABEL_ID AS 'CL_CHILDEXAMAGE', '' AS 'VITA' , V.HASIL AS AGE from pel_hasil_kia AS V WHERE SUBSTRING(V.KD_PUSKESMAS,2,4)= '$pid' AND V.VARIABEL_ID = 'CL_CHILDEXAMAGE' AND V.HASIL BETWEEN '2190' AND '4015' ) M )X INNER JOIN pelayanan AS p WHERE p.KD_PELAYANAN = X.KD_PELAYANAN AND p.TGL_PELAYANAN BETWEEN '$from' AND '$to' ) as Jumlah6, 4 as iRow  ) X ");//print_r($query);die;
			
			$query[2] = $db->query("SELECT X.* FROM (select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Ibu hamil dapat tablet tambah darah (Fe) 30 tablet (Fe1) bulan ini' as kegiatan, ''as Jumlah6, 1 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Ibu hamil dapat tablet tambah darah (Fe) 90 tablet (Fe2) bulan ini' as kegiatan, ''as Jumlah6, 2 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Balita diperiksa status anemia bulan ini' as kegiatan, ''as Jumlah6, 3 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Balita yang diperiksa dengan status anemia < 11 gr % bulan ini' as kegiatan, ''as Jumlah6, 4 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah WUS (15 - 45 th) diperiksa status anemia bulan ini' as kegiatan, ''as Jumlah6, 5 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah WUS (15 - 45 th) yang diperiksa dengan status anemia < 11 gr % bulan ini' as kegiatan, ''as Jumlah6, 6 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Remaja Putri (14 - 18 th) diperiksa status anemia bulan ini' as kegiatan, ''as Jumlah6, 7 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Remaja Putri (14 - 18 th) yang diperiksa dengan status anemia < 11 gr % bulan ini' as kegiatan, ''as Jumlah6, 8 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Tenaga Kerja Wanita (nakerwan) diperiksa status anemia bulan ini' as kegiatan, ''as Jumlah6, 9 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Tenaga Kerja Wanita (nakerwan) yang diperiksa dengan status anemia < 11 gr % bulan ini' as kegiatan, ''as Jumlah6, 10 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Ibu hamil diperiksa status anemia bulan ini' as kegiatan, ''as Jumlah6, 11 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Ibu hamil yang diperiksa dengan status anemia < 11 gr % bulan ini' as kegiatan, ''as Jumlah6, 12 as iRow) X");
			
			$query[3] = $db->query("SELECT X.* FROM (select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'C' as 'KELOMPOK', 'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita yang ada bulan ini' as kegiatan, ''as Jumlah6, 1 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'C' as 'KELOMPOK', 'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita yang mempunyai KMS bulan ini' as kegiatan, ''as Jumlah6, 2 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'C' as 'KELOMPOK', 'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita yang Naik berat badannya bulan ini' as kegiatan, ''as Jumlah6, 3 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'C' as 'KELOMPOK', 'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita yang Tidak naik/tetap berat badannya bulan ini' as kegiatan, ''as Jumlah6, 4 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'C' as 'KELOMPOK', 'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita yang ditimbang bulan ini tetapi tidak ditimbang bulan lalu' as kegiatan, ''as Jumlah6, 5 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'C' as 'KELOMPOK', 'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita yang Baru ditimbang bulan ini' as kegiatan, ''as Jumlah6, 6 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'C' as 'KELOMPOK', 'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita yang dapat ditimbang bulan ini' as kegiatan, ''as Jumlah6, 7 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'C' as 'KELOMPOK', 'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita yang tidak dapat ditimbang bulan ini' as kegiatan, ''as Jumlah6, 8 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'C' as 'KELOMPOK', 'Upaya Pemantauan Pertumbuhan Balita' as Program, 'jumlah Balita dengan Berat badan di Bawah Garis Merah (BGM) bulan ini' as kegiatan, ''as Jumlah6, 9 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'C' as 'KELOMPOK', 'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita gizi buruk bulan ini' as kegiatan, ''as Jumlah6, 10 as iRow) X");
			
			$query[4] = $db->query("SELECT X.* FROM (select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'D' as 'KELOMPOK', 'Upaya Penanggulangan Gangguan Akibat Kekurangan Yodium (GAKY)' as Program, 'Jumlah penderita GAKY laki-laki bulan ini ' as kegiatan, ''as Jumlah6, 1 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'D' as 'KELOMPOK', 'Upaya Penanggulangan Gangguan Akibat Kekurangan Yodium (GAKY)' as Program, 'Jumlah penderita GAKY perempuan bulan ini ' as kegiatan, ''as Jumlah6, 2 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'D' as 'KELOMPOK', 'Upaya Penanggulangan Gangguan Akibat Kekurangan Yodium (GAKY)' as Program, 'Jumlah ibu hamil mendapat kapsul yodium ' as kegiatan, ''as Jumlah6, 3 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'D' as 'KELOMPOK', 'Upaya Penanggulangan Gangguan Akibat Kekurangan Yodium (GAKY)' as Program, 'Jumlah penduduk lainnya mendapat kapsul yodium ' as kegiatan, ''as Jumlah6, 4 as iRow) X");
			
			$query[5] = $db->query("SELECT X.* FROM (select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'E' as 'KELOMPOK', 'Upaya Penanggulangan Kekurangan Energi Kronis (KEK)' as Program, 'Jumlah Ibu hamil baru, diukur LILA (Lingkar Lengan Atas) bulan ini ' as kegiatan, ''as Jumlah6, 1 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'E' as 'KELOMPOK', 'Upaya Penanggulangan Kekurangan Energi Kronis (KEK)' as Program, 'Jumlah Ibu hamil baru, dengan LILA < 23,5 cm bulan ini ' as kegiatan, ''as Jumlah6, 2 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'E' as 'KELOMPOK', 'Upaya Penanggulangan Kekurangan Energi Kronis (KEK)' as Program, 'Jumlah WUS baru, yang diukur LILA (Lingkar Lengan Atas) bulan ini ' as kegiatan, ''as Jumlah6, 3 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'E' as 'KELOMPOK', 'Upaya Penanggulangan Kekurangan Energi Kronis (KEK)' as Program, 'Jumlah WUS baru, dengan LILA < 23,5 cm bulan ini ' as kegiatan, ''as Jumlah6, 4 as iRow) X");
			$query[6] = $db->query("SELECT X.* FROM (select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'Jumlah kunjungan K1 Bumil ' as kegiatan, (SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil WHERE kunjungan_ke='K1' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to'))as Jumlah6, 1 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'Jumlah kunjungan Bumil lama ' as kegiatan, ''as Jumlah6, 2 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'K2' as kegiatan, (SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil WHERE kunjungan_ke='K2' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to'))as Jumlah6, 3 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'K3' as kegiatan, (SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil WHERE kunjungan_ke='K3' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to'))as Jumlah6, 4 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'K4' as kegiatan, (SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil WHERE kunjungan_ke='K4' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to'))as Jumlah6, 5 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'Kunjungan Bumil dengan faktor risiko : ' as kegiatan, ''as Jumlah6, 6 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'a. < 20 th ' as kegiatan, ''as Jumlah6, 7 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'b. > 35 th ' as kegiatan, ''as Jumlah6, 8 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'c. Spacing < 2 th ' as kegiatan, ''as Jumlah6, 9 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'd. Paritas > 5 th ' as kegiatan, ''as Jumlah6, 10 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'e. HB 11 gram %' as kegiatan, ''as Jumlah6, 11 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'f. BB Kg Triwulan III < 45 Kg ' as kegiatan, ''as Jumlah6, 12 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'g. TB < 145 cm' as kegiatan, ''as Jumlah6, 13 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'Imunisasi TT Bumil (TT1, TT2) : ' as kegiatan, ''as Jumlah6, 14 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'a. TT1 ' as kegiatan, ''as Jumlah6, 15 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'b. TT2 ' as kegiatan, ''as Jumlah6, 16 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'Pemberian tablet Fe Bumil : ' as kegiatan, ''as Jumlah6, 17 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'a. Fe1 ' as kegiatan, ''as Jumlah6, 18 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'b. Fe2 ' as kegiatan, ''as Jumlah6, 19 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'c. Fe3' as kegiatan, ''as Jumlah6, 20 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'Jumlah kesakitan dan kematian Bumil yang ditangani : ' as kegiatan, ''as Jumlah6, 21 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'a. Pendarahan ' as kegiatan, ''as Jumlah6, 22 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'b. Infeksi jalan lahir ' as kegiatan, ''as Jumlah6, 23 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'c. Preeklamasi/Eklamsi ' as kegiatan, ''as Jumlah6, 24 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'd. Sebab lain ' as kegiatan, ''as Jumlah6, 25 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'Deteksi risti bumil oleh nakes ' as kegiatan, ''as Jumlah6, 26 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'Deteksi risti bumil oleh masyarakat ' as kegiatan, ''as Jumlah6, 27 as iRow) X");
			
			$query[7] = $db->query("SELECT X.* FROM (select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, 'Persalinan ' as kegiatan, ''as Jumlah6, 1 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, 'a. < 20 tahun ' as kegiatan, ''as Jumlah6, 2 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, 'b. 20 - 24 tahun ' as kegiatan, ''as Jumlah6, 3 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, 'c. 25 - 29 tahun ' as kegiatan, ''as Jumlah6, 4 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, 'd. 30 - 34 tahun ' as kegiatan, ''as Jumlah6, 5 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, 'e. > 35 tahun ' as kegiatan, ''as Jumlah6, 6 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, 'Jumlah persalinan ditolong oleh Nakes ' as kegiatan, ''as Jumlah6, 7 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, '- Lahir hidup ' as kegiatan, ''as Jumlah6, 8 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, '- Lahir mati ' as kegiatan, ''as Jumlah6, 9 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, '- BBLR (BB < 2500 gram) ' as kegiatan, ''as Jumlah6, 10 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, 'Jumlah persalinan dukun didampingi oleh Nakes : ' as kegiatan, ''as Jumlah6, 11 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, '- Lahir hidup ' as kegiatan, ''as Jumlah6, 12 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, '- Lahir mati ' as kegiatan, ''as Jumlah6, 13 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, '- BBLR (BB < 2500 gram) ' as kegiatan, ''as Jumlah6, 14 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, 'Jumlah persalinan ditolong oleh dukun terlatih/tidak telatih : ' as kegiatan, ''as Jumlah6, 15 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, '- Lahir hidup ' as kegiatan, ''as Jumlah6, 16 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, '- Lahir mati ' as kegiatan, ''as Jumlah6, 17 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, '- BBLR (BB < 2500 gram) ' as kegiatan, ''as Jumlah6, 18 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, 'Kunjungan Neonatus ' as kegiatan, ''as Jumlah6, 19 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, '- 0 - 7 hari ' as kegiatan, ''as Jumlah6, 20 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, '- 7 - 28 hari ' as kegiatan, ''as Jumlah6, 21 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, 'Jumlah kesakitan dan kematian ibu bersalin ditangani ' as kegiatan, ''as Jumlah6, 22 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, '- Pendarahan ' as kegiatan, ''as Jumlah6, 23 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, '- Infeksi jalan lahir ' as kegiatan, ''as Jumlah6, 24 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, '- Preeklamasi/Eklamsi ' as kegiatan, ''as Jumlah6, 25 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, '- Sebab lain ' as kegiatan, ''as Jumlah6, 26 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, 'Jumlah kesakitan dan kematian ibu nifas ditangani ' as kegiatan, ''as Jumlah6, 27 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, '- Pendarahan ' as kegiatan, ''as Jumlah6, 28 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, '- Infeksi jalan lahir ' as kegiatan, ''as Jumlah6, 29 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, '- Preeklamasi/Eklamsi ' as kegiatan, ''as Jumlah6, 30 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'G' as 'KELOMPOK', 'Pelayanan Persalinan' as Program, '- Sebab lain ' as kegiatan, ''as Jumlah6, 31 as iRow) X");
			
			$query[8] = $db->query("SELECT X.* FROM (select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'H' as 'KELOMPOK', 'Pelayanan Ibu Menyusui ' as Program, 'Kunjungan baru ' as kegiatan, ''as Jumlah6, 1 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'H' as 'KELOMPOK', 'Pelayanan Ibu Menyusui ' as Program, 'Kunjungan lama ' as kegiatan, ''as Jumlah6, 2 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'H' as 'KELOMPOK', 'Pelayanan Ibu Menyusui ' as Program, 'Akseptor baru Buteki ' as kegiatan, ''as Jumlah6, 3 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'H' as 'KELOMPOK', 'Pelayanan Ibu Menyusui ' as Program, 'Akseptor aktif Buteki ' as kegiatan, ''as Jumlah6, 4 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'H' as 'KELOMPOK', 'Pelayanan Ibu Menyusui ' as Program, 'Akseptor aktif seluruh (CU) ' as kegiatan, ''as Jumlah6, 5 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'H' as 'KELOMPOK', 'Pelayanan Ibu Menyusui ' as Program, 'Buteki dapat Fe ' as kegiatan, ''as Jumlah6, 6 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'H' as 'KELOMPOK', 'Pelayanan Ibu Menyusui ' as Program, 'Buteki dapat Vitamin A dosis tinggi ' as kegiatan, ''as Jumlah6, 7 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'H' as 'KELOMPOK', 'Pelayanan Ibu Menyusui ' as Program, 'ASI Eksklusif 0 - 6 bulan ' as kegiatan, ''as Jumlah6, 8 as iRow) X");
			
			$query[9] = $db->query("SELECT X.* FROM (select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'I' as 'KELOMPOK', 'Pelayanan Bayi ' as Program, 'Kunjungan baru diperiksa ' as kegiatan, ''as Jumlah6, 1 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'I' as 'KELOMPOK', 'Pelayanan Bayi ' as Program, 'Kunjungan baru dIrujuk' as kegiatan, ''as Jumlah6, 2 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'I' as 'KELOMPOK', 'Pelayanan Bayi ' as Program, 'Kunjungan lama diperiksa' as kegiatan, ''as Jumlah6, 3 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'I' as 'KELOMPOK', 'Pelayanan Bayi ' as Program, 'Kunjungan lama dirujuk' as kegiatan, ''as Jumlah6, 4 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'I' as 'KELOMPOK', 'Pelayanan Bayi ' as Program, 'Jumlah kesakitan dan kematian Perinatal (0 - 7 hari) ' as kegiatan, ''as Jumlah6, 5 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'I' as 'KELOMPOK', 'Pelayanan Bayi ' as Program, '- BBLR ' as kegiatan, ''as Jumlah6, 6 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'I' as 'KELOMPOK', 'Pelayanan Bayi ' as Program, '- Tetanus Neonatorium ' as kegiatan, ''as Jumlah6, 7 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'I' as 'KELOMPOK', 'Pelayanan Bayi ' as Program, '- BBLR dirujuk ke RSU ' as kegiatan, ''as Jumlah6, 8 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'I' as 'KELOMPOK', 'Pelayanan Bayi ' as Program, '- Tetanus Neonatorium dirujuk ke RSU ' as kegiatan, ''as Jumlah6, 9 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'I' as 'KELOMPOK', 'Pelayanan Bayi ' as Program, '- Oleh sebab lain ' as kegiatan, ''as Jumlah6, 10 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'I' as 'KELOMPOK', 'Pelayanan Bayi ' as Program, 'Jumlah kesakitan dan kematian Perinatal (8 - 28 hari) ' as kegiatan, ''as Jumlah6, 11 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'I' as 'KELOMPOK', 'Pelayanan Bayi ' as Program, '- BBLR ' as kegiatan, ''as Jumlah6, 12 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'I' as 'KELOMPOK', 'Pelayanan Bayi ' as Program, '- Tetanus Neonatorium ' as kegiatan, ''as Jumlah6, 13 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'I' as 'KELOMPOK', 'Pelayanan Bayi ' as Program, '- BBLR dirujuk ke RSU ' as kegiatan, ''as Jumlah6, 14 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'I' as 'KELOMPOK', 'Pelayanan Bayi ' as Program, '- Tetanus Neonatorium dirujuk ke RSU' as kegiatan, ''as Jumlah6, 15 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'I' as 'KELOMPOK', 'Pelayanan Bayi ' as Program, '- Oleh sebab lain ' as kegiatan, ''as Jumlah6, 16 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'I' as 'KELOMPOK', 'Pelayanan Bayi ' as Program, 'Jumlah kesakitan dan kematian Perinatal (28 hari - 1 tahun) ' as kegiatan, ''as Jumlah6, 17 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'I' as 'KELOMPOK', 'Pelayanan Bayi ' as Program, '- BBLR ' as kegiatan, ''as Jumlah6, 18 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'I' as 'KELOMPOK', 'Pelayanan Bayi ' as Program, '- Tetanus Neonatorium ' as kegiatan, ''as Jumlah6, 19 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'I' as 'KELOMPOK', 'Pelayanan Bayi ' as Program, '- BBLR dirujuk ke RSU ' as kegiatan, ''as Jumlah6, 20 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'I' as 'KELOMPOK', 'Pelayanan Bayi ' as Program, '- Tetanus Neonatorium dirujuk ke RSU ' as kegiatan, ''as Jumlah6, 21 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'I' as 'KELOMPOK', 'Pelayanan Bayi ' as Program, '- Oleh sebab lain ' as kegiatan, ''as Jumlah6, 22 as iRow) X");
			
			$query[10] = $db->query("SELECT X.* FROM (select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'J' as 'KELOMPOK', 'Pelayanan Anak Balita' as Program, 'Kunjungan baru diperiksa ' as kegiatan, ''as Jumlah6, 1 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'J' as 'KELOMPOK', 'Pelayanan Anak Balita' as Program, 'Kunjungan baru drujuk ' as kegiatan, ''as Jumlah6, 2 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'J' as 'KELOMPOK', 'Pelayanan Anak Balita' as Program, 'Kunjungan lama diperiksa ' as kegiatan, ''as Jumlah6, 3 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'J' as 'KELOMPOK', 'Pelayanan Anak Balita' as Program, 'Kunjungan lama dirujuk ' as kegiatan, ''as Jumlah6, 4 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'J' as 'KELOMPOK', 'Pelayanan Anak Balita' as Program, 'Jumlah kesakitan dan kematian anak balita ' as kegiatan, ''as Jumlah6, 5 as iRow) X");
			
			$query[11] = $db->query("SELECT X.* FROM (select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'K' as 'KELOMPOK', 'IMUNISASI ' as Program, 'Jumlah bayi divaksinasi campak ' as kegiatan, ''as Jumlah6, 1 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'K' as 'KELOMPOK', 'IMUNISASI ' as Program, 'Jumlah bayi divaksinasi DPT I ' as kegiatan, ''as Jumlah6, 2 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'K' as 'KELOMPOK', 'IMUNISASI ' as Program, 'Jumlah bayi 0 - 7 hari divaksinasi hepatitis B ' as kegiatan, ''as Jumlah6, 3 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'K' as 'KELOMPOK', 'IMUNISASI ' as Program, 'Jumlah bayi > 7 hari divaksinasi hepatitis B ' as kegiatan, ''as Jumlah6, 4 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'K' as 'KELOMPOK', 'IMUNISASI ' as Program, 'Jumlah Ibu Hamil divaksinasi TT I ' as kegiatan, ''as Jumlah6, 5 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'K' as 'KELOMPOK', 'IMUNISASI ' as Program, 'Jumlah Ibu Hamil divaksinasi TT II ' as kegiatan, ''as Jumlah6, 6 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'K' as 'KELOMPOK', 'IMUNISASI ' as Program, 'Jumlah Ibu Hamil divaksinasi TT Boster ' as kegiatan, ''as Jumlah6, 7 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'K' as 'KELOMPOK', 'IMUNISASI ' as Program, 'Jumlah wanita usia subur/calon pengantin (WUS), divaksinasi TT I ' as kegiatan, ''as Jumlah6, 8 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'K' as 'KELOMPOK', 'IMUNISASI ' as Program, 'Jumlah murid SD kelas I divaksinasi DP ' as kegiatan, ''as Jumlah6, 9 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'K' as 'KELOMPOK', 'IMUNISASI ' as Program, 'Jumlah murid SD kelas II dan III divaksinasi TT ' as kegiatan, ''as Jumlah6, 10 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'K' as 'KELOMPOK', 'IMUNISASI ' as Program, 'Jumlah bayi divaksinasi BCG ' as kegiatan, ''as Jumlah6, 11 as iRow) X");
			
			$query[12] = $db->query("SELECT X.* FROM (select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'A' as 'KELOMPOK', 'Acute Flaccid Paralysis (AFP) ' as Program, 'Jumlah kasus AFP baru (0 - 15 tahun) ditemukan ' as kegiatan, ''as Jumlah6, 1 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'A' as 'KELOMPOK', 'Acute Flaccid Paralysis (AFP) ' as Program, 'Jumlah kasus tetanus neonatorum ditemukan ' as kegiatan, ''as Jumlah6, 2 as iRow) X");
			
			$query[13] = $db->query("SELECT X.* FROM (select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'B' as 'KELOMPOK', 'Tetanus Neonatorum ' as Program, 'Jumlah kasus tetanus neonatorum ditemukan ' as kegiatan, ''as Jumlah6, 1 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'B' as 'KELOMPOK', 'Tetanus Neonatorum ' as Program, 'Jumlah kasus tetanus neonatorum dilacak ' as kegiatan, ''as Jumlah6, 2 as iRow) X");
			
			$query[14] = $db->query("SELECT X.* FROM (select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'C' as 'KELOMPOK', 'Malaria ' as Program, 'Jumlah penderita malaria berat dan komplikasi ' as kegiatan, ''as Jumlah6, 1 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'C' as 'KELOMPOK', 'Malaria ' as Program, 'Jumlah Bumil yang memperoleh pengobatan profilaksis/pencegahan ' as kegiatan, ''as Jumlah6, 2 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'C' as 'KELOMPOK', 'Malaria ' as Program, 'Jumlah rumah yang disemprot ' as kegiatan, ''as Jumlah6, 3 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'C' as 'KELOMPOK', 'Malaria ' as Program, 'Jumlah penderita malaria klinis ' as kegiatan, ''as Jumlah6, 4 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'C' as 'KELOMPOK', 'Malaria ' as Program, 'Jumlah penderita pemeriksaan lab ' as kegiatan, ''as Jumlah6, 5 as iRow) X");
			
			$query[15] = $db->query("SELECT X.* FROM (select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'D' as 'KELOMPOK', 'D B D (Demam Berdarah Dengue) ' as Program, 'Jumlah pelacakan penderita DBD ' as kegiatan, ''as Jumlah6, 1 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'D' as 'KELOMPOK', 'D B D (Demam Berdarah Dengue) ' as Program, 'Jumlah fogging fokus ' as kegiatan, ''as Jumlah6, 2 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'D' as 'KELOMPOK', 'D B D (Demam Berdarah Dengue) ' as Program, 'Jumlah desa/kelurahan diabatisasi selektif ' as kegiatan, ''as Jumlah6, 3 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'D' as 'KELOMPOK', 'D B D (Demam Berdarah Dengue) ' as Program, 'Jumlah desa/kelurahan dilakukan Pemberantasan Sarang Nyamuk ' as kegiatan, ''as Jumlah6, 4 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'D' as 'KELOMPOK', 'D B D (Demam Berdarah Dengue) ' as Program, 'Jumlah rumah yang dilakukan pemeriksaan jentik ' as kegiatan, ''as Jumlah6, 5 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'D' as 'KELOMPOK', 'D B D (Demam Berdarah Dengue) ' as Program, 'Jumlah rumah yang ada jentik ' as kegiatan, ''as Jumlah6, 6 as iRow) X");
			
			$query[16] = $db->query("SELECT X.* FROM (select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'E' as 'KELOMPOK', 'R a b i e s ' as Program, 'Jumlah penderita digigit oleh hewan penular rabies ' as kegiatan, ''as Jumlah6, 1 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'E' as 'KELOMPOK', 'R a b i e s ' as Program, 'Jumlah penderita gigitan yg di Vaksin Anti Rabies (VAR) atau VAR (+) Serum Anti Rabies (SAR) ' as kegiatan, ''as Jumlah6, 2 as iRow) X");
			
			$query[17] = $db->query("SELECT X.* FROM (select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'F' as 'KELOMPOK', 'Filaria ' as Program, 'Jumlah desa endemis ' as kegiatan, ''as Jumlah6, 1 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'F' as 'KELOMPOK', 'Filaria ' as Program, 'Jumlah desa dengan cakupan pengobatan massal > 80 % ' as kegiatan, ''as Jumlah6, 2 as iRow) X");
			
			$query[18] = $db->query("SELECT X.* FROM (select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'G' as 'KELOMPOK', 'PENYAKIT ZOONOSIS LAIN (Antraks)' as Program, 'Jumlah yang diobati ' as kegiatan, ''as Jumlah6, 1 as iRow) X");
			
			$query[19] = $db->query("SELECT X.* FROM (select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'H' as 'KELOMPOK', 'Frambusia ' as Program, 'Jumlah penduduk 0 - 14 tahun yang diperiksa untuk Frambusia ' as kegiatan, ''as Jumlah6, 1 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'H' as 'KELOMPOK', 'Frambusia ' as Program, 'Jumlah penderita Frambusia yang ditemukan ' as kegiatan, ''as Jumlah6, 2 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'H' as 'KELOMPOK', 'Frambusia ' as Program, 'Jumlah penderita/kontak penderita yang diobati ' as kegiatan, ''as Jumlah6, 3 as iRow) X");
			
			$query[20] = $db->query("SELECT X.* FROM (select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'I' as 'KELOMPOK', 'Diare ' as Program, 'Jumlah penderita diare (termasuk tersangka kolera & disentri) dapat oralit ' as kegiatan, ''as Jumlah6, 1 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'I' as 'KELOMPOK', 'Diare ' as Program, 'Jumlah penderita diare (termasuk tersangka kolera & disentri) dapat infus ' as kegiatan, ''as Jumlah6, 2 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'I' as 'KELOMPOK', 'Diare ' as Program, 'Jumlah penderita diare (termasuk tersangka kolera & disentri) dapat antibiotik ' as kegiatan, ''as Jumlah6, 3 as iRow) X");
			
			$query[21] = $db->query("SELECT X.* FROM (select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'J' as 'KELOMPOK', 'ISPA ' as Program, 'Jumlah penderita Pneumonia ' as kegiatan, ''as Jumlah6, 1 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'J' as 'KELOMPOK', 'ISPA ' as Program, 'Jumlah penderita Pneumonia balita dirujuk dokter ' as kegiatan, ''as Jumlah6, 2 as iRow) X");
			
			$query[22] = $db->query("SELECT X.* FROM (select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'K' as 'KELOMPOK', 'TB Paru' as Program, 'Jumlah penderita BTA positif baru diobati ' as kegiatan, ''as Jumlah6, 1 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'K' as 'KELOMPOK', 'TB Paru' as Program, 'Jumlah penderita BTA negatif dan dengan Ronsen (+) diobati ' as kegiatan, ''as Jumlah6, 2 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'K' as 'KELOMPOK', 'TB Paru' as Program, 'Jumlah penderita mengikuti pengobatan lengkap ' as kegiatan, ''as Jumlah6, 3 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'K' as 'KELOMPOK', 'TB Paru' as Program, 'Jumlah penderita TB Paru yang sembuh ' as kegiatan, ''as Jumlah6, 4 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'K' as 'KELOMPOK', 'TB Paru' as Program, 'Jumlah penderita kambuh ' as kegiatan, ''as Jumlah6, 5 as iRow) X");
			
			$query[23] = $db->query("SELECT X.* FROM (select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'L' as 'KELOMPOK', 'Kusta ' as Program, 'Jumlah penderita terdaftar (PB/Pausibasiler + MB/Multibasiler) ' as kegiatan, ''as Jumlah6, 1 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'L' as 'KELOMPOK', 'Kusta ' as Program, 'Jumlah penderita baru yang ditemukan ' as kegiatan, ''as Jumlah6, 2 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'L' as 'KELOMPOK', 'Kusta ' as Program, 'Jumlah penderita MB di antara kasus baru ' as kegiatan, ''as Jumlah6, 3 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'L' as 'KELOMPOK', 'Kusta ' as Program, 'Jumlah penderita baru menurut cacat tingkat II ' as kegiatan, ''as Jumlah6, 4 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'L' as 'KELOMPOK', 'Kusta ' as Program, 'Jumlah penderita MB yang mendapat pengobatan MDT ' as kegiatan, ''as Jumlah6, 5 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'L' as 'KELOMPOK', 'Kusta ' as Program, 'Jumlah penderita PB yang mendapat pengobatan MDT ' as kegiatan, ''as Jumlah6, 6 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'L' as 'KELOMPOK', 'Kusta ' as Program, 'Jumlah penderita MB yang mendapat pengobatan MDT komplit (RFT) ' as kegiatan, ''as Jumlah6, 7 as iRow UNION ALL select 'PENGAMATAN PENYAKIT MENULAR' as 'JUDUL', 'L' as 'KELOMPOK', 'Kusta ' as Program, 'Jumlah penderita PB yang mendapat pengobatan MDT komplit (RFT) ' as kegiatan, ''as Jumlah6, 8 as iRow) X");
			
			if($query[1]->num_rows>0){
				//$data2 = $query2->result(); //print_r($data);die;
				
				/*if(!$data)
					return false;
				*/
				// Starting the PHPExcel library
				$this->load->library('Excel');
				$this->excel->getActiveSheet()->setTitle('LB3');
				$this->excel->getProperties()->setTitle("export")->setDescription("none");
				
				$objReader = PHPExcel_IOFactory::createReader('Excel5');
				$objPHPExcel = $objReader->load("tmp/laporan_lb3_kab.xls");
				$objPHPExcel->setActiveSheetIndex(0);
					
				//$no=1;
				$total=0;
				for($no=1;$no<24;$no++){
				$data = $query[$no]->result();
				$rw=array('',10,16,30,42,48,54,83,116,126,150,157,170,174,178,185,193,197,201,204,209,214,218,225,235);
				$rw2=array('',9,15,29,41,47,53,82,115,125,149,156,169,173,177,184,192,196,200,203,208,213,217,224,234);
				foreach($data as $value)
				{
					$styleArray = array(
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
							),
						),
					);
					$objPHPExcel->getActiveSheet()->getStyle('A'.($rw[$no]-1).':E'.$rw[$no])->applyFromArray($styleArray);

					$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw[$no].':D'.$rw[$no]);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$rw[$no])->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					//$objPHPExcel->getActiveSheet()->getStyle('C'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->setTitle('Data')
						->setCellValue('A'.$rw[$no], '   '.$value->kegiatan)
						->setCellValue('E'.$rw[$no], $value->Jumlah6);
					//$rw++;
					$rw[$no]++;
				}
				$objPHPExcel->getActiveSheet()->getStyle('A'.($rw2[$no]).':E'.($rw2[$no]))->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->mergeCells('A'.($rw2[$no]).':D'.($rw2[$no]));
				$objPHPExcel->getActiveSheet()->getStyle('E'.($rw2[$no]))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()
					->setCellValue('A'.($rw2[$no]), $value->JUDUL.' :   '.$value->Program)
					->setCellValue('E'.($rw2[$no]), 'JUMLAH')
					;
					
				}
				$data1 = $query[1]->result();
				foreach($data1 as $value1){
					$objPHPExcel->getActiveSheet()->getStyle('E234:E237')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$objPHPExcel->getActiveSheet()
						//->setCellValue('E234', 'KEPALA PUSKESMAS')
						//->setCellValue('E237', $value1->KEPALA_PUSKESMAS)
						//->setCellValue('C5', $pid)
						//->setCellValue('C6', $value1->NAMA_PUSKESMAS)
						->setCellValue('C5', $value1->KABKOTA)
						->setCellValue('E6', $value1->dt1.' / '.$value1->dt2);
				}
				$filename='laporan_lb3_kab_'.date('dmY_his_').'.xls'; //save our workbook as this file name
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
	
	public function lb4_excel(){
	//print_r($_POST);die;
	
		
		$from = $this->input->get('from');	//print_r($from);die;
		$to = $this->input->get('to'); //print_r($to);die;
		$pid = $this->input->get('pid');
		$jenis = $this->input->get('jenis');
		$db = $this->load->database('sikda', TRUE);
	
		//$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_uks a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'")->row();//print_r($data);die;
		$query = array();
		if($jenis=='rpt_lb4'){
			$query[1] = $db->query("SELECT DATE_FORMAT('$from','%d-%m-%Y') as dt1, DATE_FORMAT('$to','%d-%m-%Y') as dt2, '$pid' AS KD_PUSKESMAS, (SELECT S.KEY_VALUE FROM sys_setting AS S WHERE S.KEY_DATA = 'NAMA_PUSKESMAS' AND PUSKESMAS='$pid' LIMIT 1) AS NAMA_PUSKESMAS, (SELECT S.KEY_VALUE FROM sys_setting AS S WHERE S.KEY_DATA = 'NAMA_PIMPINAN' AND PUSKESMAS='$pid' LIMIT 1) AS KEPALA_PUSKESMAS, (SELECT P.PROVINSI FROM sys_setting S INNER JOIN mst_provinsi P ON S.KEY_VALUE=P.KD_PROVINSI WHERE S.KEY_DATA = 'KD_PROV' AND S.PUSKESMAS='$pid' LIMIT 1) AS PROVINSI, (SELECT P.KABUPATEN FROM sys_setting S INNER JOIN mst_kabupaten P ON S.KEY_VALUE=P.KD_KABUPATEN WHERE S.KEY_DATA = 'KD_KABKOTA' AND S.PUSKESMAS='$pid' LIMIT 1) AS KABKOTA, (SELECT P.KECAMATAN FROM sys_setting S INNER JOIN mst_kecamatan P ON S.KEY_VALUE=P.KD_KECAMATAN WHERE S.KEY_DATA = 'KD_KEC' AND S.PUSKESMAS='$pid' LIMIT 1) AS KECAMATAN, '' AS 'PUSTU_YG_ADA', '' AS 'YANG_LAPOR', 'DARI PARAMETER PHP' AS 'TAHUN', '' AS 'NAMA_MENGETAHUI', '' AS 'NIP_MENGETAHUI', '' AS 'LOKASI', 'TANGGAL HARI INI' AS 'TANGGAL', '' AS 'NAMA_PELAPOR', '' AS 'NIP_PELAPOR', X.* FROM ( SELECT 'I' AS 'GROUP', 'KUNJUNGAN PUSKESMAS' AS 'NAMA_GROUP', 'Jumlah Kunjungan Puskesmas' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM vw_rpt_penyakitpasien_grp AS V WHERE V.KD_PUSKESMAS = '$pid' AND (V.TGL_PELAYANAN BETWEEN '$from' AND '$to') ) AS JUMLAH, 1 AS iRow UNION ALL SELECT 'I' AS 'GROUP', 'KUNJUNGAN PUSKESMAS' AS 'NAMA_GROUP', 'Jumlah Kunjungan dengan Kartu Sehat' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM vw_rpt_penyakitpasien_grp AS V WHERE V.KD_PUSKESMAS = '$pid' AND V.JENIS_PASIEN = 'JAMKESMAS' OR V.JENIS_PASIEN = 'JAMKESDA' AND (V.TGL_PELAYANAN BETWEEN '$from' AND '$to')) AS JUMLAH , 2 AS iRow UNION ALL SELECT 'I' AS 'GROUP', 'KUNJUNGAN PUSKESMAS' AS 'NAMA_GROUP', 'Jumlah Kunjungan Rawat Jalan' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM vw_rpt_penyakitpasien_grp AS V WHERE V.KD_PUSKESMAS = '$pid' AND V.UNIT_PELAYANAN = 'RJ' AND (V.TGL_PELAYANAN BETWEEN '$from' AND '$to') ) AS JUMLAH , 3 AS iRow UNION ALL SELECT 'I' AS 'GROUP', 'KUNJUNGAN PUSKESMAS' AS 'NAMA_GROUP', 'a. Jumlah Kunjungan Rawat Jalan Baru' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM vw_rpt_penyakitpasien_grp AS V WHERE V.KD_PUSKESMAS = '$pid' AND V.UNIT_PELAYANAN = 'RJ' AND V.JNS_KASUS = 'BARU' AND (V.TGL_PELAYANAN BETWEEN '$from' AND '$to') ) AS JUMLAH , 4 as iRow UNION ALL SELECT 'I' AS 'GROUP', 'KUNJUNGAN PUSKESMAS' AS 'NAMA_GROUP', 'b. Jumlah Kunjungan Rawat Jalan Lama' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM vw_rpt_penyakitpasien_grp AS V WHERE V.KD_PUSKESMAS = '$pid' AND V.UNIT_PELAYANAN = 'RJ' AND (V.JNS_KASUS = 'LAMA' OR V.JNS_KASUS IS NULL) AND (V.TGL_PELAYANAN BETWEEN '$from' AND '$to') ) AS JUMLAH , 5 as iRow UNION ALL SELECT 'I' AS 'GROUP', 'KUNJUNGAN PUSKESMAS' AS 'NAMA_GROUP', 'Jumlah Kunjungan Rawat Jalan Gol Umur >=60' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM vw_rpt_penyakitpasien_grp AS V WHERE V.KD_PUSKESMAS = '$pid' AND V.UMURINDAYS >= 21536 AND (V.TGL_PELAYANAN BETWEEN '$from' AND '$to') ) AS JUMLAH , 6 as iRow UNION ALL SELECT 'I' AS 'GROUP', 'KUNJUNGAN PUSKESMAS' AS 'NAMA_GROUP', 'Jumlah Kunjungan Rawat Jalan Gigi' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM vw_rpt_penyakitpasien_grp AS V WHERE V.KD_PUSKESMAS = '$pid' AND V.NM_UNIT = 'GIGI' AND (V.TGL_PELAYANAN BETWEEN '$from' AND '$to') ) AS JUMLAH , 7 as iRow UNION ALL SELECT 'I' AS 'GROUP', 'KUNJUNGAN PUSKESMAS' AS 'NAMA_GROUP', 'Jumlah Kunjungan Polindes' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM vw_rpt_kunjungan AS V WHERE V.KD_PUSKESMAS = '$pid' AND V.KD_UNIT_LAYANAN = 'POLIDES' AND (V.TGL_MASUK BETWEEN '$from' AND '$to') ) AS JUMLAH , 8 as iRow ) X ");//print_r($query);die;
			
			$query[2] = $db->query("select X.* from ( SELECT 'II' AS 'GROUP', 'RAWAT TINGGAL' AS 'NAMA_GROUP', 'Jumlah Penderita yang Dirawat' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM vw_rpt_penyakitpasien_grp AS V WHERE V.KD_PUSKESMAS = '$pid' AND V.UNIT_PELAYANAN = 'RI' AND (V.TGL_PELAYANAN BETWEEN '$from' AND '$to') ) AS JUMLAH, 1 AS iRow UNION ALL SELECT 'II' AS 'GROUP', 'RAWAT TINGGAL' AS 'NAMA_GROUP', 'Jumlah Penderita yang Keluar' AS 'URAIAN', 0 AS JUMLAH , 2 AS iRow UNION ALL SELECT 'II' AS 'GROUP', 'RAWAT TINGGAL' AS 'NAMA_GROUP', 'Jumlah Hari Perawatan' AS 'URAIAN', 0 AS JUMLAH , 3 AS iRow UNION ALL SELECT 'II' AS 'GROUP', 'RAWAT TINGGAL' AS 'NAMA_GROUP', 'Jumlah Ibu Hamil Melahirkan, Nifas dengan Kelainan yang Dirawat' AS 'URAIAN', 0 AS JUMLAH , 4 as iRow UNION ALL SELECT 'II' AS 'GROUP', 'RAWAT TINGGAL' AS 'NAMA_GROUP', 'Jumlah balita (Sakit, dengan kelainan) yang Dirawat' AS 'URAIAN', 0 AS JUMLAH , 5 as iRow UNION ALL SELECT 'II' AS 'GROUP', 'RAWAT TINGGAL' AS 'NAMA_GROUP', 'Jumlah Kasus Cidera/ Kecelakaan yang Dirawat' AS 'URAIAN', 0 AS JUMLAH , 6 as iRow UNION ALL SELECT 'II' AS 'GROUP', 'RAWAT TINGGAL' AS 'NAMA_GROUP', 'Jumlah Penderita dengan Kasus Lainnya' AS 'URAIAN', 0 AS JUMLAH , 7 as iRow ) X");
			$query[3] = $db->query("select X.* from ( SELECT 'III' AS 'GROUP', 'KEGIATAN PERAWATAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Jumlah Keluarga dengan Penderita TB Baru yang Dibina' AS 'URAIAN', 0 AS JUMLAH, 1 AS iRow UNION ALL SELECT 'III' AS 'GROUP', 'KEGIATAN PERAWATAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Jumlah Keluarga dengan Penderita TB Kusta yang Dibina' AS 'URAIAN', 0 AS JUMLAH , 2 AS iRow UNION ALL SELECT 'III' AS 'GROUP', 'KEGIATAN PERAWATAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Jumlah Keluarga dengan Ibu Hamil Melahirkan, Nifas Risti yang Dibina' AS 'URAIAN', 0 AS JUMLAH , 3 AS iRow UNION ALL SELECT 'III' AS 'GROUP', 'KEGIATAN PERAWATAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Jumlah Keluarga dengan Bayi Risti (Pneumonia Berat, BBLR) yang Dibina ' AS 'URAIAN', 0 AS JUMLAH , 4 as iRow UNION ALL SELECT 'III' AS 'GROUP', 'KEGIATAN PERAWATAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Jumlah Keluarga dengan Tetanus Neonatorum' AS 'URAIAN', 0 AS JUMLAH , 5 as iRow UNION ALL SELECT 'III' AS 'GROUP', 'KEGIATAN PERAWATAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Jumlah Keluarga dengan Anak Balita Risti yang Dibina' AS 'URAIAN', 0 AS JUMLAH , 6 as iRow UNION ALL SELECT 'III' AS 'GROUP', 'KEGIATAN PERAWATAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Jumlah Keluarga dengan Usila Balita Risti yang Dibina' AS 'URAIAN', 0 AS JUMLAH , 7 as iRow UNION ALL SELECT 'III' AS 'GROUP', 'KEGIATAN PERAWATAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Jumlah Keluarga dengan Resiko Lainnya yang Dibina' AS 'URAIAN', 0 AS JUMLAH , 8 as iRow UNION ALL SELECT 'III' AS 'GROUP', 'KEGIATAN PERAWATAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Jumlah Keluarga yang Mempunyai Kartu Sehat yang Dibina' AS 'URAIAN', 0 AS JUMLAH , 9 as iRow UNION ALL SELECT 'III' AS 'GROUP', 'KEGIATAN PERAWATAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Jumlah Panti/ Kelompok Khusus yang Dibina' AS 'URAIAN', 0 AS JUMLAH , 10 as iRow ) X");
			$query[4] = $db->query("select X.* from ( SELECT 'IV' AS 'GROUP', 'FREKUENSI KEGIATAN PUSKESMAS DILUAR GEDUNG' AS 'NAMA_GROUP', 'Jumlah Frekuensi Kegiatan Gizi Masyarakat' AS 'URAIAN', 0 AS JUMLAH, 1 AS iRow UNION ALL SELECT 'IV' AS 'GROUP', 'FREKUENSI KEGIATAN PUSKESMAS DILUAR GEDUNG' AS 'NAMA_GROUP', 'Jumlah Frekuensi Kegiatan Imunisasi' AS 'URAIAN', 0 AS JUMLAH , 2 AS iRow UNION ALL SELECT 'IV' AS 'GROUP', 'FREKUENSI KEGIATAN PUSKESMAS DILUAR GEDUNG' AS 'NAMA_GROUP', 'Jumlah Frekuensi Kegiatan Pemberantasan Penyakit' AS 'URAIAN', 0 AS JUMLAH , 3 AS iRow UNION ALL SELECT 'IV' AS 'GROUP', 'FREKUENSI KEGIATAN PUSKESMAS DILUAR GEDUNG' AS 'NAMA_GROUP', 'Jumlah Frekuensi Kegiatan Kesling' AS 'URAIAN', 0 AS JUMLAH , 4 as iRow UNION ALL SELECT 'IV' AS 'GROUP', 'FREKUENSI KEGIATAN PUSKESMAS DILUAR GEDUNG' AS 'NAMA_GROUP', 'Jumlah Frekuensi Kegiatan Promosi Kesehatan' AS 'URAIAN', 0 AS JUMLAH , 5 as iRow ) X");
			$query[5] = $db->query("select X.* from ( SELECT 'V' AS 'GROUP', 'PENDUDUK YANG MENGGUNAKAN SARANAN KESEHATAN SWASTA' AS 'NAMA_GROUP', 'Jumlah Kunjungan pada Praktek Dokter Perorangan' AS 'URAIAN', 0 AS JUMLAH, 1 AS iRow UNION ALL SELECT 'V' AS 'GROUP', 'PENDUDUK YANG MENGGUNAKAN SARANAN KESEHATAN SWASTA' AS 'NAMA_GROUP', 'Jumlah Kunjungan pada Praktek Dokter Gigi Perorangan' AS 'URAIAN', 0 AS JUMLAH , 2 AS iRow UNION ALL SELECT 'V' AS 'GROUP', 'PENDUDUK YANG MENGGUNAKAN SARANAN KESEHATAN SWASTA' AS 'NAMA_GROUP', 'Jumlah Kunjungan pada Praktek Dokter Kelompok/ Bersama' AS 'URAIAN', 0 AS JUMLAH , 3 AS iRow UNION ALL SELECT 'V' AS 'GROUP', 'PENDUDUK YANG MENGGUNAKAN SARANAN KESEHATAN SWASTA' AS 'NAMA_GROUP', 'Jumlah Kunjungan pada Praktek Bidan/ Rumah Bersalin' AS 'URAIAN', 0 AS JUMLAH , 4 as iRow UNION ALL SELECT 'V' AS 'GROUP', 'PENDUDUK YANG MENGGUNAKAN SARANAN KESEHATAN SWASTA' AS 'NAMA_GROUP', 'Jumlah Kunjungan pada Balai Pengobatan/ Klinik Kesehatan' AS 'URAIAN', 0 AS JUMLAH , 5 as iRow ) X");
			$query[6] = $db->query("select X.* from ( SELECT 'VI' AS 'GROUP', 'PELAYANAN MEDIK DASAR KESEHATAN GIGI' AS 'NAMA_GROUP', 'Jumlah Penambahan Gigi Tetap' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM vw_rpt_penyakitpasien_grp AS V WHERE V.KD_PUSKESMAS = '$pid' AND (V.KD_TINDAKAN BETWEEN '36' AND '41') AND (V.TGL_PELAYANAN BETWEEN '$from' AND '$to') ) AS JUMLAH, 1 AS iRow UNION ALL SELECT 'VI' AS 'GROUP', 'PELAYANAN MEDIK DASAR KESEHATAN GIGI' AS 'NAMA_GROUP', 'Jumlah Pencabutan Gigi Tetap' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM vw_rpt_penyakitpasien_grp AS V WHERE V.KD_PUSKESMAS = '$pid' AND V.KD_TINDAKAN ='33' OR V.KD_TINDAKAN ='34' AND (V.TGL_PELAYANAN BETWEEN '$from' AND '$to')) AS JUMLAH , 2 AS iRow UNION ALL SELECT 'VI' AS 'GROUP', 'PELAYANAN MEDIK DASAR KESEHATAN GIGI' AS 'NAMA_GROUP', 'Jumlah Murid SD yang Perlu Perawatan Kesehatan Gigi' AS 'URAIAN', 0 AS JUMLAH , 3 AS iRow UNION ALL SELECT 'VI' AS 'GROUP', 'PELAYANAN MEDIK DASAR KESEHATAN GIGI' AS 'NAMA_GROUP', 'Jumlah Murid SD yang Mendapatkan Perawatan Kesehatan Gigi' AS 'URAIAN', 0 AS JUMLAH , 4 as iRow UNION ALL SELECT 'VI' AS 'GROUP', 'PELAYANAN MEDIK DASAR KESEHATAN GIGI' AS 'NAMA_GROUP', 'Jumlah Perawatan Gigi Lainnya' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM vw_rpt_penyakitpasien_grp AS V WHERE V.KD_PUSKESMAS = '$pid' AND (V.KD_TINDAKAN BETWEEN '29' AND '55') AND (V.KD_TINDAKAN NOT BETWEEN '36' AND '41') AND V.KD_TINDAKAN <> '36' AND V.KD_TINDAKAN <> '41' AND V.KD_TINDAKAN <> NULL AND (V.TGL_PELAYANAN BETWEEN '$from' AND '$to') ) AS JUMLAH , 5 as iRow ) X");
			$query[7] = $db->query("select X.* from (SELECT 'VII' AS 'GROUP', 'KEGIATAN PELAYANAN JPKM' AS 'NAMA_GROUP', 'Jumlah Peserta Askes' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM pasien AS V WHERE V.KD_PUSKESMAS = '$pid' AND V.KD_CUSTOMER = '0000000002' OR V.KD_CUSTOMER = '0000000006' OR V.KD_CUSTOMER = '0000000007' OR V.KD_CUSTOMER = '0000000009' AND (V.TGL_PENDAFTARAN BETWEEN '$from' AND '$to') ) AS JUMLAH, 1 AS iRow UNION ALL SELECT 'VII' AS 'GROUP', 'KEGIATAN PELAYANAN JPKM' AS 'NAMA_GROUP', 'Jumlah Kunjungan Peserta PT. Askes' AS 'URAIAN', 0 AS JUMLAH , 2 AS iRow UNION ALL SELECT 'VII' AS 'GROUP', 'KEGIATAN PELAYANAN JPKM' AS 'NAMA_GROUP', 'Jumlah Peserta Dana Sehat' AS 'URAIAN', 0 AS JUMLAH , 3 AS iRow UNION ALL SELECT 'VII' AS 'GROUP', 'KEGIATAN PELAYANAN JPKM' AS 'NAMA_GROUP', 'Jumlah Kunjungan Peserta Dana Sehat' AS 'URAIAN', 0 AS JUMLAH , 4 as iRow UNION ALL SELECT 'VII' AS 'GROUP', 'KEGIATAN PELAYANAN JPKM' AS 'NAMA_GROUP', 'Jumlah Kunjungan Peserta Asuransi Kesehatan Lainnya' AS 'URAIAN', 0 AS JUMLAH , 5 as iRow UNION ALL SELECT 'VII' AS 'GROUP', 'KEGIATAN PELAYANAN JPKM' AS 'NAMA_GROUP', 'Jumlah Peserta Tabungan Sehat' AS 'URAIAN', 0 AS JUMLAH , 6 as iRow UNION ALL SELECT 'VII' AS 'GROUP', 'KEGIATAN PELAYANAN JPKM' AS 'NAMA_GROUP', 'Jumlah Peserta Tabulin' AS 'URAIAN', 0 AS JUMLAH , 7 as iRow) X");
			$query[8] = $db->query("select X.* from (SELECT 'VIII' AS 'GROUP', 'KEGIATAN SEKOLAH' AS 'NAMA_GROUP', 'Jumlah Sekolah Dasar(SD) dan Madrasah Ibtidaiyah(IM) kelas 1 dengan Kegiatan Penjaringan Kesehatan' AS 'URAIAN', 0 AS JUMLAH, 1 AS iRow UNION ALL SELECT 'VIII' AS 'GROUP', 'KEGIATAN SEKOLAH' AS 'NAMA_GROUP', 'Jumlah Sekolah Dasar(SD) dan Madrasah Ibtidaiyah(IM) dengan Kegiatan UKGS' AS 'URAIAN', 0 AS JUMLAH , 2 AS iRow UNION ALL SELECT 'VIII' AS 'GROUP', 'KEGIATAN SEKOLAH' AS 'NAMA_GROUP', 'Jumlah Sekolah Lanjutan Tingkat Pertama (SLTP) dan Madrasah Tsanawiyah kelas 1 dengan kegiatan penjaringan kesehatan' AS 'URAIAN', 0 AS JUMLAH , 3 AS iRow UNION ALL SELECT 'VIII' AS 'GROUP', 'KEGIATAN SEKOLAH' AS 'NAMA_GROUP', 'Jumlah Sekolah Lanjutan Tingkat Atas (SLTA) dan Madrasah Aliyah kelas 1 dengan kegiatan penjaringan kesehatan' AS 'URAIAN', 0 AS JUMLAH , 4 as iRow UNION ALL SELECT 'VIII' AS 'GROUP', 'KEGIATAN SEKOLAH' AS 'NAMA_GROUP', 'Jumlah sekolah yang diperiksa sarana kesehatan lingkungan (sarana air bersih, pembuangan sampah, jamban dan air limbah)' AS 'URAIAN', 0 AS JUMLAH , 5 as iRow UNION ALL SELECT 'VIII' AS 'GROUP', 'KEGIATAN SEKOLAH' AS 'NAMA_GROUP', 'Jumlah sekolah yang memenuhi syarat kesehatan lingkungan (sarana air bersih, pembuangan sampah, jamban dan air limbah)' AS 'URAIAN', 0 AS JUMLAH , 6 as iRow UNION ALL SELECT 'VIII' AS 'GROUP', 'KEGIATAN SEKOLAH' AS 'NAMA_GROUP', 'Jumlah kunjungan pembianaan UKS ke sekolah' AS 'URAIAN', 0 AS JUMLAH , 7 as iRow UNION ALL SELECT 'VIII' AS 'GROUP', 'KEGIATAN SEKOLAH' AS 'NAMA_GROUP', 'Jumlah SLTP, SLTA memperoleh konseling kesehatan remaja' AS 'URAIAN', 0 AS JUMLAH , 8 as iRow UNION ALL SELECT 'VIII' AS 'GROUP', 'KEGIATAN SEKOLAH' AS 'NAMA_GROUP', 'Jumlah Taman Kanak-Kanak (TK) melaksanakan kesehatan Anak Pra Sekolah' AS 'URAIAN', 0 AS JUMLAH , 9 as iRow) X");
			$query[9] = $db->query("select X.* from (SELECT 'IX' AS 'GROUP', 'KESEHATAN OLAH RAGA' AS 'NAMA_GROUP', 'Jumlah kelompok/klub olah raga yang dibina' AS 'URAIAN', 0 AS JUMLAH, 1 AS iRow UNION ALL SELECT 'IX' AS 'GROUP', 'KESEHATAN OLAH RAGA' AS 'NAMA_GROUP', 'Jumlah yang mendapatkan pelayanan kesehatan olah raga' AS 'URAIAN', 0 AS JUMLAH , 2 AS iRow) X");
			$query[10] = $db->query("select X.* from (SELECT 'X' AS 'GROUP', 'KEGIATAN PENYULUHAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Frekuensi Penyuluhan dalam wilayah puskesmas untuk kel. potensial' AS 'URAIAN', 0 AS JUMLAH, 1 AS iRow UNION ALL SELECT 'X' AS 'GROUP', 'KEGIATAN PENYULUHAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Frekuensi Penyuluhan kelompok dalam puskesmas' AS 'URAIAN', 0 AS JUMLAH , 2 AS iRow UNION ALL SELECT 'X' AS 'GROUP', 'KEGIATAN PENYULUHAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Jumlah desa yang melaksanakan PHBS' AS 'URAIAN', 0 AS JUMLAH, 3 AS iRow UNION ALL SELECT 'X' AS 'GROUP', 'KEGIATAN PENYULUHAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Jumlah penduduk yang merokok' AS 'URAIAN', 0 AS JUMLAH , 4 AS iRow) X");
			$query[11] = $db->query("select X.* from (SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah Posyandu' AS 'URAIAN', 0 AS JUMLAH, 1 AS iRow UNION ALL SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah Posyandu Pratama' AS 'URAIAN', 0 AS JUMLAH , 2 AS iRow UNION ALL SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah Posyandu Madya' AS 'URAIAN', 0 AS JUMLAH, 3 AS iRow UNION ALL SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah Posyandu Purnama' AS 'URAIAN', 0 AS JUMLAH , 4 AS iRow UNION ALL SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah Kader Posyandu' AS 'URAIAN', 0 AS JUMLAH, 5 AS iRow UNION ALL SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah Kader Posyandu yang aktif' AS 'URAIAN', 0 AS JUMLAH , 6 AS iRow UNION ALL SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah tanaman obat keluarga (TOGA)' AS 'URAIAN', 0 AS JUMLAH, 7 AS iRow UNION ALL SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah TOGA Pratama' AS 'URAIAN', 0 AS JUMLAH, 8 AS iRow UNION ALL SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah TOGA Madya' AS 'URAIAN', 0 AS JUMLAH, 9 AS iRow UNION ALL SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah TOGA Purnama' AS 'URAIAN', 0 AS JUMLAH , 10 AS iRow UNION ALL SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah TOGA Mandiri' AS 'URAIAN', 0 AS JUMLAH, 11 AS iRow UNION ALL SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah Posyandu/Kelompok Lansia' AS 'URAIAN', 0 AS JUMLAH , 12 AS iRow UNION ALL SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah Kelompok Remaja' AS 'URAIAN', 0 AS JUMLAH, 13 AS iRow UNION ALL SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah Desa yang melaksanakan PHBS Strata III dan IV' AS 'URAIAN', 0 AS JUMLAH , 14 AS iRow) X");
			$query[12] = $db->query("select X.* from (SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Rumah seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 1 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Rumah yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH , 2 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Rumah yang memenuhi syarat sanitasi dasar' AS 'URAIAN', 0 AS JUMLAH, 3 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Jamban Keluarga Seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 4 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Jamban keluarga yang diperiksa' AS 'URAIAN', 0 AS JUMLAH, 5 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Jamban Keluarga yang memenuhi syarat kesehatan' AS 'URAIAN', 0 AS JUMLAH , 6 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Tempat Sampah Seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 7 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Tempat Sampah yang diperiksa' AS 'URAIAN', 0 AS JUMLAH , 8 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Tempat Sampah yang memenuhi syarat kesehatan' AS 'URAIAN', 0 AS JUMLAH, 9 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Rumah dengan Pengelolaan Air Limbah Seluruhnya' AS 'URAIAN', 0 AS JUMLAH , 10 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Rumah dengan Pengelolaan Air Limbah yang diperiksa' AS 'URAIAN', 0 AS JUMLAH, 11 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Rumah dengan Pengelolaan Air Limbah yang memenuhi syarat kesehatan' AS 'URAIAN', 0 AS JUMLAH ,12 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Sarana AIR Bersih seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 13 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Sarana PDAM seluruhnya' AS 'URAIAN', 0 AS JUMLAH , 14 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Sumur Gali seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 15 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah PAH seluruhnya' AS 'URAIAN', 0 AS JUMLAH , 16 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah SPT seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 17 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah sarana Air Bersih Yang diperiksa' AS 'URAIAN', 0 AS JUMLAH, 18 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah sarana Air Bersih Yang memenuhi syarat kesehatan' AS 'URAIAN', 0 AS JUMLAH, 19 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah sekolah seluruhnya' AS 'URAIAN', 0 AS JUMLAH , 20 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah sekolah yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH, 21 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah sekolah yang memenuhi syarat kesehatan lingkungan' AS 'URAIAN', 0 AS JUMLAH , 22 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Madrasah seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 23 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Madrasah yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH , 24 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Madrasah yang memenuhi syarat kesehatan lingkungan' AS 'URAIAN', 0 AS JUMLAH, 25 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Mesjid seluruhnya' AS 'URAIAN', 0 AS JUMLAH ,26 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Mesjid yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH, 27 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Mesjid yang memenuhi syarat kesehatan lingkungan' AS 'URAIAN', 0 AS JUMLAH , 28 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Gereja seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 29 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Gereja yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH ,30 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Gereja yang memenuhi syarat kesehatan lingkungan ''URAIAN', 0 AS JUMLAH, 31 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Pura seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 32 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Pura yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH, 33 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Pura yang memenuhi syarat kesehatan lingkungan' AS 'URAIAN', 0 AS JUMLAH , 34 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Pesantren seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 35 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Pesantren yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH , 36 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Pesantren yang memenuhi syarat kesehatan lingkungan' AS 'URAIAN', 0 AS JUMLAH, 37 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Majelis Taklim seluruhnya' AS 'URAIAN', 0 AS JUMLAH , 38 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Majelis Taklim yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH, 39 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Majelis Taklim yang memenuhi syarat kesehatan lingkungan' AS 'URAIAN', 0 AS JUMLAH ,40 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Kantor seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 41 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Kantor yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH , 42 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Kantor yang memenuhi syarat kesehatan lingkungan' AS 'URAIAN', 0 AS JUMLAH, 43 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Hotel seluruhnya' AS 'URAIAN', 0 AS JUMLAH , 44 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Hotel yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH, 45 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Hotel yang memenuhi syarat kesehatan lingkungan' AS 'URAIAN', 0 AS JUMLAH, 46 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Toko seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 47 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Toko yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH , 48 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Toko yang memenuhi syarat kesehatan lingkungan' AS 'URAIAN', 0 AS JUMLAH, 49 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Pasar seluruhnya' AS 'URAIAN', 0 AS JUMLAH , 50 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Pasar yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH, 51 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Pasar yang memenuhi syarat kesehatan lingkungan' AS 'URAIAN', 0 AS JUMLAH , 52 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Restoran / R. Makan seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 53 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Restoran / R. Makan yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH ,54 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Restoran / R. Makan yang memenuhi syarat kesehatan lingkungan' AS 'URAIAN', 0 AS JUMLAH, 55 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Salon Kecantikan seluruhnya' AS 'URAIAN', 0 AS JUMLAH , 56 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Salon Kecantikan yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH, 57 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Salon Kecantikan yang memenuhi syarat kesehatan lingkungan' AS 'URAIAN', 0 AS JUMLAH , 58 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah industri rumah tangga makanan dan minuman seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 59 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah industri rumah tangga makanan dan minuman yang diperiksa kesehatan ' AS 'URAIAN', 0 AS JUMLAH , 60 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah industri rumah tangga yang memenuhi syarat kesehatan' AS 'URAIAN', 0 AS JUMLAH, 61 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Tempat Pengelolaan Pestisida ( TP2 )' AS 'URAIAN', 0 AS JUMLAH , 62 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah TP2 yang diperiksa' AS 'URAIAN', 0 AS JUMLAH, 63 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah TP2 yang memenuhi syarat ' AS 'URAIAN', 0 AS JUMLAH , 64 AS iRow) X");
			$query[13] = $db->query("select X.* from (SELECT 'XIII' AS 'GROUP', 'LABORATORIUM' AS 'NAMA_GROUP', 'Jumlah spesimen darah yang diperiksa' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM vw_rpt_lab AS V WHERE V.KD_PUSKESMAS = '$pid' AND (KD_LAB BETWEEN '179' AND '193') AND (V.TGL_PELAYANAN BETWEEN '$from' AND '$to') ) AS JUMLAH ,1 AS iRow UNION ALL SELECT 'XIII' AS 'GROUP', 'LABORATORIUM' AS 'NAMA_GROUP', 'Jumlah spesimen air seni yang diperiksa' AS 'URAIAN', 0 AS JUMLAH, 2 AS iRow UNION ALL SELECT 'XIII' AS 'GROUP', 'LABORATORIUM' AS 'NAMA_GROUP', 'Jumlah spesimen tinja yang diperiksa' AS 'URAIAN', 0 AS JUMLAH , 3 AS iRow UNION ALL SELECT 'XIII' AS 'GROUP', 'LABORATORIUM' AS 'NAMA_GROUP', 'Jumlah pemeriksaan BTA/TBC (sputum)' AS 'URAIAN', 0 AS JUMLAH, 4 AS iRow UNION ALL SELECT 'XIII' AS 'GROUP', 'LABORATORIUM' AS 'NAMA_GROUP', 'Jumlah pemeriksaan BTA/TBC (sputum) positif' AS 'URAIAN', 0 AS JUMLAH , 5 AS iRow UNION ALL SELECT 'XIII' AS 'GROUP', 'LABORATORIUM' AS 'NAMA_GROUP', 'Jumlah pemeriksaan darah untuk Malaria' AS 'URAIAN', 0 AS JUMLAH, 6 AS iRow UNION ALL SELECT 'XIII' AS 'GROUP', 'LABORATORIUM' AS 'NAMA_GROUP', 'Jumlah pemeriksaan darah untuk Malaria positif' AS 'URAIAN', 0 AS JUMLAH , 7 AS iRow UNION ALL SELECT 'XIII' AS 'GROUP', 'LABORATORIUM' AS 'NAMA_GROUP', 'Jumlah pemeriksaan darah untuk Malaria positif P. Falsiparum' AS 'URAIAN', 0 AS JUMLAH, 8 AS iRow UNION ALL SELECT 'XIII' AS 'GROUP', 'LABORATORIUM' AS 'NAMA_GROUP', 'Jumlah pemeriksaan BTA/Kusta (Reitz serum)' AS 'URAIAN', 0 AS JUMLAH , 9 AS iRow UNION ALL SELECT 'XIII' AS 'GROUP', 'LABORATORIUM' AS 'NAMA_GROUP', 'Jumlah pemeriksaan BTA/Kusta (Reitz serum) positif' AS 'URAIAN', 0 AS JUMLAH, 10 AS iRow UNION ALL SELECT 'XIII' AS 'GROUP', 'LABORATORIUM' AS 'NAMA_GROUP', 'Jumlah pemeriksaan Laboratorium lainnya' AS 'URAIAN', 0 AS JUMLAH , 11 AS iRow) X");
			$query[14] = $db->query("select X.* from (SELECT 'XIV' AS 'GROUP', 'JAMINAN MUTU / QUALITY ASSURANCE' AS 'NAMA_GROUP', 'Frekuensi pertemuan jaminan mutu' AS 'URAIAN', 0 AS JUMLAH ,1 AS iRow UNION ALL SELECT 'XIV' AS 'GROUP', 'JAMINAN MUTU / QUALITY ASSURANCE' AS 'NAMA_GROUP', 'Jumlah identifikasi masalah jaminan mutu' AS 'URAIAN', 0 AS JUMLAH, 2 AS iRow UNION ALL SELECT 'XIV' AS 'GROUP', 'JAMINAN MUTU / QUALITY ASSURANCE' AS 'NAMA_GROUP', 'Jumlah audit kasus dalam rangka peningkatan mutu ' AS 'URAIAN', 0 AS JUMLAH , 3 AS iRow UNION ALL SELECT 'XIV' AS 'GROUP', 'JAMINAN MUTU / QUALITY ASSURANCE' AS 'NAMA_GROUP', 'Jumlah seluruh SOP yang telah dibuat sebelumnya' AS 'URAIAN', 0 AS JUMLAH, 4 AS iRow UNION ALL SELECT 'XIV' AS 'GROUP', 'JAMINAN MUTU / QUALITY ASSURANCE' AS 'NAMA_GROUP', 'Jumlah SOP yang telah dibuat bulan ini' AS 'URAIAN', 0 AS JUMLAH , 5 AS iRow UNION ALL SELECT 'XIV' AS 'GROUP', 'JAMINAN MUTU / QUALITY ASSURANCE' AS 'NAMA_GROUP', 'Jumlah SOP yang telah dikembangkan' AS 'URAIAN', 0 AS JUMLAH, 6 AS iRow UNION ALL SELECT 'XIV' AS 'GROUP', 'JAMINAN MUTU / QUALITY ASSURANCE' AS 'NAMA_GROUP', 'Jumlah seluruh daftar tilik yang telah dibuat sebelumnya' AS 'URAIAN', 0 AS JUMLAH , 7 AS iRow UNION ALL SELECT 'XIV' AS 'GROUP', 'JAMINAN MUTU / QUALITY ASSURANCE' AS 'NAMA_GROUP', 'Jumlah daftar tilik yang telah dibuat bulan ini' AS 'URAIAN', 0 AS JUMLAH, 8 AS iRow UNION ALL SELECT 'XIV' AS 'GROUP', 'JAMINAN MUTU / QUALITY ASSURANCE' AS 'NAMA_GROUP', 'Jumlah survey kepatuhan/tilik kepatuhan terhadap SOP' AS 'URAIAN', 0 AS JUMLAH , 9 AS iRow UNION ALL SELECT 'XIV' AS 'GROUP', 'JAMINAN MUTU / QUALITY ASSURANCE' AS 'NAMA_GROUP', 'Jumlah survey kepuasan pelanggan bulan ini' AS 'URAIAN', 0 AS JUMLAH, 10 AS iRow) X");
			if($query[1]->num_rows>0){
				//$data2 = $query2->result(); //print_r($data);die;
				
				/*if(!$data)
					return false;
				*/
				// Starting the PHPExcel library
				$this->load->library('Excel');
				$this->excel->getActiveSheet()->setTitle('LB4');
				$this->excel->getProperties()->setTitle("export")->setDescription("none");
				
				$objReader = PHPExcel_IOFactory::createReader('Excel5');
				$objPHPExcel = $objReader->load("tmp/laporan_lb4.xls");
				$objPHPExcel->setActiveSheetIndex(0);
					
				//$no=1;
				$total=0;
				for($no=1;$no<15;$no++){
				$data = $query[$no]->result();
				$rw=array('',10,20,29,41,48,55,62,71,82,86,92,108,174,187,199);
				$rw2=array('',9,19,28,40,47,54,61,70,81,85,91,107,173,186,198);
				foreach($data as $value)
				{
					$styleArray = array(
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
							),
						),
					);
					$objPHPExcel->getActiveSheet()->getStyle('A'.($rw[$no]-1).':E'.$rw[$no])->applyFromArray($styleArray);

					$objPHPExcel->getActiveSheet()->mergeCells('B'.$rw[$no].':D'.$rw[$no]);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$rw[$no])->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$rw[$no])->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->setTitle('Data')
						->setCellValue('A'.$rw[$no], $value->iRow)
						->setCellValue('B'.$rw[$no], '   '.$value->URAIAN)
						->setCellValue('E'.$rw[$no], $value->JUMLAH);
					//$rw++;
					$rw[$no]++;
				}
				$objPHPExcel->getActiveSheet()->getStyle('A'.($rw2[$no]).':E'.($rw2[$no]))->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->mergeCells('B'.($rw2[$no]).':D'.($rw2[$no]));
				$objPHPExcel->getActiveSheet()->getStyle('A'.($rw2[$no]))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('E'.($rw2[$no]))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()
					->setCellValue('A'.($rw2[$no]), $value->GROUP)
					->setCellValue('B'.($rw2[$no]), $value->NAMA_GROUP)
					->setCellValue('E'.($rw2[$no]), 'JUMLAH')
					;
					
				}
				$data1 = $query[1]->result();
				foreach($data1 as $value1){
					$objPHPExcel->getActiveSheet()->getStyle('E198:E202')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$objPHPExcel->getActiveSheet()
						->setCellValue('E198', 'KEPALA PUSKESMAS')
						->setCellValue('E202', $value1->KEPALA_PUSKESMAS)
						->setCellValue('C5', $pid)
						->setCellValue('C6', $value1->NAMA_PUSKESMAS)
						->setCellValue('C7', $value1->KABKOTA)
						->setCellValue('E6', $value1->dt1.' / '.$value1->dt2);
				}
				$filename='laporan_lb4_'.date('dmY_his_').'.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
				
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				$objWriter->save('php://output');
			}else{
				die('Tidak Ada Dalam Database');
			}
		}else{
			$query[1] = $db->query("SELECT '$from' as dt1, '$to' as dt2,(SELECT P.PROVINSI FROM sys_setting S INNER JOIN mst_provinsi  P
			ON S.KEY_VALUE=P.KD_PROVINSI WHERE S.KEY_DATA = 'KD_PROV' AND SUBSTRING(S.PUSKESMAS,2,4)='$pid' LIMIT 1) AS PROVINSI,
			(SELECT P.KABUPATEN FROM sys_setting S INNER JOIN mst_kabupaten  P ON S.KEY_VALUE=P.KD_KABUPATEN WHERE
			S.KEY_DATA = 'KD_KABKOTA' AND SUBSTRING(S.PUSKESMAS,2,4)='$pid' LIMIT 1) AS KABKOTA,(SELECT P.KECAMATAN FROM sys_setting S INNER JOIN mst_kecamatan  P ON S.KEY_VALUE=P.KD_KECAMATAN WHERE S.KEY_DATA = 'KD_KEC' AND SUBSTRING(S.PUSKESMAS,2,4)='$pid' LIMIT 1) AS KECAMATAN,
			 '' AS 'PUSTU_YG_ADA', '' AS 'YANG_LAPOR', 'DARI PARAMETER PHP' AS 'TAHUN', '' AS 'NAMA_MENGETAHUI', '' AS 'NIP_MENGETAHUI', '' AS 'LOKASI',
			 'TANGGAL HARI INI' AS 'TANGGAL', '' AS 'NAMA_PELAPOR', '' AS 'NIP_PELAPOR', X.* FROM (SELECT 'I' AS 'GROUP', 'KUNJUNGAN PUSKESMAS' AS 'NAMA_GROUP', 'Jumlah Kunjungan Puskesmas' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM vw_rpt_penyakitpasien_grp AS V WHERE SUBSTRING(V.KD_PUSKESMAS,2,4) = '$pid' AND V.TGL_PELAYANAN BETWEEN '$from' AND '$to' ) AS JUMLAH, 1 AS iRow UNION ALL
			SELECT 'I' AS 'GROUP', 'KUNJUNGAN PUSKESMAS' AS 'NAMA_GROUP', 'Jumlah Kunjungan dengan Kartu Sehat' AS 'URAIAN', (SELECT
			COUNT(V.KD_PASIEN) as JML FROM vw_rpt_penyakitpasien_grp AS V WHERE SUBSTRING(V.KD_PUSKESMAS,2,4) = '$pid' AND V.JENIS_PASIEN = 'JAMKESMAS' OR V.JENIS_PASIEN = 'JAMKESDA' AND (V.TGL_PELAYANAN BETWEEN '$from' AND '$to')) AS JUMLAH , 2 AS iRow	UNION ALL SELECT 'I' AS 'GROUP', 'KUNJUNGAN PUSKESMAS' AS 'NAMA_GROUP', 'Jumlah Kunjungan Rawat Jalan' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM vw_rpt_penyakitpasien_grp AS V WHERE SUBSTRING(V.KD_PUSKESMAS,2,4) = '$pid'	AND V.UNIT_PELAYANAN = 'RJ'	AND (V.TGL_PELAYANAN BETWEEN 
			'$from' AND '$to') ) AS JUMLAH , 3 AS iRow UNION ALL SELECT 'I' AS 'GROUP', 'KUNJUNGAN PUSKESMAS' AS 'NAMA_GROUP', 'a. Jumlah Kunjungan Rawat Jalan Baru' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM vw_rpt_penyakitpasien_grp AS V 
			WHERE SUBSTRING(V.KD_PUSKESMAS,2,4) = '$pid' AND V.UNIT_PELAYANAN = 'RJ' AND V.JNS_KASUS = 'BARU' AND (V.TGL_PELAYANAN BETWEEN '$from' AND '$to') ) AS JUMLAH , 4 as iRow	UNION ALL SELECT 'I' AS 'GROUP', 'KUNJUNGAN PUSKESMAS' AS 'NAMA_GROUP', 'b. Jumlah Kunjungan Rawat Jalan Lama' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM vw_rpt_penyakitpasien_grp AS V WHERE SUBSTRING(V.KD_PUSKESMAS,2,4) = '$pid'
			AND V.UNIT_PELAYANAN = 'RJ'	AND (V.JNS_KASUS = 'LAMA' OR V.JNS_KASUS IS NULL) AND (V.TGL_PELAYANAN BETWEEN '$from' AND '$to') ) AS JUMLAH , 5 as iRow	UNION ALL SELECT 'I' AS 'GROUP', 'KUNJUNGAN PUSKESMAS' AS 'NAMA_GROUP', 'Jumlah Kunjungan Rawat Jalan Gol Umur >=60' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM vw_rpt_penyakitpasien_grp AS V WHERE SUBSTRING(V.KD_PUSKESMAS,2,4) = '$pid' AND V.UMURINDAYS >= 21536 AND (V.TGL_PELAYANAN BETWEEN '$from' AND '$to') ) AS JUMLAH , 6 as iRow UNION ALL SELECT 'I' AS 'GROUP', 'KUNJUNGAN PUSKESMAS' AS 'NAMA_GROUP', 'Jumlah Kunjungan Rawat Jalan Gigi' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM vw_rpt_penyakitpasien_grp AS V	WHERE SUBSTRING(V.KD_PUSKESMAS,2,4) = '$pid' AND V.NM_UNIT = 'GIGI'	AND (V.TGL_PELAYANAN BETWEEN '$from' AND '$to') ) AS JUMLAH , 7 as iRow UNION ALL SELECT 'I' AS 'GROUP', 'KUNJUNGAN PUSKESMAS' AS 'NAMA_GROUP', 'Jumlah Kunjungan Polindes' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM vw_rpt_kunjungan AS V	WHERE SUBSTRING(V.KD_PUSKESMAS,2,4) = '$pid' AND V.KD_UNIT_LAYANAN = 'POLIDES' AND (V.TGL_MASUK BETWEEN '$from' AND '$to') ) AS JUMLAH , 8 as iRow ) X ");//print_r($query);die;
			
			$query[2] = $db->query("select X.* from ( SELECT 'II' AS 'GROUP', 'RAWAT TINGGAL' AS 'NAMA_GROUP', 'Jumlah Penderita yang Dirawat' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM vw_rpt_penyakitpasien_grp AS V WHERE V.KD_PUSKESMAS = '$pid' AND V.UNIT_PELAYANAN = 'RI' AND (V.TGL_PELAYANAN BETWEEN '$from' AND '$to') ) AS JUMLAH, 1 AS iRow UNION ALL SELECT 'II' AS 'GROUP', 'RAWAT TINGGAL' AS 'NAMA_GROUP', 'Jumlah Penderita yang Keluar' AS 'URAIAN', 0 AS JUMLAH , 2 AS iRow UNION ALL SELECT 'II' AS 'GROUP', 'RAWAT TINGGAL' AS 'NAMA_GROUP', 'Jumlah Hari Perawatan' AS 'URAIAN', 0 AS JUMLAH , 3 AS iRow UNION ALL SELECT 'II' AS 'GROUP', 'RAWAT TINGGAL' AS 'NAMA_GROUP', 'Jumlah Ibu Hamil Melahirkan, Nifas dengan Kelainan yang Dirawat' AS 'URAIAN', 0 AS JUMLAH , 4 as iRow UNION ALL SELECT 'II' AS 'GROUP', 'RAWAT TINGGAL' AS 'NAMA_GROUP', 'Jumlah balita (Sakit, dengan kelainan) yang Dirawat' AS 'URAIAN', 0 AS JUMLAH , 5 as iRow UNION ALL SELECT 'II' AS 'GROUP', 'RAWAT TINGGAL' AS 'NAMA_GROUP', 'Jumlah Kasus Cidera/ Kecelakaan yang Dirawat' AS 'URAIAN', 0 AS JUMLAH , 6 as iRow UNION ALL SELECT 'II' AS 'GROUP', 'RAWAT TINGGAL' AS 'NAMA_GROUP', 'Jumlah Penderita dengan Kasus Lainnya' AS 'URAIAN', 0 AS JUMLAH , 7 as iRow ) X");
			$query[3] = $db->query("select X.* from ( SELECT 'III' AS 'GROUP', 'KEGIATAN PERAWATAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Jumlah Keluarga dengan Penderita TB Baru yang Dibina' AS 'URAIAN', 0 AS JUMLAH, 1 AS iRow UNION ALL SELECT 'III' AS 'GROUP', 'KEGIATAN PERAWATAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Jumlah Keluarga dengan Penderita TB Kusta yang Dibina' AS 'URAIAN', 0 AS JUMLAH , 2 AS iRow UNION ALL SELECT 'III' AS 'GROUP', 'KEGIATAN PERAWATAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Jumlah Keluarga dengan Ibu Hamil Melahirkan, Nifas Risti yang Dibina' AS 'URAIAN', 0 AS JUMLAH , 3 AS iRow UNION ALL SELECT 'III' AS 'GROUP', 'KEGIATAN PERAWATAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Jumlah Keluarga dengan Bayi Risti (Pneumonia Berat, BBLR) yang Dibina ' AS 'URAIAN', 0 AS JUMLAH , 4 as iRow UNION ALL SELECT 'III' AS 'GROUP', 'KEGIATAN PERAWATAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Jumlah Keluarga dengan Tetanus Neonatorum' AS 'URAIAN', 0 AS JUMLAH , 5 as iRow UNION ALL SELECT 'III' AS 'GROUP', 'KEGIATAN PERAWATAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Jumlah Keluarga dengan Anak Balita Risti yang Dibina' AS 'URAIAN', 0 AS JUMLAH , 6 as iRow UNION ALL SELECT 'III' AS 'GROUP', 'KEGIATAN PERAWATAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Jumlah Keluarga dengan Usila Balita Risti yang Dibina' AS 'URAIAN', 0 AS JUMLAH , 7 as iRow UNION ALL SELECT 'III' AS 'GROUP', 'KEGIATAN PERAWATAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Jumlah Keluarga dengan Resiko Lainnya yang Dibina' AS 'URAIAN', 0 AS JUMLAH , 8 as iRow UNION ALL SELECT 'III' AS 'GROUP', 'KEGIATAN PERAWATAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Jumlah Keluarga yang Mempunyai Kartu Sehat yang Dibina' AS 'URAIAN', 0 AS JUMLAH , 9 as iRow UNION ALL SELECT 'III' AS 'GROUP', 'KEGIATAN PERAWATAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Jumlah Panti/ Kelompok Khusus yang Dibina' AS 'URAIAN', 0 AS JUMLAH , 10 as iRow ) X");
			$query[4] = $db->query("select X.* from ( SELECT 'IV' AS 'GROUP', 'FREKUENSI KEGIATAN PUSKESMAS DILUAR GEDUNG' AS 'NAMA_GROUP', 'Jumlah Frekuensi Kegiatan Gizi Masyarakat' AS 'URAIAN', 0 AS JUMLAH, 1 AS iRow UNION ALL SELECT 'IV' AS 'GROUP', 'FREKUENSI KEGIATAN PUSKESMAS DILUAR GEDUNG' AS 'NAMA_GROUP', 'Jumlah Frekuensi Kegiatan Imunisasi' AS 'URAIAN', 0 AS JUMLAH , 2 AS iRow UNION ALL SELECT 'IV' AS 'GROUP', 'FREKUENSI KEGIATAN PUSKESMAS DILUAR GEDUNG' AS 'NAMA_GROUP', 'Jumlah Frekuensi Kegiatan Pemberantasan Penyakit' AS 'URAIAN', 0 AS JUMLAH , 3 AS iRow UNION ALL SELECT 'IV' AS 'GROUP', 'FREKUENSI KEGIATAN PUSKESMAS DILUAR GEDUNG' AS 'NAMA_GROUP', 'Jumlah Frekuensi Kegiatan Kesling' AS 'URAIAN', 0 AS JUMLAH , 4 as iRow UNION ALL SELECT 'IV' AS 'GROUP', 'FREKUENSI KEGIATAN PUSKESMAS DILUAR GEDUNG' AS 'NAMA_GROUP', 'Jumlah Frekuensi Kegiatan Promosi Kesehatan' AS 'URAIAN', 0 AS JUMLAH , 5 as iRow ) X");
			$query[5] = $db->query("select X.* from ( SELECT 'V' AS 'GROUP', 'PENDUDUK YANG MENGGUNAKAN SARANAN KESEHATAN SWASTA' AS 'NAMA_GROUP', 'Jumlah Kunjungan pada Praktek Dokter Perorangan' AS 'URAIAN', 0 AS JUMLAH, 1 AS iRow UNION ALL SELECT 'V' AS 'GROUP', 'PENDUDUK YANG MENGGUNAKAN SARANAN KESEHATAN SWASTA' AS 'NAMA_GROUP', 'Jumlah Kunjungan pada Praktek Dokter Gigi Perorangan' AS 'URAIAN', 0 AS JUMLAH , 2 AS iRow UNION ALL SELECT 'V' AS 'GROUP', 'PENDUDUK YANG MENGGUNAKAN SARANAN KESEHATAN SWASTA' AS 'NAMA_GROUP', 'Jumlah Kunjungan pada Praktek Dokter Kelompok/ Bersama' AS 'URAIAN', 0 AS JUMLAH , 3 AS iRow UNION ALL SELECT 'V' AS 'GROUP', 'PENDUDUK YANG MENGGUNAKAN SARANAN KESEHATAN SWASTA' AS 'NAMA_GROUP', 'Jumlah Kunjungan pada Praktek Bidan/ Rumah Bersalin' AS 'URAIAN', 0 AS JUMLAH , 4 as iRow UNION ALL SELECT 'V' AS 'GROUP', 'PENDUDUK YANG MENGGUNAKAN SARANAN KESEHATAN SWASTA' AS 'NAMA_GROUP', 'Jumlah Kunjungan pada Balai Pengobatan/ Klinik Kesehatan' AS 'URAIAN', 0 AS JUMLAH , 5 as iRow ) X");
			$query[6] = $db->query("select X.* from ( SELECT 'VI' AS 'GROUP', 'PELAYANAN MEDIK DASAR KESEHATAN GIGI' AS 'NAMA_GROUP', 'Jumlah Penambahan Gigi Tetap' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM vw_rpt_penyakitpasien_grp AS V WHERE V.KD_PUSKESMAS = '$pid' AND (V.KD_TINDAKAN BETWEEN '36' AND '41') AND (V.TGL_PELAYANAN BETWEEN '$from' AND '$to') ) AS JUMLAH, 1 AS iRow UNION ALL SELECT 'VI' AS 'GROUP', 'PELAYANAN MEDIK DASAR KESEHATAN GIGI' AS 'NAMA_GROUP', 'Jumlah Pencabutan Gigi Tetap' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM vw_rpt_penyakitpasien_grp AS V WHERE V.KD_PUSKESMAS = '$pid' AND V.KD_TINDAKAN ='33' OR V.KD_TINDAKAN ='34' AND (V.TGL_PELAYANAN BETWEEN '$from' AND '$to')) AS JUMLAH , 2 AS iRow UNION ALL SELECT 'VI' AS 'GROUP', 'PELAYANAN MEDIK DASAR KESEHATAN GIGI' AS 'NAMA_GROUP', 'Jumlah Murid SD yang Perlu Perawatan Kesehatan Gigi' AS 'URAIAN', 0 AS JUMLAH , 3 AS iRow UNION ALL SELECT 'VI' AS 'GROUP', 'PELAYANAN MEDIK DASAR KESEHATAN GIGI' AS 'NAMA_GROUP', 'Jumlah Murid SD yang Mendapatkan Perawatan Kesehatan Gigi' AS 'URAIAN', 0 AS JUMLAH , 4 as iRow UNION ALL SELECT 'VI' AS 'GROUP', 'PELAYANAN MEDIK DASAR KESEHATAN GIGI' AS 'NAMA_GROUP', 'Jumlah Perawatan Gigi Lainnya' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM vw_rpt_penyakitpasien_grp AS V WHERE V.KD_PUSKESMAS = '$pid' AND (V.KD_TINDAKAN BETWEEN '29' AND '55') AND (V.KD_TINDAKAN NOT BETWEEN '36' AND '41') AND V.KD_TINDAKAN <> '36' AND V.KD_TINDAKAN <> '41' AND V.KD_TINDAKAN <> NULL AND (V.TGL_PELAYANAN BETWEEN '$from' AND '$to') ) AS JUMLAH , 5 as iRow ) X");
			$query[7] = $db->query("select X.* from (SELECT 'VII' AS 'GROUP', 'KEGIATAN PELAYANAN JPKM' AS 'NAMA_GROUP', 'Jumlah Peserta Askes' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM pasien AS V WHERE V.KD_PUSKESMAS = '$pid' AND V.KD_CUSTOMER = '0000000002' OR V.KD_CUSTOMER = '0000000006' OR V.KD_CUSTOMER = '0000000007' OR V.KD_CUSTOMER = '0000000009' AND (V.TGL_PENDAFTARAN BETWEEN '$from' AND '$to') ) AS JUMLAH, 1 AS iRow UNION ALL SELECT 'VII' AS 'GROUP', 'KEGIATAN PELAYANAN JPKM' AS 'NAMA_GROUP', 'Jumlah Kunjungan Peserta PT. Askes' AS 'URAIAN', 0 AS JUMLAH , 2 AS iRow UNION ALL SELECT 'VII' AS 'GROUP', 'KEGIATAN PELAYANAN JPKM' AS 'NAMA_GROUP', 'Jumlah Peserta Dana Sehat' AS 'URAIAN', 0 AS JUMLAH , 3 AS iRow UNION ALL SELECT 'VII' AS 'GROUP', 'KEGIATAN PELAYANAN JPKM' AS 'NAMA_GROUP', 'Jumlah Kunjungan Peserta Dana Sehat' AS 'URAIAN', 0 AS JUMLAH , 4 as iRow UNION ALL SELECT 'VII' AS 'GROUP', 'KEGIATAN PELAYANAN JPKM' AS 'NAMA_GROUP', 'Jumlah Kunjungan Peserta Asuransi Kesehatan Lainnya' AS 'URAIAN', 0 AS JUMLAH , 5 as iRow UNION ALL SELECT 'VII' AS 'GROUP', 'KEGIATAN PELAYANAN JPKM' AS 'NAMA_GROUP', 'Jumlah Peserta Tabungan Sehat' AS 'URAIAN', 0 AS JUMLAH , 6 as iRow UNION ALL SELECT 'VII' AS 'GROUP', 'KEGIATAN PELAYANAN JPKM' AS 'NAMA_GROUP', 'Jumlah Peserta Tabulin' AS 'URAIAN', 0 AS JUMLAH , 7 as iRow) X");
			$query[8] = $db->query("select X.* from (SELECT 'VIII' AS 'GROUP', 'KEGIATAN SEKOLAH' AS 'NAMA_GROUP', 'Jumlah Sekolah Dasar(SD) dan Madrasah Ibtidaiyah(IM) kelas 1 dengan Kegiatan Penjaringan Kesehatan' AS 'URAIAN', 0 AS JUMLAH, 1 AS iRow UNION ALL SELECT 'VIII' AS 'GROUP', 'KEGIATAN SEKOLAH' AS 'NAMA_GROUP', 'Jumlah Sekolah Dasar(SD) dan Madrasah Ibtidaiyah(IM) dengan Kegiatan UKGS' AS 'URAIAN', 0 AS JUMLAH , 2 AS iRow UNION ALL SELECT 'VIII' AS 'GROUP', 'KEGIATAN SEKOLAH' AS 'NAMA_GROUP', 'Jumlah Sekolah Lanjutan Tingkat Pertama (SLTP) dan Madrasah Tsanawiyah kelas 1 dengan kegiatan penjaringan kesehatan' AS 'URAIAN', 0 AS JUMLAH , 3 AS iRow UNION ALL SELECT 'VIII' AS 'GROUP', 'KEGIATAN SEKOLAH' AS 'NAMA_GROUP', 'Jumlah Sekolah Lanjutan Tingkat Atas (SLTA) dan Madrasah Aliyah kelas 1 dengan kegiatan penjaringan kesehatan' AS 'URAIAN', 0 AS JUMLAH , 4 as iRow UNION ALL SELECT 'VIII' AS 'GROUP', 'KEGIATAN SEKOLAH' AS 'NAMA_GROUP', 'Jumlah sekolah yang diperiksa sarana kesehatan lingkungan (sarana air bersih, pembuangan sampah, jamban dan air limbah)' AS 'URAIAN', 0 AS JUMLAH , 5 as iRow UNION ALL SELECT 'VIII' AS 'GROUP', 'KEGIATAN SEKOLAH' AS 'NAMA_GROUP', 'Jumlah sekolah yang memenuhi syarat kesehatan lingkungan (sarana air bersih, pembuangan sampah, jamban dan air limbah)' AS 'URAIAN', 0 AS JUMLAH , 6 as iRow UNION ALL SELECT 'VIII' AS 'GROUP', 'KEGIATAN SEKOLAH' AS 'NAMA_GROUP', 'Jumlah kunjungan pembianaan UKS ke sekolah' AS 'URAIAN', 0 AS JUMLAH , 7 as iRow UNION ALL SELECT 'VIII' AS 'GROUP', 'KEGIATAN SEKOLAH' AS 'NAMA_GROUP', 'Jumlah SLTP, SLTA memperoleh konseling kesehatan remaja' AS 'URAIAN', 0 AS JUMLAH , 8 as iRow UNION ALL SELECT 'VIII' AS 'GROUP', 'KEGIATAN SEKOLAH' AS 'NAMA_GROUP', 'Jumlah Taman Kanak-Kanak (TK) melaksanakan kesehatan Anak Pra Sekolah' AS 'URAIAN', 0 AS JUMLAH , 9 as iRow) X");
			$query[9] = $db->query("select X.* from (SELECT 'IX' AS 'GROUP', 'KESEHATAN OLAH RAGA' AS 'NAMA_GROUP', 'Jumlah kelompok/klub olah raga yang dibina' AS 'URAIAN', 0 AS JUMLAH, 1 AS iRow UNION ALL SELECT 'IX' AS 'GROUP', 'KESEHATAN OLAH RAGA' AS 'NAMA_GROUP', 'Jumlah yang mendapatkan pelayanan kesehatan olah raga' AS 'URAIAN', 0 AS JUMLAH , 2 AS iRow) X");
			$query[10] = $db->query("select X.* from (SELECT 'X' AS 'GROUP', 'KEGIATAN PENYULUHAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Frekuensi Penyuluhan dalam wilayah puskesmas untuk kel. potensial' AS 'URAIAN', 0 AS JUMLAH, 1 AS iRow UNION ALL SELECT 'X' AS 'GROUP', 'KEGIATAN PENYULUHAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Frekuensi Penyuluhan kelompok dalam puskesmas' AS 'URAIAN', 0 AS JUMLAH , 2 AS iRow UNION ALL SELECT 'X' AS 'GROUP', 'KEGIATAN PENYULUHAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Jumlah desa yang melaksanakan PHBS' AS 'URAIAN', 0 AS JUMLAH, 3 AS iRow UNION ALL SELECT 'X' AS 'GROUP', 'KEGIATAN PENYULUHAN KESEHATAN MASYARAKAT' AS 'NAMA_GROUP', 'Jumlah penduduk yang merokok' AS 'URAIAN', 0 AS JUMLAH , 4 AS iRow) X");
			$query[11] = $db->query("select X.* from (SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah Posyandu' AS 'URAIAN', 0 AS JUMLAH, 1 AS iRow UNION ALL SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah Posyandu Pratama' AS 'URAIAN', 0 AS JUMLAH , 2 AS iRow UNION ALL SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah Posyandu Madya' AS 'URAIAN', 0 AS JUMLAH, 3 AS iRow UNION ALL SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah Posyandu Purnama' AS 'URAIAN', 0 AS JUMLAH , 4 AS iRow UNION ALL SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah Kader Posyandu' AS 'URAIAN', 0 AS JUMLAH, 5 AS iRow UNION ALL SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah Kader Posyandu yang aktif' AS 'URAIAN', 0 AS JUMLAH , 6 AS iRow UNION ALL SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah tanaman obat keluarga (TOGA)' AS 'URAIAN', 0 AS JUMLAH, 7 AS iRow UNION ALL SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah TOGA Pratama' AS 'URAIAN', 0 AS JUMLAH, 8 AS iRow UNION ALL SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah TOGA Madya' AS 'URAIAN', 0 AS JUMLAH, 9 AS iRow UNION ALL SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah TOGA Purnama' AS 'URAIAN', 0 AS JUMLAH , 10 AS iRow UNION ALL SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah TOGA Mandiri' AS 'URAIAN', 0 AS JUMLAH, 11 AS iRow UNION ALL SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah Posyandu/Kelompok Lansia' AS 'URAIAN', 0 AS JUMLAH , 12 AS iRow UNION ALL SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah Kelompok Remaja' AS 'URAIAN', 0 AS JUMLAH, 13 AS iRow UNION ALL SELECT 'XI' AS 'GROUP', 'KEGIATAN UKBM' AS 'NAMA_GROUP', 'Jumlah Desa yang melaksanakan PHBS Strata III dan IV' AS 'URAIAN', 0 AS JUMLAH , 14 AS iRow) X");
			$query[12] = $db->query("select X.* from (SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Rumah seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 1 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Rumah yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH , 2 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Rumah yang memenuhi syarat sanitasi dasar' AS 'URAIAN', 0 AS JUMLAH, 3 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Jamban Keluarga Seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 4 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Jamban keluarga yang diperiksa' AS 'URAIAN', 0 AS JUMLAH, 5 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Jamban Keluarga yang memenuhi syarat kesehatan' AS 'URAIAN', 0 AS JUMLAH , 6 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Tempat Sampah Seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 7 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Tempat Sampah yang diperiksa' AS 'URAIAN', 0 AS JUMLAH , 8 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Tempat Sampah yang memenuhi syarat kesehatan' AS 'URAIAN', 0 AS JUMLAH, 9 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Rumah dengan Pengelolaan Air Limbah Seluruhnya' AS 'URAIAN', 0 AS JUMLAH , 10 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Rumah dengan Pengelolaan Air Limbah yang diperiksa' AS 'URAIAN', 0 AS JUMLAH, 11 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Rumah dengan Pengelolaan Air Limbah yang memenuhi syarat kesehatan' AS 'URAIAN', 0 AS JUMLAH ,12 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Sarana AIR Bersih seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 13 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Sarana PDAM seluruhnya' AS 'URAIAN', 0 AS JUMLAH , 14 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Sumur Gali seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 15 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah PAH seluruhnya' AS 'URAIAN', 0 AS JUMLAH , 16 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah SPT seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 17 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah sarana Air Bersih Yang diperiksa' AS 'URAIAN', 0 AS JUMLAH, 18 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah sarana Air Bersih Yang memenuhi syarat kesehatan' AS 'URAIAN', 0 AS JUMLAH, 19 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah sekolah seluruhnya' AS 'URAIAN', 0 AS JUMLAH , 20 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah sekolah yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH, 21 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah sekolah yang memenuhi syarat kesehatan lingkungan' AS 'URAIAN', 0 AS JUMLAH , 22 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Madrasah seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 23 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Madrasah yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH , 24 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Madrasah yang memenuhi syarat kesehatan lingkungan' AS 'URAIAN', 0 AS JUMLAH, 25 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Mesjid seluruhnya' AS 'URAIAN', 0 AS JUMLAH ,26 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Mesjid yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH, 27 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Mesjid yang memenuhi syarat kesehatan lingkungan' AS 'URAIAN', 0 AS JUMLAH , 28 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Gereja seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 29 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Gereja yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH ,30 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Gereja yang memenuhi syarat kesehatan lingkungan ''URAIAN', 0 AS JUMLAH, 31 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Pura seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 32 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Pura yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH, 33 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Pura yang memenuhi syarat kesehatan lingkungan' AS 'URAIAN', 0 AS JUMLAH , 34 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Pesantren seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 35 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Pesantren yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH , 36 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Pesantren yang memenuhi syarat kesehatan lingkungan' AS 'URAIAN', 0 AS JUMLAH, 37 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Majelis Taklim seluruhnya' AS 'URAIAN', 0 AS JUMLAH , 38 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Majelis Taklim yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH, 39 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Majelis Taklim yang memenuhi syarat kesehatan lingkungan' AS 'URAIAN', 0 AS JUMLAH ,40 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Kantor seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 41 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Kantor yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH , 42 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Kantor yang memenuhi syarat kesehatan lingkungan' AS 'URAIAN', 0 AS JUMLAH, 43 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Hotel seluruhnya' AS 'URAIAN', 0 AS JUMLAH , 44 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Hotel yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH, 45 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Hotel yang memenuhi syarat kesehatan lingkungan' AS 'URAIAN', 0 AS JUMLAH, 46 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Toko seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 47 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Toko yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH , 48 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Toko yang memenuhi syarat kesehatan lingkungan' AS 'URAIAN', 0 AS JUMLAH, 49 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Pasar seluruhnya' AS 'URAIAN', 0 AS JUMLAH , 50 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Pasar yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH, 51 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Pasar yang memenuhi syarat kesehatan lingkungan' AS 'URAIAN', 0 AS JUMLAH , 52 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Restoran / R. Makan seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 53 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Restoran / R. Makan yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH ,54 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Restoran / R. Makan yang memenuhi syarat kesehatan lingkungan' AS 'URAIAN', 0 AS JUMLAH, 55 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Salon Kecantikan seluruhnya' AS 'URAIAN', 0 AS JUMLAH , 56 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Salon Kecantikan yang diperiksa kesehatan lingkungannya' AS 'URAIAN', 0 AS JUMLAH, 57 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Salon Kecantikan yang memenuhi syarat kesehatan lingkungan' AS 'URAIAN', 0 AS JUMLAH , 58 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah industri rumah tangga makanan dan minuman seluruhnya' AS 'URAIAN', 0 AS JUMLAH, 59 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah industri rumah tangga makanan dan minuman yang diperiksa kesehatan ' AS 'URAIAN', 0 AS JUMLAH , 60 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah industri rumah tangga yang memenuhi syarat kesehatan' AS 'URAIAN', 0 AS JUMLAH, 61 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah Tempat Pengelolaan Pestisida ( TP2 )' AS 'URAIAN', 0 AS JUMLAH , 62 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah TP2 yang diperiksa' AS 'URAIAN', 0 AS JUMLAH, 63 AS iRow UNION ALL SELECT 'XII' AS 'GROUP', 'KESEHATAN LINGKUNGAN' AS 'NAMA_GROUP', 'Jumlah TP2 yang memenuhi syarat ' AS 'URAIAN', 0 AS JUMLAH , 64 AS iRow) X");
			$query[13] = $db->query("select X.* from (SELECT 'XIII' AS 'GROUP', 'LABORATORIUM' AS 'NAMA_GROUP', 'Jumlah spesimen darah yang diperiksa' AS 'URAIAN', (SELECT COUNT(V.KD_PASIEN) as JML FROM vw_rpt_lab AS V WHERE V.KD_PUSKESMAS = '$pid' AND (KD_LAB BETWEEN '179' AND '193') AND (V.TGL_PELAYANAN BETWEEN '$from' AND '$to') ) AS JUMLAH ,1 AS iRow UNION ALL SELECT 'XIII' AS 'GROUP', 'LABORATORIUM' AS 'NAMA_GROUP', 'Jumlah spesimen air seni yang diperiksa' AS 'URAIAN', 0 AS JUMLAH, 2 AS iRow UNION ALL SELECT 'XIII' AS 'GROUP', 'LABORATORIUM' AS 'NAMA_GROUP', 'Jumlah spesimen tinja yang diperiksa' AS 'URAIAN', 0 AS JUMLAH , 3 AS iRow UNION ALL SELECT 'XIII' AS 'GROUP', 'LABORATORIUM' AS 'NAMA_GROUP', 'Jumlah pemeriksaan BTA/TBC (sputum)' AS 'URAIAN', 0 AS JUMLAH, 4 AS iRow UNION ALL SELECT 'XIII' AS 'GROUP', 'LABORATORIUM' AS 'NAMA_GROUP', 'Jumlah pemeriksaan BTA/TBC (sputum) positif' AS 'URAIAN', 0 AS JUMLAH , 5 AS iRow UNION ALL SELECT 'XIII' AS 'GROUP', 'LABORATORIUM' AS 'NAMA_GROUP', 'Jumlah pemeriksaan darah untuk Malaria' AS 'URAIAN', 0 AS JUMLAH, 6 AS iRow UNION ALL SELECT 'XIII' AS 'GROUP', 'LABORATORIUM' AS 'NAMA_GROUP', 'Jumlah pemeriksaan darah untuk Malaria positif' AS 'URAIAN', 0 AS JUMLAH , 7 AS iRow UNION ALL SELECT 'XIII' AS 'GROUP', 'LABORATORIUM' AS 'NAMA_GROUP', 'Jumlah pemeriksaan darah untuk Malaria positif P. Falsiparum' AS 'URAIAN', 0 AS JUMLAH, 8 AS iRow UNION ALL SELECT 'XIII' AS 'GROUP', 'LABORATORIUM' AS 'NAMA_GROUP', 'Jumlah pemeriksaan BTA/Kusta (Reitz serum)' AS 'URAIAN', 0 AS JUMLAH , 9 AS iRow UNION ALL SELECT 'XIII' AS 'GROUP', 'LABORATORIUM' AS 'NAMA_GROUP', 'Jumlah pemeriksaan BTA/Kusta (Reitz serum) positif' AS 'URAIAN', 0 AS JUMLAH, 10 AS iRow UNION ALL SELECT 'XIII' AS 'GROUP', 'LABORATORIUM' AS 'NAMA_GROUP', 'Jumlah pemeriksaan Laboratorium lainnya' AS 'URAIAN', 0 AS JUMLAH , 11 AS iRow) X");
			$query[14] = $db->query("select X.* from (SELECT 'XIV' AS 'GROUP', 'JAMINAN MUTU / QUALITY ASSURANCE' AS 'NAMA_GROUP', 'Frekuensi pertemuan jaminan mutu' AS 'URAIAN', 0 AS JUMLAH ,1 AS iRow UNION ALL SELECT 'XIV' AS 'GROUP', 'JAMINAN MUTU / QUALITY ASSURANCE' AS 'NAMA_GROUP', 'Jumlah identifikasi masalah jaminan mutu' AS 'URAIAN', 0 AS JUMLAH, 2 AS iRow UNION ALL SELECT 'XIV' AS 'GROUP', 'JAMINAN MUTU / QUALITY ASSURANCE' AS 'NAMA_GROUP', 'Jumlah audit kasus dalam rangka peningkatan mutu ' AS 'URAIAN', 0 AS JUMLAH , 3 AS iRow UNION ALL SELECT 'XIV' AS 'GROUP', 'JAMINAN MUTU / QUALITY ASSURANCE' AS 'NAMA_GROUP', 'Jumlah seluruh SOP yang telah dibuat sebelumnya' AS 'URAIAN', 0 AS JUMLAH, 4 AS iRow UNION ALL SELECT 'XIV' AS 'GROUP', 'JAMINAN MUTU / QUALITY ASSURANCE' AS 'NAMA_GROUP', 'Jumlah SOP yang telah dibuat bulan ini' AS 'URAIAN', 0 AS JUMLAH , 5 AS iRow UNION ALL SELECT 'XIV' AS 'GROUP', 'JAMINAN MUTU / QUALITY ASSURANCE' AS 'NAMA_GROUP', 'Jumlah SOP yang telah dikembangkan' AS 'URAIAN', 0 AS JUMLAH, 6 AS iRow UNION ALL SELECT 'XIV' AS 'GROUP', 'JAMINAN MUTU / QUALITY ASSURANCE' AS 'NAMA_GROUP', 'Jumlah seluruh daftar tilik yang telah dibuat sebelumnya' AS 'URAIAN', 0 AS JUMLAH , 7 AS iRow UNION ALL SELECT 'XIV' AS 'GROUP', 'JAMINAN MUTU / QUALITY ASSURANCE' AS 'NAMA_GROUP', 'Jumlah daftar tilik yang telah dibuat bulan ini' AS 'URAIAN', 0 AS JUMLAH, 8 AS iRow UNION ALL SELECT 'XIV' AS 'GROUP', 'JAMINAN MUTU / QUALITY ASSURANCE' AS 'NAMA_GROUP', 'Jumlah survey kepatuhan/tilik kepatuhan terhadap SOP' AS 'URAIAN', 0 AS JUMLAH , 9 AS iRow UNION ALL SELECT 'XIV' AS 'GROUP', 'JAMINAN MUTU / QUALITY ASSURANCE' AS 'NAMA_GROUP', 'Jumlah survey kepuasan pelanggan bulan ini' AS 'URAIAN', 0 AS JUMLAH, 10 AS iRow) X");
			if($query[1]->num_rows>0){
				//$data2 = $query2->result(); //print_r($data);die;
				
				/*if(!$data)
					return false;
				*/
				// Starting the PHPExcel library
				$this->load->library('Excel');
				$this->excel->getActiveSheet()->setTitle('LB4');
				$this->excel->getProperties()->setTitle("export")->setDescription("none");
				
				$objReader = PHPExcel_IOFactory::createReader('Excel5');
				$objPHPExcel = $objReader->load("tmp/laporan_lb4_kab.xls");
				$objPHPExcel->setActiveSheetIndex(0);
					
				//$no=1;
				$total=0;
				for($no=1;$no<15;$no++){
				$data = $query[$no]->result();
				$rw=array('',10,20,29,41,48,55,62,71,82,86,92,108,174,187,199);
				$rw2=array('',9,19,28,40,47,54,61,70,81,85,91,107,173,186,198);
				foreach($data as $value)
				{
					$styleArray = array(
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
							),
						),
					);
					$objPHPExcel->getActiveSheet()->getStyle('A'.($rw[$no]-1).':E'.$rw[$no])->applyFromArray($styleArray);

					$objPHPExcel->getActiveSheet()->mergeCells('B'.$rw[$no].':D'.$rw[$no]);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$rw[$no])->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$rw[$no])->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->setTitle('Data')
						->setCellValue('A'.$rw[$no], $value->iRow)
						->setCellValue('B'.$rw[$no], '   '.$value->URAIAN)
						->setCellValue('E'.$rw[$no], $value->JUMLAH);
					//$rw++;
					$rw[$no]++;
				}
				$objPHPExcel->getActiveSheet()->getStyle('A'.($rw2[$no]).':E'.($rw2[$no]))->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->mergeCells('B'.($rw2[$no]).':D'.($rw2[$no]));
				$objPHPExcel->getActiveSheet()->getStyle('A'.($rw2[$no]))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('E'.($rw2[$no]))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()
					->setCellValue('A'.($rw2[$no]), $value->GROUP)
					->setCellValue('B'.($rw2[$no]), $value->NAMA_GROUP)
					->setCellValue('E'.($rw2[$no]), 'JUMLAH')
					;
					
				}
				$data1 = $query[1]->result();
				foreach($data1 as $value1){
					$objPHPExcel->getActiveSheet()->getStyle('E198:E202')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$objPHPExcel->getActiveSheet()
						//->setCellValue('E198', 'KEPALA PUSKESMAS')
						//->setCellValue('E202', $value1->KEPALA_PUSKESMAS)
						//->setCellValue('C5', $pid)
						//->setCellValue('C6', $value1->NAMA_PUSKESMAS)
						->setCellValue('C6', $value1->KABKOTA)
						->setCellValue('E6', $value1->dt1.' / '.$value1->dt2);
				}
				$filename='laporan_lb4_kab_'.date('dmY_his_').'.xls'; //save our workbook as this file name
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
	
	public function lbhrj_excel(){
	//print_r($_POST);die;
	
		
		$from = $this->input->get('from');	//print_r($from);die;
		$to = $this->input->get('to'); //print_r($to);die;
		$pid = $this->input->get('pid');
		$jenis = $this->input->get('jenis');
		$db = $this->load->database('sikda', TRUE);
	
		//$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_uks a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'")->row();//print_r($data);die;
		if($jenis=='rpt_hrj_kb'){
			$query = $db->query("SELECT X.KABUPATEN,DATE_FORMAT('$from','%d-%m-%Y') as dt1, DATE_FORMAT('$to','%d-%m-%Y') as dt2, I.KD_PENYAKIT, I.PENYAKIT,V.UNIT_PELAYANAN ,V.KD_UNIT,V.NM_UNIT, COL1_L_B, COL1_P_B, COL2_L_B, COL2_P_B, COL3_L_B, COL3_P_B, COL4_L_B, COL4_P_B, COL5_L_B, COL5_P_B, COL6_L_B, COL6_P_B, COL1_L_L, COL1_P_L, COL2_L_L, COL2_P_L, COL3_L_L, COL3_P_L, COL4_L_L, COL4_P_L, COL5_L_L, COL5_P_L, COL6_L_L, COL6_P_L, COL7_L_B, COL7_P_B, COL8_L_B, COL8_P_B, COL9_L_B, COL9_P_B, COL10_L_B, COL10_P_B, COL11_L_B, COL11_P_B, COL12_L_B, COL12_P_B, COL7_L_L, COL7_P_L, COL8_L_L, COL8_P_L, COL9_L_L, COL9_P_L, COL10_L_L, COL10_P_L, COL11_L_L, COL11_P_L, COL12_L_L, COL12_P_L, (COL1_L_B + COL2_L_B + COL3_L_B + COL4_L_B + COL5_L_B + COL6_L_B + COL7_L_B + COL8_L_B + COL9_L_B + COL10_L_B + COL11_L_B + COL12_L_B) AS TOTAL_L_B, (COL1_L_L + COL2_L_L + COL3_L_L + COL4_L_L + COL5_L_L + COL6_L_L + COL7_L_L + COL8_L_L + COL9_L_L + COL10_L_L + COL11_L_L + COL12_L_L) AS TOTAL_L_L, (COL1_P_B + COL2_P_B + COL3_P_B + COL4_P_B + COL5_P_B + COL6_P_B + COL7_P_B + COL8_P_B + COL9_P_B + COL10_P_B + COL11_P_B + COL12_P_B) AS TOTAL_P_B, (COL1_P_L + COL2_P_L + COL3_P_L + COL4_P_L + COL5_P_L + COL6_P_L + COL7_P_L + COL8_P_L + COL9_P_L + COL10_P_L + COL11_P_L + COL12_P_L) AS TOTAL_P_L, (COL1_L_B + COL2_L_B + COL3_L_B + COL4_L_B + COL5_L_B + COL6_L_B + COL7_L_B + COL8_L_B + COL9_L_B + COL10_L_B + COL11_L_B + COL12_L_B + COL1_L_L + COL2_L_L + COL3_L_L + COL4_L_L + COL5_L_L + COL6_L_L + COL7_L_L + COL8_L_L + COL9_L_L + COL10_L_L + COL11_L_L + COL12_L_L + COL1_P_B + COL2_P_B + COL3_P_B + COL4_P_B + COL5_P_B + COL6_P_B + COL7_P_B + COL8_P_B + COL9_P_B + COL10_P_B + COL11_P_B + COL12_P_B + COL1_P_L + COL2_P_L + COL3_P_L + COL4_P_L + COL5_P_L + COL6_P_L + COL7_P_L + COL8_P_L + COL9_P_L + COL10_P_L + COL11_P_L + COL12_P_L) AS TOTAL FROM ( SELECT V.KD_PUSKESMAS, V.NAMA_PUSKESMAS, V.KD_PENYAKIT, V.UNIT_PELAYANAN ,V.KD_UNIT,V.NM_UNIT, SUM(IF(JENIS_PASIEN='UMUM' AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL1_L_B`, SUM(IF(JENIS_PASIEN='UMUM' AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL1_P_B`, SUM(IF(JENIS_PASIEN='ASKES' AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL2_L_B`, SUM(IF(JENIS_PASIEN='ASKES' AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL2_P_B`, SUM(IF(JENIS_PASIEN='JAMSOSTEK' AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL3_L_B`, SUM(IF(JENIS_PASIEN='JAMSOSTEK' AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL3_P_B`, SUM(IF(JENIS_PASIEN='KARYAWAN' AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL4_L_B`, SUM(IF(JENIS_PASIEN='KARYAWAN' AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL4_P_B`, SUM(IF(JENIS_PASIEN='KELUARGA KARYAWAN' AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL5_L_B`, SUM(IF(JENIS_PASIEN='KELUARGA KARYAWAN' AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL5_P_B`, SUM(IF(JENIS_PASIEN='ASKES SWASTA' AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL6_L_B`, SUM(IF(JENIS_PASIEN='ASKES SWASTA' AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL6_P_B`, SUM(IF(JENIS_PASIEN='ASKES SUKARELA' AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL7_L_B`, SUM(IF(JENIS_PASIEN='ASKES SUKARELA' AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL7_P_B`, SUM(IF(JENIS_PASIEN='JAMKESMAS' AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL8_L_B`, SUM(IF(JENIS_PASIEN='JAMKESMAS' AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL8_P_B`, SUM(IF(JENIS_PASIEN='ASKES PENSIUN' AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL9_L_B`, SUM(IF(JENIS_PASIEN='ASKES PENSIUN' AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL9_P_B`, SUM(IF(JENIS_PASIEN='ASKESKIN' AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL10_L_B`, SUM(IF(JENIS_PASIEN='ASKESKIN' AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL10_P_B`, SUM(IF(JENIS_PASIEN='GAKIN' AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL11_L_B`, SUM(IF(JENIS_PASIEN='GAKIN' AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL11_P_B`, SUM(IF(JENIS_PASIEN='JAMKESDA' AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL12_L_B`, SUM(IF(JENIS_PASIEN='JAMKESDA' AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL12_P_B`, SUM(IF(JENIS_PASIEN='UMUM' AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL1_L_L`, SUM(IF(JENIS_PASIEN='UMUM' AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL1_P_L`, SUM(IF(JENIS_PASIEN='ASKES' AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL2_L_L`, SUM(IF(JENIS_PASIEN='ASKES' AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL2_P_L`, SUM(IF(JENIS_PASIEN='JAMSOSTEK' AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL3_L_L`, SUM(IF(JENIS_PASIEN='JAMSOSTEK' AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL3_P_L`, SUM(IF(JENIS_PASIEN='KARYAWAN' AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL4_L_L`, SUM(IF(JENIS_PASIEN='KARYAWAN' AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL4_P_L`, SUM(IF(JENIS_PASIEN='KELUARGA KARYAWAN' AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL5_L_L`, SUM(IF(JENIS_PASIEN='KELUARGA KARYAWAN' AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL5_P_L`, SUM(IF(JENIS_PASIEN='ASKES SWASTA' AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL6_L_L`, SUM(IF(JENIS_PASIEN='ASKES SWASTA' AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL6_P_L`, SUM(IF(JENIS_PASIEN='ASKES SUKARELA' AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL7_L_L`, SUM(IF(JENIS_PASIEN='ASKES SUKARELA' AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL7_P_L`, SUM(IF(JENIS_PASIEN='JAMKESMAS' AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL8_L_L`, SUM(IF(JENIS_PASIEN='JAMKESMAS' AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL8_P_L`, SUM(IF(JENIS_PASIEN='ASKES PENSIUN' AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL9_L_L`, SUM(IF(JENIS_PASIEN='ASKES PENSIUN' AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL9_P_L`, SUM(IF(JENIS_PASIEN='ASKESKIN' AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL10_L_L`, SUM(IF(JENIS_PASIEN='ASKESKIN' AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL10_P_L`, SUM(IF(JENIS_PASIEN='GAKIN' AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL11_L_L`, SUM(IF(JENIS_PASIEN='GAKIN' AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL11_P_L`, SUM(IF(JENIS_PASIEN='JAMKESDA' AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL12_L_L`, SUM(IF(JENIS_PASIEN='JAMKESDA' AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL12_P_L` FROM vw_rpt_penyakitpasien AS V WHERE (TGL_PELAYANAN BETWEEN '$from' AND '$to') AND SUBSTRING(KD_PUSKESMAS,2,4)='$pid' AND UNIT_PELAYANAN='RJ' GROUP BY V.KD_PUSKESMAS, V.KD_UNIT ) V INNER JOIN mst_icd I ON I.KD_PENYAKIT=V.KD_PENYAKIT LEFT JOIN mst_kabupaten X ON X.KD_KABUPATEN='$pid' ORDER BY I.KD_PENYAKIT, I.PENYAKIT; ");//print_r($query);die;
			if($query->num_rows>0){
			$data = $query->result(); //print_r($data);die;
			
			if(!$data)
				return false;
	 
			// Starting the PHPExcel library
			$this->load->library('Excel');
			$this->excel->getActiveSheet()->setTitle('Laporan Kunjungan');
			$this->excel->getProperties()->setTitle("export")->setDescription("none");
			
			$objReader = PHPExcel_IOFactory::createReader('Excel5');
			$objPHPExcel = $objReader->load("tmp/laporan_kunjungan_kab.xls");
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
				$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':BD'.($rw+1))->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				//$objPHPExcel->getActiveSheet()->getStyle('C'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->setTitle('Data')
					->setCellValue('A'.$rw, $no)
					->setCellValue('B'.$rw, $value->KD_UNIT)
					->setCellValue('C'.$rw, $value->NM_UNIT)
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
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('A'.($rw+2).':A'.($rw+4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':C'.$rw);
			$objPHPExcel->getActiveSheet()
				->setCellValue('E3', $value->KABUPATEN)
				->setCellValue('E4', ($value->dt1).' s/d '.$value->dt2)
				->setCellValue('A'.$rw, 'TOTAL  ')
				//->setCellValue('A'.($rw+2), 'Kepala Puskesmas')
				//->setCellValue('A'.($rw+4), $value->KEPALA_PUSKESMAS)
				->setCellValue('D'.$rw, '=SUM(D9:D'.($rw-1).')')
				->setCellValue('E'.$rw, '=SUM(E9:E'.($rw-1).')')
				->setCellValue('F'.$rw, '=SUM(F9:F'.($rw-1).')')
				->setCellValue('G'.$rw, '=SUM(G9:G'.($rw-1).')')
				->setCellValue('H'.$rw, '=SUM(H9:H'.($rw-1).')')
				->setCellValue('I'.$rw, '=SUM(I9:I'.($rw-1).')')
				->setCellValue('J'.$rw, '=SUM(J9:J'.($rw-1).')')
				->setCellValue('K'.$rw, '=SUM(K9:K'.($rw-1).')')
				->setCellValue('L'.$rw, '=SUM(L9:L'.($rw-1).')')
				->setCellValue('M'.$rw, '=SUM(M9:M'.($rw-1).')')
				->setCellValue('N'.$rw, '=SUM(N9:N'.($rw-1).')')
				->setCellValue('O'.$rw, '=SUM(O9:O'.($rw-1).')')
				->setCellValue('P'.$rw, '=SUM(P9:P'.($rw-1).')')
				->setCellValue('Q'.$rw, '=SUM(Q9:Q'.($rw-1).')')
				->setCellValue('R'.$rw, '=SUM(R9:R'.($rw-1).')')
				->setCellValue('S'.$rw, '=SUM(S9:S'.($rw-1).')')
				->setCellValue('T'.$rw, '=SUM(T9:T'.($rw-1).')')
				->setCellValue('U'.$rw, '=SUM(U9:U'.($rw-1).')')
				->setCellValue('V'.$rw, '=SUM(V9:V'.($rw-1).')')
				->setCellValue('W'.$rw, '=SUM(W9:W'.($rw-1).')')
				->setCellValue('X'.$rw, '=SUM(X9:X'.($rw-1).')')
				->setCellValue('Y'.$rw, '=SUM(Y9:Y'.($rw-1).')')
				->setCellValue('Z'.$rw, '=SUM(Z9:Z'.($rw-1).')')
				->setCellValue('AA'.$rw, '=SUM(AA9:AA'.($rw-1).')')
				->setCellValue('AB'.$rw, '=SUM(AB9:AB'.($rw-1).')')
				->setCellValue('AC'.$rw, '=SUM(AC9:AC'.($rw-1).')')
				->setCellValue('AD'.$rw, '=SUM(AD9:AD'.($rw-1).')')
				->setCellValue('AE'.$rw, '=SUM(AE9:AE'.($rw-1).')')
				->setCellValue('AF'.$rw, '=SUM(AF9:AF'.($rw-1).')')
				->setCellValue('AG'.$rw, '=SUM(AG9:AG'.($rw-1).')')
				->setCellValue('AH'.$rw, '=SUM(AH9:AH'.($rw-1).')')
				->setCellValue('AI'.$rw, '=SUM(AI9:AI'.($rw-1).')')
				->setCellValue('AJ'.$rw, '=SUM(AJ9:AJ'.($rw-1).')')
				->setCellValue('AK'.$rw, '=SUM(AK9:AK'.($rw-1).')')
				->setCellValue('AL'.$rw, '=SUM(AL9:AL'.($rw-1).')')
				->setCellValue('AM'.$rw, '=SUM(AM9:AM'.($rw-1).')')
				->setCellValue('AN'.$rw, '=SUM(AN9:AN'.($rw-1).')')
				->setCellValue('AO'.$rw, '=SUM(AO9:AO'.($rw-1).')')
				->setCellValue('AP'.$rw, '=SUM(AP9:AP'.($rw-1).')')
				->setCellValue('AQ'.$rw, '=SUM(AQ9:AQ'.($rw-1).')')
				->setCellValue('AR'.$rw, '=SUM(AR9:AR'.($rw-1).')')
				->setCellValue('AS'.$rw, '=SUM(AS9:AS'.($rw-1).')')
				->setCellValue('AT'.$rw, '=SUM(AT9:AT'.($rw-1).')')
				->setCellValue('AU'.$rw, '=SUM(AU9:AU'.($rw-1).')')
				->setCellValue('AV'.$rw, '=SUM(AV9:AV'.($rw-1).')')
				->setCellValue('AW'.$rw, '=SUM(AW9:AW'.($rw-1).')')
				->setCellValue('AX'.$rw, '=SUM(AX9:AX'.($rw-1).')')
				->setCellValue('AY'.$rw, '=SUM(AY9:AY'.($rw-1).')')
				->setCellValue('AZ'.$rw, '=SUM(AZ9:AZ'.($rw-1).')')
				->setCellValue('BA'.$rw, '=SUM(BA9:BA'.($rw-1).')')
				->setCellValue('BB'.$rw, '=SUM(BB9:BB'.($rw-1).')')
				->setCellValue('BC'.$rw, '=SUM(BC9:BC'.($rw-1).')')
				->setCellValue('BD'.$rw, '=SUM(BD9:BD'.($rw-1).')');
			$filename='laporan_kunjungan_kab'.date('_dmY_his').'.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			}else{
				die('Tidak Ada Dalam Database');
			}
		}else{
			$query = $db->query("SELECT DATE_FORMAT('$from','%d-%m-%Y') as dt1, DATE_FORMAT('$to','%d-%m-%Y') as dt2, V.KD_PUSKESMAS, (SELECT S.KEY_VALUE FROM sys_setting AS S WHERE S.KEY_DATA = 'NAMA_PUSKESMAS' AND PUSKESMAS='$pid' LIMIT 1) AS NAMA_PUSKESMAS, (SELECT S.KEY_VALUE FROM sys_setting AS S WHERE S.KEY_DATA = 'NAMA_PIMPINAN' AND PUSKESMAS='$pid' LIMIT 1) AS KEPALA_PUSKESMAS, I.KD_PENYAKIT, I.PENYAKIT,V.UNIT_PELAYANAN ,V.KD_UNIT,V.NM_UNIT, 
COL1_L_B, COL1_P_B, COL2_L_B, COL2_P_B, COL3_L_B, COL3_P_B, COL4_L_B, COL4_P_B, COL5_L_B, COL5_P_B, COL6_L_B, COL6_P_B, COL1_L_L, COL1_P_L, COL2_L_L, COL2_P_L, COL3_L_L, COL3_P_L, COL4_L_L, COL4_P_L, COL5_L_L, COL5_P_L, COL6_L_L, COL6_P_L, COL7_L_B, COL7_P_B, COL8_L_B, COL8_P_B, COL9_L_B, COL9_P_B, COL10_L_B, COL10_P_B, COL11_L_B, COL11_P_B, COL12_L_B, COL12_P_B, COL7_L_L, COL7_P_L, COL8_L_L, COL8_P_L, COL9_L_L, COL9_P_L, COL10_L_L, COL10_P_L, COL11_L_L, COL11_P_L, COL12_L_L, COL12_P_L, (COL1_L_B + COL2_L_B + COL3_L_B + COL4_L_B + COL5_L_B + COL6_L_B + COL7_L_B + COL8_L_B + COL9_L_B + COL10_L_B + COL11_L_B + COL12_L_B) AS TOTAL_L_B, (COL1_L_L + COL2_L_L + COL3_L_L + COL4_L_L + COL5_L_L + COL6_L_L + COL7_L_L + COL8_L_L + COL9_L_L + COL10_L_L + COL11_L_L + COL12_L_L) AS TOTAL_L_L, (COL1_P_B + COL2_P_B + COL3_P_B + COL4_P_B + COL5_P_B + COL6_P_B + COL7_P_B + COL8_P_B + COL9_P_B + COL10_P_B + COL11_P_B + COL12_P_B) AS TOTAL_P_B, (COL1_P_L + COL2_P_L + COL3_P_L + COL4_P_L + COL5_P_L + COL6_P_L + COL7_P_L + COL8_P_L + COL9_P_L + COL10_P_L + COL11_P_L + COL12_P_L) AS TOTAL_P_L, (COL1_L_B + COL2_L_B + COL3_L_B + COL4_L_B + COL5_L_B + COL6_L_B + COL7_L_B + COL8_L_B + COL9_L_B + COL10_L_B + COL11_L_B + COL12_L_B + COL1_L_L + COL2_L_L + COL3_L_L + COL4_L_L + COL5_L_L + COL6_L_L + COL7_L_L + COL8_L_L + COL9_L_L + COL10_L_L + COL11_L_L + COL12_L_L + COL1_P_B + COL2_P_B + COL3_P_B + COL4_P_B + COL5_P_B + COL6_P_B + COL7_P_B + COL8_P_B + COL9_P_B + COL10_P_B + COL11_P_B + COL12_P_B + COL1_P_L + COL2_P_L + COL3_P_L + COL4_P_L + COL5_P_L + COL6_P_L + COL7_P_L + COL8_P_L + COL9_P_L + COL10_P_L + COL11_P_L + COL12_P_L) AS TOTAL FROM ( SELECT V.KD_PUSKESMAS, V.NAMA_PUSKESMAS, V.KD_PENYAKIT, V.UNIT_PELAYANAN ,V.KD_UNIT,V.NM_UNIT, SUM(IF(JENIS_PASIEN='UMUM' AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL1_L_B`, SUM(IF(JENIS_PASIEN='UMUM' AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL1_P_B`, SUM(IF(JENIS_PASIEN='ASKES' AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL2_L_B`, SUM(IF(JENIS_PASIEN='ASKES' AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL2_P_B`, SUM(IF(JENIS_PASIEN='JAMSOSTEK' AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL3_L_B`, SUM(IF(JENIS_PASIEN='JAMSOSTEK' AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL3_P_B`, SUM(IF(JENIS_PASIEN='KARYAWAN' AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL4_L_B`, SUM(IF(JENIS_PASIEN='KARYAWAN' AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL4_P_B`, SUM(IF(JENIS_PASIEN='KELUARGA KARYAWAN' AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL5_L_B`, SUM(IF(JENIS_PASIEN='KELUARGA KARYAWAN' AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL5_P_B`, SUM(IF(JENIS_PASIEN='ASKES SWASTA' AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL6_L_B`, SUM(IF(JENIS_PASIEN='ASKES SWASTA' AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL6_P_B`, SUM(IF(JENIS_PASIEN='ASKES SUKARELA' AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL7_L_B`, SUM(IF(JENIS_PASIEN='ASKES SUKARELA' AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL7_P_B`, SUM(IF(JENIS_PASIEN='JAMKESMAS' AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL8_L_B`, SUM(IF(JENIS_PASIEN='JAMKESMAS' AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL8_P_B`, SUM(IF(JENIS_PASIEN='ASKES PENSIUN' AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL9_L_B`, SUM(IF(JENIS_PASIEN='ASKES PENSIUN' AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL9_P_B`, SUM(IF(JENIS_PASIEN='ASKESKIN' AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL10_L_B`, SUM(IF(JENIS_PASIEN='ASKESKIN' AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL10_P_B`, SUM(IF(JENIS_PASIEN='GAKIN' AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL11_L_B`, SUM(IF(JENIS_PASIEN='GAKIN' AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL11_P_B`, SUM(IF(JENIS_PASIEN='JAMKESDA' AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS `COL12_L_B`, SUM(IF(JENIS_PASIEN='JAMKESDA' AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS `COL12_P_B`, SUM(IF(JENIS_PASIEN='UMUM' AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL1_L_L`, SUM(IF(JENIS_PASIEN='UMUM' AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL1_P_L`, SUM(IF(JENIS_PASIEN='ASKES' AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL2_L_L`, SUM(IF(JENIS_PASIEN='ASKES' AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL2_P_L`, SUM(IF(JENIS_PASIEN='JAMSOSTEK' AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL3_L_L`, SUM(IF(JENIS_PASIEN='JAMSOSTEK' AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL3_P_L`, SUM(IF(JENIS_PASIEN='KARYAWAN' AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL4_L_L`, SUM(IF(JENIS_PASIEN='KARYAWAN' AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL4_P_L`, SUM(IF(JENIS_PASIEN='KELUARGA KARYAWAN' AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL5_L_L`, SUM(IF(JENIS_PASIEN='KELUARGA KARYAWAN' AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL5_P_L`, SUM(IF(JENIS_PASIEN='ASKES SWASTA' AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL6_L_L`, SUM(IF(JENIS_PASIEN='ASKES SWASTA' AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL6_P_L`, SUM(IF(JENIS_PASIEN='ASKES SUKARELA' AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL7_L_L`, SUM(IF(JENIS_PASIEN='ASKES SUKARELA' AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL7_P_L`, SUM(IF(JENIS_PASIEN='JAMKESMAS' AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL8_L_L`, SUM(IF(JENIS_PASIEN='JAMKESMAS' AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL8_P_L`, SUM(IF(JENIS_PASIEN='ASKES PENSIUN' AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL9_L_L`, SUM(IF(JENIS_PASIEN='ASKES PENSIUN' AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL9_P_L`, SUM(IF(JENIS_PASIEN='ASKESKIN' AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL10_L_L`, SUM(IF(JENIS_PASIEN='ASKESKIN' AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL10_P_L`, SUM(IF(JENIS_PASIEN='GAKIN' AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL11_L_L`, SUM(IF(JENIS_PASIEN='GAKIN' AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL11_P_L`, SUM(IF(JENIS_PASIEN='JAMKESDA' AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS `COL12_L_L`, SUM(IF(JENIS_PASIEN='JAMKESDA' AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS `COL12_P_L` FROM vw_rpt_penyakitpasien AS V WHERE (TGL_PELAYANAN BETWEEN '$from' AND '$to') AND KD_PUSKESMAS='$pid' AND UNIT_PELAYANAN='RJ' GROUP BY V.KD_PUSKESMAS, V.NAMA_PUSKESMAS, V.KD_UNIT ) V INNER JOIN mst_icd I ON I.KD_PENYAKIT=V.KD_PENYAKIT ; ");//print_r($query);die;
			if($query->num_rows>0){
			$data = $query->result(); //print_r($data);die;
			
			if(!$data)
				return false;
	 
			// Starting the PHPExcel library
			$this->load->library('Excel');
			$this->excel->getActiveSheet()->setTitle('Laporan Kunjungan');
			$this->excel->getProperties()->setTitle("export")->setDescription("none");
			
			$objReader = PHPExcel_IOFactory::createReader('Excel5');
			$objPHPExcel = $objReader->load("tmp/laporan_kunjungan.xls");
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
				$objPHPExcel->getActiveSheet()->getStyle('A'.$rw.':BD'.($rw+1))->applyFromArray($styleArray);

				$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				//$objPHPExcel->getActiveSheet()->getStyle('C'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->setTitle('Data')
					->setCellValue('A'.$rw, $no)
					->setCellValue('B'.$rw, $value->KD_UNIT)
					->setCellValue('C'.$rw, $value->NM_UNIT)
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
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('A'.($rw+2).':A'.($rw+4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw.':C'.$rw);
			$objPHPExcel->getActiveSheet()
				->setCellValue('E3', $value->KD_PUSKESMAS.'   '.$value->NAMA_PUSKESMAS)
				->setCellValue('E4', ($value->dt1).' s/d '.$value->dt2)
				->setCellValue('A'.$rw, 'TOTAL  ')
				->setCellValue('A'.($rw+2), 'Kepala Puskesmas')
				->setCellValue('A'.($rw+4), $value->KEPALA_PUSKESMAS)
				->setCellValue('D'.$rw, '=SUM(D9:D'.($rw-1).')')
				->setCellValue('E'.$rw, '=SUM(E9:E'.($rw-1).')')
				->setCellValue('F'.$rw, '=SUM(F9:F'.($rw-1).')')
				->setCellValue('G'.$rw, '=SUM(G9:G'.($rw-1).')')
				->setCellValue('H'.$rw, '=SUM(H9:H'.($rw-1).')')
				->setCellValue('I'.$rw, '=SUM(I9:I'.($rw-1).')')
				->setCellValue('J'.$rw, '=SUM(J9:J'.($rw-1).')')
				->setCellValue('K'.$rw, '=SUM(K9:K'.($rw-1).')')
				->setCellValue('L'.$rw, '=SUM(L9:L'.($rw-1).')')
				->setCellValue('M'.$rw, '=SUM(M9:M'.($rw-1).')')
				->setCellValue('N'.$rw, '=SUM(N9:N'.($rw-1).')')
				->setCellValue('O'.$rw, '=SUM(O9:O'.($rw-1).')')
				->setCellValue('P'.$rw, '=SUM(P9:P'.($rw-1).')')
				->setCellValue('Q'.$rw, '=SUM(Q9:Q'.($rw-1).')')
				->setCellValue('R'.$rw, '=SUM(R9:R'.($rw-1).')')
				->setCellValue('S'.$rw, '=SUM(S9:S'.($rw-1).')')
				->setCellValue('T'.$rw, '=SUM(T9:T'.($rw-1).')')
				->setCellValue('U'.$rw, '=SUM(U9:U'.($rw-1).')')
				->setCellValue('V'.$rw, '=SUM(V9:V'.($rw-1).')')
				->setCellValue('W'.$rw, '=SUM(W9:W'.($rw-1).')')
				->setCellValue('X'.$rw, '=SUM(X9:X'.($rw-1).')')
				->setCellValue('Y'.$rw, '=SUM(Y9:Y'.($rw-1).')')
				->setCellValue('Z'.$rw, '=SUM(Z9:Z'.($rw-1).')')
				->setCellValue('AA'.$rw, '=SUM(AA9:AA'.($rw-1).')')
				->setCellValue('AB'.$rw, '=SUM(AB9:AB'.($rw-1).')')
				->setCellValue('AC'.$rw, '=SUM(AC9:AC'.($rw-1).')')
				->setCellValue('AD'.$rw, '=SUM(AD9:AD'.($rw-1).')')
				->setCellValue('AE'.$rw, '=SUM(AE9:AE'.($rw-1).')')
				->setCellValue('AF'.$rw, '=SUM(AF9:AF'.($rw-1).')')
				->setCellValue('AG'.$rw, '=SUM(AG9:AG'.($rw-1).')')
				->setCellValue('AH'.$rw, '=SUM(AH9:AH'.($rw-1).')')
				->setCellValue('AI'.$rw, '=SUM(AI9:AI'.($rw-1).')')
				->setCellValue('AJ'.$rw, '=SUM(AJ9:AJ'.($rw-1).')')
				->setCellValue('AK'.$rw, '=SUM(AK9:AK'.($rw-1).')')
				->setCellValue('AL'.$rw, '=SUM(AL9:AL'.($rw-1).')')
				->setCellValue('AM'.$rw, '=SUM(AM9:AM'.($rw-1).')')
				->setCellValue('AN'.$rw, '=SUM(AN9:AN'.($rw-1).')')
				->setCellValue('AO'.$rw, '=SUM(AO9:AO'.($rw-1).')')
				->setCellValue('AP'.$rw, '=SUM(AP9:AP'.($rw-1).')')
				->setCellValue('AQ'.$rw, '=SUM(AQ9:AQ'.($rw-1).')')
				->setCellValue('AR'.$rw, '=SUM(AR9:AR'.($rw-1).')')
				->setCellValue('AS'.$rw, '=SUM(AS9:AS'.($rw-1).')')
				->setCellValue('AT'.$rw, '=SUM(AT9:AT'.($rw-1).')')
				->setCellValue('AU'.$rw, '=SUM(AU9:AU'.($rw-1).')')
				->setCellValue('AV'.$rw, '=SUM(AV9:AV'.($rw-1).')')
				->setCellValue('AW'.$rw, '=SUM(AW9:AW'.($rw-1).')')
				->setCellValue('AX'.$rw, '=SUM(AX9:AX'.($rw-1).')')
				->setCellValue('AY'.$rw, '=SUM(AY9:AY'.($rw-1).')')
				->setCellValue('AZ'.$rw, '=SUM(AZ9:AZ'.($rw-1).')')
				->setCellValue('BA'.$rw, '=SUM(BA9:BA'.($rw-1).')')
				->setCellValue('BB'.$rw, '=SUM(BB9:BB'.($rw-1).')')
				->setCellValue('BC'.$rw, '=SUM(BC9:BC'.($rw-1).')')
				->setCellValue('BD'.$rw, '=SUM(BD9:BD'.($rw-1).')');
			$filename='laporan_kunjungan'.date('_dmY_his').'.xls'; //save our workbook as this file name
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
	
	public function tempgizi_excel(){
	//print_r($_POST);die;
	
		
		$from = $this->input->get('from');	//print_r($from);die;
		$to = $this->input->get('to'); //print_r($to);die;
		$pid = $this->input->get('pid');
		$jenis = $this->input->get('jenis');
		$db = $this->load->database('sikda', TRUE);
		if($jenis=='temp_gizi'){
			$query = array();
			//$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_uks a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'")->row();//print_r($data);die;
			$query[1] = $db->query("SELECT DATE_FORMAT('$from','%d-%m-%Y') as dt1, DATE_FORMAT('$to','%d-%m-%Y') as dt2, '$pid' AS KD_PUSKESMAS, (SELECT S.KEY_VALUE FROM sys_setting AS S WHERE S.KEY_DATA = 'NAMA_PUSKESMAS' AND PUSKESMAS='$pid' LIMIT 1) AS NAMA_PUSKESMAS, (SELECT S.KEY_VALUE FROM sys_setting AS S WHERE S.KEY_DATA = 'NAMA_PIMPINAN' AND PUSKESMAS='$pid' LIMIT 1) AS KEPALA_PUSKESMAS, (SELECT P.PROVINSI FROM sys_setting S INNER JOIN mst_provinsi P ON S.KEY_VALUE=P.KD_PROVINSI WHERE S.KEY_DATA = 'KD_PROV' AND S.PUSKESMAS='$pid' LIMIT 1) AS PROVINSI, (SELECT P.KABUPATEN FROM sys_setting S INNER JOIN mst_kabupaten P ON S.KEY_VALUE=P.KD_KABUPATEN WHERE S.KEY_DATA = 'KD_KABKOTA' AND S.PUSKESMAS='$pid' LIMIT 1) AS KABKOTA, (SELECT P.KECAMATAN FROM sys_setting S INNER JOIN mst_kecamatan P ON S.KEY_VALUE=P.KD_KECAMATAN WHERE S.KEY_DATA = 'KD_KEC' AND S.PUSKESMAS='$pid' LIMIT 1) AS KECAMATAN, '' AS 'PUSTU_YG_ADA', '' AS 'YANG_LAPOR', 'DARI PARAMETER PHP' AS 'TAHUN', '' AS 'NAMA_MENGETAHUI', '' AS 'NIP_MENGETAHUI', '' AS 'LOKASI', 'TANGGAL HARI INI' AS 'TANGGAL', '' AS 'NAMA_PELAPOR', '' AS 'NIP_PELAPOR', X.* FROM ( select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'A' as 'KELOMPOK', 'Gizi' as Program, 'Upaya Penanggulangan Kekurangan Vitamin A' as kegiatan, '' as Jumlah6, 1 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'A' as 'KELOMPOK','Gizi' as Program, 'Jumlah anak balita (1-5 th) dapat kapsul vit. A dosis tinggi (200.000 IU) bulan ini' as kegiatan, IFNULL ((SELECT COUNT( X.KD_PELAYANAN ) AS JUMLAH FROM (SELECT V.KD_PELAYANAN,V.KD_PUSKESMAS, V.KD_OBAT, l.KD_PASIEN FROM pel_ord_obat V INNER JOIN pelayanan l WHERE l.KD_PELAYANAN = V.KD_PELAYANAN) X INNER JOIN pasien p
			WHERE p.KD_PASIEN=X.KD_PASIEN AND X.KD_OBAT = '159' AND Get_Age(p.TGL_LAHIR) >= 1 AND Get_Age(p.TGL_LAHIR) < 6 AND X.KD_PUSKESMAS = '$pid'), IFNULL((SELECT SUM(ANAK_P_12_60_K_VIT_A)+SUM(ANAK_L_12_60_K_VIT_A) FROM t_ds_gizi WHERE BULAN=DATE_FORMAT('$from','%m') AND TAHUN=DATE_FORMAT('$from','%Y') AND kd_puskesmas='$pid'),0)) as Jumlah6, 2 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'A' as 'KELOMPOK','Gizi' as Program, 'Jumlah Ibu nifas (s/d 40 hr) dapat kapsul vit. A dosis tinggi (200.000 IU) bulan ini' as kegiatan, (SELECT
			COUNT(X.KD_PASIEN) as JML
			FROM (select V.KD_PASIEN, V.KD_PELAYANAN, V.KD_PUSKESMAS, V.VARIABEL_ID AS 'CL_CHILDVITA', '' AS 'CL_CHILDEXAMAGE',  V.HASIL  AS 'VITA' , '' AS AGE from pel_hasil_kia AS V
			WHERE V.KD_PUSKESMAS = '$pid'
			AND V.VARIABEL_ID = 'CL_PNCCAREVITA'
			AND V.HASIL = 'YA'
			 )X INNER JOIN pelayanan AS p
			WHERE p.KD_PELAYANAN = X.KD_PELAYANAN
			AND p.TGL_PELAYANAN BETWEEN '$from' AND '$to') as Jumlah6, 3 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'A' as 'KELOMPOK','Gizi' as Program, 'Jumlah bayi (6-11 th) dapat kapsul vit. A dosis tinggi (200.000 IU) bulan ini' as kegiatan, IFNULL ((SELECT COUNT( X.KD_PELAYANAN ) AS JUMLAH FROM (SELECT V.KD_PELAYANAN,V.KD_PUSKESMAS, V.KD_OBAT, l.KD_PASIEN FROM pel_ord_obat V INNER JOIN pelayanan l WHERE l.KD_PELAYANAN = V.KD_PELAYANAN) X INNER JOIN pasien p
			WHERE p.KD_PASIEN=X.KD_PASIEN AND X.KD_OBAT = '159' AND Get_Age(p.TGL_LAHIR) > 6 AND Get_Age(p.TGL_LAHIR) < 11 AND X.KD_PUSKESMAS = '$pid'),IFNULL((SELECT SUM(0)+SUM(0) FROM t_ds_gizi WHERE BULAN=DATE_FORMAT('$from','%m') AND TAHUN=DATE_FORMAT('$from','%Y') AND kd_puskesmas='$pid'),0)) as Jumlah6, 4 as iRow  ) X ");//print_r($query);die;
			
			$query[2] = $db->query("SELECT X.* FROM (select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Ibu hamil dapat tablet tambah darah (Fe) 30 tablet (Fe1) bulan ini' as kegiatan, IFNULL ((SELECT COUNT( X.KD_PELAYANAN ) AS Jumlah FROM (SELECT O.KD_PELAYANAN, O.KD_PUSKESMAS, O.KD_OBAT, O.JUMLAH, O.TANGGAL, L.KD_PASIEN FROM pel_ord_obat O INNER JOIN pelayanan L WHERE L.KD_PELAYANAN = O.KD_PELAYANAN )X
			INNER JOIN kunjungan_bumil K WHERE K.KD_PASIEN = X.KD_PASIEN AND X.KD_OBAT='541' AND X.JUMLAH='30' AND X.KD_PUSKESMAS='$pid' AND (K.TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')), IFNULL((SELECT SUM(IBU_HAMIL_TTD_FE_30) FROM t_ds_gizi WHERE BULAN=DATE_FORMAT('$from','%m') AND TAHUN=DATE_FORMAT('$from','%Y') AND kd_puskesmas='$pid'),0)) as Jumlah6, 1 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Ibu hamil dapat tablet tambah darah (Fe) 90 tablet (Fe2) bulan ini' as kegiatan, 
			IFNULL ((SELECT COUNT( X.KD_PELAYANAN ) AS Jumlah FROM (SELECT O.KD_PELAYANAN, O.KD_PUSKESMAS, O.KD_OBAT, O.JUMLAH, O.TANGGAL, L.KD_PASIEN FROM pel_ord_obat O INNER JOIN pelayanan L WHERE L.KD_PELAYANAN = O.KD_PELAYANAN )X
			INNER JOIN kunjungan_bumil K WHERE K.KD_PASIEN = X.KD_PASIEN AND X.KD_OBAT='541' AND X.JUMLAH='90' AND X.KD_PUSKESMAS='$pid' AND (K.TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')), IFNULL((SELECT SUM(IBU_HAMIL_TTD_FE_90) FROM t_ds_gizi WHERE BULAN=DATE_FORMAT('$from','%m') AND TAHUN=DATE_FORMAT('$from','%Y') AND kd_puskesmas='$pid'),0)) as Jumlah6, 2 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Balita diperiksa status anemia bulan ini' as kegiatan, '0'as Jumlah6, 3 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Balita yang diperiksa dengan status anemia < 11 gr % bulan ini' as kegiatan, '0'as Jumlah6, 4 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah WUS (15 - 45 th) diperiksa status anemia bulan ini' as kegiatan, IFNULL((SELECT COUNT(a.KD_PASIEN) AS total FROM vw_rpt_penyakitpasien_grp_old a WHERE a.SEX='P' AND (Get_Age(a.TGL_LAHIR) BETWEEN '15' AND '45') AND a.KD_PENYAKIT ='D64.9' AND (a.TGL_PELAYANAN BETWEEN '$from' AND '$to') GROUP BY a.KD_PASIEN),0) as Jumlah6, 5 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah WUS (15 - 45 th) yang diperiksa dengan status anemia < 11 gr % bulan ini' as kegiatan, IFNULL((SELECT COUNT(a.KD_PASIEN) AS total FROM vw_rpt_penyakitpasien_grp_old a WHERE a.SEX='P' AND (Get_Age(a.TGL_LAHIR) BETWEEN '15' AND '45') AND a.KD_PENYAKIT ='D64' AND (a.TGL_PELAYANAN BETWEEN '$from' AND '$to') GROUP BY a.KD_PASIEN),0) as Jumlah6, 6 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Remaja Putri (14 - 18 th) diperiksa status anemia bulan ini' as kegiatan, IFNULL((SELECT COUNT(a.KD_PASIEN) AS total FROM vw_rpt_penyakitpasien_grp_old a WHERE a.SEX='P' AND (Get_Age(a.TGL_LAHIR) BETWEEN '14' AND '18') AND a.KD_PENYAKIT ='D64.9' AND (a.TGL_PELAYANAN BETWEEN '$from' AND '$to') GROUP BY a.KD_PASIEN),0) as Jumlah6, 7 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Remaja Putri (14 - 18 th) yang diperiksa dengan status anemia < 11 gr % bulan ini' as kegiatan, IFNULL((SELECT COUNT(a.KD_PASIEN) AS total FROM vw_rpt_penyakitpasien_grp_old a WHERE a.SEX='P' AND (Get_Age(a.TGL_LAHIR) BETWEEN '14' AND '18') AND a.KD_PENYAKIT ='D64' AND (a.TGL_PELAYANAN BETWEEN '$from' AND '$to') GROUP BY a.KD_PASIEN),0) as Jumlah6, 8 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Tenaga Kerja Wanita (nakerwan) diperiksa status anemia bulan ini' as kegiatan, IFNULL((SELECT COUNT(a.KD_PASIEN) AS total FROM vw_rpt_penyakitpasien_grp_old a LEFT JOIN pasien b ON a.KD_PASIEN=b.KD_PASIEN WHERE a.SEX='P' AND (Get_Age(a.TGL_LAHIR) BETWEEN '15' AND '45') AND b.KD_PEKERJAAN NOT IN (NULL,'0','6','7','8','9','10') AND a.KD_PENYAKIT ='D64.9' AND (a.TGL_PELAYANAN BETWEEN '$from' AND '$to') GROUP BY a.KD_PASIEN),0) as Jumlah6, 9 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Tenaga Kerja Wanita (nakerwan) yang diperiksa dengan status anemia < 11 gr % bulan ini' as kegiatan, IFNULL((SELECT COUNT(a.KD_PASIEN) AS total FROM vw_rpt_penyakitpasien_grp_old a LEFT JOIN pasien b ON a.KD_PASIEN=b.KD_PASIEN WHERE a.SEX='P' AND (Get_Age(a.TGL_LAHIR) BETWEEN '15' AND '45') AND b.KD_PEKERJAAN NOT IN (NULL,'0','6','7','8','9','10') AND a.KD_PENYAKIT ='D64' AND (a.TGL_PELAYANAN BETWEEN '$from' AND '$to') GROUP BY a.KD_PASIEN),0) as Jumlah6, 10 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Ibu hamil diperiksa status anemia bulan ini' as kegiatan, IFNULL((SELECT COUNT(a.KD_PASIEN) AS total FROM vw_rpt_penyakitpasien_grp_old a LEFT JOIN pasien b ON a.KD_PASIEN=b.KD_PASIEN LEFT JOIN trans_kia z ON a.KD_PELAYANAN=z.KD_PELAYANAN WHERE a.SEX='P' AND z.KD_KATEGORI_KIA='1' AND z.KD_KUNJUNGAN_KIA='1' AND a.KD_PENYAKIT ='D64.9' AND (a.TGL_PELAYANAN BETWEEN '$from' AND '$to') GROUP BY a.KD_PASIEN),0) as Jumlah6, 11 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Ibu hamil yang diperiksa dengan status anemia < 11 gr % bulan ini' as kegiatan, IFNULL((SELECT COUNT(a.KD_PASIEN) AS total FROM vw_rpt_penyakitpasien_grp_old a LEFT JOIN pasien b ON a.KD_PASIEN=b.KD_PASIEN LEFT JOIN trans_kia z ON a.KD_PELAYANAN=z.KD_PELAYANAN WHERE a.SEX='P' AND z.KD_KATEGORI_KIA='1' AND z.KD_KUNJUNGAN_KIA='1' AND a.KD_PENYAKIT ='D64' AND (a.TGL_PELAYANAN BETWEEN '$from' AND '$to') GROUP BY a.KD_PASIEN),0) as Jumlah6, 12 as iRow) X");
			
			$query[3] = $db->query("SELECT X.* FROM (select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'C' as 'KELOMPOK',  'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita yang ada bulan ini' as kegiatan, IFNULL((SELECT SUM(r.BAYI_L_0_6_S)+SUM(r.BAYI_P_0_6_S)+SUM(r.BAYI_L_6_12_S)+SUM(r.BAYI_P_6_12_S)+SUM(r.ANAK_L_12_36_S)+SUM(r.ANAK_P_12_36_S)+SUM(r.ANAK_L_37_60_S)+SUM(r.ANAK_P_37_60_S) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 1 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'C' as 'KELOMPOK',  'Upaya Pemantauan Pertumbuhan Balita' as Program,  'Jumlah Balita yang mempunyai KMS bulan ini' as kegiatan, IFNULL((SELECT SUM(r.BAYI_L_0_12_KMS_K)+SUM(r.ANAK_L_12_36_KMS_K)+SUM(r.ANAK_L_37_60_KMS_K)+SUM(r.BAYI_P_0_12_KMS_K)+SUM(r.ANAK_P_12_36_KMS_K)+SUM(r.ANAK_P_37_60_KMS_K) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 2 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'C' as 'KELOMPOK',   'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita yang Naik berat badannya bulan ini' as kegiatan, IFNULL((SELECT SUM(r.BAYI_L_0_12_N)+SUM(r.ANAK_L_12_36_N)+SUM(r.ANAK_L_37_60_N)+SUM(r.BAYI_P_0_12_N)+SUM(r.ANAK_P_12_36_N)+SUM(r.ANAK_P_37_60_N) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 3 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'C' as 'KELOMPOK',  'Upaya Pemantauan Pertumbuhan Balita' as Program,  'Jumlah Balita yang Tidak naik/tetap berat badannya bulan ini' as kegiatan, IFNULL((SELECT (SUM(r.BAYI_L_0_12_D)+SUM(r.ANAK_L_12_36_D)+SUM(r.ANAK_L_37_60_D)+SUM(r.BAYI_P_0_12_D)+SUM(r.ANAK_P_12_36_D)+SUM(r.ANAK_P_37_60_D))-(SUM(r.BAYI_L_0_12_N)+SUM(r.ANAK_L_12_36_N)+SUM(r.ANAK_L_37_60_N)+SUM(r.BAYI_P_0_12_N)+SUM(r.ANAK_P_12_36_N)+SUM(r.ANAK_P_37_60_N)) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 4 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'C' as 'KELOMPOK',   'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita yang ditimbang bulan ini tetapi tidak ditimbang bulan lalu' as kegiatan, '0' as Jumlah6, 5 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'C' as 'KELOMPOK',  'Upaya Pemantauan Pertumbuhan Balita' as Program,  'Jumlah Balita yang Baru ditimbang bulan ini' as kegiatan, IFNULL((SELECT SUM(r.BAYI_L_PK_MENIMBANG_B1)+SUM(r.BAYI_P_PK_MENIMBANG_B1) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 6 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'C' as 'KELOMPOK',   'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita yang dapat ditimbang bulan ini' as kegiatan, IFNULL((SELECT SUM(r.BAYI_L_0_12_D)+SUM(r.ANAK_L_12_36_D)+SUM(r.ANAK_L_37_60_D)+SUM(r.BAYI_P_0_12_D)+SUM(r.ANAK_P_12_36_D)+SUM(r.ANAK_P_37_60_D) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 7 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'C' as 'KELOMPOK',   'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita yang tidak dapat ditimbang bulan ini' as kegiatan, '0' as Jumlah6, 8 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'C' as 'KELOMPOK',   'Upaya Pemantauan Pertumbuhan Balita' as Program, 'jumlah Balita dengan Berat badan di Bawah Garis Merah (BGM) bulan ini' as kegiatan, IFNULL((SELECT SUM(r.BAYI_L_BGM_MP_ASI)+SUM(r.BAYI_P_BGM_MP_ASI) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 9 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'C' as 'KELOMPOK',   'Upaya Pemantauan Pertumbuhan Balita' as Program,  'Jumlah Balita gizi buruk bulan ini' as kegiatan, IFNULL((SELECT SUM(r.BAYI_L_0_12_G_BURUK_WHO_NCS)+SUM(r.ANAK_L_12_36_G_BURUK)+SUM(r.BAYI_P_0_12_G_BURUK_WHO_NCS)+SUM(r.ANAK_P_12_36_G_BURUK) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 10 as iRow) X");
			
			$query[4] = $db->query("SELECT X.* FROM (select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'D' as 'KELOMPOK',   'Upaya Penanggulangan Gangguan Akibat Kekurangan Yodium (GAKY)' as Program,  'Jumlah penderita GAKY laki-laki bulan ini ' as kegiatan, '0'as Jumlah6, 1 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'D' as 'KELOMPOK',   'Upaya Penanggulangan Gangguan Akibat Kekurangan Yodium (GAKY)' as Program,  'Jumlah penderita GAKY perempuan bulan ini ' as kegiatan, IFNULL((SELECT SUM(r.P_GONDOK_P_G_0_WUS_BARU)+SUM(r.P_GONDOK_P_G_1_WUS_BARU)+SUM(r.P_GONDOK_P_G_2_WUS_BARU)+SUM(r.P_GONDOK_P_G_0_WUS_LAMA)+SUM(r.P_GONDOK_P_G_1_WUS_LAMA)+SUM(r.P_GONDOK_P_G_2_WUS_LAMA) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 2 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'D' as 'KELOMPOK',   'Upaya Penanggulangan Gangguan Akibat Kekurangan Yodium (GAKY)' as Program,  'Jumlah ibu hamil mendapat kapsul yodium ' as kegiatan, IFNULL((SELECT SUM(r.JML_WUS_KEL_ENDEMIS_SB_YODIUM) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 3 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'D' as 'KELOMPOK',   'Upaya Penanggulangan Gangguan Akibat Kekurangan Yodium (GAKY)' as Program,  'Jumlah penduduk lainnya mendapat kapsul yodium ' as kegiatan, '0'as Jumlah6, 4 as iRow) X");
			
			$query[5] = $db->query("SELECT X.* FROM (select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'E' as 'KELOMPOK',   'Upaya Penanggulangan Kekurangan Energi Kronis (KEK)' as Program,  'Jumlah Ibu hamil baru, diukur LILA (Lingkar Lengan Atas) bulan ini ' as kegiatan, '0'as Jumlah6, 1 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'E' as 'KELOMPOK',   'Upaya Penanggulangan Kekurangan Energi Kronis (KEK)' as Program,  'Jumlah Ibu hamil baru, dengan LILA < 23,5 cm bulan ini ' as kegiatan, '0'as Jumlah6, 2 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'E' as 'KELOMPOK',   'Upaya Penanggulangan Kekurangan Energi Kronis (KEK)' as Program,  'Jumlah WUS baru, yang diukur LILA (Lingkar Lengan Atas) bulan ini ' as kegiatan, '0'as Jumlah6, 3 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'E' as 'KELOMPOK',   'Upaya Penanggulangan Kekurangan Energi Kronis (KEK)' as Program,  'Jumlah WUS baru, dengan LILA < 23,5 cm bulan ini ' as kegiatan, '0'as Jumlah6,  4 as iRow) X");
			$query[6] = $db->query("SELECT X.* FROM (select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'Jumlah kunjungan K1 Bumil ' as kegiatan, IFNULL((SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil WHERE kunjungan_ke='K1' AND kd_puskesmas='$pid' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')),0)as Jumlah6,  1 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'Jumlah kunjungan Bumil lama ' as kegiatan, ''as Jumlah6,  2 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'K2' as kegiatan, IFNULL((SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil WHERE kunjungan_ke='K2' AND kd_puskesmas='$pid' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')),0)as Jumlah6,  3 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'K3' as kegiatan, IFNULL((SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil WHERE kunjungan_ke='K3' AND kd_puskesmas='$pid' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')),0)as Jumlah6,  4 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'K4' as kegiatan, IFNULL((SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil WHERE kunjungan_ke='K4' AND kd_puskesmas='$pid' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')),0)as Jumlah6,  5 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'Kunjungan Bumil dengan faktor risiko : ' as kegiatan, ''as Jumlah6,  6 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'a. < 20 th ' as kegiatan, IFNULL((SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil  w LEFT JOIN pasien e ON w.KD_PASIEN=e.KD_PASIEN WHERE Get_Age_Tahun(e.TGL_LAHIR) < 20 AND w.kd_puskesmas='$pid' AND (w.TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')),0)as Jumlah6,  7 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'b. > 35 th  ' as kegiatan, IFNULL((SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil  w LEFT JOIN pasien e ON w.KD_PASIEN=e.KD_PASIEN WHERE Get_Age_Tahun(e.TGL_LAHIR) > 35 AND w.kd_puskesmas='$pid' AND (w.TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')),0)as Jumlah6,  8 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'c. Spacing < 2 th  ' as kegiatan, IFNULL((SELECT COUNT(KD_PASIEN) AS jumlah FROM trans_imunisasi WHERE trans_imunisasi.JARAK_KEHAMILAN != '' AND trans_imunisasi.JARAK_KEHAMILAN <2 AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='6' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6,  9 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'd. Paritas > 5 th ' as kegiatan, '0'as Jumlah6,  10 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'e. HB 11 gram %' as kegiatan, '0'as Jumlah6,  11 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'f. BB Kg Triwulan III < 45 Kg ' as kegiatan, IFNULL((SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil WHERE BERAT_BADAN<'45' AND UMUR_KEHAMILAN>'24' AND kd_puskesmas='$pid' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')),0) as Jumlah6,  12 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'g. TB < 145 cm' as kegiatan, IFNULL((SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil WHERE TINGGI_BADAN<'145' AND kd_puskesmas='$pid' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')),0) as Jumlah6,  13 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'Imunisasi TT Bumil (TT1, TT2) : ' as kegiatan, ''as Jumlah6,  14 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'a. TT1 ' as kegiatan, IFNULL((SELECT COUNT(KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='9' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='6' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')), IFNULL((SELECT SUM(r.JML_P_S_IMUNISASI_TT1) AS jumlah FROM t_ds_kematian_ibu r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0)) as Jumlah6,  15 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'b. TT2  ' as kegiatan, IFNULL((SELECT COUNT(KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='10' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='6' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')), IFNULL((SELECT SUM(r.JML_P_S_IMUNISASI_TT2) AS jumlah FROM t_ds_kematian_ibu r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0)) as Jumlah6,  16 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'Pemberian tablet Fe Bumil : ' as kegiatan, ''as Jumlah6,  17 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'a. Fe1 ' as kegiatan, IFNULL ((SELECT COUNT( X.KD_PELAYANAN ) AS Jumlah FROM (SELECT O.KD_PELAYANAN, O.KD_PUSKESMAS, O.KD_OBAT, O.JUMLAH, O.TANGGAL, L.KD_PASIEN FROM pel_ord_obat O INNER JOIN pelayanan L WHERE L.KD_PELAYANAN = O.KD_PELAYANAN )X
			INNER JOIN kunjungan_bumil K WHERE K.KD_PASIEN = X.KD_PASIEN AND X.KD_OBAT='541' AND X.JUMLAH='30' AND X.KD_PUSKESMAS='$pid' AND (K.TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')), IFNULL((SELECT SUM(IBU_HAMIL_TTD_FE_30) FROM t_ds_gizi WHERE BULAN=DATE_FORMAT('$from','%m') AND TAHUN=DATE_FORMAT('$from','%Y') AND kd_puskesmas='$pid'),0)) as Jumlah6,  18 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'b. Fe2  ' as kegiatan, IFNULL ((SELECT COUNT( X.KD_PELAYANAN ) AS Jumlah FROM (SELECT O.KD_PELAYANAN, O.KD_PUSKESMAS, O.KD_OBAT, O.JUMLAH, O.TANGGAL, L.KD_PASIEN FROM pel_ord_obat O INNER JOIN pelayanan L WHERE L.KD_PELAYANAN = O.KD_PELAYANAN )X
			INNER JOIN kunjungan_bumil K WHERE K.KD_PASIEN = X.KD_PASIEN AND X.KD_OBAT='541' AND X.JUMLAH='90' AND X.KD_PUSKESMAS='$pid' AND (K.TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')), IFNULL((SELECT SUM(IBU_HAMIL_TTD_FE_90) FROM t_ds_gizi WHERE BULAN=DATE_FORMAT('$from','%m') AND TAHUN=DATE_FORMAT('$from','%Y') AND kd_puskesmas='$pid'),0)) as Jumlah6,  19 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'c. Fe3' as kegiatan, '0'as Jumlah6,  20 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'Jumlah kesakitan dan kematian Bumil yang ditangani : ' as kegiatan, ''as Jumlah6,  21 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'a. Pendarahan  ' as kegiatan, IFNULL((SELECT SUM(r.JML_SK_PENDARAHAN) AS jumlah FROM t_ds_kematian_ibu r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6,  22 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'b. Infeksi jalan lahir  ' as kegiatan, '0'as Jumlah6,  23 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'c. Preeklamasi/Eklamsi  ' as kegiatan, IFNULL ((SELECT SUM((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN)X
					WHERE X.KD_PENYAKIT ='o15' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to'))+(SELECT COUNT(X.KD_PELAYANAN) as JML2
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN)X
					WHERE X.KD_PENYAKIT LIKE 'o14.%' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to'))+(SELECT COUNT(X.KD_PELAYANAN) as JML3
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN)X
					WHERE X.KD_PENYAKIT ='o13' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to'))) ), IFNULL((SELECT SUM(r.JML_SK_EKLAMSI) AS jumlah FROM t_ds_kematian_ibu r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0)) as Jumlah6,  24 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'd. Sebab lain  ' as kegiatan, IFNULL((SELECT SUM(r.JML_SK_LAIN_LAIN) AS jumlah FROM t_ds_kematian_ibu r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6,  25 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'Deteksi resti bumil oleh nakes ' as kegiatan, IFNULL((SELECT SUM(r.JML_KJ_BR_R_NAKES) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6,  26 as iRow
			UNION ALL
			select  'KESEHATAN IBU DAN ANAK' as 'JUDUL',  'F' as 'KELOMPOK',   'Pelayanan Ibu Hamil' as Program,  'Deteksi resti bumil oleh masyarakat ' as kegiatan, IFNULL((SELECT SUM(r.JML_KJ_BR_R_MASYARAKAT) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0)as Jumlah6,  27 as iRow) X");
			
			if($query[1]->num_rows>0){
				//$data2 = $query2->result(); //print_r($data);die;
				
				/*if(!$data)
					return false;
				*/
				// Starting the PHPExcel library
				$this->load->library('Excel');
				$this->excel->getActiveSheet()->setTitle('bulanan');
				$this->excel->getProperties()->setTitle("export")->setDescription("none");
				
				$objReader = PHPExcel_IOFactory::createReader('Excel5');
				$objPHPExcel = $objReader->load("tmp/template_bulanan_gizi2015.xls");
				$objPHPExcel->setActiveSheetIndex(0);
					
				//$no=1;
				$total=0;
				for($no=1;$no<7;$no++){
				$data = $query[$no]->result();
				$rw=array('',10,16,30,42,48,54,83);//116,126,150,157,170,174,178,185,193,197,201,204,209,214,218,225,235);
				//$rw2=array('',9,15,29,41,47,53,82,115,125,149,156,169,173,177,184,192,196,200,203,208,213,217,224,234);
				foreach($data as $value)
				{
					$styleArray = array(
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
							),
						),
					);
					//$objPHPExcel->getActiveSheet()->getStyle('F'.($rw[$no]-1).':J'.$rw[$no])->applyFromArray($styleArray);

					//$objPHPExcel->getActiveSheet()->mergeCells('F'.$rw[$no].':I'.$rw[$no]);
					//$objPHPExcel->getActiveSheet()->getStyle('F'.$rw[$no])->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					//$objPHPExcel->getActiveSheet()->getStyle('H'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->setTitle('bulanan')
						//->setCellValue('F'.$rw[$no], '   '.$value->kegiatan)
						->setCellValue('J'.$rw[$no], $value->Jumlah6);
					//$rw++;
					$rw[$no]++;
				}
				//$objPHPExcel->getActiveSheet()->getStyle('F'.($rw2[$no]).':J'.($rw2[$no]))->getFont()->setBold(true);
				//$objPHPExcel->getActiveSheet()->mergeCells('F'.($rw2[$no]).':I'.($rw2[$no]));
				//$objPHPExcel->getActiveSheet()->getStyle('F'.($rw2[$no]))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				//$objPHPExcel->getActiveSheet()
					//->setCellValue('F'.($rw2[$no]), $value->JUDUL.' :   '.$value->Program)
					//->setCellValue('J'.($rw2[$no]), 'JUMLAH');
					
				}
				$data1 = $query[1]->result();
				foreach($data1 as $value1){
					//$objPHPExcel->getActiveSheet()->getStyle('J234:J237')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$objPHPExcel->getActiveSheet()
						//->setCellValue('J234', 'KEPALA PUSKESMAS')
						//->setCellValue('EJ237', $value1->KEPALA_PUSKESMAS)
						//->setCellValue('H5', $pid)
						->setCellValue('B1', $value1->NAMA_PUSKESMAS)
						->setCellValue('B2', $value1->KABKOTA)
						->setCellValue('B3', $value1->dt1.' / '.$value1->dt2);
				}
				$filename='temp_gizi_'.date('dmY_his_').'.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
				
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				$objWriter->save('php://output');
			}else{
				die('Tidak Ada Dalam Database');
			}
		}else{	
			$query = array();
			//$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_uks a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'")->row();//print_r($data);die;
			$query[1] = $db->query("SELECT DATE_FORMAT('$from','%d-%m-%Y') as dt1, DATE_FORMAT('$to','%d-%m-%Y') as dt2, '$pid' AS KD_KAB, (SELECT P.KABUPATEN FROM sys_setting S INNER JOIN mst_kabupaten P ON S.KEY_VALUE=P.KD_KABUPATEN WHERE S.KEY_DATA = 'KD_KABKOTA' AND SUBSTRING(S.PUSKESMAS,2,4)='$pid' LIMIT 1) AS KABKOTA, '' AS 'PUSTU_YG_ADA', '' AS 'YANG_LAPOR', 'DARI PARAMETER PHP' AS 'TAHUN', '' AS 'NAMA_MENGETAHUI', '' AS 'NIP_MENGETAHUI', '' AS 'LOKASI', 'TANGGAL HARI INI' AS 'TANGGAL', '' AS 'NAMA_PELAPOR', '' AS 'NIP_PELAPOR', X.* FROM ( select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'A' as 'KELOMPOK', 'Gizi' as Program, 'Upaya Penanggulangan Kekurangan Vitamin A' as kegiatan, '' as Jumlah6, 1 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'A' as 'KELOMPOK','Gizi' as Program, 'Jumlah anak balita (1-5 th) dapat kapsul vit. A dosis tinggi (200.000 IU) bulan ini' as kegiatan, (SELECT COUNT(X.KD_PASIEN) as JML FROM (SELECT * FROM ( select V.KD_PASIEN, V.KD_PELAYANAN, V.KD_PUSKESMAS, V.VARIABEL_ID AS 'CL_CHILDVITA', '' AS 'CL_CHILDEXAMAGE', V.HASIL AS 'VITA' , '' AS AGE from pel_hasil_kia AS V WHERE SUBSTRING(V.KD_PUSKESMAS,2,4)= '$pid' AND V.VARIABEL_ID = 'CL_CHILDVITA' AND V.HASIL = 'YA' UNION ALL select V.KD_PASIEN, V.KD_PELAYANAN, V.KD_PUSKESMAS, ''AS 'CL_CHILDVITA' ,V.VARIABEL_ID AS 'CL_CHILDEXAMAGE', '' AS 'VITA' , V.HASIL AS AGE from pel_hasil_kia AS V WHERE SUBSTRING(V.KD_PUSKESMAS,2,4)= '$pid' AND V.VARIABEL_ID = 'CL_CHILDEXAMAGE' AND V.HASIL BETWEEN '365' AND '1825' ) M )X INNER JOIN pelayanan AS p WHERE p.KD_PELAYANAN = X.KD_PELAYANAN AND p.TGL_PELAYANAN BETWEEN '$from' AND '$to' ) as Jumlah6, 2 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'A' as 'KELOMPOK','Gizi' as Program, 'Jumlah Ibu nifas (s/d 40 hr) dapat kapsul vit. A dosis tinggi (200.000 IU) bulan ini' as kegiatan, (SELECT COUNT(X.KD_PASIEN) as JML FROM (select V.KD_PASIEN, V.KD_PELAYANAN, V.KD_PUSKESMAS, V.VARIABEL_ID AS 'CL_CHILDVITA', '' AS 'CL_CHILDEXAMAGE', V.HASIL AS 'VITA' , '' AS AGE from pel_hasil_kia AS V WHERE SUBSTRING(V.KD_PUSKESMAS,2,4) = '$pid' AND V.VARIABEL_ID = 'CL_PNCCAREVITA' AND V.HASIL = 'YA' )X INNER JOIN pelayanan AS p WHERE p.KD_PELAYANAN = X.KD_PELAYANAN AND p.TGL_PELAYANAN BETWEEN '$from' AND '$to') as Jumlah6, 3 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'A' as 'KELOMPOK','Gizi' as Program, 'Jumlah bayi (6-11 th) dapat kapsul vit. A dosis tinggi (200.000 IU) bulan ini' as kegiatan, (SELECT COUNT(X.KD_PASIEN) as JML FROM (SELECT * FROM ( select V.KD_PASIEN, V.KD_PELAYANAN, V.KD_PUSKESMAS, V.VARIABEL_ID AS 'CL_CHILDVITA', '' AS 'CL_CHILDEXAMAGE', V.HASIL AS 'VITA' , '' AS AGE from pel_hasil_kia AS V WHERE SUBSTRING(V.KD_PUSKESMAS,2,4)= '$pid' AND V.VARIABEL_ID = 'CL_CHILDVITA' AND V.HASIL = 'YA' UNION ALL select V.KD_PASIEN, V.KD_PELAYANAN, V.KD_PUSKESMAS, ''AS 'CL_CHILDVITA' ,V.VARIABEL_ID AS 'CL_CHILDEXAMAGE', '' AS 'VITA' , V.HASIL AS AGE from pel_hasil_kia AS V WHERE SUBSTRING(V.KD_PUSKESMAS,2,4)= '$pid' AND V.VARIABEL_ID = 'CL_CHILDEXAMAGE' AND V.HASIL BETWEEN '2190' AND '4015' ) M )X INNER JOIN pelayanan AS p WHERE p.KD_PELAYANAN = X.KD_PELAYANAN AND p.TGL_PELAYANAN BETWEEN '$from' AND '$to' ) as Jumlah6, 4 as iRow  ) X ");//print_r($query);die;
			
			$query[2] = $db->query("SELECT X.* FROM (select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Ibu hamil dapat tablet tambah darah (Fe) 30 tablet (Fe1) bulan ini' as kegiatan, ''as Jumlah6, 1 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Ibu hamil dapat tablet tambah darah (Fe) 90 tablet (Fe2) bulan ini' as kegiatan, ''as Jumlah6, 2 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Balita diperiksa status anemia bulan ini' as kegiatan, ''as Jumlah6, 3 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Balita yang diperiksa dengan status anemia < 11 gr % bulan ini' as kegiatan, ''as Jumlah6, 4 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah WUS (15 - 45 th) diperiksa status anemia bulan ini' as kegiatan, ''as Jumlah6, 5 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah WUS (15 - 45 th) yang diperiksa dengan status anemia < 11 gr % bulan ini' as kegiatan, ''as Jumlah6, 6 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Remaja Putri (14 - 18 th) diperiksa status anemia bulan ini' as kegiatan, ''as Jumlah6, 7 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Remaja Putri (14 - 18 th) yang diperiksa dengan status anemia < 11 gr % bulan ini' as kegiatan, ''as Jumlah6, 8 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Tenaga Kerja Wanita (nakerwan) diperiksa status anemia bulan ini' as kegiatan, ''as Jumlah6, 9 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Tenaga Kerja Wanita (nakerwan) yang diperiksa dengan status anemia < 11 gr % bulan ini' as kegiatan, ''as Jumlah6, 10 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Ibu hamil diperiksa status anemia bulan ini' as kegiatan, ''as Jumlah6, 11 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'B' as 'KELOMPOK', 'Upaya Penanggulangan Anemia Gizi Besi (Fe)' as Program, 'Jumlah Ibu hamil yang diperiksa dengan status anemia < 11 gr % bulan ini' as kegiatan, ''as Jumlah6, 12 as iRow) X");
			
			$query[3] = $db->query("SELECT X.* FROM (select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'C' as 'KELOMPOK', 'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita yang ada bulan ini' as kegiatan, ''as Jumlah6, 1 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'C' as 'KELOMPOK', 'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita yang mempunyai KMS bulan ini' as kegiatan, ''as Jumlah6, 2 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'C' as 'KELOMPOK', 'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita yang Naik berat badannya bulan ini' as kegiatan, ''as Jumlah6, 3 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'C' as 'KELOMPOK', 'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita yang Tidak naik/tetap berat badannya bulan ini' as kegiatan, ''as Jumlah6, 4 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'C' as 'KELOMPOK', 'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita yang ditimbang bulan ini tetapi tidak ditimbang bulan lalu' as kegiatan, ''as Jumlah6, 5 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'C' as 'KELOMPOK', 'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita yang Baru ditimbang bulan ini' as kegiatan, ''as Jumlah6, 6 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'C' as 'KELOMPOK', 'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita yang dapat ditimbang bulan ini' as kegiatan, ''as Jumlah6, 7 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'C' as 'KELOMPOK', 'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita yang tidak dapat ditimbang bulan ini' as kegiatan, ''as Jumlah6, 8 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'C' as 'KELOMPOK', 'Upaya Pemantauan Pertumbuhan Balita' as Program, 'jumlah Balita dengan Berat badan di Bawah Garis Merah (BGM) bulan ini' as kegiatan, ''as Jumlah6, 9 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'C' as 'KELOMPOK', 'Upaya Pemantauan Pertumbuhan Balita' as Program, 'Jumlah Balita gizi buruk bulan ini' as kegiatan, ''as Jumlah6, 10 as iRow) X");
			
			$query[4] = $db->query("SELECT X.* FROM (select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'D' as 'KELOMPOK', 'Upaya Penanggulangan Gangguan Akibat Kekurangan Yodium (GAKY)' as Program, 'Jumlah penderita GAKY laki-laki bulan ini ' as kegiatan, ''as Jumlah6, 1 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'D' as 'KELOMPOK', 'Upaya Penanggulangan Gangguan Akibat Kekurangan Yodium (GAKY)' as Program, 'Jumlah penderita GAKY perempuan bulan ini ' as kegiatan, ''as Jumlah6, 2 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'D' as 'KELOMPOK', 'Upaya Penanggulangan Gangguan Akibat Kekurangan Yodium (GAKY)' as Program, 'Jumlah ibu hamil mendapat kapsul yodium ' as kegiatan, ''as Jumlah6, 3 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'D' as 'KELOMPOK', 'Upaya Penanggulangan Gangguan Akibat Kekurangan Yodium (GAKY)' as Program, 'Jumlah penduduk lainnya mendapat kapsul yodium ' as kegiatan, ''as Jumlah6, 4 as iRow) X");
			
			$query[5] = $db->query("SELECT X.* FROM (select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'E' as 'KELOMPOK', 'Upaya Penanggulangan Kekurangan Energi Kronis (KEK)' as Program, 'Jumlah Ibu hamil baru, diukur LILA (Lingkar Lengan Atas) bulan ini ' as kegiatan, ''as Jumlah6, 1 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'E' as 'KELOMPOK', 'Upaya Penanggulangan Kekurangan Energi Kronis (KEK)' as Program, 'Jumlah Ibu hamil baru, dengan LILA < 23,5 cm bulan ini ' as kegiatan, ''as Jumlah6, 2 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'E' as 'KELOMPOK', 'Upaya Penanggulangan Kekurangan Energi Kronis (KEK)' as Program, 'Jumlah WUS baru, yang diukur LILA (Lingkar Lengan Atas) bulan ini ' as kegiatan, ''as Jumlah6, 3 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'E' as 'KELOMPOK', 'Upaya Penanggulangan Kekurangan Energi Kronis (KEK)' as Program, 'Jumlah WUS baru, dengan LILA < 23,5 cm bulan ini ' as kegiatan, ''as Jumlah6, 4 as iRow) X");
			$query[6] = $db->query("SELECT X.* FROM (select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'Jumlah kunjungan K1 Bumil ' as kegiatan, (SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil WHERE kunjungan_ke='K1' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to'))as Jumlah6, 1 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'Jumlah kunjungan Bumil lama ' as kegiatan, ''as Jumlah6, 2 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'K2' as kegiatan, (SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil WHERE kunjungan_ke='K2' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to'))as Jumlah6, 3 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'K3' as kegiatan, (SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil WHERE kunjungan_ke='K3' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to'))as Jumlah6, 4 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'K4' as kegiatan, (SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil WHERE kunjungan_ke='K4' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to'))as Jumlah6, 5 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'Kunjungan Bumil dengan faktor risiko : ' as kegiatan, ''as Jumlah6, 6 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'a. < 20 th ' as kegiatan, ''as Jumlah6, 7 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'b. > 35 th ' as kegiatan, ''as Jumlah6, 8 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'c. Spacing < 2 th ' as kegiatan, ''as Jumlah6, 9 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'd. Paritas > 5 th ' as kegiatan, ''as Jumlah6, 10 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'e. HB 11 gram %' as kegiatan, ''as Jumlah6, 11 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'f. BB Kg Triwulan III < 45 Kg ' as kegiatan, ''as Jumlah6, 12 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'g. TB < 145 cm' as kegiatan, ''as Jumlah6, 13 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'Imunisasi TT Bumil (TT1, TT2) : ' as kegiatan, ''as Jumlah6, 14 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'a. TT1 ' as kegiatan, ''as Jumlah6, 15 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'b. TT2 ' as kegiatan, ''as Jumlah6, 16 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'Pemberian tablet Fe Bumil : ' as kegiatan, ''as Jumlah6, 17 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'a. Fe1 ' as kegiatan, ''as Jumlah6, 18 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'b. Fe2 ' as kegiatan, ''as Jumlah6, 19 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'c. Fe3' as kegiatan, ''as Jumlah6, 20 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'Jumlah kesakitan dan kematian Bumil yang ditangani : ' as kegiatan, ''as Jumlah6, 21 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'a. Pendarahan ' as kegiatan, ''as Jumlah6, 22 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'b. Infeksi jalan lahir ' as kegiatan, ''as Jumlah6, 23 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'c. Preeklamasi/Eklamsi ' as kegiatan, ''as Jumlah6, 24 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'd. Sebab lain ' as kegiatan, ''as Jumlah6, 25 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'Deteksi risti bumil oleh nakes ' as kegiatan, ''as Jumlah6, 26 as iRow UNION ALL select 'KESEHATAN IBU DAN ANAK' as 'JUDUL', 'F' as 'KELOMPOK', 'Pelayanan Ibu Hamil' as Program, 'Deteksi risti bumil oleh masyarakat ' as kegiatan, ''as Jumlah6, 27 as iRow) X");
			
			if($query[1]->num_rows>0){
				//$data2 = $query2->result(); //print_r($data);die;
				
				/*if(!$data)
					return false;
				*/
				// Starting the PHPExcel library
				$this->load->library('Excel');
				$this->excel->getActiveSheet()->setTitle('bulanan');
				$this->excel->getProperties()->setTitle("export")->setDescription("none");
				
				$objReader = PHPExcel_IOFactory::createReader('Excel5');
				$objPHPExcel = $objReader->load("tmp/template_bulanan_gizi2015.xls");
				$objPHPExcel->setActiveSheetIndex(0);
					
				//$no=1;
				$total=0;
				for($no=1;$no<7;$no++){
				$data = $query[$no]->result();
				$rw=array('',10,16,30,42,48,54,83);//116,126,150,157,170,174,178,185,193,197,201,204,209,214,218,225,235);
				//$rw2=array('',9,15,29,41,47,53,82,115,125,149,156,169,173,177,184,192,196,200,203,208,213,217,224,234);
				foreach($data as $value)
				{
					$styleArray = array(
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
							),
						),
					);
					
					//$objPHPExcel->getActiveSheet()->getStyle('F'.($rw[$no]-1).':J'.$rw[$no])->applyFromArray($styleArray);

					//$objPHPExcel->getActiveSheet()->mergeCells('F'.$rw[$no].':I'.$rw[$no]);
					//$objPHPExcel->getActiveSheet()->getStyle('F'.$rw[$no])->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					//$objPHPExcel->getActiveSheet()->getStyle('H'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->setTitle('bulanan')
						//->setCellValue('F'.$rw[$no], '   '.$value->kegiatan)
						->setCellValue('J'.$rw[$no], $value->Jumlah6);
					//$rw++;
					$rw[$no]++;
				}
				//$objPHPExcel->getActiveSheet()->getStyle('F'.($rw2[$no]).':J'.($rw2[$no]))->getFont()->setBold(true);
				//$objPHPExcel->getActiveSheet()->mergeCells('F'.($rw2[$no]).':I'.($rw2[$no]));
				//$objPHPExcel->getActiveSheet()->getStyle('J'.($rw2[$no]))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				//$objPHPExcel->getActiveSheet()
					//->setCellValue('F'.($rw2[$no]), $value->JUDUL.' :   '.$value->Program)
					//->setCellValue('J'.($rw2[$no]), 'JUMLAH');
					
				}
				$data1 = $query[1]->result();
				foreach($data1 as $value1){
					//$objPHPExcel->getActiveSheet()->getStyle('J234:J237')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$objPHPExcel->getActiveSheet()
						//->setCellValue('E234', 'KEPALA PUSKESMAS')
						//->setCellValue('E237', $value1->KEPALA_PUSKESMAS)
						//->setCellValue('C5', $pid)
						//->setCellValue('C6', $value1->NAMA_PUSKESMAS)
						->setCellValue('B2', $value1->KABKOTA)
						->setCellValue('B3', $value1->dt1.' / '.$value1->dt2);
				}
				$filename='temp_gizi_kb'.date('dmY_his_').'.xls'; //save our workbook as this file name
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
	
	public function lb3a_excel_update(){
	//print_r($_POST);die;
	
		
		$from = $this->input->get('from');	//print_r($from);die;
		$to = $this->input->get('to'); //print_r($to);die;
		$pid = $this->input->get('pid');
		$jenis = $this->input->get('jenis');
		$db = $this->load->database('sikda', TRUE);
		if($jenis=='rpt_lb3'){
			$query = array();
			//$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_uks a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'")->row();//print_r($data);die;
			$query[1] = $db->query("SELECT DATE_FORMAT('$from','%d-%m-%Y') as dt1, DATE_FORMAT('$to','%d-%m-%Y') as dt2, '$pid' AS KD_PUSKESMAS, (SELECT S.KEY_VALUE FROM sys_setting AS S WHERE S.KEY_DATA = 'NAMA_PUSKESMAS' AND PUSKESMAS='$pid' LIMIT 1) AS NAMA_PUSKESMAS, (SELECT S.KEY_VALUE FROM sys_setting AS S WHERE S.KEY_DATA = 'NAMA_PIMPINAN' AND PUSKESMAS='$pid' LIMIT 1) AS KEPALA_PUSKESMAS, (SELECT P.PROVINSI FROM sys_setting S INNER JOIN mst_provinsi P ON S.KEY_VALUE=P.KD_PROVINSI WHERE S.KEY_DATA = 'KD_PROV' AND S.PUSKESMAS='$pid' LIMIT 1) AS PROVINSI, (SELECT P.KABUPATEN FROM sys_setting S INNER JOIN mst_kabupaten P ON S.KEY_VALUE=P.KD_KABUPATEN WHERE S.KEY_DATA = 'KD_KABKOTA' AND S.PUSKESMAS='$pid' LIMIT 1) AS KABKOTA, (SELECT P.KECAMATAN FROM sys_setting S INNER JOIN mst_kecamatan P ON S.KEY_VALUE=P.KD_KECAMATAN WHERE S.KEY_DATA = 'KD_KEC' AND S.PUSKESMAS='$pid' LIMIT 1) AS KECAMATAN, '' AS 'PUSTU_YG_ADA', '' AS 'YANG_LAPOR', 'DARI PARAMETER PHP' AS 'TAHUN', '' AS 'NAMA_MENGETAHUI', '' AS 'NIP_MENGETAHUI', '' AS 'LOKASI', 'TANGGAL HARI INI' AS 'TANGGAL', '' AS 'NAMA_PELAPOR', '' AS 'NIP_PELAPOR', X.* FROM 
			( select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK', 'Program Gizi' as Program, 'Jumlah ibu hamil terdaftar bulan ini' as kegiatan, IFNULL((SELECT COUNT(X.KD_PASIEN) AS jumlah FROM (SELECT * FROM kunjungan_bumil GROUP BY KD_PASIEN)X WHERE X.kd_puskesmas='$pid' AND (X.TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')),0) as Jumlah6, 1 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Ibu hamil dapat tablet tambah darah minimal 90 tablet' as kegiatan, IFNULL((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_OBAT, D.KD_PUSKESMAS, D.TANGGAL, D.QTY FROM trans_kia T
					INNER JOIN pel_ord_obat D 
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN)X
					WHERE X.KD_OBAT ='541' AND X.QTY>90 AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 2 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah ibu hamil anemia (baru/ulang)' as kegiatan, '0' as Jumlah6, 3 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Ibu Nifas dapat Vit. A dosis tinggi (2 kapsul) ' as kegiatan, IFNULL((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_OBAT, D.KD_PUSKESMAS, D.TANGGAL, D.QTY FROM trans_kia T
					INNER JOIN pel_ord_obat D 
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN)X
					WHERE X.KD_OBAT ='159' AND X.QTY>2 AND X.KD_KATEGORI_KIA='3' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 4 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Ibu Hamil KEK (baru/ulang)' as kegiatan, '0' as Jumlah6, 5 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Ibu Hamil KEK dapat PMT Ibu Bumil (baru/ulang)' as kegiatan, '0' as Jumlah6, 6 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Bayi 6-11 bulan mendapat Vit. A (100.000 IU)' as kegiatan, IFNULL ((SELECT COUNT( X.KD_PASIEN ) AS JUMLAH FROM (SELECT V.KD_PELAYANAN,V.KD_PUSKESMAS, V.KD_OBAT, l.KD_PASIEN FROM pel_ord_obat V INNER JOIN pelayanan l WHERE l.KD_PELAYANAN = V.KD_PELAYANAN) X INNER JOIN pasien p
			WHERE p.KD_PASIEN=X.KD_PASIEN AND X.KD_OBAT = '158' AND Get_Age(p.TGL_LAHIR) > 6 AND Get_Age(p.TGL_LAHIR) < 11 AND X.KD_PUSKESMAS = '$pid'),IFNULL((SELECT SUM(0)+SUM(0) FROM t_ds_gizi WHERE BULAN=DATE_FORMAT('$from','%m') AND TAHUN=DATE_FORMAT('$from','%Y') AND kd_puskesmas='$pid'),0)) as Jumlah6, 7 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah bayi usia kurang dari 6 bulan dapat ASI ekslusif (baru)' as kegiatan, '0' as Jumlah6, 8 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Balita (terdaftar bulan ini)' as kegiatan, '0' as Jumlah6, 9 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah anak Balita dapat Vit. A dosis tinggi (200.000 IU) ' as kegiatan, '0' as Jumlah6, 10 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Balita punya Buku KIA (terdaftar bulan ini)' as kegiatan, IFNULL((SELECT SUM(r.BAYI_L_0_12_KMS_K)+SUM(r.ANAK_L_12_36_KMS_K)+SUM(r.ANAK_L_37_60_KMS_K)+SUM(r.BAYI_P_0_12_KMS_K)+SUM(r.ANAK_P_12_36_KMS_K)+SUM(r.ANAK_P_37_60_KMS_K) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 11 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Balita ditimbang (D)' as kegiatan, IFNULL((SELECT SUM(r.BAYI_L_0_12_D)+SUM(r.ANAK_L_12_36_D)+SUM(r.ANAK_L_37_60_D)+SUM(r.BAYI_P_0_12_D)+SUM(r.ANAK_P_12_36_D)+SUM(r.ANAK_P_37_60_D) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 12 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Balita ditimbang yang naik berat badannya (N)' as kegiatan, IFNULL((SELECT SUM(r.BAYI_L_0_12_N)+SUM(r.ANAK_L_12_36_N)+SUM(r.ANAK_L_37_60_N)+SUM(r.BAYI_P_0_12_N)+SUM(r.ANAK_P_12_36_N)+SUM(r.ANAK_P_37_60_N) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 13 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Balita ditimbang yang tidak naik berat badannya (T)' as kegiatan, IFNULL((SELECT (SUM(r.BAYI_L_0_12_D)+SUM(r.ANAK_L_12_36_D)+SUM(r.ANAK_L_37_60_D)+SUM(r.BAYI_P_0_12_D)+SUM(r.ANAK_P_12_36_D)+SUM(r.ANAK_P_37_60_D))-(SUM(r.BAYI_L_0_12_N)+SUM(r.ANAK_L_12_36_N)+SUM(r.ANAK_L_37_60_N)+SUM(r.BAYI_P_0_12_N)+SUM(r.ANAK_P_12_36_N)+SUM(r.ANAK_P_37_60_N)) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 14 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Balita ditimbang yang tidak naik berat badannya 2 kali berturut-turut (2T)' as kegiatan, '0' as Jumlah6, 15 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Balita di bawah garis merah (BGM)' as kegiatan, IFNULL((SELECT SUM(r.BAYI_L_BGM_MP_ASI)+SUM(r.BAYI_P_BGM_MP_ASI) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 16 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Balita kurus' as kegiatan, '0' as Jumlah6, 17 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Balita kurus mendapat makanan tambahan (PMT)' as kegiatan, '0' as Jumlah6, 18 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah kasus Balita gizi buruk (baru/lama)' as kegiatan, IFNULL ((SELECT COUNT( Z.KD_PELAYANAN ) AS JUMLAH FROM (SELECT V.KD_PELAYANAN,V.KD_PUSKESMAS, V.KD_PENYAKIT, V.TANGGAL, l.KD_PASIEN FROM pel_diagnosa V INNER JOIN pelayanan l WHERE l.KD_PELAYANAN = V.KD_PELAYANAN) Z INNER JOIN pasien p
			WHERE p.KD_PASIEN=Z.KD_PASIEN AND Z.KD_PENYAKIT='E42' AND Z.KD_PUSKESMAS = '$pid' AND (Z.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 19 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumah kasus gizi buruk ditangani (baru/lanjutan)' as kegiatan, IFNULL ((SELECT COUNT( X.KD_PELAYANAN ) AS JUMLAH FROM (SELECT V.KD_PELAYANAN,V.KD_PUSKESMAS, V.KD_PENYAKIT, V.TANGGAL, l.KD_PASIEN FROM pel_diagnosa V INNER JOIN pelayanan l WHERE l.KD_PELAYANAN = V.KD_PELAYANAN) X INNER JOIN pasien p
			WHERE p.KD_PASIEN=X.KD_PASIEN AND X.KD_PENYAKIT='E42' AND X.KD_PUSKESMAS = '$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 20 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Bayi dengan berat badan lahir rendah (BBLR)' as kegiatan, IFNULL ((SELECT COUNT( X.KD_PELAYANAN ) AS JUMLAH FROM (SELECT V.KD_PELAYANAN,V.KD_PUSKESMAS, V.KD_PENYAKIT, V.TANGGAL, l.KD_PASIEN FROM pel_diagnosa V INNER JOIN pelayanan l WHERE l.KD_PELAYANAN = V.KD_PELAYANAN) X INNER JOIN pasien p
			WHERE p.KD_PASIEN=X.KD_PASIEN AND X.KD_PENYAKIT = 'P07.1' AND X.KD_PUSKESMAS = '$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 21 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah bayi baru lahir mendapat Inisiasi menyusu dini (IMD)' as kegiatan, '0' as Jumlah6, 22 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah remaja putri yang telah mendapat tablet tambah darah tahun ini (TTD)' as kegiatan, '0' as Jumlah6, 23 as iRow  ) X ");//print_r($query);die;
			
			$query[2] = $db->query("SELECT X.* FROM (
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'Jumlah kunjungan K1 ibu hamil' as kegiatan, IFNULL((SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil WHERE kunjungan_ke='K1' AND kd_puskesmas='$pid' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')),0) as Jumlah6, 1 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'Jumlah kunjungan K4 ibu hamil  ' as kegiatan, IFNULL((SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil WHERE kunjungan_ke='K4' AND kd_puskesmas='$pid' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')),0) as Jumlah6, 2 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'Jumlah kunjungan ibu hamil dengan faktor risiko (umur<20 th atau >35th;  paritas >4;  jarak kehamilan <2 th; LiLA <23,5 cm dan TB <145cm) (baru/ulang)' as kegiatan, '0'as Jumlah6, 3 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'Jumlah ibu hamil risiko tinggi (perdarahan, infeksi, abortus, keracunan kehamilan, partus lama) yang ditangani :' as kegiatan, '0' as Jumlah6, 4 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'a. Jumlah ibu hamil mengalami perdarahan ditangani (baru/ulang)' as kegiatan, IFNULL((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D 
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN)X
					WHERE X.KD_PENYAKIT ='o72' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 5 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'b. Jumlah ibu hamil dengan malaria ditangani (baru/ulang)' as kegiatan, IFNULL((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK')X
					WHERE X.KD_PENYAKIT ='b54' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 6 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'c. Jumlah ibu hamil dengan TB ditangani (baru/ulang)' as kegiatan, IFNULL((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK')X
					WHERE X.KD_PENYAKIT ='o98.0' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 7 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'g. Jumlah ibu hamil dengan infeksi lainnya ditangani (baru/ulang)' as kegiatan, '0' as Jumlah6, 8 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'h. Jumlah keguguran ditangani' as kegiatan, '0' as Jumlah6, 9 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'i. Jumlah ibu hamil preeklamsi ditangani' as kegiatan, IFNULL ((SELECT SUM((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK')X
					WHERE X.KD_PENYAKIT ='o13' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to'))+(SELECT COUNT(X.KD_PELAYANAN) as JML2
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK' )X
					WHERE X.KD_PENYAKIT LIKE 'o14.%' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')) )),0) as Jumlah6, 10 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'j. Jumlah ibu hamil dengan eklamsia (keracunan kehamilan) ditangani' as kegiatan, IFNULL ((SELECT SUM((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK')X
					WHERE X.KD_PENYAKIT ='o15' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to'))+(SELECT COUNT(X.KD_PELAYANAN) as JML2
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK')X
					WHERE X.KD_PENYAKIT LIKE 'o15.0' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')) )),0) as Jumlah6, 11 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'k. Jumlah ibu melahirkan dengan partus  lama ditangani' as kegiatan, IFNULL((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK')X
					WHERE X.KD_PENYAKIT ='o63' AND X.KD_KATEGORI_KIA='2' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 12 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'Jumlah ibu hamil, Ibu Bersalin, dan Ibu Nifas  risiko tinggi (perdarahan, infeksi, abortus, keracunan kehamilan, partus lama)  yang dirujuk ke RS' as kegiatan, 
			IFNULL((SELECT COUNT(t.KD_PELAYANAN) as JML2 FROM trans_kia t INNER JOIN pelayanan p WHERE p.KD_PELAYANAN=t.KD_PELAYANAN AND p.KEADAAN_KELUAR='DIRUJUK' AND p.KD_PUSKESMAS='$pid' AND (p.TGL_PELAYANAN BETWEEN '$from' AND '$to')),0) as Jumlah6, 13 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'Jumlah ibu hamil yang mengikuti kelas ibu hamil' as kegiatan, '0' as Jumlah6, 14 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'Jumlah ibu bersalin ditolong tenaga kesehatan (bidan/dokter)' as kegiatan, IFNULL((SELECT COUNT(KD_PASIEN) AS TOTAL
			FROM kunjungan_bersalin WHERE KD_DOKTER != 'DUKUN' AND SUBSTR(KD_PASIEN,1,11)='$pid' AND (TANGGAL_PERSALINAN BETWEEN '$from' AND '$to')),0) as Jumlah6, 15 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'Jumlah ibu bersalin di fasilitas pelayanan kesehatan' as kegiatan, IFNULL((SELECT COUNT(KD_PASIEN) AS TOTAL
			FROM kunjungan_bersalin WHERE KD_DOKTER != 'DUKUN' AND SUBSTR(KD_PASIEN,1,11)='$pid' AND (TANGGAL_PERSALINAN BETWEEN '$from' AND '$to')),0) as Jumlah6, 16 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'Jumlah ibu bersalin dan nifas  dengan risiko ditangani (perdarahan dan infeksi)' as kegiatan, 
			IFNULL ((SELECT SUM((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK')X
					WHERE X.KD_PENYAKIT ='o72' AND (X.KD_KATEGORI_KIA BETWEEN '2' AND '3') AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to'))+
					(SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK')X
					WHERE X.KD_PENYAKIT ='o85' AND (X.KD_KATEGORI_KIA BETWEEN '2' AND '3') AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to'))
			)),0) as Jumlah6, 17 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'a. Jumlah ibu bersalin dan nifas dengan  pendarahan ditangani (baru/ulang)' as kegiatan,  IFNULL((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK')X
					WHERE X.KD_PENYAKIT ='o72' AND (X.KD_KATEGORI_KIA BETWEEN '2' AND '3') AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 18 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'b. Jumlah ibu bersalin dan nifas dengan infeksi ditangani (baru/ulang)' as kegiatan, IFNULL((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK')X
					WHERE X.KD_PENYAKIT ='o85' AND (X.KD_KATEGORI_KIA BETWEEN '2' AND '3') AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 19 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'Jumlah peserta KB aktif (baru/aktif)' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 20 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'a. IUD' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='1' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 21 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'b. Implan' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='4' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 22 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'c. Tubektomi' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='10' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 23 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'd. Vasektomi' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='11' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 24 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'e. Suntik' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='6' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 25 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'f. Pil' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='7' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 26 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'g. Kondom' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='8' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 27 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'Jumlah peserta KB Pasca Persalinan (permetode kontrasepsi)' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 28 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'a. IUD' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='1' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 29 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'b. Implan' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='4' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 30 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'c. Tubektomi' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='10' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 31 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'd. Vasektomi' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='11' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 32 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'e. Suntik' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='6' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 33 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'f. Pil' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='7' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 34 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'g. Kondom' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='8' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 35 as iRow) X");
			
			$query[3] = $db->query("SELECT X.* FROM (
			select  'GKIA' as 'JUDUL',  'C' as 'KELOMPOK', 'Program Kesehatan Anak' as Program, 'Jumlah Kunjungan Neonatal Pertama (KN1)' as kegiatan, IFNULL((SELECT COUNT(KD_PASIEN) AS TOTAL
			FROM pemeriksaan_neonatus WHERE KUNJUNGAN_KE = 'KN1' AND KD_PUSKESMAS='$pid' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')), IFNULL((SELECT SUM(r.JML_KJ_N_BR_0_7HARI_KN1)+SUM(r.JML_KJ_N_BR_0_7HARI_KN1_p) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0)) as Jumlah6, 1 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'C' as 'KELOMPOK', 'Program Kesehatan Anak' as Program, 'Jumlah Kunjungan Neonatal Lengkap (KN lengkap)' as kegiatan, IFNULL((SELECT COUNT(X.KD_PASIEN) AS TOTAL FROM (SELECT KD_PASIEN, KUNJUNGAN_KE, KD_PUSKESMAS, TANGGAL_KUNJUNGAN FROM pemeriksaan_neonatus WHERE KUNJUNGAN_KE='KN1' )X
			INNER JOIN (SELECT KD_PASIEN, KUNJUNGAN_KE, KD_PUSKESMAS, TANGGAL_KUNJUNGAN FROM pemeriksaan_neonatus WHERE KUNJUNGAN_KE='KN2' )Y
			INNER JOIN (SELECT KD_PASIEN, KUNJUNGAN_KE, KD_PUSKESMAS, TANGGAL_KUNJUNGAN FROM pemeriksaan_neonatus WHERE KUNJUNGAN_KE='KN3' )Z WHERE Z.KD_PASIEN=Y.KD_PASIEN AND Y.KD_PASIEN=X.KD_PASIEN 
			AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL_KUNJUNGAN BETWEEN '(DATE_SUB $from,INTERVAL 31 DAY)' AND '$to')),0) as Jumlah6, 2 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'C' as 'KELOMPOK', 'Program Kesehatan Anak' as Program, 'Jumlah neonatus dengan komplikasi yang ditangani (baru/ulang)' as kegiatan, IFNULL((SELECT SUM(r.NEONATUS_KOMPLIKASI_L)+SUM(r.NEONATUS_KOMPLIKASI_P) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 3 as iRow
			UNION ALL			
			select  'GKIA' as 'JUDUL',  'C' as 'KELOMPOK', 'Program Kesehatan Anak' as Program, 'Jumlah neonatus yang mendapat pelayanan skrining hipotiroid kongenital (SHK)' as kegiatan, IFNULL((SELECT SUM(r.NEONATUS_SHK_L)+SUM(r.NEONATUS_SHK_P) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 4 as iRow
			UNION ALL			
			select  'GKIA' as 'JUDUL',  'C' as 'KELOMPOK', 'Program Kesehatan Anak' as Program, 'Jumlah Balita yang telah mendapatkan pelayanan stimulasi deteksi dan intervensi dini tumbuh kembang (SDIDTK) sebanyak 2 kali tahun ini' as kegiatan, IFNULL((SELECT SUM(r.BALITA_SDIDTK_L)+SUM(r.BALITA_SDIDTK_P) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 5 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'C' as 'KELOMPOK', 'Program Kesehatan Anak' as Program, 'Jumlah anak prasekolah yang mendapatkan pelayanan SDIDTK sebanyak 2 kali tahun ini' as kegiatan, IFNULL((SELECT SUM(r.ANAK_PRA_SDIDTK_L)+SUM(r.ANAK_PRA_SDIDTK_P) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 6 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'C' as 'KELOMPOK', 'Program Kesehatan Anak' as Program, 'Jumlah remaja (10-19 tahun) yang mendapatkan konseling oleh tenaga kesehatan (baru/ulang pada kasus yang sama)' as kegiatan, IFNULL ((SELECT COUNT( X.KD_PELAYANAN ) AS JUMLAH FROM (SELECT V.KD_PELAYANAN,V.KD_PUSKESMAS, V.KD_PENYAKIT, V.TANGGAL, l.KD_PASIEN FROM pel_diagnosa V INNER JOIN pelayanan l WHERE l.KD_PELAYANAN = V.KD_PELAYANAN) X INNER JOIN pasien p
			WHERE p.KD_PASIEN=X.KD_PASIEN AND X.KD_PENYAKIT = 'Z70' AND X.KD_PUSKESMAS = '$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')), IFNULL((SELECT SUM(r.REMAJA_KONSELING_L)+SUM(r.REMAJA_KONSELING_P) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0)) as Jumlah6, 7 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'C' as 'KELOMPOK', 'Program Kesehatan Anak' as Program, 'Jumlah kelompok remaja diluar sekolah (karang taruna, remaja mesjid, gereja, pura, wihara, dll) yang mendapatkan KIE kesehatan remaja' as kegiatan, IFNULL((SELECT SUM(r.REMAJA_KIE_L)+SUM(r.REMAJA_KIE_P) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 8 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'C' as 'KELOMPOK', 'Program Kesehatan Anak' as Program, 'Jumlah anak dan remaja (umur <20 tahun) dengan disabilitas yang ditangani (baru/ulang)' as kegiatan, IFNULL((SELECT SUM(r.REMAJA_DISABILITAS_L)+SUM(r.REMAJA_DISABILITAS_P) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 9 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'C' as 'KELOMPOK', 'Program Kesehatan Anak' as Program, 'Jumlah anak dan remaja (umur <20 tahun) korban kekerasan yang ditangani (pelayanan medis, visum, pelayanan konseling) (baru/ulang)' as kegiatan, IFNULL ((SELECT COUNT( X.KD_PELAYANAN ) AS JUMLAH FROM (SELECT V.KD_PELAYANAN,V.KD_PUSKESMAS, V.KD_PENYAKIT, V.TANGGAL, l.KD_PASIEN FROM pel_diagnosa V INNER JOIN pelayanan l WHERE l.KD_PELAYANAN = V.KD_PELAYANAN) X INNER JOIN pasien p
			WHERE p.KD_PASIEN=X.KD_PASIEN AND X.KD_PENYAKIT LIKE 'T74%' AND X.KD_PUSKESMAS = '$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')), IFNULL((SELECT SUM(r.REMAJA_KORBAN_KEKERASAN_DITANGANI_L)+SUM(r.REMAJA_KORBAN_KEKERASAN_DITANGANI_P) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0)) as Jumlah6, 10 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'C' as 'KELOMPOK', 'Program Kesehatan Anak' as Program, 'Jumlah anak korban kekerasan yang dirujuk (medis, psikososial, hukum)' as kegiatan, IFNULL((SELECT SUM(r.REMAJA_KORBAN_KEKERASAN_DIRUJUK_L)+SUM(r.REMAJA_KORBAN_KEKERASAN_DIRUJUK_P) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 11 as iRow) X");
			
			if($query[1]->num_rows>0){
				//$data2 = $query2->result(); //print_r($data);die;
				
				/*if(!$data)
					return false;
				*/
				// Starting the PHPExcel library
				$this->load->library('Excel');
				$this->excel->getActiveSheet()->setTitle('LB3');
				$this->excel->getProperties()->setTitle("export")->setDescription("none");
				
				$objReader = PHPExcel_IOFactory::createReader('Excel5');
				$objPHPExcel = $objReader->load("tmp/laporan_lb3a.xls");
				$objPHPExcel->setActiveSheetIndex(0);
					
				//$no=1;
				$total=0;
				for($no=1;$no<4;$no++){
				$data = $query[$no]->result();
				$rw=array('',10,35,72);
				$rw2=array('',9,34,71);
				foreach($data as $value)
				{
					$styleArray = array(
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
							),
						),
					);
					$objPHPExcel->getActiveSheet()->getStyle('A'.($rw[$no]-1).':E'.$rw[$no])->applyFromArray($styleArray);

					$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw[$no].':D'.$rw[$no]);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$rw[$no])->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setWrapText(true);
					//$objPHPExcel->getActiveSheet()->getStyle('C'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->setTitle('Data')
						->setCellValue('A'.$rw[$no], '   '.$value->kegiatan)
						->setCellValue('E'.$rw[$no], $value->Jumlah6);
					//$rw++;
					$rw[$no]++;
				}
				$objPHPExcel->getActiveSheet()->getStyle('A'.($rw2[$no]).':E'.($rw2[$no]))->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->mergeCells('A'.($rw2[$no]).':D'.($rw2[$no]));
				$objPHPExcel->getActiveSheet()->getStyle('E'.($rw2[$no]))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()
					->setCellValue('A'.($rw2[$no]), $value->JUDUL.' :   '.$value->Program)
					->setCellValue('E'.($rw2[$no]), 'JUMLAH')
					;
					
				}
				$data1 = $query[1]->result();
				foreach($data1 as $value1){
					$objPHPExcel->getActiveSheet()->getStyle('E234:E237')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$objPHPExcel->getActiveSheet()
						->setCellValue('E84', 'KEPALA PUSKESMAS')
						->setCellValue('E88', $value1->KEPALA_PUSKESMAS)
						->setCellValue('C5', $pid)
						->setCellValue('C6', $value1->NAMA_PUSKESMAS)
						->setCellValue('C7', $value1->KABKOTA)
						->setCellValue('E6', $value1->dt1.' / '.$value1->dt2);
				}
				$filename='laporan_lb3_'.date('dmY_his_').'.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
				
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				$objWriter->save('php://output');
			}else{
				die('Tidak Ada Dalam Database');
			}
		}else{	
			$query = array();
			//$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_uks a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'")->row();//print_r($data);die;
			$query[1] = $db->query("SELECT DATE_FORMAT('$from','%d-%m-%Y') as dt1, DATE_FORMAT('$to','%d-%m-%Y') as dt2, '$pid' AS KD_PUSKESMAS, (SELECT S.KEY_VALUE FROM sys_setting AS S WHERE S.KEY_DATA = 'NAMA_PUSKESMAS' AND PUSKESMAS='$pid' LIMIT 1) AS NAMA_PUSKESMAS, (SELECT S.KEY_VALUE FROM sys_setting AS S WHERE S.KEY_DATA = 'NAMA_PIMPINAN' AND PUSKESMAS='$pid' LIMIT 1) AS KEPALA_PUSKESMAS, (SELECT P.PROVINSI FROM sys_setting S INNER JOIN mst_provinsi P ON S.KEY_VALUE=P.KD_PROVINSI WHERE S.KEY_DATA = 'KD_PROV' AND S.PUSKESMAS='$pid' LIMIT 1) AS PROVINSI, (SELECT P.KABUPATEN FROM sys_setting S INNER JOIN mst_kabupaten P ON S.KEY_VALUE=P.KD_KABUPATEN WHERE S.KEY_DATA = 'KD_KABKOTA' AND S.PUSKESMAS='$pid' LIMIT 1) AS KABKOTA, (SELECT P.KECAMATAN FROM sys_setting S INNER JOIN mst_kecamatan P ON S.KEY_VALUE=P.KD_KECAMATAN WHERE S.KEY_DATA = 'KD_KEC' AND S.PUSKESMAS='$pid' LIMIT 1) AS KECAMATAN, '' AS 'PUSTU_YG_ADA', '' AS 'YANG_LAPOR', 'DARI PARAMETER PHP' AS 'TAHUN', '' AS 'NAMA_MENGETAHUI', '' AS 'NIP_MENGETAHUI', '' AS 'LOKASI', 'TANGGAL HARI INI' AS 'TANGGAL', '' AS 'NAMA_PELAPOR', '' AS 'NIP_PELAPOR', X.* FROM 
			( select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK', 'Program Gizi' as Program, 'Jumlah ibu hamil terdaftar bulan ini' as kegiatan, IFNULL((SELECT COUNT(X.KD_PASIEN) AS jumlah FROM (SELECT * FROM kunjungan_bumil GROUP BY KD_PASIEN)X WHERE X.kd_puskesmas='$pid' AND (X.TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')),0) as Jumlah6, 1 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Ibu hamil dapat tablet tambah darah minimal 90 tablet' as kegiatan, IFNULL((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_OBAT, D.KD_PUSKESMAS, D.TANGGAL, D.QTY FROM trans_kia T
					INNER JOIN pel_ord_obat D 
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN)X
					WHERE X.KD_OBAT ='541' AND X.QTY>90 AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 2 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah ibu hamil anemia (baru/ulang)' as kegiatan, '0' as Jumlah6, 3 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Ibu Nifas dapat Vit. A dosis tinggi (2 kapsul) ' as kegiatan, IFNULL((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_OBAT, D.KD_PUSKESMAS, D.TANGGAL, D.QTY FROM trans_kia T
					INNER JOIN pel_ord_obat D 
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN)X
					WHERE X.KD_OBAT ='159' AND X.QTY>2 AND X.KD_KATEGORI_KIA='3' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 4 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Ibu Hamil KEK (baru/ulang)' as kegiatan, '0' as Jumlah6, 5 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Ibu Hamil KEK dapat PMT Ibu Bumil (baru/ulang)' as kegiatan, '0' as Jumlah6, 6 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Bayi 6-11 bulan mendapat Vit. A (100.000 IU)' as kegiatan, IFNULL ((SELECT COUNT( X.KD_PASIEN ) AS JUMLAH FROM (SELECT V.KD_PELAYANAN,V.KD_PUSKESMAS, V.KD_OBAT, l.KD_PASIEN FROM pel_ord_obat V INNER JOIN pelayanan l WHERE l.KD_PELAYANAN = V.KD_PELAYANAN) X INNER JOIN pasien p
			WHERE p.KD_PASIEN=X.KD_PASIEN AND X.KD_OBAT = '158' AND Get_Age(p.TGL_LAHIR) > 6 AND Get_Age(p.TGL_LAHIR) < 11 AND X.KD_PUSKESMAS = '$pid'),IFNULL((SELECT SUM(0)+SUM(0) FROM t_ds_gizi WHERE BULAN=DATE_FORMAT('$from','%m') AND TAHUN=DATE_FORMAT('$from','%Y') AND kd_puskesmas='$pid'),0)) as Jumlah6, 7 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah bayi usia kurang dari 6 bulan dapat ASI ekslusif (baru)' as kegiatan, '0' as Jumlah6, 8 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Balita (terdaftar bulan ini)' as kegiatan, '0' as Jumlah6, 9 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah anak Balita dapat Vit. A dosis tinggi (200.000 IU) ' as kegiatan, '0' as Jumlah6, 10 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Balita punya Buku KIA (terdaftar bulan ini)' as kegiatan, IFNULL((SELECT SUM(r.BAYI_L_0_12_KMS_K)+SUM(r.ANAK_L_12_36_KMS_K)+SUM(r.ANAK_L_37_60_KMS_K)+SUM(r.BAYI_P_0_12_KMS_K)+SUM(r.ANAK_P_12_36_KMS_K)+SUM(r.ANAK_P_37_60_KMS_K) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 11 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Balita ditimbang (D)' as kegiatan, IFNULL((SELECT SUM(r.BAYI_L_0_12_D)+SUM(r.ANAK_L_12_36_D)+SUM(r.ANAK_L_37_60_D)+SUM(r.BAYI_P_0_12_D)+SUM(r.ANAK_P_12_36_D)+SUM(r.ANAK_P_37_60_D) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 12 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Balita ditimbang yang naik berat badannya (N)' as kegiatan, IFNULL((SELECT SUM(r.BAYI_L_0_12_N)+SUM(r.ANAK_L_12_36_N)+SUM(r.ANAK_L_37_60_N)+SUM(r.BAYI_P_0_12_N)+SUM(r.ANAK_P_12_36_N)+SUM(r.ANAK_P_37_60_N) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 13 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Balita ditimbang yang tidak naik berat badannya (T)' as kegiatan, IFNULL((SELECT (SUM(r.BAYI_L_0_12_D)+SUM(r.ANAK_L_12_36_D)+SUM(r.ANAK_L_37_60_D)+SUM(r.BAYI_P_0_12_D)+SUM(r.ANAK_P_12_36_D)+SUM(r.ANAK_P_37_60_D))-(SUM(r.BAYI_L_0_12_N)+SUM(r.ANAK_L_12_36_N)+SUM(r.ANAK_L_37_60_N)+SUM(r.BAYI_P_0_12_N)+SUM(r.ANAK_P_12_36_N)+SUM(r.ANAK_P_37_60_N)) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 14 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Balita ditimbang yang tidak naik berat badannya 2 kali berturut-turut (2T)' as kegiatan, '0' as Jumlah6, 15 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Balita di bawah garis merah (BGM)' as kegiatan, IFNULL((SELECT SUM(r.BAYI_L_BGM_MP_ASI)+SUM(r.BAYI_P_BGM_MP_ASI) AS jumlah FROM t_ds_gizi r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 16 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Balita kurus' as kegiatan, '0' as Jumlah6, 17 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Balita kurus mendapat makanan tambahan (PMT)' as kegiatan, '0' as Jumlah6, 18 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah kasus Balita gizi buruk (baru/lama)' as kegiatan, '0' as Jumlah6, 19 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumah kasus gizi buruk ditangani (baru/lanjutan)' as kegiatan, '0' as Jumlah6, 20 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah Bayi dengan berat badan lahir rendah (BBLR)' as kegiatan, '0' as Jumlah6, 21 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah bayi baru lahir mendapat Inisiasi menyusu dini (IMD)' as kegiatan, '0' as Jumlah6, 22 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'A' as 'KELOMPOK','Program Gizi' as Program, 'Jumlah remaja putri yang telah mendapat tablet tambah darah tahun ini (TTD)' as kegiatan, '0' as Jumlah6, 23 as iRow  ) X ");//print_r($query);die;
			
			$query[2] = $db->query("SELECT X.* FROM (
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'Jumlah kunjungan K1 ibu hamil' as kegiatan, IFNULL((SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil WHERE kunjungan_ke='K1' AND kd_puskesmas='$pid' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')),0) as Jumlah6, 1 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'Jumlah kunjungan K4 ibu hamil  ' as kegiatan, IFNULL((SELECT COUNT(KD_KUNJUNGAN_BUMIL) AS jumlah FROM kunjungan_bumil WHERE kunjungan_ke='K4' AND kd_puskesmas='$pid' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')),0) as Jumlah6, 2 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'Jumlah kunjungan ibu hamil dengan faktor risiko (umur<20 th atau >35th;  paritas >4;  jarak kehamilan <2 th; LiLA <23,5 cm dan TB <145cm) (baru/ulang)' as kegiatan, '0'as Jumlah6, 3 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'Jumlah ibu hamil risiko tinggi (perdarahan, infeksi, abortus, keracunan kehamilan, partus lama) yang ditangani :' as kegiatan, IFNULL ((SELECT SUM((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D 
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN)X
					WHERE X.KD_PENYAKIT ='o72' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to'))+(SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK')X
					WHERE X.KD_PENYAKIT ='b54' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to'))+(SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK')X
					WHERE X.KD_PENYAKIT ='o98.0' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to'))+(SELECT SUM((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK')X
					WHERE X.KD_PENYAKIT ='o13' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to'))+(SELECT COUNT(X.KD_PELAYANAN) as JML2
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK' )X
					WHERE X.KD_PENYAKIT LIKE 'o14.%' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')) ))+(SELECT SUM((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK')X
					WHERE X.KD_PENYAKIT ='o15' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to'))+(SELECT COUNT(X.KD_PELAYANAN) as JML2
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK')X
					WHERE X.KD_PENYAKIT LIKE 'o15.0' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')) ))+(SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK')X
					WHERE X.KD_PENYAKIT ='o63' AND X.KD_KATEGORI_KIA='2' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')))),0) as Jumlah6, 4 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'a. Jumlah ibu hamil mengalami perdarahan ditangani (baru/ulang)' as kegiatan, IFNULL((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D 
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN)X
					WHERE X.KD_PENYAKIT ='o72' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 5 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'b. Jumlah ibu hamil dengan malaria ditangani (baru/ulang)' as kegiatan, IFNULL((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK')X
					WHERE X.KD_PENYAKIT ='b54' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 6 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'c. Jumlah ibu hamil dengan TB ditangani (baru/ulang)' as kegiatan, IFNULL((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK')X
					WHERE X.KD_PENYAKIT ='o98.0' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 7 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'g. Jumlah ibu hamil dengan infeksi lainnya ditangani (baru/ulang)' as kegiatan, '0' as Jumlah6, 8 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'h. Jumlah keguguran ditangani' as kegiatan, '0' as Jumlah6, 9 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'i. Jumlah ibu hamil preeklamsi ditangani' as kegiatan, IFNULL ((SELECT SUM((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK')X
					WHERE X.KD_PENYAKIT ='o13' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to'))+(SELECT COUNT(X.KD_PELAYANAN) as JML2
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK' )X
					WHERE X.KD_PENYAKIT LIKE 'o14.%' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')) )),0) as Jumlah6, 10 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'j. Jumlah ibu hamil dengan eklamsia (keracunan kehamilan) ditangani' as kegiatan, IFNULL ((SELECT SUM((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK')X
					WHERE X.KD_PENYAKIT ='o15' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to'))+(SELECT COUNT(X.KD_PELAYANAN) as JML2
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK')X
					WHERE X.KD_PENYAKIT LIKE 'o15.0' AND X.KD_KATEGORI_KIA='1' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')) )),0) as Jumlah6, 11 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'k. Jumlah ibu melahirkan dengan partus  lama ditangani' as kegiatan, IFNULL((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK')X
					WHERE X.KD_PENYAKIT ='o63' AND X.KD_KATEGORI_KIA='2' AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 12 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'Jumlah ibu hamil, Ibu Bersalin, dan Ibu Nifas  risiko tinggi (perdarahan, infeksi, abortus, keracunan kehamilan, partus lama)  yang dirujuk ke RS' as kegiatan, 
			IFNULL((SELECT COUNT(t.KD_PELAYANAN) as JML2 FROM trans_kia t INNER JOIN pelayanan p WHERE p.KD_PELAYANAN=t.KD_PELAYANAN AND p.KEADAAN_KELUAR='DIRUJUK' AND p.KD_PUSKESMAS='$pid' AND (p.TGL_PELAYANAN BETWEEN '$from' AND '$to')),0) as Jumlah6, 13 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'Jumlah ibu hamil yang mengikuti kelas ibu hamil' as kegiatan, '0' as Jumlah6, 14 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'Jumlah ibu bersalin ditolong tenaga kesehatan (bidan/dokter)' as kegiatan, IFNULL((SELECT COUNT(KD_PASIEN) AS TOTAL
			FROM kunjungan_bersalin WHERE KD_DOKTER != 'DUKUN' AND SUBSTR(KD_PASIEN,1,11)='$pid' AND (TANGGAL_PERSALINAN BETWEEN '$from' AND '$to')),0) as Jumlah6, 15 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'Jumlah ibu bersalin di fasilitas pelayanan kesehatan' as kegiatan, IFNULL((SELECT COUNT(KD_PASIEN) AS TOTAL
			FROM kunjungan_bersalin WHERE KD_DOKTER != 'DUKUN' AND SUBSTR(KD_PASIEN,1,11)='$pid' AND (TANGGAL_PERSALINAN BETWEEN '$from' AND '$to')),0) as Jumlah6, 16 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'Jumlah ibu bersalin dan nifas  dengan risiko ditangani (perdarahan dan infeksi)' as kegiatan, 
			IFNULL ((SELECT SUM((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK')X
					WHERE X.KD_PENYAKIT ='o72' AND (X.KD_KATEGORI_KIA BETWEEN '2' AND '3') AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to'))+
					(SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK')X
					WHERE X.KD_PENYAKIT ='o85' AND (X.KD_KATEGORI_KIA BETWEEN '2' AND '3') AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to'))
			)),0) as Jumlah6, 17 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'a. Jumlah ibu bersalin dan nifas dengan  pendarahan ditangani (baru/ulang)' as kegiatan,  IFNULL((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK')X
					WHERE X.KD_PENYAKIT ='o72' AND (X.KD_KATEGORI_KIA BETWEEN '2' AND '3') AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 18 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'b. Jumlah ibu bersalin dan nifas dengan infeksi ditangani (baru/ulang)' as kegiatan, IFNULL((SELECT COUNT(X.KD_PELAYANAN) as JML1
					FROM(SELECT T.KD_PELAYANAN, T.KD_KATEGORI_KIA, D.KD_PENYAKIT, D.KD_PUSKESMAS, D.TANGGAL FROM trans_kia T
					INNER JOIN pel_diagnosa D INNER JOIN pelayanan P
					WHERE D.KD_PELAYANAN = T.KD_PELAYANAN AND P.KD_PELAYANAN = T.KD_PELAYANAN AND P.KEADAAN_KELUAR!='DIRUJUK')X
					WHERE X.KD_PENYAKIT ='o85' AND (X.KD_KATEGORI_KIA BETWEEN '2' AND '3') AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 19 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'Jumlah peserta KB aktif (baru/aktif)' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 20 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'a. IUD' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='1' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 21 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'b. Implan' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='4' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 22 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'c. Tubektomi' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='10' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 23 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'd. Vasektomi' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='11' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 24 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'e. Suntik' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='6' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 25 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'f. Pil' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='7' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 26 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'g. Kondom' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='8' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 27 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'Jumlah peserta KB Pasca Persalinan (permetode kontrasepsi)' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 28 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'a. IUD' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='1' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 29 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'b. Implan' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='4' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 30 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'c. Tubektomi' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='10' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 31 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'd. Vasektomi' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='11' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 32 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'e. Suntik' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='6' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 33 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'f. Pil' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='7' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 34 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'B' as 'KELOMPOK', 'Program Kesehatan Ibu' as Program, 'g. Kondom' as kegiatan, IFNULL ((SELECT COUNT(X.KD_PELAYANAN) as JML2 FROM 
			(SELECT a.KD_KIA, a.KD_PELAYANAN, a.KD_KATEGORI_KIA, a.KD_KUNJUNGAN_KIA, b.KD_JENIS_KB, b.KD_PUSKESMAS, b.TANGGAL FROM trans_kia a 
			INNER JOIN kunjungan_kb b WHERE b.KD_KIA=a.KD_KIA AND a.KD_KUNJUNGAN_KIA='4' AND b.KD_JENIS_KB='8' )X WHERE X.KD_PUSKESMAS='$pid' AND (X.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 35 as iRow) X");
			
			$query[3] = $db->query("SELECT X.* FROM (
			select  'GKIA' as 'JUDUL',  'C' as 'KELOMPOK', 'Program Kesehatan Anak' as Program, 'Jumlah Kunjungan Neonatal Pertama (KN1)' as kegiatan, IFNULL((SELECT COUNT(pemeriksaan_neonatus.KD_PASIEN) AS TOTAL
			FROM pemeriksaan_neonatus WHERE KUNJUNGAN_KE = 'KN1' AND KD_PUSKESMAS='$pid' AND (TANGGAL_KUNJUNGAN BETWEEN '$from' AND '$to')), IFNULL((SELECT SUM(r.JML_KJ_N_BR_0_7HARI_KN1)+SUM(r.JML_KJ_N_BR_0_7HARI_KN1_p) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0)) as Jumlah6, 1 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'C' as 'KELOMPOK', 'Program Kesehatan Anak' as Program, 'Jumlah Kunjungan Neonatal Lengkap (KN lengkap)' as kegiatan, IFNULL((SELECT COUNT(X.KD_PASIEN) AS TOTAL FROM (SELECT KD_PASIEN, KUNJUNGAN_KE, KD_PUSKESMAS, TANGGAL_KUNJUNGAN FROM pemeriksaan_neonatus WHERE KUNJUNGAN_KE='KN1' )X
			INNER JOIN (SELECT KD_PASIEN, KUNJUNGAN_KE, KD_PUSKESMAS, TANGGAL_KUNJUNGAN FROM pemeriksaan_neonatus WHERE KUNJUNGAN_KE='KN2' )Y
			INNER JOIN (SELECT KD_PASIEN, KUNJUNGAN_KE, KD_PUSKESMAS, TANGGAL_KUNJUNGAN FROM pemeriksaan_neonatus WHERE KUNJUNGAN_KE='KN3' )Z WHERE Z.KD_PASIEN=Y.KD_PASIEN AND Y.KD_PASIEN=X.KD_PASIEN 
			AND X.KD_PUSKESMAS='$pid' AND (X.TANGGAL_KUNJUNGAN BETWEEN '(DATE_SUB $from,INTERVAL 31 DAY)' AND '$to')),0) as Jumlah6, 2 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'C' as 'KELOMPOK', 'Program Kesehatan Anak' as Program, 'Jumlah neonatus dengan komplikasi yang ditangani (baru/ulang)' as kegiatan, IFNULL((SELECT SUM(r.NEONATUS_KOMPLIKASI_L)+SUM(r.NEONATUS_KOMPLIKASI_P) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 3 as iRow
			UNION ALL			
			select  'GKIA' as 'JUDUL',  'C' as 'KELOMPOK', 'Program Kesehatan Anak' as Program, 'Jumlah neonatus yang mendapat pelayanan skrining hipotiroid kongenital (SHK)' as kegiatan, IFNULL((SELECT SUM(r.NEONATUS_SHK_L)+SUM(r.NEONATUS_SHK_P) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 4 as iRow
			UNION ALL			
			select  'GKIA' as 'JUDUL',  'C' as 'KELOMPOK', 'Program Kesehatan Anak' as Program, 'Jumlah Balita yang telah mendapatkan pelayanan stimulasi deteksi dan intervensi dini tumbuh kembang (SDIDTK) sebanyak 2 kali tahun ini' as kegiatan, IFNULL((SELECT SUM(r.BALITA_SDIDTK_L)+SUM(r.BALITA_SDIDTK_P) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 5 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'C' as 'KELOMPOK', 'Program Kesehatan Anak' as Program, 'Jumlah anak prasekolah yang mendapatkan pelayanan SDIDTK sebanyak 2 kali tahun ini' as kegiatan, IFNULL((SELECT SUM(r.ANAK_PRA_SDIDTK_L)+SUM(r.ANAK_PRA_SDIDTK_P) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 6 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'C' as 'KELOMPOK', 'Program Kesehatan Anak' as Program, 'Jumlah remaja (10-19 tahun) yang mendapatkan konseling oleh tenaga kesehatan (baru/ulang pada kasus yang sama)' as kegiatan, IFNULL ((SELECT COUNT( X.KD_PELAYANAN ) AS JUMLAH FROM (SELECT V.KD_PELAYANAN,V.KD_PUSKESMAS, V.KD_PENYAKIT, V.TANGGAL, l.KD_PASIEN FROM pel_diagnosa V INNER JOIN pelayanan l WHERE l.KD_PELAYANAN = V.KD_PELAYANAN) X INNER JOIN pasien p
			WHERE p.KD_PASIEN=X.KD_PASIEN AND X.KD_PENYAKIT = 'Z70'AND (X.TANGGAL BETWEEN '$from' AND '$to')), IFNULL((SELECT SUM(r.REMAJA_KONSELING_L)+SUM(r.REMAJA_KONSELING_P) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0)) as Jumlah6, 7 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'C' as 'KELOMPOK', 'Program Kesehatan Anak' as Program, 'Jumlah kelompok remaja diluar sekolah (karang taruna, remaja mesjid, gereja, pura, wihara, dll) yang mendapatkan KIE kesehatan remaja' as kegiatan, IFNULL((SELECT SUM(r.REMAJA_KIE_L)+SUM(r.REMAJA_KIE_P) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 8 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'C' as 'KELOMPOK', 'Program Kesehatan Anak' as Program, 'Jumlah anak dan remaja (umur <20 tahun) dengan disabilitas yang ditangani (baru/ulang)' as kegiatan, IFNULL((SELECT SUM(r.REMAJA_DISABILITAS_L)+SUM(r.REMAJA_DISABILITAS_P) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 9 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'C' as 'KELOMPOK', 'Program Kesehatan Anak' as Program, 'Jumlah anak dan remaja (umur <20 tahun) korban kekerasan yang ditangani (pelayanan medis, visum, pelayanan konseling) (baru/ulang)' as kegiatan, IFNULL ((SELECT COUNT( X.KD_PELAYANAN ) AS JUMLAH FROM (SELECT V.KD_PELAYANAN,V.KD_PUSKESMAS, V.KD_PENYAKIT, V.TANGGAL, l.KD_PASIEN FROM pel_diagnosa V INNER JOIN pelayanan l WHERE l.KD_PELAYANAN = V.KD_PELAYANAN) X INNER JOIN pasien p
			WHERE p.KD_PASIEN=X.KD_PASIEN AND X.KD_PENYAKIT LIKE 'T74%' AND (X.TANGGAL BETWEEN '$from' AND '$to')), IFNULL((SELECT SUM(r.REMAJA_KORBAN_KEKERASAN_DITANGANI_L)+SUM(r.REMAJA_KORBAN_KEKERASAN_DITANGANI_P) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0)) as Jumlah6, 10 as iRow
			UNION ALL
			select  'GKIA' as 'JUDUL',  'C' as 'KELOMPOK', 'Program Kesehatan Anak' as Program, 'Jumlah anak korban kekerasan yang dirujuk (medis, psikososial, hukum)' as kegiatan, IFNULL((SELECT SUM(r.REMAJA_KORBAN_KEKERASAN_DIRUJUK_L)+SUM(r.REMAJA_KORBAN_KEKERASAN_DIRUJUK_P) AS jumlah FROM t_ds_kia r where r.KD_PUSKESMAS='$pid' AND r.BULAN=DATE_FORMAT('$from','%m') AND r.TAHUN=DATE_FORMAT('$from','%Y')),0) as Jumlah6, 11 as iRow) X");
			
			if($query[1]->num_rows>0){
				//$data2 = $query2->result(); //print_r($data);die;
				
				/*if(!$data)
					return false;
				*/
				// Starting the PHPExcel library
				$this->load->library('Excel');
				$this->excel->getActiveSheet()->setTitle('LB3');
				$this->excel->getProperties()->setTitle("export")->setDescription("none");
				
				$objReader = PHPExcel_IOFactory::createReader('Excel5');
				$objPHPExcel = $objReader->load("tmp/laporan_lb3a_kab.xls");
				$objPHPExcel->setActiveSheetIndex(0);
					
				//$no=1;
				$total=0;
				for($no=1;$no<4;$no++){
				$data = $query[$no]->result();
				$rw=array('',10,35,72);
				$rw2=array('',9,34,71);
				foreach($data as $value)
				{
					$styleArray = array(
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
							),
						),
					);
					$objPHPExcel->getActiveSheet()->getStyle('A'.($rw[$no]-1).':E'.$rw[$no])->applyFromArray($styleArray);

					$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw[$no].':D'.$rw[$no]);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$rw[$no])->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setWrapText(true);
					//$objPHPExcel->getActiveSheet()->getStyle('C'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->setTitle('Data')
						->setCellValue('A'.$rw[$no], '   '.$value->kegiatan)
						->setCellValue('E'.$rw[$no], $value->Jumlah6);
					//$rw++;
					$rw[$no]++;
				}
				$objPHPExcel->getActiveSheet()->getStyle('A'.($rw2[$no]).':E'.($rw2[$no]))->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->mergeCells('A'.($rw2[$no]).':D'.($rw2[$no]));
				$objPHPExcel->getActiveSheet()->getStyle('E'.($rw2[$no]))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()
					->setCellValue('A'.($rw2[$no]), $value->JUDUL.' :   '.$value->Program)
					->setCellValue('E'.($rw2[$no]), 'JUMLAH')
					;
					
				}
				$data1 = $query[1]->result();
				foreach($data1 as $value1){
					$objPHPExcel->getActiveSheet()->getStyle('E234:E237')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$objPHPExcel->getActiveSheet()
						//->setCellValue('E234', 'KEPALA PUSKESMAS')
						//->setCellValue('E237', $value1->KEPALA_PUSKESMAS)
						//->setCellValue('C5', $pid)
						//->setCellValue('C6', $value1->NAMA_PUSKESMAS)
						->setCellValue('C5', $value1->KABKOTA)
						->setCellValue('E6', $value1->dt1.' / '.$value1->dt2);
				}
				$filename='laporan_lb3_kab_'.date('dmY_his_').'.xls'; //save our workbook as this file name
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
	
	public function lb3c_excel_update(){
	//print_r($_POST);die;
	
		
		$from = $this->input->get('from');	//print_r($from);die;
		$to = $this->input->get('to'); //print_r($to);die;
		$pid = $this->input->get('pid');
		$jenis = $this->input->get('jenis');
		$db = $this->load->database('sikda', TRUE);
		if($jenis=='rpt_lb3'){
			$query = array();
			//$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_uks a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'")->row();//print_r($data);die;
			$query[1] = $db->query("SELECT DATE_FORMAT('$from','%d-%m-%Y') as dt1, DATE_FORMAT('$to','%d-%m-%Y') as dt2, '$pid' AS KD_PUSKESMAS, (SELECT S.KEY_VALUE FROM sys_setting AS S WHERE S.KEY_DATA = 'NAMA_PUSKESMAS' AND PUSKESMAS='$pid' LIMIT 1) AS NAMA_PUSKESMAS, (SELECT S.KEY_VALUE FROM sys_setting AS S WHERE S.KEY_DATA = 'NAMA_PIMPINAN' AND PUSKESMAS='$pid' LIMIT 1) AS KEPALA_PUSKESMAS, (SELECT P.PROVINSI FROM sys_setting S INNER JOIN mst_provinsi P ON S.KEY_VALUE=P.KD_PROVINSI WHERE S.KEY_DATA = 'KD_PROV' AND S.PUSKESMAS='$pid' LIMIT 1) AS PROVINSI, (SELECT P.KABUPATEN FROM sys_setting S INNER JOIN mst_kabupaten P ON S.KEY_VALUE=P.KD_KABUPATEN WHERE S.KEY_DATA = 'KD_KABKOTA' AND S.PUSKESMAS='$pid' LIMIT 1) AS KABKOTA, (SELECT P.KECAMATAN FROM sys_setting S INNER JOIN mst_kecamatan P ON S.KEY_VALUE=P.KD_KECAMATAN WHERE S.KEY_DATA = 'KD_KEC' AND S.PUSKESMAS='$pid' LIMIT 1) AS KECAMATAN, '' AS 'PUSTU_YG_ADA', '' AS 'YANG_LAPOR', 'DARI PARAMETER PHP' AS 'TAHUN', '' AS 'NAMA_MENGETAHUI', '' AS 'NIP_MENGETAHUI', '' AS 'LOKASI', 'TANGGAL HARI INI' AS 'TANGGAL', '' AS 'NAMA_PELAPOR', '' AS 'NIP_PELAPOR', X.* FROM 
			( select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK', 'JENIS IMUNISASI' as Program, 'Jumlah bayi usia usia 0 - 11 bulan yang mendapatkan imunisasi Hepatitis B<7 hr (HB0)' as kegiatan, 
			IFNULL((SELECT COUNT(trans_imunisasi.KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI JOIN pasien ON pasien.KD_PASIEN=trans_imunisasi.KD_PASIEN WHERE pel_imunisasi.KD_JENIS_IMUNISASI='1' AND trans_imunisasi.KD_JENIS_PASIEN='3' AND Get_AgeInDays(trans_imunisasi.TANGGAL, pasien.TGL_LAHIR) <8 AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),IFNULL((SELECT SUM(d.JML_IMUN_HBU_M7_L+d.JML_IMUN_HBU_M7_P) AS jumlah FROM t_ds_imunisasi d WHERE d.BULAN=DATE_FORMAT('$to','%m') AND d.TAHUN=DATE_FORMAT('$to','%Y') AND d.KD_PUSKESMAS='$pid'),0)) as Jumlah6, 1 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah bayi usia 0 - 11 bulan yang diimunisasi BCG' as kegiatan, 
			IFNULL((SELECT COUNT(trans_imunisasi.KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='2' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='3' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),
			IFNULL((SELECT SUM(d.JML_IMUN_BCG_L+d.JML_IMUN_BCG_P) AS jumlah FROM t_ds_imunisasi d WHERE d.BULAN=DATE_FORMAT('$to','%m') AND d.TAHUN=DATE_FORMAT('$to','%Y') AND d.KD_PUSKESMAS='$pid'),0)) as Jumlah6, 2 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah bayi usia 0 - 11 bulan yang diimunisasi DPT-HB-Hib (1)' as kegiatan, IFNULL((SELECT COUNT(trans_imunisasi.KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='3' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='3' AND trans_imunisasi.IMUNISASI_LUAR_GEDUNG='0' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 3 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah bayi usia 0 - 11 bulan yang diimunisasi DPT-HB-Hib (2)' as kegiatan, IFNULL((SELECT COUNT(trans_imunisasi.KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='4' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='3' AND trans_imunisasi.IMUNISASI_LUAR_GEDUNG='0' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 4 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah bayi usia 0 - 11 bulan yang diimunisasi DPT-HB-Hib (3)' as kegiatan, IFNULL((SELECT COUNT(trans_imunisasi.KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='5' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='3' AND trans_imunisasi.IMUNISASI_LUAR_GEDUNG='0' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 5 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah bayi usia 0 - 11 bulan yang diimunisasi Polio1' as kegiatan, IFNULL((SELECT COUNT(trans_imunisasi.KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='6' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='3' AND trans_imunisasi.IMUNISASI_LUAR_GEDUNG='0' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 6 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah bayi usia 0 - 11 bulan yang diimunisasi Polio2' as kegiatan, IFNULL((SELECT COUNT(trans_imunisasi.KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='7' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='3' AND trans_imunisasi.IMUNISASI_LUAR_GEDUNG='0' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 7 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah bayi usia 0 - 11 bulan yang diimunisasi Polio3' as kegiatan, IFNULL((SELECT COUNT(trans_imunisasi.KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='8' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='3' AND trans_imunisasi.IMUNISASI_LUAR_GEDUNG='0' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 8 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah bayi usia 0 - 11 bulan yang diimunisasi Polio4' as kegiatan, IFNULL((SELECT COUNT(trans_imunisasi.KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='9' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='3' AND trans_imunisasi.IMUNISASI_LUAR_GEDUNG='0' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 9 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah bayi usia 0 - 11 bulan yang diimunisasi IPV 1 dosis' as kegiatan, IFNULL((SELECT COUNT(trans_imunisasi.KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='11' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='3' AND trans_imunisasi.IMUNISASI_LUAR_GEDUNG='0' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 10 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah bayi usia 0 - 11 bulan yang diimunisasi campak' as kegiatan, IFNULL((SELECT COUNT(trans_imunisasi.KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='10' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='3' AND trans_imunisasi.IMUNISASI_LUAR_GEDUNG='0' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),
			IFNULL((SELECT SUM(d.JML_IMUN_CAMPAK_L+d.JML_IMUN_CAMPAK_P) AS jumlah FROM t_ds_imunisasi d WHERE d.BULAN=DATE_FORMAT('$to','%m') AND d.TAHUN=DATE_FORMAT('$to','%Y') AND d.KD_PUSKESMAS='$pid'),0)) as Jumlah6, 11 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah bayi 0 -11 bulan yang mendapat imunisasi dasar lengkap (IDL)' as kegiatan, '0' as Jumlah6, 12 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah anak usia 12-36 bulan yang mendapatkan imunisasi lanjutan DPT-HB-Hib' as kegiatan, '0' as Jumlah6, 13 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah anak usia 12-36 bulan yang mendapatkan imunisasi lanjutan Campak' as kegiatan, '0' as Jumlah6, 14 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah WUS (wanita usia subur) usia 15 - 39 tahun yang diimunisasi TT1' as kegiatan, '0' as Jumlah6, 15 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah WUS (wanita usia subur) usia 15 - 39 tahun yang diimunisasi TT2' as kegiatan, '0' as Jumlah6, 16 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah WUS (wanita usia subur) usia 15 - 39 tahun yang diimunisasi TT3' as kegiatan, '0' as Jumlah6, 17 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah WUS (wanita usia subur) usia 15 - 39 tahun yang diimunisasi TT4' as kegiatan, '0' as Jumlah6, 18 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah WUS (wanita usia subur) usia 15 - 39 tahun yang diimunisasi TT5' as kegiatan, '0' as Jumlah6, 19 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah desa yang ada laporannya/jumlah desa terdata' as kegiatan, '0' as Jumlah6, 20 as iRow  ) X ");//print_r($query);die;
			
			if($query[1]->num_rows>0){
				//$data2 = $query2->result(); //print_r($data);die;
				
				/*if(!$data)
					return false;
				*/
				// Starting the PHPExcel library
				$this->load->library('Excel');
				$this->excel->getActiveSheet()->setTitle('LB3');
				$this->excel->getProperties()->setTitle("export")->setDescription("none");
				
				$objReader = PHPExcel_IOFactory::createReader('Excel5');
				$objPHPExcel = $objReader->load("tmp/laporan_lb3c.xls");
				$objPHPExcel->setActiveSheetIndex(0);
					
				//$no=1;
				$total=0;
				for($no=1;$no<2;$no++){
				$data = $query[$no]->result();
				$rw=array('',10);
				$rw2=array('',9);
				foreach($data as $value)
				{
					$styleArray = array(
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
							),
						),
					);
					$objPHPExcel->getActiveSheet()->getStyle('A'.($rw[$no]-1).':E'.$rw[$no])->applyFromArray($styleArray);

					$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw[$no].':D'.$rw[$no]);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$rw[$no])->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setWrapText(true);
					//$objPHPExcel->getActiveSheet()->getStyle('C'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->setTitle('Data')
						->setCellValue('A'.$rw[$no], '   '.$value->kegiatan)
						->setCellValue('E'.$rw[$no], $value->Jumlah6);
					//$rw++;
					$rw[$no]++;
				}
				$objPHPExcel->getActiveSheet()->getStyle('A'.($rw2[$no]).':E'.($rw2[$no]))->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->mergeCells('A'.($rw2[$no]).':D'.($rw2[$no]));
				$objPHPExcel->getActiveSheet()->getStyle('E'.($rw2[$no]))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()
					->setCellValue('A'.($rw2[$no]), $value->JUDUL.' :   '.$value->Program)
					->setCellValue('E'.($rw2[$no]), 'JUMLAH')
					;
					
				}
				$data1 = $query[1]->result();
				foreach($data1 as $value1){
					$objPHPExcel->getActiveSheet()->getStyle('E234:E237')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$objPHPExcel->getActiveSheet()
						->setCellValue('E34', 'KEPALA PUSKESMAS')
						->setCellValue('E38', $value1->KEPALA_PUSKESMAS)
						->setCellValue('C5', $pid)
						->setCellValue('C6', $value1->NAMA_PUSKESMAS)
						->setCellValue('C7', $value1->KABKOTA)
						->setCellValue('E6', $value1->dt1.' / '.$value1->dt2);
				}
				$filename='laporan_lb3_'.date('dmY_his_').'.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
				
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				$objWriter->save('php://output');
			}else{
				die('Tidak Ada Dalam Database');
			}
		}else{	
			$query = array();
			//$data['waktu'] = $db->query("select a.*, MONTHNAME(STR_TO_DATE(a.BULAN,'%m')) as bulan, b.KABUPATEN, c.PUSKESMAS  from t_ds_uks a left join mst_kabupaten b on b.KD_KABUPATEN=a.KD_KABUPATEN left join mst_puskesmas c on c.KD_PUSKESMAS=a.KD_PUSKESMAS where a.BULAN = '$from' and a.TAHUN = '$to'")->row();//print_r($data);die;
			$query[1] = $db->query("SELECT DATE_FORMAT('$from','%d-%m-%Y') as dt1, DATE_FORMAT('$to','%d-%m-%Y') as dt2, '$pid' AS KD_PUSKESMAS, (SELECT S.KEY_VALUE FROM sys_setting AS S WHERE S.KEY_DATA = 'NAMA_PUSKESMAS' AND PUSKESMAS='$pid' LIMIT 1) AS NAMA_PUSKESMAS, (SELECT S.KEY_VALUE FROM sys_setting AS S WHERE S.KEY_DATA = 'NAMA_PIMPINAN' AND PUSKESMAS='$pid' LIMIT 1) AS KEPALA_PUSKESMAS, (SELECT P.PROVINSI FROM sys_setting S INNER JOIN mst_provinsi P ON S.KEY_VALUE=P.KD_PROVINSI WHERE S.KEY_DATA = 'KD_PROV' AND S.PUSKESMAS='$pid' LIMIT 1) AS PROVINSI, (SELECT P.KABUPATEN FROM sys_setting S INNER JOIN mst_kabupaten P ON S.KEY_VALUE=P.KD_KABUPATEN WHERE S.KEY_DATA = 'KD_KABKOTA' AND S.PUSKESMAS='$pid' LIMIT 1) AS KABKOTA, (SELECT P.KECAMATAN FROM sys_setting S INNER JOIN mst_kecamatan P ON S.KEY_VALUE=P.KD_KECAMATAN WHERE S.KEY_DATA = 'KD_KEC' AND S.PUSKESMAS='$pid' LIMIT 1) AS KECAMATAN, '' AS 'PUSTU_YG_ADA', '' AS 'YANG_LAPOR', 'DARI PARAMETER PHP' AS 'TAHUN', '' AS 'NAMA_MENGETAHUI', '' AS 'NIP_MENGETAHUI', '' AS 'LOKASI', 'TANGGAL HARI INI' AS 'TANGGAL', '' AS 'NAMA_PELAPOR', '' AS 'NIP_PELAPOR', X.* FROM 
			( select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK', 'JENIS IMUNISASI' as Program, 'Jumlah bayi usia usia 0 - 11 bulan yang mendapatkan imunisasi Hepatitis B<7 hr (HB0)' as kegiatan, 
			IFNULL((SELECT COUNT(trans_imunisasi.KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI JOIN pasien ON pasien.KD_PASIEN=trans_imunisasi.KD_PASIEN WHERE pel_imunisasi.KD_JENIS_IMUNISASI='1' AND trans_imunisasi.KD_JENIS_PASIEN='3' AND Get_AgeInDays(trans_imunisasi.TANGGAL, pasien.TGL_LAHIR) <8 AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),IFNULL((SELECT SUM(d.JML_IMUN_HBU_M7_L+d.JML_IMUN_HBU_M7_P) AS jumlah FROM t_ds_imunisasi d WHERE d.BULAN=DATE_FORMAT('$to','%m') AND d.TAHUN=DATE_FORMAT('$to','%Y') AND d.KD_PUSKESMAS='$pid'),0)) as Jumlah6, 1 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah bayi usia 0 - 11 bulan yang diimunisasi BCG' as kegiatan, 
			IFNULL((SELECT COUNT(KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='2' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='3' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),
			IFNULL((SELECT SUM(d.JML_IMUN_BCG_L+d.JML_IMUN_BCG_P) AS jumlah FROM t_ds_imunisasi d WHERE d.BULAN=DATE_FORMAT('$to','%m') AND d.TAHUN=DATE_FORMAT('$to','%Y') AND d.KD_PUSKESMAS='$pid'),0)) as Jumlah6, 2 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah bayi usia 0 - 11 bulan yang diimunisasi DPT-HB-Hib (1)' as kegiatan, IFNULL((SELECT COUNT(KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='3' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='3' AND trans_imunisasi.IMUNISASI_LUAR_GEDUNG='0' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 3 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah bayi usia 0 - 11 bulan yang diimunisasi DPT-HB-Hib (2)' as kegiatan, IFNULL((SELECT COUNT(KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='4' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='3' AND trans_imunisasi.IMUNISASI_LUAR_GEDUNG='0' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 4 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah bayi usia 0 - 11 bulan yang diimunisasi DPT-HB-Hib (3)' as kegiatan, IFNULL((SELECT COUNT(KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='5' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='3' AND trans_imunisasi.IMUNISASI_LUAR_GEDUNG='0' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 5 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah bayi usia 0 - 11 bulan yang diimunisasi Polio1' as kegiatan, IFNULL((SELECT COUNT(KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='6' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='3' AND trans_imunisasi.IMUNISASI_LUAR_GEDUNG='0' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 6 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah bayi usia 0 - 11 bulan yang diimunisasi Polio2' as kegiatan, IFNULL((SELECT COUNT(KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='7' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='3' AND trans_imunisasi.IMUNISASI_LUAR_GEDUNG='0' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 7 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah bayi usia 0 - 11 bulan yang diimunisasi Polio3' as kegiatan, IFNULL((SELECT COUNT(KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='8' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='3' AND trans_imunisasi.IMUNISASI_LUAR_GEDUNG='0' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 8 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah bayi usia 0 - 11 bulan yang diimunisasi Polio4' as kegiatan, IFNULL((SELECT COUNT(KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='9' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='3' AND trans_imunisasi.IMUNISASI_LUAR_GEDUNG='0' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 9 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah bayi usia 0 - 11 bulan yang diimunisasi IPV 1 dosis' as kegiatan, IFNULL((SELECT COUNT(KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='11' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='3' AND trans_imunisasi.IMUNISASI_LUAR_GEDUNG='0' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),0) as Jumlah6, 10 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah bayi usia 0 - 11 bulan yang diimunisasi campak' as kegiatan, IFNULL((SELECT COUNT(KD_PASIEN) AS jumlah FROM trans_imunisasi JOIN pel_imunisasi ON pel_imunisasi.KD_TRANS_IMUNISASI=trans_imunisasi.KD_TRANS_IMUNISASI WHERE pel_imunisasi.KD_JENIS_IMUNISASI='10' AND SUBSTR(trans_imunisasi.KD_PASIEN,1,11)='$pid' AND trans_imunisasi.KD_JENIS_PASIEN='3' AND trans_imunisasi.IMUNISASI_LUAR_GEDUNG='0' AND (trans_imunisasi.TANGGAL BETWEEN '$from' AND '$to')),
			IFNULL((SELECT SUM(d.JML_IMUN_CAMPAK_L+d.JML_IMUN_CAMPAK_P) AS jumlah FROM t_ds_imunisasi d WHERE d.BULAN=DATE_FORMAT('$to','%m') AND d.TAHUN=DATE_FORMAT('$to','%Y') AND d.KD_PUSKESMAS='$pid'),0)) as Jumlah6, 11 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah bayi 0 -11 bulan yang mendapat imunisasi dasar lengkap (IDL)' as kegiatan, '0' as Jumlah6, 12 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah anak usia 12-36 bulan yang mendapatkan imunisasi lanjutan DPT-HB-Hib' as kegiatan, '0' as Jumlah6, 13 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah anak usia 12-36 bulan yang mendapatkan imunisasi lanjutan Campak' as kegiatan, '0' as Jumlah6, 14 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah WUS (wanita usia subur) usia 15 - 39 tahun yang diimunisasi TT1' as kegiatan, '0' as Jumlah6, 15 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah WUS (wanita usia subur) usia 15 - 39 tahun yang diimunisasi TT2' as kegiatan, '0' as Jumlah6, 16 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah WUS (wanita usia subur) usia 15 - 39 tahun yang diimunisasi TT3' as kegiatan, '0' as Jumlah6, 17 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah WUS (wanita usia subur) usia 15 - 39 tahun yang diimunisasi TT4' as kegiatan, '0' as Jumlah6, 18 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah WUS (wanita usia subur) usia 15 - 39 tahun yang diimunisasi TT5' as kegiatan, '0' as Jumlah6, 19 as iRow
			UNION ALL
			select  'IMUNISASI' as 'JUDUL',  'A' as 'KELOMPOK','JENIS IMUNISASI' as Program, 'Jumlah desa yang ada laporannya/jumlah desa terdata' as kegiatan, '0' as Jumlah6, 20 as iRow  ) X ");//print_r($query);die;
			
			if($query[1]->num_rows>0){
				//$data2 = $query2->result(); //print_r($data);die;
				
				/*if(!$data)
					return false;
				*/
				// Starting the PHPExcel library
				$this->load->library('Excel');
				$this->excel->getActiveSheet()->setTitle('LB3');
				$this->excel->getProperties()->setTitle("export")->setDescription("none");
				
				$objReader = PHPExcel_IOFactory::createReader('Excel5');
				$objPHPExcel = $objReader->load("tmp/laporan_lb3c.xls");
				$objPHPExcel->setActiveSheetIndex(0);
					
				//$no=1;
				$total=0;
				for($no=1;$no<2;$no++){
				$data = $query[$no]->result();
				$rw=array('',10);
				$rw2=array('',9);
				foreach($data as $value)
				{
					$styleArray = array(
						'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
							),
						),
					);
					$objPHPExcel->getActiveSheet()->getStyle('A'.($rw[$no]-1).':E'.$rw[$no])->applyFromArray($styleArray);

					$objPHPExcel->getActiveSheet()->mergeCells('A'.$rw[$no].':D'.$rw[$no]);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$rw[$no])->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					//$objPHPExcel->getActiveSheet()->getStyle('C'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->setTitle('Data')
						->setCellValue('A'.$rw[$no], '   '.$value->kegiatan)
						->setCellValue('E'.$rw[$no], $value->Jumlah6);
					//$rw++;
					$rw[$no]++;
				}
				$objPHPExcel->getActiveSheet()->getStyle('A'.($rw2[$no]).':E'.($rw2[$no]))->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->mergeCells('A'.($rw2[$no]).':D'.($rw2[$no]));
				$objPHPExcel->getActiveSheet()->getStyle('E'.($rw2[$no]))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()
					->setCellValue('A'.($rw2[$no]), $value->JUDUL.' :   '.$value->Program)
					->setCellValue('E'.($rw2[$no]), 'JUMLAH')
					;
					
				}
				$data1 = $query[1]->result();
				foreach($data1 as $value1){
					$objPHPExcel->getActiveSheet()->getStyle('E234:E237')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$objPHPExcel->getActiveSheet()
						//->setCellValue('E34', 'KEPALA PUSKESMAS')
						//->setCellValue('E37', $value1->KEPALA_PUSKESMAS)
						//->setCellValue('C5', $pid)
						//->setCellValue('C6', $value1->NAMA_PUSKESMAS)
						->setCellValue('C5', $value1->KABKOTA)
						->setCellValue('E6', $value1->dt1.' / '.$value1->dt2);
				}
				$filename='laporan_lb3_kab_'.date('dmY_his_').'.xls'; //save our workbook as this file name
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
	
}

/* End of file dashboard.php */
/* Location: ./sikdaapplication/controllers/login.php */
