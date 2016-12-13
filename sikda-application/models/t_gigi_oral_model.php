<?php
class T_gigi_oral_model extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMaster($params)
  {
		$this->db->select("kd_foto_gigi, tanggal, gambar, kd_foto_gigi as action", false );
		$this->db->from('t_foto_gigi_pasien');
		$this->db->where("tipe_foto", 1);
		$this->db->where('kd_pasien', $params['pasien']);
		$this->db->where('kd_puskesmas', $params['puskesmas']);
		if($params['tanggal']){
			$this->db->where('tanggal like','%'.$params['tanggal'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('tanggal '.$params['sort'], "desc");
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMaster($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('t_foto_gigi_pasien');
		$this->db->where('kd_pasien', $params['pasien']);
		$this->db->where('kd_puskesmas', $params['puskesmas']);
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
