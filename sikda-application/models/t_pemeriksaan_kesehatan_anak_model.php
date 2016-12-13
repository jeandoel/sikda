<?php
class T_pemeriksaan_kesehatan_anak_model extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function gett_pemeriksaan_kesehatan_anak($params)
  {
		// $this->db->select("a.KD_PEMERIKSAAN_ANAK as kode,a.KD_PUSKESMAS,a.KD_PEMERIKSAAN_ANAK,DATE_FORMAT(a.TANGGAL_KUNJUNGAN,'%d-%m-%Y'),GROUP_CONCAT(DISTINCT c.PENYAKIT SEPARATOR ' | '),GROUP_CONCAT(DISTINCT o.PRODUK SEPARATOR ' , '),concat(d.NAMA,'--',d.JABATAN)as kolom_nama_pemeriksa, e.NAMA as kolom_nama_petugas, a.KD_PEMERIKSAAN_ANAK as id",false);
		// $this->db->from('pemeriksaan_anak a');
		// $this->db->join('pem_kes_icd c','a.KD_PEMERIKSAAN_ANAK=c.KD_PEMERIKSAAN_ANAK', 'left');
		// $this->db->join('pem_kes_produk o','a.KD_PEMERIKSAAN_ANAK=o.KD_PEMERIKSAAN_ANAK' , 'left');
		// $this->db->join('trans_kia k','a.KD_KIA=k.KD_KIA', 'left');
		// $this->db->join('mst_dokter d','k.KD_DOKTER_PEMERIKSA=d.KD_DOKTER', 'left');
		// $this->db->join('mst_dokter e','k.KD_DOKTER_PETUGAS=e.KD_DOKTER', 'left');


		$this->db->select("a.KD_PEMERIKSAAN_ANAK as kode,a.KD_PUSKESMAS,a.KD_PEMERIKSAAN_ANAK,DATE_FORMAT(a.TANGGAL_KUNJUNGAN,'%d-%m-%Y'),GROUP_CONCAT(DISTINCT mi.PENYAKIT SEPARATOR ' | '),GROUP_CONCAT(DISTINCT mp.PRODUK SEPARATOR ' , '),concat(d.NAMA,'--',d.JABATAN)as kolom_nama_pemeriksa, e.NAMA as kolom_nama_petugas, a.KD_PEMERIKSAAN_ANAK as id",false);
  		$this->db->from('pemeriksaan_anak a');
  		$this->db->join('trans_kia k', 'a.KD_KIA=k.KD_KIA');
  		$this->db->join('mst_dokter d','k.KD_DOKTER_PEMERIKSA=d.KD_DOKTER', 'left');
		$this->db->join('mst_dokter e','k.KD_DOKTER_PETUGAS=e.KD_DOKTER', 'left');
		$this->db->join('pel_diagnosa pd', 'k.KD_PELAYANAN = pd.KD_PELAYANAN');
		$this->db->join('mst_icd mi','pd.KD_PENYAKIT=mi.KD_PENYAKIT');
		$this->db->join('pel_tindakan pt', 'k.KD_PELAYANAN = pt.KD_PELAYANAN');
		$this->db->join('mst_produk mp','mp.KD_PRODUK=pt.KD_TINDAKAN');
		
		if($params['get_kd_pasien']){
			$this->db->where('a.KD_PASIEN =', $params['get_kd_pasien']);
		}
		if($params['dari'] and empty($params['sampai'])){
			$this->db->where('a.ninput_tgl =', date("Y-m-d", strtotime($params['dari'])));
		}
		if($params['sampai'] and empty($params['dari'])){
			$this->db->where('a.ninput_tgl <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['dari'] and $params['sampai']){
			$this->db->where('a.ninput_tgl >=', date("Y-m-d", strtotime($params['dari'])));
			$this->db->where('a.ninput_tgl <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['keyword']== 'PENYAKIT' and $params['carinama']){
			$this->db->where('c.'.$params['keyword'].' like', '%'.$params['carinama'].'%');
		}
		if($params['keyword']=='PRODUK' and $params['carinama']){
			$this->db->where('o.'.$params['keyword'].' like', '%'.$params['carinama'].'%');
		}
		if($params['keyword']=='d.NAMA' and $params['carinama']){
			$this->db->where($params['keyword'].' like', '%'.$params['carinama'].'%');
		}
		if($params['keyword']=='e.NAMA' and $params['carinama']){
			$this->db->where($params['keyword'].' like', '%'.$params['carinama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->group_by('a.KD_PEMERIKSAAN_ANAK','mi.KD_PENYAKIT','mp.KD_PRODUK');
		$this->db->order_by('KD_PEMERIKSAAN_ANAK '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		//print_r($this->db->last_query());die();
		return $result;
  }
    
  public function totalt_pemeriksaan_kesehatan_anak($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('pemeriksaan_anak');
		$this->db->join('trans_kia k','pemeriksaan_anak.KD_KIA=k.KD_KIA');
		if($params['get_kd_pasien']){
			$this->db->where('k.KD_PASIEN =', $params['get_kd_pasien']);
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
  public function getT_penyakit_anak($params)
  {
		$this->db->select('pd.KD_PENYAKIT,mi.PENYAKIT,pd.JNS_KASUS,pd.JNS_DX',false);
		$this->db->from('pel_diagnosa pd');
		$this->db->join('mst_icd mi','pd.KD_PENYAKIT=mi.KD_PENYAKIT');
		$this->db->where('pd.KD_PELAYANAN',$params['id']);
		
		$this->db->limit($params['limit'],$params['start']);
		
		$this->db->order_by('pd.KD_PELAYANAN'.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		//print_r($this->db->last_query());die();
		return $result;
  }
  
  public function totalT_penyakit_anak($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('pel_diagnosa pd');
		$this->db->where('pd.KD_PELAYANAN',$params['id']);
		
		$total = $this->db->get()->row();
		return $total->total;
  }
  
  public function getT_tindakan_anak($params)
  {
		$this->db->select('pt.KD_TINDAKAN,mp.PRODUK,pt.HRG_TINDAKAN,pt.QTY,pt.KETERANGAN',false);
		$this->db->from('pel_tindakan pt');
		$this->db->join('mst_produk mp','mp.KD_PRODUK=pt.KD_TINDAKAN');
		
		$this->db->where('pt.KD_PELAYANAN',$params['id']);
		
		$this->db->limit($params['limit'],$params['start']);
		
		$this->db->order_by('pt.KD_PELAYANAN '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		//print_r($this->db->last_query());die();
		return $result;
  }
  
  public function totalT_tindakan_anak($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('pel_tindakan pt');
		$this->db->where('pt.KD_PELAYANAN',$params['id']);
		
		$total = $this->db->get()->row();
		return $total->total;
  }
  
  public function getT_alergi_anak($params)
  {
		$this->db->select('ao.KD_OBAT,mo.NAMA_OBAT',false);
		$this->db->from('pasien_alergi_obt ao');	
		$this->db->join('apt_mst_obat mo','mo.KD_OBAT=ao.KD_OBAT');	
		
		$this->db->where('ao.KD_PASIEN',$params['id']);
		
		$this->db->limit($params['limit'],$params['start']);
		
		$this->db->order_by('ao.KD_OBAT '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		//print_r($this->db->last_query());die();
		return $result;
  }
  
  public function totalT_alergi_anak($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('pasien_alergi_obt');
		$this->db->where('KD_PASIEN',$params['id']);
		
		$total = $this->db->get()->row();
		return $total->total;
  }
  
  public function getT_obat_anak($params)
  {
		$this->db->select('po.KD_OBAT,mo.NAMA_OBAT,po.DOSIS,po.HRG_JUAL,po.QTY',false);
		$this->db->from('pel_ord_obat po');	
		$this->db->join('apt_mst_obat mo','mo.KD_OBAT=po.KD_OBAT');
		$this->db->where('po.KD_PELAYANAN',$params['id']);
		
		$this->db->limit($params['limit'],$params['start']);
		
		$this->db->order_by('po.KD_OBAT'.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		//print_r($this->db->last_query());die();
		return $result;
  }
  
  public function totalT_obat_anak($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('pel_ord_obat');
		$this->db->where('KD_PELAYANAN',$params['id']);
		
		$total = $this->db->get()->row();
		return $total->total;
  }
  
}