<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_ds_ukgs extends CI_Controller {
	public function index()
	{
		$this->load->view('t_ds_ukgs/v_ds_ukgs');
	}
	
	public function ds_ukgsxml()
	{
		$this->load->model('t_ds_ukgs_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'tahun'=>$this->input->post('tahun'),
					'carinama'=>$this->input->post('carinama')
					);
					
		$total = $this->t_ds_ukgs_model->totalds_ukgs($paramstotal);
		
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
					
		$result = $this->t_ds_ukgs_model->getds_ukgs($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_ds_ukgs/v_ds_ukgs_add');
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
				'JML_PMDGU_SD_UKGS_TAHAP_III' => $this->input->post('JML_PMDGU_SD_UKGS_TAHAP_III',true),
				'JML_PMDGU_SD_UKGS_INTEGRASI' => $this->input->post('JML_PMDGU_SD_UKGS_INTEGRASI',true),
				'JML_PMDGU_L_SD_V_VI_UKGS_III' => $this->input->post('JML_PMDGU_L_SD_V_VI_UKGS_III',true),
				'JML_PMDGU_L_SD_V_VI_UKGS_III_PERAWATAN' => $this->input->post('JML_PMDGU_L_SD_V_VI_UKGS_III_PERAWATAN',true),
				'JML_PMDGU_P_SD_V_VI_UKGS_III' => $this->input->post('JML_PMDGU_P_SD_V_VI_UKGS_III',true),
				'JML_PMDGU_P_SD_V_VI_UKGS_III_PERAWATAN' => $this->input->post('JML_PMDGU_P_SD_V_VI_UKGS_III_PERAWATAN',true),
				'JML_PEMERIKSAAN_L_BARU' => $this->input->post('JML_PEMERIKSAAN_L_BARU',true),
				'JML_PEMERIKSAAN_L_LAMA' => $this->input->post('JML_PEMERIKSAAN_L_LAMA',true),
				'JML_DIAGNOSA_L_C_DENTIS' => $this->input->post('JML_DIAGNOSA_L_C_DENTIS',true),
				'JML_DIAGNOSA_L_K_PULPA' => $this->input->post('JML_DIAGNOSA_L_K_PULPA',true),
				'JML_DIAGNOSA_L_K_PERIODONTAL' => $this->input->post('JML_DIAGNOSA_L_K_PERIODONTAL',true),
				'JML_DIAGNOSA_L_ABSES' => $this->input->post('JML_DIAGNOSA_L_ABSES',true),
				'JML_DIAGNOSA_L_PERSISTENSI' => $this->input->post('JML_DIAGNOSA_L_PERSISTENSI',true),
				'JML_DIAGNOSA_L_LAINLAIN' => $this->input->post('JML_DIAGNOSA_L_LAINLAIN',true),
				'JML_PEMERIKSAAN_P_BARU' => $this->input->post('JML_PEMERIKSAAN_P_BARU',true),
				'JML_PEMERIKSAAN_P_LAMA' => $this->input->post('JML_PEMERIKSAAN_P_LAMA',true),
				'JML_DIAGNOSA_P_C_DENTIS' => $this->input->post('JML_DIAGNOSA_P_C_DENTIS',true),
				'JML_DIAGNOSA_P_K_PULPA' => $this->input->post('JML_DIAGNOSA_P_K_PULPA',true),
				'JML_DIAGNOSA_P_K_PERIODONTAL' => $this->input->post('JML_DIAGNOSA_P_K_PERIODONTAL',true),
				'JML_DIAGNOSA_P_ABSES' => $this->input->post('JML_DIAGNOSA_P_ABSES',true),
				'JML_DIAGNOSA_P_PERSISTENSI' => $this->input->post('JML_DIAGNOSA_P_PERSISTENSI',true),
				'JML_DIAGNOSA_P_LAINLAIN' => $this->input->post('JML_DIAGNOSA_P_LAINLAIN',true),
				'JML_PERAWATAN_P_TTP_GIGITETAP' => $this->input->post('JML_PERAWATAN_P_TTP_GIGITETAP',true),
				'JML_PERAWATAN_P_TTP_GIGISULUNG' => $this->input->post('JML_PERAWATAN_P_TTP_GIGISULUNG',true),
				'JML_PERAWATAN_P_T_SEMENTARA' => $this->input->post('JML_PERAWATAN_P_T_SEMENTARA',true),
				'JML_PERAWATAN_P_P_PULPA' => $this->input->post('JML_PERAWATAN_P_P_PULPA',true),
				'JML_PERAWATAN_P_P_PERIODENTAL' => $this->input->post('JML_PERAWATAN_P_P_PERIODENTAL',true),
				'JML_PERAWATAN_P_P_ABSES' => $this->input->post('JML_PERAWATAN_P_P_ABSES',true),
				'JML_PERAWATAN_P_T_SCALLING' => $this->input->post('JML_PERAWATAN_P_T_SCALLING',true),
				'JML_PERAWATAN_P_P_GIGITETAP' => $this->input->post('JML_PERAWATAN_P_P_GIGITETAP',true),
				'JML_PERAWATAN_P_P_GIGISULUNG' => $this->input->post('JML_PERAWATAN_P_P_GIGISULUNG',true),
				'JML_PERAWATAN_P_LAINLAIN' => $this->input->post('JML_PERAWATAN_P_LAINLAIN',true),
				'JML_PEMBINAAN_P_PKGM_KELAS' => $this->input->post('JML_PEMBINAAN_P_PKGM_KELAS',true),
				'JML_PEMBINAAN_P_PKSD_UKGS' => $this->input->post('JML_PEMBINAAN_P_PKSD_UKGS',true),
				'JML_PEMBINAAN_P_PKD_UKGM' => $this->input->post('JML_PEMBINAAN_P_PKD_UKGM',true),
				'JML_PEMBINAAN_P_PYMPGSO_KADER' => $this->input->post('JML_PEMBINAAN_P_PYMPGSO_KADER',true),
				'JML_PEMBINAAN_P_PDK_GIGI' => $this->input->post('JML_PEMBINAAN_P_PDK_GIGI',true),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			//print_r($dataexc);die;
			$db->insert('t_ds_ukgs', $dataexc);
			
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
				'JML_PMDGU_SD_UKGS_TAHAP_III' => $this->input->post('JML_PMDGU_SD_UKGS_TAHAP_III',true),
				'JML_PMDGU_SD_UKGS_INTEGRASI' => $this->input->post('JML_PMDGU_SD_UKGS_INTEGRASI',true),
				'JML_PMDGU_L_SD_V_VI_UKGS_III' => $this->input->post('JML_PMDGU_L_SD_V_VI_UKGS_III',true),
				'JML_PMDGU_L_SD_V_VI_UKGS_III_PERAWATAN' => $this->input->post('JML_PMDGU_L_SD_V_VI_UKGS_III_PERAWATAN',true),
				'JML_PMDGU_P_SD_V_VI_UKGS_III' => $this->input->post('JML_PMDGU_P_SD_V_VI_UKGS_III',true),
				'JML_PMDGU_P_SD_V_VI_UKGS_III_PERAWATAN' => $this->input->post('JML_PMDGU_P_SD_V_VI_UKGS_III_PERAWATAN',true),
				'JML_PEMERIKSAAN_L_BARU' => $this->input->post('JML_PEMERIKSAAN_L_BARU',true),
				'JML_PEMERIKSAAN_L_LAMA' => $this->input->post('JML_PEMERIKSAAN_L_LAMA',true),
				'JML_DIAGNOSA_L_C_DENTIS' => $this->input->post('JML_DIAGNOSA_L_C_DENTIS',true),
				'JML_DIAGNOSA_L_K_PULPA' => $this->input->post('JML_DIAGNOSA_L_K_PULPA',true),
				'JML_DIAGNOSA_L_K_PERIODONTAL' => $this->input->post('JML_DIAGNOSA_L_K_PERIODONTAL',true),
				'JML_DIAGNOSA_L_ABSES' => $this->input->post('JML_DIAGNOSA_L_ABSES',true),
				'JML_DIAGNOSA_L_PERSISTENSI' => $this->input->post('JML_DIAGNOSA_L_PERSISTENSI',true),
				'JML_DIAGNOSA_L_LAINLAIN' => $this->input->post('JML_DIAGNOSA_L_LAINLAIN',true),
				'JML_PEMERIKSAAN_P_BARU' => $this->input->post('JML_PEMERIKSAAN_P_BARU',true),
				'JML_PEMERIKSAAN_P_LAMA' => $this->input->post('JML_PEMERIKSAAN_P_LAMA',true),
				'JML_DIAGNOSA_P_C_DENTIS' => $this->input->post('JML_DIAGNOSA_P_C_DENTIS',true),
				'JML_DIAGNOSA_P_K_PULPA' => $this->input->post('JML_DIAGNOSA_P_K_PULPA',true),
				'JML_DIAGNOSA_P_K_PERIODONTAL' => $this->input->post('JML_DIAGNOSA_P_K_PERIODONTAL',true),
				'JML_DIAGNOSA_P_ABSES' => $this->input->post('JML_DIAGNOSA_P_ABSES',true),
				'JML_DIAGNOSA_P_PERSISTENSI' => $this->input->post('JML_DIAGNOSA_P_PERSISTENSI',true),
				'JML_DIAGNOSA_P_LAINLAIN' => $this->input->post('JML_DIAGNOSA_P_LAINLAIN',true),
				'JML_PERAWATAN_P_TTP_GIGITETAP' => $this->input->post('JML_PERAWATAN_P_TTP_GIGITETAP',true),
				'JML_PERAWATAN_P_TTP_GIGISULUNG' => $this->input->post('JML_PERAWATAN_P_TTP_GIGISULUNG',true),
				'JML_PERAWATAN_P_T_SEMENTARA' => $this->input->post('JML_PERAWATAN_P_T_SEMENTARA',true),
				'JML_PERAWATAN_P_P_PULPA' => $this->input->post('JML_PERAWATAN_P_P_PULPA',true),
				'JML_PERAWATAN_P_P_PERIODENTAL' => $this->input->post('JML_PERAWATAN_P_P_PERIODENTAL',true),
				'JML_PERAWATAN_P_P_ABSES' => $this->input->post('JML_PERAWATAN_P_P_ABSES',true),
				'JML_PERAWATAN_P_T_SCALLING' => $this->input->post('JML_PERAWATAN_P_T_SCALLING',true),
				'JML_PERAWATAN_P_P_GIGITETAP' => $this->input->post('JML_PERAWATAN_P_P_GIGITETAP',true),
				'JML_PERAWATAN_P_P_GIGISULUNG' => $this->input->post('JML_PERAWATAN_P_P_GIGISULUNG',true),
				'JML_PERAWATAN_P_LAINLAIN' => $this->input->post('JML_PERAWATAN_P_LAINLAIN',true),
				'JML_PEMBINAAN_P_PKGM_KELAS' => $this->input->post('JML_PEMBINAAN_P_PKGM_KELAS',true),
				'JML_PEMBINAAN_P_PKSD_UKGS' => $this->input->post('JML_PEMBINAAN_P_PKSD_UKGS',true),
				'JML_PEMBINAAN_P_PKD_UKGM' => $this->input->post('JML_PEMBINAAN_P_PKD_UKGM',true),
				'JML_PEMBINAAN_P_PYMPGSO_KADER' => $this->input->post('JML_PEMBINAAN_P_PYMPGSO_KADER',true),
				'JML_PEMBINAAN_P_PDK_GIGI' => $this->input->post('JML_PEMBINAAN_P_PDK_GIGI',true),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);
			
			$id=$this->input->post('ID',true);
			
			$db->where('ID',$id);
			$db->update('t_ds_ukgs', $dataexc);
			
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
						from t_ds_ukgs t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI						
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('t_ds_ukgs/v_ds_ukgs_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from t_ds_ukgs where ID = '".$id."'")){
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
						from t_ds_ukgs t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_puskesmas ps on ps.KD_PUSKESMAS=t.KD_PUSKESMAS
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('t_ds_ukgs/v_ds_ukgs_detail',$data);
	}
	
}

/* End of file c_ds_ukgs.php */
/* Location: ./application/controllers/c_ds_ukgs.php */