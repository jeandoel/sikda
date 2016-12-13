<?php
class T_gigi_diagram_model extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMaster($params)
  {
  	//tpgp.kd_map_gigi
  		$this->db->select("tpgp.id, tanggal, tpgp.kd_gigi, 
  			CASE 
  				WHEN map_gigi_permukaan.kd_gigi_permukaan IS NOT NULL
  				THEN 
  					CONCAT(mst_gigi_permukaan.kode,' - ', mst_gigi_status.kd_status_gigi) 
  				ELSE  mst_gigi_status.kd_status_gigi
  			END,
  			mst_gigi_status.status,
  			CONCAT(tpgp.kd_penyakit,' - ',mst_icd.penyakit) ,    
  			CONCAT(tpgp.kd_produk,' - ',mst_produk.produk),
  			note, 
  			mst_dokter.nama, 
  			kd_petugas, 
  			tpgp.id as action", 
			false );
		$this->db->from('t_perawatan_gigi_pasien tpgp');
		$this->db->where('tpgp.kd_pasien', $params['pasien']);
		$this->db->where('tpgp.kd_puskesmas', $params['puskesmas']);
		$this->db->join('mst_gigi', 'mst_gigi.kd_gigi = tpgp.kd_gigi');
		$this->db->join('map_gigi_permukaan', 'map_gigi_permukaan.id = tpgp.kd_map_gigi');
		$this->db->join('mst_gigi_permukaan','mst_gigi_permukaan.kd_gigi_permukaan=map_gigi_permukaan.kd_gigi_permukaan','left');
		$this->db->join('mst_gigi_status', 'map_gigi_permukaan.id_status_gigi = mst_gigi_status.id_status_gigi');
		$this->db->join('mst_icd', 'mst_icd.kd_penyakit = tpgp.kd_penyakit');
		$this->db->join('mst_produk', 'mst_produk.kd_produk = tpgp.kd_produk');
		$this->db->join('mst_dokter', 'mst_dokter.kd_dokter = tpgp.kd_dokter');
		
		if($params['tanggal']){
			$this->db->where('tanggal <=',
					date('Y-m-d 23:59:59',
						strtotime(str_replace('/', '-',$params['tanggal']))
						)
				);
		}
		if($params['nomor']){
			$this->db->where('tpgp.kd_gigi',$params['nomor']);
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('tanggal '.$params['sort'], "desc");
		$this->db->order_by('tpgp.kd_gigi asc');
		
		$result['data'] = $this->db->get()->result_array();

		// $result['data'][0]['status'] = $this->db->last_query();
		
		return $result;
  }
    
  public function totalMaster($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('t_perawatan_gigi_pasien');
		$this->db->where('kd_pasien', $params['pasien']);
		$this->db->where('kd_puskesmas', $params['puskesmas']);
		if($params['tanggal']){
			$this->db->where('tanggal like','%'.$params['tanggal'].'%');
		}
		if($params['nomor']){
			$this->db->where('kd_gigi',$params['nomor']);
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
