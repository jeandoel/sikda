<?php
class M_master_jenis_imunisasi extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getJenisimunisasi($params)
  {
		$this->db->select("KD_JENIS_IMUNISASI, KD_JENIS_IMUNISASI as id, JENIS_IMUNISASI, KD_JENIS_IMUNISASI as kode", false );
		$this->db->from('mst_jenis_imunisasi');
		
		if ($params['carijenisimunisasi']){
			$this->db->where('jenis_imunisasi like', '%'.$params['carijenisimunisasi'].'%');	
		} 	
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_JENIS_IMUNISASI '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalJenisimunisasi($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_jenis_imunisasi');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
