<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_gigi_permukaan extends CI_Controller {

	public function index()
	{
		$this->load->view('masterGigipermukaan/v_master_gigi_permukaan');
	}

	public function masterPopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('masterGigipermukaan/v_master_gigi_pop',$data);
	}
	
	public function masterXml($for_dialog=NULL)
	{
		$this->load->model('m_master_gigi_permukaan');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'kode'=>$this->input->post('kode'),
					'nama'=>$this->input->post('nama')
					);
					
		$total = $this->m_master_gigi_permukaan->totalMaster($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'kode'=>$this->input->post('kode'),
					'nama'=>$this->input->post('nama'),
					'for_dialog'=>$for_dialog
					);
					
		$result = $this->m_master_gigi_permukaan->getMaster($params);	
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function addprocess()
	{
		$temp_id = $this->input->post('kd',TRUE);		
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kode', 'Kode', 'trim|required|xss_clean|min_length[1]');
		$val->set_rules('nama', 'Nama Gigi', 'trim|required|xss_clean|min_length[1]');
		$val->set_message('required', "Silahkan isi field \"%s\"");

		//check double kode gigi
		$db = $this->load->database('sikda', TRUE);

		$check_kode = $this->input->post('kode');
		@$checking_kode = $db->query("select * from mst_gigi_permukaan where kode = '".$check_kode."'")->row();
		@$primary_kd = $checking_kode->KD_GIGI_PERMUKAAN;

		if ($val->run() == FALSE)
		{
			$val->set_error_delimiters('<div style="color:white">', '</div>');
			die(validation_errors());
		}else if(!empty($checking_kode) && empty($temp_id)){
			$val->set_error_delimiters('<div style="color:white">', '</div>');
			die("kode sudah digunakan. Gunakan kode lain.");
		}else if($primary_kd != $temp_id && !empty($checking_kode)){
			$val->set_error_delimiters('<div style="color:white">', '</div>');
			die("kode sudah digunakan. Gunakan kode lain.");
		}else
		{		
			$db->trans_begin();

            $dataexc = array(
            	'kode' => $val->set_value('kode'),
				'nama' => $val->set_value('nama')
			);

			if(empty($temp_id)){
				$db->insert('mst_gigi_permukaan', $dataexc);
			}else{
				$db->where('kd_gigi_permukaan',$temp_id);
				$db->update('mst_gigi_permukaan', $dataexc);
			}
			
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
	
	public function add()
	{
		$this->load->view('masterGigipermukaan/v_master_gigi_permukaan_add');
	}
	
	public function editprocess()
	{
		$this->addprocess();
	}

	public function getEditData(){
		$kd_gigi_permukaan=$this->input->get('kd_gigi_permukaan')?$this->input->get('kd_gigi_permukaan',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_gigi_permukaan where kd_gigi_permukaan = '".$kd_gigi_permukaan."'")->row();
		$data['data']=$val;	
		return $data;
	}
	
	public function edit()
	{
		$data = $this->getEditData();
		$this->load->view('masterGigipermukaan/v_master_gigi_permukaan_edit',$data);//print_r($data);die();
	}

	public function detail()
	{
		$data = $this->getEditData();
		$this->load->view('masterGigipermukaan/v_master_gigi_permukaan_detail',$data);
	}
	
	public function delete()
	{
		$kd_gigi_permukaan=$this->input->post('kd_gigi_permukaan')?$this->input->post('kd_gigi_permukaan',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$temp = $db->query("select * from mst_gigi_permukaan where kd_gigi_permukaan = '".$kd_gigi_permukaan."'")->row();
		if($db->query("delete from mst_gigi_permukaan where kd_gigi_permukaan = '".$kd_gigi_permukaan."'")){	
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
}

/* End of file c_master_asal_pasien.php */
/* Location: ./application/controllers/c_master_asal_pasien.php */