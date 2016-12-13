<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_gigi_masalah extends CI_Controller {
	public function index()
	{
		$this->load->view('masterGigimasalah/v_master_gigi_masalah');
	}
	
	public function masterPopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$data['idprov'] = $this->input->get('kd_prov')?$this->input->get('kd_prov',TRUE):null;
		$this->load->view('masterGigimasalah/v_master_gigi_pop',$data);
	}
	
	
	public function masterXml($for_dialog=NULL)
	{
		$this->load->model('m_master_gigi_masalah');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'kd_masalah_gigi'=>$this->input->post('kd_masalah_gigi'),
					'masalah'=>$this->input->post('masalah')
					);
					
		$total = $this->m_master_gigi_masalah->totalMaster($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'kd_masalah_gigi'=>$this->input->post('kd_masalah_gigi'),
					'masalah'=>$this->input->post('masalah'),
					'for_dialog'=>$for_dialog
					);
					
		$result = $this->m_master_gigi_masalah->getMaster($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterGigimasalah/v_master_gigi_masalah_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('masalah', 'masalah', 'trim|required|xss_clean|min_length[1]');
		$val->set_rules('deskripsi', 'Deskripsi');
		
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
				'masalah' => $val->set_value('masalah'),
				'DESKRIPSI' => $val->set_value('deskripsi')
			);
			
			$db->insert('mst_gigi_masalah', $dataexc);
			
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
		$val->set_rules('masalah', 'masalah', 'trim|required|xss_clean|min_length[1]');
		$val->set_rules('deskripsi', 'Deskripsi');
		
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
				'masalah' => $val->set_value('masalah'),
				'deskripsi' => $val->set_value('deskripsi'),
			);
			
			$db->where('kd_masalah_gigi',$id);
			$db->update('mst_gigi_masalah', $dataexc);
			
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
		$id=$this->input->get('kd_masalah_gigi')?$this->input->get('kd_masalah_gigi',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_gigi_masalah where kd_masalah_gigi = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterGigimasalah/v_master_gigi_masalah_edit',$data);//print_r($data);die();
	}
	
	public function delete()
	{
		$id=$this->input->post('kd_masalah_gigi')?$this->input->post('kd_masalah_gigi',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_gigi_masalah where kd_masalah_gigi = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$kd_masalah_gigi=$this->input->get('kd_masalah_gigi')?$this->input->get('kd_masalah_gigi',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_gigi_masalah where kd_masalah_gigi = '".$kd_masalah_gigi."'")->row();
		$data['data']=$val;
		$this->load->view('masterGigimasalah/v_master_gigi_masalah_detail',$data);
	}
	
}

/* End of file c_master_asal_pasien.php */
/* Location: ./application/controllers/c_master_asal_pasien.php */