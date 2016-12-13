<?php
class M_master_gigi_permukaan extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMaster($params)
  {
		if($params['for_dialog']){
			$this->db->select("kd_gigi_permukaan as action, kd_gigi_permukaan, kode, nama", false );
  		}else{
			$this->db->select("kd_gigi_permukaan, kode, nama, kd_gigi_permukaan as action", false );
		}
		$this->db->from('mst_gigi_permukaan');

		if($params['kode']){
			$this->db->where('kode like','%'.$params['kode'].'%');
		}
		if($params['nama']){
			$this->db->where('nama like','%'.$params['nama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('CHAR_LENGTH(kode) asc');
		$this->db->order_by('kode '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMaster($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_gigi_permukaan');

		if($params['kode']){
			$this->db->where('kode like','%'.$params['kode'].'%');
		}
		if($params['nama']){
			$this->db->where('nama like','%'.$params['nama'].'%');
		}
			
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
