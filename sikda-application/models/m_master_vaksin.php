<?php
class M_master_vaksin extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMastervaksin($params)
  {
		$this->db->select("nid_vaksin,nkode_vaksin,nnama_vaksin,ngolongan,nsumber,nsatuan,DATE_FORMAT(ntgl_master_vaksin, '%d-%M-%Y') as ntgl_master_vaksin,nid_vaksin as nid", false );
		$this->db->from('tbl_master_vaksin u');
		if($params['dari'] and empty($params['sampai'])){
			$this->db->where('u.ntgl_master_vaksin >=', date("Y-m-d", strtotime($params['dari'])));
		}
		if($params['sampai'] and empty($params['dari'])){
			$this->db->where('u.ntgl_master_vaksin <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['dari'] and $params['sampai']){
			$this->db->where('u.ntgl_master_vaksin >=', date("Y-m-d", strtotime($params['dari'])));
			$this->db->where('u.ntgl_master_vaksin <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		
		if($params['nama']){
			$this->db->where('u.nnama_vaksin like','%'.$params['nama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('nid_vaksin '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMastervaksin($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('tbl_master_vaksin u');
		if($params['dari'] and empty($params['sampai'])){
			$this->db->where('u.ntgl_master_vaksin =', date("Y-m-d", strtotime($params['dari'])));
		}
		if($params['sampai'] and empty($params['dari'])){
			$this->db->where('u.ntgl_master_vaksin <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['dari'] and $params['sampai']){
			$this->db->where('u.ntgl_master_vaksin >=', date("Y-m-d", strtotime($params['dari'])));
			$this->db->where('u.ntgl_master_vaksin <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
