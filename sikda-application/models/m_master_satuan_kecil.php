<?php
class M_master_satuan_kecil extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMastersatuankecil($params)
  {
		$this->db->select("KD_SAT_KCL_OBAT,KD_SAT_KCL_OBAT as kode,SAT_KCL_OBAT,KD_SAT_KCL_OBAT as id", false );
		$this->db->from('apt_mst_sat_kecil u');
		if ($params['satuankcl']){
			$this->db->where ('u.KD_SAT_KCL_OBAT like', '%'.$params['satuankcl'].'%');
		}
		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_SAT_KCL_OBAT '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMastersatuankecil($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('apt_mst_sat_kecil u');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
