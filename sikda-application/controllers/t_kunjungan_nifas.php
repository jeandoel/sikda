<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_kunjungan_nifas extends CI_Controller {
	public function index()
	{
		$this->load->view('transaksiKunjungan_nifas/v_transaksi_kunjungan_nifas');
	}
	
	public function masterkunjungannifaspopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$data['get_kd_pasien'] = $this->input->post('get_kd_pasien')?$this->input->post('get_kd_pasien',TRUE):null;
		$this->load->view('t_pelayanan/kunjungan/v_transaksi_kunjungan_nifas_popup',$data);
	}
	
	public function kunjungannifasxml()
	{
		$this->load->model('m_tkunjungan_nifas');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'kode'=>$this->input->post('kode'),
					'get_kd_pasien'=>$this->input->post('get_kd_pasien')
					);
					
		$total = $this->m_tkunjungan_nifas->totalT_kunjungannifas($paramstotal);
		
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
					);
					
		$result = $this->m_tkunjungan_nifas->getT_kunjungannifas($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->helper('ernes_helper');
		$this->load->view('transaksiKunjungan_nifas/v_transaksi_kunjungan_nifas_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('tanggal_daftar', 'Tanggal', 'trim|myvalid_date');
		$val->set_rules('keluhan', 'Keluhan', 'trim|xss_clean');
		$val->set_rules('tekanan_darah', 'Tekanan Darah', 'trim|xss_clean');
		$val->set_rules('nadi', 'Nadi/menit', 'trim|xss_clean');
		$val->set_rules('nafas', 'Nafas/menit', 'trim|xss_clean');
		$val->set_rules('suhu', 'Suhu', 'trim|xss_clean');
		$val->set_rules('kontraksi', 'Kontraksi Rahim', 'trim|xss_clean');
		$val->set_rules('perdarahan', 'Perdarahan', 'trim|xss_clean');
		$val->set_rules('warna_lokhia', 'Warna Lokhia', 'trim|xss_clean');
		$val->set_rules('jumlah_lokhia', 'Jumlah Lokhia', 'trim|xss_clean');
		$val->set_rules('bau_lokhia', 'Bau Lokhia', 'trim|xss_clean');
		$val->set_rules('bab', 'Buang Air Besar', 'trim|xss_clean');
		$val->set_rules('bak', 'Buang Air Kecil', 'trim|xss_clean');
		$val->set_rules('produksi_asi', 'Produksi Asi', 'trim|xss_clean');
		$val->set_rules('kd_tindakan', 'Tindakan', 'trim|xss_clean');
		$val->set_rules('nasehat', 'Nasehat', 'trim|xss_clean');
		$val->set_rules('pemeriksa', 'Pemeriksa', 'trim|xss_clean');
		$val->set_rules('petugas', 'Petugas', 'trim|xss_clean');
		$val->set_rules('stat_hamil', 'Status Hamil', 'trim|xss_clean');
		if($this->input->post('stat_hamil')){
			if($this->input->post('stat_hamil')=='akhir_nifas'){
				$val->set_rules('stat_hamil', 'Status Hamil', 'trim|xss_clean');
				$val->set_rules('kead_ibu', 'Keadaan Ibu', 'trim|xss_clean');
				$val->set_rules('kead_bayi', 'Keadaan Bayi', 'trim|xss_clean');
				$val->set_rules('komp_nifas', 'Komplikasi Nifas', 'trim|xss_clean');
			}else{
				$val->set_rules('stat_hamil', 'Status Hamil', 'trim|xss_clean');
			}
		}
			$val->set_message('required', "Silahkan isi field \"%s\"");
			
		$arrayobat = $this->input->post('obat_final')?json_decode($this->input->post('obat_final',TRUE)):NULL; //print_r($arrayobat);die;
		$arrayalergi = $this->input->post('alergi_final')?json_decode($this->input->post('alergi_final',TRUE)):NULL;//print_r($arrayalergi);die;
		$arraytindakan = $this->input->post('tindakan_final')?json_decode($this->input->post('tindakan_final',TRUE)):NULL;//print_r($arraytindakan);die;
		$arraydiagnosa = $this->input->post('diagnosa_final')?json_decode($this->input->post('diagnosa_final',TRUE)):NULL;
		$datainsert = array();
		//$val->set_message('required', "Silahkan isi field \"%s\"");

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
                'URUT_MASUK' => $this->input->post('kd_urutmasuk_hidden',TRUE),
                'KD_KASIR' => $kodekasir,
                'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
                //'ANAMNESA' => $this->input->post('anamnesa',TRUE),
                //'KONDISI_PASIEN' => '-',
                //'CATATAN_FISIK' => $this->input->post('catatan_fisik',TRUE),
                'CARA_BAYAR' => $this->input->post('cara_bayar',TRUE),
                'JENIS_PASIEN' => $this->input->post('jenis_pasien',TRUE),
                'KD_USER' => $this->session->userdata('kd_petugas'),
                'UNIT_PELAYANAN' => 'RJ',
                'CATATAN_DOKTER' => $this->input->post('catatan_dokter',TRUE),
                'Created_Date' => date('Y-m-d'),
                'Created_By' => $this->session->userdata('kd_petugas'),
                'KD_DOKTER' => $this->input->post('pemeriksa')?$this->input->post('pemeriksa',TRUE):NULL,
                'KEADAAN_KELUAR' => $this->input->post('status_keluar',TRUE)
            );
			if(empty($arrayobat)){
				$datainsert['STATUS_LAYANAN'] = '1';
			}
			
			$data_pasien = array(
				'CARA_BAYAR' => $this->input->post('cara_bayar',TRUE),
                'KD_CUSTOMER' => $this->input->post('jenis_pasien',TRUE),
			);
			$db->where('KD_PASIEN', $this->input->post('kd_pasien_hidden'));
			$db->update('pasien',$data_pasien);
			
					//print_r($datainsert)	;die;
			$db->insert('pelayanan',$datainsert);
			
			$kdkunjungan=$this->input->post('kd_kunjungan_hidden',true);
			$db->set('KD_PELAYANAN',$kodepelayanan);
			$db->where('ID_KUNJUNGAN',$kdkunjungan);
			$db->update('kunjungan');
			
			// Update Trans KIA //
			$datakia = array(
				'KD_DOKTER_PEMERIKSA' => $this->input->post('pemeriksa')?$this->input->post('pemeriksa',TRUE):NULL,
				'KD_DOKTER_PETUGAS' => $this->input->post('petugas')?$this->input->post('petugas',TRUE):NULL,
				'KD_KUNJUNGAN_KIA' => $this->input->post('kia_ibu',TRUE),
				'KD_PELAYANAN'=> $datainsert['KD_PELAYANAN'],
				'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
				  'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
				'nupdate_oleh' => $this->session->userdata('user_name'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
				);
			$db->where('ID_KUNJUNGAN', $this->input->post('kd_kunjungan_hidden',TRUE));//print_r($datakia);die;
			$db->update('trans_kia', $datakia);
			
			$kodekia=$db->query("select KD_KIA from trans_kia where ID_KUNJUNGAN='".$this->input->post('kd_kunjungan_hidden',TRUE)."'")->row(); 	
			$dataexc = array(
				
				'KD_KIA' => $kodekia->KD_KIA,
				'TANGGAL_KUNJUNGAN' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tanggal_daftar',TRUE)))),
				'KELUHAN' => $val->set_value('keluhan'),
				'TEKANAN_DARAH' => $val->set_value('tekanan_darah'),
				'NADI' => $val->set_value('nadi'),
				'NAFAS' => $val->set_value('nafas'),
				'SUHU' => $val->set_value('suhu'),
				'KONTRAKSI_RAHIM' => $val->set_value('kontraksi'),
				'PERDARAHAN' => $val->set_value('perdarahan'),
				'WARNA_LOKHIA' => $val->set_value('warna_lokhia'),
				'JML_LOKHIA' => $val->set_value('jumlah_lokhia'),
				'BAU_LOKHIA' => $val->set_value('bau_lokhia'),
				'BUANG_AIR_BESAR' => $val->set_value('bab'),
				'BUANG_AIR_KECIL' => $val->set_value('bak'),
				'PRODUKSI_ASI' => $val->set_value('produksi_asi'),
				'NASEHAT' => $val->set_value('nasehat'),
				'KD_STATUS_HAMIL' => $val->set_value('stat_hamil'),
				'KD_KESEHATAN_IBU' => $val->set_value('kead_ibu'),
				'KD_KESEHATAN_BAYI' => $val->set_value('kead_bayi'),
				'KD_KOMPLIKASI_NIFAS' => $val->set_value('komp_nifas'),
				'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
				'ninput_tgl' => date('Y-m-d H:i:s'),
				'ninput_oleh' => $this->session->userdata('nusername')
			);///echo '<pre>';print_r($dataexc);die('zdfg');	
			
			$db->insert('kunjungan_nifas', $dataexc);
			$kodenifas=$db->insert_id();
			
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
			
			/// Insert Data Order Obat ///
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
						'HRG_JUAL' => $dataobattmp->hargaobt,
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
						'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
						'NO_RESEP' => $kodepelayananresep,
						'KD_OBAT' => $dataobattmp->kd_obat,
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
					$hargaobattotal = $hargaobattotal+($dataobattmp->hargaobt*$dataobattmp->jumlah);
					
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
						'QTY' => $datatindakantmp->total?$datatindakantmp->total:0,
						'HRG_TINDAKAN' => $datatindakantmp->harganifas?$datatindakantmp->harganifas:0,
						'KETERANGAN' => $datatindakantmp->keterangannifas,
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
						'HARGA_PRODUK' => $datatindakantmp->harganifas?$datatindakantmp->harganifas:0,
						'QTY' => $datatindakantmp->total,
						'TOTAL_HARGA' => $datatindakantmp->harganifas*$datatindakantmp->total,
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
	
	
	public function editprocess()
	{//print_r($_POST);die;
	
		$pasien=$this->input->post('kd_pasien_hidden')?$this->input->post('kd_pasien_hidden'):null;
		$puskesmas=$this->input->post('kd_puskesmas_hidden')?$this->input->post('kd_puskesmas_hidden'):$this->session->userdata('kd_pasien');
		$kunjungan=$this->input->post('kd_kunjungan_hidden')?$this->input->post('kd_kunjungan_hidden',true):null;//print_r($kunjungan);die;
		$pelayanan=$this->input->post('kd_pelayanan_hidden')?$this->input->post('kd_pelayanan_hidden'):null;
		$this->load->library('form_validation');
		$val = $this->form_validation;
		
		$val->set_rules('tanggal_daftar', 'Tanggal', 'trim|required|xss_clean');
		$val->set_rules('keluhan', 'Keluhan', 'trim|xss_clean');
		$val->set_rules('tekanan_darah', 'Tekanan Darah', 'trim|xss_clean');
		$val->set_rules('nadi', 'Nadi/menit', 'trim|xss_clean');
		$val->set_rules('nafas', 'Nafas/menit', 'trim|xss_clean');
		$val->set_rules('suhu', 'Suhu', 'trim|xss_clean');
		$val->set_rules('kontraksi', 'Kontraksi Rahim', 'trim|xss_clean');
		$val->set_rules('perdarahan', 'Perdarahan', 'trim|xss_clean');
		$val->set_rules('warna_lokhia', 'Warna Lokhia', 'trim|xss_clean');
		$val->set_rules('jumlah_lokhia', 'Jumlah Lokhia', 'trim|xss_clean');
		$val->set_rules('bau_lokhia', 'Bau Lokhia', 'trim|xss_clean');
		$val->set_rules('bab', 'Buang Air Besar', 'trim|xss_clean');
		$val->set_rules('bak', 'Buang Air Kecil', 'trim|xss_clean');
		$val->set_rules('produksi_asi', 'Produksi Asi', 'trim|xss_clean');
		$val->set_rules('kd_tindakan', 'Tindakan', 'trim|xss_clean');
		$val->set_rules('nasehat', 'Nasehat', 'trim|xss_clean');
		$val->set_rules('pemeriksa', 'Pemeriksa', 'trim|xss_clean');
		$val->set_rules('petugas', 'Petugas', 'trim|xss_clean');
		$val->set_rules('stat_hamil', 'Status Hamil', 'trim|xss_clean');
		
		$arrayobat = $this->input->post('obat_final')?json_decode($this->input->post('obat_final',TRUE)):NULL; //print_r($arrayobat);die;
		$arrayalergi = $this->input->post('alergi_final')?json_decode($this->input->post('alergi_final',TRUE)):NULL;//print_r($arrayalergi);die;
		$arraytindakan = $this->input->post('tindakan_final')?json_decode($this->input->post('tindakan_final',TRUE)):NULL;//print_r($arraytindakan);die;
		$arraydiagnosa = $this->input->post('diagnosa_final')?json_decode($this->input->post('diagnosa_final',TRUE)):NULL;
		//$datainsert = array();
		
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
				'KD_DOKTER_PEMERIKSA' => $this->input->post('pemeriksa')?$this->input->post('pemeriksa',TRUE):NULL,
				'KD_DOKTER_PETUGAS' => $this->input->post('petugas')?$this->input->post('petugas',TRUE):NULL,
				'nupdate_oleh' => $this->session->userdata('user_name'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
				);
				$db->where('ID_KUNJUNGAN', $kunjungan);//print_r($datakia);die;
				$db->update('trans_kia', $datakia);
				
			$kodekia = $db->query("select KD_KIA from trans_kia where ID_KUNJUNGAN='". $kunjungan."'")->row();//print_r($kunjungan);die;
			$kodepelkasir = $db->query("select KD_KASIR from pelayanan where KD_PELAYANAN='".$pelayanan."'")->row();//print_r($pelayanan);die;
			
			
			$dataexc = array(
				
				'KD_KIA' => $kodekia->KD_KIA,
				'TANGGAL_KUNJUNGAN' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tanggal_daftar',TRUE)))),
				'KELUHAN' => $val->set_value('keluhan'),
				'TEKANAN_DARAH' => $val->set_value('tekanan_darah'),
				'NADI' => $val->set_value('nadi'),
				'NAFAS' => $val->set_value('nafas'),
				'SUHU' => $val->set_value('suhu'),
				'KONTRAKSI_RAHIM' => $val->set_value('kontraksi'),
				'PERDARAHAN' => $val->set_value('perdarahan'),
				'WARNA_LOKHIA' => $val->set_value('warna_lokhia'),
				'JML_LOKHIA' => $val->set_value('jumlah_lokhia'),
				'BAU_LOKHIA' => $val->set_value('bau_lokhia'),
				'BUANG_AIR_BESAR' => $val->set_value('bab'),
				'BUANG_AIR_KECIL' => $val->set_value('bak'),
				'PRODUKSI_ASI' => $val->set_value('produksi_asi'),
				'NASEHAT' => $val->set_value('nasehat'),
				'KD_STATUS_HAMIL' => $val->set_value('stat_hamil'),
				'KD_KESEHATAN_IBU' => $val->set_value('kead_ibu'),
				'KD_KESEHATAN_BAYI' => $val->set_value('kead_bayi'),
				'KD_KOMPLIKASI_NIFAS' => $val->set_value('komp_nifas'),
				'nupdate_tgl' => date('Y-m-d H:i:s'),
				'nupdate_oleh' => $this->session->userdata('nusername')
			);///echo '<pre>';print_r($dataexc);die('zdfg');	
			
			$db->where('KD_KIA', $kodekia->KD_KIA);
			$db->update('kunjungan_nifas', $dataexc);
		
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
					$dataalergiinsert = $dataalergiloop; //print_r($dataalergiinsert);die;
				}
				$db->insert_batch('pasien_alergi_obt',$dataalergiinsert);
			}
	
		$kodepelayananobat = $db->query("select NO_RESEP,KD_PELAYANAN_OBAT from pel_ord_obat where KD_PELAYANAN='".$pelayanan."'")->row();
		
		
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
					'HRG_JUAL' => $dataobattmp->hargaobt,
					'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
					'NO_RESEP' => $kodepelayananobat?$kodepelayananobat->NO_RESEP:$kodepelayananresep1,
					'KD_OBAT' => $dataobattmp->kd_obat,
					'SAT_BESAR' => '',
					'SAT_KECIL' => '',
					'QTY' => $dataobattmp->jumlah,
					'DOSIS' => $dataobattmp->dosis,
					'JUMLAH' => $dataobattmp->jumlah,
					'KD_PETUGAS' => $this->session->userdata('user_name'),
					'STATUS' => 0,
					'iROW' => $irow,
					'TANGGAL' => date('Y-m-d'),
					'Modified_By' => $this->session->userdata('user_name'),
					'Modified_Date' => date('Y-m-d H:i:s')
				);
				
				$qtyobattotal = $qtyobattotal+$dataobattmp->jumlah;
				$hargaobattotal = $hargaobattotal+($dataobattmp->hargaobt*$dataobattmp->jumlah);
				
				
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
						'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
						'KD_TINDAKAN' => $datatindakantmp->kd_tindakan,
						'QTY' => $datatindakantmp->total?$datatindakantmp->total:0,
						'HRG_TINDAKAN' => $datatindakantmp->harganifas?$datatindakantmp->harganifas:0,
						'KETERANGAN' => $datatindakantmp->keterangannifas,
						'KD_PETUGAS' => $this->session->userdata('user_name'),
						'iROW' => $irow2,
						'TANGGAL' => date('Y-m-d'),
						'Created_By' => $this->session->userdata('user_name'),
						'Created_Date' => date('Y-m-d H:i:s')
					);					
					
					$datainsertkasirdetailloop[]=array(
						'KD_PEL_KASIR'=> $kodepelkasir->KD_KASIR,
						'KD_PASIEN' => $pasien,
						'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
						'KD_PRODUK' => $datatindakantmp->kd_tindakan,
						'REFF' => $pelayanan,
						'KD_UNIT' => '6',
						'KD_TARIF' => 'AM',
						'HARGA_PRODUK' => $datatindakantmp->harganifas?$datatindakantmp->harganifas:0,
						'QTY' => $datatindakantmp->total,
						'TOTAL_HARGA' => $datatindakantmp->harganifas*$datatindakantmp->total,
						'TGL_BERLAKU' => date('Y-m-d')						
					);
					
					$datatindakaninsert = $datatindakanloop;
					$datainsertkasirdetail = $datainsertkasirdetailloop;
					$irow2++;	
							
				}//print_r($datatindakaninsert);die;
				$db->insert_batch('pel_tindakan',$datatindakaninsert);
				$db->insert_batch('pel_kasir_detail',$datainsertkasirdetail);
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
		$db->select("u.*,k.ID_KUNJUNGAN,k.KD_PELAYANAN,t.KD_PASIEN,k.KD_DOKTER_PEMERIKSA  as PEMERIKSA,k.KD_DOKTER_PETUGAS  as PETUGAS,g.CATATAN_APOTEK,g.CATATAN_DOKTER", false);
				$db->from('kunjungan_nifas u');
				$db->join('trans_kia k', 'u.KD_KIA=k.KD_KIA');
				$db->join('pelayanan t', 'k.KD_PELAYANAN=t.KD_PELAYANAN');
				$db->join('check_coment g','k.KD_PELAYANAN=g.KD_PELAYANAN');
				$db->where('k.ID_KUNJUNGAN ',$id);
		$data['data']=$val;		
		$this->load->view('transaksiKunjungan_nifas/v_transaksi_kunjungan_nifas_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from kunjungan_nifas where KD_KUNJUNGAN_NIFAS = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("u.KD_KUNJUNGAN_NIFAS as kode,k.ID_KUNJUNGAN,DATE_FORMAT (u.TANGGAL_KUNJUNGAN, '%d-%M-%Y') as TANGGAL_KUNJUNGAN,u.KELUHAN,u.TEKANAN_DARAH, u.NADI, u.NAFAS, u.SUHU, u.KONTRAKSI_RAHIM, u.PERDARAHAN, u.WARNA_LOKHIA,u.JML_LOKHIA,u.BAU_LOKHIA,u.BUANG_AIR_BESAR, u.BUANG_AIR_KECIL, u.PRODUKSI_ASI, GROUP_CONCAT(DISTINCT t.TINDAKAN SEPARATOR ' | ') AS TINDAKAN, u.NASEHAT,concat (h.NAMA,'-',h.JABATAN) as pemeriksa,concat (i.NAMA,'-',i.JABATAN) as petugas, u.KD_STATUS_HAMIL,u.KD_KESEHATAN_IBU,u.KD_KESEHATAN_BAYI,u.KD_KOMPLIKASI_NIFAS ,u.KD_KUNJUNGAN_NIFAS as nid", false);
		$db->from('kunjungan_nifas u');
		$db->join('trans_kia k', 'u.KD_KIA=k.KD_KIA');
		$db->join('pel_tindakan x', 'x.KD_PELAYANAN=k.KD_PELAYANAN');
		$db->join('pelayanan t', 'u.KD_KUNJUNGAN_NIFAS=t.KD_KUNJUNGAN_NIFAS');
		$db->join('mst_keadaan_kesehatan q','u.KD_KESEHATAN_BAYI=q.KD_KEADAAN_KESEHATAN','left');
		$db->join('mst_dokter h', 'k.KD_DOKTER_PEMERIKSA=h.KD_DOKTER');
		$db->join('mst_dokter i', 'k.KD_DOKTER_PETUGAS=i.KD_DOKTER');
		$db->group_by('u.KD_KUNJUNGAN_NIFAS');
		$db->where('u.KD_KUNJUNGAN_NIFAS ',$id);
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('transaksiKunjungan_nifas/v_transaksi_kunjungan_detail',$data);
	}
	public function produksource()
	{
		$id=$this->input->get('term')?$this->input->get('term',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$comboproduk = $db->query("SELECT p.KD_PRODUK AS id,p.PRODUK AS label, 
							CASE WHEN g.KD_TINDAKAN IS NULL THEN '' ELSE g.KD_TINDAKAN END AS category
							FROM mst_produk p LEFT JOIN tindakan_nifas g on p.KD_GOL_PRODUK=g.KD_TINDAKAN where p.PRODUK like '%".$id."%' ")->result_array();
		die(json_encode($comboproduk));
	}
	
	public function kesimpulanakhirnifas()
	{
		$this->load->helper('beries_helper');
		$this->load->helper('ernes_helper');
		$this->load->view('t_pelayanan/kunjungan/v_kesimpulan_akhir_nifas');
	}
	
	public function t_alerginifasxml()
	{
		$this->load->model('m_tkunjungan_nifas');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid4'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$total = $this->m_tkunjungan_nifas->totalT_kunjungannifas($paramstotal);
		
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
					
		$result = $this->m_tkunjungan_nifas->getT_alergi_nifas($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function t_obatnifasxml()
	{
		$this->load->model('m_tkunjungan_nifas');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid3'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$total = $this->m_tkunjungan_nifas->totalT_kunjungannifas($paramstotal);
		
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
					
		$result = $this->m_tkunjungan_nifas->getT_obat_nifas($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	
	public function t_tindakannifasxml()
	{
		$this->load->model('m_tkunjungan_nifas');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid2'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$total = $this->m_tkunjungan_nifas->totalT_kunjungannifas($paramstotal);
		
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
					
		$result = $this->m_tkunjungan_nifas->getT_tindakan_nnifas($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
}

/* End of file transaksi1.php */
/* Location: ./application/controllers/transaksi1.php */