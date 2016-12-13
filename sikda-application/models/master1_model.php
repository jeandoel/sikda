<?php
class Master1_model extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMaster1($params)
  {
		$this->db->select("nid_master1,ncolumn1,ncolumn2,ncolumn3,DATE_FORMAT(ntgl_master1, '%d-%M-%Y') as ntgl_master1,nid_master1 as nid", false );
		$this->db->from('tbl_master1 u');
		if($params['dari'] and empty($params['sampai'])){
			$this->db->where('u.ntgl_master1 >=', date("Y-m-d", strtotime($params['dari'])));
		}
		if($params['sampai'] and empty($params['dari'])){
			$this->db->where('u.ntgl_master1 <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['dari'] and $params['sampai']){
			$this->db->where('u.ntgl_master1 >=', date("Y-m-d", strtotime($params['dari'])));
			$this->db->where('u.ntgl_master1 <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('nid_master1 '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMaster1($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('tbl_master1 u');
		if($params['dari'] and empty($params['sampai'])){
			$this->db->where('u.ntgl_master1 =', date("Y-m-d", strtotime($params['dari'])));
		}
		if($params['sampai'] and empty($params['dari'])){
			$this->db->where('u.ntgl_master1 <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['dari'] and $params['sampai']){
			$this->db->where('u.ntgl_master1 >=', date("Y-m-d", strtotime($params['dari'])));
			$this->db->where('u.ntgl_master1 <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
