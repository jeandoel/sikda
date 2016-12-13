<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_kesehatan_ibu_dan_anak extends CI_Controller {
	public function index()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_kesehatanibudananak/t_v_kesehatan_ibu_dan_anak');
	}
	public function riwayatkunjunganbersalinpopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null; //print_r($data);die;
		$this->load->view('t_pelayanan/kunjungan/v_t_pelayanan_bersalin_popup',$data);
	}
	
	public function pelayananbersalinpopupxml()
	{
		$this->load->model('t_kesehatan_ibu_dan_anak_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'kode'=>$this->input->post('kode')
					);
					
		$total = $this->t_kesehatan_ibu_dan_anak_model->totalT_bersalinpopup($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;

		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'kode'=>$this->input->post('kode')
					); //print_r($params);die;
					
		$result = $this->t_kesehatan_ibu_dan_anak_model->getT_bersalinpopup($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
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
	////////////////////////////// Mengambil Data Untuk ditampilkan pada Grid ////////////////////////////////////////
	public function t_kesehatan_ibu_dan_anakxml()
	{		//print_r($_POST); die;
		$this->load->model('t_kesehatan_ibu_dan_anak_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari')
					);
					//print_r($paramstotal); die;
					
		$total = $this->t_kesehatan_ibu_dan_anak_model->totalTkesehatanibudananak($paramstotal);
		
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
					
		$result = $this->t_kesehatan_ibu_dan_anak_model->getTkesehatanibudananak($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	///////////////////untuk memanggil view registrasi KIA/////////////////////
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->helper('my_helper');
		$this->load->view('t_kesehatanibudananak/v_t_pendaftaran_kia_add');
	}
	////////////////function proses tambah data untuk view kesehatan ibu bersalin//////////////////////
	public function addprocess()
	{ //print_r($_POST);die;
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('tanggal_daftar', 'Tanggal Daftar', 'trim|required|myvalid_date');				
		$val->set_rules('jam_kelahiran', 'Jam Kelahiran', 'trim|required|xss_clean');		
		$val->set_rules('ket_waktu', 'Jam Kelahiran', 'trim|required|xss_clean');
		$val->set_rules('umur_kehamilan', 'Umur Kehamilan', 'trim|required|xss_clean');
		$val->set_rules('dokter', 'Dokter', 'trim|required|xss_clean');
		$val->set_rules('jenis_persalinan', 'Jenis Persalinan', 'trim|required|xss_clean');
		$val->set_rules('jenis_kelahiran', 'Jenis Kelahiran', 'trim|required|xss_clean');
		$val->set_rules('jumlah_bayi', 'Jumlah Bayi', 'trim|required|xss_clean|integer');
		$val->set_rules('keadaan_kesehatan', 'Keadaan Kesehatan', 'trim|required|xss_clean');
		$val->set_rules('status_hamil', 'Status Hamil', 'trim|required|xss_clean');
		$val->set_rules('anak_ke', 'Anak Ke', 'trim|required|xss_clean');
		$val->set_rules('berat_lahir', 'Berat Lahir', 'trim|required|xss_clean');
		$val->set_rules('panjang_badan', 'Panjang Badan', 'trim|required|xss_clean');
		$val->set_rules('lingkar_kepala', 'Lingkar Kepala', 'trim|required|xss_clean');
		$val->set_rules('jk', 'Jenis Kelamin', 'trim|required|xss_clean');
		$val->set_rules('ket_tambahan');
		
		$arraykeadaanbayi = $this->input->post('keadaanbayi_final')?json_decode($this->input->post('keadaanbayi_final',TRUE)):NULL;//print_r($arraykeadaanbayi);die;
		$arrayasuhanbayi = $this->input->post('asuhanbayi_final')?json_decode($this->input->post('asuhanbayi_final',TRUE)):NULL;
		
		
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
			$null = '-';
			$data2 = array(
			
				'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
				'KD_PASIEN'=> $this->session->userdata('kd_puskesmas').sprintf("%07d", $max),
				'TGL_LAHIR' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tanggal_daftar')))),
				'KD_JENIS_KELAMIN' => $val->set_value('jk'),
				'KD_AGAMA' => $null,
				'STATUS_MARITAL' => $null,
				'KD_PASIEN'=> $this->session->userdata('kd_puskesmas').sprintf("%07d", $max),
				'TGL_PENDAFTARAN' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tanggal_daftar')))),
				'ANAK_KE' => $val->set_value('anak_ke'),
				'BERAT_LAHIR' => $val->set_value('berat_lahir'),				
				'PANJANG_BADAN' => $val->set_value('panjang_badan'),
				'LINGKAR_KEPALA' => $val->set_value('lingkar_kepala'),
				'Created_By' => $this->session->userdata('nusername'),
				'Created_Date' => date('Y-m-d H:i:s')
			);
			//print_r($data2);die;
			$db->insert('pasien', $data2);
			$kd_pasien = $this->session->userdata('kd_puskesmas').sprintf("%07d", $max);
			
			$dataexc = array(
						'KD_PASIEN' => $kd_pasien,
						'TANGGAL_BERSALIN' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tanggal_daftar')))),
						'JAM_KELAHIRAN' => $val->set_value('jam_kelahiran'),
						'KD_KET_WAKTU' => $val->set_value('ket_waktu'),
						'UMUR_KEHAMILAN' => $val->set_value('umur_kehamilan'),
						'KD_DOKTER' => $val->set_value('dokter'),
						'KD_CARA_BERSALIN' => $val->set_value('jenis_persalinan'),
						'KD_JENIS_KELAHIRAN' => $val->set_value('jenis_kelahiran'),
						'JML_BAYI' => $val->set_value('jumlah_bayi'),
						'KD_KEADAAN_KESEHATAN' => $val->set_value('keadaan_kesehatan'),
						'KD_STATUS_HAMIL' => $val->set_value('status_hamil'),
						//'KD_KEADAAN_BAYI_LAHIR' => $val->set_value('keadaan_bayi_lahir'),
						//'KD_ASUHAN_BAYI_LAHIR' => $val->set_value('asuhan_bayi_lahir'),
						'KET_TAMBAHAN' => $val->set_value('ket_tambahan'),
						'ninput_oleh' => $this->session->userdata('nusername'),
						'ninput_tgl' => date('Y-m-d H:i:s')
					);
					//print_r($dataexc);die;
			$db->insert('kunjungan_bersalin', $dataexc);
			$kdbersalin = $db->insert_id();
			
			if($arraykeadaanbayi){
				foreach($arraykeadaanbayi as $rowkeadaanbayiloop){
					$datakeadaanbayitmp = json_decode($rowkeadaanbayiloop);
					$datakeadaanbayiloop[] = array(
						'KD_KUNJUNGAN_BERSALIN' => $kdbersalin,
						'KD_KEADAAN_BAYI_LAHIR' => $datakeadaanbayitmp->kd_keadaan_bayi_lahir
					);
					//print_r($datakeadaanbayiloop);die;
					$datakeadaanbayiinsert = $datakeadaanbayiloop;
				}
				$db->insert_batch('detail_keadaan_bayi',$datakeadaanbayiinsert);
			}
			
			if($arrayasuhanbayi){
				foreach($arrayasuhanbayi as $rowasuhanbayiloop){
					$dataasuhanbayitmp = json_decode($rowasuhanbayiloop);
					$dataasuhanbayiloop[] = array(
						'KD_KUNJUNGAN_BERSALIN' => $kdbersalin,
						'KD_ASUHAN_BAYI_LAHIR' => $dataasuhanbayitmp->kd_asuhan_bayi_lahir,
					);
					$dataasuhanbayiinsert = $dataasuhanbayiloop;
				}
				$db->insert_batch('detail_asuhan_bayi',$dataasuhanbayiinsert);
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
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	////////////////////////////////proses tambah data registrasi KIA/////////////////////////////////////////////////////
	public function addprocesskia()
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
				'RINCIAN_PENANGGUNG' => $this->input->post('rincian_penangggung')?$this->input->post('rincian_penangggung',TRUE):NULL,
				'NAMA_KLG_LAIN' => $this->input->post('pic')?$this->input->post('pic',TRUE):NULL,
				'KET_WIL' => $this->input->post('wilayah')?$this->input->post('wilayah',TRUE):NULL,
				'CARA_BAYAR' => $val->set_value('cara_bayar'),
				'KK' => $val->set_value('nama_kk'),
				'TEMPAT_LAHIR' => $val->set_value('tempat_lahir'),
				'TGL_LAHIR' => $val->set_value('tanggal_lahir'),
				'TGL_LAHIR' => $val->set_value('tanggal_lahir'),
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
				$this->daftarkunjunganprocessfunction($db,$dataexckujungan);
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
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	////////////////////////unutk memanggil view dari combo box dan proses tambah data//////////////////////////////////////
	public function daftarkunjunganprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		if($this->input->post('showhide_kunjungan')){
			if($this->input->post('showhide_kunjungan')=='rawat_jalan'){
				$val->set_rules('unit_layanan', 'Unit Layanan', 'trim|required|xss_clean');
				$val->set_rules('poliklinik', 'Poliklinik', 'trim|required|xss_clean');
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
			
			$this->daftarkunjunganprocessfunction($db,$dataexc);
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
	
	function daftarkunjunganprocessfunction($db,$datainsert)
	{
			if($this->input->post('showhide_kunjungan')){
				$puskesmas = $this->input->post('kd_puskesmas_hidden')?$this->input->post('kd_puskesmas_hidden',TRUE):$this->session->userdata('kd_puskesmas');
				if($this->input->post('showhide_kunjungan')=='rawat_jalan'){
					$max = $db->query("select max(URUT_MASUK) as total from kunjungan where KD_PUSKESMAS='".$puskesmas."' and KD_UNIT='".$this->input->post('poliklinik',TRUE)."' ")->row();
					$max = $max->total + 1;
					$datainsert['KD_UNIT_LAYANAN'] = $this->input->post('unit_layanan',TRUE);
					$datainsert['KD_UNIT'] = $this->input->post('poliklinik',TRUE);
					$kdk = date('Y-m-d').'-'.$this->input->post('poliklinik',TRUE).'-'.$max;
					$datainsert['KD_KUNJUNGAN'] = $kdk;
					$datainsert['URUT_MASUK'] = $max;
					$datainsert['KD_LAYANAN_B'] = 'RJ';
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
	
	public function detailkunjungan()
	{
		
		// IF UNIT THEN VIEW ACCORDING TO SELECTED UNIT
		// IF UNIT THEN VIEW ACCORDING TO SELECTED UNIT
		// IF UNIT THEN VIEW ACCORDING TO SELECTED UNIT
		
		//$this->load->helper('beries_helper');
		//$this->load->helper('master1_helper');
		$this->load->helper('my_helper');
		
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("p.KD_PASIEN, p.NAMA_LENGKAP AS NAMA_PASIEN, p.KD_GOL_DARAH, p.TGL_LAHIR, jk.KUNJUNGAN_KIA",FALSE);
		$db->from('trans_kia k');
		$db->join('pelayanan pl','pl.KD_PELAYANAN=k.KD_PELAYANAN','left');
		$db->join('pasien p','p.KD_PASIEN=pl.KD_PASIEN','left');
		$db->join('mst_kunjungan_kia jk','jk.KD_KUNJUNGAN_KIA=k.KD_KUNJUNGAN_KIA','left');
		//$db->join('mst_unit u','k.KD_UNIT=p.KD_UNIT');
		$db->where('p.KD_PASIEN ',$id);
		$db->where('jk.KD_KUNJUNGAN_KIA ',$id2);
		$val = $db->get()->row();
		$data['data']=$val;	//print_r($data)	;die;
		
		$this->load->view('allkunjungan/v_t_kunjungan_all', $data);
	}	
	public function hamil()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_kesehatan_ibu_dan_anak/v_pelayanan_kb_add');
	}
	
}

/* End of file t_kesehatan_ibu_dan_anak.php */
/* Location: ./application/controllers/t_kesehatan_ibu_dan_anak.php */