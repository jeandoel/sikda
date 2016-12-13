<?php
class M_master_dokter extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getmasterdokter($params)
  {
		$this->db->select("KD_DOKTER,KD_DOKTER as ID,NAMA,NIP,JABATAN,STATUS,KD_PUSKESMAS,KD_DOKTER as nid", false );
		$this->db->from('mst_dokter u');
		$this->db->where('u.KD_PUSKESMAS =', $this->session->userdata('kd_puskesmas'));
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
		$this->db->order_by('KD_DOKTER '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalmasterdokter($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_dokter u');
		$this->db->where('u.KD_PUSKESMAS =', $this->session->userdata('kd_puskesmas'));
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
