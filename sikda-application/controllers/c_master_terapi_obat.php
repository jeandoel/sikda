<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_terapi_obat extends CI_Controller {
	public function index()
	{
		$this->load->view('masterTerapiobat/v_master_terapi_obat');
	}
	
	public function masterterapipopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('masterTerapiobat/v_master_terapi_obat_popup',$data);
	}
	
		public function master_terapiobatxml()
	{
		$this->load->model('m_master_terapi_obat');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'kodeterapiobat'=>$this->input->post('kodeterapiobat')
					);
					
		$total = $this->m_master_terapi_obat->totalmaster_terapiobat($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'kodeterapiobat'=>$this->input->post('kodeterapiobat')
					);
					
		$result = $this->m_master_terapi_obat->getMaster_terapiobat($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterTerapiobat/v_master_terapi_obat_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');
		$val = $this->form_validation;
		$val->set_rules('kodeterapiobat', 'Kode Terapi Obat', 'trim|required|xss_clean');
		$val->set_rules('terapiobat', 'Terapi Obat', 'trim|required|xss_clean');
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
				'KD_TERAPI_OBAT' => $val->set_value('kodeterapiobat'),
				'TERAPI_OBAT' => $val->set_value('terapiobat'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('apt_mst_terapi_obat', $dataexc);
			
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
		$id = $this->input->post('kodeterapiobatid',TRUE);		
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kodeterapiobat', 'Kode Terapi Obat', 'trim|required|xss_clean');
		$val->set_rules('terapiobat', 'Terapi Obat', 'trim|required|xss_clean');
		
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
				'KD_TERAPI_OBAT' => $val->set_value('kodeterapiobat'),
				'TERAPI_OBAT' => $val->set_value('terapiobat'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('KD_TERAPI_OBAT',$id);
			$db->update('apt_mst_terapi_obat', $dataexc);
			
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
		$id=$this->input->get('kodeterapiobat')?$this->input->get('kodeterapiobat',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from apt_mst_terapi_obat where KD_TERAPI_OBAT = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterTerapiobat/v_master_terapi_obat_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('kodeterapiobat')?$this->input->post('kodeterapiobat',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from apt_mst_terapi_obat where KD_TERAPI_OBAT = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('kodeterapiobat')?$this->input->get('kodeterapiobat',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from apt_mst_terapi_obat where KD_TERAPI_OBAT = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('masterTerapiobat/v_master_terapi_obat_detail',$data);
	}
	
}

/* End of file master_kecamatan.php */
/* Location: ./application/controllers/c_master_kecamatan.php */
