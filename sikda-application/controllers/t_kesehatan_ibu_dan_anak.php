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
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$data['get_kd_pasien'] = $this->input->post('get_kd_pasien')?$this->input->post('get_kd_pasien',TRUE):null; //print_r($data);die;
		$this->load->view('t_pelayanan/kunjungan/v_t_pelayanan_bersalin_popup',$data);
	}
	
	public function pelayananbersalinpopupxml()
	{
		$this->load->model('t_kesehatan_ibu_dan_anak_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'kode'=>$this->input->post('kode'),
					'get_kd_pasien'=>$this->input->post('get_kd_pasien')
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
					'kode'=>$this->input->post('kode'),
					'get_kd_pasien'=>$this->input->post('get_kd_pasien')
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
		$val->set_rules('ket_tambahan');
		if($this->input->post('jenis_kelahiran')==1){		
			$val->set_rules('anak_ke', 'Anak Ke', 'trim|required|xss_clean');
			$val->set_rules('berat_lahir', 'Berat Lahir', 'trim|required|xss_clean');
			$val->set_rules('panjang_badan', 'Panjang Badan', 'trim|required|xss_clean');
			$val->set_rules('lingkar_kepala', 'Lingkar Kepala', 'trim|required|xss_clean');
			$val->set_rules('jk', 'Jenis Kelamin', 'trim|required|xss_clean');
		}
		$arraybayi = $this->input->post('databayi_final')?json_decode($this->input->post('databayi_final',TRUE)):NULL;//print_r($arraykeadaanbayi);die;
		$arraykeadaanbayi = $this->input->post('keadaanbayi_final')?json_decode($this->input->post('keadaanbayi_final',TRUE)):NULL;//print_r($arraykeadaanbayi);die;
		$arrayasuhanbayi = $this->input->post('asuhanbayi_final')?json_decode($this->input->post('asuhanbayi_final',TRUE)):NULL;
		$arrayobat = $this->input->post('obat_final')?json_decode($this->input->post('obat_final',TRUE)):NULL; //print_r($arrayobat);die;
		$arrayalergi = $this->input->post('alergi_final')?json_decode($this->input->post('alergi_final',TRUE)):NULL;//print_r($arrayalergi);die;
		$arraytindakan = $this->input->post('tindakan_final')?json_decode($this->input->post('tindakan_final',TRUE)):NULL;
		$arraydiagnosa = $this->input->post('diagnosa_final')?json_decode($this->input->post('diagnosa_final',TRUE)):NULL;
		$datainsert = array();		
		
		
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
			
			//// Insert Data Alergi Obat ////
			if($arrayalergi){
				foreach($arrayalergi as $rowalergiloop){
					$dataalergitmp = json_decode($rowalergiloop);
					$dataalergiloop[] = array(
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
						'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
						'KD_OBAT' => $dataalergitmp->kd_obat,
						'Created_By' => $this->session->userdata('user_name'),
						'Created_Date' => date('Y-m-d H:i:s')
					);
					$dataalergiinsert = $dataalergiloop; //print_r($dataalergiinsert);die;
				}
				$db->insert_batch('pasien_alergi_obt',$dataalergiinsert);
			}
			
			
			/// Data Insert Table Pelayanan Kasir ///
			$maxkasir = 0;
			$maxkasir = $db->query("SELECT MAX(SUBSTR(KD_PEL_KASIR,-7)) AS total FROM pel_kasir where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
			$maxkasir = $maxkasir->total + 1;
			$kodekasir = 'KASIR'.sprintf("%07d", $maxkasir);
			
			$datainsertkasir=array(
				'KD_PEL_KASIR'=> $kodekasir,
				'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
				'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
				'KD_UNIT' => $this->input->post('kd_unit_hidden',TRUE),
				'KD_TARIF' => 0,
				'JUMLAH_BIAYA' => 0,
				'JUMLAH_PPN' => 0,
				'JUMLAH_DISC' => 0,
				'JUMLAH_TOTAL' => 0,
				'KD_USER' => $this->session->userdata('kd_petugas'),
				'STATUS_TX' => 0
			);	//print_r($datainsertkasir); die;
			$db->insert('pel_kasir',$datainsertkasir);
			
			// Data Insert Pelayanan //
			$maxpelayanan = 0;
			$maxpelayanan = $db->query("SELECT MAX(SUBSTR(KD_PELAYANAN,-7)) AS total FROM pelayanan where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
			$maxpelayanan = $maxpelayanan->total + 1;
			$kodepelayanan = $this->input->post('kd_unit_hidden',TRUE).sprintf("%07d", $maxpelayanan);
			
			$datainsert = array(
                'KD_PELAYANAN' =>  $kodepelayanan,
                'TGL_PELAYANAN' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_daftar')))),
                'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
                'KD_UNIT' => '219',
                'UNIT_PELAYANAN' => 'RJ',
                'URUT_MASUK' => $this->input->post('kd_urutmasuk_hidden',TRUE),
                'KD_KASIR' => $kodekasir,
                'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
                //'ANAMNESA' => $this->input->post('anamnesa',TRUE),
                //'KONDISI_PASIEN' => '-',
                //'CATATAN_FISIK' => $this->input->post('catatan_fisik',TRUE),
                'CARA_BAYAR' => $this->input->post('cara_bayar',TRUE),
                'JENIS_PASIEN' => $this->input->post('jenis_pasien',TRUE),
                'KD_USER' => $this->session->userdata('kd_petugas'),
                'CATATAN_DOKTER' => $this->input->post('catatan_dokter',TRUE),
                'Created_Date' => date('Y-m-d'),
                'Created_By' => $this->session->userdata('kd_petugas'),
                'KD_DOKTER' => $this->input->post('dokter')?$this->input->post('dokter',TRUE):NULL,
                'KEADAAN_KELUAR' => $this->input->post('status_keluar',TRUE)
            );
			if(empty($arrayobat)){
				$datainsert['STATUS_LAYANAN'] = '1';
			}
			
			$db->insert('pelayanan',$datainsert);
			
			$kdkunjungan=$this->input->post('kd_kunjungan_hidden',true);
			$db->set('KD_PELAYANAN',$kodepelayanan);
			$db->where('ID_KUNJUNGAN',$kdkunjungan);
			$db->update('kunjungan');
			
			$data_pasien = array(
				'CARA_BAYAR' => $this->input->post('cara_bayar',TRUE),
                'KD_CUSTOMER' => $this->input->post('jenis_pasien',TRUE)
			);
			$db->where('KD_PASIEN', $this->input->post('kd_pasien_hidden'));
			$db->update('pasien',$data_pasien);
			
			// Update Trans KIA //
			$datakia = array(
				'KD_DOKTER_PEMERIKSA' => $this->input->post('dokter')?$this->input->post('dokter',TRUE):NULL,
				'KD_DOKTER_PETUGAS' => $this->input->post('petugas')?$this->input->post('petugas',TRUE):NULL,
				'KD_KUNJUNGAN_KIA' => $this->input->post('kia_ibu',TRUE),
				'KD_PELAYANAN'=> $datainsert['KD_PELAYANAN'],
				'nupdate_oleh' => $this->session->userdata('user_name'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
				);
				$db->where('ID_KUNJUNGAN', $this->input->post('kd_kunjungan_hidden',TRUE));//print_r($datakia);die;
				$db->update('trans_kia', $datakia);
			
			// Insert data anak pasien //
			$a = $db->query("SELECT f.NO_KK,f.NAMA_KK,f.KD_FAMILY_FOLDER FROM family_folder f JOIN pasien p ON f.ID_FAMILY_FOLDER=p.ID_FAMILY_FOLDER WHERE p.KD_PASIEN='".$this->input->post('kd_pasien_hidden')."'")->row();
			if($this->input->post('jenis_kelahiran')=='1'){
				$datafamilyanak = array(
					'KD_FAMILY_FOLDER' => $a->KD_FAMILY_FOLDER,
					'NO_KK' => $this->input->post('no_kk')?$this->input->post('no_kk'):$a->NO_KK,
					'NAMA_KK' => $this->input->post('nama_kk')?$this->input->post('nama_kk'):$a->NAMA_KK,
					'KD_STATUS_KELUARGA' => '3',
					'ninput_oleh' => $this->session->userdata('user_name'),
					'ninput_tgl' => date('Y-m-d')
				);
				$db->insert('family_folder',$datafamilyanak);
				$idfamily = $db->insert_id();
				$kab_id = substr($this->session->userdata('kd_puskesmas'),1,4);
				$kab = $db->query("select KABUPATEN from mst_kabupaten where KD_KABUPATEN='".$kab_id."'")->row();
				$max = $db->query("SELECT MAX(SUBSTR(kd_pasien,-7)) AS total FROM pasien where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
				$max = $max->total + 1;
				$datapasien = array(
					'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
					'KD_PASIEN'=> $this->session->userdata('kd_puskesmas').sprintf("%07d", $max),
					'TGL_LAHIR' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tanggal_daftar')))),
					'KD_JENIS_KELAMIN' => $val->set_value('jk'),
					'NAMA_LENGKAP' => 'Anak Ibu '.sprintf($this->input->post('nama_lengkap_hidden')),
					'TEMPAT_LAHIR' => $kab->KABUPATEN,
					'ID_FAMILY_FOLDER' => $idfamily,
					'KD_AGAMA' => NULL,
					'STATUS_MARITAL' => '2',
					'TGL_PENDAFTARAN' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tanggal_daftar')))),
					'ANAK_KE' => $val->set_value('anak_ke'),
					'BERAT_LAHIR' => $val->set_value('berat_lahir'),				
					'PANJANG_BADAN' => $val->set_value('panjang_badan'),
					'LINGKAR_KEPALA' => $val->set_value('lingkar_kepala'),
					'Created_By' => $this->session->userdata('nusername'),
					'Created_Date' => date('Y-m-d H:i:s')
				);
				//print_r($datapasien);die;
				$db->insert('pasien', $datapasien);
			}else{
				if($arraybayi){
					$idfamily = 0;
					$max1 = 1;
					foreach($arraybayi as $rowbayiloop){
						$databayitmp = json_decode($rowbayiloop);
						$datafamilyanak = array(
							'KD_FAMILY_FOLDER' => $a->KD_FAMILY_FOLDER,
							'NO_KK' => $this->input->post('no_kk')?$this->input->post('no_kk'):$a->NO_KK,
							'NAMA_KK' => $this->input->post('nama_kk')?$this->input->post('nama_kk'):$a->NAMA_KK,
							'KD_STATUS_KELUARGA' => '3',
							'ninput_oleh' => $this->session->userdata('user_name'),
							'ninput_tgl' => date('Y-m-d')
						);
						$db->insert('family_folder',$datafamilyanak);//print_r($db->last_query());die;
						$idfamily = $db->insert_id();
						$db->trans_commit();
						$kab_id = substr($this->session->userdata('kd_puskesmas'),1,4);
						$kab = $db->query("select KABUPATEN from mst_kabupaten where KD_KABUPATEN='".$kab_id."'")->row();
						$max = $db->query("SELECT MAX(SUBSTR(kd_pasien,-7)) AS total FROM pasien where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
						$max = $max->total + $max1;
						$databayiloop[] = array(
							'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
							'KD_PASIEN'=> $this->session->userdata('kd_puskesmas').sprintf("%07d", $max),
							'TGL_LAHIR' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tanggal_daftar')))),
							'KD_JENIS_KELAMIN' => $databayitmp->jenis_kelamin,
							'NAMA_LENGKAP' => 'Anak '.$databayitmp->anak_ke.' Ibu '.$this->input->post('nama_lengkap_hidden'),
							'TEMPAT_LAHIR' => $kab->KABUPATEN,
							'ID_FAMILY_FOLDER' => $idfamily,
							'KD_AGAMA' => NULL,
							'STATUS_MARITAL' => '2',
							'TGL_PENDAFTARAN' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tanggal_daftar')))),
							'ANAK_KE' => $databayitmp->anak_ke,
							'BERAT_LAHIR' => $databayitmp->berat_lahir,				
							'PANJANG_BADAN' => $databayitmp->panjang_badan,
							'LINGKAR_KEPALA' => $databayitmp->lingkar_kepala,
							'Created_By' => $this->session->userdata('nusername'),
							'Created_Date' => date('Y-m-d H:i:s')
						);
						$datainsertbayi = $databayiloop;
						$idfamily++;
						$max1++;
					}	
					$db->insert_batch('pasien',$datainsertbayi);	
				}
			}
			
			// Insert Kunjungan Bersalin //
			$kd_pasien = $this->session->userdata('kd_puskesmas').sprintf("%07d", $maxpelayanan);				
			$kodekia = $db->query("select KD_KIA from trans_kia where ID_KUNJUNGAN='". $this->input->post('kd_kunjungan_hidden')."'")->row();//print_r($kodekia);die;

			$dataexc = array(
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
						'KD_KIA' => $kodekia->KD_KIA,
						'TANGGAL_PERSALINAN' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tanggal_daftar')))),
						'JAM_KELAHIRAN' => $val->set_value('jam_kelahiran'),
						'KD_KET_WAKTU' => $val->set_value('ket_waktu'),
						'UMUR_KEHAMILAN' => $val->set_value('umur_kehamilan'),
						'KD_DOKTER' => $val->set_value('dokter'),
						'KD_CARA_BERSALIN' => $val->set_value('jenis_persalinan'),
						'KD_JENIS_KELAHIRAN' => $val->set_value('jenis_kelahiran'),
						'JML_BAYI' => $val->set_value('jumlah_bayi'),
						'KD_KEADAAN_KESEHATAN' => $val->set_value('keadaan_kesehatan'),
						'KD_STATUS_HAMIL' => $val->set_value('status_hamil'),
						'ANAK_KE' => $val->set_value('anak_ke'),
						'BERAT_LAHIR' => $val->set_value('berat_lahir'),				
						'PANJANG_BADAN' => $val->set_value('panjang_badan'),
						'LINGKAR_KEPALA' => $val->set_value('lingkar_kepala'),
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
						'KD_KEADAAN_BAYI_LAHIR' => $datakeadaanbayitmp->kd_keadaan_bayi_lahir,
						'KEADAAN_BAYI_LAHIR' => $datakeadaanbayitmp->keadaan_bayi_lahir
					);
					
					$datakeadaanbayiinsert = $datakeadaanbayiloop;
				}//print_r($datakeadaanbayiinsert);die;
				$db->insert_batch('detail_keadaan_bayi',$datakeadaanbayiinsert);
			}
			
			if($arrayasuhanbayi){
				foreach($arrayasuhanbayi as $rowasuhanbayiloop){
					$dataasuhanbayitmp = json_decode($rowasuhanbayiloop);
					$dataasuhanbayiloop[] = array(
						'KD_KUNJUNGAN_BERSALIN' => $kdbersalin,
						'KD_ASUHAN_BAYI_LAHIR' => $dataasuhanbayitmp->kd_asuhan_bayi_lahir,
						'ASUHAN_BAYI_LAHIR' => $dataasuhanbayitmp->asuhan_bayi_lahir
					);
					$dataasuhanbayiinsert = $dataasuhanbayiloop;
				}//print_r($dataasuhanbayiinsert);die;
				$db->insert_batch('detail_asuhan_bayi',$dataasuhanbayiinsert);
			}
			/// Insert Data Order Obat ///
			$qtyobattotal=0;
			$hargaobattotal=0;
			if($arrayobat){
				$maxpelayananobat = 0;
				$maxpelayananobat = $db->query("SELECT MAX(SUBSTR(KD_PELAYANAN,-7)) AS total FROM pelayanan where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
				$maxpelayananobat = $maxpelayananobat->total + 1;
				$kodepelayananobat = '6'.sprintf("%07d", $maxpelayananobat);
				$kodepelayananresep = 'R'.sprintf("%07d", $maxpelayananobat);
				$irow=1;
				foreach($arrayobat as $rowobatloop){
					$dataobattmp = json_decode($rowobatloop);
					$dataobatloop[] = array(
						'KD_PELAYANAN_OBAT' => $kodepelayananobat,
						'KD_PELAYANAN' => $kodepelayanan,
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
						'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
						'NO_RESEP' => $kodepelayananresep,
						'KD_OBAT' => $dataobattmp->kd_obat,
						'HRG_JUAL' => $dataobattmp->harga,
						'SAT_BESAR' => '',
						'SAT_KECIL' => '',
						'QTY' => $dataobattmp->jumlah,
						'DOSIS' => $dataobattmp->dosis,
						'JUMLAH' => $dataobattmp->jumlah,
						'KD_PETUGAS' => $this->session->userdata('user_name'),
						'STATUS' => 0,
						'iROW' => $irow,
						'TANGGAL' => date('Y-m-d'),
						'Created_By' => $this->session->userdata('user_name'),
						'Created_Date' => date('Y-m-d H:i:s')
					);
					
					$qtyobattotal = $qtyobattotal+$dataobattmp->jumlah;
					$hargaobattotal = $hargaobattotal+($dataobattmp->harga*$dataobattmp->jumlah);
					
					$dataobatinsert = $dataobatloop;
					$irow++;
				}
				
				$simpanKasir = array(
					'KD_PEL_KASIR' => $kodekasir,
					'KD_TARIF' =>  'AM',
					'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
					'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
					'REFF' => $kodepelayanan,
					'KD_PRODUK' => "TRA",
					'KD_UNIT' => '6',
					'HARGA_PRODUK' => 0,
					'TGL_BERLAKU' => date('Y-m-d'),
					'QTY' => $qtyobattotal,
					'TOTAL_HARGA' => $hargaobattotal
				);
				
				$db->insert_batch('pel_ord_obat',$dataobatinsert);			 
				$db->insert("pel_kasir_detail", $simpanKasir);
			}
			
			if($arraydiagnosa){
				$irow3=1;
				foreach($arraydiagnosa as $rowdiagnosaloop){
					$datadiagnosatmp = json_decode($rowdiagnosaloop);
					$datadiagnosaloop[] = array(
						'KD_PELAYANAN' => $kodepelayanan,
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
						'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
						'KD_PENYAKIT' => $datadiagnosatmp->kd_penyakit,
						'JNS_KASUS' => $datadiagnosatmp->jenis_kasus,
						'JNS_DX' => $datadiagnosatmp->jenis_diagnosa,
						'KD_PETUGAS' => $this->session->userdata('user_name'),
						'iROW' => $irow3,
						'TANGGAL' => date('Y-m-d'),
						'Created_By' => $this->session->userdata('user_name'),
						'Created_Date' => date('Y-m-d H:i:s')
					);
					$datadiagnosainsert = $datadiagnosaloop;
					$irow3++;
				}
				$db->insert_batch('pel_diagnosa',$datadiagnosainsert);
			}
			
			/// Insert Data Tindakan ///
			if($arraytindakan){
				$irow2=1;
				foreach($arraytindakan as $rowtindakanloop){
					$datatindakantmp = json_decode($rowtindakanloop);
					$datatindakanloop[] = array(
						'KD_PELAYANAN' => $kodepelayanan,
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
						'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
						'KD_TINDAKAN' => $datatindakantmp->kd_tindakan,
						'QTY' => $datatindakantmp->jumlah?$datatindakantmp->jumlah:0,
						'HRG_TINDAKAN' => $datatindakantmp->harga?$datatindakantmp->harga:0,
						'KETERANGAN' => $datatindakantmp->keterangan,
						'KD_PETUGAS' => $this->session->userdata('user_name'),
						'iROW' => $irow2,
						'TANGGAL' => date('Y-m-d'),
						'Created_By' => $this->session->userdata('user_name'),
						'Created_Date' => date('Y-m-d H:i:s')
					);					
					
					$datainsertkasirdetailloop[]=array(
						'KD_PEL_KASIR'=> $kodekasir,
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
						'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
						'KD_PRODUK' => $datatindakantmp->kd_tindakan,
						'REFF' => $kodepelayanan,
						'KD_UNIT' => '6',
						'KD_TARIF' => 'AM',
						'HARGA_PRODUK' => $datatindakantmp->harga,
						'QTY' => $datatindakantmp->jumlah,
						'TOTAL_HARGA' => $datatindakantmp->harga*$datatindakantmp->jumlah,
						'TGL_BERLAKU' => date('Y-m-d')						
					);
					
					$datatindakaninsert = $datatindakanloop;
					$datainsertkasirdetail = $datainsertkasirdetailloop;
					$irow2++;	
							
				}//print_r($datatindakaninsert);die;
				$db->insert_batch('pel_tindakan',$datatindakaninsert);
				$db->insert_batch('pel_kasir_detail',$datainsertkasirdetail);
			}
			
			$dataexc = array(
				'STATUS' => 1,
				'KD_PELAYANAN' => $kodepelayanan
			);						
			$db->where('ID_KUNJUNGAN',$this->input->post('kd_kunjungan_hidden',TRUE));
			$db->update('kunjungan',$dataexc);
			
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
	
	
	public function editprocess()
	{//print_r($_POST);die;
		$pasien=$this->input->post('kd_pasien_hidden')?$this->input->post('kd_pasien_hidden'):null;
		$puskesmas=$this->input->post('kd_puskesmas_hidden')?$this->input->post('kd_puskesmas_hidden'):$this->session->userdata('kd_pasien');
		$kunjungan=$this->input->post('kd_kunjungan_hidden')?$this->input->post('kd_kunjungan_hidden',true):null;//print_r($kunjungan);die;
		$pelayanan=$this->input->post('kd_pelayanan_hidden')?$this->input->post('kd_pelayanan_hidden'):null;
		$kdbersalin=$this->input->post('kodebersalin')?$this->input->post('kodebersalin'):null;
		$this->load->library('form_validation');
		$val = $this->form_validation;
	
		$val->set_rules('tanggal_daftar', 'Tanggal Kunjungan', 'trim|required');				
		$val->set_rules('jam_kelahiran', 'Jam Kelahiran', 'trim|required|xss_clean');		
		//$val->set_rules('ket_waktu', 'Jam Kelahiran', 'trim|required|xss_clean');
		$val->set_rules('umur_kehamilan', 'Umur Kehamilan', 'trim|required|xss_clean');
		//$val->set_rules('dokter', 'Dokter', 'trim|required|xss_clean');
		$val->set_rules('jenis_persalinan', 'Jenis Persalinan', 'trim|required|xss_clean');
		$val->set_rules('jenis_kelahiran', 'Jenis Kelahiran', 'trim|required|xss_clean');
		$val->set_rules('jumlah_bayi', 'Jumlah Bayi', 'trim|required|xss_clean|integer');
		$val->set_rules('keadaan_kesehatan', 'Keadaan Ibu', 'trim|required|xss_clean');
		$val->set_rules('status_hamil', 'Status Hamil', 'trim|required|xss_clean');
		$val->set_rules('ket_tambahan');
		if($this->input->post('jenis_kelahiran')==1){		
			$val->set_rules('anak_ke', 'Anak Ke', 'trim|required|xss_clean');
			$val->set_rules('berat_lahir', 'Berat Lahir', 'trim|required|xss_clean');
			$val->set_rules('panjang_badan', 'Panjang Badan', 'trim|required|xss_clean');
			$val->set_rules('lingkar_kepala', 'Lingkar Kepala', 'trim|required|xss_clean');
			$val->set_rules('jk', 'Jenis Kelamin', 'trim|required|xss_clean');
		}
		
		$arraybayi = $this->input->post('databayi_final')?json_decode($this->input->post('databayi_final',TRUE)):NULL;//print_r($arraykeadaanbayi);die;
		$arraykeadaanbayi = $this->input->post('keadaanbayi_final')?json_decode($this->input->post('keadaanbayi_final',TRUE)):NULL;//print_r($arraykeadaanbayi);die;
		$arrayasuhanbayi = $this->input->post('asuhanbayi_final')?json_decode($this->input->post('asuhanbayi_final',TRUE)):NULL;
		$arrayobat = $this->input->post('obat_final')?json_decode($this->input->post('obat_final',TRUE)):NULL; //print_r($arrayobat);die;
		$arrayalergi = $this->input->post('alergi_final')?json_decode($this->input->post('alergi_final',TRUE)):NULL;//print_r($arrayalergi);die;
		$arraytindakan = $this->input->post('tindakan_final')?json_decode($this->input->post('tindakan_final',TRUE)):NULL;
		$arraydiagnosa = $this->input->post('diagnosa_final')?json_decode($this->input->post('diagnosa_final',TRUE)):NULL;
		
		
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
			
			$db->set('STATUS','1');
			//$db->where('KD_PUSKESMAS',$puskesmas);
			$db->where('KD_PELAYANAN',$pelayanan);
			$db->where('KD_PASIEN',$pasien);
			$db->update('kunjungan');
			
			
			$datainsert = array(
                'STATUS_LAYANAN' => 6,
				'Modified_Date' => date('Y-m-d'),
                'Modified_By' => $this->session->userdata('kd_petugas'),
				
            );
			$db->where('KD_PELAYANAN',$pelayanan);//print_r($datainsert);die;
			$db->update('pelayanan',$datainsert);
			
			
			$check = array(
                'CATATAN_DOKTER' => $this->input->post('catatan_dokter')
            );
			$db->where('KD_PELAYANAN',$pelayanan);
			$db->update('check_coment',$check);
			
			// Update Trans KIA //
			$datakia = array(
				'KD_DOKTER_PEMERIKSA' => $this->input->post('dokter')?$this->input->post('dokter',TRUE):NULL,
				'KD_DOKTER_PETUGAS' => $this->input->post('petugas')?$this->input->post('petugas',TRUE):NULL,
				'nupdate_oleh' => $this->session->userdata('user_name'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
				);
				$db->where('ID_KUNJUNGAN', $kunjungan);//print_r($datakia);die;
				$db->update('trans_kia', $datakia);
				
				
				// Insert data anak pasien //
			/*$a = $db->query("SELECT f.NO_KK,f.NAMA_KK,f.KD_FAMILY_FOLDER FROM family_folder f JOIN pasien p ON f.ID_FAMILY_FOLDER=p.ID_FAMILY_FOLDER WHERE p.KD_PASIEN='".$this->input->post('kd_pasien_hidden')."'")->row();
			if($this->input->post('jenis_kelahiran')=='1'){
				$datafamilyanak = array(
					'KD_FAMILY_FOLDER' => $a->KD_FAMILY_FOLDER,
					'NO_KK' => $this->input->post('no_kk')?$this->input->post('no_kk'):$a->NO_KK,
					'NAMA_KK' => $this->input->post('nama_kk')?$this->input->post('nama_kk'):$a->NAMA_KK,
					'KD_STATUS_KELUARGA' => '3',
					'ninput_oleh' => $this->session->userdata('user_name'),
					'ninput_tgl' => date('Y-m-d')
				);
				$db->where('KD_FAMILY_FOLDER',$datafamilyanak);
				$db->insert('family_folder',$datafamilyanak);
				
				
				if($arraybayi){
					$db->where('KD_PELAYANAN',$pelayanan);
					$db->delete('family_folder');
					
					$idfamily = 0;
					$max1 = 1;
					foreach($arraybayi as $rowbayiloop){
						$databayitmp = json_decode($rowbayiloop);
						$datafamilyanak = array(
							'KD_FAMILY_FOLDER' => $a->KD_FAMILY_FOLDER,
							'NO_KK' => $this->input->post('no_kk')?$this->input->post('no_kk'):$a->NO_KK,
							'NAMA_KK' => $this->input->post('nama_kk')?$this->input->post('nama_kk'):$a->NAMA_KK,
							'KD_STATUS_KELUARGA' => '3',
							'nupdate_oleh' => $this->session->userdata('user_name'),
							'nupdate_tgl' => date('Y-m-d')
						);
						$db->where('family_folder',$datafamilyanak);//print_r($db->last_query());die;
						$db->insert('family_folder',$datafamilyanak);//print_r($db->last_query());die;
						
						$idfamily = $db->insert_id();
						$db->trans_commit();
						$kab_id = substr($this->session->userdata('kd_puskesmas'),1,4);
						$kab = $db->query("select KABUPATEN from mst_kabupaten where KD_KABUPATEN='".$kab_id."'")->row();
						$max = $db->query("SELECT MAX(SUBSTR(kd_pasien,-7)) AS total FROM pasien where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
						$max = $max->total + $max1;
						$databayiloop[] = array(
							'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
							'KD_PASIEN'=> $this->session->userdata('kd_puskesmas').sprintf("%07d", $max),
							'TGL_LAHIR' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tanggal_daftar')))),
							'KD_JENIS_KELAMIN' => $databayitmp->jenis_kelamin,
							'NAMA_LENGKAP' => 'Anak '.$databayitmp->anak_ke.' Ibu '.$this->input->post('nama_lengkap_hidden'),
							'TEMPAT_LAHIR' => $kab->KABUPATEN,
							'ID_FAMILY_FOLDER' => $idfamily,
							'KD_AGAMA' => '',
							'STATUS_MARITAL' => '2',
							'TGL_PENDAFTARAN' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tanggal_daftar')))),
							'ANAK_KE' => $databayitmp->anak_ke,
							'BERAT_LAHIR' => $databayitmp->berat_lahir,				
							'PANJANG_BADAN' => $databayitmp->panjang_badan,
							'LINGKAR_KEPALA' => $databayitmp->lingkar_kepala,
							'Created_By' => $this->session->userdata('nusername'),
							'Created_Date' => date('Y-m-d H:i:s')
						);
						$datainsertbayi = $databayiloop;
						$idfamily++;
						$max1++;
					}	
					$db->insert_batch('pasien',$datainsertbayi);	
				}*/
				$kodekia = $db->query("select KD_KIA from trans_kia where ID_KUNJUNGAN='". $kunjungan."'")->row();//print_r($kunjungan);die;
				$kodepelkasir = $db->query("select KD_KASIR from pelayanan where KD_PELAYANAN='".$pelayanan."'")->row();
				
				$dataexc = array(
						'KD_PASIEN' => $pasien,
						'KD_KIA' => $kodekia->KD_KIA,
						'KD_KUNJUNGAN_BERSALIN' => $kdbersalin,
						'TANGGAL_PERSALINAN' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tanggal_daftar')))),
						'JAM_KELAHIRAN' => $this->input->post('jam_kelahiran'),
						'KD_KET_WAKTU' => $this->input->post('ket_waktu'),
						'UMUR_KEHAMILAN' => $this->input->post('umur_kehamilan'),
						'KD_DOKTER' => $this->input->post('dokter')?$this->input->post('dokter',TRUE):NULL,
						'KD_CARA_BERSALIN' => $this->input->post('kd_cara_persalinan'),
						'KD_JENIS_KELAHIRAN' => $this->input->post('kd_cara_persalinan'),
						'JML_BAYI' => $this->input->post('jumlah_bayi'),
						'KD_KEADAAN_KESEHATAN' => $this->input->post('kd_keadaan_kesehatan'),
						'KD_STATUS_HAMIL' => $this->input->post('kd_status_hamil'),
						'ANAK_KE' => $this->input->post('anak_ke'),
						'BERAT_LAHIR' => $this->input->post('berat_lahir'),				
						'PANJANG_BADAN' => $this->input->post('panjang_badan'),
						'LINGKAR_KEPALA' => $this->input->post('lingkar_kepala'),
						//'KD_KEADAAN_BAYI_LAHIR' => $val->set_value('keadaan_bayi_lahir'),
						//'KD_ASUHAN_BAYI_LAHIR' => $val->set_value('asuhan_bayi_lahir'),
						'KET_TAMBAHAN' => $this->input->post('ket_tambahan'),
						'nupdate_oleh' => $this->session->userdata('nusername'),
						'nupdate_tgl' => date('Y-m-d H:i:s')
					);
					//print_r($dataexc);die;
			$db->where('KD_KIA', $kodekia->KD_KIA);
			$db->update('kunjungan_bersalin', $dataexc);
			
			
				$db->where('KD_KUNJUNGAN_BERSALIN',$kdbersalin);
				$db->delete('detail_keadaan_bayi');
			if($arraykeadaanbayi){
				
				foreach($arraykeadaanbayi as $rowkeadaanbayiloop){
					$datakeadaanbayitmp = json_decode($rowkeadaanbayiloop);
					$datakeadaanbayiloop[] = array(
						'KD_KUNJUNGAN_BERSALIN' => $kdbersalin,
						'KD_KEADAAN_BAYI_LAHIR' => $datakeadaanbayitmp->kd_keadaan_bayi_lahir,
						'KEADAAN_BAYI_LAHIR' => $datakeadaanbayitmp->keadaan_bayi_lahir
					);
					
					$datakeadaanbayiinsert = $datakeadaanbayiloop;
				}//print_r($datakeadaanbayiinsert);die;
				$db->insert_batch('detail_keadaan_bayi',$datakeadaanbayiinsert);
			}
			
				$db->where('KD_KUNJUNGAN_BERSALIN',$kdbersalin);
				$db->delete('detail_asuhan_bayi');
			if($arrayasuhanbayi){
				foreach($arrayasuhanbayi as $rowasuhanbayiloop){
					$dataasuhanbayitmp = json_decode($rowasuhanbayiloop);
					$dataasuhanbayiloop[] = array(
						'KD_KUNJUNGAN_BERSALIN' => $kdbersalin,
						'KD_ASUHAN_BAYI_LAHIR' => $dataasuhanbayitmp->kd_asuhan_bayi_lahir,
						'ASUHAN_BAYI_LAHIR' => $dataasuhanbayitmp->asuhan_bayi_lahir
					);
					$dataasuhanbayiinsert = $dataasuhanbayiloop;
				}//print_r($dataasuhanbayiinsert);die;
				$db->insert_batch('detail_asuhan_bayi',$dataasuhanbayiinsert);
			}
			$db->where('KD_PELAYANAN',$pelayanan);
		$db->delete('pel_diagnosa');
		if($arraydiagnosa){
			$irow3=1;
			foreach($arraydiagnosa as $rowdiagnosaloop){
				$datadiagnosatmp = json_decode($rowdiagnosaloop);
				$datadiagnosaloop[] = array(
					'KD_PELAYANAN' => $pelayanan,
					'KD_PASIEN' => $pasien,
					'KD_PUSKESMAS' => $puskesmas,
					'KD_PENYAKIT' => $datadiagnosatmp->kd_penyakit,
					'JNS_KASUS' => $datadiagnosatmp->jenis_kasus,
					'JNS_DX' => $datadiagnosatmp->jenis_diagnosa,
					'KD_PETUGAS' => $this->session->userdata('user_name'),
					'iROW' => $irow3,
					'TANGGAL' => date('Y-m-d'),
					'Created_By' => $this->session->userdata('user_name'),
					'Created_Date' => date('Y-m-d H:i:s')
				);
				$datadiagnosainsert = $datadiagnosaloop;
				$irow3++;
			}
			$db->insert_batch('pel_diagnosa',$datadiagnosainsert);
		}
		
			$db->where('KD_PASIEN',$pasien);
			$db->delete('pasien_alergi_obt');
			if($arrayalergi){
			
			
				foreach($arrayalergi as $rowalergiloop){
					$dataalergitmp = json_decode($rowalergiloop);
					$dataalergiloop[] = array(
						'KD_PASIEN' => $pasien,
						'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
						'KD_OBAT' => $dataalergitmp->kd_obat,
						'Created_By' => $this->session->userdata('user_name'),
						'Created_Date' => date('Y-m-d H:i:s')
					);
					$dataalergiinsert = $dataalergiloop;
				}//print_r($db->last_query());die;
				$db->insert_batch('pasien_alergi_obt',$dataalergiinsert);
			}
			
			$kodepelayananobat = $db->query("select NO_RESEP,KD_PELAYANAN_OBAT from pel_ord_obat where KD_PELAYANAN='".$pelayanan."'")->row();
			
			$qtyobattotal=0;
			$hargaobattotal=0;
			
				$db->where('KD_PELAYANAN',$pelayanan);
				$db->delete('pel_ord_obat');	
				$db->where('REFF',$pelayanan);
				$db->delete('pel_kasir_detail');
			if($arrayobat){
				
				$maxpelayananobat1 = 0;
				$maxpelayananobat1 = $db->query("SELECT MAX(SUBSTR(KD_PELAYANAN,-7)) AS total FROM pelayanan where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
				$maxpelayananobat1 = $maxpelayananobat1->total + 1;
				$kodepelayananobat1 = '6'.sprintf("%07d", $maxpelayananobat1);
				$kodepelayananresep1 = 'R'.sprintf("%07d", $maxpelayananobat1);
				$qtyobattotal=0;
				$hargaobattotal=0;
				$irow=1;
				foreach($arrayobat as $rowobatloop){
					$dataobattmp = json_decode($rowobatloop);
					$dataobatloop[] = array(
						'KD_PELAYANAN_OBAT' => $kodepelayananobat?$kodepelayananobat->KD_PELAYANAN_OBAT:$kodepelayananobat1,
						'KD_PELAYANAN' => $pelayanan,
						'KD_PASIEN' => $pasien,
						'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
						'NO_RESEP' => $kodepelayananobat?$kodepelayananobat->NO_RESEP:$kodepelayananresep1,
						'KD_OBAT' => $dataobattmp->kd_obat,
						'SAT_BESAR' => '',
						'SAT_KECIL' => '',
						'HRG_JUAL' => $dataobattmp->harga,
						'QTY' => $dataobattmp->jumlah,
						'DOSIS' => $dataobattmp->dosis,
						'JUMLAH' => $dataobattmp->jumlah,
						'KD_PETUGAS' => $this->session->userdata('user_name'),
						'STATUS' => 0,
						'iROW' => $irow,
						'TANGGAL' => date('Y-m-d'),
						'Created_By' => $this->session->userdata('user_name'),
						'Created_Date' => date('Y-m-d H:i:s')
					);
					
					$qtyobattotal = $qtyobattotal+$dataobattmp->jumlah;
					$hargaobattotal = $hargaobattotal+($dataobattmp->harga*$dataobattmp->jumlah);
					
				$irow++;
				}
				$datainsertkasirdetailloop[] = array(
					'KD_PEL_KASIR'=> $kodepelkasir->KD_KASIR,
					'KD_TARIF' =>  'AM',
					'KD_PASIEN' => $pasien,
					'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
					'REFF' => $pelayanan,
					'KD_PRODUK' => "TRA",
					'KD_UNIT' => '6',
					'HARGA_PRODUK' => 0,
					'TGL_BERLAKU' => date('Y-m-d'),
					'QTY' => $qtyobattotal,
					'TOTAL_HARGA' => $hargaobattotal
				);
				
					$dataobatinsert = $dataobatloop;
					$datainsertkasirdetail1 = $datainsertkasirdetailloop;//print_r($datainsertkasirdetail1);die;
					
				$db->insert_batch('pel_ord_obat',$dataobatinsert);			 
				$db->insert_batch("pel_kasir_detail", $datainsertkasirdetail1);
			}
			
				$db->where('KD_PELAYANAN',$pelayanan);
				$db->delete('pel_tindakan');
			if($arraytindakan){
				$db->where('REFF',$pelayanan);
				$db->delete('pel_kasir_detail');
				
				$irow2=1;
				foreach($arraytindakan as $rowtindakanloop){
					$datatindakantmp = json_decode($rowtindakanloop);
					$datatindakanloop[] = array(
						'KD_PELAYANAN' => $pelayanan,
						'KD_PASIEN' => $pasien,
						'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
						'KD_TINDAKAN' => $datatindakantmp->kd_tindakan,
						'QTY' => $datatindakantmp->jumlah?$datatindakantmp->jumlah:0,
						'HRG_TINDAKAN' => $datatindakantmp->harga?$datatindakantmp->harga:0,
						'KETERANGAN' => $datatindakantmp->keterangan,
						'KD_PETUGAS' => $this->session->userdata('user_name'),
						'iROW' => $irow2,
						'TANGGAL' => date('Y-m-d'),
						'Created_By' => $this->session->userdata('user_name'),
						'Created_Date' => date('Y-m-d H:i:s')
					);					
					
					$datainsertkasirdetailloop[]=array(
						'KD_PEL_KASIR'=> $kodepelkasir->KD_KASIR,
						'KD_PASIEN' => $pasien,
						'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
						'KD_PRODUK' => $datatindakantmp->kd_tindakan,
						'REFF' => $pelayanan,
						'KD_UNIT' => '6',
						'KD_TARIF' => 'AM',
						'HARGA_PRODUK' => $datatindakantmp->harga,
						'QTY' => $datatindakantmp->jumlah,
						'TOTAL_HARGA' => $datatindakantmp->harga*$datatindakantmp->jumlah,
						'TGL_BERLAKU' => date('Y-m-d')						
					);
					
					$datatindakaninsert = $datatindakanloop;
					$datainsertkasirdetail = $datainsertkasirdetailloop;
					$irow2++;	
							
				}//print_r($datatindakaninsert);die;
				$db->insert_batch('pel_tindakan',$datatindakaninsert);
				$db->insert_batch('pel_kasir_detail',$datainsertkasirdetail);
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
	
	
	public function edit()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		
		$this->load->helper('ernes_helper');
		$this->load->helper('beries_helper');
		$this->load->helper('my_helper');
		$this->load->helper('master_helper');
		$this->load->helper('sigit_helper');
		$this->load->helper('jokos_helper');
		$this->load->helper('pemkes_helper');
		$db = $this->load->database('sikda', TRUE);
		$db->select("*");
				$db->from('vw_detail_bersalin');
				$db->where('ID_KUNJUNGAN' ,$id);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('t_kesehatan_ibu_dan_anak/v_t_kunjungan_ibu_bersalin_edit',$data);
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
	
	
	public function t_tindakanxml()
	{
		$this->load->model('t_kesehatan_ibu_dan_anak_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid2'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$total = $this->t_kesehatan_ibu_dan_anak_model->totalT_tindakan_bersalin($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'id'=>$this->input->post('myid2'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$result = $this->t_kesehatan_ibu_dan_anak_model->getT_tindakan_bersalin($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function t_alergixml()
	{
		$this->load->model('t_kesehatan_ibu_dan_anak_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid4'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$total = $this->t_kesehatan_ibu_dan_anak_model->totalT_alergi_bersalin($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'id'=>$this->input->post('myid4'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$result = $this->t_kesehatan_ibu_dan_anak_model->getT_alergi_bersalin($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function t_obatxml()
	{
		$this->load->model('t_kesehatan_ibu_dan_anak_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid3'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$total = $this->t_kesehatan_ibu_dan_anak_model->totalT_obat_bersalin($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'id'=>$this->input->post('myid3'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$result = $this->t_kesehatan_ibu_dan_anak_model->getT_obat_bersalin($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function t_asuhanxml()
	{
		$this->load->model('t_kesehatan_ibu_dan_anak_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid6')
					);
					
		$total = $this->t_kesehatan_ibu_dan_anak_model->totalT_asuhan_bayi($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'id'=>$this->input->post('myid6')
					);
					
		$result = $this->t_kesehatan_ibu_dan_anak_model->getT_asuhan_bayi($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function t_keadaanxml()
	{
		$this->load->model('t_kesehatan_ibu_dan_anak_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid5')
					);
					
		$total = $this->t_kesehatan_ibu_dan_anak_model->totalT_keadaan_bayi($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'id'=>$this->input->post('myid5')
					);
					
		$result = $this->t_kesehatan_ibu_dan_anak_model->getT_keadaan_bayi($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	
	}
	
	
	public function obatsource()
	{
		$id=$this->input->get('term')?$this->input->get('term',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$comboicd = $db->query("SELECT obat.KD_OBAT AS id,IF((st.JUMLAH_STOK_OBAT IS NULL), concat(obat.NAMA_OBAT,' => Stok: 0'), concat(obat.NAMA_OBAT,' => Stok: ',st.JUMLAH_STOK_OBAT,' => Harga:',hrg.HARGA_JUAL)) AS label,
								CASE WHEN induk.GOL_OBAT IS NULL THEN '' ELSE induk.GOL_OBAT END  AS category FROM apt_mst_obat obat 
								LEFT JOIN apt_mst_gol_obat induk ON induk.KD_GOL_OBAT = obat.KD_GOL_OBAT 
								LEFT JOIN apt_mst_harga_obat hrg ON hrg.KD_OBAT = obat.KD_OBAT 
								LEFT JOIN apt_stok_obat st ON st.KD_OBAT = obat.KD_OBAT and st.KD_PKM = '".$this->session->userdata('kd_puskesmas')."' and st.KD_MILIK_OBAT='PKM'
								where obat.NAMA_OBAT like '%".$id."%' 
								 ",false)->result_array();
		die(json_encode($comboicd));
	}
	
	
	public function obatsource_alergi()
	{
		$id=$this->input->get('term')?$this->input->get('term',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$comboicd = $db->query("SELECT obat.KD_OBAT AS id,obat.NAMA_OBAT AS label,
								CASE WHEN induk.GOL_OBAT IS NULL THEN '' ELSE induk.GOL_OBAT END  AS category FROM apt_mst_obat obat LEFT JOIN 
								apt_mst_gol_obat induk ON induk.KD_GOL_OBAT = obat.KD_GOL_OBAT where obat.NAMA_OBAT like '%".$id."%' ")->result_array();
		die(json_encode($comboicd));
	}
}

/* End of file t_kesehatan_ibu_dan_anak.php */
/* Location: ./application/controllers/t_kesehatan_ibu_dan_anak.php */