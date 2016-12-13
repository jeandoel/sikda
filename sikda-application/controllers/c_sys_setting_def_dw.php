<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_sys_setting_def_dw extends CI_Controller {
	public function index()
	{
		$this->load->view('sysSettingdefdw/v_sys_setting_def_dw');
	}
	
	
	public function sys_setting_def_dw_xml()
	{
		$this->load->model('m_sys_setting_def_dw');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama')
					);
					
		$total = $this->m_sys_setting_def_dw->totalSys_setting_def_dw($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama')
					);
					
		$result = $this->m_sys_setting_def_dw->getSys_setting_def_dw($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('sysSettingdefdw/v_sys_setting_def_dw_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');
		$val = $this->form_validation;
		$val->set_rules('kodepuskesmas', 'Kode Puskesmas', 'trim|required|xss_clean');
		$val->set_rules('kodeprovinsi', 'Kode Provinsi', 'trim|required|xss_clean');
		$val->set_rules('kodekabupaten', 'Kode Kabupaten', 'trim|required|xss_clean');
		$val->set_rules('kodekecamatan', 'Kode Kecamatan', 'trim|required|xss_clean');
		$val->set_rules('kodekelurahan', 'Kode Kelurahan', 'trim|required|xss_clean');
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
				'KD_PROVINSI' => $val->set_value('kodeprovinsi'),
				'KD_KABUPATEN' => $val->set_value('kodekabupaten'),
				'KD_KECAMATAN' => $val->set_value('kodekecamatan'),
				'KD_KELURAHAN' => $val->set_value('kodekelurahan'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			$db->insert('sys_setting_def_dw', $dataexc);
			
			$puskesmas = $db->query("select KD_PUSKESMAS from sys_setting_def where KD_PUSKESMAS='".$_POST["kodepuskesmas"]."'");
			$kelurahan = $db->query("select KD_KELURAHAN from sys_setting_def_dw where KD_PUSKESMAS='".$_POST["kodepuskesmas"]."'")->result_array();
			if ($puskesmas!==NULL){
			foreach($kelurahan as $a=>$b){
				$lurah[] = implode("",$b);
			}
			$datasetting = array(
				'PUSKESMAS' => $val->set_value('kodepuskesmas'),
				'KEY_DATA' => 'DALAM_WILAYAH',
				'KEY_VALUE' => implode("|",$lurah),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->where('PUSKESMAS',$val->set_value('kodepuskesmas'));
			$db->where('KEY_DATA','DALAM_WILAYAH');
			$db->update('sys_setting', $datasetting);
			}
			
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
		$val->set_rules('kodepuskesmas', 'Kode Puskesmas', 'trim|required|xss_clean');
		$val->set_rules('kodeprovinsi', 'Kode Provinsi', 'trim|required|xss_clean');
		$val->set_rules('kodekabupaten', 'Kode Kabupaten', 'trim|required|xss_clean');
		$val->set_rules('kodekecamatan', 'Kode Kecamatan', 'trim|required|xss_clean');
		$val->set_rules('kodekelurahan', 'Kode Kelurahan', 'trim|required|xss_clean');
		
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
				'KD_PROVINSI' => $val->set_value('kodeprovinsi'),
				'KD_KABUPATEN' => $val->set_value('kodekabupaten'),
				'KD_KECAMATAN' => $val->set_value('kodekecamatan'),
				'KD_KELURAHAN' => $val->set_value('kodekelurahan'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('KD_DW',$id);
			$db->update('sys_setting_def_dw', $dataexc);
			
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
		$db->select("a.*, b.PUSKESMAS as namapuskesmas,c.PROVINSI as namaprovinsi,d.KABUPATEN as namakabupaten,e.KECAMATAN as namakecamatan,f.KELURAHAN as namakelurahan");
		$db->from('sys_setting_def_dw a');
		$db->join('mst_puskesmas b','b.KD_PUSKESMAS=a.KD_PUSKESMAS');
		$db->join('mst_provinsi c','c.KD_PROVINSI=a.KD_PROVINSI');
		$db->join('mst_kabupaten d','d.KD_KABUPATEN=a.KD_KABUPATEN');
		$db->join('mst_kecamatan e','e.KD_KECAMATAN=a.KD_KECAMATAN');
		$db->join('mst_kelurahan f','f.KD_KELURAHAN=a.KD_KELURAHAN');
		$db->where('a.KD_DW ',$id);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('sysSettingdefdw/v_sys_setting_def_dw_edit',$data);
	}
	
	public function delete()
	{
		$db = $this->load->database('sikda', TRUE);
		$db->trans_begin();
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$puskesmas = $db->query("select KD_PUSKESMAS from sys_setting_def_dw where KD_DW='".$id."'")->result_array();
		$db->query("delete from sys_setting_def_dw where KD_DW = '".$id."'");
		foreach($puskesmas as $p=>$kesmas){
			$kelurahan = $db->query("select KD_KELURAHAN from sys_setting_def_dw where KD_PUSKESMAS='".$kesmas['KD_PUSKESMAS']."'")->result_array();
			if ($kelurahan==NULL){
				$db->set('KEY_VALUE','');
				$db->where('PUSKESMAS',$kesmas['KD_PUSKESMAS']);
				$db->where('KEY_DATA','DALAM_WILAYAH');
				$db->update('sys_setting');
			}else{
				foreach($kelurahan as $a=>$b){
					$lurah[] = implode("|",$b);
				}
				$datasetting = array(
					'PUSKESMAS' => $kesmas['KD_PUSKESMAS'],
					'KEY_DATA' => 'DALAM_WILAYAH',
					'KEY_VALUE' => implode("|",$lurah),
					'ninput_oleh' => $this->session->userdata('nusername'),
					'ninput_tgl' => date('Y-m-d H:i:s')
				);
				$db->where('PUSKESMAS',$kesmas['KD_PUSKESMAS']);
				$db->where('KEY_DATA','DALAM_WILAYAH');
				$db->update('sys_setting', $datasetting);
				$db->trans_commit();
			}
		}
		if ($db->trans_status() === FALSE)
			{
				$db->trans_rollback();
				die(json_encode('FAIL'));
			}
			else
			{
				$db->trans_commit();
				die(json_encode('OK'));
			}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("a.*, b.PUSKESMAS as namapuskesmas,c.PROVINSI as namaprovinsi,d.KABUPATEN as namakabupaten,e.KECAMATAN as namakecamatan,f.KELURAHAN as namakelurahan");
		$db->from('sys_setting_def_dw a');
		$db->join('mst_puskesmas b','b.KD_PUSKESMAS=a.KD_PUSKESMAS','left');
		$db->join('mst_provinsi c','c.KD_PROVINSI=a.KD_PROVINSI','left');
		$db->join('mst_kabupaten d','d.KD_KABUPATEN=a.KD_KABUPATEN','left');
		$db->join('mst_kecamatan e','e.KD_KECAMATAN=a.KD_KECAMATAN','left');
		$db->join('mst_kelurahan f','f.KD_KELURAHAN=a.KD_KELURAHAN','left');
		$db->where('a.KD_DW ',$id);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('sysSettingdefdw/v_sys_setting_def_dw_detail',$data);
	}
	
}

/* End of file c_sys_setting_def_dw.php */
/* Location: ./application/controllers/c_sys_setting_def_dw.php */