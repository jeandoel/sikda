<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_kabupaten extends CI_Controller {
	public function index()
	{
		$this->load->view('masterKabupaten/v_master_kabupaten');
	}
	
	public function masterkabupatenpopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$data['idprov'] = $this->input->get('kd_prov')?$this->input->get('kd_prov',TRUE):null;
		$this->load->view('masterKabupaten/v_master_kabupaten_popup',$data);
	}
	
	public function masterkabupatenxml()
	{
		$this->load->model('m_master_kabupaten');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai')
					);
					
		$total = $this->m_master_kabupaten->totalmasterkabupaten($paramstotal);
		
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
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('idprov')
					);
					
		$result = $this->m_master_kabupaten->getmasterkabupaten($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterKabupaten/v_master_kabupaten_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kode_kab', 'Kode Kabupaten', 'trim|required|xss_clean|min_length[4]|max_length[5]');
		$val->set_rules('master_propinsi_id_column', 'Kode Provinsi', 'trim|required|xss_clean');
		$val->set_rules('nama_kabupaten', 'Kabupaten', 'trim|required|xss_clean|min_length[2]');
				
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
				'KD_KABUPATEN' => $val->set_value('kode_kab'),
				'KD_PROVINSI' => $val->set_value('master_propinsi_id_column'),
				'KABUPATEN' => $val->set_value('nama_kabupaten'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('mst_kabupaten', $dataexc);
			
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
		$id = $this->input->post('id',TRUE);		
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kode_kab', 'Kode Kabupaten', 'trim|required|xss_cleanmin_length[4]|max_length[5]');
		$val->set_rules('master_propinsi_id_column', 'Kode Provinsi', 'trim|required|xss_clean');
		$val->set_rules('nama_kabupaten', 'Kabupaten', 'trim|required|xss_clean|min_length[2]');
		
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
				'KD_KABUPATEN' => $val->set_value('kode_kab'),
				'KD_PROVINSI' => $val->set_value('master_propinsi_id_column'),
				'KABUPATEN' => $val->set_value('nama_kabupaten'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('KD_KABUPATEN',$id);
			$db->update('mst_kabupaten', $dataexc);
			
			//update in other table
			$get_kab =$val->set_value('kode_kab');
			$db->query("update sys_setting SET PUSKESMAS ='$get_kab' where PUSKESMAS = '$id' "); //sys_setting
			//SARANA
			$db->query("update trans_sarana SET ASAL_SARANA ='$get_kab' where ASAL_SARANA = '$id' "); //trans_sarana
			$db->query("update apt_sarana SET KD_PEMILIK_DATA ='$get_kab' where KD_PEMILIK_DATA = '$id' "); //apt_sarana
			$db->query("update apt_sarana SET KD_TEMPAT_ASAL ='$get_kab' where KD_TEMPAT_ASAL = '$id' "); //apt_sarana - kd_tempat_asal
			$db->query("update apt_sarana_detail SET KD_PEMILIK_DATA ='$get_kab' where KD_PEMILIK_DATA = '$id' "); //apt_sarana_detail
			//--------------------------END------------------------//

			//OBAT
			$db->query("update apt_obat_terima SET KD_PKM ='$get_kab' where KD_PKM = '$id' "); //apt_obat_terima
			$db->query("update apt_stok_obat SET KD_PKM ='$get_kab' where KD_PKM = '$id' "); //apt_stok_obat
			$db->query("update apt_obat_keluar SET KD_PKM ='$get_kab' where KD_PKM = '$id' "); //apt_obat_keluar

			//---------------END------------------------------------//
			if ($db->trans_status() === FALSE)
			{
				$db->trans_rollback();
				die('Maaf Proses Update Data Gagal');
			}
			else
			{
				$db->trans_commit();
				die('OK');
			}
		}
	}
	
	public function edit()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select('a.*,b.PROVINSI');
		$db->from('mst_kabupaten a');
		$db->join('mst_provinsi b','b.KD_PROVINSI=a.KD_PROVINSI');
		$db->where('KD_KABUPATEN', $id);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('masterKabupaten/v_master_kabupaten_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->trans_begin();

		$db->query("delete from mst_kabupaten where KD_KABUPATEN ='".$id."'"); //mst_kabupaten
		$db->query("delete from sys_setting where PUSKESMAS ='".$id."'"); //sys_setting
		//SARANA
		$db->query("delete from trans_sarana where ASAL_SARANA ='".$id."'"); //trans_sarana
		$db->query("delete from apt_sarana where KD_PEMILIK_DATA ='".$id."'"); //apt_sarana
		$db->query("delete from apt_sarana_detail where KD_PEMILIK_DATA ='".$id."'"); //apt_sarana_detail
		//-----------------------------END------------//

		//OBAT
		$db->query("delete from apt_obat_terima where KD_PKM ='".$id."'"); //apt_obat_terima
		$db->query("delete from apt_stok_obat where KD_PKM ='".$id."'"); //apt_stok_obat
		$db->query("delete from apt_obat_keluar where KD_PKM ='".$id."'"); //apt_obat_keluar
		//---------------END------------------------------------//

		// if($db->query("delete from mst_kabupaten where KD_KABUPATEN = '".$id."'")){
		// 	die(json_encode('OK'));
		// }else{
		// 	die(json_encode('FAIL'));
		// }

		if($db->trans_status() === FALSE){
			$db->trans_rollback();
			die(json_encode('FAIL'));
		}else{
			$db->trans_commit();
			die(json_encode('OK'));
		}

	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select('a.*,b.PROVINSI');
		$db->from('mst_kabupaten a');
		$db->join('mst_provinsi b','b.KD_PROVINSI=a.KD_PROVINSI');
		$db->where('KD_KABUPATEN',$id);
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('masterKabupaten/v_master_kabupaten_detail',$data);
	}
	
}

/* End of file c_master_kabupaten.php */
/* Location: ./application/controllers/c_master_kabupaten.php */