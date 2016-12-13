<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_pelayanan_kb extends CI_Controller {
	public function index()
	{
		$this->load->helper('master_helper');
		$this->load->view('t_pelayanan_kb/v_pelayanan_kb');
	}

	public function tpelayanankbpopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$data['get_kd_pasien'] = $this->input->post('get_kd_pasien')?$this->input->post('get_kd_pasien',TRUE):null;
		$this->load->view('t_pelayanan/kunjungan/v_pelayanan_kb_popup',$data);
	}
	
	public function t_pelayanan_kbxml()
	{
		$this->load->model('t_pelayanan_kb_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari'),
					'get_kd_pasien'=>$this->input->post('get_kd_pasien')
					);
					
		$total = $this->t_pelayanan_kb_model->totalTpelayanankb($paramstotal);
		
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
					'cari'=>$this->input->post('cari'),
					'get_kd_pasien'=>$this->input->post('get_kd_pasien')
					);
					
		$result = $this->t_pelayanan_kb_model->getTpelayanankb($params);
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->helper('master_helper');
		$db = $this->load->database('sikda', TRUE);
		$tindakanlist = $db->query("SELECT p.KD_PRODUK AS id,CONCAT(p.PRODUK,' => Harga:',p.HARGA_PRODUK) AS label, 
								CASE WHEN g.GOL_PRODUK IS NULL THEN '' ELSE g.GOL_PRODUK END AS category
								FROM mst_produk p LEFT JOIN mst_gol_produk g on p.KD_GOL_PRODUK=g.KD_GOL_PRODUK")->result_array();
			
		$data['dataproduktindakan']=json_encode($tindakanlist);
		$this->load->view('t_pelayanan_kb/v_pelayanan_kb_add',$data);
	
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kdjeniskb', 'Kode Jenis KB', 'trim|xss_clean');
		$val->set_rules('tanggalpemeriksaan', 'Tanggal Pemeriksaan', 'trim|required|xss_clean');
		$val->set_rules('keluhan', 'Keluhan', 'trim|required|xss_clean');
		$val->set_rules('anamnese', 'Anamnese', 'trim|required|xss_clean');
		$val->set_rules('pemeriksa', 'Pemeriksa', 'trim|required|xss_clean');
		$val->set_rules('petugas', 'Petugas', 'trim|required|xss_clean');
		
		$arrayobat = $this->input->post('obatkb_final')?json_decode($this->input->post('obatkb_final',TRUE)):NULL;
		$arrayalergi = $this->input->post('alergikb_final')?json_decode($this->input->post('alergikb_final',TRUE)):NULL;
		$arraytindakan = $this->input->post('tindakankb_final')?json_decode($this->input->post('tindakankb_final',TRUE)):NULL;
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
			
			
			$maxkasir = 0;
			$maxkasir = $db->query("SELECT MAX(SUBSTR(KD_PEL_KASIR,-7)) AS total FROM pel_kasir where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
			$maxkasir = $maxkasir->total + 1;
			$kodekasir = 'KASIR'.sprintf("%07d", $maxkasir);
			
			/// Data Insert Table Kasir ///
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
			);	//print_r($datainsertkasir); die;
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
                'TGL_PELAYANAN' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggalpemeriksaan')))),
                'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
                'KD_UNIT' => '219',
                'UNIT_PELAYANAN' => 'RJ',
                'URUT_MASUK' => $this->input->post('kd_urutmasuk_hidden',TRUE),
                'KD_KASIR' => $kodekasir,
                'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
				'ANAMNESA' => $this->input->post('anamnesa',TRUE),
				'KONDISI_PASIEN' => '-',
		        'CARA_BAYAR' => $this->input->post('cara_bayar',TRUE),
                'JENIS_PASIEN' => $this->input->post('jenis_pasien',TRUE),
                'CATATAN_FISIK' => $this->input->post('catatan_fisik',TRUE),
                'KD_USER' => $this->session->userdata('kd_petugas'),
				'CATATAN_DOKTER' => $this->input->post('catatan_dokter',TRUE),
                'Created_Date' => date('Y-m-d'),
                'Created_By' => $this->session->userdata('kd_petugas'),
                'KD_DOKTER' => $this->input->post('pemeriksa')?$this->input->post('pemeriksa',TRUE):NULL,
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
				'KD_DOKTER_PEMERIKSA' => $this->input->post('pemeriksa')?$this->input->post('pemeriksa',TRUE):NULL,
				'KD_DOKTER_PETUGAS' => $this->input->post('petugas')?$this->input->post('petugas',TRUE):NULL,
				'KD_KUNJUNGAN_KIA' => $this->input->post('kia_ibu',TRUE),
				'KD_PELAYANAN'=> $datainsert['KD_PELAYANAN'],
				'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
				'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
				'nupdate_oleh' => $this->session->userdata('user_name'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
				);
				$db->where('ID_KUNJUNGAN', $this->input->post('kd_kunjungan_hidden',TRUE));//print_r($datakia);die;
				$db->update('trans_kia', $datakia);
				
			$kodekia = $db->query("select KD_KIA from trans_kia where ID_KUNJUNGAN='". $this->input->post('kd_kunjungan_hidden')."'")->row();//print_r($kodekia);die;
			$dataexc = array(
				'KD_JENIS_KB' => $this->input->post('kdjeniskb')?$this->input->post('kdjeniskb',TRUE):'',
				'KD_KIA' => $kodekia->KD_KIA,
				'TANGGAL' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tanggalpemeriksaan')))),
				'KELUHAN' => $val->set_value('keluhan'),
				'ANAMNESE' => $val->set_value('anamnese'),
				'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
				//'KD_PRODUK' => $this->input->post('kdproduk')?$this->input->post('kdproduk',TRUE):'',
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
				
			);
			//print_r($dataexc);die;
			$db->insert('kunjungan_kb', $dataexc);
			
			
			$kodekunjungankb=$db->insert_id();
			
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
			
			if($arraytindakan){
				$irow2=1;
				foreach($arraytindakan as $rowtindakanloop){
					$datatindakantmp = json_decode($rowtindakanloop);
					$datatindakanloop[] = array(
						'KD_KUNJUNGAN_KB' => $kodekunjungankb,
						'KD_PELAYANAN' => $kodepelayanan,
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
						'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
						'KD_TINDAKAN' => $datatindakantmp->kd_tindakan,
						'TINDAKAN' => $datatindakantmp->tindakan,
						'QTY' => $datatindakantmp->jumlah?$datatindakantmp->jumlah:0,
						'HRG_TINDAKAN' => $datatindakantmp->harga?$datatindakantmp->harga:0,
						'KETERANGAN' => $datatindakantmp->keterangan,
						'KD_PETUGAS' => $this->session->userdata('user_name'),
						'iROW' => $irow2,
						'ninput_oleh' => $this->session->userdata('user_name'),
						'ninput_tgl' => date('Y-m-d H:i:s')
					);					
					
					$datainsertkasirdetailloop[]=array(
						'KD_PEL_KASIR'=> $kodekasir,
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
						'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
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
				$db->insert_batch('detail_tindakan_kb',$datatindakaninsert);
				$db->insert_batch('pel_kasir_detail',$datainsertkasirdetail);
			}
			
			
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
				}
				$db->insert_batch('pasien_alergi_obt',$dataalergiinsert);
			}
			
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

		$val->set_rules('kdjeniskb', 'Kode Jenis KB', 'trim|xss_clean');
		$val->set_rules('tanggal_daftar', 'Tanggal Pemeriksaan', 'trim|required|xss_clean');
		$val->set_rules('keluhan', 'Keluhan', 'trim|required|xss_clean');
		$val->set_rules('anamnese', 'Anamnese', 'trim|required|xss_clean');
		$val->set_rules('pemeriksa', 'Pemeriksa', 'trim|required|xss_clean');
		$val->set_rules('petugas', 'Petugas', 'trim|required|xss_clean');
		
		$arrayobat = $this->input->post('obatkb_final')?json_decode($this->input->post('obatkb_final',TRUE)):NULL;
		$arrayalergi = $this->input->post('alergikb_final')?json_decode($this->input->post('alergikb_final',TRUE)):NULL;
		$arraytindakan = $this->input->post('tindakankb_final')?json_decode($this->input->post('tindakankb_final',TRUE)):NULL;
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
				'KD_JENIS_KB' => $this->input->post('kdjeniskb')?$this->input->post('kdjeniskb',TRUE):'',
				'KELUHAN' => $val->set_value('keluhan'),
				//'TANGGAL' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tanggalpemeriksaan')))),
				'ANAMNESE' => $val->set_value('anamnese'),
				'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);
			//print_r($dataexc);die;
			$db->where('KD_KIA', $kodekia->KD_KIA);
			$db->update('kunjungan_kb', $dataexc);	
		
		
				$db->where('KD_PELAYANAN',$pelayanan);
				$db->delete('detail_tindakan_kb');
				$db->where('REFF',$pelayanan);
				$db->delete('pel_kasir_detail');
			if($arraytindakan){
				
				$irow2=1;
				foreach($arraytindakan as $rowtindakanloop){
					$datatindakantmp = json_decode($rowtindakanloop);
					$datatindakanloop[] = array(
						//'KD_KUNJUNGAN_KB' => $kodekunjungankb,
						'KD_PELAYANAN' => $pelayanan,
						'KD_PASIEN' => $pasien,
						'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
						'KD_TINDAKAN' => $datatindakantmp->kd_tindakan,
						'TINDAKAN' => $datatindakantmp->tindakan,
						'QTY' => $datatindakantmp->jumlah?$datatindakantmp->jumlah:0,
						'HRG_TINDAKAN' => $datatindakantmp->harga?$datatindakantmp->harga:0,
						'KETERANGAN' => $datatindakantmp->keterangan,
						'KD_PETUGAS' => $this->session->userdata('user_name'),
						'iROW' => $irow2
					);					
					
					$datainsertkasirdetailloop[]=array(
						'KD_PEL_KASIR'=> $kodepelkasir->KD_KASIR,
						'KD_PASIEN' => $pasien,
						'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
						'KD_PRODUK' => $datatindakantmp->kd_tindakan,
						'REFF' => $pelayanan,
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
				$db->insert_batch('detail_tindakan_kb',$datatindakaninsert);
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
				}
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
			
			
			
			/*if($arraytindakan){
				foreach($arraytindakan as $rowtindakanloop){
					$datatindakantmp = json_decode($rowtindakanloop);
					$datatindakanloop = array(
						'KD_PRODUK' => $datatindakantmp->kdproduk,
						'PRODUK' => $datatindakantmp->produk,
						'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
						//'PRODUK' => $datatindakantmp->produk,
						//'TANGGAL' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tanggalpemeriksaan')))),
						'nupdate_oleh' => $this->session->userdata('nusername'),
						'nupdate_tgl' => date('Y-m-d H:i:s')
					);
					//print_r($datatindakanloop);die;
					$db->update('detail_tindakan_kb',$datatindakanloop);
				
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
		$db->select("a.*, b.ID_KUNJUNGAN, b.KD_PELAYANAN, c.KD_PASIEN, (select NAMA from mst_dokter d join trans_kia e on d.KD_DOKTER=e.KD_DOKTER_PEMERIKSA where e.ID_KUNJUNGAN='".$id."') as PEMERIKSA, (select NAMA from mst_dokter d join trans_kia e on d.KD_DOKTER=e.KD_DOKTER_PETUGAS where e.ID_KUNJUNGAN='".$id."') as PETUGAS, f.JENIS_KB", false);
				$db->from('kunjungan_kb a');
				$db->join('trans_kia b','a.KD_KIA=b.KD_KIA');
				$db->join('pelayanan c','b.KD_PELAYANAN=c.KD_PELAYANAN');
				$db->join('mst_jenis_kb f','a.KD_JENIS_KB=f.KD_JENIS_KB');
				$db->join('check_coment g','a.KD_PELAYANAN=g.KD_PELAYANAN');
				$db->where('u.KD_KUNJUNGAN_KB ',$id);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('t_pelayanan_kb/v_t_pelayanan_kb_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from kunjungan_kb where KD_KUNJUNGAN_KB = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("u.KD_KUNJUNGAN_KB as kode,DATE_FORMAT(u.TANGGAL, '%d-%M-%Y') as TANGGAL,u.KD_KUNJUNGAN_KB,u.KD_PUSKESMAS,m.JENIS_KB,concat (h.NAMA,'-',h.JABATAN) as pemeriksa,concat (i.NAMA,'-',i.JABATAN) as petugas,u.KELUHAN,u.ANAMNESE, GROUP_CONCAT(DISTINCT s.TINDAKAN SEPARATOR ' | ') AS PRODUK,group_concat(distinct concat(z.NAMA_OBAT,'-',ah.HARGA_JUAL,'-DOSIS:',o.DOSIS,'-JLH:',o.QTY) separator ' | ') as OBAT,group_concat(distinct z.NAMA_OBAT separator ' | ') as ALERGI_OBAT,u.KD_KUNJUNGAN_KB as id", false );
		//$this->db->select("GROUP_CONCAT(DISTINCT s.KD_TINDAKAN SEPARATOR ' | ')");
		$db->from('kunjungan_kb u','left');
		$db->join('detail_tindakan_kb s','u.KD_KUNJUNGAN_KB=s.KD_KUNJUNGAN_KB','left');
		$db->join('trans_kia g','u.KD_KIA=g.KD_KIA','left');
		$db->join('mst_jenis_kb m','m.KD_JENIS_KB=u.KD_JENIS_KB','left');
		$db->join('mst_dokter h','h.KD_DOKTER=g.KD_DOKTER_PEMERIKSA','left');
		$db->join('mst_dokter i','i.KD_DOKTER=g.KD_DOKTER_PETUGAS','left');
		$db->join('pel_ord_obat o','g.KD_PELAYANAN=o.KD_PELAYANAN','left');
		$db->join('apt_mst_obat z','o.KD_OBAT=z.KD_OBAT','left');
		$db->join('pasien_alergi_obt pa','z.KD_OBAT=pa.KD_OBAT','left');
		$db->join('apt_mst_harga_obat ah','z.KD_OBAT=ah.KD_OBAT','left');
		$db->group_by('u.KD_KUNJUNGAN_KB','z.KD_OBAT');
		$db->where('u.KD_KUNJUNGAN_KB ',$id);
		$val = $db->get()->row();
		$data['data']=$val;//print_r($db->last_query());die;
		$this->load->view('t_pelayanan_kb/v_pelayanan_kb_detail',$data);
	}
	
	public function t_pelayanan_tindakankbxml()
	{
		$this->load->model('t_pelayanan_kb_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari'),
					'id'=>$this->input->post('myid2'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$total = $this->t_pelayanan_kb_model->totalt_tindakan_pelayanan_kb($paramstotal);
		
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
					'cari'=>$this->input->post('cari'),
					'id'=>$this->input->post('myid2'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$result = $this->t_pelayanan_kb_model->gett_tindakan_pelayanan_kb($params);
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function t_pelayanan_alergiobatkbxml()
	{
		$this->load->model('t_pelayanan_kb_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari'),
					'id'=>$this->input->post('myid3'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$total = $this->t_pelayanan_kb_model->totalt_alergiobat_pelayanan_kb($paramstotal);
		
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
					'cari'=>$this->input->post('cari'),
					'id'=>$this->input->post('myid3'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$result = $this->t_pelayanan_kb_model->gett_alergiobat_pelayanan_kb($params);
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	
	public function t_pelayanan_obatkbxml()
	{
		$this->load->model('t_pelayanan_kb_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari'),
					'id'=>$this->input->post('myid4'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$total = $this->t_pelayanan_kb_model->totalt_obat_pelayanan_kb($paramstotal);
		
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
					'cari'=>$this->input->post('cari'),
					'id'=>$this->input->post('myid4'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$result = $this->t_pelayanan_kb_model->gett_obat_pelayanan_kb($params);
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function tindakansource()
	{
		$id=$this->input->get('term')?$this->input->get('term',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$combotindakan = $db->query("SELECT KD_PRODUK AS id,PRODUK AS label, '' as category
								FROM mst_produk
								 where PRODUK like '%".$id."%' ")->result_array();
		die(json_encode($combotindakan));
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
	
	
	public function hapus()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from detail_tindakan_kb where KD_DETAIL_TINDAKAN = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
}

/* End of file masteruser.php */
/* Location: ./application/controllers/masteruser.php */