<?php
class M_master_desa extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMasterdesa($params)
  {
		$this->db->select("nid_desa,nnama_desa,DATE_FORMAT(ntgl_master_desa, '%d-%M-%Y') as ntgl_master_desa,nid_desa as nid", false );
		$this->db->from('tbl_master_desa u');
		if($params['dari'] and empty($params['sampai'])){
			$this->db->where('u.ntgl_master_desa >=', date("Y-m-d", strtotime($params['dari'])));
		}
		if($params['sampai'] and empty($params['dari'])){
			$this->db->where('u.ntgl_master_desa <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['dari'] and $params['sampai']){
			$this->db->where('u.ntgl_master_desa >=', date("Y-m-d", strtotime($params['dari'])));
			$this->db->where('u.ntgl_master_desa <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		
		if($params['nama']){
			$this->db->where('u.nnama_desa like','%'.$params['nama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('nid_desa '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMasterdesa($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('tbl_master_desa u');
		if($params['dari'] and empty($params['sampai'])){
			$this->db->where('u.ntgl_master_desa =', date("Y-m-d", strtotime($params['dari'])));
		}
		if($params['sampai'] and empty($params['dari'])){
			$this->db->where('u.ntgl_master_desa <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['dari'] and $params['sampai']){
			$this->db->where('u.ntgl_master_desa >=', date("Y-m-d", strtotime($params['dari'])));
			$this->db->where('u.ntgl_master_desa <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
