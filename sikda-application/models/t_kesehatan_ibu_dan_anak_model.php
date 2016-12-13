<?php
class T_kesehatan_ibu_dan_anak_model extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getTkesehatanibudananak($params)
  {	
		$this->db->select("tk.KD_KIA, p.KD_PASIEN, p.TGL_PENDAFTARAN, p.NAMA_LENGKAP, jk.JENIS_KELAMIN, tk.KD_KUNJUNGAN_KIA, kg.KATEGORI_KIA, kj.KUNJUNGAN_KIA, p.KD_PASIEN as id, tk.KD_KIA as id2",false);
		$this->db->from('trans_kia tk');
		$this->db->join('pelayanan pl','pl.KD_PELAYANAN=tk.KD_PELAYANAN','left');
		$this->db->join('pasien p','p.KD_PASIEN=pl.KD_PASIEN','left');
		$this->db->join('mst_jenis_kelamin jk','jk.KD_JENIS_KELAMIN=p.KD_JENIS_KELAMIN','left');
		$this->db->join('mst_kategori_kia kg','kg.KD_KATEGORI_KIA=tk.KD_KATEGORI_KIA','left');
		$this->db->join('mst_kunjungan_kia kj','kj.KD_KUNJUNGAN_KIA=tk.KD_KUNJUNGAN_KIA','left');
		
		if($params['keyword'] and $params['cari'])
		{
			$this->db->where ('tk.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('tk.KD_KIA '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		
		return $result;
  }
    
  public function totalTkesehatanibudananak($params)
  {
		$this->db->select("count(*) as total");
		
		if($params['keyword'] and $params['cari']){
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		
		$this->db->from('trans_kia u');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
   
  public function getT_bersalinpopup($params)
  {
		$this->db->select ("DATE_FORMAT (u.TANGGAL_BERSALIN, '%d-%M-%Y') as TANGGAL_BERSALIN,
		u.JAM_KELAHIRAN,u.UMUR_KEHAMILAN, u.KD_DOKTER,d.JABATAN, mcp.CARA_PERSALINAN, mjk.JENIS_KELAHIRAN, u.JML_BAYI, mkk.KEADAAN_KESEHATAN,p.ANAK_KE,
		p.BERAT_LAHIR,p.PANJANG_BADAN,p.LINGKAR_KEPALA,jk.JENIS_KELAMIN,mkbl.KEADAAN_BAYI_LAHIR,mabl.ASUHAN_BAYI_LAHIR,u.KET_TAMBAHAN", false );
		
		$this->db->from('kunjungan_bersalin u');
		$this->db->join('mst_dokter d','u.KD_DOKTER=d.KD_DOKTER','left');
		$this->db->join('mst_cara_persalinan mcp','u.KD_CARA_BERSALIN=mcp.KD_CARA_PERSALINAN','left');
		$this->db->join('mst_jenis_kelahiran mjk','u.KD_JENIS_KELAHIRAN=u.KD_JENIS_KELAHIRAN','left');
		$this->db->join('mst_keadaan_kesehatan mkk', 'u.KD_KEADAAN_KESEHATAN=mkk.KD_KEADAAN_KESEHATAN','left');
		$this->db->join('pasien p','u.KD_PASIEN=p.KD_PASIEN','left');
		$this->db->join('mst_jenis_kelamin jk','p.KD_JENIS_KELAMIN=jk.KD_JENIS_KELAMIN','left');
		$this->db->join('mst_keadaan_bayi_lahir mkbl','u.KD_KEADAAN_BAYI_LAHIR=mkbl.KD_KEADAAN_BAYI_LAHIR','left');
		$this->db->join('mst_asuhan_bayi_lahir mabl','u.KD_ASUHAN_BAYI_LAHIR=mabl.KD_ASUHAN_BAYI_LAHIR','left');
		
		if($params['get_kd_pasien'])
		{
			$this->db->where ('u.KD_PASIEN', $params['get_kd_pasien']);
		}			
		
		if($params['kode']){
			$this->db->where('KD_KUNJUNGAN_BERSALIN like' ,$params['kode'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->group_by('u.KD_KUNJUNGAN_BERSALIN');
		$this->db->order_by('KD_KUNJUNGAN_BERSALIN '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array(); //print_r($result);die;
		
		return $result;
		//print_r($this->db->last_query());die()
  }
    
  public function totalT_bersalinpopup($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('kunjungan_bersalin');
		if($params['get_kd_pasien'])
		{
			$this->db->where ('kunjungan_bersalin.KD_PASIEN', $params['get_kd_pasien']);
		}			
		if($params['kode']){
			$this->db->where('KD_KUNJUNGAN_BERSALIN like' ,$params['kode'].'%');
		}
		$total = $this->db->get()->row();
		return $total->total;
  }

	public function getT_tindakan_bersalin($params)
  {
		$this->db->select('pt.KD_TINDAKAN,mp.PRODUK,pt.HRG_TINDAKAN,pt.QTY,pt.KETERANGAN',false);
		$this->db->from('pel_tindakan pt');
		$this->db->join('mst_produk mp','mp.KD_PRODUK=pt.KD_TINDAKAN');
		
		$this->db->where('pt.KD_PELAYANAN',$params['id']);
		$this->db->where('pt.KD_PUSKESMAS',$params['idpuskesmas']);
		
		$this->db->limit($params['limit'],$params['start']);
		
		$this->db->order_by('pt.KD_PELAYANAN '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		//print_r($this->db->last_query());die();
		return $result;
  }
  
  public function totalT_tindakan_bersalin($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('pel_tindakan');
		$this->db->where('KD_PELAYANAN',$params['id']);
		$this->db->where('KD_PUSKESMAS',$params['idpuskesmas']);
		
		$total = $this->db->get()->row();
		return $total->total;
  }
  
  public function getT_obat_bersalin($params)
  {
		$this->db->select('po.KD_OBAT,mo.NAMA_OBAT,po.DOSIS,po.HRG_JUAL,po.QTY',false);
		$this->db->from('pel_ord_obat po');	
		$this->db->join('apt_mst_obat mo','mo.KD_OBAT=po.KD_OBAT');
		$this->db->where('po.KD_PELAYANAN',$params['id']);
		$this->db->where('po.KD_PUSKESMAS',$params['idpuskesmas']);
		
		$this->db->limit($params['limit'],$params['start']);
		
		$this->db->order_by('po.KD_OBAT'.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		//print_r($this->db->last_query());die();
		return $result;
  }
  
  public function totalT_obat_bersalin($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('pel_ord_obat');
		$this->db->where('KD_PELAYANAN',$params['id']);
		$this->db->where('KD_PUSKESMAS',$params['idpuskesmas']);
		
		$total = $this->db->get()->row();
		return $total->total;
  }
  
  public function getT_alergi_bersalin($params)
  {
		$this->db->select('ao.KD_OBAT,mo.NAMA_OBAT',false);
		$this->db->from('pasien_alergi_obt ao');	
		$this->db->join('apt_mst_obat mo','mo.KD_OBAT=ao.KD_OBAT');	
		
		$this->db->where('ao.KD_PASIEN',$params['id']);
		$this->db->where('ao.KD_PUSKESMAS',$params['idpuskesmas']);
		
		$this->db->limit($params['limit'],$params['start']);
		
		$this->db->order_by('ao.KD_OBAT '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		//print_r($this->db->last_query());die();
		return $result;
  }
  
  public function totalT_alergi_bersalin($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('pasien_alergi_obt');
		$this->db->where('KD_PASIEN',$params['id']);
		$this->db->where('KD_PUSKESMAS',$params['idpuskesmas']);
		
		$total = $this->db->get()->row();
		return $total->total;
  }
  
  public function getT_asuhan_bayi($params)
  {
		$this->db->select('KD_ASUHAN_BAYI_LAHIR,ASUHAN_BAYI_LAHIR',false);
		$this->db->from('detail_asuhan_bayi');
		
		$this->db->where('KD_KUNJUNGAN_BERSALIN',$params['id']);
		
		$this->db->limit($params['limit'],$params['start']);
		
		$result['data'] = $this->db->get()->result_array();
		//print_r($this->db->last_query());die();
		return $result;
  }
  
  public function totalT_asuhan_bayi($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('detail_asuhan_bayi');
		
		$total = $this->db->get()->row();
		return $total->total;
  }
  
  public function getT_keadaan_bayi($params)
  {
		$this->db->select('KD_KEADAAN_BAYI_LAHIR,KEADAAN_BAYI_LAHIR',false);
		$this->db->from('detail_keadaan_bayi ');
		
		$this->db->where('KD_KUNJUNGAN_BERSALIN',$params['id']);
		
		$this->db->limit($params['limit'],$params['start']);
		
		$result['data'] = $this->db->get()->result_array();
		//print_r($this->db->last_query());die();
		return $result;
  }
  
  public function totalT_keadaan_bayi($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('detail_keadaan_bayi');
		
		$total = $this->db->get()->row();
		return $total->total;
  }
  
  
}
