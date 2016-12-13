<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class t_registrasi_kia extends CI_Controller {
	public function index()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_registrasi_kia/v_registrasi_kia',$datasuami);
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function t_registrasi_kiaxml()
	{		
		$this->load->model('t_registrasi_kia_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari'),
					'tanggal'=>$this->input->post('tanggal')
					);
					
		$total = $this->t_registrasi_kia_model->totalT_registrasi_kia($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari'),
					'tanggal'=>date("Y-m-d", strtotime(str_replace('/', '-',($this->input->post('tanggal')))))
					);
		
				
		$result = $this->t_registrasi_kia_model->getT_registrasi_kia($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function t_registrasi_kiaantrianxml()
	{		
		$this->load->model('t_registrasi_kia_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari')
					);
					
		$total = $this->t_registrasi_kia_model->totalDaftar_antrian($paramstotal);
		
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
					
		$result = $this->t_registrasi_kia_model->getDaftar_antrian($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function t_detailantriankunjungan()
	{		
		$this->load->model('t_registrasi_kia_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(				
					'kd_pasien'=>$this->input->post('kd_pasien'),
					'kd_puskesmas'=>$this->input->post('kd_puskesmas'),
					'kd_pelayanan'=>$this->input->post('kd_pelayanan')
					);
					//print_r($paramstotal);die;
					
		$total = $this->t_registrasi_kia_model->totalT_detailantriankunjungan($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),				
					'kd_pasien'=>$this->input->post('kd_pasien'),
					'kd_puskesmas'=>$this->input->post('kd_puskesmas'),
					'kd_pelayanan'=>$this->input->post('kd_pelayanan')
					);
					
					
		$result = $this->t_registrasi_kia_model->getT_detailantriankunjungan($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function add()
	{
		$this->load->helper('beries_helper');
		$db = $this->load->database('sikda',true);
		if($this->input->get('id')!=='undefined'){
			$id = $this->input->get('id')?$this->input->get('id',true):'';
			$d = $db->query("select KD_FAMILY_FOLDER from family_folder a join pasien b on a.ID_FAMILY_FOLDER=b.ID_FAMILY_FOLDER where KD_PASIEN='".$id."'")->row();
			$db->select("f.ID_FAMILY_FOLDER, p.NAMA_LENGKAP AS NAMA_SUAMI, p.TEMPAT_LAHIR, Get_Age(p.TGL_LAHIR) as UMUR, DATE_FORMAT(p.TGL_LAHIR, '%d-%m-%Y') as TGL_LAHIR, p.KD_AGAMA, p.KD_GOL_DARAH, p.KD_PENDIDIKAN, p.KD_PEKERJAAN", FALSE);
			$db->from('family_folder f');
			$db->join('pasien p','f.ID_FAMILY_FOLDER=p.ID_FAMILY_FOLDER');
			$db->where('KD_FAMILY_FOLDER',$d->KD_FAMILY_FOLDER);
			$db->where('KD_STATUS_KELUARGA',1);
			$valsu = $db->get()->row();
			$data['data']= $valsu;
			$this->load->view('t_registrasi_kia/v_t_registrasi_kia_add',$data);
		}else{
			$this->load->view('t_registrasi_kia/v_t_registrasi_kia_add');
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("u.*, m.ncolumn1 as nmastercolumn1");
		$db->from('tbl_t_registrasi_kia u');
		$db->join('tbl_master1 m','m.nid_master1=u.nmaster_1_id');
		$db->where('u.nid_t_registrasi_kia ',$id);
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('t_registrasi_kia/t_registrasi_kiadetail',$data);
	}
	
	public function ibuhamil()
	{
		$this->load->helper('my_helper');
		$this->load->helper('beries_helper');
		$this->load->view('t_registrasi_kia/v_kunjungan_ibuhamil');
	}
	
	public function ibunifas()
	{
		$this->load->helper('beries_helper');
		$this->load->helper('ernes_helper');
		$this->load->view('t_registrasi_kia/v_kunjungan_ibunifas');
	}
	
	public function ibubersalin()
	{
		$this->load->helper('beries_helper');
		$this->load->helper('my_helper');
		$this->load->view('t_registrasi_kia/v_kunjungan_ibubersalin');
	}
	
	public function ibukb()
	{
		$this->load->helper('beries_helper');
		$this->load->helper('master_helper');
		$this->load->view('t_registrasi_kia/v_kunjungan_ibukb');
	}
	
	public function kesehatananak()
	{
		$db = $this->load->database('sikda',true);
		$this->load->helper('beries_helper');
		$this->load->helper('master1_helper');
		$this->load->helper('my_helper');
		if($this->input->get('id')!=='undefined'){
			$id = $this->input->get('id')?$this->input->get('id',true):'';
			$valanak = $db->query("select PANJANG_BADAN,BERAT_LAHIR,ANAK_KE,LINGKAR_KEPALA from pasien where KD_PASIEN='".$id."'")->row();
			
			$d = $db->query("select KD_FAMILY_FOLDER from family_folder a join pasien b on a.ID_FAMILY_FOLDER=b.ID_FAMILY_FOLDER where KD_PASIEN='".$id."'")->row();
			//<!-- DATA SUAMI -->
			$db->select("f.ID_FAMILY_FOLDER, p.NAMA_LENGKAP AS NAMA_AYAH, p.TEMPAT_LAHIR as TEMPAT_LAHIR_AYAH, Get_Age(p.TGL_LAHIR) as UMUR_AYAH, DATE_FORMAT(p.TGL_LAHIR, '%d-%m-%Y') as TGL_LAHIR_AYAH, p.KD_AGAMA as AGAMA_AYAH, p.KD_GOL_DARAH as DARAH_AYAH, p.KD_PENDIDIKAN as PEND_AYAH, p.KD_PEKERJAAN as KERJA_SUAMI", FALSE);
			$db->from('family_folder f');
			$db->join('pasien p','f.ID_FAMILY_FOLDER=p.ID_FAMILY_FOLDER');
			$db->where('KD_FAMILY_FOLDER',$d->KD_FAMILY_FOLDER);
			$db->where('KD_STATUS_KELUARGA',1);
			$valsu = $db->get()->row();
			
			//<!-- DATA ISTRI -->
			$db->select("f.ID_FAMILY_FOLDER, p.NAMA_LENGKAP AS NAMA_IBU, p.TEMPAT_LAHIR as TEMPAT_LAHIR_IBU, Get_Age(p.TGL_LAHIR) as UMUR_IBU, DATE_FORMAT(p.TGL_LAHIR, '%d-%m-%Y') as TGL_LAHIR_IBU, p.KD_AGAMA as AGAMA_IBU, p.KD_GOL_DARAH as DARAH_IBU, p.KD_PENDIDIKAN as PEND_IBU, p.KD_PEKERJAAN as KERJA_IBU", FALSE);
			$db->from('family_folder f');
			$db->join('pasien p','f.ID_FAMILY_FOLDER=p.ID_FAMILY_FOLDER');
			$db->where('KD_FAMILY_FOLDER',$d->KD_FAMILY_FOLDER);
			$db->where('KD_STATUS_KELUARGA',2);
			$valsuibu = $db->get()->row();
			
			$data['dataanak']= $valanak;
			$data['data']= $valsu;
			$data['dataibu']= $valsuibu;
			$this->load->view('t_registrasi_bayi/v_t_registrasi_bayi_add',$data);
		}else{
			$this->load->view('t_registrasi_bayi/v_t_registrasi_bayi_add');
		}
	}
	
	
}

/* End of file t_registrasi_kia.php */
/* Location: ./application/controllers/t_registrasi_kia.php */