<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_retribusi extends CI_Controller {
	public function index()
	{
		$this->load->view('masterRetribusi/v_master_retribusi');
	}
	
	public function retribusipopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$data['idkec'] = $this->input->get('kd_kec')?$this->input->get('kd_kec',TRUE):null;
		$this->load->view('masterRetribusi/v_master_puskesmas_popup',$data);
	}
	
	public function retribusixml()
	{
		$this->load->model('m_master_retribusi');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'nama'=>$this->input->post('nama'),
					'id'=>$this->input->post('idkec')
					);
					
		$total = $this->m_master_retribusi->totalRetribusi($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'nama'=>$this->input->post('nama'),
					'id'=>$this->input->post('idkec')
					);
					
		$result = $this->m_master_retribusi->getRetribusi($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterRetribusi/v_master_retribusi_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kodepuskesmas', 'Kode Puskesmas', 'trim|required|xss_clean|min_length[11]|max_length[11]');
		$val->set_rules('kodekecamatan', 'Kode Kecamatan', 'trim|required|xss_clean');
		$val->set_rules('namapuskesmas', 'Puskesmas', 'trim|required|xss_clean');
		$val->set_rules('alamat', 'Alamat', 'trim|required|xss_clean');
		$val->set_rules('nilairetribusi', 'Nilai Retribusi', 'trim|required|xss_clean');
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
				'KD_PUSKESMAS' => $val->set_value('kodepuskesmas'),
				'KD_KECAMATAN' => $val->set_value('kodekecamatan'),
				'PUSKESMAS' => $val->set_value('namapuskesmas'),
				'ALAMAT'=> $val->set_value('alamat'),
				'NILAI_RETRIBUSI'=> $val->set_value('nilairetribusi'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('mst_retribusi', $dataexc);
			
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
		$id = $this->input->post('kd_retribusi',TRUE);		
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kodepuskesmas', 'Kode Puskesmas', 'trim|required|xss_clean|min_length[11]|max_length[11]');
		$val->set_rules('kodekecamatan', 'Kode Kecamatan', 'trim|required|xss_clean');
		$val->set_rules('namapuskesmas', 'Puskesmas', 'trim|required|xss_clean');
		$val->set_rules('alamat', 'Alamat', 'trim|required|xss_clean');
		$val->set_rules('nilairetribusi', 'Nilai Retribusi', 'trim|required|xss_clean');

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
				'KD_PUSKESMAS' => $val->set_value('kodepuskesmas'),
				'KD_KECAMATAN' => $val->set_value('kodekecamatan'),
				'PUSKESMAS' => $val->set_value('namapuskesmas'),
				'ALAMAT'=> $val->set_value('alamat'),
				'NILAI_RETRIBUSI'=> $val->set_value('nilairetribusi'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('KD_RETRIBUSI',$id);
			$db->update('mst_retribusi', $dataexc);
			
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
		$id=$this->input->get('kd_retribusi')?$this->input->get('kd_retribusi',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("a.KD_RETRIBUSI,a.KD_PUSKESMAS,a.KD_KECAMATAN,a.PUSKESMAS,a.ALAMAT,a.NILAI_RETRIBUSI,b.KD_KECAMATAN as kode_kecamatan,b.KECAMATAN as nama_kecamatan,c.KD_PUSKESMAS as kd_puskesmas,c.PUSKESMAS as puskesmas");
		$db->from('mst_retribusi a');
		$db->join('mst_kecamatan b','b.KD_KECAMATAN=a.KD_KECAMATAN','left');
		$db->join('mst_puskesmas c','c.KD_PUSKESMAS=a.KD_PUSKESMAS','left');
		$db->where('a.KD_RETRIBUSI',$id);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('masterRetribusi/v_master_retribusi_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('kd_retribusi')?$this->input->post('kd_retribusi',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from mst_retribusi where KD_RETRIBUSI = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('kd_retribusi')?$this->input->get('kd_retribusi',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("a.KD_RETRIBUSI,a.KD_PUSKESMAS,a.KD_KECAMATAN,a.PUSKESMAS,a.ALAMAT,a.NILAI_RETRIBUSI,b.KECAMATAN as nama_kecamatan");
		$db->from('mst_retribusi a');
		$db->join('mst_kecamatan b','b.KD_KECAMATAN=a.KD_KECAMATAN','left');
		$db->where('a.KD_RETRIBUSI',$id);
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('masterRetribusi/v_master_retribusi_detail',$data);
	}
	
}

/* End of file c_master_puskesmas.php */
/* Location: ./application/controllers/c_master_puskesmas.php */
