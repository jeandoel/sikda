<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_posisi extends CI_Controller {
	public function index()
	{
		$this->load->view('masterPosisi/v_master_posisi');
	}
	
	public function posisipopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('masterPosisi/v_master_posisi_popup',$data);
	}
	
	public function masterposisixml()
	{
		$this->load->model('m_master_posisi');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'nama'=>$this->input->post('nama')
					);
					
		$total = $this->m_master_posisi->totalMasterposisi($paramstotal);
		
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
					
		$result = $this->m_master_posisi->getMasterposisi($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterPosisi/v_master_posisi_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kode_posisi', 'Kode Posisi', 'trim|required|xss_clean|min_length[1]|max_length[2]');
		$val->set_rules('nama_posisi', 'Posisi', 'trim|required|xss_clean|min_length[3]');
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
				'KD_POSISI' => $val->set_value('kode_posisi'),
				'POSISI' => $val->set_value('nama_posisi'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('mst_posisi', $dataexc);
			
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
		$val->set_rules('kode_posisi', 'Kode Posisi', 'trim|required|xss_clean|min_length[1]|max_length[2]');
		$val->set_rules('nama_posisi', 'Posisi', 'trim|required|xss_clean|min_length[3]');

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
				'KD_POSISI' => $val->set_value('kode_posisi'),
				'POSISI' => $val->set_value('nama_posisi'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->where('KD_POSISI',$id);
			$db->update('mst_posisi', $dataexc);
			
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
		$val = $db->query("select * from mst_posisi where KD_POSISI = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterPosisi/v_master_posisi_edit',$data);//print_r($data);die();
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_posisi where KD_POSISI = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_posisi where KD_POSISI = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('masterPosisi/v_master_posisi_detail',$data);
	}
	
}

/* End of file c_master_posisi.php */
/* Location: ./application/controllers/c_master_posisi.php */