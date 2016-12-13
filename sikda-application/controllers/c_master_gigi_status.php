<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_gigi_status extends CI_Controller {

    private $DIR_GIGI = './assets/images/map_gigi_permukaan/';

    public function index()
    {
        $this->load->view('masterGigistatus/v_master_gigi_status');
    }

    public function masterPopup()
    {
        $data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
        $data['idprov'] = $this->input->get('kd_prov')?$this->input->get('kd_prov',TRUE):null;
        $this->load->view('masterGigistatus/v_master_gigi_pop',$data);
    }

    public function masterXml($for_dialog=NULL)
    {
        $this->load->model('m_master_gigi_status');

        $limit = $this->input->post('rows')?$this->input->post('rows'):10;

        $paramstotal=array(
            'dari'=>$this->input->post('dari'),
            'sampai'=>$this->input->post('sampai'),
            'kd_status_gigi'=>$this->input->post('kd_status_gigi'),
            'status'=>$this->input->post('status')
        );

        $total = $this->m_master_gigi_status->totalMaster($paramstotal);

        $total_pages = ($total >0)?ceil($total/$limit):1;
        $page = $this->input->post('page')?$this->input->post('page'):1;
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit;

        $params=array(
            'start'=>$start,
            'limit'=>$limit,
            'sort'=>$this->input->post('asc'),
            'kd_status_gigi'=>$this->input->post('kd_status_gigi'),
            'status'=>$this->input->post('status'),
            'for_dialog'=>$for_dialog
        );

        $result = $this->m_master_gigi_status->getMaster($params);

        header("Content-type: text/xml");
        echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
    }

    public function add()
    {
        $this->load->view('masterGigistatus/v_master_gigi_status_add');
    }

    public function addprocess()
    {
        $id = $this->input->post('kd',TRUE);
        $check_kode = $this->input->post('kd_status_gigi');
        $this->load->library('form_validation');

        $val = $this->form_validation;
        $val->set_rules('kd_status_gigi', 'Kode');
        $val->set_rules('jml_gigi_status', 'Jumlah Gigi', 'trim|required|xss_clean|min_length[1]');
        $val->set_rules('gambar', 'Gambar Gigi');
        $val->set_rules('status', 'status Gigi', 'trim|required|xss_clean|min_length[1]');
        $val->set_rules('dmf', 'DMF Gigi');
        $val->set_rules('deskripsi', 'Deskripsi');
        $val->set_message('required', "Silahkan isi field \"%s\"");


        $config['upload_path'] = './assets/images/map_gigi_permukaan';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']	= '1024';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';
        $this->load->library('upload', $config);

        //check double kode gigi
        $db = $this->load->database('sikda', TRUE);
        // $checking_kode = $db->query("select * from mst_gigi_status where kd_status_gigi = '".$check_kode."'")->row();

        $isUpload = !empty($_FILES['gambar']['name']);

        if ($val->run() == FALSE)
        {
            $val->set_error_delimiters('<div style="color:white">', '</div>');
            die(validation_errors());
            // }else if(!empty($checking_kode) && empty($id)){
            // 	$val->set_error_delimiters('<div style="color:white">', '</div>');
            // 	die("kode sudah digunakan. Gunakan kode lain.");
            // }else if(!empty($checking_kode) && $check_kode != $id){
            // 	$val->set_error_delimiters('<div style="color:white">', '</div>');
            // 	die("kode sudah digunakan. Gunakan kode lain.");
        }else if(empty($id) && !$isUpload){
            $val->set_error_delimiters('<div style="color:white">', '</div>');
            die("Gambar harus diisi");
        }else if($isUpload && ! $this->upload->do_upload('gambar')){
            $val->set_error_delimiters('<div style="color:white">', '</div>');
            die($this->upload->display_errors());
        }
        else
        {
            $db->trans_begin();

            if(!empty($id) && $isUpload){
                $temp = $db->query("select * from mst_gigi_status where id_status_gigi = '".$id."'")->row();
                @$oldImage = $this->DIR_GIGI.$temp->GAMBAR;
                if(file_exists(@$oldImage)){
                    unlink($oldImage);
                }
            }

            if($isUpload){
                $image = $this->upload->data();
            }

            $data_exc = array(
                'kd_status_gigi' => $val->set_value('kd_status_gigi'),
                'jumlah_gigi' => $val->set_value('jml_gigi_status'),
                'status' => $val->set_value('status'),
                'dmf'=> $val->set_value('dmf'),
                'deskripsi' => $val->set_value('deskripsi')
            );
            //          $data_map = array(
            //          	'id_status_gigi' => $val->set_value('kd_status_gigi')
            // );

            if(empty($id)){
                $data_exc['gambar'] = $image['file_name'];
                $data_map['gambar'] = $image['file_name'];
                $db->insert('mst_gigi_status', $data_exc);

                $id_last = $db->insert_id();
                $data_map['id_status_gigi'] = $id_last;
                $db->insert('map_gigi_permukaan', $data_map);
            }else{
                if($isUpload){
                    $data_exc['gambar'] = $image['file_name'];
                    $data_map['gambar'] = $image['file_name'];
                }
                $db->where('id_status_gigi',$id);
                $db->update('mst_gigi_status', $data_exc);

                $data_map['id_status_gigi'] = $id;
                $db->where('id_status_gigi',$id);
                $db->where('kd_gigi_permukaan',NULL);
                $db->update('map_gigi_permukaan', $data_map);
            }

            if ($db->trans_status() === FALSE)
            {
                $db->trans_rollback();
                die('Maaf Proses Insert Data Gagal');
            }
            else
            {
                $db->trans_commit();
                die('OK');
            }
        }
    }

    public function editprocess()
    {
        $this->addprocess();
    }

    public function getEditData(){
        $kd_status_gigi=$this->input->get('kd_status_gigi')?$this->input->get('kd_status_gigi',TRUE):null;
        $db = $this->load->database('sikda', TRUE);
        $val = $db->query("select * from mst_gigi_status where id_status_gigi = '".$kd_status_gigi."'")->row();
        $data['data']=$val;
        return $data;
    }

    public function edit()
    {
        $data = $this->getEditData();
        $this->load->view('masterGigistatus/v_master_gigi_status_edit',$data);//print_r($data);die();
    }

    public function delete()
    {
        $kd_status_gigi=$this->input->post('kd_status_gigi')?$this->input->post('kd_status_gigi',TRUE):null;
        $db = $this->load->database('sikda', TRUE);
        $temp = $db->query("select * from mst_gigi_status where id_status_gigi = '".$kd_status_gigi."'")->row();
        @$oldImage = $this->DIR_GIGI.$temp->GAMBAR;
        if(file_exists(@$oldImage)){
            unlink($oldImage);
        }
        if($db->query("delete from mst_gigi_status where id_status_gigi = '".$kd_status_gigi."'")){
            die(json_encode('OK'));
        }else{
            die(json_encode('FAIL'));
        }
    }

    public function detail()
    {
        $data = $this->getEditData();
        $this->load->view('masterGigistatus/v_master_gigi_status_detail',$data);
    }

}

/* End of file c_master_asal_pasien.php */
/* Location: ./application/controllers/c_master_asal_pasien.php */