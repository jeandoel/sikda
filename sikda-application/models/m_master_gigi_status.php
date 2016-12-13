<?php
class M_master_gigi_status extends CI_Model {

    private $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('sikda', TRUE);
    }

    public function getMaster($params)
    {
        if($params['for_dialog']){
            $this->db->select("id_status_gigi, id_status_gigi as action, kd_status_gigi, gambar, status, jumlah_gigi, deskripsi", false );
        }else{
            $this->db->select("kd_status_gigi, gambar, status, deskripsi, DMF,  jumlah_gigi, id_status_gigi as action", false );
        }
        $this->db->from('mst_gigi_status');
        if($params['kd_status_gigi']){
            $this->db->where('kd_status_gigi like','%'.$params['kd_status_gigi'].'%');
        }
        if($params['status']){
            $this->db->where('status like','%'.$params['status'].'%');
        }
        $this->db->limit($params['limit'],$params['start']);
        $this->db->order_by('kd_status_gigi'.$params['sort']);

        $result['data'] = $this->db->get()->result_array();

        return $result;
    }

    public function totalMaster($params)
    {
        $this->db->select("count(*) as total");
        $this->db->from('mst_gigi_status');

        if($params['kd_status_gigi']){
            $this->db->where('kd_status_gigi like','%'.$params['kd_status_gigi'].'%');
        }
        if($params['status']){
            $this->db->where('status like','%'.$params['status'].'%');
        }

        $total = $this->db->get()->row();
        return $total->total;
    }

}
