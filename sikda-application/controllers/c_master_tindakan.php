<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_tindakan extends CI_Controller {
	public function index()
	{
		$this->load->view('masterTindakan/v_master_tindakan');
	}
        
	public function masterPopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('masterTindakan/tindakan_gigi_pop',$data);
	}

	public function tindakanxml($for_dialog=NULL)
	{
		$this->load->model('m_master_tindakan');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari'),
					'kd_produk'=>$this->input->post('kd_produk'),
					'kd_puskesmas'=>$this->input->post('kd_puskesmas'),
					'gol_produk'=>$this->input->post('gol_produk'),
					'produk'=>$this->input->post('produk'),
					'for_dialog'=>$for_dialog
					);
					
		$total = $this->m_master_tindakan->totalMastertindakan($paramstotal);
		
		
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
					'kd_produk'=>$this->input->post('kd_produk'),
					'kd_puskesmas'=>$this->input->post('kd_puskesmas'),
					'gol_produk'=>$this->input->post('gol_produk'),
					'produk'=>$this->input->post('produk'),
					'for_dialog'=>$for_dialog
					);
					
		$result = $this->m_master_tindakan->getMastertindakan($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$db = $this->load->database('sikda',true);
		$gol_produk = $db->query ("select * from mst_gol_produk")->result_array();// menampilkan semua data di tabel mst_gol_produk 
		$data['gol_produk'] = $gol_produk;
		
		$this->load->view('masterTindakan/v_master_tindakan_add',$data);
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		//$val->set_rules('kd', 'Kode Puskesmas', 'trim|required|xss_clean|min_length[1]|max_length[20]');
		$val->set_rules('gol_produk', 'Golongan Produk', 'trim|required|xss_clean|min_length[1]|max_length[500]');
		$val->set_rules('produk', 'Produk', 'trim|required|xss_clean|min_length[1]|max_length[500]');
		$val->set_rules('harga', 'Harga Produk', 'trim|required|xss_clean|min_length[1]|max_length[500]');
		$val->set_rules('singkatan', 'Singkatan', 'trim|required|xss_clean|min_length[1]|max_length[500]');
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
				'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
				'KD_GOL_PRODUK' => $val->set_value('gol_produk'),
				'PRODUK' => $val->set_value('produk'),
				'HARGA_PRODUK' => $val->set_value('harga'),
				'SINGKATAN' => $val->set_value('singkatan'),
				'IS_DEFAULT' => $val->set_value('is_default'),
				'IS_ODONTOGRAM' => $val->set_value('is_odontogram'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);//echo '<pre>';print_r($dataexc);die('zdfg');	
			
			$db->insert('mst_produk', $dataexc);
			
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
		//$val->set_rules('kd', 'Kode Puskesmas', 'trim|required|xss_clean|min_length[1]|max_length[20]');
		$val->set_rules('gol_produk', 'Golongan Produk', 'trim|required|xss_clean|min_length[1]|max_length[500]');
		$val->set_rules('produk', 'Produk', 'trim|required|xss_clean|min_length[1]|max_length[500]');
		$val->set_rules('harga', 'Harga Produk', 'trim|required|xss_clean|min_length[1]|max_length[500]');
		$val->set_rules('singkatan', 'Singkatan', 'trim|required|xss_clean|min_length[1]|max_length[500]');
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
				'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
				'KD_GOL_PRODUK' => $val->set_value('gol_produk'),
				'PRODUK' => $val->set_value('produk'),
				'HARGA_PRODUK' => $val->set_value('harga'),
				'SINGKATAN' => $val->set_value('singkatan'),
				'IS_DEFAULT' => $val->set_value('is_default'),
				'IS_ODONTOGRAM' => $val->set_value('is_odontogram'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->where('KD_PRODUK',$kd);
			$db->update('mst_produk', $dataexc);
			
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
		$val = $db->query("select * from mst_produk where KD_PRODUK = '".$kd."'")->row();
		$gol_produk = $db->query ("select * from mst_gol_produk")->result_array();
		$data['gol_produk'] = $gol_produk;
		$data['data'] = $val;	
		$this->load->view('masterTindakan/v_master_tindakan_edit',$data);
                //print_r($data);die;
	}
	
	public function delete()
	{
		$kd=$this->input->post('kd')?$this->input->post('kd',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_produk where KD_PRODUK= '".$kd."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$kd=$this->input->get('kd')?$this->input->get('kd',TRUE):null; //print_r($kd); die;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from mst_produk where KD_PRODUK = '".$kd."'")->row();
		$data['data']=$val;
		$this->load->view('masterTindakan/v_master_tindakan_detail',$data);
                //print_r($data); die;
	}
	
}
