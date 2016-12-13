<?php
class M_master_retribusi extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getRetribusi($params)
  {
		$this->db->select("KD_RETRIBUSI as id,KD_PUSKESMAS,KD_KECAMATAN,PUSKESMAS,ALAMAT,NILAI_RETRIBUSI,KD_RETRIBUSI as kode", false );
		$this->db->from('mst_retribusi');
		$this->db->where('KD_PUSKESMAS',$this->session->userdata('kd_puskesmas'));
		if($params['nama']){
			$this->db->where('PUSKESMAS like','%'.$params['nama'].'%');
		}
		if($params['id']){
			$this->db->where('KD_RETRIBUSI like','P'.$params['id'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_RETRIBUSI '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();#die($this->db->last_query());
		
		return $result;
  }
    
  public function totalRetribusi($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_retribusi');
		$this->db->where('KD_PUSKESMAS',$this->session->userdata('kd_puskesmas'));
		if($params['nama']){
			$this->db->where('PUSKESMAS like','%'.$params['nama'].'%');
		}
		if($params['id']){
			$this->db->where('KD_RETRIBUSI like','P'.$params['id'].'%');
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
