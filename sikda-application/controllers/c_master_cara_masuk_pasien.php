<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_cara_masuk_pasien extends CI_Controller {
	public function index()
	{
		$this->load->view('masterCaramasukpasien/v_master_cara_masuk_pasien');
	}
	
	
	public function caramasukpasienxml()
	{
		$this->load->model('m_master_cara_masuk_pasien');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'carimasukpasien'=>$this->input->post('carimasukpasien')
					);
					
		$total = $this->m_master_cara_masuk_pasien->totalCaramasukpasien($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'carimasukpasien'=>$this->input->post('carimasukpasien')
					);
					
		$result = $this->m_master_cara_masuk_pasien->getCaramasukpasien($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterCaramasukpasien/v_master_cara_masuk_pasien_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');
		$val = $this->form_validation;
		$val->set_rules('kodecaramasuk', 'Kode Cara Masuk', 'trim|required|xss_clean');
		$val->set_rules('caramasuk', 'Cara Masuk', 'trim|required|xss_clean');
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
			$dataexc = array(
				'KD_CARA_MASUK' => $val->set_value('kodecaramasuk'),
				'CARA_MASUK' => $val->set_value('caramasuk'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('mst_cara_masuk_pasien', $dataexc);
			
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
		$val->set_rules('kodecaramasuk', 'Kode Cara Masuk', 'trim|required|xss_clean');
		$val->set_rules('caramasuk', 'Cara Masuk', 'trim|required|xss_clean');
		
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
				'KD_CARA_MASUK' => $val->set_value('kodecaramasuk'),
				'CARA_MASUK' => $val->set_value('caramasuk'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('KD_CARA_MASUK',$id);
			$db->update('mst_cara_masuk_pasien', $dataexc);
			
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
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_cara_masuk_pasien where KD_CARA_MASUK = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterCaramasukpasien/v_master_cara_masuk_pasien_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_cara_masuk_pasien where KD_CARA_MASUK = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_cara_masuk_pasien where KD_CARA_MASUK = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterCaramasukpasien/v_master_cara_masuk_pasien_detail',$data);
	}
	
}

/* End of file c_master_cara_masuk_pasien.php */
/* Location: ./application/controllers/c_master_cara_masuk_pasien.php */