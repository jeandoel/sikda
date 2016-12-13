<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_map_gigi_permukaan extends CI_Controller {

	private $DIR_GIGI = './assets/images/map_gigi_permukaan/';

	public function index()
	{
		$this->load->view('mapGigipermukaan/v_map_gigi_permukaan');
	}

	public function masterPopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('mapGigipermukaan/v_map_pop',$data);
	}
	
	public function masterXml($for_dialog=NULL)
	{
		$this->load->model('m_map_gigi_permukaan');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'sort'=>$this->input->post('asc'),
					'kd_status_gigi'=>$this->input->post('kd_status_gigi'),
					'status_gigi'=>$this->input->post('status'),
					'kode'=>$this->input->post('kode'),
					'for_dialog'=>$for_dialog
					);
					
		$total = $this->m_map_gigi_permukaan->totalMaster($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'kd_status_gigi'=>$this->input->post('kd_status_gigi'),
					'status_gigi'=>$this->input->post('status'),
					'kode'=>$this->input->post('kode'),
					'for_dialog'=>$for_dialog
					);
					
		$result = $this->m_map_gigi_permukaan->getMaster($params);	
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('mapGigipermukaan/v_map_gigi_add');
	}
	
	public function addprocess()
	{
		$id = $this->input->post('kd',TRUE);
		$id_status_gigi = $this->input->post('id_status_gigi',TRUE);	
		$id_kd_gigi_permukaan = $this->input->post('kd_gigi_permukaan',TRUE);		

		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kd_status_gigi', 'Status Gigi', 'trim|required|xss_clean|min_length[1]');
		$val->set_rules('kode_id', 'Kode Permukaan Gigi', 'trim|required|xss_clean|min_length[1]');
		$val->set_rules('gambar', 'Gambar Gigi');
		$val->set_message('required', "Silahkan isi field \"%s\"");


        $config['upload_path'] = './assets/images/map_gigi_permukaan';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']	= '1024';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';
        $this->load->library('upload', $config);

		$db = $this->load->database('sikda', TRUE);
		//check dengan kd status gigi dan kd permukaan gigi jika ada di dalam database
		$checking_kode = $db->query("select * from map_gigi_permukaan where id_status_gigi = '".$id_status_gigi."' and kd_gigi_permukaan = '".$id_kd_gigi_permukaan."'")->row();

		$isUpload = !empty($_FILES['gambar']['name']);	

		if ($val->run() == FALSE)
		{
			$val->set_error_delimiters('<div style="color:white">', '</div>');
			die(validation_errors());
		}else if(!empty($checking_kode) && empty($id)){
			$val->set_error_delimiters('<div style="color:white">', '</div>');
			die("kode sudah digunakan. Gunakan kode lain.");
		}else if( !empty($checking_kode) && $checking_kode->ID != $id){
			$val->set_error_delimiters('<div style="color:white">', '</div>');
			die("kode sudah digunakan. Gunakan kode lain.");
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
				$temp = $db->query("select * from map_gigi_permukaan where id = '".$id."'")->row();
				$oldImage = $this->DIR_GIGI.$temp->GAMBAR;

				if(file_exists(@$oldImage)){
    				unlink($oldImage);
				}	
            }

            if($isUpload){
            	$image = $this->upload->data();
            }

            $dataexc = array(
            	'id_status_gigi' => $id_status_gigi,
				'kd_gigi_permukaan' => $id_kd_gigi_permukaan
			);

			if(empty($id)){
				$dataexc['gambar'] = $image['file_name'];
				$db->insert('map_gigi_permukaan', $dataexc);
			}else{
				if($isUpload){
					$dataexc['gambar'] = $image['file_name'];
				}
				$db->where('id',$id);
				$db->update('map_gigi_permukaan', $dataexc);
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
		$main_id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		// $db = $this->load->database('sikda', TRUE);
		// $val = $db->query("select * from map_gigi_permukaan where id = '".$main_id."'")->row();
		// $data['data']=$val;
		$this->db = $this->load->database('sikda', TRUE);
		$this->db->select('*');
		$this->db->select('mp.GAMBAR as map_gambar', false);
		$this->db->from('map_gigi_permukaan mp');
		$this->db->join('mst_gigi_status mgs','mgs.id_status_gigi = mp.id_status_gigi');
		$this->db->join('mst_gigi_permukaan mgp','mgp.kd_gigi_permukaan = mp.kd_gigi_permukaan');
		$this->db->where('mp.id', $main_id);
		$data['data'] = $this->db->get()->row();
		return $data;
	}
	
	public function edit()
	{
		$data = $this->getEditData();
		$this->load->view('mapGigipermukaan/v_map_gigi_edit',$data);//print_r($data);die();
	}

	public function detail()
	{
		$data = $this->getEditData();
		$this->load->view('mapGigipermukaan/v_map_gigi_detail',$data);
	}
	
	public function delete()
	{
		$main_id=$this->input->post('id')?$this->input->post('id',TRUE):null;

		$db = $this->load->database('sikda', TRUE);
		$temp = $db->query("select * from map_gigi_permukaan where id = '".$main_id."'")->row();
		$oldImage = $this->DIR_GIGI.$temp->GAMBAR;
		if(file_exists(@$oldImage)){
			unlink($oldImage);
		}
		if($db->query("delete from map_gigi_permukaan where id = '".$main_id."'")){	
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
}

/* End of file c_master_asal_pasien.php */
/* Location: ./application/controllers/c_master_asal_pasien.php */