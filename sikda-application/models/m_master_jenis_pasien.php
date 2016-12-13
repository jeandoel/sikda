<?php
class M_master_jenis_pasien extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getJenispasien($params)
  {
		$this->db->select("KD_JENIS_PASIEN, KD_JENIS_PASIEN as id, JENIS_PASIEN, KD_JENIS_PASIEN as kode", false );
		$this->db->from('mst_jenis_pasien');
		
		if ($params['carijenispasien']){
			$this->db->where('JENIS_PASIEN like', '%'.$params['carijenispasien'].'%');	
		} 	
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_JENIS_PASIEN '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalJenispasien($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_jenis_pasien');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
