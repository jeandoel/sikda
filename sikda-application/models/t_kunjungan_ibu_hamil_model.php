<?php
class T_kunjungan_ibu_hamil_model extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function gett_kunjungan_ibu_hamil($params)
  {
		$this->db->select("a.KD_KUNJUNGAN_BUMIL as kode,a.KD_KUNJUNGAN_BUMIL, a.KD_KIA, DATE_FORMAT(a.TANGGAL_KUNJUNGAN,'%d-%m-%Y') AS TANGGAL_KUNJUNGAN, a.KUNJUNGAN_KE, a.KELUHAN, a.TEKANAN_DARAH, a.BERAT_BADAN, a.UMUR_KEHAMILAN, a.TINGGI_FUNDUS, l.LETAK_JANIN, a.DENYUT_JANTUNG, a.KAKI_BENGKAK, a.LAB_DARAH_HB, a.LAB_URIN_REDUKSI, a.LAB_URIN_PROTEIN, GROUP_CONCAT(DISTINCT t.PRODUK SEPARATOR ' | ') AS TINDAKAN, a.PEMERIKSAAN_KHUSUS, j.JENIS_KASUS,h.STATUS_HAMIL, a.NASEHAT, a.KD_KUNJUNGAN_BUMIL as id",false);
		$this->db->from('kunjungan_bumil a');
		$this->db->join('trans_kia k','a.KD_KIA=k.KD_KIA','left');
		$this->db->join('mst_letak_janin l','l.KD_LETAK_JANIN=a.KD_LETAK_JANIN','left');
		$this->db->join('bumil_produk t','t.KD_PRODUK=a.KD_TINDAKAN','left');
		$this->db->join('mst_kasus_jenis j','j.KD_JENIS_KASUS=a.KD_JENIS_KASUS','left');
		$this->db->join('mst_status_hamil h','h.KD_STATUS_HAMIL=a.KD_STATUS_HAMIL','left');
		
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
		if($params['keyword']== 'KUNJUNGAN_KE' and $params['carinama']){
			$this->db->where($params['keyword'].' like', '%'.$params['carinama'].'%');
		}
		if($params['keyword']=='PRODUK' and $params['carinama']){
			$this->db->where('t.'.$params['keyword'].' like', '%'.$params['carinama'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->group_by('a.KD_KUNJUNGAN_BUMIL','t.KD_PRODUK');
		$this->db->order_by('a.KD_KUNJUNGAN_BUMIL '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		//print_r($this->db->last_query());die();
		return $result;
  }
    
  public function totalt_kunjungan_ibu_hamil($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('kunjungan_bumil');
		if($params['get_kd_pasien']){
			$this->db->where('kunjungan_bumil.KD_PASIEN =', $params['get_kd_pasien']);
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
  public function getT_tindakan_bumil($params)
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
  
  public function totalT_tindakan_bumil($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('pel_tindakan');
		$this->db->where('KD_PELAYANAN',$params['id']);
		$this->db->where('KD_PUSKESMAS',$params['idpuskesmas']);
		
		$total = $this->db->get()->row();
		return $total->total;
  }
  
  public function getT_obat_bumil($params)
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
  
  public function totalT_obat_bumil($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('pel_ord_obat');
		$this->db->where('KD_PELAYANAN',$params['id']);
		$this->db->where('KD_PUSKESMAS',$params['idpuskesmas']);
		
		$total = $this->db->get()->row();
		return $total->total;
  }
  
  public function getT_alergi_bumil($params)
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
  
  public function totalT_alergi_bumil($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('pasien_alergi_obt');
		$this->db->where('KD_PASIEN',$params['id']);
		$this->db->where('KD_PUSKESMAS',$params['idpuskesmas']);
		
		$total = $this->db->get()->row();
		return $total->total;
  }
  
}