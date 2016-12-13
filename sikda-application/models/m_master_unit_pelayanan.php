<?php
class M_master_unit_pelayanan extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMasterunitpelayanan($params)
  {
		$this->db->select("KD_UNIT_LAYANAN, NAMA_UNIT,AKTIF, KD_UNIT_LAYANAN as nid", false );
		$this->db->from('mst_unit_pelayanan u');
		
		if($params['keyword'] and $params['cari']){
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_UNIT_LAYANAN '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMasterunitpelayanan($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_unit_pelayanan u');
		
		if($params['cari']){
			$this->db->where('KD_UNIT_LAYANAN LIKE "%'.$params['cari'].'%" ');
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
  
  
}
