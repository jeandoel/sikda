<?php
class M_master_jenis_kasus extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getJeniskasus($params)
  {
		$this->db->select("KD_JENIS_KASUS,KD_JENIS_KASUS as id,JENIS_KASUS,KD_JENIS,KD_ICD_INDUK,KD_JENIS_KASUS as nid", false );
		$this->db->from('mst_kasus_jenis');
		if($params['nama']){
			$this->db->where('JENIS_KASUS like','%'.$params['nama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_JENIS_KASUS '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalJeniskasus($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_kasus_jenis');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
