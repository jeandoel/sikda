<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_jenis_obat extends CI_Controller {
	public function index()
	{
		$this->load->view('masterJenisobat/v_master_jenis_obat');
	}
	
	public function masterjenisobatxml()
	{
		$this->load->model('m_master_jenis_obat');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'jnsobat'=>$this->input->post('jnsobat')
					);
					
		$total = $this->m_master_jenis_obat->totalMasterjenisobat($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'jnsobat'=>$this->input->post('jnsobat')
					);
					
		$result = $this->m_master_jenis_obat->getMasterjenisobat($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterJenisobat/v_master_jenis_obat_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kdjnsobat', 'Kode Jenis Obat', 'trim|required|xss_clean');
		$val->set_rules('jenisobat', 'Jenis Obat', 'trim|required|xss_clean');
		
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
				'KD_JNS_OBT' => $val->set_value('kdjnsobat'),
				'JENIS_OBAT' => $val->set_value('jenisobat'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('apt_mst_jenis_obat', $dataexc);
			
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
		$val->set_rules('kdjnsobat', 'Kode Jenis Obat', 'trim|required|xss_clean');
		$val->set_rules('jenisobat', 'Jenis Obat', 'trim|required|xss_clean');
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
				'KD_JNS_OBT' => $val->set_value('kdjnsobat'),
				'JENIS_OBAT' => $val->set_value('jenisobat'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('KD_JNS_OBT',$id);
			$db->update('apt_mst_jenis_obat', $dataexc);
			
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
		$val = $db->query("select * from apt_mst_jenis_obat where KD_JNS_OBT = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterJenisobat/v_master_jenis_obat_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from apt_mst_jenis_obat where KD_JNS_OBT = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from apt_mst_jenis_obat where KD_JNS_OBT = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('masterJenisobat/v_master_jenis_obat_detail',$data);
	}
	
}

/* End of file masteruser.php */
/* Location: ./application/controllers/masteruser.php */