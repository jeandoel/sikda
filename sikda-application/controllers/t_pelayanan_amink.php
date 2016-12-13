<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_pelayanan extends CI_Controller {
	public function index()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_pelayanan/v_pelayanan');
	}
	
	public function t_pelayananxml()
	{		
		$this->load->model('t_pelayanan_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai')
					);
					
		$total = $this->t_pelayanan_model->totalT_pelayanan($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai')
					);
					
		$result = $this->t_pelayanan_model->getT_pelayanan($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function t_pelayananantrianxml()
	{		
		$this->load->model('t_pelayanan_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),					
					'unit'=>$this->input->post('unit'),					
					'status'=>$this->input->post('status'),
					'jenis'=>$this->input->post('jenis')
					);
					
		$total = $this->t_pelayanan_model->totalT_pelayanan($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'dari'=>$this->input->post('dari'),					
					'unit'=>$this->input->post('unit'),					
					'status'=>$this->input->post('status'),
					'jenis'=>$this->input->post('jenis')
					);
					
		$result = $this->t_pelayanan_model->getT_pelayanan($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_pelayanan/v_t_pelayanan_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required|myvalid_date');
		$val->set_rules('column1', 'Column Satu', 'trim|required|xss_clean');
		$val->set_rules('column2', 'Column Dua', 'trim|required|xss_clean');
		$val->set_rules('column3', 'Column Tiga', 'trim|required|xss_clean');
		$val->set_rules('column_master_1_id', 'Column Master 1', 'trim|required|xss_clean');
		
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
				'ncolumn1' => $val->set_value('column1'),
				'ncolumn2' => $val->set_value('column2'),
				'ncolumn3' => $val->set_value('column3'),
				'nmaster_1_id' => $val->set_value('column_master_1_id'),
				'ntgl_t_pelayanan' => date("Y-m-d", strtotime($this->input->post('tglt_pelayanan',TRUE))),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('tbl_t_pelayanan', $dataexc);
			
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
	public function detailkunjunganpasien()
	{
		$this->load->helper('ernes_helper');
		$this->load->helper('beries_helper');
		$this->load->helper('my_helper');
		$this->load->helper('master_helper');
		$this->load->helper('sigit_helper');
		$this->load->helper('jokos_helper');
		$this->load->helper('pemkes_helper');
		$id=$this->input->get('kd_kunjungan')?$this->input->get('kd_kunjungan',TRUE):null; 
		$db = $this->load->database('sikda', TRUE);
		$unit = $db->query("select * from trans_kia where KD_KUNJUNGAN='".$id."'")->row();//print_r($unit);die;
		$id2 = $unit->KD_KIA; //print_r($id2);die;
		
		
		// View Detail Kunjungan Ibu Hamil
			if($unit->KD_KATEGORI_KIA==1 AND $unit->KD_KUNJUNGAN_KIA==1){
				$db->select("a.KD_KUNJUNGAN_BUMIL as kode,a.KD_KUNJUNGAN_BUMIL, a.KD_KIA, DATE_FORMAT(a.TANGGAL_KUNJUNGAN,'%d-%m-%Y') AS TANGGAL_KUNJUNGAN, a.KUNJUNGAN_KE, a.KELUHAN, a.TEKANAN_DARAH, a.BERAT_BADAN, a.UMUR_KEHAMILAN, a.TINGGI_FUNDUS, l.LETAK_JANIN, a.DENYUT_JANTUNG, a.KAKI_BENGKAK, a.LAB_DARAH_HB, a.LAB_URIN_REDUKSI, a.LAB_URIN_PROTEIN,  a.PEMERIKSAAN_KHUSUS, j.JENIS_KASUS,h.STATUS_HAMIL, a.NASEHAT, GROUP_CONCAT(DISTINCT t.PRODUK SEPARATOR ' | ') AS TINDAKAN, GROUP_CONCAT(DISTINCT m.NAMA_OBAT SEPARATOR ' | ') AS ALERGI,GROUP_CONCAT(DISTINCT s.NAMA_OBAT SEPARATOR ' | ') AS OBAT, concat(d.NAMA,'--',d.JABATAN) as DOKTER, e.NAMA as PETUGAS, a.KD_KUNJUNGAN_BUMIL as id",false);
				$db->from('kunjungan_bumil a');
				$db->join('trans_kia k','a.KD_KIA=k.KD_KIA','left');
				$db->join('mst_letak_janin l','l.KD_LETAK_JANIN=a.KD_LETAK_JANIN','left');
				$db->join('bumil_produk t','t.KD_PRODUK=a.KD_TINDAKAN','left');
				$db->join('mst_kasus_jenis j','j.KD_JENIS_KASUS=a.KD_JENIS_KASUS','left');
				//$db->join('mst_rs r','r.KD_RS= a.KD_RS','left');
				$db->join('mst_status_hamil h','h.KD_STATUS_HAMIL=a.KD_STATUS_HAMIL','left');
				$db->join('mst_dokter d','k.KD_DOKTER_PEMERIKSA=d.KD_DOKTER','left');
				$db->join('mst_dokter e','k.KD_DOKTER_PETUGAS=e.KD_DOKTER','left');
				$db->join('pel_ord_obat p','k.KD_PELAYANAN=p.KD_PELAYANAN','left');
				$db->join('apt_mst_obat m','m.KD_OBAT=p.KD_OBAT','left');
				$db->join('apt_mst_obat s','s.KD_OBAT=p.KD_OBAT','left');
				$db->group_by('a.KD_KUNJUNGAN_BUMIL','t.KD_PRODUK','m.KD_OBAT','s.KD_OBAT');
				$db->where('a.KD_KIA',$id2);//print_r($id2);die;
				$val = $db->get()->row();
				$data['data']=$val;//print_r($data);die;
				$this->load->view('t_pelayanan/kunjungan_detail/v_t_kunjungan_ibu_hamil_detail',$data);
			
			// View Detail Kunjungan Bersalin //
			}elseif($unit->KD_KATEGORI_KIA==1 AND $unit->KD_KUNJUNGAN_KIA==2){
				$this->load->view('t_pelayanan/kunjungan/v_t_pelayanan_bersalin',$data);
				
			// View Detail Kunjungan Nifas //
			}elseif($unit->KD_KATEGORI_KIA==1 AND $unit->KD_KUNJUNGAN_KIA==3){
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
				$this->load->view('t_pelayanan/kunjungan_detail/v_transaksi_kunjungan_detail',$data);
			
			// View Detail Kunjungan KB //
			}elseif($unit->KD_KATEGORI_KIA==1 AND $unit->KD_KUNJUNGAN_KIA==4){
				$db->select("u.KD_KUNJUNGAN_KB as kode,DATE_FORMAT(u.TANGGAL, '%d-%M-%Y') as TANGGAL,u.KD_KUNJUNGAN_KB,m.JENIS_KB,concat (h.NAMA,'-',h.JABATAN) as pemeriksa,concat (i.NAMA,'-',i.JABATAN) as petugas,u.KELUHAN,u.ANAMNESE,group_concat(distinct s.PRODUK separator ' | ') as PRODUK,u.KD_KUNJUNGAN_KB as id", false );
				$db->from('kunjungan_kb u');
				$db->join('mst_jenis_kb m','m.KD_JENIS_KB=u.KD_JENIS_KB');
				$db->join('detail_tindakan_kb s','s.KD_KUNJUNGAN_KB=u.KD_KUNJUNGAN_KB');
				$db->join('trans_kia g','g.KD_KIA=u.KD_KIA');
				$db->join('mst_dokter h','g.KD_DOKTER_PEMERIKSA=h.KD_DOKTER');
				$db->join('mst_dokter i','g.KD_DOKTER_PETUGAS=i.KD_DOKTER');
				$db->group_by('u.KD_KUNJUNGAN_KB');
				$db->where('u.KD_KUNJUNGAN_KB ',$id);
				$val = $db->get()->row();
				$data['data']=$val;
				$this->load->view('t_pelayanan/kunjungan_detail/v_pelayanan_kb_detail',$data);
			
			// View Detail Kunjungan Neonatus //
			}elseif($unit->KD_KATEGORI_KIA==2 AND $unit->KD_KUNJUNGAN_KIA==1){ //print_r($unit);die;
				$db->select("k.KD_KIA, u.KD_PEMERIKSAAN_NEONATUS as id, u.KD_PEMERIKSAAN_NEONATUS, DATE_FORMAT(u.TANGGAL_KUNJUNGAN,'%d-%m-%Y') as TANGGAL_KUNJUNGAN, u.KUNJUNGAN_KE, u.BERAT_BADAN, u.PANJANG_BADAN, GROUP_CONCAT(DISTINCT a.TINDAKAN_ANAK SEPARATOR ' | ') AS TINDAKAN_ANAK, GROUP_CONCAT(DISTINCT a.KET_TINDAKAN_ANAK SEPARATOR ' , ') AS KET_TINDAKAN_ANAK, u.KELUHAN, GROUP_CONCAT(DISTINCT m.NAMA_OBAT SEPARATOR ', ') AS ALERGI, GROUP_CONCAT(DISTINCT n.NAMA_OBAT SEPARATOR ', ') AS OBAT, GROUP_CONCAT(DISTINCT i.TINDAKAN_IBU SEPARATOR ' | ') AS TINDAKAN_IBU, concat (d.NAMA,'::',d.JABATAN) as dokter_pemeriksa, concat(e.NAMA, '::',e.JABATAN) as dokter_petugas, u.KD_PEMERIKSAAN_NEONATUS as kode", false );
				$db->from('trans_kia k');
				$db->join('pemeriksaan_neonatus u', 'u.KD_KIA=k.KD_KIA','left');
				$db->join('pel_ord_obat p', 'k.KD_PELAYANAN=p.KD_PELAYANAN','left');
				$db->join('apt_mst_obat m', 'p.KD_OBAT=m.KD_OBAT','left');
				$db->join('apt_mst_obat n', 'p.KD_OBAT=n.KD_OBAT','left');
				$db->join('mst_dokter d', 'd.KD_DOKTER=k.KD_DOKTER_PEMERIKSA','left');
				$db->join('mst_dokter e', 'e.KD_DOKTER=k.KD_DOKTER_PETUGAS','left');
				$db->join('detail_tindakan_anak_pem_neo a', 'a.KD_PEMERIKSAAN_NEONATUS=u.KD_PEMERIKSAAN_NEONATUS','left');
				$db->join('detail_tindakan_ibu_pem_neo i', 'i.KD_PEMERIKSAAN_NEONATUS=u.KD_PEMERIKSAAN_NEONATUS','left');
				$db->group_by ('u.KD_PEMERIKSAAN_NEONATUS','a.KD_TINDAKAN_ANAK','i.KD_TINDAKAN_IBU');
				$db->where('k.KD_KUNJUNGAN',$id);//print_r($id);die;
				$val = $db->get()->row();//print_r($db->last_query());die;
				$data['data']=$val; //print_r($data);die;
				$this->load->view('t_pelayanan/kunjungan_detail/v_t_pemeriksaan_neonatus_detail',$data);
			
			// View Detail Kunjungan Kesehatan Anak //
			}elseif($unit->KD_KATEGORI_KIA==2 AND $unit->KD_KUNJUNGAN_KIA==2){
				$db->select("a.KD_PEMERIKSAAN_ANAK as kode,a.KD_PUSKESMAS,a.KD_PEMERIKSAAN_ANAK,DATE_FORMAT(a.TANGGAL_KUNJUNGAN,'%d-%m-%Y') as TANGGAL_KUNJUNGAN,group_concat(distinct c.PENYAKIT separator ' | ') as PENYAKIT,group_concat(distinct o.PRODUK separator ' , ') as PRODUK,GROUP_CONCAT(DISTINCT m.NAMA_OBAT SEPARATOR ' | ') AS ALERGI,GROUP_CONCAT(DISTINCT s.NAMA_OBAT SEPARATOR ' | ') AS OBAT, concat(d.NAMA,'--',d.JABATAN) as dokter, e.NAMA as KD_DOKTER_PETUGAS, a.KD_PEMERIKSAAN_ANAK as id",false);
				$db->from('pemeriksaan_anak a');
				$db->join('pem_kes_icd c','a.KD_PEMERIKSAAN_ANAK=c.KD_PEMERIKSAAN_ANAK','left');
				$db->join('pem_kes_produk o','a.KD_PEMERIKSAAN_ANAK=o.KD_PEMERIKSAAN_ANAK','left');
				$db->join('trans_kia k','a.KD_KIA=k.KD_KIA','left');
				$db->join('mst_dokter d','k.KD_DOKTER_PEMERIKSA=d.KD_DOKTER','left');
				$db->join('mst_dokter e','k.KD_DOKTER_PETUGAS=e.KD_DOKTER','left');
				$db->join('pel_ord_obat p','k.KD_PELAYANAN=p.KD_PELAYANAN','left');
				$db->join('apt_mst_obat m','m.KD_OBAT=p.KD_OBAT','left');
				$db->join('apt_mst_obat s','s.KD_OBAT=p.KD_OBAT','left');
				$db->group_by('a.KD_PEMERIKSAAN_ANAK','c.KD_PENYAKIT','o.KD_PRODUK','m.KD_OBAT','s.KD_OBAT');
				$db->where('a.KD_KIA', $id2); //print_r($id2);die;
				$val = $db->get()->row();//print_r($db->last_query());die;
				$data['data']=$val; //print_r($data);die;
				$this->load->view('t_pelayanan/kunjungan_detail/v_t_pemeriksaan_kesehatan_anak_detail',$data);
			}
		else{
			$val = $db->query("select * from kunjungan where KD_KUNJUNGAN='".$id."'")->row();//print_r($val);die;
			if($val->KD_LAYANAN_B=='RJ'){
				//Detail Kunjungan Rawat Jalan //
				$this->load->view('t_pelayanan/kunjungan_detail/v_t_pelayanan_rawatjalan_detail',$data);
			}elseif($val->KD_LAYANAN_B=='RI'){
				//Detail Kunjungan Rawat Inap //
				$this->load->view('t_pelayanan/kunjungan_detail/v_t_pelayanan_rawatinap_detail',$data);
			}else{
				//Detail Kunjungan UGD //
			$this->load->view('t_pelayanan/kunjungan_detail/v_t_pelayanan_ugd_detail',$data);	
			}
		}
			
		}
		
		
	public function ubahkunjungan()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("k.KD_KUNJUNGAN,NAMA_LENGKAP AS NAMA_PASIEN,k.KD_UNIT_LAYANAN,k.KD_UNIT,k.KD_DOKTER",FALSE);
		$db->from('kunjungan k');
		$db->join('pasien p','k.KD_PASIEN=p.KD_PASIEN');
		//$db->join('mst_unit u','k.KD_UNIT=p.KD_UNIT');
		$db->where('k.KD_KUNJUNGAN ',$id);
		$db->where('k.KD_PUSKESMAS',$id2);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('t_pelayanan/v_t_pelayanan_edit_kunjungan',$data);
	}
	
	public function pelayananpelayanan()
	{
		$this->load->helper('beries_helper');
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("NAMA_LENGKAP AS NAMA_PASIEN,p.KD_PASIEN,p.KD_PUSKESMAS,p.TGL_LAHIR,p.NO_PENGENAL AS NIK,p.KET_WIL,p.KD_GOL_DARAH,k.CUSTOMER",FALSE);
		$db->from('pasien p');
		$db->join('mst_kel_pasien k','k.KD_CUSTOMER=p.KD_CUSTOMER');
		//$db->join('mst_unit u','k.KD_UNIT=p.KD_UNIT');
		$db->where('p.KD_PASIEN',$id);
		$db->where('p.KD_PUSKESMAS',$id2);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('t_pelayanan/v_t_pelayanan_pelayanan',$data);
	}
	
	public function gabungpasien()
	{
		$this->load->helper('beries_helper');
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("NAMA_LENGKAP AS NAMA_PASIEN,p.KD_PASIEN,p.KD_PUSKESMAS,p.TGL_LAHIR,p.NO_PENGENAL AS NIK,p.KET_WIL,p.KD_GOL_DARAH,k.CUSTOMER",FALSE);
		$db->from('pasien p');
		$db->join('mst_kel_pasien k','k.KD_CUSTOMER=p.KD_CUSTOMER');
		//$db->join('mst_unit u','k.KD_UNIT=p.KD_UNIT');
		$db->where('p.KD_PASIEN',$id);
		$db->where('p.KD_PUSKESMAS',$id2);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('t_pelayanan/v_t_pelayanan_gabung',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from tbl_t_pelayanan where nid_t_pelayanan = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function layanan()
	{
		/*$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
		$id3=$this->input->get('id3')?$this->input->get('id3',TRUE):null;
		$data['id']=$id;
		$data['id2']=$id2;
		$data['id3']=$id3;
		$this->load->view('t_pelayanan/v_t_pelayanan_layanan',$data);*/		
		
		$this->load->helper('ernes_helper');
		$this->load->helper('beries_helper');
		$this->load->helper('My_helper');
		$this->load->helper('master_helper');
		$this->load->helper('sigit_helper');
		$this->load->helper('jokos_helper');
		$this->load->helper('pemkes_helper');
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
		$id3=$this->input->get('id3')?$this->input->get('id3',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$unit = $db->query("select * from kunjungan where KD_KUNJUNGAN='".$id3."' and KD_UNIT=219")->row();
		if($unit){
			$db->select("NAMA_LENGKAP AS NAMA_PASIEN,p.KD_PASIEN,p.KD_PUSKESMAS,p.TGL_LAHIR,p.NO_PENGENAL AS NIK,p.KET_WIL,p.KD_GOL_DARAH,p.KD_CUSTOMER,p.CARA_BAYAR,k.CUSTOMER,mu.UNIT,kj.KD_KUNJUNGAN,kj.KD_UNIT,kj.URUT_MASUK,kj.KD_LAYANAN_B,tk.KD_KATEGORI_KIA,tk.KD_KUNJUNGAN_KIA, kkj.KUNJUNGAN_KIA",FALSE);
			$db->from('pasien p');
			$db->join('mst_kel_pasien k','k.KD_CUSTOMER=p.KD_CUSTOMER');
			$db->join('kunjungan kj','kj.KD_PASIEN=p.KD_PASIEN');
			$db->join('mst_unit mu','mu.KD_UNIT=kj.KD_UNIT');
			$db->join('trans_kia tk','tk.KD_KUNJUNGAN=kj.KD_KUNJUNGAN');
			$db->join('mst_kunjungan_kia kkj','kkj.KD_KUNJUNGAN_KIA=tk.KD_KUNJUNGAN_KIA');
			$db->where('p.KD_PASIEN',$id);
			$db->where('kj.KD_KUNJUNGAN',$id3);
			$db->where('p.KD_PUSKESMAS',$id2);
			$val = $db->get()->row();	//print_r($val);die;	
			
				$tindakanlist = $db->query("SELECT p.KD_PRODUK AS id,CONCAT(p.PRODUK,' => Harga:',p.HARGA_PRODUK) AS label, 
							CASE WHEN g.GOL_PRODUK IS NULL THEN '' ELSE g.GOL_PRODUK END AS category
							FROM mst_produk p LEFT JOIN mst_gol_produk g on p.KD_GOL_PRODUK=g.KD_GOL_PRODUK")->result_array();
			
			$data['dataproduktindakan']=json_encode($tindakanlist);
			$data['data']=$val;
			if($val->KD_LAYANAN_B=='RJ' and $val->KD_KATEGORI_KIA==1 AND $val->KD_KUNJUNGAN_KIA==1){
			$this->load->view('t_pelayanan/kunjungan/v_t_pelayanan_bumil',$data);
			}elseif($val->KD_LAYANAN_B=='RJ' and $val->KD_KATEGORI_KIA==1 AND $val->KD_KUNJUNGAN_KIA==2){
				$this->load->view('t_pelayanan/kunjungan/v_t_pelayanan_bersalin',$data);
			}elseif($val->KD_LAYANAN_B=='RJ' and $val->KD_KATEGORI_KIA==1 AND $val->KD_KUNJUNGAN_KIA==3){
				$this->load->view('t_pelayanan/kunjungan/v_transaksi_kunjungan_nifas_add',$data);
			}elseif($val->KD_LAYANAN_B=='RJ' and $val->KD_KATEGORI_KIA==1 AND $val->KD_KUNJUNGAN_KIA==4){
				$this->load->view('t_pelayanan/kunjungan/v_t_pelayanan_kb',$data);
			}elseif($val->KD_LAYANAN_B=='RJ' and $val->KD_KATEGORI_KIA==2 AND $val->KD_KUNJUNGAN_KIA==1){
				$this->load->view('t_pelayanan/kunjungan/v_t_pelayanan_neonatus',$data);
			}elseif($val->KD_LAYANAN_B=='RJ' and $val->KD_KATEGORI_KIA==2 AND $val->KD_KUNJUNGAN_KIA==2){
				$this->load->view('t_pelayanan/kunjungan/v_t_pelayanan_kesehatan_anak',$data);
			}
		}else{
			$db->select("NAMA_LENGKAP AS NAMA_PASIEN,p.KD_PASIEN,p.KD_PUSKESMAS,p.TGL_LAHIR,p.NO_PENGENAL AS NIK,p.KET_WIL,p.KD_GOL_DARAH,p.KD_CUSTOMER,p.CARA_BAYAR,k.CUSTOMER,mu.UNIT,kj.KD_KUNJUNGAN,kj.KD_UNIT,kj.URUT_MASUK,kj.KD_LAYANAN_B",FALSE);
			$db->from('pasien p');
			$db->join('mst_kel_pasien k','k.KD_CUSTOMER=p.KD_CUSTOMER');
			$db->join('kunjungan kj','kj.KD_PASIEN=p.KD_PASIEN');
			$db->join('mst_unit mu','mu.KD_UNIT=kj.KD_UNIT');
			$db->where('p.KD_PASIEN',$id);
			$db->where('kj.KD_KUNJUNGAN',$id3);
			$db->where('p.KD_PUSKESMAS',$id2);
			$val = $db->get()->row();		
			
			$tindakanlist = $db->query("SELECT p.KD_PRODUK AS id,p.PRODUK AS label, 
								CASE WHEN g.GOL_PRODUK IS NULL THEN '' ELSE g.GOL_PRODUK END AS category
								FROM mst_produk p LEFT JOIN mst_gol_produk g on p.KD_GOL_PRODUK=g.KD_GOL_PRODUK")->result_array();
			
			$data['dataproduktindakan']=json_encode($tindakanlist);
			$data['data']=$val;
			if($val->KD_LAYANAN_B=='RJ'){
				$this->load->view('t_pelayanan/v_t_pelayanan_rawatjalan',$data);
			}elseif($val->KD_LAYANAN_B=='RI'){
				$this->load->view('t_pelayanan/v_t_pelayanan_rawatinap',$data);
			}else{
			$this->load->view('t_pelayanan/v_t_pelayanan_ugd',$data);	
			}
		}
		
		
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function pelayananprocess()
	{ //print_r($_POST);die;
		$this->load->library('form_validation');
		$val = $this->form_validation;
		$val->set_rules('tanggal_daftar', 'Tanggal Pendaftaran', 'trim|required|myvalid_date');		
		$val->set_rules('cara_bayar', 'Cara Bayar', 'trim|required|xss_clean');
		$val->set_rules('jenis_pasien', 'Jenis Pasien', 'trim|required|xss_clean');
						
		$arraydiagnosa = $this->input->post('diagnosa_final')?json_decode($this->input->post('diagnosa_final',TRUE)):NULL;
		$arrayobat = $this->input->post('obat_final')?json_decode($this->input->post('obat_final',TRUE)):NULL;
		$arrayalergi = $this->input->post('alergi_final')?json_decode($this->input->post('alergi_final',TRUE)):NULL;
		$arraytindakan = $this->input->post('tindakan_final')?json_decode($this->input->post('tindakan_final',TRUE)):NULL;
		$datainsert = array();		
		
		if ($val->run() == FALSE)
		{
			$val->set_error_delimiters('<div style="color:white">', '</div>');
			die(validation_errors());
		}
		else
		{
			$db = $this->load->database('sikda', TRUE);
			$db->trans_begin();
			
			$maxkasir = 0;
			$maxkasir = $db->query("SELECT MAX(SUBSTR(KD_PEL_KASIR,-7)) AS total FROM pel_kasir where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
			$maxkasir = $maxkasir->total + 1;
			$kodekasir = 'KASIR'.sprintf("%07d", $maxkasir);
			
			$datainsertkasir=array(
				'KD_PEL_KASIR'=> $kodekasir,
				'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
				'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
				'KD_UNIT' => $this->input->post('kd_unit_hidden',TRUE),
				'KD_TARIF' => 0,
				'JUMLAH_BIAYA' => 0,
				'JUMLAH_PPN' => 0,
				'JUMLAH_DISC' => 0,
				'JUMLAH_TOTAL' => 0,
				'KD_USER' => $this->session->userdata('kd_petugas'),
				'STATUS_TX' => 0
				
			);			
			$db->insert('pel_kasir',$datainsertkasir);
			
			$maxpelayanan = 0;
			$maxpelayanan = $db->query("SELECT MAX(SUBSTR(KD_PELAYANAN,-7)) AS total FROM pelayanan where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
			$maxpelayanan = $maxpelayanan->total + 1;
			$kodepelayanan = $this->input->post('kd_unit_hidden',TRUE).sprintf("%07d", $maxpelayanan);
			
			$datainsert = array(
                'KD_PELAYANAN' =>  $kodepelayanan,
                'TGL_PELAYANAN' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_daftar')))),
                'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
                'KD_UNIT' => 6,
                'URUT_MASUK' => $this->input->post('kd_urutmasuk_hidden',TRUE),
                'KD_KASIR' => $kodekasir,
                'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
                'ANAMNESA' => $this->input->post('anamnesa',TRUE),
                'KONDISI_PASIEN' => '-',
                'CATATAN_FISIK' => $this->input->post('catatan_fisik',TRUE),
                'CARA_BAYAR' => $this->input->post('cara_bayar',TRUE),
                'JENIS_PASIEN' => $this->input->post('jenis_pasien',TRUE),
                'KD_USER' => $this->session->userdata('kd_petugas'),
                'CATATAN_DOKTER' => $this->input->post('catatan_dokter',TRUE),
                'Created_Date' => date('Y-m-d'),
                'Created_By' => $this->session->userdata('kd_petugas'),
                'KD_DOKTER' => $this->session->userdata('kd_petugas'),
                'KEADAAN_KELUAR' => $this->input->post('status_keluar',TRUE)
            );
			if($this->input->post('showhide_kunjungan')){
				if($this->input->post('showhide_kunjungan')=='rawat_jalan'){
					$datainsert['UNIT_PELAYANAN'] = 'RJ';
				}elseif($this->input->post('showhide_kunjungan')=='rawat_inap'){
					$datainsert['UNIT_PELAYANAN'] = 'RI';
				}else{
					$datainsert['UNIT_PELAYANAN'] = 'RD';
				}
			}			
			$db->insert('pelayanan',$datainsert);
			
			if($arrayobat){
				$maxpelayananobat = 0;
				$maxpelayananobat = $db->query("SELECT MAX(SUBSTR(KD_PELAYANAN,-7)) AS total FROM pelayanan where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
				$maxpelayananobat = $maxpelayananobat->total + 1;
				$kodepelayananobat = '6'.sprintf("%07d", $maxpelayananobat);
				$kodepelayananresep = 'R'.sprintf("%07d", $maxpelayananobat);
				$irow=1;
				foreach($arrayobat as $rowobatloop){
					$dataobattmp = json_decode($rowobatloop);
					$dataobatloop[] = array(
						'KD_PELAYANAN_OBAT' => $kodepelayananobat,
						'KD_PELAYANAN' => $kodepelayanan,
						'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
						'NO_RESEP' => $kodepelayananresep,
						'KD_OBAT' => $dataobattmp->kd_obat,
						'SAT_BESAR' => '',
						'SAT_KECIL' => '',
						'QTY' => $dataobattmp->jumlah,
						'DOSIS' => $dataobattmp->dosis,
						'JUMLAH' => $dataobattmp->jumlah,
						'KD_PETUGAS' => $this->session->userdata('user_name'),
						'STATUS' => 0,
						'iROW' => $irow,
						'TANGGAL' => date('Y-m-d'),
						'Created_By' => $this->session->userdata('user_name'),
						'Created_Date' => date('Y-m-d H:i:s')
					);
					$dataobatinsert = $dataobatloop;
					$irow++;
				}
				$db->insert_batch('pel_ord_obat',$dataobatinsert);
			}
			
			if($arraytindakan){
				$irow2=1;
				foreach($arraytindakan as $rowtindakanloop){
					$datatindakantmp = json_decode($rowtindakanloop);
					$datatindakanloop[] = array(
						'KD_PELAYANAN' => $kodepelayanan,
						'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
						'KD_TINDAKAN' => $datatindakantmp->kd_tindakan,
						'QTY' => $datatindakantmp->jumlah?$datatindakantmp->jumlah:0,
						'HRG_TINDAKAN' => $datatindakantmp->harga?$datatindakantmp->harga:0,
						'KETERANGAN' => $datatindakantmp->keterangan,
						'KD_PETUGAS' => $this->session->userdata('user_name'),
						'iROW' => $irow2,
						'TANGGAL' => date('Y-m-d'),
						'Created_By' => $this->session->userdata('user_name'),
						'Created_Date' => date('Y-m-d H:i:s')
					);
					$datatindakaninsert = $datatindakanloop;
					$irow2++;
				}
				$db->insert_batch('pel_tindakan',$datatindakaninsert);
			}
			
			if($arraydiagnosa){
				$irow3=1;
				foreach($arraydiagnosa as $rowdiagnosaloop){
					$datadiagnosatmp = json_decode($rowdiagnosaloop);
					$datadiagnosaloop[] = array(
						'KD_PELAYANAN' => $kodepelayanan,
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
						'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
						'KD_PENYAKIT' => $datadiagnosatmp->kd_penyakit,
						'JNS_KASUS' => $datadiagnosatmp->jenis_kasus,
						'JNS_DX' => $datadiagnosatmp->jenis_diagnosa,
						'KD_PETUGAS' => $this->session->userdata('user_name'),
						'iROW' => $irow3,
						'TANGGAL' => date('Y-m-d'),
						'Created_By' => $this->session->userdata('user_name'),
						'Created_Date' => date('Y-m-d H:i:s')
					);
					$datadiagnosainsert = $datadiagnosaloop;
					$irow3++;
				}
				$db->insert_batch('pel_diagnosa',$datadiagnosainsert);
			}
			
			//pel_kasir_detail
			//pel_kasir_detail_bayar
			
			$dataexc = array(
				'STATUS' => 1
				//'KD_UNIT' => 6
			);						
			$db->where('KD_KUNJUNGAN',$this->input->post('kd_kunjungan_hidden',TRUE));
			$db->update('kunjungan',$dataexc);
			
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
	
	public function rawatjalan()
	{
		$this->load->helper('beries_helper');
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
		$id3=$this->input->get('id3')?$this->input->get('id3',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("NAMA_LENGKAP AS NAMA_PASIEN,p.KD_PASIEN,p.KD_PUSKESMAS,p.TGL_LAHIR,p.NO_PENGENAL AS NIK,p.KET_WIL,p.KD_GOL_DARAH,k.CUSTOMER,mu.UNIT,kj.KD_KUNJUNGAN,kj.KD_UNIT,kj.URUT_MASUK",FALSE);
		$db->from('pasien p');
		$db->join('mst_kel_pasien k','k.KD_CUSTOMER=p.KD_CUSTOMER');
		$db->join('kunjungan kj','kj.KD_PASIEN=p.KD_PASIEN');
		$db->join('mst_unit mu','mu.KD_UNIT=kj.KD_UNIT');
		$db->where('p.KD_PASIEN',$id);
		$db->where('kj.KD_KUNJUNGAN',$id3);
		$db->where('p.KD_PUSKESMAS',$id2);
		$val = $db->get()->row();		
		
		$tindakanlist = $db->query("SELECT p.KD_PRODUK AS id,p.PRODUK AS label, 
							CASE WHEN g.GOL_PRODUK IS NULL THEN '' ELSE g.GOL_PRODUK END AS category
							FROM mst_produk p LEFT JOIN mst_gol_produk g on p.KD_GOL_PRODUK=g.KD_GOL_PRODUK")->result_array();
		
		$data['dataproduktindakan']=json_encode($tindakanlist);
		$data['data']=$val;
		$this->load->view('t_pelayanan/v_t_pelayanan_rawatjalan',$data);
	}
	
	public function rawatinap()
	{
		$this->load->helper('beries_helper');
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("NAMA_LENGKAP AS NAMA_PASIEN,p.KD_PASIEN,p.KD_PUSKESMAS,p.TGL_LAHIR,p.NO_PENGENAL AS NIK,p.KET_WIL,p.KD_GOL_DARAH,k.CUSTOMER,mu.UNIT",FALSE);
		$db->from('pasien p');
		$db->join('mst_kel_pasien k','k.KD_CUSTOMER=p.KD_CUSTOMER');
		$db->join('kunjungan kj','kj.KD_PASIEN=p.KD_PASIEN');
		$db->join('mst_unit mu','mu.KD_UNIT=kj.KD_UNIT');
		$db->where('p.KD_PASIEN',$id);
		$db->where('p.KD_PUSKESMAS',$id2);
		$val = $db->get()->row();
		
		$tindakanlist = $db->query("SELECT p.KD_PRODUK AS id,p.PRODUK AS label, g.GOL_PRODUK AS category FROM mst_produk p LEFT JOIN mst_gol_produk g on p.KD_GOL_PRODUK=g.KD_GOL_PRODUK")->result_array();
		
		$data['data']=$val;		
		$data['dataproduktindakan']=json_encode($tindakanlist);		
		$this->load->view('t_pelayanan/v_t_pelayanan_rawatinap',$data);
	}
	
	public function icdsource()
	{
		$id=$this->input->get('term')?$this->input->get('term',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$comboicd = $db->query("SELECT icd.KD_PENYAKIT AS id,icd.PENYAKIT AS label,
								CASE WHEN induk.ICD_INDUK IS NULL THEN '' ELSE induk.ICD_INDUK END  AS category FROM mst_icd icd LEFT JOIN 
								mst_icd_induk induk ON induk.KD_ICD_INDUK = icd.KD_ICD_INDUK where icd.PENYAKIT like '%".$id."%' ")->result_array();
		die(json_encode($comboicd));
	}
	
	public function obatsource()
	{
		$id=$this->input->get('term')?$this->input->get('term',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$comboicd = $db->query("SELECT obat.KD_OBAT AS id,obat.NAMA_OBAT AS label,
								induk.GOL_OBAT AS category FROM apt_mst_obat obat LEFT JOIN 
								apt_mst_gol_obat induk ON induk.KD_GOL_OBAT = obat.KD_GOL_OBAT where obat.NAMA_OBAT like '%".$id."%' ")->result_array();
		die(json_encode($comboicd));
	}
	/// Subgrid dari Amin ///
	public function t_subgridpelayanankia()
	{		
		$this->load->model('t_pelayanan_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(				
					'kd_pasien'=>$this->input->post('kd_pasien'),
					'kd_puskesmas'=>$this->input->post('kd_puskesmas')
					);
					
		$total = $this->t_pelayanan_model->totalsubgridpeltranskia($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),				
					'kd_pasien'=>$this->input->post('kd_pasien'),
					'kd_puskesmas'=>$this->input->post('kd_puskesmas'),
					'kd_kunjungan'=>$this->input->post('kd_kunjungan')
					);
					
		$result = $this->t_pelayanan_model->getsubgridpeltranskia($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
}

/* End of file t_pelayanan.php */
/* Location: ./application/controllers/t_pelayanan.php */