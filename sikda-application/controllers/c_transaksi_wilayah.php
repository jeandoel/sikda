<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_transaksi_wilayah extends CI_Controller {
	public function index()
	{
		$this->load->view('transaksiWilayah/v_transaksi_wilayah');
	}
	
	public function transaksiwilayahxml()
	{
		$this->load->model('m_transaksi_wilayah');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama')
					);
					
		$total = $this->m_transaksi_wilayah->totaltransaksiwilayah($paramstotal);
		
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
					
		$result = $this->m_transaksi_wilayah->gettransaksiwilayah($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('transaksiWilayah/v_transaksi_wilayah_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kode_transaksi', 'Kode Transaksi', 'trim|required|xss_clean');
		$val->set_rules('master_propinsi_id_column', 'Nama Propinsi', 'trim|required|xss_clean');
		$val->set_rules('master_kabupaten_id_column', 'Nama Kabupaten', 'trim|required|xss_clean');
		$val->set_rules('master_kota_id_column', 'Nama Kota', 'trim|required|xss_clean');
		$val->set_rules('master_kecamatan_id_column', 'Nama Kecamatan', 'trim|required|xss_clean');
		$val->set_rules('master_desa_id_column', 'Nama Desa', 'trim|required|xss_clean');
		$val->set_rules('noRT', 'No RT', 'trim|required|xss_clean');
		$val->set_rules('noRW', 'No RW', 'trim|required|xss_clean');
		
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
				'nkode_transaksi' => $val->set_value('kode_transaksi'),
				'nid_propinsi' => $val->set_value('master_propinsi_id_column'),
				'nid_kabupaten' => $val->set_value('master_kabupaten_id_column'),
				'nid_kota' => $val->set_value('master_kota_id_column'),
				'nid_kecamatan' => $val->set_value('master_kecamatan_id_column'),
				'nid_desa' => $val->set_value('master_desa_id_column'),
				'nno_rt' => $val->set_value('noRT'),
				'nno_rw' => $val->set_value('noRW'),
				'ntgl_transaksi_wilayah' => date("Y-m-d", strtotime($this->input->post('tgltransaksiwilayah',TRUE))),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('tbl_transaksi_wilayah', $dataexc);
			
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
		$val->set_rules('kode_transaksi', 'Kode Transaksi', 'trim|required|xss_clean');
		$val->set_rules('master_propinsi_id_column', 'Nama Propinsi', 'trim|required|xss_clean');
		$val->set_rules('master_kabupaten_id_column', 'Nama Kabupaten', 'trim|required|xss_clean');
		$val->set_rules('master_kota_id_column', 'Nama Kota', 'trim|required|xss_clean');
		$val->set_rules('master_kecamatan_id_column', 'Nama Kecamatan', 'trim|required|xss_clean');
		$val->set_rules('master_desa_id_column', 'Nama Desa', 'trim|required|xss_clean');
		$val->set_rules('noRT', 'No RT', 'trim|required|xss_clean');
		$val->set_rules('noRW', 'No RW', 'trim|required|xss_clean');
		
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
				'nkode_transaksi' => $val->set_value('kode_transaksi'),
				'nid_propinsi' => $val->set_value('master_propinsi_id_column'),
				'nid_kabupaten' => $val->set_value('master_kabupaten_id_column'),
				'nid_kota' => $val->set_value('master_kota_id_column'),
				'nid_kecamatan' => $val->set_value('master_kecamatan_id_column'),
				'nid_desa' => $val->set_value('master_desa_id_column'),
				'nno_rt' => $val->set_value('noRT'),
				'nno_rw' => $val->set_value('noRW'),
				'ntgl_transaksi_wilayah' => date("Y-m-d", strtotime($this->input->post('tgltransaksiwilayah',TRUE))),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('nid_wilayah',$id);
			$db->update('tbl_transaksi_wilayah', $dataexc);
			
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
		$db->select("w.*,p.nnama_propinsi,q.nnama_kabupaten,r.nnama_kota,s.nnama_kecamatan,t.nnama_desa");
		$db->from('tbl_transaksi_wilayah w');
		$db->join('tbl_master_propinsi p','p.nid_propinsi=w.nid_propinsi');
		$db->join('tbl_master_kabupaten q','q.nid_kabupaten=w.nid_kabupaten');
		$db->join('tbl_master_kota r','r.nid_kota=w.nid_kota');
		$db->join('tbl_master_kecamatan s','s.nid_master_kecamatan=w.nid_kecamatan');
		$db->join('tbl_master_desa t','t.nid_desa=w.nid_desa');
		$db->where('nid_wilayah', $id);
		$val = $db->get()->row();
		
		$data['data']=$val;		
		$this->load->view('transaksiWilayah/v_transaksi_wilayah_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from tbl_transaksi_wilayah where nid_wilayah = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("w.*,p.nnama_propinsi,q.nnama_kabupaten,r.nnama_kota,s.nnama_kecamatan,t.nnama_desa");
		$db->from('tbl_transaksi_wilayah w');
		$db->join('tbl_master_propinsi p','p.nid_propinsi=w.nid_propinsi');
		$db->join('tbl_master_kabupaten q','q.nid_kabupaten=w.nid_kabupaten');
		$db->join('tbl_master_kota r','r.nid_kota=w.nid_kota');
		$db->join('tbl_master_kecamatan s','s.nid_master_kecamatan=w.nid_kecamatan');
		$db->join('tbl_master_desa t','t.nid_desa=w.nid_desa');
		$db->where('nid_wilayah', $id);
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('transaksiWilayah/v_transaksi_wilayah_detail',$data);
	}
	
}

/* End of file c_transaksi_wilayah.php */
/* Location: ./application/controllers/c_transaksi_wilayah.php */