<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_ds_uks extends CI_Controller {
	public function index()
	{
		$this->load->view('t_ds_uks/v_ds_uks');
	}
	
	public function ds_uksxml()
	{
		$this->load->model('t_ds_uks_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'tahun'=>$this->input->post('tahun'),
					'carinama'=>$this->input->post('carinama')
					);
					
		$total = $this->t_ds_uks_model->totalds_uks($paramstotal);
		
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
					
		$result = $this->t_ds_uks_model->getds_uks($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_ds_uks/v_ds_uks_add');
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
				
				'JML_SDMI_UKS' => $this->input->post('JML_SDMI_UKS',true),
				'JML_SKL_DIBINA_PUSKESMAS' => $this->input->post('JML_SKL_DIBINA_PUSKESMAS',true),
				'JML_SKL_PENJARINGAN' => $this->input->post('JML_SKL_PENJARINGAN',true),
				
				//A. SEKOLAH SD/MI DENGAN STANDAR SEKOLAH SEHAT
				'JML_SD_SKL_MINIMAL' => $this->input->post('JML_SD_SKL_MINIMAL',true),
				'JML_SD_SKL_STANDAR' => $this->input->post('JML_SD_SKL_STANDAR',true),
				'JML_SD_SKL_OPTIMAL' => $this->input->post('JML_SD_SKL_OPTIMAL',true),
				'JML_SD_SKL_PARIPURNA' => $this->input->post('JML_SD_SKL_PARIPURNA',true),
				'JML_SD_SKL_GR_UKS' => $this->input->post('JML_SD_SKL_GR_UKS',true),
				'JML_SD_SKL_DANA_SEHAT' => $this->input->post('JML_SD_SKL_DANA_SEHAT',true),
				'JML_SD_SKL_DR_KECIL' => $this->input->post('JML_SD_SKL_DR_KECIL',true),
				'JML_SD_AK_DR_KECIL' => $this->input->post('JML_SD_AK_DR_KECIL',true),
				//LAKI-LAKI
				'JML_L_M_SD_PENGOBATAN' => $this->input->post('JML_L_M_SD_PENGOBATAN',true),
				'JML_L_M_SD_DIRUJUK' => $this->input->post('JML_L_M_SD_DIRUJUK',true),
				'JML_L_M_SD_GZ_BURUK' => $this->input->post('JML_L_M_SD_GZ_BURUK',true),
				'JML_L_M_SD_GZ_KURANG' => $this->input->post('JML_L_M_SD_GZ_KURANG',true),
				'JML_L_M_SD_GZ_BAIK' => $this->input->post('JML_L_M_SD_GZ_BAIK',true),
				'JML_L_M_SD_GZ_LEBIH' => $this->input->post('JML_L_M_SD_GZ_LEBIH',true),
				'JML_L_ALB_SD_PUSKESMAS' => $this->input->post('JML_L_ALB_SD_PUSKESMAS',true),
				'JML_L_ALB_SD_DIPERIKSA' => $this->input->post('JML_L_ALB_SD_DIPERIKSA',true),
				'JML_L_ALB_SD_DIRUJUK' => $this->input->post('JML_L_ALB_SD_DIRUJUK',true),
				'JML_L_SD_BBTSTB' => $this->input->post('JML_L_SD_BBTSTB',true),
				'JML_L_SD_SKL_PUSKESMAS' => $this->input->post('JML_L_SD_SKL_PUSKESMAS',true),
				'JML_L_SD_SKL_DIRUJUK' => $this->input->post('JML_L_SD_SKL_DIRUJUK',true),
				//PEREMPUAN
				'JML_P_M_SD_PENGOBATAN' => $this->input->post('JML_P_M_SD_PENGOBATAN',true),
				'JML_P_M_SD_DIRUJUK' => $this->input->post('JML_P_M_SD_DIRUJUK',true),
				'JML_P_M_SD_GZ_BURUK' => $this->input->post('JML_P_M_SD_GZ_BURUK',true),
				'JML_P_M_SD_GZ_KURANG' => $this->input->post('JML_P_M_SD_GZ_KURANG',true),
				'JML_P_M_SD_GZ_BAIK' => $this->input->post('JML_P_M_SD_GZ_BAIK',true),
				'JML_P_M_SD_GZ_LEBIH' => $this->input->post('JML_P_M_SD_GZ_LEBIH',true),
				'JML_P_SD_KON_KESEHATAN' => $this->input->post('JML_P_SD_KON_KESEHATAN',true),
				'JML_P_ALB_SD_PUSKESMAS' => $this->input->post('JML_P_ALB_SD_PUSKESMAS',true),
				'JML_P_ALB_SD_DIPERIKSA' => $this->input->post('JML_P_ALB_SD_DIPERIKSA',true),
				'JML_P_ALB_SD_DIRUJUK' => $this->input->post('JML_P_ALB_SD_DIRUJUK',true),
				'JML_P_SD_UKS' => $this->input->post('JML_P_SD_UKS',true),
				'JML_P_SD_PUSKESMAS' => $this->input->post('JML_P_SD_PUSKESMAS',true),
				'JML_P_SD_PENJARINGAN' => $this->input->post('JML_P_SD_PENJARINGAN',true),
				'JML_P_SD_BBTSTB' => $this->input->post('JML_P_SD_BBTSTB',true),
				'JML_P_SD_SKL_PUSKESMAS' => $this->input->post('JML_P_SD_SKL_PUSKESMAS',true),
				'JML_P_SD_SKL_DIRUJUK' => $this->input->post('JML_P_SD_SKL_DIRUJUK',true),
				
				//B. SEKOLAH SLTP/MTs DENGAN STANDAR SEKOLAH SEHAT
				'JML_SLTP_SKL_MINIMAL' => $this->input->post('JML_SLTP_SKL_MINIMAL',true),
				'JML_SLTP_SKL_STANDAR' => $this->input->post('JML_SLTP_SKL_STANDAR',true),
				'JML_SLTP_SKL_OPTIMAL' => $this->input->post('JML_SLTP_SKL_OPTIMAL',true),
				'JML_SLTP_SKL_PARIPURNA' => $this->input->post('JML_SLTP_SKL_PARIPURNA',true),
				'JML_SLTP_SKL_GR_UKS' => $this->input->post('JML_SLTP_SKL_GR_UKS',true),
				'JML_SLTP_SKL_DANA_SEHAT' => $this->input->post('JML_SLTP_SKL_DANA_SEHAT',true),
				'JML_SLTP_SKL_KDR_KESEHATAN' => $this->input->post('JML_SLTP_SKL_KDR_KESEHATAN',true),
				'JML_SLTP_SKL_KDR_AKTF' => $this->input->post('JML_SLTP_SKL_KDR_AKTF',true),
				//LAKI-LAKI
				'JML_L_M_SLTP_PENGOBATAN' => $this->input->post('JML_L_M_SLTP_PENGOBATAN',true),
				'JML_L_M_SLTP_DIRUJUK' => $this->input->post('JML_L_M_SLTP_DIRUJUK',true),
				'JML_L_M_SLTP_GZ_BURUK' => $this->input->post('JML_L_M_SLTP_GZ_BURUK',true),
				'JML_L_M_SLTP_GZ_KURANG' => $this->input->post('JML_L_M_SLTP_GZ_KURANG',true),
				'JML_L_M_SLTP_GZ_BAIK' => $this->input->post('JML_L_M_SLTP_GZ_BAIK',true),
				'JML_L_M_SLTP_GZ_LEBIH' => $this->input->post('JML_L_M_SLTP_GZ_LEBIH',true),
				'JML_L_SLTP_ALB_PUSKESMAS' => $this->input->post('JML_L_SLTP_ALB_PUSKESMAS',true),
				'JML_L_SLTP_ALB_DIPERIKSA' => $this->input->post('JML_L_SLTP_ALB_DIPERIKSA',true),
				'JML_L_SLTP_ALB_DIRUJUK' => $this->input->post('JML_L_SLTP_ALB_DIRUJUK',true),
				'JML_L_SLTP_BBTSTB' => $this->input->post('JML_L_SLTP_BBTSTB',true),
				'JML_L_SLTP_DP_PUS_SEKOLAH' => $this->input->post('JML_L_SLTP_DP_PUS_SEKOLAH',true),
				'JML_L_SLTP_DIRUJUK' => $this->input->post('JML_L_SLTP_DIRUJUK',true),
				//PEREMPUAN
				'JML_P_M_SLTP_PENGOBATAN' => $this->input->post('JML_P_M_SLTP_PENGOBATAN',true),
				'JML_P_M_SLTP_DIRUJUK' => $this->input->post('JML_P_M_SLTP_DIRUJUK',true),
				'JML_P_M_SLTP_GZ_BURUK' => $this->input->post('JML_P_M_SLTP_GZ_BURUK',true),
				'JML_P_M_SLTP_GZ_KURANG' => $this->input->post('JML_P_M_SLTP_GZ_KURANG',true),
				'JML_P_M_SLTP_GZ_BAIK' => $this->input->post('JML_P_M_SLTP_GZ_BAIK',true),
				'JML_P_M_SLTP_GZ_LEBIH' => $this->input->post('JML_P_M_SLTP_GZ_LEBIH',true),
				'JML_P_SLTP_KON_KESEHATAN' => $this->input->post('JML_P_SLTP_KON_KESEHATAN',true),
				'JML_P_SLTP_ALB_PUSKESMAS' => $this->input->post('JML_P_SLTP_ALB_PUSKESMAS',true),
				'JML_P_SLTP_ALB_DIPERIKSA' => $this->input->post('JML_P_SLTP_ALB_DIPERIKSA',true),
				'JML_P_SLTP_ALB_DIRUJUK' => $this->input->post('JML_P_SLTP_ALB_DIRUJUK',true),
				'JML_P_SLTP_UKS' => $this->input->post('JML_P_SLTP_UKS',true),
				'JML_P_SLTP_DB_PUSKESMAS' => $this->input->post('JML_P_SLTP_DB_PUSKESMAS',true),
				'JML_P_SLTP_M_PENJARINGAN' => $this->input->post('JML_P_SLTP_M_PENJARINGAN',true),
				'JML_P_SLTP_BBTSTB' => $this->input->post('JML_P_SLTP_BBTSTB',true),
				'JML_P_SLTP_DP_PUS_SEKOLAH' => $this->input->post('JML_P_SLTP_DP_PUS_SEKOLAH',true),
				'JML_P_SLTP_DIRUJUK' => $this->input->post('JML_P_SLTP_DIRUJUK',true),
				
				
				//C. SEKOLAH SLTA/MA DENGAN STANDAR SEKOLAH SEHAT
				'JML_SLTA_SKL_MINIMAL' => $this->input->post('JML_SLTP_SKL_MINIMAL',true),
				'JML_SLTA_SKL_STANDAR' => $this->input->post('JML_SLTP_SKL_STANDAR',true),
				'JML_SLTA_SKL_OPTIMAL' => $this->input->post('JML_SLTA_SKL_OPTIMAL',true),
				'JML_SLTA_SKL_PARIPURNA' => $this->input->post('JML_SLTA_SKL_PARIPURNA',true),
				'JML_SLTA_SKL_GR_UKS' => $this->input->post('JML_SLTA_SKL_GR_UKS',true),
				'JML_SLTA_SKL_DANA_SEHAT' => $this->input->post('JML_SLTA_SKL_DANA_SEHAT',true),
				'JML_SLTA_SKL_KDR_KESEHATAN' => $this->input->post('JML_SLTA_SKL_KDR_KESEHATAN',true),
				'JML_SLTA_SKL_AK_KDR_KESEHATAN' => $this->input->post('JML_SLTA_SKL_AK_KDR_KESEHATAN',true),
				//LAKI-LAKI
				'JML_L_SLTA_PENGOBATAN' => $this->input->post('JML_L_SLTA_PENGOBATAN',true),
				'JML_L_SLTA_DIRUJUK' => $this->input->post('JML_L_SLTA_DIRUJUK',true),
				'JML_L_SLTA_GZ_BURUK' => $this->input->post('JML_L_SLTA_GZ_BURUK',true),
				'JML_L_SLTA_GZ_KURANG' => $this->input->post('JML_L_SLTA_GZ_KURANG',true),
				'JML_L_SLTA_GZ_BAIK' => $this->input->post('JML_L_SLTA_GZ_BAIK',true),
				'JML_L_SLTA_GZ_LEBIH' => $this->input->post('JML_L_SLTA_GZ_LEBIH',true),
				'JML_L_SLTA_ALB_PUSKESMAS' => $this->input->post('JML_L_SLTA_ALB_PUSKESMAS',true),
				'JML_L_SLTA_ALB_DIPERIKSA' => $this->input->post('JML_L_SLTA_ALB_DIPERIKSA',true),
				'JML_L_SLTA_ALB_DIRUJUK' => $this->input->post('JML_L_SLTA_ALB_DIRUJUK',true),
				//PEREMPUAN
				'JML_P_SLTA_PENGOBATAN' => $this->input->post('JML_P_SLTA_PENGOBATAN',true),
				'JML_P_SLTA_DIRUJUK' => $this->input->post('JML_P_SLTA_DIRUJUK',true),
				'JML_P_SLTA_GZ_BURUK' => $this->input->post('JML_P_SLTA_GZ_BURUK',true),
				'JML_P_SLTA_GZ_KURANG' => $this->input->post('JML_P_SLTA_GZ_KURANG',true),
				'JML_P_SLTA_GZ_BAIK' => $this->input->post('JML_P_SLTA_GZ_BAIK',true),
				'JML_P_SLTA_GZ_LEBIH' => $this->input->post('JML_P_SLTA_GZ_LEBIH',true),
				'JML_P_SLTA_KON_KESEHATAN' => $this->input->post('JML_P_SLTA_KON_KESEHATAN',true),
				'JML_P_SLTA_ALB_PUSKESMAS' => $this->input->post('JML_P_SLTA_ALB_PUSKESMAS',true),
				'JML_P_SLTA_ALB_DIPERIKSA' => $this->input->post('JML_P_SLTA_ALB_DIPERIKSA',true),
				'JML_P_SLTA_ALB_DIRUJUK' => $this->input->post('JML_P_SLTA_ALB_DIRUJUK',true),
				
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('t_ds_uks', $dataexc);
			
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
				
				'JML_SDMI_UKS' => $this->input->post('JML_SDMI_UKS',true),
				'JML_SKL_DIBINA_PUSKESMAS' => $this->input->post('JML_SKL_DIBINA_PUSKESMAS',true),
				'JML_SKL_PENJARINGAN' => $this->input->post('JML_SKL_PENJARINGAN',true),
				
				//A. SEKOLAH SD/MI DENGAN STANDAR SEKOLAH SEHAT
				'JML_SD_SKL_MINIMAL' => $this->input->post('JML_SD_SKL_MINIMAL',true),
				'JML_SD_SKL_STANDAR' => $this->input->post('JML_SD_SKL_STANDAR',true),
				'JML_SD_SKL_OPTIMAL' => $this->input->post('JML_SD_SKL_OPTIMAL',true),
				'JML_SD_SKL_PARIPURNA' => $this->input->post('JML_SD_SKL_PARIPURNA',true),
				'JML_SD_SKL_GR_UKS' => $this->input->post('JML_SD_SKL_GR_UKS',true),
				'JML_SD_SKL_DANA_SEHAT' => $this->input->post('JML_SD_SKL_DANA_SEHAT',true),
				'JML_SD_SKL_DR_KECIL' => $this->input->post('JML_SD_SKL_DR_KECIL',true),
				'JML_SD_AK_DR_KECIL' => $this->input->post('JML_SD_AK_DR_KECIL',true),
				//LAKI-LAKI
				'JML_L_M_SD_PENGOBATAN' => $this->input->post('JML_L_M_SD_PENGOBATAN',true),
				'JML_L_M_SD_DIRUJUK' => $this->input->post('JML_L_M_SD_DIRUJUK',true),
				'JML_L_M_SD_GZ_BURUK' => $this->input->post('JML_L_M_SD_GZ_BURUK',true),
				'JML_L_M_SD_GZ_KURANG' => $this->input->post('JML_L_M_SD_GZ_KURANG',true),
				'JML_L_M_SD_GZ_BAIK' => $this->input->post('JML_L_M_SD_GZ_BAIK',true),
				'JML_L_M_SD_GZ_LEBIH' => $this->input->post('JML_L_M_SD_GZ_LEBIH',true),
				'JML_L_ALB_SD_PUSKESMAS' => $this->input->post('JML_L_ALB_SD_PUSKESMAS',true),
				'JML_L_ALB_SD_DIPERIKSA' => $this->input->post('JML_L_ALB_SD_DIPERIKSA',true),
				'JML_L_ALB_SD_DIRUJUK' => $this->input->post('JML_L_ALB_SD_DIRUJUK',true),
				'JML_L_SD_BBTSTB' => $this->input->post('JML_L_SD_BBTSTB',true),
				'JML_L_SD_SKL_PUSKESMAS' => $this->input->post('JML_L_SD_SKL_PUSKESMAS',true),
				'JML_L_SD_SKL_DIRUJUK' => $this->input->post('JML_L_SD_SKL_DIRUJUK',true),
				//PEREMPUAN
				'JML_P_M_SD_PENGOBATAN' => $this->input->post('JML_P_M_SD_PENGOBATAN',true),
				'JML_P_M_SD_DIRUJUK' => $this->input->post('JML_P_M_SD_DIRUJUK',true),
				'JML_P_M_SD_GZ_BURUK' => $this->input->post('JML_P_M_SD_GZ_BURUK',true),
				'JML_P_M_SD_GZ_KURANG' => $this->input->post('JML_P_M_SD_GZ_KURANG',true),
				'JML_P_M_SD_GZ_BAIK' => $this->input->post('JML_P_M_SD_GZ_BAIK',true),
				'JML_P_M_SD_GZ_LEBIH' => $this->input->post('JML_P_M_SD_GZ_LEBIH',true),
				'JML_P_SD_KON_KESEHATAN' => $this->input->post('JML_P_SD_KON_KESEHATAN',true),
				'JML_P_ALB_SD_PUSKESMAS' => $this->input->post('JML_P_ALB_SD_PUSKESMAS',true),
				'JML_P_ALB_SD_DIPERIKSA' => $this->input->post('JML_P_ALB_SD_DIPERIKSA',true),
				'JML_P_ALB_SD_DIRUJUK' => $this->input->post('JML_P_ALB_SD_DIRUJUK',true),
				'JML_P_SD_UKS' => $this->input->post('JML_P_SD_UKS',true),
				'JML_P_SD_PUSKESMAS' => $this->input->post('JML_P_SD_PUSKESMAS',true),
				'JML_P_SD_PENJARINGAN' => $this->input->post('JML_P_SD_PENJARINGAN',true),
				'JML_P_SD_BBTSTB' => $this->input->post('JML_P_SD_BBTSTB',true),
				'JML_P_SD_SKL_PUSKESMAS' => $this->input->post('JML_P_SD_SKL_PUSKESMAS',true),
				'JML_P_SD_SKL_DIRUJUK' => $this->input->post('JML_P_SD_SKL_DIRUJUK',true),
				
				//B. SEKOLAH SLTP/MTs DENGAN STANDAR SEKOLAH SEHAT
				'JML_SLTP_SKL_MINIMAL' => $this->input->post('JML_SLTP_SKL_MINIMAL',true),
				'JML_SLTP_SKL_STANDAR' => $this->input->post('JML_SLTP_SKL_STANDAR',true),
				'JML_SLTP_SKL_OPTIMAL' => $this->input->post('JML_SLTP_SKL_OPTIMAL',true),
				'JML_SLTP_SKL_PARIPURNA' => $this->input->post('JML_SLTP_SKL_PARIPURNA',true),
				'JML_SLTP_SKL_GR_UKS' => $this->input->post('JML_SLTP_SKL_GR_UKS',true),
				'JML_SLTP_SKL_DANA_SEHAT' => $this->input->post('JML_SLTP_SKL_DANA_SEHAT',true),
				'JML_SLTP_SKL_KDR_KESEHATAN' => $this->input->post('JML_SLTP_SKL_KDR_KESEHATAN',true),
				'JML_SLTP_SKL_KDR_AKTF' => $this->input->post('JML_SLTP_SKL_KDR_AKTF',true),
				//LAKI-LAKI
				'JML_L_M_SLTP_PENGOBATAN' => $this->input->post('JML_L_M_SLTP_PENGOBATAN',true),
				'JML_L_M_SLTP_DIRUJUK' => $this->input->post('JML_L_M_SLTP_DIRUJUK',true),
				'JML_L_M_SLTP_GZ_BURUK' => $this->input->post('JML_L_M_SLTP_GZ_BURUK',true),
				'JML_L_M_SLTP_GZ_KURANG' => $this->input->post('JML_L_M_SLTP_GZ_KURANG',true),
				'JML_L_M_SLTP_GZ_BAIK' => $this->input->post('JML_L_M_SLTP_GZ_BAIK',true),
				'JML_L_M_SLTP_GZ_LEBIH' => $this->input->post('JML_L_M_SLTP_GZ_LEBIH',true),
				'JML_L_SLTP_ALB_PUSKESMAS' => $this->input->post('JML_L_SLTP_ALB_PUSKESMAS',true),
				'JML_L_SLTP_ALB_DIPERIKSA' => $this->input->post('JML_L_SLTP_ALB_DIPERIKSA',true),
				'JML_L_SLTP_ALB_DIRUJUK' => $this->input->post('JML_L_SLTP_ALB_DIRUJUK',true),
				'JML_L_SLTP_BBTSTB' => $this->input->post('JML_L_SLTP_BBTSTB',true),
				'JML_L_SLTP_DP_PUS_SEKOLAH' => $this->input->post('JML_L_SLTP_DP_PUS_SEKOLAH',true),
				'JML_L_SLTP_DIRUJUK' => $this->input->post('JML_L_SLTP_DIRUJUK',true),
				//PEREMPUAN
				'JML_P_M_SLTP_PENGOBATAN' => $this->input->post('JML_P_M_SLTP_PENGOBATAN',true),
				'JML_P_M_SLTP_DIRUJUK' => $this->input->post('JML_P_M_SLTP_DIRUJUK',true),
				'JML_P_M_SLTP_GZ_BURUK' => $this->input->post('JML_P_M_SLTP_GZ_BURUK',true),
				'JML_P_M_SLTP_GZ_KURANG' => $this->input->post('JML_P_M_SLTP_GZ_KURANG',true),
				'JML_P_M_SLTP_GZ_BAIK' => $this->input->post('JML_P_M_SLTP_GZ_BAIK',true),
				'JML_P_M_SLTP_GZ_LEBIH' => $this->input->post('JML_P_M_SLTP_GZ_LEBIH',true),
				'JML_P_SLTP_KON_KESEHATAN' => $this->input->post('JML_P_SLTP_KON_KESEHATAN',true),
				'JML_P_SLTP_ALB_PUSKESMAS' => $this->input->post('JML_P_SLTP_ALB_PUSKESMAS',true),
				'JML_P_SLTP_ALB_DIPERIKSA' => $this->input->post('JML_P_SLTP_ALB_DIPERIKSA',true),
				'JML_P_SLTP_ALB_DIRUJUK' => $this->input->post('JML_P_SLTP_ALB_DIRUJUK',true),
				'JML_P_SLTP_UKS' => $this->input->post('JML_P_SLTP_UKS',true),
				'JML_P_SLTP_DB_PUSKESMAS' => $this->input->post('JML_P_SLTP_DB_PUSKESMAS',true),
				'JML_P_SLTP_M_PENJARINGAN' => $this->input->post('JML_P_SLTP_M_PENJARINGAN',true),
				'JML_P_SLTP_BBTSTB' => $this->input->post('JML_P_SLTP_BBTSTB',true),
				'JML_P_SLTP_DP_PUS_SEKOLAH' => $this->input->post('JML_P_SLTP_DP_PUS_SEKOLAH',true),
				'JML_P_SLTP_DIRUJUK' => $this->input->post('JML_P_SLTP_DIRUJUK',true),
				
				
				//C. SEKOLAH SLTA/MA DENGAN STANDAR SEKOLAH SEHAT
				'JML_SLTA_SKL_MINIMAL' => $this->input->post('JML_SLTP_SKL_MINIMAL',true),
				'JML_SLTA_SKL_STANDAR' => $this->input->post('JML_SLTP_SKL_STANDAR',true),
				'JML_SLTA_SKL_OPTIMAL' => $this->input->post('JML_SLTA_SKL_OPTIMAL',true),
				'JML_SLTA_SKL_PARIPURNA' => $this->input->post('JML_SLTA_SKL_PARIPURNA',true),
				'JML_SLTA_SKL_GR_UKS' => $this->input->post('JML_SLTA_SKL_GR_UKS',true),
				'JML_SLTA_SKL_DANA_SEHAT' => $this->input->post('JML_SLTA_SKL_DANA_SEHAT',true),
				'JML_SLTA_SKL_KDR_KESEHATAN' => $this->input->post('JML_SLTA_SKL_KDR_KESEHATAN',true),
				'JML_SLTA_SKL_AK_KDR_KESEHATAN' => $this->input->post('JML_SLTA_SKL_AK_KDR_KESEHATAN',true),
				//LAKI-LAKI
				'JML_L_SLTA_PENGOBATAN' => $this->input->post('JML_L_SLTA_PENGOBATAN',true),
				'JML_L_SLTA_DIRUJUK' => $this->input->post('JML_L_SLTA_DIRUJUK',true),
				'JML_L_SLTA_GZ_BURUK' => $this->input->post('JML_L_SLTA_GZ_BURUK',true),
				'JML_L_SLTA_GZ_KURANG' => $this->input->post('JML_L_SLTA_GZ_KURANG',true),
				'JML_L_SLTA_GZ_BAIK' => $this->input->post('JML_L_SLTA_GZ_BAIK',true),
				'JML_L_SLTA_GZ_LEBIH' => $this->input->post('JML_L_SLTA_GZ_LEBIH',true),
				'JML_L_SLTA_ALB_PUSKESMAS' => $this->input->post('JML_L_SLTA_ALB_PUSKESMAS',true),
				'JML_L_SLTA_ALB_DIPERIKSA' => $this->input->post('JML_L_SLTA_ALB_DIPERIKSA',true),
				'JML_L_SLTA_ALB_DIRUJUK' => $this->input->post('JML_L_SLTA_ALB_DIRUJUK',true),
				//PEREMPUAN
				'JML_P_SLTA_PENGOBATAN' => $this->input->post('JML_P_SLTA_PENGOBATAN',true),
				'JML_P_SLTA_DIRUJUK' => $this->input->post('JML_P_SLTA_DIRUJUK',true),
				'JML_P_SLTA_GZ_BURUK' => $this->input->post('JML_P_SLTA_GZ_BURUK',true),
				'JML_P_SLTA_GZ_KURANG' => $this->input->post('JML_P_SLTA_GZ_KURANG',true),
				'JML_P_SLTA_GZ_BAIK' => $this->input->post('JML_P_SLTA_GZ_BAIK',true),
				'JML_P_SLTA_GZ_LEBIH' => $this->input->post('JML_P_SLTA_GZ_LEBIH',true),
				'JML_P_SLTA_KON_KESEHATAN' => $this->input->post('JML_P_SLTA_KON_KESEHATAN',true),
				'JML_P_SLTA_ALB_PUSKESMAS' => $this->input->post('JML_P_SLTA_ALB_PUSKESMAS',true),
				'JML_P_SLTA_ALB_DIPERIKSA' => $this->input->post('JML_P_SLTA_ALB_DIPERIKSA',true),
				'JML_P_SLTA_ALB_DIRUJUK' => $this->input->post('JML_P_SLTA_ALB_DIRUJUK',true),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);
			
			$id=$this->input->post('ID',true);
			
			$db->where('ID',$id);
			$db->update('t_ds_uks', $dataexc);
			
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
						from t_ds_uks t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI						
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('t_ds_uks/v_ds_uks_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from t_ds_uks where ID = '".$id."'")){
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
						from t_ds_uks t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_puskesmas ps on ps.KD_PUSKESMAS=t.KD_PUSKESMAS
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('t_ds_uks/v_ds_uks_detail',$data);
	}
	
}

/* End of file c_ds_uks.php */
/* Location: ./application/controllers/c_ds_uks.php */