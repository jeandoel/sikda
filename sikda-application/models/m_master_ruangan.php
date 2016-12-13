<?php
class M_master_ruangan extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMaster_ruangan($params)
  {
		$this->db->select("KD_RUANGAN, KD_RUANGAN as id, KD_PUSKESMAS, NAMA_RUANGAN, KD_RUANGAN as kode", false );
		$this->db->from('mst_ruangan');
		$this->db->where('KD_PUSKESMAS',$this->session->userdata('kd_puskesmas'));
		if ($params['koderuangan']){
			$this->db->where('NAMA_RUANGAN like', '%'.$params['koderuangan'].'%');	
		} 	
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_RUANGAN '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMaster_ruangan($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_ruangan');
		$this->db->where('KD_PUSKESMAS',$this->session->userdata('kd_puskesmas'));
		if ($params['koderuangan']){
			$this->db->where('NAMA_RUANGAN like', '%'.$params['koderuangan'].'%');	
		} 	
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
