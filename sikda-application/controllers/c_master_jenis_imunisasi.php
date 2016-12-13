<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_jenis_imunisasi extends CI_Controller {
	public function index()
	{
		$this->load->view('masterJenisimunisasi/v_master_jenis_imunisasi');
	}
	
	public function jenisimunisasixml()
	{
		$this->load->model('m_master_jenis_imunisasi');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'carijenisimunisasi'=>$this->input->post('carijenisimunisasi')
					);
					
		$total = $this->m_master_jenis_imunisasi->totalJenisimunisasi($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'carijenisimunisasi'=>$this->input->post('carijenisimunisasi')
					);
					
		$result = $this->m_master_jenis_imunisasi->getJenisimunisasi($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterJenisimunisasi/v_master_jenis_imunisasi_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');
		$val = $this->form_validation;
		//$val->set_rules('kodejenisimunisasi', 'Kode Jenis Imunisasi', 'trim|required|xss_clean');
		$val->set_rules('jenisimunisasi', 'Jenis Imunisasi', 'trim|required|xss_clean');
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
				//'KD_JENIS_IMUNISASI' => $val->set_value('kodejenisimunisasi'),
				'JENIS_IMUNISASI' => $val->set_value('jenisimunisasi'),
				'Created_By' => $this->session->userdata('nusername'),
				'Created_Date' => date('Y-m-d H:i:s')
			);
			
			$db->insert('mst_jenis_imunisasi', $dataexc);
			
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
		//$val->set_rules('kodejenisimunisasi', 'Kode Jenis Imunisasi', 'trim|required|xss_clean');
		$val->set_rules('jenisimunisasi', 'Jenis Imunisasi', 'trim|required|xss_clean');
		
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
				//'KD_jenis_imunisasi' => $val->set_value('kodekategoriimunisasi'),
				'JENIS_IMUNISASI' => $val->set_value('jenisimunisasi'),
				'Updated_By' => $this->session->userdata('nusername'),
				'Updated_Date' => date('Y-m-d H:i:s')
			);			
			
			$db->where('KD_JENIS_IMUNISASI',$id);
			$db->update('mst_jenis_imunisasi', $dataexc);
			
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
		$val = $db->query("select * from mst_jenis_imunisasi where KD_JENIS_IMUNISASI = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterJenisimunisasi/v_master_jenis_imunisasi_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_jenis_imunisasi where KD_JENIS_IMUNISASI = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_jenis_imunisasi where KD_JENIS_IMUNISASI = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterJenisimunisasi/v_master_jenis_imunisasi_detail',$data);
	}
	
}

/* End of file c_master_jenis_imunisasi.php */
/* Location: ./application/controllers/c_master_jenis_imunisasi.php */