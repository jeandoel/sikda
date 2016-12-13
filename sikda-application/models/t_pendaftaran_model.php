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
		$this->db->select("KD_PASIEN,KD_PUSKESMAS,SHORT_KD_PASIEN, NAMA_LENGKAP, KK, DATE_FORMAT(TGL_LAHIR,'%d-%m-%Y') as TGL_LAHIR ,REPLACE(REPLACE(REPLACE(UMUR,'m','Bln'),'y','Th'),'d','Hr') AS UMUR, ALAMAT,NO_KK, NO_PENGENAL,KD_PASIEN as nid, NO_PENGENAL,KD_PASIEN as nid2", false );
		$this->db->from('vw_pasien u');
		
		if($params['keyword'] and $params['cari']){
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		if(isset($params['usergabung'])){
			$this->db->where ('u.KD_PASIEN <>', $params['usergabung']);
		}		
		$this->db->where ('u.KD_PUSKESMAS =', $this->session->userdata('kd_puskesmas'));
		$this->db->where ('u.JENIS_DATA IS NULL', NULL);
		$this->db->where ('FLAG_L =', '1');		
		$this->db->or_where ('FLAG_L =', '3');			
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_PASIEN ','desc');
		
		$result['data'] = $this->db->get()->result_array();//die($this->db->last_query());
		
		
		return $result;
  }
    
  public function totalT_pendaftaran($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('vw_pasien u');
		if($params['keyword'] and $params['cari']){
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		$this->db->where ('u.KD_PUSKESMAS =', $this->session->userdata('kd_puskesmas'));
		$this->db->where ('u.JENIS_DATA is NULL', NULL);
		$this->db->where ('FLAG_L =', '1');		
		$this->db->or_where ('FLAG_L =', '3');			
		/*$this->db->where ('u.NAMA_LENGKAP not like','Anak Ibu%');	*/
		
		
		$total = $this->db->get()->row();#die($this->db->last_query());
		return $total->total;
  } 
  
}
