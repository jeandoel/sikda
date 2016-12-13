<?php
class T_registrasi_kia_model extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getT_registrasi_kia($params)
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
    
  public function totalT_registrasi_kia($params)
  {
		$this->db->select("count(*) as total");
		
		if($params['keyword'] and $params['cari']){
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		
		$this->db->from('vw_pasien u');
		$total = $this->db->get()->row();
		return $total->total;
  } 
   public function getDaftar_antrian($params)
  {
		$this->db->select("u.KD_PASIEN,u.KD_PUSKESMAS,u.URUT_MASUK, u.KD_PASIEN as kode, p.NAMA_LENGKAP, p.KD_JENIS_KELAMIN,p.TGL_LAHIR, kk.KATEGORI_KIA, kj.KUNJUNGAN_KIA,
						(CASE u.STATUS WHEN 0 THEN 'BELUM' WHEN 1 THEN 'SUDAH' END) AS STATUS, kj.KUNJUNGAN_KIA ,u.KD_PASIEN as id", false );
		$this->db->from('kunjungan u');
		$this->db->join('pasien p','p.KD_PASIEN=u.KD_PASIEN','left');
		$this->db->join('pelayanan pl','pl.KD_PASIEN=u.KD_PASIEN','left');
		$this->db->join('trans_kia tk','tk.KD_PELAYANAN=pl.KD_PELAYANAN','left');
		$this->db->join('mst_kategori_kia kk','tk.KD_KATEGORI_KIA=kk.KD_KATEGORI_KIA','left');
		$this->db->join('mst_kunjungan_kia kj','tk.KD_KUNJUNGAN_KIA=kj.KD_KUNJUNGAN_KIA','left');
		
		if($params['keyword'] and $params['cari']){
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		if(isset($params['usergabung'])){
			$this->db->where ('u.KD_PASIEN <>', $params['usergabung']);
		}		
		$this->db->where ('u.KD_PUSKESMAS =', $this->session->userdata('kd_puskesmas'));		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('u.KD_PASIEN '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		
		return $result;
  }
    
  public function totalDaftar_antrian($paramstotal)
  {
		$this->db->select("count(*) as total");
		$this->db->from('kunjungan u');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
  public function getT_detailantriankunjungan($params)
	{
		$this->db->select("p.KD_PASIEN,p.KD_KUNJUNGAN, p.TGL_MASUK,p.KD_DOKTER as pemeriksa, p.KD_DOKTER as petugas, p.KD_KUNJUNGAN as id",false);
		$this->db->from('kunjungan p');
				
		$this->db->where('p.KD_PASIEN =', $params['kd_pasien']);
		$this->db->where('p.KD_PUSKESMAS =', $params['kd_puskesmas']);
		
		$this->db->limit($params['limit'],$params['start']);
		
		$result['data'] = $this->db->get()->result_array();
		
		
		return $result;
	}
	public function totalT_detailantriankunjungan($params)
	{
		$this->db->select("count(*) as total");
		
		$this->db->where('KD_PASIEN =', $params['kd_pasien']);
		$this->db->where('KD_PUSKESMAS =', $params['kd_puskesmas']);
		
		$this->db->from('kunjungan');
		$total = $this->db->get()->row();
		return $total->total;

	}
	
  
  
}
