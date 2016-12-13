<?php
class M_master_gol_obat extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getmastergolobat($params)
  {
		$this->db->select("KD_GOL_OBAT,KD_GOL_OBAT AS id,GOL_OBAT,KD_GOL_OBAT as nid", false );
		$this->db->from('apt_mst_gol_obat u');
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
		if($params['keyword'] and $params['carinama']){
			$this->db->where('u.'.$params['keyword'].' like', '%'.$params['carinama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_GOL_OBAT '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalmastergolobat($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('apt_mst_gol_obat u');
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
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
