<?php
class M_master_kamar extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getmasterKamar($params)
  {
		$this->db->select("KD_UNIT, NO_KAMAR, NAMA_KAMAR, JUMLAH_BED, DIGUNAKAN, KD_UNIT as nid", false );
		$this->db->from('mst_kamar u');
		
		if($params['keyword'] and $params['cari']){
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
                if($params['keyword'] and $params['cari']){
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		
		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_UNIT '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalmasterKamar($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_kamar u');
		
		if($params['cari']){
			$this->db->where('KD_UNIT LIKE "%'.$params['cari'].'%" ');
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
  
  
}
