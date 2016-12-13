<?php
class M_sys_setting_def extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getsyssettingdef($params)
  {
		$this->db->select("KD_SETTING,KD_SETTING AS id,KD_PROV,KD_KABKOTA,KD_KEC,KD_PUSKESMAS,NAMA_PUSKESMAS,NAMA_PIMPINAN,NIP,ALAMAT,AGAMA,LEVEL,SERVER_KEMKES,SERVER_DINKES_PROV,SERVER_DINKES_KAB_KOTA,KD_SETTING AS nid", false );
		$this->db->from('sys_setting_def u');
		$this->db->where('u.KD_PUSKESMAS =', $this->session->userdata('kd_puskesmas'));
		$this->db->or_where("u.KD_KABKOTA =".$this->session->userdata('kd_kabupaten')." AND u.LEVEL='KABUPATEN'");
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
		$this->db->order_by('KD_SETTING '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalsyssettingdef($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('sys_setting_def u');
		$this->db->where ('u.KD_PUSKESMAS =', $this->session->userdata('kd_puskesmas'));
		$this->db->or_where("u.KD_KABKOTA =".$this->session->userdata('kd_kabupaten')." AND u.LEVEL='KABUPATEN'");
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
		if($params['keyword'] and $params['carinama']){
			$this->db->where('u.'.$params['keyword'].' like', '%'.$params['carinama'].'%');
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
