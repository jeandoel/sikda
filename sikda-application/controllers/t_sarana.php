<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_sarana extends CI_Controller {
	public function index()
	{
		$this->load->helper('sigit_helper');
		$this->load->view('t_sarana/v_t_sarana');
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function t_saranaxml()
	{		
		$this->load->model('t_sarana_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'carisarana'=>$this->input->post('carisarana')
					);
					
		$total = $this->t_sarana_model->totalT_sarana($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'carisarana'=>$this->input->post('carisarana')
					);
		
		if($this->input->post('usergabung')) $params['usergabung']=$this->input->post('usergabung',TRUE);
					
		$result = $this->t_sarana_model->getT_sarana($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function t_subgridsaranaxml()
	{		
		$this->load->model('t_sarana_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(				
					'kd_sarana'=>$this->input->post('kd_sarana'),
					'nama_sarana'=>$this->input->post('nama_sarana')
					);
					
		$total = $this->t_sarana_model->totalsubgridSarana($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'kd_sarana'=>$this->input->post('kd_sarana'),
					'nama_sarana'=>$this->input->post('nama_sarana')
					);
					
					
		$result = $this->t_sarana_model->getsubgridSarana($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function addsaranamasuk()
	{	
		$this->load->helper('sigit_helper');
		$this->load->helper('beries_helper');
		/*$db = $this->load->database('sikda', TRUE);
		$dataall = $db->query("select a.KD_PUSKESMAS,a.NAMA_PUSKESMAS,a.LEVEL,a.KD_SUB_LEVEL,a.NAMA_SUB_LEVEL,c.KABUPATEN from sys_setting_def a 
								join users b on b.KD_PUSKESMAS=a.KD_PUSKESMAS
								join mst_kabupaten c on c.KD_KABUPATEN=a.KD_KABKOTA
								where group_id='".$this->session->userdata("group_id")."'")->row(); //print_r($dataall);die;
		$data['data'] = $dataall;*/
		
		/*$dataall = $db->query("SELECT a.KD_PUSKESMAS,a.LEVEL,a.NAMA_PUSKESMAS,a.KD_SUB_LEVEL,a.NAMA_SUB_LEVEL,b.KABUPATEN FROM sys_setting_def a
								join mst_kabupaten b on a.KD_KABKOTA=b.KD_KABUPATEN WHERE a.kd_puskesmas='".$this->session->userdata("kd_puskesmas")."'")->row(); //print_r($db->last_query());die;
		$data['data'] = $dataall;*/
		
		$this->load->view('t_sarana/v_t_sarana_masuk_add'/*,$data*/);
	}
	
	public function saranamasukprocess()
	{
		//print_r($_POST);die;
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('tanggal_sarana_masuk', 'Tanggal', 'trim|required|myvalid_date');		
		$val->set_rules('no_faktur_sarana_masuk', 'Nomor Faktur', 'trim|required|xss_clean');
		
		$arraysaranamasuk = $this->input->post('jenis_sarana_masuk_final')?json_decode($this->input->post('jenis_sarana_masuk_final',TRUE)):NULL;//print_r($arraysaranamasuk);die;
		
		$val->set_message('required', "Silahkan isi field \"%s\"");
		
		if ($val->run() == FALSE)
		{
			$val->set_error_delimiters('<div style="color:white">', '</div>');
			die(validation_errors());
		}
		else
		{						
			if(!$arraysaranamasuk) die('Silahkan Tambahkan Barang Masuk');
			$db = $this->load->database('sikda', TRUE);
			$db->trans_begin();
			//$tujuanmasuk = explode('-',$this->input->post('sub_level_sarana'));
			$milik = $this->session->userdata('level_aplikasi')=='KABUPATEN'?$this->session->userdata('kd_kabupaten'):($this->session->userdata('level_aplikasi')=='PUSKESMAS'?$this->session->userdata('kd_puskesmas'):$this->session->userdata('nid_user'));
			$datasaranamasuk = array(
								'TANGGAL_TRANSAKSI' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_sarana_masuk')))),
								'NO_FAKTUR' => $this->input->post('no_faktur_sarana_masuk'),
								'KD_PEMILIK_DATA' => $milik,
								'ASAL_SARANA' => $this->input->post('from_level'),
								'KD_TEMPAT_ASAL' => $this->session->userdata('level_aplikasi')=='PUSKESMAS'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas'),
								'NAMA_TEMPAT_ASAL' => $this->input->post('nama_asal_sarana_masuk'),
								'TUJUAN_SARANA' => $this->input->post('level_sarana'),
								'KD_TEMPAT_TUJUAN' => $this->session->userdata('level_aplikasi')=='KABUPATEN'?$this->session->userdata('kd_kabupaten'):($this->session->userdata('level_aplikasi')=='PUSKESMAS'?$this->session->userdata('kd_puskesmas'):$this->input->post('sub_level_sarana')),
								'NAMA_TEMPAT_TUJUAN' => $this->input->post('sub_level_sarana'),
								'NAMA_PEMILIK_SARANA' => $this->input->post('sub_level_sarana'),
								'Created_By' => $this->session->userdata('user_name'),
								'Created_Date' => date("Y-m-d")
							);//echo print_r($datasaranamasuk);die;
			$db->insert('apt_sarana',$datasaranamasuk);
			$kdsaranamasuk = $db->insert_id();
			//$kdsaranamasuk = '';
			$uniques = array();
			if($arraysaranamasuk){
				foreach($arraysaranamasuk as $rowjenissaranamasukloop){
					$datajenissaranamasuktmp = json_decode($rowjenissaranamasukloop);//print_r($datajenissaranamasuktmp);die;
					$jmlitem = $datajenissaranamasuktmp->kode_satuan_masuk=='buah'?1:($datajenissaranamasuktmp->kode_satuan_masuk=='lusin'?12:20);
			
					$querysel_ = $db->query("select * from apt_sarana_detail where KD_SARANA_POSYANDU='".$datajenissaranamasuktmp->kode_jenis_sarana_masuk."' and KD_PEMILIK_DATA='".$milik."'")->result_array();$a=count($querysel_);$querysel=$querysel_?$querysel_[$a-1]:$querysel_;
					$stockawl = $querysel?$querysel['STOK_AKHIR']:0;
					$stockahr = $stockawl+$jmlitem;
					$datajenissaranamasukloop = array(
						'KD_SARANA'=> $kdsaranamasuk,
						'KD_PEMILIK_DATA' => $milik,
						'KD_SARANA_POSYANDU' => $datajenissaranamasuktmp->kode_jenis_sarana_masuk,
						'KD_SATUAN' => $datajenissaranamasuktmp->kode_satuan_masuk,
						'KODE_BARANG' => $datajenissaranamasuktmp->kode_barang_sarana_masuk,
						'PEMILIK_SARANA' => $this->input->post('sub_level_sarana'),
						'STOK_AWAL' => $stockawl,
						'STOK_AKHIR' => $stockahr,
						'FLAG' => 'masuk',
						'Created_By' => $this->session->userdata('user_name'),
						'Created_Date' => date("Y-m-d")
					);
					//$datajenissaranamasukinsert = $datajenissaranamasukloop;					
					$uniques[$datajenissaranamasuktmp->kode_jenis_sarana_masuk] = $datajenissaranamasuktmp->kode_jenis_sarana_masuk;
					
					$db->insert('apt_sarana_detail',$datajenissaranamasukloop);
					//print_r($db->last_query());die();
				}				
				//print_r($datajenissaranamasukinsert);die;
				//$db->insert_batch('apt_sarana_detail',$datajenissaranamasukinsert);
				$qtytotal = $db->query("select sum(case when KD_SATUAN='buah' then 1 when KD_SATUAN='kodi' then 20 else 12 end) as total from apt_sarana_detail where KD_PEMILIK_DATA='".$milik."'")->row();
				$db->set('JUMLAH_TOTAL',$qtytotal->total);
				$db->where('KD_SARANA',$kdsaranamasuk);
				$db->where('NAMA_TEMPAT_TUJUAN',$this->input->post('sub_level_sarana'));
				$db->update('apt_sarana');
				
				foreach($uniques as $val){
					$jmlmasuk = $db->query("select SUM((CASE WHEN (KD_SATUAN = 'buah') THEN 1 WHEN (KD_SATUAN = 'kodi') THEN 20 ELSE 12 END)) AS `STOK` from apt_sarana_detail where KD_SARANA_POSYANDU='".$val."' and KD_PEMILIK_DATA='".$milik."' and KD_SARANA='".$kdsaranamasuk."' ")->row();
					$queryupdate = $db->query("select * from trans_sarana where  KD_SARANA_POSYANDU='".$val."' and TUJUAN_SARANA='".$milik."' ")->row();
					if($queryupdate){
						$dataupdate = array(
							'STOK_AWAL' => $queryupdate->STOK_AKHIR,
							'STOK_AKHIR' => $queryupdate->STOK_AKHIR+$jmlmasuk->STOK
						);
						
						$db->where('FLAG', 'masuk');
						$db->where('KD_SARANA_POSYANDU', $val);
						$db->where('TUJUAN_SARANA', $milik);
						$db->update('trans_sarana', $dataupdate);
					}else{
						$datainserttrans = array (
							'KD_SARANA_POSYANDU' => $val,
							'TANGGAL_TRANSAKSI' =>  date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_sarana_masuk')))),
							'FLAG' =>  'masuk',
							'ASAL_SARANA' => $this->session->userdata('level_aplikasi')=='PUSKESMAS'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas'),
							'TUJUAN_SARANA' =>  $this->session->userdata('level_aplikasi')=='KABUPATEN'?$this->session->userdata('kd_kabupaten'):($this->session->userdata('level_aplikasi')=='PUSKESMAS'?$this->session->userdata('kd_puskesmas'):$this->input->post('sub_level_sarana')),
							'STOK_AWAL' =>  0,
							'STOK_AKHIR' =>  $jmlmasuk->STOK
						);//echo print_r($datainserttrans);die;
						$db->insert('trans_sarana', $datainserttrans);
					}
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
	}

	public function addsaranakeluar()
	{
		$this->load->helper('sigit_helper');
		$this->load->helper('beries_helper');
		/*$db = $this->load->database('sikda', TRUE);
		$dataall = $db->query("select a.KD_PUSKESMAS,a.NAMA_PUSKESMAS,a.LEVEL,a.KD_SUB_LEVEL,a.NAMA_SUB_LEVEL,c.KABUPATEN from sys_setting_def a 
								left join users b on b.KD_PUSKESMAS=a.KD_PUSKESMAS
								left join mst_kabupaten c on c.KD_KABUPATEN=a.KD_KABKOTA
								where group_id='".$this->session->userdata("group_id")."'")->row(); //print_r($dataall);die;
		$data['data'] = $dataall;*/
		$this->load->view('t_sarana/v_t_sarana_keluar_add'/*,$data*/);
	}
	
	public function saranakeluarprocess()
	{
		//print_r($_POST);die;
		$this->load->library('form_validation');
		$val = $this->form_validation;
		$val->set_rules('tanggal_sarana_keluar', 'Tanggal', 'trim|required|myvalid_date');		
		$val->set_rules('no_faktur_sarana_keluar', 'Nomor Faktur', 'trim|required|xss_clean');
		
		$arraysaranakeluar = $this->input->post('jenis_sarana_keluar_final')?json_decode($this->input->post('jenis_sarana_keluar_final',TRUE)):NULL;
		
		$val->set_message('required', "Silahkan isi field \"%s\"");
		
		if ($val->run() == FALSE)
		{
			$val->set_error_delimiters('<div style="color:white">', '</div>');
			die(validation_errors());
		}
		else
		{						
			if(!$arraysaranakeluar) die('Silahkan Tambahkan Barang Keluar');
			$db = $this->load->database('sikda', TRUE);
			$db->trans_begin();
			//$tujuankeluar = explode('-',$this->input->post('sub_level'));
			$milik = $this->session->userdata('level_aplikasi')=='KABUPATEN'?$this->session->userdata('kd_kabupaten'):($this->session->userdata('level_aplikasi')=='PUSKESMAS'?$this->session->userdata('kd_puskesmas'):$this->session->userdata('nid_user'));
			$datasaranakeluar = array(
								'TANGGAL_TRANSAKSI' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_sarana_keluar')))),
								'NO_FAKTUR' => $this->input->post('no_faktur_sarana_keluar'),
								'KD_PEMILIK_DATA' => $milik,
								'ASAL_SARANA' => $this->input->post('from_level'),
								'KD_TEMPAT_ASAL' => $this->session->userdata('level_aplikasi')=='KABUPATEN'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas'),
								'NAMA_TEMPAT_ASAL' => $this->input->post('nama_asal_sarana_keluar'),
								'TUJUAN_SARANA' => $this->input->post('level_sarana'),
								'KD_TEMPAT_TUJUAN' => $this->input->post('sub_level_sarana'),
								'NAMA_TEMPAT_TUJUAN' => $this->input->post('sub_level_sarana'),
								'NAMA_PEMILIK_SARANA' => $this->input->post('sub_level_sarana'),
								'Created_By' => $this->session->userdata('user_name'),
								'Created_Date' => date("Y-m-d")
							);
			$db->insert('apt_sarana',$datasaranakeluar);
			$kdsaranakeluar = $db->insert_id();
			if($arraysaranakeluar){
				foreach($arraysaranakeluar as $rowjenissaranakeluarloop){
					$datajenissaranakeluartmp = json_decode($rowjenissaranakeluarloop);
					$jmlitem = $datajenissaranakeluartmp->kode_satuan_keluar=='buah'?1:($datajenissaranakeluartmp->kode_satuan_keluar=='lusin'?12:20);
			
					$querysel_ = $db->query("select * from apt_sarana_detail where KD_SARANA_POSYANDU='".$datajenissaranakeluartmp->kode_jenis_sarana_keluar."' and KD_PEMILIK_DATA='".$milik."'")->result_array();$a=count($querysel_);$querysel=$querysel_?$querysel_[$a-1]:$querysel_;
					//print_r($querysel);die;
					$stockawl = $querysel?$querysel['STOK_AKHIR']:0;
					$stockahr = $stockawl-$jmlitem;
					$datajenissaranakeluarloop = array(
						'KD_SARANA'=> $kdsaranakeluar,
						'KD_PEMILIK_DATA' => $milik,
						'KD_SARANA_POSYANDU' => $datajenissaranakeluartmp->kode_jenis_sarana_keluar,
						'KD_SATUAN' => $datajenissaranakeluartmp->kode_satuan_keluar,
						'KODE_BARANG' => $datajenissaranakeluartmp->kode_barang_sarana_keluar,
						'PEMILIK_SARANA' => $this->input->post('sub_level_sarana'),
						'STOK_AWAL' => $stockawl,
						'STOK_AKHIR' => $stockahr,
						'FLAG' => 'keluar',
						'Created_By' => $this->session->userdata('user_name'),
						'Created_Date' => date("Y-m-d")
					);
					//$datajenissaranakeluarinsert = $datajenissaranakeluarloop;				
					$uniques[$datajenissaranakeluartmp->kode_jenis_sarana_keluar] = $datajenissaranakeluartmp->kode_jenis_sarana_keluar;
					
					$db->insert('apt_sarana_detail',$datajenissaranakeluarloop);
				}
				//$db->insert_batch('apt_sarana_detail',$datajenissaranakeluarinsert);
				$qtytotal = $db->query("select sum(case when KD_SATUAN='buah' then 1 when KD_SATUAN='kodi' then 20 else 12 end) as total from apt_sarana_detail where KD_PEMILIK_DATA='".$milik."' and KD_SARANA= '".$kdsaranakeluar."'")->row();
				$db->set('JUMLAH_TOTAL',$qtytotal->total);
				$db->where('KD_SARANA',$kdsaranakeluar);
				$db->update('apt_sarana');				
			}
			foreach($uniques as $val){
			$jmlkeluar = $db->query("select SUM((CASE WHEN (KD_SATUAN = 'buah') THEN 1 WHEN (KD_SATUAN = 'kodi') THEN 20 ELSE 12 END)) AS `JUMLAH_KELUAR` from apt_sarana_detail where KD_SARANA_POSYANDU='".$val."' and KD_PEMILIK_DATA='".$milik."' and KD_SARANA='".$kdsaranakeluar."' ")->row();			
			$queryupdate = $db->query("select * from trans_sarana where KD_SARANA_POSYANDU='".$val."' and TUJUAN_SARANA='".$milik."' ")->row();
				if($queryupdate){
						$dataupdate = array(
							'STOK_AWAL' => $queryupdate->STOK_AKHIR,
							'STOK_AKHIR' => $queryupdate->STOK_AKHIR-$jmlkeluar->JUMLAH_KELUAR
						);
						
						//$db->where('FLAG', 'keluar');
						$db->where('KD_SARANA_POSYANDU', $val);
						$db->where('TUJUAN_SARANA', $milik);
						$db->update('trans_sarana', $dataupdate);
				}else{
					$datainserttrans = array (
							'KD_SARANA_POSYANDU' => $val,
							'TANGGAL_TRANSAKSI' =>  date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_sarana_keluar')))),
							'FLAG' =>  'keluar',
							'ASAL_SARANA' =>  $this->session->userdata('level_aplikasi')=='KABUPATEN'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas'),
							'TUJUAN_SARANA' =>  $this->input->post('sub_level_sarana'),
							'STOK_AWAL' =>  0,
							'STOK_AKHIR' =>  $jmlkeluar->JUMLAH_KELUAR
					);
					$db->insert('trans_sarana', $datainserttrans);
				}
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
	
	

}

/* End of file t_sarana.php */
/* Location: ./application/controllers/t_sarana.php */
