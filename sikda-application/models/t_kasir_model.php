<?php
class T_kasir_model extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getT_kasir($params)
  {
		$this->db->select("u.KD_PEL_KASIR,u.KD_PEL_KASIR,u.STATUS,u.KD_PASIEN,u.NAMA_LENGKAP, u.NO_PENGENAL, u.KD_PASIEN as id, u.KD_PEL_KASIR as id2", false );
		$this->db->from('vw_lst_kasir u');
		
		if($params['keyword'] and $params['cari']){
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		
		if($params['status']){
			$this->db->where('u.STATUS =', $params['status']);
		}
		
		
		if(isset($params['usergabung'])){
			$this->db->where ('u.KD_PASIEN <>', $params['usergabung']);
		}		
		$this->db->where ('u.KD_PUSKESMAS =', $this->session->userdata('kd_puskesmas'));		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_PEL_KASIR '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		
		return $result;
  }
    
  public function totalT_kasir($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('vw_lst_kasir u');
		$this->db->where ('u.KD_PUSKESMAS =', $this->session->userdata('kd_puskesmas'));	
		
		if($params['keyword'] and $params['cari']){
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		if($params['status']){
			$this->db->where('u.STATUS =', $params['status']);
		}
		
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
  
}
