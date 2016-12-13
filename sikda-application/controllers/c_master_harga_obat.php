<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_harga_obat extends CI_Controller {
	public function index()
	{
		$this->load->view('masterHargaobat/v_master_harga_obat');
	}
	
	public function masterhargaobatpopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('masterHargaobat/v_master_harga_obat_popup',$data);
	}
	
	public function masterhargaobatxml()
	{
		$this->load->model('m_master_harga_obat');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai')
					);
					
		$total = $this->m_master_harga_obat->totalmasterhargaobat($paramstotal);
		
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
					
		$result = $this->m_master_harga_obat->getmasterhargaobat($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$db = $this->load->database('sikda', TRUE);
		$db->select("*");
		$db->from("apt_mst_milik_obat");
		$val = $db->get()->result();
		$data['data']=$val;		
		$this->load->view('masterHargaobat/v_master_harga_obat_add', $data);
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kd_tarif', 'Kode Tarif', 'trim|required|xss_clean|min_length[2]');
		$val->set_rules('kd_obat', 'Kode Obat', 'trim|required|xss_clean');
		$val->set_rules('harga_beli', 'Harga Beli', 'trim|required|xss_clean');
		$val->set_rules('harga_jual', 'Harga Jual', 'trim|required|xss_clean');
		$val->set_rules('kd_milik_obat', 'Kode Milik Obat', 'trim|required|xss_clean|min_length[2]');
				
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
				'KD_TARIF' => $val->set_value('kd_tarif'),
				'KD_OBAT' => $val->set_value('kd_obat'),
				'HARGA_BELI' => $val->set_value('harga_beli'),
				'HARGA_JUAL' => $val->set_value('harga_jual'),
				'KD_MILIK_OBAT' => $val->set_value('kd_milik_obat'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('apt_mst_harga_obat', $dataexc);
			
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
		$val->set_rules('kd_tarif', 'Kode Tarif', 'trim|required|xss_clean|min_length[2]');
		$val->set_rules('kd_obat', 'Kode Obat', 'trim|required|xss_clean');
		$val->set_rules('harga_beli', 'Harga Beli', 'trim|required|xss_clean');
		$val->set_rules('harga_jual', 'Harga Jual', 'trim|required|xss_clean');
		$val->set_rules('kd_milik_obat', 'Kode Milik Obat', 'trim|required|xss_clean|min_length[2]');
		
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
				'KD_TARIF' => $val->set_value('kd_tarif'),
				'KD_OBAT' => $val->set_value('kd_obat'),
				'HARGA_BELI' => $val->set_value('harga_beli'),
				'HARGA_JUAL' => $val->set_value('harga_jual'),
				'KD_MILIK_OBAT' => $val->set_value('kd_milik_obat'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where("CONCAT(KD_TARIF,KD_OBAT,KD_MILIK_OBAT)='$id'");
			$db->update('apt_mst_harga_obat', $dataexc);
			
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
		$db->select("a.*,b.NAMA_OBAT,CONCAT(KD_TARIF,a.KD_OBAT,KD_MILIK_OBAT) as idd",false);
		$db->from('apt_mst_harga_obat a');
		$db->join('apt_mst_obat b','a.KD_OBAT=b.KD_OBAT');
		$db->where("CONCAT(a.KD_TARIF,a.KD_OBAT,a.KD_MILIK_OBAT) ='$id'",null, false);
		$val = $db->get()->row();
		$data['data']=$val;	


		$db = $this->load->database('sikda', TRUE);
		$db->select("*");
		$db->from("apt_mst_milik_obat");
		$vals = $db->get()->result();
		$data['miliks']=$vals;			
		$this->load->view('masterHargaobat/v_master_harga_obat_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from apt_mst_harga_obat where CONCAT(KD_TARIF,KD_OBAT,KD_MILIK_OBAT) = '".$id."'",null, false)){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("a.*,b.NAMA_OBAT,CONCAT(KD_TARIF,a.KD_OBAT,KD_MILIK_OBAT) as idd",false);
		$db->from('apt_mst_harga_obat a');
		$db->join('apt_mst_obat b','a.KD_OBAT=b.KD_OBAT');
		$db->where("CONCAT(a.KD_TARIF,a.KD_OBAT,a.KD_MILIK_OBAT) = '$id'",null, false);
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('masterHargaobat/v_master_harga_obat_detail',$data);
	}
	
}

/* End of file c_master_harga_obat.php */
/* Location: ./application/controllers/c_master_harga_obat.php */