<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_icd extends CI_Controller {
	public function index()
	{
		$this->load->view('masterIcd/v_master_icd');
	}
        
	public function icdpopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('masterIcdinduk/v_master_icd_induk_popup',$data);
	}
	 
	public function diagnosa_gigi_pop()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('masterIcd/diagnosa_gigi_pop',$data);
	}

	public function icdxml($for_dialog=NULL)
	{
		$this->load->model('m_master_icd');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari'),
					'kd_penyakit'=>$this->input->post('kd_penyakit'),
					'kd_icd_induk'=>$this->input->post('kd_icd_induk'),
					'penyakit'=>$this->input->post('penyakit'),
					'for_dialog'=>$for_dialog
					);
					
		$total = $this->m_master_icd->totalMastericd($paramstotal);
		
		
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
					'cari' =>$this->input->post('cari'),
					'kd_penyakit'=>$this->input->post('kd_penyakit'),
					'kd_icd_induk'=>$this->input->post('kd_icd_induk'),
					'penyakit'=>$this->input->post('penyakit'),
					'for_dialog'=>$for_dialog
					);
					
		$result = $this->m_master_icd->getMastericd($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterIcd/v_master_icd_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kode_penyakit', 'Kode Penyakti', 'trim|required|xss_clean|min_length[1]|max_length[20]');
		$val->set_rules('kode_icd_induk', 'Kode ICD Induk', 'trim|required|xss_clean|min_length[1]|max_length[20]');
		$val->set_rules('penyakit', 'Penyakit', 'trim|required|xss_clean|min_length[1]|max_length[500]');
		$val->set_rules('includes');
		$val->set_rules('excludes');
		$val->set_rules('notes');
                $val->set_rules('status_app');
		$val->set_rules('description');
		$val->set_rules('is_default', 'Is Default', 'trim|required|xss_clean|min_length[1]|max_length[3]');
		$val->set_rules('is_odontogram', 'Odontogram', 'trim|required|xss_clean|min_length[1]|max_length[3]');
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
				'KD_PENYAKIT' => $val->set_value('kode_penyakit'),
				'KD_ICD_INDUK' => $val->set_value('kode_icd_induk'),
				'PENYAKIT' => $val->set_value('penyakit'),
				'INCLUDES' => $val->set_value('includes'),
				'EXCLUDES' => $val->set_value('excludes'),
				'NOTES' => $val->set_value('notes'),
				'STATUS_APP' => $val->set_value('status_app'),
				'DESCRIPTION' => $val->set_value('description'),
				'IS_DEFAULT' => $val->set_value('is_default'),
				'IS_ODONTOGRAM' => $val->set_value('is_odontogram'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('mst_icd', $dataexc);
			
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
		$kd = $this->input->post('kd',TRUE);		
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kode_penyakit', 'Kode Penyakti', 'trim|required|xss_clean|min_length[1]|max_length[20]');
		$val->set_rules('kode_icd_induk', 'Kode ICD Induk', 'trim|required|xss_clean|min_length[1]|max_length[20]');
		$val->set_rules('penyakit', 'Penyakit', 'trim|required|xss_clean|min_length[1]|max_length[500]');
		$val->set_rules('includes');
		$val->set_rules('excludes');
		$val->set_rules('notes');
		$val->set_rules('status_app');
		$val->set_rules('description');
		$val->set_rules('is_default', 'Is Default', 'trim|required|xss_clean|min_length[1]|max_length[3]');
		$val->set_rules('is_odontogram', 'Odontogram', 'trim|required|xss_clean|min_length[1]|max_length[3]');
		
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
				'KD_PENYAKIT' => $val->set_value('kode_penyakit'),
				'KD_ICD_INDUK' => $val->set_value('kode_icd_induk'),
				'PENYAKIT' => $val->set_value('penyakit'),
				'INCLUDES' => $val->set_value('includes'),
				'EXCLUDES' => $val->set_value('excludes'),
				'NOTES' => $val->set_value('notes'),
				'STATUS_APP' => $val->set_value('status_app'),
				'DESCRIPTION' => $val->set_value('description'),
				'IS_DEFAULT' => $val->set_value('is_default'),
				'IS_ODONTOGRAM' => $val->set_value('is_odontogram'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->where('KD_PENYAKIT',$kd);
			$db->update('mst_icd', $dataexc);
			
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
		$kd=$this->input->get('kd')?$this->input->get('kd',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("u.*, m.ICD_INDUK as icd_induk");
		$db->from('mst_icd u');
                $db->join('mst_icd_induk m','m.KD_ICD_INDUK=u.KD_ICD_INDUK','left');
		$db->where('u.KD_PENYAKIT ',$kd);
		$val = $db->get()->row();
                $data['data']=$val;		
		$this->load->view('masterIcd/v_master_icd_edit',$data);
                //print_r($data);die;
	}
	
	public function delete()
	{
		$kd=$this->input->post('kd')?$this->input->post('kd',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_icd where KD_PENYAKIT= '".$kd."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$kd=$this->input->get('kd')?$this->input->get('kd',TRUE):null; //print_r($kd); die;
		$db = $this->load->database('sikda', TRUE);
		$db->select("u.*, m.ICD_INDUK as icd_induk");
		$db->from('mst_icd u');
                $db->join('mst_icd_induk m','m.KD_ICD_INDUK=u.KD_ICD_INDUK','left');
		$db->where('u.KD_PENYAKIT ',$kd);
		$val = $db->get()->row();
                $data['data']=$val;
		$this->load->view('masterIcd/v_master_icd_detail',$data);
                //print_r($data); die;
	}
	
}
