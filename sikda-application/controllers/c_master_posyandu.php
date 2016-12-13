<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_posyandu extends CI_Controller {
	public function index()
	{
		$this->load->view('masterPosyandu/v_master_posyandu');
	}
	
	public function posyanduxml()
	{
		$this->load->model('m_master_posyandu');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'nama'=>$this->input->post('nama')
					);
					
		$total = $this->m_master_posyandu->totalposyandu($paramstotal);
		
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
					
		$result = $this->m_master_posyandu->getposyandu($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterPosyandu/v_master_posyandu_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kodeposyandu', 'Kode Posyandu', 'trim|required|xss_clean');
		$val->set_rules('namaposyandu', 'Nama Posyandu', 'trim|required|xss_clean');
		$val->set_rules('alamatposyandu', 'Alamat Posyandu', 'trim|required|xss_clean');
		$val->set_rules('jumlahkader', 'Jumlah Kader', 'trim|required|xss_clean');
		
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
				'nkode_posyandu' => $val->set_value('kodeposyandu'),
				'nnama_posyandu' => $val->set_value('namaposyandu'),
				'nalamat_posyandu' => $val->set_value('alamatposyandu'),
				'njumlah_kader' => $val->set_value('jumlahkader'),
				'ntgl_posyandu' => date("Y-m-d", strtotime($this->input->post('tglposyandu',TRUE))),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('tbl_master_posyandu', $dataexc);
			
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
		$val->set_rules('kodeposyandu', 'Kode Posyandu', 'trim|required|xss_clean');
		$val->set_rules('namaposyandu', 'Nama Posyandu', 'trim|required|xss_clean');
		$val->set_rules('alamatposyandu', 'Alamat Posyandu', 'trim|required|xss_clean');
		$val->set_rules('jumlahkader', 'Jumlah Kader', 'trim|required|xss_clean');

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
				'nkode_posyandu' => $val->set_value('kodeposyandu'),
				'nnama_posyandu' => $val->set_value('namaposyandu'),
				'nalamat_posyandu' => $val->set_value('alamatposyandu'),
				'njumlah_kader' => $val->set_value('jumlahkader'),
				'ntgl_posyandu' => $this->input->post('tglposyandu',TRUE),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('nid_posyandu',$id);
			$db->update('tbl_master_posyandu', $dataexc);
			
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
		$val = $db->query("select * from tbl_master_posyandu where nid_posyandu = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterPosyandu/v_master_posyandu_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from tbl_master_posyandu where nid_posyandu = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from tbl_master_posyandu where nid_posyandu = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('masterPosyandu/v_master_posyandu_detail',$data);
	}
	
}

/* End of file C_master_posyandu.php */
/* Location: ./application/controllers/c_master_posyandu.php */