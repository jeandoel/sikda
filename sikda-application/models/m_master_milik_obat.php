<?php
class M_master_milik_obat extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMastermilikobat($params)
  {
		$this->db->select("KD_MILIK_OBAT,KEPEMILIKAN,KD_MILIK_OBAT as id", false );
		$this->db->from('apt_mst_milik_obat u');
		if ($params['pemilik']){
			$this->db->where ('u.KEPEMILIKAN like', '%'.$params['pemilik'].'%');
		}
		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_MILIK_OBAT '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMastermilikobat($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('apt_mst_milik_obat u');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
