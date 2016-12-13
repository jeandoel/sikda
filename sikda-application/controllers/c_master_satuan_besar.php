<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_satuan_besar extends CI_Controller {
	public function index()
	{
		$this->load->view('masterSatuanbesar/v_master_satuan_besar');
	}
	
	public function mastersatuanbesarpopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('masterSatuanbesar/v_master_satuan_besar_popup',$data);
	}
	
	public function mastersatuanbesarxml()
	{
		$this->load->model('m_master_satuan_besar');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'satuan'=>$this->input->post('satuan')
					);
					
		$total = $this->m_master_satuan_besar->totalMastersatuanbesar($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'satuan'=>$this->input->post('satuan')
					);
					
		$result = $this->m_master_satuan_besar->getMastersatuanbesar($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterSatuanbesar/v_master_satuan_besar_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kdsatbesar', 'Kode Satuan Besar', 'trim|required|xss_clean');
		$val->set_rules('satbesarobat', 'Satuan Besar Obat', 'trim|required|xss_clean');
		
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
				'KD_SAT_BESAR' => $val->set_value('kdsatbesar'),
				'SAT_BESAR_OBAT' => $val->set_value('satbesarobat'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('apt_mst_sat_besar', $dataexc);
			
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
		$val->set_rules('kdsatbesar', 'Kode Satuan Besar', 'trim|required|xss_clean');
		$val->set_rules('satbesarobat', 'Satuan Besar Obat', 'trim|required|xss_clean');
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
				'KD_SAT_BESAR' => $val->set_value('kdsatbesar'),
				'SAT_BESAR_OBAT' => $val->set_value('satbesarobat'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('KD_SAT_BESAR',$id);
			$db->update('apt_mst_sat_besar', $dataexc);
			
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
		$val = $db->query("select * from apt_mst_sat_besar where KD_SAT_BESAR = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterSatuanbesar/v_master_satuan_besar_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from apt_mst_sat_besar where KD_SAT_BESAR = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from apt_mst_sat_besar where KD_SAT_BESAR = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('masterSatuanbesar/v_master_satuan_besar_detail',$data);
	}
	
}

/* End of file masteruser.php */
/* Location: ./application/controllers/masteruser.php */