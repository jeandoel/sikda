<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_kamar extends CI_Controller {
	public function index()
	{
		$this->load->view('masterKamar/v_master_kamar');
	}
        
      
	public function kamarxml()
	{
		$this->load->model('m_master_kamar');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari')
					);
					
		$total = $this->m_master_kamar->totalmasterKamar($paramstotal);
		
		
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
					
		$result = $this->m_master_kamar->getmasterKamar($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterKamar/v_master_kamar_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kode_unit', 'Kode Unit', 'trim|required|xss_clean|integer|min_length[1]|max_length[20]');
		$val->set_rules('no_kamar', 'No Kamar', 'trim|required|xss_clean|min_length[1]|max_length[10]');
		$val->set_rules('nama_kamar', 'Nama Kamar', 'trim|required|xss_clean|min_length[1]|max_length[30]');
		$val->set_rules('jumlah_bed', 'Jumlah Bed', 'trim|xss_clean|integer|min_length[1]|max_length[11]');
		$val->set_rules('digunakan', 'Digunakan', 'trim|xss_clean|integer|min_length[1]|max_length[11]');
                
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
				'KD_UNIT' => $val->set_value('kode_unit'),
				'NO_KAMAR' => $val->set_value('no_kamar'),
				'NAMA_KAMAR' => $val->set_value('nama_kamar'),
				'JUMLAH_BED' => $val->set_value('jumlah_bed'),
				'DIGUNAKAN' => $val->set_value('digunakan'),
				
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('mst_kamar', $dataexc);
			
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
		$no_kamar = $this->input->post('no',TRUE);		
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kode_unit', 'Kode Unit', 'trim|required|xss_clean|integer|min_length[1]|max_length[20]');
		$val->set_rules('no_kamar', 'No Kamar', 'trim|required|xss_clean|min_length[1]|max_length[10]');
		$val->set_rules('nama_kamar', 'Nama Kamar', 'trim|required|xss_clean|min_length[1]|max_length[30]');
		$val->set_rules('jumlah_bed', 'Jumlah Bed', 'trim|xss_clean|integer|min_length[1]|max_length[11]');
		$val->set_rules('digunakan', 'Digunakan', 'trim|xss_clean|integer|min_length[1]|max_length[11]');
                
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
				'KD_UNIT' => $val->set_value('kode_unit'),
				'NO_KAMAR' => $val->set_value('no_kamar'),
				'NAMA_KAMAR' => $val->set_value('nama_kamar'),
				'JUMLAH_BED' => $val->set_value('jumlah_bed'),
				'DIGUNAKAN' => $val->set_value('digunakan'),
				
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->where('KD_UNIT',$kd);
			$db->where('NO_KAMAR',$no_kamar);
			$db->update('mst_kamar', $dataexc);
			
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
		$no=$this->input->get('no_kamar')?$this->input->get('no_kamar',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_kamar where KD_UNIT= '".$kd."' and NO_KAMAR='".$no."'")->row();
		$data['data']=$val;		
		$this->load->view('masterKamar/v_master_kamar_edit',$data);
                //print_r($data);die;
	}
	
	public function delete()
	{
		$kd=$this->input->post('kd')?$this->input->post('kd',TRUE):null;
		$no=$this->input->post('no_kamar')?$this->input->post('no_kamar',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_kamar where KD_UNIT= '".$kd."' and NO_KAMAR='".$no."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$kd=$this->input->get('kd')?$this->input->get('kd',TRUE):null; //print_r($kd); die;
		$no=$this->input->get('no_kamar')?$this->input->get('no_kamar',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_kamar where KD_UNIT= '".$kd."' and NO_KAMAR='".$no."'")->row();
		$data['data']= $val;
		$this->load->view('masterKamar/v_master_kamar_detail',$data);
                //print_r($data); die;
	}
	
}
