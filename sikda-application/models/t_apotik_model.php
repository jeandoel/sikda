<?php
class T_apotik_model extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getT_apotik($params)
  {
		$this->db->select("
			kj.KD_KUNJUNGAN,
			k.KD_PELAYANAN,
			k.KD_PUSKESMAS,
			k.KD_PASIEN, 
			RIGHT(k.KD_PASIEN,7) AS SHORT_KD_PASIEN, 
			p.NAMA_LENGKAP AS NAMA_PASIEN, 
			REPLACE(REPLACE(REPLACE(Get_Age(p.TGL_LAHIR),'m','Bln'),'y','Th'),'d','Hr') AS UMUR,
			KD_JENIS_KELAMIN, 
			p.KK, 
			p.ALAMAT, 
			IFNULL(dok.NAMA,k.Created_By),
			CASE WHEN k.STATUS_LAYANAN=1 THEN 'SUDAH DILAYANI' 
				 WHEN  k.STATUS_LAYANAN=5 THEN 'CHECK ULANG' 
				 WHEN  k.STATUS_LAYANAN=6 THEN 'SELESAI CHECK' 
				 ELSE 'BELUM DILAYANI' 
			END STATUS_LAYANAN, 
			k.KD_PELAYANAN as MYKD_PELAYANAN, 
			CASE WHEN k.STATUS_LAYANAN=5 THEN 'CHECK' 
				 WHEN k.STATUS_LAYANAN=6 THEN 'LIHAT' 
				 ELSE k.KD_PELAYANAN 
			END MYKD_PELAYANAN_CHECK, 
			k.KD_UNIT, 
			k.UNIT_PELAYANAN",false);
		$this->db->from('pelayanan k');
		$this->db->join('kunjungan kj','kj.KD_PASIEN=k.KD_PASIEN and kj.KD_PELAYANAN=k.KD_PELAYANAN');
		$this->db->join('pasien p','p.KD_PASIEN=k.KD_PASIEN');
		$this->db->join('mst_dokter dok','dok.KD_DOKTER=k.KD_DOKTER','left');
		
		if($params['dari']){
			$this->db->where('k.TGL_PELAYANAN =', date("Y-m-d", strtotime(str_replace('/', '-',$params['dari']))));
		}
		if($params['status']){
			$this->db->where('k.STATUS_LAYANAN =', $params['status']);
		}
		
		if($params['keyword'] and $params['cari']){
			$tb=$params['keyword']=='NAMA_LENGKAP'?'p.':'k.';
			$this->db->where ($tb.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		$this->db->where('substr(kj.KD_KUNJUNGAN,12,5) NOT LIKE','219-3'); //imunisasi
		$this->db->where ('k.KD_PUSKESMAS =', $this->session->userdata('kd_puskesmas'));
		$this->db->where ("CASE WHEN
					k.KD_DOKTER IS NOT NULL
					THEN dok.KD_PUSKESMAS = '".$this->session->userdata('kd_puskesmas')."'
					ELSE 1
				END",NULL,FALSE);
		// $this->db->where('dok.KD_PUSKESMAS',$this->session->userdata('kd_puskesmas'));
		//$this->db->where('k.KD_UNIT =', '6');
		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('k.TGL_PELAYANAN','desc');
		//$this->db->order_by('k.KD_PELAYANAN','ASC');
		$this->db->order_by('k.STATUS_LAYANAN','asc');
		$result['data'] = $this->db->get()->result_array();//PRINT_R($this->db->last_query());DIE;
		
		return $result;
  }
    
  public function totalT_apotik($params)
  {
		$this->db->select("count(*) as total",false);
		$this->db->from('pelayanan k');
		$this->db->join('kunjungan kj','kj.KD_PASIEN=k.KD_PASIEN and kj.KD_PELAYANAN=k.KD_PELAYANAN');
		$this->db->join('pasien p','p.KD_PASIEN=k.KD_PASIEN');
		
		if($params['dari']){
			$this->db->where('k.TGL_PELAYANAN =', date("Y-m-d", strtotime(str_replace('/', '-',$params['dari']))));
		}
		if($params['status']){
			$this->db->where('k.STATUS_LAYANAN =', $params['status']);
		}
		
		if($params['keyword'] and $params['cari']){
			$tb=$params['keyword']=='NAMA_LENGKAP'?'p.':'k.';
			$this->db->where ($tb.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		$this->db->where('substr(kj.KD_KUNJUNGAN,12,5) NOT LIKE','219-3');
		$this->db->where ('k.KD_PUSKESMAS =', $this->session->userdata('kd_puskesmas'));		
		
		//$this->db->where('k.KD_UNIT =', '6');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
