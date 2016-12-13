<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_letak_janin extends CI_Controller {
	public function index()
	{
		$this->load->view('masterLetakJanin/v_master_letak_janin');
	}
	
	public function masterletakjaninpopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('masterLetakJanin/v_master_letak_janin_popup',$data);
	}
	
	public function masterletakjaninxml()
	{
		$this->load->model('m_master_letak_janin');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'carinama'=>$this->input->post('carinama')
					);
					
		$total = $this->m_master_letak_janin->totalmasterletakjanin($paramstotal);
		
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
					'carinama'=>$this->input->post('carinama')
					);
					
		$result = $this->m_master_letak_janin->getmasterletakjanin($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterLetakJanin/v_master_letak_janin_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('letak_janin', 'Letak Janin', 'trim|required|xss_clean|min_length[2]');
				
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
				'LETAK_JANIN' => $val->set_value('letak_janin'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d')
			);
			
			$db->insert('mst_letak_janin', $dataexc);
			
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
		$val->set_rules('letak_janin', 'Letak Janin', 'trim|required|xss_clean|min_length[2]');
				
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
				'LETAK_JANIN' => $val->set_value('letak_janin'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d')
			);			
			
			$db->where('KD_LETAK_JANIN',$id);
			$db->update('mst_letak_janin', $dataexc);
			
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
		$val = $db->query("select * from mst_letak_janin where KD_LETAK_JANIN = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterLetakJanin/v_master_letak_janin_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_letak_janin where KD_LETAK_JANIN = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_letak_janin where KD_LETAK_JANIN = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('masterLetakJanin/v_master_letak_janin_detail',$data);
	}
	
}

/* End of file c_master_letak_janin.php */
/* Location: ./application/controllers/c_master_letak_janin.php */