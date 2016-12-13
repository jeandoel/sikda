<?php
class M_master_kategori_imunisasi extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getKategoriimunisasi($params)
  {
		$this->db->select("KD_KATEGORI_IMUNISASI, KD_KATEGORI_IMUNISASI as id, KATEGORI_IMUNISASI, KD_KATEGORI_IMUNISASI as kode", false );
		$this->db->from('mst_kategori_jenis_lokasi_imunisasi');
		
		if ($params['carikategori']){
			$this->db->where('KATEGORI_IMUNISASI like', '%'.$params['carikategori'].'%');	
		} 	
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_KATEGORI_IMUNISASI '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalKategoriimunisasi($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_kategori_jenis_lokasi_imunisasi');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
