<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_users extends CI_Controller {
	public function index()
	{
		$this->load->view('masterUsers/v_master_users');
	}
	
	
	public function masterusersxml()
	{
		$this->load->model('m_master_users');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'user'=>$this->input->post('user')
					);
					
		$total = $this->m_master_users->totalMasterusers($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'user'=>$this->input->post('user')
					);
					
		$result = $this->m_master_users->getMasterusers($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		
		$this->load->helper('my_helper');
		$this->load->helper('beries_helper');
		$this->load->view('masterUsers/v_master_users_add');
	}
	
	public function addprocess()
	{
	//print_r($_POST);die;
		$this->load->library('form_validation');

		$val = $this->form_validation;
		if($this->input->post('showhide_level')=='KABUPATEN'){
			$val->set_rules('provinsi', 'Provinsi', 'trim|required|xss_clean');
			$val->set_rules('kabupaten', 'Kabupaten', 'trim|required|xss_clean');
		}if($this->input->post('showhide_level')=='PUSKESMAS'){
			$val->set_rules('nama_puskesmas', 'Puskesmas', 'trim|required|xss_clean');
		}if($this->input->post('showhide_level')=='PUSTU'){
			$val->set_rules('pustu', 'Pustu', 'trim|required|xss_clean');
		}if($this->input->post('showhide_level')=='POLINDES'){
			$val->set_rules('polindes', 'Pustu', 'trim|required|xss_clean');
		}if($this->input->post('showhide_level')=='BIDAN_DESA'){
			$val->set_rules('bidan_desa', 'Bidan Desa', 'trim|required|xss_clean');
		}if($this->input->post('showhide_level')=='PUSLING'){
			$val->set_rules('bidan_desa', 'Bidan Desa', 'trim|required|xss_clean');
		}else{
			
			$val->set_rules('kduser', 'Kode User', 'trim|required|xss_clean');
			$val->set_rules('idgroup', 'Id Group', 'trim|required|xss_clean');
			$val->set_rules('username', 'User Name', 'trim|required|xss_clean');
			$val->set_rules('fullname', 'Full Name','trim|required|xss_clean');
			$val->set_rules('userpassword', 'User Password','trim|required|xss_clean');
			$val->set_rules('email', 'E mail','trim|required|xss_clean|valid_email');
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
			
			$dataexc = array(
					'KD_USER' => $this->input->post('kduser'),
					'GROUP_ID' => $this->input->post('idgroup'),
					'USER_NAME' => $this->input->post('username'),
					'FULL_NAME' => $this->input->post('fullname'),
					'USER_PASSWORD' => $this->input->post('userpassword'),
					'EMAIL' => $this->input->post('email'),
					'LEVEL' => $this->input->post('showhide_level')
			);
			if($this->input->post('showhide_level')=='KABUPATEN'){
				$dataexc['KD_PROVINSI'] = $this->input->post('provinsi');		
				$dataexc['KD_KABUPATEN'] = $this->input->post('kabupaten');					
			}if($this->input->post('showhide_level')=='PUSKESMAS'){
				$dataexc['KD_PROVINSI'] = $this->input->post('provinsi');	
				$dataexc['KD_KABUPATEN'] = $this->input->post('kabupaten');	
				$dataexc['KD_KECAMATAN'] = $this->input->post('kecamatan');	
				$dataexc['KD_KELURAHAN'] = $this->input->post('desa_kelurahan');	
				$dataexc['KD_PUSKESMAS'] = $this->input->post('nama_puskesmas');			
			}if($this->input->post('showhide_level')=='PUSTU'){
				$dataexc['KD_PROVINSI'] = $this->input->post('provinsi');	
				$dataexc['KD_KABUPATEN'] = $this->input->post('kabupaten');	
				$dataexc['KD_KECAMATAN'] = $this->input->post('kecamatan');	
				$dataexc['KD_KELURAHAN'] = $this->input->post('desa_kelurahan');
				$dataexc['KD_PUSKESMAS'] = $this->input->post('nama_puskesmas');	
				$dataexc['KD_SUB_LEVEL'] = $this->input->post('pustu');	
			}if($this->input->post('showhide_level')=='POLINDES'){
				$dataexc['KD_PROVINSI'] = $this->input->post('provinsi');	
				$dataexc['KD_KABUPATEN'] = $this->input->post('kabupaten');	
				$dataexc['KD_KECAMATAN'] = $this->input->post('kecamatan');	
				$dataexc['KD_KELURAHAN'] = $this->input->post('desa_kelurahan');
				$dataexc['KD_PUSKESMAS'] = $this->input->post('nama_puskesmas');	
				$dataexc['KD_SUB_LEVEL'] = $this->input->post('polindes');	
			}if($this->input->post('showhide_level')=='BIDAN_DESA'){
				$dataexc['KD_PROVINSI'] = $this->input->post('provinsi');	
				$dataexc['KD_KABUPATEN'] = $this->input->post('kabupaten');	
				$dataexc['KD_KECAMATAN'] = $this->input->post('kecamatan');	
				$dataexc['KD_KELURAHAN'] = $this->input->post('desa_kelurahan');
				$dataexc['KD_PUSKESMAS'] = $this->input->post('nama_puskesmas');	
				$dataexc['KD_SUB_LEVEL'] = $this->input->post('bidan_desa');	
			}if($this->input->post('showhide_level')=='PUSLING'){
				$dataexc['KD_PROVINSI'] = $this->input->post('provinsi');	
				$dataexc['KD_KABUPATEN'] = $this->input->post('kabupaten');	
				$dataexc['KD_KECAMATAN'] = $this->input->post('kecamatan');	
				$dataexc['KD_KELURAHAN'] = $this->input->post('desa_kelurahan');
				$dataexc['KD_PUSKESMAS'] = $this->input->post('nama_puskesmas');	
				$dataexc['KD_SUB_LEVEL'] = $this->input->post('pusling');	
			}else{
			
				'DB_INSERT_OK';
				
			}
			//print_r($dataexc);die;
			$db->insert('users', $dataexc);
			
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
		$val->set_rules('kduser', 'Kd User', 'trim|required|xss_clean');
		if($this->session->userdata('group_id')=='all'){
			$val->set_rules('kdpuskesmas', 'Kd Puskesmas', 'trim|required|xss_clean');
		}
		$val->set_rules('username', 'User Name', 'trim|required|xss_clean');
		$val->set_rules('fullname', 'Full Name','trim|required|xss_clean');
		$val->set_rules('userdesc', 'User Desc');
		$val->set_rules('userpassword', 'User Password','trim|required|xss_clean');
		$val->set_rules('userpassword2', 'User Password 2');
		$val->set_rules('email', 'E mail','trim|required|xss_clean|valid_email');
		$val->set_rules('idgroup', 'Id Group', 'trim|required|xss_clean');
		$val->set_rules('mustchgpass', 'Must Chg Pass');
		$val->set_rules('cannotchgpass', 'Cannot Chg Pass');
		$val->set_rules('passneverexpires', 'Pass Never Expires');
		$val->set_rules('accdisabled', 'Acc Disabled');
		$val->set_rules('acclockedout', 'Acc Locked Out');
		$val->set_rules('accexpires', 'Acc Expires');
		$val->set_rules('endofexpires', 'End Of Expires');
		$val->set_rules('lastlogon', 'Deskripsi');
		$val->set_rules('badlogonattemps', 'Bad Logon Attemps');

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
				'KD_USER' => $val->set_value('kduser'),
				'USER_NAME' => $val->set_value('username'),
				'FULL_NAME' => $val->set_value('fullname'),
				'USER_DESC' => $val->set_value('userdesc'),
				'USER_PASSWORD' => $val->set_value('userpassword'),
				'USER_PASSWORD2' => $val->set_value('userpassword2'),
				'EMAIL' => $val->set_value('email'),
				'GROUP_ID' => $val->set_value('idgroup'),
				'MUST_CHG_PASS' => $val->set_value('mustchgpass'),
				'CANNOT_CHG_PASS' => $val->set_value('cannotchgpass'),
				'PASS_NEVER_EXPIRES' => $val->set_value('passneverexpires'),
				'ACC_DISABLED' => $val->set_value('accdisabled'),
				'ACC_LOCKED_OUT' => $val->set_value('acclockedout'),
				'ACC_EXPIRES' => $val->set_value('accexpires'),
				'END_OF_EXPIRES' => $val->set_value('endofexpires'),
				'LAST_LOGON' => $val->set_value('lastlogon'),
				'BAD_LOGON_ATTEMPS' => $val->set_value('badlogonattemps'),
				'Updated_BY' => $this->session->userdata('nusername'),
				'Updated_Datetime' => date('Y-m-d H:i:s')
			);
			if($this->session->userdata('group_id')=='all'){
				$dataexc['KD_PUSKESMAS'] = $val->set_value('kdpuskesmas');
			}else{
				$dataexc['KD_KABUPATEN'] = $this->input->post('kd_kabupaten');
			}
			$db->where('KD_USER',$id);
			$db->update('users', $dataexc);
			
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
		$db->select("a.KD_USER,a.LEVEL,a.KD_KABUPATEN,a.KD_PUSKESMAS,a.USER_NAME,a.FULL_NAME,a.USER_DESC,a.USER_PASSWORD,a.USER_PASSWORD2,a.EMAIL,a.GROUP_ID,a.MUST_CHG_PASS,a.CANNOT_CHG_PASS,a.PASS_NEVER_EXPIRES,a.ACC_DISABLED,a.ACC_LOCKED_OUT,a.ACC_EXPIRES,a.END_OF_EXPIRES,a.LAST_LOGON,a.BAD_LOGON_ATTEMPS,b.group_id as id_group,b.group_name as nama_group,c.KD_PUSKESMAS as kd_puskesmas,c.PUSKESMAS as nama_puskesmas");
		$db->from('users a');
		$db->join('user_group b','b.group_id=a.GROUP_ID','left');
		$db->join('mst_puskesmas c','c.KD_PUSKESMAS=a.KD_PUSKESMAS','left');
		$db->where('a.KD_USER',$id);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('masterUsers/v_master_users_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from users where KD_USER = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("a.KD_USER,a.LEVEL,a.KD_PUSKESMAS,a.USER_NAME,a.FULL_NAME,a.USER_DESC,a.USER_PASSWORD,a.USER_PASSWORD2,a.EMAIL,a.GROUP_ID,a.MUST_CHG_PASS,a.CANNOT_CHG_PASS,a.PASS_NEVER_EXPIRES,a.ACC_DISABLED,a.ACC_LOCKED_OUT,a.ACC_EXPIRES,a.END_OF_EXPIRES,a.LAST_LOGON,a.BAD_LOGON_ATTEMPS,b.group_id as id_group,b.group_name as nama_group,c.KD_PUSKESMAS as kd_puskesmas,c.PUSKESMAS as nama_puskesmas");
		$db->from('users a');
		$db->join('user_group b','b.group_id=a.GROUP_ID','left');
		$db->join('mst_puskesmas c','c.KD_PUSKESMAS=a.KD_PUSKESMAS','left');
		$db->where('a.KD_USER',$id);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('masterUsers/v_master_users_detail',$data);
	}
	
}

/* End of file masteruser.php */
/* Location: ./application/controllers/masteruser.php */
