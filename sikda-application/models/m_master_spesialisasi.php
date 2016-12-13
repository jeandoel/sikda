<?php
class M_master_spesialisasi extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMasterspesialisasi($params)
  {
		$this->db->select("KD_SPESIAL,KD_SPESIAL as kode,SPESIALISASI,KD_SPESIAL as id", false );
		$this->db->from('mst_spesialisasi');
		if($params['nama']){
			$this->db->where('SPESIALISASI like','%'.$params['nama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_SPESIAL '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMasterspesialisasi($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_spesialisasi');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
