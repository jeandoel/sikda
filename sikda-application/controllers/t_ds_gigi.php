<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_ds_gigi extends CI_Controller {
	public function index()
	{
		$this->load->view('t_ds_gigi/v_ds_gigi');
	}
	
	public function ds_gigixml()
	{
		$this->load->model('t_ds_gigi_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'tahun'=>$this->input->post('tahun'),
					'carinama'=>$this->input->post('carinama')
					);
					
		$total = $this->t_ds_gigi_model->totalds_gigi($paramstotal);
		
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
					
		$result = $this->t_ds_gigi_model->getds_gigi($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_ds_gigi/v_ds_gigi_add');
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
				'JML_L_C_DENTIS' => $this->input->post('JML_L_C_DENTIS',true),
				'JML_L_K_PULPA' => $this->input->post('JML_L_K_PULPA',true),
				'JML_L_K_PERIODONTAL' => $this->input->post('JML_L_K_PERIODONTAL',true),
				'JML_L_ABSES' => $this->input->post('JML_L_ABSES',true),
				'JML_L_PERSISTENSI' => $this->input->post('JML_L_PERSISTENSI',true),
				'JML_L_LAINLAIN' => $this->input->post('JML_L_LAINLAIN',true),
				'JML_P_C_DENTIS' => $this->input->post('JML_P_C_DENTIS',true),
				'JML_P_K_PULPA' => $this->input->post('JML_P_K_PULPA',true),
				'JML_P_K_PERIODONTAL' => $this->input->post('JML_P_K_PERIODONTAL',true),
				'JML_P_ABSES' => $this->input->post('JML_P_ABSES',true),
				'JML_P_PERSISTENSI' => $this->input->post('JML_P_PERSISTENSI',true),
				'JML_P_LAINLAIN' => $this->input->post('JML_P_LAINLAIN',true),
				'JML_PR_TTG_TETAP' => $this->input->post('JML_PR_TTG_TETAP',true),
				'JML_PR_TTG_SULUNG' => $this->input->post('JML_PR_TTG_SULUNG',true),
				'JML_PR_TTS_TETAP' => $this->input->post('JML_PR_TTS_TETAP',true),
				'JML_PR_TTS_SULUNG' => $this->input->post('JML_PR_TTS_SULUNG',true),
				'JML_PR_PULPA' => $this->input->post('JML_PR_PULPA',true),
				'JML_PR_PERIODONTAL' => $this->input->post('JML_PR_PERIODONTAL',true),
				'JML_PR_ABSES' => $this->input->post('JML_PR_ABSES',true),
				'JML_PR_PG_TETAP' => $this->input->post('JML_PR_PG_TETAP',true),
				'JML_PR_PG_SULUNG' => $this->input->post('JML_PR_PG_SULUNG',true),
				'JML_PR_T_SCALING' => $this->input->post('JML_PR_T_SCALING',true),
				'JML_PR_LAINLAIN' => $this->input->post('JML_PR_LAINLAIN',true),
				'JML_PR_KRJGBI_HAMIL' => $this->input->post('JML_PR_KRJGBI_HAMIL',true),
				'JML_PR_KRJGLI_HAMIL' => $this->input->post('JML_PR_KRJGLI_HAMIL',true),
				'JML_KJ_L_KRJB_ANAK' => $this->input->post('JML_KJ_L_KRJB_ANAK',true),
				'JML_KJ_L_KRJL_ANAK' => $this->input->post('JML_KJ_L_KRJL_ANAK',true),
				'JML_KJ_L_KRJB_ANAKSEKOLAH' => $this->input->post('JML_KJ_L_KRJB_ANAKSEKOLAH',true),
				'JML_KJ_L_KRJL_ANAKSEKOLAH' => $this->input->post('JML_KJ_L_KRJL_ANAKSEKOLAH',true),
				'JML_KJ_L_KRJGLL_WILAYAH' => $this->input->post('JML_KJ_L_KRJGLL_WILAYAH',true),
				'JML_KJ_L_KRJGBL_WILAYAH' => $this->input->post('JML_KJ_L_KRJGBL_WILAYAH',true),
				'JML_KJ_P_KRJB_ANAK' => $this->input->post('JML_KJ_P_KRJB_ANAK',true),
				'JML_KJ_P_KRJL_ANAK' => $this->input->post('JML_KJ_P_KRJL_ANAK',true),
				'JML_KJ_P_KRJB_ANAKSEKOLAH' => $this->input->post('JML_KJ_P_KRJB_ANAKSEKOLAH',true),
				'JML_KJ_P_KRJL_ANAKSEKOLAH' => $this->input->post('JML_KJ_P_KRJL_ANAKSEKOLAH',true),
				'JML_KJ_P_KRJGLL_WILAYAH' => $this->input->post('JML_KJ_P_KRJGLL_WILAYAH',true),
				'JML_KJ_P_KRJGBL_WILAYAH' => $this->input->post('JML_KJ_P_KRJGBL_WILAYAH',true),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('t_ds_gigi', $dataexc);
			
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
				'JML_L_C_DENTIS' => $this->input->post('JML_L_C_DENTIS',true),
				'JML_L_K_PULPA' => $this->input->post('JML_L_K_PULPA',true),
				'JML_L_K_PERIODONTAL' => $this->input->post('JML_L_K_PERIODONTAL',true),
				'JML_L_ABSES' => $this->input->post('JML_L_ABSES',true),
				'JML_L_PERSISTENSI' => $this->input->post('JML_L_PERSISTENSI',true),
				'JML_L_LAINLAIN' => $this->input->post('JML_L_LAINLAIN',true),
				'JML_P_C_DENTIS' => $this->input->post('JML_P_C_DENTIS',true),
				'JML_P_K_PULPA' => $this->input->post('JML_P_K_PULPA',true),
				'JML_P_K_PERIODONTAL' => $this->input->post('JML_P_K_PERIODONTAL',true),
				'JML_P_ABSES' => $this->input->post('JML_P_ABSES',true),
				'JML_P_PERSISTENSI' => $this->input->post('JML_P_PERSISTENSI',true),
				'JML_P_LAINLAIN' => $this->input->post('JML_P_LAINLAIN',true),
				'JML_PR_TTG_TETAP' => $this->input->post('JML_PR_TTG_TETAP',true),
				'JML_PR_TTG_SULUNG' => $this->input->post('JML_PR_TTG_SULUNG',true),
				'JML_PR_TTS_TETAP' => $this->input->post('JML_PR_TTS_TETAP',true),
				'JML_PR_TTS_SULUNG' => $this->input->post('JML_PR_TTS_SULUNG',true),
				'JML_PR_PULPA' => $this->input->post('JML_PR_PULPA',true),
				'JML_PR_PERIODONTAL' => $this->input->post('JML_PR_PERIODONTAL',true),
				'JML_PR_ABSES' => $this->input->post('JML_PR_ABSES',true),
				'JML_PR_PG_TETAP' => $this->input->post('JML_PR_PG_TETAP',true),
				'JML_PR_PG_SULUNG' => $this->input->post('JML_PR_PG_SULUNG',true),
				'JML_PR_T_SCALING' => $this->input->post('JML_PR_T_SCALING',true),
				'JML_PR_LAINLAIN' => $this->input->post('JML_PR_LAINLAIN',true),
				'JML_PR_KRJGBI_HAMIL' => $this->input->post('JML_PR_KRJGBI_HAMIL',true),
				'JML_PR_KRJGLI_HAMIL' => $this->input->post('JML_PR_KRJGLI_HAMIL',true),
				'JML_KJ_L_KRJB_ANAK' => $this->input->post('JML_KJ_L_KRJB_ANAK',true),
				'JML_KJ_L_KRJL_ANAK' => $this->input->post('JML_KJ_L_KRJL_ANAK',true),
				'JML_KJ_L_KRJB_ANAKSEKOLAH' => $this->input->post('JML_KJ_L_KRJB_ANAKSEKOLAH',true),
				'JML_KJ_L_KRJL_ANAKSEKOLAH' => $this->input->post('JML_KJ_L_KRJL_ANAKSEKOLAH',true),
				'JML_KJ_L_KRJGLL_WILAYAH' => $this->input->post('JML_KJ_L_KRJGLL_WILAYAH',true),
				'JML_KJ_L_KRJGBL_WILAYAH' => $this->input->post('JML_KJ_L_KRJGBL_WILAYAH',true),
				'JML_KJ_P_KRJB_ANAK' => $this->input->post('JML_KJ_P_KRJB_ANAK',true),
				'JML_KJ_P_KRJL_ANAK' => $this->input->post('JML_KJ_P_KRJL_ANAK',true),
				'JML_KJ_P_KRJB_ANAKSEKOLAH' => $this->input->post('JML_KJ_P_KRJB_ANAKSEKOLAH',true),
				'JML_KJ_P_KRJL_ANAKSEKOLAH' => $this->input->post('JML_KJ_P_KRJL_ANAKSEKOLAH',true),
				'JML_KJ_P_KRJGLL_WILAYAH' => $this->input->post('JML_KJ_P_KRJGLL_WILAYAH',true),
				'JML_KJ_P_KRJGBL_WILAYAH' => $this->input->post('JML_KJ_P_KRJGBL_WILAYAH',true),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);
			
			$id=$this->input->post('ID',true);
			
			$db->where('ID',$id);
			$db->update('t_ds_gigi', $dataexc);
			
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
						from t_ds_gigi t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI						
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('t_ds_gigi/v_ds_gigi_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from t_ds_gigi where ID = '".$id."'")){
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
						from t_ds_gigi t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_puskesmas ps on ps.KD_PUSKESMAS=t.KD_PUSKESMAS
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('t_ds_gigi/v_ds_gigi_detail',$data);
	}
	
}

/* End of file c_ds_gigi.php */
/* Location: ./application/controllers/c_ds_gigi.php */