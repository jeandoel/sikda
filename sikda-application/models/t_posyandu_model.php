<?php
class T_posyandu_model extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getposyandu($params)
  {
		$this->db->select("u.ID,u.NAMA_POSYANDU,u.JUMLAH_KADER,u.RW,u.RT,k.KELURAHAN,u.ID as nid", false );
		$this->db->from('t_posyandu u');
		$this->db->join('mst_kelurahan k','k.KD_KELURAHAN=u.KD_KELURAHAN');
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
			$this->db->where('u.NAMA_POSYANDU like', '%'.$params['carinama'].'%');
		}
		if($this->session->userdata('level_aplikasi')=='PUSKESMAS'){
		$this->db->where('u.KD_KECAMATAN =', $this->session->userdata('kd_kecamatan'));
		}
		if($this->session->userdata('level_aplikasi')=='KABUPATEN'){
		$this->db->where('u.KD_KABUPATEN =', $this->session->userdata('kd_kabupaten'));
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('u.ID '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();//die($this->db->last_query());
		return $result;
  }
    
  public function totalposyandu($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('t_posyandu u');
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
			$this->db->where('u.NAMA_POSYANDU like', '%'.$params['carinama'].'%');
		}
		if($this->session->userdata('level_aplikasi')=='PUSKESMAS'){
		$this->db->where('u.KD_KECAMATAN =', $this->session->userdata('kd_kecamatan'));
		}
		if($this->session->userdata('level_aplikasi')=='KABUPATEN'){
		$this->db->where('u.KD_KABUPATEN =', $this->session->userdata('kd_kabupaten'));
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
