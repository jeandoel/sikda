<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_pelayanan extends CI_Controller {
    public function index()
    {
        $this->load->helper('beries_helper');
        $this->load->view('t_pelayanan/v_pelayanan');
    }
    public function getRawatJalanContent(){
        $data = $this->layanan(true);
        $this->load->view('t_pelayanan/v_t_pelayanan_rawatjalan_content',$data);
    }

    public function t_pelayananxml()
    {
        $this->load->model('t_pelayanan_model');

        $limit = $this->input->post('rows')?$this->input->post('rows'):10;

        $paramstotal=array(
            'dari'=>$this->input->post('dari'),
            'sampai'=>$this->input->post('sampai'),
            'get_key'=>$this->input->post('get_key'),
            'get_cari'=>$this->input->post('get_cari')
        );

        $total = $this->t_pelayanan_model->totalT_pelayanan($paramstotal);

        $total_pages = ($total >0)?ceil($total/$limit):1;
        $page = $this->input->post('page')?$this->input->post('page'):1;
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit;

        $params=array(
            'start'=>$start,
            'limit'=>$limit,
            'sort'=>$this->input->post('asc'),
            'dari'=>$this->input->post('dari'),
            'sampai'=>$this->input->post('sampai'),
            'get_key'=>$this->input->post('get_key'),
            'get_cari'=>$this->input->post('get_cari')
        );

        $result = $this->t_pelayanan_model->getT_pelayanan($params);

        header("Content-type: text/xml");
        echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
    }

    public function t_pelayananantrianxml()
    {
        $this->load->model('t_pelayanan_model');

        $limit = $this->input->post('rows')?$this->input->post('rows'):10;

        $paramstotal=array(
            'dari'=>$this->input->post('dari'),
            'unit'=>$this->input->post('unit'),
            'status'=>$this->input->post('status'),
            'jenis'=>$this->input->post('jenis'),
            'get_key'=>$this->input->post('get_key'),
            'get_cari'=>$this->input->post('get_cari')
        );

        $total = $this->t_pelayanan_model->totalT_pelayanan($paramstotal);

        $total_pages = ($total >0)?ceil($total/$limit):1;
        $page = $this->input->post('page')?$this->input->post('page'):1;
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit;

        $params=array(
            'start'=>$start,
            'limit'=>$limit,
            'sort'=>$this->input->post('asc'),
            'dari'=>$this->input->post('dari'),
            'unit'=>$this->input->post('unit'),
            'status'=>$this->input->post('status'),
            'jenis'=>$this->input->post('jenis'),
            'get_key'=>$this->input->post('get_key'),
            'get_cari'=>$this->input->post('get_cari')
        );

        $result = $this->t_pelayanan_model->getT_pelayanan($params);

        header("Content-type: text/xml");
        echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
    }

    public function add()
    {
        $this->load->helper('beries_helper');
        $this->load->view('t_pelayanan/v_t_pelayanan_add');
    }

    public function addprocess()
    {
        $this->load->library('form_validation');

        $val = $this->form_validation;
        $val->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required|myvalid_date');
        $val->set_rules('column1', 'Column Satu', 'trim|required|xss_clean');
        $val->set_rules('column2', 'Column Dua', 'trim|required|xss_clean');
        $val->set_rules('column3', 'Column Tiga', 'trim|required|xss_clean');
        $val->set_rules('column_master_1_id', 'Column Master 1', 'trim|required|xss_clean');

        $val->set_message('required', "Silahkan isi field \"%s\"");

        if ($val->run() == FALSE)
        {
            $val->set_error_delimiters('<div style="color:white">', '</div>');
            die(validation_errors());
        }
        else
        {
            $db = $this->load->database('sikda', TRUE);
            $db->trans_begin();
            $dataexc = array(
                'ncolumn1' => $val->set_value('column1'),
                'ncolumn2' => $val->set_value('column2'),
                'ncolumn3' => $val->set_value('column3'),
                'nmaster_1_id' => $val->set_value('column_master_1_id'),
                'ntgl_t_pelayanan' => date("Y-m-d", strtotime($this->input->post('tglt_pelayanan',TRUE))),
                'ninput_oleh' => $this->session->userdata('nusername'),
                'ninput_tgl' => date('Y-m-d H:i:s')
            );

            $db->insert('tbl_t_pelayanan', $dataexc);

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

        $pasien=$this->input->post('kd_pasien')?$this->input->post('kd_pasien'):null;
        $puskesmas=$this->session->userdata('kd_puskesmas');
        $kunjungan=$this->input->post('kd_kunjungan')?$this->input->post('kd_kunjungan',true):null;//print_r($kunjungan);die;
        $pelayanan=$this->input->post('kd_pelayanan')?$this->input->post('kd_pelayanan'):null;

        $arrayobat = $this->input->post('obat_final')?json_decode($this->input->post('obat_final',TRUE)):NULL;
        $arrayalergi = $this->input->post('alergi_final')?json_decode($this->input->post('alergi_final',TRUE)):NULL;
        $arraytindakan = $this->input->post('tindakan_final')?json_decode($this->input->post('tindakan_final',TRUE)):NULL;
        $arraydiagnosa = $this->input->post('diagnosa_final')?json_decode($this->input->post('diagnosa_final',TRUE)):NULL;

        $db = $this->load->database('sikda', TRUE);
        $db->trans_begin();

        //update table kunjungan
        $db->set('STATUS','1');
        $db->where('KD_PUSKESMAS',$puskesmas);
        $db->where('KD_PELAYANAN',$pelayanan);
        $db->where('KD_PASIEN',$pasien);
        $db->update('kunjungan');

        $datainsert = array(
            'STATUS_LAYANAN' => 6,
            'CATATAN_FISIK' => $this->input->post('catatan_fisik',TRUE),
            'ANAMNESA' => $this->input->post('anamnesa',TRUE),
            'CATATAN_DOKTER' => $this->input->post('catatan_dokter',TRUE),
            'Modified_Date' => date('Y-m-d'),
            'Modified_By' => $this->session->userdata('kd_petugas')
        );
        $db->where('KD_PELAYANAN',$pelayanan);
        $db->update('pelayanan',$datainsert);

        $cat = $this->input->post('catatan_dokter_c');
        $check = array(
            'CATATAN_DOKTER' => !empty($cat)?$cat:''
        );
        $db->where('KD_PELAYANAN',$pelayanan);
        $db->update('check_coment',$check);

        $kodepelkasir = $db->query("select KD_KASIR from pelayanan where KD_PELAYANAN='".$pelayanan."'")->row();

        $db->where('KD_PELAYANAN',$pelayanan);
        $db->delete('pel_tindakan');
        $db->where('REFF',$pelayanan);
        $db->delete('pel_kasir_detail');

        if($arraytindakan){
            $irow2=1;
            foreach($arraytindakan as $rowtindakanloop){
                $datatindakantmp = json_decode($rowtindakanloop);
                $datatindakanloop[] = array(
                    'KD_PELAYANAN' => $pelayanan,
                    'KD_PASIEN' => $pasien,
                    'KD_PUSKESMAS' => $puskesmas,
                    'KD_TINDAKAN' => $datatindakantmp->kd_tindakan,
                    'QTY' => $datatindakantmp->jumlah?$datatindakantmp->jumlah:0,
                    'HRG_TINDAKAN' => $datatindakantmp->harga?$datatindakantmp->harga:0,
                    'KETERANGAN' => $datatindakantmp->keterangan,
                    'KD_PETUGAS' => $this->session->userdata('user_name'),
                    'iROW' => $irow2,
                    'TANGGAL' => date('Y-m-d'),
                    'Created_By' => $this->session->userdata('user_name'),
                    'Created_Date' => date('Y-m-d H:i:s')
                );

                $datainsertkasirdetailloop[]=array(
                    'KD_PEL_KASIR'=> $kodepelkasir->KD_KASIR,
                    'KD_PASIEN' => $pasien,
                    'KD_PUSKESMAS' => $puskesmas,
                    'KD_PRODUK' => $datatindakantmp->kd_tindakan,
                    'REFF' => $pelayanan,
                    'KD_UNIT' => '6',
                    'KD_TARIF' => 'AM',
                    'HARGA_PRODUK' => $datatindakantmp->harga?$datatindakantmp->harga:0,
                    'QTY' => $datatindakantmp->jumlah?$datatindakantmp->jumlah:0,
                    'TOTAL_HARGA' => $datatindakantmp->harga?($datatindakantmp->harga*$datatindakantmp->jumlah):0,
                    'TGL_BERLAKU' => date('Y-m-d')
                );

                $datatindakaninsert = $datatindakanloop;
                $datainsertkasirdetail = $datainsertkasirdetailloop;
                $irow2++;
            }
            $asd = $this->input->post('kd_pasien_hidden',TRUE);
            echo $asd;
            $db->insert_batch('pel_tindakan',$datatindakaninsert);
            $db->insert_batch('pel_kasir_detail',$datainsertkasirdetail);
        }

        $db->where('KD_PASIEN',$pasien);
        $db->delete('pasien_alergi_obt');
        if($arrayalergi){

            foreach($arrayalergi as $rowalergiloop){
                $dataalergitmp = json_decode($rowalergiloop);
                $dataalergiloop[] = array(
                    'KD_PASIEN' => $pasien,
                    'KD_PUSKESMAS' => $puskesmas,
                    'KD_OBAT' => $dataalergitmp->kd_obat,
                    'Created_By' => $this->session->userdata('user_name'),
                    'Created_Date' => date('Y-m-d H:i:s')
                );
                $dataalergiinsert = $dataalergiloop;
            }
            $db->insert_batch('pasien_alergi_obt',$dataalergiinsert);
        }

        $kodepelayananobat = $db->query("select NO_RESEP,KD_PELAYANAN_OBAT from pel_ord_obat where KD_PELAYANAN='".$pelayanan."'")->row();
        $db->where('KD_PELAYANAN',$pelayanan);
        $db->delete('pel_ord_obat');
        $db->where('REFF',$pelayanan);
        $db->delete('pel_kasir_detail');

        if($arrayobat){
            $maxpelayananobat1 = 0;
            $maxpelayananobat1 = $db->query("SELECT MAX(SUBSTR(KD_PELAYANAN,-7)) AS total FROM pelayanan where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
            $maxpelayananobat1 = $maxpelayananobat1->total + 1;
            $kodepelayananobat1 = '6'.sprintf("%07d", $maxpelayananobat1);
            $kodepelayananresep1 = 'R'.sprintf("%07d", $maxpelayananobat1);

            $qtyobattotal=0;
            $hargaobattotal=0;
            $irow=1;
            foreach($arrayobat as $rowobatloop){
                $dataobattmp = json_decode($rowobatloop);
                $dataobatloop[] = array(
                    'KD_PELAYANAN_OBAT' => $kodepelayananobat?$kodepelayananobat->KD_PELAYANAN_OBAT:$kodepelayananobat1,
                    'KD_PELAYANAN' => $pelayanan,
                    'KD_PASIEN' => $pasien,
                    'KD_KABUPATEN' => $this->session->userdata('kd_kabupaten'),
                    'KD_PUSKESMAS' => $puskesmas,
                    'NO_RESEP' => $kodepelayananobat?$kodepelayananobat->NO_RESEP:$kodepelayananresep1,
                    'KD_OBAT' => $dataobattmp->kd_obat,
                    'SAT_BESAR' => '',
                    'SAT_KECIL' => '',
                    'HRG_JUAL' => $dataobattmp->harga,
                    'QTY' => $dataobattmp->jumlah,
                    'DOSIS' => $dataobattmp->dosis,
                    'JUMLAH' => $dataobattmp->jumlah,
                    'KD_PETUGAS' => $this->session->userdata('user_name'),
                    'STATUS' => 0,
                    'iROW' => $irow,
                    'TANGGAL' => date('Y-m-d'),
                    'Modified_By' => $this->session->userdata('user_name'),
                    'Modified_Date' => date('Y-m-d H:i:s')
                );

                $qtyobattotal = $qtyobattotal+$dataobattmp->jumlah;
                $hargaobattotal = $hargaobattotal+($dataobattmp->harga*$dataobattmp->jumlah);


            }

            $datainsertkasirdetailloop[] = array(
                'KD_PEL_KASIR'=> $kodepelkasir->KD_KASIR,
                'KD_TARIF' =>  'AM',
                'KD_PASIEN' => $pasien,
                'KD_PUSKESMAS' => $puskesmas,
                'REFF' => $pelayanan,
                'KD_PRODUK' => "TRA",
                'KD_UNIT' => '6',
                'HARGA_PRODUK' => 0,
                'TGL_BERLAKU' => date('Y-m-d'),
                'QTY' => $qtyobattotal,
                'TOTAL_HARGA' => $hargaobattotal
            );

            $dataobatinsert = $dataobatloop;
            $datainsertkasirdetail1 = $datainsertkasirdetailloop;
            $irow++;

            $db->insert_batch('pel_ord_obat',$dataobatinsert);
            $db->insert_batch("pel_kasir_detail", $datainsertkasirdetail1);
        }

        $db->where('KD_PELAYANAN',$pelayanan);
        $db->delete('pel_diagnosa');
        if($arraydiagnosa){
            $irow3=1;
            foreach($arraydiagnosa as $rowdiagnosaloop){
                $datadiagnosatmp = json_decode($rowdiagnosaloop);
                $datadiagnosaloop[] = array(
                    'KD_PELAYANAN' => $pelayanan,
                    'KD_PASIEN' => $pasien,
                    'KD_PUSKESMAS' => $puskesmas,
                    'KD_PENYAKIT' => $datadiagnosatmp->kd_penyakit,
                    'JNS_KASUS' => $datadiagnosatmp->jenis_kasus,
                    'JNS_DX' => $datadiagnosatmp->jenis_diagnosa,
                    'KD_PETUGAS' => $this->session->userdata('user_name'),
                    'iROW' => $irow3,
                    'TANGGAL' => date('Y-m-d'),
                    'Created_By' => $this->session->userdata('user_name'),
                    'Created_Date' => date('Y-m-d H:i:s')
                );
                $datadiagnosainsert = $datadiagnosaloop;
                $irow3++;
            }
            $db->insert_batch('pel_diagnosa',$datadiagnosainsert);
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

    public function edit()
    {
        $id=$this->input->get('id')?$this->input->get('id',TRUE):null;
        $db = $this->load->database('sikda', TRUE);
        $db->select("u.*, m.ncolumn1 as nmastercolumn1");
        $db->from('tbl_t_pelayanan u');
        $db->join('tbl_master1 m','m.nid_master1=u.nmaster_1_id');
        $db->where('u.nid_t_pelayanan ',$id);
        $val = $db->get()->row();
        $data['data']=$val;
        $this->load->view('t_pelayanan/t_pelayananedit',$data);
    }

    public function ubahkunjungan()
    {
        $id=$this->input->get('id')?$this->input->get('id',TRUE):null;
        $id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
        $db = $this->load->database('sikda', TRUE);
        $db->select("k.KD_KUNJUNGAN,NAMA_LENGKAP AS NAMA_PASIEN,k.KD_UNIT_LAYANAN,k.KD_UNIT,k.KD_DOKTER",FALSE);
        $db->from('kunjungan k');
        $db->join('pasien p','k.KD_PASIEN=p.KD_PASIEN');
        //$db->join('mst_unit u','k.KD_UNIT=p.KD_UNIT');
        $db->where('k.KD_KUNJUNGAN ',$id);
        $db->where('k.KD_PUSKESMAS',$id2);
        $val = $db->get()->row();
        $data['data']=$val;
        $this->load->view('t_pelayanan/v_t_pelayanan_edit_kunjungan',$data);
    }

    public function pelayananpelayanan()
    {
        $this->load->helper('beries_helper');
        $id=$this->input->get('id')?$this->input->get('id',TRUE):null;
        $id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
        $db = $this->load->database('sikda', TRUE);
        $db->select("NAMA_LENGKAP AS NAMA_PASIEN,p.KD_PASIEN,p.KD_PUSKESMAS,p.TGL_LAHIR,p.NO_PENGENAL AS NIK,p.KET_WIL,p.KD_GOL_DARAH,k.CUSTOMER",FALSE);
        $db->from('pasien p');
        $db->join('mst_kel_pasien k','k.KD_CUSTOMER=p.KD_CUSTOMER');
        //$db->join('mst_unit u','k.KD_UNIT=p.KD_UNIT');
        $db->where('p.KD_PASIEN',$id);
        $db->where('p.KD_PUSKESMAS',$id2);
        $val = $db->get()->row();
        $data['data']=$val;
        $this->load->view('t_pelayanan/v_t_pelayanan_pelayanan',$data);
    }

    public function gabungpasien()
    {
        $this->load->helper('beries_helper');
        $id=$this->input->get('id')?$this->input->get('id',TRUE):null;
        $id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
        $db = $this->load->database('sikda', TRUE);
        $db->select("NAMA_LENGKAP AS NAMA_PASIEN,p.KD_PASIEN,p.KD_PUSKESMAS,p.TGL_LAHIR,p.NO_PENGENAL AS NIK,p.KET_WIL,p.KD_GOL_DARAH,k.CUSTOMER",FALSE);
        $db->from('pasien p');
        $db->join('mst_kel_pasien k','k.KD_CUSTOMER=p.KD_CUSTOMER');
        //$db->join('mst_unit u','k.KD_UNIT=p.KD_UNIT');
        $db->where('p.KD_PASIEN',$id);
        $db->where('p.KD_PUSKESMAS',$id2);
        $val = $db->get()->row();
        $data['data']=$val;
        $this->load->view('t_pelayanan/v_t_pelayanan_gabung',$data);
    }

    public function delete()
    {
        $id=$this->input->post('id')?$this->input->post('id',TRUE):null;
        $db = $this->load->database('sikda', TRUE);
        if($db->query("delete from tbl_t_pelayanan where nid_t_pelayanan = '".$id."'")){
            die(json_encode('OK'));
        }else{
            die(json_encode('FAIL'));
        }
    }
    public function detailkunjunganpasien()
    {
        $this->load->helper('ernes_helper');
        $this->load->helper('beries_helper');
        $this->load->helper('my_helper');
        $this->load->helper('master_helper');
        $this->load->helper('sigit_helper');
        $this->load->helper('jokos_helper');
        $this->load->helper('pemkes_helper');
        $id=$this->input->get('id_kunjungan')?$this->input->get('id_kunjungan',TRUE):null; //print_r($id);die;
        $id1=$this->input->get('kd_pelayanan')?$this->input->get('kd_pelayanan',TRUE):null; //print_r($id1);die;
        $idpuskesmas = $this->input->get('kd_puskesmas')?$this->input->get('kd_puskesmas',TRUE):null; //echo $id; die();
        $db = $this->load->database('sikda', TRUE);
        $kdunit = $db->query("select KD_UNIT from kunjungan where ID_KUNJUNGAN='".$id."' AND KD_PUSKESMAS ='$idpuskesmas'")->row();
        if($kdunit->KD_UNIT==219){
            // $unit = $db->query("select * from trans_kia where KD_KUNJUNGAN='".$id."'")->row();//print_r($unit);die;

            $unit = $db->query(
                "select * from trans_kia tkia
					LEFT JOIN kunjungan k ON tkia.ID_KUNJUNGAN=k.ID_KUNJUNGAN
					where tkia.ID_KUNJUNGAN='$id'
					AND k.KD_PUSKESMAS = '$idpuskesmas'
				"
            )->row();//print_r($unit);die;

            // View Detail Kunjungan Ibu Hamil
            if($unit->KD_KATEGORI_KIA==1 AND $unit->KD_KUNJUNGAN_KIA==1){
                $db->select('a.*,b.ID_KUNJUNGAN,b.KD_PELAYANAN,e.KD_PASIEN,c.STATUS_HAMIL,d.LETAK_JANIN,md_dokter.NAMA AS DOKTER, md_petugas.NAMA AS PETUGAS');
                $db->from('kunjungan_bumil a');
                $db->join('trans_kia b','a.KD_KIA=b.KD_KIA');
                $db->join('pelayanan e','b.KD_PELAYANAN=e.KD_PELAYANAN');
                $db->join('mst_status_hamil c','c.KD_STATUS_HAMIL=a.KD_STATUS_HAMIL');
                $db->join('mst_letak_janin d','d.KD_LETAK_JANIN=a.KD_LETAK_JANIN');
                $db->join('mst_dokter md_dokter', 'md_dokter.KD_DOKTER = b.KD_DOKTER_PEMERIKSA', 'left');
                $db->join('mst_dokter md_petugas', 'md_petugas.KD_DOKTER = b.KD_DOKTER_PETUGAS', 'left');
                $db->where('b.ID_KUNJUNGAN',$id);
                $db->where('b.KD_PELAYANAN', $id1);
                $db->where('a.KD_PUSKESMAS',$idpuskesmas);
                $val = $db->get()->row();
                $data['data']=$val;//print_r($db->last_query());die;
                if(!empty($val)){
                    $this->load->view('t_pelayanan/kunjungan_detail/v_t_kunjungan_ibu_hamil_detail',$data);
                }else{
                    echo("<script type='text/javascript'> message();</script>");
                    $this->load->view('t_pelayanan/v_pelayanan');
                }

                // View Detail Kunjungan Bersalin //
            }elseif($unit->KD_KATEGORI_KIA==1 AND $unit->KD_KUNJUNGAN_KIA==2){
                $db->select("*");
                $db->from('vw_detail_bersalin');
                $db->where('ID_KUNJUNGAN' ,$id);
                $db->where('KD_PELAYANAN', $id1);
                $val = $db->get()->row();
                $data['data']=$val;
                $data['data']->KD_PUSKESMAS=$idpuskesmas;
                if(!empty($val->TANGGAL_PERSALINAN)){
                    $this->load->view('t_pelayanan/kunjungan_detail/v_t_kunjungan_ibu_bersalin_detail',$data);
                }else{
                    echo("<script type='text/javascript'> message();</script>");
                    $this->load->view('t_pelayanan/v_pelayanan');
                }

                // View Detail Kunjungan Nifas //
            }elseif($unit->KD_KATEGORI_KIA==1 AND $unit->KD_KUNJUNGAN_KIA==3){
                $db->select("u.*,k.ID_KUNJUNGAN,k.KD_PELAYANAN,t.KD_PASIEN,(select a.NAMA from mst_dokter a join trans_kia b on a.KD_DOKTER=b.KD_DOKTER_PEMERIKSA where b.ID_KUNJUNGAN='".$id."') as PEMERIKSA,(select a.NAMA from mst_dokter a join trans_kia b on a.KD_DOKTER=b.KD_DOKTER_PETUGAS where b.ID_KUNJUNGAN='".$id."') as PETUGAS", false);
                $db->from('kunjungan_nifas u');
                $db->join('trans_kia k', 'u.KD_KIA=k.KD_KIA');
                $db->join('pelayanan t', 'k.KD_PELAYANAN=t.KD_PELAYANAN');
                $db->where('k.ID_KUNJUNGAN ',$id);
                $db->where('k.KD_PELAYANAN', $id1);
                $db->where('u.KD_PUSKESMAS',$idpuskesmas);
                $val = $db->get()->row();//echo print_r($val);die;
                $data['data']=$val;
                if(!empty($val)){
                    $this->load->view('t_pelayanan/kunjungan_detail/v_transaksi_kunjungan_nifas_detail',$data);
                }else{
                    echo("<script type='text/javascript'> message();</script>");
                    $this->load->view('t_pelayanan/v_pelayanan');
                }

                // View Detail Kunjungan KB //
            }elseif($unit->KD_KATEGORI_KIA==1 AND $unit->KD_KUNJUNGAN_KIA==4){
                $db->select("a.*, b.ID_KUNJUNGAN, b.KD_PELAYANAN, c.KD_PASIEN, (select NAMA from mst_dokter d join trans_kia e on d.KD_DOKTER=e.KD_DOKTER_PEMERIKSA where e.ID_KUNJUNGAN='".$id."') as PEMERIKSA, (select NAMA from mst_dokter d join trans_kia e on d.KD_DOKTER=e.KD_DOKTER_PETUGAS where e.ID_KUNJUNGAN='".$id."') as PETUGAS, f.JENIS_KB", false);
                $db->from('kunjungan_kb a');
                $db->join('trans_kia b','a.KD_KIA=b.KD_KIA');
                $db->join('pelayanan c','b.KD_PELAYANAN=c.KD_PELAYANAN');
                $db->join('mst_jenis_kb f','a.KD_JENIS_KB=f.KD_JENIS_KB');
                $db->where('b.ID_KUNJUNGAN',$id);
                $db->where('b.KD_PELAYANAN', $id1);
                $db->where('a.KD_PUSKESMAS',$idpuskesmas);
                $val = $db->get()->row();
                $data['data']=$val;
                if(!empty($val)){
                    $this->load->view('t_pelayanan/kunjungan_detail/v_t_pelayanan_kb_detail',$data);
                }else{
                    echo("<script type='text/javascript'> message();</script>");
                    $this->load->view('t_pelayanan/v_pelayanan');
                }

                // View Detail Kunjungan Neonatus //
            }elseif($unit->KD_KATEGORI_KIA==2 AND $unit->KD_KUNJUNGAN_KIA==1){ //print_r($unit);die;
                $db->select("a.*,DATE_FORMAT(a.TANGGAL_KUNJUNGAN,'%d-%m-%Y') as TANGGAL_KUNJUNGAN,b.ID_KUNJUNGAN,b.KD_PELAYANAN,c.KD_PASIEN,(select NAMA from mst_dokter d join trans_kia e on d.KD_DOKTER=e.KD_DOKTER_PEMERIKSA where e.ID_KUNJUNGAN='".$id."') as PEMERIKSA,(select NAMA from mst_dokter d join trans_kia e on d.KD_DOKTER=e.KD_DOKTER_PETUGAS where e.ID_KUNJUNGAN='".$id."') as PETUGAS", false );
                $db->from('pemeriksaan_neonatus a');
                $db->join('trans_kia b', 'a.KD_KIA=b.KD_KIA','left');
                $db->join('pelayanan c', 'b.KD_PELAYANAN=c.KD_PELAYANAN','left');
                $db->where('b.ID_KUNJUNGAN',$id);//print_r($id);die;
                $db->where('b.KD_PELAYANAN', $id1);
                $db->where('a.KD_PUSKESMAS',$idpuskesmas);
                $val = $db->get()->row();//print_r($db->last_query());die;
                $data['data']=$val; //print_r($data);die;
                if(!empty($val)){
                    $this->load->view('t_pelayanan/kunjungan_detail/v_t_pemeriksaan_neonatus_detail',$data);
                }else{
                    echo("<script type='text/javascript'> message();</script>");
                    $this->load->view('t_pelayanan/v_pelayanan');
                }

                // View Detail Kunjungan Kesehatan Anak // query masih salah
            }elseif($unit->KD_KATEGORI_KIA==2 AND $unit->KD_KUNJUNGAN_KIA==2){
                $db->select('a.*,c.KD_PASIEN,b.ID_KUNJUNGAN,b.KD_PELAYANAN, md_dokter.NAMA AS DOKTER, md_petugas.NAMA AS PETUGAS');
                $db->from('pemeriksaan_anak a');
                $db->join('trans_kia b','a.KD_KIA=b.KD_KIA');
                $db->join('pelayanan c','b.KD_PELAYANAN=c.KD_PELAYANAN');
                $db->join('mst_dokter md_dokter', 'md_dokter.KD_DOKTER = b.KD_DOKTER_PEMERIKSA', 'left');
                $db->join('mst_dokter md_petugas', 'md_petugas.KD_DOKTER = b.KD_DOKTER_PETUGAS', 'left');
                $db->where('b.ID_KUNJUNGAN',$id);
                $db->where('b.KD_PELAYANAN', $id1);
                $db->where('a.KD_PUSKESMAS',$idpuskesmas);
                $val = $db->get()->row();
                $data['data']=$val;
                if(!empty($val)){
                    $this->load->view('t_pelayanan/kunjungan_detail/v_t_pemeriksaan_kesehatan_anak_detail',$data);
                }else{
                    echo("<script type='text/javascript'> message();</script>");
                    $this->load->view('t_pelayanan/v_pelayanan');
                }
            }elseif($unit->KD_KATEGORI_KIA==3){
                $db->select('a.*,f.KD_FAMILY_FOLDER,d.STATUS_MARITAL,d.KD_KECAMATAN,d.NAMA_LENGKAP,d.NO_PENGENAL,d.KD_GOL_DARAH,d.TGL_LAHIR,e.*,c.TGL_PELAYANAN,c.KEADAAN_KELUAR,c.KD_PASIEN,b.ID_KUNJUNGAN,b.KD_PELAYANAN,b.KD_DOKTER_PEMERIKSA AS DOKTER,b.KD_DOKTER_PETUGAS AS PETUGAS');
                $db->from('trans_imunisasi a');
                $db->join('trans_kia b','a.KD_PELAYANAN=b.KD_PELAYANAN');
                $db->join('pelayanan c','b.KD_PELAYANAN=c.KD_PELAYANAN');
                $db->join('pasien d','d.KD_PASIEN=c.KD_PASIEN');
                $db->join('family_folder f','f.ID_FAMILY_FOLDER=d.ID_FAMILY_FOLDER');
                $db->join('kunjungan e','e.KD_PELAYANAN=c.KD_PELAYANAN');
                $db->where('b.ID_KUNJUNGAN',$id);
                $db->where('b.KD_PELAYANAN', $id1);
                $db->where('a.KD_PUSKESMAS',$idpuskesmas);
                $db->where('c.KD_PUSKESMAS',$idpuskesmas);
                $db->where('e.KD_PUSKESMAS',$idpuskesmas);
                $val = $db->get()->row();

                // get nama suami dan ibu
                $namasuami = $db->query("select NAMA_LENGKAP AS NAMA_SUAMI FROM pasien a join family_folder b on a.ID_FAMILY_FOLDER=b.ID_FAMILY_FOLDER where b.KD_FAMILY_FOLDER='".$val->KD_FAMILY_FOLDER."' and b.KD_STATUS_KELUARGA=1")->row();
                $namaibu = $db->query("select NAMA_LENGKAP AS NAMA_IBU FROM pasien a join family_folder b on a.ID_FAMILY_FOLDER=b.ID_FAMILY_FOLDER where b.KD_FAMILY_FOLDER='".$val->KD_FAMILY_FOLDER."' and b.KD_STATUS_KELUARGA=2")->row();
                $data['data']=$val;
                $data['datasuami']=$namasuami;
                $data['dataibu']=$namaibu;
                if(!empty($val)){
                    $this->load->view('t_pelayanan/kunjungan_detail/v_t_kunjungan_imunisasi_detail',$data);
                }else{
                    echo("<script type='text/javascript'> message();</script>");
                    $this->load->view('t_pelayanan/v_pelayanan');
                }
            }
        }else{
            $val = $db->query("select * from kunjungan where ID_KUNJUNGAN='".$id."'")->row();//print_r($val);die;
            if($val->KD_LAYANAN_B=='RJ'){
                //Detail Kunjungan Rawat Jalan //
                $db->select ("*",false);
                $db->from("vw_detail_rawat_jalan");
                $db->where('ID_KUNJUNGAN', $id);
                $db->where('KD_PELAYANAN', $id1);
                $db->where('KD_PUSKESMAS',$idpuskesmas);
                $val = $db->get()->row();//print_r($db->last_query());die;
                $data['data']=$val;
                $this->load->view('t_pelayanan/kunjungan_detail/v_t_pelayanan_rawatjalan_detail',$data);
            }elseif($val->KD_LAYANAN_B=='RI'){
                //Detail Kunjungan Rawat Inap //
                $db->select ("*",false);
                $db->from('vw_detail_rawat_inap');
                $db->where('ID_KUNJUNGAN', $id);
                $db->where('KD_PELAYANAN', $id1);
                $db->where('KD_PUSKESMAS',$idpuskesmas);
                $val = $db->get()->row();
                $data['data']=$val;
                $this->load->view('t_pelayanan/kunjungan_detail/v_t_pelayanan_rawatinap_detail',$data);
            }else{
                //Detail Kunjungan UGD //
                $this->load->view('t_pelayanan/kunjungan_detail/v_t_pelayanan_ugd_detail',$data);
            }
        }

    }

    public function layanan($only_get_data=false)
    {
        /*$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
          $id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
          $id3=$this->input->get('id3')?$this->input->get('id3',TRUE):null;
          $data['id']=$id;
          $data['id2']=$id2;
          $data['id3']=$id3;
          $this->load->view('t_pelayanan/v_t_pelayanan_layanan',$data);*/
        $this->load->helper('ernes_helper');
        $this->load->helper('beries_helper');
        $this->load->helper('my_helper');
        $this->load->helper('master_helper');
        $this->load->helper('sigit_helper');
        $this->load->helper('jokos_helper');
        $this->load->helper('pemkes_helper');
        $id=$this->input->get('id')?$this->input->get('id',TRUE):null; //kd_pasien
        $id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null; //kd_puskesmas
        $id3=$this->input->get('id3')?$this->input->get('id3',TRUE):null; //id_kunjungan

        $db = $this->load->database('sikda', TRUE);
        $unit = $db->query("select * from kunjungan where ID_KUNJUNGAN='".$id3."' and KD_UNIT=219")->row();
        if($unit){
            $kia = $db->query("select KD_KATEGORI_KIA from trans_kia where ID_KUNJUNGAN='".$id3."'")->row();
            if(!empty($kia) && $kia->KD_KATEGORI_KIA=='3'){
                $db->select("p.NAMA_LENGKAP AS NAMA_PASIEN,p.KD_PASIEN,,p.KD_KECAMATAN,p.KD_KELURAHAN,p.KD_PUSKESMAS,p.TGL_LAHIR,p.NO_PENGENAL AS NIK,p.KET_WIL,p.ID_FAMILY_FOLDER,p.KD_GOL_DARAH,p.KD_CUSTOMER,p.CARA_BAYAR,k.CUSTOMER,mu.UNIT,kj.KD_UNIT_LAYANAN,kj.ID_KUNJUNGAN,kj.TGL_MASUK,kj.KD_UNIT,kj.URUT_MASUK,kj.KD_LAYANAN_B,tk.KD_KATEGORI_KIA",FALSE);
                $db->from('pasien p');
                $db->join('mst_kel_pasien k','k.KD_CUSTOMER=p.KD_CUSTOMER','left');
                $db->join('kunjungan kj','kj.KD_PASIEN=p.KD_PASIEN','left');
                $db->join('mst_unit mu','mu.KD_UNIT=kj.KD_UNIT','left');
                $db->join('trans_kia tk','tk.ID_KUNJUNGAN=kj.ID_KUNJUNGAN','left');
                $db->where('p.KD_PASIEN',$id);
                $db->where('kj.ID_KUNJUNGAN',$id3);
                $db->where('p.KD_PUSKESMAS',$id2);
                $val = $db->get()->row();
                $data['data'] = $val;

                $this->load->view('t_pelayanan/kunjungan/v_t_pelayanan_imunisasi',$data);
            }else{
                $db->select("p.KD_PASIEN,kj.KD_PUSKESMAS,kj.ID_KUNJUNGAN,substr(kj.KD_KUNJUNGAN,16,1) as KUNJUNGAN",FALSE);
                $db->from('pasien p');
                $db->join('kunjungan kj','kj.KD_PASIEN=p.KD_PASIEN','left');
                $db->where('p.KD_PASIEN',$id);
                $db->where('kj.ID_KUNJUNGAN',$id3);
                $db->where('p.KD_PUSKESMAS',$id2);
                $val = $db->get()->row();
                $data['data']=$val;
                $this->load->view('t_pelayanan/v_t_pelayanan_kia',$data);
            }
        }else{
            $db->select("NAMA_LENGKAP AS NAMA_PASIEN,p.KD_PASIEN,p.KD_PUSKESMAS,p.TGL_LAHIR,p.NO_PENGENAL AS NIK,p.KET_WIL,p.KD_GOL_DARAH,p.KD_CUSTOMER,p.CARA_BAYAR,k.CUSTOMER,mu.UNIT,kj.ID_KUNJUNGAN,kj.KD_UNIT,kj.URUT_MASUK,kj.KD_LAYANAN_B,p.NO_ASURANSI,kj.KD_UNIT_LAYANAN",FALSE);
            $db->from('pasien p');
            $db->join('mst_kel_pasien k','k.KD_CUSTOMER=p.KD_CUSTOMER','left');
            $db->join('kunjungan kj','kj.KD_PASIEN=p.KD_PASIEN','left');
            $db->join('mst_unit mu','mu.KD_UNIT=kj.KD_UNIT','left');
            $db->where('p.KD_PASIEN',$id);
            $db->where('kj.ID_KUNJUNGAN',$id3);
            $db->where('p.KD_PUSKESMAS',$id2);
            $val = $db->get()->row();

            $tindakanlist = $db->query("SELECT p.KD_PRODUK AS id,CONCAT(p.PRODUK,' => Harga:',p.HARGA_PRODUK) AS label,
							CASE WHEN g.GOL_PRODUK IS NULL THEN '' ELSE g.GOL_PRODUK END AS category
							FROM mst_produk p LEFT JOIN mst_gol_produk g on p.KD_GOL_PRODUK=g.KD_GOL_PRODUK")->result_array(); //print_r($tindakanlist);die;

            $data['dataproduktindakan']=json_encode($tindakanlist);
            $data['rawatjalan_id']=$id;
            $data['rawatjalan_id2']=$id2;
            $data['rawatjalan_id3']=$id3;
            $data['data']=$val;
            if($only_get_data) return $data;
            if($val->KD_LAYANAN_B=='RJ'){
                $this->load->view('t_pelayanan/v_t_pelayanan_rawatjalan',$data);
            }elseif($val->KD_LAYANAN_B=='RI'){
                $this->load->view('t_pelayanan/v_t_pelayanan_rawatinap',$data);
            }else{
                $this->load->view('t_pelayanan/v_t_pelayanan_ugd',$data);
            }
        }


    }

    public function layanan_kia()
    {

        $this->load->helper('ernes_helper');
        $this->load->helper('beries_helper');
        $this->load->helper('my_helper');
        $this->load->helper('master_helper');
        $this->load->helper('sigit_helper');
        $this->load->helper('jokos_helper');
        $this->load->helper('pemkes_helper');
        $id=$this->input->get('id')?$this->input->get('id',TRUE):null;
        $id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
        $id3=$this->input->get('id3')?$this->input->get('id3',tRUE):null;
        $mykd=$this->input->get('mykd')?$this->input->get('mykd',tRUE):null;
        $mykd2=$this->input->get('mykd2')?$this->input->get('mykd2',tRUE):null;
        $db = $this->load->database('sikda', TRUE);
        $db->select("p.NAMA_LENGKAP AS NAMA_PASIEN,p.KD_PASIEN,p.KD_PUSKESMAS,p.TGL_LAHIR,p.NO_PENGENAL AS NIK,p.KET_WIL,p.ID_FAMILY_FOLDER,p.KD_GOL_DARAH,p.KD_CUSTOMER,p.CARA_BAYAR,k.CUSTOMER,mu.UNIT,kj.ID_KUNJUNGAN,kj.TGL_MASUK,kj.KD_UNIT,kj.URUT_MASUK,kj.KD_LAYANAN_B,tk.KD_KATEGORI_KIA,tk.KD_KUNJUNGAN_KIA",FALSE);
        $db->from('pasien p');
        $db->join('mst_kel_pasien k','k.KD_CUSTOMER=p.KD_CUSTOMER','left');
        $db->join('kunjungan kj','kj.KD_PASIEN=p.KD_PASIEN','left');
        $db->join('mst_unit mu','mu.KD_UNIT=kj.KD_UNIT','left');
        $db->join('trans_kia tk','tk.ID_KUNJUNGAN=kj.ID_KUNJUNGAN','left');
        $db->where('p.KD_PASIEN',$id);
        $db->where('kj.ID_KUNJUNGAN',$id3);
        $db->where('p.KD_PUSKESMAS',$id2);
        $val = $db->get()->row();
        $maxkunj = $db->query("SELECT MAX(kunjungan_ke) as maxx FROM kunjungan_bumil WHERE KD_PASIEN='".$id."'")->row();
        $data['kunj']=$maxkunj->maxx;
        $tindakanlist = $db->query("SELECT p.KD_PRODUK AS id,CONCAT(p.PRODUK,' => Harga:',p.HARGA_PRODUK) AS label,
						CASE WHEN g.GOL_PRODUK IS NULL THEN '' ELSE g.GOL_PRODUK END AS category
						FROM mst_produk p LEFT JOIN mst_gol_produk g on p.KD_GOL_PRODUK=g.KD_GOL_PRODUK")->result_array(); //print_r($tindakanlist);die;

        $data['dataproduktindakan']=json_encode($tindakanlist);
        $data['mykd']=$mykd;
        $data['mykd2']=$mykd2;
        $data['data']=$val;
        if($mykd==1){
            $this->load->view('t_pelayanan/kunjungan/v_t_pelayanan_bumil',$data);
        }elseif($mykd==2){
            $this->load->view('t_pelayanan/kunjungan/v_t_pelayanan_bersalin',$data);
        }elseif($mykd==3){
            $this->load->view('t_pelayanan/kunjungan/v_transaksi_kunjungan_nifas_add',$data);
        }elseif($mykd==4){
            $a = $db->query("select KD_FAMILY_FOLDER from family_folder where ID_FAMILY_FOLDER=".$val->ID_FAMILY_FOLDER."")->row();
            $namasuami = $db->query("select z.NAMA_LENGKAP as NAMA_SUAMI from pasien z join family_folder x on z.ID_FAMILY_FOLDER=x.ID_FAMILY_FOLDER where x.KD_FAMILY_FOLDER=".$a->KD_FAMILY_FOLDER." and x.KD_STATUS_KELUARGA=1")->row();
            $data['datasuami'] = $namasuami;
            $this->load->view('t_pelayanan/kunjungan/v_t_pelayanan_kb',$data);
        }elseif($mykd2==1){
            $this->load->view('t_pelayanan/kunjungan/v_t_pelayanan_neonatus',$data);
        }elseif($mykd2==2){
            $this->load->view('t_pelayanan/kunjungan/v_t_pelayanan_kesehatan_anak',$data);
        }
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function existsOdontogramRecord(){
        $check_unit = $this->input->post('get_unit_pelayanan');

        $db = $this->load->database('sikda', TRUE);
        $puskesmas = $this->input->post('kd_puskesmas_hidden')?$this->input->post('kd_puskesmas_hidden',TRUE):$this->session->userdata('kd_puskesmas');
        $pasien = $this->input->post('kd_pasien_hidden',TRUE);
        $check_gigi = $db->query("select * from t_perawatan_gigi_pasien where KD_PUSKESMAS='".$puskesmas."' and KD_PASIEN='".$pasien."'")->row();


        if(empty($check_gigi) && $check_unit == 'Gigi'){
            echo 'error odontogram';
        }else{
            echo 'OK';
        }
    }
    public function pelayananprocess()
    {

        $data_insert_trans_kia = null;
        //if($this->input->post('konsulpoliklinik'))echo 'proses transfer';
        $this->load->library('form_validation');
        $val = $this->form_validation;
        $val->set_rules('tanggal_daftar', 'Tanggal Pendaftaran', 'trim|required|myvalid_date');
        $val->set_rules('cara_bayar', 'Cara Bayar', 'trim|required|xss_clean');
        $val->set_rules('jenis_pasien', 'Jenis Pasien', 'trim|required|xss_clean');
        if($this->input->post('jenis_pasien')!=='0000000001'){
            $val->set_rules('no_asuransi_pasien', 'No. Asuransi', 'trim|required|xss_clean');
        }
        $arraydiagnosa = $this->input->post('diagnosa_final')?json_decode($this->input->post('diagnosa_final',TRUE)):NULL;
        $arrayobat = $this->input->post('obat_final')?json_decode($this->input->post('obat_final',TRUE)):NULL;
        $arrayalergi = $this->input->post('alergi_final')?json_decode($this->input->post('alergi_final',TRUE)):NULL;
        $arraylab = $this->input->post('lab_final')?json_decode($this->input->post('lab_final',TRUE)):NULL;
        $arraytindakan = $this->input->post('tindakan_final')?json_decode($this->input->post('tindakan_final',TRUE)):NULL;
        $datainsert = array();

        if ($val->run() == FALSE)
        {
            $val->set_error_delimiters('<div style="color:white">', '</div>');
            die(validation_errors());
        }
        else
        {
            $db = $this->load->database('sikda', TRUE);
            $db->trans_begin();

            $puskesmas = $this->input->post('kd_puskesmas_hidden')?$this->input->post('kd_puskesmas_hidden',TRUE):$this->session->userdata('kd_puskesmas');

            // $check_gigi = $db->query("select * from t_perawatan_gigi_pasien where KD_PUSKESMAS='".$puskesmas."' and KD_PASIEN='".$this->input->post('kd_pasien_hidden',TRUE)."'")->row();
            // $check_unit = $this->input->post('get_unit_pelayanan');
            // if(empty($check_gigi) && $check_unit == 'Gigi'){
            // 	die('Data Odontogram belum terdaftarkan. Mohon diisi terlebih dahulu');
            // }

            if($arrayalergi){
                foreach($arrayalergi as $rowalergiloop){
                    $dataalergitmp = json_decode($rowalergiloop);
                    $dataalergiloop[] = array(
                        'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
                        'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
                        'KD_OBAT' => $dataalergitmp->kd_obat,
                        'Created_By' => $this->session->userdata('user_name'),
                        'Created_Date' => date('Y-m-d H:i:s')
                    );
                    $dataalergiinsert = $dataalergiloop;
                }
                $db->insert_batch('pasien_alergi_obt',$dataalergiinsert);
            }

            $maxkasir = 0;
            $maxkasir = $db->query("SELECT MAX(SUBSTR(KD_PEL_KASIR,-7)) AS total FROM pel_kasir where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
            $maxkasir = $maxkasir->total + 1;
            $kodekasir = 'KASIR'.sprintf("%07d", $maxkasir);

            $datainsertkasir=array(
                'KD_PEL_KASIR'=> $kodekasir,
                'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
                'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
                'KD_UNIT' => $this->input->post('kd_unit_hidden',TRUE),
                'KD_TARIF' => 0,
                'JUMLAH_BIAYA' => 0,
                'JUMLAH_PPN' => 0,
                'JUMLAH_DISC' => 0,
                'JUMLAH_TOTAL' => 0,
                'KD_USER' => $this->session->userdata('kd_petugas'),
                'STATUS_TX' => 0

            );
            $db->insert('pel_kasir',$datainsertkasir);

            $maxpelayanan = 0;
            $maxpelayanan = $db->query("SELECT MAX(SUBSTR(KD_PELAYANAN,-7)) AS total FROM pelayanan where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
            $maxpelayanan = $maxpelayanan->total + 1;
            $kodepelayanan = $this->input->post('kd_unit_hidden',TRUE).sprintf("%07d", $maxpelayanan);

            $datainsert = array(
                'KD_PELAYANAN' =>  $kodepelayanan,
                'TGL_PELAYANAN' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_daftar')))),
                'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
                'KD_UNIT' => $this->input->post('kd_unit_hidden',TRUE),
                'URUT_MASUK' => $this->input->post('kd_urutmasuk_hidden',TRUE),
                'KD_KASIR' => $kodekasir,
                'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
                'ANAMNESA' => $this->input->post('anamnesa',TRUE),
                'KONDISI_PASIEN' => '-',
                'CATATAN_FISIK' => $this->input->post('catatan_fisik',TRUE),
                'CARA_BAYAR' => $this->input->post('cara_bayar',TRUE),
                'JENIS_PASIEN' => $this->input->post('jenis_pasien',TRUE),
                'KD_USER' => $this->session->userdata('kd_petugas'),
                'CATATAN_DOKTER' => $this->input->post('catatan_dokter',TRUE),
                'Created_Date' => date('Y-m-d'),
                'Created_By' => $this->session->userdata('kd_petugas'),
                'KD_DOKTER' => $this->input->post('petugas2')? $this->input->post('petugas2'): NULL,
                'KEADAAN_KELUAR' => $this->input->post('status_keluar',TRUE)
            );
            if($this->input->post('showhide_kunjungan')){
                if($this->input->post('showhide_kunjungan')=='rawat_jalan'){
                    $datainsert['UNIT_PELAYANAN'] = 'RJ';
                }elseif($this->input->post('showhide_kunjungan')=='rawat_inap'){
                    $datainsert['UNIT_PELAYANAN'] = 'RI';
                }else{
                    $datainsert['UNIT_PELAYANAN'] = 'RD';
                }
            }
            //if($this->input->post('jenis_pasien')=='0000000003' or $this->input->post('jenis_pasien')=='0000000004' or $this->input->post('jenis_pasien')=='0000000005' or $this->input->post('jenis_pasien')=='0000000006'){
            if($this->input->post('jenis_pasien')!=='0000000001'){
                $datainsert['NO_ASURANSI'] = $this->input->post('no_asuransi_pasien');
            }

            if(empty($arrayobat)){
                $datainsert['STATUS_LAYANAN'] = '1';
            }
            $db->insert('pelayanan',$datainsert);

            //update pasien
            $dataasuransi=array(
                'CARA_BAYAR' => $this->input->post('cara_bayar',TRUE),
                'KD_CUSTOMER' => $this->input->post('jenis_pasien',TRUE)
            );
            //if($this->input->post('jenis_pasien')=='0000000003' or $this->input->post('jenis_pasien')=='0000000004' or $this->input->post('jenis_pasien')=='0000000005' or $this->input->post('jenis_pasien')=='0000000006'){
            if($this->input->post('jenis_pasien')!=='0000000001'){
                $dataasuransi['NO_ASURANSI'] = $this->input->post('no_asuransi_pasien');
            }
            $db->where('KD_PASIEN',$this->input->post('kd_pasien_hidden'));
            $db->update('pasien',$dataasuransi);

            if($arraylab){//print_r($arraylab);die;
                foreach($arraylab as $rowlabloop){
                    $datalabtmp = json_decode($rowlabloop);
                    $tmplb = explode('=>',$datalabtmp->lab);
                    $hrglb = explode(':',$tmplb[1]);
                    $datalabloop[] = array(
                        'KD_PELAYANAN_LAB' => $kodepelayanan,
                        'KD_PELAYANAN' => $kodepelayanan,
                        'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
                        'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
                        'KD_LAB' => $datalabtmp->kd_lab,
                        'QTY' => $datalabtmp->jumlah,
                        'HRG' => $hrglb[1],
                        'JUMLAH' => $datalabtmp->jumlah,
                        'Created_By' => $this->session->userdata('user_name'),
                        'Created_Date' => date('Y-m-d H:i:s')
                    );
                    $datalabinsert = $datalabloop;
                }
                $db->insert_batch('pel_ord_lab',$datalabinsert);
            }

            $kdkunjungan=$this->input->post('kd_kunjungan_hidden',true);
            $db->set('KD_PELAYANAN',$kodepelayanan);
            $db->where('ID_KUNJUNGAN',$kdkunjungan);
            $db->update('kunjungan');

            if($arrayobat){
                $maxpelayananobat = 0;
                $maxpelayananobat = $db->query("SELECT MAX(SUBSTR(KD_PELAYANAN,-7)) AS total FROM pelayanan where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
                $maxpelayananobat = $maxpelayananobat->total + 1;
                $kodepelayananobat = '6'.sprintf("%07d", $maxpelayananobat);
                $kodepelayananresep = 'R'.sprintf("%07d", $maxpelayananobat);
                $qtyobattotal=0;
                $hargaobattotal=0;
                $irow=1;
                foreach($arrayobat as $rowobatloop){
                    $dataobattmp = json_decode($rowobatloop);
                    $dataobatloop[] = array(
                        'KD_PELAYANAN_OBAT' => $kodepelayananobat,
                        'KD_PELAYANAN' => $kodepelayanan,
                        'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
                        'KD_KABUPATEN' => $this->session->userdata('kd_kabupaten'),
                        'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
                        'NO_RESEP' => $kodepelayananresep,
                        'KD_OBAT' => $dataobattmp->kd_obat,
                        'SAT_BESAR' => '',
                        'SAT_KECIL' => '',
                        'QTY' => $dataobattmp->jumlah,
                        'HRG_JUAL' => $dataobattmp->harga,
                        'DOSIS' => $dataobattmp->dosis,
                        'JUMLAH' => $dataobattmp->jumlah,
                        'KD_PETUGAS' => $this->session->userdata('user_name'),
                        'STATUS' => 0,
                        'iROW' => $irow,
                        'TANGGAL' => date('Y-m-d'),
                        'Created_By' => $this->session->userdata('user_name'),
                        'Created_Date' => date('Y-m-d H:i:s')
                    );

                    $qtyobattotal = $qtyobattotal+$dataobattmp->jumlah;
                    $hargaobattotal = $hargaobattotal+($dataobattmp->harga*$dataobattmp->jumlah);

                    $dataobatinsert = $dataobatloop;
                    $irow++;
                }

                $simpanKasir = array(
                    'KD_PEL_KASIR' => $kodekasir,
                    'KD_TARIF' =>  'AM',
                    'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
                    'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
                    'REFF' => $kodepelayanan,
                    'KD_PRODUK' => "TRA",
                    'KD_UNIT' => $this->input->post('kd_unit_hidden',TRUE),
                    'HARGA_PRODUK' => 0,
                    'TGL_BERLAKU' => date('Y-m-d'),
                    'QTY' => $qtyobattotal,
                    'TOTAL_HARGA' => $hargaobattotal
                );

                $db->insert_batch('pel_ord_obat',$dataobatinsert);
                $db->insert("pel_kasir_detail", $simpanKasir);
            }


            if($arraytindakan){
                $irow2=1;
                foreach($arraytindakan as $rowtindakanloop){
                    $datatindakantmp = json_decode($rowtindakanloop);
                    $datatindakanloop[] = array(
                        'KD_PELAYANAN' => $kodepelayanan,
                        'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
                        'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
                        'KD_TINDAKAN' => $datatindakantmp->kd_tindakan,
                        'QTY' => !empty($datatindakantmp->jumlah)?$datatindakantmp->jumlah:1,
                        'HRG_TINDAKAN' => $datatindakantmp->harga?$datatindakantmp->harga:0,
                        'KETERANGAN' => $datatindakantmp->keterangan,
                        'KD_PETUGAS' => $this->session->userdata('user_name'),
                        'iROW' => $irow2,
                        'TANGGAL' => date('Y-m-d'),
                        'Created_By' => $this->session->userdata('user_name'),
                        'Created_Date' => date('Y-m-d H:i:s')
                    );

                    $datainsertkasirdetailloop[]=array(
                        'KD_PEL_KASIR'=> $kodekasir,
                        'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
                        'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
                        'KD_PRODUK' => $datatindakantmp->kd_tindakan?$datatindakantmp->kd_tindakan:'',
                        'REFF' => $kodepelayanan,
                        'KD_UNIT' => $this->input->post('kd_unit_hidden',TRUE),
                        'KD_TARIF' => 'AM',
                        'HARGA_PRODUK' => $datatindakantmp->harga?$datatindakantmp->harga:0,
                        'QTY' => !empty($datatindakantmp->jumlah)?$datatindakantmp->jumlah:1,
                        'TOTAL_HARGA' => !empty($datatindakantmp->jumlah)?($datatindakantmp->harga*$datatindakantmp->jumlah):$datatindakantmp->harga,
                        'TGL_BERLAKU' => date('Y-m-d')
                    );

                    $datatindakaninsert = $datatindakanloop;
                    $datainsertkasirdetail = $datainsertkasirdetailloop;
                    $irow2++;
                }
                $db->insert_batch('pel_tindakan',$datatindakaninsert);
                $db->insert_batch('pel_kasir_detail',$datainsertkasirdetail);
            }

            if($arraydiagnosa){
                $irow3=1;
                foreach($arraydiagnosa as $rowdiagnosaloop){
                    $datadiagnosatmp = json_decode($rowdiagnosaloop);
                    $datadiagnosaloop[] = array(
                        'KD_PELAYANAN' => $kodepelayanan,
                        'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
                        'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
                        'KD_PENYAKIT' => $datadiagnosatmp->kd_penyakit,
                        'JNS_KASUS' => $datadiagnosatmp->jenis_kasus,
                        'JNS_DX' => $datadiagnosatmp->jenis_diagnosa,
                        'KD_PETUGAS' => $this->session->userdata('user_name'),
                        'iROW' => $irow3,
                        'TANGGAL' => date('Y-m-d'),
                        'Created_By' => $this->session->userdata('user_name'),
                        'Created_Date' => date('Y-m-d H:i:s')
                    );
                    $datadiagnosainsert = $datadiagnosaloop;
                    $irow3++;
                }
                $db->insert_batch('pel_diagnosa',$datadiagnosainsert);
            }

            //pel_kasir_detail
            //pel_kasir_detail_bayar

            $dataexc = array(
                'STATUS' => 1
                //'KD_UNIT' => 6
            );
            $db->where('ID_KUNJUNGAN',$this->input->post('kd_kunjungan_hidden',TRUE));
            $db->where('KD_PUSKESMAS',$this->input->post('kd_puskesmas_hidden',TRUE));
            $db->update('kunjungan',$dataexc);

            // konsul poli lain
//          $datainsert = insert ke table KUNJUNGAN
            $konsul=$this->input->post('konsulpoliklinik');
            if(!empty($konsul)){
                $datainsert = array(
                    'KD_PASIEN'=> $this->input->post('kd_pasien_hidden'),
                    'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
                    'KD_DOKTER' => $this->session->userdata('kd_petugas'),
                    'TGL_MASUK' => date('Y-m-d'),
                    'KD_UNIT_LAYANAN' => $this->input->post('unit_layanan_hidden',TRUE),
                    'KD_UNIT' => $this->input->post('konsulpoliklinik',TRUE),
                    'KD_LAYANAN_B' => 'RJ'
                );
                if($this->input->post('konsulpoliklinik')=='219'){
                    if($this->input->post('kategori_kia')=='1'){
                        $maxkia = $db->query("select max(kj.URUT_MASUK) as total from kunjungan kj join trans_kia tk on kj.ID_KUNJUNGAN=tk.ID_KUNJUNGAN where kj.KD_PUSKESMAS='".$puskesmas."' and kj.KD_UNIT='".$this->input->post('konsulpoliklinik',TRUE)."' and kj.TGL_MASUK= CURDATE()")->row();
                        $maxkia = $maxkia->total + 1;
                        $kdk1 = date('Y-m-d').'-'.'219'.'-'.$this->input->post('kategori_kia').'-'.$maxkia;
                        $datainsert['KD_KUNJUNGAN'] = $kdk1;
                        $datainsert['URUT_MASUK'] = $maxkia;
                        $dataexc_kesehatanibu['KD_PUSKESMAS'] =  $puskesmas;
                        $dataexc_kesehatanibu['KD_PASIEN'] = $this->input->post('kd_pasien_hidden',TRUE);
                        $dataexc_kesehatanibu['KD_DOKTER_PEMERIKSA'] = NULL;
                        $dataexc_kesehatanibu['KD_DOKTER_PETUGAS'] = NULL;
                        $dataexc_kesehatanibu['KD_KATEGORI_KIA'] = $this->input->post('kategori_kia');
                        $dataexc_kesehatanibu['KD_UNIT_PELAYANAN'] = $this->input->post('unit_layanan_hidden');
                        $dataexc_kesehatanibu['ninput_oleh'] = $this->session->userdata('user_name');
                        $dataexc_kesehatanibu['ninput_tgl'] = date('Y-m-d');

                        $data_insert_trans_kia = $dataexc_kesehatanibu;
                        // $db->insert('trans_kia', $dataexc_kesehatanibu);

                    }elseif($this->input->post('kategori_kia')=='2'){
                        $maxkia2 = $db->query("select max(kj.URUT_MASUK) as total from kunjungan kj join trans_kia tk on kj.ID_KUNJUNGAN=tk.ID_KUNJUNGAN where kj.KD_PUSKESMAS='".$puskesmas."' and kj.KD_UNIT='".$this->input->post('konsulpoliklinik',TRUE)."' and kj.TGL_MASUK= CURDATE()")->row();
                        $maxkia2 = $maxkia2->total + 1;
                        $kdk2 = date('Y-m-d').'-'.'219'.'-'.$this->input->post('kategori_kia').'-'.$maxkia2;
                        $datainsert['KD_KUNJUNGAN'] = $kdk2;
                        $datainsert['URUT_MASUK'] = $maxkia2;
                        $dataexc_kesehatanibu['KD_DOKTER_PEMERIKSA'] = NULL;
                        $dataexc_kesehatanibu['KD_DOKTER_PETUGAS'] = NULL;
                        $dataexc_kesehatanibu['KD_PASIEN'] =$this->input->post('kd_pasien_hidden');
                        $dataexc_kesehatanibu['KD_PUSKESMAS'] =$this->input->post('kd_puskesmas');
                        $dataexc_kesehatananak['KD_KATEGORI_KIA'] = $this->input->post('kategori_kia');
                        $dataexc_kesehatananak['KD_UNIT_PELAYANAN'] = $this->input->post('unit_layanan_hidden');
                        $dataexc_kesehatananak['ninput_oleh'] = $this->session->userdata('user_name');
                        $dataexc_kesehatananak['ninput_tgl'] = date('Y-m-d');

                        $data_insert_trans_kia = $dataexc_kesehatananak;
                        // $db->insert('trans_kia', $dataexc_kesehatananak);
                    }else{
                        $max3 = $db->query("select max(kj.URUT_MASUK) as total from kunjungan kj join trans_kia tk on kj.ID_KUNJUNGAN=tk.ID_KUNJUNGAN where kj.KD_PUSKESMAS='".$puskesmas."' and kj.KD_UNIT='".$this->input->post('konsulpoliklinik',TRUE)."' and kj.TGL_MASUK= CURDATE()")->row();
                        $max3 = $max3->total + 1;
                        $kdk = date('Y-m-d').'-219-3-'.$max3;
                        $datainsert['KD_KUNJUNGAN'] = $kdk;
                        $datainsert['URUT_MASUK'] = $max3;

                        $dataexc_kesehatanibu['KD_DOKTER_PEMERIKSA'] = NULL;
                        $dataexc_kesehatanibu['KD_DOKTER_PETUGAS'] = NULL;
                        $dataexc_kesehatanibu['KD_PASIEN'] =$this->input->post('kd_pasien_hidden');
                        $dataexc_kesehatanibu['KD_PUSKESMAS'] =$this->input->post('kd_puskesmas');
                        $kia['KD_KATEGORI_KIA'] = $this->input->post('kategori_kia');
                        $kia['KD_UNIT_PELAYANAN'] = $this->input->post('unit_layanan_hidden');
                        $kia['ninput_oleh'] = $this->session->userdata('user_name');
                        $kia['ninput_tgl'] = date('Y-m-d');

                        $data_insert_trans_kia = $kia;
                        // $db->insert('trans_kia', $kia);
                    }
                }else{
                    $max = $db->query("select max(URUT_MASUK) as total from kunjungan where KD_PUSKESMAS='".$puskesmas."' and KD_UNIT='".$this->input->post('konsulpoliklinik',TRUE)."' and TGL_MASUK= CURDATE() ")->row();
                    $max = $max->total + 1;
                    $kdk = date('Y-m-d').'-'.$this->input->post('konsulpoliklinik',TRUE).'-'.$max;

                    do{
                        $exist = $db->query("select * FROM kunjungan WHERE KD_KUNJUNGAN='$kdk' AND KD_PUSKESMAS='$puskesmas' and TGL_MASUK=CURDATE()")->row();
                        if(!empty($exist)){
                            $max = $max + 1;
                            $kdk = date('Y-m-d').'-'.$this->input->post('konsulpoliklinik',TRUE).'-'.$max;
                        }else{
                            $exist = null;
                        }
                    }while(!empty($exist));

                    $datainsert['KD_KUNJUNGAN'] = $kdk;
                    $datainsert['URUT_MASUK'] = $max;
                }
                $db->insert('kunjungan',$datainsert);
                $get_last_id_kunjungan = $db->insert_id();

                if($this->input->post('konsulpoliklinik')=='219'){
                    $data_insert_trans_kia['ID_KUNJUNGAN'] = $get_last_id_kunjungan;
                    $db->insert('trans_kia',$data_insert_trans_kia);
                }
            }

            //rujuk rs lain
            if($this->input->post('status_keluar')=='DIRUJUK'){
                $kd_ru = $puskesmas.rand(100000,999999);
                $datarujuk['KD_RUJUKAN'] = $kd_ru;
                $datarujuk['KD_PASIEN'] = $this->input->post('kd_pasien_hidden');
                $datarujuk['KD_PELAYANAN'] = $kodepelayanan;
                $datarujuk['KD_PUSKESMAS'] = $puskesmas;
                $datarujuk['POLI_RUJUKAN'] = $this->input->post('polirujuk');
                $datarujuk['RS_RUJUKAN'] = $this->input->post('rsrujuk');
                $datarujuk['ninput_oleh'] = $this->session->userdata('user_name');
                $datarujuk['ninput_tgl'] = date('Y-m-d');
                $db->insert('pel_rujuk_pasien',$datarujuk);
            }

            //CHECK JIKA UNIT = GIGI MAKA DI LAKUKAN PENGECEKAN, PASIEN SUDAH MELAKUKAN INPUT DIAGRAM GIGI ATAU BELUM


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

    public function rawatjalan()
    {
        $this->load->helper('beries_helper');
        $id=$this->input->get('id')?$this->input->get('id',TRUE):null;
        $id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
        $id3=$this->input->get('id3')?$this->input->get('id3',TRUE):null;
        $db = $this->load->database('sikda', TRUE);
        $db->select("NAMA_LENGKAP AS NAMA_PASIEN,p.KD_PASIEN,p.KD_PUSKESMAS,p.TGL_LAHIR,p.NO_PENGENAL AS NIK,p.KET_WIL,p.KD_GOL_DARAH,k.CUSTOMER,mu.UNIT,kj.ID_KUNJUNGAN,kj.KD_UNIT,kj.URUT_MASUK,p.NO_ASURANSI",FALSE);
        $db->from('pasien p');
        $db->join('mst_kel_pasien k','k.KD_CUSTOMER=p.KD_CUSTOMER');
        $db->join('kunjungan kj','kj.KD_PASIEN=p.KD_PASIEN');
        $db->join('mst_unit mu','mu.KD_UNIT=kj.KD_UNIT');
        $db->where('p.KD_PASIEN',$id);
        $db->where('kj.ID_KUNJUNGAN',$id3);
        $db->where('p.KD_PUSKESMAS',$id2);
        $val = $db->get()->row();

        $tindakanlist = $db->query("SELECT p.KD_PRODUK AS id,p.PRODUK AS label,
							CASE WHEN g.GOL_PRODUK IS NULL THEN '' ELSE g.GOL_PRODUK END AS category
							FROM mst_produk p LEFT JOIN mst_gol_produk g on p.KD_GOL_PRODUK=g.KD_GOL_PRODUK")->result_array();

        $data['dataproduktindakan']=json_encode($tindakanlist);
        echo $data['rawatjalan_id'];
        $data['data']=$val;
        $this->load->view('t_pelayanan/v_t_pelayanan_rawatjalan',$data);
    }

    public function rawatinap()
    {
        $this->load->helper('beries_helper');
        $id=$this->input->get('id')?$this->input->get('id',TRUE):null;
        $id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
        $db = $this->load->database('sikda', TRUE);
        $db->select("NAMA_LENGKAP AS NAMA_PASIEN,p.KD_PASIEN,p.KD_PUSKESMAS,p.TGL_LAHIR,p.NO_PENGENAL AS NIK,p.KET_WIL,p.KD_GOL_DARAH,k.CUSTOMER,mu.UNIT",FALSE);
        $db->from('pasien p');
        $db->join('mst_kel_pasien k','k.KD_CUSTOMER=p.KD_CUSTOMER');
        $db->join('kunjungan kj','kj.KD_PASIEN=p.KD_PASIEN');
        $db->join('mst_unit mu','mu.KD_UNIT=kj.KD_UNIT');
        $db->where('p.KD_PASIEN',$id);
        $db->where('p.KD_PUSKESMAS',$id2);
        $val = $db->get()->row();

        $tindakanlist = $db->query("SELECT p.KD_PRODUK AS id,p.PRODUK AS label, g.GOL_PRODUK AS category FROM mst_produk p LEFT JOIN mst_gol_produk g on p.KD_GOL_PRODUK=g.KD_GOL_PRODUK")->result_array();

        $data['data']=$val;
        $data['dataproduktindakan']=json_encode($tindakanlist);
        $this->load->view('t_pelayanan/v_t_pelayanan_rawatinap',$data);
    }

    public function icdsource()
    {
        $id=$this->input->get('term')?$this->input->get('term',TRUE):null;
        $db = $this->load->database('sikda', TRUE);
        $comboicd = $db->query("SELECT icd.KD_PENYAKIT AS id,icd.PENYAKIT AS label,
								CASE WHEN induk.ICD_INDUK IS NULL THEN '' ELSE induk.ICD_INDUK END  AS category FROM mst_icd icd LEFT JOIN 
								mst_icd_induk induk ON induk.KD_ICD_INDUK = icd.KD_ICD_INDUK where icd.PENYAKIT like '%".$id."%' or icd.KD_PENYAKIT like '%".$id."%' ")->result_array();
        die(json_encode($comboicd));
    }

    public function obatsource()
    {
        $id=$this->input->get('term')?$this->input->get('term',TRUE):null;
        $db = $this->load->database('sikda', TRUE);
        $comboicd = $db->query("SELECT obat.KD_OBAT AS id,IF((st.JUMLAH_STOK_OBAT IS NULL), concat(obat.NAMA_OBAT,' => Stok: 0',concat(' => Harga:',IF((hrg.HARGA_JUAL),hrg.HARGA_JUAL,0))), concat(obat.NAMA_OBAT,' => Stok: ',st.JUMLAH_STOK_OBAT,' => Harga:',hrg.HARGA_JUAL)) AS label,
								CASE WHEN induk.GOL_OBAT IS NULL THEN '' ELSE induk.GOL_OBAT END  AS category FROM apt_mst_obat obat 
								LEFT JOIN apt_mst_gol_obat induk ON induk.KD_GOL_OBAT = obat.KD_GOL_OBAT 
								LEFT JOIN apt_mst_harga_obat hrg ON hrg.KD_OBAT = obat.KD_OBAT 
								LEFT JOIN apt_stok_obat st ON st.KD_OBAT = obat.KD_OBAT and st.KD_PKM = '".$this->session->userdata('kd_puskesmas')."' and st.KD_MILIK_OBAT='PKM' and st.KD_UNIT_APT='APT'
								where obat.NAMA_OBAT like '%".$id."%' group by obat.KD_OBAT 
								 ",false)->result_array();
        die(json_encode($comboicd));
    }

    public function obatsourcepkm()
    {
        $id=$this->input->get('term')?$this->input->get('term',TRUE):null;
        $db = $this->load->database('sikda', TRUE);
        $kdpmobat = $this->session->userdata('level_aplikasi')=='KABUPATEN'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas');
        $kdmilik = $this->session->userdata('level_aplikasi')=='PUSKESMAS'?'PKM':$this->session->userdata('level_aplikasi');
        $comboicd = $db->query("SELECT obat.KD_OBAT AS id,IF((st.JUMLAH_STOK_OBAT IS NULL), concat(obat.NAMA_OBAT,' => Stok: 0',concat(' => Harga:',IF((hrg.HARGA_JUAL),hrg.HARGA_JUAL,0))), concat(obat.NAMA_OBAT,' => Stok: ',st.JUMLAH_STOK_OBAT,' => Harga:',hrg.HARGA_JUAL)) AS label,
								CASE WHEN induk.GOL_OBAT IS NULL THEN '' ELSE induk.GOL_OBAT END  AS category FROM apt_mst_obat obat 
								LEFT JOIN apt_mst_gol_obat induk ON induk.KD_GOL_OBAT = obat.KD_GOL_OBAT 
								LEFT JOIN apt_mst_harga_obat hrg ON hrg.KD_OBAT = obat.KD_OBAT 
								LEFT JOIN apt_stok_obat st ON st.KD_OBAT = obat.KD_OBAT and st.KD_PKM = '".$kdpmobat."' and st.KD_MILIK_OBAT='".$kdmilik."' and st.KD_UNIT_APT='".$this->session->userdata('level_aplikasi')."'
								where obat.NAMA_OBAT like '%".$id."%' group by obat.KD_OBAT 
								 ",false)->result_array();//die($db->last_query());
        die(json_encode($comboicd));
    }

    public function obatsource_alergi()
    {
        $id=$this->input->get('term')?$this->input->get('term',TRUE):null;
        $db = $this->load->database('sikda', TRUE);
        $comboicd = $db->query("SELECT obat.KD_OBAT AS id,obat.NAMA_OBAT AS label,
								CASE WHEN induk.GOL_OBAT IS NULL THEN '' ELSE induk.GOL_OBAT END  AS category FROM apt_mst_obat obat LEFT JOIN 
								apt_mst_gol_obat induk ON induk.KD_GOL_OBAT = obat.KD_GOL_OBAT where obat.NAMA_OBAT like '%".$id."%' ")->result_array();
        die(json_encode($comboicd));
    }

    public function obatsource_lab()
    {
        $id=$this->input->get('term')?$this->input->get('term',TRUE):null;
        $db = $this->load->database('sikda', TRUE);
        $comboicd = $db->query("select KD_PRODUK as id,concat(PRODUK,' => harga: ',HARGA_PRODUK) as label, 'Pilih Layanan lab' as category, SINGKATAN, HARGA_PRODUK from vw_lst_laboratorium where PRODUK like '%".$id."%' ")->result_array();
        die(json_encode($comboicd));
    }
    // Subgrid Pelayanan Dari Amink //
    public function t_subgridpelayanankia()
    {
        $this->load->model('t_pelayanan_model');

        $limit = $this->input->post('rows')?$this->input->post('rows'):10;

        $paramstotal=array(
            'kd_pasien'=>$this->input->post('kd_pasien'),
            'kd_puskesmas'=>$this->input->post('kd_puskesmas')
        );

        $total = $this->t_pelayanan_model->totalsubgridpeltranskia($paramstotal);

        $total_pages = ($total >0)?ceil($total/$limit):1;
        $page = $this->input->post('page')?$this->input->post('page'):1;
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit;

        $params=array(
            'start'=>$start,
            'limit'=>$limit,
            'sort'=>$this->input->post('asc'),
            'kd_pasien'=>$this->input->post('kd_pasien'),
            'kd_puskesmas'=>$this->input->post('kd_puskesmas'),
            'kd_kunjungan'=>$this->input->post('kd_kunjungan'),
            'kd_pelayanan'=>$this->input->post('kd_pelayanan')
        );

        $result = $this->t_pelayanan_model->getsubgridpeltranskia($params);

        header("Content-type: text/xml");
        echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
    }

    public function diagnosarawatjalan_xml()
    {
        $this->load->model('t_pelayanan_model');

        $limit = $this->input->post('rows')?$this->input->post('rows'):5;

        $paramstotal=array(
            'id1'=>$this->input->post('myid1'),
            'idpuskesmas'=>$this->input->post('idpuskesmas')
        );

        $total = $this->t_pelayanan_model->totalDiagnosarawatjalan($paramstotal);

        $total_pages = ($total >0)?ceil($total/$limit):1;
        $page = $this->input->post('page')?$this->input->post('page'):1;
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit;

        $params=array(
            'start'=>$start,
            'limit'=>$limit,
            'sort'=>$this->input->post('asc'),
            'id1'=>$this->input->post('myid1'),
            'idpuskesmas'=>$this->input->post('idpuskesmas')
        );

        $result = $this->t_pelayanan_model->getDiagnosarawatjalan($params);

        header("Content-type: text/xml");
        echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
    }

    public function tindakanrawatjalan_xml()
    {
        $this->load->model('t_pelayanan_model');

        $limit = $this->input->post('rows')?$this->input->post('rows'):5;

        $paramstotal=array(
            'id2'=>$this->input->post('myid2'),
            'idpuskesmas'=>$this->input->post('idpuskesmas')
        );

        $total = $this->t_pelayanan_model->totalTindakanrawatjalan($paramstotal);

        $total_pages = ($total >0)?ceil($total/$limit):1;
        $page = $this->input->post('page')?$this->input->post('page'):1;
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit;

        $params=array(
            'start'=>$start,
            'limit'=>$limit,
            'sort'=>$this->input->post('asc'),
            'id2'=>$this->input->post('myid2'),
            'idpuskesmas'=>$this->input->post('idpuskesmas')
        );

        $result = $this->t_pelayanan_model->getTindakanrawatjalan($params);

        header("Content-type: text/xml");
        echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
    }

    public function alergirawatjalan_xml()
    {
        $this->load->model('t_pelayanan_model');

        $limit = $this->input->post('rows')?$this->input->post('rows'):5;

        $paramstotal=array(
            'id3'=>$this->input->post('myid3'),
            'idpuskesmas'=>$this->input->post('idpuskesmas')
        );

        $total = $this->t_pelayanan_model->totalAlergirawatjalan($paramstotal);

        $total_pages = ($total >0)?ceil($total/$limit):1;
        $page = $this->input->post('page')?$this->input->post('page'):1;
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit;

        $params=array(
            'start'=>$start,
            'limit'=>$limit,
            'sort'=>$this->input->post('asc'),
            'id3'=>$this->input->post('myid3'),
            'idpuskesmas'=>$this->input->post('idpuskesmas')
        );

        $result = $this->t_pelayanan_model->getAlergirawatjalan($params);

        header("Content-type: text/xml");
        echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
    }

    public function obatrawatjalan_xml()
    {
        $this->load->model('t_pelayanan_model');

        $limit = $this->input->post('rows')?$this->input->post('rows'):5;

        $paramstotal=array(
            'id4'=>$this->input->post('myid4'),
            'idpuskesmas'=>$this->input->post('idpuskesmas')
        );

        $total = $this->t_pelayanan_model->totalObatrawatjalan($paramstotal);

        $total_pages = ($total >0)?ceil($total/$limit):1;
        $page = $this->input->post('page')?$this->input->post('page'):1;
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit;

        $params=array(
            'start'=>$start,
            'limit'=>$limit,
            'sort'=>$this->input->post('asc'),
            'id4'=>$this->input->post('myid4'),
            'idpuskesmas'=>$this->input->post('idpuskesmas')
        );

        $result = $this->t_pelayanan_model->getObatrawatjalan($params);

        header("Content-type: text/xml");
        echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
    }

    public function diagnosarawatinap_xml()
    {
        $this->load->model('t_pelayanan_model');

        $limit = $this->input->post('rows')?$this->input->post('rows'):5;

        $paramstotal=array(
            'id1'=>$this->input->post('myid1'),
            'idpuskesmas'=>$this->input->post('idpuskesmas')
        );

        $total = $this->t_pelayanan_model->totalDiagnosarawatinap($paramstotal);

        $total_pages = ($total >0)?ceil($total/$limit):1;
        $page = $this->input->post('page')?$this->input->post('page'):1;
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit;

        $params=array(
            'start'=>$start,
            'limit'=>$limit,
            'sort'=>$this->input->post('asc'),
            'id1'=>$this->input->post('myid1'),
            'idpuskesmas'=>$this->input->post('idpuskesmas')
        );

        $result = $this->t_pelayanan_model->getDiagnosarawatinap($params);

        header("Content-type: text/xml");
        echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
    }

    public function tindakanrawatinap_xml()
    {
        $this->load->model('t_pelayanan_model');

        $limit = $this->input->post('rows')?$this->input->post('rows'):5;

        $paramstotal=array(
            'id2'=>$this->input->post('myid2'),
            'idpuskesmas'=>$this->input->post('idpuskesmas')
        );

        $total = $this->t_pelayanan_model->totalTindakanrawatinap($paramstotal);

        $total_pages = ($total >0)?ceil($total/$limit):1;
        $page = $this->input->post('page')?$this->input->post('page'):1;
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit;

        $params=array(
            'start'=>$start,
            'limit'=>$limit,
            'sort'=>$this->input->post('asc'),
            'id2'=>$this->input->post('myid2'),
            'idpuskesmas'=>$this->input->post('idpuskesmas')
        );

        $result = $this->t_pelayanan_model->getTindakanrawatinap($params);

        header("Content-type: text/xml");
        echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
    }

    public function alergirawatinap_xml()
    {
        $this->load->model('t_pelayanan_model');

        $limit = $this->input->post('rows')?$this->input->post('rows'):5;

        $paramstotal=array(
            'id3'=>$this->input->post('myid3'),
            'idpuskesmas'=>$this->input->post('idpuskesmas')
        );

        $total = $this->t_pelayanan_model->totalAlergirawatinap($paramstotal);

        $total_pages = ($total >0)?ceil($total/$limit):1;
        $page = $this->input->post('page')?$this->input->post('page'):1;
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit;

        $params=array(
            'start'=>$start,
            'limit'=>$limit,
            'sort'=>$this->input->post('asc'),
            'id3'=>$this->input->post('myid3'),
            'idpuskesmas'=>$this->input->post('idpuskesmas')
        );

        $result = $this->t_pelayanan_model->getAlergirawatinap($params);

        header("Content-type: text/xml");
        echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
    }

    public function obatrawatinap_xml()
    {
        $this->load->model('t_pelayanan_model');

        $limit = $this->input->post('rows')?$this->input->post('rows'):5;

        $paramstotal=array(
            'id4'=>$this->input->post('myid4'),
            'idpuskesmas'=>$this->input->post('idpuskesmas')
        );

        $total = $this->t_pelayanan_model->totalObatrawatinap($paramstotal);

        $total_pages = ($total >0)?ceil($total/$limit):1;
        $page = $this->input->post('page')?$this->input->post('page'):1;
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit;

        $params=array(
            'start'=>$start,
            'limit'=>$limit,
            'sort'=>$this->input->post('asc'),
            'id4'=>$this->input->post('myid4'),
            'idpuskesmas'=>$this->input->post('idpuskesmas')
        );

        $result = $this->t_pelayanan_model->getObatrawatinap($params);

        header("Content-type: text/xml");
        echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
    }


    public function check ()
    {

        $this->load->helper('ernes_helper');
        $this->load->helper('beries_helper');
        $this->load->helper('my_helper');
        $this->load->helper('master_helper');
        $this->load->helper('sigit_helper');
        $this->load->helper('jokos_helper');
        $this->load->helper('pemkes_helper');
        $id=$this->input->get('id')?$this->input->get('id',TRUE):null;
        $id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
        $id3=$this->input->get('id3')?$this->input->get('id3',TRUE):null;
        $db = $this->load->database('sikda', TRUE);
        $tindakanlist = $db->query("SELECT p.KD_PRODUK AS id,CONCAT(p.PRODUK,' => Harga:',p.HARGA_PRODUK) AS label,
							CASE WHEN g.GOL_PRODUK IS NULL THEN '' ELSE g.GOL_PRODUK END AS category
							FROM mst_produk p LEFT JOIN mst_gol_produk g on p.KD_GOL_PRODUK=g.KD_GOL_PRODUK")->result_array(); //print_r($tindakanlist);die;

        $data['dataproduktindakan']=json_encode($tindakanlist);
        $kdunit = $db->query("select KD_UNIT from kunjungan where ID_KUNJUNGAN='".$id3."'")->row();
        if($kdunit->KD_UNIT==219){
            $unit = $db->query("select * from trans_kia where ID_KUNJUNGAN='".$id3."'")->row();//print_r($unit);die;

            // View Detail Kunjungan Ibu Hamil
            if($unit->KD_KATEGORI_KIA==1 AND $unit->KD_KUNJUNGAN_KIA==1){
                $db->select('a.*,b.ID_KUNJUNGAN,b.KD_PELAYANAN,e.KD_PASIEN,c.STATUS_HAMIL,d.LETAK_JANIN,b.KD_DOKTER_PEMERIKSA AS DOKTER,b.KD_DOKTER_PETUGAS AS PETUGAS,g.CATATAN_APOTEK,g.CATATAN_DOKTER', false);
                $db->from('kunjungan_bumil a');
                $db->join('trans_kia b','a.KD_KIA=b.KD_KIA');
                $db->join('pelayanan e','b.KD_PELAYANAN=e.KD_PELAYANAN');
                $db->join('mst_status_hamil c','c.KD_STATUS_HAMIL=a.KD_STATUS_HAMIL');
                $db->join('mst_letak_janin d','d.KD_LETAK_JANIN=a.KD_LETAK_JANIN');
                $db->join('check_coment g','b.KD_PELAYANAN=g.KD_PELAYANAN');
                $db->where('b.ID_KUNJUNGAN',$id3);
                $val = $db->get()->row();
                $data['data']=$val;//print_r($db->last_query());die;
                $this->load->view('t_pelayanan/kunjungan_edit/v_t_kunjungan_ibu_hamil_edit',$data);

                // View Detail Kunjungan Bersalin //
            }elseif($unit->KD_KATEGORI_KIA==1 AND $unit->KD_KUNJUNGAN_KIA==2){
                $db->select("*");
                $db->from('vw_detail_bersalin');
                $db->where('ID_KUNJUNGAN' ,$id3);
                $val = $db->get()->row();
                $data['data']=$val;//print_r($db->last_query());die;
                if(!empty($val)){
                    $this->load->view('t_pelayanan/kunjungan_edit/v_t_kunjungan_ibu_bersalin_edit',$data);
                }else{
                    echo("<script type='text/javascript'> message();</script>");
                    $this->load->view('t_pelayanan/v_pelayanan');
                }

                // View Detail Kunjungan Nifas //
            }elseif($unit->KD_KATEGORI_KIA==1 AND $unit->KD_KUNJUNGAN_KIA==3){
                $db->select("u.*,k.ID_KUNJUNGAN,k.KD_PELAYANAN,t.KD_PASIEN,k.KD_DOKTER_PEMERIKSA  as PEMERIKSA,k.KD_DOKTER_PETUGAS  as PETUGAS,g.CATATAN_APOTEK,g.CATATAN_DOKTER", false);
                $db->from('kunjungan_nifas u');
                $db->join('trans_kia k', 'u.KD_KIA=k.KD_KIA');
                $db->join('pelayanan t', 'k.KD_PELAYANAN=t.KD_PELAYANAN');
                $db->join('check_coment g','k.KD_PELAYANAN=g.KD_PELAYANAN');
                $db->where('k.ID_KUNJUNGAN ',$id3);
                $val = $db->get()->row();//echo print_r($val);die;
                $data['data']=$val;
                if(!empty($val)){
                    $this->load->view('t_pelayanan/kunjungan_edit/v_t_kunjungan_nifas_edit',$data);
                }else{
                    echo("<script type='text/javascript'> message();</script>");
                    $this->load->view('t_pelayanan/v_pelayanan');
                }

                // View Detail Kunjungan KB //
            }elseif($unit->KD_KATEGORI_KIA==1 AND $unit->KD_KUNJUNGAN_KIA==4){
                $db->select("a.*, b.ID_KUNJUNGAN, b.KD_PELAYANAN, c.KD_PASIEN, b.KD_DOKTER_PEMERIKSA as PEMERIKSA, b.KD_DOKTER_PETUGAS as PETUGAS, f.JENIS_KB,g.CATATAN_APOTEK,g.CATATAN_DOKTER", false);
                $db->from('kunjungan_kb a');
                $db->join('trans_kia b','a.KD_KIA=b.KD_KIA');
                $db->join('pelayanan c','b.KD_PELAYANAN=c.KD_PELAYANAN');
                $db->join('mst_jenis_kb f','a.KD_JENIS_KB=f.KD_JENIS_KB');
                $db->join('check_coment g','b.KD_PELAYANAN=g.KD_PELAYANAN');
                $db->where('b.ID_KUNJUNGAN',$id3);
                $val = $db->get()->row();//print_r($db->last_query());die;
                $data['data']=$val;
                $this->load->view('t_pelayanan/kunjungan_edit/v_t_pelayanan_kb_edit',$data);

                // View Detail Kunjungan Neonatus //
            }elseif($unit->KD_KATEGORI_KIA==2 AND $unit->KD_KUNJUNGAN_KIA==1){ //print_r($unit);die;
                $db->select("a.*,b.ID_KUNJUNGAN,b.KD_PELAYANAN,c.KD_PASIEN,b.KD_DOKTER_PEMERIKSA as PEMERIKSA,b.KD_DOKTER_PETUGAS as PETUGAS,g.CATATAN_APOTEK,g.CATATAN_DOKTER", false );
                $db->from('pemeriksaan_neonatus a');
                $db->join('trans_kia b', 'a.KD_KIA=b.KD_KIA','left');
                $db->join('pelayanan c', 'b.KD_PELAYANAN=c.KD_PELAYANAN','left');
                $db->join('check_coment g','b.KD_PELAYANAN=g.KD_PELAYANAN');
                $db->where('b.ID_KUNJUNGAN',$id3);//print_r($id);die;
                $val = $db->get()->row();//print_r($db->last_query());die;
                $data['data']=$val; //print_r($data);die;
                if(!empty($val)){
                    $this->load->view('t_pelayanan/kunjungan_edit/v_t_pemeriksaan_neonatus_edit',$data);
                }else{
                    echo("<script type='text/javascript'> message();</script>");
                    $this->load->view('t_pelayanan/v_pelayanan');
                }

                // View Detail Kunjungan Kesehatan Anak // query masih salah
            }elseif($unit->KD_KATEGORI_KIA==2 AND $unit->KD_KUNJUNGAN_KIA==2){
                $db->select("a.*,c.KD_PASIEN,b.ID_KUNJUNGAN,b.KD_PELAYANAN,b.KD_DOKTER_PEMERIKSA AS DOKTER,b.KD_DOKTER_PETUGAS AS PETUGAS,g.CATATAN_APOTEK,g.CATATAN_DOKTER",false);
                $db->from('pemeriksaan_anak a');
                $db->join('trans_kia b','a.KD_KIA=b.KD_KIA');
                $db->join('pelayanan c','b.KD_PELAYANAN=c.KD_PELAYANAN');
                $db->join('check_coment g','b.KD_PELAYANAN=g.KD_PELAYANAN');
                $db->where('b.ID_KUNJUNGAN',$id3);
                $val = $db->get()->row();
                $data['data']=$val;
                if(!empty($val)){
                    $this->load->view('t_pelayanan/kunjungan_edit/v_t_pemeriksaan_kesehatan_anak_edit',$data);
                }else{
                    echo("<script type='text/javascript'> message();</script>");
                    $this->load->view('t_pelayanan/v_pelayanan');
                }
            }
        }else{
            $val = $db->query("select * from kunjungan where ID_KUNJUNGAN='".$id3."'")->row();//print_r($val);die;
            if($val->KD_LAYANAN_B=='RJ'){
                //Detail Kunjungan Rawat Jalan //
                $db->select ("*",false);
                $db->from("vw_detail_rawat_jalan");
                $db->where('ID_KUNJUNGAN', $id3);
                $val = $db->get()->row();//print_r($db->last_query());die;
                $data['data']=$val;
                $data['datacat']=$db->query("select * from check_coment where KD_PELAYANAN='".$val->KD_PELAYANAN."'")->row();
                $this->load->view('t_pelayanan/kunjungan_edit/v_t_pelayanan_rawatjalan_edit',$data);
            }elseif($val->KD_LAYANAN_B=='RI'){
                //Detail Kunjungan Rawat Inap //
                $db->select ("*",false);
                $db->from('vw_detail_rawat_inap');
                $db->where('ID_KUNJUNGAN', $id3);
                $val = $db->get()->row();
                $data['data']=$val;
                $this->load->view('t_pelayanan/kunjungan_edit/v_t_pelayanan_rawatinap_edit',$data);
            }else{
                //Detail Kunjungan UGD //
                //$this->load->view('t_pelayanan/kunjungan_edit/v_t_pelayanan_ugd_detail',$data);
                $this->load->view('t_pelayanan/kunjungan_edit/v_t_pelayanan_rawatjalan_edit',$data);
            }
        }

    }

    function umurhamil(){
        $hpht = $this->input->get('hpht');
        if($hpht){
            $umr = floor(strtotime(date('d-m-Y'))-strtotime($hpht))/86400;
            $umur = floor((int)$umr/7);
            print_r($umur);
        }else{
            print_r(0);
        }
    }

   function gethpl(){
        $hpht = $this->input->get('hpht');
        if($hpht){
			$hpht = strtotime($hpht);
            $hpl = date('d-m-Y',strtotime('+10 days, -3 months, +1 year',$hpht));
            print_r($hpl);
        }else{
            print_r(0);
        }
    }
}

/* End of file t_pelayanan.php */
/* Location: ./application/controllers/t_pelayanan.php */
