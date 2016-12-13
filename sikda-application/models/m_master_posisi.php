<?php
class M_master_posisi extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMasterposisi($params)
  {
		$this->db->select("KD_POSISI,KD_POSISI as kd,POSISI,KD_POSISI as kode", false );
		$this->db->from('mst_posisi');
		if($params['nama']){
			$this->db->where('POSISI like','%'.$params['nama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_POSISI '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMasterposisi($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_posisi');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
