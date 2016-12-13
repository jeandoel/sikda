<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Report_ppjk extends CI_Controller {

	public function upload_data(){
		$this->load->helper('beries_helper');
		
		if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['name'] != ""){
			
			//input rekap kunjungan
			$data = $this->readExcelKunjungan($_FILES['fileToUpload']['tmp_name']);	
			$this->load->view('agregat/rpt_lapjknpus_temp', $data);
			
			//input diagnosa rawat jalan dan rawat inap
			$data = $this->readExcel10BesarICD($_FILES['fileToUpload']['tmp_name']);			
			$this->load->view('agregat/rpt_lap10besarICD_temp', $data);
			
			//input diagnosa rujukan
			$data = $this->readExcel10BesarICDRujukan($_FILES['fileToUpload']['tmp_name']);			
			$this->load->view('agregat/rpt_lap10besarICDRujukan_temp', $data);
			
		}else{
			$this->load->view('agregat/data_agregat');
		}
	}
	
	function readExcelRekapJenisPasien($file){
		$this->load->library('PHPExcel/Classes/PHPExcel');
		$db = $this->load->database('sikda', TRUE);
		
		$objReader = new PHPExcel_Reader_Excel2007();
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file);

		$data =  array();
		
		$sheet = 'KUNJUNGAN JENIS PESERTA';
		$worksheet = $objPHPExcel->setActiveSheetIndexByName($sheet);
		foreach ($worksheet->getRowIterator() as $row) {
		  $cellIterator = $row->getCellIterator();
		  $cellIterator->setIterateOnlyExistingCells(false);
		  foreach ($cellIterator as $cell) {
			$data[$sheet][$cell->getRow()][$cell->getColumn()] = $cell->getValue();
		  }
		}
		
		$montharray = bulan();
		
		$rekap = $data['KUNJUNGAN JENIS PESERTA'];
		
					
		$nama_puskesmas = $rekap['6']['C'];
		$kode_puskesmas = $rekap['7']['C'];
		$data_bulan		= $rekap['7']['F'];
		$data_bulan 	= explode(' ',$data_bulan);
		
		$bulan = array();
		$bulan['NAMA_PUSKESMAS'] 	= $nama_puskesmas;
		$bulan['KODE_PUSKESMAS'] 	= $kode_puskesmas;
		$bulan['BULAN'] 			= date('Y-m-01', strtotime($data_bulan[0]."-".$montharray[$data_bulan[1]]));
		
		
		$rank = 1;
		for($i=14; $i<=23; $i++){ 			//array bulan
			$rekap_row = $rekap[$i];			
			
			$array = array();
			$array['ID'] 			= $bulan['BULAN'].$kode_puskesmas."RJ".$rank;
			$array['MONTH'] 		= $bulan['BULAN'];
			$array['KD_PUSKESMAS'] 	= $kode_puskesmas;
			$array['PUSKESMAS'] 	= $nama_puskesmas;
			//$array['TYPE'] 			= 'RJ';
			$array['NM_ICD'] 		= $rekap_row['B'];
			$array['KD_ICD'] 		= $rekap_row['E'];
			$array['L'] 			= $rekap_row['F'];
			$array['P'] 			= $rekap_row['G'];
			
			
			$query = $db->get_where('laporan_agregat_diagnosa_rujukan', array('ID'=>$array['ID']));
			if ($query->num_rows() > 0){
				$db->where('ID', $array['ID']);
				$db->update('laporan_agregat_diagnosa_rujukan', $array); 				
				$array['ACTION'] = 'Update';
			}else{
				$db->insert('laporan_agregat_diagnosa_rujukan', $array); 				
				$array['ACTION'] = 'Insert';
			}
			
			$bulan['ROWS'][] = $array;
			
			$rank++;
		}		
		/* echo "<pre>";
		print_r($rekap);
		echo "</pre>"; */
		
		return $bulan;
	}
	
	function readExcel10BesarICDRujukan($file){
		$this->load->library('PHPExcel/Classes/PHPExcel');
		$db = $this->load->database('sikda', TRUE);
		
		$objReader = new PHPExcel_Reader_Excel2007();
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file);

		$data =  array();
		
		$sheet = '10 PENYAKIT TERBANYAK (RUJUK)';
		$worksheet = $objPHPExcel->setActiveSheetIndexByName($sheet);
		foreach ($worksheet->getRowIterator() as $row) {
		  $cellIterator = $row->getCellIterator();
		  $cellIterator->setIterateOnlyExistingCells(false);
		  foreach ($cellIterator as $cell) {
			$data[$sheet][$cell->getRow()][$cell->getColumn()] = $cell->getValue();
		  }
		}
		
		$montharray = bulan();
		
		$rekap = $data['10 PENYAKIT TERBANYAK (RUJUK)'];
		
					
		$nama_puskesmas = $rekap['6']['C'];
		$kode_puskesmas = $rekap['7']['C'];
		$data_bulan		= $rekap['7']['F'];
		$data_bulan 	= explode(' ',$data_bulan);
		
		$bulan = array();
		$bulan['NAMA_PUSKESMAS'] 	= $nama_puskesmas;
		$bulan['KODE_PUSKESMAS'] 	= $kode_puskesmas;
		$bulan['BULAN'] 			= date('Y-m-01', strtotime($data_bulan[0]."-".$montharray[$data_bulan[1]]));
		
		
		$rank = 1;
		for($i=14; $i<=23; $i++){ 			//array bulan
			$rekap_row = $rekap[$i];			
			
			$array = array();
			$array['ID'] 			= $bulan['BULAN'].$kode_puskesmas."RJ".$rank;
			$array['MONTH'] 		= $bulan['BULAN'];
			$array['KD_PUSKESMAS'] 	= $kode_puskesmas;
			$array['PUSKESMAS'] 	= $nama_puskesmas;
			//$array['TYPE'] 			= 'RJ';
			$array['NM_ICD'] 		= $rekap_row['B'];
			$array['KD_ICD'] 		= $rekap_row['E'];
			$array['L'] 			= $rekap_row['F'];
			$array['P'] 			= $rekap_row['G'];
			
			
			$query = $db->get_where('laporan_agregat_diagnosa_rujukan', array('ID'=>$array['ID']));
			if ($query->num_rows() > 0){
				$db->where('ID', $array['ID']);
				$db->update('laporan_agregat_diagnosa_rujukan', $array); 				
				$array['ACTION'] = 'Update';
			}else{
				$db->insert('laporan_agregat_diagnosa_rujukan', $array); 				
				$array['ACTION'] = 'Insert';
			}
			
			$bulan['ROWS'][] = $array;
			
			$rank++;
		}		
		/* echo "<pre>";
		print_r($rekap);
		echo "</pre>"; */
		
		return $bulan;
	}
	
	function readExcel10BesarICD($file){
		$this->load->library('PHPExcel/Classes/PHPExcel');
		$db = $this->load->database('sikda', TRUE);
		
		$objReader = new PHPExcel_Reader_Excel2007();
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file);

		$data =  array();
		
		$sheet = '10 PENYAKIT TERBANYAK';
		$worksheet = $objPHPExcel->setActiveSheetIndexByName($sheet);
		foreach ($worksheet->getRowIterator() as $row) {
		  $cellIterator = $row->getCellIterator();
		  $cellIterator->setIterateOnlyExistingCells(false);
		  foreach ($cellIterator as $cell) {
			$data[$sheet][$cell->getRow()][$cell->getColumn()] = $cell->getValue();
		  }
		}
		
		$montharray = bulan();
		
		$rekap = $data['10 PENYAKIT TERBANYAK'];
		
					
		$nama_puskesmas = $rekap['6']['C'];
		$kode_puskesmas = $rekap['7']['C'];
		$data_bulan		= $rekap['7']['F'];
		$data_bulan 	= explode(' ',$data_bulan);
		
		$bulan = array();
		$bulan['NAMA_PUSKESMAS'] 	= $nama_puskesmas;
		$bulan['KODE_PUSKESMAS'] 	= $kode_puskesmas;
		$bulan['BULAN'] 			= date('Y-m-01', strtotime($data_bulan[0]."-".$montharray[$data_bulan[1]]));
		
		//-------------start rawat jalan--------------------//
		$rank = 1;
		for($i=16; $i<=25; $i++){ 			//array bulan
			$rekap_row = $rekap[$i];			
			
			$array = array();
			$array['ID'] 			= $bulan['BULAN'].$kode_puskesmas."RJ".$rank;
			$array['MONTH'] 		= $bulan['BULAN'];
			$array['KD_PUSKESMAS'] 	= $kode_puskesmas;
			$array['PUSKESMAS'] 	= $nama_puskesmas;
			$array['TYPE'] 			= 'RJ';
			$array['NM_ICD'] 		= $rekap_row['B'];
			$array['KD_ICD'] 		= $rekap_row['E'];
			$array['L'] 			= $rekap_row['F'];
			$array['P'] 			= $rekap_row['G'];
						
			$query = $db->get_where('laporan_agregat_diagnosa', array('ID'=>$array['ID']));
			if ($query->num_rows() > 0){
				$db->where('ID', $array['ID']);
				$db->update('laporan_agregat_diagnosa', $array); 
				$array['ACTION'] = 'Update';
			}else{
				$db->insert('laporan_agregat_diagnosa', $array); 
				$array['ACTION'] = 'Insert';
			}
			$bulan['ROWS']['RJ'][] = $array;
			
			$rank++;
		}		
		//-------------end   rawat jalan--------------------//
		
		//-------------start rawat inap--------------------//
		$rank = 1;
		for($i=37; $i<=46; $i++){ 			//array bulan
			$rekap_row = $rekap[$i];			
			
			$array = array();
			$array['ID'] 			= $bulan['BULAN'].$kode_puskesmas."RI".$rank;
			$array['MONTH'] 		= $bulan['BULAN'];
			$array['KD_PUSKESMAS'] 	= $kode_puskesmas;
			$array['PUSKESMAS'] 	= $nama_puskesmas;
			$array['TYPE'] 			= 'RI';
			$array['NM_ICD'] 		= $rekap_row['B'];
			$array['KD_ICD'] 		= $rekap_row['E'];
			$array['L'] 			= $rekap_row['F'];
			$array['P'] 			= $rekap_row['G'];
						
			$query = $db->get_where('laporan_agregat_diagnosa', array('ID'=>$array['ID']));
			if ($query->num_rows() > 0){
				$db->where('ID', $array['ID']);
				$db->update('laporan_agregat_diagnosa', $array); 
				$array['ACTION'] = 'Update';
			}else{
				$db->insert('laporan_agregat_diagnosa', $array); 
				$array['ACTION'] = 'Insert';
			}
			$bulan['ROWS']['RI'][] = $array;
			
			$rank++;
		}
		//-------------end   rawat inap--------------------//
		/* echo "<pre>";
		print_r($bulan);
		echo "</pre>"; */
		
		return $bulan;
	}
	
	function readExcelKunjungan($file){
		$this->load->library('PHPExcel/Classes/PHPExcel');
		$db = $this->load->database('sikda', TRUE);
		
		$objReader = new PHPExcel_Reader_Excel2007();
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file);

		$data =  array();
		
		$sheet = 'REKAP BULANAN KUNJ PRIMER';
		$worksheet = $objPHPExcel->setActiveSheetIndexByName($sheet);
		foreach ($worksheet->getRowIterator() as $row) {
		  $cellIterator = $row->getCellIterator();
		  $cellIterator->setIterateOnlyExistingCells(false);
		  foreach ($cellIterator as $cell) {
			$data[$sheet][$cell->getRow()][$cell->getColumn()] = $cell->getValue();
		  }
		}
		
		$montharray = bulan();
		
		$rekap = $data['REKAP BULANAN KUNJ PRIMER'];
					
		$nama_puskesmas = $rekap['4']['C'];
		$kode_puskesmas = $rekap['5']['C'];
		$tahun 			= $rekap['5']['I'];
				
		$bulan = array();
		$bulan['NAMA_PUSKESMAS'] 	= $nama_puskesmas;
		$bulan['KODE_PUSKESMAS'] 	= $kode_puskesmas;
		$bulan['TAHUN'] 			= $tahun;
		for($i=11; $i<=22; $i++){ 			//array bulan
			$rekap_row = $rekap[$i];	
			
			$array = array();
			$array['month'] 		= date('Y-m-01', strtotime($tahun."-".$montharray[$rekap_row['B']] ));
			$array['kode_puskesmas']= $kode_puskesmas;
			$array['puskesmas'] 	= $nama_puskesmas;
			$array['RawatJalanL'] 	= $rekap_row['C'];
			$array['RawatJalanP'] 	= $rekap_row['D'];
			$array['RawatInapL'] 	= $rekap_row['E'];
			$array['RawatInapP'] 	= $rekap_row['F'];
			$array['KIA_ANC'] 		= $rekap_row['G'];
			$array['KIA_PNC'] 		= $rekap_row['H'];
			$array['KIA_NORMAL'] 	= $rekap_row['I'];
			$array['KB'] 			= $rekap_row['J'];
			$array['DIRUJUK'] 		= $rekap_row['K'];
			$array['RUJUKBALIK'] 	= $rekap_row['L'];
			$array['id']			= $array['kode_puskesmas'].$array['month'];
						
			$query = $db->get_where('laporan_agregat', array('id'=>$array['id']));
			if ($query->num_rows() > 0){
				$db->where('id', $array['id']);
				$db->update('laporan_agregat', $array); 
				$array['ACTION'] = 'Update';
			}else{
				$db->insert('laporan_agregat', $array); 
				$array['ACTION'] = 'Insert';
			}
			$bulan['ROWS'][] = $array;
		}		
		return $bulan;
	}
	
	
	function download_template(){
		$this->load->view("template_upload_agregat_p2jk.xlsx"); // Read the file's contents
	}
	
	public function sepuluhbesarrjrw(){	
		$this->load->helper('beries_helper');
				
		if(isset($_GET['jenispt']) && ( ($_GET['jenispt'] == 'html') || ($_GET['jenispt'] == 'excel') )){
			$propinsi = $_GET['propinsi'];
			$kabupaten = $_GET['kabupaten'];
			$kecamatan = $_GET['kecamatan'];
			$puskesmas = $_GET['puskesmas'];
			//print_r($_GET);
			
			$_GET['from'] 	= date('Y-m-01', strtotime($_GET['from']));
			$_GET['to'] 	= date('Y-m-t', strtotime($_GET['to']));
			
			if($_GET['jenispt'] == 'excel'){
				$fileName = "Report_Sepuluh_Besar_Rujuk_".date('Ymd').".xls";
				header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
				header("Content-Disposition: attachment; filename=".$fileName);  //File name extension was wrong
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private",false);
			}
			
			if($puskesmas != '0'){
				$this->sepuluhbesarrjrwpus_html();
			}elseif($puskesmas == 0 && $kecamatan > 0){
				//echo "Pilih Puskesmas";				
			}elseif($puskesmas == 0 && $kecamatan == 0 && $kabupaten > 0){
				$this->sepuluhbesarrjrwkab_html();
			}elseif($puskesmas == 0 && $kecamatan == 0 && $kabupaten == 0 && $propinsi > 0){
				$this->sepuluhbesarrjrwprov_html();
			}else{
				$this->sepuluhbesarrjrwnas_html();
			}
			
		}else{
			$this->load->view('reports/rpt_sepuluhbesarrjrw');
		}
	}
	
	public function sepuluhbesarrjrwnas_html(){
		$from = $this->input->get('from')?date("Y-m-d", strtotime(str_replace('/', '-',$this->input->get('from')))):date('Y-m-d');;	//print_r($from);die;
		$to = $this->input->get('to')?date("Y-m-d", strtotime(str_replace('/', '-',$this->input->get('to')))):date('Y-m-d');; //print_r($to);die;
		
		$data['FROM'] = $from;
		$data['TO'] = $to;
		
		$propinsi = $this->input->get('propinsi'); //print_r($propinsi);die;
		$db = $this->load->database('sikda', TRUE);
		
		
		$sql = "
				SELECT a.PROVINSI, a.KD_KABUPATEN, a.KABUPATEN, a.KD_PUSKESMAS, a.PUSKESMAS, a.KD_PENYAKIT, a.TGL_PELAYANAN, a.UNIT_PELAYANAN, a.SEX, SUM(a.JMLPASIEN) AS JMLPASIEN
					FROM(
							SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN, p.KD_PUSKESMAS, p.PUSKESMAS				
							, CONCAT(c.PENYAKIT,' ',vw.KD_PENYAKIT) AS KD_PENYAKIT
							, vw.TGL_PELAYANAN, vw.UNIT_PELAYANAN, vw.SEX
							, COUNT( vw.KD_PENYAKIT ) AS JMLPASIEN
							FROM mst_provinsi v 
							LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI 
							LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN 
							LEFT JOIN vw_rpt_penyakitpasien_grp_old vw ON vw.KD_PUSKESMAS = p.KD_PUSKESMAS
							LEFT JOIN mst_icd c ON c.KD_PENYAKIT = vw.KD_PENYAKIT
							WHERE 1=1 
							AND (vw.TGL_PELAYANAN >= '$from' AND vw.TGL_PELAYANAN <= '$to')
							AND vw.SEX IS NOT NULL
							GROUP BY vw.KD_PENYAKIT, vw.SEX

							UNION

							SELECT 
								v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN
								, d.KD_PUSKESMAS, d.PUSKESMAS
								, CONCAT(d.NM_ICD,' ', d.KD_ICD) AS KD_PENYAKIT
								, d.MONTH AS TGL_PELAYANAN
								, d.TYPE AS UNIT_PELAYANAN, 'P' AS SEX
								, SUM(d.P) AS JMLPASIEN
							FROM laporan_agregat_diagnosa d
							LEFT JOIN mst_provinsi v ON v.KD_PROVINSI IS NOT NULL
							LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI 
							LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
							WHERE 1=1 
							AND p.KD_PUSKESMAS = d.KD_PUSKESMAS
							AND (d.MONTH >= '$from' AND d.MONTH <= '$to')
							GROUP BY d.KD_PUSKESMAS, d.TYPE, d.KD_ICD

							UNION

							SELECT 
								v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN
								, d.KD_PUSKESMAS, d.PUSKESMAS
								, CONCAT(d.NM_ICD,' ', d.KD_ICD) AS KD_PENYAKIT
								, d.MONTH AS TGL_PELAYANAN
								, d.TYPE AS UNIT_PELAYANAN, 'L' AS SEX
								, SUM(d.L) AS JMLPASIEN
							FROM laporan_agregat_diagnosa d
							LEFT JOIN mst_provinsi v ON v.KD_PROVINSI IS NOT NULL
							LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI 
							LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
							WHERE 1=1 
							AND p.KD_PUSKESMAS = d.KD_PUSKESMAS
							AND (d.MONTH >= '$from' AND d.MONTH <= '$to')
							GROUP BY d.KD_PUSKESMAS, d.TYPE, d.KD_ICD
					) a
					GROUP BY a.PROVINSI, a.KD_KABUPATEN, a.KABUPATEN, a.KD_PUSKESMAS, a.PUSKESMAS, a.KD_PENYAKIT, a.TGL_PELAYANAN, a.UNIT_PELAYANAN, a.SEX
					ORDER BY SUM(a.JMLPASIEN) DESC";
					/* echo "<pre>";
					echo $sql;
					echo "</pre>"; */
		$query = $db->query($sql);
		$result = $query->result_array();
		
		$newArray = array();
		$obat = array();
		
		foreach($result as $key=>$row){
			$newArray[$row['UNIT_PELAYANAN']]['OBAT'][$row['KD_PENYAKIT']] = $row['KD_PENYAKIT']; //[$row['KD_PENYAKIT']][$row['SEX']][] = $row;
			
			//total
			if(isset($newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']]))
				$newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']] = $newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']] + $row['JMLPASIEN'];
			else
				$newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']] = $row['JMLPASIEN'];
			
			
			//rowsdata
			if(isset($newArray[$row['UNIT_PELAYANAN']]['ROWS'][$row['PROVINSI']][$row['KD_PENYAKIT']][$row['SEX']]['TOTAL']))
				$newArray[$row['UNIT_PELAYANAN']]['ROWS'][$row['PROVINSI']][$row['KD_PENYAKIT']][$row['SEX']]['TOTAL'] = $newArray[$row['UNIT_PELAYANAN']]['ROWS'][$row['PROVINSI']][$row['KD_PENYAKIT']][$row['SEX']]['TOTAL'] + $row['JMLPASIEN'];			
			else
				$newArray[$row['UNIT_PELAYANAN']]['ROWS'][$row['PROVINSI']][$row['KD_PENYAKIT']][$row['SEX']]['TOTAL'] = $row['JMLPASIEN'];			
		}
		/* echo "<pre>";
		print_r($newArray);
		echo "</pre>"; */
	
		$sql = "SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN
				FROM mst_provinsi v
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
				GROUP BY k.KD_KABUPATEN
				ORDER BY k.KABUPATEN";
				
		$query = $db->query($sql);
		$result = $db->query($sql)->result_array(); //print_r($data);die;
		
		$data['PROPINSI'] = $result[0]['PROVINSI'];
		$newData = array();		
		foreach($result as $value){
			$newArray['RI']['ROWS'][$value['PROVINSI']] = isset($newArray['RI']['ROWS'][$value['PROVINSI']])?$newArray['RI']['ROWS'][$value['PROVINSI']]:array();
			$newArray['RJ']['ROWS'][$value['PROVINSI']] = isset($newArray['RJ']['ROWS'][$value['PROVINSI']])?$newArray['RJ']['ROWS'][$value['PROVINSI']]:array();	

			$rows = 10 - COUNT($newArray['RI']['ROWS'][$value['PROVINSI']]);
			for($i=0; $i<=$rows; $i++){
				$newArray['RI']['ROWS'][$value['PROVINSI']][] = array('L'=>array('TOTAL'=>0), 'P'=>array('TOTAL'=>0));
			}
			
			$rows = 10 - COUNT($newArray['RJ']['ROWS'][$value['PROVINSI']]);
			for($i=0; $i<=$rows; $i++){
				$newArray['RJ']['ROWS'][$value['PROVINSI']][] = array('L'=>array('TOTAL'=>0), 'P'=>array('TOTAL'=>0));
			}
		}
		
		$newArray['RJ']['OBAT'] = isset($newArray['RJ']['OBAT'])?$newArray['RJ']['OBAT']:array();
		$newArray['RJ']['TOTAL'] = isset($newArray['RJ']['TOTAL'])?$newArray['RJ']['TOTAL']:array();
		$newArray['RJ']['ROWS'] = isset($newArray['RJ']['ROWS'])?$newArray['RJ']['ROWS']:array();
		
		$newArray['RI']['OBAT'] = isset($newArray['RI']['OBAT'])?$newArray['RI']['OBAT']:array();
		$newArray['RI']['TOTAL'] = isset($newArray['RI']['TOTAL'])?$newArray['RI']['TOTAL']:array();
		$newArray['RI']['ROWS'] = isset($newArray['RI']['ROWS'])?$newArray['RI']['ROWS']:array();
		
		$data['result'] = $newArray;	
		
		$this->load->view('reports/rpt_sepuluhbesarrjrwnas_html',$data);
	}
	
	public function sepuluhbesarrjrwprov_html(){
		$from = $this->input->get('from')?date("Y-m-d", strtotime(str_replace('/', '-',$this->input->get('from')))):date('Y-m-d');;	//print_r($from);die;
		$to = $this->input->get('to')?date("Y-m-d", strtotime(str_replace('/', '-',$this->input->get('to')))):date('Y-m-d');; //print_r($to);die;
		
		$data['FROM'] = $from;
		$data['TO'] = $to;
		
		$propinsi = $this->input->get('propinsi'); //print_r($propinsi);die;
		$db = $this->load->database('sikda', TRUE);
		
		$sql = "SELECT v.PROVINSI
				FROM mst_provinsi v  
				WHERE 1=1 
				AND v.KD_PROVINSI = '".$propinsi."'";
		$query = $db->query($sql);
		$result = $query->result_array();
		$data['PROPINSI'] = $result[0]['PROVINSI'];
		
		$sql = "
				SELECT a.PROVINSI, a.KD_KABUPATEN, a.KABUPATEN, a.KD_PUSKESMAS, a.PUSKESMAS, a.KD_PENYAKIT, a.TGL_PELAYANAN, a.UNIT_PELAYANAN, a.SEX, SUM(a.JMLPASIEN) AS JMLPASIEN
					FROM(
							SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN, p.KD_PUSKESMAS, p.PUSKESMAS				
							, CONCAT(c.PENYAKIT,' ',vw.KD_PENYAKIT) AS KD_PENYAKIT
							, vw.TGL_PELAYANAN, vw.UNIT_PELAYANAN, vw.SEX
							, COUNT( vw.KD_PENYAKIT ) AS JMLPASIEN
							FROM mst_provinsi v 
							LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI 
							LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN 
							LEFT JOIN vw_rpt_penyakitpasien_grp_old vw ON vw.KD_PUSKESMAS = p.KD_PUSKESMAS
							LEFT JOIN mst_icd c ON c.KD_PENYAKIT = vw.KD_PENYAKIT
							WHERE 1=1 
							AND (vw.TGL_PELAYANAN >= '$from' AND vw.TGL_PELAYANAN <= '$to')
							AND v.KD_PROVINSI = '".$propinsi."'
							AND vw.SEX IS NOT NULL
							GROUP BY vw.KD_PENYAKIT, vw.SEX

							UNION

							SELECT 
								v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN
								, d.KD_PUSKESMAS, d.PUSKESMAS
								, CONCAT(d.NM_ICD,' ', d.KD_ICD) AS KD_PENYAKIT
								, d.MONTH AS TGL_PELAYANAN
								, d.TYPE AS UNIT_PELAYANAN, 'P' AS SEX
								, SUM(d.P) AS JMLPASIEN
							FROM laporan_agregat_diagnosa d
							LEFT JOIN mst_provinsi v ON v.KD_PROVINSI = '".$propinsi."'
							LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI 
							LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
							WHERE 1=1 
							AND p.KD_PUSKESMAS = d.KD_PUSKESMAS
							AND (d.MONTH >= '$from' AND d.MONTH <= '$to')
							GROUP BY d.KD_PUSKESMAS, d.TYPE, d.KD_ICD

							UNION

							SELECT 
								v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN
								, d.KD_PUSKESMAS, d.PUSKESMAS
								, CONCAT(d.NM_ICD,' ', d.KD_ICD) AS KD_PENYAKIT
								, d.MONTH AS TGL_PELAYANAN
								, d.TYPE AS UNIT_PELAYANAN, 'L' AS SEX
								, SUM(d.L) AS JMLPASIEN
							FROM laporan_agregat_diagnosa d
							LEFT JOIN mst_provinsi v ON v.KD_PROVINSI = '".$propinsi."'
							LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI 
							LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
							WHERE 1=1 
							AND p.KD_PUSKESMAS = d.KD_PUSKESMAS
							AND (d.MONTH >= '$from' AND d.MONTH <= '$to')
							GROUP BY d.KD_PUSKESMAS, d.TYPE, d.KD_ICD
					) a
					GROUP BY a.PROVINSI, a.KD_KABUPATEN, a.KABUPATEN, a.KD_PUSKESMAS, a.PUSKESMAS, a.KD_PENYAKIT, a.TGL_PELAYANAN, a.UNIT_PELAYANAN, a.SEX
					ORDER BY SUM(a.JMLPASIEN) DESC";
					
		$query = $db->query($sql);
		$result = $query->result_array();
		
		$newArray = array();
		$obat = array();
		
		foreach($result as $key=>$row){
			$newArray[$row['UNIT_PELAYANAN']]['OBAT'][$row['KD_PENYAKIT']] = $row['KD_PENYAKIT']; //[$row['KD_PENYAKIT']][$row['SEX']][] = $row;
			
			//total
			if(isset($newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']]))
				$newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']] = $newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']] + $row['JMLPASIEN'];
			else
				$newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']] = $row['JMLPASIEN'];
			
			
			//rowsdata
			if(isset($newArray[$row['UNIT_PELAYANAN']]['ROWS'][$row['KABUPATEN']][$row['KD_PENYAKIT']][$row['SEX']]['TOTAL']))
				$newArray[$row['UNIT_PELAYANAN']]['ROWS'][$row['KABUPATEN']][$row['KD_PENYAKIT']][$row['SEX']]['TOTAL'] = $newArray[$row['UNIT_PELAYANAN']]['ROWS'][$row['KABUPATEN']][$row['KD_PENYAKIT']][$row['SEX']]['TOTAL'] + $row['JMLPASIEN'];			
			else
				$newArray[$row['UNIT_PELAYANAN']]['ROWS'][$row['KABUPATEN']][$row['KD_PENYAKIT']][$row['SEX']]['TOTAL'] = $row['JMLPASIEN'];			
		}
		
		
		$arrDatakab = $newArray;
		$sql = "SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN
				FROM mst_provinsi v
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
				WHERE v.KD_PROVINSI = '".$propinsi."'
				GROUP BY k.KD_KABUPATEN
				ORDER BY k.KABUPATEN";
				
		$query = $db->query($sql);
		$result = $db->query($sql)->result_array(); //print_r($data);die;
		
		$data['PROPINSI'] = $result[0]['PROVINSI'];
		$newData = array();		
		foreach($result as $value){
			$newArray['RI']['ROWS'][$value['KABUPATEN']] = isset($newArray['RI']['ROWS'][$value['KABUPATEN']])?$newArray['RI']['ROWS'][$value['KABUPATEN']]:array();
			$newArray['RJ']['ROWS'][$value['KABUPATEN']] = isset($newArray['RJ']['ROWS'][$value['KABUPATEN']])?$newArray['RJ']['ROWS'][$value['KABUPATEN']]:array();	

			$rows = 10 - COUNT($newArray['RI']['ROWS'][$value['KABUPATEN']]);
			for($i=0; $i<=$rows; $i++){
				$newArray['RI']['ROWS'][$value['KABUPATEN']][] = array('L'=>array('TOTAL'=>0), 'P'=>array('TOTAL'=>0));
			}
			
			$rows = 10 - COUNT($newArray['RJ']['ROWS'][$value['KABUPATEN']]);
			for($i=0; $i<=$rows; $i++){
				$newArray['RJ']['ROWS'][$value['KABUPATEN']][] = array('L'=>array('TOTAL'=>0), 'P'=>array('TOTAL'=>0));
			}
		}
		
		$newArray['RJ']['OBAT'] = isset($newArray['RJ']['OBAT'])?$newArray['RJ']['OBAT']:array();
		$newArray['RJ']['TOTAL'] = isset($newArray['RJ']['TOTAL'])?$newArray['RJ']['TOTAL']:array();
		$newArray['RJ']['ROWS'] = isset($newArray['RJ']['ROWS'])?$newArray['RJ']['ROWS']:array();
		
		$newArray['RI']['OBAT'] = isset($newArray['RI']['OBAT'])?$newArray['RI']['OBAT']:array();
		$newArray['RI']['TOTAL'] = isset($newArray['RI']['TOTAL'])?$newArray['RI']['TOTAL']:array();
		$newArray['RI']['ROWS'] = isset($newArray['RI']['ROWS'])?$newArray['RI']['ROWS']:array();
		
		$data['result'] = $newArray;	
		
		$this->load->view('reports/rpt_sepuluhbesarrjrwprov_html',$data);
	}
	
	public function sepuluhbesarrjrwkab_html(){
		$from = $this->input->get('from')?date("Y-m-d", strtotime(str_replace('/', '-',$this->input->get('from')))):date('Y-m-d');;	//print_r($from);die;
		$to = $this->input->get('to')?date("Y-m-d", strtotime(str_replace('/', '-',$this->input->get('to')))):date('Y-m-d');; //print_r($to);die;
		
		$data['FROM'] = $from;
		$data['TO'] = $to;
		
		$propinsi = $this->input->get('propinsi'); //print_r($propinsi);die;
		$kabupaten = $this->input->get('kabupaten'); //print_r($propinsi);die;
		
		$db = $this->load->database('sikda', TRUE);
		
		$sql = "SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN
				FROM mst_provinsi v 
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI  
				WHERE 1=1 
				AND v.KD_PROVINSI = '".$propinsi."'
				AND k.KD_KABUPATEN = '".$kabupaten."'";
		$query = $db->query($sql);
		$result = $query->result_array();
		$data['PROPINSI'] = $result[0]['PROVINSI'];
		$data['KABUPATEN'] = $result[0]['KABUPATEN'];
		
		$sqls = "SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN, p.KD_PUSKESMAS, p.PUSKESMAS
				, CONCAT(c.PENYAKIT,' \n ',vw.KD_PENYAKIT) AS KD_PENYAKIT
				, vw.TGL_PELAYANAN, vw.KD_UNIT, vw.NM_UNIT
				, vw.UNIT_PELAYANAN, vw.SEX
				, COUNT( vw.KD_PENYAKIT ) AS JMLPASIEN
				FROM mst_provinsi v 
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI 
				LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN 
				LEFT JOIN vw_rpt_penyakitpasien_grp_old vw ON vw.KD_PUSKESMAS = p.KD_PUSKESMAS
				LEFT JOIN mst_icd c ON c.KD_PENYAKIT = vw.KD_PENYAKIT
				WHERE 1=1 
				AND (vw.TGL_PELAYANAN > '$from' AND vw.TGL_PELAYANAN < '$to')
				AND v.KD_PROVINSI = '".$propinsi."'
				AND k.KD_KABUPATEN = '".$kabupaten."'
				AND vw.SEX IS NOT NULL
				GROUP BY vw.KD_PENYAKIT, vw.SEX
				ORDER BY COUNT(vw.KD_PENYAKIT) DESC 
				";
		$sql = "
				SELECT a.PROVINSI, a.KD_KABUPATEN, a.KABUPATEN, a.KD_PUSKESMAS, a.PUSKESMAS, a.KD_PENYAKIT, a.TGL_PELAYANAN, a.UNIT_PELAYANAN, a.SEX, SUM(a.JMLPASIEN) AS JMLPASIEN
					FROM(
							SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN, p.KD_PUSKESMAS, p.PUSKESMAS				
							, CONCAT(c.PENYAKIT,' ',vw.KD_PENYAKIT) AS KD_PENYAKIT
							, vw.TGL_PELAYANAN, vw.UNIT_PELAYANAN, vw.SEX
							, COUNT( vw.KD_PENYAKIT ) AS JMLPASIEN
							FROM mst_provinsi v 
							LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI 
							LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN 
							LEFT JOIN vw_rpt_penyakitpasien_grp_old vw ON vw.KD_PUSKESMAS = p.KD_PUSKESMAS
							LEFT JOIN mst_icd c ON c.KD_PENYAKIT = vw.KD_PENYAKIT
							WHERE 1=1 
							AND (vw.TGL_PELAYANAN >= '$from' AND vw.TGL_PELAYANAN <= '$to')
							AND v.KD_PROVINSI = '".$propinsi."'
							AND k.KD_KABUPATEN = '".$kabupaten."'
							AND vw.SEX IS NOT NULL
							GROUP BY vw.KD_PENYAKIT, vw.SEX

							UNION

							SELECT 
								v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN
								, d.KD_PUSKESMAS, d.PUSKESMAS
								, CONCAT(d.NM_ICD,' ', d.KD_ICD) AS KD_PENYAKIT
								, d.MONTH AS TGL_PELAYANAN
								, d.TYPE AS UNIT_PELAYANAN, 'P' AS SEX
								, SUM(d.P) AS JMLPASIEN
							FROM laporan_agregat_diagnosa d
							LEFT JOIN mst_provinsi v ON v.KD_PROVINSI = '".$propinsi."'
							LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI 
							LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
							WHERE 1=1 
							AND p.KD_PUSKESMAS = d.KD_PUSKESMAS
							AND k.KD_KABUPATEN = '".$kabupaten."'
							AND (d.MONTH >= '$from' AND d.MONTH <= '$to')
							GROUP BY d.KD_PUSKESMAS, d.TYPE, d.KD_ICD

							UNION

							SELECT 
								v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN
								, d.KD_PUSKESMAS, d.PUSKESMAS
								, CONCAT(d.NM_ICD,' ', d.KD_ICD) AS KD_PENYAKIT
								, d.MONTH AS TGL_PELAYANAN
								, d.TYPE AS UNIT_PELAYANAN, 'L' AS SEX
								, SUM(d.L) AS JMLPASIEN
							FROM laporan_agregat_diagnosa d
							LEFT JOIN mst_provinsi v ON v.KD_PROVINSI = '".$propinsi."'
							LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI 
							LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
							WHERE 1=1 
							AND p.KD_PUSKESMAS = d.KD_PUSKESMAS
							AND k.KD_KABUPATEN = '".$kabupaten."'
							AND (d.MONTH >= '$from' AND d.MONTH <= '$to')
							GROUP BY d.KD_PUSKESMAS, d.TYPE, d.KD_ICD
					) a
					GROUP BY a.PROVINSI, a.KD_KABUPATEN, a.KABUPATEN, a.KD_PUSKESMAS, a.PUSKESMAS, a.KD_PENYAKIT, a.TGL_PELAYANAN, a.UNIT_PELAYANAN, a.SEX
					ORDER BY SUM(a.JMLPASIEN) DESC";
		/* echo "<pre>";	
		echo $sql;
		echo "</pre>";	 */
		$query = $db->query($sql);
		$result = $query->result_array();
		
		$newArray = array();
		$obat = array();
		
		foreach($result as $key=>$row){
			$newArray[$row['UNIT_PELAYANAN']]['OBAT'][$row['KD_PENYAKIT']] = $row['KD_PENYAKIT']; //[$row['KD_PENYAKIT']][$row['SEX']][] = $row;
			/* $newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']][] = $row;
			$newArray[$row['UNIT_PELAYANAN']]['ROWS'][$row['PUSKESMAS']][$row['KD_PENYAKIT']][$row['SEX']][] = $row;	 */

			//total
			if(isset($newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']]))
				$newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']] = $newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']] + $row['JMLPASIEN'];
			else
				$newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']] = $row['JMLPASIEN'];
			
			
			//rowsdata
			if(isset($newArray[$row['UNIT_PELAYANAN']]['ROWS'][$row['PUSKESMAS']][$row['KD_PENYAKIT']][$row['SEX']]['TOTAL']))
				$newArray[$row['UNIT_PELAYANAN']]['ROWS'][$row['PUSKESMAS']][$row['KD_PENYAKIT']][$row['SEX']]['TOTAL'] = $newArray[$row['UNIT_PELAYANAN']]['ROWS'][$row['PUSKESMAS']][$row['KD_PENYAKIT']][$row['SEX']]['TOTAL'] + $row['JMLPASIEN'];			
			else
				$newArray[$row['UNIT_PELAYANAN']]['ROWS'][$row['PUSKESMAS']][$row['KD_PENYAKIT']][$row['SEX']]['TOTAL'] = $row['JMLPASIEN'];			
			
		}
		
		$sql = "SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN, p.KD_PUSKESMAS, p.PUSKESMAS
				FROM mst_provinsi v
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
				LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
				WHERE v.KD_PROVINSI = '".$propinsi."'
				AND k.KD_KABUPATEN = '".$kabupaten."'
				GROUP BY k.KD_KABUPATEN
				ORDER BY k.KABUPATEN";
				
		$query = $db->query($sql);
		$result = $db->query($sql)->result_array(); //print_r($data);die;
		
		$data['PROPINSI'] = $result[0]['PROVINSI'];
		$newData = array();		
		foreach($result as $value){
			$newArray['RI']['ROWS'][$value['PUSKESMAS']] = isset($newArray['RI']['ROWS'][$value['PUSKESMAS']])?$newArray['RI']['ROWS'][$value['PUSKESMAS']]:array();
			$newArray['RJ']['ROWS'][$value['PUSKESMAS']] = isset($newArray['RJ']['ROWS'][$value['PUSKESMAS']])?$newArray['RJ']['ROWS'][$value['PUSKESMAS']]:array();	

			$rows = 10 - COUNT($newArray['RI']['ROWS'][$value['PUSKESMAS']]);
			for($i=0; $i<=$rows; $i++){
				$newArray['RJ']['ROWS'][$value['PUSKESMAS']][] = array('L'=>array('TOTAL'=>0), 'P'=>array('TOTAL'=>0));
			}
			$rows = 10 - COUNT($newArray['RJ']['ROWS'][$value['PUSKESMAS']]);
			for($i=0; $i<=$rows; $i++){
				$newArray['RI']['ROWS'][$value['PUSKESMAS']][] = array('L'=>array('TOTAL'=>0), 'P'=>array('TOTAL'=>0));
			}
		}
		
		/* echo "<pre>";
		print_r($newArray);
		echo "</pre>"; */
		
		$newArray['RJ']['OBAT'] = isset($newArray['RJ']['OBAT'])?$newArray['RJ']['OBAT']:array();
		$newArray['RJ']['TOTAL'] = isset($newArray['RJ']['TOTAL'])?$newArray['RJ']['TOTAL']:array();
		$newArray['RJ']['ROWS'] = isset($newArray['RJ']['ROWS'])?$newArray['RJ']['ROWS']:array();
		
		$newArray['RI']['OBAT'] = isset($newArray['RI']['OBAT'])?$newArray['RI']['OBAT']:array();
		$newArray['RI']['TOTAL'] = isset($newArray['RI']['TOTAL'])?$newArray['RI']['TOTAL']:array();
		$newArray['RI']['ROWS'] = isset($newArray['RI']['ROWS'])?$newArray['RI']['ROWS']:array();
		
		$data['result'] = $newArray;	
		
		$this->load->view('reports/rpt_sepuluhbesarrjrwkab_html',$data);
	}
	
	public function sepuluhbesarrjrwpus_html(){	
		$from = $this->input->get('from')?date("Y-m-d", strtotime(str_replace('/', '-',$this->input->get('from')))):date('Y-m-d');;	//print_r($from);die;
		$to = $this->input->get('to')?date("Y-m-d", strtotime(str_replace('/', '-',$this->input->get('to')))):date('Y-m-d');; //print_r($to);die;
		
		$data['FROM'] = $from;
		$data['TO'] = $to;
		
		$pid = $this->input->get('pid');
		$propinsi = $this->input->get('propinsi'); //print_r($propinsi);die;
		$kabupaten = $this->input->get('kabupaten'); //print_r($propinsi);die;
		$kecamatan = $this->input->get('kecamatan'); //print_r($propinsi);die;
		$puskesmas = $this->input->get('puskesmas'); //print_r($propinsi);die;
		
		$db = $this->load->database('sikda', TRUE);
		
		$sql = "SELECT v.PUSKESMAS, v.KD_PUSKESMAS
				FROM mst_puskesmas v  
				WHERE 1=1 
				AND v.KD_PUSKESMAS = '".$puskesmas."'";
		$query = $db->query($sql);
		$result = $query->result_array();
		$data['PUSKESMAS'] = $result[0]['PUSKESMAS'];
		$data['KD_PUSKESMAS'] = $result[0]['KD_PUSKESMAS'];
		
		$sql = "SELECT a.KD_PUSKESMAS, a.NAMA_PUSKESMAS
						, a.KD_PENYAKIT
						, a.PENYAKIT
						, a.UNIT_PELAYANAN
						, SUM(a.TOTAL_L) AS TOTAL_L
						, SUM(a.TOTAL_P) AS TOTAL_P
						, SUM(a.TOTAL) AS TOTAL
				FROM(	
					SELECT V.KD_PUSKESMAS, (SELECT S.KEY_VALUE FROM sys_setting AS S WHERE S.KEY_DATA = 'NAMA_PUSKESMAS' AND PUSKESMAS LIKE 'P$pid%' LIMIT 1) AS NAMA_PUSKESMAS, I.KD_PENYAKIT, I.PENYAKIT, V.UNIT_PELAYANAN,  
					(COL1_L_B + COL2_L_B + COL3_L_B + COL4_L_B + COL5_L_B + COL6_L_B + COL7_L_B + COL8_L_B + COL9_L_B + COL10_L_B + COL11_L_B + COL12_L_B + COL1_L_L + COL2_L_L + COL3_L_L + COL4_L_L + COL5_L_L + COL6_L_L + COL7_L_L + COL8_L_L + COL9_L_L + COL10_L_L + COL11_L_L + COL12_L_L) AS TOTAL_L,
					(COL1_P_B + COL2_P_B + COL3_P_B + COL4_P_B + COL5_P_B + COL6_P_B + COL7_P_B + COL8_P_B + COL9_P_B + COL10_P_B + COL11_P_B + COL12_P_B + COL1_P_L + COL2_P_L + COL3_P_L + COL4_P_L + COL5_P_L + COL6_P_L + COL7_P_L + COL8_P_L + COL9_P_L + COL10_P_L + COL11_P_L + COL12_P_L) AS TOTAL_P,
					(COL1_L_B + COL2_L_B + COL3_L_B + COL4_L_B + COL5_L_B + COL6_L_B + COL7_L_B + COL8_L_B + COL9_L_B + COL10_L_B + COL11_L_B + COL12_L_B + COL1_L_L + COL2_L_L + COL3_L_L + COL4_L_L + COL5_L_L + COL6_L_L + COL7_L_L + COL8_L_L + COL9_L_L + COL10_L_L + COL11_L_L + COL12_L_L + COL1_P_B + COL2_P_B + COL3_P_B + COL4_P_B + COL5_P_B + COL6_P_B + COL7_P_B + COL8_P_B + COL9_P_B + COL10_P_B + COL11_P_B + COL12_P_B + COL1_P_L + COL2_P_L + COL3_P_L + COL4_P_L + COL5_P_L + COL6_P_L + COL7_P_L + COL8_P_L + COL9_P_L + COL10_P_L + COL11_P_L + COL12_P_L) AS TOTAL
					FROM ( SELECT V.KD_PUSKESMAS, V.NAMA_PUSKESMAS, V.UNIT_PELAYANAN, V.KD_PENYAKIT, SUM(IF(UMURINDAYS>=0 AND UMURINDAYS<=7 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS COL1_L_B, 
					SUM(IF(UMURINDAYS>=0 AND UMURINDAYS<=7 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS COL1_P_B, 
					SUM(IF(UMURINDAYS>=8 AND UMURINDAYS<=28 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS COL2_L_B, 
					SUM(IF(UMURINDAYS>=8 AND UMURINDAYS<=28 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS COL2_P_B, 
					SUM(IF(UMURINDAYS>=29 AND UMURINDAYS<=365 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS COL3_L_B, 
					SUM(IF(UMURINDAYS>=29 AND UMURINDAYS<=365 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS COL3_P_B, 
					SUM(IF(UMURINDAYS>=366 AND UMURINDAYS<=1460 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS COL4_L_B, 
					SUM(IF(UMURINDAYS>=366 AND UMURINDAYS<=1460 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS COL4_P_B, 
					SUM(IF(UMURINDAYS>=1461 AND UMURINDAYS<=3285 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS COL5_L_B, 
					SUM(IF(UMURINDAYS>=1461 AND UMURINDAYS<=3285 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS COL5_P_B, 
					SUM(IF(UMURINDAYS>=3286 AND UMURINDAYS<=5110 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS COL6_L_B, 
					SUM(IF(UMURINDAYS>=3286 AND UMURINDAYS<=5110 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS COL6_P_B, 
					SUM(IF(UMURINDAYS>=5111 AND UMURINDAYS<=6935 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS COL7_L_B, 
					SUM(IF(UMURINDAYS>=5111 AND UMURINDAYS<=6935 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS COL7_P_B, 
					SUM(IF(UMURINDAYS>=6936 AND UMURINDAYS<=16060 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS COL8_L_B, 
					SUM(IF(UMURINDAYS>=6936 AND UMURINDAYS<=16060 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS COL8_P_B, 
					SUM(IF(UMURINDAYS>=16061 AND UMURINDAYS<=19710 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS COL9_L_B, 
					SUM(IF(UMURINDAYS>=16061 AND UMURINDAYS<=19710 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS COL9_P_B, 
					SUM(IF(UMURINDAYS>=19711 AND UMURINDAYS<=21535 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS COL10_L_B, 
					SUM(IF(UMURINDAYS>=19711 AND UMURINDAYS<=21535 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS COL10_P_B, 
					SUM(IF(UMURINDAYS>=21900 AND UMURINDAYS<=25185 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS COL11_L_B, 
					SUM(IF(UMURINDAYS>=21900 AND UMURINDAYS<=25185 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS COL11_P_B, 
					SUM(IF(UMURINDAYS>=25186 AND SEX='L' AND JNS_KASUS='Baru', 1,0)) AS COL12_L_B, 
					SUM(IF(UMURINDAYS>=25186 AND SEX='P' AND JNS_KASUS='Baru', 1,0)) AS COL12_P_B, 
					SUM(IF(UMURINDAYS>=0 AND UMURINDAYS<=7 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS COL1_L_L, 
					SUM(IF(UMURINDAYS>=0 AND UMURINDAYS<=7 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS COL1_P_L, 
					SUM(IF(UMURINDAYS>=8 AND UMURINDAYS<=28 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS COL2_L_L, 
					SUM(IF(UMURINDAYS>=8 AND UMURINDAYS<=28 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS COL2_P_L, 
					SUM(IF(UMURINDAYS>=29 AND UMURINDAYS<=365 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS COL3_L_L, 
					SUM(IF(UMURINDAYS>=29 AND UMURINDAYS<=365 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS COL3_P_L, 
					SUM(IF(UMURINDAYS>=366 AND UMURINDAYS<=1460 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS COL4_L_L, 
					SUM(IF(UMURINDAYS>=366 AND UMURINDAYS<=1460 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS COL4_P_L, 
					SUM(IF(UMURINDAYS>=1461 AND UMURINDAYS<=3285 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS COL5_L_L, 
					SUM(IF(UMURINDAYS>=1461 AND UMURINDAYS<=3285 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS COL5_P_L, 
					SUM(IF(UMURINDAYS>=3286 AND UMURINDAYS<=5110 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS COL6_L_L, 
					SUM(IF(UMURINDAYS>=3286 AND UMURINDAYS<=5110 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS COL6_P_L, 
					SUM(IF(UMURINDAYS>=5111 AND UMURINDAYS<=6935 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS COL7_L_L, 
					SUM(IF(UMURINDAYS>=5111 AND UMURINDAYS<=6935 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS COL7_P_L, 
					SUM(IF(UMURINDAYS>=6936 AND UMURINDAYS<=16060 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS COL8_L_L, 
					SUM(IF(UMURINDAYS>=6936 AND UMURINDAYS<=16060 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS COL8_P_L, 
					SUM(IF(UMURINDAYS>=16061 AND UMURINDAYS<=19710 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS COL9_L_L, 
					SUM(IF(UMURINDAYS>=16061 AND UMURINDAYS<=19710 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS COL9_P_L, 
					SUM(IF(UMURINDAYS>=19711 AND UMURINDAYS<=21535 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS COL10_L_L, 
					SUM(IF(UMURINDAYS>=19711 AND UMURINDAYS<=21535 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS COL10_P_L, 
					SUM(IF(UMURINDAYS>=21900 AND UMURINDAYS<=25185 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS COL11_L_L, 
					SUM(IF(UMURINDAYS>=21900 AND UMURINDAYS<=25185 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS COL11_P_L, 
					SUM(IF(UMURINDAYS>=25186 AND SEX='L' AND JNS_KASUS='Lama', 1,0)) AS COL12_L_L, 
					SUM(IF(UMURINDAYS>=25186 AND SEX='P' AND JNS_KASUS='Lama', 1,0)) AS COL12_P_L 
					FROM vw_rpt_penyakitpasien_grp_old AS V 
					WHERE (TGL_PELAYANAN > '$from' AND TGL_PELAYANAN < '$to') 
					AND KD_PUSKESMAS LIKE '$puskesmas%'  
					GROUP BY V.KD_PUSKESMAS, V.NAMA_PUSKESMAS, V.KD_PENYAKIT ) 
					V INNER JOIN mst_icd I ON I.KD_PENYAKIT=V.KD_PENYAKIT 
					
					UNION
					
					SELECT 
						d.KD_PUSKESMAS, d.PUSKESMAS AS NAMA_PUSKESMAS
						, d.KD_ICD AS KD_PENYAKIT
						, d.NM_ICD AS PENYAKIT
						, d.TYPE AS UNIT_PELAYANAN	
						, d.L AS TOTAL_L
						, d.P AS TOTAL_P
						, (d.L+d.P) AS TOTAL
					FROM laporan_agregat_diagnosa d
					WHERE 1=1
					AND (d.MONTH >= '$from' AND d.MONTH <= '$to') 
					AND d.KD_PUSKESMAS LIKE '$puskesmas%'  
				) a
				GROUP BY a.KD_PUSKESMAS
						, a.KD_PENYAKIT, a.UNIT_PELAYANAN
				ORDER BY SUM(a.TOTAL) DESC
				";
		/* 		
		echo "<pre>";
		echo $sql;
		echo "</pre>"; */
		$query = $db->query($sql);
		$data['result'] = $query->result_array();
				
		$this->load->view('reports/rpt_sepuluhbesarrjrwpus_html',$data);
	}
	
	public function sepuluhbesarrujuk(){	
		$this->load->helper('beries_helper');
						
		if(isset($_GET['jenispt']) && ( ($_GET['jenispt'] == 'html') || ($_GET['jenispt'] == 'excel') )){
			$propinsi = $_GET['propinsi'];
			$kabupaten = $_GET['kabupaten'];
			$kecamatan = $_GET['kecamatan'];
			$puskesmas = $_GET['puskesmas'];
			//print_r($_GET);
			
			$_GET['from'] 	= date('Y-m-01', strtotime($_GET['from']));
			$_GET['to'] 	= date('Y-m-t', strtotime($_GET['to']));
			
			if($_GET['jenispt'] == 'excel'){
				$fileName = "Report_Sepuluh_Besar_Rawat_Jalan_".date('Ymd').".xls";
				header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
				header("Content-Disposition: attachment; filename=".$fileName);  //File name extension was wrong
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private",false);
			}
			
			if($puskesmas != '0'){
				$this->sepuluhbesarrujukpus_html();
			}elseif($puskesmas == 0 && $kecamatan > 0){
				echo "Pilih Puskesmas";				
			}elseif($puskesmas == 0 && $kecamatan == 0 && $kabupaten > 0){
				$this->sepuluhbesarrujukkab_html();
			}elseif($puskesmas == 0 && $kecamatan == 0 && $kabupaten == 0 && $propinsi > 0){
				$this->sepuluhbesarrujukprov_html();
			}else{
				$this->sepuluhbesarrujuknas_html();
			}
			
		}else{
			$this->load->view('reports/rpt_sepuluhbesarrujuk');
		}
	}
	
	public function sepuluhbesarrujuknas_html(){
		$from = $this->input->get('from')?date("Y-m-d", strtotime(str_replace('/', '-',$this->input->get('from')))):date('Y-m-d');;	//print_r($from);die;
		$to = $this->input->get('to')?date("Y-m-d", strtotime(str_replace('/', '-',$this->input->get('to')))):date('Y-m-d');; //print_r($to);die;
		
		$data['FROM'] = $from;
		$data['TO'] = $to;
		
		$propinsi = $this->input->get('propinsi'); //print_r($propinsi);die;
		$db = $this->load->database('sikda', TRUE);
		
		/* $sql = "SELECT v.PROVINSI
				FROM mst_provinsi v  
				WHERE 1=1 
				AND v.KD_PROVINSI = '".$propinsi."'";
		$query = $db->query($sql);
		$result = $query->result_array();
		$data['PROPINSI'] = $result[0]['PROVINSI']; */
		
		$sql = "SELECT a.PROVINSI, a.KD_KABUPATEN, a.KABUPATEN, a.KD_PUSKESMAS
					   ,a.PUSKESMAS, a.KD_PENYAKIT, a.TGL_PELAYANAN, a.UNIT_PELAYANAN
					   ,a.SEX, a.KEADAAN_KELUAR, SUM(a.JMLPASIEN) AS JMLPASIEN
				FROM(
					SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN, p.KD_PUSKESMAS
					, p.PUSKESMAS
					, CONCAT(c.PENYAKIT,' \n ',d.KD_PENYAKIT) AS KD_PENYAKIT
					, vw.TGL_PELAYANAN, vw.UNIT_PELAYANAN, e.KD_JENIS_KELAMIN AS SEX, vw.KEADAAN_KELUAR
					, COUNT( d.KD_PENYAKIT ) AS JMLPASIEN
					FROM mst_provinsi v 
					LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI 
					LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN 
					LEFT JOIN pelayanan vw ON vw.KD_PUSKESMAS = p.KD_PUSKESMAS
					LEFT JOIN pel_diagnosa d ON d.KD_PELAYANAN = vw.KD_PELAYANAN
					LEFT JOIN mst_icd c ON c.KD_PENYAKIT = d.KD_PENYAKIT
					LEFT JOIN mst_unit u ON u.KD_UNIT = vw.KD_UNIT	
					LEFT JOIN pasien e ON e.KD_PASIEN = vw.KD_PASIEN
					WHERE 1=1 
					AND (vw.TGL_PELAYANAN >= '$from' AND vw.TGL_PELAYANAN <= '$to') 
					AND e.KD_JENIS_KELAMIN IS NOT NULL
					AND d.KD_PENYAKIT IS NOT NULL
					AND vw.KEADAAN_KELUAR = 'DIRUJUK'
					GROUP BY d.KD_PENYAKIT, e.KD_JENIS_KELAMIN
					
					UNION

					SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN, a.KD_PUSKESMAS, a.PUSKESMAS
						,CONCAT(a.NM_ICD,' ',a.KD_ICD) AS KD_PENYAKIT
						,a.MONTH AS TGL_PELAYANAN
						,'RJ' AS UNIT_PELAYANAN, 'L' AS SEX
						,'DIRUJUK' AS KEADAAN_KELUAR, a.L AS JMLPASIEN
					FROM mst_provinsi v
					LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
					LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
					LEFT JOIN laporan_agregat_diagnosa_rujukan a ON a.KD_PUSKESMAS = p.KD_PUSKESMAS
					WHERE v.KD_PROVINSI IS NOT NULL
					AND a.MONTH >= '$from'
					AND a.MONTH <= '$to'
					GROUP BY k.KD_KABUPATEN, p.KD_PUSKESMAS, CONCAT(a.NM_ICD,' ',a.KD_ICD)
					
					UNION 
					
					SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN, a.KD_PUSKESMAS, a.PUSKESMAS
						,CONCAT(a.NM_ICD,' ',a.KD_ICD) AS KD_PENYAKIT
						,a.MONTH AS TGL_PELAYANAN
						,'RJ' AS UNIT_PELAYANAN, 'P' AS SEX
						,'DIRUJUK' AS KEADAAN_KELUAR, a.P AS JMLPASIEN
					FROM mst_provinsi v
					LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
					LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
					LEFT JOIN laporan_agregat_diagnosa_rujukan a ON a.KD_PUSKESMAS = p.KD_PUSKESMAS
					WHERE v.KD_PROVINSI IS NOT NULL
					AND a.MONTH >= '$from'
					AND a.MONTH <= '$to'
					GROUP BY k.KD_KABUPATEN, p.KD_PUSKESMAS, CONCAT(a.NM_ICD,' ',a.KD_ICD)
				) a
				GROUP BY a.PROVINSI, a.KD_KABUPATEN, a.KABUPATEN, a.KD_PUSKESMAS
					   ,a.PUSKESMAS, a.KD_PENYAKIT, a.TGL_PELAYANAN, a.UNIT_PELAYANAN
					   ,a.SEX, a.KEADAAN_KELUAR
				ORDER BY SUM( a.JMLPASIEN ) DESC 
				";
				/* echo "<pre>";
				print_r($sql);
				echo "</pre>"; */
				
		$query = $db->query($sql);
		$result = $query->result_array();
		
		$newArray = array();
		$obat = array();
		
		foreach($result as $key=>$row){
			$newArray[$row['UNIT_PELAYANAN']]['OBAT'][$row['KD_PENYAKIT']] = $row['KD_PENYAKIT']; 

			//total
			if(isset($newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']]))
				$newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']] = $newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']] + $row['JMLPASIEN'];
			else
				$newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']] = $row['JMLPASIEN'];
			
			//rowsdata
			if(isset($newArray[$row['UNIT_PELAYANAN']]['ROWS'][$row['PROVINSI']][$row['KD_PENYAKIT']][$row['SEX']]['TOTAL']))
				$newArray[$row['UNIT_PELAYANAN']]['ROWS'][$row['PROVINSI']][$row['KD_PENYAKIT']][$row['SEX']]['TOTAL'] = $newArray[$row['UNIT_PELAYANAN']]['ROWS'][$row['PROVINSI']][$row['KD_PENYAKIT']][$row['SEX']]['TOTAL'] + $row['JMLPASIEN'];			
			else
				$newArray[$row['UNIT_PELAYANAN']]['ROWS'][$row['PROVINSI']][$row['KD_PENYAKIT']][$row['SEX']]['TOTAL'] = $row['JMLPASIEN'];			
			
		}
		
		$sql = "SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN
				FROM mst_provinsi v
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
				GROUP BY k.KD_KABUPATEN
				ORDER BY k.KABUPATEN";
				
		$query = $db->query($sql);
		$result = $db->query($sql)->result_array(); //print_r($data);die;
		
		$newData = array();		
		foreach($result as $value){
			$newArray['RI']['ROWS'][$value['PROVINSI']] = isset($newArray['RI']['ROWS'][$value['PROVINSI']])?$newArray['RI']['ROWS'][$value['PROVINSI']]:array();
			$newArray['RJ']['ROWS'][$value['PROVINSI']] = isset($newArray['RJ']['ROWS'][$value['PROVINSI']])?$newArray['RJ']['ROWS'][$value['PROVINSI']]:array();	

			$rows = 10 - COUNT($newArray['RI']['ROWS'][$value['PROVINSI']]);
			for($i=0; $i<=$rows; $i++){
				$newArray['RI']['ROWS'][$value['PROVINSI']][] = array('L'=>array('TOTAL'=>0), 'P'=>array('TOTAL'=>0));
			}
			
			$rows = 10 - COUNT($newArray['RJ']['ROWS'][$value['PROVINSI']]);
			for($i=0; $i<=$rows; $i++){
				$newArray['RJ']['ROWS'][$value['PROVINSI']][] = array('L'=>array('TOTAL'=>0), 'P'=>array('TOTAL'=>0));
			}
		}
		
		$newArray['RJ']['OBAT'] = isset($newArray['RJ']['OBAT'])?$newArray['RJ']['OBAT']:array();
		$newArray['RJ']['TOTAL'] = isset($newArray['RJ']['TOTAL'])?$newArray['RJ']['TOTAL']:array();
		$newArray['RJ']['ROWS'] = isset($newArray['RJ']['ROWS'])?$newArray['RJ']['ROWS']:array();
		
		$newArray['RI']['OBAT'] = isset($newArray['RI']['OBAT'])?$newArray['RI']['OBAT']:array();
		$newArray['RI']['TOTAL'] = isset($newArray['RI']['TOTAL'])?$newArray['RI']['TOTAL']:array();
		$newArray['RI']['ROWS'] = isset($newArray['RI']['ROWS'])?$newArray['RI']['ROWS']:array();
		
		$data['result'] = $newArray;	
		$this->load->view('reports/rpt_sepuluhbesarrujuknas_html',$data);
	}
	
	public function sepuluhbesarrujukprov_html(){
		$from = $this->input->get('from')?date("Y-m-d", strtotime(str_replace('/', '-',$this->input->get('from')))):date('Y-m-d');;	//print_r($from);die;
		$to = $this->input->get('to')?date("Y-m-d", strtotime(str_replace('/', '-',$this->input->get('to')))):date('Y-m-d');; //print_r($to);die;
		
		$data['FROM'] = $from;
		$data['TO'] = $to;
		
		$propinsi = $this->input->get('propinsi'); //print_r($propinsi);die;
		$db = $this->load->database('sikda', TRUE);
		
		$sql = "SELECT v.PROVINSI
				FROM mst_provinsi v  
				WHERE 1=1 
				AND v.KD_PROVINSI = '".$propinsi."'";
		$query = $db->query($sql);
		$result = $query->result_array();
		$data['PROPINSI'] = $result[0]['PROVINSI'];
		
		$sql = "SELECT a.PROVINSI, a.KD_KABUPATEN, a.KABUPATEN, a.KD_PUSKESMAS
					   ,a.PUSKESMAS, a.KD_PENYAKIT, a.TGL_PELAYANAN, a.UNIT_PELAYANAN
					   ,a.SEX, a.KEADAAN_KELUAR, SUM(a.JMLPASIEN) AS JMLPASIEN
				FROM(
					SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN, p.KD_PUSKESMAS
					, p.PUSKESMAS
					, CONCAT(c.PENYAKIT,' \n ',d.KD_PENYAKIT) AS KD_PENYAKIT
					, vw.TGL_PELAYANAN, vw.UNIT_PELAYANAN, e.KD_JENIS_KELAMIN AS SEX, vw.KEADAAN_KELUAR
					, COUNT( d.KD_PENYAKIT ) AS JMLPASIEN
					FROM mst_provinsi v 
					LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI 
					LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN 
					LEFT JOIN pelayanan vw ON vw.KD_PUSKESMAS = p.KD_PUSKESMAS
					LEFT JOIN pel_diagnosa d ON d.KD_PELAYANAN = vw.KD_PELAYANAN
					LEFT JOIN mst_icd c ON c.KD_PENYAKIT = d.KD_PENYAKIT
					LEFT JOIN mst_unit u ON u.KD_UNIT = vw.KD_UNIT	
					LEFT JOIN pasien e ON e.KD_PASIEN = vw.KD_PASIEN
					WHERE 1=1 
					AND (vw.TGL_PELAYANAN >= '$from' AND vw.TGL_PELAYANAN <= '$to') 
					AND v.KD_PROVINSI = '".$propinsi."'
					AND e.KD_JENIS_KELAMIN IS NOT NULL
					AND d.KD_PENYAKIT IS NOT NULL
					AND vw.KEADAAN_KELUAR = 'DIRUJUK'
					GROUP BY d.KD_PENYAKIT, e.KD_JENIS_KELAMIN
					
					UNION

					SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN, a.KD_PUSKESMAS, a.PUSKESMAS
						,CONCAT(a.NM_ICD,' ',a.KD_ICD) AS KD_PENYAKIT
						,a.MONTH AS TGL_PELAYANAN
						,'RJ' AS UNIT_PELAYANAN, 'L' AS SEX
						,'DIRUJUK' AS KEADAAN_KELUAR, a.L AS JMLPASIEN
					FROM mst_provinsi v
					LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
					LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
					LEFT JOIN laporan_agregat_diagnosa_rujukan a ON a.KD_PUSKESMAS = p.KD_PUSKESMAS
					WHERE v.KD_PROVINSI = '".$propinsi."'
					AND a.MONTH >= '$from'
					AND a.MONTH <= '$to'
					GROUP BY k.KD_KABUPATEN, p.KD_PUSKESMAS, CONCAT(a.NM_ICD,' ',a.KD_ICD)
					
					UNION 
					
					SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN, a.KD_PUSKESMAS, a.PUSKESMAS
						,CONCAT(a.NM_ICD,' ',a.KD_ICD) AS KD_PENYAKIT
						,a.MONTH AS TGL_PELAYANAN
						,'RJ' AS UNIT_PELAYANAN, 'P' AS SEX
						,'DIRUJUK' AS KEADAAN_KELUAR, a.P AS JMLPASIEN
					FROM mst_provinsi v
					LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
					LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
					LEFT JOIN laporan_agregat_diagnosa_rujukan a ON a.KD_PUSKESMAS = p.KD_PUSKESMAS
					WHERE v.KD_PROVINSI = '".$propinsi."'
					AND a.MONTH >= '$from'
					AND a.MONTH <= '$to'
					GROUP BY k.KD_KABUPATEN, p.KD_PUSKESMAS, CONCAT(a.NM_ICD,' ',a.KD_ICD)
				) a
				GROUP BY a.PROVINSI, a.KD_KABUPATEN, a.KABUPATEN, a.KD_PUSKESMAS
					   ,a.PUSKESMAS, a.KD_PENYAKIT, a.TGL_PELAYANAN, a.UNIT_PELAYANAN
					   ,a.SEX, a.KEADAAN_KELUAR
				ORDER BY SUM( a.JMLPASIEN ) DESC 
				";
				/* echo "<pre>";
				print_r($sql);
				echo "</pre>"; */
				
		$query = $db->query($sql);
		$result = $query->result_array();
		
		$newArray = array();
		$obat = array();
		
		foreach($result as $key=>$row){
			$newArray[$row['UNIT_PELAYANAN']]['OBAT'][$row['KD_PENYAKIT']] = $row['KD_PENYAKIT']; //[$row['KD_PENYAKIT']][$row['SEX']][] = $row;
			//$newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']][] = $row;
			//$newArray[$row['UNIT_PELAYANAN']]['ROWS'][$row['KABUPATEN']][$row['KD_PENYAKIT']][$row['SEX']][] = $row;	

			//total
			if(isset($newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']]))
				$newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']] = $newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']] + $row['JMLPASIEN'];
			else
				$newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']] = $row['JMLPASIEN'];
			
			
			//rowsdata
			if(isset($newArray[$row['UNIT_PELAYANAN']]['ROWS'][$row['KABUPATEN']][$row['KD_PENYAKIT']][$row['SEX']]['TOTAL']))
				$newArray[$row['UNIT_PELAYANAN']]['ROWS'][$row['KABUPATEN']][$row['KD_PENYAKIT']][$row['SEX']]['TOTAL'] = $newArray[$row['UNIT_PELAYANAN']]['ROWS'][$row['KABUPATEN']][$row['KD_PENYAKIT']][$row['SEX']]['TOTAL'] + $row['JMLPASIEN'];			
			else
				$newArray[$row['UNIT_PELAYANAN']]['ROWS'][$row['KABUPATEN']][$row['KD_PENYAKIT']][$row['SEX']]['TOTAL'] = $row['JMLPASIEN'];			
			
		}
		
		
		$sql = "SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN
				FROM mst_provinsi v
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
				WHERE v.KD_PROVINSI = '".$propinsi."'
				GROUP BY k.KD_KABUPATEN
				ORDER BY k.KABUPATEN";
				
		$query = $db->query($sql);
		$result = $db->query($sql)->result_array(); //print_r($data);die;
		
		$data['PROPINSI'] = $result[0]['PROVINSI'];
		$newData = array();		
		foreach($result as $value){
			$newArray['RI']['ROWS'][$value['KABUPATEN']] = isset($newArray['RI']['ROWS'][$value['KABUPATEN']])?$newArray['RI']['ROWS'][$value['KABUPATEN']]:array();
			$newArray['RJ']['ROWS'][$value['KABUPATEN']] = isset($newArray['RJ']['ROWS'][$value['KABUPATEN']])?$newArray['RJ']['ROWS'][$value['KABUPATEN']]:array();	

			$rows = 10 - COUNT($newArray['RI']['ROWS'][$value['KABUPATEN']]);
			for($i=0; $i<=$rows; $i++){
				$newArray['RI']['ROWS'][$value['KABUPATEN']][] = array('L'=>array('TOTAL'=>0), 'P'=>array('TOTAL'=>0));
			}
			
			$rows = 10 - COUNT($newArray['RJ']['ROWS'][$value['KABUPATEN']]);
			for($i=0; $i<=$rows; $i++){
				$newArray['RJ']['ROWS'][$value['KABUPATEN']][] = array('L'=>array('TOTAL'=>0), 'P'=>array('TOTAL'=>0));
			}
		}
		
		$newArray['RJ']['OBAT'] = isset($newArray['RJ']['OBAT'])?$newArray['RJ']['OBAT']:array();
		$newArray['RJ']['TOTAL'] = isset($newArray['RJ']['TOTAL'])?$newArray['RJ']['TOTAL']:array();
		$newArray['RJ']['ROWS'] = isset($newArray['RJ']['ROWS'])?$newArray['RJ']['ROWS']:array();
		
		$newArray['RI']['OBAT'] = isset($newArray['RI']['OBAT'])?$newArray['RI']['OBAT']:array();
		$newArray['RI']['TOTAL'] = isset($newArray['RI']['TOTAL'])?$newArray['RI']['TOTAL']:array();
		$newArray['RI']['ROWS'] = isset($newArray['RI']['ROWS'])?$newArray['RI']['ROWS']:array();
		
		$data['result'] = $newArray;	
		
		$this->load->view('reports/rpt_sepuluhbesarrujukprov_html',$data);
	}
	
	public function sepuluhbesarrujukkab_html(){
		$from = $this->input->get('from')?date("Y-m-d", strtotime(str_replace('/', '-',$this->input->get('from')))):date('Y-m-d');;	//print_r($from);die;
		$to = $this->input->get('to')?date("Y-m-d", strtotime(str_replace('/', '-',$this->input->get('to')))):date('Y-m-d');; //print_r($to);die;
		
		$data['FROM'] = $from;
		$data['TO'] = $to;
		
		$propinsi = $this->input->get('propinsi'); //print_r($propinsi);die;
		$kabupaten = $this->input->get('kabupaten'); //print_r($propinsi);die;
		
		$db = $this->load->database('sikda', TRUE);
		
		$sql = "SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN
				FROM mst_provinsi v 
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI  
				WHERE 1=1 
				AND v.KD_PROVINSI = '".$propinsi."'
				AND k.KD_KABUPATEN = '".$kabupaten."'";
		$query = $db->query($sql);
		$result = $query->result_array();
		$data['PROPINSI'] = $result[0]['PROVINSI'];
		$data['KABUPATEN'] = $result[0]['KABUPATEN'];
		
		$sql = "SELECT a.PROVINSI, a.KD_KABUPATEN, a.KABUPATEN, a.KD_PUSKESMAS
					   ,a.PUSKESMAS, a.KD_PENYAKIT, a.TGL_PELAYANAN, a.UNIT_PELAYANAN
					   ,a.SEX, a.KEADAAN_KELUAR, SUM(a.JMLPASIEN) AS JMLPASIEN
				FROM(
					SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN, p.KD_PUSKESMAS
					, p.PUSKESMAS
					, CONCAT(c.PENYAKIT,' \n ',d.KD_PENYAKIT) AS KD_PENYAKIT
					, vw.TGL_PELAYANAN
					, vw.UNIT_PELAYANAN, e.KD_JENIS_KELAMIN AS SEX, vw.KEADAAN_KELUAR
					, COUNT( d.KD_PENYAKIT ) AS JMLPASIEN
					FROM mst_provinsi v 
					LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI 
					LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN 
					LEFT JOIN pelayanan vw ON vw.KD_PUSKESMAS = p.KD_PUSKESMAS
					LEFT JOIN pel_diagnosa d ON d.KD_PELAYANAN = vw.KD_PELAYANAN
					LEFT JOIN mst_icd c ON c.KD_PENYAKIT = d.KD_PENYAKIT
					LEFT JOIN mst_unit u ON u.KD_UNIT = vw.KD_UNIT	
					LEFT JOIN pasien e ON e.KD_PASIEN = vw.KD_PASIEN
					WHERE 1=1 
					AND (vw.TGL_PELAYANAN >= '$from' AND vw.TGL_PELAYANAN <= '$to') 
					AND v.KD_PROVINSI = '".$propinsi."'
					AND k.KD_KABUPATEN = '".$kabupaten."'
					AND e.KD_JENIS_KELAMIN IS NOT NULL
					AND d.KD_PENYAKIT IS NOT NULL
					AND vw.KEADAAN_KELUAR = 'DIRUJUK'
					GROUP BY d.KD_PENYAKIT, e.KD_JENIS_KELAMIN
					
					UNION

					SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN, a.KD_PUSKESMAS, a.PUSKESMAS
						,CONCAT(a.NM_ICD,' ',a.KD_ICD) AS KD_PENYAKIT
						,a.MONTH AS TGL_PELAYANAN
						,'RJ' AS UNIT_PELAYANAN, 'L' AS SEX
						,'DIRUJUK' AS KEADAAN_KELUAR, a.L AS JMLPASIEN
					FROM mst_provinsi v
					LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
					LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
					LEFT JOIN laporan_agregat_diagnosa_rujukan a ON a.KD_PUSKESMAS = p.KD_PUSKESMAS
					WHERE v.KD_PROVINSI = '".$propinsi."'
					AND k.KD_KABUPATEN = '".$kabupaten."'
					AND a.MONTH >= '$from'
					AND a.MONTH <= '$to'
					GROUP BY k.KD_KABUPATEN, p.KD_PUSKESMAS, CONCAT(a.NM_ICD,' ',a.KD_ICD)
					
					UNION 
					
					SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN, a.KD_PUSKESMAS, a.PUSKESMAS
						,CONCAT(a.NM_ICD,' ',a.KD_ICD) AS KD_PENYAKIT
						,a.MONTH AS TGL_PELAYANAN
						,'RJ' AS UNIT_PELAYANAN, 'P' AS SEX
						,'DIRUJUK' AS KEADAAN_KELUAR, a.P AS JMLPASIEN
					FROM mst_provinsi v
					LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
					LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
					LEFT JOIN laporan_agregat_diagnosa_rujukan a ON a.KD_PUSKESMAS = p.KD_PUSKESMAS
					WHERE v.KD_PROVINSI = '".$propinsi."'
					AND k.KD_KABUPATEN = '".$kabupaten."'
					AND a.MONTH >= '$from'
					AND a.MONTH <= '$to'
					GROUP BY k.KD_KABUPATEN, p.KD_PUSKESMAS, CONCAT(a.NM_ICD,' ',a.KD_ICD)
				) a
				GROUP BY a.PROVINSI, a.KD_KABUPATEN, a.KABUPATEN, a.KD_PUSKESMAS
					   ,a.PUSKESMAS, a.KD_PENYAKIT, a.TGL_PELAYANAN, a.UNIT_PELAYANAN
					   ,a.SEX, a.KEADAAN_KELUAR
				ORDER BY SUM( a.JMLPASIEN ) DESC 
				";
				
		$query = $db->query($sql);
		$result = $query->result_array();
		
		$newArray = array();
		$obat = array();
		
		foreach($result as $key=>$row){
			$newArray[$row['UNIT_PELAYANAN']]['OBAT'][$row['KD_PENYAKIT']] = $row['KD_PENYAKIT']; 			
			
			//total
			if(isset($newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']]))
				$newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']] = $newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']] + $row['JMLPASIEN'];
			else
				$newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']] = $row['JMLPASIEN'];
			
			
			//rowsdata
			if(isset($newArray[$row['UNIT_PELAYANAN']]['ROWS'][$row['PUSKESMAS']][$row['KD_PENYAKIT']][$row['SEX']]['TOTAL']))
				$newArray[$row['UNIT_PELAYANAN']]['ROWS'][$row['PUSKESMAS']][$row['KD_PENYAKIT']][$row['SEX']]['TOTAL'] = $newArray[$row['UNIT_PELAYANAN']]['ROWS'][$row['KABUPATEN']][$row['KD_PENYAKIT']][$row['SEX']]['TOTAL'] + $row['JMLPASIEN'];			
			else
				$newArray[$row['UNIT_PELAYANAN']]['ROWS'][$row['PUSKESMAS']][$row['KD_PENYAKIT']][$row['SEX']]['TOTAL'] = $row['JMLPASIEN'];			
			
		}
		
		$sql = "SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN, p.KD_PUSKESMAS, p.PUSKESMAS
				FROM mst_provinsi v
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
				LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
				WHERE v.KD_PROVINSI = '".$propinsi."'
				AND k.KD_KABUPATEN = '".$kabupaten."'
				GROUP BY k.KD_KABUPATEN
				ORDER BY k.KABUPATEN";
				
		$query = $db->query($sql);
		$result = $db->query($sql)->result_array(); //print_r($data);die;
		
		$data['PROPINSI'] = $result[0]['PROVINSI'];
		$newData = array();		
		foreach($result as $value){
			$newArray['RI']['ROWS'][$value['PUSKESMAS']] = isset($newArray['RI']['ROWS'][$value['PUSKESMAS']])?$newArray['RI']['ROWS'][$value['PUSKESMAS']]:array();
			$newArray['RJ']['ROWS'][$value['PUSKESMAS']] = isset($newArray['RJ']['ROWS'][$value['PUSKESMAS']])?$newArray['RJ']['ROWS'][$value['PUSKESMAS']]:array();	

			$rows = 10 - COUNT($newArray['RI']['ROWS'][$value['PUSKESMAS']]);
			for($i=0; $i<=$rows; $i++){
				$newArray['RJ']['ROWS'][$value['PUSKESMAS']][] = array('L'=>array('TOTAL'=>0), 'P'=>array('TOTAL'=>0));
			}
			$rows = 10 - COUNT($newArray['RJ']['ROWS'][$value['PUSKESMAS']]);
			for($i=0; $i<=$rows; $i++){
				$newArray['RI']['ROWS'][$value['PUSKESMAS']][] = array('L'=>array('TOTAL'=>0), 'P'=>array('TOTAL'=>0));
			}
		}
		
		$newArray['RJ']['OBAT'] = isset($newArray['RJ']['OBAT'])?$newArray['RJ']['OBAT']:array();
		$newArray['RJ']['TOTAL'] = isset($newArray['RJ']['TOTAL'])?$newArray['RJ']['TOTAL']:array();
		$newArray['RJ']['ROWS'] = isset($newArray['RJ']['ROWS'])?$newArray['RJ']['ROWS']:array();
		
		$newArray['RI']['OBAT'] = isset($newArray['RI']['OBAT'])?$newArray['RI']['OBAT']:array();
		$newArray['RI']['TOTAL'] = isset($newArray['RI']['TOTAL'])?$newArray['RI']['TOTAL']:array();
		$newArray['RI']['ROWS'] = isset($newArray['RI']['ROWS'])?$newArray['RI']['ROWS']:array();
		
		$data['result'] = $newArray;	
		
		$this->load->view('reports/rpt_sepuluhbesarujukkab_html',$data);
	}
	
	public function sepuluhbesarrujukpus_html(){
		$from = $this->input->get('from')?date("Y-m-d", strtotime(str_replace('/', '-',$this->input->get('from')))):date('Y-m-d');;	//print_r($from);die;
		$to = $this->input->get('to')?date("Y-m-d", strtotime(str_replace('/', '-',$this->input->get('to')))):date('Y-m-d');; //print_r($to);die;
		
		$data['FROM'] = $from;
		$data['TO'] = $to;
		
		$propinsi = $this->input->get('propinsi'); //print_r($propinsi);die;
		$kabupaten = $this->input->get('kabupaten'); //print_r($propinsi);die;
		$puskesmas = $this->input->get('puskesmas'); //print_r($propinsi);die;
		
		$db = $this->load->database('sikda', TRUE);
		
		$sql = "SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN, p.KD_PUSKESMAS, p.PUSKESMAS
				FROM mst_provinsi v 
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI  
				LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN 
				WHERE 1=1 
				AND v.KD_PROVINSI = '".$propinsi."'
				AND k.KD_KABUPATEN = '".$kabupaten."'
				AND p.KD_PUSKESMAS = '".$puskesmas."'
				";
		$query = $db->query($sql);
		$result = $query->result_array();
		$data['PROPINSI'] = $result[0]['PROVINSI'];
		$data['KABUPATEN'] = $result[0]['KABUPATEN'];
		$data['KD_PUSKESMAS'] = $result[0]['KD_PUSKESMAS'];
		$data['PUSKESMAS'] = $result[0]['PUSKESMAS'];
		
		$sql = "SELECT a.PROVINSI, a.KD_KABUPATEN, a.KABUPATEN, a.KD_PUSKESMAS
					   ,a.PUSKESMAS, a.KD_PENYAKIT, a.DESCRIPTION, a.TGL_PELAYANAN, a.UNIT_PELAYANAN
					   ,a.SEX, a.KEADAAN_KELUAR, SUM(a.JMLPASIEN) AS JMLPASIEN
				FROM(
					SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN, p.KD_PUSKESMAS
					, p.PUSKESMAS
					, d.KD_PENYAKIT
					, c.PENYAKIT AS DESCRIPTION
					, vw.TGL_PELAYANAN
					, vw.UNIT_PELAYANAN, e.KD_JENIS_KELAMIN AS SEX, vw.KEADAAN_KELUAR
					, COUNT( d.KD_PENYAKIT ) AS JMLPASIEN
					FROM mst_provinsi v 
					LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI 
					LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN 
					LEFT JOIN pelayanan vw ON vw.KD_PUSKESMAS = p.KD_PUSKESMAS
					LEFT JOIN pel_diagnosa d ON d.KD_PELAYANAN = vw.KD_PELAYANAN
					LEFT JOIN mst_icd c ON c.KD_PENYAKIT = d.KD_PENYAKIT
					LEFT JOIN mst_unit u ON u.KD_UNIT = vw.KD_UNIT	
					LEFT JOIN pasien e ON e.KD_PASIEN = vw.KD_PASIEN
					WHERE 1=1 
					AND (vw.TGL_PELAYANAN >= '$from' AND vw.TGL_PELAYANAN <= '$to') 
					AND v.KD_PROVINSI = '".$propinsi."'
					AND k.KD_KABUPATEN = '".$kabupaten."'
					AND p.KD_PUSKESMAS = '".$puskesmas."'
					AND e.KD_JENIS_KELAMIN IS NOT NULL
					AND d.KD_PENYAKIT IS NOT NULL
					AND vw.KEADAAN_KELUAR = 'DIRUJUK'
					GROUP BY d.KD_PENYAKIT, e.KD_JENIS_KELAMIN
					
					UNION

					SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN, a.KD_PUSKESMAS, a.PUSKESMAS
						,a.KD_ICD AS KD_PENYAKIT
						,a.NM_ICD AS DESCRIPTION
						,a.MONTH AS TGL_PELAYANAN
						,'RJ' AS UNIT_PELAYANAN, 'L' AS SEX
						,'DIRUJUK' AS KEADAAN_KELUAR, a.L AS JMLPASIEN
					FROM mst_provinsi v
					LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
					LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
					LEFT JOIN laporan_agregat_diagnosa_rujukan a ON a.KD_PUSKESMAS = p.KD_PUSKESMAS
					WHERE v.KD_PROVINSI = '".$propinsi."'
					AND k.KD_KABUPATEN = '".$kabupaten."'
					AND p.KD_PUSKESMAS = '".$puskesmas."'
					AND a.MONTH >= '$from'
					AND a.MONTH <= '$to'
					GROUP BY k.KD_KABUPATEN, p.KD_PUSKESMAS, a.KD_ICD
					
					UNION 
					
					SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN, a.KD_PUSKESMAS, a.PUSKESMAS
						,a.KD_ICD AS KD_PENYAKIT
						,a.NM_ICD AS DESCRIPTION
						,a.MONTH AS TGL_PELAYANAN
						,'RJ' AS UNIT_PELAYANAN, 'P' AS SEX
						,'DIRUJUK' AS KEADAAN_KELUAR, a.P AS JMLPASIEN
					FROM mst_provinsi v
					LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
					LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
					LEFT JOIN laporan_agregat_diagnosa_rujukan a ON a.KD_PUSKESMAS = p.KD_PUSKESMAS
					WHERE v.KD_PROVINSI = '".$propinsi."'
					AND k.KD_KABUPATEN = '".$kabupaten."'
					AND p.KD_PUSKESMAS = '".$puskesmas."'
					AND a.MONTH >= '$from'
					AND a.MONTH <= '$to'
					GROUP BY k.KD_KABUPATEN, p.KD_PUSKESMAS, a.KD_ICD
				) a
				GROUP BY a.PROVINSI, a.KD_KABUPATEN, a.KABUPATEN, a.KD_PUSKESMAS
					   ,a.PUSKESMAS, a.KD_PENYAKIT, a.TGL_PELAYANAN, a.UNIT_PELAYANAN
					   ,a.SEX, a.KEADAAN_KELUAR
				ORDER BY SUM( a.JMLPASIEN ) DESC 
				";
				/* echo "<pre>";
				echo $sql;
				echo "</pre>"; */
		$query = $db->query($sql);
		$result = $query->result_array();
		
		$newArray = array();
		$obat = array();
		
		foreach($result as $key=>$row){
			$newArray[$row['KD_PENYAKIT']] = $row;
			$newArray[$row['KD_PENYAKIT']][$row['SEX']][] = $row;
			
			/* //total
			if(isset($newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']]))
				$newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']] = $newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']] + $row['JMLPASIEN'];
			else
				$newArray[$row['UNIT_PELAYANAN']]['TOTAL'][$row['KD_PENYAKIT']][$row['SEX']] = $row['JMLPASIEN'];
			 */
			
			//rowsdata
			if(isset($newArray[$row['KD_PENYAKIT']][$row['SEX']]['TOTAL']))
				$newArray[$row['KD_PENYAKIT']][$row['SEX']]['TOTAL'] = $newArray[$row['KD_PENYAKIT']][$row['SEX']]['TOTAL'] + $row['JMLPASIEN'];			
			else
				$newArray[$row['KD_PENYAKIT']][$row['SEX']]['TOTAL'] = $row['JMLPASIEN'];			
						
		}
		/* echo "<pre>";
		print_r($newArray);
		echo "</pre>"; */
		$data['result'] = $newArray;	
		$this->load->view('reports/rpt_sepuluhbesarrujukpus_html',$data);
	}
	
	public function lapjknpus(){			
		$this->load->helper('beries_helper');
				
		if(isset($_GET['jenispt']) && ( ($_GET['jenispt'] == 'html') || ($_GET['jenispt'] == 'excel') )){
			$propinsi = $_GET['propinsi'];
			$kabupaten = $_GET['kabupaten'];
			$kecamatan = $_GET['kecamatan'];
			$puskesmas = $_GET['puskesmas'];
			//print_r($_GET);
			
			$_GET['from'] 	= date('Y-m-01', strtotime($_GET['from']));
			$_GET['to'] 	= date('Y-m-t', strtotime($_GET['to']));
			
			if($_GET['jenispt'] == 'excel'){
				$fileName = "Report_Rekap_Kunjungan_".date('Ymd').".xls";
				header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
				header("Content-Disposition: attachment; filename=".$fileName);  //File name extension was wrong
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private",false);
			}
			
			if($puskesmas != '0'){
				$this->lapjknpus_temp();
			}elseif($puskesmas == 0 && $kecamatan > 0){
				//echo "Pilih Puskesmas";				
			}elseif($puskesmas == 0 && $kecamatan == 0 && $kabupaten > 0){
				$this->lapjknkab_temp();
			}elseif($puskesmas == 0 && $kecamatan == 0 && $kabupaten == 0 && $propinsi > 0){
				$this->lapjknprov_temp();
			}else{
				$this->lapjknnasional_temp();
			}
			
		}else{
			$this->load->view('reports/rpt_lapjkn');		
		}
		
	}
	
	public function lapjknnasional_temp(){
		$from = $this->input->get('from');	//print_r($from);die;
		$to = $this->input->get('to'); //print_r($to);die;
		
		$data['FROM'] = $from;
		$data['TO'] = $to;
		
		$propinsi = $this->input->get('propinsi'); //print_r($propinsi);die;
		$db = $this->load->database('sikda', TRUE);
		
		$sql = "SELECT v.KD_PROVINSI, v.PROVINSI, k.KD_KABUPATEN, p.KD_PUSKESMAS, p.PUSKESMAS, g.KD_LAYANAN_B, count(g.KD_PASIEN) AS PASIEN, e.KD_JENIS_KELAMIN
				FROM mst_provinsi v
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
				LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
				LEFT JOIN kunjungan g ON g.KD_PUSKESMAS = p.KD_PUSKESMAS
				LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN
				WHERE 1=1
				AND g.TGL_MASUK >= '".$from."'
				AND g.TGL_MASUK <= '".$to."'
				AND g.KD_PASIEN IS NOT NULL
				GROUP BY k.KD_PROVINSI, p.KD_PUSKESMAS, e.KD_JENIS_KELAMIN;";
				
		$query = $db->query($sql);
		$dataPasien = $db->query($sql)->result_array();
				
		$arrDatakab = array();
		foreach($dataPasien as $value){
			//$arrDatakab[$value['KD_KABUPATEN']][$value['KD_LAYANAN_B']][$value['KD_JENIS_KELAMIN']] = $value;
			if($value['KD_JENIS_KELAMIN'] == 'L'){
				if(isset($arrDatakab[$value['KD_PROVINSI']][$value['KD_LAYANAN_B']]['L']['PASIEN']))
					$arrDatakab[$value['KD_PROVINSI']][$value['KD_LAYANAN_B']]['L']['PASIEN'] += $value['PASIEN'];
				else
					$arrDatakab[$value['KD_PROVINSI']][$value['KD_LAYANAN_B']]['L']['PASIEN'] = $value['PASIEN'];
			}
			
			if($value['KD_JENIS_KELAMIN'] == 'P'){
				if(isset($arrDatakab[$value['KD_PROVINSI']][$value['KD_LAYANAN_B']]['P']['PASIEN']))
					$arrDatakab[$value['KD_PROVINSI']][$value['KD_LAYANAN_B']]['P']['PASIEN'] += $value['PASIEN'];
				else
					$arrDatakab[$value['KD_PROVINSI']][$value['KD_LAYANAN_B']]['P']['PASIEN'] = $value['PASIEN'];
			}
				
		}
		
		$sql ="SELECT v.KD_PROVINSI, v.PROVINSI, k.KD_KABUPATEN, p.KD_PUSKESMAS, g.Type, g.KD_LAYANAN_B, count(g.KD_PASIEN) AS PASIEN, g.KD_JENIS_KELAMIN, g.KD_UNIT 
				FROM mst_provinsi v 
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI 
				LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN 
				LEFT JOIN (
							SELECT 'kunjungan_bumil' AS Type, g.KD_PUSKESMAS, g.KD_LAYANAN_B, g.KD_PASIEN, e.KD_JENIS_KELAMIN, g.KD_UNIT
							FROM kunjungan g
							LEFT JOIN kunjungan_bumil b ON b.KD_PASIEN = g.KD_PASIEN 
							LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN 
							WHERE 1=1
							AND b.TANGGAL_KUNJUNGAN = g.TGL_MASUK
							AND g.KD_PASIEN IS NOT NULL 
							AND g.STATUS = '1' 
							AND g.TGL_MASUK >= '".$from."'
							AND g.TGL_MASUK <= '".$to."'
							
							UNION
							
							SELECT 'kunjungan_nifas' AS Type, g.KD_PUSKESMAS, g.KD_LAYANAN_B, g.KD_PASIEN, e.KD_JENIS_KELAMIN, g.KD_UNIT
							FROM kunjungan g
							LEFT JOIN kunjungan_nifas b ON b.KD_PASIEN = g.KD_PASIEN 
							LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN 
							WHERE 1=1
							AND b.TANGGAL_KUNJUNGAN = g.TGL_MASUK
							AND g.KD_PASIEN IS NOT NULL 
							AND g.STATUS = '1' 
							AND g.TGL_MASUK >= '".$from."'
							AND g.TGL_MASUK <= '".$to."'
							
							UNION
							
							SELECT 'kunjungan_bersalin' AS Type, g.KD_PUSKESMAS, g.KD_LAYANAN_B, g.KD_PASIEN, e.KD_JENIS_KELAMIN, g.KD_UNIT
							FROM kunjungan g
							LEFT JOIN kunjungan_bersalin b ON b.KD_PASIEN = g.KD_PASIEN 
							LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN 
							WHERE 1=1
							AND b.TANGGAL_PERSALINAN = g.TGL_MASUK
							AND g.KD_PASIEN IS NOT NULL 
							AND g.STATUS = '1' 
							AND g.TGL_MASUK >= '".$from."'
							AND g.TGL_MASUK <= '".$to."'
							
							UNION
							
							SELECT 'kunjungan_kb' AS Type, g.KD_PUSKESMAS, g.KD_LAYANAN_B, g.KD_PASIEN, e.KD_JENIS_KELAMIN, g.KD_UNIT
							FROM kunjungan g
							LEFT JOIN kunjungan_kb b ON b.KD_PASIEN = g.KD_PASIEN 
							LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN 
							WHERE 1=1
							AND b.TANGGAL = g.TGL_MASUK
							AND g.KD_PASIEN IS NOT NULL 
							AND g.STATUS = '1' 
							AND g.TGL_MASUK >= '".$from."'
							AND g.TGL_MASUK <= '".$to."'
							
							UNION
							
							SELECT 'pel_rujuk_pasien' AS Type, g.KD_PUSKESMAS, g.KD_LAYANAN_B, g.KD_PASIEN, e.KD_JENIS_KELAMIN, g.KD_UNIT
							FROM kunjungan g
							LEFT JOIN pel_rujuk_pasien b ON b.KD_PASIEN = g.KD_PASIEN 
							LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN 
							WHERE 1=1
							AND b.ninput_tgl = g.TGL_MASUK
							AND g.KD_PASIEN IS NOT NULL 
							AND g.STATUS = '1' 
							AND g.TGL_MASUK >= '".$from."'
							AND g.TGL_MASUK <= '".$to."'
							
							)g ON g.KD_PUSKESMAS = p.KD_PUSKESMAS 
				WHERE 1=1 
				AND g.Type IS NOT NULL
				GROUP BY v.KD_PROVINSI, p.KD_PUSKESMAS, g.KD_UNIT, g.Type, g.KD_LAYANAN_B;";
				
		$query = $db->query($sql);
		$dataPasien = $db->query($sql)->result_array();
				
		foreach($dataPasien as $value){
			
			if($value['KD_JENIS_KELAMIN'] == 'L'){
				if(isset($arrDatakab[$value['KD_PROVINSI']][$value['Type']]['L']['PASIEN']))
					$arrDatakab[$value['KD_PROVINSI']][$value['Type']]['L']['PASIEN'] += $value['PASIEN'];
				else
					$arrDatakab[$value['KD_PROVINSI']][$value['Type']]['L']['PASIEN'] = $value['PASIEN'];
			}
			
			if($value['KD_JENIS_KELAMIN'] == 'P'){
				if(isset($arrDatakab[$value['KD_PROVINSI']][$value['Type']]['P']['PASIEN']))
					$arrDatakab[$value['KD_PROVINSI']][$value['Type']]['P']['PASIEN'] += $value['PASIEN'];
				else
					$arrDatakab[$value['KD_PROVINSI']][$value['Type']]['P']['PASIEN'] = $value['PASIEN'];
			}
				
			//$arrDatakab[$value['KD_KABUPATEN']][$value['Type']][$value['KD_UNIT']][$value['KD_JENIS_KELAMIN']] = $value;
		}
		
		$sql = "SELECT v.KD_PROVINSI, v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN
				FROM mst_provinsi v
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
				WHERE 1=1
				GROUP BY k.KD_PROVINSI";
				
		$query = $db->query($sql);
		$result = $db->query($sql)->result_array(); //print_r($data);die;
		
		$data['PROPINSI'] = $result[0]['PROVINSI'];
		$newData = array();
		foreach($result as $value){
			
			//inisialisasi
			/* $newData[$value['KD_KABUPATEN']]['PROPINSI'] = $value['PROVINSI']; */
			$newData[$value['KD_PROVINSI']]['PROVINSI'] = $value['PROVINSI'];
			
			//rawat jalan
			$newData[$value['KD_PROVINSI']]['RJ']['L'] = isset($arrDatakab[$value['KD_PROVINSI']]['RJ']['L'])?$arrDatakab[$value['KD_PROVINSI']]['RJ']['L']['PASIEN']:0;
			$newData[$value['KD_PROVINSI']]['RJ']['P'] = isset($arrDatakab[$value['KD_PROVINSI']]['RJ']['L'])?$arrDatakab[$value['KD_PROVINSI']]['RJ']['P']['PASIEN']:0;
			
			//rawat inap
			$newData[$value['KD_PROVINSI']]['RI']['L'] = isset($arrDatakab[$value['KD_PROVINSI']]['RI']['L'])?$arrDatakab[$value['KD_PROVINSI']]['RI']['L']['PASIEN']:0;
			$newData[$value['KD_PROVINSI']]['RI']['P'] = isset($arrDatakab[$value['KD_PROVINSI']]['RI']['L'])?$arrDatakab[$value['KD_PROVINSI']]['RI']['P']['PASIEN']:0;
			
			//rawat bersalin
			$newData[$value['KD_PROVINSI']]['B']['ANC'] = isset($arrDatakab[$value['KD_PROVINSI']]['kunjungan_bumil'])?$arrDatakab[$value['KD_PROVINSI']]['kunjungan_bumil']['P']['PASIEN']:0;
			$newData[$value['KD_PROVINSI']]['B']['PNC'] = isset($arrDatakab[$value['KD_PROVINSI']]['kunjungan_nifas'])?$arrDatakab[$value['KD_PROVINSI']]['kunjungan_nifas']['P']['PASIEN']:0;
			$newData[$value['KD_PROVINSI']]['B']['NORMAL'] = isset($arrDatakab[$value['KD_PROVINSI']]['kunjungan_bersalin'])?$arrDatakab[$value['KD_PROVINSI']]['kunjungan_bersalin']['P']['PASIEN']:0;
			
			//KB
			$newData[$value['KD_PROVINSI']]['KB'] = isset($arrDatakab[$value['KD_PROVINSI']]['kb'])?$arrDatakab[$value['KD_PROVINSI']]['kb']['P']['PASIEN']:0;;
			
			
			//DIRUJUK
			$dirujukL = isset($arrDatakab[$value['KD_PROVINSI']]['pel_rujuk_pasien']['L'])?$arrDatakab[$value['KD_PROVINSI']]['pel_rujuk_pasien']['L']['PASIEN']:0;
			$dirujukP = isset($arrDatakab[$value['KD_PROVINSI']]['pel_rujuk_pasien']['P'])?$arrDatakab[$value['KD_PROVINSI']]['pel_rujuk_pasien']['P']['PASIEN']:0;
			$newData[$value['KD_PROVINSI']]['DIRUJUK'] = $dirujukL+$dirujukP;
			
			//DIRUJUKBALIK
			$newData[$value['KD_PROVINSI']]['DIRUJUKBALIK'] = isset($arrDatakab[$value['KD_PROVINSI']]['DIRUJUKBALIK'])?$arrDatakab[$value['KD_PROVINSI']]['DIRUJUKBALIK']['P']['PASIEN']:0;
		}
		
		//-------------------start data agregat---------------------//
		$sql = "SELECT v.KD_PROVINSI, v.PROVINSI, k.KD_KABUPATEN, p.KD_PUSKESMAS, p.PUSKESMAS, g.RawatJalanL
				,g.RawatJalanP ,g.RawatInapL, g.RawatInapP, g.KIA_ANC, g.KIA_PNC, g.KIA_NORMAL, g.KB, g.DIRUJUK, g.RUJUKBALIK
				FROM mst_provinsi v
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
				LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
				LEFT JOIN laporan_agregat g ON g.kode_puskesmas = p.KD_PUSKESMAS
				WHERE 1=1
				AND g.month >= '".$from."'
				AND g.month <= '".$to."'
				GROUP BY k.KD_PROVINSI, p.KD_PUSKESMAS";
		
		$result = $db->query($sql)->result_array();// print_r($result);die;
		
		foreach($result as $value){			
			//rawat jalan
			$newData[$value['KD_PROVINSI']]['RJ']['L'] += $value['RawatJalanL'];
			$newData[$value['KD_PROVINSI']]['RJ']['P'] += $value['RawatJalanP'];
			
			//rawat inap
			$newData[$value['KD_PROVINSI']]['RI']['L'] += $value['RawatInapL'];
			$newData[$value['KD_PROVINSI']]['RI']['P'] += $value['RawatInapP'];
			
			//rawat bersalin
			$newData[$value['KD_PROVINSI']]['B']['ANC'] += $value['KIA_ANC'];
			$newData[$value['KD_PROVINSI']]['B']['PNC'] += $value['KIA_PNC'];
			$newData[$value['KD_PROVINSI']]['B']['NORMAL'] += $value['KIA_NORMAL'];
			
			//KB
			$newData[$value['KD_PROVINSI']]['KB'] += $value['KB'];
					
			//DIRUJUK			
			$newData[$value['KD_PROVINSI']]['DIRUJUK'] += $value['DIRUJUK'];
			
			//DIRUJUKBALIK
			$newData[$value['KD_PROVINSI']]['DIRUJUKBALIK'] += $value['RUJUKBALIK'];
		}
		//-------------------end   data agregat---------------------//
		
		$data['result'] = $newData;
		$this->load->view('reports/rpt_lapjknnas_temp', $data);
	}
	
	public function lapjknprov_temp(){
		$from = $this->input->get('from');	//print_r($from);die;
		$to = $this->input->get('to'); //print_r($to);die;
		
		$data['FROM'] = $from;
		$data['TO'] = $to;
		
		$propinsi = $this->input->get('propinsi'); //print_r($propinsi);die;
		$db = $this->load->database('sikda', TRUE);
		
		$sql = "SELECT k.KD_KABUPATEN, p.KD_PUSKESMAS, p.PUSKESMAS, g.KD_LAYANAN_B, count(g.KD_PASIEN) AS PASIEN, e.KD_JENIS_KELAMIN
				FROM mst_provinsi v
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
				LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
				LEFT JOIN kunjungan g ON g.KD_PUSKESMAS = p.KD_PUSKESMAS
				LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN
				WHERE v.KD_PROVINSI = '".$propinsi."'
				AND g.TGL_MASUK >= '".$from."'
				AND g.TGL_MASUK <= '".$to."'
				AND g.KD_PASIEN IS NOT NULL
				GROUP BY k.KD_KABUPATEN, p.KD_PUSKESMAS, e.KD_JENIS_KELAMIN;";
		$query = $db->query($sql);
		$dataPasien = $db->query($sql)->result_array();
				
		$arrDatakab = array();
		foreach($dataPasien as $value){
			//$arrDatakab[$value['KD_KABUPATEN']][$value['KD_LAYANAN_B']][$value['KD_JENIS_KELAMIN']] = $value;
			if($value['KD_JENIS_KELAMIN'] == 'L'){
				if(isset($arrDatakab[$value['KD_KABUPATEN']][$value['KD_LAYANAN_B']]['L']['PASIEN']))
					$arrDatakab[$value['KD_KABUPATEN']][$value['KD_LAYANAN_B']]['L']['PASIEN'] += $value['PASIEN'];
				else
					$arrDatakab[$value['KD_KABUPATEN']][$value['KD_LAYANAN_B']]['L']['PASIEN'] = $value['PASIEN'];
			}
			
			if($value['KD_JENIS_KELAMIN'] == 'P'){
				if(isset($arrDatakab[$value['KD_KABUPATEN']][$value['KD_LAYANAN_B']]['P']['PASIEN']))
					$arrDatakab[$value['KD_KABUPATEN']][$value['KD_LAYANAN_B']]['P']['PASIEN'] += $value['PASIEN'];
				else
					$arrDatakab[$value['KD_KABUPATEN']][$value['KD_LAYANAN_B']]['P']['PASIEN'] = $value['PASIEN'];
			}
				
		}
		
		$sql ="SELECT k.KD_KABUPATEN, p.KD_PUSKESMAS, g.Type, g.KD_LAYANAN_B, count(g.KD_PASIEN) AS PASIEN, g.KD_JENIS_KELAMIN, g.KD_UNIT 
				FROM mst_provinsi v 
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI 
				LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN 
				LEFT JOIN (
							SELECT 'kunjungan_bumil' AS Type, g.KD_PUSKESMAS, g.KD_LAYANAN_B, g.KD_PASIEN, e.KD_JENIS_KELAMIN, g.KD_UNIT
							FROM kunjungan g
							LEFT JOIN kunjungan_bumil b ON b.KD_PASIEN = g.KD_PASIEN 
							LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN 
							WHERE 1=1
							AND b.TANGGAL_KUNJUNGAN = g.TGL_MASUK
							AND g.KD_PASIEN IS NOT NULL 
							AND g.STATUS = '1' 
							AND g.TGL_MASUK >= '".$from."'
							AND g.TGL_MASUK <= '".$to."'
							
							UNION
							
							SELECT 'kunjungan_nifas' AS Type, g.KD_PUSKESMAS, g.KD_LAYANAN_B, g.KD_PASIEN, e.KD_JENIS_KELAMIN, g.KD_UNIT
							FROM kunjungan g
							LEFT JOIN kunjungan_nifas b ON b.KD_PASIEN = g.KD_PASIEN 
							LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN 
							WHERE 1=1
							AND b.TANGGAL_KUNJUNGAN = g.TGL_MASUK
							AND g.KD_PASIEN IS NOT NULL 
							AND g.STATUS = '1' 
							AND g.TGL_MASUK >= '".$from."'
							AND g.TGL_MASUK <= '".$to."'
							
							UNION
							
							SELECT 'kunjungan_bersalin' AS Type, g.KD_PUSKESMAS, g.KD_LAYANAN_B, g.KD_PASIEN, e.KD_JENIS_KELAMIN, g.KD_UNIT
							FROM kunjungan g
							LEFT JOIN kunjungan_bersalin b ON b.KD_PASIEN = g.KD_PASIEN 
							LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN 
							WHERE 1=1
							AND b.TANGGAL_PERSALINAN = g.TGL_MASUK
							AND g.KD_PASIEN IS NOT NULL 
							AND g.STATUS = '1' 
							AND g.TGL_MASUK >= '".$from."'
							AND g.TGL_MASUK <= '".$to."'
							
							UNION
							
							SELECT 'kunjungan_kb' AS Type, g.KD_PUSKESMAS, g.KD_LAYANAN_B, g.KD_PASIEN, e.KD_JENIS_KELAMIN, g.KD_UNIT
							FROM kunjungan g
							LEFT JOIN kunjungan_kb b ON b.KD_PASIEN = g.KD_PASIEN 
							LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN 
							WHERE 1=1
							AND b.TANGGAL = g.TGL_MASUK
							AND g.KD_PASIEN IS NOT NULL 
							AND g.STATUS = '1' 
							AND g.TGL_MASUK >= '".$from."'
							AND g.TGL_MASUK <= '".$to."'
							
							UNION
							
							SELECT 'pel_rujuk_pasien' AS Type, g.KD_PUSKESMAS, g.KD_LAYANAN_B, g.KD_PASIEN, e.KD_JENIS_KELAMIN, g.KD_UNIT
							FROM kunjungan g
							LEFT JOIN pel_rujuk_pasien b ON b.KD_PASIEN = g.KD_PASIEN 
							LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN 
							WHERE 1=1
							AND b.ninput_tgl = g.TGL_MASUK
							AND g.KD_PASIEN IS NOT NULL 
							AND g.STATUS = '1' 
							AND g.TGL_MASUK >= '".$from."'
							AND g.TGL_MASUK <= '".$to."'
							
							)g ON g.KD_PUSKESMAS = p.KD_PUSKESMAS 
				WHERE 1=1 
				AND v.KD_PROVINSI = '".$propinsi."'
				AND g.Type IS NOT NULL
				GROUP BY k.KD_KABUPATEN, p.KD_PUSKESMAS, g.KD_UNIT, g.Type, g.KD_LAYANAN_B;";
				
		$query = $db->query($sql);
		$dataPasien = $db->query($sql)->result_array();
				
		foreach($dataPasien as $value){
			
			if($value['KD_JENIS_KELAMIN'] == 'L'){
				if(isset($arrDatakab[$value['KD_KABUPATEN']][$value['Type']]['L']['PASIEN']))
					$arrDatakab[$value['KD_KABUPATEN']][$value['Type']]['L']['PASIEN'] += $value['PASIEN'];
				else
					$arrDatakab[$value['KD_KABUPATEN']][$value['Type']]['L']['PASIEN'] = $value['PASIEN'];
			}
			
			if($value['KD_JENIS_KELAMIN'] == 'P'){
				if(isset($arrDatakab[$value['KD_KABUPATEN']][$value['Type']]['P']['PASIEN']))
					$arrDatakab[$value['KD_KABUPATEN']][$value['Type']]['P']['PASIEN'] += $value['PASIEN'];
				else
					$arrDatakab[$value['KD_KABUPATEN']][$value['Type']]['P']['PASIEN'] = $value['PASIEN'];
			}
				
			//$arrDatakab[$value['KD_KABUPATEN']][$value['Type']][$value['KD_UNIT']][$value['KD_JENIS_KELAMIN']] = $value;
		}
		
		$sql = "SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN
				FROM mst_provinsi v
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
				WHERE v.KD_PROVINSI = '".$propinsi."'
				GROUP BY k.KD_KABUPATEN";
				
		$query = $db->query($sql);
		$result = $db->query($sql)->result_array(); //print_r($data);die;
		
		$data['PROPINSI'] = $result[0]['PROVINSI'];
		$newData = array();
		foreach($result as $value){
			
			//inisialisasi
			/* $newData[$value['KD_KABUPATEN']]['PROPINSI'] = $value['PROVINSI']; */
			$newData[$value['KD_KABUPATEN']]['KABUPATEN'] = $value['KABUPATEN'];
			
			//rawat jalan
			$newData[$value['KD_KABUPATEN']]['RJ']['L'] = isset($arrDatakab[$value['KD_KABUPATEN']]['RJ']['L'])?$arrDatakab[$value['KD_KABUPATEN']]['RJ']['L']['PASIEN']:0;
			$newData[$value['KD_KABUPATEN']]['RJ']['P'] = isset($arrDatakab[$value['KD_KABUPATEN']]['RJ']['L'])?$arrDatakab[$value['KD_KABUPATEN']]['RJ']['P']['PASIEN']:0;
			
			//rawat inap
			$newData[$value['KD_KABUPATEN']]['RI']['L'] = isset($arrDatakab[$value['KD_KABUPATEN']]['RI']['L'])?$arrDatakab[$value['KD_KABUPATEN']]['RI']['L']['PASIEN']:0;
			$newData[$value['KD_KABUPATEN']]['RI']['P'] = isset($arrDatakab[$value['KD_KABUPATEN']]['RI']['L'])?$arrDatakab[$value['KD_KABUPATEN']]['RI']['P']['PASIEN']:0;
			
			//rawat bersalin
			$newData[$value['KD_KABUPATEN']]['B']['ANC'] = isset($arrDatakab[$value['KD_KABUPATEN']]['kunjungan_bumil'])?$arrDatakab[$value['KD_KABUPATEN']]['kunjungan_bumil']['P']['PASIEN']:0;
			$newData[$value['KD_KABUPATEN']]['B']['PNC'] = isset($arrDatakab[$value['KD_KABUPATEN']]['kunjungan_nifas'])?$arrDatakab[$value['KD_KABUPATEN']]['kunjungan_nifas']['P']['PASIEN']:0;
			$newData[$value['KD_KABUPATEN']]['B']['NORMAL'] = isset($arrDatakab[$value['KD_KABUPATEN']]['kunjungan_bersalin'])?$arrDatakab[$value['KD_KABUPATEN']]['kunjungan_bersalin']['P']['PASIEN']:0;
			
			//KB
			$newData[$value['KD_KABUPATEN']]['KB'] = isset($arrDatakab[$value['KD_KABUPATEN']]['kb'])?$arrDatakab[$value['KD_KABUPATEN']]['kb']['P']['PASIEN']:0;;
			
			
			//DIRUJUK
			$dirujukL = isset($arrDatakab[$value['KD_KABUPATEN']]['pel_rujuk_pasien']['L'])?$arrDatakab[$value['KD_KABUPATEN']]['pel_rujuk_pasien']['L']['PASIEN']:0;
			$dirujukP = isset($arrDatakab[$value['KD_KABUPATEN']]['pel_rujuk_pasien']['P'])?$arrDatakab[$value['KD_KABUPATEN']]['pel_rujuk_pasien']['P']['PASIEN']:0;
			$newData[$value['KD_KABUPATEN']]['DIRUJUK'] = $dirujukL+$dirujukP;
			
			//DIRUJUKBALIK
			$newData[$value['KD_KABUPATEN']]['DIRUJUKBALIK'] = isset($arrDatakab[$value['KD_KABUPATEN']]['DIRUJUKBALIK'])?$arrDatakab[$value['KD_KABUPATEN']]['DIRUJUKBALIK']['P']['PASIEN']:0;
		}
		
		//-------------------start data agregat---------------------//
		$sql = "SELECT k.KD_KABUPATEN, p.KD_PUSKESMAS, p.PUSKESMAS, g.RawatJalanL
				,g.RawatJalanP ,g.RawatInapL, g.RawatInapP, g.KIA_ANC, g.KIA_PNC, g.KIA_NORMAL, g.KB, g.DIRUJUK, g.RUJUKBALIK
				FROM mst_provinsi v
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
				LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
				LEFT JOIN laporan_agregat g ON g.kode_puskesmas = p.KD_PUSKESMAS
				WHERE v.KD_PROVINSI = '".$propinsi."'
				AND g.month >= '".$from."'
				AND g.month <= '".$to."'
				GROUP BY k.KD_KABUPATEN, p.KD_PUSKESMAS";
		
		$result = $db->query($sql)->result_array();// print_r($result);die;
		
		foreach($result as $value){			
			//rawat jalan
			$newData[$value['KD_KABUPATEN']]['RJ']['L'] += $value['RawatJalanL'];
			$newData[$value['KD_KABUPATEN']]['RJ']['P'] += $value['RawatJalanP'];
			
			//rawat inap
			$newData[$value['KD_KABUPATEN']]['RI']['L'] += $value['RawatInapL'];
			$newData[$value['KD_KABUPATEN']]['RI']['P'] += $value['RawatInapP'];
			
			//rawat bersalin
			$newData[$value['KD_KABUPATEN']]['B']['ANC'] += $value['KIA_ANC'];
			$newData[$value['KD_KABUPATEN']]['B']['PNC'] += $value['KIA_PNC'];
			$newData[$value['KD_KABUPATEN']]['B']['NORMAL'] += $value['KIA_NORMAL'];
			
			//KB
			$newData[$value['KD_KABUPATEN']]['KB'] += $value['KB'];
					
			//DIRUJUK			
			$newData[$value['KD_KABUPATEN']]['DIRUJUK'] += $value['DIRUJUK'];
			
			//DIRUJUKBALIK
			$newData[$value['KD_KABUPATEN']]['DIRUJUKBALIK'] += $value['RUJUKBALIK'];
		}
		//-------------------end   data agregat---------------------//
		
		$data['result'] = $newData;		
		$this->load->view('reports/rpt_lapjknprov_temp', $data);
	}
	
	public function lapjknkab_temp(){
		$from = $this->input->get('from');	//print_r($from);die;
		$to = $this->input->get('to'); //print_r($to);die;
		
		$data['FROM'] = $from;
		$data['TO'] = $to;
		
		$propinsi = $this->input->get('propinsi'); //print_r($propinsi);die;
		$kabupaten = $this->input->get('kabupaten'); //print_r($propinsi);die;
		
		$db = $this->load->database('sikda', TRUE);
		
		$sql = "SELECT k.KD_KABUPATEN, p.KD_PUSKESMAS, p.PUSKESMAS, g.KD_LAYANAN_B, count(g.KD_PASIEN) AS PASIEN, e.KD_JENIS_KELAMIN
				FROM mst_provinsi v
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
				LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
				LEFT JOIN kunjungan g ON g.KD_PUSKESMAS = p.KD_PUSKESMAS
				LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN
				WHERE v.KD_PROVINSI = '".$propinsi."'
				AND k.KD_KABUPATEN = '".$kabupaten."'
				AND g.TGL_MASUK >= '".$from."'
				AND g.TGL_MASUK <= '".$to."'
				AND g.KD_PASIEN IS NOT NULL
				GROUP BY k.KD_KABUPATEN, p.KD_PUSKESMAS, e.KD_JENIS_KELAMIN;";
		
		$query = $db->query($sql);
		$dataPasien = $db->query($sql)->result_array();
				
		$arrDatakab = array();
		foreach($dataPasien as $value){
			$arrDatakab[$value['KD_PUSKESMAS']][$value['KD_LAYANAN_B']][$value['KD_JENIS_KELAMIN']] = $value;
		}
		
		$sql ="
				SELECT k.KD_KABUPATEN, p.KD_PUSKESMAS, p.PUSKESMAS, g.Type, g.KD_LAYANAN_B, count(g.KD_PASIEN) AS PASIEN, g.KD_JENIS_KELAMIN, g.KD_UNIT 
				FROM mst_provinsi v 
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI 
				LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN 
				LEFT JOIN (
							SELECT 'kunjungan_bumil' AS Type, g.KD_PUSKESMAS, g.KD_LAYANAN_B, g.KD_PASIEN, e.KD_JENIS_KELAMIN, g.KD_UNIT
							FROM kunjungan g
							LEFT JOIN kunjungan_bumil b ON b.KD_PASIEN = g.KD_PASIEN 
							LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN 
							WHERE 1=1
							AND b.TANGGAL_KUNJUNGAN = g.TGL_MASUK
							AND g.KD_PASIEN IS NOT NULL 
							AND g.STATUS = '1' 
							AND g.TGL_MASUK >= '".$from."'
							AND g.TGL_MASUK <= '".$to."'
							
							UNION
							
							SELECT 'kunjungan_nifas' AS Type, g.KD_PUSKESMAS, g.KD_LAYANAN_B, g.KD_PASIEN, e.KD_JENIS_KELAMIN, g.KD_UNIT
							FROM kunjungan g
							LEFT JOIN kunjungan_nifas b ON b.KD_PASIEN = g.KD_PASIEN 
							LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN 
							WHERE 1=1
							AND b.TANGGAL_KUNJUNGAN = g.TGL_MASUK
							AND g.KD_PASIEN IS NOT NULL 
							AND g.STATUS = '1' 
							AND g.TGL_MASUK >= '".$from."'
							AND g.TGL_MASUK <= '".$to."'
							
							UNION
							
							SELECT 'kunjungan_bersalin' AS Type, g.KD_PUSKESMAS, g.KD_LAYANAN_B, g.KD_PASIEN, e.KD_JENIS_KELAMIN, g.KD_UNIT
							FROM kunjungan g
							LEFT JOIN kunjungan_bersalin b ON b.KD_PASIEN = g.KD_PASIEN 
							LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN 
							WHERE 1=1
							AND b.TANGGAL_PERSALINAN = g.TGL_MASUK
							AND g.KD_PASIEN IS NOT NULL 
							AND g.STATUS = '1' 
							AND g.TGL_MASUK >= '".$from."'
							AND g.TGL_MASUK <= '".$to."'
							
							UNION
							
							SELECT 'kunjungan_kb' AS Type, g.KD_PUSKESMAS, g.KD_LAYANAN_B, g.KD_PASIEN, e.KD_JENIS_KELAMIN, g.KD_UNIT
							FROM kunjungan g
							LEFT JOIN kunjungan_kb b ON b.KD_PASIEN = g.KD_PASIEN 
							LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN 
							WHERE 1=1
							AND b.TANGGAL = g.TGL_MASUK
							AND g.KD_PASIEN IS NOT NULL 
							AND g.STATUS = '1' 
							AND g.TGL_MASUK >= '".$from."'
							AND g.TGL_MASUK <= '".$to."'
							
							UNION
							
							SELECT 'pel_rujuk_pasien' AS Type, g.KD_PUSKESMAS, g.KD_LAYANAN_B, g.KD_PASIEN, e.KD_JENIS_KELAMIN, g.KD_UNIT
							FROM kunjungan g
							LEFT JOIN pel_rujuk_pasien b ON b.KD_PASIEN = g.KD_PASIEN 
							LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN 
							WHERE 1=1
							AND b.ninput_tgl = g.TGL_MASUK
							AND g.KD_PASIEN IS NOT NULL 
							AND g.STATUS = '1' 
							AND g.TGL_MASUK >= '".$from."'
							AND g.TGL_MASUK <= '".$to."'	
							
							)g ON g.KD_PUSKESMAS = p.KD_PUSKESMAS 
				WHERE 1=1 
				AND v.KD_PROVINSI = '".$propinsi."'
				AND k.KD_KABUPATEN = '".$kabupaten."'
				AND g.Type IS NOT NULL
				GROUP BY k.KD_KABUPATEN, p.KD_PUSKESMAS, g.KD_UNIT, g.Type, g.KD_LAYANAN_B
		";
		$query = $db->query($sql);
		$dataPasien = $db->query($sql)->result_array(); //print_r($data);die;
				
		foreach($dataPasien as $value){
			$arrDatakab[$value['KD_PUSKESMAS']][$value['Type']][$value['KD_JENIS_KELAMIN']] = $value;
		}
		
		$sql = "SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN, p.KD_PUSKESMAS, p.PUSKESMAS
				FROM mst_provinsi v
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
				LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
				WHERE v.KD_PROVINSI = '".$propinsi."'
				AND k.KD_KABUPATEN = '".$kabupaten."'
				GROUP BY k.KD_KABUPATEN, p.KD_PUSKESMAS";
				
		$query = $db->query($sql);
		$dataPasien = $db->query($sql)->result_array(); //print_r($data);die;
		
		$data['PROPINSI'] = $dataPasien[0]['PROVINSI'];
		$data['KABUPATEN'] = $dataPasien[0]['KABUPATEN'];
		
		$newData = array();
		foreach($dataPasien as $value){
			
			//inisialisasi
			$newData[$value['KD_PUSKESMAS']]['PROPINSI'] = $value['PROVINSI'];
			$newData[$value['KD_PUSKESMAS']]['KABUPATEN'] = $value['KABUPATEN'];
			$newData[$value['KD_PUSKESMAS']]['PUSKESMAS'] = $value['PUSKESMAS'];
			
			//rawat jalan
			$newData[$value['KD_PUSKESMAS']]['RJ']['L'] = isset($arrDatakab[$value['KD_PUSKESMAS']]['RJ']['L'])?$arrDatakab[$value['KD_PUSKESMAS']]['RJ']['L']['PASIEN']:0;
			$newData[$value['KD_PUSKESMAS']]['RJ']['P'] = isset($arrDatakab[$value['KD_PUSKESMAS']]['RJ']['L'])?$arrDatakab[$value['KD_PUSKESMAS']]['RJ']['P']['PASIEN']:0;
			
			//rawat inap
			$newData[$value['KD_PUSKESMAS']]['RI']['L'] = isset($arrDatakab[$value['KD_PUSKESMAS']]['RI']['L'])?$arrDatakab[$value['KD_PUSKESMAS']]['RI']['L']['PASIEN']:0;
			$newData[$value['KD_PUSKESMAS']]['RI']['P'] = isset($arrDatakab[$value['KD_PUSKESMAS']]['RI']['L'])?$arrDatakab[$value['KD_PUSKESMAS']]['RI']['P']['PASIEN']:0;
			
			//rawat bersalin
			$newData[$value['KD_PUSKESMAS']]['B']['ANC'] = isset($arrDatakab[$value['KD_PUSKESMAS']]['kunjungan_bumil']['P'])?$arrDatakab[$value['KD_PUSKESMAS']]['kunjungan_bumil']['P']['PASIEN']:0;
			$newData[$value['KD_PUSKESMAS']]['B']['PNC'] = isset($arrDatakab[$value['KD_PUSKESMAS']]['kunjungan_nifas']['P'])?$arrDatakab[$value['KD_PUSKESMAS']]['kunjungan_nifas']['P']['PASIEN']:0;
			$newData[$value['KD_PUSKESMAS']]['B']['NORMAL'] = isset($arrDatakab[$value['KD_PUSKESMAS']]['kunjungan_bersalin']['P'])?$arrDatakab[$value['KD_PUSKESMAS']]['kunjungan_bersalin']['P']['PASIEN']:0;
			
			//KB
			$newData[$value['KD_PUSKESMAS']]['KB'] = isset($arrDatakab[$value['KD_PUSKESMAS']]['kunjungan_kb'])?$arrDatakab[$value['KD_PUSKESMAS']]['kunjungan_kb']['P']['PASIEN']:0;
			
			//DIRUJUK
			$dirujukL = isset($arrDatakab[$value['KD_PUSKESMAS']]['pel_rujuk_pasien']['L'])?$arrDatakab[$value['KD_PUSKESMAS']]['pel_rujuk_pasien']['L']['PASIEN']:0;
			$dirujukP = isset($arrDatakab[$value['KD_PUSKESMAS']]['pel_rujuk_pasien']['P'])?$arrDatakab[$value['KD_PUSKESMAS']]['pel_rujuk_pasien']['P']['PASIEN']:0;
			$newData[$value['KD_PUSKESMAS']]['DIRUJUK'] = $dirujukL+$dirujukP;
			
			//DIRUJUKBALIK
			$newData[$value['KD_PUSKESMAS']]['DIRUJUKBALIK'] = 0;
			
		}
		
		
		//-------------------start data agregat---------------------//
		$sql = "SELECT k.KD_KABUPATEN, p.KD_PUSKESMAS, p.PUSKESMAS, g.RawatJalanL
				,g.RawatJalanP ,g.RawatInapL, g.RawatInapP, g.KIA_ANC, g.KIA_PNC, g.KIA_NORMAL, g.KB, g.DIRUJUK, g.RUJUKBALIK
				FROM mst_provinsi v
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
				LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
				LEFT JOIN laporan_agregat g ON g.kode_puskesmas = p.KD_PUSKESMAS
				WHERE v.KD_PROVINSI = '".$propinsi."'
				AND k.KD_KABUPATEN = '".$kabupaten."'
				AND g.month >= '".$from."'
				AND g.month <= '".$to."'
				GROUP BY k.KD_KABUPATEN, p.KD_PUSKESMAS";
		
		$result = $db->query($sql)->result_array();// print_r($result);die;
		
		foreach($result as $value){			
			//rawat jalan
			$newData[$value['KD_PUSKESMAS']]['RJ']['L'] += $value['RawatJalanL'];
			$newData[$value['KD_PUSKESMAS']]['RJ']['P'] += $value['RawatJalanP'];
			
			//rawat inap
			$newData[$value['KD_PUSKESMAS']]['RI']['L'] += $value['RawatInapL'];
			$newData[$value['KD_PUSKESMAS']]['RI']['P'] += $value['RawatInapP'];
			
			//rawat bersalin
			$newData[$value['KD_PUSKESMAS']]['B']['ANC'] += $value['KIA_ANC'];
			$newData[$value['KD_PUSKESMAS']]['B']['PNC'] += $value['KIA_PNC'];
			$newData[$value['KD_PUSKESMAS']]['B']['NORMAL'] += $value['KIA_NORMAL'];
			
			//KB
			$newData[$value['KD_PUSKESMAS']]['KB'] += $value['KB'];
					
			//DIRUJUK			
			$newData[$value['KD_PUSKESMAS']]['DIRUJUK'] += $value['DIRUJUK'];
			
			//DIRUJUKBALIK
			$newData[$value['KD_PUSKESMAS']]['DIRUJUKBALIK'] += $value['RUJUKBALIK'];
		}
		//-------------------end   data agregat---------------------//
		$data['result'] = $newData;
		$this->load->view('reports/rpt_lapjknkab_temp', $data);
		
	}

	public function lapjknpus_temp(){
		$from = $this->input->get('from');	//print_r($from);die;
		$to = $this->input->get('to'); //print_r($to);die;
		
		$data['FROM'] = $from;
		$data['TO'] = $to;
		
		$propinsi = $this->input->get('propinsi'); //print_r($propinsi);die;
		$kabupaten = $this->input->get('kabupaten'); //print_r($propinsi);die;
		$kecamatan = $this->input->get('kecamatan'); //print_r($propinsi);die;
		$puskesmas = $this->input->get('puskesmas'); //print_r($propinsi);die;
		$db = $this->load->database('sikda', TRUE);
		
		$sql = "SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN, p.KD_PUSKESMAS, p.PUSKESMAS
				FROM mst_provinsi v 
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI  
				LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN 
				WHERE 1=1 
				AND v.KD_PROVINSI = '".$propinsi."'
				AND k.KD_KABUPATEN = '".$kabupaten."'
				AND p.KD_PUSKESMAS = '".$puskesmas."'
				";
		$query = $db->query($sql);
		$result = $query->result_array();
		$data['PROPINSI'] = $result[0]['PROVINSI'];
		$data['KABUPATEN'] = $result[0]['KABUPATEN'];
		$data['KD_PUSKESMAS'] = $result[0]['KD_PUSKESMAS'];
		$data['PUSKESMAS'] = $result[0]['PUSKESMAS'];
		
		$sqlpuskesmas = ($puskesmas !='0') ? "AND p.KD_PUSKESMAS = '".$puskesmas."'":"";
		$sql = "SELECT k.KD_KABUPATEN, p.KD_PUSKESMAS, p.PUSKESMAS, g.KD_LAYANAN_B, g.TGL_MASUK, count(g.KD_PASIEN) AS PASIEN, e.KD_JENIS_KELAMIN
				FROM mst_provinsi v
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
				LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
				LEFT JOIN kunjungan g ON g.KD_PUSKESMAS = p.KD_PUSKESMAS
				LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN
				WHERE v.KD_PROVINSI = '".$propinsi."'
				AND k.KD_KABUPATEN = '".$kabupaten."'
				AND p.KD_KECAMATAN	 = '".$kecamatan."'
				".$sqlpuskesmas."
				AND g.TGL_MASUK >= '".$from."'
				AND g.TGL_MASUK <= '".$to."'
				AND g.KD_PASIEN IS NOT NULL
				GROUP BY g.TGL_MASUK;";
		
		$query = $db->query($sql);
		$dataPasien = $db->query($sql)->result_array();
		
		$arrDatakab = array();
		foreach($dataPasien as $value){
			$bulan = date('n', strtotime($value['TGL_MASUK']));
			$arrDatakab[$bulan][$value['KD_LAYANAN_B']][$value['KD_JENIS_KELAMIN']] = $value;
		}
		
		$sql ="
				SELECT k.KD_KABUPATEN, p.KD_PUSKESMAS, p.PUSKESMAS, g.Type, g.KD_LAYANAN_B, g.TGL_MASUK, count(g.KD_PASIEN) AS PASIEN, g.KD_JENIS_KELAMIN, g.KD_UNIT 
				FROM mst_provinsi v 
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI 
				LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN 
				LEFT JOIN (
							SELECT 'kunjungan_bumil' AS Type, g.TGL_MASUK, g.KD_PUSKESMAS, g.KD_LAYANAN_B, g.KD_PASIEN, e.KD_JENIS_KELAMIN, g.KD_UNIT
							FROM kunjungan g
							LEFT JOIN kunjungan_bumil b ON b.KD_PASIEN = g.KD_PASIEN 
							LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN 
							WHERE 1=1
							AND b.TANGGAL_KUNJUNGAN = g.TGL_MASUK
							AND g.KD_PASIEN IS NOT NULL 
							AND g.STATUS = '1' 
							AND g.TGL_MASUK >= '".$from."'
							AND g.TGL_MASUK <= '".$to."'
							
							UNION
							
							SELECT 'kunjungan_nifas' AS Type, g.TGL_MASUK, g.KD_PUSKESMAS, g.KD_LAYANAN_B, g.KD_PASIEN, e.KD_JENIS_KELAMIN, g.KD_UNIT
							FROM kunjungan g
							LEFT JOIN kunjungan_nifas b ON b.KD_PASIEN = g.KD_PASIEN 
							LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN 
							WHERE 1=1
							AND b.TANGGAL_KUNJUNGAN = g.TGL_MASUK
							AND g.KD_PASIEN IS NOT NULL 
							AND g.STATUS = '1' 
							AND g.TGL_MASUK >= '".$from."'
							AND g.TGL_MASUK <= '".$to."'
							
							UNION
							
							SELECT 'kunjungan_bersalin' AS Type, g.TGL_MASUK, g.KD_PUSKESMAS, g.KD_LAYANAN_B, g.KD_PASIEN, e.KD_JENIS_KELAMIN, g.KD_UNIT
							FROM kunjungan g
							LEFT JOIN kunjungan_bersalin b ON b.KD_PASIEN = g.KD_PASIEN 
							LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN 
							WHERE 1=1
							AND b.TANGGAL_PERSALINAN = g.TGL_MASUK
							AND g.KD_PASIEN IS NOT NULL 
							AND g.STATUS = '1' 
							AND g.TGL_MASUK >= '".$from."'
							AND g.TGL_MASUK <= '".$to."'
							
							UNION
							
							SELECT 'kunjungan_kb' AS Type, g.TGL_MASUK, g.KD_PUSKESMAS, g.KD_LAYANAN_B, g.KD_PASIEN, e.KD_JENIS_KELAMIN, g.KD_UNIT
							FROM kunjungan g
							LEFT JOIN kunjungan_kb b ON b.KD_PASIEN = g.KD_PASIEN 
							LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN 
							WHERE 1=1
							AND b.TANGGAL = g.TGL_MASUK
							AND g.KD_PASIEN IS NOT NULL 
							AND g.STATUS = '1' 
							AND g.TGL_MASUK >= '".$from."'
							AND g.TGL_MASUK <= '".$to."'
							
							UNION
							
							SELECT 'pel_rujuk_pasien' AS Type, g.TGL_MASUK, g.KD_PUSKESMAS, g.KD_LAYANAN_B, g.KD_PASIEN, e.KD_JENIS_KELAMIN, g.KD_UNIT
							FROM kunjungan g
							LEFT JOIN pel_rujuk_pasien b ON b.KD_PASIEN = g.KD_PASIEN 
							LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN 
							WHERE 1=1
							AND b.ninput_tgl = g.TGL_MASUK
							AND g.KD_PASIEN IS NOT NULL 
							AND g.STATUS = '1' 
							AND g.TGL_MASUK >= '".$from."'
							AND g.TGL_MASUK <= '".$to."'	
							
							)g ON g.KD_PUSKESMAS = p.KD_PUSKESMAS 
				WHERE 1=1 
				AND v.KD_PROVINSI = '".$propinsi."'
				AND k.KD_KABUPATEN = '".$kabupaten."'
				AND p.KD_KECAMATAN	 = '".$kecamatan."'
				".$sqlpuskesmas."
				AND g.Type IS NOT NULL
				GROUP BY k.KD_KABUPATEN, p.KD_PUSKESMAS, g.KD_UNIT, g.Type, g.KD_LAYANAN_B
		";
		
		$query = $db->query($sql);
		$dataPasien = $db->query($sql)->result_array(); //print_r($data);die;
		
		$puskesmas = '';
		$kd_puskesmas = '';
		foreach($dataPasien as $value){
			$bulan = date('n', strtotime($value['TGL_MASUK']));
			$arrDatakab[$bulan][$value['Type']][$value['KD_JENIS_KELAMIN']] = $value;
			
			if($value['PUSKESMAS'])
				$puskesmas = $value['PUSKESMAS'];
			
			if($value['KD_PUSKESMAS'])
				$kd_puskesmas = $value['KD_PUSKESMAS'];
		}
		
		$months = array(
					'',
					'January',
					'February',
					'March',
					'April',
					'May',
					'June',
					'July ',
					'August',
					'September',
					'October',
					'November',
					'December',
				);
		
		$newData = array();
		
		foreach($months as $k=>$v){
			if($v == '')continue;
			//inisialisasi
			
			$newData[$v] = isset($arrDatakab[$k])?$arrDatakab[$k]:'';
			
			$puskesmas = isset($arrDatakab[$k]['RJ']['L']['PUSKESMAS'])?$arrDatakab[$k]['RJ']['L']['PUSKESMAS']:$puskesmas;
			$kd_puskesmas = isset($arrDatakab[$k]['RJ']['L']['PUSKESMAS'])?$arrDatakab[$k]['RJ']['L']['KD_PUSKESMAS']:$kd_puskesmas;
						
			//rawat jalan
			$newData[$v]['RJ']['L'] = isset($arrDatakab[$k]['RJ']['L'])?$arrDatakab[$k]['RJ']['L']['PASIEN']:0;
			$newData[$v]['RJ']['P'] = isset($arrDatakab[$k]['RJ']['P'])?$arrDatakab[$k]['RJ']['P']['PASIEN']:0;
			
			//rawat inap
			$newData[$v]['RI']['L'] = isset($arrDatakab[$k]['RI']['L'])?$arrDatakab[$k]['RI']['L']['PASIEN']:0;
			$newData[$v]['RI']['P'] = isset($arrDatakab[$k]['RI']['P'])?$arrDatakab[$k]['RI']['P']['PASIEN']:0;
			
			//rawat bersalin
			$newData[$v]['B']['ANC'] = isset($arrDatakab[$k]['kunjungan_bumil']['P'])?$arrDatakab[$k]['kunjungan_bumil']['P']['PASIEN']:0;
			$newData[$v]['B']['PNC'] = isset($arrDatakab[$k]['kunjungan_nifas']['P'])?$arrDatakab[$k]['kunjungan_nifas']['P']['PASIEN']:0;
			$newData[$v]['B']['NORMAL'] = isset($arrDatakab[$k]['kunjungan_bersalin']['P'])?$arrDatakab[$k]['kunjungan_bersalin']['P']['PASIEN']:0;
			
			//KB
			$newData[$v]['KB'] = isset($arrDatakab[$k]['kunjungan_kb'])?$arrDatakab[$k]['kunjungan_kb']['P']['PASIEN']:0;
			
			//DIRUJUK
			$dirujukL = isset($arrDatakab[$k]['pel_rujuk_pasien']['L'])?$arrDatakab[$k]['pel_rujuk_pasien']['L']['PASIEN']:0;
			$dirujukP = isset($arrDatakab[$k]['pel_rujuk_pasien']['P'])?$arrDatakab[$k]['pel_rujuk_pasien']['P']['PASIEN']:0;
			$newData[$v]['DIRUJUK'] = $dirujukL+$dirujukP;
			
			//DIRUJUKBALIK
			$newData[$v]['DIRUJUKBALIK'] = 0;
		}
		
		//-------------------start data agregat---------------------//
		$sql = "SELECT k.KD_KABUPATEN, p.KD_PUSKESMAS, p.PUSKESMAS, g.month, g.RawatJalanL
				,g.RawatJalanP ,g.RawatInapL, g.RawatInapP, g.KIA_ANC, g.KIA_PNC, g.KIA_NORMAL, g.KB, g.DIRUJUK, g.RUJUKBALIK
				FROM mst_provinsi v
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
				LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
				LEFT JOIN laporan_agregat g ON g.kode_puskesmas = p.KD_PUSKESMAS
				WHERE v.KD_PROVINSI = '".$propinsi."'
				AND k.KD_KABUPATEN = '".$kabupaten."'
				AND p.KD_KECAMATAN	 = '".$kecamatan."'
				".$sqlpuskesmas."
				AND g.month >= '".$from."'
				AND g.month <= '".$to."'
				GROUP BY k.KD_KABUPATEN, p.KD_PUSKESMAS";
		$result = $db->query($sql)->result_array();// print_r($result);die;
		foreach($result as $value){			
			$month = date('F', strtotime($value['month']));
			
			//rawat jalan
			$newData[$month]['RJ']['L'] += $value['RawatJalanL'];
			$newData[$month]['RJ']['P'] += $value['RawatJalanP'];
			
			//rawat inap
			$newData[$month]['RI']['L'] += $value['RawatInapL'];
			$newData[$month]['RI']['P'] += $value['RawatInapP'];
			
			//rawat bersalin
			$newData[$month]['B']['ANC'] += $value['KIA_ANC'];
			$newData[$month]['B']['PNC'] += $value['KIA_PNC'];
			$newData[$month]['B']['NORMAL'] += $value['KIA_NORMAL'];
			
			//KB
			$newData[$month]['KB'] += $value['KB'];
					
			//DIRUJUK			
			$newData[$month]['DIRUJUK'] += $value['DIRUJUK'];
			
			//DIRUJUKBALIK
			$newData[$month]['DIRUJUKBALIK'] += $value['RUJUKBALIK']; 
		}
		//-------------------end   data agregat---------------------//
		
		/* echo "<pre>";
		print_r($newData);
		echo "</pre>"; */
		
		$data['result'] = $newData;
		$this->load->view('reports/rpt_lapjknpus_temp', $data);
	}
	
	public function lapjenispasien(){
		$this->load->helper('beries_helper');
				
		if(isset($_GET['jenispt']) && ( ($_GET['jenispt'] == 'html') || ($_GET['jenispt'] == 'excel') )){
			$propinsi = $_GET['propinsi'];
			$kabupaten = $_GET['kabupaten'];
			$kecamatan = $_GET['kecamatan'];
			$puskesmas = $_GET['puskesmas'];
			
			$_GET['from'] 	= date('Y-m-01', strtotime($_GET['from']));
			$_GET['to'] 	= date('Y-m-t', strtotime($_GET['to']));
			
			if($_GET['jenispt'] == 'excel'){
				$fileName = "Report_Rekap_Kunjungan_".date('Ymd').".xls";
				header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
				header("Content-Disposition: attachment; filename=".$fileName);  //File name extension was wrong
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private",false);
			}
			
			if($puskesmas != '0'){
				$this->lapjenispasienpus_temp();
			}elseif($puskesmas == 0 && $kecamatan > 0){
				//echo "Pilih Puskesmas";				
			}elseif($puskesmas == 0 && $kecamatan == 0 && $kabupaten > 0){
				$this->lapjenispasienkab_temp();
			}elseif($puskesmas == 0 && $kecamatan == 0 && $kabupaten == 0 && $propinsi > 0){
				$this->lapjenispasienprov_temp();
			}else{
				$this->lapjenispasiennasional_temp();
			}
			
		}else{
			$this->load->view('reports/rpt_lapjenispasien');		
		}
	}
	
	public function lapjenispasiennasional_temp(){
		$from = $this->input->get('from');	//print_r($from);die;
		$to = $this->input->get('to'); //print_r($to);die;
		
		$data['FROM'] = $from;
		$data['TO'] = $to;
		
		$propinsi = $this->input->get('propinsi'); //print_r($propinsi);die;
		$db = $this->load->database('sikda', TRUE);
		
		$sql = "
				SELECT SUBSTRING(g.KD_PASIEN,-7,7) AS KD_JENIS_PASIEN
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='01L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 01L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='01P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 01P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='02L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 02L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='02P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 02P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='03L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 03L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='03P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 03P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='04L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 04L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='04P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 04P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='05L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 05L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='05P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 05P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='06L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 06L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='06P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 06P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='07L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 07L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='07P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 07P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='08L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 08L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='08P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 08P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='09L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 09L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='09P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 09P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='10L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 10L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='10P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 10P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='11L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 11L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='11P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 11P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='12L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 12L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='12P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 12P
				FROM mst_provinsi v
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
				LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
				LEFT JOIN kunjungan g ON g.KD_PUSKESMAS = p.KD_PUSKESMAS
				LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN
				WHERE 1=1
				AND g.TGL_MASUK >= '2014-01-01'
				AND g.TGL_MASUK <= '2014-11-30'
				AND g.KD_PASIEN IS NOT NULL
				GROUP BY k.KD_PROVINSI, SUBSTRING(g.KD_PASIEN,-7,7);
				";
				
		$query = $db->query($sql);
		$dataPasien = $db->query($sql)->result_array();
		$data['result'] = $dataPasien;
		$this->load->view('reports/rpt_lapjenispasiennasional_html', $data);
	}
		
	public function lapjenispasienprov_temp(){
		$from = $this->input->get('from');	//print_r($from);die;
		$to = $this->input->get('to'); //print_r($to);die;
		
		$data['FROM'] = $from;
		$data['TO'] = $to;
		
		$propinsi = $this->input->get('propinsi'); //print_r($propinsi);die;
		$db = $this->load->database('sikda', TRUE);
		
		$sql = "
				SELECT c.CUSTOMER AS KD_JENIS_PASIEN
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='01L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 01L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='01P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 01P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='02L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 02L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='02P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 02P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='03L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 03L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='03P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 03P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='04L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 04L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='04P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 04P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='05L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 05L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='05P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 05P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='06L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 06L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='06P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 06P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='07L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 07L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='07P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 07P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='08L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 08L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='08P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 08P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='09L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 09L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='09P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 09P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='10L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 10L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='10P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 10P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='11L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 11L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='11P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 11P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='12L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 12L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='12P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 12P
				FROM mst_provinsi v
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
				LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
				LEFT JOIN kunjungan g ON g.KD_PUSKESMAS = p.KD_PUSKESMAS
				LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN
				LEFT JOIN mst_kel_pasien c ON SUBSTRING(c.KD_CUSTOMER,-7,7) = SUBSTRING(g.KD_PASIEN,-7,7)
				WHERE 1=1
				AND v.KD_PROVINSI = '".$propinsi."'
				AND g.TGL_MASUK >= '2014-01-01'
				AND g.TGL_MASUK <= '2014-11-30'
				AND g.KD_PASIEN IS NOT NULL
				GROUP BY k.KD_PROVINSI, SUBSTRING(g.KD_PASIEN,-7,7);
				";
				
		$query = $db->query($sql);
		$dataPasien = $db->query($sql)->result_array();
		$data['result'] = $dataPasien;
		
		$sql = "SELECT v.PROVINSI
				FROM mst_provinsi v  
				WHERE 1=1 
				AND v.KD_PROVINSI = '".$propinsi."'";
		$query = $db->query($sql);
		$result = $query->result_array();
		$data['PROPINSI'] = $result[0]['PROVINSI'];
		
		$this->load->view('reports/rpt_lapjenispasienprov_html.php', $data);
	}
	
	public function lapjenispasienkab_temp(){
		$from = $this->input->get('from');	//print_r($from);die;
		$to = $this->input->get('to'); //print_r($to);die;
		
		$data['FROM'] = $from;
		$data['TO'] = $to;
		
		$propinsi = $this->input->get('propinsi'); //print_r($propinsi);die;
		$kabupaten = $this->input->get('kabupaten'); //print_r($propinsi);die;
		
		$db = $this->load->database('sikda', TRUE);
		
		$sql = "
				SELECT c.CUSTOMER AS KD_JENIS_PASIEN
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='01L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 01L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='01P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 01P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='02L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 02L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='02P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 02P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='03L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 03L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='03P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 03P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='04L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 04L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='04P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 04P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='05L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 05L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='05P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 05P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='06L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 06L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='06P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 06P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='07L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 07L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='07P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 07P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='08L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 08L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='08P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 08P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='09L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 09L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='09P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 09P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='10L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 10L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='10P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 10P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='11L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 11L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='11P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 11P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='12L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 12L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='12P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 12P
				FROM mst_provinsi v
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
				LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
				LEFT JOIN kunjungan g ON g.KD_PUSKESMAS = p.KD_PUSKESMAS
				LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN
				LEFT JOIN mst_kel_pasien c ON SUBSTRING(c.KD_CUSTOMER,-7,7) = SUBSTRING(g.KD_PASIEN,-7,7)
				WHERE 1=1
				AND v.KD_PROVINSI = '".$propinsi."'
				AND k.KD_KABUPATEN = '".$kabupaten."'
				AND g.TGL_MASUK >= '2014-01-01'
				AND g.TGL_MASUK <= '2014-11-30'
				AND g.KD_PASIEN IS NOT NULL
				GROUP BY k.KD_PROVINSI, SUBSTRING(g.KD_PASIEN,-7,7);
				";
				
		$query = $db->query($sql);
		$dataPasien = $db->query($sql)->result_array();
		$data['result'] = $dataPasien;
		
		$sql = "SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN
				FROM mst_provinsi v 
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI  
				WHERE 1=1 
				AND v.KD_PROVINSI = '".$propinsi."'
				AND k.KD_KABUPATEN = '".$kabupaten."'";		
		$query = $db->query($sql);
		$result = $query->result_array();
		$data['PROPINSI'] = $result[0]['PROVINSI'];
		$data['KABUPATEN'] = $result[0]['KABUPATEN'];
		
		$this->load->view('reports/rpt_lapjenispasienkab_html.php', $data);
	}
	
	public function lapjenispasienpus_temp(){
		$from = $this->input->get('from');	//print_r($from);die;
		$to = $this->input->get('to'); //print_r($to);die;
		
		$data['FROM'] = $from;
		$data['TO'] = $to;
		
		$propinsi = $this->input->get('propinsi'); //print_r($propinsi);die;
		$kabupaten = $this->input->get('kabupaten'); //print_r($propinsi);die;
		$kecamatan = $this->input->get('kecamatan'); //print_r($propinsi);die;
		$puskesmas = $this->input->get('puskesmas'); //print_r($propinsi);die;
		
		$db = $this->load->database('sikda', TRUE);
		
		$sql = "
				SELECT c.CUSTOMER AS KD_JENIS_PASIEN
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='01L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 01L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='01P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 01P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='02L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 02L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='02P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 02P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='03L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 03L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='03P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 03P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='04L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 04L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='04P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 04P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='05L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 05L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='05P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 05P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='06L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 06L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='06P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 06P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='07L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 07L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='07P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 07P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='08L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 08L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='08P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 08P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='09L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 09L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='09P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 09P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='10L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 10L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='10P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 10P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='11L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 11L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='11P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 11P

				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='12L', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 12L
				,IF(CONCAT_WS('', SUBSTRING(g.TGL_MASUK,6,2), e.KD_JENIS_KELAMIN) ='12P', count( SUBSTRING(g.KD_PASIEN,0,10) ),0) AS 12P
				FROM mst_provinsi v
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI
				LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
				LEFT JOIN kunjungan g ON g.KD_PUSKESMAS = p.KD_PUSKESMAS
				LEFT JOIN pasien e ON e.KD_PASIEN = g.KD_PASIEN
				LEFT JOIN mst_kel_pasien c ON SUBSTRING(c.KD_CUSTOMER,-7,7) = SUBSTRING(g.KD_PASIEN,-7,7)
				WHERE 1=1
				AND v.KD_PROVINSI = '".$propinsi."'
				AND k.KD_KABUPATEN = '".$kabupaten."'
				AND p.KD_PUSKESMAS = '".$puskesmas."'
				AND g.TGL_MASUK >= '2014-01-01'
				AND g.TGL_MASUK <= '2014-11-30'
				AND g.KD_PASIEN IS NOT NULL
				GROUP BY k.KD_PROVINSI, SUBSTRING(g.KD_PASIEN,-7,7);
				";
				
		$query = $db->query($sql);
		$dataPasien = $db->query($sql)->result_array();
		$data['result'] = $dataPasien;
		
		$sql = "SELECT v.PROVINSI, k.KD_KABUPATEN, k.KABUPATEN, p.KD_PUSKESMAS, p.PUSKESMAS
				FROM mst_provinsi v 
				LEFT JOIN mst_kabupaten k ON k.KD_PROVINSI = v.KD_PROVINSI  
				LEFT JOIN mst_puskesmas p ON SUBSTRING(p.KD_KECAMATAN, 1, 4) = k.KD_KABUPATEN
				WHERE 1=1 
				AND v.KD_PROVINSI = '".$propinsi."'
				AND k.KD_KABUPATEN = '".$kabupaten."'
				AND p.KD_PUSKESMAS = '".$puskesmas."'";					
		$query = $db->query($sql);
		$result = $query->result_array();
		$data['PROPINSI'] = $result[0]['PROVINSI'];
		$data['KABUPATEN'] = $result[0]['KABUPATEN'];
		$data['PUSKESMAS'] = $result[0]['PUSKESMAS'];
		$data['KD_PUSKESMAS'] = $result[0]['KD_PUSKESMAS'];
		
		$this->load->view('reports/rpt_lapjenispasienpus_html', $data);
	}
	
}

/* End of file dashboard.php */
/* Location: ./sikdaapplication/controllers/login.php */