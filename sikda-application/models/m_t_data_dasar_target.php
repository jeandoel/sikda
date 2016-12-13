<?php
class M_t_data_dasar_target extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getData_dasar_target($params)
  {
		$this->db->select("u.KD_DATA_DASAR,u.KD_KECAMATAN, u.KD_KELURAHAN, a.KECAMATAN, b.KELURAHAN, TAHUN, JML_BAYI, JML_BALITA, JML_ANAK, JML_CATEN, JML_WUS_HAMIL, JML_WUS_TDK_HAMIL, KD_DATA_DASAR as nid", false );
		$this->db->from('data_dasar u');
		$this->db->join('mst_kecamatan a','a.KD_KECAMATAN=u.KD_KECAMATAN');
		$this->db->join('mst_kelurahan b','b.KD_KELURAHAN=u.KD_KELURAHAN');
		
		
		if ($params['kodedatadasartarget'] and $params['carinama']){
			$tb=$params['kodedatadasartarget']=='KELURAHAN'?'b.':'u.';
			$this->db->where($tb.$params['kodedatadasartarget'].' like', '%'.$params['carinama'].'%');	
		}
		
		$this->db->where('a.KD_KECAMATAN',$this->session->userdata('kd_kecamatan'));
		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_DATA_DASAR'.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		//print_r($this->db->last_query());die;
		return $result;
  }
  
   public function totalt_datadasartarget($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('data_dasar u');
		$this->db->join('mst_kecamatan a','a.KD_KECAMATAN=u.KD_KECAMATAN');
		$this->db->join('mst_kelurahan b','b.KD_KELURAHAN=u.KD_KELURAHAN');
		
		
		if ($params['kodedatadasartarget'] and $params['carinama']){
			$tb=$params['kodedatadasartarget']=='KELURAHAN'?'b.':'u.';
			$this->db->where($tb.$params['kodedatadasartarget'].' like', '%'.$params['carinama'].'%');	
		}
		
		$this->db->where('a.KD_KECAMATAN',$this->session->userdata('kd_kecamatan'));
		
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function totalsubgriddatadasartarget($params)
	{
		$this->db->select("count(*) as total");
		
		$this->db->where('KD_KELURAHAN =', $params['namadesa']);
		//$this->db->where('a.KD_KECAMATAN',$this->session->userdata('kd_kecamatan'));
		
		$this->db->from('trans_imunisasi');
		$total = $this->db->get()->row();
		return $total->total;
	}
 
 public function getsubgridData_dasar_target($params)
	{
		$this->db->select("a.KD_KELURAHAN, a.TAHUN, SUM(IF((a.KD_JENIS_PASIEN ='1'), 1,0)) AS JUMLAH_SISWA, SUM(IF((a.KD_JENIS_PASIEN ='2'), 1,0)) AS ANAK,
						  SUM(IF((a.KD_JENIS_PASIEN ='3'), 1,0)) AS BAYI, SUM(IF((a.KD_JENIS_PASIEN ='4'), 1,0)) AS BALITA, 
						  SUM(IF((a.KD_JENIS_PASIEN ='5'), 1,0)) AS WUS_TIDAK_HAMIL, SUM(IF((a.KD_JENIS_PASIEN ='6'), 1,0)) AS WUS_HAMIL, 
						  SUM(IF((a.KD_JENIS_PASIEN ='7'), 1,0)) AS PASIEN_BIASA, SUM(IF((a.KD_JENIS_PASIEN ='8'), 1,0)) AS CATEN, a.KD_KELURAHAN as nid", false);
		$this->db->from('trans_imunisasi a');	
		$this->db->join('mst_jenis_pasien b','a.KD_JENIS_PASIEN=b.KD_JENIS_PASIEN');	
		$this->db->join('data_dasar c','c.KD_KELURAHAN=a.`KD_KELURAHAN`');	
		$this->db->group_by('a.TAHUN ASC');
		
		$this->db->where('c.KD_KELURAHAN =', $params['namadesa']);
		$this->db->where('c.KD_KECAMATAN =', $params['kodekecamatan']);
		$this->db->where('c.TAHUN =', $params['tahun']);
		
		$result['data'] = $this->db->get()->result_array();
		
		//print_r($this->db->last_query());die;
		return $result;
	}
	
}
