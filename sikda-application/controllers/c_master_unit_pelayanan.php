<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_unit_pelayanan extends CI_Controller {
	public function index()
	{
		$this->load->view('masterUnitpelayanan/v_master_unit_pelayanan');
	}
        
      
	public function unitpelayananxml()
	{
		$this->load->model('m_master_unit_pelayanan');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari')
					);
					
		$total = $this->m_master_unit_pelayanan->totalMasterunitpelayanan($paramstotal);
		
		
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
					
		$result = $this->m_master_unit_pelayanan->getMasterunitpelayanan($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterUnitpelayanan/v_master_unit_pelayanan_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kode_unit_pelayanan', 'Kode Unit Pelayanan', 'trim|required|xss_clean|min_length[1]|max_length[20]');
		$val->set_rules('nama_unit', 'Nama Unit', 'trim|required|xss_clean|min_length[1]|max_length[30]');
		$val->set_rules('aktif', 'Aktif', 'min_length[1]|max_length[10]');
		
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
				'KD_UNIT_LAYANAN' => $val->set_value('kode_unit_pelayanan'),
				'NAMA_UNIT' => $val->set_value('nama_unit'),
				'AKTIF' => $val->set_value('aktif'),
				
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('mst_unit_pelayanan', $dataexc);
			
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
		$val->set_rules('kode_unit_pelayanan', 'Kode Unit Pelayanan', 'trim|required|xss_clean|min_length[1]|max_length[20]');
		$val->set_rules('nama_unit', 'Nama Unit', 'trim|required|xss_clean|min_length[1]|max_length[30]');
		$val->set_rules('aktif', 'Aktif', 'min_length[1]|max_length[10]');
		
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
				'KD_UNIT_LAYANAN' => $val->set_value('kode_unit_pelayanan'),
				'NAMA_UNIT' => $val->set_value('nama_unit'),
				'AKTIF' => $val->set_value('aktif'),
				
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->where('KD_UNIT_LAYANAN',$kd);
			$db->update('mst_unit_pelayanan', $dataexc);
			
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
		$val = $db->query("select * from mst_unit_pelayanan where KD_UNIT_LAYANAN= '".$kd."'")->row();
		$data['data']=$val;		
		$this->load->view('masterUnitpelayanan/v_master_unit_pelayanan_edit',$data);
                //print_r($data);die;
	}
	
	public function delete()
	{
		$kd=$this->input->post('kd')?$this->input->post('kd',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_unit_pelayanan where KD_UNIT_LAYANAN= '".$kd."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$kd=$this->input->get('kd')?$this->input->get('kd',TRUE):null; //print_r($kd); die;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_unit_pelayanan where KD_UNIT_LAYANAN= '".$kd."'")->row();
		$data['data']= $val;
		$this->load->view('masterUnitpelayanan/v_master_unit_pelayanan_detail',$data);
                //print_r($data); die;
	}
	
}
