<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_gigi_diagram_pasien extends CI_Controller {

    private $DIR_GIGI = './assets/images/gigi_pasien/';

    public function index(){
        $this->load->view('t_gigi_pasien/diagram/diagram_main.php');
    }
    public function foto(){
        $this->load->view('t_gigi_diagram_pasien/foto/foto_main.php');
    }
    public function foto_preview(){
        $this->load->view('t_gigi_diagram_pasien/foto/foto_preview.php');
    }
    public function views($urls){
        $kd_pasien =$this->input->post('kd_pasien')?$this->input->post('kd_pasien',TRUE):null;
        $kd_puskesmas =$this->input->post('kd_puskesmas')?$this->input->post('kd_puskesmas',TRUE):null;
        $sebelum_tanggal =$this->input->post('sebelum_tanggal')?$this->input->post('sebelum_tanggal',TRUE):null;

        $this->db = $this->load->database('sikda', TRUE);

        if($urls == "diagram_gigi"){
            if(!empty($sebelum_tanggal)){
                $sebelum_tanggal = date('Y-m-d 23:59:59',
                    strtotime(str_replace('/', '-',$sebelum_tanggal))
                );

            }
//		 echo ($sebelum_tanggal);
            $query_str = "SELECT *
						FROM (
							SELECT KD_GIGI, mgs.ID_STATUS_GIGI,mgs.KD_STATUS_GIGI, mgs.DMF, mgs.JUMLAH_GIGI,
							AKAR_GIGI, TANGGAL, `map_gigi_permukaan`.`GAMBAR` as GAMBAR_MAP
							FROM (`t_perawatan_gigi_pasien`)
							LEFT JOIN `map_gigi_permukaan` ON `map_gigi_permukaan`.`id` = `t_perawatan_gigi_pasien`.`kd_map_gigi`
							INNER JOIN mst_gigi_status mgs ON mgs.ID_STATUS_GIGI = map_gigi_permukaan.ID_STATUS_GIGI
							WHERE
								`kd_pasien` = '$kd_pasien' AND
								`kd_puskesmas` = '$kd_puskesmas'
					";

            if(!empty($sebelum_tanggal)){
                $query_str.=" AND tanggal <= '$sebelum_tanggal'";
            }
            $query_str.= "
					ORDER BY `t_perawatan_gigi_pasien`.`tanggal` desc
				)vt
				GROUP BY vt.`kd_gigi`
			";

            $query = $this->db->query($query_str);
            $result = $query->result();

            $str_query_dmf = "
				SELECT 
					va.DMF, SUM(va.JUMLAH) AS JUMLAH
					FROM
						(
							SELECT 
								CEILING(COUNT(mgs.KD_STATUS_GIGI)/mgs.JUMLAH_GIGI) AS JUMLAH,
								mgs.DMF
							FROM
							(
								$query_str
							)mgs
							GROUP BY mgs.DMF
						)va
					GROUP BY va.DMF";
            $query_dmf = $this->db->query($str_query_dmf);
            $result_dmf = $query_dmf->result();

            $DMF = array(
                'D'=>0,
                'M'=>0,
                'F'=>0
            );
            foreach($result_dmf as $tes){
                if($tes->DMF=="D") $DMF['D'] =$tes->JUMLAH;
                else if($tes->DMF=="M") $DMF['M'] = $tes->JUMLAH;
                else if($tes->DMF=="F") $DMF['F'] = $tes->JUMLAH;
            }

            $structured=array();
            foreach($result as $msg){
                $structured[$msg->KD_GIGI]['GAMBAR_MAP'] = $msg->GAMBAR_MAP;
                $structured[$msg->KD_GIGI]['AKAR_GIGI'] = $msg->AKAR_GIGI;
            }
            $this->db->select('*');
            $this->db->from('mst_gigi');
            $master_gigi = $this->db->get()->result();
            $m_data_gigi=array();
            foreach($master_gigi as $gigi){
                $m_data_gigi[$gigi->KD_GIGI]['GAMBAR'] = $gigi->GAMBAR;
            }

            $this->load->view('t_gigi_pasien/diagram/'.$urls, array('data_dmf'=>$DMF,'data_gigi'=>$structured, 'm_data_gigi'=>$m_data_gigi));
        }else{
            $this->load->view('t_gigi_pasien/diagram/'.$urls );
        }
    }
    public function data_gigi(){
        $id_transaksi_perawatan =$this->input->post('id_transaksi_perawatan')?$this->input->post('id_transaksi_perawatan',TRUE):null;
        $kd_pasien =$this->input->post('kd_pasien')?$this->input->post('kd_pasien',TRUE):null;
        $nomor = $this->input->post('nomor_gigi');
        $kd_puskesmas = $this->input->post('kd_puskesmas')?$this->input->post('kd_puskesmas',TRUE):null;

        $this->db = $this->load->database('sikda', TRUE);
        // $val = $db->query("select * from t_perawatan_gigi_pasien where kd_gigi = '".$nomor."' and kd_pasien = '".$kd_pasien."'")->row();

        $this->db->select('*, t_perawatan_gigi_pasien.id as ID, mst_gigi.nama as MST_GIGI_NAMA, map_gigi_permukaan.id as MGP_ID');
        $this->db->from('t_perawatan_gigi_pasien');
        //master gigi join ke t_perawatan_gigi
        $this->db->join('mst_gigi', 'mst_gigi.kd_gigi = t_perawatan_gigi_pasien.kd_gigi');
        //master icd join ke t_perawtan_gigi
        $this->db->join('mst_icd', 'mst_icd.kd_penyakit = t_perawatan_gigi_pasien.kd_penyakit');
        //master produk join ke t_perawatan_gigi
        $this->db->join('mst_produk', 'mst_produk.kd_produk = t_perawatan_gigi_pasien.kd_produk');
        //map gigi permukaan join ke t_perawatan_gigi
        $this->db->join('map_gigi_permukaan', 'map_gigi_permukaan.id = t_perawatan_gigi_pasien.kd_map_gigi');
        //mst gigi permukaan join ke map gigi permukaan
        $this->db->join('mst_gigi_permukaan', 'mst_gigi_permukaan.kd_gigi_permukaan = map_gigi_permukaan.kd_gigi_permukaan','left');
        $this->db->join('mst_gigi_status', 'mst_gigi_status.id_status_gigi = map_gigi_permukaan.id_status_gigi','left');
        if(empty($id_transaksi_perawatan)){
            $this->db->where('t_perawatan_gigi_pasien.kd_gigi', $nomor);
            $this->db->where('t_perawatan_gigi_pasien.kd_pasien', $kd_pasien);
            $this->db->where('t_perawatan_gigi_pasien.kd_puskesmas', $kd_puskesmas);
        }else{
            $this->db->where('t_perawatan_gigi_pasien.id', $id_transaksi_perawatan);
            $this->db->where('t_perawatan_gigi_pasien.kd_pasien', $kd_pasien);
            $this->db->where('t_perawatan_gigi_pasien.kd_puskesmas', $kd_puskesmas);
        }
        $this->db->order_by('t_perawatan_gigi_pasien.tanggal desc');
        $query = $this->db->get()->row();
        // die($this->db->last_query());
        // die($this->db->last_query());
        if(!empty($query)){
            $kode_output_status = $query->KODE.'-';
            if(empty($query->KODE)){
                $kode_output_status = $query->KD_STATUS_GIGI;
            }else{
                $kode_output_status .= $query->KD_STATUS_GIGI;
            }
            $arr = array(
                "tanggal"=>Date('d/m/Y', strtotime($query->TANGGAL)),
                "kd_pasien"=>$query->KD_PASIEN,
                "main_transaksi_id"=>$query->ID,
                "kode_gigi"=>$query->KD_GIGI,
                "kode_n_gigi"=>$query->MST_GIGI_NAMA,
                "kode_map_id"=>$query->MGP_ID,
                "kode_status"=>$query->KD_STATUS_GIGI,
                "kode_output_status"=>$kode_output_status,
                "kode_n_status"=>$query->STATUS,
                "kode_penyakit"=>$query->KD_PENYAKIT,
                "kode_icd_induk"=>$query->KD_ICD_INDUK,
                "kode_n_penyakit"=>$query->PENYAKIT,
                "kode_produk"=>$query->KD_PRODUK,
                "kode_n_produk"=>$query->PRODUK,
                "kode_dokter"=>$query->KD_DOKTER,
                "akar_gigi"=>$query->AKAR_GIGI,
                "note"=>$query->NOTE
                // "note"=>$object->note,
                // "nomor_gigi"=>$object->nomor_gigi
            );

            // echo json_encode($arr);
        }else{
            $arr=array();
        }
        echo json_encode($arr);

        // echo "{\"id\":\"$object->id\",\"note\":\"$object->note\",\"nomor_gigi\":\"$object->nomor_gigi\"}";
    }
    public function masterXml()
    {
        $this->load->model('t_gigi_diagram_model');

        $limit = $this->input->post('rows')?$this->input->post('rows'):10;

        $paramstotal=array(
            'dari'=>$this->input->post('dari'),
            'sampai'=>$this->input->post('sampai'),
            'tanggal'=>$this->input->post('tanggal'),
            'nomor'=>$this->input->post('nomor'),
            'pasien'=>$this->input->post('pasien'),
            'puskesmas'=>$this->input->post('puskesmas')
        );

        $total = $this->t_gigi_diagram_model->totalMaster($paramstotal);

        $total_pages = ($total >0)?ceil($total/$limit):1;
        $page = $this->input->post('page')?$this->input->post('page'):1;
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit;

        $params=array(
            'start'=>$start,
            'limit'=>$limit,
            'sort'=>$this->input->post('asc'),
            'tanggal'=>$this->input->post('tanggal'),
            'nomor'=>$this->input->post('nomor'),
            'pasien'=>$this->input->post('pasien'),
            'puskesmas'=>$this->input->post('puskesmas')
        );

        $result = $this->t_gigi_diagram_model->getMaster($params);

        header("Content-type: text/xml");
        echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
    }

    public function add($types, $tipe_foto)
    {
        $this->load->view('t_gigi_diagram_pasien/foto/foto_gigi_pasien_add', array('types'=>$types, 'tipe_foto'=>$tipe_foto));
    }

    public function addprocess(){

        $id_transaksi_perawatan = $this->input->post('main_transaksi_id', TRUE);

        $kd_gigi = $this->input->post('kd_gigi', TRUE);
        $kd_status_gigi = $this->input->post('kd_status_gigi', TRUE);

        $kd_map_gigi = $this->input->post('kd_map_id', TRUE);

        $kd_penyakit = $this->input->post('kd_penyakit', TRUE);
        $kd_icd_induk = $this->input->post('kd_icd_induk', TRUE);
        $kd_tindakan = $this->input->post('kd_tindakan', TRUE);

        $akar_gigi = $this->input->post('akar_gigi', TRUE);


        $note = $this->input->post('note',TRUE);
        $tanggal = $this->input->post('tanggal', TRUE);
        $kd_pasien = $this->input->post('kd_pasien',TRUE);
        $kd_puskesmas = $this->input->post('kd_puskesmas',TRUE);

        $dokter = $this->input->post('kd_dokter_gigi');
        $petugas = $this->input->post('kd_petugas_gigi');

        $tanggal_formated = Date('Y-m-d',strtotime(str_replace('/', '-',$tanggal))).Date(' H:i:s');

        if(empty($kd_gigi)){
            sendHeader("Nomor Gigi harus diisi");
            sendHeader("1","error_code");
            die();
        }else if(empty($tanggal)){
            sendHeader("Tanggal harus diisi");
            sendHeader("1","error_code");
            die();
        }else if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4}$/",$tanggal)){
            sendHeader("Tanggal harus sesuai format DD/MM/YYYY");
            sendHeader("1","error_code");
            die();
        }else if(empty($kd_map_gigi)){
            sendHeader("Status Gigi harus diisi");
            sendHeader("1","error_code");
            die();
        }else if(empty($kd_penyakit)){
            sendHeader("Penyakit Gigi harus diisi");
            sendHeader("1","error_code");
            die();
        }else if(empty($kd_tindakan)){
            sendHeader("Tindakan harus diisi");
            sendHeader("1","error_code");
            die();
        }else if(empty($dokter)){
            sendHeader("Petugas 2 harus dipilih");
            sendHeader("1","error_code");
            die();
        }else{
            //database insert & edit
            $db = $this->load->database('sikda', TRUE);
            $db->trans_begin();
            $dataexc = array(
                'kd_gigi'=>$kd_gigi,
                'kd_map_gigi'=>$kd_map_gigi,
                'kd_penyakit'=>$kd_penyakit,
                'kd_icd_induk'=>$kd_icd_induk,
                'kd_produk'=>$kd_tindakan,
                'kd_dokter'=>$dokter,
                'kd_petugas'=>$petugas,
                'tanggal'=>$tanggal_formated,
                'note'=>$note,
                'akar_gigi'=>$akar_gigi
            );
            if(empty($id_transaksi_perawatan)){
                $dataexc['kd_pasien'] = $kd_pasien;
                $dataexc['kd_puskesmas'] = $kd_puskesmas;
                $db->insert('t_perawatan_gigi_pasien', $dataexc);
            }else{
                $db->where('id', $id_transaksi_perawatan);
                $db->update('t_perawatan_gigi_pasien', $dataexc);
            }

            if ($db->trans_status() === FALSE)
            {
                $db->trans_rollback();
                sendHeader('Maaf Proses Insert Data Gagal');
                sendHeader("1","error_code");
                die('Maaf Proses Insert Data Gagal');
            }
            else
            {
                $db->trans_commit();
                if(empty($id_transaksi_perawatan)){
                    sendHeader('Data Berhasil Ditambah');
                }else{
                    sendHeader('Data Berhasil Diperbarui');
                }
                sendHeader("0","error_code");
                die();
            }
        }
    }
    public function editprocess()
    {
        $this->addprocess();
    }

    public function getEditData(){
        $kd_foto_gigi=$this->input->get('kd_foto_gigi')?$this->input->get('kd_foto_gigi',TRUE):null;
        $db = $this->load->database('sikda', TRUE);
        $val = $db->query("select * from t_foto_gigi_pasien where kd_foto_gigi = '".$kd_foto_gigi."'")->row();
        $data['data']=$val;
        return $data;
    }

    public function edit()
    {
        $data = $this->getEditData();
        $this->load->view('t_gigi_diagram_pasien/foto/foto_gigi_pasien_edit',$data);//print_r($data);die();
    }

    public function delete()
    {
        $id_transaksi_perawatan=$this->input->post('id_transaksi_perawatan')?$this->input->post('id_transaksi_perawatan',TRUE):null;
        $db = $this->load->database('sikda', TRUE);
        if($db->query("delete from t_perawatan_gigi_pasien where id = '".$id_transaksi_perawatan."'")){
            die(json_encode('OK'));
        }else{
            die(json_encode('FAIL'));
        }
    }


    public function diagram(){
        $this->load->view('t_gigi_diagram_pasien/diagram/diagram_main.php');
    }
}