<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_ds_kb extends CI_Controller {
	public function index()
	{
		$this->load->view('t_ds_kb/v_ds_kb');
	}
	
	public function ds_kbxml()
	{
		$this->load->model('t_ds_kb_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'tahun'=>$this->input->post('tahun'),
					'carinama'=>$this->input->post('carinama')
					);
					
		$total = $this->t_ds_kb_model->totalds_kb($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'tahun'=>$this->input->post('tahun'),
					'carinama'=>$this->input->post('carinama')
					);
					
		$result = $this->t_ds_kb_model->getds_kb($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_ds_kb/v_ds_kb_add');
	}
	
	public function addprocess()
	{	
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('KD_KECAMATAN', 'Kecamatan', 'trim|required|xss_clean');
		$val->set_rules('KD_KELURAHAN', 'Kelurahan', 'trim|required|xss_clean');
		$val->set_rules('KD_PUSKESMAS', 'Puskesmas', 'trim|required|xss_clean');
		$val->set_rules('TAHUN', 'Tahun', 'trim|required|xss_clean');
		$val->set_rules('BULAN', 'Bulan', 'trim|required|xss_clean');
				
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
				'KD_PROPINSI' => $this->session->userdata('kd_provinsi'),
				'KD_KABUPATEN' => $this->session->userdata('kd_kabupaten'),
				'KD_KECAMATAN' => $val->set_value('KD_KECAMATAN'),
				'KD_KELURAHAN' => $val->set_value('KD_KELURAHAN'),
				'KD_PUSKESMAS' => $val->set_value('KD_PUSKESMAS'),
				'BULAN' => $val->set_value('BULAN'),
				'TAHUN' => $val->set_value('TAHUN'),
				'AKS_BDAK_MOP' => $this->input->post('AKS_BDAK_MOP',true),
				'AKS_BDAK_MOW' => $this->input->post('AKS_BDAK_MOW',true),
				'AKS_BDAK_IMPLANT' => $this->input->post('AKS_BDAK_IMPLANT',true),
				'AKS_BDAK_IUD' => $this->input->post('AKS_BDAK_IUD',true),
				'AKS_BDAK_SUNTIK' => $this->input->post('AKS_BDAK_SUNTIK',true),
				'AKS_BDAK_PIL' => $this->input->post('AKS_BDAK_PIL',true),
				'AKS_BDAK_KONDOM' => $this->input->post('AKS_BDAK_KONDOM',true),
				'AKS_UDAK_IMPLANT' => $this->input->post('AKS_UDAK_IMPLANT',true),
				'AKS_UDAK_IUD' => $this->input->post('AKS_UDAK_IUD',true),
				'AKS_UDAK_SUNTIK' => $this->input->post('AKS_UDAK_SUNTIK',true),
				'AKS_UDAK_PIL' => $this->input->post('AKS_UDAK_PIL',true),
				'AKS_UDAK_KONDOM' => $this->input->post('AKS_UDAK_KONDOM',true),
				'AKS_ADA_MOP' => $this->input->post('AKS_ADA_MOP',true),
				'AKS_ADA_MOW' => $this->input->post('AKS_ADA_MOW',true),
				'AKS_ADA_IMPLANT' => $this->input->post('AKS_ADA_IMPLANT',true),
				'AKS_ADA_IUD' => $this->input->post('AKS_ADA_IUD',true),
				'AKS_ADA_SUNTIK' => $this->input->post('AKS_ADA_SUNTIK',true),
				'AKS_ADA_PIL' => $this->input->post('AKS_ADA_PIL',true),
				'AKS_ADA_KONDOM' => $this->input->post('AKS_ADA_KONDOM',true),
				'EFK_SMK_MOP' => $this->input->post('EFK_SMK_MOP',true),
				'EFK_SMK_MOW' => $this->input->post('EFK_SMK_MOW',true),
				'EFK_SMK_IMPLANT' => $this->input->post('EFK_SMK_IMPLANT',true),
				'EFK_SMK_IUD' => $this->input->post('EFK_SMK_IUD',true),
				'EFK_SMK_SUNTIK' => $this->input->post('EFK_SMK_SUNTIK',true),
				'EFK_SMK_PIL' => $this->input->post('EFK_SMK_PIL',true),
				'EFK_SMK_KONDOM' => $this->input->post('EFK_SMK_KONDOM',true),
				'KOM_MK_MOP' => $this->input->post('KOM_MK_MOP',true),
				'KOM_MK_MOW' => $this->input->post('KOM_MK_MOW',true),
				'KOM_MK_IMPLANT' => $this->input->post('KOM_MK_IMPLANT',true),
				'KOM_MK_IUD' => $this->input->post('KOM_MK_IUD',true),
				'KGL_MK_MOP' => $this->input->post('KGL_MK_MOP',true),
				'KGL_MK_MOW' => $this->input->post('KGL_MK_MOW',true),
				'KGL_MK_IMPLANT' => $this->input->post('KGL_MK_IMPLANT',true),
				'KGL_MK_IUD' => $this->input->post('KGL_MK_IUD',true),
				'KGL_MK_SUNTIK' => $this->input->post('KGL_MK_SUNTIK',true),
				'KGL_MK_PIL' => $this->input->post('KGL_MK_PIL',true),
				'KGL_MK_KONDOM' => $this->input->post('KGL_MK_KONDOM',true),
				'JML_RYMP_KRR' => $this->input->post('JML_RYMP_KRR',true),
				'JML_PK_REMAJA' => $this->input->post('JML_PK_REMAJA',true),
				'JML_BRBY_DITANGANI' => $this->input->post('JML_BRBY_DITANGANI',true),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('t_ds_kb', $dataexc);
			
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
		$this->load->library('form_validation');
		$val = $this->form_validation;
		$val->set_rules('KD_KECAMATAN', 'Kecamatan', 'trim|required|xss_clean');
		$val->set_rules('KD_KELURAHAN', 'Kelurahan', 'trim|required|xss_clean');
		$val->set_rules('KD_PUSKESMAS', 'Puskesmas', 'trim|required|xss_clean');
		$val->set_rules('TAHUN', 'Tahun', 'trim|required|xss_clean');
		$val->set_rules('BULAN', 'Bulan', 'trim|required|xss_clean');
				
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
				'KD_KECAMATAN' => $val->set_value('KD_KECAMATAN'),
				'KD_KELURAHAN' => $val->set_value('KD_KELURAHAN'),
				'KD_PUSKESMAS' => $val->set_value('KD_PUSKESMAS'),
				'BULAN' => $val->set_value('BULAN'),
				'TAHUN' => $val->set_value('TAHUN'),
				'AKS_BDAK_MOP' => $this->input->post('AKS_BDAK_MOP',true),
				'AKS_BDAK_MOW' => $this->input->post('AKS_BDAK_MOW',true),
				'AKS_BDAK_IMPLANT' => $this->input->post('AKS_BDAK_IMPLANT',true),
				'AKS_BDAK_IUD' => $this->input->post('AKS_BDAK_IUD',true),
				'AKS_BDAK_SUNTIK' => $this->input->post('AKS_BDAK_SUNTIK',true),
				'AKS_BDAK_PIL' => $this->input->post('AKS_BDAK_PIL',true),
				'AKS_BDAK_KONDOM' => $this->input->post('AKS_BDAK_KONDOM',true),
				'AKS_UDAK_IMPLANT' => $this->input->post('AKS_UDAK_IMPLANT',true),
				'AKS_UDAK_IUD' => $this->input->post('AKS_UDAK_IUD',true),
				'AKS_UDAK_SUNTIK' => $this->input->post('AKS_UDAK_SUNTIK',true),
				'AKS_UDAK_PIL' => $this->input->post('AKS_UDAK_PIL',true),
				'AKS_UDAK_KONDOM' => $this->input->post('AKS_UDAK_KONDOM',true),
				'AKS_ADA_MOP' => $this->input->post('AKS_ADA_MOP',true),
				'AKS_ADA_MOW' => $this->input->post('AKS_ADA_MOW',true),
				'AKS_ADA_IMPLANT' => $this->input->post('AKS_ADA_IMPLANT',true),
				'AKS_ADA_IUD' => $this->input->post('AKS_ADA_IUD',true),
				'AKS_ADA_SUNTIK' => $this->input->post('AKS_ADA_SUNTIK',true),
				'AKS_ADA_PIL' => $this->input->post('AKS_ADA_PIL',true),
				'AKS_ADA_KONDOM' => $this->input->post('AKS_ADA_KONDOM',true),
				'EFK_SMK_MOP' => $this->input->post('EFK_SMK_MOP',true),
				'EFK_SMK_MOW' => $this->input->post('EFK_SMK_MOW',true),
				'EFK_SMK_IMPLANT' => $this->input->post('EFK_SMK_IMPLANT',true),
				'EFK_SMK_IUD' => $this->input->post('EFK_SMK_IUD',true),
				'EFK_SMK_SUNTIK' => $this->input->post('EFK_SMK_SUNTIK',true),
				'EFK_SMK_PIL' => $this->input->post('EFK_SMK_PIL',true),
				'EFK_SMK_KONDOM' => $this->input->post('EFK_SMK_KONDOM',true),
				'KOM_MK_MOP' => $this->input->post('KOM_MK_MOP',true),
				'KOM_MK_MOW' => $this->input->post('KOM_MK_MOW',true),
				'KOM_MK_IMPLANT' => $this->input->post('KOM_MK_IMPLANT',true),
				'KOM_MK_IUD' => $this->input->post('KOM_MK_IUD',true),
				'KGL_MK_MOP' => $this->input->post('KGL_MK_MOP',true),
				'KGL_MK_MOW' => $this->input->post('KGL_MK_MOW',true),
				'KGL_MK_IMPLANT' => $this->input->post('KGL_MK_IMPLANT',true),
				'KGL_MK_IUD' => $this->input->post('KGL_MK_IUD',true),
				'KGL_MK_SUNTIK' => $this->input->post('KGL_MK_SUNTIK',true),
				'KGL_MK_PIL' => $this->input->post('KGL_MK_PIL',true),
				'KGL_MK_KONDOM' => $this->input->post('KGL_MK_KONDOM',true),
				'JML_RYMP_KRR' => $this->input->post('JML_RYMP_KRR',true),
				'JML_PK_REMAJA' => $this->input->post('JML_PK_REMAJA',true),
				'JML_BRBY_DITANGANI' => $this->input->post('JML_BRBY_DITANGANI',true),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);
			
			$id=$this->input->post('ID',true);
			
			$db->where('ID',$id);
			$db->update('t_ds_kb', $dataexc);
			
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
		$this->load->helper('beries_helper');
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select t.*,p.PROVINSI,k.KABUPATEN,kc.KECAMATAN,kl.KELURAHAN 
						from t_ds_kb t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI						
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('t_ds_kb/v_ds_kb_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from t_ds_kb where ID = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select t.*,p.PROVINSI,ps.PUSKESMAS,k.KABUPATEN,kc.KECAMATAN,kl.KELURAHAN 
						from t_ds_kb t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_puskesmas ps on ps.KD_PUSKESMAS=t.KD_PUSKESMAS
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('t_ds_kb/v_ds_kb_detail',$data);
	}
	
}

/* End of file t_ds_kb.php */
/* Location: ./application/controllers/t_ds_kb.php */