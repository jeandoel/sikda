<?php
class M_master_icd_induk extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getIcdinduk($params)
  {
		$this->db->select("KD_ICD_INDUK, KD_ICD_INDUK as id, ICD_INDUK, KD_ICD_INDUK as kode", false );
		$this->db->from('mst_icd_induk u');
		
		if($params['keyword']=='KD_ICD_INDUK' and $params['cari'])
		{
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
        if($params['keyword']=='ICD_INDUK' and $params['cari'])
		{
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		if($params['nama']){
			$this->db->where('KD_ICD_INDUK like','%'.$params['nama'].'%');
		}

		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_ICD_INDUK '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalIcdinduk($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_icd_induk u');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
