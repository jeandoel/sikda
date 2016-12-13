<?php
class T_pelayanan_model extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getT_pelayanan($params)
  {
		$this->db->select("ID_KUNJUNGAN,KD_PELAYANAN,KD_PUSKESMAS,KD_PASIEN,URUT_MASUK, SHORT_KD_PASIEN, NAMA_PASIEN, REPLACE(REPLACE(REPLACE(UMUR,'m','Bln'),'y','Th'),'d','Hr') AS UMUR, KK, ALAMAT, NAMA_UNIT, KD_DOKTER, STATUS, MYKD_KUNJUNGAN, MYKD_KUNJUNGAN as MYKD_KUNJUNGANDUA, KD_UNIT, KD_UNIT_LAYANAN, TGL_MASUK",false);
		$this->db->from('vw_lst_antrian');
		
		if($params['dari']){
			$this->db->where('TGL_MASUK =', date("Y-m-d", strtotime(str_replace('/', '-',$params['dari']))));
		}
		if($params['unit']!=='all'){
			$this->db->where('KD_UNIT =', $params['unit']);
		}
		if($params['status']){
			$this->db->where('STATUS =', $params['status']);
		}
		if($params['jenis']){
			$parentselect = $params['jenis']==2?2:99;
			$this->db->where('PARENT =', $parentselect);
		}

		if($params['get_key'] and $params['get_cari']){
			$this->db->where ('vw_lst_antrian.'.$params['get_key'].' like', '%'.$params['get_cari'].'%');
		}
		

		$this->db->where ('KD_PUSKESMAS =', $this->session->userdata('kd_puskesmas'));		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('STATUS','asc');
		$this->db->order_by('KD_PELAYANAN','asc');
		
		$result['data'] = $this->db->get()->result_array();

		// $result['data'][0]['URUT_MASUK'] = $this->db->last_query();
		
		//print_r($this->db->last_query());die;
		return $result;
  }
    
	public function getT_pendaftaran($params)
  {
		$this->db->select("KD_KUNJUNGAN,KD_PELAYANAN,KD_PUSKESMAS,KD_PASIEN,URUT_MASUK, SHORT_KD_PASIEN, NAMA_PASIEN, REPLACE(REPLACE(REPLACE(UMUR,'m','Bln'),'y','Th'),'d','Hr') AS UMUR, KK, ALAMAT, NAMA_UNIT, KD_DOKTER, STATUS, MYKD_KUNJUNGAN, MYKD_KUNJUNGAN as MYKD_KUNJUNGANDUA, KD_UNIT, KD_UNIT_LAYANAN, TGL_MASUK",false);
		$this->db->from('vw_lst_antrian');
		
		if($params['dari']){
			$this->db->where('TGL_MASUK =', date("Y-m-d", strtotime(str_replace('/', '-',$params['dari']))));
		}
		if($params['unit']!=='all'){
			$this->db->where('KD_UNIT =', $params['unit']);
		}
		if($params['status']){
			$this->db->where('STATUS =', $params['status']);
		}
		if($params['jenis']){
			$parentselect = $params['jenis']==2?2:99;
			$this->db->where('PARENT =', $parentselect);
		}

		//if($params['get_key'] and $params['get_cari']){
		//	$this->db->where ('vw_lst_antrian.'.$params['get_key'].' like', '%'.$params['get_cari'].'%');
		//}
		

		$this->db->where ('KD_PUSKESMAS =', $this->session->userdata('kd_puskesmas'));		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('STATUS','asc');
		$this->db->order_by('KD_PELAYANAN','asc');
		
		$result['data'] = $this->db->get()->result_array();

		// $result['data'][0]['URUT_MASUK'] = $this->db->last_query();
		
		//print_r($this->db->last_query());die;
		return $result;
  }
  
  public function totalT_pelayanan($params)
  {
		$this->db->select("count(*) as total");
		
		if($params['dari']){
			$this->db->where('TGL_MASUK =', date("Y-m-d", strtotime(str_replace('/', '-',$params['dari']))));
		}
		if($params['unit']!=='all'){
			$this->db->where('KD_UNIT =', $params['unit']);
		}
		if($params['status']){
			$this->db->where('STATUS =', $params['status']);
		}
		if($params['jenis']){
			$parentselect = $params['jenis']==2?2:99;
			$this->db->where('PARENT =', $parentselect);
		}
		
		if($params['get_key'] and $params['get_cari']){
			$this->db->where ('vw_lst_antrian.'.$params['get_key'].' like', '%'.$params['get_cari'].'%');
		}

		$this->db->where ('KD_PUSKESMAS =', $this->session->userdata('kd_puskesmas'));		
		$this->db->from('vw_lst_antrian');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
  public function totalT_pendaftaran($params)
  {
		$this->db->select("count(*) as total");
		
		if($params['dari']){
			$this->db->where('TGL_MASUK =', date("Y-m-d", strtotime(str_replace('/', '-',$params['dari']))));
		}
		if($params['unit']!=='all'){
			$this->db->where('KD_UNIT =', $params['unit']);
		}
		if($params['status']){
			$this->db->where('STATUS =', $params['status']);
		}
		if($params['jenis']){
			$parentselect = $params['jenis']==2?2:99;
			$this->db->where('PARENT =', $parentselect);
		}
		
		//if($params['get_key'] and $params['get_cari']){
		//	$this->db->where ('vw_lst_antrian.'.$params['get_key'].' like', '%'.$params['get_cari'].'%');
		//}

		$this->db->where ('KD_PUSKESMAS =', $this->session->userdata('kd_puskesmas'));		
		$this->db->from('vw_lst_antrian');
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
   public function getsubgridpeltranskia($params)
	{
		$this->db->select("p.ID_KUNJUNGAN,n.KD_PELAYANAN,p.KD_PUSKESMAS,p.KD_PASIEN, DATE_FORMAT(n.TGL_PELAYANAN,'%d-%m-%Y'),o.UNIT as unit,p.KD_DOKTER as pemeriksa, p.KD_DOKTER as petugas, p.KD_KUNJUNGAN as id",false);
		$this->db->from('kunjungan p');	
		$this->db->join('pelayanan n','n.KD_PELAYANAN=p.KD_PELAYANAN');	
		$this->db->join('mst_unit o','o.KD_UNIT=p.KD_UNIT');	
		$this->db->where('p.KD_PASIEN =', $params['kd_pasien']);
		//$this->db->where('p.KD_PELAYANAN =', $params['kd_pelayanan']);
		$this->db->where('p.KD_PUSKESMAS =', $params['kd_puskesmas']);
		$this->db->where('n.KD_PUSKESMAS',$params['kd_puskesmas']);
		
		$this->db->where('n.KD_PASIEN',$params['kd_pasien']); //added rev01: 26-10-2014
		
		//$this->db->where('KD_KUNJUNGAN =', $params['kd_kunjungan']);
		
		$this->db->limit($params['limit'],$params['start']);
		
		$result['data'] = $this->db->get()->result_array();

		//$result['data'][0]['unit']=$this->db->last_query();
		
		//print_r($this->db->last_query());die;
		return $result;
	}
	public function totalsubgridpeltranskia($params)
	{
		$this->db->select("count(*) as total");
		$this->db->from('kunjungan p');
		$this->db->join('pelayanan n','n.KD_PELAYANAN=p.KD_PELAYANAN'); //added rev01: 26-10-2014
		$this->db->join('mst_unit o','o.KD_UNIT=p.KD_UNIT');	 //added rev01: 26-10-2014	
		$this->db->where('p.KD_PASIEN =', $params['kd_pasien']);
		$this->db->where('p.KD_PUSKESMAS =', $params['kd_puskesmas']);
		$this->db->where('n.KD_PUSKESMAS', $params['kd_puskesmas']); //added rev01: 26-10-2014
		$this->db->where('n.KD_PASIEN',$params['kd_pasien']); //added rev01: 26-10-2014
		
		$total = $this->db->get()->row();
		return $total->total;
	}
	
	public function getDiagnosarawatjalan($params)
	{
		$this->db->select(" a.KD_PENYAKIT, b.PENYAKIT, a.JNS_KASUS, a.JNS_DX",false);
		$this->db->from('pel_diagnosa a');
		$this->db->join('mst_icd b','b.KD_PENYAKIT=a.KD_PENYAKIT','left');
		$this->db->where('a.KD_PELAYANAN',$params['id1']);
		$this->db->where('a.KD_PUSKESMAS',$params['idpuskesmas']);
		$result['data'] = $this->db->get()->result_array();
		return $result;
	}  
  
	public function totalDiagnosarawatjalan($params)
	{
		$this->db->select("count(*) as total");
		$this->db->from('pel_diagnosa');
		$this->db->where('KD_PELAYANAN',$params['id1']);
		$this->db->where('KD_PUSKESMAS',$params['idpuskesmas']);
		
		$total = $this->db->get()->row();
		return $total->total;
	}
	public function getTindakanrawatjalan($params)
	{
		$this->db->select("a.KD_TINDAKAN, b.PRODUK, a.HRG_TINDAKAN, a.QTY, a.KETERANGAN",false);
		$this->db->from('pel_tindakan a');
		$this->db->join('mst_produk b','b.KD_PRODUK=a.KD_TINDAKAN','left');
		$this->db->where('a.KD_PELAYANAN',$params['id2']);
		$this->db->where('a.KD_PUSKESMAS',$params['idpuskesmas']);
		
		$result['data'] = $this->db->get()->result_array();
		return $result;
	}  
  
	public function totalTindakanrawatjalan($params)
	{
		$this->db->select("count(*) as total");
		$this->db->from('pel_tindakan');
		$this->db->where('KD_PELAYANAN',$params['id2']);
		$this->db->where('KD_PUSKESMAS',$params['idpuskesmas']);
		
		$total = $this->db->get()->row();
		return $total->total;
	}
  
	public function getAlergirawatjalan($params)
	{
		$this->db->select("a.KD_OBAT, b.NAMA_OBAT",false);
		$this->db->from('pasien_alergi_obt a');
		$this->db->join('apt_mst_obat b','b.KD_OBAT=a.KD_OBAT','left');
		$this->db->where('a.KD_PASIEN',$params['id3']);
		$this->db->where('a.KD_PUSKESMAS',$params['idpuskesmas']);
	
		$result['data'] = $this->db->get()->result_array();
		return $result;
	}  
  
	public function totalAlergirawatjalan($params)
	{
		$this->db->select("count(*) as total");
		$this->db->from('pasien_alergi_obt');
		$this->db->where('KD_PASIEN',$params['id3']);
		$this->db->where('KD_PUSKESMAS',$params['idpuskesmas']);
		
		$total = $this->db->get()->row();
		return $total->total;
	}
  
	public function getObatrawatjalan($params)
	{
		$this->db->select("a.KD_OBAT, b.NAMA_OBAT, a.DOSIS,a.HRG_JUAL,a.JUMLAH",false);
		$this->db->from('pel_ord_obat a');
		$this->db->join('apt_mst_obat b','b.KD_OBAT=a.KD_OBAT','left');
		$this->db->where('KD_PELAYANAN',$params['id4']);
		$this->db->where('a.KD_PUSKESMAS',$params['idpuskesmas']);
		$result['data'] = $this->db->get()->result_array();
		return $result;
	}  
  
	public function totalObatrawatjalan($params)
	{
		$this->db->select("count(*) as total");
		$this->db->from('pel_ord_obat');
		$this->db->where('KD_PELAYANAN',$params['id4']);
		$this->db->where('KD_PUSKESMAS',$params['idpuskesmas']);
		
		$total = $this->db->get()->row();
		return $total->total;
	}
	
	public function getDiagnosarawatinap($params)
	{
		$this->db->select(" a.KD_PENYAKIT, b.PENYAKIT, a.JNS_KASUS, a.JNS_DX",false);
		$this->db->from('pel_diagnosa a');
		$this->db->join('mst_icd b','b.KD_PENYAKIT=a.KD_PENYAKIT','left');
		$this->db->where('a.KD_PELAYANAN',$params['id1']);
		$this->db->where('a.KD_PUSKESMAS',$params['idpuskesmas']);
		$result['data'] = $this->db->get()->result_array();
		return $result;
	}  
  
	public function totalDiagnosarawatinap($params)
	{
		$this->db->select("count(*) as total");
		$this->db->from('pel_diagnosa');
		$this->db->where('KD_PELAYANAN',$params['id1']);
		$this->db->where('KD_PUSKESMAS',$params['idpuskesmas']);
		
		$total = $this->db->get()->row();
		return $total->total;
	}
	public function getTindakanrawatinap($params)
	{
		$this->db->select("a.KD_TINDAKAN, b.PRODUK, a.HRG_TINDAKAN, a.QTY, a.KETERANGAN",false);
		$this->db->from('pel_tindakan a');
		$this->db->join('mst_produk b','b.KD_PRODUK=a.KD_TINDAKAN','left');
		$this->db->where('a.KD_PELAYANAN',$params['id2']);
		$this->db->where('a.KD_PUSKESMAS',$params['idpuskesmas']);
		
		$result['data'] = $this->db->get()->result_array();
		return $result;
	}  
  
	public function totalTindakanrawatinap($params)
	{
		$this->db->select("count(*) as total");
		$this->db->from('pel_tindakan');
		$this->db->where('KD_PELAYANAN',$params['id2']);
		$this->db->where('KD_PUSKESMAS',$params['idpuskesmas']);
		
		$total = $this->db->get()->row();
		return $total->total;
	}
  
	public function getAlergirawatinap($params)
	{
		$this->db->select("a.KD_OBAT, b.NAMA_OBAT",false);
		$this->db->from('pasien_alergi_obt a');
		$this->db->join('apt_mst_obat b','b.KD_OBAT=a.KD_OBAT','left');
		$this->db->where('a.KD_PASIEN',$params['id3']);
		$this->db->where('a.KD_PUSKESMAS',$params['idpuskesmas']);
		$result['data'] = $this->db->get()->result_array();
		return $result;
	}  
  
	public function totalAlergirawatinap($params)
	{
		$this->db->select("count(*) as total");
		$this->db->from('pasien_alergi_obt');
		$this->db->where('KD_PASIEN',$params['id3']);
		$this->db->where('KD_PUSKESMAS',$params['idpuskesmas']);
		
		$total = $this->db->get()->row();
		return $total->total;
	}
  
	public function getObatrawatinap($params)
	{
		$this->db->select("a.KD_OBAT, b.NAMA_OBAT, a.DOSIS,a.HRG_JUAL,a.JUMLAH",false);
		$this->db->from('pel_ord_obat a');
		$this->db->join('apt_mst_obat b','b.KD_OBAT=a.KD_OBAT','left');
		$this->db->where('KD_PELAYANAN',$params['id4']);
		$this->db->where('a.KD_PUSKESMAS',$params['idpuskesmas']);
		$result['data'] = $this->db->get()->result_array();
		return $result;
	}  
  
	public function totalObatrawatinap($params)
	{
		$this->db->select("count(*) as total");
		$this->db->from('pel_ord_obat');
		$this->db->where('KD_PELAYANAN',$params['id4']);
		$this->db->where('KD_PUSKESMAS',$params['idpuskesmas']);
		
		$total = $this->db->get()->row();
		return $total->total;
	}
	
}
