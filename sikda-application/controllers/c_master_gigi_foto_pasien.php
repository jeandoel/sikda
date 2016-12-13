<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_gigi_foto_pasien extends CI_Controller {
	public function index()
	{
		$this->load->view('masterGigifotopasien/v_master_gigi_foto_pasien');
	}
	
	public function gigipopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('masterGigi/v_master_gigi_popup',$data);
	}
	
	public function masterXml()
	{
		$this->load->model('m_master_gigi_foto_pasien');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'kd_foto_gigi'=>$this->input->post('kd_foto_gigi')
					);
					
		$total = $this->m_master_gigi_foto_pasien->totalMaster($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'kd_foto_gigi'=>$this->input->post('kd_foto_gigi')
					);
					
		$result = $this->m_master_gigi_foto_pasien->getMaster($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterGigifotopasien/v_master_gigi_foto_pasien_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kd_foto_gigi', 'Kode Foto Gigi', 'trim|required|xss_clean|min_length[2]|max_length[4]');
		$val->set_rules('gambar', 'gambar', 'trim|required|xss_clean|min_length[6]|max_length[18]');
		$val->set_rules('tipe', 'Tipe Gigi', 'trim|required|xss_clean|min_length[2]|max_length[4]');	
		$val->set_rules('tanggal', 'Tanggal', 'trim|required|xss_clean|min_length[6]|max_length[18]');
		$val->set_rules('kode_pasien', 'Kode Pasien', 'trim|required|xss_clean|min_length[2]|max_length[4]');
		$val->set_rules('kode_puskesmas', 'Kode Puskesmas', 'trim|required|xss_clean|min_length[6]|max_length[18]');
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
				'kd_foto_gigi' => $val->set_value('kode_gigi'),
				'gambar' => $val->set_value('gambar'),
				'tipe' => $val->set_value('tipe'),
				'tanggal' => $val->set_value('tanggal'),
				'kode_pasiend' => $val->set_value('kode_pasien'),
				'kode_puskesmas' => $val->set_value('kode_puskesmas')
			);
			
			$db->insert('mst_gigi_foto_pasien', $dataexc);
			
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
		$val->set_rules('kd_foto_gigi', 'Kode Photo Gigi', 'trim|required|xss_clean|min_length[2]|max_length[4]');
		$val->set_rules('gambar', 'gambar', 'trim|required|xss_clean|min_length[6]|max_length[18]');
		$val->set_rules('tipe', 'Tipe Gigi', 'trim|required|xss_clean|min_length[2]|max_length[4]');	
		$val->set_rules('tanggal', 'Tanggal', 'trim|required|xss_clean|min_length[6]|max_length[18]');
		$val->set_rules('kode_pasien', 'Kode Pasien', 'trim|required|xss_clean|min_length[2]|max_length[4]');
		$val->set_rules('kode_puskesmas', 'Kode Puskesmas', 'trim|required|xss_clean|min_length[6]|max_length[18]');
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
				'kode_gigi' => $val->set_value('kode_gigi'),
				'gambar' => $val->set_value('gambar'),
				'tipe' => $val->set_value('tipe'),
				'tanggal' => $val->set_value('tanggal'),
				'kode_pasiend' => $val->set_value('kode_pasien'),
				'kode_puskesmas' => $val->set_value('kode_puskesmas')
			);
			
			$db->where('id',$id);
			$db->update('mst_gigi_foto_pasien', $dataexc);
			
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
		$id=$this->input->get('kd_foto_gigi')?$this->input->get('kd_foto_gigi',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_gigi_foto_pasien where kd_foto_gigi = '".$kd_foto_gigi."'")->row();
		$data['data']=$val;		
		$this->load->view('masterGigifotopasien/v_master_gigi_foto_pasien_edit',$data);//print_r($data);die();
	}
	
	public function delete()
	{
		$id=$this->input->get('kd_foto_gigi')?$this->input->get('kd_foto_gigi',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_gigi_foto_pasien where kd_foto_gigi = '".$kd_foto_gigi."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('kd_foto_gigi')?$this->input->get('kd_foto_gigi',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_gigi_foto_pasien where kd_foto_gigi = '".$kd_foto_gigi."'")->row();
		$data['data']=$val;
		$this->load->view('masterGigifotopasien/v_master_gigi_foto_pasien_detail',$data);
	}
	
}

/* End of file c_master_asal_pasien.php */
/* Location: ./application/controllers/c_master_asal_pasien.php */