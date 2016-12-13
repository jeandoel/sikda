<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_jenis_kasus extends CI_Controller {
	public function index()
	{
		$this->load->view('masterJeniskasus/v_master_jenis_kasus');
	}
	
	public function masterjeniskasuspopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('masterJeniskasus/v_master_jenis_kasus_popup',$data);
	}
	
	public function jeniskasusxml()
	{
		$this->load->model('m_master_jenis_kasus');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'nama'=>$this->input->post('nama')
					);
					
		$total = $this->m_master_jenis_kasus->totalJeniskasus($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'nama'=>$this->input->post('nama')
					);
					
		$result = $this->m_master_jenis_kasus->getJeniskasus($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterJeniskasus/v_master_jenis_kasus_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kodejeniskasus', 'Kode Jenis Kasus', 'trim|required|xss_clean');
		$val->set_rules('jeniskasus', 'Jenis Kasus', 'trim|required|xss_clean');
		$val->set_rules('kodeicd');
		$val->set_rules('kodejenis', 'Kode Jenis', 'trim|required|xss_clean');
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
				'KD_JENIS_KASUS' => $val->set_value('kodejeniskasus'),
				'JENIS_KASUS' => $val->set_value('jeniskasus'),
				'KD_ICD_INDUK' => $val->set_value('kodeicd'),
				'KD_JENIS'=> $val->set_value('kodejenis'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('mst_kasus_jenis', $dataexc);
			
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
		$val->set_rules('kodejeniskasus', 'Kode Jenis Kasus', 'trim|required|xss_clean');
		$val->set_rules('jeniskasus', 'Jenis Kasus', 'trim|required|xss_clean');
		$val->set_rules('kodeicd');
		$val->set_rules('kodejenis', 'Kode Jenis', 'trim|required|xss_clean');

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
				'KD_JENIS_KASUS' => $val->set_value('kodejeniskasus'),
				'JENIS_KASUS' => $val->set_value('jeniskasus'),
				'KD_ICD_INDUK' => $val->set_value('kodeicd'),
				'KD_JENIS'=> $val->set_value('kodejenis'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);	
//print_r($dataexc);die;
			
			$db->where('KD_JENIS_KASUS',$id);
			$db->update('mst_kasus_jenis', $dataexc);
			
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
		$db->select("a.KD_JENIS_KASUS,a.JENIS_KASUS,a.KD_ICD_INDUK,a.KD_JENIS,b.KD_ICD_INDUK as kode_icd,b.PENYAKIT as namapenyakit");
		$db->from('mst_kasus_jenis a');
		$db->join('mst_icd b','b.KD_ICD_INDUK=a.KD_ICD_INDUK','left');
		$db->where('a.KD_JENIS_KASUS',$id);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('masterJeniskasus/v_master_jenis_kasus_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_kasus_jenis where KD_JENIS_KASUS = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("a.KD_JENIS_KASUS,a.JENIS_KASUS,a.KD_ICD_INDUK,a.KD_JENIS,b.KD_ICD_INDUK as kode_icd,b.PENYAKIT as namapenyakit");
		$db->from('mst_kasus_jenis a');
		$db->join('mst_icd b','b.KD_ICD_INDUK=a.KD_ICD_INDUK','left');
		$db->where('a.KD_JENIS_KASUS',$id);
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('masterJeniskasus/v_master_jenis_kasus_detail',$data);
		//print_r($data); die;
	}
	
}

/* End of file c_master_jenis_kasus.php */
/* Location: ./application/controllers/c_master_jenis_kasus.php */