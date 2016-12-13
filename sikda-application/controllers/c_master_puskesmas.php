<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_puskesmas extends CI_Controller {
	public function index()
	{
		$this->load->view('masterPuskesmas/v_master_puskesmas');
	}
	
	public function puskesmaspopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$data['idkec'] = $this->input->get('kd_kec')?$this->input->get('kd_kec',TRUE):null;
		$this->load->view('masterPuskesmas/v_master_puskesmas_popup',$data);
	}
	
	public function puskesmasxml()
	{
		$this->load->model('m_master_puskesmas');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'nama'=>$this->input->post('nama'),
					'kodepuskesmas'=>$this->input->post('kodepuskesmas')
					);
					
		$total = $this->m_master_puskesmas->totalPuskesmas($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'nama'=>$this->input->post('nama'),
					'kodepuskesmas'=>$this->input->post('kodepuskesmas'),
					'id'=>$this->input->post('idkec')
					);
					
		$result = $this->m_master_puskesmas->getPuskesmas($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterPuskesmas/v_master_puskesmas_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kodepuskesmas', 'Kode Puskesmas', 'trim|required|xss_clean|min_length[11]|max_length[11]');
		$val->set_rules('kodekecamatan', 'Kode Kecamatan', 'trim|required|xss_clean');
		$val->set_rules('namapuskesmas', 'Puskesmas', 'trim|required|xss_clean');
		$val->set_rules('alamat', 'Alamat', 'trim|required|xss_clean');
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
				'KD_PUSKESMAS' => $val->set_value('kodepuskesmas'),
				'KD_KECAMATAN' => $val->set_value('kodekecamatan'),
				'PUSKESMAS' => $val->set_value('namapuskesmas'),
				'ALAMAT'=> $val->set_value('alamat'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('mst_puskesmas', $dataexc);
			
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
		$id = $this->input->post('kd_puskesmas',TRUE);		
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kodepuskesmas', 'Kode Puskesmas', 'trim|required|xss_clean|min_length[11]|max_length[11]');
		$val->set_rules('kodekecamatan', 'Kode Kecamatan', 'trim|required|xss_clean');
		$val->set_rules('namapuskesmas', 'Puskesmas', 'trim|required|xss_clean');
		$val->set_rules('alamat', 'Alamat', 'trim|required|xss_clean');

		if ($val->run() == FALSE)
		{
			$val->set_error_delimiters('<div style="color:white">', '</div>');
			die(validation_errors());
		}
		else
		{						
			$db = $this->load->database('sikda', TRUE);
			$db->trans_begin();

			// $db->query('SET FOREIGN_KEY_CHECKS=0');

			$dataexc = array(
				'KD_PUSKESMAS' => $val->set_value('kodepuskesmas'),
				'KD_KECAMATAN' => $val->set_value('kodekecamatan'),
				'PUSKESMAS' => $val->set_value('namapuskesmas'),
				'ALAMAT'=> $val->set_value('alamat'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('KD_PUSKESMAS',$id);
			$db->update('mst_puskesmas', $dataexc);

			//update in other table
			$get_puskesmas =$val->set_value('kodepuskesmas');
			$db->query("update sys_setting SET PUSKESMAS ='$get_puskesmas' where PUSKESMAS = '$id' "); //sys_setting

			//SARANA
			$db->query("update trans_sarana SET ASAL_SARANA ='$get_puskesmas' where ASAL_SARANA = '$id' "); //trans_sarana
			$db->query("update trans_sarana SET TUJUAN_SARANA ='$get_puskesmas' where TUJUAN_SARANA = '$id' "); //trans_sarana
			$db->query("update apt_sarana SET KD_PEMILIK_DATA ='$get_puskesmas' where KD_PEMILIK_DATA = '$id' "); //apt_sarana
			$db->query("update apt_sarana SET KD_TEMPAT_ASAL ='$get_puskesmas' where KD_TEMPAT_ASAL = '$id' "); //apt_sarana - kd_tempat_asal
			$db->query("update apt_sarana SET NAMA_TEMPAT_ASAL ='$get_puskesmas' where NAMA_TEMPAT_ASAL = '$id' "); //apt_sarana - nama_tempat_asal
			$db->query("update apt_sarana SET KD_TEMPAT_TUJUAN ='$get_puskesmas' where KD_TEMPAT_TUJUAN = '$id' "); //apt_sarana - kd_tempat_asal
			$db->query("update apt_sarana_detail SET KD_PEMILIK_DATA ='$get_puskesmas' where KD_PEMILIK_DATA = '$id' "); //apt_sarana_detail
			//---------------END------------------------------------//

			//OBAT
			$db->query("update apt_obat_terima SET KD_PKM ='$get_puskesmas' where KD_PKM = '$id' "); //apt_obat_terima
			$db->query("update apt_stok_obat SET KD_PKM ='$get_puskesmas' where KD_PKM = '$id' "); //apt_stok_obat
			$db->query("update apt_obat_keluar SET KD_PKM ='$get_puskesmas' where KD_PKM = '$id' "); //apt_obat_keluar
			//---------------END------------------------------------//


			// $db->query('SET FOREIGN_KEY_CHECKS=1');

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
	
	public function edit()
	{
		$id=$this->input->get('kd_puskesmas')?$this->input->get('kd_puskesmas',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("a.KD_PUSKESMAS,a.KD_KECAMATAN,a.PUSKESMAS,a.ALAMAT,b.KD_KECAMATAN as kode_kecamatan,b.KECAMATAN as nama_kecamatan");
		$db->from('mst_puskesmas a');
		$db->join('mst_kecamatan b','b.KD_KECAMATAN=a.KD_KECAMATAN','left');
		$db->where('a.KD_PUSKESMAS',$id);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('masterPuskesmas/v_master_puskesmas_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('kd_puskesmas')?$this->input->post('kd_puskesmas',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->trans_begin();

		$db->query("delete from mst_puskesmas where KD_PUSKESMAS = '".$id."'"); //mst_puskesmas
		$db->query("delete from sys_setting where PUSKESMAS ='".$id."'"); //sys_setting

		//SARANA
		$db->query("delete from trans_sarana where ASAL_SARANA ='".$id."'"); //trans_sarana - ASAL_SARANA
		$db->query("delete from trans_sarana where TUJUAN_SARANA ='".$id."'"); //trans_sarana
		$db->query("delete from apt_sarana where KD_PEMILIK_DATA ='".$id."'"); //apt_sarana
		$db->query("delete from apt_sarana_detail where KD_PEMILIK_DATA ='".$id."'"); //apt_sarana_detail
		//--------------------------END---------------------//

		//OBAT
		$db->query("delete from apt_obat_terima where KD_PKM ='".$id."'"); //apt_obat_terima
		$db->query("delete from apt_stok_obat where KD_PKM ='".$id."'"); //apt_stok_obat
		$db->query("delete from apt_obat_keluar where KD_PKM ='".$id."'"); //apt_obat_keluar
		//---------------END------------------------------------//

		// if($db->query("delete from mst_puskesmas where KD_PUSKESMAS = '".$id."'")){
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
		$id=$this->input->get('kd_puskesmas')?$this->input->get('kd_puskesmas',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("a.KD_PUSKESMAS,a.KD_KECAMATAN,a.PUSKESMAS,a.ALAMAT,b.KD_KECAMATAN as kode_kecamatan,b.KECAMATAN as nama_kecamatan");
		$db->from('mst_puskesmas a');
		$db->join('mst_kecamatan b','b.KD_KECAMATAN=a.KD_KECAMATAN','left');
		$db->where('a.KD_PUSKESMAS',$id);
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('masterPuskesmas/v_master_puskesmas_detail',$data);
	}
	
}

/* End of file c_master_puskesmas.php */
/* Location: ./application/controllers/c_master_puskesmas.php */