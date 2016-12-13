<?php
class M_master_puskesmas extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getPuskesmas($params)
  {
		$this->db->select("KD_PUSKESMAS,KD_PUSKESMAS as id,KD_KECAMATAN,PUSKESMAS,ALAMAT,KD_PUSKESMAS as kode", false );
		$this->db->from('mst_puskesmas');
		if($params['nama']){
			$this->db->where('PUSKESMAS like','%'.$params['nama'].'%');
		}
		if($params['kodepuskesmas']){
			// $this->db->where('KD_PUSKESMAS like','P'.$params['kodepuskesmas'].'%');
			$this->db->where('KD_PUSKESMAS like', '%'.$params['kodepuskesmas'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_PUSKESMAS '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalPuskesmas($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_puskesmas');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
