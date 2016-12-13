<?php
class M_sys_setting_def_dw extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getSys_setting_def_dw($params)
  {
		$this->db->select("a.KD_DW,b.PUSKESMAS as namapuskesmas,f.KELURAHAN as namakelurahan,e.KECAMATAN as namakecamatan,d.KABUPATEN as namakabupaten,c.PROVINSI as namaprovinsi,a.KD_DW as nid", false );
		$this->db->from('sys_setting_def_dw a');
		$this->db->join('mst_puskesmas b','b.KD_PUSKESMAS=a.KD_PUSKESMAS');
		$this->db->join('mst_provinsi c','c.KD_PROVINSI=a.KD_PROVINSI');
		$this->db->join('mst_kabupaten d','d.KD_KABUPATEN=a.KD_KABUPATEN');
		$this->db->join('mst_kecamatan e','e.KD_KECAMATAN=a.KD_KECAMATAN');
		$this->db->join('mst_kelurahan f','f.KD_KELURAHAN=a.KD_KELURAHAN');
		$this->db->where ('a.KD_PUSKESMAS =', $this->session->userdata('kd_puskesmas'));

		if($params['keyword']=='PUSKESMAS' and $params['carinama']){
			$this->db->where('b.'.$params['keyword'].' like', $params['carinama'].'%');
		}
		if($params['keyword']=='KABUPATEN' and $params['carinama']){
			$this->db->where('d.'.$params['keyword'].' like', $params['carinama'].'%');
		}
		if($params['keyword']=='KECAMATAN' and $params['carinama']){
			$this->db->where('e.'.$params['keyword'].' like', $params['carinama'].'%');
		}
		if($params['keyword']=='KELURAHAN' and $params['carinama']){
			$this->db->where('f.'.$params['keyword'].' like', $params['carinama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('d.KABUPATEN '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalSys_setting_def_dw($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('sys_setting_def_dw a');
		$this->db->join('mst_puskesmas b','b.KD_PUSKESMAS=a.KD_PUSKESMAS');
		$this->db->join('mst_provinsi c','c.KD_PROVINSI=a.KD_PROVINSI');
		$this->db->join('mst_kabupaten d','d.KD_KABUPATEN=a.KD_KABUPATEN');
		$this->db->join('mst_kecamatan e','e.KD_KECAMATAN=a.KD_KECAMATAN');
		$this->db->join('mst_kelurahan f','f.KD_KELURAHAN=a.KD_KELURAHAN');
		$this->db->where ('a.KD_PUSKESMAS =', $this->session->userdata('kd_puskesmas'));

		if($params['keyword']=='PUSKESMAS' and $params['carinama']){
			$this->db->where('b.'.$params['keyword'].' like', $params['carinama'].'%');
		}
		if($params['keyword']=='KABUPATEN' and $params['carinama']){
			$this->db->where('d.'.$params['keyword'].' like', $params['carinama'].'%');
		}
		if($params['keyword']=='KECAMATAN' and $params['carinama']){
			$this->db->where('e.'.$params['keyword'].' like', $params['carinama'].'%');
		}
		if($params['keyword']=='KELURAHAN' and $params['carinama']){
			$this->db->where('f.'.$params['keyword'].' like', $params['carinama'].'%');
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 

  
}
