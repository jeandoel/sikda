<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_ds_promkes extends CI_Controller {
	public function index()
	{
		$this->load->view('t_ds_promkes/v_ds_promkes');
	}
	
	public function ds_promkesxml()
	{
		$this->load->model('t_ds_promkes_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'tahun'=>$this->input->post('tahun'),
					'carinama'=>$this->input->post('carinama')
					);
					
		$total = $this->t_ds_promkes_model->totalds_promkes($paramstotal);
		
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
					
		$result = $this->t_ds_promkes_model->getds_promkes($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_ds_promkes/v_ds_promkes_add');
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
				'JML_P_AKTIF' => $this->input->post('JML_P_AKTIF',true),
				'JML_P_PRATAMA' => $this->input->post('JML_P_PRATAMA',true),
				'JML_P_MADYA' => $this->input->post('JML_P_MADYA',true),
				'JML_P_PURNAMA' => $this->input->post('JML_P_PURNAMA',true),
				'JML_P_MANDIRI' => $this->input->post('JML_P_MANDIRI',true),
				'JML_P_LANSIA' => $this->input->post('JML_P_LANSIA',true),
				'JML_LKP_LANSIA' => $this->input->post('JML_LKP_LANSIA',true),
				'JML_KADER_AKTIF' => $this->input->post('JML_KADER_AKTIF',true),
				'JML_PP_DIBINA' => $this->input->post('JML_PP_DIBINA',true),
				'JML_FPP_PESANTREN' => $this->input->post('JML_FPP_PESANTREN',true),
				'JML_SKSB_HUSADA' => $this->input->post('JML_SKSB_HUSADA',true),
				'JML_PSB_HUSADA' => $this->input->post('JML_PSB_HUSADA',true),
				'JML_PENYULUHAN_DB' => $this->input->post('JML_PENYULUHAN_DB',true),
				'JML_PENYULUHAN_KESLING' => $this->input->post('JML_PENYULUHAN_KESLING',true),
				'JML_PENYULUHAN_KIA' => $this->input->post('JML_PENYULUHAN_KIA',true),
				'JML_PENYULUHAN_TBC' => $this->input->post('JML_PENYULUHAN_TBC',true),
				'JML_PENYULUHAN_NAPZA' => $this->input->post('JML_PENYULUHAN_NAPZA',true),
				'JML_PENYULUHAN_PTM' => $this->input->post('JML_PENYULUHAN_PTM',true),
				'JML_PENYULUHAN_MALARIA' => $this->input->post('JML_PENYULUHAN_MALARIA',true),
				'JML_PENYULUHAN_DIARE' => $this->input->post('JML_PENYULUHAN_DIARE',true),
				'JML_PENYULUHAN_GIZI' => $this->input->post('JML_PENYULUHAN_GIZI',true),
				'JML_PENYULUHAN_PHBS' => $this->input->post('JML_PENYULUHAN_PHBS',true),
				'JML_PD_PSN' => $this->input->post('JML_PD_PSN',true),
				'JML_RMH_BEBAS_JENTIK' => $this->input->post('JML_RMH_BEBAS_JENTIK',true),
				'JML_RMH_DIPERIKSA' => $this->input->post('JML_RMH_DIPERIKSA',true),
				'JML_TTU_BEBAS_JENTIK' => $this->input->post('JML_TTU_BEBAS_JENTIK',true),
				'JML_TTU_DIPERIKSA' => $this->input->post('JML_TTU_DIPERIKSA',true),
				'JML_TOGA' => $this->input->post('JML_TOGA',true),
				'JML_P_TOMAGA' => $this->input->post('JML_P_TOMAGA',true),
				'JML_P_UKK' => $this->input->post('JML_P_UKK',true),
				'JML_PD_SIAGA' => $this->input->post('JML_PD_SIAGA',true),
				'JML_RT_PRATAMA' => $this->input->post('JML_RT_PRATAMA',true),
				'JML_RT_MADYA' => $this->input->post('JML_RT_MADYA',true),
				'JML_RT_UTAMA' => $this->input->post('JML_RT_UTAMA',true),
				'JML_RT_PARIPURNA' => $this->input->post('JML_RT_PARIPURNA',true),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('t_ds_promkes', $dataexc);
			
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
				'JML_P_AKTIF' => $this->input->post('JML_P_AKTIF',true),
				'JML_P_PRATAMA' => $this->input->post('JML_P_PRATAMA',true),
				'JML_P_MADYA' => $this->input->post('JML_P_MADYA',true),
				'JML_P_PURNAMA' => $this->input->post('JML_P_PURNAMA',true),
				'JML_P_MANDIRI' => $this->input->post('JML_P_MANDIRI',true),
				'JML_P_LANSIA' => $this->input->post('JML_P_LANSIA',true),
				'JML_LKP_LANSIA' => $this->input->post('JML_LKP_LANSIA',true),
				'JML_KADER_AKTIF' => $this->input->post('JML_KADER_AKTIF',true),
				'JML_PP_DIBINA' => $this->input->post('JML_PP_DIBINA',true),
				'JML_FPP_PESANTREN' => $this->input->post('JML_FPP_PESANTREN',true),
				'JML_SKSB_HUSADA' => $this->input->post('JML_SKSB_HUSADA',true),
				'JML_PSB_HUSADA' => $this->input->post('JML_PSB_HUSADA',true),
				'JML_PENYULUHAN_DB' => $this->input->post('JML_PENYULUHAN_DB',true),
				'JML_PENYULUHAN_KESLING' => $this->input->post('JML_PENYULUHAN_KESLING',true),
				'JML_PENYULUHAN_KIA' => $this->input->post('JML_PENYULUHAN_KIA',true),
				'JML_PENYULUHAN_TBC' => $this->input->post('JML_PENYULUHAN_TBC',true),
				'JML_PENYULUHAN_NAPZA' => $this->input->post('JML_PENYULUHAN_NAPZA',true),
				'JML_PENYULUHAN_PTM' => $this->input->post('JML_PENYULUHAN_PTM',true),
				'JML_PENYULUHAN_MALARIA' => $this->input->post('JML_PENYULUHAN_MALARIA',true),
				'JML_PENYULUHAN_DIARE' => $this->input->post('JML_PENYULUHAN_DIARE',true),
				'JML_PENYULUHAN_GIZI' => $this->input->post('JML_PENYULUHAN_GIZI',true),
				'JML_PENYULUHAN_PHBS' => $this->input->post('JML_PENYULUHAN_PHBS',true),
				'JML_PD_PSN' => $this->input->post('JML_PD_PSN',true),
				'JML_RMH_BEBAS_JENTIK' => $this->input->post('JML_RMH_BEBAS_JENTIK',true),
				'JML_RMH_DIPERIKSA' => $this->input->post('JML_RMH_DIPERIKSA',true),
				'JML_TTU_BEBAS_JENTIK' => $this->input->post('JML_TTU_BEBAS_JENTIK',true),
				'JML_TTU_DIPERIKSA' => $this->input->post('JML_TTU_DIPERIKSA',true),
				'JML_TOGA' => $this->input->post('JML_TOGA',true),
				'JML_P_TOMAGA' => $this->input->post('JML_P_TOMAGA',true),
				'JML_P_UKK' => $this->input->post('JML_P_UKK',true),
				'JML_PD_SIAGA' => $this->input->post('JML_PD_SIAGA',true),
				'JML_RT_PRATAMA' => $this->input->post('JML_RT_PRATAMA',true),
				'JML_RT_MADYA' => $this->input->post('JML_RT_MADYA',true),
				'JML_RT_UTAMA' => $this->input->post('JML_RT_UTAMA',true),
				'JML_RT_PARIPURNA' => $this->input->post('JML_RT_PARIPURNA',true),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);
			
			$id=$this->input->post('ID',true);
			
			$db->where('ID',$id);
			$db->update('t_ds_promkes', $dataexc);
			
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
						from t_ds_promkes t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI						
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('t_ds_promkes/v_ds_promkes_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from t_ds_promkes where ID = '".$id."'")){
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
						from t_ds_promkes t left join mst_provinsi p on p.KD_PROVINSI=t.KD_PROPINSI
						join mst_kabupaten k on k.KD_KABUPATEN=t.KD_KABUPATEN
						join mst_puskesmas ps on ps.KD_PUSKESMAS=t.KD_PUSKESMAS
						join mst_kecamatan kc on kc.KD_KECAMATAN=t.KD_KECAMATAN
						join mst_kelurahan kl on kl.KD_KELURAHAN=t.KD_KELURAHAN
						where ID = '".$id."'")->row();
		$data['data']=$val;
		$this->load->view('t_ds_promkes/v_ds_promkes_detail',$data);
	}
	
}

/* End of file c_ds_promkes.php */
/* Location: ./application/controllers/c_ds_promkes.php */