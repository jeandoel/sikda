<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_pendidikan extends CI_Controller {
	public function index()
	{
		$this->load->view('masterPendidikan/v_master_pendidikan');
	}
	
	
	public function master_pendidikanxml()
	{
		$this->load->model('m_master_pendidikan');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'kodependidikan'=>$this->input->post('kodependidikan')
					);
					
		$total = $this->m_master_pendidikan->totalmaster_pendidikan($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'kodependidikan'=>$this->input->post('kodependidikan')
					);
					
		$result = $this->m_master_pendidikan->getMaster_pendidikan($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterPendidikan/v_master_pendidikan_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');
		$val = $this->form_validation;
		$val->set_rules('kodependidikan', 'Kode Pendidikan', 'trim|required|xss_clean');
		$val->set_rules('pendidikan', 'Pendidikan', 'trim|required|xss_clean');
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
				'KD_PENDIDIKAN' => $val->set_value('kodependidikan'),
				'PENDIDIKAN' => $val->set_value('pendidikan'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('mst_pendidikan', $dataexc);
			
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
		$id = $this->input->post('kodependidikanid',TRUE);		
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kodependidikan', 'Kode Pendidikan', 'trim|required|xss_clean');
		$val->set_rules('pendidikan', 'Pendidikan', 'trim|required|xss_clean');
		
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
				'KD_PENDIDIKAN' => $val->set_value('kodependidikan'),
				'PENDIDIKAN' => $val->set_value('pendidikan'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('KD_PENDIDIKAN',$id);
			$db->update('mst_pendidikan', $dataexc);
			
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
		$id=$this->input->get('kodependidikan')?$this->input->get('kodependidikan',TRUE):null;
		$id=$id=='nol'?'0':$id;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_pendidikan where KD_PENDIDIKAN = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterPendidikan/v_master_pendidikan_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('kodependidikan')?$this->input->post('kodependidikan',TRUE):null;
		$id=$id=='nol'?'0':$id;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_pendidikan where KD_PENDIDIKAN = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('kodependidikan')?$this->input->get('kodependidikan',TRUE):null;
		$id=$id=='nol'?'0':$id;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_pendidikan where KD_PENDIDIKAN = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterPendidikan/v_master_pendidikan_detail',$data);
		//PRINT_R($data);die;
	}
	
}

/* End of file master_kecamatan.php */
/* Location: ./application/controllers/c_master_kecamatan.php */
