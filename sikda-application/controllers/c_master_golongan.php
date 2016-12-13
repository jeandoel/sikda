<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_golongan extends CI_Controller {
	public function index()
	{
		$this->load->view('masterGolonganpetugas/v_master_golongan_petugas');
	}
	
	public function mastergolonganpopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('masterGolonganpetugas/v_master_golongan_petugas_popup',$data);
	}
	
	public function golonganxml()
	{
		$this->load->model('m_master_golongan');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'nama'=>$this->input->post('nama')
					);
					
		$total = $this->m_master_golongan->totalGolongan($paramstotal);
		
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
					
		$result = $this->m_master_golongan->getGolongan($params);
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterGolonganpetugas/v_master_golongan_petugas_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kd_golongan', 'KODE GOLONGAN', 'trim|required|xss_clean');
		$val->set_rules('nama_golongan', 'NAMA GOLONGAN', 'trim|required|xss_clean');
				
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
				'KD_GOLONGAN' => $val->set_value('kd_golongan'),
				'NM_GOLONGAN' => $val->set_value('nama_golongan'),
				'ninput_golongan_oleh' => $this->session->userdata('nusername'),
				'ninput_golongan_tgl' => date('Y-m-d H:i:s')
			);///echo '<pre>';print_r($dataexc);die('zdfg');
		
			$db->insert('mst_golongan', $dataexc);
			
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
		$id = $this->input->post('kd_gol',TRUE);		
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kd_golongan', 'KODE GOLONGAN', 'trim|required|xss_clean');
		$val->set_rules('nama_golongan', 'NAMA GOLONGAN', 'trim|required|xss_clean');
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
				'KD_GOLONGAN' => $val->set_value('kd_golongan'),
				'NM_GOLONGAN' => $val->set_value('nama_golongan'),
				'nupdate_golongan_oleh' => $this->session->userdata('nusername'),
				'nupdate_golongan_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('KD_GOLONGAN',$id);
			$db->update('mst_golongan', $dataexc);
			
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
		$id=$this->input->get('kd_golongan')?$this->input->get('kd_golongan',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_golongan where KD_GOLONGAN = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterGolonganpetugas/v_master_golongan_petugas_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_golongan where KD_GOLONGAN = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('kd_golongan')?$this->input->get('kd_golongan',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_golongan where KD_GOLONGAN = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('masterGolonganpetugas/v_master_golongan_petugas_detail',$data);
	}
	
}

/* End of file master1.php */
/* Location: ./application/controllers/master1.php */