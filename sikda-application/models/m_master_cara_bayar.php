<?php
class M_master_cara_bayar extends CI_Model {

  private $db;
  public function __construct()
  {
	parent::__construct();
	$this->db = $this->load->database('sikda', TRUE);
  }	
 
	
  public function getdatacus()
  {
		$result = $this->db->get ("mst_kel_pasien");
		$option = array();
		foreach ($result->result_array() as $row) {
		$option[$row["KD_CUSTOMER"]]= $row["CUSTOMER"];
		}
		return $option;
  }
	
  public function getCarabayar($params)
  { 
		$this->db->select('u.KD_BAYAR, u.CARA_BAYAR, u.KD_CUSTOMER, t.CUSTOMER, u.KD_BAYAR as nid', false );
		$this->db->from('mst_cara_bayar u');
		$this->db->join('mst_kel_pasien t', 't.KD_CUSTOMER=u.KD_CUSTOMER','left');
		if($params['keyword'] and $params['cari'])
		{
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
        if($params['keyword'] and $params['cari'])
		{
			$this->db->where ('u.'.$params['keyword'].' like', '%'.$params['cari'].'%');
		}
		
		$this->db->limit($params['limit'],$params['start']);
		$this->db->order_by('KD_BAYAR '.$params['sort']);
		
		$result['data'] = $this->db->get()->result_array();
		
		return $result;
  }
    
  public function totalCarabayar($params)
  {
		$this->db->select("count(*) as total");
		$this->db->from('mst_cara_bayar u');
		if($params['cari'])
		{
			$this->db->where('KD_BAYAR LIKE "%'.$params['cari'].'%" ');
		}
		$total = $this->db->get()->row();
		return $total->total;
  } 
  
}
