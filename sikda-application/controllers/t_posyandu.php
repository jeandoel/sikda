<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_posyandu extends CI_Controller {
	public function index()
	{
		$this->load->view('t_posyandu/v_posyandu');
	}
	
	public function posyandupopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('t_posyandu/v_posyandu_popup',$data);
	}
	
	public function posyanduxml()
	{
		$this->load->model('t_posyandu_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'carinama'=>$this->input->post('carinama')
					);
					
		$total = $this->t_posyandu_model->totalposyandu($paramstotal);
		
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
					'carinama'=>$this->input->post('carinama')
					);
					
		$result = $this->t_posyandu_model->getposyandu($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_posyandu/v_posyandu_add');
	}
	
	public function addprocess()
	{	
		$this->load->library('form_validation');

		$val = $this->form_validation;
		//$val->set_rules('provinsi', 'Propinsi', 'trim|required|xss_clean');
		//$val->set_rules('kabupaten_kota', 'Kabupaten', 'trim|required|xss_clean');
		//$val->set_rules('kecamatan', 'Kecamatan', 'trim|required|xss_clean');
		$val->set_rules('desa_kelurahan', 'Desa', 'trim|required|xss_clean');
		$val->set_rules('nama_posyandu', 'Nama Posyandu', 'trim|required|xss_clean');
		$val->set_rules('jumlah_kader', 'Jumlah Kader', 'trim|required|xss_clean');
		$val->set_rules('rt', 'RT', 'trim|required|xss_clean');
		$val->set_rules('rw', 'RW', 'trim|required|xss_clean');
		$val->set_rules('alamat', 'Alamat', 'trim|required|xss_clean');
		$val->set_rules('jenis_posyandu', 'Jenis Posyandu', 'trim|required|xss_clean');
				
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
				//'KD_PROPINSI' => $val->set_value('provinsi'),
				//'KD_KABUPATEN' => $val->set_value('kabupaten_kota'),
				//'KD_KECAMATAN' => $val->set_value('kecamatan'),
				'KD_PROPINSI' => $this->session->userdata('kd_propinsi'),
				'KD_KABUPATEN' => $this->session->userdata('kd_kabupaten'),
				'KD_KECAMATAN' => $this->session->userdata('kd_kecamatan'),
				'KD_KELURAHAN' => $val->set_value('desa_kelurahan'),
				'NAMA_POSYANDU' => $val->set_value('nama_posyandu'),
				'JUMLAH_KADER' => $val->set_value('jumlah_kader'),
				'JENIS_POSYANDU' => $val->set_value('jenis_posyandu'),
				'ALAMAT' => $val->set_value('alamat'),
				'RT' => $this->input->post('rt',true),
				'RW' => $this->input->post('rw',true),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('t_posyandu', $dataexc);
			
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
		$this->load->library('form_validation');
		$val = $this->form_validation;
		//$val->set_rules('provinsi', 'Propinsi', 'trim|required|xss_clean');
		//$val->set_rules('kabupaten_kota', 'Kabupaten', 'trim|required|xss_clean');
		//$val->set_rules('kecamatan', 'Kecamatan', 'trim|required|xss_clean');
		$val->set_rules('desa_kelurahan', 'Desa', 'trim|required|xss_clean');
		$val->set_rules('nama_posyandu', 'Nama Posyandu', 'trim|required|xss_clean');
		$val->set_rules('jumlah_kader', 'Jumlah Kader', 'trim|required|xss_clean');
		$val->set_rules('rt', 'RT', 'trim|required|xss_clean');
		$val->set_rules('rw', 'RW', 'trim|required|xss_clean');
		$val->set_rules('alamat', 'Alamat', 'trim|required|xss_clean');
		$val->set_rules('jenis_posyandu', 'Jenis Posyandu', 'trim|required|xss_clean');
				
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
				//'KD_PROPINSI' => $val->set_value('provinsi'),
				//'KD_KABUPATEN' => $val->set_value('kabupaten_kota'),
				//'KD_KECAMATAN' => $val->set_value('kecamatan'),
				'KD_KELURAHAN' => $val->set_value('desa_kelurahan'),
				'NAMA_POSYANDU' => $val->set_value('nama_posyandu'),
				'JUMLAH_KADER' => $val->set_value('jumlah_kader'),
				'JENIS_POSYANDU' => $val->set_value('jenis_posyandu'),
				'ALAMAT' => $val->set_value('alamat'),
				'RT' => $this->input->post('rt',true),
				'RW' => $this->input->post('rw',true),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);
			
			$id=$this->input->post('ID',true);
			
			$db->where('ID',$id);
			$db->update('t_posyandu', $dataexc);
			
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
		$this->load->helper('beries_helper');
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select t.*,p.PROVINSI,k.KABUPATEN,kc.KECAMATAN,kl.KELURAHAN 
						from t_posyandu t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('t_posyandu/v_posyandu_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from t_posyandu where ID = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select t.*,p.PROVINSI,k.KABUPATEN,kc.KECAMATAN,kl.KELURAHAN 
						from t_posyandu t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('t_posyandu/v_posyandu_detail',$data);
	}
	
}

/* End of file c_posyandu.php */
/* Location: ./application/controllers/c_posyandu.php */