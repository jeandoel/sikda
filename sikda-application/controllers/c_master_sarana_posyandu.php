<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_sarana_posyandu extends CI_Controller {
	public function index()
	{
		$this->load->view('masterSaranaposyandu/v_master_sarana_posyandu');
	}
	
	public function mastersaranaposyanduxml()
	{
		$this->load->model('m_master_sarana_posyandu');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'nama'=>$this->input->post('nama')
					);
					
		$total = $this->m_master_sarana_posyandu->totalMastersaranaposyandu($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'nama'=>$this->input->post('nama')
					);
					
		$result = $this->m_master_sarana_posyandu->getMastersaranaposyandu($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterSaranaposyandu/v_master_sarana_posyandu_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kodesarana', 'Kode Sarana', 'trim|required|xss_clean');
		$val->set_rules('saranaposyandu', 'Sarana Posyandu', 'trim|required|xss_clean');
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
				'KD_SARANA_POSYANDU' => $val->set_value('kodesarana'),
				'NAMA_SARANA_POSYANDU' => $val->set_value('saranaposyandu'),
				'nama_input' => $this->session->userdata('nusername'),
				'tgl_input' => date('Y-m-d H:i:s')
			);
			
			$db->insert('mst_sarana_posyandu', $dataexc);
			
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
		$val->set_rules('kodesarana', 'Kode Sarana', 'trim|required|xss_clean');
		$val->set_rules('saranaposyandu', 'Sarana Posyandu', 'trim|required|xss_clean');

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
				'KD_SARANA_POSYANDU' => $val->set_value('kodesarana'),
				'NAMA_SARANA_POSYANDU' => $val->set_value('saranaposyandu'),
				'nama_update' => $this->session->userdata('nusername'),
				'tgl_update' => date('Y-m-d H:i:s')
			);
			
			$db->where('KD_SARANA_POSYANDU',$id);
			$db->update('mst_sarana_posyandu', $dataexc);
			
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
		$val = $db->query("select * from mst_sarana_posyandu where KD_SARANA_POSYANDU = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterSaranaposyandu/v_master_sarana_posyandu_edit',$data);//print_r($data);die();
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_sarana_posyandu where KD_SARANA_POSYANDU = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_sarana_posyandu where KD_SARANA_POSYANDU= '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('masterSaranaposyandu/v_master_sarana_posyandu_detail',$data);
	}
	
}

/* End of file c_master_asal_pasien.php */
/* Location: ./application/controllers/c_master_asal_pasien.php */