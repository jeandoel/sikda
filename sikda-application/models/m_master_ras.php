<?php
class M_master_ras extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getRas($params)
  {
		$this->db->select("KD_RAS,RAS,KD_RAS as nid", false );
		$this->db->from('mst_ras');
		
		if($params['nama']){
			$this->db->where('RAS like' ,$params['nama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_RAS '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalRas($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_ras');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
