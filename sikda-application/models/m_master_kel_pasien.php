<?php
class M_master_kel_pasien extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getKelpasien($params)
  {
		$this->db->select("KD_CUSTOMER,CUSTOMER,TELEPON1,KD_CUSTOMER as nid", false );
		$this->db->from('mst_kel_pasien');
		
		if($params['nama']){
			$this->db->where('CUSTOMER like' ,$params['nama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_CUSTOMER '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }

  public function getByCustomer($nama,$params=null){
  		$this->db->select()->from('mst_kel_pasien');
  		if(!empty($params['where'])){
  			$this->db->where($params['where']);
  		}
  		$this->db->where('CUSTOMER',$nama);

  		return $this->db->get()->row_array();
  }
  public function getAll($params){
  		$this->db->select()->from('mst_kel_pasien');
  		if(!empty($params['where'])){
  			$this->db->where($params['where']);
  		}
  		$this->db->order_by('KD_CUSTOMER');

  		return $this->db->get()->result_array();
  }
    
  public function totalKelpasien($params)
  {
		$this->db->select("KD_CUSTOMER,CUSTOMER,TELEPON1 as total");
		$this->db->from('mst_kel_pasien');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
