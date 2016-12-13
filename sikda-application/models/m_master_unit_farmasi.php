<?php
class M_master_unit_farmasi extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMaster_unitfarmasi($params)
  {
		$this->db->select("KD_UNIT_FAR, KD_UNIT_FAR as id, NAMA_UNIT_FAR, FAR_UTAMA, KD_UNIT_FAR as kode", false );
		$this->db->from('apt_mst_unit');
		
		if ($params['kodeunitfarmasi']){
			$this->db->where('NAMA_UNIT_FAR like', '%'.$params['kodeunitfarmasi'].'%');	
		} 	
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_UNIT_FAR'.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMaster_unitfarmasi($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('apt_mst_unit');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
