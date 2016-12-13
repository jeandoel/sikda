<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_tempat extends CI_Controller {
	public function index()
	{
		$this->load->view('masterTempat/v_master_tempat');
	}
	
	public function mastertempatxml()
	{
		$this->load->model('m_master_tempat');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'nama'=>$this->input->post('nama')
					);
					
		$total = $this->m_master_tempat->totalMastertempat($paramstotal);
		
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
					'nama'=>$this->input->post('nama')
					);
					
		$result = $this->m_master_tempat->getMastertempat($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterTempat/v_master_tempat_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kolom_kode_tempat', 'Kode', 'trim|required|xss_clean');
		$val->set_rules('kolom_nama_tempat', 'Nama', 'trim|required|xss_clean');
		$val->set_rules('kolom_jenis_tempat', 'Jenis', 'trim|required|xss_clean');
		$val->set_rules('kolom_no_telp', 'No. Telp', 'trim|required|xss_clean');
		$val->set_rules('kolom_pengelola_tempat', 'Pengelola', 'trim|required|xss_clean');
		$val->set_rules('kolom_id_wilayah', 'ID Wilayah', 'trim|required|xss_clean');
		
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
				'nkode_tempat' => $val->set_value('kolom_kode_tempat'),
				'nnama_tempat' => $val->set_value('kolom_nama_tempat'),
				'njenis_tempat' => $val->set_value('kolom_jenis_tempat'),
				'nno_telp_tempat' => $val->set_value('kolom_no_telp'),
				'npengelola_tempat' => $val->set_value('kolom_pengelola_tempat'),
				'nid_wilayah' => $val->set_value('kolom_id_wilayah'),
				'ntgl_master_tempat' => date("Y-m-d", strtotime($this->input->post('tglmastertempat',TRUE))),
				'ninput_tempat_oleh' => $this->session->userdata('nusername'),
				'ninput_tempat_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('tbl_master_tempat', $dataexc);
			
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
		$val->set_rules('kolom_kode_tempat', 'Kode', 'trim|required|xss_clean');
		$val->set_rules('kolom_nama_tempat', 'Nama', 'trim|required|xss_clean');
		$val->set_rules('kolom_jenis_tempat', 'Jenis', 'trim|required|xss_clean');
		$val->set_rules('kolom_no_telp', 'No. Telp', 'trim|required|xss_clean');
		$val->set_rules('kolom_pengelola_tempat', 'Pengelola', 'trim|required|xss_clean');
		$val->set_rules('kolom_id_wilayah', 'ID Wilayah', 'trim|required|xss_clean');

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
				'nkode_tempat' => $val->set_value('kolom_kode_tempat'),
				'nnama_tempat' => $val->set_value('kolom_nama_tempat'),
				'njenis_tempat' => $val->set_value('kolom_jenis_tempat'),
				'nno_telp_tempat' => $val->set_value('kolom_no_telp'),
				'npengelola_tempat' => $val->set_value('kolom_pengelola_tempat'),
				'nid_wilayah' => $val->set_value('kolom_id_wilayah'),
				'ntgl_master_tempat' => $this->input->post('tglmastertempat',TRUE),
				'nupdate_tempat_oleh' => $this->session->userdata('nusername'),
				'nupdate_tempat_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('nid_reg_tempat',$id);
			$db->update('tbl_master_tempat', $dataexc);
			
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
		$val = $db->query("select * from tbl_master_tempat where nid_reg_tempat = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterTempat/v_master_tempat_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from tbl_master_tempat where nid_reg_tempat = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from tbl_master_tempat where nid_reg_tempat = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('masterTempat/v_master_tempat_detail',$data);
	}
	
}

/* End of file c_master_tempat.php */
/* Location: ./application/controllers/c_master_tempat.php */