<?php
class M_map_gigi_permukaan extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMaster($params)
  {
		// $this->db->from('map_gigi_permukaan mp');
		// if($params['for_dialog']){

		// 	$this->db->select("id as action, mp.id,  mp.gambar,  mgp.kode, mp.kd_status_gigi, mgs.status", false );
		// 	$this->db->join('mst_gigi_status mgs', 'mgs.kd_status_gigi = mp.kd_status_gigi', 'left');
		// 	$this->db->join('mst_gigi_permukaan mgp', 'mgp.kd_gigi_permukaan = mp.kd_gigi_permukaan', 'left');
  // 		}else{
		// 	$this->db->select("mp.id, mgp.kode, mp.kd_status_gigi, mgs.status, mp.gambar, mp.id as action", false );
		// 	$this->db->join('mst_gigi_status mgs', 'mgs.kd_status_gigi = mp.kd_status_gigi');
		// 	$this->db->join('mst_gigi_permukaan mgp', 'mgp.kd_gigi_permukaan = mp.kd_gigi_permukaan');
		// }


		// if($params['kd_status_gigi']){
		// 	$this->db->where('mp.kd_status_gigi like','%'.$params['kd_status_gigi'].'%');
		// }

		// if($params['status_gigi']){
		// 	$this->db->where('mgs.status like','%'.$params['status_gigi'].'%');
		// }
		// if($params['kode']){
		// 	$this->db->where('mgp.kode like','%'.$params['kode'].'%');
		// }

		// $this->db->limit($params['limit'],$params['start']);
		// $this->db->order_by('mp.kd_status_gigi asc');
		// $this->db->order_by('CHAR_LENGTH(kode) asc');
		// $this->db->order_by('mgp.kode asc');
		// $this->db->order_by('mp.kd_status_gigi '.$params['sort']);
		
		// $result['data'] = $this->db->get()->result_array();

		if($params['for_dialog']){

			$limit_start = $params['start'];
			$limit_count = $params['limit'];
			$kd_status_gigi = $params['kd_status_gigi'];
			$status_gigi = $params['status_gigi'];
			$kode = $params['kode'];
			$query_str = "
				SELECT id as action, mp.id, mp.gambar, mgp.kode, mgs.kd_status_gigi,mgs.jumlah_gigi, mgs.status
				FROM map_gigi_permukaan mp
				LEFT JOIN mst_gigi_status mgs ON mgs.id_status_gigi = mp.id_status_gigi
				LEFT JOIN mst_gigi_permukaan mgp ON mgp.kd_gigi_permukaan = mp.kd_gigi_permukaan
				WHERE 
					CASE WHEN (
							SELECT ID
							FROM map_gigi_permukaan tmp
							WHERE tmp.id_status_gigi = mp.id_status_gigi
							AND tmp.kd_gigi_permukaan IS NOT NULL
							GROUP BY id_status_gigi
						) IS NOT NULL
					THEN 
						mp.kd_gigi_permukaan IS NOT NULL
					ELSE
						mp.kd_gigi_permukaan IS NULL
					END
			";

			if($kd_status_gigi){
				$query_str.=" AND mgs.kd_status_gigi LIKE '%$kd_status_gigi%'";
			}
			if($status_gigi){
				$query_str.=" AND mgs.status LIKE '%$status_gigi%'";
			}
			if($kode){
				$query_str.=" AND mgp.kode LIKE '%$kode%'";
			}

			$query_str .= " ORDER BY mp.kd_gigi_permukaan IS NULL desc, mp.id_status_gigi asc, CHAR_LENGTH(kode) asc, mgp.kode asc
				LIMIT $limit_start, $limit_count
			";

			$result['data']=$this->db->query($query_str)->result_array();
  		}else{
  			$this->db->from('map_gigi_permukaan mp');
			$this->db->select("mp.id, mgp.kode, mgs.kd_status_gigi, mgs.status, mp.gambar, mp.id as action", false );
			$this->db->join('mst_gigi_status mgs', 'mgs.id_status_gigi = mp.id_status_gigi');
			$this->db->join('mst_gigi_permukaan mgp', 'mgp.kd_gigi_permukaan = mp.kd_gigi_permukaan');


			if($params['kd_status_gigi']){
				$this->db->where('mgs.kd_status_gigi like','%'.$params['kd_status_gigi'].'%');
			}

			if($params['status_gigi']){
				$this->db->where('mgs.status like','%'.$params['status_gigi'].'%');
			}
			if($params['kode']){
				$this->db->where('mgp.kode like','%'.$params['kode'].'%');
			}

			$this->db->limit($params['limit'],$params['start']);
			$this->db->order_by('mp.id_status_gigi asc');
			$this->db->order_by('CHAR_LENGTH(kode) asc');
			$this->db->order_by('mgp.kode asc');
			$this->db->order_by('mp.id_status_gigi '.$params['sort']);
			
			$result['data'] = $this->db->get()->result_array();

		}
		
		return $result;
  }
    
  public function totalMaster($params)
  {

		if($params['for_dialog']){
			// $this->db->join('mst_gigi_status mgs', 'mgs.id_status_gigi = mp.id_status_gigi');
			// $this->db->join('mst_gigi_permukaan mgp', 'mgp.kd_gigi_permukaan = mp.kd_gigi_permukaan', 'left');
			// $this->db->where("					CASE WHEN (
			// 				SELECT ID
			// 				FROM map_gigi_permukaan tmp
			// 				WHERE tmp.id_status_gigi = mp.id_status_gigi
			// 				AND tmp.kd_gigi_permukaan IS NOT NULL
			// 				GROUP BY id_status_gigi
			// 			) IS NOT NULL
			// 		THEN 
			// 			mp.kd_gigi_permukaan IS NOT NULL
			// 		ELSE
			// 			mp.kd_gigi_permukaan IS NULL
			// 		END");

			// $this->db->where('mp.kd_gigi_permukaan IS NOT NULL',NULL,false);


			$kd_status_gigi = $params['kd_status_gigi'];
			$status_gigi = $params['status_gigi'];
			$kode = $params['kode'];
			$query_str = "
				SELECT COUNT(id) AS TOTAL
				FROM map_gigi_permukaan mp
				LEFT JOIN mst_gigi_status mgs ON mgs.id_status_gigi = mp.id_status_gigi
				LEFT JOIN mst_gigi_permukaan mgp ON mgp.kd_gigi_permukaan = mp.kd_gigi_permukaan
				WHERE 
					CASE WHEN (
							SELECT ID
							FROM map_gigi_permukaan tmp
							WHERE tmp.id_status_gigi = mp.id_status_gigi
							AND tmp.kd_gigi_permukaan IS NOT NULL
							GROUP BY id_status_gigi
						) IS NOT NULL
					THEN 
						mp.kd_gigi_permukaan IS NOT NULL
					ELSE
						mp.kd_gigi_permukaan IS NULL
					END
			";

			if($kd_status_gigi){
				$query_str.=" AND mgs.kd_status_gigi LIKE '%$kd_status_gigi%'";
			}
			if($status_gigi){
				$query_str.=" AND mgs.status LIKE '%$status_gigi%'";
			}
			if($kode){
				$query_str.=" AND mgp.kode LIKE '%$kode%'";
			}

			$query_str .= " ORDER BY mp.kd_gigi_permukaan IS NULL desc, mp.id_status_gigi asc, CHAR_LENGTH(kode) asc, mgp.kode asc
			";

			return $this->db->query($query_str)->row()->TOTAL;
  		}else{
			$this->db->select("count(*) as total");
			$this->db->from('map_gigi_permukaan mp');

			$this->db->join('mst_gigi_status mgs', 'mgs.id_status_gigi = mp.id_status_gigi');
			$this->db->join('mst_gigi_permukaan mgp', 'mgp.kd_gigi_permukaan = mp.kd_gigi_permukaan');



			if($params['kd_status_gigi']){
				$this->db->where('mgs.kd_status_gigi like','%'.$params['kd_status_gigi'].'%');
			}

			if($params['status_gigi']){
				$this->db->where('mgs.status like','%'.$params['status_gigi'].'%');
			}
			if($params['kode']){
				$this->db->where('mgp.kode like','%'.$params['kode'].'%');
			}


			$total = $this->db->get()->row();
			return $total->total;
		}
  } 
  
}
