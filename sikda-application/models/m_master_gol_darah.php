<?php
class M_master_gol_darah extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMastergoldarah($params)
  {
		$this->db->select("KD_GOL_DARAH, GOL_DARAH, KD_GOL_DARAH as nid", false );
		$this->db->from('mst_gol_darah u');
		
		if($params['keyword'] and $params['cari']){
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_GOL_DARAH '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMastergoldarah($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_gol_darah u');
		
		if($params['cari']){
			$this->db->where('KD_GOL_DARAH LIKE "%'.$params['cari'].'%" ');
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
  
  
}
