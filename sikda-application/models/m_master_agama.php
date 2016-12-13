<?php
class M_master_agama extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMaster_agama($params)
  {
		$this->db->select("KD_AGAMA, KD_AGAMA as id, AGAMA, KD_AGAMA as kode", false );
		$this->db->from('mst_agama');
		
		if ($params['kodeagama']){
			$this->db->where('AGAMA like', '%'.$params['kodeagama'].'%');	
		} 	
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_AGAMA '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMaster_agama($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_agama');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
