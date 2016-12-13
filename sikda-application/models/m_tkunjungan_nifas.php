<?php
class M_tkunjungan_nifas extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getT_kunjungannifas($params)
  {
		// $this->db->select ("u.KD_KUNJUNGAN_NIFAS as kode,DATE_FORMAT (u.TANGGAL_KUNJUNGAN, '%d-%M-%Y') as TANGGAL_KUNJUNGAN,u.KELUHAN,u.TEKANAN_DARAH, u.NADI, u.NAFAS, u.SUHU, u.KONTRAKSI_RAHIM, u.PERDARAHAN, u.WARNA_LOKHIA,u.JML_LOKHIA,u.BAU_LOKHIA,u.BUANG_AIR_BESAR, u.BUANG_AIR_KECIL, u.PRODUKSI_ASI, GROUP_CONCAT(DISTINCT t.TINDAKAN SEPARATOR ' | ') AS TINDAKAN, u.NASEHAT,concat (h.NAMA,'-',h.JABATAN) as PEMERIKSA,concat (i.NAMA,'-',i.JABATAN) as PETUGAS, u.KD_STATUS_HAMIL,u.KD_KESEHATAN_IBU,u.KD_KESEHATAN_BAYI,u.KD_KOMPLIKASI_NIFAS, u.KD_KUNJUNGAN_NIFAS as nid", false );
		// $this->db->from('kunjungan_nifas u');
		// $this->db->join('trans_kia k', 'u.KD_KIA=k.KD_KIA');
		// $this->db->join('mst_keadaan_kesehatan q','u.KD_KESEHATAN_BAYI=q.KD_KEADAAN_KESEHATAN','left');
		// $this->db->join('mst_komplikasi_nifas p','u.KD_KOMPLIKASI_NIFAS=p.KD_KOMPLIKASI_NIFAS','left');
		// $this->db->join('tindakan_nifas t', 'u.KD_KUNJUNGAN_NIFAS=t.KD_KUNJUNGAN_NIFAS');
		// $this->db->join('mst_dokter h','h.KD_DOKTER=k.KD_DOKTER_PEMERIKSA','left');
		// $this->db->join('mst_dokter i','i.KD_DOKTER=k.KD_DOKTER_PETUGAS','left');
  		$this->db->select('kn.KD_KIA, kn.TANGGAL_KUNJUNGAN, kn.KELUHAN, kn.TEKANAN_DARAH, kn.NADI, kn.NAFAS, kn.SUHU, kn.KONTRAKSI_RAHIM, kn.PERDARAHAN, kn.WARNA_LOKHIA, kn.JML_LOKHIA, kn.BAU_LOKHIA, kn.BUANG_AIR_BESAR, kn.BUANG_AIR_KECIL, kn.PRODUKSI_ASI, kn.NASEHAT, kn.KD_STATUS_HAMIL');
  		$this->db->from('kunjungan_nifas kn');
  		$this->db->join('trans_kia tk', 'tk.KD_KIA = kn.KD_KIA');
		if($params['get_kd_pasien']){
			$this->db->where('tk.KD_PASIEN =' ,$params['get_kd_pasien']);
		}
		if($params['kode']){
			$this->db->where('TEKANAN_DARAH like' ,$params['kode'].'%');
		}
		$this->db->limit($params['limit'],$params['start']);
		// $this->db->group_by('u.KD_KUNJUNGAN_NIFAS','t.KD_TINDAKAN ');
		$this->db->order_by('TEKANAN_DARAH '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array(); //print_r($result);die;
		
		return $result;
		////print_r($this->db->last_query());die()
  }

  public function totalT_kunjungannifas($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('kunjungan_nifas');
		$this->db->join('trans_kia tk', 'tk.KD_KIA = kunjungan_nifas.KD_KIA');
		if($params['get_kd_pasien']){
			$this->db->where('tk.KD_PASIEN =' ,$params['get_kd_pasien']);
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 
  public function getT_obat_nifas($params)
  {
	$this->db->select ("a.KD_OBAT,b.NAMA_OBAT,a.HRG_JUAL, a.QTY,a.DOSIS ",false);
	$this->db->from ('pel_ord_obat a');
	$this->db->join ('apt_mst_obat b', 'a.KD_OBAT=b.KD_OBAT');
	
		if($params['id']){
			$this->db->where('KD_PELAYANAN like' ,$params['id']);
		}
		$this->db->where('a.KD_PUSKESMAS',$params['idpuskesmas']);
		$this->db->limit($params['limit'],$params['start']);
		
		$this->db->order_by('KD_OBAT '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array(); //print_r($result);die;
		
		return $result;
		////print_r($this->db->last_query());die()
  } 
  
  public function getT_alergi_nifas($params)
  {
	$this->db->select ("a.KD_OBAT,b.NAMA_OBAT",false);
	$this->db->from ('pasien_alergi_obt a');
	$this->db->join ('apt_mst_obat b', 'a.KD_OBAT=b.KD_OBAT');
		$this->db->where('a.KD_PUSKESMAS',$params['idpuskesmas']);
	
	
		
		
		if($params['id']){
			$this->db->where('KD_PASIEN like' ,$params['id']);
		}
		$this->db->limit($params['limit'],$params['start']);
		
		$this->db->order_by('KD_OBAT '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array(); //print_r($result);die;
		
		return $result;
		////print_r($this->db->last_query());die()
  }


  public function getT_tindakan_nnifas($params)
  {
	$this->db->select ("a.KD_TINDAKAN,b.PRODUK,a.HRG_TINDAKAN,a.KETERANGAN,a.QTY",false);
	$this->db->from ('pel_tindakan a');
	$this->db->join ('mst_produk b', 'a.KD_TINDAKAN=b.KD_PRODUK');
		$this->db->where('a.KD_PUSKESMAS',$params['idpuskesmas']);
	
	
	
	
		
		
		if($params['id']){
			$this->db->where('KD_PELAYANAN like' ,$params['id']);
		}
		$this->db->limit($params['limit'],$params['start']);
		
		$this->db->order_by('KD_TINDAKAN '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array(); //print_r($result);die;
		
		return $result;
		////print_r($this->db->last_query());die()
  }

    

  
}
