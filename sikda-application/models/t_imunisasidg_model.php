<?php
class T_imunisasidg_model extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getT_imunisasi($params)
  {
		$this->db->select("c.JENIS_IMUNISASI,b.NAMA_OBAT,a.KD_JENIS_IMUNISASI,a.KD_OBAT", false );
		$this->db->from('pel_imunisasi a');
		$this->db->join('apt_mst_obat b','a.KD_OBAT=b.KD_OBAT','left');
		$this->db->join('mst_jenis_imunisasi c','c.KD_JENIS_IMUNISASI=a.KD_JENIS_IMUNISASI','left');
		
		$this->db->where('a.KD_PELAYANAN', $params['kd_pelayanan']);
		$this->db->where('a.KD_PUSKESMAS',$params['idpuskesmas']);
						
		$result['data'] = $this->db->get()->result_array();
		// $result['data'][0]['NAMA_OBAT']=$this->db->last_query();

		return $result;
  }
    
  public function totalT_imunisasi($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('pel_imunisasi a');

		$this->db->where('a.KD_PELAYANAN', $params['kd_pelayanan']);
		$this->db->where('a.KD_PUSKESMAS',$params['idpuskesmas']);
		
		$total = $this->db->get()->row();
		return $total->total;
  }
  public function getT_petugas($params){

  		$this->db->select("d.NAMA");
		$this->db->from('pel_petugas a');
		$this->db->join('trans_imunisasi ti','ti.KD_TRANS_IMUNISASI=a.KD_TRANS_IMUNISASI');
		$this->db->join('mst_dokter d','d.KD_DOKTER=a.KD_DOKTER');

		$this->db->where('a.KD_PELAYANAN', $params['kd_pelayanan']);
		$this->db->where('ti.KD_PUSKESMAS',$params['idpuskesmas']);

		$result['data'] = $this->db->get()->result_array();
		// $result['data'][0]['NAMA_OBAT']=$this->db->last_query();

		return $result;
  }
  public function totalT_petugas($params){
  		$this->db->select("count(*) as total");
		$this->db->from('pel_petugas a');
		$this->db->join('trans_imunisasi ti','ti.KD_TRANS_IMUNISASI=a.KD_TRANS_IMUNISASI');

		$this->db->where('a.KD_PELAYANAN', $params['kd_pelayanan']);
		$this->db->where('ti.KD_PUSKESMAS',$params['idpuskesmas']);
		
		$total = $this->db->get()->row();
		return $total->total;
  }
 }