<?php
class M_master_pekerjaan extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getPekerjaan($params)
  {
		$this->db->select("KD_PEKERJAAN, KD_PEKERJAAN as id, PEKERJAAN, KD_PEKERJAAN as kode", false );
		$this->db->from('mst_pekerjaan');
		
		if ($params['caripekerjaan']){
			$this->db->where('PEKERJAAN like', '%'.$params['caripekerjaan'].'%');	
		} 	
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_PEKERJAAN'.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalPekerjaan($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_pekerjaan');
		$this->db->order_by('KD_PEKERJAAN');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
