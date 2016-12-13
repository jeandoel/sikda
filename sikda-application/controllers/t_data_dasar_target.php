<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_data_dasar_target extends CI_Controller {
	public function index()
	{
		$this->load->view('t_data_dasar_target/v_t_data_dasar_target');
	}
	
	public function t_datadasartargetxml()
	{
		$this->load->model('m_t_data_dasar_target');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'kodedatadasartarget'=>$this->input->post('kodedatadasartarget'),
					'carinama'=>$this->input->post('carinama')
					);
					
		$total = $this->m_t_data_dasar_target->totalt_datadasartarget($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'kodedatadasartarget'=>$this->input->post('kodedatadasartarget'),
					'carinama'=>$this->input->post('carinama')
					);
					
		$result = $this->m_t_data_dasar_target->getData_dasar_target($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	///////////////////////////////////////////////////////////////////////////////////////////////
	public function t_subgriddatadasartargetxml()
	{		
		$this->load->model('m_t_data_dasar_target');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(				
					'namadesa'=>$this->input->post('namadesa'),
					'kodekecamatan'=>$this->input->post('kodekecamatan'),
					'tahun'=>$this->input->post('tahun')
					);
					
		$total = $this->m_t_data_dasar_target->totalsubgriddatadasartarget($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'namadesa'=>$this->input->post('namadesa'),
					'kodekecamatan'=>$this->input->post('kodekecamatan'),
					'tahun'=>$this->input->post('tahun')
					);
					
					
		$result = $this->m_t_data_dasar_target->getsubgridData_dasar_target($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	///////////////////////////////////////////////////////////////////////////////////////////////
	public function add()
	{
		
		$db = $this->load->database('sikda', TRUE);
		$dataall = $db->query("select a.*, b.KECAMATAN from sys_setting_def a join mst_kecamatan b on a.KD_KEC=b.KD_KECAMATAN
		where kd_puskesmas='".$this->session->userdata("kd_puskesmas")."'")->row(); //print_r($dataall);die;
		$data['data'] = $dataall;
		//$data['desa'] = $db->query("select KD_KELURAHAN from mst_kelurahan where KELURAHAN like'".$dataall->NAMA_PUSKESMAS."' and KD_KECAMATAN='".$dataall->KD_KEC."'")->row();*/
		$this->load->view('t_data_dasar_target/v_t_data_dasar_target_add', $data);
		
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');
		$val = $this->form_validation;
		$val->set_rules('kodedatadasartarget');		
		$val->set_rules('kecamatan', 'Kecamatan', 'trim|required|xss_clean');		
		$val->set_rules('namadesa', 'Nama Desa', 'trim|required|xss_clean');
		$val->set_rules('tahun', 'Tahun', 'trim|required|xss_clean|min_length[4]|max_length[4]');
		$val->set_rules('jmlbayi', 'Jumlah Bayi', 'trim|required|xss_clean');
		$val->set_rules('jmlbalita', 'Jumlah Balita', 'trim|required|xss_clean');
		$val->set_rules('jmlanak', 'Jumlah Anak', 'trim|required|xss_clean');
		$val->set_rules('jmlcaten', 'Jumlah Caten', 'trim|required|xss_clean');
		$val->set_rules('jmlwushamil', 'Jumlah WUS Hamil', 'trim|required|xss_clean');
		$val->set_rules('jmlwustdkhamil', 'Jumlah WUS Tidak Hamil', 'trim|required|xss_clean');
		$val->set_rules('jmlsd', 'Jumlah SD', 'trim|required|xss_clean');
		$val->set_rules('jmlposyandu', 'Jumlah Posyandu', 'trim|required|xss_clean');
		$val->set_rules('jmlupsbds', 'Jumlah UPS BDS', 'trim|required|xss_clean');
		$val->set_rules('jmlpembinawil', 'Jumlah Pembina WIL', 'trim|required|xss_clean');
		$val->set_rules('waktutempuh', 'Waktu Tempuh', 'trim|required|xss_clean');
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
				'KD_DATA_DASAR' => $val->set_value('kodedatadasartarget'),
				'KD_KECAMATAN' => $this->input->post('kd_kec_hidden'),
				'KD_KELURAHAN' => $val->set_value('namadesa'),
				'TAHUN' => $val->set_value('tahun'),
				'JML_BAYI' => $val->set_value('jmlbayi'),
				'JML_BALITA' => $val->set_value('jmlbalita'),
				'JML_ANAK' => $val->set_value('jmlanak'),
				'JML_CATEN' => $val->set_value('jmlcaten'),
				'JML_WUS_HAMIL' => $val->set_value('jmlwushamil'),
				'JML_WUS_TDK_HAMIL' => $val->set_value('jmlwustdkhamil'),
				'JML_SD' => $val->set_value('jmlsd'),
				'JML_POSYANDU' => $val->set_value('jmlposyandu'),
				'JML_UPS_BDS' => $val->set_value('jmlupsbds'),
				'JML_PEMBINA_WIL' => $val->set_value('jmlpembinawil'),
				'WAKTU_TEMPUH' => $val->set_value('waktutempuh'),
				'nama_input' => $this->session->userdata('nusername'),
				'tgl_input' => date('Y-m-d H:i:s')
			);
			
			$db->insert('data_dasar', $dataexc);
			$id_datadasar = $db->insert_id();
			
			
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
		$id = $this->input->post('id',TRUE);	
		
		$val = $this->form_validation;	
		$val->set_rules('kecamatan', 'Kecamatan', 'trim|required|xss_clean');		
		$val->set_rules('namadesa', 'Nama Desa', 'trim|required|xss_clean');
		$val->set_rules('tahun', 'Tahun', 'trim|required|xss_clean');
		$val->set_rules('jmlbayi', 'Jumlah Bayi', 'trim|required|xss_clean');
		$val->set_rules('jmlbalita', 'Jumlah Balita', 'trim|required|xss_clean');
		$val->set_rules('jmlanak', 'Jumlah Anak', 'trim|required|xss_clean');
		$val->set_rules('jmlcaten', 'Jumlah Caten', 'trim|required|xss_clean');
		$val->set_rules('jmlwushamil', 'Jumlah WUS Hamil', 'trim|required|xss_clean');
		$val->set_rules('jmlwustdkhamil', 'Jumlah WUS Tidak Hamil', 'trim|required|xss_clean');
		$val->set_rules('jmlsd', 'Jumlah SD', 'trim|required|xss_clean');
		$val->set_rules('jmlposyandu', 'Jumlah Posyandu', 'trim|required|xss_clean');
		$val->set_rules('jmlupsbds', 'Jumlah UPS BDS', 'trim|required|xss_clean');
		$val->set_rules('jmlpembinawil', 'Jumlah Pembina WIL', 'trim|required|xss_clean');
		$val->set_rules('waktutempuh', 'Waktu Tempuh', 'trim|required|xss_clean');
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
				'KD_KECAMATAN' => $this->input->post('kd_kec_hidden'),
				'KD_KELURAHAN' => $this->input->post('namadesa'),
				'TAHUN' => $val->set_value('tahun'),
				'JML_BAYI' => $val->set_value('jmlbayi'),
				'JML_BALITA' => $val->set_value('jmlbalita'),
				'JML_ANAK' => $val->set_value('jmlanak'),
				'JML_CATEN' => $val->set_value('jmlcaten'),
				'JML_WUS_HAMIL' => $val->set_value('jmlwushamil'),
				'JML_WUS_TDK_HAMIL' => $val->set_value('jmlwustdkhamil'),
				'JML_SD' => $val->set_value('jmlsd'),
				'JML_POSYANDU' => $val->set_value('jmlposyandu'),
				'JML_UPS_BDS' => $val->set_value('jmlupsbds'),
				'JML_PEMBINA_WIL' => $val->set_value('jmlpembinawil'),
				'WAKTU_TEMPUH' => $val->set_value('waktutempuh'),
				'nama_update' => $this->session->userdata('nusername'),
				'tgl_update' => date('Y-m-d H:i:s')
			);			
			//print_r($dataexc);die;
			$db->where('KD_DATA_DASAR',$id);
			$db->update('data_dasar', $dataexc);
			//print_r($db->last_query());die;
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
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$puskesmas = $this->session->userdata('puskesmas');
		
		$db->select('u.KD_DATA_DASAR, u.KD_KECAMATAN, a.KECAMATAN, b.KD_KELURAHAN, b.KELURAHAN, TAHUN, JML_BAYI, JML_BALITA, JML_ANAK, 
		JML_CATEN, JML_WUS_HAMIL, JML_WUS_TDK_HAMIL, JML_SD, JML_POSYANDU, JML_UPS_BDS, JML_PEMBINA_WIL, WAKTU_TEMPUH');
		$db->from('data_dasar u');
		$db->join('mst_kecamatan a','a.KD_KECAMATAN=u.KD_KECAMATAN');
		$db->join('mst_kelurahan b','b.KD_KELURAHAN=u.KD_KELURAHAN');
		$db->where('KD_DATA_DASAR',$id);
		$val = $db->get()->row();
		$data['data']=$val;//print_r($data);die;
		$this->load->view('t_data_dasar_target/v_t_data_dasar_target_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from data_dasar where KD_DATA_DASAR = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$puskesmas = $this->session->userdata('puskesmas');
		
		$db->select('a.KECAMATAN, b.KELURAHAN, TAHUN, JML_BAYI, JML_BALITA, JML_ANAK, JML_CATEN, JML_WUS_HAMIL, JML_WUS_TDK_HAMIL, JML_SD, JML_POSYANDU, JML_UPS_BDS, JML_PEMBINA_WIL, WAKTU_TEMPUH');
		$db->from('data_dasar u');
		$db->join('mst_kecamatan a','a.KD_KECAMATAN=u.KD_KECAMATAN');
		$db->join('mst_kelurahan b','b.KD_KELURAHAN=u.KD_KELURAHAN');
		$db->where('KD_DATA_DASAR',$id);
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('t_data_dasar_target/v_t_data_dasar_target_detail',$data);
	}
	
	/*public function detailsub()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$puskesmas = $this->session->userdata('puskesmas');
		
		$db->select("a.KD_TRANS_IMUNISASI, a.TAHUN, SUM(IF((a.KD_JENIS_PASIEN ='1'), 1,0)) AS JUMLAH_SISWA, SUM(IF((a.KD_JENIS_PASIEN ='2'), 1,0)) AS ANAK,
						  SUM(IF((a.KD_JENIS_PASIEN ='3'), 1,0)) AS BAYI, SUM(IF((a.KD_JENIS_PASIEN ='4'), 1,0)) AS BALITA, 
						  SUM(IF((a.KD_JENIS_PASIEN ='5'), 1,0)) AS WUS_TIDAK_HAMIL, SUM(IF((a.KD_JENIS_PASIEN ='6'), 1,0)) AS WUS_HAMIL, 
						  SUM(IF((a.KD_JENIS_PASIEN ='7'), 1,0)) AS PASIEN_BIASA, SUM(IF((a.KD_JENIS_PASIEN ='8'), 1,0)) AS CATEN, KD_TRANS_IMUNISASI as nid", false);
		$db->from('trans_imunisasi a');
		$db->join('mst_jenis_pasien b','a.KD_JENIS_PASIEN=b.KD_JENIS_PASIEN');
		$db->join('data_dasar c','c.KD_KELURAHAN=a.`KD_KELURAHAN`');
		$db->where('c.KD_KELURAHAN =', $id);
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('t_data_dasar_target/v_t_data_dasar_target_detail_sub',$data);
	}*/
	
}

/* End of file master_kecamatan.php */
/* Location: ./application/controllers/c_master_kecamatan.php */