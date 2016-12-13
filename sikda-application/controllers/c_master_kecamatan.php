<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_kecamatan extends CI_Controller {
	public function index()
	{
		$this->load->view('masterKecamatan/v_master_kecamatan');
	}
	
	public function masterkecamatanpopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$data['idkab'] = $this->input->get('kd_kabkota')?$this->input->get('kd_kabkota',TRUE):null;
		$this->load->view('masterKecamatan/v_master_kecamatan_popup',$data);
	}
	
	public function master_kecamatanxml()
	{
		$this->load->model('m_master_kecamatan');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'kodekecamatan'=>$this->input->post('kodekecamatan'),
					'id'=>$this->input->post('idkab')
					);
					
		$total = $this->m_master_kecamatan->totalmaster_kecamatan($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'kodekecamatan'=>$this->input->post('kodekecamatan'),
					'id'=>$this->input->post('idkab')
					);
					
		$result = $this->m_master_kecamatan->getMaster_kecamatan($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterKecamatan/v_master_kecamatan_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kodekecamatan', 'Kode Kecamatan', 'trim|required|xss_clean|min_length[7]|max_length[7]');
		$val->set_rules('kodekabupaten', 'Kode Kabupaten', 'trim|required|xss_clean|min_length[4]|max_length[4]');
		$val->set_rules('kecamatan', 'Kecamatan', 'trim|required|xss_clean');
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
				'KD_KECAMATAN' => $val->set_value('kodekecamatan'),
				'KD_KABUPATEN' => $val->set_value('kodekabupaten'),
				'KECAMATAN' => $val->set_value('kecamatan'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('mst_kecamatan', $dataexc);
			
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
		$id = $this->input->post('kodekecamatan',TRUE);		
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kodekecamatan', 'Kode Kecamatan', 'trim|required|xss_clean|min_length[7]|max_length[7]');
		$val->set_rules('kodekabupaten', 'Kode Kabupaten', 'trim|required|xss_clean|min_length[4]|max_length[4]');
		$val->set_rules('kecamatan', 'Kecamatan', 'trim|required|xss_clean');
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
				'KD_KECAMATAN' => $val->set_value('kodekecamatan'),
				'KD_KABUPATEN' => $val->set_value('kodekabupaten'),
				'KECAMATAN' => $val->set_value('kecamatan'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('KD_KECAMATAN',$id);
			$db->update('mst_kecamatan', $dataexc);
			
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
		$id=$this->input->get('kodekecamatan')?$this->input->get('kodekecamatan',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select('a.*,b.KABUPATEN');
		$db->from('mst_kecamatan a');
		$db->join('mst_kabupaten b','b.KD_KABUPATEN=a.KD_KABUPATEN');
		$db->where('KD_KECAMATAN',$id);
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('masterKecamatan/v_master_kecamatan_edit',$data);
	}
	public function delete()
	{
		$id=$this->input->post('kodekecamatan')?$this->input->post('kodekecamatan',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_kecamatan where KD_KECAMATAN = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('kodekecamatan')?$this->input->get('kodekecamatan',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select('a.*,b.KABUPATEN');
		$db->from('mst_kecamatan a');
		$db->join('mst_kabupaten b','b.KD_KABUPATEN=a.KD_KABUPATEN');
		$db->where('KD_KECAMATAN',$id);
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('masterKecamatan/v_master_kecamatan_detail',$data);
	}
	
}

/* End of file master_kecamatan.php */
/* Location: ./application/controllers/c_master_kecamatan.php */