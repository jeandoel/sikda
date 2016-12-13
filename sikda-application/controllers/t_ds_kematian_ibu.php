<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_ds_kematian_ibu extends CI_Controller {
	public function index()
	{
		$this->load->view('t_ds_kematian_ibu/v_ds_kematian_ibu');
	}
	
	public function ds_kematian_ibuxml()
	{
		$this->load->model('t_ds_kematian_ibu_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'tahun'=>$this->input->post('tahun'),
					'carinama'=>$this->input->post('carinama')
					);
					
		$total = $this->t_ds_kematian_ibu_model->totalds_kematian_ibu($paramstotal);
		
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
					
		$result = $this->t_ds_kematian_ibu_model->getds_kematian_ibu($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_ds_kematian_ibu/v_ds_kematian_ibu_add');
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
				'JML_K_IBU' => $this->input->post('JML_K_IBU',true),
				'JML_IIYM_UMUR_K_20' => $this->input->post('JML_IIYM_UMUR_K_20',true),
				'JML_IIYM_UMUR_20_30TH' => $this->input->post('JML_IIYM_UMUR_20_30TH',true),
				'JML_IIYM_UMUR_L_30TH' => $this->input->post('JML_IIYM_UMUR_L_30TH',true),
				'JML_P_SD' => $this->input->post('JML_P_SD',true),
				'JML_P_SLTP' => $this->input->post('JML_P_SLTP',true),
				'JML_P_SLTA' => $this->input->post('JML_P_SLTA',true),
				'JML_P_PA_KE_K_5' => $this->input->post('JML_P_PA_KE_K_5',true),
				'JML_P_PA_KE_L_5' => $this->input->post('JML_P_PA_KE_L_5',true),
				'JML_P_ANC_K_4' => $this->input->post('JML_P_ANC_K_4',true),
				'JML_P_ANC_L_4' => $this->input->post('JML_P_ANC_L_4',true),
				'JML_P_S_IMUNISASI_O' => $this->input->post('JML_P_S_IMUNISASI_O',true),
				'JML_P_S_IMUNISASI_TT1' => $this->input->post('JML_P_S_IMUNISASI_TT1',true),
				'JML_P_S_IMUNISASI_TT2' => $this->input->post('JML_P_S_IMUNISASI_TT2',true),
				'JML_SK_PENDARAHAN' => $this->input->post('JML_SK_PENDARAHAN',true),
				'JML_SK_EKLAMSI' => $this->input->post('JML_SK_EKLAMSI',true),
				'JML_SK_SEPSIS' => $this->input->post('JML_SK_SEPSIS',true),
				'JML_SK_LAIN_LAIN' => $this->input->post('JML_SK_LAIN_LAIN',true),
				'JML_MS_HAMIL' => $this->input->post('JML_MS_HAMIL',true),
				'JML_MS_NIFAS' => $this->input->post('JML_MS_NIFAS',true),
				'JML_MS_BERSALIN' => $this->input->post('JML_MS_BERSALIN',true),
				'JML_TK_KI_RUMAH' => $this->input->post('JML_TK_KI_RUMAH',true),
				'JML_TK_KI_PUSKESMAS_R_B' => $this->input->post('JML_TK_KI_PUSKESMAS_R_B',true),
				'JML_TK_KI_RS' => $this->input->post('JML_TK_KI_RS',true),
				'JML_TK_KI_PERJALANAN' => $this->input->post('JML_TK_KI_PERJALANAN',true),
				'JML_KI_PP_DUKUN' => $this->input->post('JML_KI_PP_DUKUN',true),
				'JML_KI_PP_BIDAN' => $this->input->post('JML_KI_PP_BIDAN',true),
				'JML_KI_PP_DR' => $this->input->post('JML_KI_PP_DR',true),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('t_ds_kematian_ibu', $dataexc);
			
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
				'JML_K_IBU' => $this->input->post('JML_K_IBU',true),
				'JML_IIYM_UMUR_K_20' => $this->input->post('JML_IIYM_UMUR_K_20',true),
				'JML_IIYM_UMUR_20_30TH' => $this->input->post('JML_IIYM_UMUR_20_30TH',true),
				'JML_IIYM_UMUR_L_30TH' => $this->input->post('JML_IIYM_UMUR_L_30TH',true),
				'JML_P_SD' => $this->input->post('JML_P_SD',true),
				'JML_P_SLTP' => $this->input->post('JML_P_SLTP',true),
				'JML_P_SLTA' => $this->input->post('JML_P_SLTA',true),
				'JML_P_PA_KE_K_5' => $this->input->post('JML_P_PA_KE_K_5',true),
				'JML_P_PA_KE_L_5' => $this->input->post('JML_P_PA_KE_L_5',true),
				'JML_P_ANC_K_4' => $this->input->post('JML_P_ANC_K_4',true),
				'JML_P_ANC_L_4' => $this->input->post('JML_P_ANC_L_4',true),
				'JML_P_S_IMUNISASI_O' => $this->input->post('JML_P_S_IMUNISASI_O',true),
				'JML_P_S_IMUNISASI_TT1' => $this->input->post('JML_P_S_IMUNISASI_TT1',true),
				'JML_P_S_IMUNISASI_TT2' => $this->input->post('JML_P_S_IMUNISASI_TT2',true),
				'JML_SK_PENDARAHAN' => $this->input->post('JML_SK_PENDARAHAN',true),
				'JML_SK_EKLAMSI' => $this->input->post('JML_SK_EKLAMSI',true),
				'JML_SK_SEPSIS' => $this->input->post('JML_SK_SEPSIS',true),
				'JML_SK_LAIN_LAIN' => $this->input->post('JML_SK_LAIN_LAIN',true),
				'JML_MS_HAMIL' => $this->input->post('JML_MS_HAMIL',true),
				'JML_MS_NIFAS' => $this->input->post('JML_MS_NIFAS',true),
				'JML_MS_BERSALIN' => $this->input->post('JML_MS_BERSALIN',true),
				'JML_TK_KI_RUMAH' => $this->input->post('JML_TK_KI_RUMAH',true),
				'JML_TK_KI_PUSKESMAS_R_B' => $this->input->post('JML_TK_KI_PUSKESMAS_R_B',true),
				'JML_TK_KI_RS' => $this->input->post('JML_TK_KI_RS',true),
				'JML_TK_KI_PERJALANAN' => $this->input->post('JML_TK_KI_PERJALANAN',true),
				'JML_KI_PP_DUKUN' => $this->input->post('JML_KI_PP_DUKUN',true),
				'JML_KI_PP_BIDAN' => $this->input->post('JML_KI_PP_BIDAN',true),
				'JML_KI_PP_DR' => $this->input->post('JML_KI_PP_DR',true),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);
			
			$id=$this->input->post('ID',true);
			
			$db->where('ID',$id);
			$db->update('t_ds_kematian_ibu', $dataexc);
			
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
						from t_ds_kematian_ibu t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI						
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('t_ds_kematian_ibu/v_ds_kematian_ibu_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from t_ds_kematian_ibu where ID = '".$id."'")){
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
						from t_ds_kematian_ibu t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_puskesmas ps on ps.KD_PUSKESMAS=t.KD_PUSKESMAS
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('t_ds_kematian_ibu/v_ds_kematian_ibu_detail',$data);
	}
	
}

/* End of file c_ds_kematian_ibu.php */
/* Location: ./application/controllers/c_ds_kematian_ibu.php */