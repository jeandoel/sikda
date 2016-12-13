<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_gol_darah extends CI_Controller {
	public function index()
	{
		$this->load->view('masterGoldarah/v_master_gol_darah');
	}
        
      
	public function goldarahxml()
	{
		$this->load->model('m_master_gol_darah');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari')
					);
					
		$total = $this->m_master_gol_darah->totalMastergoldarah($paramstotal);
		
		
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
					'cari' =>$this->input->post('cari')
					);
					
		$result = $this->m_master_gol_darah->getMastergoldarah($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterGoldarah/v_master_gol_darah_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kode_gol_darah', 'Kode Gol Darah', 'trim|required|xss_clean|min_length[1]|max_length[5]');
		$val->set_rules('gol_darah', 'Golongan Darah', 'trim|required|xss_clean|min_length[1]|max_length[3]');
		
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
				'KD_GOL_DARAH' => $val->set_value('kode_gol_darah'),
				'GOL_DARAH' => $val->set_value('gol_darah'),
				
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('mst_gol_darah', $dataexc);
			
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
		$val->set_rules('kode_gol_darah', 'Kode Gol Darah', 'trim|required|xss_clean|min_length[1]|max_length[5]');
		$val->set_rules('gol_darah', 'Golongan Darah', 'trim|required|xss_clean|min_length[1]|max_length[10]');
		
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
				'KD_GOL_DARAH' => $val->set_value('kode_gol_darah'),
				'GOL_DARAH' => $val->set_value('gol_darah'),
				
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->where('KD_GOL_DARAH',$kd);
			$db->update('mst_gol_darah', $dataexc);
			
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
		$val = $db->query("select * from mst_gol_darah where KD_GOL_DARAH= '".$kd."'")->row();
		$data['data']=$val;		
		$this->load->view('masterGoldarah/v_master_gol_darah_edit',$data);
                //print_r($data);die;
	}
	
	public function delete()
	{
		$kd=$this->input->post('kd')?$this->input->post('kd',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_gol_darah where KD_GOL_DARAH= '".$kd."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$kd=$this->input->get('kd')?$this->input->get('kd',TRUE):null; //print_r($kd); die;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_gol_darah where KD_GOL_DARAH= '".$kd."'")->row();
		$data['data']= $val;
		$this->load->view('masterGoldarah/v_master_gol_darah_detail',$data);
                //print_r($data); die;
	}
	
}
