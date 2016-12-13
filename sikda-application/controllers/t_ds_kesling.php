<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_ds_kesling extends CI_Controller {
	public function index()
	{
		$this->load->view('t_ds_kesling/v_ds_kesling');
	}
	
	public function ds_keslingxml()
	{
		$this->load->model('t_ds_kesling_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'tahun'=>$this->input->post('tahun'),
					'carinama'=>$this->input->post('carinama')
					);
					
		$total = $this->t_ds_kesling_model->totalds_kesling($paramstotal);
		
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
					
		$result = $this->t_ds_kesling_model->getds_kesling($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_ds_kesling/v_ds_kesling_add');
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
				'SD_MI' => $this->input->post('SD_MI',true),
				'SLTP_MTS' => $this->input->post('SLTP_MTS',true),
				'SLTA_MA' => $this->input->post('SLTA_MA',true),
				'PERGURUAN_TINGGI' => $this->input->post('PERGURUAN_TINGGI',true),
				'KIOS_KUD' => $this->input->post('KIOS_KUD',true),
				'HOTEL_MELATI_LOSMEN' => $this->input->post('HOTEL_MELATI_LOSMEN',true),
				'SALON_KECNTIKAN_P_RAMBUT' => $this->input->post('SALON_KECNTIKAN_P_RAMBUT',true),
				'TEMPAT_REKREASI' => $this->input->post('TEMPAT_REKREASI',true),
				'GD_PERTEMUAN_GD_PERTUNJUKAN' => $this->input->post('GD_PERTEMUAN_GD_PERTUNJUKAN',true),
				'KOLAM_RENANG' => $this->input->post('KOLAM_RENANG',true),
				'MASJID_MUSHOLA' => $this->input->post('MASJID_MUSHOLA',true),
				'GEREJA' => $this->input->post('GEREJA',true),
				'KELENTENG' => $this->input->post('KELENTENG',true),
				'PURA' => $this->input->post('PURA',true),
				'WIHARA' => $this->input->post('WIHARA',true),
				'TERMINAL' => $this->input->post('TERMINAL',true),
				'STASIUN' => $this->input->post('STASIUN',true),
				'PELABUHAN_LAUT' => $this->input->post('PELABUHAN_LAUT',true),
				'PASAR' => $this->input->post('PASAR',true),
				'APOTIK' => $this->input->post('APOTIK',true),
				'TOKO_OBAT' => $this->input->post('TOKO_OBAT',true),
				'SARANA_PANTI_SOSIAL' => $this->input->post('SARANA_PANTI_SOSIAL',true),
				'SARANA_KESEHATAN' => $this->input->post('SARANA_KESEHATAN',true),
				'WARUNG_MAKAN' => $this->input->post('WARUNG_MAKAN',true),
				'RUMAH_MAKAN' => $this->input->post('RUMAH_MAKAN',true),
				'JASA_BOGA' => $this->input->post('JASA_BOGA',true),
				'INDSTRI_MKNAN_MNMAN' => $this->input->post('INDSTRI_MKNAN_MNMAN',true),
				'INDSTRI_KCL_R_TANGGA' => $this->input->post('INDSTRI_KCL_R_TANGGA',true),
				'INDUSTRI_BESAR' => $this->input->post('INDUSTRI_BESAR',true),
				'JML_RUMAH' => $this->input->post('JML_RUMAH',true),
				'SGL' => $this->input->post('SGL',true),
				'SPT' => $this->input->post('SPT',true),
				'SR_PDAM' => $this->input->post('SR_PDAM',true),
				'LAIN_LAIN_SAB' => $this->input->post('LAIN_LAIN_SAB',true),
				'JMBN_UMUM_MCK' => $this->input->post('JMBN_UMUM_MCK',true),
				'JMBN_KELUARGA' => $this->input->post('JMBN_KELUARGA',true),
				'SPAL' => $this->input->post('SPAL',true),
				'TPS' => $this->input->post('TPS',true),
				'TPA' => $this->input->post('TPA',true),
				'PONDOK_PESANTREN' => $this->input->post('PONDOK_PESANTREN',true),
				'KIMIAWI' => $this->input->post('KIMIAWI',true),
				'BAKTERIOLOGI' => $this->input->post('BAKTERIOLOGI',true),
				'KLIEN_YDRJ_KLNK_SANITASI' => $this->input->post('KLIEN_YDRJ_KLNK_SANITASI',true),
				'KLIEN_DIKUNJUNGI' => $this->input->post('KLIEN_DIKUNJUNGI',true),
				
				'SD_MI_MS' => $this->input->post('SD_MI_MS',true),
				'SLTP_MTS_MS' => $this->input->post('SLTP_MTS_MS',true),
				'SLTA_MA_MS' => $this->input->post('SLTA_MA_MS',true),
				'PERGURUAN_TINGGI_MS' => $this->input->post('PERGURUAN_TINGGI_MS',true),
				'KIOS_KUD_MS' => $this->input->post('KIOS_KUD_MS',true),
				'HOTEL_MELATI_LOSMEN_MS' => $this->input->post('HOTEL_MELATI_LOSMEN_MS',true),
				'SALON_KECNTIKAN_P_RAMBUT_MS' => $this->input->post('SALON_KECNTIKAN_P_RAMBUT_MS',true),
				'TEMPAT_REKREASI_MS' => $this->input->post('TEMPAT_REKREASI_MS',true),
				'GD_PERTEMUAN_GD_PERTUNJUKAN_MS' => $this->input->post('GD_PERTEMUAN_GD_PERTUNJUKAN_MS',true),
				'KOLAM_RENANG_MS' => $this->input->post('KOLAM_RENANG_MS',true),
				'MASJID_MUSHOLA_MS' => $this->input->post('MASJID_MUSHOLA_MS',true),
				'GEREJA_MS' => $this->input->post('GEREJA_MS',true),
				'KELENTENG_MS' => $this->input->post('KELENTENG_MS',true),
				'PURA_MS' => $this->input->post('PURA_MS',true),
				'WIHARA_MS' => $this->input->post('WIHARA_MS',true),
				'TERMINAL_MS' => $this->input->post('TERMINAL_MS',true),
				'STASIUN_MS' => $this->input->post('STASIUN_MS',true),
				'PELABUHAN_LAUT_MS' => $this->input->post('PELABUHAN_LAUT_MS',true),
				'PASAR_MS' => $this->input->post('PASAR_MS',true),
				'APOTIK_MS' => $this->input->post('APOTIK_MS',true),
				'TOKO_OBAT_MS' => $this->input->post('TOKO_OBAT_MS',true),
				'SARANA_PANTI_SOSIAL_MS' => $this->input->post('SARANA_PANTI_SOSIAL_MS',true),
				'SARANA_KESEHATAN_MS' => $this->input->post('SARANA_KESEHATAN_MS',true),
				'WARUNG_MAKAN_MS' => $this->input->post('WARUNG_MAKAN_MS',true),
				'RUMAH_MAKAN_MS' => $this->input->post('RUMAH_MAKAN_MS',true),
				'JASA_BOGA_MS' => $this->input->post('JASA_BOGA_MS',true),
				'INDSTRI_MKNAN_MNMAN_MS' => $this->input->post('INDSTRI_MKNAN_MNMAN_MS',true),
				'INDSTRI_KCL_R_TANGGA_MS' => $this->input->post('INDSTRI_KCL_R_TANGGA_MS',true),
				'INDUSTRI_BESAR_MS' => $this->input->post('INDUSTRI_BESAR_MS',true),
				'JML_RUMAH_MS' => $this->input->post('JML_RUMAH_MS',true),
				'SGL_MS' => $this->input->post('SGL_MS',true),
				'SPT_MS' => $this->input->post('SPT_MS',true),
				'SR_PDAM_MS' => $this->input->post('SR_PDAM_MS',true),
				'LAIN_LAIN_SAB_MS' => $this->input->post('LAIN_LAIN_SAB_MS',true),
				'JMBN_UMUM_MCK_MS' => $this->input->post('JMBN_UMUM_MCK_MS',true),
				'JMBN_KELUARGA_MS' => $this->input->post('JMBN_KELUARGA_MS',true),
				'SPAL_MS' => $this->input->post('SPAL_MS',true),
				'TPS_MS' => $this->input->post('TPS_MS',true),
				'TPA_MS' => $this->input->post('TPA_MS',true),
				'PONDOK_PESANTREN_MS' => $this->input->post('PONDOK_PESANTREN_MS',true),
				'KIMIAWI_MS' => $this->input->post('KIMIAWI_MS',true),
				'BAKTERIOLOGI_MS' => $this->input->post('BAKTERIOLOGI_MS',true),
				'KLIEN_YDRJ_KLNK_SANITASI_MS' => $this->input->post('KLIEN_YDRJ_KLNK_SANITASI_MS',true),
				'KLIEN_DIKUNJUNGI_MS' => $this->input->post('KLIEN_DIKUNJUNGI_MS',true),
				
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('t_ds_kesling', $dataexc);
			
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
				'SD_MI' => $this->input->post('SD_MI',true),
				'SLTP_MTS' => $this->input->post('SLTP_MTS',true),
				'SLTA_MA' => $this->input->post('SLTA_MA',true),
				'PERGURUAN_TINGGI' => $this->input->post('PERGURUAN_TINGGI',true),
				'KIOS_KUD' => $this->input->post('KIOS_KUD',true),
				'HOTEL_MELATI_LOSMEN' => $this->input->post('HOTEL_MELATI_LOSMEN',true),
				'SALON_KECNTIKAN_P_RAMBUT' => $this->input->post('SALON_KECNTIKAN_P_RAMBUT',true),
				'TEMPAT_REKREASI' => $this->input->post('TEMPAT_REKREASI',true),
				'GD_PERTEMUAN_GD_PERTUNJUKAN' => $this->input->post('GD_PERTEMUAN_GD_PERTUNJUKAN',true),
				'KOLAM_RENANG' => $this->input->post('KOLAM_RENANG',true),
				'MASJID_MUSHOLA' => $this->input->post('MASJID_MUSHOLA',true),
				'GEREJA' => $this->input->post('GEREJA',true),
				'KELENTENG' => $this->input->post('KELENTENG',true),
				'PURA' => $this->input->post('PURA',true),
				'WIHARA' => $this->input->post('WIHARA',true),
				'TERMINAL' => $this->input->post('TERMINAL',true),
				'STASIUN' => $this->input->post('STASIUN',true),
				'PELABUHAN_LAUT' => $this->input->post('PELABUHAN_LAUT',true),
				'PASAR' => $this->input->post('PASAR',true),
				'APOTIK' => $this->input->post('APOTIK',true),
				'TOKO_OBAT' => $this->input->post('TOKO_OBAT',true),
				'SARANA_PANTI_SOSIAL' => $this->input->post('SARANA_PANTI_SOSIAL',true),
				'SARANA_KESEHATAN' => $this->input->post('SARANA_KESEHATAN',true),
				'WARUNG_MAKAN' => $this->input->post('WARUNG_MAKAN',true),
				'RUMAH_MAKAN' => $this->input->post('RUMAH_MAKAN',true),
				'JASA_BOGA' => $this->input->post('JASA_BOGA',true),
				'INDSTRI_MKNAN_MNMAN' => $this->input->post('INDSTRI_MKNAN_MNMAN',true),
				'INDSTRI_KCL_R_TANGGA' => $this->input->post('INDSTRI_KCL_R_TANGGA',true),
				'INDUSTRI_BESAR' => $this->input->post('INDUSTRI_BESAR',true),
				'JML_RUMAH' => $this->input->post('JML_RUMAH',true),
				'SGL' => $this->input->post('SGL',true),
				'SPT' => $this->input->post('SPT',true),
				'SR_PDAM' => $this->input->post('SR_PDAM',true),
				'LAIN_LAIN_SAB' => $this->input->post('LAIN_LAIN_SAB',true),
				'JMBN_UMUM_MCK' => $this->input->post('JMBN_UMUM_MCK',true),
				'JMBN_KELUARGA' => $this->input->post('JMBN_KELUARGA',true),
				'SPAL' => $this->input->post('SPAL',true),
				'TPS' => $this->input->post('TPS',true),
				'TPA' => $this->input->post('TPA',true),
				'PONDOK_PESANTREN' => $this->input->post('PONDOK_PESANTREN',true),
				'KIMIAWI' => $this->input->post('KIMIAWI',true),
				'BAKTERIOLOGI' => $this->input->post('BAKTERIOLOGI',true),
				'KLIEN_YDRJ_KLNK_SANITASI' => $this->input->post('KLIEN_YDRJ_KLNK_SANITASI',true),
				'KLIEN_DIKUNJUNGI' => $this->input->post('KLIEN_DIKUNJUNGI',true),
				
				'SD_MI_MS' => $this->input->post('SD_MI_MS',true),
				'SLTP_MTS_MS' => $this->input->post('SLTP_MTS_MS',true),
				'SLTA_MA_MS' => $this->input->post('SLTA_MA_MS',true),
				'PERGURUAN_TINGGI_MS' => $this->input->post('PERGURUAN_TINGGI_MS',true),
				'KIOS_KUD_MS' => $this->input->post('KIOS_KUD_MS',true),
				'HOTEL_MELATI_LOSMEN_MS' => $this->input->post('HOTEL_MELATI_LOSMEN_MS',true),
				'SALON_KECNTIKAN_P_RAMBUT_MS' => $this->input->post('SALON_KECNTIKAN_P_RAMBUT_MS',true),
				'TEMPAT_REKREASI_MS' => $this->input->post('TEMPAT_REKREASI_MS',true),
				'GD_PERTEMUAN_GD_PERTUNJUKAN_MS' => $this->input->post('GD_PERTEMUAN_GD_PERTUNJUKAN_MS',true),
				'KOLAM_RENANG_MS' => $this->input->post('KOLAM_RENANG_MS',true),
				'MASJID_MUSHOLA_MS' => $this->input->post('MASJID_MUSHOLA_MS',true),
				'GEREJA_MS' => $this->input->post('GEREJA_MS',true),
				'KELENTENG_MS' => $this->input->post('KELENTENG_MS',true),
				'PURA_MS' => $this->input->post('PURA_MS',true),
				'WIHARA_MS' => $this->input->post('WIHARA_MS',true),
				'TERMINAL_MS' => $this->input->post('TERMINAL_MS',true),
				'STASIUN_MS' => $this->input->post('STASIUN_MS',true),
				'PELABUHAN_LAUT_MS' => $this->input->post('PELABUHAN_LAUT_MS',true),
				'PASAR_MS' => $this->input->post('PASAR_MS',true),
				'APOTIK_MS' => $this->input->post('APOTIK_MS',true),
				'TOKO_OBAT_MS' => $this->input->post('TOKO_OBAT_MS',true),
				'SARANA_PANTI_SOSIAL_MS' => $this->input->post('SARANA_PANTI_SOSIAL_MS',true),
				'SARANA_KESEHATAN_MS' => $this->input->post('SARANA_KESEHATAN_MS',true),
				'WARUNG_MAKAN_MS' => $this->input->post('WARUNG_MAKAN_MS',true),
				'RUMAH_MAKAN_MS' => $this->input->post('RUMAH_MAKAN_MS',true),
				'JASA_BOGA_MS' => $this->input->post('JASA_BOGA_MS',true),
				'INDSTRI_MKNAN_MNMAN_MS' => $this->input->post('INDSTRI_MKNAN_MNMAN_MS',true),
				'INDSTRI_KCL_R_TANGGA_MS' => $this->input->post('INDSTRI_KCL_R_TANGGA_MS',true),
				'INDUSTRI_BESAR_MS' => $this->input->post('INDUSTRI_BESAR_MS',true),
				'JML_RUMAH_MS' => $this->input->post('JML_RUMAH_MS',true),
				'SGL_MS' => $this->input->post('SGL_MS',true),
				'SPT_MS' => $this->input->post('SPT_MS',true),
				'SR_PDAM_MS' => $this->input->post('SR_PDAM_MS',true),
				'LAIN_LAIN_SAB_MS' => $this->input->post('LAIN_LAIN_SAB_MS',true),
				'JMBN_UMUM_MCK_MS' => $this->input->post('JMBN_UMUM_MCK_MS',true),
				'JMBN_KELUARGA_MS' => $this->input->post('JMBN_KELUARGA_MS',true),
				'SPAL_MS' => $this->input->post('SPAL_MS',true),
				'TPS_MS' => $this->input->post('TPS_MS',true),
				'TPA_MS' => $this->input->post('TPA_MS',true),
				'PONDOK_PESANTREN_MS' => $this->input->post('PONDOK_PESANTREN_MS',true),
				'KIMIAWI_MS' => $this->input->post('KIMIAWI_MS',true),
				'BAKTERIOLOGI_MS' => $this->input->post('BAKTERIOLOGI_MS',true),
				'KLIEN_YDRJ_KLNK_SANITASI_MS' => $this->input->post('KLIEN_YDRJ_KLNK_SANITASI_MS',true),
				'KLIEN_DIKUNJUNGI_MS' => $this->input->post('KLIEN_DIKUNJUNGI_MS',true),
				
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);
			
			$id=$this->input->post('ID',true);
			
			$db->where('ID',$id);
			$db->update('t_ds_kesling', $dataexc);
			
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
						from t_ds_kesling t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI						
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('t_ds_kesling/v_ds_kesling_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from t_ds_kesling where ID = '".$id."'")){
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
						from t_ds_kesling t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_puskesmas ps on ps.KD_PUSKESMAS=t.KD_PUSKESMAS
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('t_ds_kesling/v_ds_kesling_detail',$data);
	}
	
}

/* End of file c_ds_gigi.php */
/* Location: ./application/controllers/c_ds_gigi.php */