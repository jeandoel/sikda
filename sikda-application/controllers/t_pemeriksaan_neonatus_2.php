<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_pemeriksaan_neonatus extends CI_Controller {
	public function index()
	{
		$this->load->view('t_pemeriksaanneonatus/v_t_pemeriksaan_neonatus');
	}
	
	public function pemeriksaanneonatuspopup()
	{
		$data['id_caller'] = $this->input->get('id_caller')?$this->input->get('id_caller',TRUE):null;
		$this->load->view('t_pelayanan/kunjungan/v_t_pemeriksaan_neonatus_popup',$data);
	}

		public function transaksi_pemeriksaanneonatusxml()
	{
		$this->load->model('t_pemeriksaan_neonatus_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari')
					);
					
		$total = $this->t_pemeriksaan_neonatus_model->totaltransaksi_pemeriksaanneonatus($paramstotal);
		
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
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari')
					);
					
		$result = $this->t_pemeriksaan_neonatus_model->getTransaksi_pemeriksaanneonatus($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}

	public function add()
	{
		$this->load->helper('jokos_helper');
		$this->load->view('t_pemeriksaanneonatus/v_t_pemeriksaan_neonatus_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');
		$val = $this->form_validation;
		$val->set_rules('kodepemeriksaanneonatus');
		$val->set_rules('tglkunjungan', 'Tanggal', 'trim|required|xss_clean');
		$val->set_rules('kunjunganke', 'Kunjungan ke', 'trim|required|xss_clean');
		$val->set_rules('beratbadan', 'Berat Badan', 'trim|required|xss_clean');
		$val->set_rules('panjangbadan', 'Panjang Badan', 'trim|required|xss_clean');
		//$val->set_rules('tindakananak', 'Tindakan Anak', 'trim|required|xss_clean');
		$val->set_rules('keluhan', 'Keluhan', 'trim|required|xss_clean');
		//$val->set_rules('tindakanibu', 'Tindakan Ibu', 'trim|required|xss_clean');
		$val->set_rules('pemeriksa', 'Pemeriksa', 'trim|required|xss_clean');
		$val->set_rules('petugas', 'Petugas', 'trim|required|xss_clean');
		$val->set_message('required', "Silahkan isi field \"%s\"");
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$arraytindakanibu = $this->input->post('produkibu_final')?json_decode($this->input->post('produkibu_final',TRUE)):NULL;//print_r($arraykeadaanbayi);die;
		$arraytindakananak = $this->input->post('produkanak_final')?json_decode($this->input->post('produkanak_final',TRUE)):NULL;
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
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
				'KD_KUNJUNGAN' => $this->input->post('kd_kunjungan')? $this->input->post('kd_kunjungan'.TRUE):'-',
				'KD_UNIT_PELAYANAN' => $this->input->post('kd_unit_pelayanan')? $this->input->post('kd_unit_pelayanan'.TRUE):'-',
				'KD_PELAYANAN' => $this->input->post('kd_pelayanan')? $this->input->post('kd_pelayanan'.TRUE):'-',
				'KD_KATEGORI_KIA' => $this->input->post('kd_kategori_kia')? $this->input->post('kd_kategori_kia'.TRUE):'-',
				'KD_KUNJUNGAN_KIA' => $this->input->post('kd_kunjungan_kia')? $this->input->post('kd_kunjungan_kia'.TRUE):'-',
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('trans_kia', $dataexc1);
	
			
			$kodekia=$db->insert_id(); 
			
			$dataexc = array(
				'KD_PEMERIKSAAN_NEONATUS' => $val->set_value('kodepemeriksaanneonatus'),
				'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
				'TANGGAL_KUNJUNGAN' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tglkunjungan')))),
				'KUNJUNGAN_KE' => $val->set_value('kunjunganke'),
				'BERAT_BADAN' => $val->set_value('beratbadan'),
				'PANJANG_BADAN' => $val->set_value('panjangbadan'),
				'KELUHAN' => $val->set_value('keluhan'),
				'KD_KIA' => $kodekia,
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			$db->insert('pemeriksaan_neonatus', $dataexc);
			
			$kd_pn=$db->insert_id();
			
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			if($arraytindakanibu){
				foreach($arraytindakanibu as $rowtindakanibuloop){
					$datatindakanibutmp = json_decode($rowtindakanibuloop);
					$datatindakanibuloop[] = array(
					'KD_PEMERIKSAAN_NEONATUS' => $kd_pn,
					'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
					'KD_TINDAKAN_IBU' => $datatindakanibutmp->kdprodukibu,
					'TINDAKAN_IBU' => $datatindakanibutmp->produkibu
					);
					$datatindakanibuinsert = $datatindakanibuloop;
				}
				$db->insert_batch('detail_tindakan_ibu_pem_neo',$datatindakanibuinsert);
			}
			
			
			if($arraytindakananak){
				foreach($arraytindakananak as $rowtindakananakloop){
					$datatindakananaktmp = json_decode($rowtindakananakloop);
					$datatindakananakloop[] = array(
					'KD_PEMERIKSAAN_NEONATUS' => $kd_pn,
					'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
					'KD_TINDAKAN_ANAK' => $datatindakananaktmp->kdprodukanak,
					'TINDAKAN_ANAK' => $datatindakananaktmp->produkanak,
					'KET_TINDAKAN_ANAK' => $datatindakananaktmp->keterangan
					);
					$datatindakananakinsert = $datatindakananakloop;
				}
				$db->insert_batch('detail_tindakan_anak_pem_neo',$datatindakananakinsert);
			}
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
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
		$val->set_rules('id', 'Kode Kia Hidden', 'trim|required|xss_clean');
		$val->set_rules('tglkunjungan', 'Tanggal', 'trim|required|xss_clean');
		$val->set_rules('kunjunganke', 'Kunjungan ke', 'trim|required|xss_clean');
		$val->set_rules('beratbadan', 'Berat Badan', 'trim|required|xss_clean');
		$val->set_rules('panjangbadan', 'Panjang Badan', 'trim|required|xss_clean');
		$val->set_rules('keluhan', 'Keluhan', 'trim|required|xss_clean');
		$val->set_rules('pemeriksa', 'Pemeriksa', 'trim|required|xss_clean');
		$val->set_rules('petugas', 'Petugas', 'trim|required|xss_clean');
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
			$kdkia=$val->set_rules('id', 'Kode Kia Hidden', 'trim|required|xss_clean');
			$dataexc1 = array( 	
				'KD_DOKTER_PEMERIKSA' => $val->set_value('pemeriksa'),
				'KD_DOKTER_PETUGAS' => $val->set_value('petugas'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);//print_r($dataexc1);die; 
			
			$db->where('KD_KIA',$id);
			$db->update('trans_kia', $dataexc1);
			
			$kodekia=$db->insert_id(); 
			$dataexc = array(
				'TANGGAL_KUNJUNGAN' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tglkunjungan')))),
				'KUNJUNGAN_KE' => $val->set_value('kunjunganke'),
				'BERAT_BADAN' => $val->set_value('beratbadan'),
				'PANJANG_BADAN' => $val->set_value('panjangbadan'),
				'KELUHAN' => $val->set_value('keluhan'),
				'KD_KIA' => $kodekia,
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);//print_r($dataexc);die;
			
			$db->where('KD_PEMERIKSAAN_NEONATUS',$id);
			$db->update('pemeriksaan_neonatus', $dataexc);
			
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
		$this->load->helper('jokos_helper');
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("u.KD_PEMERIKSAAN_NEONATUS as id, u.KD_PEMERIKSAAN_NEONATUS, DATE_FORMAT(u.TANGGAL_KUNJUNGAN,'%d-%m-%Y') as TANGGAL_KUNJUNGAN, u.KUNJUNGAN_KE, u.BERAT_BADAN, u.PANJANG_BADAN, GROUP_CONCAT(DISTINCT a.TINDAKAN_ANAK SEPARATOR ' | '), GROUP_CONCAT(DISTINCT a.KET_TINDAKAN_ANAK SEPARATOR ' , '), GROUP_CONCAT(DISTINCT i.TINDAKAN_IBU SEPARATOR ' | '), u.KELUHAN, concat (d.NAMA,'::',d.JABATAN) as dokter_pemeriksa, concat(e.NAMA, '::',e.JABATAN) as dokter_petugas, u.KD_PEMERIKSAAN_NEONATUS as kode", false );
		$db->from('pemeriksaan_neonatus u');
		$db->join('trans_kia k', 'u.KD_KIA=k.KD_KIA');
		$db->join('mst_dokter d', 'd.KD_DOKTER=k.KD_DOKTER_PEMERIKSA');
		$db->join('mst_dokter e', 'e.KD_DOKTER=k.KD_DOKTER_PETUGAS');
		$db->join('detail_tindakan_anak_pem_neo a', 'a.KD_PEMERIKSAAN_NEONATUS=u.KD_PEMERIKSAAN_NEONATUS');
		$db->join('detail_tindakan_ibu_pem_neo i', 'i.KD_PEMERIKSAAN_NEONATUS=u.KD_PEMERIKSAAN_NEONATUS');
		$db->where('u.KD_PEMERIKSAAN_NEONATUS', $id);
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('t_pemeriksaanneonatus/v_t_pemeriksaan_neonatus_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('kodepemeriksaanneonatus')?$this->input->post('kodepemeriksaanneonatus',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from pemeriksaan_neonatus where KD_PEMERIKSAAN_NEONATUS = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function deletetindakananak()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from detail_tindakan_anak_pem_neo where KD_TINDAKAN_ANAK = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function deletetindakanibu()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from detail_tindakan_ibu_pem_neo where KD_TINDAKAN_IBU= '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
		
	public function detail()
	{
		$this->load->helper('jokos_helper');
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("u.KD_PEMERIKSAAN_NEONATUS as id, u.KD_PEMERIKSAAN_NEONATUS, DATE_FORMAT(u.TANGGAL_KUNJUNGAN,'%d-%m-%Y') as TANGGAL_KUNJUNGAN, u.KUNJUNGAN_KE, u.BERAT_BADAN, u.PANJANG_BADAN, GROUP_CONCAT(DISTINCT a.TINDAKAN_ANAK SEPARATOR ' | ') AS TINDAKAN_ANAK, GROUP_CONCAT(DISTINCT a.KET_TINDAKAN_ANAK SEPARATOR ' , ') AS KET_TINDAKAN_ANAK, u.KELUHAN, GROUP_CONCAT(DISTINCT i.TINDAKAN_IBU SEPARATOR ' | ') AS TINDAKAN_IBU, concat (d.NAMA,'::',d.JABATAN) as dokter_pemeriksa, concat(e.NAMA, '::',e.JABATAN) as dokter_petugas, u.KD_PEMERIKSAAN_NEONATUS as kode", false );
		$db->from('pemeriksaan_neonatus u');
		$db->join('trans_kia k', 'u.KD_KIA=k.KD_KIA');
		$db->join('mst_dokter d', 'd.KD_DOKTER=k.KD_DOKTER_PEMERIKSA');
		$db->join('mst_dokter e', 'e.KD_DOKTER=k.KD_DOKTER_PETUGAS');
		$db->join('detail_tindakan_anak_pem_neo a', 'a.KD_PEMERIKSAAN_NEONATUS=u.KD_PEMERIKSAAN_NEONATUS');
		$db->join('detail_tindakan_ibu_pem_neo i', 'i.KD_PEMERIKSAAN_NEONATUS=u.KD_PEMERIKSAAN_NEONATUS');
		$db->group_by ('u.KD_PEMERIKSAAN_NEONATUS','a.KD_TINDAKAN_ANAK','i.KD_TINDAKAN_IBU');
		$db->where('u.KD_PEMERIKSAAN_NEONATUS', $id);
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('t_pemeriksaanneonatus/v_t_pemeriksaan_neonatus_detail',$data);
	}
	
	public function produkibusource()
	{
		$id=$this->input->get('term')?$this->input->get('term',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$comboprodukibu = $db->query("SELECT KD_PRODUK AS id,PRODUK AS label, '' as category
								FROM mst_produk
								 where PRODUK like '%".$id."%' ")->result_array();
		die(json_encode($comboprodukibu));
	}
	
	public function produkanaksource()
	{
		$id=$this->input->get('term')?$this->input->get('term',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$comboprodukanak = $db->query("SELECT KD_PRODUK AS id,PRODUK AS label, '' as category
								FROM mst_produk
								 where PRODUK like '%".$id."%' ")->result_array();
		die(json_encode($comboprodukanak));
	}
	
	public function transaksi_tindakananakxml()
	{
		$this->load->model('t_pemeriksaan_neonatus_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid')
					);
					
		$total = $this->t_pemeriksaan_neonatus_model->totalTransaksi_tindakananak($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid')
					);
					
		$result = $this->t_pemeriksaan_neonatus_model->getTransaksi_tindakananak($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}

	public function transaksi_tindakanibuxml()
	{
		$this->load->model('t_pemeriksaan_neonatus_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid')
					);
					
		$total = $this->t_pemeriksaan_neonatus_model->totalTransaksi_tindakanibu($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid')
					);
					
		$result = $this->t_pemeriksaan_neonatus_model->getTransaksi_tindakanibu($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
}
