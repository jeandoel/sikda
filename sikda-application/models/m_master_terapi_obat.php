<?php
class M_master_terapi_obat extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMaster_terapiobat($params)
  {
		$this->db->select("KD_TERAPI_OBAT, KD_TERAPI_OBAT as id, TERAPI_OBAT, KD_TERAPI_OBAT as kode", false );
		$this->db->from('apt_mst_terapi_obat');
		
		if ($params['kodeterapiobat']){
			$this->db->where('TERAPI_OBAT like', '%'.$params['kodeterapiobat'].'%');	
		} 	
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_TERAPI_OBAT'.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMaster_terapiobat($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('apt_mst_terapi_obat');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
