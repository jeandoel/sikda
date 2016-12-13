<?php
class M_master_sarana_posyandu extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMastersaranaposyandu($params)
  {
		$this->db->select("KD_SARANA_POSYANDU,NAMA_SARANA_POSYANDU,KD_SARANA_POSYANDU as nid", false );
		$this->db->from('mst_sarana_posyandu');
		if($params['nama']){
			$this->db->where('NAMA_SARANA_POSYANDU like','%'.$params['nama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_SARANA_POSYANDU '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMastersaranaposyandu($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_sarana_posyandu');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
