<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_ruangan extends CI_Controller {
	public function index()
	{
		$this->load->view('masterRuangan/v_master_ruangan');
	}
	
	/*public function masterpuskesmaspopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('masterPuskesmas/v_master_puskesmas_popup',$data);
	}*/
	

	public function master_ruanganxml()
	{
		$this->load->model('m_master_ruangan');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'koderuangan'=>$this->input->post('koderuangan')
					);
					
		$total = $this->m_master_ruangan->totalmaster_ruangan($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'koderuangan'=>$this->input->post('koderuangan')
					);
					
		$result = $this->m_master_ruangan->getMaster_ruangan($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterRuangan/v_master_ruangan_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');
		$val = $this->form_validation;
		$val->set_rules('koderuangan', 'Kode Ruangan', 'trim|required|xss_clean');
		$val->set_rules('kodepuskesmas', 'Kode Puskesmas', 'trim|required|xss_clean');
		$val->set_rules('ruangan', 'Ruangan', 'trim|required|xss_clean');
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
				'KD_RUANGAN' => $val->set_value('koderuangan'),
				'KD_PUSKESMAS' => $val->set_value('kodepuskesmas'),
				'NAMA_RUANGAN' => $val->set_value('ruangan'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('mst_ruangan', $dataexc);
			
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
		$id = $this->input->post('koderuanganid',TRUE);		
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('koderuangan', 'Kode Ruangan', 'trim|required|xss_clean');
		$val->set_rules('kodepuskesmas', 'Kode Puskesmas', 'trim|required|xss_clean');
		$val->set_rules('ruangan', 'Ruangan', 'trim|required|xss_clean');
		
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
				'KD_RUANGAN' => $val->set_value('koderuangan'),
				'KD_PUSKESMAS' => $val->set_value('kodepuskesmas'),
				'NAMA_RUANGAN' => $val->set_value('ruangan'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('KD_RUANGAN',$id);
			$db->update('mst_ruangan', $dataexc);
			
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
		$id=$this->input->get('koderuangan')?$this->input->get('koderuangan',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select('a.*,b.KD_PUSKESMAS, b.PUSKESMAS');
		$db->from('mst_ruangan a');
		$db->join('mst_puskesmas b','b.KD_PUSKESMAS=a.KD_PUSKESMAS');
		$db->where('a.KD_RUANGAN', $id);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('masterRuangan/v_master_ruangan_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('koderuangan')?$this->input->post('koderuangan',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_ruangan where KD_RUANGAN = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('koderuangan')?$this->input->get('koderuangan',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select('a.*,b.KD_PUSKESMAS, b.PUSKESMAS');
		$db->from('mst_ruangan a');
		$db->join('mst_puskesmas b','b.KD_PUSKESMAS=a.KD_PUSKESMAS');
		$db->where('a.KD_RUANGAN', $id);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('masterRuangan/v_master_ruangan_detail',$data);
	}
	
	
}

/* End of file master_kecamatan.php */
/* Location: ./application/controllers/c_master_kecamatan.php */
