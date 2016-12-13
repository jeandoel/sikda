<?php
class M_master_transfer extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMastertransfer($params)
  {
		$this->db->select("KD_TRANSFER,KD_TRANSFER as kode,PRODUK_TRANSFER,KD_TRANSFER as id", false );
		$this->db->from('mst_transfer');
		if($params['nama']){
			$this->db->where('PRODUK_TRANSFER like','%'.$params['nama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_TRANSFER '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMastertransfer($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_transfer');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
