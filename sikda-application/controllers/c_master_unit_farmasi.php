<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_unit_farmasi extends CI_Controller {
	public function index()
	{
		$this->load->view('masterUnitfarmasi/v_master_unit_farmasi');
	}
	
	
	public function master_unitfarmasixml()
	{
		$this->load->model('m_master_unit_farmasi');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'kodeunitfarmasi'=>$this->input->post('kodeunitfarmasi')
					);
					
		$total = $this->m_master_unit_farmasi->totalmaster_unitfarmasi($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'kodeunitfarmasi'=>$this->input->post('kodeunitfarmasi')
					);
					
		$result = $this->m_master_unit_farmasi->getMaster_unitfarmasi($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterUnitfarmasi/v_master_unit_farmasi_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');
		$val = $this->form_validation;
		$val->set_rules('kodeunitfarmasi', 'Kode Unit Farmasi', 'trim|required|xss_clean');
		$val->set_rules('unitfarmasi', 'Unit Farmasi', 'trim|required|xss_clean');
		$val->set_rules('farmasiutama', 'Farmasi Utama', 'trim|required|xss_clean');
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
				'KD_UNIT_FAR' => $val->set_value('kodeunitfarmasi'),
				'NAMA_UNIT_FAR' => $val->set_value('unitfarmasi'),
				'FAR_UTAMA' => $val->set_value('farmasiutama'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('apt_mst_unit', $dataexc);
			
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
		$id = $this->input->post('kodeunitfarmasiid',TRUE);		
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kodeunitfarmasi', 'Kode Unit Farmasi', 'trim|required|xss_clean');
		$val->set_rules('unitfarmasi', 'Unit Farmasi', 'trim|required|xss_clean');
		$val->set_rules('farmasiutama', 'Farmasi Utama', 'trim|required|xss_clean');
		
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
				'KD_UNIT_FAR' => $val->set_value('kodeunitfarmasi'),
				'NAMA_UNIT_FAR' => $val->set_value('unitfarmasi'),
				'FAR_UTAMA' => $val->set_value('farmasiutama'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('KD_UNIT_FAR',$id);
			$db->update('apt_mst_unit', $dataexc);
			
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
		$id=$this->input->get('kodeunitfarmasi')?$this->input->get('kodeunitfarmasi',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from apt_mst_unit where KD_UNIT_FAR = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterUnitfarmasi/v_master_unit_farmasi_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('kodeunitfarmasi')?$this->input->post('kodeunitfarmasi',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from apt_mst_unit where KD_UNIT_FAR = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('kodeunitfarmasi')?$this->input->get('kodeunitfarmasi',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from apt_mst_unit where KD_UNIT_FAR = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterUnitfarmasi/v_master_unit_farmasi_detail',$data);
	}
	
}

/* End of file master_kecamatan.php */
/* Location: ./application/controllers/c_master_kecamatan.php */
