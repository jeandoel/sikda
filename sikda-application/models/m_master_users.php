<?php
class M_master_users extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMasterusers($params)
  {
		$this->db->select("a.KD_USER,c.KD_PUSKESMAS,a.USER_NAME,a.FULL_NAME,a.USER_DESC,a.USER_PASSWORD,a.USER_PASSWORD2,a.EMAIL,b.group_id,a.MUST_CHG_PASS,a.CANNOT_CHG_PASS,a.PASS_NEVER_EXPIRES,a.ACC_DISABLED,a.ACC_LOCKED_OUT,a.ACC_EXPIRES,a.END_OF_EXPIRES,a.LAST_LOGON,a.BAD_LOGON_ATTEMPS,KD_USER as id", false );
		$this->db->from('users a');
		$this->db->join('user_group b','b.group_id=a.GROUP_ID','left');
		$this->db->join('mst_puskesmas c','c.KD_PUSKESMAS=a.KD_PUSKESMAS','left');
		if($this->session->userdata('group_id')!=='kabupaten'){
			$this->db->where('a.kd_puskesmas',$this->session->userdata('kd_puskesmas'));
			$this->db->not_like('a.group_id','kabupaten');
		}else{
			$this->db->where('KD_KABUPATEN',$this->session->userdata('kd_kabupaten'));
		}
		if ($params['user']){
			$this->db->where ('a.USER_NAME like', '%'.$params['user'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_USER '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMasterusers($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('users a');
		if($this->session->userdata('group_id')!=='kabupaten'){
			$this->db->where('a.kd_puskesmas',$this->session->userdata('kd_puskesmas'));
			$this->db->not_like('a.group_id','kabupaten');
		}else{
			$this->db->where('KD_KABUPATEN',$this->session->userdata('kd_kabupaten'));
		}
		if ($params['user']){
			$this->db->where ('a.USER_NAME like', '%'.$params['user'].'%');
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
