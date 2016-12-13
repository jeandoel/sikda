<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_masters extends CI_Controller {
	public function index()
	{
		echo 'index';
	}
	
	public function getKabupatenByProvinceID()
	{
		$this->load->model('t_masters_model');
		$kab = $this->input->get('kabedit')?$this->input->get('kabedit'):'';
		$resultarray = $this->t_masters_model->getKabupatenByProvinceID($this->input->get('provinsit_pendaftaranadd',TRUE));
		
		$result = array();
		$result[0]= '- Silahkan Pilih -';
		if($resultarray->num_rows >0){
			foreach ($resultarray->result() as $row)
			{
				if($row->KD_KABUPATEN==$this->session->userdata('kd_kabupaten')){
					$result[$row->KD_KABUPATEN] = $row->KABUPATEN;
					if($kab){
						$result['selected'] = $kab;
					}else{
						$result['selected'] = $this->session->userdata('kd_kabupaten');
					}
				}else{
					$result[$row->KD_KABUPATEN] = $row->KABUPATEN;
				}				
			}
		}else{
			$result['nodata']= '- Data Tidak Ditemukan -';
		}//print_r($result);die;
        die(json_encode($result));		
	}
	
	public function getKabupatenByProvinceID2()
	{
		$this->load->model('t_masters_model');
		$getid='';
		if($this->input->get('provinsirmh_sehatadd')){
			$getid = $this->input->get('provinsirmh_sehatadd',TRUE);
		}
		if($this->input->get('provinsisanitasi_rmadd')){
			$getid = $this->input->get('provinsisanitasi_rmadd',TRUE);
		}
		if($this->input->get('provinsiinspeksi_pasaradd')){
			$getid = $this->input->get('provinsiinspeksi_pasaradd',TRUE);
		}
		if($this->input->get('provinsikesehatan_hoteladd')){
			$getid = $this->input->get('provinsikesehatan_hoteladd',TRUE);
		}
		$resultarray = $this->t_masters_model->getKabupatenByProvinceID($getid);
		
		$result = array();
		
		if($resultarray->num_rows >0){
			foreach ($resultarray->result() as $row)
			{
				if($row->KD_KABUPATEN==$this->session->userdata('kd_kabupaten')){
					$result[$row->KD_KABUPATEN] = $row->KABUPATEN;
					$result['selected'] = $this->session->userdata('kd_kabupaten');
				}else{
					$result[$row->KD_KABUPATEN] = $row->KABUPATEN;
				}				
			}
		}else{
			$result['nodata']= '- Data Tidak Ditemukan -';
		}//print_r($result);die;
        die(json_encode($result));		
	}
	
	public function getKabupatenByProvinceID3()
	{
		$this->load->model('t_masters_model');
		$getid='';
		if($this->input->get('kab_id_combo_ds_gigi')){
			$getid = $this->input->get('kab_id_combo_ds_gigi',TRUE);
		}
		$resultarray = $this->t_masters_model->getKabupatenByProvinceID($getid);
		
		$result = array();
		
		if($resultarray->num_rows >0){
			foreach ($resultarray->result() as $row)
			{
				if($row->KD_KABUPATEN==$this->session->userdata('kd_kabupaten')){
					$result[$row->KD_KABUPATEN] = $row->KABUPATEN;
					$result['selected'] = $this->session->userdata('kd_kabupaten');
				}else{
					$result[$row->KD_KABUPATEN] = $row->KABUPATEN;
				}				
			}
		}else{
			$result['nodata']= '- Data Tidak Ditemukan -';
		}//print_r($result);die;
        die(json_encode($result));		
	}
	
	/////////////////////////////////////////////////////////////////////////////amin
	public function getPuskesmasByKecamatanId()
	{
		$this->load->model('t_masters_model');
		
		$resultarray = $this->t_masters_model->getPuskesmasByKecamatanId($this->input->get('kecamatant_pendaftaranadd',TRUE));
		
		$result = array();
		$result[0]= '- silahkan Pilih -';
		if($resultarray->num_rows >0){
			foreach ($resultarray->result() as $row)
			{
				$result[$row->KD_PUSKESMAS]= $row->PUSKESMAS;
			}
		}else{
			$result['nodata']= '- Data Tidak Ditemukan -';
		}
		
        die(json_encode($result));		
	}
	
	public function getPuskesmasByKecamatanId2()
	{
		$this->load->model('t_masters_model');
		
		$getid='';
		
		if($this->input->get('kec_id_combo_ds_gigi')){
			$getid = $this->input->get('kec_id_combo_ds_gigi',TRUE);
		}
		if($this->input->get('kec_id_combo_ds_uks')){
			$getid = $this->input->get('kec_id_combo_ds_uks',TRUE);
		}
		if($this->input->get('kec_id_combo_ds_datadasar')){
			$getid = $this->input->get('kec_id_combo_ds_datadasar',TRUE);
		}
		if($this->input->get('kec_id_combo_ds_kia')){
			$getid = $this->input->get('kec_id_combo_ds_kia',TRUE);
		}
		if($this->input->get('kec_id_combo_ds_kesling')){
			$getid = $this->input->get('kec_id_combo_ds_kesling',TRUE);
		}
		if($this->input->get('kec_id_combo_ds_kb')){
			$getid = $this->input->get('kec_id_combo_ds_kb',TRUE);
		}
		if($this->input->get('kec_id_combo_ds_imunisasi')){
			$getid = $this->input->get('kec_id_combo_ds_imunisasi',TRUE);
		}
		if($this->input->get('kec_id_combo_ds_gizi')){
			$getid = $this->input->get('kec_id_combo_ds_gizi',TRUE);
		}
		if($this->input->get('kec_id_combo_ds_kegiatanpuskesmas')){
			$getid = $this->input->get('kec_id_combo_ds_kegiatanpuskesmas',TRUE);
		}
		if($this->input->get('kec_id_combo_ds_promkes')){
			$getid = $this->input->get('kec_id_combo_ds_promkes',TRUE);
		}
		if($this->input->get('kec_id_combo_ds_ukgs')){
			$getid = $this->input->get('kec_id_combo_ds_ukgs',TRUE);
		}
		if($this->input->get('kec_id_combo_ds_kematian_ibu')){
			$getid = $this->input->get('kec_id_combo_ds_kematian_ibu',TRUE);
		}
		if($this->input->get('kec_id_combo_ds_kematian_anak')){
			$getid = $this->input->get('kec_id_combo_ds_kematian_anak',TRUE);
		}
		
		$resultarray = $this->t_masters_model->getPuskesmasByKecamatanId($getid);
		
		$result = array();
		
		if($resultarray->num_rows >0){
			foreach ($resultarray->result() as $row)
			{
				$result[$row->KD_PUSKESMAS]= $row->PUSKESMAS;
			}
		}else{
			$result['nodata']= '- silahkan pilih -';
		}
		
        die(json_encode($result));		
	}
	
	public function getPustuByKecamatanId()
	{
		$this->load->model('t_masters_model');
		
		$resultarray = $this->t_masters_model->getPustuByKecamatanId($this->input->get('kecamatant_pendaftaranadd',TRUE));

		$result = array();
		
		if($resultarray->num_rows >0){
			foreach ($resultarray->result() as $row)
			{
				$result[$row->KD_SUB_LEVEL]= $row->NAMA_SUB_LEVEL;
			}
		}else{
			$result['nodata']= '- Data Tidak Ditemukan -';
		}
		
        die(json_encode($result));		
	}
	
	public function getPolindesByKecamatanId()
	{
		$this->load->model('t_masters_model');
		
		$resultarray = $this->t_masters_model->getPolindesByKecamatanId($this->input->get('kecamatant_pendaftaranadd',TRUE));
		
		$result = array();
		
		if($resultarray->num_rows >0){
			foreach ($resultarray->result() as $row)
			{
				$result[$row->KD_SUB_LEVEL]= $row->NAMA_SUB_LEVEL;
			}
		}else{
			$result['nodata']= '- Data Tidak Ditemukan -';
		}
		
        die(json_encode($result));		
	}
	
	public function getBidandesaByKecamatanId()
	{
		$this->load->model('t_masters_model');
		
		$resultarray = $this->t_masters_model->getBidandesaByKecamatanId($this->input->get('kecamatant_pendaftaranadd',TRUE));
		
		$result = array();
		
		if($resultarray->num_rows >0){
			foreach ($resultarray->result() as $row)
			{
				$result[$row->KD_SUB_LEVEL]= $row->NAMA_SUB_LEVEL;
			}
		}else{
			$result['nodata']= '- Data Tidak Ditemukan -';
		}
		
        die(json_encode($result));		
	}
	
	
	public function getPuslingByKecamatanId()
	{
		$this->load->model('t_masters_model');
		
		$resultarray = $this->t_masters_model->getPuslingByKecamatanId($this->input->get('kecamatant_pendaftaranadd',TRUE));
		
		$result = array();
		
		if($resultarray->num_rows >0){
			foreach ($resultarray->result() as $row)
			{
				$result[$row->KD_SUB_LEVEL]= $row->NAMA_SUB_LEVEL;
			}
		}else{
			$result['nodata']= '- Data Tidak Ditemukan -';
		}
		
        die(json_encode($result));		
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function getKecamatanByKabupatenID()
	{
		$this->load->model('t_masters_model');
		$kec = $this->input->get('kecedit')?$this->input->get('kecedit'):'';
		
		$resultarray = $this->t_masters_model->getKecamatanByKabupatenID($this->input->get('kabupaten_kotat_pendaftaranadd',TRUE));
		
		$result = array();
		$result[0]= '- Silahkan Pilih -';
		if($resultarray->num_rows >0){
			foreach ($resultarray->result() as $row)
			{
				if($row->KD_KECAMATAN==$this->session->userdata('kd_kecamatan')){
					$result[$row->KD_KECAMATAN] = $row->KECAMATAN;
					if($kec){
						$result['selected'] = $kec;
					}else{
						$result['selected'] = $this->session->userdata('kd_kecamatan');
					}
				}else{
					$result[$row->KD_KECAMATAN]= $row->KECAMATAN;
				}
			}
		}else{
			$result['nodata']= '- Data Tidak Ditemukan -';
		}
		
        die(json_encode($result));		
	}
	
	public function getKecamatanByKabupatenID2()
	{
		$this->load->model('t_masters_model');
		$getid='';
		if($this->input->get('kabupaten_kotarmh_sehatadd')){
			$getid = $this->input->get('kabupaten_kotarmh_sehatadd',TRUE);
		}
		if($this->input->get('kabupaten_kotasanitasi_rmadd')){
			$getid = $this->input->get('kabupaten_kotasanitasi_rmadd',TRUE);
		}
		if($this->input->get('kabupaten_kotainspeksi_pasaradd')){
			$getid = $this->input->get('kabupaten_kotainspeksi_pasaradd',TRUE);
		}
		if($this->input->get('kabupaten_kotakesehatan_hoteladd')){
			$getid = $this->input->get('kabupaten_kotakesehatan_hoteladd',TRUE);
		}
		
		$resultarray = $this->t_masters_model->getKecamatanByKabupatenID($getid);
		
		$result = array();
		
		if($resultarray->num_rows >0){
			foreach ($resultarray->result() as $row)
			{
				if($row->KD_KECAMATAN==$this->session->userdata('kd_kecamatan')){
					$result[$row->KD_KECAMATAN] = $row->KECAMATAN;
					$result['selected'] = $this->session->userdata('kd_kecamatan');
				}else{
					$result[$row->KD_KECAMATAN]= $row->KECAMATAN;
				}
			}
		}else{
			$result['nodata']= '- Data Tidak Ditemukan -';
		}
		
        die(json_encode($result));		
	}
	
	public function getKelurahanByKecamatanID()
	{
		$this->load->model('t_masters_model');
		$kel = $this->input->get('keledit')?$this->input->get('keledit'):'';
		//die($kel);
		$resultarray = $this->t_masters_model->getKelurahanByKecamatanID($this->input->get('kecamatant_pendaftaranadd',TRUE));
		
		$result = array();
		
		if($resultarray->num_rows >0){
			foreach ($resultarray->result() as $row)
			{
				if($row->KELURAHAN==$this->session->userdata('puskesmas')){
					$result[$row->KD_KELURAHAN] = $row->KELURAHAN;
					if($kel){
						$result['selected'] = $kel;
					}else{
						$result['selected'] = $this->session->userdata('kd_kelurahan');
					}
				}else{
					$result[$row->KD_KELURAHAN]= $row->KELURAHAN;
				}
			}
		}else{
			$result['nodata']= '- Data Tidak Ditemukan -';
		}
		
        die(json_encode($result));		
	}
	
	public function getKelurahanByKecamatanID2()
	{
		$this->load->model('t_masters_model');
		$getid='';
		
		if($this->input->get('kecamatanrmh_sehatadd')){
			$getid = $this->input->get('kecamatanrmh_sehatadd',TRUE);
		}
		if($this->input->get('kecamatansanitasi_rmadd')){
			$getid = $this->input->get('kecamatansanitasi_rmadd',TRUE);
		}
		if($this->input->get('kecamataninspeksi_pasaradd')){
			$getid = $this->input->get('kecamataninspeksi_pasaradd',TRUE);
		}
		if($this->input->get('kecamatankesehatan_hoteladd')){
			$getid = $this->input->get('kecamatankesehatan_hoteladd',TRUE);
		}
		if($this->input->get('kec_id_combo')){
			$getid = $this->input->get('kec_id_combo',TRUE);
		}
		
		$resultarray = $this->t_masters_model->getKelurahanByKecamatanID($getid);
		
		$result = array();
		
		if($resultarray->num_rows >0){
			foreach ($resultarray->result() as $row)
			{
				if($row->KELURAHAN==$this->session->userdata('puskesmas')){
					$result[$row->KD_KELURAHAN] = $row->KELURAHAN;
					$result['selected'] = $this->session->userdata('kd_kelurahan');
				}else{
					$result[$row->KD_KELURAHAN]= $row->KELURAHAN;
				}
			}
		}else{
			$result['nodata']= '- Data Tidak Ditemukan -';
		}
		
        die(json_encode($result));		
	}
	
	public function getKelurahanByKecamatanID3()
	{
		$this->load->model('t_masters_model');
		$getid='';
		
		if($this->input->get('kec_id_combo_ds_gigi')){
			$getid = $this->input->get('kec_id_combo_ds_gigi',TRUE);
		}
		if($this->input->get('kec_id_combo_ds_uks')){
			$getid = $this->input->get('kec_id_combo_ds_uks',TRUE);
		}
		if($this->input->get('kec_id_combo_ds_datadasar')){
			$getid = $this->input->get('kec_id_combo_ds_datadasar',TRUE);
		}
		if($this->input->get('kec_id_combo_ds_kia')){
			$getid = $this->input->get('kec_id_combo_ds_kia',TRUE);
		}
		if($this->input->get('kec_id_combo_ds_kesling')){
			$getid = $this->input->get('kec_id_combo_ds_kesling',TRUE);
		}
		if($this->input->get('kec_id_combo_ds_kb')){
			$getid = $this->input->get('kec_id_combo_ds_kb',TRUE);
		}
		if($this->input->get('kec_id_combo_ds_imunisasi')){
			$getid = $this->input->get('kec_id_combo_ds_imunisasi',TRUE);
		}
		if($this->input->get('kec_id_combo_ds_gizi')){
			$getid = $this->input->get('kec_id_combo_ds_gizi',TRUE);
		}
		if($this->input->get('kec_id_combo_ds_kegiatanpuskesmas')){
			$getid = $this->input->get('kec_id_combo_ds_kegiatanpuskesmas',TRUE);
		}
		if($this->input->get('kec_id_combo_ds_promkes')){
			$getid = $this->input->get('kec_id_combo_ds_promkes',TRUE);
		}
		if($this->input->get('kec_id_combo_ds_ukgs')){
			$getid = $this->input->get('kec_id_combo_ds_ukgs',TRUE);
		}
		if($this->input->get('kec_id_combo_ds_kematian_ibu')){
			$getid = $this->input->get('kec_id_combo_ds_kematian_ibu',TRUE);
		}
		if($this->input->get('kec_id_combo_ds_kematian_anak')){
			$getid = $this->input->get('kec_id_combo_ds_kematian_anak',TRUE);
		}
		
		$resultarray = $this->t_masters_model->getKelurahanByKecamatanID($getid);
		
		$result = array();
		
		if($resultarray->num_rows >0){
			foreach ($resultarray->result() as $row)
			{
				if($row->KELURAHAN==$this->session->userdata('puskesmas')){
					$result[$row->KD_KELURAHAN] = $row->KELURAHAN;
					$result['selected'] = $this->session->userdata('kd_kelurahan');
				}else{
					$result[$row->KD_KELURAHAN]= $row->KELURAHAN;
				}
			}
		}else{
			$result['nodata']= '- silahkan pilih -';
		}
		
        die(json_encode($result));		
	}
	
	public function getNoKamarByNamaKamar()
	{
		$this->load->model('t_masters_model');
		$getid='';
		
		if($this->input->get('kamart_pendaftaranpelayanan')){
			$getid = $this->input->get('kamart_pendaftaranpelayanan',TRUE);
		}
		
		$resultarray = $this->t_masters_model->getNoKamarByNamaKamar($getid);
		
		$result = array();
		
		if($resultarray->num_rows >0){
			foreach ($resultarray->result() as $row)
			{
				$result[$row->NO_KAMAR]= $row->NO_KAMAR;
			}
		}else{
			$result['nodata']= '- silahkan pilih -';
		}
		
        die(json_encode($result));		
	}
	
	public function getNoBedByNoKamar()
	{
		$this->load->model('t_masters_model');
		$getid='';
		
		if($this->input->get('nokamart_pendaftaranpelayanan')){
			$getid = $this->input->get('nokamart_pendaftaranpelayanan',TRUE);
		}
		
		$resultarray = $this->t_masters_model->getNoBedByNoKamar($getid);
		
		$result = array();
		if($resultarray->JUMLAH_BED >0){
			for($i=1;$i<=$resultarray->JUMLAH_BED;$i++)
			{
				$result[$i]= $i;
			}
		}else{
			$result['nodata']= '- silahkan pilih -';
		}
		
        die(json_encode($result));		
	}
	
	public function getPasienDetailSubgrid()
	{
		$kd_pasien=$this->input->post('kd_pasien')?$this->input->post('kd_pasien',TRUE):null;
		$kd_puskesmas=$this->input->post('kd_puskesmas')?$this->input->post('kd_puskesmas',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("p.*,k.CUSTOMER",FALSE);
		$db->from('pasien p');
		$db->join('mst_kel_pasien k','k.KD_CUSTOMER=p.KD_CUSTOMER');
		$db->where('p.KD_PASIEN ',$kd_pasien);
		$db->where('p.KD_PUSKESMAS',$kd_puskesmas);
		$row = $db->get()->row();
		$css='style="padding:3px!important;font-size:.9em!important;border:1px solid #CCC!important;"';
		$cssth = ' style="padding:3px!important;color:#0B77B7!important;background-color:#CCC!important;font-size:.9em!important;border:1px solid #CCC!important;font-weight:bold!important"';
		$html='';
		$html.='<table width="100%" style="padding-bottom:15px!important;">';
		$html.='<tr>
				<td '.$cssth.' width="25%">NIK</td>
				<td'.$cssth.' width="25%">Tempat Tgl. Lahir</td>
				<td'.$cssth.' width="10%">Gol. Darah</td>
				<td'.$cssth.' width="15%">Jenis Pasien</td>
				<td'.$cssth.' width="10%">Cara Bayar</td>
				<td'.$cssth.' width="15%">Telepon/HP</td>
				</tr>
				';
		$html.='<tr>';				
				$html.='<td '.$css.' align="center">'.$row->NO_PENGENAL.'</td>';
				$html.='<td '.$css.' align="center">'.$row->TEMPAT_LAHIR.', '.$row->TGL_LAHIR.'</td>';
				$html.='<td '.$css.' align="center">'.$row->KD_GOL_DARAH.'</td>';
				$html.='<td '.$css.' align="center">'.$row->CUSTOMER.'</td>';
				$html.='<td '.$css.' align="center">'.$row->CARA_BAYAR.'</td>';
				$html.='<td '.$css.' align="center">'.$row->TELEPON.' '.$row->HP.'</td>';
		$html.='</tr>';
		$html.='</table>';
		die($html);
		
	}
	
	public function t_obatbyparentxml()
	{		
		$this->load->model('t_masters_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(				
					'kd_pelayanan'=>$this->input->post('kd_kunjungan'),
					'kd_puskesmas'=>$this->input->post('kd_puskesmas')
					);
					
		$total = $this->t_masters_model->totalT_obatbyparent($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),					
					'kd_pelayanan'=>$this->input->post('kd_pelayanan'),
					'kd_puskesmas'=>$this->input->post('kd_puskesmas')
					);
					
		$result = $this->t_masters_model->getT_obatbyparent($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function t_riwayatbyparentxml()
	{		
		$this->load->model('t_masters_model');
		$db = $this->load->database('sikda', TRUE);
		$id = $this->input->post('kd_pasien')?$this->input->post('kd_pasien',true):null;
		$id2= $this->input->post('kd_puskesmas')?$this->input->post('kd_puskesmas'):$this->session->userdata('kd_puskesmas');
		$id3= $this->input->post('kd_kunjungan')?$this->input->post('kd_kunjungan'):null;
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(				
					'kd_pasien'=>$this->input->post('kd_pasien'),
					'kd_puskesmas'=>$this->input->post('kd_puskesmas'),
					'kd_kunjungan'=>$id3,
					'kd_pelayanan'=>$this->input->post('kd_pelayanan')
					);
		$total = $this->t_masters_model->totalT_riwayatbyparent($paramstotal);
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
					'kd_kunjungan'=>$id3,
					'kd_pelayanan'=>$this->input->post('kd_pelayanan')
					);
					
		$unit = $db->query("select * from kunjungan where KD_KUNJUNGAN='".$id3."' and KD_UNIT=219")->row();
		if($unit){
			$db->select("kj.KD_LAYANAN_B,tk.KD_KATEGORI_KIA,tk.KD_KUNJUNGAN_KIA",FALSE);
			$db->from('kunjungan kj');
			$db->join('trans_kia tk','tk.KD_KUNJUNGAN=kj.KD_KUNJUNGAN');
			$db->where('kj.KD_PASIEN',$id);
			$db->where('kj.KD_KUNJUNGAN',$id3);
			$db->where('kj.KD_PUSKESMAS',$id2);
			$val = $db->get()->row();	//print_r($val);die;	
			if($val->KD_LAYANAN_B=='RJ' and $val->KD_KATEGORI_KIA==1 AND $val->KD_KUNJUNGAN_KIA==4){
				$result = $this->t_masters_model->getT_riwayatbyparentkb($params);		
			}elseif($val->KD_LAYANAN_B=='RJ' and $val->KD_KATEGORI_KIA==2 AND $val->KD_KUNJUNGAN_KIA==1){
				$result = $this->t_masters_model->getT_riwayatbyparentneo($params);		
			}elseif($val->KD_LAYANAN_B=='RJ' and $val->KD_KATEGORI_KIA==2 AND $val->KD_KUNJUNGAN_KIA==2){
				$result = $this->t_masters_model->getT_riwayatbyparentanak($params);		
			}else{
				$result = $this->t_masters_model->getT_riwayatbyparentother($params);		
			}
		}else{
			$result = $this->t_masters_model->getT_riwayatbyparent($params);		
		}			
		
		//print_r($this->db->last_query());die;
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function t_pasienbyparentxml()
	{		
		$this->load->model('t_masters_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(				
					'kd_pasien'=>$this->input->post('kd_pasien'),
					'kd_puskesmas'=>$this->input->post('kd_puskesmas')
					);
					
		$total = $this->t_masters_model->totalT_pasienbyparent($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),				
					'kd_pasien'=>$this->input->post('kd_pasien'),
					'kd_puskesmas'=>$this->input->post('kd_puskesmas')
					);
					
		$result = $this->t_masters_model->getT_pasienbyparent($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function getLevelByPuskesmasID()
	{
		$this->load->model('t_masters_model');
		$db = $this->load->database('sikda', TRUE);
		$data = $db->query("select a.KD_PUSKESMAS,a.LEVEL,a.KD_SUB_LEVEL,a.NAMA_SUB_LEVEL from sys_setting_def a join users b on a.KD_PUSKESMAS=b.KD_PUSKESMAS where group_id='".$this->session->userdata("group_id")."'")->row();//print_r($data);die;
		$level = $data->LEVEL; 
		//$sublevel = $data->NAMA_SUB_LEVEL; 
		$id = $data->KD_PUSKESMAS; //print_r($id);die;
		
		$resultarray = $this->t_masters_model->getLevelByPuskesmasID($id,$level);
		//print_r($id);die;
		$result = array();
		
		if($resultarray->num_rows >0){
			foreach ($resultarray->result() as $row)
			{
				$result[$row->LEVEL]= $row->LEVEL;
			}
		}else{
			$result['nodata']= '- Data Tidak Ditemukan -';
		}
		
        die(json_encode($result));		
	}
	
	public function getLevelallByPuskesmasID()
	{
		$this->load->model('t_masters_model');
		$resultarray = $this->t_masters_model->getLevelallByPuskesmasID();
		//print_r($id);die;
		$result = array();
		
		foreach ($resultarray->result() as $row)
			{
				$result[$row->LEVEL]= $row->LEVEL;
			}
		
        die(json_encode($result));		
	}

	public function getSubLevelByPuskesmas()
	{
		$this->load->model('t_masters_model');
		$level=$this->input->get('level',TRUE);
		if($level=='Posyandu'){
			$resultarray = $this->t_masters_model->getPosyanduByPuskesmas($level);
			
			$result = array();
			
			if($resultarray->num_rows >0){
				foreach ($resultarray->result() as $row)
				{
					$result[$row->ID]= $row->NAMA_POSYANDU;
				}
			}else{
				$result['nodata']= '- Data Tidak Ditemukan -';
			}
		}else{
			$resultarray = $this->t_masters_model->getSubLevelByPuskesmas($level);
			
			$result = array();
			
			if($resultarray->num_rows >0){
				foreach ($resultarray->result() as $row)
				{
					$result[$row->NAMA_SUB_LEVEL]= $row->NAMA_SUB_LEVEL;
				}
			}else{
				$result['nodata']= '- Data Tidak Ditemukan -';
			}
		}
		
        die(json_encode($result));		
	}
	
	public function getDesaByKecamatanID()
	{
		$this->load->model('t_masters_model');
		$db = $this->load->database('sikda', TRUE);
		$data = $db->query("select a.*, b.KECAMATAN from sys_setting_def a join mst_kecamatan b on a.KD_KEC=b.KD_KECAMATAN
		where kd_puskesmas='".$this->session->userdata("kd_puskesmas")."'")->row();//print_r($data);die;
		$id = $data->KD_KEC; //print_r($id);die;
		
		$resultarray = $this->t_masters_model->getDesaByKecamatanID($id);
		//print_r($resultarray);die;
		$result = array();
		
		if($resultarray->num_rows >0){
			foreach ($resultarray->result() as $row)
			{
				$result[$row->KD_KELURAHAN]= $row->KELURAHAN;
			}
		}else{
			$result['nodata']= '- Data Tidak Ditemukan -';
		}
		
        die(json_encode($result));		
	}
	
	public function t_subgrid_pasien_kipixml()
	{		
		$this->load->model('t_masters_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(				
					'kd_pasien'=>$this->input->post('kd_pasien'),
					'kd_puskesmas'=>$this->input->post('kd_puskesmas')
					);
					
		$total = $this->t_masters_model->totalT_subgrid_pasien_kipi($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'start'=>$start,
					'limit'=>$limit,
					'sort'=>$this->input->post('asc'),				
					'kd_pasien'=>$this->input->post('kd_pasien'),
					'kd_puskesmas'=>$this->input->post('kd_puskesmas')
					);
					
		$result = $this->t_masters_model->getT_subgrid_pasien_kipi($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function getLevelBySaranaPuskesmasID()
	{
		$this->load->model('t_masters_model');
		$db = $this->load->database('sikda', TRUE);
		$data = $db->query("select a.KD_PUSKESMAS,a.LEVEL,a.KD_SUB_LEVEL,a.NAMA_SUB_LEVEL from sys_setting_def a join users b on a.KD_PUSKESMAS=b.KD_PUSKESMAS where group_id='".$this->session->userdata("group_id")."'")->row();//print_r($data);die;
		$level = $data->LEVEL; 
		//$sublevel = $data->NAMA_SUB_LEVEL; 
		$id = $data->KD_PUSKESMAS; //print_r($id);die;
		
		$resultarray = $this->t_masters_model->getLevelByPuskesmasID($id,$level);
		//print_r($id);die;
		$result = array();
		
		if($resultarray->num_rows >0){
			foreach ($resultarray->result() as $row)
			{
				$result[$row->LEVEL]= $row->LEVEL;
			}
		}else{
			$result['nodata']= '- Data Tidak Ditemukan -';
		}
		
        die(json_encode($result));			
	}
	
	public function getLevelallBySaranaPuskesmasID()
	{
		$this->load->model('t_masters_model');
		$resultarray = $this->t_masters_model->getLevelallByPuskesmasID();
		//print_r($id);die;
		$result = array();
		
		foreach ($resultarray->result() as $row)
			{
				$result[$row->LEVEL]= $row->LEVEL;
			}
		
        die(json_encode($result));		
	}
	
	public function getSubLevelBySaranaPuskesmas()
	{
		$this->load->model('t_masters_model');
		$level=$this->input->get('level_sarana',TRUE);
		$resultarray = $this->t_masters_model->getSubLevelByPuskesmas($level);
		
		$result = array();
		
		if($resultarray->num_rows >0){
			foreach ($resultarray->result() as $row)
			{
				$result[$row->NAMA_SUB_LEVEL]= $row->NAMA_SUB_LEVEL;
			}
		}else{
			$result['nodata']= '- Data Tidak Ditemukan -';
		}
		
        die(json_encode($result));		
	}
	
	
}

/* End of file t_pendaftaran.php */
/* Location: ./application/controllers/t_pendaftaran.php */