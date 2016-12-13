<?php
class M_master_user_group extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMasterusergroup($params)
  {
		$this->db->select("group_id,group_id as id,group_name,description,group_id as nid", false );
		$this->db->from('user_group u');
		
		if ($params['group']){
			$this->db->where ('u.group_name like', '%'.$params['group'].'%');
		}
		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('group_id '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMasterusergroup($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('user_group u');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
