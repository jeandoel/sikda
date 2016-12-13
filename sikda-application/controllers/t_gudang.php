<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_gudang extends CI_Controller {
	public function index()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_gudang/v_gudang');
	}
	
	public function obatkeluar()
	{
		$this->load->helper('beries_helper');
		$this->load->helper('my_helper');
		
		/*$db = $this->load->database('sikda', TRUE);
		$dataall = $db->query("SELECT a.KD_PUSKESMAS,a.LEVEL,a.NAMA_PUSKESMAS,a.KD_SUB_LEVEL,a.NAMA_SUB_LEVEL,b.KABUPATEN FROM sys_setting_def a join mst_kabupaten b on a.KD_KABKOTA=b.KD_KABUPATEN WHERE a.kd_puskesmas='".$this->session->userdata("kd_puskesmas")."'")->row(); //print_r($db->last_query());die;
		$data['data'] = $dataall;*/

		//$data['desa'] = $db->query("select KD_KELURAHAN from mst_kelurahan where KELURAHAN like'".$dataall->NAMA_PUSKESMAS."' and KD_KECAMATAN='".$dataall->KD_KEC."'")->row();*/
		
		$this->load->view('t_gudang/v_t_gudang_kel'/*,$data*/);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function t_gudangxml()
	{		
		$this->load->model('t_gudang_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari')
					);
					
		$total = $this->t_gudang_model->totalT_gudang($paramstotal);
		
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
					
		$result = $this->t_gudang_model->getT_gudang($params);		
		//print_r($result);die;
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function t_gudangxmlapt()
	{		
		$this->load->model('t_gudang_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari')
					);
					
		$total = $this->t_gudang_model->totalT_gudangapt($paramstotal);
		
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
					
		$result = $this->t_gudang_model->getT_gudangapt($params);		
		//print_r($result);die;
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function t_subgridgudangxml()
	{		
		$this->load->model('t_gudang_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(				
					'kd_pkm'=>$this->input->post('kd_puskesmas'),
					'level'=>$this->input->post('level'),
					'kd_obat'=>$this->input->post('kd_obat')
					);
					
		$total = $this->t_gudang_model->totalsubgridGudang($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'kd_pkm'=>$this->input->post('kd_puskesmas'),
					'level'=>$this->input->post('level'),
					'kd_obat'=>$this->input->post('kd_obat')
					);
					
					
		$result = $this->t_gudang_model->getsubgridGudang($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	public function t_subgridgudangxmlapt()
	{		
		$this->load->model('t_gudang_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(				
					'kd_pkm'=>$this->input->post('kd_puskesmas'),
					'level'=>$this->input->post('level'),
					'kd_obat'=>$this->input->post('kd_obat')
					);
					
		$total = $this->t_gudang_model->totalsubgridGudang($paramstotal,true);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'kd_pkm'=>$this->input->post('kd_puskesmas'),
					'level'=>$this->input->post('level'),
					'kd_obat'=>$this->input->post('kd_obat')
					);
					
					
		$result = $this->t_gudang_model->getsubgridGudang($params,true);	
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->helper('my_helper');
		
		/*$db = $this->load->database('sikda', TRUE);
		
		$dataall = $db->query("SELECT a.KD_PUSKESMAS,a.LEVEL,a.NAMA_PUSKESMAS,a.KD_SUB_LEVEL,a.NAMA_SUB_LEVEL,b.KABUPATEN FROM sys_setting_def a join mst_kabupaten b on a.KD_KABKOTA=b.KD_KABUPATEN WHERE a.kd_puskesmas='".$this->session->userdata("kd_puskesmas")."'")->row(); //print_r($db->last_query());die;
		$data['data'] = $dataall;*/

		//$data['desa'] = $db->query("select KD_KELURAHAN from mst_kelurahan where KELURAHAN like'".$dataall->NAMA_PUSKESMAS."' and KD_KECAMATAN='".$dataall->KD_KEC."'")->row();*/
		
		$this->load->view('t_gudang/v_t_gudang_add'/*,$data*/);
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kd_terima', 'Kode Penerimaan', 'trim|required|xss_clean');		
		$val->set_rules('tanggal_terima', 'Tanggal', 'trim|required|myvalid_date');		
		$val->set_rules('no_faktur', 'Nomor Faktur', 'trim|required|xss_clean');
		$val->set_rules('from', 'Dikirim oleh', 'trim|required|xss_clean');
		//$val->set_rules('duedate', 'DueDate', 'trim|required|myvalid_date');
		$val->set_rules('pengirim', 'Nama Pengirim', 'trim|required|xss_clean');
		$val->set_rules('sumber_dana', 'Sumber Dana');
		$val->set_rules('level', 'Diterima oleh');
		//$val->set_rules('levelkab', 'Diterima oleh');
		$val->set_rules('catatan', 'Catatan');
		$val->set_rules('ppn', 'PPN');
		$val->set_rules('diskon', 'Diskon');
		
		$val->set_message('required', "Silahkan isi field \"%s\"");
		
		$arrayobat = $this->input->post('obat_final')?json_decode($this->input->post('obat_final',TRUE)):NULL;
		if(empty($arrayobat))die('Silahkan Tambahkan Obat');
		if ($val->run() == FALSE)
		{
			$val->set_error_delimiters('<div style="color:white">', '</div>');
			die(validation_errors());
		}
		else
		{						
			$db = $this->load->database('sikda', TRUE);
			$db->trans_begin();
			$totaljumlah=0;
			if($arrayobat){
					$irow=0;
					foreach($arrayobat as $rowobatloop){
					$dataobattmp = json_decode($rowobatloop);//print_r($dataobattmp);die;
					$totaljumlah = $totaljumlah + $dataobattmp->jumlah;
					$totalharga = $dataobattmp->harga;
					$totaldiskonharga = ($dataobattmp->diskon*$dataobattmp->harga);
					$totaldiskon = ($totaldiskonharga*100)/$totalharga;
					$kdunit = $this->input->post('level');
					$kdmilik = $this->session->userdata('level_aplikasi')=='PUSKESMAS'?'PKM':$this->input->post('level',true);
					$kdpmobat = $this->session->userdata('level_aplikasi')=='KABUPATEN'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas');
					//$lihat_stok = $db->query("select * from apt_stok_obat where KD_UNIT_APT='".$this->input->post('nama_unit')."' and KD_OBAT=".$dataobattmp[$irow]['kd_obat']." and KD_MILIK_OBAT='".$this->input->post('kd_milik_obat')."' ")->row();
					//die("select JUMLAH_STOK_OBAT from apt_stok_obat where KD_UNIT_APT='".$this->input->post('level')."' and KD_OBAT='$dataobattmp->kd_obat' and KD_MILIK_OBAT='PKM' and KD_PKM='".$this->session->userdata('kd_puskesmas')."' ");
					//$lihat_stok = $db->query("select JUMLAH_STOK_OBAT from apt_stok_obat where KD_UNIT_APT='".$this->input->post('level')."' and KD_OBAT='$dataobattmp->kd_obat' and KD_MILIK_OBAT='PKM' and KD_PKM='".$this->session->userdata('kd_puskesmas')."' ")->row();//print_r($lihat_stok);die;
					$lihat_stok = $db->query("select JUMLAH_STOK_OBAT from apt_stok_obat where KD_UNIT_APT='".$kdunit."' and KD_OBAT='$dataobattmp->kd_obat' and KD_MILIK_OBAT='".$kdmilik."' and KD_PKM='".$kdpmobat."' ")->row();//print_r($lihat_stok);die;
					if(isset($lihat_stok->JUMLAH_STOK_OBAT)){
						$datastokupdt = array(
							'JUMLAH_STOK_OBAT' => $dataobattmp->jumlah + $lihat_stok->JUMLAH_STOK_OBAT
						);
						//$db->where('KD_UNIT_APT',$this->input->post('level'));
						$db->where('KD_UNIT_APT',$kdunit);
						$db->where_in('KD_OBAT',$dataobattmp->kd_obat);
						$db->where('KD_MILIK_OBAT',$kdmilik);
						$db->where('KD_PKM',$kdpmobat);
						$db->update('apt_stok_obat', $datastokupdt);
					}else{
						$datastok[$irow] = array(
							'KD_PKM' => $kdpmobat,
							//'KD_UNIT_APT' => $val->set_value('level'),
							'KD_UNIT_APT' => $kdunit,
							'KD_OBAT' => $dataobattmp->kd_obat,
							'KD_MILIK_OBAT' => $kdmilik,
							'JUMLAH_STOK_OBAT' => $dataobattmp->jumlah,
							'Created_By' => $this->session->userdata('user_name'),
							'Created_Date' => date('Y-m-d')
						);
						$datastock = $datastok;					
					}
					
					if(!empty($datastock)){
						$db->insert_batch('apt_stok_obat', $datastock);
					}
					
					$dataobatloop[] = array(
							'KD_TERIMA' => $val->set_value('kd_terima'),
							'KD_MILIK_OBAT' => $kdmilik,//$val->set_value('kd_milik_obat'),
							'DISKON_SATUAN' => !empty($dataobattmp->diskon)?$dataobattmp->diskon:0,
							'PPN_SATUAN' => $dataobattmp->ppn,
							'KD_OBAT' => $dataobattmp->kd_obat,
							'NO_BATCH' => $dataobattmp->batch,
							'TGL_KADALUARSA' =>date("Y-m-d", strtotime(str_replace('/', '-',$dataobattmp->kadaluarsa))),
							'HARGA_BELI_OBAT' => $dataobattmp->harga,
							'JUMLAH_TERIMA' => $dataobattmp->jumlah,
							'to_xml' => 0,
							'iRow' => $irow,
							'Created_By' => $this->session->userdata('user_name'),
							'Created_Date' => date('Y-m-d H:i:s')
						);
					
					$dataobatinsert = $dataobatloop;
					$irow+1;
					
					}
					$db->insert_batch('apt_obat_terima_detail',$dataobatinsert);
			
				$dataexc = array(
					'KD_TERIMA' => $val->set_value('kd_terima'),
					'TGL_TERIMA' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_terima')))),
					'KD_PKM' => $kdpmobat,
					'KD_KABUPATEN'=> $this->session->userdata('kd_kabupaten'),
					'NO_FAKTUR_TERIMA' => $val->set_value('no_faktur'),
					//'DUE_DATE' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('duedate')))),
					'UNIT_APT_FROM' => $this->input->post('from'),
					'KD_VENDOR' => $val->set_value('from'),
					'UNIT_APT_TO' => $val->set_value('level'),
					'KD_MILIK_OBAT' => $kdmilik,
					'KETERANGAN' => $val->set_value('catatan'),
					'PPN' => null,
					'DISKON_TOTAL' => $totaldiskon,
					'JUMLAH_TOTAL' => $totaljumlah,
					'Created_By' => $this->session->userdata('user_name'),
					'Created_Date' => date('Y-m-d H:i:s')
				);
				
				$db->insert('apt_obat_terima', $dataexc);
				
				$dataobt = array(
					'KD_TRANSAKSI' => $val->set_value('kd_terima'),
					'TGL_TRANSAKSI' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_terima')))),
					'NO_FAKTUR' => $val->set_value('no_faktur'),
					'UNIT_APT_FROM' => $this->input->post('from'),
					'UNIT_APT_TO' => $val->set_value('level'),
					'KD_MILIK_OBAT' => $kdmilik,
					'JUMLAH_TOTAL' => $totaljumlah,
					'ninput_oleh' => $this->session->userdata('user_name'),
					'ninput_tgl' => date('Y-m-d H:i:s')
				);
				
				$db->insert('apt_trans_obat', $dataobt);
				
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
	
	public function keluarprocess()
	{//print_r($_POST);die;
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kd_keluar', 'Kode Pengeluaran', 'trim|required|xss_clean');		
		$val->set_rules('tanggal_keluar', 'Tanggal', 'trim|required|myvalid_date');		
		$val->set_rules('no_faktur', 'Nomor Faktur', 'trim|required|xss_clean');
		//$val->set_rules('duedate', 'DueDate', 'trim|required|myvalid_date');
		$val->set_rules('from', 'Diterima Dari', 'trim|required|xss_clean');
		$val->set_rules('level', 'Diterima oleh');
		//$val->set_rules('levelkab', 'Diterima oleh');
		$val->set_rules('catatan', 'Catatan');
		$val->set_rules('ppn', 'PPN');
		$val->set_rules('diskon', 'Diskon');
		
		$val->set_message('required', "Silahkan isi field \"%s\"");
		
		$arrayobat = $this->input->post('obat_final')?json_decode($this->input->post('obat_final',TRUE)):NULL;
		if(empty($arrayobat))die('Silahkan Tambahkan Obat');
		
		if ($val->run() == FALSE)
		{
			$val->set_error_delimiters('<div style="color:white">', '</div>');
			die(validation_errors());
		}
		else
		{						
			$db = $this->load->database('sikda', TRUE);
			$db->trans_begin();
			$totaljumlah = 0;
			$totaljumlah2=0;
			if(!empty($arrayobat)){
				$irow1=0;
					foreach($arrayobat as $rowobatloop){
					$dataobattmp = json_decode($rowobatloop);//print_r($dataobattmp);die;
					$totaljumlah = $totaljumlah + $dataobattmp->jumlah;
					$kdunit = $this->input->post('from');
					$kdmilik =  $this->session->userdata('level_aplikasi')=='PUSKESMAS'?'PKM':$this->session->userdata('level_aplikasi');
					$kdpmobat = $this->session->userdata('level_aplikasi')=='KABUPATEN'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas');
					//$lihat_stok = $db->query("select * from apt_stok_obat where KD_UNIT_APT='".$this->input->post('nama_unit')."' and KD_OBAT=".$dataobattmp[$irow1]['kd_obat']." and KD_MILIK_OBAT='".$this->input->post('kd_milik_obat')."' ")->row();
					$lihat_stok = $db->query("select * from apt_stok_obat where KD_UNIT_APT='".$kdunit."' and KD_OBAT='$dataobattmp->kd_obat' and KD_PKM='".$kdpmobat."' ")->row();
					// SET UNTUK LIVE $lihat_stok = $db->query("select * from apt_stok_obat where KD_UNIT_APT='".$this->input->post('from')."' and KD_OBAT='$dataobattmp->kd_obat' and KD_MILIK_OBAT='PKM' and KD_PKM='".$kdpmobat."' ")->row();
					//print_r($db->last_query());die;
					if(empty($lihat_stok))die('Silahkan Lakukan Proses Obat Masuk Sebelum Melakukan Proses Obat Keluar');
					$datastokupdt = array(
						'JUMLAH_STOK_OBAT' => $lihat_stok->JUMLAH_STOK_OBAT - $dataobattmp->jumlah
					);
					$db->where('KD_UNIT_APT',$kdunit);
					$db->where_in('KD_OBAT',$dataobattmp->kd_obat);
					$db->where('KD_MILIK_OBAT',$kdmilik);
					$db->where('KD_PKM',$kdpmobat);
					$db->update('apt_stok_obat', $datastokupdt);
					//print_r($db->last_query());die;
					$dataobatloop[] = array(
						'KD_KELUAR_OBAT' => $val->set_value('kd_keluar'),
						'KD_MILIK_OBAT' => $kdmilik,
						'KD_OBAT' => $dataobattmp->kd_obat,
						'NO_BATCH' => $dataobattmp->batch,
						'TGL_KADALUARSA' =>date("Y-m-d", strtotime(str_replace('/', '-',$dataobattmp->kadaluarsa))),
						'HARGA_BELI_OBAT' => $dataobattmp->harga,
						'JUMLAH_KELUAR' => $dataobattmp->jumlah,
						'to_xml' => 0,
						'iRow' => $irow1,
					);
					$dataobatinsert = $dataobatloop;
					
					$kd_terimarand = date('His').rand(1000,9999);
					if($this->session->userdata('level_aplikasi')=='PUSKESMAS' and $val->set_value('level')=='APT'){
						$totaljumlah2 = $totaljumlah2 + $dataobattmp->jumlah;
						$totalharga = $dataobattmp->harga;
						$totaldiskonharga = ($dataobattmp->diskon*$dataobattmp->harga);
						$totaldiskon = ($totaldiskonharga*100)/$totalharga;
						
						$lihat_stok2 = $db->query("select JUMLAH_STOK_OBAT from apt_stok_obat where KD_UNIT_APT='APT' and KD_OBAT='$dataobattmp->kd_obat' and KD_MILIK_OBAT='PKM' and KD_PKM='".$kdpmobat."' ")->row();//print_r($lihat_stok);die;
						if(isset($lihat_stok2->JUMLAH_STOK_OBAT)){
							$datastokupdt = array(
								'JUMLAH_STOK_OBAT' => $dataobattmp->jumlah + $lihat_stok2->JUMLAH_STOK_OBAT
							);
							//$db->where('KD_UNIT_APT',$this->input->post('level'));
							$db->where('KD_UNIT_APT','APT');
							$db->where_in('KD_OBAT',$dataobattmp->kd_obat);
							$db->where('KD_MILIK_OBAT','PKM');
							$db->where('KD_PKM',$kdpmobat);
							$db->update('apt_stok_obat', $datastokupdt);
						}else{
							$datastok[$irow1] = array(
								'KD_PKM' => $kdpmobat,
								//'KD_UNIT_APT' => $val->set_value('level'),
								'KD_UNIT_APT' => 'APT',
								'KD_OBAT' => $dataobattmp->kd_obat,
								'KD_MILIK_OBAT' => 'PKM',
								'JUMLAH_STOK_OBAT' => $dataobattmp->jumlah,
								'Created_By' => $this->session->userdata('user_name'),
								'Created_Date' => date('Y-m-d')
							);
							$datastock = $datastok;					
						}
						
						if(!empty($datastock)){
							$db->insert_batch('apt_stok_obat', $datastock);
						}
						$dataobatloopx[] = array(
							'KD_TERIMA' => $kd_terimarand,
							'KD_MILIK_OBAT' => $kdmilik,//$val->set_value('kd_milik_obat'),
							'DISKON_SATUAN' => !empty($dataobattmp->diskon)?$dataobattmp->diskon:0,
							'PPN_SATUAN' => $dataobattmp->ppn,
							'KD_OBAT' => $dataobattmp->kd_obat,
							'NO_BATCH' => $dataobattmp->batch,
							'TGL_KADALUARSA' =>date("Y-m-d", strtotime(str_replace('/', '-',$dataobattmp->kadaluarsa))),
							'HARGA_BELI_OBAT' => $dataobattmp->harga,
							'JUMLAH_TERIMA' => $dataobattmp->jumlah,
							'to_xml' => 0,
							'iRow' => $irow1,
							'Created_By' => $this->session->userdata('user_name'),
							'Created_Date' => date('Y-m-d H:i:s')
						);
					
						$dataobatinsertx = $dataobatloopx;
					}
					
					$irow1+1;
				}		
				
				$db->insert_batch('apt_obat_keluar_detail',$dataobatinsert);
				
				/**
				 * Comments bellow is part of rev01: 26-10-2014
				 * This comment is to prevent double transaction for 'keluar' and 'masuk'
				 * Previously: 'keluar' transaction from puskesmas to apotik will also means 'masuk' transaction to be inserted again
				 */
				// if(!empty($dataobatinsertx)){
				// $db->insert_batch('apt_obat_terima_detail',$dataobatinsertx);
				// }
				
				// if($this->session->userdata('level_aplikasi')=='PUSKESMAS' and $val->set_value('level')=='APT'){
				// 	$dataexcx = array(
				// 		'KD_TERIMA' => $kd_terimarand,
				// 		'TGL_TERIMA' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_keluar')))),
				// 		'KD_PKM' => $kdpmobat,
				// 		//'DUE_DATE' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('duedate')))),
				// 		'UNIT_APT_FROM' => $this->input->post('from'),
				// 		'NO_FAKTUR_TERIMA' => $val->set_value('no_faktur'),
				// 		'KD_VENDOR' => '',
				// 		'UNIT_APT_TO' => $val->set_value('level'),
				// 		'KD_MILIK_OBAT' => 'PKM',
				// 		'PPN' => null,
				// 		'DISKON_TOTAL' => $totaldiskon,
				// 		'JUMLAH_TOTAL' => $totaljumlah2,
				// 		'Created_By' => $this->session->userdata('user_name'),
				// 		'Created_Date' => date('Y-m-d H:i:s')
				// 	);
					
				// 	$db->insert('apt_obat_terima', $dataexcx);
					
				// 	$dataobt = array(
				// 		// 'KD_TRANSAKSI' => $val->set_value('kd_terima'),
				// 		'KD_TRANSAKSI' => $kd_terimarand, //added new rev01: 26-10-2014
				// 		'TGL_TRANSAKSI' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_keluar')))),
				// 		'NO_FAKTUR' => $val->set_value('no_faktur'),
				// 		'UNIT_APT_FROM' => $this->input->post('from'),
				// 		'UNIT_APT_TO' => $val->set_value('level'),
				// 		'KD_MILIK_OBAT' => $kdmilik,
				// 		'JUMLAH_TOTAL' => $totaljumlah,
				// 		'ninput_oleh' => $this->session->userdata('user_name'),
				// 		'ninput_tgl' => date('Y-m-d H:i:s')
				// 	);
					
				// $db->insert('apt_trans_obat', $dataobt);
				// }
				/**
				 * End of Comments
				 */
			
				$dataexc = array(
					'KD_KELUAR_OBAT' => $val->set_value('kd_keluar'),
					'TGL_OBAT_KELUAR' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_keluar')))),
					'KD_PKM' => $kdpmobat,
					'KD_KABUPATEN' => $this->session->userdata('kd_kabupaten'),
					'NO_FAKTUR_KELUAR' => $val->set_value('no_faktur'),
					//'DUE_DATE' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('duedate')))),
					'UNIT_APT_FROM' => $val->set_value('from'),
					'UNIT_APT_TO' => $val->set_value('level'),
					'KD_SUB_LEVEL' => $val->set_value('level')=='APT'?$this->input->post('sub_level2'):$this->input->post('sub_level'),
					'KETERANGAN' => $val->set_value('catatan'),
					'JUMLAH_TOTAL' => $totaljumlah,
					'Created_By' => $this->session->userdata('user_name'),
					'Created_Date' => date('Y-m-d H:i:s')
				);
				
				$db->insert('apt_obat_keluar', $dataexc);
				

				$dataobt = array(
					'KD_TRANSAKSI' => $val->set_value('kd_keluar'),
					'TGL_TRANSAKSI' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_keluar')))),
					'NO_FAKTUR' => $val->set_value('no_faktur'),
					'UNIT_APT_FROM' => $this->input->post('from'),
					'UNIT_APT_TO' => $val->set_value('level'),
					'KD_MILIK_OBAT' => $kdmilik,
					'FLAG' => 1,
					'JUMLAH_TOTAL' => $totaljumlah,
					'ninput_oleh' => $this->session->userdata('user_name'),
					'ninput_tgl' => date('Y-m-d H:i:s')
				);
				
				$db->insert('apt_trans_obat', $dataobt);
				
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
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from tbl_t_gudang where nid_t_gudang = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function edit_pkm()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$idtmp = explode('-',$_GET['id']);
		$kd_puskesmas = $idtmp[0];
		$kd_obat = $idtmp[1];
		$db = $this->load->database('sikda', TRUE);
		$db->select("*");
		$db->from('vw_lst_obat');
		$db->where('KD_PKM',$kd_puskesmas);
		$db->where('KD_OBAT',$kd_obat);
		$db->where('KD_MILIK_OBAT','PKM');
		$db->order_by('KD_MILIK_OBAT','DESC');
		$val = $db->get()->result_array();
		$data['data']=$val;
		$this->load->view('t_gudang/v_t_gudang_edit_pkm',$data);
	}
	
	public function editprocess_pkm()
	{
		$kd_puskesmas = $this->input->post('kd_puskesmas')?$this->input->post('kd_puskesmas',TRUE):null;
		$kd_obat = $this->input->post('kd_obat')?$this->input->post('kd_obat',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$post = $this->input->post('stock',true);
		$post1 = $this->input->post('stock1',true);
		if($post){
			if(!is_numeric($post))die('Silahkan Masukan Angka pada kolom Stock APT');
			$db->where('KD_PKM',$kd_puskesmas);
			$db->where('KD_OBAT',$kd_obat);
			$db->where('KD_MILIK_OBAT','PKM');
			$db->where('KD_UNIT_APT','APT');
			$db->set('JUMLAH_STOK_OBAT',$post);
			$db->update('apt_stok_obat');
		}
		if($post1){
			if(!is_numeric($post1))die('Silahkan Masukan Angka pada kolom Stock IF');
			$db->where('KD_PKM',$kd_puskesmas);
			$db->where('KD_OBAT',$kd_obat);
			$db->where('KD_MILIK_OBAT','PKM');
			$db->where('KD_UNIT_APT','IF');
			$db->set('JUMLAH_STOK_OBAT',$post1);
			$db->update('apt_stok_obat');
		}
		if($post and $post1){
			if(!is_numeric($post))die('Silahkan Masukan Angka pada kolom Stock APT');
			if(!is_numeric($post1))die('Silahkan Masukan Angka pada kolom Stock IF');
			$db->where('KD_PKM',$kd_puskesmas);
			$db->where('KD_OBAT',$kd_obat);
			$db->where('KD_MILIK_OBAT','PKM');
			$db->where('KD_UNIT_APT','APT');
			$db->set('JUMLAH_STOK_OBAT',$post);
			$db->update('apt_stok_obat');
			
			$db->where('KD_PKM',$kd_puskesmas);
			$db->where('KD_OBAT',$kd_obat);
			$db->where('KD_MILIK_OBAT','PKM');
			$db->where('KD_UNIT_APT','IF');
			$db->set('JUMLAH_STOK_OBAT',$post1);
			$db->update('apt_stok_obat');
		}
		if ($db->trans_status() === FALSE)
		{
			$db->trans_rollback();
			die('Maaf Proses Update Data Gagal');
		}
		else
		{
			$db->trans_commit();
			die('OK');
		}
	}
	
	public function edit_dk()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$idtmp = explode('-',$_GET['id']);
		$kd_puskesmas = $idtmp[0];
		$kd_obat = $idtmp[1];
		$db = $this->load->database('sikda', TRUE);
		$db->select("*");
		$db->from('vw_lst_obat');
		$db->where('KD_PKM',$kd_puskesmas);
		$db->where('KD_OBAT',$kd_obat);
		$db->where('KD_MILIK_OBAT','DK');
		$db->order_by('KD_MILIK_OBAT','DESC');
		$val = $db->get()->result_array();
		$data['data']=$val;
		$this->load->view('t_gudang/v_t_gudang_edit_dk',$data);
	}
	
	public function editprocess_dk()
	{
		$kd_puskesmas = $this->input->post('kd_puskesmas')?$this->input->post('kd_puskesmas',TRUE):null;
		$kd_obat = $this->input->post('kd_obat')?$this->input->post('kd_obat',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$post = $this->input->post('stock3',true);
		$post1 = $this->input->post('stock4',true);
		if($post){
			if(!is_numeric($post))die('Silahkan Masukan Angka pada kolom Stock APT');
			$db->where('KD_PKM',$kd_puskesmas);
			$db->where('KD_OBAT',$kd_obat);
			$db->where('KD_MILIK_OBAT','DK');
			$db->where('KD_UNIT_APT','APT');
			$db->set('JUMLAH_STOK_OBAT',$post);
			$db->update('apt_stok_obat');
		}
		if($post1){
			if(!is_numeric($post1))die('Silahkan Masukan Angka pada kolom Stock IF');
			$db->where('KD_PKM',$kd_puskesmas);
			$db->where('KD_OBAT',$kd_obat);
			$db->where('KD_MILIK_OBAT','DK');
			$db->where('KD_UNIT_APT','IF');
			$db->set('JUMLAH_STOK_OBAT',$post1);
			$db->update('apt_stok_obat');
		}
		if($post and $post1){
			if(!is_numeric($post))die('Silahkan Masukan Angka pada kolom Stock APT');
			if(!is_numeric($post1))die('Silahkan Masukan Angka pada kolom Stock IF');
			$db->where('KD_PKM',$kd_puskesmas);
			$db->where('KD_OBAT',$kd_obat);
			$db->where('KD_MILIK_OBAT','DK');
			$db->where('KD_UNIT_APT','APT');
			$db->set('JUMLAH_STOK_OBAT',$post);
			$db->update('apt_stok_obat');
			
			$db->where('KD_PKM',$kd_puskesmas);
			$db->where('KD_OBAT',$kd_obat);
			$db->where('KD_MILIK_OBAT','DK');
			$db->where('KD_UNIT_APT','IF');
			$db->set('JUMLAH_STOK_OBAT',$post1);
			$db->update('apt_stok_obat');
		}
		if ($db->trans_status() === FALSE)
		{
			$db->trans_rollback();
			die('Maaf Proses Update Data Gagal');
		}
		else
		{
			$db->trans_commit();
			die('OK');
		}
	}
	
	public function obatsource()
	{
		$kdpmobat = $this->session->userdata('level_aplikasi')=='KABUPATEN'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas');
		$kdmilik = $this->session->userdata('level_aplikasi')=='PUSKESMAS'?'PKM':$this->session->userdata('level_aplikasi');
		$id=$this->input->get('term')?$this->input->get('term',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$comboicd = $db->query("SELECT obat.KD_OBAT AS id,IF((st.JUMLAH_STOK_OBAT IS NULL), concat(obat.NAMA_OBAT,' => Stok: 0'), concat(obat.NAMA_OBAT,' => Stok: ',st.JUMLAH_STOK_OBAT)) AS label
								FROM apt_mst_obat obat 
								LEFT JOIN apt_stok_obat st ON st.KD_OBAT = obat.KD_OBAT and st.KD_PKM = '".$kdpmobat."' and st.KD_MILIK_OBAT='".$kdmilik."'
								where obat.NAMA_OBAT like '%".$id."%' group by obat.KD_OBAT 
								 ",false)->result_array();//print_r($db->last_query());die;
		die(json_encode($comboicd));
	}
	
	public function obatsource1()
	{
		$id=$this->input->get('term')?$this->input->get('term',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$comboicd = $db->query("SELECT obat.KD_OBAT AS id,obat.NAMA_OBAT AS label,
								induk.GOL_OBAT AS category FROM apt_mst_obat obat LEFT JOIN 
								apt_mst_gol_obat induk ON induk.KD_GOL_OBAT = obat.KD_GOL_OBAT where obat.NAMA_OBAT like '%".$id."%' ")->result_array();
		die(json_encode($comboicd));
	}
	
}

/* End of file t_gudang.php */
/* Location: ./application/controllers/t_gudang.php */
