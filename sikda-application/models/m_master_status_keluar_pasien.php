<?php
class M_master_status_keluar_pasien extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMasterstatuskeluarpasien($params)
  {
		$this->db->select("KD_STATUS, KETERANGAN, KD_STATUS as nid", false );
		$this->db->from('mst_status_keluar_pasien u');
		
		if($params['keyword'] and $params['cari']){
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_STATUS '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMasterstatuskeluarpasien($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_status_keluar_pasien u');
		
		if($params['cari']){
			$this->db->where('KD_STATUS LIKE "%'.$params['cari'].'%" ');
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
  
  
}
