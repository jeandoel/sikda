<?php
class T_imunisasi_model extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getT_imunisasi($params)
  {
		$this->db->select("KD_PASIEN, KD_PUSKESMAS, NAMA_LENGKAP, TGL_LAHIR, KD_JENIS_KELAMIN, ALAMAT,STATUS_MARITAL, ifnull(NAMA_IBU,'-') as NAMA_IBU, ifnull(NAMA_SUAMI,'-') AS NAMA_SUAMI, KD_PASIEN AS nid, KD_PASIEN AS nid2, id_trans as id3", false );
		$this->db->from('vw_imunisasi a');
		
		if($params['keyword'] and $params['cari']){
			$this->db->where ('a.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		if(isset($params['usergabung'])){
			$this->db->where ('KD_PASIEN <>', $params['usergabung']);
		}

		$this->db->where('a.KD_KECAMATAN',$this->session->userdata('kd_kecamatan'));
		
		$this->db->where ('FLAG_L =', '2');		
		$this->db->or_where ('FLAG_L =', '3');		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_TRANS_IMUNISASI','desc');
		
		$result['data'] = $this->db->get()->result_array();
		
		
		return $result;
  }
    
  public function totalT_imunisasi($params)
  {
		$this->db->select("count(*) as total");
		
		if($params['keyword'] and $params['cari']){
			$this->db->where ('a.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		if(isset($params['usergabung'])){
			$this->db->where ('KD_PASIEN <>', $params['usergabung']);
		}
		$this->db->from('vw_imunisasi a');
		$this->db->where('a.KD_KECAMATAN',$this->session->userdata('kd_kecamatan'));
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
   public function getT_semuapasien($params)
  {
		$this->db->select("KD_PASIEN, KD_PUSKESMAS, NAMA_LENGKAP, TGL_LAHIR, KD_JENIS_KELAMIN, ALAMAT,STATUS_MARITAL, NAMA_IBU, NAMA_SUAMI, nid, nid2", false );
		$this->db->from('vw_semua_pasien a');
		
		if($params['keyword'] and $params['cari']){
			$this->db->where ('a.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		if(isset($params['usergabung'])){
			$this->db->where ('KD_PASIEN <>', $params['usergabung']);
		}
		$this->db->where('a.KD_KECAMATAN',$this->session->userdata('kd_kecamatan'));
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_PASIEN ','desc');
		
		$result['data'] = $this->db->get()->result_array();
		
		
		return $result;
  }
    
  public function totalT_semuapasien($params)
  {
		$this->db->select("count(*) as total");		
		
		$this->db->from('vw_semua_pasien a');
		if($params['keyword'] and $params['cari']){
			$this->db->where ('a.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		if(isset($params['usergabung'])){
			$this->db->where ('KD_PASIEN <>', $params['usergabung']);
		}
		$this->db->where('a.KD_KECAMATAN',$this->session->userdata('kd_kecamatan'));
		$total = $this->db->get()->row();
		return $total->total;
  } 
  public function getT_subgridsemuapasien($params)
	{
		$this->db->select("p.NO_PENGENAL,concat(p.TEMPAT_LAHIR,' ',p.TGL_LAHIR) as TTL,p.KD_GOL_DARAH,k.CUSTOMER,p.CARA_BAYAR,concat(TELEPON,' / ',HP) as TLP",false);
		$this->db->from('pasien p');
		$this->db->join('mst_kel_pasien k','k.KD_CUSTOMER=p.KD_CUSTOMER');
				
		$this->db->where('p.KD_PASIEN =', $params['kd_pasien']);
		$this->db->where('p.KD_PUSKESMAS =', $params['kd_puskesmas']);
		
		$this->db->limit($params['limit'],$params['start']);
		
		$result['data'] = $this->db->get()->result_array();
		
		
		return $result;
	}

	public function totalT_subgridsemuapasien($params)
	{
		$this->db->select("count(*) as total");
		
		$this->db->where('KD_PASIEN =', $params['kd_pasien']);
		$this->db->where('KD_PUSKESMAS =', $params['kd_puskesmas']);
		
		$this->db->from('pasien');
		$total = $this->db->get()->row();
		return $total->total;
	}
  
  
  
  
  public function getT_imunisasi_kipi($params)
  {
		$this->db->select("a.*", false );
		$this->db->from('vw_pasien_kipi a');
		
		if($params['keyword'] and $params['cari']){
			$this->db->where ('a.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		if(isset($params['usergabung'])){
			$this->db->where ('KD_PASIEN <>', $params['usergabung']);
		}				
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_PASIEN ','desc');
		
		$result['data'] = $this->db->get()->result_array();
		
		
		return $result;
  }
    
  public function totalT_imunisasi_kipi($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('vw_pasien_kipi a');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
  
  public function getT_imunisasisubgrid($params)
  {
		$this->db->select("a.TANGGAL, a.JENIS_IMUNISASI, a.NAMA_OBAT, a.KATEGORI_IMUNISASI, a.KECAMATAN, a.KELURAHAN, a.DOKTER, a.ID", false );
		$this->db->from('vw_subgrid_imunisasi a');
		
		if($params['keyword'] and $params['cari']){
			$this->db->where ('a.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		
		$this->db->where('KD_PASIEN', $params['kd_pasien']);
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_PASIEN ','desc');
		
		$result['data'] = $this->db->get()->result_array();
		
		
		return $result;
  }
    
  public function totalT_imunisasisubgrid($params)
  {
		$this->db->select("count(*) as total");
		
		
		$this->db->from('vw_subgrid_imunisasi a');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
   public function getPetugas_imunisasi($params)
  {
		$this->db->select("b.JENIS_IMUNISASI, c.NAMA_OBAT",false);
		$this->db->from('pel_imunisasi a');	
		$this->db->join('mst_jenis_imunisasi b','b.KD_JENIS_IMUNISASI=a.KD_JENIS_IMUNISASI');
		$this->db->join('apt_mst_obat c','c.KD_OBAT=a.KD_OBAT');
		
		$this->db->where('KD_TRANS_IMUNISASI',$params['id']);
		
		$this->db->limit($params['limit'],$params['start']);
		
		$result['data'] = $this->db->get()->result_array();
		//print_r($this->db->last_query());die();
		return $result;
  }  
   public function totalPetugas_imunisasi($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('pel_imunisasi u');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
  
}
