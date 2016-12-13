<?php
class M_master_posyandu extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getposyandu($params)
  {
		$this->db->select("nid_posyandu,nkode_posyandu,nnama_posyandu,nalamat_posyandu,njumlah_kader,DATE_FORMAT(ntgl_posyandu, '%d-%M-%Y') as ntgl_posyandu,nid_posyandu as nid", false );
		$this->db->from('tbl_master_posyandu u');
		if($params['dari'] and empty($params['sampai'])){
			$this->db->where('u.ntgl_posyandu >=', date("Y-m-d", strtotime($params['dari'])));
		}
		if($params['sampai'] and empty($params['dari'])){
			$this->db->where('u.ntgl_posyandu <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['dari'] and $params['sampai']){
			$this->db->where('u.ntgl_posyandu >=', date("Y-m-d", strtotime($params['dari'])));
			$this->db->where('u.ntgl_posyandu <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['nama']){
			$this->db->where('u.nnama_posyandu like', $params['nama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('nid_posyandu '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalposyandu($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('tbl_master_posyandu u');
		if($params['dari'] and empty($params['sampai'])){
			$this->db->where('u.ntgl_posyandu =', date("Y-m-d", strtotime($params['dari'])));
		}
		if($params['sampai'] and empty($params['dari'])){
			$this->db->where('u.ntgl_posyandu <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['dari'] and $params['sampai']){
			$this->db->where('u.ntgl_posyandu >=', date("Y-m-d", strtotime($params['dari'])));
			$this->db->where('u.ntgl_posyandu <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
