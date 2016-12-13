<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_kia extends CI_Controller {
	public function index()
	{
		$this->load->view('masterKia/v_master_kia');
	}
	
	public function masterkiapopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('masterKia/v_master_kia_popup',$data);
	}
	
	public function masterkiaxml()
	{
		$this->load->model('m_master_kia');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai')
					);
					
		$total = $this->m_master_kia->totalmasterkia($paramstotal);
		
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
					
		$result = $this->m_master_kia->getmasterkia($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterKia/v_master_kia_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('format_xml', 'Format XML', 'trim|required|xss_clean');
		$val->set_rules('variabel_id', 'Variabel ID', 'trim|required|xss_clean');
		$val->set_rules('parent_id', 'Parent ID', 'trim|required|xss_clean');
		$val->set_rules('variabel_data', 'Variabel Data', 'trim|required|xss_clean');
		$val->set_rules('definisi', 'Definisi', 'trim|required|xss_clean');
		$val->set_rules('status', 'Status');
		$val->set_rules('pilihan_value', 'Pilihan Value', 'trim|required|xss_clean');
		$val->set_rules('IRow', 'I Row', 'trim|required|xss_clean');
		$val->set_rules('pelayanan_ulang', 'Pelayanan Ulang');
				
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
				'FORMAT_XML' => $val->set_value('format_xml'),
				'VARIABEL_ID' => $val->set_value('variabel_id'),
				'PARENT_ID' => $val->set_value('parent_id'),
				'VARIABEL_DATA' => $val->set_value('variabel_data'),
				'DEFINISI' => $val->set_value('definisi'),
				'STATUS' => $val->set_value('status'),
				'PILIHAN_VALUE' => $val->set_value('pilihan_value'),
				'IROW' => $val->set_value('IRow'),
				'PELAYANAN_ULANG' => $val->set_value('pelayanan_ulang'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('mst_kia', $dataexc);
			
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
		$val->set_rules('format_xml', 'Format XML', 'trim|required|xss_clean');
		$val->set_rules('variabel_id', 'Variabel ID', 'trim|required|xss_clean');
		$val->set_rules('parent_id', 'Parent ID', 'trim|required|xss_clean');
		$val->set_rules('variabel_data', 'Variabel Data', 'trim|required|xss_clean');
		$val->set_rules('definisi', 'Definisi', 'trim|required|xss_clean');
		$val->set_rules('status', 'Status');
		$val->set_rules('pilihan_value', 'Pilihan Value', 'trim|required|xss_clean');
		$val->set_rules('IRow', 'I Row', 'trim|required|xss_clean');
		$val->set_rules('pelayanan_ulang', 'Pelayanan Ulang');
		
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
				'FORMAT_XML' => $val->set_value('format_xml'),
				'VARIABEL_ID' => $val->set_value('variabel_id'),
				'PARENT_ID' => $val->set_value('parent_id'),
				'VARIABEL_DATA' => $val->set_value('variabel_data'),
				'DEFINISI' => $val->set_value('definisi'),
				'STATUS' => $val->set_value('status'),
				'PILIHAN_VALUE' => $val->set_value('pilihan_value'),
				'IROW' => $val->set_value('IRow'),
				'PELAYANAN_ULANG' => $val->set_value('pelayanan_ulang'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('VARIABEL_ID',$id);
			$db->update('mst_kia', $dataexc);
			
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
		$db->from('mst_kia a');
		$db->where('VARIABEL_ID', $id);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('masterKia/v_master_kia_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_kia where VARIABEL_ID = '".$id."'")){
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
		$db->from('mst_kia');
		$db->where('VARIABEL_ID',$id);
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('masterKia/v_master_kia_detail',$data);
	}
	
}

/* End of file c_master_kia.php */
/* Location: ./application/controllers/c_master_kia.php */