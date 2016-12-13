<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_transaksi_sarana_posyandu_masuk extends CI_Controller {
	public function index()
	{
		$this->load->view('transaksiSaranaposyandumasuk/v_transaksi_sarana_posyandu_masuk');
	}
	
	public function transaksisaranaposyandumasukxml()
	{
		$this->load->model('m_transaksi_sarana_posyandu_masuk');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai')
					);
					
		$total = $this->m_transaksi_sarana_posyandu_masuk->totalSaranaposyandumasuk($paramstotal);
		
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
					
		$result = $this->m_transaksi_sarana_posyandu_masuk->getSaranaposyandumasuk($params);			
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('transaksiSaranaposyandumasuk/v_transaksi_sarana_posyandu_masuk_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');
		$val = $this->form_validation;
		$val->set_rules('asalsaranaposyandu', 'Asal Sarana Posyandu', 'trim|required|xss_clean');
		$val->set_rules('idpuskesmas', 'Tujuan Sarana', 'trim|required|xss_clean');
		$val->set_rules('idpegawai', 'Id Pegawai', 'trim|required|xss_clean');
		$val->set_rules('idsaranaposyandu', 'Nama Sarana Posyandu', 'trim|required|xss_clean');
		$val->set_rules('keterangansarana', 'Keterangan', 'trim|required|xss_clean');
		$val->set_rules('kodetransaksi', 'Kode Transaksi', 'trim|required|xss_clean');
		$val->set_rules('tgltransaksi', 'Tgl Transaksi', 'trim|required|xss_clean');
		$val->set_rules('jumlahsarana', 'Jumlah Sarana', 'trim|required|xss_clean');
		
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
				'nasal_sarana_posyandu' => $val->set_value('asalsaranaposyandu'),
				'nid_puskesmas' => $val->set_value('idpuskesmas'),
				'nid_pegawai' => $val->set_value('idpegawai'),
				'nid_sarana_posyandu' => $val->set_value('idsaranaposyandu'),
				'nketerangan_sarana' => $val->set_value('keterangansarana'),
				'nkode_transaksi' => $val->set_value('kodetransaksi'),
				'ntgl_transaksi' => date("Y-m-d", strtotime($this->input->post('tgltransaksi',TRUE))),
				'njumlah_sarana' => $val->set_value('jumlahsarana'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('tbl_transaksi_sarana_posyandu_masuk', $dataexc);
			
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
		$val->set_rules('asalsaranaposyandu', 'Asal Sarana Posyandu', 'trim|required|xss_clean');
		$val->set_rules('idpuskesmas', 'Tujuan Sarana', 'trim|required|xss_clean');
		$val->set_rules('idpegawai', 'Id Pegawai', 'trim|required|xss_clean');
		$val->set_rules('idsaranaposyandu', 'Nama Sarana Posyandu', 'trim|required|xss_clean');
		$val->set_rules('keterangansarana', 'Keterangan', 'trim|required|xss_clean');
		$val->set_rules('kodetransaksi', 'Kode Transaksi', 'trim|required|xss_clean');
		$val->set_rules('tgltransaksi', 'Tgl Transaksi', 'trim|required|xss_clean');
		$val->set_rules('jumlahsarana', 'Jumlah Sarana', 'trim|required|xss_clean');

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
				'nasal_sarana_posyandu' => $val->set_value('asalsaranaposyandu'),
				'nid_puskesmas' => $val->set_value('idpuskesmas'),
				'nid_pegawai' => $val->set_value('idpegawai'),
				'nid_sarana_posyandu' => $val->set_value('idsaranaposyandu'),
				'nketerangan_sarana' => $val->set_value('keterangansarana'),
				'nkode_transaksi' => $val->set_value('kodetransaksi'),
				'ntgl_transaksi' => date("Y-m-d", strtotime($this->input->post('tgltransaksi',TRUE))),
				'njumlah_sarana' => $val->set_value('jumlahsarana'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('nid_sarana_posyandu_masuk',$id);
			$db->update('tbl_transaksi_sarana_posyandu_masuk', $dataexc);
			
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
		$db->select("u.*, m.nnama_puskesmas as nnamapuskesmas, n.nnama_sarana_posyandu as nnamasaranaposyandu");
		$db->from('tbl_transaksi_sarana_posyandu_masuk u');
		$db->join('tbl_master_puskesmas m','m.nid_puskesmas=u.nid_puskesmas');
		$db->join('tbl_master_sarana_posyandu n','n.nid_sarana_posyandu=u.nid_sarana_posyandu');
		$db->where('u.nid_sarana_posyandu_masuk ',$id);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('transaksiSaranaposyandumasuk/v_transaksi_sarana_posyandu_masuk_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from tbl_transaksi_sarana_posyandu_masuk where nid_sarana_posyandu_masuk = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("u.*, m.nnama_puskesmas as nnamapuskesmas,n.nnama_sarana_posyandu as nnamasaranaposyandu");
		$db->from('tbl_transaksi_sarana_posyandu_masuk u');
		$db->join('tbl_master_puskesmas m','m.nid_puskesmas=u.nid_puskesmas');
		$db->join('tbl_master_sarana_posyandu n','n.nid_sarana_posyandu=u.nid_sarana_posyandu');
		$db->where('u.nid_sarana_posyandu_masuk ',$id);
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('transaksiSaranaposyandumasuk/v_transaksi_sarana_posyandu_masuk_detail',$data);
	}
	
}

/* End of file c_transaksi_sarana_posyandu_masuk.php */
/* Location: ./application/controllers/c_transaksi_sarana_posyandu_masuk.php */