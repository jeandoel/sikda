<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_ds_imunisasi extends CI_Controller {
	public function index()
	{
		$this->load->view('t_ds_imunisasi/v_ds_imunisasi');
	}
	
	public function ds_imunisasixml()
	{
		$this->load->model('t_ds_imunisasi_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'tahun'=>$this->input->post('tahun'),
					'carinama'=>$this->input->post('carinama')
					);
					
		$total = $this->t_ds_imunisasi_model->totalds_imunisasi($paramstotal);
		
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
					
		$result = $this->t_ds_imunisasi_model->getds_imunisasi($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_ds_imunisasi/v_ds_imunisasi_add');
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
				'JML_IMUN_BCG_L' => $this->input->post('JML_IMUN_BCG_L',true),
				'JML_IMUN_DPT1_L' => $this->input->post('JML_IMUN_DPT1_L',true),
				'JML_IMUN_DPT2_L' => $this->input->post('JML_IMUN_DPT2_L',true),
				'JML_IMUN_DPT3_L' => $this->input->post('JML_IMUN_DPT3_L',true),
				'JML_IMUN_DPT_HB1_L' => $this->input->post('JML_IMUN_DPT_HB1_L',true),
				'JML_IMUN_DPT_HB2_L' => $this->input->post('JML_IMUN_DPT_HB2_L',true),
				'JML_IMUN_DPT_HB3_L' => $this->input->post('JML_IMUN_DPT_HB3_L',true),
				'JML_IMUN_POLIO1_L' => $this->input->post('JML_IMUN_POLIO1_L',true),
				'JML_IMUN_POLIO2_L' => $this->input->post('JML_IMUN_POLIO2_L',true),
				'JML_IMUN_POLIO3_L' => $this->input->post('JML_IMUN_POLIO3_L',true),
				'JML_IMUN_POLIO4_L' => $this->input->post('JML_IMUN_POLIO4_L',true),
				'JML_IMUN_CAMPAK_L' => $this->input->post('JML_IMUN_CAMPAK_L',true),
				'JML_IMUN_HBU_M7_L' => $this->input->post('JML_IMUN_HBU_M7_L',true),
				'JML_IMUN_HBU_P7_L' => $this->input->post('JML_IMUN_HBU_P7_L',true),
				'JML_IMUN_HB_UNIJECT2_L' => $this->input->post('JML_IMUN_HB_UNIJECT2_L',true),
				'JML_IMUN_HB_UNIJECT3_L' => $this->input->post('JML_IMUN_HB_UNIJECT3_L',true),
				'JML_IMUN_HB_VIAL1_L' => $this->input->post('JML_IMUN_HB_VIAL1_L',true),
				'JML_IMUN_HB_VIAL2_L' => $this->input->post('JML_IMUN_HB_VIAL2_L',true),
				'JML_IMUN_HB_VIAL3_L' => $this->input->post('JML_IMUN_HB_VIAL3_L',true),
				'JML_IMUN_BCG_P' => $this->input->post('JML_IMUN_BCG_P',true),
				'JML_IMUN_DPT1_P' => $this->input->post('JML_IMUN_DPT1_P',true),
				'JML_IMUN_DPT2_P' => $this->input->post('JML_IMUN_DPT2_P',true),
				'JML_IMUN_DPT3_P' => $this->input->post('JML_IMUN_DPT3_P',true),
				'JML_IMUN_DPT_HB1_P' => $this->input->post('JML_IMUN_DPT_HB1_P',true),
				'JML_IMUN_DPT_HB2_P' => $this->input->post('JML_IMUN_DPT_HB2_P',true),
				'JML_IMUN_DPT_HB3_P' => $this->input->post('JML_IMUN_DPT_HB3_P',true),
				'JML_IMUN_POLIO1_P' => $this->input->post('JML_IMUN_POLIO1_P',true),
				'JML_IMUN_POLIO2_P' => $this->input->post('JML_IMUN_POLIO2_P',true),
				'JML_IMUN_POLIO3_P' => $this->input->post('JML_IMUN_POLIO3_P',true),
				'JML_IMUN_POLIO4_P' => $this->input->post('JML_IMUN_POLIO4_P',true),
				'JML_IMUN_CAMPAK_P' => $this->input->post('JML_IMUN_CAMPAK_P',true),
				'JML_IMUN_HBU_M7_P' => $this->input->post('JML_IMUN_HBU_M7_P',true),
				'JML_IMUN_HBU_P7_P' => $this->input->post('JML_IMUN_HBU_P7_P',true),
				'JML_IMUN_HB_UNIJECT2_P' => $this->input->post('JML_IMUN_HB_UNIJECT2_P',true),
				'JML_IMUN_HB_UNIJECT3_P' => $this->input->post('JML_IMUN_HB_UNIJECT3_P',true),
				'JML_IMUN_HB_VIAL1_P' => $this->input->post('JML_IMUN_HB_VIAL1_P',true),
				'JML_IMUN_HB_VIAL2_P' => $this->input->post('JML_IMUN_HB_VIAL2_P',true),
				'JML_IMUN_HB_VIAL3_P' => $this->input->post('JML_IMUN_HB_VIAL3_P',true),
				'JML_IMUN_TT1_HAMIL_P' => $this->input->post('JML_IMUN_TT1_HAMIL_P',true),
				'JML_IMUN_TT1_WUS_P' => $this->input->post('JML_IMUN_TT1_WUS_P',true),
				'JML_IMUN_TT2_HAMIL_P' => $this->input->post('JML_IMUN_TT2_HAMIL_P',true),
				'JML_IMUN_TT2_WUS_P' => $this->input->post('JML_IMUN_TT2_WUS_P',true),
				'JML_IMUN_TT3_HAMIL_P' => $this->input->post('JML_IMUN_TT3_HAMIL_P',true),
				'JML_IMUN_TT3_WUS_P' => $this->input->post('JML_IMUN_TT3_WUS_P',true),
				'JML_IMUN_TT4_HAMIL_P' => $this->input->post('JML_IMUN_TT4_HAMIL_P',true),
				'JML_IMUN_TT4_WUS_P' => $this->input->post('JML_IMUN_TT4_WUS_P',true),
				'JML_IMUN_TT5_HAMIL_P' => $this->input->post('JML_IMUN_TT5_HAMIL_P',true),
				'JML_IMUN_TT5_WUS_P' => $this->input->post('JML_IMUN_TT5_WUS_P',true),
				'JML_IMUN_BCGL_WILAYAH_L' => $this->input->post('JML_IMUN_BCGL_WILAYAH_L',true),
				'JML_IMUN_DPT1L_WILAYAH_L' => $this->input->post('JML_IMUN_DPT1L_WILAYAH_L',true),
				'JML_IMUN_DPT2L_WILAYAH_L' => $this->input->post('JML_IMUN_DPT2L_WILAYAH_L',true),
				'JML_IMUN_DPT3L_WILAYAH_L' => $this->input->post('JML_IMUN_DPT3L_WILAYAH_L',true),
				'JML_IMUN_DPT_HB1L_WILAYAH_L' => $this->input->post('JML_IMUN_DPT_HB1L_WILAYAH_L',true),
				'JML_IMUN_DPT_HB2L_WILAYAH_L' => $this->input->post('JML_IMUN_DPT_HB2L_WILAYAH_L',true),
				'JML_IMUN_DPT_HB3L_WILAYAH_L' => $this->input->post('JML_IMUN_DPT_HB3L_WILAYAH_L',true),
				'JML_IMUN_CL_WILAYAH_L' => $this->input->post('JML_IMUN_CL_WILAYAH_L',true),
				'JML_IMUN_P1L_WILAYAH_L' => $this->input->post('JML_IMUN_P1L_WILAYAH_L',true),
				'JML_IMUN_P2L_WILAYAH_L' => $this->input->post('JML_IMUN_P2L_WILAYAH_L',true),
				'JML_IMUN_P3L_WILAYAH_L' => $this->input->post('JML_IMUN_P3L_WILAYAH_L',true),
				'JML_IMUN_P4L_WILAYAH_L' => $this->input->post('JML_IMUN_P4L_WILAYAH_L',true),
				'JML_IMUN_HBU_M7L_WILAYAH_L' => $this->input->post('JML_IMUN_HBU_M7L_WILAYAH_L',true),
				'JML_IMUN_HBU_P7L_WILAYAH_L' => $this->input->post('JML_IMUN_HBU_P7L_WILAYAH_L',true),
				'JML_IMUN_HBU2L_WILAYAH_L' => $this->input->post('JML_IMUN_HBU2L_WILAYAH_L',true),
				'JML_IMUN_HBU3L_WILAYAH_L' => $this->input->post('JML_IMUN_HBU3L_WILAYAH_L',true),
				'JML_IMUN_HBV1L_WILAYAH_L' => $this->input->post('JML_IMUN_HBV1L_WILAYAH_L',true),
				'JML_IMUN_HBV2L_WILAYAH_L' => $this->input->post('JML_IMUN_HBV2L_WILAYAH_L',true),
				'JML_IMUN_HBV3L_WILAYAH_L' => $this->input->post('JML_IMUN_HBV3L_WILAYAH_L',true),
				'JML_IMUN_BCGL_WILAYAH_P' => $this->input->post('JML_IMUN_BCGL_WILAYAH_P',true),
				'JML_IMUN_DPT1L_WILAYAH_P' => $this->input->post('JML_IMUN_DPT1L_WILAYAH_P',true),
				'JML_IMUN_DPT2L_WILAYAH_P' => $this->input->post('JML_IMUN_DPT2L_WILAYAH_P',true),
				'JML_IMUN_DPT3L_WILAYAH_P' => $this->input->post('JML_IMUN_DPT3L_WILAYAH_P',true),
				'JML_IMUN_DPT_HB1L_WILAYAH_P' => $this->input->post('JML_IMUN_DPT_HB1L_WILAYAH_P',true),
				'JML_IMUN_DPT_HB2L_WILAYAH_P' => $this->input->post('JML_IMUN_DPT_HB2L_WILAYAH_P',true),
				'JML_IMUN_DPT_HB3L_WILAYAH_P' => $this->input->post('JML_IMUN_DPT_HB3L_WILAYAH_P',true),
				'JML_IMUN_CL_WILAYAH_P' => $this->input->post('JML_IMUN_CL_WILAYAH_P',true),
				'JML_IMUN_P1L_WILAYAH_P' => $this->input->post('JML_IMUN_P1L_WILAYAH_P',true),
				'JML_IMUN_P2L_WILAYAH_P' => $this->input->post('JML_IMUN_P2L_WILAYAH_P',true),
				'JML_IMUN_P3L_WILAYAH_P' => $this->input->post('JML_IMUN_P3L_WILAYAH_P',true),
				'JML_IMUN_P4L_WILAYAH_P' => $this->input->post('JML_IMUN_P4L_WILAYAH_P',true),
				'JML_IMUN_HBU_M7L_WILAYAH_P' => $this->input->post('JML_IMUN_HBU_M7L_WILAYAH_P',true),
				'JML_IMUN_HBU_P7L_WILAYAH_P' => $this->input->post('JML_IMUN_HBU_P7L_WILAYAH_P',true),
				'JML_IMUN_HBU2L_WILAYAH_P' => $this->input->post('JML_IMUN_HBU2L_WILAYAH_P',true),
				'JML_IMUN_HBU3L_WILAYAH_P' => $this->input->post('JML_IMUN_HBU3L_WILAYAH_P',true),
				'JML_IMUN_HBV1L_WILAYAH_P' => $this->input->post('JML_IMUN_HBV1L_WILAYAH_P',true),
				'JML_IMUN_HBV2L_WILAYAH_P' => $this->input->post('JML_IMUN_HBV2L_WILAYAH_P',true),
				'JML_IMUN_HBV3L_WILAYAH_P' => $this->input->post('JML_IMUN_HBV3L_WILAYAH_P',true),
				'JML_IMUN_TT1IHL_WILAYAH_P' => $this->input->post('JML_IMUN_TT1IHL_WILAYAH_P',true),
				'JML_IMUN_TT1WL_WILAYAH_P' => $this->input->post('JML_IMUN_TT1WL_WILAYAH_P',true),
				'JML_IMUN_TT2IHL_WILAYAH_P' => $this->input->post('JML_IMUN_TT2IHL_WILAYAH_P',true),
				'JML_IMUN_TT2WL_WILAYAH_P' => $this->input->post('JML_IMUN_TT2WL_WILAYAH_P',true),
				'JML_IMUN_TT3IHL_WILAYAH_P' => $this->input->post('JML_IMUN_TT3IHL_WILAYAH_P',true),
				'JML_IMUN_TT3WL_WILAYAH_P' => $this->input->post('JML_IMUN_TT3WL_WILAYAH_P',true),
				'JML_IMUN_TT4IHL_WILAYAH_P' => $this->input->post('JML_IMUN_TT4IHL_WILAYAH_P',true),
				'JML_IMUN_TT4WL_WILAYAH_P' => $this->input->post('JML_IMUN_TT4WL_WILAYAH_P',true),
				'JML_IMUN_TT5IHL_WILAYAH_P' => $this->input->post('JML_IMUN_TT5IHL_WILAYAH_P',true),
				'JML_IMUN_TT5WL_WILAYAH_P' => $this->input->post('JML_IMUN_TT5WL_WILAYAH_P',true),
				'JML_VBCG_TERIMA' => $this->input->post('JML_VBCG_TERIMA',true),
				'JML_VDPT_TERIMA' => $this->input->post('JML_VDPT_TERIMA',true),
				'JML_VDPTHB_TERIMA' => $this->input->post('JML_VDPTHB_TERIMA',true),
				'JML_VP_TERIMA' => $this->input->post('JML_VP_TERIMA',true),
				'JML_VC_TERIMA' => $this->input->post('JML_VC_TERIMA',true),
				'JML_VHBU_TERIMA' => $this->input->post('JML_VHBU_TERIMA',true),
				'JML_VHBV_TERIMA' => $this->input->post('JML_VHBV_TERIMA',true),
				'JML_VTT_TERIMA' => $this->input->post('JML_VTT_TERIMA',true),
				'JML_VDT_TERIMA' => $this->input->post('JML_VDT_TERIMA',true),
				'JML_VBCG_DIPAKAI' => $this->input->post('JML_VBCG_DIPAKAI',true),
				'JML_VDPT_DIPAKAI' => $this->input->post('JML_VDPT_DIPAKAI',true),
				'JML_VDPTHB_DIPAKAI' => $this->input->post('JML_VDPTHB_DIPAKAI',true),
				'JML_VP_DIPAKAI' => $this->input->post('JML_VP_DIPAKAI',true),
				'JML_VC_DIPAKAI' => $this->input->post('JML_VC_DIPAKAI',true),
				'JML_VHBU_DIPAKAI' => $this->input->post('JML_VHBU_DIPAKAI',true),
				'JML_VHBV_DIPAKAI' => $this->input->post('JML_VHBV_DIPAKAI',true),
				'JML_VTT_DIPAKAI' => $this->input->post('JML_VTT_DIPAKAI',true),
				'JML_VDT_DIPAKAI' => $this->input->post('JML_VDT_DIPAKAI',true),
				'JML_VDT1_ANAKSEKOLAH' => $this->input->post('JML_VDT1_ANAKSEKOLAH',true),
				'JML_VDT2_ANAKSEKOLAH' => $this->input->post('JML_VDT2_ANAKSEKOLAH',true),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('t_ds_imunisasi', $dataexc);
			
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
				'JML_IMUN_BCG_L' => $this->input->post('JML_IMUN_BCG_L',true),
				'JML_IMUN_DPT1_L' => $this->input->post('JML_IMUN_DPT1_L',true),
				'JML_IMUN_DPT2_L' => $this->input->post('JML_IMUN_DPT2_L',true),
				'JML_IMUN_DPT3_L' => $this->input->post('JML_IMUN_DPT3_L',true),
				'JML_IMUN_DPT_HB1_L' => $this->input->post('JML_IMUN_DPT_HB1_L',true),
				'JML_IMUN_DPT_HB2_L' => $this->input->post('JML_IMUN_DPT_HB2_L',true),
				'JML_IMUN_DPT_HB3_L' => $this->input->post('JML_IMUN_DPT_HB3_L',true),
				'JML_IMUN_POLIO1_L' => $this->input->post('JML_IMUN_POLIO1_L',true),
				'JML_IMUN_POLIO2_L' => $this->input->post('JML_IMUN_POLIO2_L',true),
				'JML_IMUN_POLIO3_L' => $this->input->post('JML_IMUN_POLIO3_L',true),
				'JML_IMUN_POLIO4_L' => $this->input->post('JML_IMUN_POLIO4_L',true),
				'JML_IMUN_CAMPAK_L' => $this->input->post('JML_IMUN_CAMPAK_L',true),
				'JML_IMUN_HBU_M7_L' => $this->input->post('JML_IMUN_HBU_M7_L',true),
				'JML_IMUN_HBU_P7_L' => $this->input->post('JML_IMUN_HBU_P7_L',true),
				'JML_IMUN_HB_UNIJECT2_L' => $this->input->post('JML_IMUN_HB_UNIJECT2_L',true),
				'JML_IMUN_HB_UNIJECT3_L' => $this->input->post('JML_IMUN_HB_UNIJECT3_L',true),
				'JML_IMUN_HB_VIAL1_L' => $this->input->post('JML_IMUN_HB_VIAL1_L',true),
				'JML_IMUN_HB_VIAL2_L' => $this->input->post('JML_IMUN_HB_VIAL2_L',true),
				'JML_IMUN_HB_VIAL3_L' => $this->input->post('JML_IMUN_HB_VIAL3_L',true),
				'JML_IMUN_BCG_P' => $this->input->post('JML_IMUN_BCG_P',true),
				'JML_IMUN_DPT1_P' => $this->input->post('JML_IMUN_DPT1_P',true),
				'JML_IMUN_DPT2_P' => $this->input->post('JML_IMUN_DPT2_P',true),
				'JML_IMUN_DPT3_P' => $this->input->post('JML_IMUN_DPT3_P',true),
				'JML_IMUN_DPT_HB1_P' => $this->input->post('JML_IMUN_DPT_HB1_P',true),
				'JML_IMUN_DPT_HB2_P' => $this->input->post('JML_IMUN_DPT_HB2_P',true),
				'JML_IMUN_DPT_HB3_P' => $this->input->post('JML_IMUN_DPT_HB3_P',true),
				'JML_IMUN_POLIO1_P' => $this->input->post('JML_IMUN_POLIO1_P',true),
				'JML_IMUN_POLIO2_P' => $this->input->post('JML_IMUN_POLIO2_P',true),
				'JML_IMUN_POLIO3_P' => $this->input->post('JML_IMUN_POLIO3_P',true),
				'JML_IMUN_POLIO4_P' => $this->input->post('JML_IMUN_POLIO4_P',true),
				'JML_IMUN_CAMPAK_P' => $this->input->post('JML_IMUN_CAMPAK_P',true),
				'JML_IMUN_HBU_M7_P' => $this->input->post('JML_IMUN_HBU_M7_P',true),
				'JML_IMUN_HBU_P7_P' => $this->input->post('JML_IMUN_HBU_P7_P',true),
				'JML_IMUN_HB_UNIJECT2_P' => $this->input->post('JML_IMUN_HB_UNIJECT2_P',true),
				'JML_IMUN_HB_UNIJECT3_P' => $this->input->post('JML_IMUN_HB_UNIJECT3_P',true),
				'JML_IMUN_HB_VIAL1_P' => $this->input->post('JML_IMUN_HB_VIAL1_P',true),
				'JML_IMUN_HB_VIAL2_P' => $this->input->post('JML_IMUN_HB_VIAL2_P',true),
				'JML_IMUN_HB_VIAL3_P' => $this->input->post('JML_IMUN_HB_VIAL3_P',true),
				'JML_IMUN_TT1_HAMIL_P' => $this->input->post('JML_IMUN_TT1_HAMIL_P',true),
				'JML_IMUN_TT1_WUS_P' => $this->input->post('JML_IMUN_TT1_WUS_P',true),
				'JML_IMUN_TT2_HAMIL_P' => $this->input->post('JML_IMUN_TT2_HAMIL_P',true),
				'JML_IMUN_TT2_WUS_P' => $this->input->post('JML_IMUN_TT2_WUS_P',true),
				'JML_IMUN_TT3_HAMIL_P' => $this->input->post('JML_IMUN_TT3_HAMIL_P',true),
				'JML_IMUN_TT3_WUS_P' => $this->input->post('JML_IMUN_TT3_WUS_P',true),
				'JML_IMUN_TT4_HAMIL_P' => $this->input->post('JML_IMUN_TT4_HAMIL_P',true),
				'JML_IMUN_TT4_WUS_P' => $this->input->post('JML_IMUN_TT4_WUS_P',true),
				'JML_IMUN_TT5_HAMIL_P' => $this->input->post('JML_IMUN_TT5_HAMIL_P',true),
				'JML_IMUN_TT5_WUS_P' => $this->input->post('JML_IMUN_TT5_WUS_P',true),
				'JML_IMUN_BCGL_WILAYAH_L' => $this->input->post('JML_IMUN_BCGL_WILAYAH_L',true),
				'JML_IMUN_DPT1L_WILAYAH_L' => $this->input->post('JML_IMUN_DPT1L_WILAYAH_L',true),
				'JML_IMUN_DPT2L_WILAYAH_L' => $this->input->post('JML_IMUN_DPT2L_WILAYAH_L',true),
				'JML_IMUN_DPT3L_WILAYAH_L' => $this->input->post('JML_IMUN_DPT3L_WILAYAH_L',true),
				'JML_IMUN_DPT_HB1L_WILAYAH_L' => $this->input->post('JML_IMUN_DPT_HB1L_WILAYAH_L',true),
				'JML_IMUN_DPT_HB2L_WILAYAH_L' => $this->input->post('JML_IMUN_DPT_HB2L_WILAYAH_L',true),
				'JML_IMUN_DPT_HB3L_WILAYAH_L' => $this->input->post('JML_IMUN_DPT_HB3L_WILAYAH_L',true),
				'JML_IMUN_CL_WILAYAH_L' => $this->input->post('JML_IMUN_CL_WILAYAH_L',true),
				'JML_IMUN_P1L_WILAYAH_L' => $this->input->post('JML_IMUN_P1L_WILAYAH_L',true),
				'JML_IMUN_P2L_WILAYAH_L' => $this->input->post('JML_IMUN_P2L_WILAYAH_L',true),
				'JML_IMUN_P3L_WILAYAH_L' => $this->input->post('JML_IMUN_P3L_WILAYAH_L',true),
				'JML_IMUN_P4L_WILAYAH_L' => $this->input->post('JML_IMUN_P4L_WILAYAH_L',true),
				'JML_IMUN_HBU_M7L_WILAYAH_L' => $this->input->post('JML_IMUN_HBU_M7L_WILAYAH_L',true),
				'JML_IMUN_HBU_P7L_WILAYAH_L' => $this->input->post('JML_IMUN_HBU_P7L_WILAYAH_L',true),
				'JML_IMUN_HBU2L_WILAYAH_L' => $this->input->post('JML_IMUN_HBU2L_WILAYAH_L',true),
				'JML_IMUN_HBU3L_WILAYAH_L' => $this->input->post('JML_IMUN_HBU3L_WILAYAH_L',true),
				'JML_IMUN_HBV1L_WILAYAH_L' => $this->input->post('JML_IMUN_HBV1L_WILAYAH_L',true),
				'JML_IMUN_HBV2L_WILAYAH_L' => $this->input->post('JML_IMUN_HBV2L_WILAYAH_L',true),
				'JML_IMUN_HBV3L_WILAYAH_L' => $this->input->post('JML_IMUN_HBV3L_WILAYAH_L',true),
				'JML_IMUN_BCGL_WILAYAH_P' => $this->input->post('JML_IMUN_BCGL_WILAYAH_P',true),
				'JML_IMUN_DPT1L_WILAYAH_P' => $this->input->post('JML_IMUN_DPT1L_WILAYAH_P',true),
				'JML_IMUN_DPT2L_WILAYAH_P' => $this->input->post('JML_IMUN_DPT2L_WILAYAH_P',true),
				'JML_IMUN_DPT3L_WILAYAH_P' => $this->input->post('JML_IMUN_DPT3L_WILAYAH_P',true),
				'JML_IMUN_DPT_HB1L_WILAYAH_P' => $this->input->post('JML_IMUN_DPT_HB1L_WILAYAH_P',true),
				'JML_IMUN_DPT_HB2L_WILAYAH_P' => $this->input->post('JML_IMUN_DPT_HB2L_WILAYAH_P',true),
				'JML_IMUN_DPT_HB3L_WILAYAH_P' => $this->input->post('JML_IMUN_DPT_HB3L_WILAYAH_P',true),
				'JML_IMUN_CL_WILAYAH_P' => $this->input->post('JML_IMUN_CL_WILAYAH_P',true),
				'JML_IMUN_P1L_WILAYAH_P' => $this->input->post('JML_IMUN_P1L_WILAYAH_P',true),
				'JML_IMUN_P2L_WILAYAH_P' => $this->input->post('JML_IMUN_P2L_WILAYAH_P',true),
				'JML_IMUN_P3L_WILAYAH_P' => $this->input->post('JML_IMUN_P3L_WILAYAH_P',true),
				'JML_IMUN_P4L_WILAYAH_P' => $this->input->post('JML_IMUN_P4L_WILAYAH_P',true),
				'JML_IMUN_HBU_M7L_WILAYAH_P' => $this->input->post('JML_IMUN_HBU_M7L_WILAYAH_P',true),
				'JML_IMUN_HBU_P7L_WILAYAH_P' => $this->input->post('JML_IMUN_HBU_P7L_WILAYAH_P',true),
				'JML_IMUN_HBU2L_WILAYAH_P' => $this->input->post('JML_IMUN_HBU2L_WILAYAH_P',true),
				'JML_IMUN_HBU3L_WILAYAH_P' => $this->input->post('JML_IMUN_HBU3L_WILAYAH_P',true),
				'JML_IMUN_HBV1L_WILAYAH_P' => $this->input->post('JML_IMUN_HBV1L_WILAYAH_P',true),
				'JML_IMUN_HBV2L_WILAYAH_P' => $this->input->post('JML_IMUN_HBV2L_WILAYAH_P',true),
				'JML_IMUN_HBV3L_WILAYAH_P' => $this->input->post('JML_IMUN_HBV3L_WILAYAH_P',true),
				'JML_IMUN_TT1IHL_WILAYAH_P' => $this->input->post('JML_IMUN_TT1IHL_WILAYAH_P',true),
				'JML_IMUN_TT1WL_WILAYAH_P' => $this->input->post('JML_IMUN_TT1WL_WILAYAH_P',true),
				'JML_IMUN_TT2IHL_WILAYAH_P' => $this->input->post('JML_IMUN_TT2IHL_WILAYAH_P',true),
				'JML_IMUN_TT2WL_WILAYAH_P' => $this->input->post('JML_IMUN_TT2WL_WILAYAH_P',true),
				'JML_IMUN_TT3IHL_WILAYAH_P' => $this->input->post('JML_IMUN_TT3IHL_WILAYAH_P',true),
				'JML_IMUN_TT3WL_WILAYAH_P' => $this->input->post('JML_IMUN_TT3WL_WILAYAH_P',true),
				'JML_IMUN_TT4IHL_WILAYAH_P' => $this->input->post('JML_IMUN_TT4IHL_WILAYAH_P',true),
				'JML_IMUN_TT4WL_WILAYAH_P' => $this->input->post('JML_IMUN_TT4WL_WILAYAH_P',true),
				'JML_IMUN_TT5IHL_WILAYAH_P' => $this->input->post('JML_IMUN_TT5IHL_WILAYAH_P',true),
				'JML_IMUN_TT5WL_WILAYAH_P' => $this->input->post('JML_IMUN_TT5WL_WILAYAH_P',true),
				'JML_VBCG_TERIMA' => $this->input->post('JML_VBCG_TERIMA',true),
				'JML_VDPT_TERIMA' => $this->input->post('JML_VDPT_TERIMA',true),
				'JML_VDPTHB_TERIMA' => $this->input->post('JML_VDPTHB_TERIMA',true),
				'JML_VP_TERIMA' => $this->input->post('JML_VP_TERIMA',true),
				'JML_VC_TERIMA' => $this->input->post('JML_VC_TERIMA',true),
				'JML_VHBU_TERIMA' => $this->input->post('JML_VHBU_TERIMA',true),
				'JML_VHBV_TERIMA' => $this->input->post('JML_VHBV_TERIMA',true),
				'JML_VTT_TERIMA' => $this->input->post('JML_VTT_TERIMA',true),
				'JML_VDT_TERIMA' => $this->input->post('JML_VDT_TERIMA',true),
				'JML_VBCG_DIPAKAI' => $this->input->post('JML_VBCG_DIPAKAI',true),
				'JML_VDPT_DIPAKAI' => $this->input->post('JML_VDPT_DIPAKAI',true),
				'JML_VDPTHB_DIPAKAI' => $this->input->post('JML_VDPTHB_DIPAKAI',true),
				'JML_VP_DIPAKAI' => $this->input->post('JML_VP_DIPAKAI',true),
				'JML_VC_DIPAKAI' => $this->input->post('JML_VC_DIPAKAI',true),
				'JML_VHBU_DIPAKAI' => $this->input->post('JML_VHBU_DIPAKAI',true),
				'JML_VHBV_DIPAKAI' => $this->input->post('JML_VHBV_DIPAKAI',true),
				'JML_VTT_DIPAKAI' => $this->input->post('JML_VTT_DIPAKAI',true),
				'JML_VDT_DIPAKAI' => $this->input->post('JML_VDT_DIPAKAI',true),
				'JML_VDT1_ANAKSEKOLAH' => $this->input->post('JML_VDT1_ANAKSEKOLAH',true),
				'JML_VDT2_ANAKSEKOLAH' => $this->input->post('JML_VDT2_ANAKSEKOLAH',true),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);
			
			$id=$this->input->post('ID',true);
			
			$db->where('ID',$id);
			$db->update('t_ds_imunisasi', $dataexc);
			
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
						from t_ds_imunisasi t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI						
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('t_ds_imunisasi/v_ds_imunisasi_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from t_ds_imunisasi where ID = '".$id."'")){
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
						from t_ds_imunisasi t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_puskesmas ps on ps.KD_PUSKESMAS=t.KD_PUSKESMAS
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('t_ds_imunisasi/v_ds_imunisasi_detail',$data);
	}
	
}

/* End of file c_ds_imunisasi.php */
/* Location: ./application/controllers/c_ds_imunisasi.php */