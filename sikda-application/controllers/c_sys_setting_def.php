<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_sys_setting_def extends CI_Controller {
	public function index()
	{
		$this->load->view('sysSettingdef/v_sys_setting_def');
	}
	
	public function syssettingdefpopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('sysSettingdef/v_sys_setting_def_popup',$data);
	}
	
	public function syssettingdefxml()
	{
		$this->load->model('m_sys_setting_def');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama')
					);
					
		$total = $this->m_sys_setting_def->totalsyssettingdef($paramstotal);
		
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
					
		$result = $this->m_sys_setting_def->getsyssettingdef($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->helper('my_helper');
		$db = $this->load->database('sikda',true);
		
		$data['agama'] = $db->query("select * from mst_agama")->result_array();
		$data['jenispasien'] = $db->query("select * from mst_kel_pasien")->result_array();
		$data['marital'] = $db->query("select * from mst_status_marital")->result_array();
		$data['pekerjaan'] = $db->query("select * from mst_pekerjaan")->result_array();
		$data['pendidikan'] = $db->query("select * from mst_pendidikan")->result_array();
		$data['unitpelayanan'] =  $db->query("select * from mst_unit_pelayanan")->result_array();
		$data['carabayar'] = array();
		$data['poli'] = $db->query("select * from mst_unit where PARENT=2")->result_array();
		$data['bayar'] = $db->query("select * from mst_cara_bayar")->result_array();
		
		$this->load->view('sysSettingdef/v_sys_setting_def_add',$data);
	}
	
	public function changeCombo() {
	$db = $this->load->database('sikda',true);
		
	if($_POST){
			$kdcustom = $_POST['idjenispasien'];
			if ($kdcustom){
				$db->select('KD_BAYAR,CARA_BAYAR');
				$db->from('mst_cara_bayar');
				$db->where('KD_CUSTOMER',$kdcustom);
				$carabayar = $db->get()->result_array();
			}
		}
		
		$change = '<select data-placeholder="Pilih" name="cara_bayar" id="idcarabayar" style="width:203px">';
		foreach($carabayar as $d) {
		$change.= '<option value="'.$d['KD_BAYAR'].'" >'.$d['CARA_BAYAR'].'</option>';
		}
		$change .= '</select>';
		
		echo $change;
	}
	
	public function transData($dataexc,$val,$action)
	{
		$db = $this->load->database('sikda',true);
		$fielddata = $dataexc;
		$n=0;
		foreach ($fielddata as $k=>$j){			
			
			switch($val->set_value('level'))
			{
			case 'PUSKESMAS':
				$default[] = array(
					'LEVEL'=>$val->set_value('level'),
					'PUSKESMAS'=>$val->set_value('kd_puskesmas'),
					'KEY_DATA' => $k,
					'KEY_VALUE' => $j				
				);
			  break;
			case 'KABUPATEN':
			  $default[] = array(
					'LEVEL'=>$val->set_value('level'),
					'PUSKESMAS'=>$val->set_value('kd_kabkota'),
					'KEY_DATA' => $k,
					'KEY_VALUE' => $j				
				);
			  break;
			default:
			  $default[] = array(
					'LEVEL'=>$val->set_value('level'),
					'PUSKESMAS'=>$val->set_value('kd_puskesmas'),
					'KEY_DATA' => $k,
					'KEY_VALUE' => $j				
				);
			} 			
				
			if($action=='addprocess'){
				$default[$n]['ninput_oleh'] = $this->session->userdata('nusername');
				$default[$n]['ninput_tgl'] = date('Y-m-d H:i:s');				
			}
			if($action=='editprocess'){
				$default[$n]['nupdate_oleh'] = $this->session->userdata('nusername');
				$default[$n]['nupdate_tgl'] = date('Y-m-d H:i:s');				
			}
			if ($k=='nupdate_tgl') break;
			elseif ($k=='nupdate_oleh') break;
			elseif ($k=='ninput_oleh') break;
			elseif ($k=='ninput_tgl') break;
			$datadef = $default;
			$n++;
		}
		
		if($this->input->post('level')=='PUSKESMAS'){
			$kelurahan = $db->query("select KD_KELURAHAN from sys_setting_def_dw where KD_PUSKESMAS='".$_POST["kd_puskesmas"]."'")->result_array();
			if ($kelurahan == null){
				die('Silahkan Input Setting Dalam Wilayah Terlebih Dahulu');
			}else{
				foreach($kelurahan as $a=>$b){
					$lurah[] = implode("|",$b);
				}
				$datasetting = array(
					'PUSKESMAS' => $val->set_value('kd_puskesmas'),
					'KEY_DATA' => 'DALAM_WILAYAH',
					'KEY_VALUE' => implode("|",$lurah),
					'ninput_oleh' => $this->session->userdata('nusername'),
					'ninput_tgl' => date('Y-m-d H:i:s')
				);
				
				$db->insert('sys_setting', $datasetting);
			}
		}
		$db->insert_batch('sys_setting', $datadef);
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('level', 'Level', 'trim|required|xss_clean');
		$val->set_rules('kd_prov', 'Kode Provinsi', 'trim|required|xss_clean');
		$val->set_rules('kd_kabkota', 'Kode Kabupaten/Kota', 'trim|required|xss_clean');
		/*$val->set_rules('server_dinkes_kabkota', 'Server Dinas Kesehatan Kabupaten/Kota');
		$val->set_rules('server_dinkes_prov', 'Server Dinas Kesehatan Provinsi');
		$val->set_rules('server_kemkes', 'Server Kementrian Kesehatan');*/
		if($this->input->post('level')!=='KABUPATEN'){
			$val->set_rules('kd_puskesmas', 'Kode Puskesmas', 'trim|required|xss_clean');
			$val->set_rules('nama_puskesmas', 'Nama Puskesmas', 'trim|required|xss_clean');
			$val->set_rules('alamat', 'Alamat', 'trim|required|xss_clean');
			$val->set_rules('kd_kec', 'Kode Kecamatan', 'trim|required|xss_clean');
			if($this->input->post('level')=='PUSKESMAS'){
				$val->set_rules('nama_pimpinan', 'Nama Pimpinan', 'trim|required|xss_clean');
				$val->set_rules('nip', 'NIP');
			}
		}
				
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
			$puskesmas = $this->session->userdata('kd_puskesmas');
			$kd123 = 0;
			$kd123 = $db->query("select max(substr(KD_SUB_LEVEL,13,1)) AS total from sys_setting_def")->row();
			$kd123 = $kd123->total + 1;
			$dataexc = array(
				'LEVEL' => $val->set_value('level'),
				'KD_PROV' => $val->set_value('kd_prov'),
				'KD_KABKOTA' => $val->set_value('kd_kabkota'),
				'SERVER_DINKES_KAB_KOTA' => $this->input->post('server_dinkes_kabkota'),
				'SERVER_DINKES_PROV' => $this->input->post('server_dinkes_prov'),
				'SERVER_KEMKES' => $this->input->post('server_kemkes'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			if($this->input->post('level')!=='KABUPATEN'){//die('puskesmas');
				$dataexc['KD_PUSKESMAS'] = $val->set_value('kd_puskesmas');
				$dataexc['NAMA_PUSKESMAS'] = $val->set_value('nama_puskesmas');
				$dataexc['ALAMAT'] = $val->set_value('alamat');
				$dataexc['ALAMAT'] = $val->set_value('alamat');
				$dataexc['KD_SUB_LEVEL'] = $puskesmas.'-'.$kd123;
				$dataexc['KD_KEC'] = $val->set_value('kd_kec');
				if($this->input->post('nama_pustu')){$dataexc['NAMA_SUB_LEVEL'] = $this->input->post('nama_pustu');}
				elseif($this->input->post('nama_polindes')){$dataexc['NAMA_SUB_LEVEL'] = $this->input->post('nama_polindes');}
				elseif($this->input->post('nama_bidan')){$dataexc['NAMA_SUB_LEVEL'] = $this->input->post('nama_bidan');}
				elseif($this->input->post('nama_pusling')){$dataexc['NAMA_SUB_LEVEL'] = $this->input->post('nama_pusling');}
				if($this->input->post('level')=='PUSKESMAS'){
					$dataexc['NAMA_PIMPINAN'] = $val->set_value('nama_pimpinan');
					$dataexc['NIP'] = $val->set_value('nip');
				}
			}
				
			$this->transData($dataexc,$val,'addprocess');
			
			$db->insert('sys_setting_def', $dataexc);
				
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
		$val->set_rules('kd_prov', 'Kode Provinsi', 'trim|required|xss_clean');
		$val->set_rules('kd_kabkota', 'Kode Kabupaten/Kota', 'trim|required|xss_clean');
		$val->set_rules('kd_kec', 'Kode Kecamatan', 'trim|required|xss_clean');
		$val->set_rules('kd_puskesmas', 'Kode Puskesmas', 'trim|required|xss_clean');
		$val->set_rules('nama_puskesmas', 'Nama Puskesmas', 'trim|required|xss_clean');
		$val->set_rules('alamat', 'Alamat', 'trim|required|xss_clean');
		$val->set_rules('nama_pimpinan', 'Nama Pimpinan', 'trim|required|xss_clean');
		$val->set_rules('nip', 'NIP');		
		$val->set_rules('level', 'Level', 'trim|required|xss_clean');
		/*
		$val->set_rules('agama', 'Agama', 'trim|required|xss_clean');
		$val->set_rules('cara_bayar', 'Cara Bayar');
		$val->set_rules('jenis_pasien', 'Jenis Pasien', 'trim|required|xss_clean');
		$val->set_rules('marital', 'Marital', 'trim|required|xss_clean');
		$val->set_rules('pekerjaan', 'Pekerjaan', 'trim|required|xss_clean');
		$val->set_rules('pendidikan', 'Pendidikan', 'trim|required|xss_clean');
		$val->set_rules('poli', 'Poli', 'trim|required|xss_clean');
		$val->set_rules('gender', 'Gender', 'trim|required|xss_clean');
		$val->set_rules('suku', 'Suku', 'trim|required|xss_clean');
		$val->set_rules('unit_pelayanan', 'Unit pelayanan', 'trim|required|xss_clean');
		$val->set_rules('server_dinkes_kabkota', 'Server Dinas Kesehatan Kabupaten/Kota', 'trim|required|xss_clean');
		$val->set_rules('server_dinkes_prov', 'Server Dinas Kesehatan Provinsi', 'trim|required|xss_clean');
		$val->set_rules('server_kemkes', 'Server Kementrian Kesehatan', 'trim|required|xss_clean');
		*/
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
				'KD_PROV' => $val->set_value('kd_prov'),
				'KD_KABKOTA' => $val->set_value('kd_kabkota'),
				'KD_KEC' => $val->set_value('kd_kec'),
				'KD_PUSKESMAS' => $val->set_value('kd_puskesmas'),
				'NAMA_PUSKESMAS' => $val->set_value('nama_puskesmas'),
				'ALAMAT' => $val->set_value('alamat'),
				'NAMA_PIMPINAN' => $val->set_value('nama_pimpinan'),
				'NIP' => $val->set_value('nip'),
				'LEVEL' => $val->set_value('level'),
				'SERVER_DINKES_KAB_KOTA' => $this->input->post('server_dinkes_kabkota'),
				'SERVER_DINKES_PROV' => $this->input->post('server_dinkes_prov'),
				'SERVER_KEMKES' => $this->input->post('server_kemkes'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);
	
			$sysSetting = $db->query("select KD_PUSKESMAS from sys_setting_def where KD_SETTING = '".$id."'")->result_array();
			foreach($sysSetting as $a=>$setting){
				$db->query("delete from sys_setting where PUSKESMAS= '".$setting['KD_PUSKESMAS']."'");
			}
			
			$this->transData($dataexc,$val,'editprocess');
			
			$db->where('KD_SETTING',$id);
			$db->update('sys_setting_def', $dataexc);
			
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
		$this->load->helper('my_helper');
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;

		$db = $this->load->database('sikda', TRUE);
		$db->select('a.*,b.PROVINSI,c.KABUPATEN,d.KECAMATAN,e.RAS');
		$db->from('sys_setting_def a');
		$db->join('mst_provinsi b','b.KD_PROVINSI=a.KD_PROV','left');
		$db->join('mst_kabupaten c','c.KD_KABUPATEN=a.KD_KABKOTA','left');
		$db->join('mst_kecamatan d','d.KD_KECAMATAN=a.KD_KEC','left');
		$db->join('mst_ras e','e.KD_RAS=a.SUKU','left');
		$db->where('KD_SETTING', $id);
		$val = $db->get()->row();
		$data['data']=$val;
		$data['poli'] = $db->query("select * from mst_unit where PARENT=2")->result_array();
		$data['agama'] =$db->query("select * from mst_agama")->result_array();
		$data['jenispasien'] = $db->query("select * from mst_kel_pasien")->result_array();
		$data['marital'] = $db->query("select * from mst_status_marital")->result_array();
		$data['pekerjaan'] = $db->query("select * from mst_pekerjaan")->result_array();
		$data['pendidikan'] = $db->query("select * from mst_pendidikan")->result_array();
		$data['unitpelayanan'] = $db->query("select * from mst_unit_pelayanan")->result_array();
		$data['bayar'] = $db->query("select * from mst_cara_bayar")->result_array();
		$data['carabayar'] = array();		
		$this->load->view('sysSettingdef/v_sys_setting_def_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$sysSetting = $db->query("select KD_PUSKESMAS from sys_setting_def where KD_SETTING = '".$id."'")->result_array();
		foreach($sysSetting as $a=>$setting){
			$db->query("delete from sys_setting where PUSKESMAS= '".$setting['KD_PUSKESMAS']."'");
		}
		if($db->query("delete from sys_setting_def where KD_SETTING = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select('a.*,b.PROVINSI,c.KABUPATEN,d.KECAMATAN,e.RAS,f.PEKERJAAN as KERJA,g.PENDIDIKAN as DIDIK,h.AGAMA,i.CARA_BAYAR as CARA,j.CUSTOMER,k.UNIT,l.STATUS');
		$db->from('sys_setting_def a');
		$db->join('mst_provinsi b','b.KD_PROVINSI=a.KD_PROV', 'left');
		$db->join('mst_kabupaten c','c.KD_KABUPATEN=a.KD_KABKOTA', 'left');
		$db->join('mst_kecamatan d','d.KD_KECAMATAN=a.KD_KEC', 'left');
		$db->join('mst_ras e','e.KD_RAS=a.SUKU', 'left');
		$db->join('mst_pekerjaan f','f.KD_PEKERJAAN=a.PEKERJAAN', 'left');
		$db->join('mst_pendidikan g','g.KD_PENDIDIKAN=a.PENDIDIKAN', 'left');
		$db->join('mst_agama h','h.KD_AGAMA=a.AGAMA', 'left');
		$db->join('mst_cara_bayar i','i.KD_BAYAR=a.CARA_BAYAR', 'left');
		$db->join('mst_kel_pasien j','j.KD_CUSTOMER=a.JENIS_PASIEN', 'left');
		$db->join('mst_unit k','k.KD_UNIT=a.POLI', 'left');
		$db->join('mst_status_marital l','l.KD_STATUS=a.MARITAL', 'left');
		$db->where('KD_SETTING', $id);
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('sysSettingdef/v_sys_setting_def_detail',$data);
	}
	
}

/* End of file c_sys_setting_def.php */
/* Location: ./application/controllers/c_sys_setting_def.php */
