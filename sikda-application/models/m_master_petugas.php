<?php
class M_master_petugas extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getPetugas($params)
  {
		$this->db->select("Kd_Petugas,Nm_Petugas,Unit,Kd_Petugas as nid", false );
		$this->db->from('mst_petugas u');
		if($params['nama']){
		$this->db->where('u.Nm_Petugas like' ,$params['nama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('Kd_Petugas '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalPetugas($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_petugas u');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
