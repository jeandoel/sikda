<?php
class T_pendaftaran_model extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getT_pendaftaran($params)
  {
		$this->db->select("KD_PASIEN,KD_PUSKESMAS,SHORT_KD_PASIEN, NAMA_LENGKAP, KK, TGL_LAHIR,UMUR, ALAMAT,NO_KK, NO_PENGENAL,KD_PASIEN as nid, NO_PENGENAL,KD_PASIEN as nid2", false );
		$this->db->from('vw_pasien u');
		
		if($params['keyword'] and $params['cari']){
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		if(isset($params['usergabung'])){
			$this->db->where ('u.KD_PASIEN <>', $params['usergabung']);
		}		
		$this->db->where ('u.KD_PUSKESMAS =', $this->session->userdata('kd_puskesmas'));		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_PASIEN '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		
		return $result;
  }
    
  public function totalT_pendaftaran($params)
  {
		$this->db->select("count(*) as total");
		
		if($params['keyword'] and $params['cari']){
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		
		$this->db->from('vw_pasien u');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
