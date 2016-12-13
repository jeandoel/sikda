<?php
class M_master_pendidikan_kesehatan extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getPenkes($params)
  {
		$this->db->select("KD_PENDIDIKAN,PENDIDIKAN,KD_PENDIDIKAN as nid", false );
		$this->db->from('mst_pendidikan_kesehatan');
		
		if($params['nama']){
			$this->db->where('PENDIDIKAN like' ,$params['nama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_PENDIDIKAN '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalPenkes($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_pendidikan_kesehatan');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
