<?php
class M_master_satuan_besar extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMastersatuanbesar($params)
  {
		$this->db->select("KD_SAT_BESAR,KD_SAT_BESAR as kode,SAT_BESAR_OBAT,KD_SAT_BESAR as id", false );
		$this->db->from('apt_mst_sat_besar u');
		if ($params['satuan']){
			$this->db->where ('u.KD_SAT_BESAR like', '%'.$params['satuan'].'%');
		}
		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_SAT_BESAR '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMastersatuanbesar($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('apt_mst_sat_besar u');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
