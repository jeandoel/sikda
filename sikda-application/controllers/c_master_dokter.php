<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_dokter extends CI_Controller {
	public function index()
	{
		$this->load->view('masterDokter/v_master_dokter');
	}
	
	public function masterdokterpopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('masterDokter/v_master_dokter_popup',$data);
	}
	
	public function masterdokterxml()
	{
		$this->load->model('m_master_dokter');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					);
					
		$total = $this->m_master_dokter->totalmasterdokter($paramstotal);
		
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
					'carinama'=>$this->input->post('carinama')
					);
					
		$result = $this->m_master_dokter->getmasterdokter($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterDokter/v_master_dokter_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kd_dokter', 'Kode Dokter', 'trim|required|xss_clean|min_length[1]');
		$val->set_rules('nama', 'Nama', 'trim|required|xss_clean|min_length[2]');
		$val->set_rules('nip', 'NIP', 'trim|required|xss_clean');
		$val->set_rules('jabatan', 'Jabatan', 'trim|required|xss_clean');
		$val->set_rules('status', 'Status', 'trim|required|xss_clean');
		$val->set_rules('kd_puskesmas', 'Kode Puskesmas', 'trim|required|xss_clean|min_length[10]|max_length[12]');
				
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
				'KD_DOKTER' => $val->set_value('kd_dokter'),
				'NAMA' => $val->set_value('nama'),
				'NIP' => $val->set_value('nip'),
				'JABATAN' => $val->set_value('jabatan'),
				'STATUS' => $val->set_value('status'),
				'KD_PUSKESMAS' => $val->set_value('kd_puskesmas'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('mst_dokter', $dataexc);
			
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
		$val->set_rules('kd_dokter', 'Kode Dokter', 'trim|required|xss_clean|min_length[1]');
		$val->set_rules('nama', 'Nama', 'trim|required|xss_clean|min_length[2]');
		$val->set_rules('nip', 'NIP', 'trim|required|xss_clean');
		$val->set_rules('jabatan', 'Jabatan', 'trim|required|xss_clean');
		$val->set_rules('status', 'Status', 'trim|required|xss_clean');
		$val->set_rules('kd_puskesmas', 'Kode Puskesmas', 'trim|required|xss_clean|min_length[10]|max_length[12]');
				
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
				'KD_DOKTER' => $val->set_value('kd_dokter'),
				'NAMA' => $val->set_value('nama'),
				'NIP' => $val->set_value('nip'),
				'JABATAN' => $val->set_value('jabatan'),
				'STATUS' => $val->set_value('status'),
				'KD_PUSKESMAS' => $val->set_value('kd_puskesmas'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('KD_DOKTER',$id);
			$db->update('mst_dokter', $dataexc);
			
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
		$db->select('a.*,b.PUSKESMAS');
		$db->from('mst_dokter a');
		$db->join('mst_puskesmas b','a.KD_PUSKESMAS=b.KD_PUSKESMAS');
		$db->where('a.KD_DOKTER', $id);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('masterDokter/v_master_dokter_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_dokter where KD_DOKTER = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select('a.*,b.PUSKESMAS');
		$db->from('mst_dokter a');
		$db->join('mst_puskesmas b','a.KD_PUSKESMAS=b.KD_PUSKESMAS');
		$db->where('a.KD_DOKTER', $id);
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('masterDokter/v_master_dokter_detail',$data);
	}
	
}

/* End of file c_master_dokter.php */
/* Location: ./application/controllers/c_master_dokter.php */