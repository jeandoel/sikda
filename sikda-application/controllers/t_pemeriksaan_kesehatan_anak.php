<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_pemeriksaan_kesehatan_anak extends CI_Controller {
	public function index()
	{
		$this->load->helper('pemkes_helper');
		$this->load->helper('beries_helper');
		$this->load->view('t_pemeriksaan_kesehatan_anak/v_t_pemeriksaan_kesehatan_anak');
	}
	
	public function pemeriksaan_kesehatan_anak_popup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$data['get_kd_pasien'] = $this->input->post('kd_pasien')?$this->input->post('kd_pasien',TRUE):null;
		$this->load->view('t_pelayanan/kunjungan/v_t_pemeriksaan_kesehatan_anak_popup',$data);
	}
	
	public function t_pemeriksaan_kesehatan_anakxml()
	{
		$this->load->model('t_pemeriksaan_kesehatan_anak_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'get_kd_pasien'=>$this->input->post('get_kd_pasien')
					);
					
		$total = $this->t_pemeriksaan_kesehatan_anak_model->totalt_pemeriksaan_kesehatan_anak($paramstotal);
		
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
					
		$result = $this->t_pemeriksaan_kesehatan_anak_model->gett_pemeriksaan_kesehatan_anak($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->helpers('pemkes_helper');
		$this->load->helpers('beries_helper');
		
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
		$id3=$this->input->get('id3')?$this->input->get('id3',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("NAMA_LENGKAP AS NAMA_PASIEN,p.KD_PASIEN,p.KD_PUSKESMAS,p.TGL_LAHIR,p.NO_PENGENAL AS NIK,p.KET_WIL,p.KD_GOL_DARAH,p.KD_CUSTOMER,p.CARA_BAYAR,k.CUSTOMER,mu.UNIT,kj.ID_KUNJUNGAN,kj.KD_UNIT,kj.URUT_MASUK,kj.KD_LAYANAN_B",FALSE);
		$db->from('pasien p');
		$db->join('mst_kel_pasien k','k.KD_CUSTOMER=p.KD_CUSTOMER');
		$db->join('kunjungan kj','kj.KD_PASIEN=p.KD_PASIEN');
		$db->join('mst_unit mu','mu.KD_UNIT=kj.KD_UNIT');
		$db->where('p.KD_PASIEN',$id);
		$db->where('kj.ID_KUNJUNGAN',$id3);
		$db->where('p.KD_PUSKESMAS',$id2);
		$val = $db->get()->row();//print_r($data);die;
		$tindakanlist = $db->query("SELECT p.KD_PRODUK AS id,CONCAT(p.PRODUK,' => Harga:',p.HARGA_PRODUK) AS label, 
							CASE WHEN g.GOL_PRODUK IS NULL THEN '' ELSE g.GOL_PRODUK END AS category
							FROM mst_produk p LEFT JOIN mst_gol_produk g on p.KD_GOL_PRODUK=g.KD_GOL_PRODUK")->result_array();
		
		$data['dataproduktindakan']=json_encode($tindakanlist);
		$data['data']=$val;
		
		$this->load->view('t_pemeriksaan_kesehatan_anak/v_t_pemeriksaan_kesehatan_anak_add',$data);
	}
	
	public function addprocess()
	{//print_r($_POST);die;
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('tgl_periksa', 'Tanggal Pemeriksaan', 'trim|required|xss_clean|myvalid_date');
		//$val->set_rules('kd_penyakit', 'Penyakit', 'trim|required|xss_clean');
		//$val->set_rules('kd_tindakan', 'Tindakan', 'trim|required|xss_clean');
		$val->set_rules('kolom_nama_pemeriksa', 'Pemeriksa', 'trim|required|xss_clean');
		$val->set_rules('kolom_nama_petugas', 'Petugas', 'trim|required|xss_clean');
				
		$val->set_message('required', "Silahkan isi field \"%s\"");
		
		$arraydiagnosa = $this->input->post('diagnosa_final')?json_decode($this->input->post('diagnosa_final',TRUE)):NULL;
		$arrayobat = $this->input->post('obat_final')?json_decode($this->input->post('obat_final',TRUE)):NULL;
		$arrayalergi = $this->input->post('alergi_final')?json_decode($this->input->post('alergi_final',TRUE)):NULL;
		$arraytindakan = $this->input->post('tindakan_final')?json_decode($this->input->post('tindakan_final',TRUE)):NULL;
		
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
			
			//Data Insert Kasir//
			
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
                'TGL_PELAYANAN' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tgl_periksa')))),
                'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
                'KD_UNIT' => '219',
                'UNIT_PELAYANAN' => 'RJ',
                'URUT_MASUK' => $this->input->post('kd_urutmasuk_hidden',TRUE),
                'KD_KASIR' => $kodekasir,
                'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
                //'ANAMNESA' => $this->input->post('anamnesa',TRUE),
                //'KONDISI_PASIEN' => '-',
                //'CATATAN_FISIK' => $this->input->post('catatan_fisik',TRUE),
                'CARA_BAYAR' => $this->input->post('cara_bayar',TRUE),
                'JENIS_PASIEN' => $this->input->post('jenis_pasien',TRUE),
                'KD_USER' => $this->session->userdata('kd_petugas'),
                'CATATAN_DOKTER' => $this->input->post('catatan_dokter',TRUE),
                'Created_Date' => date('Y-m-d'),
                'Created_By' => $this->session->userdata('kd_petugas'),
                'KD_DOKTER' => $this->input->post('kolom_nama_pemeriksa')?$this->input->post('kolom_nama_pemeriksa',TRUE):NULL,
                'KEADAAN_KELUAR' => 'DILAYANI',
                'STATUS_LAYANAN' => '1',
                'UNIT_PELAYANAN' => 'RJ'
				
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
				'KD_DOKTER_PEMERIKSA' => $this->input->post('kolom_nama_pemeriksa')?$this->input->post('kolom_nama_pemeriksa',TRUE):NULL,
				'KD_DOKTER_PETUGAS' => $this->input->post('kolom_nama_petugas')?$this->input->post('kolom_nama_petugas',TRUE):NULL,
				'KD_KUNJUNGAN_KIA' => $this->input->post('kia_anak',TRUE),
				'KD_PELAYANAN'=> $datainsert['KD_PELAYANAN'],
				'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
				'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
				'nupdate_oleh' => $this->session->userdata('user_name'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
				);
				$db->where('ID_KUNJUNGAN', $this->input->post('kd_kunjungan_hidden',TRUE));//print_r($datakia);die;
				$db->update('trans_kia', $datakia);
			
			//Data Insert Pemeriksaan Anak//
			$kd_pasien = $this->session->userdata('kd_puskesmas').sprintf("%07d", $maxpelayanan);				
			$kodekia = $db->query("select KD_KIA from trans_kia where ID_KUNJUNGAN='". $this->input->post('kd_kunjungan_hidden')."'")->row();//print_r($kodekia);die;
			$dataexc = array(
				'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
				'KD_KIA' => $kodekia->KD_KIA,
				'TANGGAL_KUNJUNGAN' => date("Y-m-d"),
				//'KD_PENYAKIT' => $val->set_value('kd_penyakit'),
				//'KD_PRODUK' => $val->set_value('kd_tindakan'),
				'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);//print_r($dataexc);die;
			$db->insert('pemeriksaan_anak', $dataexc);
			
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
						'QTY' => $datatindakantmp->jumlah?$datatindakantmp->jumlah:0,
						'HRG_TINDAKAN' => $datatindakantmp->harga,
						'KETERANGAN' => $datatindakantmp->keterangan,
						'KD_PETUGAS' => $this->session->userdata('user_name'),
						'iROW' => $irow2,
						'TANGGAL' => date('Y-m-d'),
						'Created_By' => $this->session->userdata('user_name'),
						'Created_Date' => date('Y-m-d H:i:s')
					);					
					//$qtyobattotal = $qtyobattotal+$datatindakantmp->jumlah;
					//$hargaobattotal = $hargaobattotal+($datatindakantmp->harga*$datatindakantmp->jumlah);
					
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
			
			//Data Insert Diagnosa//
			
			if($arraydiagnosa){
				$irow3=1;
				foreach($arraydiagnosa as $rowdiagnosaloop){
					$datadiagnosatmp = json_decode($rowdiagnosaloop);
					$datadiagnosaloop[] = array(
						'KD_PELAYANAN' => $kodepelayanan,
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
						'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden')?$this->input->post('kd_puskesmas_hidden',TRUE):$this->session->userdata('kd_puskesmas'),
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
	{
		$pasien=$this->input->post('kd_pasien_hidden')?$this->input->post('kd_pasien_hidden'):null;
		$puskesmas=$this->input->post('kd_puskesmas_hidden')?$this->input->post('kd_puskesmas_hidden'):$this->session->userdata('kd_pasien');
		$kunjungan=$this->input->post('kd_kunjungan_hidden')?$this->input->post('kd_kunjungan_hidden',true):null;//print_r($kunjungan);die;
		$pelayanan=$this->input->post('kd_pelayanan_hidden')?$this->input->post('kd_pelayanan_hidden'):null;
		$this->load->library('form_validation');
		$val = $this->form_validation;
		
		
		$val->set_rules('tgl_periksa', 'Tanggal Pemeriksaan', 'trim|required|xss_clean');
		//$val->set_rules('kd_penyakit', 'Penyakit', 'trim|required|xss_clean');
		//$val->set_rules('kd_tindakan', 'Tindakan', 'trim|required|xss_clean');
		$val->set_rules('kolom_nama_pemeriksa', 'Pemeriksa', 'trim|required|xss_clean');
		$val->set_rules('kolom_nama_petugas', 'Petugas', 'trim|required|xss_clean');
		
		$arraydiagnosa = $this->input->post('diagnosa_final')?json_decode($this->input->post('diagnosa_final',TRUE)):NULL;
		$arrayobat = $this->input->post('obat_final')?json_decode($this->input->post('obat_final',TRUE)):NULL;
		$arrayalergi = $this->input->post('alergi_final')?json_decode($this->input->post('alergi_final',TRUE)):NULL;
		$arraytindakan = $this->input->post('tindakan_final')?json_decode($this->input->post('tindakan_final',TRUE)):NULL;
		
		if ($val->run() == FALSE)
		{
			$val->set_error_delimiters('<div style="color:white">', '</div>');
			die(validation_errors());
		}
		else
		{						
			$db = $this->load->database('sikda', TRUE);
			$db->trans_begin();
			
			
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
			$db->where('KD_PELAYANAN',$pelayanan);//print_r($datakia);die;
			$db->update('pelayanan',$datainsert);
			
			
			$check = array(
                'CATATAN_DOKTER' => $this->input->post('catatan_dokter')
            );
			$db->where('KD_PELAYANAN',$pelayanan);
			$db->update('check_coment',$check);
			
			// Update Trans KIA //
			$datakia = array(
				'KD_DOKTER_PEMERIKSA' => $this->input->post('kolom_nama_pemeriksa')?$this->input->post('kolom_nama_pemeriksa',TRUE):NULL,
				'KD_DOKTER_PETUGAS' => $this->input->post('kolom_nama_petugas')?$this->input->post('kolom_nama_petugas',TRUE):NULL,
				'nupdate_oleh' => $this->session->userdata('user_name'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
				);
				$db->where('ID_KUNJUNGAN', $this->input->post('kd_kunjungan_hidden',TRUE));//print_r($datakia);die;
				$db->update('trans_kia', $datakia);
			
			$kodekia = $db->query("select KD_KIA from trans_kia where ID_KUNJUNGAN='". $kunjungan."'")->row();//print_r($kunjungan);die;
			$kodepelkasir = $db->query("select KD_KASIR from pelayanan where KD_PELAYANAN='".$pelayanan."'")->row();//print_r($pelayanan);die;
			
			
			$dataexc = array(
				'KD_PASIEN' => $this->input->post('kd_pasien_hidden'),
				'KD_KIA' => $kodekia->KD_KIA,
				'TANGGAL_KUNJUNGAN' => date("Y-m-d"),
				//'KD_PENYAKIT' => $val->set_value('kd_penyakit'),
				//'KD_PRODUK' => $val->set_value('kd_tindakan'),
				'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
				'nupdate_oleh' => $this->session->userdata('user_name'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);//print_r($dataexc);die;
			$db->where('KD_KIA', $kodekia->KD_KIA);
			$db->update('pemeriksaan_anak', $dataexc);
			

			$kodepelayananobat = $db->query("select NO_RESEP,KD_PELAYANAN_OBAT from pel_ord_obat where KD_PELAYANAN='".$pelayanan."'")->row();
			
				$db->where('KD_PELAYANAN',$pelayanan);
				$db->delete('pel_ord_obat');
				$db->where('REFF',$pelayanan);
				$db->delete('pel_kasir_detail');
			if($arrayobat){
			//print_r($_POST);die;
				

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
						'HRG_JUAL' => $dataobattmp->harga,
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
					
				//print_r($dataobatinsert);die;
				$db->insert_batch('pel_ord_obat',$dataobatinsert);
				$db->insert_batch("pel_kasir_detail", $datainsertkasirdetail1);
			}
			
				$db->where('KD_PASIEN',$pasien);
				$db->delete('pasien_alergi_obt');
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
						'QTY' => $datatindakantmp->jumlah?$datatindakantmp->jumlah:0,
						'HRG_TINDAKAN' => $datatindakantmp->harga,
						'KETERANGAN' => $datatindakantmp->keterangan,
						'KD_PETUGAS' => $this->session->userdata('user_name'),
						'iROW' => $irow2,
						'TANGGAL' => date('Y-m-d'),
						'Created_By' => $this->session->userdata('user_name'),
						'Created_Date' => date('Y-m-d H:i:s')
					);					
					//$qtyobattotal = $qtyobattotal+$datatindakantmp->jumlah;
					//$hargaobattotal = $hargaobattotal+($datatindakantmp->harga*$datatindakantmp->jumlah);
					
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
			
				$db->where('KD_PELAYANAN',$pelayanan);
				$db->delete('pel_diagnosa');
			if($arraydiagnosa){
				
				
				$irow3=1;
				foreach($arraydiagnosa as $rowdiagnosaloop){
					$datadiagnosatmp = json_decode($rowdiagnosaloop);
					$datadiagnosaloop[] = array(
						'KD_PELAYANAN' => $pelayanan,
						'KD_PASIEN' => $pasien,
						'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden')?$this->input->post('kd_puskesmas_hidden',TRUE):$this->session->userdata('kd_puskesmas'),
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
		$this->load->helpers('pemkes_helper');
		$db = $this->load->database('sikda', TRUE);
		$db->select("a.KD_PEMERIKSAAN_ANAK as kode,a.KD_PEMERIKSAAN_ANAK,DATE_FORMAT(a.TANGGAL_KUNJUNGAN,'%d-%m-%Y') as TANGGAL_KUNJUNGAN,group_concat(distinct c.PENYAKIT separator ' | ') as PENYAKIT,group_concat(distinct o.PRODUK separator ' , ') as PRODUK,concat(d.NAMA,'--',d.JABATAN) as dokter, e.NAMA as KD_DOKTER_PETUGAS, a.KD_PEMERIKSAAN_ANAK as id",false);
		$db->from('pemeriksaan_anak a');
		$db->join('pem_kes_icd c','a.KD_PEMERIKSAAN_ANAK=c.KD_PEMERIKSAAN_ANAK');
		$db->join('pem_kes_produk o','a.KD_PEMERIKSAAN_ANAK=o.KD_PEMERIKSAAN_ANAK');
		$db->join('trans_kia k','a.KD_KIA=k.KD_KIA');
		$db->join('mst_dokter d','k.KD_DOKTER_PEMERIKSA=d.KD_DOKTER');
		$db->join('mst_dokter e','k.KD_DOKTER_PETUGAS=e.KD_DOKTER');
		$db->group_by('a.KD_PEMERIKSAAN_ANAK','c.KD_PENYAKIT','o.KD_PRODUK');
		$db->where("a.KD_PEMERIKSAAN_ANAK ='$id'",null, false);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('t_pemeriksaan_kesehatan_anak/v_t_pemeriksaan_kesehatan_anak_edit',$data);
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
		$db->select("a.KD_PEMERIKSAAN_ANAK as kode,a.KD_PUSKESMAS,a.KD_PEMERIKSAAN_ANAK,DATE_FORMAT(a.TANGGAL_KUNJUNGAN,'%d-%m-%Y') as TANGGAL_KUNJUNGAN,group_concat(distinct c.PENYAKIT separator ' | ') as PENYAKIT,group_concat(distinct o.PRODUK separator ' , ') as PRODUK,GROUP_CONCAT(DISTINCT m.NAMA_OBAT SEPARATOR ' | ') AS ALERGI,GROUP_CONCAT(DISTINCT s.NAMA_OBAT SEPARATOR ' | ') AS OBAT, concat(d.NAMA,'--',d.JABATAN) as dokter, e.NAMA as KD_DOKTER_PETUGAS, a.KD_PEMERIKSAAN_ANAK as id",false);
		$db->from('pemeriksaan_anak a');
		$db->join('pem_kes_icd c','a.KD_PEMERIKSAAN_ANAK=c.KD_PEMERIKSAAN_ANAK');
		$db->join('pem_kes_produk o','a.KD_PEMERIKSAAN_ANAK=o.KD_PEMERIKSAAN_ANAK');
		$db->join('trans_kia k','a.KD_KIA=k.KD_KIA');
		$db->join('mst_dokter d','k.KD_DOKTER_PEMERIKSA=d.KD_DOKTER');
		$db->join('mst_dokter e','k.KD_DOKTER_PETUGAS=e.KD_DOKTER');
		$db->join('pel_ord_obat p','k.KD_PELAYANAN=p.KD_PELAYANAN');
		$db->join('apt_mst_obat m','m.KD_OBAT=p.KD_OBAT');
		$db->join('apt_mst_obat s','s.KD_OBAT=p.KD_OBAT');
		$db->group_by('a.KD_PEMERIKSAAN_ANAK','c.KD_PENYAKIT','o.KD_PRODUK','m.KD_OBAT','s.KD_OBAT');
		$db->where("a.KD_PEMERIKSAAN_ANAK ='$id'",null, false);
		$val = $db->get()->row();
		$data['data']=$val;//print_r($data);die;
		$this->load->view('t_pemeriksaan_kesehatan_anak/v_t_pemeriksaan_kesehatan_anak_detail',$data);
	}
	
	public function icdsource()
	{
		$id=$this->input->get('term')?$this->input->get('term',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$comboicd = $db->query("SELECT icd.KD_PENYAKIT AS id,icd.PENYAKIT AS label,
								CASE WHEN induk.ICD_INDUK IS NULL THEN '' ELSE induk.ICD_INDUK END  AS category FROM mst_icd icd LEFT JOIN 
								mst_icd_induk induk ON induk.KD_ICD_INDUK = icd.KD_ICD_INDUK where icd.PENYAKIT like '%".$id."%' ")->result_array();
		die(json_encode($comboicd));//print_r($id);die();
	}
	
	public function produksource()
	{
		$id=$this->input->get('term')?$this->input->get('term',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$comboproduk = $db->query("SELECT p.KD_PRODUK AS id,CONCAT(p.PRODUK,' => Harga:',p.HARGA_PRODUK) AS label, 
							CASE WHEN g.GOL_PRODUK IS NULL THEN '' ELSE g.GOL_PRODUK END AS category
							FROM mst_produk p LEFT JOIN mst_gol_produk g on p.KD_GOL_PRODUK=g.KD_GOL_PRODUK where p.PRODUK like '%".$id."%' ")->result_array();
		die(json_encode($comboproduk));
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
	
	public function t_alergixml()
	{
		$this->load->model('t_pemeriksaan_kesehatan_anak_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid4')
					);
					
		$total = $this->t_pemeriksaan_kesehatan_anak_model->totalT_alergi_anak($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'id'=>$this->input->post('myid4')
					);
					
		$result = $this->t_pemeriksaan_kesehatan_anak_model->getT_alergi_anak($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function t_obatxml()
	{
		$this->load->model('t_pemeriksaan_kesehatan_anak_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid3')
					);
					
		$total = $this->t_pemeriksaan_kesehatan_anak_model->totalT_obat_anak($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'id'=>$this->input->post('myid3')
					);
					
		$result = $this->t_pemeriksaan_kesehatan_anak_model->getT_obat_anak($params);		
		
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
	}
	
	public function t_tindakanxml()
	{
		$this->load->model('t_pemeriksaan_kesehatan_anak_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid2')
					);
					
		$total = $this->t_pemeriksaan_kesehatan_anak_model->totalT_tindakan_anak($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'id'=>$this->input->post('myid2')
					);
					
		$result = $this->t_pemeriksaan_kesehatan_anak_model->getT_tindakan_anak($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function t_penyakitxml()
	{
		$this->load->model('t_pemeriksaan_kesehatan_anak_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid')
					);
					
		$total = $this->t_pemeriksaan_kesehatan_anak_model->totalT_penyakit_anak($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'id'=>$this->input->post('myid')
					);
					
		$result = $this->t_pemeriksaan_kesehatan_anak_model->getT_penyakit_anak($params);		
		
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

/* End of file t_pemeriksaan_kesehatan_anak.php */
/* Location: ./application/controllers/t_pemeriksaan_kesehatan_anak.php */