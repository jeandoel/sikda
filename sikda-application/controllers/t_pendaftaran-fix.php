<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_pendaftaran extends CI_Controller {
	public function index()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_pendaftaran/v_pendaftaran');
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function t_pendaftaranxml()
	{		
		$this->load->model('t_pendaftaran_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari')
					);
					
		$total = $this->t_pendaftaran_model->totalT_pendaftaran($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),
					'keyword'=>$this->input->post('keyword'),
					'cari'=>$this->input->post('cari')
					);
		
		if($this->input->post('usergabung')) $params['usergabung']=$this->input->post('usergabung',TRUE);
					
		$result = $this->t_pendaftaran_model->getT_pendaftaran($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function t_pendaftaranantrianxml()
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
	
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function add()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_pendaftaran/v_t_pendaftaran_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('tanggal_lahir', 'Tanggal Lahir', 'trim|required|myvalid_date');		
		$val->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required|xss_clean');
		$val->set_rules('tanggal_daftar', 'Tanggal Daftar', 'trim|required|myvalid_date');
		$val->set_rules('tempat_lahir', 'Tempat Lahir', 'trim|required|xss_clean');
		$val->set_rules('jenis_kelamin', 'Jenis Kelamin', 'trim|required|xss_clean');
		$val->set_rules('jenis_pasien', 'Jenis Pasien', 'trim|required|xss_clean');
		$val->set_rules('cara_bayar', 'Cara Bayar', 'trim|required|xss_clean');
		$val->set_rules('nama_kk', 'Nama KK', 'trim|required|xss_clean');
		$val->set_rules('alamat', 'Alamat', 'trim|required|xss_clean');
		
		if($this->input->post('showhide_kunjungan')){
			if($this->input->post('showhide_kunjungan')=='rawat_jalan'){
				$val->set_rules('unit_layanan', 'Unit Layanan', 'trim|required|xss_clean');
				$val->set_rules('poliklinik', 'Poliklinik', 'trim|required|xss_clean');
			}elseif($this->input->post('showhide_kunjungan')=='rawat_inap'){
				$val->set_rules('spesialisasi', 'Spesialisasi', 'trim|required|xss_clean');
				/*$val->set_rules('ruangan', 'Ruangan', 'trim|required|xss_clean');
				$val->set_rules('kelas', 'Kelas', 'trim|required|xss_clean');
				$val->set_rules('kamar', 'Kamar', 'trim|required|xss_clean');*/
			}else{
				$val->set_rules('unit_layanan', 'Unit Layanan', 'trim|required|xss_clean');
			}
		}
		
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
			$max = $db->query("SELECT MAX(SUBSTR(kd_pasien,-7)) AS total FROM pasien where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
			$max = $max->total + 1;
			$dataexc = array(
				'NAMA_LENGKAP' => $val->set_value('nama_lengkap'),
				'KD_CUSTOMER' => $val->set_value('jenis_pasien'),
				'KD_PASIEN'=> $this->session->userdata('kd_puskesmas').sprintf("%07d", $max),
				'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
				'NO_PENGENAL' => $this->input->post('nik')?$this->input->post('nik',TRUE):'',
				'KD_KABKOTA' => $this->input->post('kabupaten_kota')?$this->input->post('kabupaten_kota',TRUE):'',
				'KD_KECAMATAN' => $this->input->post('kecamatan')?$this->input->post('kecamatan',TRUE):'',
				'KD_KELURAHAN' => $this->input->post('desa_kelurahan')?$this->input->post('desa_kelurahan',TRUE):'',
				'KD_POS' => $this->input->post('kode_pos')?$this->input->post('kode_pos',TRUE):'',
				'TELEPON' => $this->input->post('no_tlp')?$this->input->post('no_tlp',TRUE):'',
				'HP' => $this->input->post('no_hp')?$this->input->post('no_hp',TRUE):'',
				'KD_PENDIDIKAN' => $this->input->post('pendidikan_akhir')?$this->input->post('pendidikan_akhir',TRUE):'',
				'KD_PEKERJAAN' => $this->input->post('pekerjaan')?$this->input->post('pekerjaan',TRUE):'',
				'KD_AGAMA' => $this->input->post('agama')?$this->input->post('agama',TRUE):'',
				'STATUS_MARITAL' => $this->input->post('status_nikah')?$this->input->post('status_nikah',TRUE):'',
				'KD_GOL_DARAH' => $this->input->post('gol_darah')?$this->input->post('gol_darah',TRUE):'',
				'KD_RAS' => $this->input->post('ras_suku')?$this->input->post('ras_suku',TRUE):'',
				'NAMA_AYAH' => $this->input->post('nama_ayah')?$this->input->post('nama_ayah',TRUE):'',
				'NAMA_IBU' => $this->input->post('nama_ibu')?$this->input->post('nama_ibu',TRUE):'',
				//'RINCIAN_PENANGGUNG' => $this->input->post('rincian_penangggung')?$this->input->post('rincian_penangggung',TRUE):'',
				'NAMA_KLG_LAIN' => $this->input->post('pic')?$this->input->post('pic',TRUE):'',
				'KET_WIL' => $this->input->post('wilayah')?$this->input->post('wilayah',TRUE):'',
				'CARA_BAYAR' => $val->set_value('cara_bayar'),
				'KK' => $val->set_value('nama_kk'),
				'TEMPAT_LAHIR' => $val->set_value('tempat_lahir'),
				'TGL_LAHIR' => $val->set_value('tanggal_lahir'),
				'TGL_LAHIR' => $val->set_value('tanggal_lahir'),
				'ALAMAT' => $val->set_value('alamat'),
				'KD_PROVINSI' => $this->input->post('provinsi')?$this->input->post('provinsi',TRUE):'',
				'KD_JENIS_KELAMIN' => $val->set_value('jenis_kelamin'),
				'TGL_PENDAFTARAN' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tanggal_daftar')))),
				'TGL_LAHIR' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tanggal_lahir')))),
				'PETUGAS2' => $this->input->post('petugas2')?$this->input->post('petugas2',TRUE):'',
				'Created_By' => $this->session->userdata('user_name'),
				'Created_Date' => date('Y-m-d H:i:s')
			);
			
			$db->insert('pasien', $dataexc);
			
			if($this->input->post('showhide_kunjungan')){
				$dataexckujungan = array(
					'KD_PASIEN'=> $this->session->userdata('kd_puskesmas').sprintf("%07d", $max),
					'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
					'KD_DOKTER' => $this->session->userdata('kd_petugas'),
					'TGL_MASUK' => date('Y-m-d'),
					
				);			
				$this->daftarkunjunganprocessfunction($db,$dataexckujungan);
			}
			
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
	
	public function daftarkunjunganprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		if($this->input->post('showhide_kunjungan')){
			if($this->input->post('showhide_kunjungan')=='rawat_jalan'){
				$val->set_rules('unit_layanan', 'Unit Layanan', 'trim|required|xss_clean');
				$val->set_rules('poliklinik', 'Poliklinik', 'trim|required|xss_clean');
			}elseif($this->input->post('showhide_kunjungan')=='rawat_inap'){
				$val->set_rules('spesialisasi', 'Spesialisasi', 'trim|required|xss_clean');
				/*$val->set_rules('ruangan', 'Ruangan', 'trim|required|xss_clean');
				$val->set_rules('kelas', 'Kelas', 'trim|required|xss_clean');
				$val->set_rules('kamar', 'Kamar', 'trim|required|xss_clean');*/
			}else{
				$val->set_rules('unit_layanan', 'Unit Layanan', 'trim|required|xss_clean');
			}
		}
		
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
				'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
				'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
				'PETUGAS2' => $this->input->post('petugas2')?$this->input->post('petugas2',TRUE):'',
				'KD_DOKTER' => $this->session->userdata('kd_petugas'),
				'TGL_MASUK' => date('Y-m-d'),
				
			);
			
			$this->daftarkunjunganprocessfunction($db,$dataexc);
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
	
	function daftarkunjunganprocessfunction($db,$datainsert)
	{
			if($this->input->post('showhide_kunjungan')){
				$puskesmas = $this->input->post('kd_puskesmas_hidden')?$this->input->post('kd_puskesmas_hidden',TRUE):$this->session->userdata('kd_puskesmas');
				if($this->input->post('showhide_kunjungan')=='rawat_jalan'){
					$max = $db->query("select max(URUT_MASUK) as total from kunjungan where KD_PUSKESMAS='".$puskesmas."' and KD_UNIT='".$this->input->post('poliklinik',TRUE)."' ")->row();
					$max = $max->total + 1;
					$datainsert['KD_UNIT_LAYANAN'] = $this->input->post('unit_layanan',TRUE);
					$datainsert['KD_UNIT'] = $this->input->post('poliklinik',TRUE);
					$kdk = date('Y-m-d').'-'.$this->input->post('poliklinik',TRUE).'-'.$max;
					$datainsert['KD_KUNJUNGAN'] = $kdk;
					$datainsert['URUT_MASUK'] = $max;
					$datainsert['KD_LAYANAN_B'] = 'RJ';
				}elseif($this->input->post('showhide_kunjungan')=='rawat_inap'){
					$max = $db->query("select max(URUT_MASUK) as total from kunjungan where KD_PUSKESMAS='".$puskesmas."' and KD_UNIT='".$this->input->post('spesialisasi',TRUE)."' ")->row();
					$max = $max->total + 1;
					$datainsert['KD_UNIT'] = $this->input->post('spesialisasi',TRUE);
					$kdk = date('Y-m-d').'-'.$this->input->post('spesialisasi',TRUE).'-'.$max;
					$datainsert['KD_KUNJUNGAN'] = $kdk;
					$datainsert['URUT_MASUK'] = $max;
					$datainsert['KD_LAYANAN_B'] = 'RI';
					/*$val->set_rules('spesialisasi', 'Spesialisasi', 'trim|required|xss_clean');
					$val->set_rules('ruangan', 'Ruangan', 'trim|required|xss_clean');
					$val->set_rules('kelas', 'Kelas', 'trim|required|xss_clean');
					$val->set_rules('kamar', 'Kamar', 'trim|required|xss_clean');*/
				}else{
					$datainsert['KD_UNIT_LAYANAN'] = $this->input->post('unit_layanan',TRUE);
					$kdk = date('Y-m-d').'-'.$max;
					$datainsert['KD_KUNJUNGAN'] = $kdk;
					$datainsert['URUT_MASUK'] = $max;
					$datainsert['KD_LAYANAN_B'] = 'RD';
				}
			}
		$db->insert('kunjungan',$datainsert);
	}	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
	public function ubahkunjungan()
	{
		
		// IF UNIT THEN VIEW ACCORDING TO SELECTED UNIT
		// IF UNIT THEN VIEW ACCORDING TO SELECTED UNIT
		// IF UNIT THEN VIEW ACCORDING TO SELECTED UNIT
		
		$this->load->helper('beries_helper');
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$id2=$this->input->get('id2')?$this->input->get('id2',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("k.KD_KUNJUNGAN,NAMA_LENGKAP AS NAMA_PASIEN,k.KD_UNIT_LAYANAN,k.KD_UNIT,k.KD_DOKTER,k.KD_PUSKESMAS",FALSE);
		$db->from('kunjungan k');
		$db->join('pasien p','k.KD_PASIEN=p.KD_PASIEN');
		//$db->join('mst_unit u','k.KD_UNIT=p.KD_UNIT');
		$db->where('k.KD_KUNJUNGAN ',$id);
		$db->where('k.KD_PUSKESMAS',$id2);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('t_pendaftaran/v_t_pendaftaran_edit_kunjungan',$data);
	}	
	public function ubahkunjunganprocess()
	{
		$id = $this->input->post('id',TRUE);
		$kd_puskesmas = $this->input->post('kd_puskesmas',TRUE);
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('unit_layanan', 'Unit Layanan', 'trim|required|xss_clean');
		$val->set_rules('poliklinik', 'Poliklinik', 'trim|required|xss_clean');

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
				'KD_UNIT_LAYANAN' => $val->set_value('unit_layanan'),
				'KD_UNIT' => $val->set_value('poliklinik'),
				'Modified_By' => $this->session->userdata('user_name'),
				'Modified_Date' => date('Y-m-d H:i:s')
			);			
			
			$db->where('KD_KUNJUNGAN',$id);
			$db->where('KD_PUSKESMAS',$kd_puskesmas);
			$db->update('kunjungan', $dataexc);
			
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
	
	public function gabungprocess()
	{
		$kdpasien1 = $this->input->post('kd_pasien_hidden',TRUE);
		$kdpasien2 = $this->input->post('kd_pasien_selected_hidden',TRUE);
		$kdpuskesmas1 = $this->input->post('kd_puskesmas_hidden',TRUE);		
		$kdpuskesmas2 = $this->input->post('kd_puskesmas_selected_hidden',TRUE);	
		$selectedparent = $this->input->post('id_gabung',TRUE);	
		
		if(!$kdpasien2) die('Silahkan Pilih Pasien yang akan di Gabung');
		
		$db = $this->load->database('sikda', TRUE);
		$db->trans_begin();
		
		$queryGetAllTTable = " SELECT DISTINCT  TABLE_NAME";
		$queryGetAllTTable .= " FROM INFORMATION_SCHEMA.COLUMNS";
		$queryGetAllTTable .= " WHERE COLUMN_NAME IN ('KD_PASIEN') and TABLE_NAME not like 'vw_%' and TABLE_NAME not in ('pasien')";
		$queryGetAllTTable .= " AND TABLE_SCHEMA='".$db->database."'";
	   
		$query = $db->query($queryGetAllTTable);
		if ($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$selectedchild = $kdpasien1==$selectedparent?$kdpasien2:$kdpasien1;
				$queryExecute = "UPDATE ".$row->TABLE_NAME." SET KD_PASIEN = '".$selectedparent."' WHERE KD_PASIEN = '".$selectedchild."'";
				$db->query($queryExecute);			  
			}
		}else{
			die('Proses Gagal Mohon di Ulangi');
		}
		
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
	
	public function batalkunjunganprocess()
	{
		$id = $this->input->post('id',TRUE);		
		$kd_puskesmas = $this->input->post('kd_puskesmas',TRUE);		
		$this->load->library('form_validation');
		$db = $this->load->database('sikda', TRUE);
		$db->trans_begin();
		
		$db->where('KD_KUNJUNGAN',$id);
		$db->where('KD_PUSKESMAS',$kd_puskesmas);
		$db->delete('kunjungan');
		
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
	
	public function pendaftaranpelayanan()
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
		$this->load->view('t_pendaftaran/v_t_pendaftaran_pelayanan',$data);
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
		$this->load->view('t_pendaftaran/v_t_pendaftaran_gabung',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		if($db->query("delete from tbl_t_pendaftaran where nid_t_pendaftaran = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("u.*, m.ncolumn1 as nmastercolumn1");
		$db->from('tbl_t_pendaftaran u');
		$db->join('tbl_master1 m','m.nid_master1=u.nmaster_1_id');
		$db->where('u.nid_t_pendaftaran ',$id);
		$val = $db->get()->row();
		$data['data']=$val;
		$this->load->view('t_pendaftaran/t_pendaftarandetail',$data);
	}
	
	public function rawatjalan()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_pendaftaran/v_kunjungan_rawatjalan');
	}
	
	public function rawatinap()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_pendaftaran/v_kunjungan_rawatinap');
	}
	
	public function ugd()
	{
		$this->load->helper('beries_helper');
		$this->load->view('t_pendaftaran/v_kunjungan_ugd');
	}
	
	/*public function coba()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('default', TRUE);
		$a = $db->query("select * from ADM_T_USER where ID = 81");
		$val = $a->result_object();
		
		echo '<pre>';print_r($val);die;
	}*/
	
}

/* End of file t_pendaftaran.php */
/* Location: ./application/controllers/t_pendaftaran.php */