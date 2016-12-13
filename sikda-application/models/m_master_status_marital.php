<?php
class M_master_status_marital extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getStatusmarital($params)
  {
		$this->db->select("KD_STATUS,STATUS,KD_STATUS as nid", false );
		$this->db->from('mst_status_marital');
		
		if($params['nama']){
			$this->db->where('STATUS like' ,$params['nama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_STATUS '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalStatusmarital($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_status_marital');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
