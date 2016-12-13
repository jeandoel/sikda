<?php
class T_ds_kematian_anak_model extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getds_kematian_anak($params)
  {
		$this->db->select("u.ID,k.KELURAHAN,kc.KECAMATAN,p.PUSKESMAS,MONTHNAME(STR_TO_DATE(u.BULAN,'%m')) as BULAN,u.TAHUN,u.ID as nid", false );
		$this->db->from('t_ds_kematian_anak u');
		$this->db->join('mst_kelurahan k','k.KD_KELURAHAN=u.KD_KELURAHAN');
		$this->db->join('mst_kecamatan kc','kc.KD_KECAMATAN=u.KD_KECAMATAN');
		$this->db->join('mst_puskesmas p','p.KD_PUSKESMAS=u.KD_PUSKESMAS');
		if($params['tahun']){
			$this->db->where('u.TAHUN =', $params['tahun']);
		}
		if($params['carinama']){
			$this->db->where('p.PUSKESMAS like', '%'.$params['carinama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('u.TAHUN '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();//die($this->db->last_query());
		return $result;
  }
    
  public function totalds_kematian_anak($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('t_ds_kematian_anak u');
		$this->db->join('mst_kelurahan k','k.KD_KELURAHAN=u.KD_KELURAHAN');
		$this->db->join('mst_kecamatan kc','kc.KD_KECAMATAN=u.KD_KECAMATAN');
		$this->db->join('mst_puskesmas p','p.KD_PUSKESMAS=u.KD_PUSKESMAS');
		if($params['tahun']){
			$this->db->where('u.TAHUN =', $params['tahun']);
		}
		if($params['carinama']){
			$this->db->where('p.PUSKESMAS like', '%'.$params['carinama'].'%');
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
