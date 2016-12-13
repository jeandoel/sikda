<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_gigi_pasien extends CI_Controller {

	private $DIR_GIGI = './assets/images/gigi_pasien/';		

	public function index(){
		$pasien = $this->input->post('pasien_id', TRUE);
		$puskesmas = $this->input->post('puskesmas_id', TRUE);
		$petugas = $this->input->post('petugas_id', TRUE);
		$this->load->view('t_gigi_pasien/v_t_gigi_pasien.php', array('pasien_id'=>$pasien, 'petugas_id'=>$petugas, 'puskesmas_id'=>$puskesmas));
	}
	public function foto(){
		$this->load->view('t_gigi_pasien/foto/foto_main.php');
	}
	public function foto_preview(){
		$this->load->view('t_gigi_pasien/foto/foto_preview.php');
	}
	public function table_foto_pasien($views){
		$this->load->view('t_gigi_pasien/foto/'.$views);
	}
	public function masterXml($models)
	{
		$this->load->model($models);
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'tanggal'=>$this->input->post('tanggal'),
					'pasien'=>$this->input->post('pasien'),
					'puskesmas'=>$this->input->post('puskesmas')
					);
					
		$total = $this->$models->totalMaster($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'tanggal'=>$this->input->post('tanggal'),
					'pasien'=>$this->input->post('pasien'),
					'puskesmas'=>$this->input->post('puskesmas')
					);
					
		$result = $this->$models->getMaster($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}

	public function add($types, $tipe_foto)
	{
		$pasien=$this->input->get('kd_pasien')?$this->input->get('kd_pasien',TRUE):null;
		$puskesmas=$this->input->get('kd_puskesmas')?$this->input->get('kd_puskesmas',TRUE):null;
		$this->load->view('t_gigi_pasien/foto/foto_gigi_pasien_add', array('types'=>$types, 'tipe_foto'=>$tipe_foto, 'kd_pasien'=>$pasien, 'kd_puskesmas'=>$puskesmas));
	}
	
	public function addprocess()
	{
		$id = $this->input->post('kd_foto_gigi',TRUE);
		$gambar = $this->input->post('gambar', TRUE);
		$types = $this->input->post('types',TRUE);	
		$pasien = $this->input->post('kd_pasien', TRUE);
		$puskesmas = $this->input->post('kd_puskesmas', TRUE);

        if($types == 1){
            $types_foto = 'oral';
        }else{
        	$types_foto = 'xray';
        }

		//get date now
		$this->load->model('m_migration');
        $date_now = Date('dmY');

        if(empty($id)){
    	    $lastId = $this->m_migration->getAI('t_foto_gigi_pasien');
	        $re_image = $date_now.$lastId;
        }else{
        	$re_image = $this->input->post('gambar');
        }
        $config['upload_path'] = './assets/images/gigi_pasien/'.$types_foto.'/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['maintain_ratio'] = TRUE;
        $config['max_size']	= '1024';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';
        $config['file_name'] = $re_image;
        $config['overwrite'] = true;

        $this->load->library('upload', $config);
		$isUpload = !empty($_FILES['gambar']['name']);	


		if(empty($id) && !$isUpload){
			sendHeader("Gambar harus diisi");
			sendHeader("1","error_code");
			die();
		}else if($isUpload && ! $this->upload->do_upload('gambar')){
			sendHeader($this->upload->display_errors());
			sendHeader("1","error_code");
			die();			
		}
		else
		{		
			$db = $this->load->database('sikda', TRUE);
			$db->trans_begin();

            if($isUpload){
            	$image = $this->upload->data();
            	if(empty($id)){
        			$re_image .= $image['file_ext'];
        		}
            }

            $dataexc = array(
            	'tipe_foto' => $types
			);
				
			if(empty($id)){
				$dataexc['gambar'] = $re_image;
				$dataexc['kd_pasien'] = $pasien;
				$dataexc['kd_puskesmas'] = $puskesmas;
			
				$db->insert('t_foto_gigi_pasien', $dataexc);
			}else{
				if($isUpload){
					$dataexc['gambar'] = $re_image;
				}
				$db->where('kd_foto_gigi',$id);
				$db->update('t_foto_gigi_pasien', $dataexc);
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
				if(empty($id)){
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
		$this->load->view('t_gigi_pasien/foto/foto_gigi_pasien_edit',$data);//print_r($data);die();
	}
	
	public function delete($types)
	{
		$kd_foto_gigi=$this->input->post('kd_foto_gigi')?$this->input->post('kd_foto_gigi',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$temp = $db->query("select * from t_foto_gigi_pasien where kd_foto_gigi = '".$kd_foto_gigi."'")->row();
		$oldImage = $this->DIR_GIGI.$types.'/'.$temp->GAMBAR;
		if(file_exists(@$oldImage)){
			unlink($oldImage);
		}
		if($db->query("delete from t_foto_gigi_pasien where kd_foto_gigi = '".$kd_foto_gigi."'")){	
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}


	public function diagram(){
		$this->load->view('t_gigi_pasien/diagram/diagram_main.php');
	}
}