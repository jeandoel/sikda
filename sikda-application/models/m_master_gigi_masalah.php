<?php
class M_master_gigi_masalah extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMaster($params)
  {
  		if($params['for_dialog']){
			$this->db->select("kd_masalah_gigi, kd_masalah_gigi as action, masalah, deskripsi", false );
  		}else{
			$this->db->select("kd_masalah_gigi, masalah, deskripsi, kd_masalah_gigi as action", false );
		}
		$this->db->from('mst_gigi_masalah');
		
		if ($params['kd_masalah_gigi']){
			$this->db->where('kd_masalah_gigi like', '%'.$params['kd_masalah_gigi'].'%');	
		} 	
		if ($params['masalah']){
			$this->db->where('masalah like', '%'.$params['masalah'].'%');	
		} 	
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('masalah '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMaster($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_gigi_masalah');

		if ($params['kd_masalah_gigi']){
			$this->db->where('kd_masalah_gigi like', '%'.$params['kd_masalah_gigi'].'%');	
		} 	
		if ($params['masalah']){
			$this->db->where('masalah like', '%'.$params['masalah'].'%');	
		} 	
		$total = $this->db->get()->row();
		return $total->total;;
  } 
  
}

