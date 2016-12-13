<?php
class M_master_jenis_kelamin extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMasterjk($params)
  {
		$this->db->select("KD_JENIS_KELAMIN, JENIS_KELAMIN, KD_JENIS_KELAMIN as nid", false );
		$this->db->from('mst_jenis_kelamin u');
		
		if($params['keyword'] and $params['cari']){
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_JENIS_KELAMIN '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMasterjk($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_jenis_kelamin u');
		
		if($params['cari']){
			$this->db->where('KD_JENIS_KELAMIN LIKE "%'.$params['cari'].'%" ');
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
  
  
}
