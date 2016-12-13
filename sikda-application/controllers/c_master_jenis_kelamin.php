<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_jenis_kelamin extends CI_Controller {
	public function index()
	{
		$this->load->view('masterJeniskelamin/v_master_jenis_kelamin');
	}
        
       
	public function jeniskelaminxml()
	{
		$this->load->model('m_master_jenis_kelamin');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari')
					);
					
		$total = $this->m_master_jenis_kelamin->totalMasterjk($paramstotal);
		
		
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
					'keyword'=>$this->input->post('keyword'),
					'cari' =>$this->input->post('cari')
					);
					
		$result = $this->m_master_jenis_kelamin->getMasterjk($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterJeniskelamin/v_master_jenis_kelamin_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kode_jenis_kelamin', 'Kode Jenis Kelamin', 'trim|required|xss_clean|min_length[1]|max_length[2]');
		$val->set_rules('jenis_kelamin', 'Jenis Kelamin', 'trim|required|xss_clean|min_length[1]|max_length[15]');
		
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
				'KD_JENIS_KELAMIN' => $val->set_value('kode_jenis_kelamin'),
				'JENIS_KELAMIN' => $val->set_value('jenis_kelamin'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('mst_jenis_kelamin', $dataexc);
			
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
		$kd = $this->input->post('kd',TRUE);		
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kode_jenis_kelamin', 'Kode Jenis Kelamin', 'trim|required|xss_clean|min_length[1]|max_length[2]');
		$val->set_rules('jenis_kelamin', 'Jenis Kelamin', 'trim|required|xss_clean|min_length[1]|max_length[15]');
		
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
				'KD_JENIS_KELAMIN' => $val->set_value('kode_jenis_kelamin'),
				'JENIS_KELAMIN' => $val->set_value('jenis_kelamin'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('KD_JENIS_KELAMIN',$kd);
			$db->update('mst_jenis_kelamin', $dataexc);
			
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
		$kd=$this->input->get('kd')?$this->input->get('kd',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_jenis_kelamin where KD_JENIS_KELAMIN= '".$kd."'")->row();
		$data['data']=$val;		
		$this->load->view('masterJeniskelamin/v_master_jenis_kelamin_edit',$data);
	}
	
	public function delete()
	{
		$kd=$this->input->post('kd')?$this->input->post('kd',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_jenis_kelamin where KD_JENIS_KELAMIN= '".$kd."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$kd=$this->input->get('kd')?$this->input->get('kd',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_jenis_kelamin where KD_JENIS_KELAMIN = '".$kd."'")->row();
		$data['data']=$val;
		$this->load->view('masterJeniskelamin/v_master_jenis_kelamin_detail',$data);
                //print_r($data);die;
	}
	
}
