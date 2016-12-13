<?php
class M_transaksi_sarana_posyandu_masuk extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getSaranaposyandumasuk($params)
  {
		$this->db->select("u.nid_sarana_posyandu_masuk,u.nasal_sarana_posyandu,m.nnama_puskesmas,u.nid_pegawai,n.nnama_sarana_posyandu,u.nketerangan_sarana,u.nkode_transaksi,DATE_FORMAT(u.ntgl_transaksi, '%d-%M-%Y') as ntgl_transaksi,u.njumlah_sarana,u.nid_sarana_posyandu_masuk as nid", false );
		$this->db->from('tbl_transaksi_sarana_posyandu_masuk u');
		$this->db->join('tbl_master_puskesmas m','m.nid_puskesmas=u.nid_puskesmas');
		$this->db->join('tbl_master_sarana_posyandu n','n.nid_sarana_posyandu=u.nid_sarana_posyandu');
		if($params['dari'] and empty($params['sampai'])){
			$this->db->where('u.ntgl_transaksi >=', date("Y-m-d", strtotime($params['dari'])));
		}
		if($params['sampai'] and empty($params['dari'])){
			$this->db->where('u.ntgl_transaksi <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['dari'] and $params['sampai']){
			$this->db->where('u.ntgl_transaksi >=', date("Y-m-d", strtotime($params['dari'])));
			$this->db->where('u.ntgl_transaksi <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('nid_sarana_posyandu_masuk '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalSaranaposyandumasuk($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('tbl_transaksi_sarana_posyandu_masuk u');
		if($params['dari'] and empty($params['sampai'])){
			$this->db->where('u.ntgl_transaksi =', date("Y-m-d", strtotime($params['dari'])));
		}
		if($params['sampai'] and empty($params['dari'])){
			$this->db->where('u.ntgl_transaksi <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['dari'] and $params['sampai']){
			$this->db->where('u.ntgl_transaksi >=', date("Y-m-d", strtotime($params['dari'])));
			$this->db->where('u.ntgl_transaksi <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
