<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_agama extends CI_Controller {
	public function index()
	{
		$this->load->view('masterAgama/v_master_agama');
	}
	
	
	public function master_agamaxml()
	{
		$this->load->model('m_master_agama');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'kodeagama'=>$this->input->post('kodeagama')
					);
					
		$total = $this->m_master_agama->totalmaster_agama($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'kodeagama'=>$this->input->post('kodeagama')
					);
					
		$result = $this->m_master_agama->getMaster_agama($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterAgama/v_master_agama_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');
		$val = $this->form_validation;
		$val->set_rules('kodeagama', 'Kode Agama', 'trim|required|xss_clean');
		$val->set_rules('agama', 'Agama', 'trim|required|xss_clean');
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
				'KD_AGAMA' => $val->set_value('kodeagama'),
				'AGAMA' => $val->set_value('agama'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('mst_agama', $dataexc);
			
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
		$id = $this->input->post('kodeagamaid',TRUE);		
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kodeagama', 'Kode Agama', 'trim|required|xss_clean');
		$val->set_rules('agama', 'Agama', 'trim|required|xss_clean');
		
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
				'KD_AGAMA' => $val->set_value('kodeagama'),
				'AGAMA' => $val->set_value('agama'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('KD_AGAMA',$id);
			$db->update('mst_agama', $dataexc);
			
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
		$id=$this->input->get('kodeagama')?$this->input->get('kodeagama',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_agama where KD_AGAMA = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterAgama/v_master_agama_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('kodeagama')?$this->input->post('kodeagama',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_agama where KD_AGAMA = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('kodeagama')?$this->input->get('kodeagama',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_agama where KD_AGAMA = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('masterAgama/v_master_agama_detail',$data);
	}
	
}

/* End of file master_kecamatan.php */
/* Location: ./application/controllers/c_master_kecamatan.php */
