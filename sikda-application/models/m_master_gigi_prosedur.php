<?php
class M_master_gigi_prosedur extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMaster($params)
  {
  		if($params['for_dialog']){
			$this->db->select("kd_prosedur_gigi, kd_prosedur_gigi as action, prosedur, deskripsi", false );
		}else{
			$this->db->select("kd_prosedur_gigi, prosedur, deskripsi, kd_prosedur_gigi as action", false );
		}
		$this->db->from('mst_gigi_prosedur');
		if($params['kd_prosedur_gigi']){
			$this->db->where('kd_prosedur_gigi like','%'.$params['kd_prosedur_gigi'].'%');
		}
		if($params['prosedur']){
			$this->db->where('prosedur like','%'.$params['prosedur'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('kd_prosedur_gigi '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMaster($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_gigi_prosedur');
		
		if($params['kd_prosedur_gigi']){
			$this->db->where('kd_prosedur_gigi like','%'.$params['kd_prosedur_gigi'].'%');
		}
		if($params['prosedur']){
			$this->db->where('prosedur like','%'.$params['prosedur'].'%');
		}

		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
