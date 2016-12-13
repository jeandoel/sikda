<?php
class M_master_asal_pasien extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMasterasalpasien($params)
  {
		$this->db->select("KD_ASAL,KD_ASAL as kd,ASAL_PASIEN,KD_ASAL as kode", false );
		$this->db->from('mst_asal_pasien');
		if($params['nama']){
			$this->db->where('ASAL_PASIEN like','%'.$params['nama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_ASAL '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMasterasalpasien($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_asal_pasien');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
