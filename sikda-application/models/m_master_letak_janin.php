<?php
class M_master_letak_janin extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getmasterletakjanin($params)
  {
		$this->db->select("KD_LETAK_JANIN,KD_LETAK_JANIN as ID,LETAK_JANIN,KD_LETAK_JANIN as nid", false );
		$this->db->from('mst_letak_janin u');
		if($params['dari'] and empty($params['sampai'])){
			$this->db->where('u.ninput_tgl >=', date("Y-m-d", strtotime($params['dari'])));
		}
		if($params['sampai'] and empty($params['dari'])){
			$this->db->where('u.ninput_tgl <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['dari'] and $params['sampai']){
			$this->db->where('u.ninput_tgl >=', date("Y-m-d", strtotime($params['dari'])));
			$this->db->where('u.ninput_tgl <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['carinama']){
			$this->db->where('u.LETAK_JANIN like', '%'.$params['carinama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_LETAK_JANIN '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalmasterletakjanin($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_letak_janin u');
		if($params['dari'] and empty($params['sampai'])){
			$this->db->where('u.ninput_tgl =', date("Y-m-d", strtotime($params['dari'])));
		}
		if($params['sampai'] and empty($params['dari'])){
			$this->db->where('u.ninput_tgl <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['dari'] and $params['sampai']){
			$this->db->where('u.ninput_tgl >=', date("Y-m-d", strtotime($params['dari'])));
			$this->db->where('u.ninput_tgl <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['carinama']){
			$this->db->where('u.LETAK_JANIN like', '%'.$params['carinama'].'%');
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
