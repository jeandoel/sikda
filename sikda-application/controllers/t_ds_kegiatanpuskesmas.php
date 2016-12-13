<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_ds_kegiatanpuskesmas extends CI_Controller {
	public function index()
	{
		$this->load->view('t_ds_kegiatanpuskesmas/v_ds_kegiatanpuskesmas');
	}
	
	public function ds_kegiatanpuskesmasxml()
	{
		$this->load->model('t_ds_kegiatanpuskesmas_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'tahun'=>$this->input->post('tahun'),
					'carinama'=>$this->input->post('carinama')
					);
					
		$total = $this->t_ds_kegiatanpuskesmas_model->totalds_kegiatanpuskesmas($paramstotal);
		
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
					
		$result = $this->t_ds_kegiatanpuskesmas_model->getds_kegiatanpuskesmas($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_ds_kegiatanpuskesmas/v_ds_kegiatanpuskesmas_add');
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
				'JML_KR_DARI_PUSKESMAS' => $this->input->post('JML_KR_DARI_PUSKESMAS',true),
				'JML_KR_B_RUMAH_SAKIT' => $this->input->post('JML_KR_B_RUMAH_SAKIT',true),
				'JML_KR_KA_PUSKESMAS' => $this->input->post('JML_KR_KA_PUSKESMAS',true),
				'JML_KR_PO_PUSKESMAS' => $this->input->post('JML_KR_PO_PUSKESMAS',true),
				'JML_KR_PU_PUSKESMAS' => $this->input->post('JML_KR_PU_PUSKESMAS',true),
				'JML_KR_SE_PUSKESMAS' => $this->input->post('JML_KR_SE_PUSKESMAS',true),
				'JML_KR_LAIN_PUSKESMAS' => $this->input->post('JML_KR_LAIN_PUSKESMAS',true),
				'JML_KR_KE_PUSKESMAS' => $this->input->post('JML_KR_KE_PUSKESMAS',true),
				'JML_KR_K_DOKTER_AHLI' => $this->input->post('JML_KR_K_DOKTER_AHLI',true),
				'KL_PS_DARAH' => $this->input->post('KL_PS_DARAH',true),
				'KL_PS_URINE' => $this->input->post('KL_PS_URINE',true),
				'KL_PS_TINJA' => $this->input->post('KL_PS_TINJA',true),
				'KL_PS_LAIN' => $this->input->post('KL_PS_LAIN',true),
				'JML_PKR_PUSKESMAS' => $this->input->post('JML_PKR_PUSKESMAS',true),
				'JML_PKR_DIBINA' => $this->input->post('JML_PKR_DIBINA',true),
				'JML_PKR_KUNJUNGAN_DIBINA' => $this->input->post('JML_PKR_KUNJUNGAN_DIBINA',true),
				'JML_KASUS_TLPSB' => $this->input->post('JML_KASUS_TLPSB',true),
				'JML_KUNJ_TLPSB' => $this->input->post('JML_KUNJ_TLPSB',true),
				//'JML_PGR_BUMIL_PERAWATAN' => $this->input->post('JML_PGR_BUMIL_PERAWATAN',true),
				'JML_PGR_BALITA_PERAWATAN' => $this->input->post('JML_PGR_BALITA_PERAWATAN',true),
				'JML_PKKP_DIBINA' => $this->input->post('JML_PKKP_DIBINA',true),
				'JML_KK_UMUM_BAYAR' => $this->input->post('JML_KK_UMUM_BAYAR',true),
				'JML_KK_ASKES' => $this->input->post('JML_KK_ASKES',true),
				'JML_KK_JPS_K_SEHAT' => $this->input->post('JML_KK_JPS_K_SEHAT',true),
				'JML_RT_P_DIRAWAT' => $this->input->post('JML_RT_P_DIRAWAT',true),
				'JML_RT_H_PERAWATAN' => $this->input->post('JML_RT_H_PERAWATAN',true),
				'JML_RT_T_TIDUR' => $this->input->post('JML_RT_T_TIDUR',true),
				'JML_RT_H_BUKA' => $this->input->post('JML_RT_H_BUKA',true),
				'JML_RT_PK_MENINGGAL_K_48' => $this->input->post('JML_RT_PK_MENINGGAL_K_48',true),
				'JML_RT_PK_MENINGGAL_L_48' => $this->input->post('JML_RT_PK_MENINGGAL_L_48',true),
				
				'JML_KR_DARI_PUSKESMAS_P' => $this->input->post('JML_KR_DARI_PUSKESMAS_P',true),
				'JML_KR_B_RUMAH_SAKIT_P' => $this->input->post('JML_KR_B_RUMAH_SAKIT_P',true),
				'JML_KR_KA_PUSKESMAS_P' => $this->input->post('JML_KR_KA_PUSKESMAS_P',true),
				'JML_KR_PO_PUSKESMAS_P' => $this->input->post('JML_KR_PO_PUSKESMAS_P',true),
				'JML_KR_PU_PUSKESMAS_P' => $this->input->post('JML_KR_PU_PUSKESMAS_P',true),
				'JML_KR_SE_PUSKESMAS_P' => $this->input->post('JML_KR_SE_PUSKESMAS_P',true),
				'JML_KR_LAIN_PUSKESMAS_P' => $this->input->post('JML_KR_LAIN_PUSKESMAS_P',true),
				'JML_KR_KE_PUSKESMAS_P' => $this->input->post('JML_KR_KE_PUSKESMAS_P',true),
				'JML_KR_K_DOKTER_AHLI_P' => $this->input->post('JML_KR_K_DOKTER_AHLI_P',true),
				'KL_PS_DARAH_P' => $this->input->post('KL_PS_DARAH_P',true),
				'KL_PS_URINE_P' => $this->input->post('KL_PS_URINE_P',true),
				'KL_PS_TINJA_P' => $this->input->post('KL_PS_TINJA_P',true),
				'KL_PS_LAIN_P' => $this->input->post('KL_PS_LAIN_P',true),
				'JML_PKR_PUSKESMAS_P' => $this->input->post('JML_PKR_PUSKESMAS_P',true),
				'JML_PKR_DIBINA_P' => $this->input->post('JML_PKR_DIBINA_P',true),
				'JML_PKR_KUNJUNGAN_DIBINA_P' => $this->input->post('JML_PKR_KUNJUNGAN_DIBINA_P',true),
				'JML_KASUS_TLPSB_P' => $this->input->post('JML_KASUS_TLPSB_P',true),
				'JML_KUNJ_TLPSB_P' => $this->input->post('JML_KUNJ_TLPSB_P',true),
				'JML_PGR_BUMIL_PERAWATAN_P' => $this->input->post('JML_PGR_BUMIL_PERAWATAN_P',true),
				'JML_PGR_BALITA_PERAWATAN_P' => $this->input->post('JML_PGR_BALITA_PERAWATAN_P',true),
				'JML_PKKP_DIBINA_P' => $this->input->post('JML_PKKP_DIBINA_P',true),
				'JML_KK_UMUM_BAYAR_P' => $this->input->post('JML_KK_UMUM_BAYAR_P',true),
				'JML_KK_ASKES_P' => $this->input->post('JML_KK_ASKES_P',true),
				'JML_KK_JPS_K_SEHAT_P' => $this->input->post('JML_KK_JPS_K_SEHAT_P',true),
				'JML_RT_P_DIRAWAT_P' => $this->input->post('JML_RT_P_DIRAWAT_P',true),
				'JML_RT_H_PERAWATAN_P' => $this->input->post('JML_RT_H_PERAWATAN_P',true),
				'JML_RT_T_TIDUR_P' => $this->input->post('JML_RT_T_TIDUR_P',true),
				'JML_RT_H_BUKA_P' => $this->input->post('JML_RT_H_BUKA_P',true),
				'JML_RT_PK_MENINGGAL_K_48_P' => $this->input->post('JML_RT_PK_MENINGGAL_K_48_P',true),
				'JML_RT_PK_MENINGGAL_L_48_P' => $this->input->post('JML_RT_PK_MENINGGAL_L_48_P',true),
				
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('t_ds_kegiatanpuskesmas', $dataexc);
			
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
				'JML_KR_DARI_PUSKESMAS' => $this->input->post('JML_KR_DARI_PUSKESMAS',true),
				'JML_KR_B_RUMAH_SAKIT' => $this->input->post('JML_KR_B_RUMAH_SAKIT',true),
				'JML_KR_KA_PUSKESMAS' => $this->input->post('JML_KR_KA_PUSKESMAS',true),
				'JML_KR_PO_PUSKESMAS' => $this->input->post('JML_KR_PO_PUSKESMAS',true),
				'JML_KR_PU_PUSKESMAS' => $this->input->post('JML_KR_PU_PUSKESMAS',true),
				'JML_KR_SE_PUSKESMAS' => $this->input->post('JML_KR_SE_PUSKESMAS',true),
				'JML_KR_LAIN_PUSKESMAS' => $this->input->post('JML_KR_LAIN_PUSKESMAS',true),
				'JML_KR_KE_PUSKESMAS' => $this->input->post('JML_KR_KE_PUSKESMAS',true),
				'JML_KR_K_DOKTER_AHLI' => $this->input->post('JML_KR_K_DOKTER_AHLI',true),
				'KL_PS_DARAH' => $this->input->post('KL_PS_DARAH',true),
				'KL_PS_URINE' => $this->input->post('KL_PS_URINE',true),
				'KL_PS_TINJA' => $this->input->post('KL_PS_TINJA',true),
				'KL_PS_LAIN' => $this->input->post('KL_PS_LAIN',true),
				'JML_PKR_PUSKESMAS' => $this->input->post('JML_PKR_PUSKESMAS',true),
				'JML_PKR_DIBINA' => $this->input->post('JML_PKR_DIBINA',true),
				'JML_PKR_KUNJUNGAN_DIBINA' => $this->input->post('JML_PKR_KUNJUNGAN_DIBINA',true),
				'JML_KASUS_TLPSB' => $this->input->post('JML_KASUS_TLPSB',true),
				'JML_KUNJ_TLPSB' => $this->input->post('JML_KUNJ_TLPSB',true),
				//'JML_PGR_BUMIL_PERAWATAN' => $this->input->post('JML_PGR_BUMIL_PERAWATAN',true),
				'JML_PGR_BALITA_PERAWATAN' => $this->input->post('JML_PGR_BALITA_PERAWATAN',true),
				'JML_PKKP_DIBINA' => $this->input->post('JML_PKKP_DIBINA',true),
				'JML_KK_UMUM_BAYAR' => $this->input->post('JML_KK_UMUM_BAYAR',true),
				'JML_KK_ASKES' => $this->input->post('JML_KK_ASKES',true),
				'JML_KK_JPS_K_SEHAT' => $this->input->post('JML_KK_JPS_K_SEHAT',true),
				'JML_RT_P_DIRAWAT' => $this->input->post('JML_RT_P_DIRAWAT',true),
				'JML_RT_H_PERAWATAN' => $this->input->post('JML_RT_H_PERAWATAN',true),
				'JML_RT_T_TIDUR' => $this->input->post('JML_RT_T_TIDUR',true),
				'JML_RT_H_BUKA' => $this->input->post('JML_RT_H_BUKA',true),
				'JML_RT_PK_MENINGGAL_K_48' => $this->input->post('JML_RT_PK_MENINGGAL_K_48',true),
				'JML_RT_PK_MENINGGAL_L_48' => $this->input->post('JML_RT_PK_MENINGGAL_L_48',true),
				
				'JML_KR_DARI_PUSKESMAS_P' => $this->input->post('JML_KR_DARI_PUSKESMAS_P',true),
				'JML_KR_B_RUMAH_SAKIT_P' => $this->input->post('JML_KR_B_RUMAH_SAKIT_P',true),
				'JML_KR_KA_PUSKESMAS_P' => $this->input->post('JML_KR_KA_PUSKESMAS_P',true),
				'JML_KR_PO_PUSKESMAS_P' => $this->input->post('JML_KR_PO_PUSKESMAS_P',true),
				'JML_KR_PU_PUSKESMAS_P' => $this->input->post('JML_KR_PU_PUSKESMAS_P',true),
				'JML_KR_SE_PUSKESMAS_P' => $this->input->post('JML_KR_SE_PUSKESMAS_P',true),
				'JML_KR_LAIN_PUSKESMAS_P' => $this->input->post('JML_KR_LAIN_PUSKESMAS_P',true),
				'JML_KR_KE_PUSKESMAS_P' => $this->input->post('JML_KR_KE_PUSKESMAS_P',true),
				'JML_KR_K_DOKTER_AHLI_P' => $this->input->post('JML_KR_K_DOKTER_AHLI_P',true),
				'KL_PS_DARAH_P' => $this->input->post('KL_PS_DARAH_P',true),
				'KL_PS_URINE_P' => $this->input->post('KL_PS_URINE_P',true),
				'KL_PS_TINJA_P' => $this->input->post('KL_PS_TINJA_P',true),
				'KL_PS_LAIN_P' => $this->input->post('KL_PS_LAIN_P',true),
				'JML_PKR_PUSKESMAS_P' => $this->input->post('JML_PKR_PUSKESMAS_P',true),
				'JML_PKR_DIBINA_P' => $this->input->post('JML_PKR_DIBINA_P',true),
				'JML_PKR_KUNJUNGAN_DIBINA_P' => $this->input->post('JML_PKR_KUNJUNGAN_DIBINA_P',true),
				'JML_KASUS_TLPSB_P' => $this->input->post('JML_KASUS_TLPSB_P',true),
				'JML_KUNJ_TLPSB_P' => $this->input->post('JML_KUNJ_TLPSB_P',true),
				'JML_PGR_BUMIL_PERAWATAN_P' => $this->input->post('JML_PGR_BUMIL_PERAWATAN_P',true),
				'JML_PGR_BALITA_PERAWATAN_P' => $this->input->post('JML_PGR_BALITA_PERAWATAN_P',true),
				'JML_PKKP_DIBINA_P' => $this->input->post('JML_PKKP_DIBINA_P',true),
				'JML_KK_UMUM_BAYAR_P' => $this->input->post('JML_KK_UMUM_BAYAR_P',true),
				'JML_KK_ASKES_P' => $this->input->post('JML_KK_ASKES_P',true),
				'JML_KK_JPS_K_SEHAT_P' => $this->input->post('JML_KK_JPS_K_SEHAT_P',true),
				'JML_RT_P_DIRAWAT_P' => $this->input->post('JML_RT_P_DIRAWAT_P',true),
				'JML_RT_H_PERAWATAN_P' => $this->input->post('JML_RT_H_PERAWATAN_P',true),
				'JML_RT_T_TIDUR_P' => $this->input->post('JML_RT_T_TIDUR_P',true),
				'JML_RT_H_BUKA_P' => $this->input->post('JML_RT_H_BUKA_P',true),
				'JML_RT_PK_MENINGGAL_K_48_P' => $this->input->post('JML_RT_PK_MENINGGAL_K_48_P',true),
				'JML_RT_PK_MENINGGAL_L_48_P' => $this->input->post('JML_RT_PK_MENINGGAL_L_48_P',true),
				
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);
			
			$id=$this->input->post('ID',true);
			
			$db->where('ID',$id);
			$db->update('t_ds_kegiatanpuskesmas', $dataexc);
			
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
						from t_ds_kegiatanpuskesmas t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI						
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('t_ds_kegiatanpuskesmas/v_ds_kegiatanpuskesmas_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from t_ds_kegiatanpuskesmas where ID = '".$id."'")){
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
						from t_ds_kegiatanpuskesmas t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_puskesmas ps on ps.KD_PUSKESMAS=t.KD_PUSKESMAS
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('t_ds_kegiatanpuskesmas/v_ds_kegiatanpuskesmas_detail',$data);
	}
	
}

/* End of file c_ds_kegiatanpuskesmas.php */
/* Location: ./application/controllers/c_ds_kegiatanpuskesmas.php */