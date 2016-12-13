<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class Transaksi1 extends CI_Controller {
	public function index()
	{
		$this->load->view('transaksi1');
	}
	
	public function transaksi1xml()
	{
		$this->load->model('transaksi1_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai')
					);
					
		$total = $this->transaksi1_model->totalTransaksi1($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai')
					);
					
		$result = $this->transaksi1_model->getTransaksi1($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('transaksi1add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('column1', 'Column Satu', 'trim|required|xss_clean');
		$val->set_rules('column2', 'Column Dua', 'trim|required|xss_clean');
		$val->set_rules('column3', 'Column Tiga', 'trim|required|xss_clean');
		$val->set_rules('column_master_1_id', 'Column Master 1', 'trim|required|xss_clean');
		
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
				'ncolumn1' => $val->set_value('column1'),
				'ncolumn2' => $val->set_value('column2'),
				'ncolumn3' => $val->set_value('column3'),
				'nmaster_1_id' => $val->set_value('column_master_1_id'),
				'ntgl_transaksi1' => date("Y-m-d", strtotime($this->input->post('tgltransaksi1',TRUE))),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('tbl_transaksi1', $dataexc);
			
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
		$val->set_rules('column1', 'Column Satu', 'trim|required|xss_clean');
		$val->set_rules('column2', 'Column Dua', 'trim|required|xss_clean');
		$val->set_rules('column3', 'Column Tiga', 'trim|required|xss_clean');
		$val->set_rules('column_master_1_id', 'Column Master 1', 'trim|required|xss_clean');

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
				'ncolumn1' => $val->set_value('column1'),
				'ncolumn2' => $val->set_value('column2'),
				'ncolumn3' => $val->set_value('column3'),
				'nmaster_1_id' => $val->set_value('column_master_1_id'),
				'ntgl_transaksi1' => date("Y-m-d", strtotime($this->input->post('tgltransaksi1',TRUE))),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('nid_transaksi1',$id);
			$db->update('tbl_transaksi1', $dataexc);
			
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
		$db->select("u.*, m.ncolumn1 as nmastercolumn1");
		$db->from('tbl_transaksi1 u');
		$db->join('tbl_master1 m','m.nid_master1=u.nmaster_1_id');
		$db->where('u.nid_transaksi1 ',$id);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('transaksi1edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from tbl_transaksi1 where nid_transaksi1 = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("u.*, m.ncolumn1 as nmastercolumn1");
		$db->from('tbl_transaksi1 u');
		$db->join('tbl_master1 m','m.nid_master1=u.nmaster_1_id');
		$db->where('u.nid_transaksi1 ',$id);
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('transaksi1detail',$data);
	}
	
	public function coba()
	{
		echo '<pre>';
		print_r($_POST);
		die;
		
		$asdf= json_decode($_POST['array']);
		foreach($asdf as $a){
			$my[] = json_decode($a);
			$xx = $my;
		}
		
		echo '<pre>';
		print_r($xx[0]->tax);
		die;
	}
	
}

/* End of file transaksi1.php */
/* Location: ./application/controllers/transaksi1.php */