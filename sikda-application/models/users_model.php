<?php
class Users_model extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('brsk', TRUE);
  }
  
  public function getUsers($params)
  {
		$this->db->select("*", false );
		$this->db->from('tbl_users u');
		if($params['dari'] and empty($params['sampai'])){
			$this->db->where('u.ntgl_input =', date("Y-m-d", strtotime($params['dari'])));
		}
		if($params['sampai'] and empty($params['dari'])){
			$this->db->where('u.ntgl_input <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['dari'] and $params['sampai']){
			$this->db->where('u.ntgl_input >=', date("Y-m-d", strtotime($params['dari'])));
			$this->db->where('u.ntgl_input <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('nid_user asc');
		
		$result['data'] = $this->db->get()->result_array();//print_r($this->db->last_query());die;
		
		return $result;
  }
    
  public function totalUsers($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('tbl_users u');
		if($params['dari'] and empty($params['sampai'])){
			$this->db->where('u.ntgl_input =', date("Y-m-d", strtotime($params['dari'])));
		}
		if($params['sampai'] and empty($params['dari'])){
			$this->db->where('u.ntgl_input <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['dari'] and $params['sampai']){
			$this->db->where('u.ntgl_input >=', date("Y-m-d", strtotime($params['dari'])));
			$this->db->where('u.ntgl_input <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
