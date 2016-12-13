<?php
class Mastertempat_model extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMastertempat($params)
  {
		$this->db->select("nid_reg_tempat,nkode_tempat,nnama_tempat,njenis_tempat,nno_telp_tempat,npengelola_tempat,nid_wilayah,DATE_FORMAT(ntgl_master_tempat, '%d-%M-%Y') as ntgl_master_tempat,nid_reg_tempat as nid", false );
		$this->db->from('tbl_master_reg_tempat u');
		if($params['dari'] and empty($params['sampai'])){
			$this->db->where('u.ntgl_master_tempat >=', date("Y-m-d", strtotime($params['dari'])));
		}
		if($params['sampai'] and empty($params['dari'])){
			$this->db->where('u.ntgl_master_tempat <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['dari'] and $params['sampai']){
			$this->db->where('u.ntgl_master_tempat >=', date("Y-m-d", strtotime($params['dari'])));
			$this->db->where('u.ntgl_master_tempat <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		
		if($params['nama']){
			$this->db->where('u.nnama_tempat like','%'.$params['nama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('nid_reg_tempat '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMastertempat($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('tbl_master_reg_tempat u');
		if($params['dari'] and empty($params['sampai'])){
			$this->db->where('u.ntgl_master_tempat >=', date("Y-m-d", strtotime($params['dari'])));
		}
		if($params['sampai'] and empty($params['dari'])){
			$this->db->where('u.ntgl_master_tempat <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['dari'] and $params['sampai']){
			$this->db->where('u.ntgl_master_tempat >=', date("Y-m-d", strtotime($params['dari'])));
			$this->db->where('u.ntgl_master_tempat <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
