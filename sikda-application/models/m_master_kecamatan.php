<?php
class m_master_kecamatan extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMaster_kecamatan($params)
  {
		$this->db->select("KD_KECAMATAN,KD_KECAMATAN as id,KD_KABUPATEN,KECAMATAN, KD_KECAMATAN as kode", false );
		$this->db->from('mst_kecamatan u');
		
		if ($params['kodekecamatan']){
			$this->db->where('u.KECAMATAN like', '%'.$params['kodekecamatan'].'%');	
		}
		if($params['id']){
			$this->db->where('u.KD_KECAMATAN like',$params['id'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_KECAMATAN '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMaster_kecamatan($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_kecamatan u');
		if ($params['kodekecamatan']){
			$this->db->where('u.KECAMATAN like', '%'.$params['kodekecamatan'].'%');	
		}
		if($params['id']){
			$this->db->where('u.KD_KECAMATAN like',$params['id'].'%');
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
