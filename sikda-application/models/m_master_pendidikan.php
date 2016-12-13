<?php
class M_master_pendidikan extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMaster_pendidikan($params)
  {
		$this->db->select("KD_PENDIDIKAN, KD_PENDIDIKAN as id, PENDIDIKAN, KD_PENDIDIKAN as kode", false );
		$this->db->from('mst_pendidikan');
		
		if ($params['kodependidikan']){
			$this->db->where('PENDIDIKAN like', '%'.$params['kodependidikan'].'%');	
		} 	
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_PENDIDIKAN'.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMaster_pendidikan($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_pendidikan');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
