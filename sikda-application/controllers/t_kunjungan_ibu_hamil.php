<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_kunjungan_ibu_hamil extends CI_Controller {
	public function index()
	{
		$this->load->helper('pemkes_helper');
		$this->load->helper('beries_helper');
		//$this->load->helper('My_helper');
		$this->load->view('t_kunjungan_bumil/v_t_kunjungan_ibu_hamil');
	}
	
	public function kunjungan_ibu_hamil_popup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$data['get_kd_pasien'] = $this->input->post('kd_pasien');
		$this->load->view('t_pelayanan/kunjungan/v_t_kunjungan_ibu_hamil_popup',$data);
	}
	
	public function t_kunjungan_ibu_hamilxml($forPop=NULL)
	{
		$this->load->model('t_kunjungan_ibu_hamil_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'get_kd_pasien'=>$this->input->post('get_kd_pasien')
					);
					
		$total = $this->t_kunjungan_ibu_hamil_model->totalt_kunjungan_ibu_hamil($paramstotal);
		
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
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'get_kd_pasien'=>$this->input->post('get_kd_pasien')
					);
					
		$result = $this->t_kunjungan_ibu_hamil_model->gett_kunjungan_ibu_hamil($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->helpers('pemkes_helper');
		//$this->load->helpers('My_helper');
		$this->load->helpers('beries_helper');		
		$this->load->view('t_kunjungan_bumil/v_t_kunjungan_ibu_hamil_add',$data);
	}
	
	public function addprocess()
	{//print_r($_POST);die;
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kunjungan_ke', 'Kunjungan Ke', 'trim|required|xss_clean');
		$val->set_rules('keluhan', 'Keluhan');
		$val->set_rules('tekanan_darah', 'Tekanan Darah');
		$val->set_rules('berat_badan', 'Berat Badan');
		$val->set_rules('umur_hamil', 'Umur Kehamilan');
		$val->set_rules('tinggi_fundus', 'Tinggi Fundus');
		$val->set_rules('letak_janin', 'Letak Janin');
		$val->set_rules('denyut_jantung', 'Denyut Jantung');
		$val->set_rules('kaki_bengkak', 'Kaki Bengkak');
		$val->set_rules('lab_darah', 'Lab Darah');
		$val->set_rules('lab_urin_reduksi', 'Lab Urin Reduksi');
		$val->set_rules('lab_urin_protein', 'Lab Urin Protein');
		$val->set_rules('status_hamil', 'Status Hamil');
		$val->set_rules('pemeriksaan_khusus', 'Pemeriksaan Khusus');
		$val->set_rules('nasehat', 'Nasehat', 'trim|required|xss_clean');
		$val->set_rules('nama_pemeriksa', 'Pemeriksa', 'trim|required|xss_clean');
		$val->set_rules('nama_petugas', 'Petugas');
		
		$val->set_message('required', "Silahkan isi field \"%s\"");
		
		$arrayobat = $this->input->post('obat_final')?json_decode($this->input->post('obat_final',TRUE)):NULL;
		$arrayalergi = $this->input->post('alergi_final')?json_decode($this->input->post('alergi_final',TRUE)):NULL;
		$arraytindakan = $this->input->post('tindakan_final')?json_decode($this->input->post('tindakan_final',TRUE)):NULL;
		$arraydiagnosa = $this->input->post('diagnosa_final')?json_decode($this->input->post('diagnosa_final',TRUE)):NULL;
		$datainsert = array();	
		
		if ($val->run() == FALSE)
		{
			$val->set_error_delimiters('<div style="color:white">', '</div>');
			die(validation_errors());
		}
		else
		{						
			$db = $this->load->database('sikda', TRUE);
			$db->trans_begin();
			
			//Data Insert Alergi Obat//
			if($arrayalergi){
				foreach($arrayalergi as $rowalergiloop){
					$dataalergitmp = json_decode($rowalergiloop);
					$dataalergiloop[] = array(
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
						'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
						'KD_OBAT' => $dataalergitmp->kd_obat,
						'Created_By' => $this->session->userdata('user_name'),
						'Created_Date' => date('Y-m-d H:i:s')
					);
					$dataalergiinsert = $dataalergiloop;
				}
				$db->insert_batch('pasien_alergi_obt',$dataalergiinsert);
			}
			
			//Data Insert Tabel Pelayanan Kasir//
			
			$maxkasir = 0;
			$maxkasir = $db->query("SELECT MAX(SUBSTR(KD_PEL_KASIR,-7)) AS total FROM pel_kasir where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
			$maxkasir = $maxkasir->total + 1;
			$kodekasir = 'KASIR'.sprintf("%07d", $maxkasir);
			
			$datainsertkasir=array(
				'KD_PEL_KASIR'=> $kodekasir,
				'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
				'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
				'KD_UNIT' => $this->input->post('kd_unit_hidden',TRUE),
				'KD_TARIF' => 0,
				'JUMLAH_BIAYA' => 0,
				'JUMLAH_PPN' => 0,
				'JUMLAH_DISC' => 0,
				'JUMLAH_TOTAL' => 0,
				'KD_USER' => $this->session->userdata('kd_petugas'),
				'STATUS_TX' => 0
				
			);			
			$db->insert('pel_kasir',$datainsertkasir);
			
			$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
			$id3=$this->input->get('kd_kunjungan_hidden')?$this->input->get('kd_kunjungan_hidden',TRUE):null;
			
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
                'URUT_MASUK' => $this->input->post('kd_urutmasuk_hidden',TRUE),
                'KD_KASIR' => $kodekasir,
                'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
                'UNIT_PELAYANAN' => 'RJ',
                'CARA_BAYAR' => $this->input->post('cara_bayar',TRUE),
                'JENIS_PASIEN' => $this->input->post('jenis_pasien',TRUE),
                'KD_USER' => $this->session->userdata('kd_petugas'),
                'CATATAN_DOKTER' => $this->input->post('catatan_dokter',TRUE),
                'Created_Date' => date('Y-m-d'),
                'Created_By' => $this->session->userdata('kd_petugas'),
                'KD_DOKTER' =>  $this->input->post('nama_pemeriksa')?$this->input->post('nama_pemeriksa',TRUE):NULL,
                'KEADAAN_KELUAR' => $this->input->post('status_keluar',TRUE)
				
            );
			if(empty($arrayobat)){
				$datainsert['STATUS_LAYANAN'] = '1';
			}
			
			$db->insert('pelayanan',$datainsert);
			
			$data_pasien = array(
				'CARA_BAYAR' => $this->input->post('cara_bayar',TRUE),
                'KD_CUSTOMER' => $this->input->post('jenis_pasien',TRUE),
			);
			$db->where('KD_PASIEN', $this->input->post('kd_pasien_hidden'));
			$db->update('pasien',$data_pasien);
			
			$kdkunjungan=$this->input->post('kd_kunjungan_hidden',true);
			$db->set('KD_PELAYANAN',$kodepelayanan);
			$db->where('ID_KUNJUNGAN',$kdkunjungan);
			$db->update('kunjungan');
			
			// Update Trans KIA //
			$datakia = array(
				'KD_DOKTER_PEMERIKSA' => $this->input->post('nama_pemeriksa')?$this->input->post('nama_pemeriksa',TRUE):NULL,
				'KD_DOKTER_PETUGAS' => $this->input->post('nama_petugas')?$this->input->post('nama_petugas',TRUE):NULL,
				'KD_KUNJUNGAN_KIA' => $this->input->post('kia_ibu',TRUE),
				'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
				'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
				'KD_PELAYANAN'=> $datainsert['KD_PELAYANAN'],
				'nupdate_oleh' => $this->session->userdata('user_name'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
				);
				$db->where('ID_KUNJUNGAN', $this->input->post('kd_kunjungan_hidden',TRUE));//print_r($datakia);die;
				$db->update('trans_kia', $datakia);
			
			
			// Insert Kunjungan Ibu Hamil //
			$kd_pasien = $this->session->userdata('kd_puskesmas').sprintf("%07d", $maxpelayanan);				
			$kodekia = $db->query("select KD_KIA from trans_kia where ID_KUNJUNGAN='". $this->input->post('kd_kunjungan_hidden')."'")->row();//print_r($kodekia);die;
			$dataexc = array(
				'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
				'KD_KIA' => $kodekia->KD_KIA,
				'TANGGAL_KUNJUNGAN' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_daftar')))),
				'HPHT' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('hphthpl')))),
				'HPL' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('hpht')))),
				'KUNJUNGAN_KE' => $this->input->post('kunjungan_ke'),
				'KELUHAN' => $this->input->post('keluhan'),
				'TEKANAN_DARAH' => $this->input->post('tekanan_darah'),
				'BERAT_BADAN' => $this->input->post('berat_badan'),
				'TINGGI_BADAN' => $this->input->post('tinggi_badan'),
				'LILA' => $this->input->post('lila'),
				'UMUR_KEHAMILAN' => $this->input->post('umur_hamil'),
				'TINGGI_FUNDUS' => $this->input->post('tinggi_fundus'),
				'KD_LETAK_JANIN' => $this->input->post('letak_janin'),
				'DENYUT_JANTUNG' => $this->input->post('denyut_jantung'),
				'KAKI_BENGKAK' => $this->input->post('kaki_bengkak'),
				'LAB_DARAH_HB' => $this->input->post('lab_darah'),
				'LAB_URIN_REDUKSI' => $this->input->post('lab_urin_reduksi'),
				'LAB_URIN_PROTEIN' => $this->input->post('lab_urin_protein'),
				//'KD_TINDAKAN' => $this->input->post('tindakan')?$this->input->post('tindakan',TRUE):NULL,
				'PEMERIKSAAN_KHUSUS' => $this->input->post('pemeriksaan_khusus')?$this->input->post('pemeriksaan_khusus',TRUE):NULL,
				'KD_JENIS_KASUS' => $this->input->post('jenis_kasus')?$this->input->post('jenis_kasus',TRUE):NULL,
				'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
				//'KD_RS' => $this->input->post('kd_rs')?$this->input->post('kd_rs',TRUE):NULL,
				'KD_STATUS_HAMIL' => 1,
				'NASEHAT' => $this->input->post('nasehat'),				
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			$db->insert('kunjungan_bumil', $dataexc);
			
			//Data Insert Order Obat dan Kasir//
			
			if($arrayobat){
				$maxpelayananobat = 0;
				$maxpelayananobat = $db->query("SELECT MAX(SUBSTR(KD_PELAYANAN,-7)) AS total FROM pelayanan where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
				$maxpelayananobat = $maxpelayananobat->total + 1;
				$kodepelayananobat = '6'.sprintf("%07d", $maxpelayananobat);
				$kodepelayananresep = 'R'.sprintf("%07d", $maxpelayananobat);
				$qtyobattotal=0;
				$hargaobattotal=0;
				$irow=1;
				foreach($arrayobat as $rowobatloop){
					$dataobattmp = json_decode($rowobatloop);
					$dataobatloop[] = array(
						'KD_PELAYANAN_OBAT' => $kodepelayananobat,
						'KD_PELAYANAN' => $kodepelayanan,
						'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
						'NO_RESEP' => $kodepelayananresep,
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
					
					$dataobatinsert = $dataobatloop;
					$irow++;
				}
				
				$simpanKasir = array(
					'KD_PEL_KASIR' => $kodekasir,
					'KD_TARIF' =>  'AM',
					'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
					'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
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
						'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
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
				
				//Data Insert Tindakan//
			
			if($arraytindakan){
				$irow2=1;
				foreach($arraytindakan as $rowtindakanloop){
					$datatindakantmp = json_decode($rowtindakanloop);
					$datatindakanloop[] = array(
						'KD_PELAYANAN' => $kodepelayanan,
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
						'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
						'KD_TINDAKAN' => $datatindakantmp->kd_tindakan,
						'QTY' => !empty($datatindakantmp->jumlah)?$datatindakantmp->jumlah:1,
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
						'HARGA_PRODUK' => $datatindakantmp->harga?$datatindakantmp->harga:0,
						'QTY' => $datatindakantmp->jumlah?$datatindakantmp->jumlah:0,
						'TOTAL_HARGA' => $datatindakantmp->harga*$datatindakantmp->jumlah,
						'TGL_BERLAKU' => date('Y-m-d')						
					);
					
					$datatindakaninsert = $datatindakanloop;
					$datainsertkasirdetail = $datainsertkasirdetailloop;
					$irow2++;					
				}
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
	
	public function t_tindakanxml()
	{
		$this->load->model('t_kunjungan_ibu_hamil_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid2'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$total = $this->t_kunjungan_ibu_hamil_model->totalT_tindakan_bumil($paramstotal);
		
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
					
		$result = $this->t_kunjungan_ibu_hamil_model->getT_tindakan_bumil($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function t_alergixml()
	{
		$this->load->model('t_kunjungan_ibu_hamil_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid4'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$total = $this->t_kunjungan_ibu_hamil_model->totalT_alergi_bumil($paramstotal);
		
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
					
		$result = $this->t_kunjungan_ibu_hamil_model->getT_alergi_bumil($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function t_obatxml()
	{
		$this->load->model('t_kunjungan_ibu_hamil_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid3'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$total = $this->t_kunjungan_ibu_hamil_model->totalT_obat_bumil($paramstotal);
		
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
					
		$result = $this->t_kunjungan_ibu_hamil_model->getT_obat_bumil($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function editprocess()
	{
		$pasien=$this->input->post('kd_pasien_hidden')?$this->input->post('kd_pasien_hidden'):null;
		$puskesmas=$this->input->post('kd_puskesmas_hidden')?$this->input->post('kd_puskesmas_hidden'):$this->session->userdata('kd_pasien');
		$kunjungan=$this->input->post('kd_kunjungan_hidden')?$this->input->post('kd_kunjungan_hidden',true):null;//print_r($kunjungan);die;
		$pelayanan=$this->input->post('kd_pelayanan_hidden')?$this->input->post('kd_pelayanan_hidden'):null;
		$this->load->library('form_validation');
		$val = $this->form_validation;
		
		$val->set_rules('kunjungan_ke', 'Kunjungan Ke', 'trim|required|xss_clean');
		$val->set_rules('keluhan', 'Keluhan');
		$val->set_rules('tekanan_darah', 'Tekanan Darah');
		$val->set_rules('berat_badan', 'Berat Badan');
		$val->set_rules('umur_hamil', 'Umur Kehamilan');
		$val->set_rules('tinggi_fundus', 'Tinggi Fundus');
		$val->set_rules('letak_janin', 'Letak Janin');
		$val->set_rules('denyut_jantung', 'Denyut Jantung');
		$val->set_rules('kaki_bengkak', 'Kaki Bengkak');
		$val->set_rules('lab_darah', 'Lab Darah');
		$val->set_rules('lab_urin_reduksi', 'Lab Urin Reduksi');
		$val->set_rules('lab_urin_protein', 'Lab Urin Protein');
		$val->set_rules('status_hamil', 'Status Hamil');
		$val->set_rules('pemeriksaan_khusus', 'Pemeriksaan Khusus');
		$val->set_rules('nasehat', 'Nasehat', 'trim|required|xss_clean');
		$val->set_rules('nama_pemeriksa', 'Pemeriksa', 'trim|required|xss_clean');
		
		$arrayobat = $this->input->post('obat_final')?json_decode($this->input->post('obat_final',TRUE)):NULL;
		$arrayalergi = $this->input->post('alergi_final')?json_decode($this->input->post('alergi_final',TRUE)):NULL;
		$arraytindakan = $this->input->post('tindakan_final')?json_decode($this->input->post('tindakan_final',TRUE)):NULL;
		$arraydiagnosa = $this->input->post('diagnosa_final')?json_decode($this->input->post('diagnosa_final',TRUE)):NULL;
		
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
			$db->where('KD_PUSKESMAS',$puskesmas);
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
				'KD_DOKTER_PEMERIKSA' => $this->input->post('nama_pemeriksa')?$this->input->post('nama_pemeriksa',TRUE):NULL,
				'KD_DOKTER_PETUGAS' => $this->input->post('nama_petugas')?$this->input->post('nama_petugas',TRUE):NULL,
				'nupdate_oleh' => $this->session->userdata('user_name'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
				);
				$db->where('ID_KUNJUNGAN', $kunjungan);//print_r($kunjungan);die;
				$db->update('trans_kia', $datakia);
			
			$kodekia = $db->query("select KD_KIA from trans_kia where ID_KUNJUNGAN='". $kunjungan."'")->row();//print_r($kunjungan);die;
			$kodepelkasir = $db->query("select KD_KASIR from pelayanan where KD_PELAYANAN='".$pelayanan."'")->row();
			
			//$arraytindakan = $this->input->post('tindakanbumil_final')?json_decode($this->input->post('tindakanbumil_final',TRUE)):NULL;
			
			$dataexc = array(
				'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
				'KUNJUNGAN_KE' => $this->input->post('kunjungan_ke'),
				'KELUHAN' => $this->input->post('keluhan'),
				'TEKANAN_DARAH' => $this->input->post('tekanan_darah'),
				'BERAT_BADAN' => $this->input->post('berat_badan'),
				'TINGGI_BADAN' => $this->input->post('tinggi_badan'),
				'UMUR_KEHAMILAN' => $this->input->post('umur_hamil'),
				'LILA' => $this->input->post('lila'),
				'TINGGI_FUNDUS' => $this->input->post('tinggi_fundus'),
				'KD_LETAK_JANIN' => $this->input->post('letak_janin'),
				'DENYUT_JANTUNG' => $this->input->post('denyut_jantung'),
				'KAKI_BENGKAK' => $this->input->post('kaki_bengkak'),
				'LAB_DARAH_HB' => $this->input->post('lab_darah'),
				'LAB_URIN_REDUKSI' => $this->input->post('lab_urin_reduksi'),
				'LAB_URIN_PROTEIN' => $this->input->post('lab_urin_protein'),
				//'KD_TINDAKAN' => $this->input->post('tindakan')?$this->input->post('tindakan',TRUE):NULL,
				'PEMERIKSAAN_KHUSUS' => $this->input->post('pemeriksaan_khusus')?$this->input->post('pemeriksaan_khusus',TRUE):NULL,
				'KD_JENIS_KASUS' => $this->input->post('jenis_kasus')?$this->input->post('jenis_kasus',TRUE):NULL,
				'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
				//'KD_RS' => $this->input->post('kd_rs')?$this->input->post('kd_rs',TRUE):NULL,
				'KD_STATUS_HAMIL' => 1,
				'NASEHAT' => $this->input->post('nasehat'),				
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);//print_r($dataexc);die();
			$db->where('KD_KIA', $kodekia->KD_KIA);
			$db->update('kunjungan_bumil', $dataexc);
			
			/*if($arraypenyakit){
				foreach($arraypenyakit as $rowpenyakitloop){
					$datapenyakittmp = json_decode($rowpenyakitloop);
					$datapenyakitloop = array(
						'KD_PENYAKIT' => $datapenyakittmp->kd_penyakit,
						'PENYAKIT' => $datapenyakittmp->penyakit,
						'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
						'nupdate_oleh' => $this->session->userdata('user_name'),
						'nupdate_tgl' => date('Y-m-d H:i:s')
					);
					$db->update('pem_kes_icd',$datapenyakitloop);
				}

			}*/
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
		
			$db->where('KD_PELAYANAN',$pelayanan);
			$db->delete('pel_tindakan');//print_r($db->last_query());die;			
			$db->where('REFF',$pelayanan);
			$db->delete('pel_kasir_detail');
			if($arraytindakan){
			
			
				$irow2=1;
				foreach($arraytindakan as $rowtindakanloop){
					$datatindakantmp = json_decode($rowtindakanloop);
					$datatindakanloop[] = array(
						'KD_PELAYANAN' => $pelayanan,
						'KD_PASIEN' => $pasien,
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
					);//print_r($db->last_query());die;					
					
					$datainsertkasirdetailloop[]=array(
						'KD_PEL_KASIR'=> $kodepelkasir->KD_KASIR,
						'KD_PASIEN' => $pasien,
						'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
						'KD_PRODUK' => $datatindakantmp->kd_tindakan,
						'REFF' => $pelayanan,
						'KD_UNIT' => '6',
						'KD_TARIF' => 'AM',
						'HARGA_PRODUK' => $datatindakantmp->harga?$datatindakantmp->harga:0,
						'QTY' => $datatindakantmp->jumlah?$datatindakantmp->jumlah:0,
						'TOTAL_HARGA' => $datatindakantmp->harga?($datatindakantmp->harga*$datatindakantmp->jumlah):0,
						'TGL_BERLAKU' => date('Y-m-d')						
					);
					
					$datatindakaninsert = $datatindakanloop;
					$datainsertkasirdetail = $datainsertkasirdetailloop;
					$irow2++;					
				}//print_r($datainsertkasirdetail);die;
				$db->insert_batch('pel_tindakan',$datatindakaninsert);
				$db->insert_batch('pel_kasir_detail',$datainsertkasirdetail);
			}
			
			$db->where('KD_PASIEN',$pasien);
			$db->delete('pasien_alergi_obt');
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
					$dataalergiinsert = $dataalergiloop;
				}//print_r($db->last_query());die;
				$db->insert_batch('pasien_alergi_obt',$dataalergiinsert);
			}
			
			$kodepelayananobat = $db->query("select NO_RESEP,KD_PELAYANAN_OBAT from pel_ord_obat where KD_PELAYANAN='".$pelayanan."'")->row();
			
			$db->where('KD_PELAYANAN',$pelayanan);
			$db->delete('pel_ord_obat');
			if($arrayobat){
			$db->where('REFF',$pelayanan);
			$db->delete('pel_kasir_detail');
			
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
						'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
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
					
					
				}
				
				$datainsertkasirdetailloop[] = array(
					'KD_PEL_KASIR'=> $kodepelkasir->KD_KASIR,
					'KD_TARIF' =>  'AM',
					'KD_PASIEN' => $pasien,
					'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
					'REFF' => $pelayanan,
					'KD_PRODUK' => "TRA",
					'KD_UNIT' => '6',
					'HARGA_PRODUK' => 0,
					'TGL_BERLAKU' => date('Y-m-d'),
					'QTY' => $qtyobattotal,
					'TOTAL_HARGA' => $hargaobattotal
				);
				
					$dataobatinsert = $dataobatloop;
					$datainsertkasirdetail1 = $datainsertkasirdetailloop;
					$irow++;
				
				$db->insert_batch('pel_ord_obat',$dataobatinsert);			 
				$db->insert_batch("pel_kasir_detail", $datainsertkasirdetail1);
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
		$db->select('a.*,b.ID_KUNJUNGAN,b.KD_PELAYANAN,e.KD_PASIEN,c.STATUS_HAMIL,d.LETAK_JANIN,b.KD_DOKTER_PEMERIKSA AS DOKTER,b.KD_DOKTER_PETUGAS AS PETUGAS');
		$db->from('kunjungan_bumil a');
		$db->join('trans_kia b','a.KD_KIA=b.KD_KIA');
		$db->join('pelayanan e','b.KD_PELAYANAN=e.KD_PELAYANAN');
		$db->join('mst_status_hamil c','c.KD_STATUS_HAMIL=a.KD_STATUS_HAMIL');
		$db->join('mst_letak_janin d','d.KD_LETAK_JANIN=a.KD_LETAK_JANIN');
		$db->where('a.KD_KUNJUNGAN_BUMIL',$id);
		//$db->where('b.KD_PELAYANAN', $id1);
		$val = $db->get()->row();
		$data['data']=$val;
		//print_r($data);die;
		$this->load->view('t_kunjungan_ibu_hamil/v_t_kunjungan_ibu_hamil_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);//print_r($id);die();
		if($db->query("delete from pemeriksaan_anak where KD_PEMERIKSAAN_ANAK = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("a.KD_KUNJUNGAN_BUMIL as kode,a.KD_KUNJUNGAN_BUMIL, a.KD_KIA, DATE_FORMAT(a.TANGGAL_KUNJUNGAN, '%d-%m-%Y') AS TANGGAL_KUNJUNGAN, 
					a.KUNJUNGAN_KE, a.KELUHAN, a.TEKANAN_DARAH, a.BERAT_BADAN, a.UMUR_KEHAMILAN, a.TINGGI_FUNDUS, l.LETAK_JANIN, a.DENYUT_JANTUNG, 
					a.KAKI_BENGKAK, a.LAB_DARAH_HB, a.LAB_URIN_REDUKSI, a.LAB_URIN_PROTEIN, a.PEMERIKSAAN_KHUSUS, j.JENIS_KASUS, h.STATUS_HAMIL, 
					a.NASEHAT, GROUP_CONCAT(DISTINCT CONCAT(z.PRODUK,'-Rp.',z.HARGA_PRODUK,'-Jlh:',t.QTY,'-Ket.',t.KETERANGAN) SEPARATOR ' | ') AS TINDAKAN, 
					GROUP_CONCAT(DISTINCT c.NAMA_OBAT SEPARATOR ' | ') AS ALERGI, GROUP_CONCAT(DISTINCT CONCAT(c.NAMA_OBAT,'-',b.HARGA_JUAL,'-Dosis:',p.DOSIS,'-Jlh:',p.QTY) SEPARATOR ' | ') AS OBAT, 
					CONCAT(d.NAMA, '--', d.JABATAN) AS DOKTER, e.NAMA AS PETUGAS, a.KD_KUNJUNGAN_BUMIL as id",false);
		$db->from('kunjungan_bumil a');
		$db->join('trans_kia k','a.KD_KIA=k.KD_KIA','left');
		$db->join('mst_letak_janin l','l.KD_LETAK_JANIN=a.KD_LETAK_JANIN','left');
		$db->join('pel_tindakan t','t.KD_TINDAKAN=a.KD_TINDAKAN','left');
		$db->join('mst_produk z','z.KD_PRODUK=t.KD_TINDAKAN','left');
		$db->join('mst_kasus_jenis j','j.KD_JENIS_KASUS=a.KD_JENIS_KASUS','left');
		//$db->join('mst_rs r','r.KD_RS=a.KD_RS','left');
		$db->join('mst_status_hamil h','h.KD_STATUS_HAMIL=a.KD_STATUS_HAMIL','left');
		$db->join('mst_dokter d','k.KD_DOKTER_PEMERIKSA=d.KD_DOKTER','left');
		$db->join('mst_dokter e','k.KD_DOKTER_PETUGAS=e.KD_DOKTER','left');
		$db->join('pel_ord_obat p','k.KD_PELAYANAN=p.KD_PELAYANAN','left');
		$db->join('pasien_alergi_obt v','v.KD_OBAT=p.KD_OBAT','left');
		$db->join('apt_mst_obat c','c.KD_OBAT=v.KD_OBAT','left');
		$db->join('apt_mst_harga_obat b','b.KD_OBAT=v.KD_OBAT','left');
		$db->group_by('a.KD_KUNJUNGAN_BUMIL','t.KD_TINDAKAN','v.KD_OBAT','p.KD_PELAYANAN');
		$db->where("a.KD_KUNJUNGAN_BUMIL ='$id'",null, false);
		$val = $db->get()->row();
		$data['data']=$val;//print_r($db->last_query());die;
		$this->load->view('t_kunjungan_bumil/v_t_kunjungan_ibu_hamil_detail',$data);
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
	
	/*public function t_pemeriksaan_kesehatan_anak_penyakitxml()
	{
		$this->load->model('t_pemeriksaan_kesehatan_anak_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid')
					);
					
		$total = $this->t_pemeriksaan_kesehatan_anak_model->totalt_pemeriksaan_kesehatan_anak_penyakit($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid')
					);
					
		$result = $this->t_pemeriksaan_kesehatan_anak_model->gett_pemeriksaan_kesehatan_anak_penyakit($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function delete_penyakit()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);//print_r($id);die();
		if($db->query("delete from pem_kes_icd where KD_PENYAKIT = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}*/
	
	public function t_kunjungan_ibu_hamil_tindakanxml()
	{
		$this->load->model('t_kunjungan_ibu_hamil_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid2')
					);
					
		$total = $this->t_kunjungan_ibu_hamil_model->totalt_kunjungan_ibu_hamil_tindakan($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid2')
					);
					
		$result = $this->t_kunjungan_ibu_hamil_model->gett_kunjungan_ibu_hamil_tindakan($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function delete_tindakan()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);//print_r($id);die();
		if($db->query("delete from pem_kes_produk where KD_PRODUK = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
}

/* End of file t_kunjungan_ibu_hamil.php */
/* Location: ./application/controllers/t_kunjungan_ibu_hamil.php */