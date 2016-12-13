<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_petugas extends CI_Controller {
	public function index()
	{
		
		$this->load->view('masterPetugas/v_master_petugas');
	}
	
	public function petugasxml()
	{
		$this->load->model('m_master_petugas');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'nama'=>$this->input->post('nama')
					);
					
		$total = $this->m_master_petugas->totalPetugas($paramstotal);
		
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
					
		$result = $this->m_master_petugas->getPetugas($params);
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$db = $this->load->database('sikda',true);
		$unit = $db->query ("select * from mst_unit")->result_array();
		$data['unit'] = $unit;
		
		$this->load->view('masterPetugas/v_master_petugas_add',$data);
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kdpetugas', 'KODE PETUGAS', 'trim|required|xss_clean');
		$val->set_rules('nmpetugas', 'NAMA PETUGAS', 'trim|required|xss_clean');
		$val->set_rules('unit', 'UNIT', 'trim|required|xss_clean');

		
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
				'Kd_Petugas' => $val->set_value('kdpetugas'),
				'Nm_Petugas' => $val->set_value('nmpetugas'),
				'Unit' => $val->set_value('unit'),
				'ninput_petugas_oleh' => $this->session->userdata('nusername'),
				'ninput_petugas_tgl' => date('Y-m-d H:i:s')
			);
		
			$db->insert('mst_petugas', $dataexc);
			
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
		$val->set_rules('kdpetugas', 'KODE PETUGAS', 'trim|required|xss_clean');
		$val->set_rules('nmpetugas', 'NAMA PETUGAS', 'trim|required|xss_clean');
		$val->set_rules('unit', 'UNIT', 'trim|required|xss_clean');
		
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
				'Kd_Petugas' => $val->set_value('kdpetugas'),
				'Nm_Petugas' => $val->set_value('nmpetugas'),
				'Unit' => $val->set_value('unit'),
				'nupdate_petugas_oleh' => $this->session->userdata('nusername'),
				'nupdate_petugas_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('Kd_Petugas',$id);
			$db->update('mst_petugas', $dataexc);
			
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
		$val = $db->query("select * from mst_petugas where Kd_Petugas = '".$id."'")->row();
		$unit = $db->query ("select * from mst_unit")->result_array();
		$data['unit'] = $unit;
		$data['data'] = $val;		
		$this->load->view('masterPetugas/v_master_petugas_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_petugas where Kd_Petugas = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_petugas where Kd_Petugas = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('masterPetugas/v_master_petugas_detail',$data);
	}
	
}

/* End of file master1.php */
/* Location: ./application/controllers/master1.php */
