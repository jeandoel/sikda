<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_imunisasi extends CI_Controller {
	public function index()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_imunisasi/v_imunisasi');
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function t_imunisasixml()
	{		
		$this->load->model('t_imunisasi_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari')
					);
					
		$total = $this->t_imunisasi_model->totalT_imunisasi($paramstotal);
		
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
					
		$result = $this->t_imunisasi_model->getT_imunisasi($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function t_semua_pasienxml()
	{		
		$this->load->model('t_imunisasi_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari')
					);
					
		$total = $this->t_imunisasi_model->totalT_semuapasien($paramstotal);
		
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
					
		$result = $this->t_imunisasi_model->getT_semuapasien($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	public function t_subgridsemuapasienxml()
	{		
		$this->load->model('t_imunisasi_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(				
					'kd_pasien'=>$this->input->post('kd_pasien'),
					'kd_puskesmas'=>$this->input->post('kd_puskesmas')
					);
					
		$total = $this->t_imunisasi_model->totalT_subgridsemuapasien($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),				
					'kd_pasien'=>$this->input->post('kd_pasien'),
					'kd_puskesmas'=>$this->input->post('kd_puskesmas')
					);
					
		$result = $this->t_imunisasi_model->getT_subgridsemuapasien($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	
	
	
	public function t_imunisasi_kipixml()
	{		
		$this->load->model('t_imunisasi_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari')
					);
					
		$total = $this->t_imunisasi_model->totalT_imunisasi_kipi($paramstotal);
		
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
					
		$result = $this->t_imunisasi_model->getT_imunisasi_kipi($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	
	public function t_imunisasisubgrid()
	{		
		$this->load->model('t_imunisasi_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari')
					);
					
		$total = $this->t_imunisasi_model->totalT_imunisasisubgrid($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari'),
					'kd_pasien'=>$this->input->post('kd_pasien')
					);
		
		if($this->input->post('usergabung')) $params['usergabung']=$this->input->post('usergabung',TRUE);
					
		$result = $this->t_imunisasi_model->getT_imunisasisubgrid($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	
	
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->helper('My_helper');
		$this->load->helper('sigit_helper');
		$db = $this->load->database('sikda', TRUE);
		$data = $db->query("SELECT b.KECAMATAN, c.KELURAHAN, c.KD_KELURAHAN FROM sys_setting_def a
								LEFT JOIN mst_kecamatan b ON b.`KD_KECAMATAN`=a.`KD_KEC`
								LEFT JOIN data_dasar d ON d.`KD_KECAMATAN`=b.`KD_KECAMATAN`
								LEFT JOIN mst_kelurahan c ON c.`KD_KELURAHAN`=d.`KD_KELURAHAN`
								WHERE a.`KD_PUSKESMAS`='".$this->session->userdata("kd_puskesmas")."'")->row();
		$this->load->view('t_imunisasi/v_t_imunisasi_add',$data);
	}
	public function addprocess()
	{
	//print_r($_POST);die;
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('jenis_lokasi', 'Jenis Lokasi', 'trim|required|xss_clean');	
		$val->set_rules('namalokasi', 'Nama Lokasi', 'trim|required|xss_clean');
		$val->set_rules('alamatlokasi', 'Alamat', 'trim|required|xss_clean');
		
		if($this->input->post('kategori_imunisasi')){
			if($this->input->post('kategori_imunisasi')=='imunisasi'){
				$val->set_rules('nama_pasien', 'Nama Pasien', 'trim|required|xss_clean');
				$val->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required|xss_clean');
				$val->set_rules('jenis_kelamin', 'Jenis Kelamin', 'trim|required|xss_clean');
				$val->set_rules('alamatpasien', 'Alamat', 'trim|required|xss_clean');
				$val->set_rules('prov', 'Provinsi', 'trim|required|xss_clean');
				$val->set_rules('kab', 'Kabupaten', 'trim|required|xss_clean');
				$val->set_rules('kec', 'Kecamatan', 'trim|required|xss_clean');
				$val->set_rules('kel', 'Kelurahan', 'trim|required|xss_clean');
				}if($this->input->post('showhide_jenis_pasien')=='6'){
					//$val->set_rules('status_nikah', 'Status Nikah', 'trim|required|xss_clean');
					$val->set_rules('nama_suami', 'Nama Suami', 'trim|required|xss_clean');	
					$val->set_rules('tanggal_hpht', 'Tgl HPHT', 'trim|required|xss_clean');	
					$val->set_rules('kehamilan_ke', 'Kehamilan Ke', 'trim|required|xss_clean');	
					$val->set_rules('jarak_kehamilan', 'Jarak Kehamilan', 'trim|required|xss_clean');	
						}if($this->input->post('showhide_jenis_pasien')=='1,2,3,4'){
							$val->set_rules('nama_ibu', 'Nama Ibu', 'trim|required|xss_clean');
								}if($this->input->post('showhide_jenis_pasien')=='5'){
									$val->set_rules('status_nikah', 'Status Nikah', 'trim|required|xss_clean');
									$val->set_rules('nama_suami', 'Nama Suami', 'trim|required|xss_clean');
										}else{
											//$val->set_rules('vaksin', 'Vaksin', 'trim|required|xss_clean');
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
			
			$arraypetugas = $this->input->post('petugasimunisasi_final')?json_decode($this->input->post('petugasimunisasi_final',TRUE)):NULL;//print_r($arraypetugas);die;
			$arrayimunisasivaksin = $this->input->post('imunisasivaksin_final')?json_decode($this->input->post('imunisasivaksin_final',TRUE)):NULL;
			
			$check = $db->query("select * from pasien where KD_PASIEN='".$this->input->post('kd_pasien')."'")->row();
			$max = $db->query("SELECT MAX(SUBSTR(kd_pasien,-7)) AS total FROM pasien where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
			$max = $max->total + 1;

			if($check){
				$kd_pasien_a = $this->input->post('kd_pasien');
				$datapasien = array(
								'NAMA_LENGKAP' => $this->input->post('nama_pasien'),
								'TGL_LAHIR' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_lahir')))),
								'KD_JENIS_KELAMIN' => $this->input->post('jenis_kelamin'),
								'ALAMAT' => $this->input->post('alamatpasien'),
								'KD_PROVINSI' => $this->input->post('provinsipasien'),
								'KD_KABKOTA' => $this->input->post('kabupaten_kotapasien'),
								'KD_KECAMATAN' => $this->input->post('kecamatanpasien'),
								'KD_KELURAHAN' => $this->input->post('desa_kelurahanpasien'),
								'STATUS_MARITAL' => $this->input->post('status_nikah'),
								'Created_By' => $this->session->userdata('user_name'),
								'Created_Date' => date("Y-m-d")
							);//print_r($datapasien);die;
				if($check->FLAG_LUAR_GEDUNG==2){
					$datapasien['FLAG_LUAR_GEDUNG'] = '2';
				}else{
					$datapasien['FLAG_LUAR_GEDUNG'] = '3';
				}
				$db->where('KD_PASIEN',$kd_pasien_a);
				$db->update('pasien',$datapasien);//print_r($db->last_query());die;
			}else{
				$kd_pasien_a = $this->session->userdata('kd_puskesmas').sprintf("%07d",$max);
				$datapasien = array(
								'KD_PASIEN' => $kd_pasien_a,
								'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
								'TGL_PENDAFTARAN' => date('Y-m-d'),
								'NAMA_LENGKAP' => $this->input->post('nama_pasien'),
								'TGL_LAHIR' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_lahir')))),
								'KD_JENIS_KELAMIN' => $this->input->post('jenis_kelamin'),
								'ALAMAT' => $this->input->post('alamatpasien'),
								'KD_AGAMA' => NULL,
								'FLAG_LUAR_GEDUNG' => 2,
								'KD_PROVINSI' => $this->input->post('provinsipasien'),
								'KD_KABKOTA' => $this->input->post('kabupaten_kotapasien'),
								'KD_KECAMATAN' => $this->input->post('kecamatanpasien'),
								'KD_KELURAHAN' => $this->input->post('desa_kelurahanpasien'),
								'STATUS_MARITAL' => $this->input->post('status_nikah'),
								'Created_By' => $this->session->userdata('user_name'),
								'Created_Date' => date("Y-m-d")
							);//print_r($datapasien);die;
				$db->insert('pasien',$datapasien);
			}
			/// Insert Table Pelayanan ///
			$maxpelayanan = 0;
			$maxpelayanan = $db->query("SELECT MAX(SUBSTR(KD_PELAYANAN,-7)) AS total FROM pelayanan where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();//print_r($maxpelayanan);die;
			$maxpelayanan = $maxpelayanan->total + 1;
			$kodepelayanan = $this->input->post('kd_unit_hidden',TRUE).sprintf("%07d", $maxpelayanan);
			$datainsert = array(
                'KD_PELAYANAN' =>  '219'.$kodepelayanan,
				'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
                'TGL_PELAYANAN' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_imunisasi')))),
                'UNIT_PELAYANAN' => 'RJ',
				'KD_PASIEN'=> $kd_pasien_a,
                'KD_UNIT' => '219',
                'KD_USER' => $this->session->userdata('kd_petugas'),
                'KD_DOKTER' => $this->session->userdata('kd_petugas'),
                'Created_Date' => date('Y-m-d'),
                'Created_By' => $this->session->userdata('kd_petugas')
            );//print_r($datainsert);die;
			$db->insert('pelayanan',$datainsert);
			$kode_pelayanan = $kodepelayanan;
			
			/// insert trans_imunisasi ///
			//$checktransimun = $db->query("select * from trans_imunisasi where KD_PASIEN='".$this->input->post('kd_pasien')."'")->row();
			if($this->input->post('kd_pasien')){
			$dataimunisasi = array(
							'TANGGAL' => date('Y-m-d') ,
							'TAHUN' => date('Y') ,
							'KD_PASIEN' => $kd_pasien_a ,
							'IMUNISASI_LUAR_GEDUNG' => 1 ,
							'KD_KATEGORI_IMUNISASI' => $this->input->post('jenis_lokasi'),
							'KD_PELAYANAN' => '219'.$kode_pelayanan,
							'KD_JENIS_PASIEN' => $this->input->post('showhide_jenis_pasien')?$this->input->post('showhide_jenis_pasien'):NULL,
							'NAMA_LOKASI' => $this->input->post('namalokasi'),
							'ALAMAT' => $this->input->post('alamatlokasi'),
							'KD_KELURAHAN' => $this->input->post('desalokasi'),
							'nama_input' => $this->session->userdata('user_name'),
							'tgl_input' => date("Y-m-d")
						);//print_r($dataimunisasi);die;
			}else{
			$dataimunisasi = array(
							'TANGGAL' => date('Y-m-d') ,
							'TAHUN' => date('Y') ,
							'KD_PASIEN' => $kd_pasien_a ,
							'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
							'IMUNISASI_LUAR_GEDUNG' => 1 ,
							'KD_KATEGORI_IMUNISASI' => $this->input->post('jenis_lokasi'),
							'KD_PELAYANAN' => '219'.$kode_pelayanan,
							'KD_JENIS_PASIEN' => $this->input->post('showhide_jenis_pasien')?$this->input->post('showhide_jenis_pasien'):NULL,
							'NAMA_LOKASI' => $this->input->post('namalokasi'),
							'ALAMAT' => $this->input->post('alamatlokasi'),
							'KD_KELURAHAN' => $this->input->post('desalokasi'),
							'nama_input' => $this->session->userdata('user_name'),
							'tgl_input' => date("Y-m-d")
						);//print_r($dataimunisasi);die;
						}
						
		if($this->input->post('showhide_jenis_pasien')=='6'){ ///---> wus_hamil
			
			$dataimunisasi['NAMA_SUAMI'] = $this->input->post('nama_suami');
			$dataimunisasi['HPHT'] = date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_hpht'))));
			$dataimunisasi['HAMIL_KE'] = $this->input->post('kehamilan_ke');
			$dataimunisasi['JARAK_KEHAMILAN']= $this->input->post('jarak_kehamilan');	
			
		}
		if($this->input->post('showhide_jenis_pasien')=='1' or '2' or '3' or '4'){ ///--- Anak
			$dataimunisasi['NAMA_IBU'] = $this->input->post('nama_ibu')?$this->input->post('nama_ibu'):NULL;	
		}
		if($this->input->post('showhide_jenis_pasien')=='5'){ ///--- Wus tidak hamil
			
			$dataimunisasi['NAMA_SUAMI'] = $this->input->post('nama_suami')?$this->input->post('nama_suami'):NULL;																		;
			
		}else{
			$dataimunisasi['PEMERIKSAAN_FISIK'] = $this->input->post('pemeriksaan_fisik');
		}
		
		//print_r($dataimunisasi);die;
			$db->insert('trans_imunisasi',$dataimunisasi);
			//print_r($db->last_query());die;
			$kdtransimun = $db->insert_id();
			
			/// insert petugas ///
			if($arraypetugas){
				foreach($arraypetugas as $rowpetugasloop){
					$datapetugastmp = json_decode($rowpetugasloop);
					$datapetugasloop[] = array(
						'KD_TRANS_IMUNISASI'=> $kdtransimun,
						'KD_DOKTER' => $datapetugastmp->kd_petugas,
						'STATUS_PEMBINA' => !EMPTY($datapetugastmp->keterangan)?$datapetugastmp->keterangan:0,
						'nama_input' => $this->session->userdata('user_name'),
						'tgl_input' => date("Y-m-d")
					);
					$datapetugasinsert = $datapetugasloop;
				}
				$db->insert_batch('pel_petugas',$datapetugasinsert);
			}

			///insert vaksin ///
			if($arrayimunisasivaksin){
				foreach($arrayimunisasivaksin as $rowimunisasivaksinloop){
					$dataimunisasivaksintmp = json_decode($rowimunisasivaksinloop);
					$dataimunisasivaksinloop[] = array(
						'KD_TRANS_IMUNISASI' => $kdtransimun,
						//'KD_OBAT' => $dataimunisasivaksintmp->kd_vaksin,
						'KD_PASIEN' => $kd_pasien_a ,
						'KD_JENIS_IMUNISASI' => $dataimunisasivaksintmp->kd_jenis_imunisasi,
						//'KD_UNIT_APT' => 'PSY',
						'nama_input' => $this->session->userdata('user_name'),
						'tgl_input' => date("Y-m-d")
					);
					$dataimunisasivaksininsert = $dataimunisasivaksinloop;
				}
				$db->insert_batch('pel_imunisasi',$dataimunisasivaksininsert);
			}
			
			$query = $db->query("select * from trans_imunisasi where KD_TRANS_IMUNISASI='".$this->input->post('kd_trans_imunisasi_hidden')."'")->row();//print_r($query);die;
			if(!empty($query->NAMA_SUAMI)){
				$db->set('NAMA_IBU', $this->input->post('nama_ibu'));
				$db->where('KD_TRANS_IMUNISASI', $this->input->post('kd_trans_imunisasi_hidden'));
				$db->update('trans_imunisasi');
			}if (!empty($query->NAMA_IBU)){
				$db->set('NAMA_SUAMI', $this->input->post('nama_suami'));
				$db->where('KD_TRANS_IMUNISASI', $this->input->post('kd_trans_imunisasi_hidden'));
				$db->update('trans_imunisasi');
			}else{
			
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
	public function t_data_petugas()
	{
		$this->load->model('t_imunisasi_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'id'=>$this->input->post('id2')
					);
					
		$total = $this->t_imunisasi_model->totalPetugas_imunisasi($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'id'=>$this->input->post('id2')
					);
					
		$result = $this->t_imunisasi_model->getPetugas_imunisasi($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function detail_pasien_kipi()
	{
		$this->load->helper('beries_helper');
		$this->load->helper('my_helper');
		$this->load->helper('sigit_helper');
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null; //print_r($id);die;
		$db = $this->load->database('sikda', TRUE);
		$data = $db->query("select * from vw_detail_pasien_kipi where KD_TRANS_KIPI='".$id."'")->row();
		//print_r($db->last_query());die;
		$this->load->view('t_imunisasi/detail_imunisasi/v_t_kipi_add', $data);
	}
	public function detail_pasien_imunisasi()
	{
		$this->load->helper('beries_helper');
		$this->load->helper('my_helper');
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null; //print_r($id);die;
		$db = $this->load->database('sikda', TRUE);
		$data = $db->query("select * from vw_detail_pasien_imunisasi where KD_TRANS_IMUNISASI='".$id."'")->row();
		//print_r($data);die;
		
		$this->load->view('t_imunisasi/detail_imunisasi/v_t_imunisasi_add_2', $data);

	}
	
	
	public function load_view_kipi()
	{
		$this->load->helper('beries_helper');
		$this->load->helper('my_helper');
		$this->load->helper('sigit_helper');
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null; //print_r($id);die;
		$id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null; //print_r($id2);die;
		$id3=$this->input->get('id3')?$this->input->get('id3',TRUE):null; //print_r($id2);die;
		$db = $this->load->database('sikda', TRUE);
		$data = $db->query("select a.*, b.KD_TRANS_IMUNISASI, date_format(b.TANGGAL,'%d-%m-%Y') as TANGGAL, b.KD_KELURAHAN, (select b.KECAMATAN from mst_puskesmas a join mst_kecamatan b on b.KD_KECAMATAN=a.KD_KECAMATAN where a.KD_PUSKESMAS='".$id2."') as kecamatan from trans_imunisasi b join pasien a on a.KD_PASIEN=b.KD_PASIEN where b.KD_PASIEN='".$id."' order by b.KD_TRANS_IMUNISASI DESC")->row();
		//print_r($data);die;
		$this->load->view('t_imunisasi/tambah_imunisasi/v_t_kipi_add', $data);
	}
	
	public function load_view_imunisasi()
	{
		$this->load->helper('beries_helper');
		$this->load->helper('my_helper');
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null; //print_r($id);die;
		$id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null; //print_r($id);die;
		$db = $this->load->database('sikda', TRUE);
		$val1 = $db->query("select KD_PASIEN, NAMA_LENGKAP, date_format(TGL_LAHIR,'%d-%m-%Y') as TGL_LAHIR, KD_JENIS_KELAMIN, ALAMAT, KD_PROVINSI, KD_KABKOTA, KD_KECAMATAN, KD_KELURAHAN, (select b.KECAMATAN from mst_puskesmas a join mst_kecamatan b on b.KD_KECAMATAN=a.KD_KECAMATAN where a.KD_PUSKESMAS='".$id2."') as kecamatan from pasien where KD_PASIEN='".$id."'")->row();
		$val2 = $db->query("select NAMA_IBU, NAMA_SUAMI, KD_TRANS_IMUNISASI from trans_imunisasi where KD_PASIEN ='".$id."'")->row();
		$data ['data1'] = $val1;
		$data ['data2'] = $val2;
		//print_r($data);die;
		$this->load->view('t_imunisasi/tambah_imunisasi/v_t_imunisasi_add_2', $data);
	}
	
	public function petugasimunisasisource()
	{
		$id=$this->input->get('term')?$this->input->get('term',TRUE):null;
		$db = $this->load->database('sikda', TRUE);

		$query = "SELECT KD_DOKTER AS id,NAMA AS label, '' as category FROM mst_dokter where NAMA like '%".$id."%' ";

		$level_aplikasi = $this->session->userdata('level_aplikasi');
		$kd_puskesmas = $this->session->userdata('kd_puskesmas');
		if(!empty($level_aplikasi) && $level_aplikasi=='PUSKESMAS' && !empty($kd_puskesmas)){
			$query.= "AND KD_PUSKESMAS = '$kd_puskesmas' ";
		};

		$combopetugasimunisasi = $db->query($query)->result_array();
		die(json_encode($combopetugasimunisasi));
	}
	
	public function siswa_anak_bayi_balita()
	{
		$db = $this->load->database('sikda',true);
		$this->load->helper('beries_helper');
		$this->load->helper('sigit_helper');
		$kdpasien = $this->input->get('kdpasien');
	
			$namaibu = $db->query("select NAMA_IBU from trans_imunisasi where KD_PASIEN='".$kdpasien."'")->row();
			if(!empty($namaibu)){
				$data['dataibu']=$namaibu;
			}
		$data['dataibu'] = $namaibu;
		$this->load->view('t_imunisasi/v_t_siswa_anak_bayi_balita',$data);
	}
	
	public function wustidakhamil()
	{
		$db = $this->load->database('sikda',true);
		$this->load->helper('beries_helper');
		$this->load->helper('sigit_helper');
		$kdpasien = $this->input->get('kdpasien');
		$namasuami = $db->query("select a.STATUS_MARITAL, b.NAMA_SUAMI from trans_imunisasi b join pasien a on a.KD_PASIEN=b.KD_PASIEN where b.KD_PASIEN='".$kdpasien."'")->row();
			if(!empty($namasuami)){
				$data['datasuami']=$namasuami;
			}
		$data['datasuami']=$namasuami;
		$this->load->view('t_imunisasi/v_t_wustidakhamil',$data);
	}
	
	public function wushamil()
	{
		$db = $this->load->database('sikda',true);
		$this->load->helper('beries_helper');
		$this->load->helper('sigit_helper');
		$kdpasien = $this->input->get('kdpasien');
		
			$namasuami = $db->query("select a.STATUS_MARITAL, b.NAMA_SUAMI from trans_imunisasi b join pasien a on a.KD_PASIEN=b.KD_PASIEN where b.KD_PASIEN='".$kdpasien."'")->row();
			if(!empty($namasuami)){
				$data['datasuami']=$namasuami;
			}
		$data['datasuami']=$namasuami;
		$this->load->view('t_imunisasi/v_t_wushamil',$data);
	}
	
	public function pasienbiasa_caten()
	{
		$this->load->helper('beries_helper');
		$this->load->helper('sigit_helper');
		$this->load->view('t_imunisasi/v_t_pasienbiasa_caten');
	}
	
}

/* End of file t_pendaftaran.php */
/* Location: ./application/controllers/t_pendaftaran.php */
