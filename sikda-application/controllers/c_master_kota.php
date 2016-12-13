<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_kota extends CI_Controller {
	public function index()
	{
		$this->load->view('masterKota/v_master_kota');
	}
	
	public function transaksikotapopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('masterKota/v_master_kota_popup',$data);
	}
	
	public function masterkotaxml()
	{
		$this->load->model('m_master_kota');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai')
					);
					
		$total = $this->m_master_kota->totalmasterkota($paramstotal);
		
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
					
		$result = $this->m_master_kota->getmasterkota($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterKota/v_master_kota_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('nama_kota', 'Nama Kota', 'trim|required|xss_clean');
				
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
				'nnama_kota' => $val->set_value('nama_kota'),
				'ntgl_master_kota' => date("Y-m-d", strtotime($this->input->post('tglmasterkota',TRUE))),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('tbl_master_kota', $dataexc);
			
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
		$val->set_rules('nama_kota', 'Nama Kota', 'trim|required|xss_clean');
		
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
				'nnama_kota' => $val->set_value('nama_kota'),
				'ntgl_master_kota' => date("Y-m-d", strtotime($this->input->post('tglmasterkota',TRUE))),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('nid_kota',$id);
			$db->update('tbl_master_kota', $dataexc);
			
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
		$val = $db->query("select * from tbl_master_kota where nid_kota = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterKota/v_master_kota_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from tbl_master_kota where nid_kota = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from tbl_master_kota where nid_kota = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('masterKota/v_master_kota_detail',$data);
	}
	
}

/* End of file c_master_kota.php */
/* Location: ./application/controllers/c_master_kota.php */