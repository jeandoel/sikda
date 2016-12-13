<?php
class M_master_gigi extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMaster($params)
  {
		if($params['for_dialog']){
			$this->db->select("kd_gigi,  kd_gigi as action, gambar, nama", false );
  		}else{
			$this->db->select("kd_gigi, gambar, nama, kd_gigi as action", false );
		}
		$this->db->from('mst_gigi');

		if($params['kd_gigi']){
			$this->db->where('kd_gigi like','%'.$params['kd_gigi'].'%');
		}
		if($params['nama']){
			$this->db->where('nama like','%'.$params['nama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('kd_gigi '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMaster($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_gigi');
		
		if($params['kd_gigi']){
			$this->db->where('kd_gigi like','%'.$params['kd_gigi'].'%');
		}
		if($params['nama']){
			$this->db->where('nama like','%'.$params['nama'].'%');
		}

		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
