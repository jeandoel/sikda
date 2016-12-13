<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_vaksin extends CI_Controller {
	public function index()
	{
		$this->load->view('masterVaksin/v_master_vaksin');
	}
	
	public function vaksinpopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('masterVaksin/v_master_vaksin_popup',$data);
	}
	
	public function mastervaksinxml()
	{
		$this->load->model('m_master_vaksin');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'nama'=>$this->input->post('nama')
					);
					
		$total = $this->m_master_vaksin->totalMastervaksin($paramstotal);
		
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
					
		$result = $this->m_master_vaksin->getMastervaksin($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterVaksin/v_master_vaksin_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kolom_kode', 'Kode', 'trim|required|xss_clean');
		$val->set_rules('kolom_nama', 'Nama', 'trim|required|xss_clean');
		$val->set_rules('kolom_golongan', 'Golongan', 'trim|required|xss_clean');
		$val->set_rules('kolom_sumber', 'Sumber', 'trim|required|xss_clean');
		$val->set_rules('kolom_satuan', 'Satuan', 'trim|required|xss_clean');
		
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
				'nkode_vaksin' => $val->set_value('kolom_kode'),
				'nnama_vaksin' => $val->set_value('kolom_nama'),
				'ngolongan' => $val->set_value('kolom_golongan'),
				'nsumber' => $val->set_value('kolom_sumber'),
				'nsatuan' => $val->set_value('kolom_satuan'),
				'ntgl_master_vaksin' => date("Y-m-d", strtotime($this->input->post('tglmastervaksin',TRUE))),
				'ninput_vaksin_oleh' => $this->session->userdata('nusername'),
				'ninput_vaksin_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('tbl_master_vaksin', $dataexc);
			
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
		$val->set_rules('kolom_kode', 'Kode', 'trim|required|xss_clean');
		$val->set_rules('kolom_nama', 'Nama', 'trim|required|xss_clean');
		$val->set_rules('kolom_golongan', 'Golongan', 'trim|required|xss_clean');
		$val->set_rules('kolom_sumber', 'Sumber', 'trim|required|xss_clean');
		$val->set_rules('kolom_satuan', 'Satuan', 'trim|required|xss_clean');

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
				'nkode_vaksin' => $val->set_value('kolom_kode'),
				'nnama_vaksin' => $val->set_value('kolom_nama'),
				'ngolongan' => $val->set_value('kolom_golongan'),
				'nsumber' => $val->set_value('kolom_sumber'),
				'nsatuan' => $val->set_value('kolom_satuan'),
				'ntgl_master_vaksin' => $this->input->post('tglmastervaksin',TRUE),
				'nupdate_vaksin_oleh' => $this->session->userdata('nusername'),
				'nupdate_vaksin_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('nid_vaksin',$id);
			$db->update('tbl_master_vaksin', $dataexc);
			
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
		$val = $db->query("select * from tbl_master_vaksin where nid_vaksin = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterVaksin/v_master_vaksin_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from tbl_master_vaksin where nid_vaksin = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from tbl_master_vaksin where nid_vaksin = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('masterVaksin/v_master_vaksin_detail',$data);
	}
	
}

/* End of file c_master_vaksin.php */
/* Location: ./application/controllers/c_master_vaksin.php */