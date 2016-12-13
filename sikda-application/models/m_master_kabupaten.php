<?php
class M_master_kabupaten extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getmasterkabupaten($params)
  {
		$this->db->select("KD_KABUPATEN,KD_KABUPATEN as ID,KD_PROVINSI,KABUPATEN,KD_KABUPATEN as nid", false );
		$this->db->from('mst_kabupaten u');
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
			$this->db->where('u.KABUPATEN like', '%'.$params['carinama'].'%');
		}
		if($params['id']){
			$this->db->where('u.KD_KABUPATEN like', $params['id'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_KABUPATEN '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalmasterkabupaten($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_kabupaten u');
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
