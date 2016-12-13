<?php
class M_master_kota extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getmasterkota($params)
  {
		$this->db->select("nid_kota,nnama_kota,DATE_FORMAT(ntgl_master_kota, '%d-%M-%Y') as ntgl_master_kota,nid_kota as nid", false );
		$this->db->from('tbl_master_kota u');
		if($params['dari'] and empty($params['sampai'])){
			$this->db->where('u.ntgl_master_kota =', date("Y-m-d", strtotime($params['dari'])));
		}
		if($params['sampai'] and empty($params['dari'])){
			$this->db->where('u.ntgl_master_kota <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['dari'] and $params['sampai']){
			$this->db->where('u.ntgl_master_kota >=', date("Y-m-d", strtotime($params['dari'])));
			$this->db->where('u.ntgl_master_kota <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['carinama']){
			$this->db->where('u.nnama_kota like', '%'.$params['carinama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('nid_kota '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalmasterkota($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('tbl_master_kota u');
		if($params['dari'] and empty($params['sampai'])){
			$this->db->where('u.ntgl_master_kota =', date("Y-m-d", strtotime($params['dari'])));
		}
		if($params['sampai'] and empty($params['dari'])){
			$this->db->where('u.ntgl_master_kota <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['dari'] and $params['sampai']){
			$this->db->where('u.ntgl_master_kota >=', date("Y-m-d", strtotime($params['dari'])));
			$this->db->where('u.ntgl_master_kota <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
