<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class C_master_obat extends CI_Controller {
	public function index()
	{
		$this->load->helper('ernes_helper');
		$this->load->view('masterObat/v_master_obat');
	}
	public function masterobatpopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('masterObat/v_master_obat_popup',$data);
	}
	
	public function obatxml()
	{
		$this->load->model('m_master_obat');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'nama'=>$this->input->post('nama')
					);
					
		$total = $this->m_master_obat->totalObat($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'nama'=>$this->input->post('nama')
					);
					
		$result = $this->m_master_obat->getObat($params);
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->view('masterObat/v_master_obat_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');
		
		
		$val = $this->form_validation;
		
		$val->set_rules('kode_obat_val', 'KODE OBAT', 'trim|required|xss_clean');
		$val->set_rules('nama_obat', 'NAMA OBAT', 'trim|required|xss_clean');
		$val->set_rules('kd_gol_obat', 'KD GOL OBAT', 'trim|required|xss_clean');
		if($this->input->post('kd_gol_obat')){
			if($this->input->post('kd_gol_obat')=='VAKSIN'){
				$val->set_rules('jenis_imunisasi', 'Jenis Imunisasi', 'trim|xss_clean');
			}else{
				$val->set_rules('kd_gol_obat', 'KD GOL OBAT', 'trim|xss_clean');
			}
		}
		$val->set_rules('kd_sat_kecil', 'KD SAT KECIL', 'trim|required|xss_clean');
		$val->set_rules('kd_sat_besar', 'KD SAT BESAR', 'trim|required|xss_clean');
		$val->set_rules('kd_ter_obat', 'KD TERAPI OBAT', 'trim|required|xss_clean');
		$val->set_rules('generik', 'GENERIK', 'trim|required|xss_clean');
		$val->set_rules('fraction', 'FRACTION', 'trim|required|xss_clean');
		$val->set_rules('singkatan', 'SINGKATAN', 'trim|required|xss_clean');
		$val->set_rules('default', 'IS DEFAULT', 'trim|required|xss_clean');
		
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
				'KD_OBAT_VAL' => $val->set_value('kode_obat_val'),
				'NAMA_OBAT' => $val->set_value('nama_obat'),
				'KD_GOL_OBAT' => $val->set_value('kd_gol_obat'),
				'KD_JENIS_IMUNISASI' => ($val->set_value('jenis_imunisasi'))?$val->set_value('jenis_imunisasi'):0,
				'KD_SAT_KECIL' => $val->set_value('kd_sat_kecil'),
				'KD_SAT_BESAR' => $this->input->post('kd_sat_besar'),
				'KD_TERAPI_OBAT' => $val->set_value('kd_ter_obat'),
				'GENERIK' => $val->set_value('generik'),
				'FRACTION' => $this->input->post('fraction'),
				'SINGKATAN' => $val->set_value('singkatan'),
				'IS_DEFAULT' => $this->input->post('default'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);//echo '<pre>';print_r($dataexc);die();
		
			$db->insert('apt_mst_obat', $dataexc);
			
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
		$id = $this->input->post('kd_obat',TRUE);		
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('kode_obat_val', 'KODE OBAT', 'trim|required|xss_clean');
		$val->set_rules('nama_obat', 'NAMA OBAT', 'trim|required|xss_clean');
		$val->set_rules('kd_gol_obat', 'KD GOL OBAT', 'trim|required|xss_clean');
		if($this->input->post('kd_gol_obat')){
			if($this->input->post('kd_gol_obat')=='VAKSIN'){
				$val->set_rules('jenis_imunisasi', 'Jenis Imunisasi', 'trim|xss_clean');
			}else{
				$val->set_rules('kd_gol_obat', 'KD GOL OBAT', 'trim|xss_clean');
			}
		}
		$val->set_rules('kd_sat_kecil', 'KD SAT KECIL', 'trim|required|xss_clean');
		$val->set_rules('kd_sat_besar', 'KD SAT BESAR', 'trim|required|xss_clean');
		$val->set_rules('kd_ter_obat', 'KD TERAPI OBAT', 'trim|required|xss_clean');
		$val->set_rules('generik', 'GENERIK', 'trim|required|xss_clean');
		$val->set_rules('fraction', 'FRACTION', 'trim|required|xss_clean');
		$val->set_rules('singkatan', 'SINGKATAN', 'trim|required|xss_clean');
		$val->set_rules('default', 'IS DEFAULT', 'trim|required|xss_clean');
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
				'KD_OBAT_VAL' => $val->set_value('kode_obat_val'),
				'NAMA_OBAT' => $val->set_value('nama_obat'),
				'KD_GOL_OBAT' => $val->set_value('kd_gol_obat'),
				'KD_JENIS_IMUNISASI' => $this->input->post('jenis_imunisasi')!==''?$this->input->post('jenis_imunisasi'):0,
				'KD_SAT_KECIL' => $val->set_value('kd_sat_kecil'),
				'KD_SAT_BESAR' => $this->input->post('kd_sat_besar'),
				'KD_TERAPI_OBAT' => $val->set_value('kd_ter_obat'),
				'GENERIK' => $val->set_value('generik'),
				'FRACTION' => $this->input->post('fraction'),
				'SINGKATAN' => $val->set_value('singkatan'),
				'IS_DEFAULT' => $this->input->post('default'),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);///echo '<pre>';print_r($dataexc);die('zdfg');			
			
			$db->where('KD_OBAT',$id);
			$db->update('apt_mst_obat', $dataexc);
			
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
		$this->load->helper('ernes_helper');
		$id=$this->input->get('kd_obat')?$this->input->get('kd_obat',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("u.KD_OBAT,u.KD_OBAT_VAL,u.NAMA_OBAT,u.KD_GOL_OBAT,u.KD_JENIS_IMUNISASI,u.KD_SAT_KECIL,u.KD_SAT_BESAR,u.KD_TERAPI_OBAT,u.GENERIK,CAST(u.FRACTION AS Char) FRACTION,u.SINGKATAN,u.IS_DEFAULT, m.KD_GOL_OBAT as kodegolongan , n.KD_SAT_BESAR as kodesatbesar, o.KD_SAT_KCL_OBAT as kodesatkcl, p.KD_TERAPI_OBAT as kodeterapi");
		$db->from('apt_mst_obat u');
		$db->join('apt_mst_gol_obat m','u.KD_GOL_OBAT=m.KD_GOL_OBAT','left');
		$db->join('apt_mst_sat_besar n','u.KD_SAT_BESAR=n.KD_SAT_BESAR','left');
		$db->join('apt_mst_sat_kecil o','u.KD_SAT_KECIL=o.KD_SAT_KCL_OBAT','left');
		$db->join('apt_mst_terapi_obat p','u.KD_TERAPI_OBAT=p.KD_TERAPI_OBAT','left');
		$db->join('mst_jenis_imunisasi q','u.KD_JENIS_IMUNISASI=q.KD_JENIS_IMUNISASI','left');
		$db->where('u.KD_OBAT ',$id);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('masterObat/v_master_obat_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from apt_mst_obat where KD_OBAT = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$this->load->helper('ernes_helper');
		$id=$this->input->get('kd_obat')?$this->input->get('kd_obat',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("u.KD_OBAT,u.KD_OBAT_VAL,u.NAMA_OBAT,u.KD_GOL_OBAT,u.KD_JENIS_IMUNISASI,u.KD_SAT_KECIL,u.KD_SAT_BESAR,u.KD_TERAPI_OBAT,u.GENERIK,CAST(u.FRACTION AS Char) FRACTION,u.SINGKATAN,u.IS_DEFAULT, m.KD_GOL_OBAT as kodegolongan , m.GOL_OBAT as namagolongan, n.KD_SAT_BESAR as kodesatbesar, n.SAT_BESAR_OBAT as namasatbesar, o.KD_SAT_KCL_OBAT as kodesatkcl, o.SAT_KCL_OBAT as namasatkcl, p.KD_TERAPI_OBAT as kodeterapi, p.TERAPI_OBAT as namaterapi");
		$db->from('apt_mst_obat u');
		$db->join('apt_mst_gol_obat m','u.KD_GOL_OBAT=m.KD_GOL_OBAT','left');
		$db->join('apt_mst_sat_besar n','u.KD_SAT_BESAR=n.KD_SAT_BESAR','left');
		$db->join('apt_mst_sat_kecil o','u.KD_SAT_KECIL=o.KD_SAT_KCL_OBAT','left');
		$db->join('apt_mst_terapi_obat p','u.KD_TERAPI_OBAT=p.KD_TERAPI_OBAT','left');
		//$db->join('mst_jenis_imunisasi q','u.KD_JENIS_IMUNISASI=q.KD_JENIS_IMUNISASI','left');
		$db->where('u.KD_OBAT ',$id);
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('masterObat/v_master_obat_detail',$data);
	}
	
	public function imunisasi()
	{
		
		$this->load->helper('ernes_helper');
		$id=$this->input->get('kd_obat')?$this->input->get('kd_obat',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("u.KD_OBAT,u.KD_OBAT_VAL,u.NAMA_OBAT,u.KD_GOL_OBAT,u.KD_JENIS_IMUNISASI,u.KD_SAT_KECIL,u.KD_SAT_BESAR,u.KD_TERAPI_OBAT,u.GENERIK,CAST(u.FRACTION AS Char) FRACTION,u.SINGKATAN,u.IS_DEFAULT, m.KD_GOL_OBAT as kodegolongan , n.KD_SAT_BESAR as kodesatbesar, o.KD_SAT_KCL_OBAT as kodesatkcl, p.KD_TERAPI_OBAT as kodeterapi");
		$db->from('apt_mst_obat u');
		$db->join('apt_mst_gol_obat m','u.KD_GOL_OBAT=m.KD_GOL_OBAT','left');
		$db->join('apt_mst_sat_besar n','u.KD_SAT_BESAR=n.KD_SAT_BESAR','left');
		$db->join('apt_mst_sat_kecil o','u.KD_SAT_KECIL=o.KD_SAT_KCL_OBAT','left');
		$db->join('apt_mst_terapi_obat p','u.KD_TERAPI_OBAT=p.KD_TERAPI_OBAT','left');
		$db->join('mst_jenis_imunisasi q','u.KD_JENIS_IMUNISASI=q.KD_JENIS_IMUNISASI','left');
		$db->where('u.KD_OBAT ',$id);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('masterObat/v_master_obat_imunisasi',$data);
	}
	
}

/* End of file master1.php */
/* Location: ./application/controllers/master1.php */