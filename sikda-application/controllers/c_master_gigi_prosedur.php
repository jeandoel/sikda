<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_gigi_prosedur extends CI_Controller {
	public function index()
	{
		$this->load->view('masterGigiprosedur/v_master_gigi_prosedur');
	}
	
	public function masterPopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$data['idprov'] = $this->input->get('kd_prov')?$this->input->get('kd_prov',TRUE):null;
		$this->load->view('masterGigiprosedur/v_master_gigi_pop',$data);
	}
	
	public function masterXml($for_dialog=NULL)
	{
		$this->load->model('m_master_gigi_prosedur');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'kd_prosedur_gigi'=>$this->input->post('kd_prosedur_gigi'),
					'prosedur'=>$this->input->post('prosedur')
					);
					
		$total = $this->m_master_gigi_prosedur->totalMaster($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'kd_prosedur_gigi'=>$this->input->post('kd_prosedur_gigi'),
					'prosedur'=>$this->input->post('prosedur'),
					'for_dialog'=>$for_dialog
					);
					
		$result = $this->m_master_gigi_prosedur->getMaster($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterGigiprosedur/v_master_gigi_prosedur_add');
	}
	
	public function addprocess()
	{	
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kd_prosedur_gigi', 'Kode Prosedur Gigi', 'trim|required|xss_clean|min_length[1]');
		$val->set_rules('prosedur', 'Prosedur Gigi', 'trim|required|xss_clean|min_length[1]');
		$val->set_rules('deskripsi', 'deskripsi');
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
				'kd_prosedur_gigi' => $val->set_value('kd_prosedur_gigi'),
				'prosedur' => $val->set_value('prosedur'),
				'deskripsi' => $val->set_value('deskripsi')
			);
			
			$db->insert('mst_gigi_prosedur', $dataexc);
			
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
		$val->set_rules('kd_prosedur_gigi', 'Kode Prosedur Gigi', 'trim|required|xss_clean|min_length[1]');
		$val->set_rules('prosedur', 'Prosedur Gigi', 'trim|required|xss_clean|min_length[1]');
		$val->set_rules('deskripsi', 'deskripsi');
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
				'kd_prosedur_gigi' => $val->set_value('kd_prosedur_gigi'),
				'prosedur' => $val->set_value('prosedur'),
				'deskripsi' => $val->set_value('deskripsi')
			);
			
			$db->where('kd_prosedur_gigi',$kd);
			$db->update('mst_gigi_prosedur', $dataexc);
			
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
		$kd_prosedur_gigi=$this->input->get('kd_prosedur_gigi')?$this->input->get('kd_prosedur_gigi',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_gigi_prosedur where kd_prosedur_gigi = '".$kd_prosedur_gigi."'")->row();
		$data['data']=$val;		
		$this->load->view('masterGigiprosedur/v_master_gigi_prosedur_edit',$data);//print_r($data);die();
	}
	
	public function delete()
	{
		$kd_prosedur_gigi=$this->input->post('kd_prosedur_gigi')?$this->input->post('kd_prosedur_gigi',TRUE):null;

		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_gigi_prosedur where kd_prosedur_gigi = '".$kd_prosedur_gigi."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$kd_prosedur_gigi=$this->input->get('kd_prosedur_gigi')?$this->input->get('kd_prosedur_gigi',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_gigi_prosedur where kd_prosedur_gigi = '".$kd_prosedur_gigi."'")->row();
		$data['data']=$val;
		$this->load->view('masterGigiprosedur/v_master_gigi_prosedur_detail',$data);
	}
	
}

/* End of file c_master_asal_pasien.php */
/* Location: ./application/controllers/c_master_asal_pasien.php */