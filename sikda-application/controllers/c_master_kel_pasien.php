<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_kel_pasien extends CI_Controller {
	public function index()
	{
		$this->load->view('masterKelpasien/v_master_kel_pasien');
	}
	
	public function masterKelpasienpopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('masterKelpasien/v_master_kel_pasien_popup',$data);
	}
	
	public function kelpasienxml()
	{
		$this->load->model('m_master_kel_pasien');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'nama'=>$this->input->post('nama')
					);
					
		$total = $this->m_master_kel_pasien->totalKelpasien($paramstotal);
		
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
					
		$result = $this->m_master_kel_pasien->getKelpasien($params);
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterKelpasien/v_master_kel_pasien_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kd_cus', 'KODE CUSTEMER', 'trim|required|xss_clean');
		$val->set_rules('cus', 'CUSTEMER', 'trim|required|xss_clean');
		$val->set_rules('tlp1', 'TELEPON');
				
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
				'KD_CUSTOMER' => $val->set_value('kd_cus'),
				'CUSTOMER' => $val->set_value('cus'),
				'TELEPON1' => $val->set_value('tlp1'),
				'ninput_kel_pasien_oleh' => $this->session->userdata('nusername'),
				'ninput_kel_pasien_tgl' => date('Y-m-d H:i:s')
			);///echo '<pre>';print_r($dataexc);die('zdfg');
		
			$db->insert('mst_kel_pasien', $dataexc);
			
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
		$id = $this->input->post('cus1',TRUE);		
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kd_cus', 'KODE CUSTEMER', 'trim|required|xss_clean');
		$val->set_rules('cus', 'CUSTEMER', 'trim|required|xss_clean');
		$val->set_rules('tlp1', 'TELEPON');
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
				'KD_CUSTOMER' => $val->set_value('kd_cus'),
				'CUSTOMER' => $val->set_value('cus'),
				'TELEPON1' => $val->set_value('tlp1'),
				'nupdate_kel_pasien_oleh' => $this->session->userdata('nusername'),
				'nupdate_kel_pasien_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('KD_CUSTOMER',$id);
			$db->update('mst_kel_pasien', $dataexc);
			
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
		$id=$this->input->get('kd_cus')?$this->input->get('kd_cus',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select KD_CUSTOMER,CUSTOMER,TELEPON1 from mst_kel_pasien where KD_CUSTOMER = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterKelpasien/v_master_kel_pasien_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_kel_pasien where KD_CUSTOMER = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('kd_cus')?$this->input->get('kd_cus',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select KD_CUSTOMER,CUSTOMER,TELEPON1 from mst_kel_pasien where KD_CUSTOMER = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('masterKelpasien/v_master_kel_pasien_detail',$data);
	}
	
}

/* End of file master1.php */
/* Location: ./application/controllers/master1.php */
