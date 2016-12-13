<?php
class T_k_inspeksi_pasar_model extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getinspeksipasar($params)
  {
		$this->db->select("u.ID,u.NAMA_PASAR,u.JUMLAH_PEDAGANG,u.JUMLAH_KIOS,JUMLAH_ASOSIASI,u.TOTAL_NILAI,u.ID as nid", false );
		$this->db->from('t_k_inspeksipasar u');
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
			$this->db->where('u.NAMA_PASAR like', '%'.$params['carinama'].'%');
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
    
  public function totalinspeksipasar($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('t_k_inspeksipasar u');
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
			$this->db->where('u.NAMA_PASAR like', '%'.$params['carinama'].'%');
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
