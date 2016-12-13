<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_kategori_imunisasi extends CI_Controller {
	public function index()
	{
		$this->load->view('masterKategoriimunisasi/v_master_kategori_imunisasi');
	}
	
	
	public function kategoriimunisasixml()
	{
		$this->load->model('m_master_kategori_imunisasi');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'carikategori'=>$this->input->post('carikategori')
					);
					
		$total = $this->m_master_kategori_imunisasi->totalKategoriimunisasi($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'carikategori'=>$this->input->post('carikategori')
					);
					
		$result = $this->m_master_kategori_imunisasi->getKategoriimunisasi($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterKategoriimunisasi/v_master_kategori_imunisasi_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');
		$val = $this->form_validation;
		//$val->set_rules('kodekategoriimunisasi', 'Kode Kategori Imunisasi', 'trim|required|xss_clean');
		$val->set_rules('kategoriimunisasi', 'Kategori Imunisasi', 'trim|required|xss_clean');
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
				//'KD_KATEGORI_IMUNISASI' => $val->set_value('kodekategoriimunisasi'),
				'KATEGORI_IMUNISASI' => $val->set_value('kategoriimunisasi'),
				'Created_By' => $this->session->userdata('nusername'),
				'Created_Date' => date('Y-m-d H:i:s')
			);
			
			$db->insert('mst_kategori_jenis_lokasi_imunisasi', $dataexc);
			
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
		//$val->set_rules('kodekategoriimunisasi', 'Kode Kategori Imunisasi', 'trim|required|xss_clean');
		$val->set_rules('kategoriimunisasi', 'Kategori Imunisasi', 'trim|required|xss_clean');
		
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
				//'KD_KATEGORI_IMUNISASI' => $val->set_value('kodekategoriimunisasi'),
				'KATEGORI_IMUNISASI' => $val->set_value('kategoriimunisasi'),
				'Updated_By' => $this->session->userdata('nusername'),
				'Updated_Date' => date('Y-m-d H:i:s')
			);			
			
			$db->where('KD_KATEGORI_IMUNISASI',$id);
			$db->update('mst_kategori_jenis_lokasi_imunisasi', $dataexc);
			
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
		$val = $db->query("select * from mst_kategori_jenis_lokasi_imunisasi where KD_KATEGORI_IMUNISASI = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterKategoriimunisasi/v_master_kategori_imunisasi_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_kategori_jenis_lokasi_imunisasi where KD_KATEGORI_IMUNISASI = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_kategori_jenis_lokasi_imunisasi where KD_KATEGORI_IMUNISASI = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterKategoriimunisasi/v_master_kategori_imunisasi_detail',$data);
	}
	
}

/* End of file c_master_kategori_imunisasi.php */
/* Location: ./application/controllers/c_master_kategori_imunisasi.php */