<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_kunjungan_nifas extends CI_Controller {
	public function index()
	{
		$this->load->view('transaksiKunjungan_nifas/v_transaksi_kunjungan_nifas');
	}
	
	public function masterkunjungannifaspopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('t_pelayanan/kunjungan/v_transaksi_kunjungan_nifas_popup',$data);
	}
	
	public function kunjungannifasxml()
	{
		$this->load->model('m_tkunjungan_nifas');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'kode'=>$this->input->post('kode')
					);
					
		$total = $this->m_tkunjungan_nifas->totalT_kunjungannifas($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'kode'=>$this->input->post('kode')
					);
					
		$result = $this->m_tkunjungan_nifas->getT_kunjungannifas($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->helper('ernes_helper');
		$this->load->view('transaksiKunjungan_nifas/v_transaksi_kunjungan_nifas_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('tanggal_daftart_pendaftaranadd', 'Tanggal', 'trim|myvalid_date');
		$val->set_rules('keluhan', 'Keluhan', 'trim|xss_clean');
		$val->set_rules('tekanan_darah', 'Tekanan Darah', 'trim|xss_clean');
		$val->set_rules('nadi', 'Nadi/menit', 'trim|xss_clean');
		$val->set_rules('nafas', 'Nafas/menit', 'trim|xss_clean');
		$val->set_rules('suhu', 'Suhu', 'trim|xss_clean');
		$val->set_rules('kontraksi', 'Kontraksi Rahim', 'trim|xss_clean');
		$val->set_rules('perdarahan', 'Perdarahan', 'trim|xss_clean');
		$val->set_rules('warna_lokhia', 'Warna Lokhia', 'trim|xss_clean');
		$val->set_rules('jumlah_lokhia', 'Jumlah Lokhia', 'trim|xss_clean');
		$val->set_rules('bau_lokhia', 'Bau Lokhia', 'trim|xss_clean');
		$val->set_rules('bab', 'Buang Air Besar', 'trim|xss_clean');
		$val->set_rules('bak', 'Buang Air Kecil', 'trim|xss_clean');
		$val->set_rules('produksi_asi', 'Produksi Asi', 'trim|xss_clean');
		$val->set_rules('kd_tindakan', 'Tindakan', 'trim|xss_clean');
		$val->set_rules('nasehat', 'Nasehat', 'trim|xss_clean');
		$val->set_rules('pemeriksa', 'Pemeriksa', 'trim|xss_clean');
		$val->set_rules('petugas', 'Petugas', 'trim|xss_clean');
		$val->set_rules('stat_hamil', 'Status Hamil', 'trim|xss_clean');
		if($this->input->post('stat_hamil')){
			if($this->input->post('stat_hamil')=='akhir_nifas'){
				$val->set_rules('stat_hamil', 'Status Hamil', 'trim|xss_clean');
				$val->set_rules('kead_ibu', 'Keadaan Ibu', 'trim|xss_clean');
				$val->set_rules('kead_bayi', 'Keadaan Bayi', 'trim|xss_clean');
				$val->set_rules('komp_nifas', 'Komplikasi Nifas', 'trim|xss_clean');
			}else{
				$val->set_rules('stat_hamil', 'Status Hamil', 'trim|xss_clean');
			}
		}
			$val->set_message('required', "Silahkan isi field \"%s\"");
			
		
		$arraytindakan = $this->input->post('tindakan_final')?json_decode($this->input->post('tindakan_final',TRUE)):NULL;//print_r($arraytindakan);die;
		
		//$val->set_message('required', "Silahkan isi field \"%s\"");

		if ($val->run() == FALSE)
		{
			$val->set_error_delimiters('<div style="color:white">', '</div>');
			die(validation_errors());
			}
			else
		{						
			$db = $this->load->database('sikda', TRUE);
			$db->trans_begin();
			
			$dataexc1 = array( 	
				'KD_DOKTER_PEMERIKSA' => $val->set_value('pemeriksa'),
				'KD_DOKTER_PETUGAS' => $val->set_value('petugas'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('trans_kia', $dataexc1);

			
			$kodekia=$db->insert_id(); 	
			$dataexc = array(
				
				'KD_KIA' => $kodekia,
				'TANGGAL_KUNJUNGAN' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tanggal_daftart_pendaftaranadd',TRUE)))),
				'KELUHAN' => $val->set_value('keluhan'),
				'TEKANAN_DARAH' => $val->set_value('tekanan_darah'),
				'NADI' => $val->set_value('nadi'),
				'NAFAS' => $val->set_value('nafas'),
				'SUHU' => $val->set_value('suhu'),
				'KONTRAKSI_RAHIM' => $val->set_value('kontraksi'),
				'PERDARAHAN' => $val->set_value('perdarahan'),
				'WARNA_LOKHIA' => $val->set_value('warna_lokhia'),
				'JML_LOKHIA' => $val->set_value('jumlah_lokhia'),
				'BAU_LOKHIA' => $val->set_value('bau_lokhia'),
				'BUANG_AIR_BESAR' => $val->set_value('bab'),
				'BUANG_AIR_KECIL' => $val->set_value('bak'),
				'PRODUKSI_ASI' => $val->set_value('produksi_asi'),
				'NASEHAT' => $val->set_value('nasehat'),
				'KD_STATUS_HAMIL' => $val->set_value('stat_hamil'),
				'KD_KESEHATAN_IBU' => $val->set_value('kead_ibu'),
				'KD_KESEHATAN_BAYI' => $val->set_value('kead_bayi'),
				'KD_KOMPLIKASI_NIFAS' => $val->set_value('komp_nifas'),
				'ninput_tgl' => date('Y-m-d H:i:s'),
				'ninput_oleh' => $this->session->userdata('nusername')
			);///echo '<pre>';print_r($dataexc);die('zdfg');	
			
			$db->insert('kunjungan_nifas', $dataexc);
			$kodenifas=$db->insert_id();
			
			if($arraytindakan){
				foreach($arraytindakan as $rowtindakanloop){
					$datatindakantmp = json_decode($rowtindakanloop);
					$datatindakanloop[] = array(
						'KD_TINDAKAN' => $datatindakantmp->kd_tindakan,
						'TINDAKAN' => $datatindakantmp->tindakan,
						'KETERANGAN' => $datatindakantmp->keterangan,
						'KD_KUNJUNGAN_NIFAS' => $kodenifas,
						'ninput_tgl' => date('Y-m-d H:i:s'),
						'ninput_oleh' => $this->session->userdata('nusername')
						);//echo '<pre>';print_r($datatindakanloop);die('zdfg');
					$datatindakaninsert = $datatindakanloop;
					
				}
				$db->insert_batch('tindakan_nifas',$datatindakaninsert);
			}
			/*if($this->input->post('showhide_kesimpulan_nifas')){
				$dataexckesimpulan = array(
					'KD_KESEHATAN_IBU'=> $this->session->userdata('kead_ibu').sprintf("%07d", $max),
					'KD_KESEHATAN_BAYI' => $this->session->userdata('kead_bayi'),
					'KD_KOMPLIKASI_NIFAS' => $this->session->userdata('komp_nifas'),
										
				);			
				$this->kesimpulanakhirnifasprocessfunction($db,$dataexckesimpulan);
			}*/
			
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
		$id = $this->input->post('id',TRUE);		
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('tanggal_daftart_pendaftaranadd', 'Tanggal', 'trim|myvalid_date');
		$val->set_rules('keluhan', 'Keluhan', 'trim|xss_clean');
		$val->set_rules('tekanan_darah', 'Tekanan Darah', 'trim|xss_clean');
		$val->set_rules('nadi', 'Nadi/menit', 'trim|xss_clean');
		$val->set_rules('nafas', 'Nafas/menit', 'trim|xss_clean');
		$val->set_rules('suhu', 'Suhu', 'trim|xss_clean');
		$val->set_rules('kontraksi', 'Kontraksi Rahim', 'trim|xss_clean');
		$val->set_rules('perdarahan', 'Perdarahan', 'trim|xss_clean');
		$val->set_rules('warna_lokhia', 'Warna Lokhia', 'trim|xss_clean');
		$val->set_rules('jumlah_lokhia', 'Jumlah Lokhia', 'trim|xss_clean');
		$val->set_rules('bau_lokhia', 'Bau Lokhia', 'trim|xss_clean');
		$val->set_rules('bab', 'Buang Air Besar', 'trim|xss_clean');
		$val->set_rules('bak', 'Buang Air Kecil', 'trim|xss_clean');
		$val->set_rules('produksi_asi', 'Produksi Asi', 'trim|xss_clean');
		$val->set_rules('tindakan', 'Tindakan', 'trim|xss_clean');
		$val->set_rules('nasehat', 'Nasehat', 'trim|xss_clean');
		$val->set_rules('kd_pet', 'Nama Pemeriksa', 'trim|xss_clean');
		$val->set_rules('jabatan', 'Jabatan', 'trim|xss_clean');
		$val->set_rules('stat_hamil', 'Status Hamil', 'trim|xss_clean');
		$val->set_rules('kead_ibu', 'Keadaan Ibu', 'trim|xss_clean');
		$val->set_rules('kead_bayi', 'Keadaan Bayi', 'trim|xss_clean');
		$val->set_rules('komp_nifas', 'Komplikasi Nifas', 'trim|xss_clean');
		$val->set_rules('pemeriksa', 'Pemeriksa', 'trim|xss_clean');
		$val->set_rules('petugas', 'Petugas', 'trim|xss_clean');

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
				'KD_KUNJUNGAN_NIFAS' => $val->set_value('kdkunjnifas'),
				'TANGGAL_KUNJUNGAN' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tanggal_daftart_pendaftaranadd',TRUE)))),
				'KELUHAN' => $val->set_value('keluhan'),
				'TEKANAN_DARAH' => $val->set_value('tekanan_darah'),
				'NADI' => $val->set_value('nadi'),
				'NAFAS' => $val->set_value('nafas'),
				'SUHU' => $val->set_value('suhu'),
				'KONTRAKSI_RAHIM' => $val->set_value('kontraksi'),
				'PERSARAHAN' => $val->set_value('perdarahan'),
				'WARNA_LOKHIA' => $val->set_value('warna_lokhia'),
				'JML_LOKHIA' => $val->set_value('jumlah_lokhia'),
				'BAU_LOKHIA' => $val->set_value('bau_lokhia'),
				'BUANG_AIR_BESAR' => $val->set_value('bab'),
				'BUANG_AIR_KECIL' => $val->set_value('bak'),
				'PRODUKSI_ASI' => $val->set_value('produksi_asi'),
				'KD_TINDAKAN' => $val->set_value('kd_tndkn'),
				'KET_TINDAKAN' => $val->set_value('tindakan'),
				'NASEHAT' => $val->set_value('nasehat'),
				'KD_PETUGAS' => $val->set_value('kd_pet'),
				'KD_DOKTER' => $val->set_value('jabatan'),
				'KD_STATUS_HAMIL' => $val->set_value('stat_hamil'),
				'KD_KESEHATAN_IBU' => $val->set_value('kead_ibu'),
				'KD_KESEHATAN_BAYI' => $val->set_value('kead_bayi'),
				'KD_KOMPLIKASI_NIFAS' => $val->set_value('komp_nifas'),
				'nupdate_tgl' => date("Y-m-d", strtotime($this->input->post('tgltransaksiobatkeluar',TRUE))),
				'nupdate_oleh' => $this->session->userdata('nusername')
			);//echo '<pre>';print_r($dataexc);die('zdfg');		
			
			$db->where('KD_KUNJUNGAN_NIFAS',$id);
			$db->update('kunjungan_nifas', $dataexc);
			
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
		$$db = $this->load->database('sikda', TRUE);
		$val = $db->query("select * from kunjungan_nifas where KD_KUNJUNGAN_NIFAS = '".$id."'")->row();
		$data['data']=$val;		
		$this->load->view('transaksiKunjungan_nifas/v_transaksi_kunjungan_nifas_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from kunjungan_nifas where KD_KUNJUNGAN_NIFAS = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("u.KD_KUNJUNGAN_NIFAS as kode,DATE_FORMAT (u.TANGGAL_KUNJUNGAN, '%d-%M-%Y') as TANGGAL_KUNJUNGAN,u.KELUHAN,u.TEKANAN_DARAH, u.NADI, u.NAFAS, u.SUHU, u.KONTRAKSI_RAHIM, u.PERDARAHAN, u.WARNA_LOKHIA,u.JML_LOKHIA,u.BAU_LOKHIA,u.BUANG_AIR_BESAR, u.BUANG_AIR_KECIL, u.PRODUKSI_ASI, GROUP_CONCAT(DISTINCT t.TINDAKAN SEPARATOR ' | ') AS TINDAKAN, u.NASEHAT,concat (h.NAMA,'-',h.JABATAN) as pemeriksa,concat (i.NAMA,'-',i.JABATAN) as petugas, u.KD_STATUS_HAMIL,u.KD_KESEHATAN_IBU,u.KD_KESEHATAN_BAYI,u.KD_KOMPLIKASI_NIFAS ,u.KD_KUNJUNGAN_NIFAS as nid", false);
		$db->from('kunjungan_nifas u');
		$db->join('tindakan_nifas t', 'u.KD_KUNJUNGAN_NIFAS=t.KD_KUNJUNGAN_NIFAS');
		$db->join('trans_kia k', 'u.KD_KIA=k.KD_KIA');
		$db->join('mst_keadaan_kesehatan q','u.KD_KESEHATAN_BAYI=q.KD_KEADAAN_KESEHATAN','left');
		$db->join('mst_dokter h', 'k.KD_DOKTER_PEMERIKSA=h.KD_DOKTER');
		$db->join('mst_dokter i', 'k.KD_DOKTER_PETUGAS=i.KD_DOKTER');
		$db->group_by('u.KD_KUNJUNGAN_NIFAS');
		$db->where('u.KD_KUNJUNGAN_NIFAS ',$id);//print_r($db);die();
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('transaksiKunjungan_nifas/v_transaksi_kunjungan_detail',$data);
	}
	public function produksource()
	{
		$id=$this->input->get('term')?$this->input->get('term',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$comboproduk = $db->query("SELECT p.KD_PRODUK AS id,p.PRODUK AS label, 
							CASE WHEN g.KD_TINDAKAN IS NULL THEN '' ELSE g.KD_TINDAKAN END AS category
							FROM mst_produk p LEFT JOIN tindakan_nifas g on p.KD_GOL_PRODUK=g.KD_TINDAKAN where p.PRODUK like '%".$id."%' ")->result_array();
		die(json_encode($comboproduk));
	}
	
	public function kesimpulanakhirnifas()
	{
		$this->load->helper('beries_helper');
		$this->load->helper('ernes_helper');
		$this->load->view('transaksiKunjungan_nifas/v_kesimpulan_akhir_nifas');
	}
	
}

/* End of file transaksi1.php */
/* Location: ./application/controllers/transaksi1.php */