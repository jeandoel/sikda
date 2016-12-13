<?php
class T_pelayanan_kb_model extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function gettpelayanankb($params)
  {
		$this->db->select("u.KD_KUNJUNGAN_KB as kode,DATE_FORMAT(u.TANGGAL, '%d-%M-%Y') as TANGGAL,u.KD_KUNJUNGAN_KB,u.KD_PUSKESMAS,m.JENIS_KB,concat (h.NAMA,'-',h.JABATAN) as pemeriksa,concat (i.NAMA,'-',i.JABATAN) as petugas,u.KELUHAN,u.ANAMNESE, GROUP_CONCAT(DISTINCT s.TINDAKAN SEPARATOR ' | ') AS PRODUK,group_concat(distinct z.NAMA_OBAT separator ' | ') as OBAT,u.KD_KUNJUNGAN_KB as id", false );
		//$this->db->select("GROUP_CONCAT(DISTINCT s.KD_TINDAKAN SEPARATOR ' | ')");
		$this->db->from('kunjungan_kb u','left');
		$this->db->join('detail_tindakan_kb s','u.KD_KUNJUNGAN_KB=s.KD_KUNJUNGAN_KB','left');
		$this->db->join('trans_kia g','u.KD_KIA=g.KD_KIA','left');
		$this->db->join('mst_jenis_kb m','m.KD_JENIS_KB=u.KD_JENIS_KB','left');
		$this->db->join('mst_dokter h','h.KD_DOKTER=g.KD_DOKTER_PEMERIKSA','left');
		$this->db->join('mst_dokter i','i.KD_DOKTER=g.KD_DOKTER_PETUGAS','left');
		$this->db->join('pel_ord_obat o','g.KD_PELAYANAN=o.KD_PELAYANAN','left');
		$this->db->join('apt_mst_obat z','o.KD_OBAT=z.KD_OBAT','left');
		
		if($params['get_kd_pasien']){
			$this->db->where ('g.KD_PASIEN =', $params['get_kd_pasien']);
		}

		if($params['dari'] and empty($params['sampai'])){
			$this->db->where('u.TANGGAL >=', date("Y-m-d", strtotime($params['dari'])));
		}
		if($params['sampai'] and empty($params['dari'])){
			$this->db->where('u.TANGGAL <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['dari'] and $params['sampai']){
			$this->db->where('u.TANGGAL >=', date("Y-m-d", strtotime($params['dari'])));
			$this->db->where('u.TANGGAL <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['keyword']=='PRODUK' and $params['cari']){
			$this->db->where ('s.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		if($params['keyword']=='JENIS_KB' and $params['cari']){
			$this->db->where ('m.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		if($params['keyword']=='h.NAMA' and $params['cari']){
			$this->db->where ($params['keyword'].' like', '%'.$params['cari'].'%');
		}
		if($params['keyword']=='i.NAMA' and $params['cari']){
			$this->db->where ($params['keyword'].' like', '%'.$params['cari'].'%');
		}
		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->group_by('u.KD_KUNJUNGAN_KB');
		$this->db->order_by('KD_KUNJUNGAN_KB '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
  
  
    
  public function totaltpelayanankb($params)
  {
		if($params['dari'] and empty($params['sampai'])){
			$this->db->where('u.TANGGAL =', date("Y-m-d", strtotime($params['dari'])));
		}
		if($params['sampai'] and empty($params['dari'])){
			$this->db->where('u.TANGGAL <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['dari'] and $params['sampai']){
			$this->db->where('u.TANGGAL >=', date("Y-m-d", strtotime($params['dari'])));
			$this->db->where('u.TANGGAL <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		$this->db->select("count(*) as total");
		$this->db->from('kunjungan_kb u');
		$this->db->join('trans_kia tk', 'u.KD_KIA = tk.KD_KIA');
		if($params['get_kd_pasien']){
			$this->db->where ('tk.KD_PASIEN =', $params['get_kd_pasien']);
		}
		$total = $this->db->get()->row();
		return $total->total;
  }
  
  
  public function gett_tindakan_pelayanan_kb($params)
  {
		$this->db->select('KD_TINDAKAN,TINDAKAN, HRG_TINDAKAN, QTY, KETERANGAN',false);
		$this->db->from('detail_tindakan_kb');
		
		$this->db->where('KD_PELAYANAN',$params['id']);
		$this->db->where('KD_PUSKESMAS',$params['idpuskesmas']);
		
		$this->db->limit($params['limit'],$params['start']);
		
		$this->db->order_by('TINDAKAN '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		//print_r($this->db->last_query());die();
		return $result;
  }
  

 public function totalt_tindakan_pelayanan_kb($params)
  {
		//$this->db->select("count(*) as total");
		//$this->db->from('kunjungan_kb');
		//$this->db->where('KD_PELAYANAN',$params['id']);
		
		$this->db->select("count(*) as total");
		$this->db->from('detail_tindakan_kb');
		$this->db->where('KD_PELAYANAN',$params['id']);
		$this->db->where('KD_PUSKESMAS',$params['idpuskesmas']);
		
		$total = $this->db->get()->row();
		return $total->total;
  }
  
   public function gett_alergiobat_pelayanan_kb($params)
  {
		$this->db->select('a.KD_OBAT, b.NAMA_OBAT',false);
		$this->db->from('pasien_alergi_obt a');
		$this->db->join('apt_mst_obat b', 'a.KD_OBAT=b.KD_OBAT');
		
		
		$this->db->where('a.KD_PASIEN',$params['id']);
		$this->db->where('a.KD_PUSKESMAS',$params['idpuskesmas']);
		
		$this->db->limit($params['limit'],$params['start']);
		
		$this->db->order_by('a.KD_OBAT '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		//print_r($this->db->last_query());die();
		return $result;
  }
  
  public function totalt_alergiobat_pelayanan_kb($params)
  {
		//$this->db->select("count(*) as total");
		//$this->db->from('kunjungan_kb');
		//$this->db->where('a.KD_PASIEN',$params['id']);
		
  		$this->db->select("count(*) as total");
		$this->db->from('pasien_alergi_obt a');
		$this->db->where('a.KD_PASIEN',$params['id']);
		$this->db->where('a.KD_PUSKESMAS',$params['idpuskesmas']);
		
		$total = $this->db->get()->row();
		return $total->total;
  }
  
  public function gett_obat_pelayanan_kb($params)
  {
		$this->db->select('a.KD_OBAT, b.NAMA_OBAT, a.DOSIS, a.HRG_JUAL, a.QTY',false);
		$this->db->from('pel_ord_obat a');
		$this->db->join('apt_mst_obat b', 'a.KD_OBAT=b.KD_OBAT');
		
		$this->db->where('KD_PELAYANAN',$params['id']);
		$this->db->where('a.KD_PUSKESMAS',$params['idpuskesmas']);
		
		$this->db->limit($params['limit'],$params['start']);
		
		$this->db->order_by('KD_OBAT '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		//print_r($this->db->last_query());die();
		return $result;
  }
  
  public function totalt_obat_pelayanan_kb($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('pel_ord_obat');
		$this->db->where('KD_PELAYANAN',$params['id']);
		$this->db->where('KD_PUSKESMAS',$params['idpuskesmas']);
		
		$total = $this->db->get()->row();
		return $total->total;
  }
  
  
}
