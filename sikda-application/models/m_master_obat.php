<?php
class M_master_obat extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getObat($params)
  {
		$this->db->select("u.KD_OBAT,u.KD_OBAT_VAL,u.NAMA_OBAT,m.KD_GOL_OBAT,q.JENIS_IMUNISASI,o.KD_SAT_KCL_OBAT,n.KD_SAT_BESAR,p.KD_TERAPI_OBAT,u.GENERIK,CAST(u.FRACTION AS Char) FRACTION,u.SINGKATAN,u.IS_DEFAULT,KD_OBAT as nid", false );
		$this->db->from('apt_mst_obat u');
		$this->db->join('apt_mst_gol_obat m','u.KD_GOL_OBAT=m.KD_GOL_OBAT','left');
		$this->db->join('apt_mst_sat_besar n','u.KD_SAT_BESAR=n.KD_SAT_BESAR','left');
		$this->db->join('apt_mst_sat_kecil o','u.KD_SAT_KECIL=o.KD_SAT_KCL_OBAT','left');
		$this->db->join('apt_mst_terapi_obat p','u.KD_TERAPI_OBAT=p.KD_TERAPI_OBAT','left');
		$this->db->join('mst_jenis_imunisasi q','u.KD_JENIS_IMUNISASI=q.KD_JENIS_IMUNISASI','left');
		
		if($params['nama']){
			$this->db->where('u.NAMA_OBAT like' ,$params['nama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('u.KD_OBAT '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalObat($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('apt_mst_obat');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
