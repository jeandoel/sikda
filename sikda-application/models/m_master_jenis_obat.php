<?php
class M_master_jenis_obat extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMasterjenisobat($params)
  {
		$this->db->select("KD_JNS_OBT,JENIS_OBAT,KD_JNS_OBT as id", false );
		$this->db->from('apt_mst_jenis_obat u');
		if ($params['jnsobat']){
			$this->db->where ('u.JENIS_OBAT like', '%'.$params['jnsobat'].'%');
		}
		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_JNS_OBT '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMasterjenisobat($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('apt_mst_jenis_obat u');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
