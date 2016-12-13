<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_cara_bayar extends CI_Controller {
	public function index()
	{
			
		$this->load->view('masterCarabayar/v_master_cara_bayar');
	}
	
	public function carabayarxml()
	{
		$this->load->model('m_master_cara_bayar');
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari')
					);
					
		$total = $this->m_master_cara_bayar->totalCarabayar($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'keyword'=>$this->input->post('keyword'),
					'cari' =>$this->input->post('cari')
					);
					
		$result = $this->m_master_cara_bayar->getCarabayar($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$db = $this->load->database('sikda', TRUE);
		$customer=$db->query("select * from mst_kel_pasien")->result_array();
		$data['customer']=$customer;
		$this->load->view('masterCarabayar/v_master_cara_bayar_add', $data);
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kodebayar', 'Kode Bayar', 'trim|required|xss_clean');
		$val->set_rules('carabayar', 'Cara Bayar', 'trim|required|xss_clean');
		$val->set_rules('kodecustomer', 'Kode Customer');
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
				'KD_BAYAR' => $val->set_value('kodebayar'),
				'CARA_BAYAR' => $val->set_value('carabayar'),
				'KD_CUSTOMER' => $val->set_value('kodecustomer'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('mst_cara_bayar', $dataexc);
			
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
		$val->set_rules('kodebayar', 'Kode Bayar', 'trim|required|xss_clean');
		$val->set_rules('carabayar', 'Cara Bayar', 'trim|required|xss_clean');
		$val->set_rules('kodecustomer', 'Kode Customer');

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
				'KD_BAYAR' => $val->set_value('kodebayar'),
				'CARA_BAYAR' => $val->set_value('carabayar'),
				'KD_CUSTOMER' => $val->set_value('kodecustomer'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('KD_BAYAR',$id);
			$db->update('mst_cara_bayar', $dataexc);
			
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
		$customer=$db->query("select * from mst_kel_pasien")->result_array();
		$val = $db->query("select * from mst_cara_bayar where KD_BAYAR ='".$id."'")->row();
		$data['customer']=$customer;
		$data['data']=$val;		
		$this->load->view('masterCarabayar/v_master_cara_bayar_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_cara_bayar where KD_BAYAR = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("a.*, b.CUSTOMER" );
		$db->from('mst_cara_bayar a');
		$db->join('mst_kel_pasien b', 'b.KD_CUSTOMER=a.KD_CUSTOMER','left');
		$db->where('KD_BAYAR',$id);
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('masterCarabayar/v_master_cara_bayar_detail',$data);
	}
	
}

/* End of file c_master_cara_bayar.php */
/* Location: ./application/controllers/c_master_cara_bayar.php */