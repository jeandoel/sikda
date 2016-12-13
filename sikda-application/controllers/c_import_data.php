<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class C_import_data extends CI_Controller {

	public function index()
	{			
		$this->load->view('import');	
		
	}
	public static function deleteDir($dirPath) {
		if (! is_dir($dirPath)) {
			throw new InvalidArgumentException("$dirPath must be a directory");
		}
		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			$dirPath .= '/';
		}
		$files = glob($dirPath . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file)) {
				self::deleteDir($file);
			} else {
				unlink($file);
			}
		}
		rmdir($dirPath);
	}
	public function import_sql()
	{			
		$db=$this->load->database('sikda',true);
		$username=$db->username;
		$password=$db->password;
		
		$config['upload_path'] = './tmp/import/';
		$config['allowed_types'] = 'zip';

		$this->load->library('upload', $config);
		
		/*if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

			$this->load->view('import', $error);
		}
		else
		{
			$datafile = $this->upload->data();
			mkdir($datafile['file_name']);die;
			$filefolder = dirname(__FILE__).'/../../tmp/import/'.$datafile['file_name']; //die($filename);
			//die("mysql -u$username -p$password sikda_puskesmas < ".$filename);
			//exec("mysql -u$username -p$password sikda_puskesmas < ".$filename, $output=array(),$worked);
			
			
			if($worked){
				die('Proses Import Gagal');
			}else{
				die('OK');
			}
			//$data = array('upload_data' => 'File Berhasil di Proses');
	
			//$this->load->view('import', $data);
		}*/
		$this->upload->initialize($config);	
		$jumlah_file = count ($_FILES);
		$kab = $this->session->userdata('kd_kabupaten');
			
		if($jumlah_file>0){
			$ext = $this->upload->get_extension($_FILES['userfile']['name']);	
			if($ext=='.zip'){
				$db->trans_begin();

				$db->query("SET FOREIGN_KEY_CHECKS=0");
					
				$uploads_dir = BASEPATH."../tmp/import/";
				if ($_FILES["userfile"]["error"] == UPLOAD_ERR_OK) {
					$tmp_name = $_FILES["userfile"]["tmp_name"];
					$name = $_FILES["userfile"]["name"];
					$nwe = explode('.',$name);
					
					$table_name = array("kunjungan",
						"kunjungan_nifas",
						"kunjungan_kb",
						"kunjungan_bersalin",
						"kunjungan_bumil",
						"pasien",
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
						"t_k_inspeksihotel"
						,"t_k_inspeksipasar",
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
					if(move_uploaded_file($tmp_name, "$uploads_dir/$name")){
						$zip = new ZipArchive;
						$zip2 = $zip->open("$uploads_dir/$name");
						if ($zip2 === TRUE) {
							if (!is_dir("$uploads_dir/".$nwe[0])) {
								mkdir("$uploads_dir/".$nwe[0]);
							}else{
								$this->deleteDir("$uploads_dir/".$nwe[0]);
								mkdir("$uploads_dir/".$nwe[0]);
							}
							
							//then extract the zip
							$zip->extractTo("$uploads_dir/".$nwe[0]);
							$zip->close();
							foreach($table_name as $table){
								if(file_exists("$uploads_dir/".$nwe[0]."/".$kab)){
									if(file_exists("$uploads_dir/".$nwe[0]."/backup_".$table.".sql")){
										$sql = "LOAD DATA INFILE '$uploads_dir/".$nwe[0]."/backup_".$table.".sql' REPLACE INTO TABLE $table FIELDS TERMINATED BY ','
												ENCLOSED BY '\"'
												LINES TERMINATED BY '\n';";
										$exec = $db->query($sql);//print_r($table);
									}
								}else die('Proses Gagal, File Backup tidak sesuai dengan Kode Kabupaten!');
							}
							
							$db->query("SET FOREIGN_KEY_CHECKS=1");

							$db->trans_commit();							
							die('OK');
						}
						
					}else{
						$db->query("SET FOREIGN_KEY_CHECKS=1");
						$db->trans_commit();							
					}
				}
				
			}else{
				die('Extensi file tidak berlaku');
			}			
		}else{
			die('Silahkan pilih file');
		}	
	}
	
	
}
?>
	