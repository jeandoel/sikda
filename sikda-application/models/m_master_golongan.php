<?php
class M_master_golongan extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getGolongan($params)
  {
		$this->db->select("KD_GOLONGAN,NM_GOLONGAN,KD_GOLONGAN as nid", false );
		$this->db->from('mst_golongan');
		
		if($params['nama']){
			$this->db->where('NM_GOLONGAN like' ,$params['nama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_GOLONGAN '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalGolongan($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_golongan');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
