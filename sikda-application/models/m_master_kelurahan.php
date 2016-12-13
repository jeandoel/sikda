<?php
class M_master_kelurahan extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMasterkelurahan($params)
  {
		$this->db->select("l.KD_KELURAHAN,l.KD_KELURAHAN as id,c.KD_KECAMATAN,l.KELURAHAN,KD_KELURAHAN as kode", false );
		$this->db->from('mst_kelurahan l');
		$this->db->join('mst_kecamatan c','l.KD_KECAMATAN=c.KD_KECAMATAN');
		if($params['nama']){
			$this->db->where('l.KELURAHAN like','%'.$params['nama'].'%');
		}
		if($params['id']){
			$this->db->where('l.KD_KELURAHAN like','%'.$params['id'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_KELURAHAN '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMasterkelurahan($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_kelurahan l');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
