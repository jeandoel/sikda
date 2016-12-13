<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class C_export_data extends CI_Controller {

	public function index()
	{			
		$this->load->view('export');	
		
	}
	
	public function export_sql()
	{			
		$db=$this->load->database('sikda',true);
		
		$table_name = array(
			"kunjungan",
			"kunjungan_nifas",
			"kunjungan_kb",
			"kunjungan_bersalin",
			"kunjungan_bumil","pasien",
			"pasien_alergi_obt",
			"pel_hasil_kia",
			"pel_tindakan",
			"pel_diagnosa",
			"pel_kasir",
			"pel_rujuk_pasien",
			"pelayanan",
			"pemeriksaan_anak",
			"trans_kia",
			"trans_imunisasi",
			"apt_stok_obat",
			"apt_trans_obat",
			"apt_obat_terima",
			"apt_obat_terima_detail",
			"apt_obat_keluar",
			"apt_obat_keluar_detail",
			"data_dasar",
			"detail_asuhan_bayi",
			"detail_keadaan_bayi",
			"detail_tindakan_anak_pem_neo",
			"detail_tindakan_ibu_pem_neo",
			"detail_tindakan_kb",
			"family_folder",
			"pel_kasir_detail",
			"pel_kasir_detail_bayar",
			"pel_imunisasi",
			"pel_ord_lab",
			"pel_ord_obat",
			"pel_petugas",
			"pem_kes_icd",
			"pem_kes_produk",
			"pemeriksaan_neonatus",
			"sys_setting",
			"sys_setting_def",
			"sys_setting_def_dw",
			"t_ds_datadasar",
			"t_ds_gizi",
			"t_ds_imunisasi",
			"t_ds_kb",
			"t_ds_kegiatanpuskesmas",
			"t_ds_kematian_anak",
			"t_ds_kematian_ibu",
			"t_ds_kesling",
			"t_ds_kia",
			"t_ds_promkes",
			"t_ds_ukgs",
			"t_ds_uks",
			"t_k_inspeksihotel",
			"t_k_inspeksipasar",
			"t_k_rmrestoran",
			"t_k_rumahsehat",
			"t_posyandu",
			"tindakan_nifas",
			"trans_kipi",
			"trans_sarana",
			"apt_sarana",
			"apt_sarana_detail",
			"apt_sarana_keluar",
			"apt_sarana_keluar_detail",
			"apt_sarana_masuk",
			"apt_sarana_masuk_detail",
			"t_perawatan_gigi_pasien",
			"t_foto_gigi_pasien"
			);
		$folder = date('Ymd_his');
		$kab = $this->session->userdata('kd_kabupaten');
		mkdir(BASEPATH."../tmp/export/".$folder);
		for($k = 0;$k<sizeof($table_name);$k++){
			$namafile = "backup_".$table_name[$k].".sql";
			$backup_file  = BASEPATH."../tmp/export/".$folder."/".$namafile;
			$backup_file_array[]  = $namafile;
			$sql = "SELECT * INTO OUTFILE '$backup_file' FIELDS TERMINATED BY ','
				ENCLOSED BY '\"'
				LINES TERMINATED BY '\n' FROM ".$table_name[$k];
			//print_r(E_RECOVERABLE_ERROR);die;
			$retval = $db->query( $sql );
		}
		if(! $retval )
		{
		  die('Could not take data backup: ' . mysql_error());
		}
		$zip = new ZipArchive();
		$archive_file_name = "backup_".date('dmY_his').".zip";
		$fileKompresi = BASEPATH."../tmp/export/".$archive_file_name;
		//if true, good; if false, zip creation failed
		$kompresi = $zip->open($fileKompresi, ZIPARCHIVE::CREATE);
		if ($kompresi){
			$zip->addFromString($kab, '');
			foreach($backup_file_array as $namaFile){
				$tmpName = BASEPATH."../tmp/export/".$folder."/".$namaFile;
				if(filesize($tmpName)>0){
					$fp      = fopen($tmpName, 'r');
					$isiFile = fread($fp, filesize($tmpName));//print_r($isiFile);die;
					fclose($fp);
					$zip->addFromString($namaFile, $isiFile);
				}
				
			}
			
		}else die("Backup Gagal");
		
		$zip->close();
		header("Content-type: application/zip");
		header("Content-Disposition: attachment; filename=$archive_file_name");
		header("Pragma: no-cache");
		header("Expires: 0");
		readfile("$fileKompresi");
		exit; 
		/*$username=$db->username;
		$password=$db->password;
		$filename1 = "backup_" . date('Ymd_his') . ".sql";
		$filename = dirname(__FILE__).'/../../tmp/export/'.$filename1; //die($filename);
		//$filename = "/backup_" . date('Ymd_his') . ".sql";
		// pclose(popen("start /B mysql -e 'select * from pasien' -u $username -p $password sikda_puskesmas > e:\mydumpfile.sql", "r"));
		
		$tables="kunjungan kunjungan_bersalin kunjungan_bumil pasien pasien_alergi_obt pel_hasil_kia pel_kasir pel_rujuk_pasien pelayanan pemeriksaan_anak trans_imunisasi";
		exec("mysqldump --no-create-db --no-create-info  -u$username -p$password sikda_puskesmas $tables > $filename",$output=array(),$worked);
		//die("mysqldump --no-create-db --no-create-info  -uroot -proot sikda_puskesmas $tables > $filename");
		print_r($worked);die;
		if($worked){
			die('Proses export gagal');
			redirect(base_url('c_export_data'));
		}else{
		header('content-type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.$filename1.'"');
		readfile($filename);
		}*/
			
	}	
	
	/* creates a compressed zip file */

	public function create_zip($pathfile,$files = array(),$destination = '',$overwrite = false) {
		//if the zip file already exists and overwrite is false, return false
		if(file_exists($destination) && !$overwrite) { return false; }
		//vars
		$valid_files = array();
		//if files were passed in...
		if(is_array($files)) {
			//cycle through each file
			foreach($files as $file) {
				//make sure the file exists
				$valid_files[] = $file;
				if(file_exists($file)) {
					$valid_files[] = $file;
				}
			}
		}
		//if we have good files...
		if(count($valid_files)) {
			//create the archive
			$zip = new ZipArchive();
			if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
				return false;
			}
			//add the files
			foreach($valid_files as $file) {
				$zip->addFile($pathfile,"\\".$file);
			}
			//debug
			//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
			
			//close the zip -- done!
			$zip->close();
			
			//check to make sure the file exists
			return true;
		}
		else
		{
			return false;
		}
	}
	
}
