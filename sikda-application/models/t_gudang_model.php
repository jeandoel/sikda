<?php
class T_gudang_model extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getT_gudang($params)
  {
		$kdpmobat = $this->session->userdata('level_aplikasi')=='KABUPATEN'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas');
		$this->db->select("KD_PKM,KD_OBAT,NAMA_OBAT, KD_GOL_OBAT, KD_SAT_KECIL, KD_SAT_BESAR,FRACTION,NAMA_UNIT, JUMLAH_STOK_OBAT,concat(KD_PKM,'-',KD_OBAT) as nid2", false );
		$this->db->from('vw_lst_obat u');
		
		if($params['keyword'] and $params['cari']){
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}		
		if($this->session->userdata('level_aplikasi')=='PUSKESMAS'){
			$this->db->where ('u.KD_PKM =', $this->session->userdata('kd_puskesmas'));
			$this->db->where ('u.KD_MILIK_OBAT =', 'PKM');
			$this->db->where ('u.KD_UNIT_APT =', 'PUSKESMAS');
			//$this->db->where ('u.KD_UNIT_APT =', 'APT');
		}else{
			$this->db->where ('u.KD_MILIK_OBAT =', $this->session->userdata('level_aplikasi'));
			$this->db->where ('u.KD_PKM =', $kdpmobat);
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('NAMA_OBAT '.$params['sort']);
		//$this->db->group_by('KD_OBAT');
		$result['data'] = $this->db->get()->result_array();
		//print_r($this->db->last_query());die;
		
		
		return $result;
  }
    
  public function totalT_gudang($params)
  {
		$kdpmobat = $this->session->userdata('level_aplikasi')=='KABUPATEN'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas');
		$this->db->select("count(*) as total");
		
		if($params['keyword'] and $params['cari']){
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}		
		if($this->session->userdata('level_aplikasi')=='PUSKESMAS'){
			$this->db->where ('u.KD_PKM =', $this->session->userdata('kd_puskesmas'));
			$this->db->where ('u.KD_MILIK_OBAT =', 'PKM');
			$this->db->where ('u.KD_UNIT_APT =', 'PUSKESMAS');
			//$this->db->where ('u.KD_UNIT_APT =', 'APT');
		}else{
			$this->db->where ('u.KD_MILIK_OBAT =', $this->session->userdata('level_aplikasi'));
			$this->db->where ('u.KD_PKM =', $kdpmobat);
		}
		
		$this->db->from('vw_lst_obat u');
		$total = $this->db->get()->row();
		return $total->total;
  }

public function getT_gudangapt($params)
  {
		$kdpmobat = $this->session->userdata('level_aplikasi')=='KABUPATEN'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas');
		$this->db->select("KD_PKM,KD_OBAT,NAMA_OBAT, KD_GOL_OBAT, KD_SAT_KECIL, KD_SAT_BESAR,FRACTION,NAMA_UNIT, JUMLAH_STOK_OBAT,concat(KD_PKM,'-',KD_OBAT) as nid2", false );
		$this->db->from('vw_lst_obat u');
		
		if($params['keyword'] and $params['cari']){
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}		
		if($this->session->userdata('level_aplikasi')=='PUSKESMAS'){
			$this->db->where ('u.KD_PKM =', $this->session->userdata('kd_puskesmas'));
			$this->db->where ('u.KD_MILIK_OBAT =', 'PKM');
			//$this->db->where ('u.KD_UNIT_APT =', 'PUSKESMAS');
			$this->db->where ('u.KD_UNIT_APT =', 'APT');
		}else{
			$this->db->where ('u.KD_MILIK_OBAT =', $this->session->userdata('level_aplikasi'));
			$this->db->where ('u.KD_PKM =', $kdpmobat);
		}
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('NAMA_OBAT '.$params['sort']);
		//$this->db->group_by('KD_OBAT');
		$result['data'] = $this->db->get()->result_array();
		//print_r($this->db->last_query());die;
		
		
		return $result;
  }
    
  public function totalT_gudangapt($params)
  {
		$kdpmobat = $this->session->userdata('level_aplikasi')=='KABUPATEN'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas');
		$this->db->select("count(*) as total");
		
		if($params['keyword'] and $params['cari']){
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}		
		if($this->session->userdata('level_aplikasi')=='PUSKESMAS'){
			$this->db->where ('u.KD_PKM =', $this->session->userdata('kd_puskesmas'));
			$this->db->where ('u.KD_MILIK_OBAT =', 'PKM');
			//$this->db->where ('u.KD_UNIT_APT =', 'PUSKESMAS');
			$this->db->where ('u.KD_UNIT_APT =', 'APT');
		}else{
			$this->db->where ('u.KD_MILIK_OBAT =', $this->session->userdata('level_aplikasi'));
			$this->db->where ('u.KD_PKM =', $kdpmobat);
		}
		
		$this->db->from('vw_lst_obat u');
		$total = $this->db->get()->row();
		return $total->total;
  }  

   public function totalsubgridGudang($params,$apt=null)
	{

		// $kdpmobat = $this->session->userdata('level_aplikasi')=='KABUPATEN'?$this->session->userdata('kd_kabupaten'):$params['kd_pkm'];
		// $kdmilik = $this->session->userdata('level_aplikasi')=='PUSKESMAS'?'PKM':$this->session->userdata('level_aplikasi');

		// $query = "SELECT count(*) as total FROM
		// 	(
		// 		SELECT a.KD_TRANSAKSI, a.TGL_TRANSAKSI, a.NO_FAKTUR, ".
		// 		(($apt)? 
		// 			"CASE WHEN a.FLAG=0 THEN 'KELUAR' ELSE 'MASUK' END FLAG":
		// 			"CASE WHEN a.FLAG=0 THEN 'MASUK' ELSE 'KELUAR' END FLAG")
		// 		.", a.UNIT_APT_FROM, a.UNIT_APT_TO, a.JUMLAH_TOTAL
		// 		FROM apt_trans_obat a
		// 		LEFT JOIN apt_obat_terima_detail b ON a.KD_TRANSAKSI=b.KD_TERIMA
		// 		LEFT JOIN apt_obat_terima e ON e.KD_TERIMA=b.KD_TERIMA
		// 		LEFT JOIN apt_obat_keluar_detail d ON a.KD_TRANSAKSI=d.KD_KELUAR_OBAT
		// 		LEFT JOIN apt_obat_keluar f ON f.KD_KELUAR_OBAT = d.KD_KELUAR_OBAT
		// 		INNER JOIN apt_stok_obat c ON c.KD_OBAT=d.KD_OBAT OR c.KD_OBAT=b.KD_OBAT AND c.KD_UNIT_APT='".$this->session->userdata('level_aplikasi')."'
		// 		WHERE IFNULL(e.KD_PKM,f.KD_PKM) = '$kdpmobat' AND
		// 			  c.KD_OBAT = '".$params['kd_obat']."'  AND
		// 			  a.KD_MILIK_OBAT = '$kdmilik'
		// 		GROUP BY a.NO_FAKTUR
		// 		ORDER BY a.TGL_TRANSAKSI DESC
		// 	)vt
		// ";
		// if($apt){
		// 	$query.=" WHERE FLAG='MASUK' AND UNIT_APT_TO='APT'";
		// }

		// $result= $this->db->query($query)->row();
		
		$subgridquery = $this->getSubgridGudangaptQuery($params, $apt);
		$query = "SELECT count(*) as total FROM ($subgridquery)vt";
		$result = $this->db->query($query)->row();

		return $result->total;
	}
 
  public function getsubgridGudang($params,$apt=null)
	{

		// $kdpmobat = $this->session->userdata('level_aplikasi')=='KABUPATEN'?$this->session->userdata('kd_kabupaten'):$params['kd_pkm'];
		// $kdmilik = $this->session->userdata('level_aplikasi')=='PUSKESMAS'?'PKM':$this->session->userdata('level_aplikasi');

		//kode original sebelum revisi
		// $query = "SELECT * FROM
		// 	(
		// 		SELECT a.KD_TRANSAKSI, a.TGL_TRANSAKSI, a.NO_FAKTUR, ".
		// 		(($apt)? 
		// 			"CASE WHEN a.FLAG=0 THEN 'KELUAR' ELSE 'MASUK' END FLAG":
		// 			"CASE WHEN a.FLAG=0 THEN 'MASUK' ELSE 'KELUAR' END FLAG")
		// 		.", a.UNIT_APT_FROM, a.UNIT_APT_TO, a.JUMLAH_TOTAL
		// 		FROM apt_trans_obat a
		// 		LEFT JOIN apt_obat_terima_detail b ON a.KD_TRANSAKSI=b.KD_TERIMA
		// 		LEFT JOIN apt_obat_terima e ON e.KD_TERIMA=b.KD_TERIMA
		// 		LEFT JOIN apt_obat_keluar_detail d ON a.KD_TRANSAKSI=d.KD_KELUAR_OBAT
		// 		LEFT JOIN apt_obat_keluar f ON f.KD_KELUAR_OBAT = d.KD_KELUAR_OBAT
		// 		INNER JOIN apt_stok_obat c ON c.KD_OBAT=d.KD_OBAT OR c.KD_OBAT=b.KD_OBAT AND c.KD_UNIT_APT='".$this->session->userdata('level_aplikasi')."'
		// 		WHERE IFNULL(e.KD_PKM,f.KD_PKM) = '$kdpmobat' AND
		// 			  c.KD_OBAT = '".$params['kd_obat']."'  AND
		// 			  a.KD_MILIK_OBAT = '$kdmilik'
		// 		GROUP BY a.NO_FAKTUR
		// 		ORDER BY a.TGL_TRANSAKSI DESC
		// 		LIMIT ".$params['start'].", ".$params['limit']."
		// 	)vt
		// ";
		// if($apt){
		// 	$query.=" WHERE FLAG='MASUK' AND UNIT_APT_TO='APT'";
		// }

		/**
		 * Added New Rev01: 26-10-2014
		 */
		$start = $params['start'];
		$limit = $params['limit'];
		$query = $this->getSubgridGudangaptQuery($params, $apt);
		$query .= " 
				ORDER BY TGL_TRANSAKSI DESC
				LIMIT $start, $limit";
		/**
		 * End of Added New
		 * Rev01 : 26-10-2014
		 */

		//$result['data'][0]['TGL_TRANSAKSI'] = $this->db->last_query();


		$result['data']= $this->db->query($query)->result_array();

		return $result;
	}


	/**
	 * Added New Rev01: 26-10-2014
	 */
	private function getSubgridGudangaptQuery($params, $apt=null){
		$kd_puskesmas = $this->session->userdata('level_aplikasi')=='KABUPATEN'?$this->session->userdata('kd_kabupaten'):$params['kd_pkm'];
		$kdmilik = $this->session->userdata('level_aplikasi')=='PUSKESMAS'?'PKM':$this->session->userdata('level_aplikasi');
		$kd_obat = $params['kd_obat'];
		$masuk_str = 'MASUK';
		$keluar_str = 'KELUAR';
		if($apt) $keluar_str='MASUK';
		$query = "";

		//FLAG 0 = MASUK, FLAG 1 = KELUAR
		//terima detail
		if(!$apt){
			$query .= "SELECT trans.KD_TRANSAKSI, trans.TGL_TRANSAKSI, trans.NO_FAKTUR, '$masuk_str' AS FLAG,
							trans.UNIT_APT_FROM, trans.UNIT_APT_TO, tdetail.JUMLAH_TERIMA
						FROM apt_trans_obat trans
						LEFT JOIN apt_obat_terima trima ON trima.KD_TERIMA=trans.KD_TRANSAKSI #to get kode puskesmas
			 			LEFT JOIN apt_obat_terima_detail tdetail ON tdetail.KD_TERIMA=trans.KD_TRANSAKSI
			 			WHERE trans.FLAG=0
			 				AND trima.KD_PKM = '$kd_puskesmas'
			 				AND tdetail.KD_OBAT = '$kd_obat'
			 				AND trans.KD_MILIK_OBAT = '$kdmilik'
					";
			$query .= " UNION ";
		}
		//keluar detail
		$query .= "SELECT trans.KD_TRANSAKSI, trans.TGL_TRANSAKSI, trans.NO_FAKTUR, '$keluar_str' AS FLAG,
		 				trans.UNIT_APT_FROM, trans.UNIT_APT_TO, kdetail.JUMLAH_KELUAR
		 				FROM apt_trans_obat trans
		 				LEFT JOIN apt_obat_keluar kluar ON kluar.KD_KELUAR_OBAT=trans.KD_TRANSAKSI
		 				LEFT JOIN apt_obat_keluar_detail kdetail ON kdetail.KD_KELUAR_OBAT=trans.KD_TRANSAKSI
		 				WHERE trans.FLAG=1
		 					AND kluar.KD_PKM = '$kd_puskesmas'
		 					AND kdetail.KD_OBAT ='$kd_obat'
		 					AND trans.KD_MILIK_OBAT = '$kdmilik'
					";
		if($apt){
			$query.= " AND trans.UNIT_APT_TO = 'APT' and trans.UNIT_APT_FROM = 'PUSKESMAS'";
		}
		return $query;
	}
	/**
	 * End of Added New
	 * Rev01 : 26-10-2014
	 */
	
	public function totalsubgridGudangapt($params, $apt)
	{
		$this->db->select("count(*) as total");
		
		//$this->db->where('KD_KELURAHAN =', $params['namadesa']);
		
		//$this->db->from('apt_stok_obat');
		/*$this->db->from('apt_obat_terima a');	
		$this->db->join('apt_obat_terima_detail b','a.KD_TERIMA=b.KD_TERIMA');	
		$this->db->join('apt_stok_obat c','c.KD_OBAT=b.KD_OBAT');	
		$this->db->where('c.KD_UNIT_APT =', 'APT');
		$this->db->where('c.KD_PKM =', $params['kd_pkm']);
		$this->db->where('a.KD_MILIK_OBAT =', 'PKM');
		$this->db->where('c.KD_OBAT =', $params['kd_obat']);
		$this->db->where('a.UNIT_APT_FROM =', 'PUSKESMAS');*/
		$this->db->from('apt_obat_terima a');	
		$this->db->join('apt_obat_terima_detail b','a.KD_TERIMA=b.KD_TERIMA');	
		$this->db->join('apt_stok_obat c','c.KD_OBAT=b.KD_OBAT');	
		//$this->db->group_by('TGL_TERIMA');
		
		$this->db->where('c.KD_UNIT_APT =', 'APT');
		$this->db->where('a.KD_MILIK_OBAT =', 'PKM');
		$this->db->where('a.KD_PKM =', $params['kd_pkm']);
		$this->db->where('c.KD_OBAT =', $params['kd_obat']);
		$this->db->where('a.UNIT_APT_FROM =', 'PUSKESMAS');
		$this->db->group_by('b.KD_TERIMA');

		$total = $this->db->get()->row();
		return $total->total;
	}
 
  public function getsubgridGudangapt($params)
	{
		$this->db->select("a.KD_TERIMA,a.TGL_TERIMA,a.NO_FAKTUR_TERIMA,a.UNIT_APT_FROM,a.UNIT_APT_TO,b.JUMLAH_TERIMA",false);
		$this->db->from('apt_obat_terima a');	
		$this->db->join('apt_obat_terima_detail b','a.KD_TERIMA=b.KD_TERIMA');	
		$this->db->join('apt_stok_obat c','c.KD_OBAT=b.KD_OBAT');	
		//$this->db->group_by('TGL_TERIMA');
		
		$this->db->where('c.KD_UNIT_APT =', 'APT');
		$this->db->where('a.KD_MILIK_OBAT =', 'PKM');
		$this->db->where('a.KD_PKM =', $params['kd_pkm']);
		$this->db->where('c.KD_OBAT =', $params['kd_obat']);
		$this->db->where('a.UNIT_APT_FROM =', 'PUSKESMAS');
		$this->db->group_by('b.KD_TERIMA');
		$this->db->limit($params['limit'],$params['start']);
		
		$result['data'] = $this->db->get()->result_array();//print_r($result);die;
		
		// print_r($this->db->last_query());die;
		return $result;
	}
}
