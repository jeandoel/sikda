<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_ds_gizi extends CI_Controller {
	public function index()
	{
		$this->load->view('t_ds_gizi/v_ds_gizi');
	}
	
	public function ds_gizixml()
	{
		$this->load->model('t_ds_gizi_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'tahun'=>$this->input->post('tahun'),
					'carinama'=>$this->input->post('carinama')
					);
					
		$total = $this->t_ds_gizi_model->totalds_gizi($paramstotal);
		
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
					
		$result = $this->t_ds_gizi_model->getds_gizi($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_ds_gizi/v_ds_gizi_add');
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
				'BAYI_L_0_6_S' => $this->input->post('BAYI_L_0_6_S',true),
				'BAYI_L_6_12_S' => $this->input->post('BAYI_L_6_12_S',true),
				'ANAK_L_12_36_S' => $this->input->post('ANAK_L_12_36_S',true),
				'ANAK_L_37_60_S' => $this->input->post('ANAK_L_37_60_S',true),
				'BAYI_L_0_12_KMS_K' => $this->input->post('BAYI_L_0_12_KMS_K',true),
				'ANAK_L_12_36_KMS_K' => $this->input->post('ANAK_L_12_36_KMS_K',true),
				'ANAK_L_37_60_KMS_K' => $this->input->post('ANAK_L_37_60_KMS_K',true),
				'BAYI_L_0_12_D' => $this->input->post('BAYI_L_0_12_D',true),
				'ANAK_L_12_36_D' => $this->input->post('ANAK_L_12_36_D',true),
				'ANAK_L_37_60_D' => $this->input->post('ANAK_L_37_60_D',true),
				'BAYI_L_0_12_N' => $this->input->post('BAYI_L_0_12_N',true),
				'ANAK_L_12_36_N' => $this->input->post('ANAK_L_12_36_N',true),
				'ANAK_L_37_60_N' => $this->input->post('ANAK_L_37_60_N',true),
				'BAYI_L_PK_MENIMBANG_B1' => $this->input->post('BAYI_L_PK_MENIMBANG_B1',true),
				'BAYI_L_KK_MENIMBANG_B6' => $this->input->post('BAYI_L_KK_MENIMBANG_B6',true),
				'BAYI_L_0_12_G_BURUK_WHO_NCS' => $this->input->post('BAYI_L_0_12_G_BURUK_WHO_NCS',true),
				'BAYI_L_0_12_G_KURANG' => $this->input->post('BAYI_L_0_12_G_KURANG',true),
				'BAYI_L_0_12_G_BAIK' => $this->input->post('BAYI_L_0_12_G_BAIK',true),
				'BAYI_L_0_12_G_LEBIH' => $this->input->post('BAYI_L_0_12_G_LEBIH',true),
				'ANAK_L_12_36_G_BURUK' => $this->input->post('ANAK_L_12_36_G_BURUK',true),
				'ANAK_L_12_36_G_KURANG' => $this->input->post('ANAK_L_12_36_G_KURANG',true),
				'ANAK_L_12_36_G_BAIK' => $this->input->post('ANAK_L_12_36_G_BAIK',true),
				'ANAK_L_12_36_G_LEBIH' => $this->input->post('ANAK_L_12_36_G_LEBIH',true),
				'ANAK_L_36_60_G_BURUK' => $this->input->post('ANAK_L_36_60_G_BURUK',true),
				'ANAK_L_36_60_G_KURANG' => $this->input->post('ANAK_L_36_60_G_KURANG',true),
				'ANAK_L_36_60_G_BAIK' => $this->input->post('ANAK_L_36_60_G_BAIK',true),
				'ANAK_L_36_60_G_LEBIH' => $this->input->post('ANAK_L_36_60_G_LEBIH',true),
				'BAYI_L_6_12_K_VIT_A' => $this->input->post('BAYI_L_6_12_K_VIT_A',true),
				'ANAK_L_12_60_K_VIT_A' => $this->input->post('ANAK_L_12_60_K_VIT_A',true),
				'BAYI_L_6_ASI_EKSKLUSIF' => $this->input->post('BAYI_L_6_ASI_EKSKLUSIF',true),
				'BAYI_L_BGM_MP_ASI' => $this->input->post('BAYI_L_BGM_MP_ASI',true),
				'BAYI_P_0_6_S' => $this->input->post('BAYI_P_0_6_S',true),
				'BAYI_P_6_12_S' => $this->input->post('BAYI_P_6_12_S',true),
				'ANAK_P_12_36_S' => $this->input->post('ANAK_P_12_36_S',true),
				'ANAK_P_37_60_S' => $this->input->post('ANAK_P_37_60_S',true),
				'BAYI_P_0_12_KMS_K' => $this->input->post('BAYI_P_0_12_KMS_K',true),
				'ANAK_P_12_36_KMS_K' => $this->input->post('ANAK_P_12_36_KMS_K',true),
				'ANAK_P_37_60_KMS_K' => $this->input->post('ANAK_P_37_60_KMS_K',true),
				'BAYI_P_0_12_D' => $this->input->post('BAYI_P_0_12_D',true),
				'ANAK_P_12_36_D' => $this->input->post('ANAK_P_12_36_D',true),
				'ANAK_P_37_60_D' => $this->input->post('ANAK_P_37_60_D',true),
				'BAYI_P_0_12_N' => $this->input->post('BAYI_P_0_12_N',true),
				'ANAK_P_12_36_N' => $this->input->post('ANAK_P_12_36_N',true),
				'ANAK_P_37_60_N' => $this->input->post('ANAK_P_37_60_N',true),
				'BAYI_P_PK_MENIMBANG_B1' => $this->input->post('BAYI_P_PK_MENIMBANG_B1',true),
				'BAYI_P_KK_MENIMBANG_B6' => $this->input->post('BAYI_P_KK_MENIMBANG_B6',true),
				'BAYI_P_0_12_G_BURUK_WHO_NCS' => $this->input->post('BAYI_P_0_12_G_BURUK_WHO_NCS',true),
				'BAYI_P_0_12_G_KURANG' => $this->input->post('BAYI_P_0_12_G_KURANG',true),
				'BAYI_P_0_12_G_BAIK' => $this->input->post('BAYI_P_0_12_G_BAIK',true),
				'BAYI_P_0_12_G_LEBIH' => $this->input->post('BAYI_P_0_12_G_LEBIH',true),
				'ANAK_P_12_36_G_BURUK' => $this->input->post('ANAK_P_12_36_G_BURUK',true),
				'ANAK_P_12_36_G_KURANG' => $this->input->post('ANAK_P_12_36_G_KURANG',true),
				'ANAK_P_12_36_G_BAIK' => $this->input->post('ANAK_P_12_36_G_BAIK',true),
				'ANAK_P_12_36_G_LEBIH' => $this->input->post('ANAK_P_12_36_G_LEBIH',true),
				'ANAK_P_36_60_G_BURUK' => $this->input->post('ANAK_P_36_60_G_BURUK',true),
				'ANAK_P_36_60_G_KURANG' => $this->input->post('ANAK_P_36_60_G_KURANG',true),
				'ANAK_P_36_60_G_BAIK' => $this->input->post('ANAK_P_36_60_G_BAIK',true),
				'ANAK_P_36_60_G_LEBIH' => $this->input->post('ANAK_P_36_60_G_LEBIH',true),
				'BAYI_P_6_12_K_VIT_A' => $this->input->post('BAYI_P_6_12_K_VIT_A',true),
				'ANAK_P_12_60_K_VIT_A' => $this->input->post('ANAK_P_12_60_K_VIT_A',true),
				'BAYI_P_6_ASI_EKSKLUSIF' => $this->input->post('BAYI_P_6_ASI_EKSKLUSIF',true),
				'BAYI_P_BGM_MP_ASI' => $this->input->post('BAYI_P_BGM_MP_ASI',true),
				'IBU_HAMIL_TTD_FE_30' => $this->input->post('IBU_HAMIL_TTD_FE_30',true),
				'IBU_HAMIL_TTD_FE_60' => $this->input->post('IBU_HAMIL_TTD_FE_60',true),
				'IBU_HAMIL_TTD_FE_90' => $this->input->post('IBU_HAMIL_TTD_FE_90',true),
				'BUMIL_KEK_BARU' => $this->input->post('BUMIL_KEK_BARU',true),
				'BUMIL_KEK_LAMA' => $this->input->post('BUMIL_KEK_LAMA',true),
				'VIT_A_100RB_IU' => $this->input->post('VIT_A_100RB_IU',true),
				'VIT_A_200RB_IU' => $this->input->post('VIT_A_200RB_IU',true),
				'P_GONDOK_P_G_0_WUS_BARU' => $this->input->post('P_GONDOK_P_G_0_WUS_BARU',true),
				'P_GONDOK_P_G_1_WUS_BARU' => $this->input->post('P_GONDOK_P_G_1_WUS_BARU',true),
				'P_GONDOK_P_G_2_WUS_BARU' => $this->input->post('P_GONDOK_P_G_2_WUS_BARU',true),
				'P_GONDOK_P_G_0_WUS_LAMA' => $this->input->post('P_GONDOK_P_G_0_WUS_LAMA',true),
				'P_GONDOK_P_G_1_WUS_LAMA' => $this->input->post('P_GONDOK_P_G_1_WUS_LAMA',true),
				'P_GONDOK_P_G_2_WUS_LAMA' => $this->input->post('P_GONDOK_P_G_2_WUS_LAMA',true),
				'BIBIR_SUMBING_L' => $this->input->post('BIBIR_SUMBING_L',true),
				'BIBIR_SUMBING_P' => $this->input->post('BIBIR_SUMBING_P',true),
				'GIZI_BURUK_PERAWATAN_L' => $this->input->post('GIZI_BURUK_PERAWATAN_L',true),
				'GIZI_BURUK_PERAWATAN_P' => $this->input->post('GIZI_BURUK_PERAWATAN_P',true),
				'JML_KEL_SURVEY' => $this->input->post('JML_KEL_SURVEY',true),
				'JML_KEL_GARAM_Y_BAIK' => $this->input->post('JML_KEL_GARAM_Y_BAIK',true),
				'JML_KEL_ENDEMIS_SB' => $this->input->post('JML_KEL_ENDEMIS_SB',true),
				'JML_WUS_KEL_ENDEMIS_SB_YODIUM' => $this->input->post('JML_WUS_KEL_ENDEMIS_SB_YODIUM',true),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('t_ds_gizi', $dataexc);
			
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
				'BAYI_L_0_6_S' => $this->input->post('BAYI_L_0_6_S',true),
				'BAYI_L_6_12_S' => $this->input->post('BAYI_L_6_12_S',true),
				'ANAK_L_12_36_S' => $this->input->post('ANAK_L_12_36_S',true),
				'ANAK_L_37_60_S' => $this->input->post('ANAK_L_37_60_S',true),
				'BAYI_L_0_12_KMS_K' => $this->input->post('BAYI_L_0_12_KMS_K',true),
				'ANAK_L_12_36_KMS_K' => $this->input->post('ANAK_L_12_36_KMS_K',true),
				'ANAK_L_37_60_KMS_K' => $this->input->post('ANAK_L_37_60_KMS_K',true),
				'BAYI_L_0_12_D' => $this->input->post('BAYI_L_0_12_D',true),
				'ANAK_L_12_36_D' => $this->input->post('ANAK_L_12_36_D',true),
				'ANAK_L_37_60_D' => $this->input->post('ANAK_L_37_60_D',true),
				'BAYI_L_0_12_N' => $this->input->post('BAYI_L_0_12_N',true),
				'ANAK_L_12_36_N' => $this->input->post('ANAK_L_12_36_N',true),
				'ANAK_L_37_60_N' => $this->input->post('ANAK_L_37_60_N',true),
				'BAYI_L_PK_MENIMBANG_B1' => $this->input->post('BAYI_L_PK_MENIMBANG_B1',true),
				'BAYI_L_KK_MENIMBANG_B6' => $this->input->post('BAYI_L_KK_MENIMBANG_B6',true),
				'BAYI_L_0_12_G_BURUK_WHO_NCS' => $this->input->post('BAYI_L_0_12_G_BURUK_WHO_NCS',true),
				'BAYI_L_0_12_G_KURANG' => $this->input->post('BAYI_L_0_12_G_KURANG',true),
				'BAYI_L_0_12_G_BAIK' => $this->input->post('BAYI_L_0_12_G_BAIK',true),
				'BAYI_L_0_12_G_LEBIH' => $this->input->post('BAYI_L_0_12_G_LEBIH',true),
				'ANAK_L_12_36_G_BURUK' => $this->input->post('ANAK_L_12_36_G_BURUK',true),
				'ANAK_L_12_36_G_KURANG' => $this->input->post('ANAK_L_12_36_G_KURANG',true),
				'ANAK_L_12_36_G_BAIK' => $this->input->post('ANAK_L_12_36_G_BAIK',true),
				'ANAK_L_12_36_G_LEBIH' => $this->input->post('ANAK_L_12_36_G_LEBIH',true),
				'ANAK_L_36_60_G_BURUK' => $this->input->post('ANAK_L_36_60_G_BURUK',true),
				'ANAK_L_36_60_G_KURANG' => $this->input->post('ANAK_L_36_60_G_KURANG',true),
				'ANAK_L_36_60_G_BAIK' => $this->input->post('ANAK_L_36_60_G_BAIK',true),
				'ANAK_L_36_60_G_LEBIH' => $this->input->post('ANAK_L_36_60_G_LEBIH',true),
				'BAYI_L_6_12_K_VIT_A' => $this->input->post('BAYI_L_6_12_K_VIT_A',true),
				'ANAK_L_12_60_K_VIT_A' => $this->input->post('ANAK_L_12_60_K_VIT_A',true),
				'BAYI_L_6_ASI_EKSKLUSIF' => $this->input->post('BAYI_L_6_ASI_EKSKLUSIF',true),
				'BAYI_L_BGM_MP_ASI' => $this->input->post('BAYI_L_BGM_MP_ASI',true),
				'BAYI_P_0_6_S' => $this->input->post('BAYI_P_0_6_S',true),
				'BAYI_P_6_12_S' => $this->input->post('BAYI_P_6_12_S',true),
				'ANAK_P_12_36_S' => $this->input->post('ANAK_P_12_36_S',true),
				'ANAK_P_37_60_S' => $this->input->post('ANAK_P_37_60_S',true),
				'BAYI_P_0_12_KMS_K' => $this->input->post('BAYI_P_0_12_KMS_K',true),
				'ANAK_P_12_36_KMS_K' => $this->input->post('ANAK_P_12_36_KMS_K',true),
				'ANAK_P_37_60_KMS_K' => $this->input->post('ANAK_P_37_60_KMS_K',true),
				'BAYI_P_0_12_D' => $this->input->post('BAYI_P_0_12_D',true),
				'ANAK_P_12_36_D' => $this->input->post('ANAK_P_12_36_D',true),
				'ANAK_P_37_60_D' => $this->input->post('ANAK_P_37_60_D',true),
				'BAYI_P_0_12_N' => $this->input->post('BAYI_P_0_12_N',true),
				'ANAK_P_12_36_N' => $this->input->post('ANAK_P_12_36_N',true),
				'ANAK_P_37_60_N' => $this->input->post('ANAK_P_37_60_N',true),
				'BAYI_P_PK_MENIMBANG_B1' => $this->input->post('BAYI_P_PK_MENIMBANG_B1',true),
				'BAYI_P_KK_MENIMBANG_B6' => $this->input->post('BAYI_P_KK_MENIMBANG_B6',true),
				'BAYI_P_0_12_G_BURUK_WHO_NCS' => $this->input->post('BAYI_P_0_12_G_BURUK_WHO_NCS',true),
				'BAYI_P_0_12_G_KURANG' => $this->input->post('BAYI_P_0_12_G_KURANG',true),
				'BAYI_P_0_12_G_BAIK' => $this->input->post('BAYI_P_0_12_G_BAIK',true),
				'BAYI_P_0_12_G_LEBIH' => $this->input->post('BAYI_P_0_12_G_LEBIH',true),
				'ANAK_P_12_36_G_BURUK' => $this->input->post('ANAK_P_12_36_G_BURUK',true),
				'ANAK_P_12_36_G_KURANG' => $this->input->post('ANAK_P_12_36_G_KURANG',true),
				'ANAK_P_12_36_G_BAIK' => $this->input->post('ANAK_P_12_36_G_BAIK',true),
				'ANAK_P_12_36_G_LEBIH' => $this->input->post('ANAK_P_12_36_G_LEBIH',true),
				'ANAK_P_36_60_G_BURUK' => $this->input->post('ANAK_P_36_60_G_BURUK',true),
				'ANAK_P_36_60_G_KURANG' => $this->input->post('ANAK_P_36_60_G_KURANG',true),
				'ANAK_P_36_60_G_BAIK' => $this->input->post('ANAK_P_36_60_G_BAIK',true),
				'ANAK_P_36_60_G_LEBIH' => $this->input->post('ANAK_P_36_60_G_LEBIH',true),
				'BAYI_P_6_12_K_VIT_A' => $this->input->post('BAYI_P_6_12_K_VIT_A',true),
				'ANAK_P_12_60_K_VIT_A' => $this->input->post('ANAK_P_12_60_K_VIT_A',true),
				'BAYI_P_6_ASI_EKSKLUSIF' => $this->input->post('BAYI_P_6_ASI_EKSKLUSIF',true),
				'BAYI_P_BGM_MP_ASI' => $this->input->post('BAYI_P_BGM_MP_ASI',true),
				'IBU_HAMIL_TTD_FE_30' => $this->input->post('IBU_HAMIL_TTD_FE_30',true),
				'IBU_HAMIL_TTD_FE_60' => $this->input->post('IBU_HAMIL_TTD_FE_60',true),
				'IBU_HAMIL_TTD_FE_90' => $this->input->post('IBU_HAMIL_TTD_FE_90',true),
				'BUMIL_KEK_BARU' => $this->input->post('BUMIL_KEK_BARU',true),
				'BUMIL_KEK_LAMA' => $this->input->post('BUMIL_KEK_LAMA',true),
				'VIT_A_100RB_IU' => $this->input->post('VIT_A_100RB_IU',true),
				'VIT_A_200RB_IU' => $this->input->post('VIT_A_200RB_IU',true),
				'P_GONDOK_P_G_0_WUS_BARU' => $this->input->post('P_GONDOK_P_G_0_WUS_BARU',true),
				'P_GONDOK_P_G_1_WUS_BARU' => $this->input->post('P_GONDOK_P_G_1_WUS_BARU',true),
				'P_GONDOK_P_G_2_WUS_BARU' => $this->input->post('P_GONDOK_P_G_2_WUS_BARU',true),
				'P_GONDOK_P_G_0_WUS_LAMA' => $this->input->post('P_GONDOK_P_G_0_WUS_LAMA',true),
				'P_GONDOK_P_G_1_WUS_LAMA' => $this->input->post('P_GONDOK_P_G_1_WUS_LAMA',true),
				'P_GONDOK_P_G_2_WUS_LAMA' => $this->input->post('P_GONDOK_P_G_2_WUS_LAMA',true),
				'BIBIR_SUMBING_L' => $this->input->post('BIBIR_SUMBING_L',true),
				'BIBIR_SUMBING_P' => $this->input->post('BIBIR_SUMBING_P',true),
				'GIZI_BURUK_PERAWATAN_L' => $this->input->post('GIZI_BURUK_PERAWATAN_L',true),
				'GIZI_BURUK_PERAWATAN_P' => $this->input->post('GIZI_BURUK_PERAWATAN_P',true),
				'JML_KEL_SURVEY' => $this->input->post('JML_KEL_SURVEY',true),
				'JML_KEL_GARAM_Y_BAIK' => $this->input->post('JML_KEL_GARAM_Y_BAIK',true),
				'JML_KEL_ENDEMIS_SB' => $this->input->post('JML_KEL_ENDEMIS_SB',true),
				'JML_WUS_KEL_ENDEMIS_SB_YODIUM' => $this->input->post('JML_WUS_KEL_ENDEMIS_SB_YODIUM',true),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);
			
			$id=$this->input->post('ID',true);
			
			$db->where('ID',$id);
			$db->update('t_ds_gizi', $dataexc);
			
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
						from t_ds_gizi t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI						
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('t_ds_gizi/v_ds_gizi_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from t_ds_gizi where ID = '".$id."'")){
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
						from t_ds_gizi t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_puskesmas ps on ps.KD_PUSKESMAS=t.KD_PUSKESMAS
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('t_ds_gizi/v_ds_gizi_detail',$data);
	}
	
}

/* End of file c_ds_gizi.php */
/* Location: ./application/controllers/c_ds_gizi.php */