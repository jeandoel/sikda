<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_pendaftaran extends CI_Controller {
	public function index()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_pendaftaran/v_pendaftaran');
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function t_pendaftaranxml()
	{		
		$this->load->model('t_pendaftaran_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari')
					);
					
		$total = $this->t_pendaftaran_model->totalT_pendaftaran($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari')
					);
		
		if($this->input->post('usergabung')) $params['usergabung']=$this->input->post('usergabung',TRUE);
					
		$result = $this->t_pendaftaran_model->getT_pendaftaran($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'],$total,$page,$total_pages);
	}
	
	public function t_pendaftaranantrianxml()
	{		
		$this->load->model('t_pelayanan_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),					
					'unit'=>$this->input->post('unit'),					
					'status'=>$this->input->post('status'),
					'jenis'=>$this->input->post('jenis')
					);
					
		$total = $this->t_pelayanan_model->totalT_pendaftaran($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'dari'=>$this->input->post('dari'),					
					'unit'=>$this->input->post('unit'),					
					'status'=>$this->input->post('status'),
					'jenis'=>$this->input->post('jenis')
					);
					
		$result = $this->t_pelayanan_model->getT_pendaftaran($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function updatekdpuskesmas()
	{
		$db = $this->load->database('sikda', TRUE);
		$db->trans_begin();
		
		$queryGetAllTTable = " SELECT DISTINCT  TABLE_NAME";
		$queryGetAllTTable .= " FROM INFORMATION_SCHEMA.COLUMNS";
		$queryGetAllTTable .= " WHERE COLUMN_NAME IN ('KD_PUSKESMAS') and TABLE_NAME not like 'vw_%'";
		$queryGetAllTTable .= " AND TABLE_SCHEMA='".$db->database."'";
	   
		$query = $db->query($queryGetAllTTable);//print_r($db->last_query());die;
		if ($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$kd_baru = 'P1234020201';
				$kd_lama = 'P1704020201';
				$queryExecute = "UPDATE ".$row->TABLE_NAME." SET KD_PUSKESMAS = '".$kd_baru."' WHERE KD_PUSKESMAS = '".$kd_lama."'";
				$db->query($queryExecute);			  
			}
		}else{
			die('Proses Gagal Mohon di Ulangi');
		}
		
		if ($db->trans_status() === FALSE)
		{
			$db->trans_rollback();
			die('Maaf Proses Insert Data Gagal');
		}
		else
		{
			$db->trans_commit();
			die('OK');
		}
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_pendaftaran/v_t_pendaftaran_add');
	}
	
	public function edit()
	{
		$this->load->helper('beries_helper');
		$id = $this->input->get('kd_pasien')?$this->input->get('kd_pasien'):NULL;
		$db = $this->load->database('sikda', TRUE);
		$editquery = $db->query("select * from pasien where KD_PASIEN='".$id."'")->row();
		$data['data']= $editquery;
		$this->load->view('t_pendaftaran/v_t_pendaftaran_edit',$data);
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required|myvalid_date');		
		$val->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required|xss_clean');
		$val->set_rules('tanggal_daftar', 'Tanggal Daftar', 'trim|required|myvalid_date');
		$val->set_rules('tempat_lahir', 'Tempat Lahir', 'trim|required|xss_clean');
		$val->set_rules('jenis_kelamin', 'Jenis Kelamin', 'trim|required|xss_clean');
		$val->set_rules('jenis_pasien', 'Jenis Pasien', 'trim|required|xss_clean');
		if($this->input->post('jenis_pasien')=='0000000003' or $this->input->post('jenis_pasien')=='0000000004' or $this->input->post('jenis_pasien')=='0000000005' or $this->input->post('jenis_pasien')=='0000000006'){
			$val->set_rules('no_asuransi_pasien', 'No. Asuransi', 'trim|required|xss_clean');
		}
		$val->set_rules('cara_bayar', 'Cara Bayar', 'trim|required|xss_clean');
		$val->set_rules('nama_kk', 'Nama KK', 'trim|required|xss_clean');
		$val->set_rules('alamat', 'Alamat', 'trim|required|xss_clean');
		
		if($this->input->post('showhide_kunjungan')){
			if($this->input->post('showhide_kunjungan')=='rawat_jalan'){
				$val->set_rules('unit_layanan', 'Unit Layanan', 'trim|required|xss_clean');
				$val->set_rules('poliklinik', 'Poliklinik', 'trim|required|xss_clean');
				if($this->input->post('poliklinik')=='219'){
					$val->set_rules('kategori_kia', 'Kategori KIA', 'trim|required|xss_clean');
					if($this->input->post('kategori_kia')==1){
						if($this->input->post('nama_suami')){
							$val->set_rules('tempat_lahir_suami','Tempat Lahir','trim|required|xss_clean');
							$val->set_rules('tanggal_lahir_suami','Tanggal Lahir','trim|required|xss_clean');
						}
					}elseif($this->input->post('kategori_kia')==2){
						$val->set_rules('nama_ibu_pasien','Nama Ibu','trim|required|xss_clean');
						$val->set_rules('tempat_lahir_ibu','Tempat Lahir','trim|required|xss_clean');
						$val->set_rules('tanggal_lahir_ibu','Tanggal Lahir','trim|required|xss_clean');
						if($this->input->post('nama_ayah_pasien')){
							$val->set_rules('tempat_lahir_ayah','Tempat Lahir','trim|required|xss_clean');
							$val->set_rules('tanggal_lahir_ayah','Tanggal Lahir','trim|required|xss_clean');
						}
					}
				}
			}elseif($this->input->post('showhide_kunjungan')=='rawat_inap'){
				$val->set_rules('spesialisasi', 'Spesialisasi', 'trim|required|xss_clean');
				/*$val->set_rules('ruangan', 'Ruangan', 'trim|required|xss_clean');
				$val->set_rules('kelas', 'Kelas', 'trim|required|xss_clean');
				$val->set_rules('kamar', 'Kamar', 'trim|required|xss_clean');*/
			}else{
				$val->set_rules('unit_layanan', 'Unit Layanan', 'trim|required|xss_clean');
			}
		}
		
		$val->set_message('required', "Silahkan isi field \"%s\"");

		if ($val->run() == FALSE)
		{
			$val->set_error_delimiters('<div style="color:white">', '</div>');
			die(validation_errors());
		}
		else
		{						
			$db = $this->load->database('sikda', TRUE);
			$db->trans_begin();
			$kdfamily = $db->query("select max(KD_FAMILY_FOLDER) as total from family_folder")->row();
			$kdfamily = $kdfamily->total+1;
			$datafamily = array(
							'KD_FAMILY_FOLDER' => $kdfamily,
							'NO_KK' => $this->input->post('no_kk'),
							'NAMA_KK' => $this->input->post('nama_kk'),
							'ninput_oleh' => $this->session->userdata('user_name'),
							'ninput_tgl' => date("Y-m-d")
						);
			$db->insert('family_folder',$datafamily);
			$IDfamily = $db->insert_id();
			$db->trans_commit();
			$max = $db->query("SELECT MAX(SUBSTR(kd_pasien,-7)) AS total FROM pasien where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
			$max = $max->total + 1;
			$dataexc = array(
				'CMLAMA' => $this->input->post('cmlama')?$this->input->post('cmlama'):NULL,
				'NAMA_LENGKAP' => $val->set_value('nama_lengkap'),
				'KD_CUSTOMER' => $val->set_value('jenis_pasien'),
				'KD_PASIEN'=> $this->session->userdata('kd_puskesmas').sprintf("%07d", $max),
				'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
				'NO_PENGENAL' => $this->input->post('nik')?$this->input->post('nik',TRUE):NULL,
				'KD_KABKOTA' => $this->input->post('kabupaten_kota')?$this->input->post('kabupaten_kota',TRUE):NULL,
				'KD_KECAMATAN' => $this->input->post('kecamatan')?$this->input->post('kecamatan',TRUE):NULL,
				'KD_KELURAHAN' => $this->input->post('desa_kelurahan')?$this->input->post('desa_kelurahan',TRUE):NULL,
				'KD_POS' => $this->input->post('kode_pos')?$this->input->post('kode_pos',TRUE):NULL,
				'TELEPON' => $this->input->post('no_tlp')?$this->input->post('no_tlp',TRUE):NULL,
				'HP' => $this->input->post('no_hp')?$this->input->post('no_hp',TRUE):NULL,
				'KD_PENDIDIKAN' => $this->input->post('pendidikan_akhir')?$this->input->post('pendidikan_akhir',TRUE):NULL,
				'KD_PEKERJAAN' => $this->input->post('pekerjaan')!=""?$this->input->post('pekerjaan',TRUE):NULL,
				'KD_AGAMA' => $this->input->post('agama')?$this->input->post('agama',TRUE):NULL,
				'STATUS_MARITAL' => $this->input->post('status_nikah')?$this->input->post('status_nikah',TRUE):NULL,
				'KD_GOL_DARAH' => $this->input->post('gol_darah')?$this->input->post('gol_darah',TRUE):NULL,
				'KD_RAS' => $this->input->post('ras_suku')?$this->input->post('ras_suku',TRUE):NULL,
				'NAMA_AYAH' => $this->input->post('nama_ayah')?$this->input->post('nama_ayah',TRUE):NULL,
				'NAMA_IBU' => $this->input->post('nama_ibu')?$this->input->post('nama_ibu',TRUE):NULL,
				//'RINCIAN_PENANGGUNG' => $this->input->post('rincian_penangggung')?$this->input->post('rincian_penangggung',TRUE):NULL,
				'NAMA_KLG_LAIN' => $this->input->post('pic')?$this->input->post('pic',TRUE):NULL,
				'KET_WIL' => $this->input->post('wilayah')?$this->input->post('wilayah',TRUE):NULL,
				'CARA_BAYAR' => $val->set_value('cara_bayar'),
				'NO_KK' => $this->input->post('no_kk')?$this->input->post('no_kk'):NULL,
				'KK' => $val->set_value('nama_kk'),
				'TEMPAT_LAHIR' => $val->set_value('tempat_lahir'),
				'ALAMAT' => $val->set_value('alamat'),
				'KD_PROVINSI' => $this->input->post('provinsi')?$this->input->post('provinsi',TRUE):NULL,
				'KD_JENIS_KELAMIN' => $val->set_value('jenis_kelamin'),
				'TGL_PENDAFTARAN' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tanggal_daftar')))),
				'TGL_LAHIR' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tanggal_lahir')))),
				'PETUGAS2' => $this->input->post('petugas2')?$this->input->post('petugas2',TRUE):NULL,
				'ID_FAMILY_FOLDER' => $IDfamily,
				'Created_By' => $this->session->userdata('user_name'),
				'Created_Date' => date('Y-m-d H:i:s')
			);
			if($this->input->post('jenis_pasien')!=='0000000001'){
				$dataexc['NO_ASURANSI'] = $this->input->post('no_asuransi_pasien');
			}
			if($this->input->post('kategori_kia')==2){
				$dataexc['ANAK_KE'] = $this->input->post('anak_ke');
				$dataexc['BERAT_LAHIR'] = $this->input->post('berat_lahir');
				$dataexc['LINGKAR_KEPALA'] = $this->input->post('lingkar_kapala');
				$dataexc['PANJANG_BADAN'] = $this->input->post('panjang_badan');
			}
			$db->insert('pasien', $dataexc);
			
			if($this->input->post('showhide_kunjungan')){
				$dataexckujungan = array(
					'KD_PASIEN'=> $this->session->userdata('kd_puskesmas').sprintf("%07d", $max),
					'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
					'KD_DOKTER' => $this->session->userdata('kd_petugas'),
					'TGL_MASUK' => date('Y-m-d'),
					
				);			
				$this->daftarkunjunganprocessfunction($db,$dataexckujungan,$dataexc,$val);
			}
			
			if ($db->trans_status() === FALSE)
			{
				$db->trans_rollback();
				die('Maaf Proses Insert Data Gagal');
			}
			else
			{
				$db->trans_commit();
				die('OK');
			}
		}
	}
	
	public function editpasienprocess()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('kd_pasien');
		$val = $this->form_validation;
		$val->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required|myvalid_date');		
		$val->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required|xss_clean');
		$val->set_rules('tanggal_daftar', 'Tanggal Daftar', 'trim|required|myvalid_date');
		$val->set_rules('tempat_lahir', 'Tempat Lahir', 'trim|required|xss_clean');
		$val->set_rules('jenis_kelamin', 'Jenis Kelamin', 'trim|required|xss_clean');
		$val->set_rules('jenis_pasien', 'Jenis Pasien', 'trim|required|xss_clean');
		if($this->input->post('jenis_pasien')=='0000000003' or $this->input->post('jenis_pasien')=='0000000004' or $this->input->post('jenis_pasien')=='0000000005' or $this->input->post('jenis_pasien')=='0000000006'){
			$val->set_rules('no_asuransi_pasien', 'No. Asuransi', 'trim|required|xss_clean');
		}
		$val->set_rules('cara_bayar', 'Cara Bayar', 'trim|required|xss_clean');
		$val->set_rules('nama_kk', 'Nama KK', 'trim|required|xss_clean');
		$val->set_rules('alamat', 'Alamat', 'trim|required|xss_clean');
		
		$val->set_message('required', "Silahkan isi field \"%s\"");

		if ($val->run() == FALSE)
		{
			$val->set_error_delimiters('<div style="color:white">', '</div>');
			die(validation_errors());
		}
		else
		{						
			$db = $this->load->database('sikda', TRUE);
			$db->trans_begin();
			$dataexc = array(
				'CMLAMA' => $this->input->post('cmlama')?$this->input->post('cmlama'):NULL,
				'NAMA_LENGKAP' => $val->set_value('nama_lengkap'),
				'KD_CUSTOMER' => $val->set_value('jenis_pasien'),
				'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
				'NO_PENGENAL' => $this->input->post('nik')?$this->input->post('nik',TRUE):NULL,
				'KD_KABKOTA' => $this->input->post('kabupaten_kota')?$this->input->post('kabupaten_kota',TRUE):NULL,
				'KD_KECAMATAN' => $this->input->post('kecamatan')?$this->input->post('kecamatan',TRUE):NULL,
				'KD_KELURAHAN' => $this->input->post('desa_kelurahan')?$this->input->post('desa_kelurahan',TRUE):NULL,
				'KD_POS' => $this->input->post('kode_pos')?$this->input->post('kode_pos',TRUE):NULL,
				'TELEPON' => $this->input->post('no_tlp')?$this->input->post('no_tlp',TRUE):NULL,
				'HP' => $this->input->post('no_hp')?$this->input->post('no_hp',TRUE):NULL,
				'KD_PENDIDIKAN' => $this->input->post('pendidikan_akhir')?$this->input->post('pendidikan_akhir',TRUE):NULL,
				'KD_PEKERJAAN' => $this->input->post('pekerjaan')!=""?$this->input->post('pekerjaan',TRUE):NULL,
				'KD_AGAMA' => $this->input->post('agama')?$this->input->post('agama',TRUE):NULL,
				'STATUS_MARITAL' => $this->input->post('status_nikah')?$this->input->post('status_nikah',TRUE):NULL,
				'KD_GOL_DARAH' => $this->input->post('gol_darah')?$this->input->post('gol_darah',TRUE):NULL,
				'KD_RAS' => $this->input->post('ras_suku')?$this->input->post('ras_suku',TRUE):NULL,
				'NAMA_AYAH' => $this->input->post('nama_ayah')?$this->input->post('nama_ayah',TRUE):NULL,
				'NAMA_IBU' => $this->input->post('nama_ibu')?$this->input->post('nama_ibu',TRUE):NULL,
				'NAMA_KLG_LAIN' => $this->input->post('pic')?$this->input->post('pic',TRUE):NULL,
				'KET_WIL' => $this->input->post('wilayah')?$this->input->post('wilayah',TRUE):NULL,
				'CARA_BAYAR' => $val->set_value('cara_bayar'),
				'NO_KK' => $this->input->post('no_kk')?$this->input->post('no_kk'):NULL,
				'KK' => $val->set_value('nama_kk'),
				'TEMPAT_LAHIR' => $val->set_value('tempat_lahir'),
				'ALAMAT' => $val->set_value('alamat'),
				'KD_PROVINSI' => $this->input->post('provinsi')?$this->input->post('provinsi',TRUE):NULL,
				'KD_JENIS_KELAMIN' => $val->set_value('jenis_kelamin'),
				'TGL_PENDAFTARAN' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tanggal_daftar')))),
				'TGL_LAHIR' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tanggal_lahir')))),
				'PETUGAS2' => $this->input->post('petugas2')?$this->input->post('petugas2',TRUE):NULL,
				'Created_By' => $this->session->userdata('user_name'),
				'Created_Date' => date('Y-m-d H:i:s')
			);
			if($this->input->post('jenis_pasien')!=='0000000001'){
				$dataexc['NO_ASURANSI'] = $this->input->post('no_asuransi_pasien');
			}
			if($this->input->post('kategori_kia')==2){
				$dataexc['ANAK_KE'] = $this->input->post('anak_ke');
				$dataexc['BERAT_LAHIR'] = $this->input->post('berat_lahir');
				$dataexc['LINGKAR_KEPALA'] = $this->input->post('lingkar_kapala');
				$dataexc['PANJANG_BADAN'] = $this->input->post('panjang_badan');
			}
			$db->where('KD_PASIEN', $id);
			$db->update('pasien', $dataexc);
			if ($db->trans_status() === FALSE)
			{
				$db->trans_rollback();
				die('Maaf Proses Insert Data Gagal');
			}
			else
			{
				$db->trans_commit();
				die('OK');
			}
		}
	}
	public function daftarkunjunganprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		if($this->input->post('showhide_kunjungan')){
			if($this->input->post('showhide_kunjungan')=='rawat_jalan'){
				$val->set_rules('unit_layanan', 'Unit Layanan', 'trim|required|xss_clean');
				$val->set_rules('poliklinik', 'Poliklinik', 'trim|required|xss_clean');
				if($this->input->post('poliklinik')=='219'){
					$val->set_rules('kategori_kia', 'Kategori KIA', 'trim|required|xss_clean');
					if($this->input->post('kategori_kia')==1){
						if($this->input->post('nama_suami')){
							$val->set_rules('tempat_lahir_suami','Tempat Lahir','trim|required|xss_clean');
							$val->set_rules('tanggal_lahir_suami','Tanggal Lahir','trim|required|xss_clean');
						}
					}elseif($this->input->post('kategori_kia')==2){
						$val->set_rules('nama_ibu_pasien','Nama Ibu','trim|required|xss_clean');
						$val->set_rules('tempat_lahir_ibu','Tempat Lahir','trim|required|xss_clean');
						$val->set_rules('tanggal_lahir_ibu','Tanggal Lahir','trim|required|xss_clean');
						if($this->input->post('nama_ayah_pasien')){
							$val->set_rules('tempat_lahir_ayah','Tempat Lahir','trim|required|xss_clean');
							$val->set_rules('tanggal_lahir_ayah','Tanggal Lahir','trim|required|xss_clean');
						}
					}
				}
			}elseif($this->input->post('showhide_kunjungan')=='rawat_inap'){
				$val->set_rules('spesialisasi', 'Spesialisasi', 'trim|required|xss_clean');
				/*$val->set_rules('ruangan', 'Ruangan', 'trim|required|xss_clean');
				$val->set_rules('kelas', 'Kelas', 'trim|required|xss_clean');
				$val->set_rules('kamar', 'Kamar', 'trim|required|xss_clean');*/
			}else{
				$val->set_rules('unit_layanan', 'Unit Layanan', 'trim|required|xss_clean');
			}
		}
		if ($val->run() == FALSE)
		{
			$val->set_error_delimiters('<div style="color:white">', '</div>');
			die(validation_errors());
		}
		else
		{
			$db = $this->load->database('sikda', TRUE);
			$db->trans_begin();
			if($this->input->post('jenis_pasien')){
				$db->where('KD_PASIEN',$this->input->post('kd_pasien_hidden',TRUE));
				$db->set('KD_CUSTOMER',$this->input->post('jenis_pasien'));
				$db->update('pasien');
			}
			$dataexc = array(
				'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
				'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
				'PETUGAS2' => $this->input->post('petugas2')?$this->input->post('petugas2',TRUE):NULL,
				'KD_DOKTER' => $this->session->userdata('kd_petugas'),
				'TGL_MASUK' => date('Y-m-d'),	
			);

			$this->daftarkunjunganprocessfunction($db,$dataexc,'',$val);

			if ($db->trans_status() === FALSE)
			{
				$db->trans_rollback();
				die('Maaf Proses Insert Data Gagal');
			}
			else
			{
				$db->trans_commit();
				die('OK');
			}
		}
	}
	
	function daftarkunjunganprocessfunction($db,$datainsert,$dataexc,$val)
	{
		// echo($this->input->post('kd_puskesmas_hidden'));
		// echo "\r\n";
		// die($this->input->post('poliklinik'));
			$data_insert_trans_kia = null;
			$is_insert_kunjungan_bersalin = null;
			$arraykeadaanbayi = $this->input->post('keadaanbayi_final')?json_decode($this->input->post('keadaanbayi_final',TRUE)):NULL;
			$arrayasuhanbayi = $this->input->post('asuhanbayi_final')?json_decode($this->input->post('asuhanbayi_final',TRUE)):NULL;
			if($this->input->post('showhide_kunjungan')){
				$puskesmas = $this->input->post('kd_puskesmas_hidden')?$this->input->post('kd_puskesmas_hidden',TRUE):$this->session->userdata('kd_puskesmas');
				if($this->input->post('showhide_kunjungan')=='rawat_jalan'){
					$datainsert['KD_UNIT_LAYANAN'] = $this->input->post('unit_layanan',TRUE);
					$datainsert['KD_UNIT'] = $this->input->post('poliklinik',TRUE);
					$datainsert['KD_LAYANAN_B'] = 'RJ';
					if($this->input->post('poliklinik')==219){
						$idpasien = $this->input->post('kd_pasien_hidden')?$this->input->post('kd_pasien_hidden'):$dataexc['KD_PASIEN'];

						//mendapatkan data kd family folder dari si pasien
						$a = $db->query("SELECT f.KD_FAMILY_FOLDER FROM family_folder f JOIN pasien p ON f.ID_FAMILY_FOLDER=p.ID_FAMILY_FOLDER WHERE p.KD_PASIEN='".$idpasien."'")->row();
				//echo print_r($a);///////////////////////////////////////////
				
				// die($a->KD_FAMILY_FOLDER);
						if($this->input->post('kategori_kia')==1){
							$maxkia = $db->query("select max(kj.URUT_MASUK) as total from kunjungan kj join trans_kia tk on kj.ID_KUNJUNGAN=tk.ID_KUNJUNGAN where kj.KD_PUSKESMAS='".$puskesmas."' and kj.KD_UNIT='".$this->input->post('poliklinik',TRUE)."' and kj.TGL_MASUK= CURDATE()")->row();

							$maxkia = $maxkia->total + 1;

							// $kdk1 = date('Y-m-d').'-'.'219'.'-'.$this->input->post('kategori_kia').'-'.$maxkia;

							$this->load->model('m_kunjungan');							 
							$str_identifier = date('Y-m-d').'-'.'219'.'-'.$this->input->post('kategori_kia').'-';
							$kdk1 = $this->m_kunjungan->getNextKodeKunjungan($str_identifier, $maxkia);

							// echo $this->input->post('nama_suami');

							$datainsert['KD_KUNJUNGAN'] = $kdk1;
							$datainsert['URUT_MASUK'] = $maxkia;
							if($this->input->post('nama_suami')){

								//cek apakah si pasien sudah punya suami
								$check1 = $db->query("SELECT a.KD_PASIEN FROM pasien a JOIN family_folder b ON a.ID_FAMILY_FOLDER=b.ID_FAMILY_FOLDER WHERE KD_FAMILY_FOLDER='".$a->KD_FAMILY_FOLDER."' AND b.KD_STATUS_KELUARGA=1",false)->row();
								// echo $db->last_query();
								if(empty($check1->KD_PASIEN)){
									// echo "tidak ada suami";
									
									// tambah data family folder yang menandakan data suami dengan kd status keluarga adalah 1
									$datafamilysuami = array(
										'KD_FAMILY_FOLDER' => $a->KD_FAMILY_FOLDER,
										'NO_KK' => $this->input->post('no_kk')?$this->input->post('no_kk'):NULL,
										'NAMA_KK' => $this->input->post('nama_kk')?$this->input->post('nama_kk'):NULL,
										'KD_STATUS_KELUARGA' => $this->input->post('status_keluarga')?$this->input->post('status_keluarga'):1,
										'ninput_oleh' => $this->session->userdata('user_name'),
										'ninput_tgl' => date('Y-m-d')
									);
							// echo print_r($datafamilysuami);
							// die();
									$db->insert('family_folder',$datafamilysuami);

									//idsuami adalah id family folder dari data family folder yang baru saja dimasukkan
									//pada pasien, id family folder di auto generate dengan mendapatkan max KD_FAMILY_FOLDER ditambah dengan 1
									$idsuami = $db->insert_id(); 
									$idpas = $db->query("SELECT MAX(SUBSTR(kd_pasien,-7)) AS total FROM pasien where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();

									//masukkan data suami sebagai pasien baru
									$dataexcsuami = array(
										'NAMA_LENGKAP' => $val->set_value('nama_suami')?$val->set_value('nama_suami'):$this->input->post('nama_suami'),
										'TGL_LAHIR' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_lahir_suami')))),
										'TEMPAT_LAHIR' => $val->set_value('tempat_lahir_suami')?$val->set_value('tempat_lahir_suami'):$this->input->post('tempat_lahir_suami',true),
										'KD_PASIEN'=> $this->session->userdata('kd_puskesmas').sprintf("%07d",$idpas->total+1),
										'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
										'KD_JENIS_KELAMIN' => 'L',
										'KD_KABKOTA' => $this->input->post('kabupaten_kota')?$this->input->post('kabupaten_kota',TRUE):NULL,
										'KD_KECAMATAN' => $this->input->post('kecamatan')?$this->input->post('kecamatan',TRUE):NULL,
										'KD_KELURAHAN' => $this->input->post('desa_kelurahan')?$this->input->post('desa_kelurahan',TRUE):NULL,
										'KD_POS' => $this->input->post('kode_pos')?$this->input->post('kode_pos',TRUE):NULL,
										'TELEPON' => $this->input->post('no_tlp')?$this->input->post('no_tlp',TRUE):NULL,
										'KD_PENDIDIKAN' => $this->input->post('pendidikan_suami')?$this->input->post('pendidikan_suami',TRUE):NULL,
										'KD_PEKERJAAN' => $this->input->post('pekerjaan_suami')?$this->input->post('pekerjaan_suami',TRUE):NULL,
										'KD_AGAMA' => $this->input->post('agama_suami')?$this->input->post('agama_suami',TRUE):NULL,
										'KD_GOL_DARAH' => $this->input->post('gol_darah_suami')?$this->input->post('gol_darah_suami',TRUE):NULL,
										'KK' => $this->input->post('nama_kk')?$this->input->post('nama_kk',TRUE):NULL,
										'STATUS_MARITAL' => $this->input->post('status_nikah')?$this->input->post('status_nikah',TRUE):1,
										'ALAMAT' => $this->input->post('alamat')?$this->input->post('alamat',TRUE):NULL,
										'ID_FAMILY_FOLDER' =>$idsuami,
										'JENIS_DATA' => 'X',
										'KD_PROVINSI' => $this->input->post('provinsi')?$this->input->post('provinsi',TRUE):NULL,
										'TGL_PENDAFTARAN' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_daftar')))),
										'Created_By' => $this->session->userdata('user_name'),
										'Created_Date' => date('Y-m-d H:i:s')
									);
							// die();
									$db->insert('pasien', $dataexcsuami);
								}else{
									$dataexcsuami = array(
										'NAMA_LENGKAP' => $val->set_value('nama_suami')?$val->set_value('nama_suami'):$this->input->post('nama_suami'),
										'TGL_LAHIR' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_lahir_suami')))),
										'TEMPAT_LAHIR' => $val->set_value('tempat_lahir_suami')?$val->set_value('tempat_lahir_suami'):$this->input->post('tempat_lahir_suami',true),
										'KD_PENDIDIKAN' => $this->input->post('pendidikan_suami')?$this->input->post('pendidikan_suami',TRUE):NULL,
										'KD_PEKERJAAN' => $this->input->post('pekerjaan_suami')?$this->input->post('pekerjaan_suami',TRUE):NULL,
										'KD_AGAMA' => $this->input->post('agama_suami')?$this->input->post('agama_suami',TRUE):NULL,
										'KD_GOL_DARAH' => $this->input->post('gol_darah_suami')?$this->input->post('gol_darah_suami',TRUE):NULL,
										'Updated_By' => $this->session->userdata('user_name'),
										'Updated_Date' => date('Y-m-d H:i:s')
									);
									$db->where('KD_PASIEN',$check1->KD_PASIEN);
							// echo "sudah bersuami";
							// die();
									$db->update('pasien', $dataexcsuami);
								}
							}
							// echo "habis cek suami";
							// die();
							
							if($this->input->post('kategori_kia')){

								//get KD_PASIEN & KD_PUSKESMAS
								// $get_kd_pasien = $this->input->post('kd_pasien_hidden',TRUE);
								// $get_kd_puskesmas = $this->input->post('kd_puskesmas_hidden',TRUE);	
								// $dataexc_kesehatanibu['KD_PASIEN'] = $idpasien;	
								// $dataexc_kesehatanibu['KD_PUSKESMAS'] = $puskesmas;
								//BUG 
								//KD_DOKTER_PEMERIKSA = POST(PEMERIKSA) -> POST (PETUGAS2)
								//set :NULL to :NULL, KD_DOKTER_PEMERIKSA
								$dataexc_kesehatanibu['KD_DOKTER_PEMERIKSA'] = $this->input->post('petugas2')?$this->input->post('petugas2',TRUE):NULL;
								$dataexc_kesehatanibu['KD_DOKTER_PETUGAS'] = $this->input->post('petugas')?$this->input->post('petugas',TRUE):NULL;
								$dataexc_kesehatanibu['KD_KATEGORI_KIA'] = $this->input->post('kategori_kia');
								$dataexc_kesehatanibu['KD_KUNJUNGAN'] = $kdk1;
								$dataexc_kesehatanibu['KD_UNIT_PELAYANAN'] = $this->input->post('unit_layanan');
								$dataexc_kesehatanibu['ninput_oleh'] = $this->session->userdata('user_name');
								$dataexc_kesehatanibu['ninput_tgl'] = date('Y-m-d');

								$data_insert_trans_kia = $dataexc_kesehatanibu;
								//$db->insert('trans_kia', $dataexc_kesehatanibu);	
							}
						}elseif($this->input->post('kategori_kia')==2){
							$maxkia2 = $db->query("select max(kj.URUT_MASUK) as total from kunjungan kj join trans_kia tk on kj.ID_KUNJUNGAN=tk.ID_KUNJUNGAN where kj.KD_PUSKESMAS='".$puskesmas."' and kj.KD_UNIT='".$this->input->post('poliklinik',TRUE)."' and kj.TGL_MASUK= CURDATE()")->row();
							$maxkia2 = $maxkia2->total + 1;
							$kdk2 = date('Y-m-d').'-'.'219'.'-'.$this->input->post('kategori_kia').'-'.$maxkia2;
							$datainsert['KD_KUNJUNGAN'] = $kdk2;
							$datainsert['URUT_MASUK'] = $maxkia2;
							$checkibu = $db->query("SELECT a.KD_PASIEN FROM pasien a JOIN family_folder b ON a.ID_FAMILY_FOLDER=b.ID_FAMILY_FOLDER WHERE KD_FAMILY_FOLDER='".$a->KD_FAMILY_FOLDER."' AND b.KD_STATUS_KELUARGA=2",false)->row();
							if($this->input->post('nama_ibu_pasien')){
								if(empty($checkibu->KD_PASIEN)){
									$datafamilyibu = array(
										'KD_FAMILY_FOLDER' => $a->KD_FAMILY_FOLDER,
										'NO_KK' => $this->input->post('no_kk')?$this->input->post('no_kk'):NULL,
										'NAMA_KK' => $this->input->post('nama_kk')?$this->input->post('nama_kk'):NULL,
										'KD_STATUS_KELUARGA' => $this->input->post('status_keluarga')?$this->input->post('status_keluarga'):2,
										'ninput_oleh' => $this->session->userdata('user_name'),
										'ninput_tgl' => date('Y-m-d')
										);
									$db->insert('family_folder',$datafamilyibu);
									$idibu = $db->insert_id();
									$max4 = $db->query("SELECT MAX(SUBSTR(kd_pasien,-7)) AS total FROM pasien where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
									$max4 = $max4->total + 1;
									$dataibu= array(
													'ID_FAMILY_FOLDER' => $idibu,
													'NAMA_LENGKAP' => $this->input->post('nama_ibu_pasien'),
													'KD_PASIEN'=> $this->session->userdata('kd_puskesmas').sprintf("%07d", $max4),
													'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
													'TGL_PENDAFTARAN' => date('Y-m-d H:i:s'),
													'KD_JENIS_KELAMIN' => 'P',
													'ALAMAT' => $this->input->post('alamat')?$this->input->post('alamat',TRUE):NULL,
													'KD_KABKOTA' => $this->input->post('kabupaten_kota')?$this->input->post('kabupaten_kota',TRUE):NULL,
													'KD_KECAMATAN' => $this->input->post('kecamatan')?$this->input->post('kecamatan',TRUE):NULL,
													'KD_KELURAHAN' => $this->input->post('desa_kelurahan')?$this->input->post('desa_kelurahan',TRUE):NULL,
													'KD_POS' => $this->input->post('kode_pos')?$this->input->post('kode_pos',TRUE):NULL,
													'NO_KK' => $this->input->post('no_kk')?$this->input->post('no_kk'):NULL,
													'KK' => $this->input->post('nama_kk')?$this->input->post('nama_kk',TRUE):NULL,
													'KD_PROVINSI' => $this->input->post('provinsi')?$this->input->post('provinsi',TRUE):NULL,
													'TEMPAT_LAHIR' => $this->input->post('tempat_lahir_ibu'),
													'TGL_LAHIR' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_lahir_ibu')))),
													'KD_AGAMA' => $this->input->post('agama_ibu')?$this->input->post('agama_ibu'):NULL,
													'KD_GOL_DARAH' => $this->input->post('gol_darah_ibu')?$this->input->post('gol_darah_ibu'):NULL,
													'KD_PENDIDIKAN' => $this->input->post('pendidikan_ibu')?$this->input->post('pendidikan_ibu'):NULL,
													'KD_PEKERJAAN' => $this->input->post('pekerjaan_ibu')?$this->input->post('pekerjaan_ibu'):NULL,
													'STATUS_MARITAL' => '1',
													'JENIS_DATA' => 'X',
													'Created_By' => $this->session->userdata('user_name'),
													'Created_Date' => date('Y-m-d H:i:s')
													);
									$db->insert('pasien',$dataibu);
								}else{
									$dataibu= array(
												'NAMA_LENGKAP' => $this->input->post('nama_ibu_pasien'),
												'TEMPAT_LAHIR' => $this->input->post('tempat_lahir_ibu'),
												'TGL_LAHIR' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_lahir_ibu')))),
												'KD_AGAMA' => $this->input->post('agama_ibu')?$this->input->post('agama_ibu'):NULL,
												'KD_GOL_DARAH' => $this->input->post('gol_darah_ibu')?$this->input->post('gol_darah_ibu'):NULL,
												'KD_PENDIDIKAN' => $this->input->post('pendidikan_ibu')?$this->input->post('pendidikan_ibu'):NULL,
												'KD_PEKERJAAN' => $this->input->post('pekerjaan_ibu')?$this->input->post('pekerjaan_ibu'):NULL,
												'Updated_By' => $this->session->userdata('user_name'),
												'Updated_Date' => date('Y-m-d H:i:s')
												);
									$db->where('KD_PASIEN',$checkibu->KD_PASIEN);
									$db->update('pasien',$dataibu);
									/*$kd_ibu = empty($checkibu->KD_PASIEN)?$dataibu['KD_PASIEN']:$checkibu->KD_PASIEN;
									$kj = $db->query("select KD_KUNJUNGAN_BERSALIN from kunjungan_bersalin where KD_PASIEN='".$kd_ibu."'")->row();print_r($kj);die;
									$kunjungan = $kj->KD_KUNJUNGAN_BERSALIN;
									
									if($arraykeadaanbayi){
										$db->where('KD_KUNJUNGAN_BERSALIN',$kunjungan);
										$db->delete('detail_keadaan_bayi');
										foreach($arraykeadaanbayi as $rowkeadaanbayiloop){
											$datakeadaanbayitmp = json_decode($rowkeadaanbayiloop);
											$datakeadaanbayiloop[] = array(
												'KD_KUNJUNGAN_BERSALIN' => $kunjungan,
												'KD_KEADAAN_BAYI_LAHIR' => $datakeadaanbayitmp->kd_keadaan_bayi_lahir,
												'KEADAAN_BAYI_LAHIR' => $datakeadaanbayitmp->keadaan_bayi_lahir
											);
											$datakeadaanbayiinsert = $datakeadaanbayiloop;
										}
										$db->insert_batch('detail_keadaan_bayi',$datakeadaanbayiinsert);
									}
									
									if($arrayasuhanbayi){
										$db->where('KD_KUNJUNGAN_BERSALIN',$kunjungan);
										$db->delete('detail_asuhan_bayi');
										foreach($arrayasuhanbayi as $rowasuhanbayiloop){
											$dataasuhanbayitmp = json_decode($rowasuhanbayiloop);
											$dataasuhanbayiloop[] = array(
												'KD_KUNJUNGAN_BERSALIN' => $kunjungan,
												'KD_ASUHAN_BAYI_LAHIR' => $dataasuhanbayitmp->kd_asuhan_bayi_lahir,
												'ASUHAN_BAYI_LAHIR' => $dataasuhanbayitmp->asuhan_bayi_lahir
											);
											$dataasuhanbayiinsert = $dataasuhanbayiloop;
										}
										$db->insert_batch('detail_asuhan_bayi',$dataasuhanbayiinsert);
									}*/
								}
							}
							if($this->input->post('nama_ayah_pasien')){
								$checkayah = $db->query("SELECT a.KD_PASIEN FROM pasien a JOIN family_folder b ON a.ID_FAMILY_FOLDER=b.ID_FAMILY_FOLDER WHERE KD_FAMILY_FOLDER='".$a->KD_FAMILY_FOLDER."' AND b.KD_STATUS_KELUARGA=1",false)->row();
								if(empty($checkayah->KD_PASIEN)){
									$datafamilyayah = array(
										'KD_FAMILY_FOLDER' => $a->KD_FAMILY_FOLDER,
										'NO_KK' => $this->input->post('no_kk')?$this->input->post('no_kk'):NULL,
										'NAMA_KK' => $this->input->post('nama_kk')?$this->input->post('nama_kk'):NULL,
										'KD_STATUS_KELUARGA' => $this->input->post('status_keluarga')?$this->input->post('status_keluarga'):1,
										'ninput_oleh' => $this->session->userdata('user_name'),
										'ninput_tgl' => date('Y-m-d')
										);
									$db->insert('family_folder',$datafamilyayah);
									$idayah = $db->insert_id();
									$max4 = $db->query("SELECT MAX(SUBSTR(kd_pasien,-7)) AS total FROM pasien where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
									$max4 = $max4->total + 1;
									$dataayah= array(
													'ID_FAMILY_FOLDER' => $idayah,
													'NAMA_LENGKAP' => $this->input->post('nama_ayah_pasien'),
													'KD_PASIEN'=> $this->session->userdata('kd_puskesmas').sprintf("%07d", $max4),
													'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
													'TGL_PENDAFTARAN' => date('Y-m-d H:i:s'),
													'KD_JENIS_KELAMIN' => 'L',
													'ALAMAT' => $this->input->post('alamat')?$this->input->post('alamat',TRUE):NULL,
													'KD_KABKOTA' => $this->input->post('kabupaten_kota')?$this->input->post('kabupaten_kota',TRUE):NULL,
													'KD_KECAMATAN' => $this->input->post('kecamatan')?$this->input->post('kecamatan',TRUE):NULL,
													'KD_KELURAHAN' => $this->input->post('desa_kelurahan')?$this->input->post('desa_kelurahan',TRUE):NULL,
													'KD_POS' => $this->input->post('kode_pos')?$this->input->post('kode_pos',TRUE):NULL,
													'NO_KK' => $this->input->post('no_kk')?$this->input->post('no_kk'):NULL,
													'KK' => $this->input->post('nama_kk')?$this->input->post('nama_kk',TRUE):NULL,
													'KD_PROVINSI' => $this->input->post('provinsi')?$this->input->post('provinsi',TRUE):NULL,
													'TEMPAT_LAHIR' => $this->input->post('tempat_lahir_ayah'),
													'TGL_LAHIR' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_lahir_ayah')))),
													'KD_AGAMA' => $this->input->post('agama_ayah')?$this->input->post('agama_ayah'):NULL,
													'KD_GOL_DARAH' => $this->input->post('gol_darah_ayah')?$this->input->post('gol_darah_ayah'):NULL,
													'KD_PENDIDIKAN' => $this->input->post('pendidikan_ayah')?$this->input->post('pendidikan_ayah'):NULL,
													'KD_PEKERJAAN' => $this->input->post('pekerjaan_ayah')?$this->input->post('pekerjaan_ayah'):NULL,
													'STATUS_MARITAL' => '1',
													'JENIS_DATA' => 'X',
													'Created_By' => $this->session->userdata('user_name'),
													'Created_Date' => date('Y-m-d H:i:s')
													);
									$db->insert('pasien',$dataayah);
								}else{
									$dataayah= array(
												'NAMA_LENGKAP' => $this->input->post('nama_ayah_pasien'),
												'TEMPAT_LAHIR' => $this->input->post('tempat_lahir_ayah'),
												'TGL_LAHIR' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_lahir_ayah')))),
												'KD_AGAMA' => $this->input->post('agama_ayah')?$this->input->post('agama_ayah'):NULL,
												'KD_GOL_DARAH' => $this->input->post('gol_darah_ayah')?$this->input->post('gol_darah_ayah'):NULL,
												'KD_PENDIDIKAN' => $this->input->post('pendidikan_ayah')?$this->input->post('pendidikan_ayah'):NULL,
												'KD_PEKERJAAN' => $this->input->post('pekerjaan_ayah')?$this->input->post('pekerjaan_ayah'):NULL,
												'Updated_By' => $this->session->userdata('user_name'),
												'Updated_Date' => date('Y-m-d H:i:s')
												);
									$db->where('KD_PASIEN',$checkayah->KD_PASIEN);
									$db->update('pasien',$dataayah);
								}
							}
							if($this->input->post('kategori_kia')){
								$dataexc_kesehatananak['KD_DOKTER_PEMERIKSA'] = $this->input->post('petugas2')?$this->input->post('petugas2',TRUE):NULL;
								$dataexc_kesehatananak['KD_DOKTER_PETUGAS'] = $this->input->post('petugas')?$this->input->post('petugas',TRUE):NULL;
								$dataexc_kesehatananak['KD_KATEGORI_KIA'] = $this->input->post('kategori_kia');
								$dataexc_kesehatananak['KD_KUNJUNGAN'] = $kdk2;
								$dataexc_kesehatananak['KD_UNIT_PELAYANAN'] = $this->input->post('unit_layanan');
								$dataexc_kesehatananak['ninput_oleh'] = $this->session->userdata('user_name');
								$dataexc_kesehatananak['ninput_tgl'] = date('Y-m-d');

								$data_insert_trans_kia = $dataexc_kesehatananak;

								// $db->insert('trans_kia', $dataexc_kesehatananak);
								$is_insert_kunjungan_bersalin = true;
								// $kd_kia=$db->insert_id();
								// if($this->input->post('ket')){
								// 	$dataket= array(
								// 					'KET_TAMBAHAN' => $this->input->post('ket'),
								// 					'KD_KIA'=> $kd_kia,
								// 					'ninput_oleh'=>$this->session->userdata('user_name'),
								// 					'ninput_tgl'=> date('Y-m-d')
								// 					);
								// 	$db->where('KD_PASIEN',$kd_ibu);
								// 	$db->update('kunjungan_bersalin',$dataket);
								// }
							}
							
						}elseif($this->input->post('kategori_kia')==3){
							$max3 = $db->query("select max(kj.URUT_MASUK) as total from kunjungan kj left join trans_kia tk on kj.ID_KUNJUNGAN=tk.ID_KUNJUNGAN where kj.KD_PUSKESMAS='".$puskesmas."' and kj.KD_UNIT='".$this->input->post('poliklinik',TRUE)."' and kj.TGL_MASUK= CURDATE()")->row();
							$max3 = $max3->total + 1;
							$kdk = date('Y-m-d').'-219-3-'.$max3;
							$datainsert['KD_KUNJUNGAN'] = $kdk;
							$datainsert['URUT_MASUK'] = $max3;
							
							$kia['KD_DOKTER_PEMERIKSA'] = $this->input->post('petugas2')?$this->input->post('petugas2',TRUE):NULL;
							$kia['KD_DOKTER_PETUGAS'] = $this->input->post('petugas')?$this->input->post('petugas',TRUE):NULL;
							$kia['KD_KATEGORI_KIA'] = $this->input->post('kategori_kia');
							$kia['KD_KUNJUNGAN'] = $kdk;
							$kia['KD_UNIT_PELAYANAN'] = $this->input->post('unit_layanan');
							$kia['ninput_oleh'] = $this->session->userdata('user_name');
							$kia['ninput_tgl'] = date('Y-m-d');
							// $db->insert('trans_kia', $kia);
							$data_insert_trans_kia = $kia;
						}
					}else{
						$max = $db->query("select max(URUT_MASUK) as total from kunjungan where KD_PUSKESMAS='".$puskesmas."' and KD_UNIT='".$this->input->post('poliklinik',TRUE)."' and TGL_MASUK= CURDATE() ")->row();
						$max = $max->total + 1;
						$kdk = date('Y-m-d').'-'.$this->input->post('poliklinik',TRUE).'-'.$max;
						$datainsert['KD_KUNJUNGAN'] = $kdk;
						$datainsert['URUT_MASUK'] = $max;
					}	
				}elseif($this->input->post('showhide_kunjungan')=='rawat_inap'){
					$max = $db->query("select max(URUT_MASUK) as total from kunjungan where KD_PUSKESMAS='".$puskesmas."' and KD_UNIT='".$this->input->post('spesialisasi',TRUE)."' and TGL_MASUK= CURDATE() ")->row();
					$max = $max->total + 1;
					$datainsert['KD_UNIT'] = $this->input->post('spesialisasi',TRUE);
					$datainsert['KD_UNIT_LAYANAN'] = $this->session->userdata('level_aplikasi');
					$kdk = date('Y-m-d').'-'.$this->input->post('spesialisasi',TRUE).'-'.$max;
					$datainsert['KD_KUNJUNGAN'] = $kdk;
					$datainsert['URUT_MASUK'] = $max;
					$datainsert['KD_LAYANAN_B'] = 'RI';
					$datainsert['KD_RUANGAN'] = $this->input->post('ruangan',TRUE);
					$datainsert['KD_KELAS'] = $this->input->post('kelas',TRUE);
					$datainsert['NAMA_KAMAR'] = $this->input->post('kamar',TRUE);
					$datainsert['NO_KAMAR'] = $this->input->post('kamar',TRUE);
					$datainsert['NO_BED'] = $this->input->post('no_tidur',TRUE);
					/*$val->set_rules('spesialisasi', 'Spesialisasi', 'trim|required|xss_clean');
					$val->set_rules('ruangan', 'Ruangan', 'trim|required|xss_clean');
					$val->set_rules('kelas', 'Kelas', 'trim|required|xss_clean');
					$val->set_rules('kamar', 'Kamar', 'trim|required|xss_clean');*/
				}else{
					$max = $db->query("select max(URUT_MASUK) as total from kunjungan where KD_PUSKESMAS='".$puskesmas."' and KD_UNIT='".$this->input->post('spesialisasi',TRUE)."' and TGL_MASUK= CURDATE() ")->row();
					$max = $max->total + 1;
					$datainsert['KD_UNIT_LAYANAN'] = $this->input->post('unit_layanan',TRUE);
					$kdk = date('Y-m-d').'-'.$max;
					$datainsert['KD_KUNJUNGAN'] = $kdk;
					$datainsert['URUT_MASUK'] = $max;
					$datainsert['KD_LAYANAN_B'] = 'RD';
				}
			}


		$db->insert('kunjungan',$datainsert);

		if(!empty($data_insert_trans_kia)){
			$data_insert_trans_kia['ID_KUNJUNGAN'] = $db->insert_id();
			$data_insert_trans_kia['KD_PASIEN'] = $idpasien;
			$data_insert_trans_kia['KD_PUSKESMAS'] = $puskesmas;
			$db->insert('trans_kia',$data_insert_trans_kia);
			if(!empty($is_insert_kunjungan_bersalin)){
				$kd_kia=$db->insert_id();
				if($this->input->post('ket')){
					$dataket= array(
									'KET_TAMBAHAN' => $this->input->post('ket'),
									'KD_KIA'=> $kd_kia,
									'ninput_oleh'=>$this->session->userdata('user_name'),
									'ninput_tgl'=> date('Y-m-d')
									);
					$db->where('KD_PASIEN',$kd_ibu);
					$db->update('kunjungan_bersalin',$dataket);
				}
			}
		}
	}	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
	public function ubahkunjungan()
	{
		
		// IF UNIT THEN VIEW ACCORDING TO SELECTED UNIT
		// IF UNIT THEN VIEW ACCORDING TO SELECTED UNIT
		// IF UNIT THEN VIEW ACCORDING TO SELECTED UNIT
		
		$this->load->helper('beries_helper');
		$this->load->helper('my_helper');
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$unit = $db->query("select * from kunjungan where KD_KUNJUNGAN='".$id."' and KD_PUSKESMAS='".$id2."' and KD_UNIT=219")->row();
		if($unit){
			$db->select("k.KD_KUNJUNGAN,NAMA_LENGKAP AS NAMA_PASIEN,k.KD_UNIT_LAYANAN,k.KD_UNIT,k.KD_DOKTER,k.KD_PUSKESMAS,t.KD_KATEGORI_KIA",FALSE);
			$db->from('kunjungan k');
			$db->join('pasien p','k.KD_PASIEN=p.KD_PASIEN');
			$db->join('trans_kia t','k.KD_KUNJUNGAN=t.KD_KUNJUNGAN','left');
			$db->where('k.KD_KUNJUNGAN ',$id);
			$db->where('k.KD_PUSKESMAS',$id2);
			$val = $db->get()->row();
			$data['data']=$val;		
			$this->load->view('t_pendaftaran/v_t_pendaftaran_edit_kunjungan_kia',$data);
		}else{
			$db->select("k.KD_KUNJUNGAN,NAMA_LENGKAP AS NAMA_PASIEN,k.KD_UNIT_LAYANAN,k.KD_UNIT,k.KD_DOKTER,k.KD_PUSKESMAS",FALSE);
			$db->from('kunjungan k');
			$db->join('pasien p','k.KD_PASIEN=p.KD_PASIEN');
			//$db->join('mst_unit u','k.KD_UNIT=p.KD_UNIT');
			$db->where('k.KD_KUNJUNGAN ',$id);
			$db->where('k.KD_PUSKESMAS',$id2);
			$val = $db->get()->row();
			$data['data']=$val;		
			$this->load->view('t_pendaftaran/v_t_pendaftaran_edit_kunjungan',$data);
		}
	}	
	public function ubahkunjunganprocess()
	{
		$id = $this->input->post('id',TRUE);
		$kd_puskesmas = $this->input->post('kd_puskesmas',TRUE);
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('unit_layanan', 'Unit Layanan', 'trim|required|xss_clean');
		$val->set_rules('poliklinik', 'Poliklinik', 'trim|required|xss_clean');

		if ($val->run() == FALSE)
		{
			$val->set_error_delimiters('<div style="color:white">', '</div>');
			die(validation_errors());
		}
		else
		{						
			$db = $this->load->database('sikda', TRUE);
			$db->trans_begin();
			if($this->input->post('poliklinik')==219){
				$maxkiabaru = $db->query("select max(kj.URUT_MASUK) as total from kunjungan kj join trans_kia tk on kj.ID_KUNJUNGAN=tk.ID_KUNJUNGAN where kj.KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' and kj.KD_UNIT=219")->row();
				$maxkiabaru = $maxkiabaru->total + 1;
				$kdkunjunganbaru = date('Y-m-d').'-'.'219'.'-'.$this->input->post('kategori_kia').'-'.$maxkiabaru;
				
				$mch = $db->query("select id_kunjungan as ikj, kd_pasien as kp, petugas2 as petugas2 from kunjungan where KD_KUNJUNGAN='".$id."'")->row();
								
				$lihatdatatrans = $db->query("select * from trans_kia where ID_KUNJUNGAN='".$id."'")->row();
				if($lihatdatatrans){
					$datakia = array(
						
						'KD_UNIT_PELAYANAN' => $val->set_value('unit_layanan'),
						'KD_KUNJUNGAN' => $kdkunjunganbaru,
						'KD_KATEGORI_KIA' => $this->input->post('kategori_kia')
					);
					/*if($this->input->post('kategori_kia')=='1' or $this->input->post('kategori_kia')=='2'){
						$datakia['KD_KUNJUNGAN_KIA'] = $this->input->post('kategori_kia')==1?$this->input->post('kunjungan_kia_ibu'):$this->input->post('kunjungan_kia_anak');
					}*/
					$db->where('KD_KUNJUNGAN',$id);
					$db->update('trans_kia', $datakia);
				}else{
					$datakia = array(
							'ID_KUNJUNGAN' => $mch->ikj,
							'KD_DOKTER_PEMERIKSA' => $mch ->petugas2,
							'KD_PASIEN' => $mch->kp,
							'KD_PUSKESMAS' => $this->input->post('kd_puskesmas'),
							'KD_UNIT_PELAYANAN' => $val->set_value('unit_layanan'),
							'KD_KUNJUNGAN' => $kdkunjunganbaru,
							'KD_KATEGORI_KIA' => $this->input->post('kategori_kia'),
							'KD_DOKTER_PETUGAS' => $this->input->post('petugas'),
							//'KD_KUNJUNGAN_KIA' => '',//$this->input->post('kategori_kia')==1?$this->input->post('kunjungan_kia_ibu'):$this->input->post('kunjungan_kia_anak'),
							'ninput_oleh' => $this->session->userdata('user_name'),
							'ninput_tgl' => date("Y-m-d")
					);
					//die("$id");
					$db->insert('trans_kia', $datakia);
				}	
				$db->where('KD_KUNJUNGAN',$id);
				$db->where('KD_PUSKESMAS',$kd_puskesmas);
				$kunjungankiaupdate = array(
					'KD_UNIT' => $val->set_value('poliklinik'),
					'KD_KUNJUNGAN' => $datakia['KD_KUNJUNGAN'],
					'URUT_MASUK' => $maxkiabaru
				);
				$db->update('kunjungan',$kunjungankiaupdate);	
			}else{
				$maxkiabaruadd = $db->query("select max(URUT_MASUK) as total from kunjungan where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' and KD_UNIT='".$this->input->post('poliklinik')."' ")->row();
				$maxkiabaruadd = $maxkiabaruadd->total + 1;
				$kdkunjungannew = date('Y-m-d').'-'.$this->input->post('poliklinik').'-'.$maxkiabaruadd;
				$dataexc = array(
					'KD_KUNJUNGAN' => $kdkunjungannew,
					'KD_UNIT_LAYANAN' => $val->set_value('unit_layanan'),
					'KD_UNIT' => $val->set_value('poliklinik'),
					'Modified_By' => $this->session->userdata('user_name'),
					'Modified_Date' => date('Y-m-d H:i:s'),
					'URUT_MASUK' => $maxkiabaruadd
				);			
				
				$db->where('KD_KUNJUNGAN',$id);
				$db->where('KD_PUSKESMAS',$kd_puskesmas);
				$db->update('kunjungan', $dataexc);
			}
			if ($db->trans_status() === FALSE)
			{
				$db->trans_rollback();
				die('Maaf Proses Insert Data Gagal');
			}
			else
			{
				$db->trans_commit();
				die('OK');
			}
		}
	}
	
	public function gabungprocess()
	{
		$kdpasien1 = $this->input->post('kd_pasien_hidden',TRUE);
		$kdpasien2 = $this->input->post('kd_pasien_selected_hidden',TRUE);
		$kdpuskesmas1 = $this->input->post('kd_puskesmas_hidden',TRUE);		
		$kdpuskesmas2 = $this->input->post('kd_puskesmas_selected_hidden',TRUE);	
		$selectedparent = $this->input->post('id_gabung',TRUE);	
		
		if(!$kdpasien2) die('Silahkan Pilih Pasien yang akan di Gabung');
		
		$db = $this->load->database('sikda', TRUE);
		$db->trans_begin();
		
		if($this->input->post('jenis_pasien')){
				$db->where('KD_PASIEN',$this->input->post('kd_pasien_hidden',TRUE));
				$db->set('KD_CUSTOMER',$this->input->post('jenis_pasien'));
				$db->update('pasien');
		}
			
		$queryGetAllTTable = " SELECT DISTINCT  TABLE_NAME";
		$queryGetAllTTable .= " FROM INFORMATION_SCHEMA.COLUMNS";
		$queryGetAllTTable .= " WHERE COLUMN_NAME IN ('KD_PASIEN') and TABLE_NAME not like 'vw_%' and TABLE_NAME not in ('pasien')";
		$queryGetAllTTable .= " AND TABLE_SCHEMA='".$db->database."'";
	   
		$query = $db->query($queryGetAllTTable);
		if ($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$selectedchild = $kdpasien1==$selectedparent?$kdpasien2:$kdpasien1;
				$queryExecute = "UPDATE ".$row->TABLE_NAME." SET KD_PASIEN = '".$selectedparent."' WHERE KD_PASIEN = '".$selectedchild."'";
				$db->query($queryExecute);			  
			}
		}else{
			die('Proses Gagal Mohon di Ulangi');
		}
		
		if ($db->trans_status() === FALSE)
		{
			$db->trans_rollback();
			die('Maaf Proses Insert Data Gagal');
		}
		else
		{
			$db->trans_commit();
			die('OK');
		}
	}
	
	public function batalkunjunganprocess()
	{
		$id = $this->input->post('id',TRUE);		
		$kd_puskesmas = $this->input->post('kd_puskesmas',TRUE);		
		$this->load->library('form_validation');
		$db = $this->load->database('sikda', TRUE);
		$db->trans_begin();
		
		$db->where('KD_KUNJUNGAN',$id);
		$db->where('KD_PUSKESMAS',$kd_puskesmas);
		$db->delete('kunjungan');
		
		if ($db->trans_status() === FALSE)
		{
			$db->trans_rollback();
			die('Maaf Proses Insert Data Gagal');
		}
		else
		{
			$db->trans_commit();
			die('OK');
		}
	}
	
	public function pendaftaranpelayanan()
	{
		$this->load->helper('beries_helper');
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("NAMA_LENGKAP AS NAMA_PASIEN,p.KD_PASIEN,p.KD_PUSKESMAS,p.TGL_LAHIR,p.NO_PENGENAL AS NIK,p.KET_WIL,p.KD_GOL_DARAH,k.CUSTOMER,f.KD_FAMILY_FOLDER",FALSE);
		$db->from('pasien p');
		$db->join('family_folder f','f.ID_FAMILY_FOLDER=p.ID_FAMILY_FOLDER','left');
		$db->join('mst_kel_pasien k','k.KD_CUSTOMER=p.KD_CUSTOMER','left');
		//$db->join('mst_unit u','k.KD_UNIT=p.KD_UNIT');
		$db->where('p.KD_PASIEN',$id);
		$db->where('p.KD_PUSKESMAS',$id2);
		$val = $db->get()->row();
		$data['data']=$val;
		if(!empty($val)){
			$this->load->view('t_pendaftaran/v_t_pendaftaran_pelayanan',$data);
		}else{
			$db->select("NAMA_LENGKAP AS NAMA_PASIEN,p.KD_PASIEN,p.KD_PUSKESMAS,p.TGL_LAHIR,p.NO_PENGENAL AS NIK,p.KET_WIL,p.KD_GOL_DARAH,p.KD_CUSTOMER as CUSTOMER,f.KD_FAMILY_FOLDER",FALSE);
			$db->from('pasien p');
			$db->join('family_folder f','f.ID_FAMILY_FOLDER=p.ID_FAMILY_FOLDER','left');
			$db->where('p.KD_PASIEN',$id);
			$db->where('p.KD_PUSKESMAS',$id2);
			$val = $db->get()->row();
			$data['data']=$val;
			$this->load->view('t_pendaftaran/v_t_pendaftaran_pelayanan1',$data);
		}
	}
	
	public function gabungpasien()
	{
		$this->load->helper('beries_helper');
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("NAMA_LENGKAP AS NAMA_PASIEN,p.KD_PASIEN,p.KD_PUSKESMAS,p.TGL_LAHIR,p.NO_PENGENAL AS NIK,p.KET_WIL,p.KD_GOL_DARAH,k.CUSTOMER",FALSE);
		$db->from('pasien p');
		$db->join('mst_kel_pasien k','k.KD_CUSTOMER=p.KD_CUSTOMER');
		//$db->join('mst_unit u','k.KD_UNIT=p.KD_UNIT');
		$db->where('p.KD_PASIEN',$id);
		$db->where('p.KD_PUSKESMAS',$id2);
		$val = $db->get()->row();
		$data['data']=$val;		
		if(!empty($val)){
			$this->load->view('t_pendaftaran/v_t_pendaftaran_gabung',$data);
		}else{
			$db->select("NAMA_LENGKAP AS NAMA_PASIEN,KD_PASIEN,KD_PUSKESMAS,TGL_LAHIR,NO_PENGENAL AS NIK,KET_WIL,KD_GOL_DARAH",FALSE);
			$db->from('pasien p');
			$db->where('p.KD_PASIEN',$id);
			$db->where('p.KD_PUSKESMAS',$id2);
			$val = $db->get()->row();
			$data['data']=$val;
			$this->load->view('t_pendaftaran/v_t_pendaftaran_gabungin',$data);
		}
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from tbl_t_pendaftaran where nid_t_pendaftaran = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("u.*, m.ncolumn1 as nmastercolumn1");
		$db->from('tbl_t_pendaftaran u');
		$db->join('tbl_master1 m','m.nid_master1=u.nmaster_1_id');
		$db->where('u.nid_t_pendaftaran ',$id);
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('t_pendaftaran/t_pendaftarandetail',$data);
	}
	
	public function rawatjalan()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_pendaftaran/v_kunjungan_rawatjalan');
	}
	
	public function rawatinap()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_pendaftaran/v_kunjungan_rawatinap');
	}
	
	public function ugd()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_pendaftaran/v_kunjungan_ugd');
	}
	
	public function keadaanbayisource()
	{
		$id=$this->input->get('term')?$this->input->get('term',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$combokeadaanbayi = $db->query("SELECT KD_KEADAAN_BAYI_LAHIR AS id,KEADAAN_BAYI_LAHIR AS label, '' as category FROM mst_keadaan_bayi_lahir where KEADAAN_BAYI_LAHIR like '%".$id."%' ")->result_array();
		die(json_encode($combokeadaanbayi));
	}
	
	public function asuhanbayisource()
	{
		$id=$this->input->get('term')?$this->input->get('term',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$comboasuhanbayi = $db->query("SELECT KD_ASUHAN_BAYI_LAHIR AS id,ASUHAN_BAYI_LAHIR AS label, '' as category FROM mst_asuhan_bayi_lahir where ASUHAN_BAYI_LAHIR like '%".$id."%' ")->result_array();
		die(json_encode($comboasuhanbayi));
	}
	
	/*public function coba()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('default', TRUE);
		$a = $db->query("select * from ADM_T_USER where ID = 81");
		$val = $a->result_object();
		
		echo '<pre>';print_r($val);die;
	}*/
	
}

/* End of file t_pendaftaran.php */
/* Location: ./application/controllers/t_pendaftaran.php */
