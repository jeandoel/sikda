<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_ds_kematian_anak extends CI_Controller {
	public function index()
	{
		$this->load->view('t_ds_kematian_anak/v_ds_kematian_anak');
	}
	
	public function ds_kematian_anakxml()
	{
		$this->load->model('t_ds_kematian_anak_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'tahun'=>$this->input->post('tahun'),
					'carinama'=>$this->input->post('carinama')
					);
					
		$total = $this->t_ds_kematian_anak_model->totalds_kematian_anak($paramstotal);
		
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
					
		$result = $this->t_ds_kematian_anak_model->getds_kematian_anak($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_ds_kematian_anak/v_ds_kematian_anak_add');
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
				'JML_L_K_BAYI' => $this->input->post('JML_L_K_BAYI',true),
				'JML_L_U_0_7_HARI' => $this->input->post('JML_L_U_0_7_HARI',true),
				'JML_L_U_8_30_HARI' => $this->input->post('JML_L_U_8_30_HARI',true),
				'JML_L_U_1_12_BULAN' => $this->input->post('JML_L_U_1_12_BULAN',true),
				'JML_L_U_1_5_TAHUN' => $this->input->post('JML_L_U_1_5_TAHUN',true),
				'JML_P_K_BAYI' => $this->input->post('JML_P_K_BAYI',true),
				'JML_P_U_0_7_HARI' => $this->input->post('JML_P_U_0_7_HARI',true),
				'JML_P_U_8_30_HARI' => $this->input->post('JML_P_U_8_30_HARI',true),
				'JML_P_U_1_12_BULAN' => $this->input->post('JML_P_U_1_12_BULAN',true),
				'JML_P_U_1_5_TAHUN' => $this->input->post('JML_P_U_1_5_TAHUN',true),
				'JML_P_PA_KE_KSD_5' => $this->input->post('JML_P_PA_KE_KSD_5',true),
				'JML_P_PA_KE_KSD_5_L' => $this->input->post('JML_P_PA_KE_KSD_5_L',true),
				'JML_P_PA_KE_L_5' => $this->input->post('JML_P_PA_KE_L_5',true),
				'JML_P_PA_KE_L_5_L' => $this->input->post('JML_P_PA_KE_L_5_L',true),
				'JML_ANC_KSD_4' => $this->input->post('JML_ANC_KSD_4',true),
				'JML_ANC_L_4' => $this->input->post('JML_ANC_L_4',true),
				'JML_SI_BCG' => $this->input->post('JML_SI_BCG',true),
				'JML_SI_DPT' => $this->input->post('JML_SI_DPT',true),
				'JML_SI_POLIO' => $this->input->post('JML_SI_POLIO',true),
				'JML_SI_CAMPAK' => $this->input->post('JML_SI_CAMPAK',true),
				'JML_SI_HB' => $this->input->post('JML_SI_HB',true),
				'JML_SK_TN' => $this->input->post('JML_SK_TN',true),
				'JML_SK_BBLR' => $this->input->post('JML_SK_BBLR',true),
				'JML_SK_ASFEKSIA' => $this->input->post('JML_SK_ASFEKSIA',true),
				'JML_SK_LAIN_LAIN' => $this->input->post('JML_SK_LAIN_LAIN',true),
				'JML_TK_RUMAH' => $this->input->post('JML_TK_RUMAH',true),
				'JML_TK_PUSKESMAS_RB' => $this->input->post('JML_TK_PUSKESMAS_RB',true),
				'JML_TK_RS' => $this->input->post('JML_TK_RS',true),
				'JML_TK_PERJALANAN' => $this->input->post('JML_TK_PERJALANAN',true),
				'JML_PP_DUKUN' => $this->input->post('JML_PP_DUKUN',true),
				'JML_PP_BIDAN' => $this->input->post('JML_PP_BIDAN',true),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('t_ds_kematian_anak', $dataexc);
			
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
				'JML_L_K_BAYI' => $this->input->post('JML_L_K_BAYI',true),
				'JML_L_U_0_7_HARI' => $this->input->post('JML_L_U_0_7_HARI',true),
				'JML_L_U_8_30_HARI' => $this->input->post('JML_L_U_8_30_HARI',true),
				'JML_L_U_1_12_BULAN' => $this->input->post('JML_L_U_1_12_BULAN',true),
				'JML_L_U_1_5_TAHUN' => $this->input->post('JML_L_U_1_5_TAHUN',true),
				'JML_P_K_BAYI' => $this->input->post('JML_P_K_BAYI',true),
				'JML_P_U_0_7_HARI' => $this->input->post('JML_P_U_0_7_HARI',true),
				'JML_P_U_8_30_HARI' => $this->input->post('JML_P_U_8_30_HARI',true),
				'JML_P_U_1_12_BULAN' => $this->input->post('JML_P_U_1_12_BULAN',true),
				'JML_P_U_1_5_TAHUN' => $this->input->post('JML_P_U_1_5_TAHUN',true),
				'JML_P_PA_KE_KSD_5' => $this->input->post('JML_P_PA_KE_KSD_5',true),
				'JML_P_PA_KE_L_5' => $this->input->post('JML_P_PA_KE_L_5',true),
				'JML_P_PA_KE_KSD_5_L' => $this->input->post('JML_P_PA_KE_KSD_5_L',true),
				'JML_P_PA_KE_L_5_L' => $this->input->post('JML_P_PA_KE_L_5_L',true),
				'JML_ANC_KSD_4' => $this->input->post('JML_ANC_KSD_4',true),
				'JML_ANC_L_4' => $this->input->post('JML_ANC_L_4',true),
				'JML_SI_BCG' => $this->input->post('JML_SI_BCG',true),
				'JML_SI_DPT' => $this->input->post('JML_SI_DPT',true),
				'JML_SI_POLIO' => $this->input->post('JML_SI_POLIO',true),
				'JML_SI_CAMPAK' => $this->input->post('JML_SI_CAMPAK',true),
				'JML_SI_HB' => $this->input->post('JML_SI_HB',true),
				'JML_SK_TN' => $this->input->post('JML_SK_TN',true),
				'JML_SK_BBLR' => $this->input->post('JML_SK_BBLR',true),
				'JML_SK_ASFEKSIA' => $this->input->post('JML_SK_ASFEKSIA',true),
				'JML_SK_LAIN_LAIN' => $this->input->post('JML_SK_LAIN_LAIN',true),
				'JML_TK_RUMAH' => $this->input->post('JML_TK_RUMAH',true),
				'JML_TK_PUSKESMAS_RB' => $this->input->post('JML_TK_PUSKESMAS_RB',true),
				'JML_TK_RS' => $this->input->post('JML_TK_RS',true),
				'JML_TK_PERJALANAN' => $this->input->post('JML_TK_PERJALANAN',true),
				'JML_PP_DUKUN' => $this->input->post('JML_PP_DUKUN',true),
				'JML_PP_BIDAN' => $this->input->post('JML_PP_BIDAN',true),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);
			
			$id=$this->input->post('ID',true);
			
			$db->where('ID',$id);
			$db->update('t_ds_kematian_anak', $dataexc);
			
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
						from t_ds_kematian_anak t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI						
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('t_ds_kematian_anak/v_ds_kematian_anak_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from t_ds_kematian_anak where ID = '".$id."'")){
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
						from t_ds_kematian_anak t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_puskesmas ps on ps.KD_PUSKESMAS=t.KD_PUSKESMAS
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('t_ds_kematian_anak/v_ds_kematian_anak_detail',$data);
	}
	
}

/* End of file c_ds_kematian_anak.php */
/* Location: ./application/controllers/c_ds_kematian_anak.php */