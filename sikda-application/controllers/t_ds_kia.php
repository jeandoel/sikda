<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_ds_kia extends CI_Controller {
	public function index()
	{
		$this->load->view('t_ds_kia/v_ds_kia');
	}
	
	public function ds_kiaxml()
	{
		$this->load->model('t_ds_kia_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'tahun'=>$this->input->post('tahun'),
					'carinama'=>$this->input->post('carinama')
					);
					
		$total = $this->t_ds_kia_model->totalds_kia($paramstotal);
		
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
					
		$result = $this->t_ds_kia_model->getds_kia($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_ds_kia/v_ds_kia_add');
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
				'JML_KJ_K1_BUMIL' => $this->input->post('JML_KJ_K1_BUMIL',true),
				'JML_KJ_K4_BUMIL' => $this->input->post('JML_KJ_K4_BUMIL',true),
				'JML_KJ_BR_R_MASYARAKAT' => $this->input->post('JML_KJ_BR_R_MASYARAKAT',true),
				'JML_KJ_BR_R_NAKES' => $this->input->post('JML_KJ_BR_R_NAKES',true),
				'JML_B_R_R_YD_PUSKESMAS' => $this->input->post('JML_B_R_R_YD_PUSKESMAS',true),
				'JML_B_R_R_YD_RUMAH_SAKIT' => $this->input->post('JML_B_R_R_YD_RUMAH_SAKIT',true),
				'JML_K_BR_I_HAMIL' => $this->input->post('JML_K_BR_I_HAMIL',true),
				'JML_P_IB_T_KESEHATAN' => $this->input->post('JML_P_IB_T_KESEHATAN',true),
				'JML_P_IB_T_DUKUN' => $this->input->post('JML_P_IB_T_DUKUN',true),
				'JML_I_B_DRJ_PUSKESMAS' => $this->input->post('JML_I_B_DRJ_PUSKESMAS',true),
				'JML_I_B_DRJ_RUMAH_SAKIT' => $this->input->post('JML_I_B_DRJ_RUMAH_SAKIT',true),
				'JML_K_I_BERSALIN' => $this->input->post('JML_K_I_BERSALIN',true),
				'JML_K_I_NIFAS' => $this->input->post('JML_K_I_NIFAS',true),
				'JML_KJ_N_BR_0_7HARI_KN1' => $this->input->post('JML_KJ_N_BR_0_7HARI_KN1',true),
				'JML_KJ_N_BR_8_28HARI_KN2' => $this->input->post('JML_KJ_N_BR_8_28HARI_KN2',true),
				'JML_B_N_BBL_K_2500GR' => $this->input->post('JML_B_N_BBL_K_2500GR',true),
				'JML_BBLR_N_D_T_KESEHATAN' => $this->input->post('JML_BBLR_N_D_T_KESEHATAN',true),
				'B_N_D_BBL_2500_3000GR' => $this->input->post('B_N_D_BBL_2500_3000GR',true),
				'JML_B_N_D_BBL_L_3000GR' => $this->input->post('JML_B_N_D_BBL_L_3000GR',true),
				'B_N_L_HIDUP' => $this->input->post('B_N_L_HIDUP',true),
				'B_N_L_MATI' => $this->input->post('B_N_L_MATI',true),
				'K_B_N_UMR_0_7_HARI' => $this->input->post('K_B_N_UMR_0_7_HARI',true),
				'K_B_N_UMR_8HR_1BL' => $this->input->post('K_B_N_UMR_8HR_1BL',true),
				'K_B_N_UMR_1BL_1THN' => $this->input->post('K_B_N_UMR_1BL_1THN',true),
				'K_N_BALITA' => $this->input->post('K_N_BALITA',true),
				'N_RESTI' => $this->input->post('N_RESTI',true),
				'N_R_DRJ_PUSKESMAS' => $this->input->post('N_R_DRJ_PUSKESMAS',true),
				'N_R_DRJ_RS' => $this->input->post('N_R_DRJ_RS',true),
				'B_N_YG_DTK_TBH_KEMBANGNYA' => $this->input->post('B_N_YG_DTK_TBH_KEMBANGNYA',true),
				'A_N_D_KLN_TBH_KEMBANG' => $this->input->post('A_N_D_KLN_TBH_KEMBANG',true),
				'JML_KJ_TK_ADA' => $this->input->post('JML_KJ_TK_ADA',true),
				'JML_KJ_TK_DIKUNJUNGI' => $this->input->post('JML_KJ_TK_DIKUNJUNGI',true),
				'M_KJ_TK_DIPERIKSA' => $this->input->post('M_KJ_TK_DIPERIKSA',true),
				'M_KJ_TK_DIRUJUK' => $this->input->post('M_KJ_TK_DIRUJUK',true),
				
				
				'JML_KJ_N_BR_0_7HARI_KN1_p' => $this->input->post('JML_KJ_N_BR_0_7HARI_KN1_p',true),
				'JML_KJ_N_BR_8_28HARI_KN2_p' => $this->input->post('JML_KJ_N_BR_8_28HARI_KN2_p',true),
				'JML_B_N_BBL_K_2500GR_p' => $this->input->post('JML_B_N_BBL_K_2500GR_p',true),
				'JML_BBLR_N_D_T_KESEHATAN_p' => $this->input->post('JML_BBLR_N_D_T_KESEHATAN_p',true),
				'B_N_D_BBL_2500_3000GR_p' => $this->input->post('B_N_D_BBL_2500_3000GR_p',true),
				'JML_B_N_D_BBL_L_3000GR_p' => $this->input->post('JML_B_N_D_BBL_L_3000GR_p',true),
				'B_N_L_HIDUP_p' => $this->input->post('B_N_L_HIDUP_p',true),
				'B_N_L_MATI_p' => $this->input->post('B_N_L_MATI_p',true),
				'K_B_N_UMR_0_7_HARI_p' => $this->input->post('K_B_N_UMR_0_7_HARI_p',true),
				'K_B_N_UMR_8HR_1BL_p' => $this->input->post('K_B_N_UMR_8HR_1BL_p',true),
				'K_B_N_UMR_1BL_1THN_p' => $this->input->post('K_B_N_UMR_1BL_1THN_p',true),
				'K_N_BALITA_p' => $this->input->post('K_N_BALITA_p',true),
				'N_RESTI_p' => $this->input->post('N_RESTI_p',true),
				'N_R_DRJ_PUSKESMAS_p' => $this->input->post('N_R_DRJ_PUSKESMAS_p',true),
				'N_R_DRJ_RS_p' => $this->input->post('N_R_DRJ_RS_p',true),
				'B_N_YG_DTK_TBH_KEMBANGNYA_p' => $this->input->post('B_N_YG_DTK_TBH_KEMBANGNYA_p',true),
				'A_N_D_KLN_TBH_KEMBANG_p' => $this->input->post('A_N_D_KLN_TBH_KEMBANG_p',true),
				'JML_KJ_TK_ADA_p' => $this->input->post('JML_KJ_TK_ADA_p',true),
				'JML_KJ_TK_DIKUNJUNGI_p' => $this->input->post('JML_KJ_TK_DIKUNJUNGI_p',true),
				
				//TAMBAHAN
				'NEONATUS_KOMPLIKASI_L' => $this->input->post('NEONATUS_KOMPLIKASI_L',true),
				'NEONATUS_KOMPLIKASI_P' => $this->input->post('NEONATUS_KOMPLIKASI_P',true),
				'NEONATUS_SHK_L' => $this->input->post('NEONATUS_SHK_L',true),
				'NEONATUS_SHK_P' => $this->input->post('NEONATUS_SHK_P',true),
				'BALITA_SDIDTK_L' => $this->input->post('BALITA_SDIDTK_L',true),
				'BALITA_SDIDTK_P' => $this->input->post('BALITA_SDIDTK_P',true),
				'ANAK_PRA_SDIDTK_L' => $this->input->post('ANAK_PRA_SDIDTK_L',true),
				'ANAK_PRA_SDIDTK_P' => $this->input->post('ANAK_PRA_SDIDTK_P',true),
				'REMAJA_KONSELING_L' => $this->input->post('REMAJA_KONSELING_L',true),
				'REMAJA_KONSELING_P' => $this->input->post('REMAJA_KONSELING_P',true),
				'REMAJA_KIE_L' => $this->input->post('REMAJA_KIE_L',true),
				'REMAJA_KIE_P' => $this->input->post('REMAJA_KIE_P',true),
				'REMAJA_DISABILITAS_L' => $this->input->post('REMAJA_DISABILITAS_L',true),
				'REMAJA_DISABILITAS_P' => $this->input->post('REMAJA_DISABILITAS_P',true),
				'REMAJA_KORBAN_KEKERASAN_DITANGANI_L' => $this->input->post('REMAJA_KORBAN_KEKERASAN_DITANGANI_L',true),
				'REMAJA_KORBAN_KEKERASAN_DITANGANI_P' => $this->input->post('REMAJA_KORBAN_KEKERASAN_DITANGANI_P',true),
				'REMAJA_KORBAN_KEKERASAN_DIRUJUK_L' => $this->input->post('REMAJA_KORBAN_KEKERASAN_DIRUJUK_L',true),
				'REMAJA_KORBAN_KEKERASAN_DIRUJUK_P' => $this->input->post('REMAJA_KORBAN_KEKERASAN_DIRUJUK_P',true),
				
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('t_ds_kia', $dataexc);
			
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
				'JML_KJ_K1_BUMIL' => $this->input->post('JML_KJ_K1_BUMIL',true),
				'JML_KJ_K4_BUMIL' => $this->input->post('JML_KJ_K4_BUMIL',true),
				'JML_KJ_BR_R_MASYARAKAT' => $this->input->post('JML_KJ_BR_R_MASYARAKAT',true),
				'JML_KJ_BR_R_NAKES' => $this->input->post('JML_KJ_BR_R_NAKES',true),
				'JML_B_R_R_YD_PUSKESMAS' => $this->input->post('JML_B_R_R_YD_PUSKESMAS',true),
				'JML_B_R_R_YD_RUMAH_SAKIT' => $this->input->post('JML_B_R_R_YD_RUMAH_SAKIT',true),
				'JML_K_BR_I_HAMIL' => $this->input->post('JML_K_BR_I_HAMIL',true),
				'JML_P_IB_T_KESEHATAN' => $this->input->post('JML_P_IB_T_KESEHATAN',true),
				'JML_P_IB_T_DUKUN' => $this->input->post('JML_P_IB_T_DUKUN',true),
				'JML_I_B_DRJ_PUSKESMAS' => $this->input->post('JML_I_B_DRJ_PUSKESMAS',true),
				'JML_I_B_DRJ_RUMAH_SAKIT' => $this->input->post('JML_I_B_DRJ_RUMAH_SAKIT',true),
				'JML_K_I_BERSALIN' => $this->input->post('JML_K_I_BERSALIN',true),
				'JML_K_I_NIFAS' => $this->input->post('JML_K_I_NIFAS',true),
				'JML_KJ_N_BR_0_7HARI_KN1' => $this->input->post('JML_KJ_N_BR_0_7HARI_KN1',true),
				'JML_KJ_N_BR_8_28HARI_KN2' => $this->input->post('JML_KJ_N_BR_8_28HARI_KN2',true),
				'JML_B_N_BBL_K_2500GR' => $this->input->post('JML_B_N_BBL_K_2500GR',true),
				'JML_BBLR_N_D_T_KESEHATAN' => $this->input->post('JML_BBLR_N_D_T_KESEHATAN',true),
				'B_N_D_BBL_2500_3000GR' => $this->input->post('B_N_D_BBL_2500_3000GR',true),
				'JML_B_N_D_BBL_L_3000GR' => $this->input->post('JML_B_N_D_BBL_L_3000GR',true),
				'B_N_L_HIDUP' => $this->input->post('B_N_L_HIDUP',true),
				'B_N_L_MATI' => $this->input->post('B_N_L_MATI',true),
				'K_B_N_UMR_0_7_HARI' => $this->input->post('K_B_N_UMR_0_7_HARI',true),
				'K_B_N_UMR_8HR_1BL' => $this->input->post('K_B_N_UMR_8HR_1BL',true),
				'K_B_N_UMR_1BL_1THN' => $this->input->post('K_B_N_UMR_1BL_1THN',true),
				'K_N_BALITA' => $this->input->post('K_N_BALITA',true),
				'N_RESTI' => $this->input->post('N_RESTI',true),
				'N_R_DRJ_PUSKESMAS' => $this->input->post('N_R_DRJ_PUSKESMAS',true),
				'N_R_DRJ_RS' => $this->input->post('N_R_DRJ_RS',true),
				'B_N_YG_DTK_TBH_KEMBANGNYA' => $this->input->post('B_N_YG_DTK_TBH_KEMBANGNYA',true),
				'A_N_D_KLN_TBH_KEMBANG' => $this->input->post('A_N_D_KLN_TBH_KEMBANG',true),
				'JML_KJ_TK_ADA' => $this->input->post('JML_KJ_TK_ADA',true),
				'JML_KJ_TK_DIKUNJUNGI' => $this->input->post('JML_KJ_TK_DIKUNJUNGI',true),
				'M_KJ_TK_DIPERIKSA' => $this->input->post('M_KJ_TK_DIPERIKSA',true),
				'M_KJ_TK_DIRUJUK' => $this->input->post('M_KJ_TK_DIRUJUK',true),
				
				
				'JML_KJ_N_BR_0_7HARI_KN1_p' => $this->input->post('JML_KJ_N_BR_0_7HARI_KN1_p',true),
				'JML_KJ_N_BR_8_28HARI_KN2_p' => $this->input->post('JML_KJ_N_BR_8_28HARI_KN2_p',true),
				'JML_B_N_BBL_K_2500GR_p' => $this->input->post('JML_B_N_BBL_K_2500GR_p',true),
				'JML_BBLR_N_D_T_KESEHATAN_p' => $this->input->post('JML_BBLR_N_D_T_KESEHATAN_p',true),
				'B_N_D_BBL_2500_3000GR_p' => $this->input->post('B_N_D_BBL_2500_3000GR_p',true),
				'JML_B_N_D_BBL_L_3000GR_p' => $this->input->post('JML_B_N_D_BBL_L_3000GR_p',true),
				'B_N_L_HIDUP_p' => $this->input->post('B_N_L_HIDUP_p',true),
				'B_N_L_MATI_p' => $this->input->post('B_N_L_MATI_p',true),
				'K_B_N_UMR_0_7_HARI_p' => $this->input->post('K_B_N_UMR_0_7_HARI_p',true),
				'K_B_N_UMR_8HR_1BL_p' => $this->input->post('K_B_N_UMR_8HR_1BL_p',true),
				'K_B_N_UMR_1BL_1THN_p' => $this->input->post('K_B_N_UMR_1BL_1THN_p',true),
				'K_N_BALITA_p' => $this->input->post('K_N_BALITA_p',true),
				'N_RESTI_p' => $this->input->post('N_RESTI_p',true),
				'N_R_DRJ_PUSKESMAS_p' => $this->input->post('N_R_DRJ_PUSKESMAS_p',true),
				'N_R_DRJ_RS_p' => $this->input->post('N_R_DRJ_RS_p',true),
				'B_N_YG_DTK_TBH_KEMBANGNYA_p' => $this->input->post('B_N_YG_DTK_TBH_KEMBANGNYA_p',true),
				'A_N_D_KLN_TBH_KEMBANG_p' => $this->input->post('A_N_D_KLN_TBH_KEMBANG_p',true),
				'JML_KJ_TK_ADA_p' => $this->input->post('JML_KJ_TK_ADA_p',true),
				'JML_KJ_TK_DIKUNJUNGI_p' => $this->input->post('JML_KJ_TK_DIKUNJUNGI_p',true),
				
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);
			
			$id=$this->input->post('ID',true);
			
			$db->where('ID',$id);
			$db->update('t_ds_kia', $dataexc);
			
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
						from t_ds_kia t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI						
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('t_ds_kia/v_ds_kia_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from t_ds_kia where ID = '".$id."'")){
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
						from t_ds_kia t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_puskesmas ps on ps.KD_PUSKESMAS=t.KD_PUSKESMAS
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('t_ds_kia/v_ds_kia_detail',$data);
	}
	
}

/* End of file c_ds_gigi.php */
/* Location: ./application/controllers/c_ds_gigi.php */