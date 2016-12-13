<?php
class M_transaksi_wilayah extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function gettransaksiwilayah($params)
  {
		$this->db->select("u.nid_wilayah,u.nkode_transaksi,v.nnama_propinsi,w.nnama_kabupaten,x.nnama_kota,y.nnama_kecamatan,z.nnama_desa,u.nno_rt,u.nno_rw,DATE_FORMAT(u.ntgl_transaksi_wilayah, '%d-%M-%Y') as ntgl_transaksi_wilayah,u.nid_wilayah as nid", false );
		$this->db->from('tbl_transaksi_wilayah u');
		$this->db->join('tbl_master_propinsi v','v.nid_propinsi=u.nid_propinsi');
		$this->db->join('tbl_master_kabupaten w','w.nid_kabupaten=u.nid_kabupaten');
		$this->db->join('tbl_master_kota x','x.nid_kota=u.nid_kota');
		$this->db->join('tbl_master_kecamatan y','y.nid_master_kecamatan=u.nid_kecamatan');
		$this->db->join('tbl_master_desa z','z.nid_desa=u.nid_desa');
		if($params['dari'] and empty($params['sampai'])){
			$this->db->where('u.ntgl_transaksi_wilayah >=', date("Y-m-d", strtotime($params['dari'])));
		}
		if($params['sampai'] and empty($params['dari'])){
			$this->db->where('u.ntgl_transaksi_wilayah <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['dari'] and $params['sampai']){
			$this->db->where('u.ntgl_transaksi_wilayah >=', date("Y-m-d", strtotime($params['dari'])));
			$this->db->where('u.ntgl_transaksi_wilayah <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['keyword']=='nnama_kecamatan' and $params['carinama']){
			$this->db->where('y.'.$params['keyword'].' like', '%'.$params['carinama'].'%');
		}
		if($params['keyword']=='nnama_desa' and $params['carinama']){
			$this->db->where('z.'.$params['keyword'].' like', '%'.$params['carinama'].'%');
		}
		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('nid_wilayah '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totaltransaksiwilayah($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('tbl_transaksi_wilayah u');
		if($params['dari'] and empty($params['sampai'])){
			$this->db->where('u.ntgl_transaksi_wilayah =', date("Y-m-d", strtotime($params['dari'])));
		}
		if($params['sampai'] and empty($params['dari'])){
			$this->db->where('u.ntgl_transaksi_wilayah <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['dari'] and $params['sampai']){
			$this->db->where('u.ntgl_transaksi_wilayah >=', date("Y-m-d", strtotime($params['dari'])));
			$this->db->where('u.ntgl_transaksi_wilayah <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
