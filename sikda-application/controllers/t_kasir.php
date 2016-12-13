<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_kasir extends CI_Controller {
	public function index()
	{
		$this->load->helper('beries_helper');
		$this->load->view('v_kasir/v_kasir_index');
	}
	
	public function t_kasirxml()
	{		
		$this->load->model('t_kasir_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),					
					'keyword'=>$this->input->post('keyword'),					
					'status'=>$this->input->post('status'),
					'cari'=>$this->input->post('cari')
					);
					
		$total = $this->t_kasir_model->totalT_kasir($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('sord'),
					'dari'=>$this->input->post('dari'),					
					'keyword'=>$this->input->post('keyword'),					
					'status'=>$this->input->post('status'),
					'cari'=>$this->input->post('cari')
					);
					
		$result = $this->t_kasir_model->getT_kasir($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}	
	
	public function listtransaksikasir()
	{
		$this->load->model('t_kasir_model');
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
		$id3= $this->session->userdata('kd_puskesmas');
		$db = $this->load->database('sikda', TRUE);
		$db->select("KD_PRODUK, PRODUK, KD_TARIF, QTY, HARGA_PRODUK, TOTAL_HARGA",FALSE);
		$db->from('vw_kasir_detail');
		$db->where('KD_PEL_KASIR',$id);
		$db->where('KD_PUSKESMAS',$id3);		
		$val = $db->get()->result_array();
		
		$db->select("p.*,u.KD_PEL_KASIR",FALSE);
		$db->from('vw_lst_kasir u');
		$db->join('pasien p','p.KD_PASIEN=u.KD_PASIEN');
		$db->where('u.KD_PEL_KASIR ',$id);
		$db->where('p.KD_PUSKESMAS',$id3);		
		$val2 = $db->get()->row();
		
		$db->select("KD_PEL_KASIR, CARA_BAYAR, JUMLAH_BAYAR, TGL_BAYAR,JUMLAH_DISC,JUMLAH_PPN,JUMLAH_TTL",FALSE);
		$db->from('vw_lst_kasir_bayar');
		$db->where('KD_PEL_KASIR ',$id);
		$db->where('KD_PUSKESMAS',$id3);
		$val3 = $db->get()->row();
		
		$db->select("NILAI_RETRIBUSI",FALSE);
		$db->from('mst_retribusi');
		//$db->where('KD_PEL_KASIR ',$id);
		$db->where('KD_PUSKESMAS',$id3);
		$val4 = $db->get()->row();
		
		$data['id']=$id;
		$data['data']=$val2;
		$data['data2']=$val;
		$data['data3']=$val3;
		$data['data4']=$val4;
		$this->load->view('v_kasir/v_t_kasir',$data);
	}
	
	public function bayar()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$kdbayar=$this->input->post('kdbayar')?$this->input->post('kdbayar',TRUE):null;
		$jumlahbayar=$this->input->post('jumlahbayar')?$this->input->post('jumlahbayar',TRUE):null;
		$disc=$this->input->post('disc')?$this->input->post('disc',TRUE):0;
		$ppn=$this->input->post('ppn')?$this->input->post('ppn',TRUE):0;
		$ttl=$this->input->post('ttl')?$this->input->post('ttl',TRUE):0;
		$kdPuskesmas= $this->session->userdata('kd_puskesmas');
		$db = $this->load->database('sikda', TRUE);
		$cekBayar = $db->query("select * from pel_kasir_detail_bayar where KD_PEL_KASIR='$id' and KD_PUSKESMAS='$kdPuskesmas'")->row();
		if ($cekBayar == FALSE)
		{
			  $simpanBayar = array(
				'KD_PEL_KASIR' => $id,
				'KD_BAYAR' => $kdbayar,
				'KD_PUSKESMAS' => $kdPuskesmas,
				'JUMLAH_BAYAR' => $jumlahbayar,
				'JUMLAH_DISC' => $disc,
				'JUMLAH_PPN' => $ppn,
				'JUMLAH_TTL' => $ttl,
				'TGL_BAYAR' => date("Y-m-d H:i:s")   
				);      

			$db->insert('pel_kasir_detail_bayar', $simpanBayar);

		}else{

				$dataexc1 = array(
					'KD_BAYAR' => $kdbayar,
					'JUMLAH_BAYAR' => $jumlahbayar,
					'TGL_BAYAR' => date("Y-m-d H:i:s"),
					'JUMLAH_DISC' => $disc,
					'JUMLAH_TTL' => $ttl,
					'JUMLAH_PPN' => $ppn
				);
				
				$db->where('KD_PUSKESMAS',$kdPuskesmas);
				$db->where('KD_PEL_KASIR',$id);
				$db->update('pel_kasir_detail_bayar', $dataexc1);
		}
		$dataexc = array(
			'STATUS_TX' => 1
		);
		$db->where('KD_PEL_KASIR',$id);
		$db->where('KD_PUSKESMAS',$kdPuskesmas);
		$db->update('pel_kasir',$dataexc);
		
		die(json_encode('OK'));
	}
	
	public function tutuptransaksi()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$kdPuskesmas= $this->session->userdata('kd_puskesmas');
		$db = $this->load->database('sikda', TRUE);
		
		$dataexc = array(
			'STATUS_TX' => 1,
			'CLOSING_USER' => $this->session->userdata('user_name')
		);
		$db->where('KD_PEL_KASIR',$id);
		$db->where('KD_PUSKESMAS',$kdPuskesmas);
		$db->update('pel_kasir',$dataexc);
		die(json_encode('OK'));
	}
	
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_kasir/v_t_kasir_add');
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
				'ntgl_t_kasir' => date("Y-m-d", strtotime($this->input->post('tglt_kasir',TRUE))),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('tbl_t_kasir', $dataexc);
			
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
		$val->set_rules('column1', 'Column Satu', 'trim|required|xss_clean');
		$val->set_rules('column2', 'Column Dua', 'trim|required|xss_clean');
		$val->set_rules('column3', 'Column Tiga', 'trim|required|xss_clean');
		$val->set_rules('column_master_1_id', 'Column Master 1', 'trim|required|xss_clean');

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
				'ntgl_t_kasir' => date("Y-m-d", strtotime($this->input->post('tglt_kasir',TRUE))),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('nid_t_kasir',$id);
			$db->update('tbl_t_kasir', $dataexc);
			
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
		$db->select("u.*, m.ncolumn1 as nmastercolumn1");
		$db->from('tbl_t_kasir u');
		$db->join('tbl_master1 m','m.nid_master1=u.nmaster_1_id');
		$db->where('u.nid_t_kasir ',$id);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('t_kasir/t_kasiredit',$data);
	}
	
	public function ubahkunjungan()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("k.KD_KUNJUNGAN,CONCAT(p.NAMA_DEPAN,' ',p.NAMA_TENGAH,' ',p.NAMA_BELAKANG) AS NAMA_PASIEN,k.KD_UNIT_LAYANAN,k.KD_UNIT,k.KD_DOKTER",FALSE);
		$db->from('kunjungan k');
		$db->join('pasien p','k.KD_PASIEN=p.KD_PASIEN');
		//$db->join('mst_unit u','k.KD_UNIT=p.KD_UNIT');
		$db->where('k.KD_KUNJUNGAN ',$id);
		$db->where('k.KD_PUSKESMAS',$id2);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('t_kasir/v_t_kasir_edit_kunjungan',$data);
	}
	
	public function kasirkasir()
	{
		$this->load->helper('beries_helper');
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("CONCAT(p.NAMA_DEPAN,' ',p.NAMA_TENGAH,' ',p.NAMA_BELAKANG) AS NAMA_PASIEN,p.KD_PASIEN,p.KD_PUSKESMAS,p.TGL_LAHIR,p.NO_PENGENAL AS NIK,p.KET_WIL,p.KD_GOL_DARAH,k.CUSTOMER",FALSE);
		$db->from('pasien p');
		$db->join('mst_kel_pasien k','k.KD_CUSTOMER=p.KD_CUSTOMER');
		//$db->join('mst_unit u','k.KD_UNIT=p.KD_UNIT');
		$db->where('p.KD_PASIEN',$id);
		$db->where('p.KD_PUSKESMAS',$id2);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('t_kasir/v_t_kasir_kasir',$data);
	}
	
	public function gabungpasien()
	{
		$this->load->helper('beries_helper');
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("CONCAT(p.NAMA_DEPAN,' ',p.NAMA_TENGAH,' ',p.NAMA_BELAKANG) AS NAMA_PASIEN,p.KD_PASIEN,p.KD_PUSKESMAS,p.TGL_LAHIR,p.NO_PENGENAL AS NIK,p.KET_WIL,p.KD_GOL_DARAH,k.CUSTOMER",FALSE);
		$db->from('pasien p');
		$db->join('mst_kel_pasien k','k.KD_CUSTOMER=p.KD_CUSTOMER');
		//$db->join('mst_unit u','k.KD_UNIT=p.KD_UNIT');
		$db->where('p.KD_PASIEN',$id);
		$db->where('p.KD_PUSKESMAS',$id2);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('t_kasir/v_t_kasir_gabung',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from tbl_t_kasir where nid_t_kasir = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function posting()
	{
		$kd_puskesmas=$this->input->post('kd_puskesmas')?$this->input->post('kd_puskesmas',TRUE):null;
		$kd_obat=$this->input->post('kd_obat')?$this->input->post('kd_obat',TRUE):null;
		$kd_pelayanan=$this->input->post('kd_obat')?$this->input->post('kd_pelayanan',TRUE):null;
		$random=$this->input->post('random')?$this->input->post('random',TRUE):null;
		$stk=$this->input->post('stock')?$this->input->post('stock',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		
		$val = $db->query("select * from apt_stok_obat where KD_OBAT='$kd_obat' and KD_PKM='$kd_puskesmas'")->row();
		if($val->random==$random){
			die(json_encode('OK'));
		}				
		
		$stock = $val->JUMLAH_STOK_OBAT - $stk;
		
		$dataexc1 = array(
			'STATUS' => 1
		);
		
		$db->where('KD_PUSKESMAS',$kd_puskesmas);
		$db->where('KD_PELAYANAN',$kd_pelayanan);
		$db->where('KD_OBAT',$kd_obat);
		$db->update('pel_ord_obat', $dataexc1);
		
		$dataexc = array(
			'JUMLAH_STOK_OBAT' => $stock,
			'random' => $random
		);
		
		$db->where('KD_PKM',$kd_puskesmas);
		$db->where('KD_OBAT',$kd_obat);
		$db->update('apt_stok_obat', $dataexc);
		die(json_encode('OK'));
	}
	
	public function layanan()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
		$data['id']=$id;
		$data['id2']=$id2;
		$this->load->view('t_kasir/v_t_kasir_layanan',$data);
	}
	
	public function rawatjalan()
	{
		$this->load->helper('beries_helper');
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("CONCAT(p.NAMA_DEPAN,' ',p.NAMA_TENGAH,' ',p.NAMA_BELAKANG) AS NAMA_PASIEN,p.KD_PASIEN,p.KD_PUSKESMAS,p.TGL_LAHIR,p.NO_PENGENAL AS NIK,p.KET_WIL,p.KD_GOL_DARAH,k.CUSTOMER,mu.UNIT",FALSE);
		$db->from('pasien p');
		$db->join('mst_kel_pasien k','k.KD_CUSTOMER=p.KD_CUSTOMER');
		$db->join('kunjungan kj','kj.KD_PASIEN=p.KD_PASIEN');
		$db->join('mst_unit mu','mu.KD_UNIT=kj.KD_UNIT');
		$db->where('p.KD_PASIEN',$id);
		$db->where('p.KD_PUSKESMAS',$id2);
		$val = $db->get()->row();		
		
		$tindakanlist = $db->query("SELECT p.KD_PRODUK AS id,p.PRODUK AS label, 
							CASE WHEN g.GOL_PRODUK IS NULL THEN '' ELSE g.GOL_PRODUK END AS category
							FROM mst_produk p LEFT JOIN mst_gol_produk g on p.KD_GOL_PRODUK=g.KD_GOL_PRODUK")->result_array();
		
		$data['dataproduktindakan']=json_encode($tindakanlist);
		$data['data']=$val;
		$this->load->view('t_kasir/v_t_kasir_rawatjalan',$data);
	}
	
	public function rawatinap()
	{
		$this->load->helper('beries_helper');
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("CONCAT(p.NAMA_DEPAN,' ',p.NAMA_TENGAH,' ',p.NAMA_BELAKANG) AS NAMA_PASIEN,p.KD_PASIEN,p.KD_PUSKESMAS,p.TGL_LAHIR,p.NO_PENGENAL AS NIK,p.KET_WIL,p.KD_GOL_DARAH,k.CUSTOMER,mu.UNIT",FALSE);
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
		$this->load->view('t_kasir/v_t_kasir_rawatinap',$data);
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
	
	public function cetakkasir()
	{//print_r($_GET);die;
		$kd_pel_kasir = $this->input->get('pel_kasir',TRUE);
		$diskon = $this->input->get('diskon',TRUE);
		$ppn = $this->input->get('ppn',TRUE);
		$retri = $this->input->get('retri',TRUE);
		$total = $this->input->get('total',TRUE);
		$bayarppn = $this->input->get('bayarppn',TRUE);
		$id3 = $this->session->userdata('kd_puskesmas');
		
		$array = array(
				'datappn' => $ppn,
				'datadiskon' => $diskon,
				'dataretri' => $retri,
				'datatotal' => $total,
				'databayarppn' => $bayarppn);
		
		$db = $this->load->database('sikda', TRUE);
		$db->select("DATE_FORMAT(pe.TGL_PELAYANAN,'%d-%m-%Y') AS TGL_PELAYANAN,pu.*,p.*,u.KD_PEL_KASIR,j.CUSTOMER,dk.NAMA,us.FULL_NAME as PETUGAS_2",FALSE);
		$db->from('vw_lst_kasir u');
		$db->join('mst_puskesmas pu','pu.KD_PUSKESMAS=u.KD_PUSKESMAS','left');
		$db->join('pel_kasir pk','pk.KD_PEL_KASIR=u.KD_PEL_KASIR', 'left');
		// $db->join('mst_dokter dk','dk.KD_DOKTER=pk.CLOSING_USER', 'left');
		$db->join('pelayanan pe','pe.KD_KASIR=u.KD_PEL_KASIR');
		$db->join('mst_dokter dk','dk.KD_DOKTER=pe.KD_DOKTER', 'left');
		$db->join('pasien p','p.KD_PASIEN=u.KD_PASIEN');
		$db->join('mst_kel_pasien j','j.KD_CUSTOMER=p.KD_CUSTOMER','left');
		$db->join('users us','us.KD_USER=pe.KD_USER','left');
		$db->where('u.KD_PEL_KASIR ',$kd_pel_kasir);
		$db->where('p.KD_PUSKESMAS',$id3);		
		$val = $db->get()->row();
		
		$db->select("*",FALSE);
		$db->from('pel_kasir_detail_bayar u');
		$db->where('u.KD_PEL_KASIR ',$kd_pel_kasir);
		$val1 = $db->get()->row();
		
		$db->select("KD_PRODUK, PRODUK, KD_TARIF, QTY, HARGA_PRODUK, TOTAL_HARGA",FALSE);
		$db->from('vw_kasir_detail');
		$db->where('KD_PEL_KASIR',$kd_pel_kasir);
		$db->where('KD_PUSKESMAS',$id3);		
		$val2 = $db->get()->result_array();
		
		$data['data']=$val;
		$data['data1']=$val1;
		$data['data2']=$val2;
		$data['data3']=$array;
		$data['NAMA']=$this->session->userdata('kd_petugas');
		$this->load->view('v_kasir/v_kasir_cetak',$data);
	}
	
	public function cetak()
	{
		$kd_puskesmas = $this->input->get('kd_puskesmas',TRUE);
		$kd_pelayanan = $this->input->get('kd_pelayanan',TRUE);
		$kd_pasien = $this->input->post('kd_pasien',TRUE);
		$db = $this->load->database('sikda', TRUE);
		$db->select("pl.NO_RESEP",FALSE);
		$db->from('pelayanan y');		
		$db->join('pel_ord_obat pl','pl.KD_PELAYANAN=y.KD_PELAYANAN');
		$db->where('y.KD_PELAYANAN',$kd_pelayanan);
		$db->where('y.KD_PUSKESMAS',$kd_puskesmas);
		$pasien = $db->get()->row();
		if($pasien){
			$noresep=$pasien->NO_RESEP;
			die(site_url().'sikda_reports/resep.php?pid='.$kd_puskesmas.'&hdnNoResep='.$noresep);
		}else{
			die('Maaf Proses Database Gagal');
		}
	}
	
	public function cetakold()
	{
		$kd_puskesmas = $this->input->get('kd_puskesmas',TRUE);
		$kd_pelayanan = $this->input->get('kd_pelayanan',TRUE);
		$kd_pasien = $this->input->post('kd_pasien',TRUE);
		$db = $this->load->database('sikda', TRUE);
		$db->select("p.NAMA_LENGKAP as NAMA_PASIEN,p.KD_PASIEN,k.CUSTOMER,ms.PUSKESMAS,pl.NO_RESEP, Get_Age(p.TGL_LAHIR) AS UMUR,p.ALAMAT,y.KD_DOKTER,y.TGL_PELAYANAN",FALSE);
		$db->from('pelayanan y');		
		$db->join('pasien p','p.KD_PASIEN=y.KD_PASIEN');
		$db->join('mst_puskesmas ms','ms.KD_PUSKESMAS=y.KD_PUSKESMAS');
		$db->join('mst_kel_pasien k','k.KD_CUSTOMER=y.JENIS_PASIEN');
		$db->join('pel_ord_obat pl','pl.KD_PELAYANAN=y.KD_PELAYANAN');
		$db->where('y.KD_PELAYANAN',$kd_pelayanan);
		$db->where('y.KD_PUSKESMAS',$kd_puskesmas);
		$pasien = $db->get()->row();
		$html = '';
		$html .= '<div style="text-align:center">RESEP OBAT</div></br>';
		$html .= '<div style="border-top:1px solid #000"></div>';
		$html .= '<table border="0" style="font-size:11px">';
		$html .= '<tr><td>Puskesmas</td><td>: '.$pasien->PUSKESMAS.'</td></tr>';
		$html .= '<tr><td>No. Resep</td><td>: '.$pasien->NO_RESEP.'</td></tr>';
		$html .= '<tr><td>Rekam Medis#</td><td>: '.$pasien->KD_PASIEN.'</td></tr>';
		$html .= '<tr><td>Nama Pasien</td><td>: '.$pasien->NAMA_PASIEN.'</td></tr>';
		$html .= '<tr><td>Umur</td><td>: '.$pasien->UMUR.'</td></tr>';
		$html .= '<tr><td>Alamat</td><td>: '.$pasien->ALAMAT.'</td></tr>';
		$html .= '<tr><td>Jenis Pasien</td><td>: '.$pasien->CUSTOMER.'</td></tr>';
		$html .= '<tr><td>Petugas</td><td>: '.$pasien->KD_DOKTER.'</td></tr>';
		$html .= '<tr><td>Tgl. Pelayanan</td><td>: '.$pasien->TGL_PELAYANAN.'</td></tr>';
		$html .= '<table border="0">';		
		$html .= '</table><br/>';
		
		$db->select('p.KD_OBAT,o.NAMA_OBAT,o.KD_GOL_OBAT,p.DOSIS,p.HRG_DASAR,p.QTY,p.QTY as jumlah,p.STATUS,p.KD_PELAYANAN_OBAT',false);
		$db->from('pel_ord_obat p');
		$db->join('apt_mst_obat o','o.KD_OBAT=p.KD_OBAT');
				
		$db->where('p.KD_PELAYANAN =', $kd_pelayanan);
		$db->where('p.KD_PUSKESMAS =', $kd_puskesmas);
		$db->order_by('p.iROW ASC');
		
		$obat = $db->get()->result_object();
		
		$html .= '<style>.brd{border-top:1px solid #000000;border-bottom:1px solid #000000;border-left:0px;}</style>';
		$html .= '<table width="100%" border="0" style="font-size:11px">';
		$html .= '<tr><th class="brd" width="5%">No.</th><th class="brd" width="5%">&nbsp;</th><th class="brd" width="55%">Obat</th><th class="brd" width="15%">Dosis</th><th class="brd" width="10%">Qty</th><th class="brd" width="15%">Racik</th></tr>';
		$n=1;
		foreach($obat as $rowobat){
			$html .= '<tr><td>'.$n.'</td><td>'.$rowobat->KD_OBAT.'</td><td>'.$rowobat->NAMA_OBAT.'</td><td>'.$rowobat->DOSIS.'</td><td>'.$rowobat->QTY.'</td><td>Racik</td></tr>';
			$n++;
		}		
		$html .= '<table border="0">';		
		$html .= '</stable>';
		die($html);
	}
	
}

/* End of file t_kasir.php */
/* End of file t_kasir.php */
/* End of file t_kasir.php */
/* End of file t_kasir.php */
/* Location: ./application/controllers/t_kasir.php */
