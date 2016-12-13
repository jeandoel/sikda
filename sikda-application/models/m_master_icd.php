<?php
class M_master_icd extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMastericd($params)
  {
		

		if($params['for_dialog']){
			$this->db->select("KD_PENYAKIT, KD_PENYAKIT as nid, KD_ICD_INDUK, PENYAKIT, DESCRIPTION", false );
			$this->db->where("IS_ODONTOGRAM", 1);
  		}else{
			$this->db->select("KD_PENYAKIT, KD_ICD_INDUK, PENYAKIT, DESCRIPTION, KD_PENYAKIT as nid", false );
		}

		$this->db->from('mst_icd u');
		
		if($params['keyword'] and $params['cari']){
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}		
		
		if ($params['kd_penyakit']){
			$this->db->where('kd_penyakit like', '%'.$params['kd_penyakit'].'%');	
		} 	
		if ($params['kd_icd_induk']){
			$this->db->where('kd_icd_induk like', '%'.$params['kd_icd_induk'].'%');	
		} 	
		if ($params['penyakit']){
			$this->db->where('penyakit like', '%'.$params['penyakit'].'%');	
		} 	

		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_PENYAKIT '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMastericd($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_icd u');
		if($params['for_dialog']){
			$this->db->where("IS_ODONTOGRAM", 1);
  		}
		if($params['keyword'] and $params['cari']){
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}

		if ($params['kd_penyakit']){
			$this->db->where('kd_penyakit like', '%'.$params['kd_penyakit'].'%');	
		} 	
		if ($params['kd_icd_induk']){
			$this->db->where('kd_icd_induk like', '%'.$params['kd_icd_induk'].'%');	
		} 	
		if ($params['penyakit']){
			$this->db->where('penyakit like', '%'.$params['penyakit'].'%');	
		} 	
		
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
  
  
}
