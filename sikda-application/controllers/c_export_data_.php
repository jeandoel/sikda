<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class C_export_data extends CI_Controller {

	public function index()
	{			
		$this->load->view('export');	
		
	}
	
	public function export_sql()
	{			
		$db=$this->load->database('sikda',true);
		$username=$db->username;
		$password=$db->password;
		$filename1 = "backup_" . date('Ymd_his') . ".sql";//print_r($filename1);die();
		$filename = dirname(__FILE__).'\..\..\tmp\export/'.$filename1; //die($filename);
		
		$tables="kunjungan kunjungan_bersalin kunjungan_bumil pasien pasien_alergi_obt pel_hasil_kia pel_kasir pel_rujuk_pasien pelayanan pemeriksaan_anak trans_imunisasi";
		shell_exec("mysqldump --opt -hlocalhost --no-create-db --no-create-info  -u$username -p$password sikda_puskesmas $tables > $filename",$output=array(),$worked);
		if($worked){
			//redirect(base_url('dashboard'));
			die('Proses export gagal');
		}else{
		header('content-type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.$filename1.'"');
		readfile($filename);
		}
		//print_r($output);
		//return $result;
			
	}
	
	
}
?>
	