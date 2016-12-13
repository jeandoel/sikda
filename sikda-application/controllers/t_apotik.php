<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_apotik extends CI_Controller {
	public function index()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_apotik/v_apotik');
	}
	
	public function t_apotikantrianxml()
	{		
		$this->load->model('t_apotik_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),					
					'keyword'=>$this->input->post('keyword'),					
					'status'=>$this->input->post('status'),
					'cari'=>$this->input->post('cari')
					);
					
		$total = $this->t_apotik_model->totalT_apotik($paramstotal);
		
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
					
		$result = $this->t_apotik_model->getT_apotik($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}	
	
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_apotik/v_t_apotik_add');
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
				'ntgl_t_apotik' => date("Y-m-d", strtotime($this->input->post('tglt_apotik',TRUE))),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);
			
			$db->insert('tbl_t_apotik', $dataexc);
			
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
				'ntgl_t_apotik' => date("Y-m-d", strtotime($this->input->post('tglt_apotik',TRUE))),
				'nupdate_oleh' => $this->session->userdata('nusername'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('nid_t_apotik',$id);
			$db->update('tbl_t_apotik', $dataexc);
			
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
		$db->from('tbl_t_apotik u');
		$db->join('tbl_master1 m','m.nid_master1=u.nmaster_1_id');
		$db->where('u.nid_t_apotik ',$id);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('t_apotik/t_apotikedit',$data);
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
		$this->load->view('t_apotik/v_t_apotik_edit_kunjungan',$data);
	}
	
	public function apotikapotik()
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
		$this->load->view('t_apotik/v_t_apotik_apotik',$data);
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
		$this->load->view('t_apotik/v_t_apotik_gabung',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from tbl_t_apotik where nid_t_apotik = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function posting()
	{
		$kd_puskesmas=$this->input->post('kd_puskesmas')?$this->input->post('kd_puskesmas',TRUE):null;
		$kd_obat=$this->input->post('kd_obat')?$this->input->post('kd_obat',TRUE):null;
		$kd_kasir=$this->input->post('kd_kasir')?$this->input->post('kd_kasir',TRUE):null;
		$kd_pelayanan=$this->input->post('kd_obat')?$this->input->post('kd_pelayanan',TRUE):null;		
		$harga=$this->input->post('harga')?$this->input->post('harga',TRUE):null;
		$random=$this->input->post('random')?$this->input->post('random',TRUE):null;
		$stk=$this->input->post('stock')?$this->input->post('stock',TRUE):null;
		$qty=$stk;
		$db = $this->load->database('sikda', TRUE);
		$db->trans_begin();
		
		$val = $db->query("select * from apt_stok_obat where KD_OBAT='$kd_obat' and KD_PKM='$kd_puskesmas' and KD_MILIK_OBAT='PKM' and KD_UNIT_APT='APT'")->row();
		//die($db->last_query());
		//print_r($val);die;
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
		
		$dataexc2 = array(
			'STATUS_LAYANAN' => 1
		);
		
		$db->where('KD_PUSKESMAS',$kd_puskesmas);
		$db->where('KD_PELAYANAN',$kd_pelayanan);
		$db->update('pelayanan', $dataexc2);
		
		$dataexc = array(
			'JUMLAH_STOK_OBAT' => $stock,
			'random' => $random
		);
		
		$db->where('KD_UNIT_APT','APT');
		$db->where('KD_PKM',$kd_puskesmas);
		$db->where('KD_OBAT',$kd_obat);
		$db->update('apt_stok_obat', $dataexc);
		
		if($val->random==$random){
			die(json_encode('OK'));
		}		

		if ($db->trans_status() === FALSE)
		{
			$db->trans_rollback();
			die('Maaf Proses Posting Data Gagal');
		}
		else
		{
			$db->trans_commit();
			die(json_encode('OK'));
		}
	}
	
	public function layanan()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
		$data['id']=$id;
		$data['id2']=$id2;
		$this->load->view('t_apotik/v_t_apotik_layanan',$data);
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
		$this->load->view('t_apotik/v_t_apotik_rawatjalan',$data);
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
		$this->load->view('t_apotik/v_t_apotik_rawatinap',$data);
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

	public function cetakresep(){
		include("include/fpdf17/fpdf.php");
		$this->load->library("resep_pdf");

		$kd_puskesmas = $this->input->get('kd_puskesmas',TRUE);
		$kd_pelayanan = $this->input->get('kd_pelayanan',TRUE);
		$kd_pasien = $this->input->post('kd_pasien',TRUE);

		$db = $this->load->database("sikda",TRUE);
		$db->select("*, 
			Get_Age(tgl_lahir) as umur,
			IFNULL(dok.NAMA, pl.Created_By) AS NAMA_PETUGAS
			"
		,FALSE)->from("pelayanan pl");
		$db->join("pel_ord_obat plobat","pl.KD_PELAYANAN=plobat.KD_PELAYANAN");
		$db->join("pasien p","pl.KD_PASIEN=p.KD_PASIEN");
		$db->join("apt_mst_obat o","o.KD_OBAT=plobat.KD_OBAT");
		$db->join("mst_dokter dok","dok.KD_DOKTER=pl.KD_DOKTER","left");
		$db->where(array(
			"pl.KD_PELAYANAN"=>$kd_pelayanan,
			"pl.KD_PUSKESMAS"=>$kd_puskesmas,
			"plobat.STATUS"=>1
		));
		$db->where("
				CASE WHEN
					pl.KD_DOKTER IS NOT NULL
					THEN dok.KD_PUSKESMAS = '".$this->session->userdata('kd_puskesmas')."'
					ELSE 1
				END
			",NULL,FALSE);

		$meds = $db->get()->result();
		if($meds){
			$rekam_medis = substr($meds[0]->KD_PASIEN,-7);


			$pdf = $this->resep_pdf;
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont("Arial","B",16);
			$pdf->keyValue("Puskesmas",$this->session->userdata("puskesmas"));
			$pdf->keyValue("No. Resep",$meds[0]->NO_RESEP);
			$pdf->keyValue("Rekam Medis#",$rekam_medis);
			$pdf->keyValue("Nama",$meds[0]->NAMA_LENGKAP);
			$pdf->keyValue("Umur",$meds[0]->umur);
			$pdf->keyValue("Alamat",$meds[0]->ALAMAT);
			$pdf->keyValue("Petugas",$meds[0]->NAMA_PETUGAS);
			$pdf->keyValue("Tgl Pelayanan",Date("d-m-Y",strtotime($meds[0]->TGL_PELAYANAN)));
			$pdf->Ln("4");
			$pdf->fullLine(111);

			$height=9;
			$pdf->tabValue("No.","Obat","Dosis","Qty","C");
			$pdf->fullLine(124);
			$count = 0;
			$pdf->SetFont("Arial","",14);
			foreach($meds as $m){
				$count++;
				$pdf->tabValue($count, $m->NAMA_OBAT, $m->DOSIS, $m->JUMLAH);
			}
			$pdf->Output();
		}else{
			die("Daftar obat pasien tidak ditemukan. Pastikan obat telah diposting.");
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
	
	
	public function checkkomentar()
	{
		$db = $this->load->database('sikda',true);
		$pelayanan = $db->query("select KD_PELAYANAN,KD_PASIEN,KD_PUSKESMAS from pelayanan where KD_PELAYANAN='".$this->input->get('id1')."'")->row();//print_r($pelayanan);die;
		$data['data'] = $pelayanan;
		$this->load->view('t_apotik/v_t_check',$data);
	}
	
	public function lihatcheck()
	{
		$db = $this->load->database('sikda',true);
		$db->trans_begin();
		$db->set('STATUS_LAYANAN',0);
		$db->where('KD_PELAYANAN',$this->input->get('id1'));
		$db->update('pelayanan');
		$db->trans_commit();
		$pelayanan = $db->query("select CATATAN_DOKTER from check_coment where KD_PELAYANAN='".$this->input->get('id1')."'")->row();
		//echo("<script type='text/javascript'> function message(){alert(".$pelayanan->CATATAN_DOKTER.")};</script>");
		$data['data'] = $pelayanan;
		$this->load->view('t_apotik/v_t_lihatcheck',$data);
	}
	
	public function checkkomentar1()
	{
		$db = $this->load->database('sikda',true);
		$db->trans_begin();
		$check = $db->query("select CATATAN_APOTEK from check_coment where KD_PELAYANAN='".$this->input->post('kd_pelayanan')."'")->row();
		if(!empty($check)){
			$datakoment = array(
				'CATATAN_APOTEK' => $this->input->post('komentar')
			);
			$db->where('KD_PELAYANAN',$this->input->post('kd_pelayanan'));
			$db->update('check_coment',$datakoment);
		}else{
			$datakoment = array(
				'CATATAN_APOTEK' => $this->input->post('komentar'),
				'KD_PELAYANAN' => $this->input->post('kd_pelayanan'),
				'KD_PASIEN' => $this->input->post('kd_pasien'),
				'KD_PUSKESMAS' => $this->input->post('kd_puskesmas')
			);
			$db->insert('check_coment',$datakoment);
		}
		if ($db->trans_status() === FALSE)
		{
			$db->trans_rollback();
			die('Maaf Proses Posting Data Gagal');
		}
		else
		{
			$db->trans_commit();
			die(json_encode('OK'));
		}
	}
	
	public function check()
	{
		$db=$this->load->database('sikda',true);
		$kd_puskesmas=$this->input->post('id3')?$this->input->post('id3'):$this->session->userdata('kd_puskesmas');
		$id=$this->input->post('id1');
		$idpasien=$this->input->post('id2');
		$db->trans_begin();
		$db->set('STATUS_LAYANAN','5');
		$db->where('KD_PUSKESMAS',$kd_puskesmas);
		$db->where('KD_PELAYANAN',$id);
		$db->update('pelayanan');
		
		$db->set('STATUS','5');
		$db->where('KD_PUSKESMAS',$kd_puskesmas);
		$db->where('KD_PELAYANAN',$id);
		$db->where('KD_PASIEN',$idpasien);
		$db->update('kunjungan');//print_r($db->last_query());die;
		if ($db->trans_status() === FALSE)
		{
			$db->trans_rollback();
			die('Maaf Proses Posting Data Gagal');
		}
		else
		{
			$db->trans_commit();
			die(json_encode('OK'));
		}
	}
	
}

/* End of file t_apotik.php */
/* End of file t_apotik.php */
/* End of file t_apotik.php */
/* End of file t_apotik.php */
/* Location: ./application/controllers/t_apotik.php */
