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
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
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
					
		$total = $this->t_pelayanan_model->totalT_pelayanan($paramstotal);
		
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
					
		$result = $this->t_pelayanan_model->getT_pelayanan($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_pendaftaran/v_t_pendaftaran_add');
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
		$val->set_rules('cara_bayar', 'Cara Bayar', 'trim|required|xss_clean');
		$val->set_rules('nama_kk', 'Nama KK', 'trim|required|xss_clean');
		$val->set_rules('alamat', 'Alamat', 'trim|required|xss_clean');
		
		if($this->input->post('showhide_kunjungan')){
			if($this->input->post('showhide_kunjungan')=='rawat_jalan'){
				$val->set_rules('unit_layanan', 'Unit Layanan', 'trim|required|xss_clean');
				$val->set_rules('poliklinik', 'Poliklinik', 'trim|required|xss_clean');
				if($this->input->post('kategori_kia')==1){
					$val->set_rules('showhide_kunjungan_kia','Pilih Kunjungan Pemeriksaan','trim|required|xss_clean');
					if($this->input->post('nama_suami')){
						$val->set_rules('tempat_lahir_suami','Tempat Lahir','trim|required|xss_clean');
						$val->set_rules('tanggal_lahir_suami','Tanggal Lahir','trim|required|xss_clean');
					}
				}elseif($this->input->post('kategori_kia')==2){
					$val->set_rules('showhide_pemeriksaan','Pilih Pemeriksaan','trim|required|xss_clean');
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
			$max = $db->query("SELECT MAX(SUBSTR(kd_pasien,-7)) AS total FROM pasien where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
			$max = $max->total + 1;
			$dataexc = array(
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
				'KD_PEKERJAAN' => $this->input->post('pekerjaan')?$this->input->post('pekerjaan',TRUE):NULL,
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
	
	public function daftarkunjunganprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		if($this->input->post('showhide_kunjungan')){
			if($this->input->post('showhide_kunjungan')=='rawat_jalan'){
				$val->set_rules('unit_layanan', 'Unit Layanan', 'trim|required|xss_clean');
				$val->set_rules('poliklinik', 'Poliklinik', 'trim|required|xss_clean');
				if($this->input->post('kategori_kia')==1){
					$val->set_rules('showhide_kunjungan_kia','Pilih Kunjungan Pemeriksaan','trim|required|xss_clean');
					if($this->input->post('nama_suami')){
						$val->set_rules('tempat_lahir_suami','Tempat Lahir','trim|required|xss_clean');
						$val->set_rules('tanggal_lahir_suami','Tanggal Lahir','trim|required|xss_clean');
					}
				}elseif($this->input->post('kategori_kia')==2){
					$val->set_rules('showhide_pemeriksaan','Pilih Pemeriksaan','trim|required|xss_clean');
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

			$dataexc = array(
				'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
				'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
				'PETUGAS2' => $this->input->post('petugas2')?$this->input->post('petugas2',TRUE):'',
				'KD_DOKTER' => $this->session->userdata('kd_petugas'),
				'TGL_MASUK' => date('Y-m-d'),
				
			);
			
			$this->daftarkunjunganprocessfunction($db,$dataexc,$dataexc,$val);
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
			$arraykeadaanbayi = $this->input->post('keadaanbayi_final')?json_decode($this->input->post('keadaanbayi_final',TRUE)):NULL;
			$arrayasuhanbayi = $this->input->post('asuhanbayi_final')?json_decode($this->input->post('asuhanbayi_final',TRUE)):NULL;
			if($this->input->post('showhide_kunjungan')){
				$puskesmas = $this->input->post('kd_puskesmas_hidden')?$this->input->post('kd_puskesmas_hidden',TRUE):$this->session->userdata('kd_puskesmas');
				if($this->input->post('showhide_kunjungan')=='rawat_jalan'){
					$datainsert['KD_UNIT_LAYANAN'] = $this->input->post('unit_layanan',TRUE);
					$datainsert['KD_UNIT'] = $this->input->post('poliklinik',TRUE);
					$datainsert['KD_LAYANAN_B'] = 'RJ';
					if($this->input->post('poliklinik')==219){
						if($this->input->post('kategori_kia')==1){
							$maxkia = $db->query("select max(kj.URUT_MASUK) as total from kunjungan kj join trans_kia tk on kj.KD_KUNJUNGAN=tk.KD_KUNJUNGAN where kj.KD_PUSKESMAS='".$puskesmas."' and kj.KD_UNIT='".$this->input->post('poliklinik',TRUE)."' and tk.KD_KATEGORI_KIA='".$this->input->post('kategori_kia')."' and tk.KD_KUNJUNGAN_KIA='".$this->input->post('showhide_kunjungan_kia')."'")->row();
							$maxkia = $maxkia->total + 1;
							$kdk1 = date('Y-m-d').'-'.'219'.'-'.$this->input->post('kategori_kia').'-'.$this->input->post('showhide_kunjungan_kia').'-'.$maxkia;
							$datainsert['KD_KUNJUNGAN'] = $kdk1;
							$datainsert['URUT_MASUK'] = $maxkia;
							$kdfamily = $db->query("select max(KD_FAMILY_FOLDER) as total from family_folder")->row();
							$kdfamily = $kdfamily->total+1;
							if($this->input->post('nama_suami')){
								$datafamilysuami = array(
									'KD_FAMILY_FOLDER' => $kdfamily,
									'NO_KK' => $this->input->post('no_kk')?$this->input->post('no_kk'):'',
									'NAMA_KK' => $this->input->post('nama_kk')?$this->input->post('nama_kk'):'',
									'KD_STATUS_KELUARGA' => $this->input->post('status_keluarga')?$this->input->post('status_keluarga'):1,
									'ninput_oleh' => $this->session->userdata('user_name'),
									'ninput_tgl' => date('Y-m-d')
								);
								$db->insert('family_folder',$datafamilysuami);
								$idsuami = $db->insert_id();
								$idpas = $db->query("SELECT MAX(SUBSTR(kd_pasien,-7)) AS total FROM pasien where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
								
								$dataexcsuami = array(
									'NAMA_LENGKAP' => $val->set_value('nama_suami')?$val->set_value('nama_suami'):$this->input->post('nama_suami'),
									'TGL_LAHIR' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_lahir_suami')))),
									'TEMPAT_LAHIR' => $val->set_value('tempat_lahir_suami')?$val->set_value('tempat_lahir_suami'):$this->input->post('tempat_lahir_suami',true),
									'KD_PASIEN'=> $this->session->userdata('kd_puskesmas').sprintf("%07d",$idpas->total+1),
									'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
									'KD_JENIS_KELAMIN' => 'L',
									'KD_KABKOTA' => $this->input->post('kabupaten_kota')?$this->input->post('kabupaten_kota',TRUE):'',
									'KD_KECAMATAN' => $this->input->post('kecamatan')?$this->input->post('kecamatan',TRUE):'',
									'KD_KELURAHAN' => $this->input->post('desa_kelurahan')?$this->input->post('desa_kelurahan',TRUE):'',
									'KD_POS' => $this->input->post('kode_pos')?$this->input->post('kode_pos',TRUE):'',
									'TELEPON' => $this->input->post('no_tlp')?$this->input->post('no_tlp',TRUE):'',
									'KD_PENDIDIKAN' => $this->input->post('pendidikan_suami')?$this->input->post('pendidikan_suami',TRUE):'',
									'KD_PEKERJAAN' => $this->input->post('pekerjaan_suami')?$this->input->post('pekerjaan_suami',TRUE):'',
									'KD_AGAMA' => $this->input->post('agama_suami')?$this->input->post('agama_suami',TRUE):'',
									'KD_GOL_DARAH' => $this->input->post('gol_darah_suami')?$this->input->post('gol_darah_suami',TRUE):'',
									'KK' => $this->input->post('nama_kk')?$this->input->post('nama_kk',TRUE):'',
									'STATUS_MARITAL' => $this->input->post('status_nikah')?$this->input->post('status_nikah',TRUE):1,
									'ALAMAT' => $this->input->post('alamat')?$this->input->post('alamat',TRUE):'',
									'ID_FAMILY_FOLDER' => $idsuami,
									'KD_PROVINSI' => $this->input->post('provinsi')?$this->input->post('provinsi',TRUE):'',
									'TGL_PENDAFTARAN' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_daftar')))),
									'Created_By' => $this->session->userdata('user_name'),
									'Created_Date' => date('Y-m-d H:i:s')
								);
							$db->insert('pasien', $dataexcsuami);
							}
							
							if($this->input->post('showhide_kunjungan_kia')){
								$max1 = $db->query("select max(KD_KIA) as total from trans_kia")->row();
								$max1 = $max1->total + 1;
								$dataexc_kesehatanibu['KD_DOKTER_PEMERIKSA'] = $this->input->post('pemeriksa')?$this->input->post('pemeriksa',TRUE):'';
								$dataexc_kesehatanibu['KD_DOKTER_PETUGAS'] = $this->input->post('petugas')?$this->input->post('petugas',TRUE):'';
								$dataexc_kesehatanibu['KD_KATEGORI_KIA'] = $this->input->post('kategori_kia');
								$dataexc_kesehatanibu['KD_KUNJUNGAN'] = $kdk1;
								$dataexc_kesehatanibu['KD_UNIT_PELAYANAN'] = $this->input->post('unit_layanan');
								$dataexc_kesehatanibu['KD_KUNJUNGAN_KIA'] = $val->set_value('showhide_kunjungan_kia')?$val->set_value('showhide_kunjungan_kia'):$this->input->post('showhide_kunjungan_kia');
								$dataexc_kesehatanibu['ninput_oleh'] = $this->session->userdata('user_name');
								$dataexc_kesehatanibu['ninput_tgl'] = date('Y-m-d');
								$db->insert('trans_kia', $dataexc_kesehatanibu);
								
							}
						}elseif($this->input->post('kategori_kia')==2){
							$maxkia2 = $db->query("select max(kj.URUT_MASUK) as total from kunjungan kj join trans_kia tk on kj.KD_KUNJUNGAN=tk.KD_KUNJUNGAN where kj.KD_PUSKESMAS='".$puskesmas."' and kj.KD_UNIT='".$this->input->post('poliklinik',TRUE)."' and tk.KD_KATEGORI_KIA=2 and tk.KD_KUNJUNGAN_KIA='".$this->input->post('showhide_pemeriksaan')."'")->row();
							$maxkia2 = $maxkia2->total + 1;
							$kdk2 = date('Y-m-d').'-'.'219'.'-'.$this->input->post('kategori_kia').'-'.$this->input->post('showhide_pemeriksaan').'-'.$maxkia2;
							$datainsert['KD_KUNJUNGAN'] = $kdk2;
							$datainsert['URUT_MASUK'] = $maxkia2;
							$max4 = $db->query("SELECT MAX(SUBSTR(kd_pasien,-7)) AS total FROM pasien where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
							$max4 = $max4->total + 1;
							$kdfamily = $db->query("select max(KD_FAMILY_FOLDER) as total from family_folder")->row();
							$kdfamily2 = $kdfamily->total+1;
							if($this->input->post('nama_ibu_pasien')){
								$datafamilyibu = array(
									'KD_FAMILY_FOLDER' => $kdfamily2,
									'NO_KK' => $this->input->post('no_kk')?$this->input->post('no_kk'):'',
									'NAMA_KK' => $this->input->post('nama_kk')?$this->input->post('nama_kk'):'',
									'KD_STATUS_KELUARGA' => $this->input->post('status_keluarga')?$this->input->post('status_keluarga'):2,
									'ninput_oleh' => $this->session->userdata('user_name'),
									'ninput_tgl' => date('Y-m-d')
									);
								$db->insert('family_folder',$datafamilyibu);
								$idibu = $db->insert_id();
								$dataibu= array(
												'ID_FAMILY_FOLDER' => $idibu,
												'NAMA_LENGKAP' => $this->input->post('nama_ibu_pasien'),
												'KD_PASIEN'=> $this->session->userdata('kd_puskesmas').sprintf("%07d", $max4+1),
												'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
												'TGL_PENDAFTARAN' => date('Y-m-d H:i:s'),
												'KD_JENIS_KELAMIN' => 'P',
												'ALAMAT' => $this->input->post('alamat')?$this->input->post('alamat',TRUE):'',
												'KD_KABKOTA' => $this->input->post('kabupaten_kota')?$this->input->post('kabupaten_kota',TRUE):'',
												'KD_KECAMATAN' => $this->input->post('kecamatan')?$this->input->post('kecamatan',TRUE):'',
												'KD_KELURAHAN' => $this->input->post('desa_kelurahan')?$this->input->post('desa_kelurahan',TRUE):'',
												'KD_POS' => $this->input->post('kode_pos')?$this->input->post('kode_pos',TRUE):'',
												'KK' => $this->input->post('nama_kk')?$this->input->post('nama_kk',TRUE):'',
												'KD_PROVINSI' => $this->input->post('provinsi')?$this->input->post('provinsi',TRUE):'',
												'TEMPAT_LAHIR' => $this->input->post('tempat_lahir_ibu'),
												'TGL_LAHIR' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_lahir_ibu')))),
												'KD_AGAMA' => $this->input->post('agama_ibu'),
												'KD_GOL_DARAH' => $this->input->post('gol_darah_ibu'),
												'KD_PENDIDIKAN' => $this->input->post('pendidikan_ibu'),
												'KD_PEKERJAAN' => $this->input->post('pekerjaan_ibu'),
												'STATUS_MARITAL' => $this->input->post('status_nikah')?$this->input->post('status_nikah',TRUE):'',
												'Created_By' => $this->session->userdata('user_name'),
												'Created_Date' => date('Y-m-d H:i:s')
												);
								$db->insert('pasien',$dataibu);
							}
							$kdfamily = $db->query("select max(KD_FAMILY_FOLDER) as total from family_folder")->row();
							$kdfamily3 = $kdfamily->total+1;
							if($this->input->post('nama_ayah_pasien')){
								$datafamilyayah = array(
									'KD_FAMILY_FOLDER' => $kdfamily3,
									'NO_KK' => $this->input->post('no_kk')?$this->input->post('no_kk'):'',
									'NAMA_KK' => $this->input->post('nama_kk')?$this->input->post('nama_kk'):'',
									'KD_STATUS_KELUARGA' => $this->input->post('status_keluarga')?$this->input->post('status_keluarga'):1,
									'ninput_oleh' => $this->session->userdata('user_name'),
									'ninput_tgl' => date('Y-m-d')
									);
								$db->insert('family_folder',$datafamilyayah);
								$idayah = $db->insert_id();
								$dataayah= array(
												'ID_FAMILY_FOLDER' => $idayah,
												'NAMA_LENGKAP' => $this->input->post('nama_ayah_pasien'),
												'TGL_PENDAFTARAN' => date('Y-m-d H:i:s'),
												'KD_PASIEN'=> $this->session->userdata('kd_puskesmas').sprintf("%07d", $max4+2),
												'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
												'TEMPAT_LAHIR' => $this->input->post('tempat_lahir_ayah'),
												'ALAMAT' => $this->input->post('alamat')?$this->input->post('alamat',TRUE):'',
												'KD_KECAMATAN' => $this->input->post('kecamatan')?$this->input->post('kecamatan',TRUE):'',
												'KD_KELURAHAN' => $this->input->post('desa_kelurahan')?$this->input->post('desa_kelurahan',TRUE):'',
												'KD_POS' => $this->input->post('kode_pos')?$this->input->post('kode_pos',TRUE):'',
												'KK' => $this->input->post('nama_kk')?$this->input->post('nama_kk',TRUE):'',
												'KD_PROVINSI' => $this->input->post('provinsi')?$this->input->post('provinsi',TRUE):'',
												'KD_JENIS_KELAMIN' => 'L',
												'TGL_LAHIR' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_lahir_ayah')))),
												'KD_AGAMA' => $this->input->post('agama_ayah'),
												'KD_GOL_DARAH' => $this->input->post('gol_darah_ayah'),
												'KD_PENDIDIKAN' => $this->input->post('pendidikan_ayah'),
												'KD_PEKERJAAN' => $this->input->post('pekerjaan_ayah'),
												'STATUS_MARITAL' => $this->input->post('status_nikah')?$this->input->post('status_nikah',TRUE):'',
												'Created_By' => $this->session->userdata('user_name'),
												'Created_Date' => date('Y-m-d H:i:s')
												);
								$db->insert('pasien',$dataayah);
							}
							
							if($this->input->post('showhide_pemeriksaan')){
								$max5 = $db->query("select max(KD_KIA) as total from trans_kia")->row();
								$max5 = $max5->total + 1;
								$dataexc_kesehatananak['KD_DOKTER_PEMERIKSA'] = $this->input->post('pemeriksa')?$this->input->post('pemeriksa',TRUE):'';
								$dataexc_kesehatananak['KD_DOKTER_PETUGAS'] = $this->input->post('petugas')?$this->input->post('petugas',TRUE):'';
								$dataexc_kesehatananak['KD_KATEGORI_KIA'] = $this->input->post('kategori_kia');
								$dataexc_kesehatananak['KD_KUNJUNGAN'] = $kdk2;
								$dataexc_kesehatananak['KD_UNIT_PELAYANAN'] = $this->input->post('unit_layanan');
								$dataexc_kesehatananak['KD_KUNJUNGAN_KIA'] =  $val->set_value('showhide_pemeriksaan')?$val->set_value('showhide_pemeriksaan'):$this->input->post('showhide_pemeriksaan');
								$dataexc_kesehatananak['ninput_oleh'] = $this->session->userdata('user_name');
								$dataexc_kesehatananak['ninput_tgl'] = date('Y-m-d');
								$db->insert('trans_kia', $dataexc_kesehatananak);
								$kd_kia=$db->insert_id();
							}
							
							$dataket= array('KET_TAMBAHAN' => $this->input->post('ket'),
											'KD_KIA'=> $kd_kia,
											'ninput_oleh'=>$this->session->userdata('user_name'),
											'ninput_tgl'=> date('Y-m-d')
											);
							$db->insert('kunjungan_bersalin',$dataket);
							$kunjungan = $db->insert_id();
							
							if($arraykeadaanbayi){
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
							}
						}
					}else{
						$max = $db->query("select max(URUT_MASUK) as total from kunjungan where KD_PUSKESMAS='".$puskesmas."' and KD_UNIT='".$this->input->post('poliklinik',TRUE)."' ")->row();
						$max = $max->total + 1;
						$kdk = date('Y-m-d').'-'.$this->input->post('poliklinik',TRUE).'-'.$max;
						$datainsert['KD_KUNJUNGAN'] = $kdk;
						$datainsert['URUT_MASUK'] = $max;
					}	
				}elseif($this->input->post('showhide_kunjungan')=='rawat_inap'){
					$max = $db->query("select max(URUT_MASUK) as total from kunjungan where KD_PUSKESMAS='".$puskesmas."' and KD_UNIT='".$this->input->post('spesialisasi',TRUE)."' ")->row();
					$max = $max->total + 1;
					$datainsert['KD_UNIT'] = $this->input->post('spesialisasi',TRUE);
					$kdk = date('Y-m-d').'-'.$this->input->post('spesialisasi',TRUE).'-'.$max;
					$datainsert['KD_KUNJUNGAN'] = $kdk;
					$datainsert['URUT_MASUK'] = $max;
					$datainsert['KD_LAYANAN_B'] = 'RI';
					/*$val->set_rules('spesialisasi', 'Spesialisasi', 'trim|required|xss_clean');
					$val->set_rules('ruangan', 'Ruangan', 'trim|required|xss_clean');
					$val->set_rules('kelas', 'Kelas', 'trim|required|xss_clean');
					$val->set_rules('kamar', 'Kamar', 'trim|required|xss_clean');*/
				}else{
					$datainsert['KD_UNIT_LAYANAN'] = $this->input->post('unit_layanan',TRUE);
					$kdk = date('Y-m-d').'-'.$max;
					$datainsert['KD_KUNJUNGAN'] = $kdk;
					$datainsert['URUT_MASUK'] = $max;
					$datainsert['KD_LAYANAN_B'] = 'RD';
				}
			}
		$db->insert('kunjungan',$datainsert);
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
			$db->select("k.KD_KUNJUNGAN,NAMA_LENGKAP AS NAMA_PASIEN,k.KD_UNIT_LAYANAN,k.KD_UNIT,k.KD_DOKTER,k.KD_PUSKESMAS,t.KD_KATEGORI_KIA,t.KD_KUNJUNGAN_KIA",FALSE);
			$db->from('kunjungan k');
			$db->join('pasien p','k.KD_PASIEN=p.KD_PASIEN');
			$db->join('trans_kia t','k.KD_KUNJUNGAN=t.KD_KUNJUNGAN');
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
				if($this->input->post('kategori_kia')==1){
					$maxkiabaru = $db->query("select max(kj.URUT_MASUK) as total from kunjungan kj join trans_kia tk on kj.KD_KUNJUNGAN=tk.KD_KUNJUNGAN where kj.KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' and kj.KD_UNIT=219 and tk.KD_KATEGORI_KIA='".$this->input->post('kategori_kia')."' and tk.KD_KUNJUNGAN_KIA='".$this->input->post('kunjungan_kia_ibu')."'")->row();
					$maxkiabaru = $maxkiabaru->total + 1;
					$kdkunjunganbaru = date('Y-m-d').'-'.'219'.'-'.$this->input->post('kategori_kia').'-'.$this->input->post('kunjungan_kia_ibu').'-'.$maxkiabaru;
				}else{
					$maxkiabaru = $db->query("select max(kj.URUT_MASUK) as total from kunjungan kj join trans_kia tk on kj.KD_KUNJUNGAN=tk.KD_KUNJUNGAN where kj.KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' and kj.KD_UNIT=219 and tk.KD_KATEGORI_KIA='".$this->input->post('kategori_kia')."' and tk.KD_KUNJUNGAN_KIA='".$this->input->post('kunjungan_kia_anak')."'")->row();
					$maxkiabaru = $maxkiabaru->total + 1;
					$kdkunjunganbaru = date('Y-m-d').'-'.'219'.'-'.$this->input->post('kategori_kia').'-'.$this->input->post('kunjungan_kia_anak').'-'.$maxkiabaru;
				}
				
				$lihatdatatrans = $db->query("select * from trans_kia where KD_KUNJUNGAN='".$id."'")->row();
				if($lihatdatatrans){
					$datakia = array(
							'KD_UNIT_PELAYANAN' => $val->set_value('unit_layanan'),
							'KD_KUNJUNGAN' => $kdkunjunganbaru,
							'KD_KATEGORI_KIA' => $this->input->post('kategori_kia'),
							'KD_KUNJUNGAN_KIA' => $this->input->post('kategori_kia')==1?$this->input->post('kunjungan_kia_ibu'):$this->input->post('kunjungan_kia_anak')
					);
					$db->where('KD_KUNJUNGAN',$id);
					$db->update('trans_kia', $datakia);
				}else{
					$datakia = array(
							'KD_UNIT_PELAYANAN' => $val->set_value('unit_layanan'),
							'KD_KUNJUNGAN' => $kdkunjunganbaru,
							'KD_KATEGORI_KIA' => $this->input->post('kategori_kia'),
							'KD_DOKTER_PETUGAS' => $this->input->post('petugas'),
							'KD_KUNJUNGAN_KIA' => $this->input->post('kategori_kia')==1?$this->input->post('kunjungan_kia_ibu'):$this->input->post('kunjungan_kia_anak'),
							'ninput_oleh' => $this->session->userdata('user_name'),
							'ninput_oleh' => date("Y-m-d")
					);
					$db->insert('trans_kia', $datakia);
				}	
				$db->where('KD_KUNJUNGAN',$id);
				$db->where('KD_PUSKESMAS',$kd_puskesmas);
				$kunjungankiaupdate = array(
					'KD_UNIT' => $val->set_value('poliklinik'),
					'KD_KUNJUNGAN' => $datakia['KD_KUNJUNGAN']
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
					'Modified_Date' => date('Y-m-d H:i:s')
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
		$db->select("NAMA_LENGKAP AS NAMA_PASIEN,p.KD_PASIEN,p.KD_PUSKESMAS,p.TGL_LAHIR,p.NO_PENGENAL AS NIK,p.KET_WIL,p.KD_GOL_DARAH,k.CUSTOMER",FALSE);
		$db->from('pasien p');
		$db->join('mst_kel_pasien k','k.KD_CUSTOMER=p.KD_CUSTOMER');
		//$db->join('mst_unit u','k.KD_UNIT=p.KD_UNIT');
		$db->where('p.KD_PASIEN',$id);
		$db->where('p.KD_PUSKESMAS',$id2);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('t_pendaftaran/v_t_pendaftaran_pelayanan',$data);
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
		$this->load->view('t_pendaftaran/v_t_pendaftaran_gabung',$data);
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