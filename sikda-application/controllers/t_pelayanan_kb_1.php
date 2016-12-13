<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_pelayanan_kb extends CI_Controller {
	public function index()
	{
		$this->load->helper('master_helper');
		$this->load->view('t_pelayanan_kb/v_pelayanan_kb');
	}
	
	
	public function t_pelayanan_kbxml()
	{
		$this->load->model('t_pelayanan_kb_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari')
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
					'cari'=>$this->input->post('cari')
					);
					
		$result = $this->t_pelayanan_kb_model->getTpelayanankb($params);
		//$result = $this->t_pelayanan_kb_model->getttindakankb($params);
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->helper('master_helper');
		
		$this->load->view('t_pelayanan_kb/v_pelayanan_kb_add');
	
	
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
		
		$arraytindakan = $this->input->post('tindakan_final')?json_decode($this->input->post('tindakan_final',TRUE)):NULL;
		
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
			
			$dataexc1 = array( 	
				'KD_DOKTER_PEMERIKSA' => $val->set_value('pemeriksa'),
				'KD_DOKTER_PETUGAS' => $val->set_value('petugas'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
				$db->insert('trans_kia', $dataexc1);
				
				$kodekia=$db->insert_id();
			
			$dataexc = array(
				'KD_JENIS_KB' => $this->input->post('kdjeniskb')?$this->input->post('kdjeniskb',TRUE):'',
				'KD_KIA' => $kodekia,
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
			
			if($arraytindakan){
				foreach($arraytindakan as $rowtindakanloop){
					$datatindakantmp = json_decode($rowtindakanloop);
					$datatindakanloop[] = array(
						'KD_KUNJUNGAN_KB' => $kodekunjungankb,
						'KD_PRODUK' => $datatindakantmp->kdproduk,
						'PRODUK' => $datatindakantmp->produk,
						'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
						//'PRODUK' => $datatindakantmp->produk,
						//'TANGGAL' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tanggalpemeriksaan')))),
						'ninput_oleh' => $this->session->userdata('nusername'),
						'ninput_tgl' => date('Y-m-d H:i:s')
					);
					//print_r($datatindakanloop);die;
					$datatindakaninsert = $datatindakanloop;
				}
				$db->insert_batch('detail_tindakan_kb',$datatindakaninsert);
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
	{
		$id = $this->input->post('id',TRUE);		
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kdjeniskb', 'Kd Jenis Kb', 'trim|required|xss_clean');
		$val->set_rules('tanggalpemeriksaan', 'Tanggal Pemeriksaan', 'trim|required|xss_clean');
		$val->set_rules('keluhan', 'Keluhan', 'trim|required|xss_clean');
		$val->set_rules('anamnese', 'Anamnese', 'trim|required|xss_clean');
		$val->set_rules('pemeriksa', 'Pemeriksa', 'trim|required|xss_clean');
		$val->set_rules('petugas', 'Petugas', 'trim|required|xss_clean');
		if ($val->run() == FALSE)
		
		
		
		{
			$val->set_error_delimiters('<div style="color:white">', '</div>');
			die(validation_errors());
		}
		else
		{						
			$db = $this->load->database('sikda', TRUE);
			$db->trans_begin();
			
			$arraytindakan = $this->input->post('tindakan_final')?json_decode($this->input->post('tindakan_final',TRUE)):NULL;
			
			$dataexc = array(
				'KD_JENIS_KB' => $this->input->post('kdjeniskb')?$this->input->post('kdjeniskb',TRUE):'',
				'TANGGAL' =>  date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tanggalpemeriksaan')))),
				'KELUHAN' => $val->set_value('keluhan'),
				'ANAMNESE' => $val->set_value('anamnese'),
				'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('KD_KUNJUNGAN_KB',$id);
			$db->update('kunjungan_kb', $dataexc);
			
			
			
			if($arraytindakan){
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
		$this->load->helpers('master_helper');
		$db = $this->load->database('sikda', TRUE);
		$db->select("u.KD_KUNJUNGAN_KB as kode,DATE_FORMAT(u.TANGGAL, '%d-%M-%Y') as TANGGAL,u.KD_KUNJUNGAN_KB,m.JENIS_KB,concat (h.NAMA,'-',h.JABATAN) as pemeriksa,concat (i.NAMA,'-',i.JABATAN) as petugas,u.KELUHAN,u.ANAMNESE,s.PRODUK,u.KD_KUNJUNGAN_KB as id", false );
		$db->from('kunjungan_kb u');
		$db->join('mst_jenis_kb m','m.KD_JENIS_KB=u.KD_JENIS_KB');
		$db->join('detail_tindakan_kb s','s.KD_KUNJUNGAN_KB=u.KD_KUNJUNGAN_KB');
		$db->join('trans_kia g','g.KD_KIA=u.KD_KIA');
		$db->join('mst_dokter h','g.KD_DOKTER_PEMERIKSA=h.KD_DOKTER');
		$db->join('mst_dokter i','g.KD_DOKTER_PETUGAS=i.KD_DOKTER');
		$db->where('u.KD_KUNJUNGAN_KB ',$id);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('t_pelayanan_kb/v_pelayanan_kb_edit',$data);
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
		$db->select("u.KD_KUNJUNGAN_KB as kode,DATE_FORMAT(u.TANGGAL, '%d-%M-%Y') as TANGGAL,u.KD_KUNJUNGAN_KB,m.JENIS_KB,concat (h.NAMA,'-',h.JABATAN) as pemeriksa,concat (i.NAMA,'-',i.JABATAN) as petugas,u.KELUHAN,u.ANAMNESE,group_concat(distinct s.PRODUK separator ' | ') as PRODUK,u.KD_KUNJUNGAN_KB as id", false );
		$db->from('kunjungan_kb u');
		$db->join('mst_jenis_kb m','m.KD_JENIS_KB=u.KD_JENIS_KB');
		$db->join('detail_tindakan_kb s','s.KD_KUNJUNGAN_KB=u.KD_KUNJUNGAN_KB');
		$db->join('trans_kia g','g.KD_KIA=u.KD_KIA');
		$db->join('mst_dokter h','g.KD_DOKTER_PEMERIKSA=h.KD_DOKTER');
		$db->join('mst_dokter i','g.KD_DOKTER_PETUGAS=i.KD_DOKTER');
		$db->group_by('u.KD_KUNJUNGAN_KB');
		$db->where('u.KD_KUNJUNGAN_KB ',$id);
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('t_pelayanan_kb/v_pelayanan_kb_detail',$data);
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
	
	
	public function t_tindakan_pelayanan_kbxml()
	{
		$this->load->model('t_pelayanan_kb_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari'),
					'id'=>$this->input->post('myid')
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
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid')
					);
					
		$result = $this->t_pelayanan_kb_model->gett_tindakan_pelayanan_kb($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
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