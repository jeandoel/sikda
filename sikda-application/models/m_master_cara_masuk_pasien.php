<?php
class M_master_cara_masuk_pasien extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getCaramasukpasien($params)
  {
		$this->db->select("KD_CARA_MASUK, KD_CARA_MASUK as id, CARA_MASUK, KD_CARA_MASUK as kode", false );
		$this->db->from('mst_cara_masuk_pasien');
		
		if ($params['carimasukpasien']){
			$this->db->where('CARA_MASUK like', '%'.$params['carimasukpasien'].'%');	
		} 	
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_CARA_MASUK '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalCaramasukpasien($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_cara_masuk_pasien');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
