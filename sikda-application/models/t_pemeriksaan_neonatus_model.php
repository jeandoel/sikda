<?php
class T_pemeriksaan_neonatus_model extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getTransaksi_pemeriksaanneonatus($params)
  {

		$this->db->select("u.KD_PEMERIKSAAN_NEONATUS as id, u.KD_PEMERIKSAAN_NEONATUS, u.KD_PUSKESMAS, DATE_FORMAT(u.TANGGAL_KUNJUNGAN,'%d-%m-%Y'), u.KUNJUNGAN_KE, u.BERAT_BADAN, u.PANJANG_BADAN, GROUP_CONCAT(DISTINCT a.TINDAKAN_ANAK SEPARATOR ' | '), GROUP_CONCAT(DISTINCT a.KET_TINDAKAN_ANAK SEPARATOR ' , '), GROUP_CONCAT(DISTINCT i.TINDAKAN_IBU SEPARATOR ' | '), u.KELUHAN, concat (d.NAMA,'::',d.JABATAN), concat(e.NAMA, '::',e.JABATAN), u.KD_PEMERIKSAAN_NEONATUS as kode", false );
		$this->db->from('pemeriksaan_neonatus u');
		$this->db->join('trans_kia k', 'u.KD_KIA=k.KD_KIA');
		$this->db->join('mst_dokter d', 'd.KD_DOKTER=k.KD_DOKTER_PEMERIKSA', 'left');
		$this->db->join('mst_dokter e', 'e.KD_DOKTER=k.KD_DOKTER_PETUGAS', 'left');
		$this->db->join('detail_tindakan_anak_pem_neo a', 'a.KD_PEMERIKSAAN_NEONATUS=u.KD_PEMERIKSAAN_NEONATUS', 'left');
		$this->db->join('detail_tindakan_ibu_pem_neo i', 'i.KD_PEMERIKSAAN_NEONATUS=u.KD_PEMERIKSAAN_NEONATUS', 'left');

		if($params['get_kd_pasien']){
			$this->db->where('k.KD_PASIEN =', $params['get_kd_pasien']);
		}
		if($params['dari'] and empty($params['sampai'])){
			$this->db->where('u.TANGGAL_KUNJUNGAN =', date("Y-m-d", strtotime($params['dari'])));
		}
		if($params['sampai'] and empty($params['dari'])){
			$this->db->where('u.TANGGAL_KUNJUNGAN <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['dari'] and $params['sampai']){
			$this->db->where('u.TANGGAL_KUNJUNGAN >=', date("Y-m-d", strtotime($params['dari'])));
			$this->db->where('u.TANGGAL_KUNJUNGAN <=', date("Y-m-d", strtotime($params['sampai'])));
		}
		if($params['keyword']== 'KUNJUNGAN_KE' and $params['cari']){
			$this->db->where('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		if($params['keyword']== 'BERAT_BADAN' and $params['cari']){
			$this->db->where('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		if($params['keyword']== 'PANJANG_BADAN' and $params['cari']){
			$this->db->where('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		if($params['keyword']== 'd.NAMA' and $params['cari']){
			$this->db->where($params['keyword'].' like', '%'.$params['cari'].'%');
		}
		if($params['keyword']== 'e.NAMA' and $params['cari']){
			$this->db->where($params['keyword'].' like', '%'.$params['cari'].'%');
		}
		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->group_by ('u.KD_PEMERIKSAAN_NEONATUS','a.KD_TINDAKAN_ANAK','i.KD_TINDAKAN_IBU');
		$this->db->order_by('KD_PEMERIKSAAN_NEONATUS'.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		return $result;
  }
    
  public function totalTransaksi_pemeriksaanneonatus($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('pemeriksaan_neonatus u');
		$this->db->join('trans_kia k', 'u.KD_KIA=k.KD_KIA');
		if($params['get_kd_pasien']){
			$this->db->where('k.KD_PASIEN =', $params['get_kd_pasien']);
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
  public function getT_tindakan_anak($params)
  {
		$this->db->select("KD_TINDAKAN_ANAK,TINDAKAN_ANAK,HRG_TINDAKAN_ANAK,QTY, KET_TINDAKAN_ANAK",false);
		$this->db->from('detail_tindakan_anak_pem_neo');	
		//$this->db->join('detail_tindakan_anak_pem_neo c','u.KD_PEMERIKSAAN_NEONATUS=c.KD_PEMERIKSAAN_NEONATUS');
		
		$this->db->where('KD_PELAYANAN',$params['id']);
		$this->db->where('KD_PUSKESMAS',$params['idpuskesmas']);
		
		$this->db->limit($params['limit'],$params['start']);
		
		$this->db->order_by('TINDAKAN_ANAK '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		//print_r($this->db->last_query());die();
		return $result;
  }  
  public function totalT_tindakan_anak($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('detail_tindakan_anak_pem_neo');
		$this->db->where('KD_PELAYANAN',$params['id']);
		$this->db->where('KD_PUSKESMAS',$params['idpuskesmas']);
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
    public function getTransaksi_tindakanibu($params)
  {
		$this->db->select(" KD_TINDAKAN_IBU,TINDAKAN_IBU, HRG_TINDAKAN,QTY",false);
		$this->db->from('detail_tindakan_ibu_pem_neo');	
		//$this->db->join('detail_tindakan_anak_pem_neo c','u.KD_PEMERIKSAAN_NEONATUS=c.KD_PEMERIKSAAN_NEONATUS');
		
		$this->db->where('KD_PELAYANAN',$params['id']);
		$this->db->where('KD_PUSKESMAS',$params['idpuskesmas']);
		
		$this->db->limit($params['limit'],$params['start']);
		
		$this->db->order_by('TINDAKAN_IBU '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		//print_r($this->db->last_query());die();
		return $result;
  }  
   public function totalTransaksi_tindakanibu($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('detail_tindakan_ibu_pem_neo');
		$this->db->where('KD_PELAYANAN',$params['id']);
		$this->db->where('KD_PUSKESMAS',$params['idpuskesmas']);
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
   public function getTransaksi_alergiobat($params)
  {
		$this->db->select(" a.KD_OBAT, b.NAMA_OBAT, a.KD_OBAT as id",false);
		$this->db->from('pasien_alergi_obt a');	
		$this->db->join('apt_mst_obat b', 'a.KD_OBAT=b.KD_OBAT');	
		//$this->db->join('detail_tindakan_anak_pem_neo c','u.KD_PEMERIKSAAN_NEONATUS=c.KD_PEMERIKSAAN_NEONATUS');
		
		$this->db->where('KD_PASIEN',$params['id']);
		$this->db->where('a.KD_PUSKESMAS',$params['idpuskesmas']);
		
		$this->db->limit($params['limit'],$params['start']);
		
		$this->db->order_by('KD_OBAT '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		//print_r($this->db->last_query());die();
		return $result;
  }  
  
	public function getTransaksi_obat($params)
  {
		$this->db->select(" a.KD_OBAT, b.NAMA_OBAT,a.DOSIS, a.HRG_JUAL, QTY",false);
		$this->db->from('pel_ord_obat a');	
		$this->db->join('apt_mst_obat b', 'a.KD_OBAT=b.KD_OBAT');	
		//$this->db->join('detail_tindakan_anak_pem_neo c','u.KD_PEMERIKSAAN_NEONATUS=c.KD_PEMERIKSAAN_NEONATUS');
		
		$this->db->where('KD_PELAYANAN',$params['id']);
		$this->db->where('a.KD_PUSKESMAS',$params['idpuskesmas']);
		
		$this->db->limit($params['limit'],$params['start']);
		
		$this->db->order_by('KD_OBAT '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		//print_r($this->db->last_query());die();
		return $result;
  }  
  public function totalTransaksi_alergiobat($params){
  		$this->db->select("count(*) as total");
		$this->db->from('pasien_alergi_obt');
		$this->db->where('KD_PASIEN',$params['id']);
		$this->db->where('KD_PUSKESMAS',$params['idpuskesmas']);
		
		$total = $this->db->get()->row();
		return $total->total;
  }
  public function totalTransaksi_obat($params){
  		$this->db->select("count(*) as total");
		$this->db->from('pel_ord_obat a');
		$this->db->where('KD_PELAYANAN',$params['id']);
		$this->db->where('KD_PUSKESMAS',$params['idpuskesmas']);
		
		$total = $this->db->get()->row();
		return $total->total;
  }
    
}
