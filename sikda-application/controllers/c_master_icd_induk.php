<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_icd_induk extends CI_Controller {
	public function index()
	{
		$this->load->view('masterIcdinduk/v_master_icd_induk');
	}
	
	public function icdindukpopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('masterIcdinduk/v_master_icd_induk_popup',$data);
	}
	
	public function icdindukxml()
	{
		$this->load->model('m_master_icd_induk');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari'),
					'nama'=>$this->input->post('nama')
					);
					
		$total = $this->m_master_icd_induk->totalIcdinduk($paramstotal);
		
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
					'nama'=>$this->input->post('nama')
					);
					
		$result = $this->m_master_icd_induk->getIcdinduk($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterIcdinduk/v_master_icd_induk_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');
		$val = $this->form_validation;
		$val->set_rules('kodeicdinduk', 'Kode ICD Induk', 'trim|required|xss_clean');
		$val->set_rules('icdinduk', 'ICD Induk', 'trim|required|xss_clean');
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
				'KD_ICD_INDUK' => $val->set_value('kodeicdinduk'),
				'ICD_INDUK' => $val->set_value('icdinduk'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('mst_icd_induk', $dataexc);
			
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
		$val->set_rules('kodeicdinduk', 'Kode ICD Induk', 'trim|required|xss_clean');
		$val->set_rules('icdinduk', 'ICD Induk', 'trim|required|xss_clean');
		
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
				'KD_ICD_INDUK' => $val->set_value('kodeicdinduk'),
				'ICD_INDUK' => $val->set_value('icdinduk'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('KD_ICD_INDUK',$id);
			$db->update('mst_icd_induk', $dataexc);
			
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
		$val = $db->query("select * from mst_icd_induk where KD_ICD_INDUK = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterIcdinduk/v_master_icd_induk_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_icd_induk where KD_ICD_INDUK = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_icd_induk where KD_ICD_INDUK = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterIcdinduk/v_master_icd_induk_detail',$data);
	}
	
}

/* End of file c_master_icd_induk.php */
/* Location: ./application/controllers/c_master_icd_induk.php */