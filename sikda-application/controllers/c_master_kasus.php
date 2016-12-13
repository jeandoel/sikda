<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_kasus extends CI_Controller {
	public function index()
	{
		$this->load->view('masterKasus/v_master_kasus');
	}
	
	public function masterkasuspopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('masterKasus/v_master_kasus_popup',$data);
	}
	
	public function masterkasusxml()
	{
		$this->load->model('m_master_kasus');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai')
					);
					
		$total = $this->m_master_kasus->totalmasterkasus($paramstotal);
		
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
					
		$result = $this->m_master_kasus->getmasterkasus($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterKasus/v_master_kasus_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kode_jenis_kasus', 'Kode Jenis Kasus', 'trim|required|xss_clean');
		$val->set_rules('variabel_idd', 'Variabel ID', 'trim|required|xss_clean');
		$val->set_rules('parent_idd', 'Parent ID', 'trim|required|xss_clean');
		$val->set_rules('variabel_name', 'Variabel Name', 'trim|required|xss_clean');
		$val->set_rules('variabel_defi', 'Variabel Definisi', 'trim|required|xss_clean');
		$val->set_rules('ket', 'Keterangan', 'trim|required|xss_clean|min_length[1]');
		$val->set_rules('pilihan_value', 'Pilihan Value', 'trim|required|xss_clean|min_length[1]');
		$val->set_rules('IRow', 'I Row', 'trim|required|xss_clean|int');
				
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
				'KD_JENIS_KASUS' => $val->set_value('kode_jenis_kasus'),
				'VARIABEL_ID' => $val->set_value('variabel_idd'),
				'PARENT_ID' => $val->set_value('parent_idd'),
				'VARIABEL_NAME' => $val->set_value('variabel_name'),
				'VARIABEL_DEFINISI' => $val->set_value('variabel_defi'),
				'KETERANGAN' => $val->set_value('ket'),
				'PILIHAN_VALUE' => $val->set_value('pilihan_value'),
				'IROW' => $val->set_value('IRow'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('mst_kasus', $dataexc);
			
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
		$val->set_rules('kode_jenis_kasus', 'Kode Jenis Kasus', 'trim|required|xss_clean');
		$val->set_rules('variabel_idd', 'Variabel ID', 'trim|required|xss_clean');
		$val->set_rules('parent_idd', 'Parent ID', 'trim|required|xss_clean');
		$val->set_rules('variabel_name', 'Variabel Name', 'trim|required|xss_clean');
		$val->set_rules('variabel_defi', 'Variabel Definisi', 'trim|required|xss_clean');
		$val->set_rules('ket', 'Keterangan', 'trim|required|xss_clean|min_length[2]');
		$val->set_rules('pilihan_value', 'Pilihan Value', 'trim|required|xss_clean|min_length[2]');
		$val->set_rules('IRow', 'I Row', 'trim|required|xss_clean');
		
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
				'KD_JENIS_KASUS' => $val->set_value('kode_jenis_kasus'),
				'VARIABEL_ID' => $val->set_value('variabel_idd'),
				'PARENT_ID' => $val->set_value('parent_idd'),
				'VARIABEL_NAME' => $val->set_value('variabel_name'),
				'VARIABEL_DEFINISI' => $val->set_value('variabel_defi'),
				'KETERANGAN' => $val->set_value('ket'),
				'PILIHAN_VALUE' => $val->set_value('pilihan_value'),
				'IROW' => $val->set_value('IRow'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('VARIABEL_ID',$id);
			$db->update('mst_kasus', $dataexc);
			
			if ($db->trans_status() === FALSE)
			{
				$db->trans_rollback();
				die('Maaf Proses Update Data Gagal');
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
		$db->select('*');
		$db->from('mst_kasus a');
		$db->where('VARIABEL_ID', $id);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('masterKasus/v_master_kasus_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_kasus where VARIABEL_ID = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select('*');
		$db->from('mst_kasus');
		$db->where('VARIABEL_ID',$id);
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('masterKasus/v_master_kasus_detail',$data);
	}
	
}

/* End of file c_master_kasus.php */
/* Location: ./application/controllers/c_master_kasus.php */
