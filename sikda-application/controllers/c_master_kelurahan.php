<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_kelurahan extends CI_Controller {
	public function index()
	{
		$this->load->view('masterKelurahan/v_master_kelurahan');
	}
	
	public function masterkelurahanpopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$data['idkec'] = $this->input->get('kd_kec')?$this->input->get('kd_kec',TRUE):null;
		$this->load->view('masterKelurahan/v_master_kelurahan_popup',$data);
	}
	
	public function masterkelurahanxml()
	{
		$this->load->model('m_master_kelurahan');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'nama'=>$this->input->post('nama')
					);
					
		$total = $this->m_master_kelurahan->totalMasterkelurahan($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'nama'=>$this->input->post('nama'),
					'id'=>$this->input->post('idkec')
					);
					
		$result = $this->m_master_kelurahan->getMasterkelurahan($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterKelurahan/v_master_kelurahan_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kode_kelurahan', 'Kode Kelurahan', 'trim|required|xss_clean|min_length[10]|max_length[10]');
		$val->set_rules('kode_kecamatan', 'Kode Kecamatan', 'trim|required|xss_clean|min_length[7]|max_length[7]');
		$val->set_rules('kelurahan', 'Kelurahan', 'trim|required|xss_clean');
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
				'KD_KELURAHAN' => $val->set_value('kode_kelurahan'),
				'KD_KECAMATAN' => $val->set_value('kode_kecamatan'),
				'KELURAHAN' => $val->set_value('kelurahan'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('mst_kelurahan', $dataexc);
			
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
		$id = $this->input->post('kd',TRUE);		
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kode_kelurahan', 'Kode Kelurahan', 'trim|required|xss_clean|min_length[10]|max_length[10]');
		$val->set_rules('kode_kecamatan', 'Kode Kecamatan', 'trim|required|xss_clean|min_length[7]|max_length[7]');
		$val->set_rules('kelurahan', 'Kelurahan', 'trim|required|xss_clean');

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
				'KD_KELURAHAN' => $val->set_value('kode_kelurahan'),
				'KD_KECAMATAN' => $val->set_value('kode_kecamatan'),
				'KELURAHAN' => $val->set_value('kelurahan'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('KD_KELURAHAN',$id);
			$db->update('mst_kelurahan', $dataexc);
			
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
		$id =$this->input->get('kode_kelurahan')?$this->input->get('kode_kelurahan',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("l.KD_KELURAHAN,l.KD_KECAMATAN,l.KELURAHAN ,c.KECAMATAN as namakecamatan,c.KD_KECAMATAN as kodekecamatan");
		$db->from('mst_kelurahan l');
		$db->join('mst_kecamatan c','l.KD_KECAMATAN=c.KD_KECAMATAN');
		$db->where('KD_KELURAHAN',$id);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('masterKelurahan/v_master_kelurahan_edit',$data);
		//print_r($data);die;
	}
	
	public function delete()
	{
		$id=$this->input->post('kode_kelurahan')?$this->input->post('kode_kelurahan',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_kelurahan where KD_KELURAHAN = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('kode_kelurahan')?$this->input->get('kode_kelurahan',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("l.KD_KELURAHAN,l.KD_KECAMATAN,l.KELURAHAN ,c.KECAMATAN as namakecamatan,c.KD_KECAMATAN as kodekecamatan");
		$db->from('mst_kelurahan l');
		$db->join('mst_kecamatan c','l.KD_KECAMATAN=c.KD_KECAMATAN');
		$db->where('KD_KELURAHAN',$id);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('masterKelurahan/v_master_kelurahan_detail',$data);
		//print_r($id);die;
	}
	
}

/* End of file c_master_kelurahan.php */
/* Location: ./application/controllers/c_master_kelurahan.php */