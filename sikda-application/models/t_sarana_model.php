<?php
class T_sarana_model extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getT_sarana($params)
  {
		$this->db->select("a.*", false );
		$this->db->from('vw_stok_sarana a');
		
		if ($params['carisarana']){
			$this->db->where('a.NAMA_SARANA_POSYANDU like', '%'.$params['carisarana'].'%');	
		} 	
		$this->db->where('a.TUJUAN_SARANA =', $this->session->userdata('level_aplikasi')=='KABUPATEN'?$this->session->userdata('kd_kabupaten'):($this->session->userdata('level_aplikasi')=='PUSKESMAS'?$this->session->userdata('kd_puskesmas'):$this->session->userdata('nid_user')));
		$this->db->limit($params['limit'],$params['start']);
		
		$result['data'] = $this->db->get()->result_array();
		//print_r($this->db->last_query());die;
		return $result;
  }
    
  public function totalT_sarana($params)
  {
		$this->db->select("count(*) as total");
		
		if ($params['carisarana']){
			$this->db->where('a.NAMA_SARANA_POSYANDU like', '%'.$params['carisarana'].'%');	
		} 	
		
		$this->db->from('vw_stok_sarana a');
		$this->db->where('a.TUJUAN_SARANA =', $this->session->userdata('level_aplikasi')=='KABUPATEN'?$this->session->userdata('kd_kabupaten'):($this->session->userdata('level_aplikasi')=='PUSKESMAS'?$this->session->userdata('kd_puskesmas'):$this->session->userdata('nid_user')));
		$total =$this->db->get()->row();
		return $total->total;
  } 
  
  public function totalsubgridSarana($params)
	{
		/*$querymasuk = $this->db->query("select SUM((CASE WHEN (KD_SATUAN = 'buah') THEN 1 WHEN (KD_SATUAN = 'kodi') THEN 20 ELSE 12 END)) AS `STOK` from apt_sarana_detail where KD_SARANA_POSYANDU='".$params['kd_sarana']."'")->row();
		$querykeluar = $this->db->query("select SUM((CASE WHEN (KD_SATUAN = 'buah') THEN 1 WHEN (KD_SATUAN = 'kodi') THEN 20 ELSE 12 END)) AS `JUMLAH_KELUAR` from apt_sarana_keluar_detail where KD_SARANA_POSYANDU='".$params['kd_sarana']."'")->row();
		$stokakhir = $querymasuk - $querykeluar;*/
		
		$this->db->select("count(*) as total");
		$this->db->from('apt_sarana a');		
		$this->db->join('apt_sarana_detail d','d.KD_SARANA=a.KD_SARANA');
		$this->db->where('d.KD_SARANA_POSYANDU =', $params['kd_sarana']);
		$this->db->where('d.KD_PEMILIK_DATA =', $this->session->userdata('level_aplikasi')=='KABUPATEN'?$this->session->userdata('kd_kabupaten'):($this->session->userdata('level_aplikasi')=='PUSKESMAS'?$this->session->userdata('kd_puskesmas'):$this->session->userdata('nid_user')));
		//$this->db->where('d.FLAG =', 'masuk');
		//$this->db->group_by('d.KD_SARANA');
		//$this->db->group_by('d.FLAG');
		
		$total =$this->db->get()->row();
		return $total->total;
	}
 
  public function getsubgridSarana($params)
	{
		$this->db->select("a.KD_SARANA,a.KD_SARANA as kds,a.TANGGAL_TRANSAKSI,a.NO_FAKTUR,d.FLAG,a.ASAL_SARANA,a.TUJUAN_SARANA,(CASE WHEN (d.KD_SATUAN = 'buah') THEN 1 WHEN (d.KD_SATUAN = 'kodi') THEN 20 ELSE 12 END) as JUMLAH,d.STOK_AWAL,d.STOK_AKHIR",false); 
		$this->db->from('apt_sarana a');		
		$this->db->join('apt_sarana_detail d','d.KD_SARANA=a.KD_SARANA');
		$this->db->where('d.KD_SARANA_POSYANDU =', $params['kd_sarana']);
		$this->db->where('d.KD_PEMILIK_DATA =', $this->session->userdata('level_aplikasi')=='KABUPATEN'?$this->session->userdata('kd_kabupaten'):($this->session->userdata('level_aplikasi')=='PUSKESMAS'?$this->session->userdata('kd_puskesmas'):$this->session->userdata('nid_user')));
		//$this->db->where('d.FLAG =', 'masuk');
		//$this->db->group_by('d.KD_SARANA');
		//$this->db->group_by('d.FLAG');
		$result['data'] = $this->db->get()->result_array();
		
		//print_r($this->db->last_query());die;
		return $result;
	}
  
}
