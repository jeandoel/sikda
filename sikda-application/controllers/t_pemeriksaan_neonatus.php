<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_pemeriksaan_neonatus extends CI_Controller {
	public function index()
	{
		$this->load->view('t_pemeriksaanneonatus/v_t_pemeriksaan_neonatus');
	}
	
	public function pemeriksaanneonatuspopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$data['get_kd_pasien'] = $this->input->post('kd_pasien')?$this->input->post('kd_pasien',TRUE):null;
		$this->load->view('t_pelayanan/kunjungan/v_t_pelayanan_neonatus_popup',$data);
	}

		public function transaksi_pemeriksaanneonatusxml()
	{
		$this->load->model('t_pemeriksaan_neonatus_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari'),
					'get_kd_pasien'=>$this->input->post('get_kd_pasien')
					);
					
		$total = $this->t_pemeriksaan_neonatus_model->totaltransaksi_pemeriksaanneonatus($paramstotal);
		
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
					
		$result = $this->t_pemeriksaan_neonatus_model->getTransaksi_pemeriksaanneonatus($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}

	public function add()
	{
		$this->load->helper('jokos_helper');
		$this->load->helpers('beries_helper');
		$this->load->helpers('master1_helper');
		$db=$this->load->database('sikda',true);
		$tindakanlist = $db->query("SELECT p.KD_PRODUK AS id,CONCAT(p.PRODUK,' => Harga:',p.HARGA_PRODUK) AS label, 
							CASE WHEN g.GOL_PRODUK IS NULL THEN '' ELSE g.GOL_PRODUK END AS category
							FROM mst_produk p LEFT JOIN mst_gol_produk g on p.KD_GOL_PRODUK=g.KD_GOL_PRODUK")->result_array();
		$data['dataproduktindakan']=json_encode($tindakanlist);
		$this->load->view('t_pemeriksaanneonatus/v_t_pemeriksaan_neonatus_add',$data);
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');
		$val = $this->form_validation;
		$val->set_rules('kodepemeriksaanneonatus');
		$val->set_rules('tglkunjungan', 'Tanggal', 'trim|required|xss_clean');
		$val->set_rules('kunjunganke', 'Kunjungan ke', 'trim|required|xss_clean');
		$val->set_rules('beratbadan', 'Berat Badan', 'trim|required|xss_clean');
		$val->set_rules('panjangbadan', 'Panjang Badan', 'trim|required|xss_clean');
		//$val->set_rules('tindakananak', 'Tindakan Anak', 'trim|required|xss_clean');
		$val->set_rules('keluhan', 'Keluhan', 'trim|required|xss_clean');
		//$val->set_rules('tindakanibu', 'Tindakan Ibu', 'trim|required|xss_clean');
		$val->set_rules('nama_pemeriksa', 'Pemeriksa', 'trim|required|xss_clean');
		$val->set_rules('nama_petugas', 'Petugas', 'trim|required|xss_clean');
		$val->set_message('required', "Silahkan isi field \"%s\"");
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$arraytindakanibu = $this->input->post('produkibu_final')?json_decode($this->input->post('produkibu_final',TRUE)):NULL;//print_r($arraykeadaanbayi);die;
		$arraytindakananak = $this->input->post('produkanak_final')?json_decode($this->input->post('produkanak_final',TRUE)):NULL;
		$arrayobat = $this->input->post('obatneonatus_final')?json_decode($this->input->post('obatneonatus_final',TRUE)):NULL;
		$arrayalergi = $this->input->post('alergineonatus_final')?json_decode($this->input->post('alergineonatus_final',TRUE)):NULL;
		$arraydiagnosa = $this->input->post('diagnosa_final')?json_decode($this->input->post('diagnosa_final',TRUE)):NULL;
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		if ($val->run() == FALSE)
		{
			$val->set_error_delimiters('<div style="color:white">', '</div>');
			die(validation_errors());
		}
			else
		{						
			$db = $this->load->database('sikda', TRUE);
			$db->trans_begin();
			
			
			
			//Data Insert Kasir//
			$maxkasir = 0;
			$maxkasir = $db->query("SELECT MAX(SUBSTR(KD_PEL_KASIR,-7)) AS total FROM pel_kasir where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
			$maxkasir = $maxkasir->total + 1;
			$kodekasir = 'KASIR'.sprintf("%07d", $maxkasir);
			
			$datainsertkasir=array(
				'KD_PEL_KASIR'=> $kodekasir,
				'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden')?$this->input->post('kd_puskesmas_hidden',TRUE):$this->session->userdata('kd_puskesmas'),
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
			
			//Data Insert Pelayanan//
			$maxpelayanan = 0;
			$maxpelayanan = $db->query("SELECT MAX(SUBSTR(KD_PELAYANAN,-7)) AS total FROM pelayanan where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
			$maxpelayanan = $maxpelayanan->total + 1;
			$kodepelayanan = $this->input->post('kd_unit_hidden')?$this->input->post('kd_unit_hidden',TRUE).sprintf("%07d", $maxpelayanan):'219'.sprintf("%07d", $maxpelayanan);
			
			$datainsert = array(
				'KD_PELAYANAN' =>  $kodepelayanan,
                'TGL_PELAYANAN' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_daftar')))),
                'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
                'KD_UNIT' => 219,
                'URUT_MASUK' => $this->input->post('kd_urutmasuk_hidden',TRUE),
                'KD_KASIR' => $kodekasir,
                'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden')?$this->input->post('kd_puskesmas_hidden',TRUE):$this->session->userdata('kd_puskesmas'),
                'ANAMNESA' => $this->input->post('anamnesa',TRUE),
                'KONDISI_PASIEN' => '-',
                'CATATAN_FISIK' => $this->input->post('catatan_fisik',TRUE),
                'CARA_BAYAR' => $this->input->post('cara_bayar',TRUE),
                'JENIS_PASIEN' => $this->input->post('jenis_pasien',TRUE),
                'UNIT_PELAYANAN' => 'RJ',
                'KD_USER' => $this->session->userdata('kd_petugas'),
                'CATATAN_DOKTER' => $this->input->post('catatan_dokter',TRUE),
                'Created_Date' => date('Y-m-d'),
                'Created_By' => $this->session->userdata('kd_petugas'),
                'KD_DOKTER' => $this->input->post('nama_pemeriksa')?$this->input->post('nama_pemeriksa',TRUE):NULL,
                'KEADAAN_KELUAR' => $this->input->post('status_keluar',TRUE)			
            );
			if(empty($arrayobat)){
				$datainsert['STATUS_LAYANAN'] = '1';
			}
			
			$db->insert('pelayanan',$datainsert);
			
			$data_pasien = array(
				'CARA_BAYAR' => $this->input->post('cara_bayar',TRUE),
                'KD_CUSTOMER' => $this->input->post('jenis_pasien',TRUE),
				'ANAK_KE' => $this->input->post('anak_ke')?$this->input->post('anak_ke'):NULL,
                'PANJANG_BADAN' => $this->input->post('panjang_badan')?$this->input->post('panjang_badan'):NULL,
                'BERAT_LAHIR' => $this->input->post('berat_lahir')?$this->input->post('berat_lahir'):NULL,
                'LINGKAR_KEPALA' => $this->input->post('lingkar_kepala')?$this->input->post('lingkar_kepala'):NULL
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
				'KD_KUNJUNGAN_KIA' => $this->input->post('kia_anak',TRUE),
				'KD_PELAYANAN'=> $datainsert['KD_PELAYANAN'],
				'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
				'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden')?$this->input->post('kd_puskesmas_hidden',TRUE):$this->session->userdata('kd_puskesmas'),
				'nupdate_oleh' => $this->session->userdata('user_name'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
				);
				$db->where('ID_KUNJUNGAN', $this->input->post('kd_kunjungan_hidden',TRUE));//print_r($this->input->post('kd_kunjungan_hidden',TRUE));die;
				$db->update('trans_kia', $datakia);
			
			$kodekia = $db->query("select KD_KIA from trans_kia where ID_KUNJUNGAN='". $this->input->post('kd_kunjungan_hidden')."'")->row();
			
			$dataexc = array(
				'KD_PEMERIKSAAN_NEONATUS' => $val->set_value('kodepemeriksaanneonatus'),
				'KD_PASIEN' => $this->input->post('kd_pasien_hidden'),
				'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
				'TANGGAL_KUNJUNGAN' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tglkunjungan')))),
				'KUNJUNGAN_KE' => $val->set_value('kunjunganke'),
				'BERAT_BADAN' => $val->set_value('beratbadan'),
				'PANJANG_BADAN' => $val->set_value('panjangbadan'),
				'KELUHAN' => $val->set_value('keluhan'),
				'KD_KIA' => $kodekia->KD_KIA,
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			$db->insert('pemeriksaan_neonatus', $dataexc);
			
			$kd_pn=$db->insert_id();
			
			
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////			
			if($arraytindakanibu){
				$irow2=1;
				foreach($arraytindakanibu as $rowtindakanibuloop){
					$datatindakanibutmp = json_decode($rowtindakanibuloop);
					$datatindakanibuloop[] = array(
						'KD_PEMERIKSAAN_NEONATUS' => $kd_pn,
						'KD_PELAYANAN' => $kodepelayanan,
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
						'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
						'KD_TINDAKAN_IBU' => $datatindakanibutmp->kdprodukibu,
						'TINDAKAN_IBU' => $datatindakanibutmp->produkibu,
						'QTY' => $datatindakanibutmp->jumlahtindakanibu,
						'HRG_TINDAKAN' => $datatindakanibutmp->hargai?$datatindakanibutmp->hargai:0,
						'KD_PETUGAS' => $this->session->userdata('user_name'),
						'iROW' => $irow2,
						'ninput_oleh' => $this->session->userdata('user_name'),
						'ninput_tgl' => date('Y-m-d H:i:s')
					);					
					
					$datainsertibukasirdetailloop[]=array(
						'KD_PEL_KASIR'=> $kodekasir,
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
						'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
						'KD_PRODUK' => $datatindakanibutmp->kdprodukibu,
						'REFF' => $kodepelayanan,
						'KD_UNIT' => '6',
						'KD_TARIF' => 'AM',
						'HARGA_PRODUK' => $datatindakanibutmp->hargai?$datatindakanibutmp->hargai:0,
						'QTY' => $datatindakanibutmp->jumlahtindakanibu,
						'TOTAL_HARGA' => $datatindakanibutmp->hargai*$datatindakanibutmp->jumlahtindakanibu,
						'TGL_BERLAKU' => date('Y-m-d')						
					);
					
					$datatindakaninsert = $datatindakanibuloop;
					$datainsertkasirdetail = $datainsertibukasirdetailloop;
					$irow2++;					
				}
				$db->insert_batch('detail_tindakan_ibu_pem_neo',$datatindakaninsert);
				$db->insert_batch('pel_kasir_detail',$datainsertkasirdetail);
			}
			
			if($arraytindakananak){
				$irow3=1;
				foreach($arraytindakananak as $rowtindakananakloop){
					$datatindakananaktmp = json_decode($rowtindakananakloop);
					$datatindakananakloop[] = array(
					'KD_PEMERIKSAAN_NEONATUS' => $kd_pn,
					'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
					'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
					'KD_PELAYANAN' => $kodepelayanan,
					'KD_TINDAKAN_ANAK' => $datatindakananaktmp->kdprodukanak,
					'TINDAKAN_ANAK' => $datatindakananaktmp->produkanak,
					'KET_TINDAKAN_ANAK' => $datatindakananaktmp->keterangantindakananak,
					'QTY' => $datatindakananaktmp->jumlahtindakananak?$datatindakananaktmp->jumlahtindakananak:0,
					'HRG_TINDAKAN_ANAK' => $datatindakananaktmp->harga?$datatindakananaktmp->harga:0,
					'KD_PETUGAS' => $this->session->userdata('user_name'),
					'iROW' => $irow3,
					'ninput_oleh' => $this->session->userdata('user_name'),
					'ninput_tgl' => date('Y-m-d H:i:s')		
					);
					$datainsertkasirdetailloop[]=array(
						'KD_PEL_KASIR'=> $kodekasir,
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
						'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
						'KD_PRODUK' => $datatindakananaktmp->kdprodukanak,
						'REFF' => $kodepelayanan,
						'KD_UNIT' => '6',
						'KD_TARIF' => 'AM',
						'HARGA_PRODUK' => $datatindakananaktmp->harga,
						'QTY' => $datatindakananaktmp->jumlahtindakananak?$datatindakananaktmp->jumlahtindakananak:0,
						'TOTAL_HARGA' => $datatindakananaktmp->harga*$datatindakananaktmp->jumlahtindakananak,
						'TGL_BERLAKU' => date('Y-m-d')						
					);
					$datatindakananakinsert = $datatindakananakloop;
					$datainsertkasirdetail = $datainsertkasirdetailloop;
					
				}
				$db->insert_batch('detail_tindakan_anak_pem_neo',$datatindakananakinsert);
				$db->insert_batch('pel_kasir_detail',$datainsertkasirdetail);
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
			
			if($arrayalergi){
				foreach($arrayalergi as $rowalergiloop){
					$dataalergitmp = json_decode($rowalergiloop);
					$dataalergiloop[] = array(
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden')?$this->input->post('kd_pasien_hidden',TRUE):'',
						'KD_PUSKESMAS' =>$this->input->post('kd_puskesmas')? $this->input->post('kd_puskesmas',TRUE):$this->session->userdata('kd_puskesmas'),
						'KD_OBAT' => $dataalergitmp->kd_obatalergineonatus,
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
						'KD_OBAT' => $dataobattmp->kd_obatneonatus,
						'HRG_JUAL' => $dataobattmp->hargaobatneonatus,
						'SAT_BESAR' => '',
						'SAT_KECIL' => '',
						'QTY' => $dataobattmp->jumlahobatneonatus,
						'DOSIS' => $dataobattmp->dosis,
						'JUMLAH' => $dataobattmp->jumlahobatneonatus,
						'KD_PETUGAS' => $this->session->userdata('user_name'),
						'STATUS' => 0,
						'iROW' => $irow,
						'TANGGAL' => date('Y-m-d'),
						'Created_By' => $this->session->userdata('user_name'),
						'Created_Date' => date('Y-m-d H:i:s')
					);
					
					$qtyobattotal = $qtyobattotal+$dataobattmp->jumlahobatneonatus;
					$hargaobattotal = $hargaobattotal+($dataobattmp->hargaobatneonatus*$dataobattmp->jumlahobatneonatus);
					
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
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
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
	{
		
		$pasien=$this->input->post('kd_pasien_hidden')?$this->input->post('kd_pasien_hidden'):null;
		$puskesmas=$this->input->post('kd_puskesmas_hidden')?$this->input->post('kd_puskesmas_hidden'):$this->session->userdata('kd_pasien');
		$kunjungan=$this->input->post('kd_kunjungan_hidden')?$this->input->post('kd_kunjungan_hidden',true):null;//print_r($kunjungan);die;
		$pelayanan=$this->input->post('kd_pelayanan_hidden')?$this->input->post('kd_pelayanan_hidden'):null;
		$kdneo=$this->input->post('id')?$this->input->post('id'):NULL;//print_r($kdneo);die;
		$this->load->library('form_validation');
		$val = $this->form_validation;
		
		$val->set_rules('kodepemeriksaanneonatus');
		$val->set_rules('tglkunjungan', 'Tanggal', 'trim|required|xss_clean');
		$val->set_rules('kunjunganke', 'Kunjungan ke', 'trim|required|xss_clean');
		$val->set_rules('beratbadan', 'Berat Badan', 'trim|required|xss_clean');
		$val->set_rules('panjangbadan', 'Panjang Badan', 'trim|required|xss_clean');
		//$val->set_rules('tindakananak', 'Tindakan Anak', 'trim|required|xss_clean');
		$val->set_rules('keluhan', 'Keluhan', 'trim|required|xss_clean');
		//$val->set_rules('tindakanibu', 'Tindakan Ibu', 'trim|required|xss_clean');
		$val->set_rules('nama_pemeriksa', 'Pemeriksa', 'trim|required|xss_clean');
		$val->set_rules('nama_petugas', 'Petugas', 'trim|required|xss_clean');
		$val->set_message('required', "Silahkan isi field \"%s\"");
		
		$arraytindakanibu = $this->input->post('produkibu_final')?json_decode($this->input->post('produkibu_final',TRUE)):NULL;//print_r($arraykeadaanbayi);die;
		$arraytindakananak = $this->input->post('produkanak_final')?json_decode($this->input->post('produkanak_final',TRUE)):NULL;
		$arrayobat = $this->input->post('obatneonatus_final')?json_decode($this->input->post('obatneonatus_final',TRUE)):NULL;
		$arrayalergi = $this->input->post('alergineonatus_final')?json_decode($this->input->post('alergineonatus_final',TRUE)):NULL;
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
			
			/*$maxkasir = 0;
			$maxkasir = $db->query("SELECT MAX(SUBSTR(KD_PEL_KASIR,-7)) AS total FROM pel_kasir where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
			$maxkasir = $maxkasir->total + 1;
			$kodekasir = 'KASIR'.sprintf("%07d", $maxkasir);*/
			
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
			$kodepelkasir = $db->query("select KD_KASIR from pelayanan where KD_PELAYANAN='".$pelayanan."'")->row();//print_r($pelayanan);die;
			
			$dataexc = array(
				'KD_PEMERIKSAAN_NEONATUS' => $this->input->post('id'),
				'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
				'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
				'TANGGAL_KUNJUNGAN' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tglkunjungan')))),
				'KUNJUNGAN_KE' => $val->set_value('kunjunganke'),
				'BERAT_BADAN' => $val->set_value('beratbadan'),
				'PANJANG_BADAN' => $val->set_value('panjangbadan'),
				'KELUHAN' => $val->set_value('keluhan'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);
			$db->where('KD_KIA', $kodekia->KD_KIA);//print_r($dataexc);die;
			$db->update('pemeriksaan_neonatus', $dataexc);

				$db->where('KD_PELAYANAN',$pelayanan);
				$db->delete('detail_tindakan_ibu_pem_neo');
				$db->where('REFF',$pelayanan);
				$db->delete('pel_kasir_detail');
			if($arraytindakanibu){
				
				$irow2=1;
				foreach($arraytindakanibu as $rowtindakanibuloop){
					$datatindakanibutmp = json_decode($rowtindakanibuloop);
					$datatindakanibuloop[] = array(
						'KD_PEMERIKSAAN_NEONATUS' => $kdneo,
						'KD_PELAYANAN' => $pelayanan,
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
						'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
						'KD_TINDAKAN_IBU' => $datatindakanibutmp->kdprodukibu,
						'TINDAKAN_IBU' => $datatindakanibutmp->produkibu,
						'QTY' => $datatindakanibutmp->jumlahtindakanibu,
						'HRG_TINDAKAN' => $datatindakanibutmp->harga?$datatindakanibutmp->harga:0,
						'KD_PETUGAS' => $this->session->userdata('user_name'),
						'iROW' => $irow2,
						'ninput_oleh' => $this->session->userdata('user_name'),
						'ninput_tgl' => date('Y-m-d H:i:s')
					);					
					
					$datainsertkasirdetailloop[]=array(
						'KD_PEL_KASIR'=> $kodepelkasir->KD_KASIR,
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
						'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
						'KD_PRODUK' => $datatindakanibutmp->kdprodukibu,
						'REFF' => $pelayanan,
						'KD_UNIT' => '6',
						'KD_TARIF' => 'AM',
						'HARGA_PRODUK' => $datatindakanibutmp->harga?$datatindakanibutmp->harga:0,
						'QTY' => $datatindakanibutmp->jumlahtindakanibu,
						'TOTAL_HARGA' => $datatindakanibutmp->harga*$datatindakanibutmp->jumlahtindakanibu,
						'TGL_BERLAKU' => date('Y-m-d')						
					);
					
					$datatindakaninsert = $datatindakanibuloop;
					$datainsertkasiribudetail = $datainsertkasirdetailloop;
					$irow2++;					
				}//print_r($datainsertkasirdetail);die;
				$db->insert_batch('detail_tindakan_ibu_pem_neo',$datatindakaninsert);
				$db->insert_batch('pel_kasir_detail',$datainsertkasiribudetail);
			}
			
				$db->where('KD_PELAYANAN',$pelayanan);
				$db->delete('detail_tindakan_anak_pem_neo');
			if($arraytindakananak){
				$db->where('REFF',$pelayanan);
				$db->delete('pel_kasir_detail');
				$irow3=1;
				foreach($arraytindakananak as $rowtindakananakloop){
					$datatindakananaktmp = json_decode($rowtindakananakloop);
					$datatindakananakloop[] = array(
					'KD_PEMERIKSAAN_NEONATUS' => $kdneo,
					'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
					'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
					'KD_PELAYANAN' => $pelayanan,
					'KD_TINDAKAN_ANAK' => $datatindakananaktmp->kdprodukanak,
					'TINDAKAN_ANAK' => $datatindakananaktmp->produkanak,
					'KET_TINDAKAN_ANAK' => $datatindakananaktmp->keterangantindakananak,
					'QTY' => $datatindakananaktmp->jumlahtindakananak?$datatindakananaktmp->jumlahtindakananak:0,
					'HRG_TINDAKAN_ANAK' => $datatindakananaktmp->harga?$datatindakananaktmp->harga:0,
					'KD_PETUGAS' => $this->session->userdata('user_name'),
					'iROW' => $irow3,
					'ninput_oleh' => $this->session->userdata('user_name'),
					'ninput_tgl' => date('Y-m-d H:i:s')		
					);
					$datainsertkasirdetailloop[]=array(
						'KD_PEL_KASIR'=> $kodepelkasir->KD_KASIR,
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
						'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
						'KD_PRODUK' => $datatindakananaktmp->kdprodukanak,
						'REFF' => $pelayanan,
						'KD_UNIT' => '6',
						'KD_TARIF' => 'AM',
						'HARGA_PRODUK' => $datatindakananaktmp->harga,
						'QTY' => $datatindakananaktmp->jumlahtindakananak?$datatindakananaktmp->jumlahtindakananak:0,
						'TOTAL_HARGA' => $datatindakananaktmp->harga*$datatindakananaktmp->jumlahtindakananak,
						'TGL_BERLAKU' => date('Y-m-d')						
					);
					$datatindakananakinsert = $datatindakananakloop;
					$datainsertkasirdetail = $datainsertkasirdetailloop;
					
				}
				$db->insert_batch('detail_tindakan_anak_pem_neo',$datatindakananakinsert);
				$db->insert_batch('pel_kasir_detail',$datainsertkasirdetail);
			}
			
				$db->where('KD_PASIEN',$pasien);
				$db->delete('pasien_alergi_obt');
			if($arrayalergi){
				
				foreach($arrayalergi as $rowalergiloop){
					$dataalergitmp = json_decode($rowalergiloop);
					$dataalergiloop[] = array(
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden')?$this->input->post('kd_pasien_hidden',TRUE):NULL,
						'KD_PUSKESMAS' =>$this->input->post('kd_puskesmas')? $this->input->post('kd_puskesmas',TRUE):$this->session->userdata('kd_puskesmas'),
						'KD_OBAT' => $dataalergitmp->kd_obatalergineonatus,
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
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
						'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
						'NO_RESEP' => $kodepelayananobat?$kodepelayananobat->NO_RESEP:$kodepelayananresep1,
						'KD_OBAT' => $dataobattmp->kd_obatneonatus,
						'HRG_JUAL' => $dataobattmp->hargaobatneonatus,
						'SAT_BESAR' => '',
						'SAT_KECIL' => '',
						'QTY' => $dataobattmp->jumlahobatneonatus,
						'DOSIS' => $dataobattmp->dosis,
						'JUMLAH' => $dataobattmp->jumlahobatneonatus,
						'KD_PETUGAS' => $this->session->userdata('user_name'),
						'STATUS' => 0,
						'iROW' => $irow,
						'TANGGAL' => date('Y-m-d'),
						'Created_By' => $this->session->userdata('user_name'),
						'Created_Date' => date('Y-m-d H:i:s')
					);
					
					$qtyobattotal = $qtyobattotal+$dataobattmp->jumlahobatneonatus;
					$hargaobattotal = $hargaobattotal+($dataobattmp->hargaobatneonatus*$dataobattmp->jumlahobatneonatus);
					
					$dataobatinsert = $dataobatloop;
					$irow++;
				}
				
				$datainsertkasirdetailloop[] = array(
					'KD_PEL_KASIR'=> $kodepelkasir->KD_KASIR,
					'KD_TARIF' =>  'AM',
					'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
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
		$db->delete('pel_diagnosa');
		if($arraydiagnosa){
			$irow3=1;
			foreach($arraydiagnosa as $rowdiagnosaloop){
				$datadiagnosatmp = json_decode($rowdiagnosaloop);
				$datadiagnosaloop[] = array(
					'KD_PELAYANAN' => $pelayanan,
					'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
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
		$this->load->helper('jokos_helper');
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("u.KD_PEMERIKSAAN_NEONATUS as id, u.KD_PEMERIKSAAN_NEONATUS, DATE_FORMAT(u.TANGGAL_KUNJUNGAN,'%d-%m-%Y') as TANGGAL_KUNJUNGAN, u.KUNJUNGAN_KE, u.BERAT_BADAN, u.PANJANG_BADAN, GROUP_CONCAT(DISTINCT a.TINDAKAN_ANAK SEPARATOR ' | '), GROUP_CONCAT(DISTINCT a.KET_TINDAKAN_ANAK SEPARATOR ' , '), GROUP_CONCAT(DISTINCT i.TINDAKAN_IBU SEPARATOR ' | '), u.KELUHAN, concat (d.NAMA,'::',d.JABATAN) as dokter_pemeriksa, concat(e.NAMA, '::',e.JABATAN) as dokter_petugas, u.KD_PEMERIKSAAN_NEONATUS as kode", false );
		$db->from('pemeriksaan_neonatus u');
		$db->join('trans_kia k', 'u.KD_KIA=k.KD_KIA');
		$db->join('mst_dokter d', 'd.KD_DOKTER=k.KD_DOKTER_PEMERIKSA');
		$db->join('mst_dokter e', 'e.KD_DOKTER=k.KD_DOKTER_PETUGAS');
		$db->join('detail_tindakan_anak_pem_neo a', 'a.KD_PEMERIKSAAN_NEONATUS=u.KD_PEMERIKSAAN_NEONATUS');
		$db->join('detail_tindakan_ibu_pem_neo i', 'i.KD_PEMERIKSAAN_NEONATUS=u.KD_PEMERIKSAAN_NEONATUS');
		$db->where('u.KD_PEMERIKSAAN_NEONATUS', $id);
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('t_pemeriksaanneonatus/v_t_pemeriksaan_neonatus_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('kodepemeriksaanneonatus')?$this->input->post('kodepemeriksaanneonatus',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from pemeriksaan_neonatus where KD_PEMERIKSAAN_NEONATUS = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function deletetindakananak()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from detail_tindakan_anak_pem_neo where KD_TINDAKAN_ANAK = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function deletetindakanibu()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from detail_tindakan_ibu_pem_neo where KD_TINDAKAN_IBU= '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
		
	public function detail()
	{
		$this->load->helper('jokos_helper');
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select('*');
		$db->from('vw_detail_pemeriksaan_neonatus');
		/*$db->select("u.KD_PEMERIKSAAN_NEONATUS as id, u.KD_PEMERIKSAAN_NEONATUS as KD_PEMERIKSAAN_NEONATUS, u.KD_PUSKESMAS as KD_PUSKESMAS, DATE_FORMAT(u.TANGGAL_KUNJUNGAN,'%d-%m-%Y') as TANGGAL_KUNJUNGAN, u.KUNJUNGAN_KE as KUNJUNGAN_KE, u.BERAT_BADAN as BERAT_BADAN, u.PANJANG_BADAN as PANJANG_BADAN, GROUP_CONCAT(DISTINCT a.TINDAKAN_ANAK SEPARATOR ' | ') as TINDAKAN_ANAK, GROUP_CONCAT(DISTINCT a.KET_TINDAKAN_ANAK SEPARATOR ' , ') as KET_TINDAKAN_ANAK, GROUP_CONCAT(DISTINCT i.TINDAKAN_IBU SEPARATOR ' | ') as TINDAKAN_IBU, u.KELUHAN as KELUHAN, concat (d.NAMA,'::',d.JABATAN) as dokter_pemeriksa, concat(e.NAMA, '::',e.JABATAN) as dokter_petugas, mo.NAMA_OBAT as nama_obat, u.KD_PEMERIKSAAN_NEONATUS as kode", false );
		$db->from('pemeriksaan_neonatus u');
		$db->join('trans_kia k', 'u.KD_KIA=k.KD_KIA');
		$db->join('pelayanan p', 'k.KD_PELAYANAN=p.KD_PELAYANAN');
		$db->join('pel_ord_obat po', 'p.KD_PELAYANAN=po.KD_PELAYANAN');
		$db->join('pasien_alergi_obt pa', 'po.KD_OBAT=pa.KD_OBAT');
		$db->join('apt_mst_obat mo', 'pa.KD_OBAT=mo.KD_OBAT');
		$db->join('mst_dokter d', 'd.KD_DOKTER=k.KD_DOKTER_PEMERIKSA');
		$db->join('mst_dokter e', 'e.KD_DOKTER=k.KD_DOKTER_PETUGAS');
		$db->join('detail_tindakan_anak_pem_neo a', 'a.KD_PEMERIKSAAN_NEONATUS=u.KD_PEMERIKSAAN_NEONATUS');
		$db->join('detail_tindakan_ibu_pem_neo i', 'i.KD_PEMERIKSAAN_NEONATUS=u.KD_PEMERIKSAAN_NEONATUS');
		$db->group_by ('u.KD_PEMERIKSAAN_NEONATUS','a.KD_TINDAKAN_ANAK','i.KD_TINDAKAN_IBU');
		$db->where('u.KD_PEMERIKSAAN_NEONATUS', $id);}*/
		$val = $db->get()->row();
		$data['data']=$val;//print_r($val);die;
		$this->load->view('t_pemeriksaanneonatus/v_t_pemeriksaan_neonatus_detail',$data);
	}
	
	public function produkibusource()
	{
		$id=$this->input->get('term')?$this->input->get('term',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$comboprodukibu = $db->query("SELECT KD_PRODUK AS id,PRODUK AS label, '' as category
								FROM mst_produk
								 where PRODUK like '%".$id."%' ")->result_array();
		die(json_encode($comboprodukibu));
	}
	
	public function produkanaksource()
	{
		$id=$this->input->get('term')?$this->input->get('term',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$comboprodukanak = $db->query("SELECT KD_PRODUK AS id,PRODUK AS label, '' as category
								FROM mst_produk
								 where PRODUK like '%".$id."%' ")->result_array();
		die(json_encode($comboprodukanak));
	}
	
	public function transaksi_tindakananakxml()
	{
		$this->load->model('t_pemeriksaan_neonatus_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid')
					);
					
		$total = $this->t_pemeriksaan_neonatus_model->totalTransaksi_tindakananak($paramstotal);
		
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
					
		$result = $this->t_pemeriksaan_neonatus_model->getTransaksi_tindakananak($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}

	public function t_tindakan_ibuxml()
	{
		$this->load->model('t_pemeriksaan_neonatus_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid2'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$total = $this->t_pemeriksaan_neonatus_model->totalTransaksi_tindakanibu($paramstotal);
		
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
					'id'=>$this->input->post('myid2'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$result = $this->t_pemeriksaan_neonatus_model->getTransaksi_tindakanibu($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function t_alergixml()
	{
		$this->load->model('t_pemeriksaan_neonatus_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid2'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		
		$total = $this->t_pemeriksaan_neonatus_model->totalTransaksi_alergiobat($paramstotal);
		
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
					'id'=>$this->input->post('myid4'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$result = $this->t_pemeriksaan_neonatus_model->getTransaksi_alergiobat($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function t_obatxml()
	{
		$this->load->model('t_pemeriksaan_neonatus_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid2'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$total = $this->t_pemeriksaan_neonatus_model->totalTransaksi_obat($paramstotal);
		
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
					'id'=>$this->input->post('myid3'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$result = $this->t_pemeriksaan_neonatus_model->getTransaksi_obat($params);		
		
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
	
	public function t_tindakan_anakxml()
	{
		$this->load->model('t_pemeriksaan_neonatus_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$total = $this->t_pemeriksaan_neonatus_model->totalT_tindakan_anak($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'id'=>$this->input->post('myid'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$result = $this->t_pemeriksaan_neonatus_model->getT_tindakan_anak($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	
}
