<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_ds_datadasar extends CI_Controller {
	public function index()
	{
		$this->load->view('t_ds_datadasar/v_ds_datadasar');
	}
	
	public function ds_datadasarxml()
	{
		$this->load->model('t_ds_datadasar_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'tahun'=>$this->input->post('tahun'),
					'carinama'=>$this->input->post('carinama')
					);
					
		$total = $this->t_ds_datadasar_model->totalds_datadasar($paramstotal);
		
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
					
		$result = $this->t_ds_datadasar_model->getds_datadasar($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_ds_datadasar/v_ds_datadasar_add');
	}
	
	public function addprocess()
	{	
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('KD_KECAMATAN', 'Kecamatan', 'trim|required|xss_clean');
		$val->set_rules('KD_KELURAHAN', 'Kelurahan', 'trim|required|xss_clean');
		$val->set_rules('KD_PUSKESMAS', 'Puskesmas', 'trim|required|xss_clean');
		$val->set_rules('TAHUN', 'Tahun', 'trim|required|xss_clean');
				
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
				'KD_PROPINSI' 			=> $this->session->userdata('kd_provinsi'),
				'KD_KABUPATEN' 			=> $this->session->userdata('kd_kabupaten'),
				'KD_KECAMATAN' 			=> $val->set_value('KD_KECAMATAN'),
				'KD_KELURAHAN' 			=> $val->set_value('KD_KELURAHAN'),
				'KD_PUSKESMAS' 			=> $val->set_value('KD_PUSKESMAS'),
				'TAHUN' 				=> $val->set_value('TAHUN'),
				'JML_SP_DESA'			=> $this->input->post('JML_SP_DESA',true),
				'JML_SP_RT'				=> $this->input->post('JML_SP_RT',true),
				'JML_SP_RW'				=> $this->input->post('JML_SP_RW',true),
				'JML_SP_KK'				=> $this->input->post('JML_SP_KK',true),
				'JML_SP_L_WILAYAH'		=> $this->input->post('JML_SP_L_WILAYAH',true),
				'JML_L_K1TH'			=> $this->input->post('JML_L_K1TH',true),
				'JML_L_1_4TH'			=> $this->input->post('JML_L_1_4TH',true),
				'JML_L_5_9TH'			=> $this->input->post('JML_L_5_9TH',true),
				'JML_L_10_14TH'			=> $this->input->post('JML_L_10_14TH',true),
				'JML_L_15_19TH'			=> $this->input->post('JML_L_15_19TH',true),
				'JML_L_20_24TH'			=> $this->input->post('JML_L_20_24TH',true),
				'JML_L_25_29TH'			=> $this->input->post('JML_L_25_29TH',true),
				'JML_L_30_34TH'			=> $this->input->post('JML_L_30_34TH',true),
				'JML_L_35_39TH'			=> $this->input->post('JML_L_35_39TH',true),
				'JML_L_40_44TH'			=> $this->input->post('JML_L_40_44TH',true),
				'JML_L_45_49TH'			=> $this->input->post('JML_L_45_49TH',true),
				'JML_L_50_54TH'			=> $this->input->post('JML_L_50_54TH',true),
				'JML_L_55_59TH'			=> $this->input->post('JML_L_55_59TH',true),
				'JML_L_60_64TH'			=> $this->input->post('JML_L_60_64TH',true),
				'JML_L_65_69TH'			=> $this->input->post('JML_L_65_69TH',true),
				'JML_L_70_74TH'			=> $this->input->post('JML_L_70_74TH',true),
				'JML_L_L75TH'			=> $this->input->post('JML_L_L75TH',true),
				'JML_P_K1TH'			=> $this->input->post('JML_P_K1TH',true),
				'JML_P_1_4TH'			=> $this->input->post('JML_P_1_4TH',true),
				'JML_P_5_9TH'			=> $this->input->post('JML_P_5_9TH',true),
				'JML_P_10_14TH'			=> $this->input->post('JML_P_10_14TH',true),
				'JML_P_15_19TH'			=> $this->input->post('JML_P_15_19TH',true),
				'JML_P_20_24TH'			=> $this->input->post('JML_P_20_24TH',true),
				'JML_P_25_29TH'			=> $this->input->post('JML_P_25_29TH',true),
				'JML_P_30_34TH'			=> $this->input->post('JML_P_30_34TH',true),
				'JML_P_35_39TH'			=> $this->input->post('JML_P_35_39TH',true),
				'JML_P_40_44TH'			=> $this->input->post('JML_P_40_44TH',true),
				'JML_P_45_49TH'			=> $this->input->post('JML_P_45_49TH',true),
				'JML_P_50_54TH'			=> $this->input->post('JML_P_50_54TH',true),
				'JML_P_55_59TH'			=> $this->input->post('JML_P_55_59TH',true),
				'JML_P_60_64TH'			=> $this->input->post('JML_P_60_64TH',true),
				'JML_P_65_69TH'			=> $this->input->post('JML_P_65_69TH',true),
				'JML_P_70_74TH'			=> $this->input->post('JML_P_70_74TH',true),
				'JML_P_L75TH'			=> $this->input->post('JML_P_L75TH',true),
				'JML_GA_GAKIN'			=> $this->input->post('JML_GA_GAKIN',true),
				'JML_GA_LAKI'			=> $this->input->post('JML_GA_LAKI',true),
				'JML_GA_PEREMPUAN'		=> $this->input->post('JML_GA_PEREMPUAN',true),
				'JML_SAB_RUMAH'			=> $this->input->post('JML_SAB_RUMAH',true),
				'JML_SAB_SGL'			=> $this->input->post('JML_SAB_SGL',true),
				'JML_SAB_SPT'			=> $this->input->post('JML_SAB_SPT',true),
				'JML_SAB_SR_PDAM'		=> $this->input->post('JML_SAB_SR_PDAM',true),
				'JML_SAB_LAINLAIN'		=> $this->input->post('JML_SAB_LAINLAIN',true),
				'JML_SAB_SPAL'			=> $this->input->post('JML_SAB_SPAL',true),
				'JML_SAB_J_KELUARGA'	=> $this->input->post('JML_SAB_J_KELUARGA',true),
				'JML_SAB_TPA'			=> $this->input->post('JML_SAB_TPA',true),
				'JML_SAB_TPS'			=> $this->input->post('JML_SAB_TPS',true),
				'JML_TTU_TK'			=> $this->input->post('JML_TTU_TK',true),
				'JML_TTU_SD'			=> $this->input->post('JML_TTU_SD',true),
				'JML_TTU_MI'			=> $this->input->post('JML_TTU_MI',true),
				'JML_TTU_SLTP'			=> $this->input->post('JML_TTU_SLTP',true),
				'JML_TTU_MTS'			=> $this->input->post('JML_TTU_MTS',true),
				'JML_TTU_SLTA'			=> $this->input->post('JML_TTU_SLTA',true),
				'JML_TTU_MA'			=> $this->input->post('JML_TTU_MA',true),
				'JML_TTU_P_TINGGI'		=> $this->input->post('JML_TTU_P_TINGGI',true),
				'JML_TTU_KIOS'			=> $this->input->post('JML_TTU_KIOS',true),
				'JML_TTU_H_M_LOSMEN'	=> $this->input->post('JML_TTU_H_M_LOSMEN',true),
				'JML_TTU_SK_P_RAMBUT'	=> $this->input->post('JML_TTU_SK_P_RAMBUT',true),
				'JML_TTU_T_REKREASI'	=> $this->input->post('JML_TTU_T_REKREASI',true),
				'JML_TTU_GP_G_PERTUNJUKAN' => $this->input->post('JML_TTU_GP_G_PERTUNJUKAN',true),
				'JML_TTU_K_RENANG'		=> $this->input->post('JML_TTU_K_RENANG',true),
				'JML_SI_MAS_MUSHOLA'	=> $this->input->post('JML_SI_MAS_MUSHOLA',true),
				'JML_SI_GEREJA'			=> $this->input->post('JML_SI_GEREJA',true),
				'JML_SI_KLENTENG'		=> $this->input->post('JML_SI_KLENTENG',true),
				'JML_SI_VIHARA'			=> $this->input->post('JML_SI_VIHARA',true),
				'JML_SI_PURA'			=> $this->input->post('JML_SI_PURA',true),
				'JML_STR_TERMINAL'		=> $this->input->post('JML_STR_TERMINAL',true),
				'JML_STR_STASIUN'		=> $this->input->post('JML_STR_STASIUN',true),
				'JML_STR_P_LAUT'		=> $this->input->post('JML_STR_P_LAUT',true),
				'JML_SES_PASAR'			=> $this->input->post('JML_SES_PASAR',true),
				'JML_SES_APOTIK'		=> $this->input->post('JML_SES_APOTIK',true),
				'JML_SES_T_OBAT'		=> $this->input->post('JML_SES_T_OBAT',true),
				'JML_SES_P_SOSIAL'		=> $this->input->post('JML_SES_P_SOSIAL',true),
				'JML_SES_S_KESEHATAN'	=> $this->input->post('JML_SES_S_KESEHATAN',true),
				'JML_SES_PERKANTORAN'	=> $this->input->post('JML_SES_PERKANTORAN',true),
				'JML_SES_P_PESANTREN'	=> $this->input->post('JML_SES_P_PESANTREN',true),
				'JML_TPM_W_MAKAN'		=> $this->input->post('JML_TPM_W_MAKAN',true),
				'JML_TPM_R_MAKAN'		=> $this->input->post('JML_TPM_R_MAKAN',true),
				'JML_TPM_JB_CATERING'	=> $this->input->post('JML_TPM_JB_CATERING',true),
				'JML_TPM_IMD_MINUMAN'	=> $this->input->post('JML_TPM_IMD_MINUMAN',true),
				'JML_SASKIA_PUS'		=> $this->input->post('JML_SASKIA_PUS',true),
				'JML_SASKIA_WUS'		=> $this->input->post('JML_SASKIA_WUS',true),
				'JML_L_SASKIA_BAYI'		=> $this->input->post('JML_L_SASKIA_BAYI',true),
				'JML_P_SASKIA_BAYI'		=> $this->input->post('JML_P_SASKIA_BAYI',true),
				'JML_L_SASKIA_BALITA'	=> $this->input->post('JML_L_SASKIA_BALITA',true),
				'JML_P_SASKIA_BALITA'	=> $this->input->post('JML_P_SASKIA_BALITA',true),
				'JML_SASKIA_BUMIL'		=> $this->input->post('JML_SASKIA_BUMIL',true),
				'JML_SASKIA_BULIN'		=> $this->input->post('JML_SASKIA_BULIN',true),
				'JML_SASKIA_BUFAS'		=> $this->input->post('JML_SASKIA_BUFAS',true),
				'JML_SASKIA_K1'			=> $this->input->post('JML_SASKIA_K1',true),
				'JML_SASKIA_K4'			=> $this->input->post('JML_SASKIA_K4',true),
				'JML_SASKIA_KN1'		=> $this->input->post('JML_SASKIA_KN1',true),
				'JML_SASKIA_KN2'		=> $this->input->post('JML_SASKIA_KN2',true),
				'JML_SASKIA_P_NAKES'	=> $this->input->post('JML_SASKIA_P_NAKES',true),
				'JML_SASKIA_RES_NAKES'	=> $this->input->post('JML_SASKIA_RES_NAKES',true),
				'JML_SASKIA_RES_MASYARAKAT'=> $this->input->post('JML_SASKIA_RES_MASYARAKAT',true),
				'JML_SASKIA_P_NON_NAKES'=> $this->input->post('JML_SASKIA_P_NON_NAKES',true),
				'JML_SASKIA_PMPB'		=> $this->input->post('JML_SASKIA_PMPB',true),
				'JML_SASKIA_POSYANDU'	=> $this->input->post('JML_SASKIA_POSYANDU',true),
				'JML_SASKIA_M_TK'		=> $this->input->post('JML_SASKIA_M_TK',true),
				'JML_SASKIA_KADER'		=> $this->input->post('JML_SASKIA_KADER',true),
				'JML_L_SAS_DD_M_TK'		=> $this->input->post('JML_L_SAS_DD_M_TK',true),
				'JML_P_SAS_DD_M_TK'		=> $this->input->post('JML_P_SAS_DD_M_TK',true),
				'JML_L_SAS_DD_MSD_KELAS1'=> $this->input->post('JML_L_SAS_DD_MSD_KELAS1',true),
				'JML_P_SAS_DD_MSD_KELAS1'=> $this->input->post('JML_P_SAS_DD_MSD_KELAS1',true),
				'JML_L_SAS_DD_MSD_KELAS2'=> $this->input->post('JML_L_SAS_DD_MSD_KELAS2',true),
				'JML_P_SAS_DD_MSD_KELAS2'=> $this->input->post('JML_P_SAS_DD_MSD_KELAS2',true),
				'JML_L_SAS_DD_MSD_KELAS3'=> $this->input->post('JML_L_SAS_DD_MSD_KELAS3',true),
				'JML_P_SAS_DD_MSD_KELAS3'=> $this->input->post('JML_P_SAS_DD_MSD_KELAS3',true),
				'ninput_oleh' 			=> $this->session->userdata('nusername'),
				'ninput_tgl' 			=> date('Y-m-d H:i:s')
			);
			
			$db->insert('t_ds_datadasar', $dataexc);
			
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
		//$val->set_rules('BULAN', 'Bulan', 'trim|required|xss_clean');
				
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
				// 'BULAN' => $val->set_value('BULAN'),
				'TAHUN' => $val->set_value('TAHUN'),
				'JML_SP_DESA'			=> $this->input->post('JML_SP_DESA',true),
				'JML_SP_RT'				=> $this->input->post('JML_SP_RT',true),
				'JML_SP_RW'				=> $this->input->post('JML_SP_RW',true),
				'JML_SP_KK'				=> $this->input->post('JML_SP_KK',true),
				'JML_SP_L_WILAYAH'		=> $this->input->post('JML_SP_L_WILAYAH',true),
				'JML_L_K1TH'			=> $this->input->post('JML_L_K1TH',true),
				'JML_L_1_4TH'			=> $this->input->post('JML_L_1_4TH',true),
				'JML_L_5_9TH'			=> $this->input->post('JML_L_5_9TH',true),
				'JML_L_10_14TH'			=> $this->input->post('JML_L_10_14TH',true),
				'JML_L_15_19TH'			=> $this->input->post('JML_L_15_19TH',true),
				'JML_L_20_24TH'			=> $this->input->post('JML_L_20_24TH',true),
				'JML_L_25_29TH'			=> $this->input->post('JML_L_25_29TH',true),
				'JML_L_30_34TH'			=> $this->input->post('JML_L_30_34TH',true),
				'JML_L_35_39TH'			=> $this->input->post('JML_L_35_39TH',true),
				'JML_L_40_44TH'			=> $this->input->post('JML_L_40_44TH',true),
				'JML_L_45_49TH'			=> $this->input->post('JML_L_45_49TH',true),
				'JML_L_50_54TH'			=> $this->input->post('JML_L_50_54TH',true),
				'JML_L_55_59TH'			=> $this->input->post('JML_L_55_59TH',true),
				'JML_L_60_64TH'			=> $this->input->post('JML_L_60_64TH',true),
				'JML_L_65_69TH'			=> $this->input->post('JML_L_65_69TH',true),
				'JML_L_70_74TH'			=> $this->input->post('JML_L_70_74TH',true),
				'JML_L_L75TH'			=> $this->input->post('JML_L_L75TH',true),
				'JML_P_K1TH'			=> $this->input->post('JML_P_K1TH',true),
				'JML_P_1_4TH'			=> $this->input->post('JML_P_1_4TH',true),
				'JML_P_5_9TH'			=> $this->input->post('JML_P_5_9TH',true),
				'JML_P_10_14TH'			=> $this->input->post('JML_P_10_14TH',true),
				'JML_P_15_19TH'			=> $this->input->post('JML_P_15_19TH',true),
				'JML_P_20_24TH'			=> $this->input->post('JML_P_20_24TH',true),
				'JML_P_25_29TH'			=> $this->input->post('JML_P_25_29TH',true),
				'JML_P_30_34TH'			=> $this->input->post('JML_P_30_34TH',true),
				'JML_P_35_39TH'			=> $this->input->post('JML_P_35_39TH',true),
				'JML_P_40_44TH'			=> $this->input->post('JML_P_40_44TH',true),
				'JML_P_45_49TH'			=> $this->input->post('JML_P_45_49TH',true),
				'JML_P_50_54TH'			=> $this->input->post('JML_P_50_54TH',true),
				'JML_P_55_59TH'			=> $this->input->post('JML_P_55_59TH',true),
				'JML_P_60_64TH'			=> $this->input->post('JML_P_60_64TH',true),
				'JML_P_65_69TH'			=> $this->input->post('JML_P_65_69TH',true),
				'JML_P_70_74TH'			=> $this->input->post('JML_P_70_74TH',true),
				'JML_P_L75TH'			=> $this->input->post('JML_P_L75TH',true),
				'JML_GA_GAKIN'			=> $this->input->post('JML_GA_GAKIN',true),
				'JML_GA_LAKI'			=> $this->input->post('JML_GA_LAKI',true),
				'JML_GA_PEREMPUAN'		=> $this->input->post('JML_GA_PEREMPUAN',true),
				'JML_SAB_RUMAH'			=> $this->input->post('JML_SAB_RUMAH',true),
				'JML_SAB_SGL'			=> $this->input->post('JML_SAB_SGL',true),
				'JML_SAB_SPT'			=> $this->input->post('JML_SAB_SPT',true),
				'JML_SAB_SR_PDAM'		=> $this->input->post('JML_SAB_SR_PDAM',true),
				'JML_SAB_LAINLAIN'		=> $this->input->post('JML_SAB_LAINLAIN',true),
				'JML_SAB_SPAL'			=> $this->input->post('JML_SAB_SPAL',true),
				'JML_SAB_J_KELUARGA'	=> $this->input->post('JML_SAB_J_KELUARGA',true),
				'JML_SAB_TPA'			=> $this->input->post('JML_SAB_TPA',true),
				'JML_SAB_TPS'			=> $this->input->post('JML_SAB_TPS',true),
				'JML_TTU_TK'			=> $this->input->post('JML_TTU_TK',true),
				'JML_TTU_SD'			=> $this->input->post('JML_TTU_SD',true),
				'JML_TTU_MI'			=> $this->input->post('JML_TTU_MI',true),
				'JML_TTU_SLTP'			=> $this->input->post('JML_TTU_SLTP',true),
				'JML_TTU_MTS'			=> $this->input->post('JML_TTU_MTS',true),
				'JML_TTU_SLTA'			=> $this->input->post('JML_TTU_SLTA',true),
				'JML_TTU_MA'			=> $this->input->post('JML_TTU_MA',true),
				'JML_TTU_P_TINGGI'		=> $this->input->post('JML_TTU_P_TINGGI',true),
				'JML_TTU_KIOS'			=> $this->input->post('JML_TTU_KIOS',true),
				'JML_TTU_H_M_LOSMEN'	=> $this->input->post('JML_TTU_H_M_LOSMEN',true),
				'JML_TTU_SK_P_RAMBUT'	=> $this->input->post('JML_TTU_SK_P_RAMBUT',true),
				'JML_TTU_T_REKREASI'	=> $this->input->post('JML_TTU_T_REKREASI',true),
				'JML_TTU_GP_G_PERTUNJUKAN' => $this->input->post('JML_TTU_GP_G_PERTUNJUKAN',true),
				'JML_TTU_K_RENANG'		=> $this->input->post('JML_TTU_K_RENANG',true),
				'JML_SI_MAS_MUSHOLA'	=> $this->input->post('JML_SI_MAS_MUSHOLA',true),
				'JML_SI_GEREJA'			=> $this->input->post('JML_SI_GEREJA',true),
				'JML_SI_KLENTENG'		=> $this->input->post('JML_SI_KLENTENG',true),
				'JML_SI_VIHARA'			=> $this->input->post('JML_SI_VIHARA',true),
				'JML_SI_PURA'			=> $this->input->post('JML_SI_PURA',true),
				'JML_STR_TERMINAL'		=> $this->input->post('JML_STR_TERMINAL',true),
				'JML_STR_STASIUN'		=> $this->input->post('JML_STR_STASIUN',true),
				'JML_STR_P_LAUT'		=> $this->input->post('JML_STR_P_LAUT',true),
				'JML_SES_PASAR'			=> $this->input->post('JML_SES_PASAR',true),
				'JML_SES_APOTIK'		=> $this->input->post('JML_SES_APOTIK',true),
				'JML_SES_T_OBAT'		=> $this->input->post('JML_SES_T_OBAT',true),
				'JML_SES_P_SOSIAL'		=> $this->input->post('JML_SES_P_SOSIAL',true),
				'JML_SES_S_KESEHATAN'	=> $this->input->post('JML_SES_S_KESEHATAN',true),
				'JML_SES_PERKANTORAN'	=> $this->input->post('JML_SES_PERKANTORAN',true),
				'JML_SES_P_PESANTREN'	=> $this->input->post('JML_SES_P_PESANTREN',true),
				'JML_TPM_W_MAKAN'		=> $this->input->post('JML_TPM_W_MAKAN',true),
				'JML_TPM_R_MAKAN'		=> $this->input->post('JML_TPM_R_MAKAN',true),
				'JML_TPM_JB_CATERING'	=> $this->input->post('JML_TPM_JB_CATERING',true),
				'JML_TPM_IMD_MINUMAN'	=> $this->input->post('JML_TPM_IMD_MINUMAN',true),
				'JML_SASKIA_PUS'		=> $this->input->post('JML_SASKIA_PUS',true),
				'JML_SASKIA_WUS'		=> $this->input->post('JML_SASKIA_WUS',true),
				'JML_L_SASKIA_BAYI'		=> $this->input->post('JML_L_SASKIA_BAYI',true),
				'JML_P_SASKIA_BAYI'		=> $this->input->post('JML_P_SASKIA_BAYI',true),
				'JML_L_SASKIA_BALITA'	=> $this->input->post('JML_L_SASKIA_BALITA',true),
				'JML_P_SASKIA_BALITA'	=> $this->input->post('JML_P_SASKIA_BALITA',true),
				'JML_SASKIA_BUMIL'		=> $this->input->post('JML_SASKIA_BUMIL',true),
				'JML_SASKIA_BULIN'		=> $this->input->post('JML_SASKIA_BULIN',true),
				'JML_SASKIA_BUFAS'		=> $this->input->post('JML_SASKIA_BUFAS',true),
				'JML_SASKIA_K1'			=> $this->input->post('JML_SASKIA_K1',true),
				'JML_SASKIA_K4'			=> $this->input->post('JML_SASKIA_K4',true),
				'JML_SASKIA_KN1'		=> $this->input->post('JML_SASKIA_KN1',true),
				'JML_SASKIA_KN2'		=> $this->input->post('JML_SASKIA_KN2',true),
				'JML_SASKIA_P_NAKES'	=> $this->input->post('JML_SASKIA_P_NAKES',true),
				'JML_SASKIA_RES_NAKES'	=> $this->input->post('JML_SASKIA_RES_NAKES',true),
				'JML_SASKIA_RES_MASYARAKAT'=> $this->input->post('JML_SASKIA_RES_MASYARAKAT',true),
				'JML_SASKIA_P_NON_NAKES'=> $this->input->post('JML_SASKIA_P_NON_NAKES',true),
				'JML_SASKIA_PMPB'		=> $this->input->post('JML_SASKIA_PMPB',true),
				'JML_SASKIA_POSYANDU'	=> $this->input->post('JML_SASKIA_POSYANDU',true),
				'JML_SASKIA_M_TK'		=> $this->input->post('JML_SASKIA_M_TK',true),
				'JML_SASKIA_KADER'		=> $this->input->post('JML_SASKIA_KADER',true),
				'JML_L_SAS_DD_M_TK'		=> $this->input->post('JML_L_SAS_DD_M_TK',true),
				'JML_P_SAS_DD_M_TK'		=> $this->input->post('JML_P_SAS_DD_M_TK',true),
				'JML_L_SAS_DD_MSD_KELAS1'=> $this->input->post('JML_L_SAS_DD_MSD_KELAS1',true),
				'JML_P_SAS_DD_MSD_KELAS1'=> $this->input->post('JML_P_SAS_DD_MSD_KELAS1',true),
				'JML_L_SAS_DD_MSD_KELAS2'=> $this->input->post('JML_L_SAS_DD_MSD_KELAS2',true),
				'JML_P_SAS_DD_MSD_KELAS2'=> $this->input->post('JML_P_SAS_DD_MSD_KELAS2',true),
				'JML_L_SAS_DD_MSD_KELAS3'=> $this->input->post('JML_L_SAS_DD_MSD_KELAS3',true),
				'JML_P_SAS_DD_MSD_KELAS3'=> $this->input->post('JML_P_SAS_DD_MSD_KELAS3',true),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);
			
			$id=$this->input->post('ID',true);
			
			$db->where('ID',$id);
			$db->update('t_ds_datadasar', $dataexc);
			
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
						from t_ds_datadasar t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI						
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('t_ds_datadasar/v_ds_datadasar_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from t_ds_datadasar where ID = '".$id."'")){
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
						from t_ds_datadasar t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_puskesmas ps on ps.KD_PUSKESMAS=t.KD_PUSKESMAS
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('t_ds_datadasar/v_ds_datadasar_detail',$data);
	}
	
}

/* End of file c_ds_datadasar.php */
/* Location: ./application/controllers/c_ds_datadasar.php */