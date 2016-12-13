<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller {

	public function index()
	{	
		if($this->session->userdata('logged')==true){
			redirect('dashboard','location');exit;
		}
		$db = $this->load->database('sikda', TRUE);
		$pusk = $db->query("SELECT kd_puskesmas, NAMA_PUSKESMAS FROM sys_setting_def WHERE kd_puskesmas IS NOT NULL GROUP BY kd_puskesmas")->result();
		$data['pusk'] = $pusk;
		$this->load->view('login',$data);
	}

	public function patchdatabase(){
		$this->load->model('m_migration');
		$this->m_migration->fixDB1();
	}
	
	public function checksession()
	{			
		if($this->session->userdata('logged')==true){
			die('ok');
		}else{
			die('not');
		}
	}
	
	public function mlogout()
	{	
		$sess_data = array ('nid_user'=>NULL,
							'user_name'=>NULL,
							'nusername'=>NULL,
							'nrole'=>NULL,
							'nemail'=>NULL,
							'puskesmas'=>NULL,
							'kd_puskesmas'=>NULL,
							'group_id'=>NULL,
							'group_name'=>NULL,
							'kd_petugas'=>NULL,
							'nama_propinsi'=>NULL,
							'nama_kabupaten'=>NULL,
							'nama_kecamatan'=>NULL,
							'nama_kelurahan'=>NULL,
							'kd_propinsi'=>NULL,
							'kd_kabupaten'=>NULL,
							'kd_kecamatan'=>NULL,
							'kd_kelurahan'=>NULL,
							'logged'=>false
							);
		$this->session->unset_userdata($sess_data);
		redirect('/','location');exit;
	}
	
	public function mlogin()
	{		
		$not='';
		$this->load->library('form_validation');
		$val = $this->form_validation;
		$val->set_rules('username', 'Username', 'trim|required|xss_clean');
		$val->set_rules('password', 'Password', 'trim|required|xss_clean');		
		$db = $this->load->database('sikda', TRUE);
		$whr = '';
		$chkgrp = $db->query("select GROUP_ID,KD_PUSKESMAS from users where USER_NAME ='".$this->input->post('username')."' and USER_PASSWORD = '".$this->input->post('password')."'")->row();#DIE($chkgrp->GROUP_ID);
		if(!empty($chkgrp)){
			if($chkgrp->GROUP_ID !== 'kabupaten'){
				$chksys = $db->query("select PUSKESMAS from sys_setting where PUSKESMAS ='".$chkgrp->KD_PUSKESMAS."'")->row();
				if(!empty($chksys->PUSKESMAS)){
					$val->set_rules('kd_puskesmas', 'Puskesmas', 'trim|required|xss_clean');	
					$whr = $db->where('p.KD_PUSKESMAS ',$this->input->post('kd_puskesmas'));
				}else{
					$not='Silahkan setting aplikasi terlebih dahulu';
				}
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
			$username = $val->set_value('username');
			$password = $val->set_value('password');
			$db->select("u.*, p.KD_PUSKESMAS,p.PUSKESMAS,g.group_name,pr.PROVINSI,kb.KABUPATEN,kc.KECAMATAN,kl.KELURAHAN");
			$db->from('users u');
			$db->join('mst_puskesmas p','p.KD_PUSKESMAS = u.KD_PUSKESMAS','left');
			$db->join('user_group g','g.group_id = u.GROUP_ID');
			$db->join('mst_provinsi pr','pr.KD_PROVINSI = u.KD_PROVINSI','left');
			$db->join('mst_kabupaten kb','kb.KD_KABUPATEN = u.KD_KABUPATEN','left');
			$db->join('mst_kecamatan kc','kc.KD_KECAMATAN = u.KD_KECAMATAN','left');
			$db->join('mst_kelurahan kl','kl.KD_KELURAHAN = u.KD_KELURAHAN','left');
			$db->where('u.USER_NAME ',$username);
			$db->where('u.USER_PASSWORD ',$password);
			$user = $db->get()->row();#die($db->last_query());
			if($user){
				$db->select("s.KEY_DATA,s.KEY_VALUE");
				$db->from('sys_setting s');
				if($user->LEVEL!=='KABUPATEN'){
				$db->where('s.PUSKESMAS ',$user->KD_PUSKESMAS);
				}else{
				$db->where('s.LEVEL ','KABUPATEN');
				$db->where('s.PUSKESMAS ',$user->KD_KABUPATEN);
				}
				$detail_user = $db->get()->result_array();#die($db->last_query());
				$sess_data = array ('nid_user'=>$user->KD_USER,
								'user_name'=>$user->USER_NAME,
								'nusername'=>$user->USER_NAME,
								'group_id'=>$user->GROUP_ID,
								'group_name'=>$user->group_name,
								'email'=>$user->EMAIL,
								'puskesmas'=>$user->PUSKESMAS,
								'kd_puskesmas'=>$user->KD_PUSKESMAS,
								'kd_petugas'=>$user->USER_NAME,
								'nama_propinsi'=>$user->PROVINSI,
								'nama_kabupaten'=>$user->KABUPATEN,
								'nama_kecamatan'=>$user->KECAMATAN,
								'nama_kelurahan'=>$user->KELURAHAN,
								'kd_propinsi'=>$user->KD_PROVINSI,
								'kd_kabupaten'=>$user->KD_KABUPATEN,
								'kd_kecamatan'=>$user->KD_KECAMATAN,
								'kd_kelurahan'=>$user->KD_KELURAHAN,
								'logged'=>true
								);
				foreach($detail_user as $data=>$value){
					if($value['KEY_DATA']=='KD_PROV') $sess_data['kd_provinsi']=$value['KEY_VALUE'];
					if($value['KEY_DATA']=='KD_KABKOTA') $sess_data['kd_kabupaten']=$value['KEY_VALUE'];
					if($value['KEY_DATA']=='KD_KEC') $sess_data['kd_kecamatan']=$value['KEY_VALUE'];
					if($value['KEY_DATA']=='DALAM_WILAYAH') $sess_data['DW']=$value['KEY_VALUE'];
					if($value['KEY_DATA']=='LEVEL') $sess_data['level_aplikasi']=$value['KEY_VALUE'];
				}
				
				$this->session->set_userdata($sess_data);
				$user = $db->query("update users set LAST_LOGON=now() where USER_NAME = '".$username."' and USER_PASSWORD = '".$password."' ");
				die('OK_'.$not);
			}else{
				die('Username atau Password atau Puskesmas tidak Sesuai');
			}
		}			
	}	
}

/* End of file dashboard.php */
/* Location: ./sikdaapplication/controllers/login.php */