<?php
class M_master_harga_obat extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getmasterhargaobat($params)
  {
		$this->db->select("concat(KD_TARIF,u.KD_OBAT,KD_MILIK_OBAT),KD_TARIF,u.KD_OBAT AS id,a.NAMA_OBAT,HARGA_BELI,HARGA_JUAL,KD_MILIK_OBAT,concat(KD_TARIF,u.KD_OBAT,KD_MILIK_OBAT) as nid", false );
		$this->db->from('apt_mst_harga_obat u');
		$this->db->join('apt_mst_obat a', 'a.KD_OBAT=u.KD_OBAT', 'left');
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
		if($params['keyword']=='NAMA_OBAT' and $params['carinama']){
			$this->db->where('a.'.$params['keyword'].' like', '%'.$params['carinama'].'%');
		}else{
			$this->db->where('u.'.$params['keyword'].' like', '%'.$params['carinama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('u.KD_OBAT '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalmasterhargaobat($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('apt_mst_harga_obat u');
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
