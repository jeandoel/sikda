<?php
class T_masters_model extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
	function getProvinsiList(){
		$this->db->select('KD_PROVINSI, PROVINSI');
		$this->db->from('mst_provinsi');
		$this->db->order_by('PROVINSI','ASC');
		$array_keys_values = $this->db->get()->result_array();
		return $array_keys_values;
	}
	
	function getKabupatenByProvinceID($id){
		$this->db->select('KD_KABUPATEN, KABUPATEN');
		$this->db->from('mst_kabupaten');		
		$this->db->where('KD_PROVINSI',$id);
		$this->db->order_by('KABUPATEN','ASC');
		$array_keys_values = $this->db->get();
		return $array_keys_values;
	}
	
	function getKecamatanByKabupatenID($id){
		$this->db->select('KD_KECAMATAN, KECAMATAN');
		$this->db->from('mst_kecamatan');		
		$this->db->where('KD_KABUPATEN',$id);
		$this->db->order_by('KECAMATAN','ASC');
		$array_keys_values = $this->db->get();
		return $array_keys_values;
	}
	
	function getKelurahanByKecamatanID($id){
		$this->db->select('KD_KELURAHAN, KELURAHAN');
		$this->db->from('mst_kelurahan');		
		$this->db->where('KD_KECAMATAN',$id);
		$this->db->order_by('KELURAHAN','ASC');
		$array_keys_values = $this->db->get();
		return $array_keys_values;
	}
	
	function getNoKamarByNamaKamar($id){
		$this->db->select('NO_KAMAR');
		$this->db->from('mst_kamar');		
		$this->db->where('NAMA_KAMAR',$id);
		$this->db->order_by('NO_KAMAR','DESC');
		$array_keys_values = $this->db->get();
		return $array_keys_values;
	}
	
	function getNoBedByNoKamar($id){
		$this->db->select('JUMLAH_BED');
		$this->db->from('mst_kamar');		
		$this->db->where('NO_KAMAR',$id);
		$array_keys_values = $this->db->get()->row();
		return $array_keys_values;
	}
	
	function getDesaByKecamatanID($id){
		$this->db->select('KD_KELURAHAN, KELURAHAN');
		$this->db->from('mst_kelurahan');		
		$this->db->where('KD_KECAMATAN',$id);
		$this->db->order_by('KELURAHAN','ASC');
		$array_keys_values = $this->db->get();
		return $array_keys_values;
	}
	
	function getLevelByPuskesmas($id){
		$this->db->select('KD_PUSKESMAS, LEVEL');
		$this->db->from('sys_setting_def');		
		$this->db->where('KD_PUSKESMAS',$id);
		$this->db->order_by('LEVEL','ASC');
		$array_keys_values = $this->db->get();
		return $array_keys_values;
	}
	
	function getLevelByPuskesmasID($id,$level){
		$this->db->select('KD_PUSKESMAS, LEVEL');
		$this->db->from('sys_setting_def');		
		$this->db->where('KD_PUSKESMAS',$id);
		$this->db->where('LEVEL not like',$level);
		$this->db->where('LEVEL not like','Kabupaten');
		$array_keys_values = $this->db->get();
		return $array_keys_values;
	}
	
	function getLevelallByPuskesmasID(){
		$this->db->distinct('KD_PUSKESMAS, LEVEL');
		$this->db->from('sys_setting_def');		
		$this->db->where('KD_PUSKESMAS',$this->session->userdata('kd_puskesmas'));
		$array_keys_values = $this->db->get();
		return $array_keys_values;
	}
	
	function getPosyanduByPuskesmas($level){
		$this->db->select('ID, NAMA_POSYANDU');
		$this->db->from('t_posyandu');		
		$this->db->where('KD_KECAMATAN',$this->session->userdata('kd_kecamatan'));
		$array_keys_values = $this->db->get();
		return $array_keys_values;
	}
	
	function getSubLevelByPuskesmas($level){
		$this->db->select('KD_SUB_LEVEL, NAMA_SUB_LEVEL');
		$this->db->from('sys_setting_def');		
		$this->db->where('LEVEL',$level);
		$array_keys_values = $this->db->get();
		return $array_keys_values;
	}
	
	///////////////////////////////////////////////////////////////////////////////
	function getPuskesmasByKecamatanId($id){
		$this->db->select('KD_PUSKESMAS, PUSKESMAS');
		$this->db->from('mst_puskesmas');		
		$this->db->where('KD_KECAMATAN',$id);
		$this->db->order_by('PUSKESMAS','ASC');
		$array_keys_values = $this->db->get();
		return $array_keys_values;
	}
	function getPustuByKecamatanId($id){
		$this->db->select('KD_SUB_LEVEL, NAMA_SUB_LEVEL');
		$this->db->from('sys_setting_def');		
		$this->db->where('KD_KEC',$id);
		$this->db->where('LEVEL','PUSTU');
		$this->db->order_by('LEVEL','ASC');
		$array_keys_values = $this->db->get();
		return $array_keys_values;
	}
	
	function getPolindesByKecamatanId($id){
		$this->db->select('KD_SUB_LEVEL, NAMA_SUB_LEVEL');
		$this->db->from('sys_setting_def');		
		$this->db->where('KD_KEC',$id);
		$this->db->where('LEVEL','POLINDES');
		$this->db->order_by('LEVEL','ASC');
		$array_keys_values = $this->db->get();
		return $array_keys_values;
	}
	
	function getBidandesaByKecamatanId($id){
		$this->db->select('KD_SUB_LEVEL, NAMA_SUB_LEVEL');
		$this->db->from('sys_setting_def');		
		$this->db->where('KD_KEC',$id);
		$this->db->where('LEVEL','BIDAN');
		$this->db->order_by('LEVEL','ASC');
		$array_keys_values = $this->db->get();
		return $array_keys_values;
	}
	
	function getPuslingByKecamatanId($id){
		$this->db->select('KD_SUB_LEVEL, NAMA_SUB_LEVEL');
		$this->db->from('sys_setting_def');		
		$this->db->where('KD_KEC',$id);
		$this->db->where('LEVEL','PUSLIN');
		$this->db->order_by('LEVEL','ASC');//print_r($this->db->last_query());die;
		$array_keys_values = $this->db->get();
		return $array_keys_values;
	}
	///////////////////////////////////////////////////////////////////////////////////////
	
	public function getT_obatbyparent($params)
	{
		$this->db->select("p.KD_PUSKESMAS,pl.KD_KASIR,p.KD_OBAT,o.NAMA_OBAT,o.KD_GOL_OBAT,p.DOSIS,pm.HARGA_JUAL,p.QTY,p.QTY as jumlah,p.STATUS, IF((p.STATUS = 1),1,p.KD_PELAYANAN) AS STATUS_ALL,, IF((p.STATUS = 1),1,p.KD_PELAYANAN) AS STATUS_ALL2",false);
		$this->db->from('pel_ord_obat p');
		$this->db->join('apt_mst_obat o','o.KD_OBAT=p.KD_OBAT');		
		$this->db->join('apt_mst_harga_obat pm','pm.KD_OBAT=p.KD_OBAT');		
		$this->db->join('pelayanan pl','pl.KD_PELAYANAN=p.KD_PELAYANAN');		
		$this->db->where('p.KD_PELAYANAN =', $params['kd_pelayanan']);
		$this->db->where('p.KD_PUSKESMAS =', $params['kd_puskesmas']);
		//$this->db->where('pm.KD_TARIF =', 'AM');
		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('p.iROW'.$params['sort']);
		$this->db->group_by('p.KD_PUSKESMAS');
		$this->db->group_by('p.KD_PELAYANAN');
		$this->db->group_by('p.KD_OBAT');
		
		$result['data'] = $this->db->get()->result_array();//die($this->db->last_query());
		
		
		return $result;
	}

	public function totalT_obatbyparent($params)
	{
		$this->db->select("count(*) as total");
		
		$this->db->where('KD_PELAYANAN =', $params['kd_pelayanan']);
		$this->db->where('KD_PUSKESMAS =', $params['kd_puskesmas']);
		
		$this->db->from('pel_ord_obat');
		$total = $this->db->get()->row();
		return $total->total;
	}
	
	public function getT_riwayatbyparent($params)
	{
		$this->db->select('TANGGAL, NAMA_UNIT, PENYAKIT, TINDAKAN, NAMA_OBAT, CATATAN_DOKTER, KD_DOKTER',FALSE);
		$this->db->from('vw_mr_kunjungan');
				
		$this->db->where('KD_PASIEN =', $params['kd_pasien']);
		$this->db->where('KD_PUSKESMAS =', $params['kd_puskesmas']);
		//$this->db->where('KD_PELAYANAN =', $params['kd_pelayanan']);
		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_PASIEN'.$params['sort']);
		$this->db->order_by('TANGGAL','desc');
		$result['data'] = $this->db->get()->result_array();
		//PRINT_R($this->db->last_query());die;
		return $result;
	}
	
	public function getT_riwayatbyparentkb($params)
	{
		$this->db->select('TANGGAL, NAMA_UNIT, PENYAKIT, TINDAKAN, NAMA_OBAT, CATATAN_DOKTER, KD_DOKTER',FALSE);
		$this->db->from('vw_mr_kunjungan_kia1');
				
		$this->db->where('KD_PASIEN =', $params['kd_pasien']);
		$this->db->where('KD_PUSKESMAS =', $params['kd_puskesmas']);
		$this->db->where('KD_KUNJUNGAN =', $params['kd_kunjungan']);
		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_PASIEN'.$params['sort']);
		$this->db->order_by('TANGGAL','desc');
		$result['data'] = $this->db->get()->result_array();
		//PRINT_R($this->db->last_query());die;
		return $result;
	}
	
	public function getT_riwayatbyparentneo($params)
	{
		$this->db->select('TANGGAL, NAMA_UNIT, PENYAKIT, TINDAKAN, NAMA_OBAT, CATATAN_DOKTER, KD_DOKTER',FALSE);
		$this->db->from('vw_mr_kunjungan_kia');
				
		$this->db->where('KD_PASIEN =', $params['kd_pasien']);
		$this->db->where('KD_PUSKESMAS =', $params['kd_puskesmas']);
		$this->db->where('KD_KUNJUNGAN =', $params['kd_kunjungan']);
		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_PASIEN'.$params['sort']);
		$this->db->order_by('TANGGAL','desc');
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
	}

	public function getT_riwayatbyparentanak($params)
	{
		$this->db->select('TANGGAL, NAMA_UNIT, PENYAKIT, TINDAKAN, NAMA_OBAT, CATATAN_DOKTER, KD_DOKTER',FALSE);
		$this->db->from('vw_mr_kunjungan_kia3');
				
		$this->db->where('KD_PASIEN =', $params['kd_pasien']);
		$this->db->where('KD_PUSKESMAS =', $params['kd_puskesmas']);
		$this->db->where('KD_KUNJUNGAN =', $params['kd_kunjungan']);
		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_PASIEN'.$params['sort']);
		$this->db->order_by('TANGGAL','desc');
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
	}

	public function getT_riwayatbyparentother($params)
	{
		$this->db->select('TANGGAL, NAMA_UNIT, PENYAKIT, TINDAKAN, NAMA_OBAT, CATATAN_DOKTER, KD_DOKTER',FALSE);
		$this->db->from('vw_mr_kunjungan_kia2');
				
		$this->db->where('KD_PASIEN =', $params['kd_pasien']);
		$this->db->where('KD_PUSKESMAS =', $params['kd_puskesmas']);
		$this->db->where('KD_KUNJUNGAN =', $params['kd_kunjungan']);
		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_PASIEN'.$params['sort']);
		$this->db->order_by('TANGGAL','desc');
		$result['data'] = $this->db->get()->result_array();
		//PRINT_R($this->db->last_query());die;
		return $result;
	}

	public function totalT_riwayatbyparent($params)
	{
		$this->db->select("count(*) as total");
		
		$this->db->where('KD_PASIEN =', $params['kd_pasien']);
		$this->db->where('KD_PUSKESMAS =', $params['kd_puskesmas']);
		
		$this->db->from('vw_mr_kunjungan');
		$total = $this->db->get()->row();
		return $total->total;
	}
	
	public function getT_pasienbyparent($params)
	{
		$this->db->select("p.NO_PENGENAL,concat(p.TEMPAT_LAHIR,', ',p.TGL_LAHIR) as TTL,p.KD_GOL_DARAH,k.CUSTOMER,p.CARA_BAYAR,concat(TELEPON,' / ',HP) as TLP",false);
		$this->db->from('pasien p');
		$this->db->join('mst_kel_pasien k','k.KD_CUSTOMER=p.KD_CUSTOMER');
				
		$this->db->where('KD_PASIEN =', $params['kd_pasien']);
		$this->db->where('KD_PUSKESMAS =', $params['kd_puskesmas']);
		
		$this->db->limit($params['limit'],$params['start']);
		
		$result['data'] = $this->db->get()->result_array();
		
		
		return $result;
	}

	public function totalT_pasienbyparent($params)
	{
		$this->db->select("count(*) as total");
		
		$this->db->where('KD_PASIEN =', $params['kd_pasien']);
		$this->db->where('KD_PUSKESMAS =', $params['kd_puskesmas']);
		
		$this->db->from('pasien');
		$total = $this->db->get()->row();
		return $total->total;
	}
	
	public function getT_subgrid_pasien_kipi($params)
	{
		$this->db->select("p.*",false);
		$this->db->from('vw_subgrid_pasien_kipi p');
				
		$this->db->where('KD_PASIEN =', $params['kd_pasien']);

		$this->db->limit($params['limit'],$params['start']);
		
		$result['data'] = $this->db->get()->result_array();
		
		
		return $result;
	}

	public function totalT_subgrid_pasien_kipi($params)
	{
		$this->db->select("count(*) as total");
		
		$this->db->where('KD_PASIEN =', $params['kd_pasien']);
		
		$this->db->from('vw_pasien_kipi');
		$total = $this->db->get()->row();
		return $total->total;
	}
	
		function getLevelBySaranaPuskesmasID($id,$level){
		$this->db->select('KD_PUSKESMAS, LEVEL');
		$this->db->from('sys_setting_def');		
		$this->db->where('KD_PUSKESMAS',$id);
		$this->db->where('LEVEL not like',$level);
		$this->db->where('LEVEL not like','Kabupaten');
		$array_keys_values = $this->db->get();
		return $array_keys_values;
	}
		
	function getLevelallBySaranaPuskesmasID(){
		$this->db->distinct('KD_PUSKESMAS, LEVEL');
		$this->db->from('sys_setting_def');		
		$this->db->where('KD_PUSKESMAS',$this->session->userdata('kd_puskesmas'));
		$array_keys_values = $this->db->get();
		return $array_keys_values;
	}
		
	function getSubLevelBySaranaPuskesmas($level){
		$this->db->select('KD_SUB_LEVEL, NAMA_SUB_LEVEL');
		$this->db->from('sys_setting_def');		
		$this->db->where('LEVEL',$level);
		$array_keys_values = $this->db->get();
		return $array_keys_values;
	}
  
}
