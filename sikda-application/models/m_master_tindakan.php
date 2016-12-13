<?php
class M_master_tindakan extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }
  
  public function getMastertindakan($params)
  {

  		if($params['for_dialog']){
			$this->db->select("u.KD_PRODUK, u.KD_PRODUK as nid, k.GOL_PRODUK, u.PRODUK, u.HARGA_PRODUK, u.SINGKATAN", false );
			$this->db->where("IS_ODONTOGRAM", 1);
		}else{
			$this->db->select("u.KD_PRODUK, u.KD_PUSKESMAS, k.GOL_PRODUK, u.PRODUK, u.HARGA_PRODUK, u.SINGKATAN, u.IS_DEFAULT, u.KD_PRODUK as nid", false );
		}

		$this->db->from('mst_produk u');
		$this->db->join('mst_gol_produk k','u.KD_GOL_PRODUK=k.KD_GOL_PRODUK','left');
		
		if($params['keyword'] and $params['cari']){
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		//search pop up untuk gigi		
		if ($params['kd_produk']){
			$this->db->where('u.KD_PRODUK like', '%'.$params['kd_produk'].'%');	
		} 	

		if($params['gol_produk']){
			$this->db->where('k.GOL_PRODUK like','%'.$params['gol_produk'].'%');
		}
		if($params['produk']){
			$this->db->where('u.PRODUK like','%'.$params['produk'].'%');
		}

		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_PRODUK '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalMastertindakan($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_produk u');
		$this->db->join('mst_gol_produk k','u.KD_GOL_PRODUK=k.KD_GOL_PRODUK','left');
		if($params['for_dialog']){
			$this->db->where("IS_ODONTOGRAM", 1);
  		}
		if($params['keyword'] and $params['cari']){
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
	
		//search pop up untuk gigi		
		if ($params['kd_produk']){
			$this->db->where('u.KD_PRODUK like', '%'.$params['kd_produk'].'%');	
		} 	

		if($params['gol_produk']){
			$this->db->where('k.GOL_PRODUK like','%'.$params['gol_produk'].'%');
		}
		if($params['produk']){
			$this->db->where('u.PRODUK like','%'.$params['produk'].'%');
		}
		
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
  
  
}
