<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_imunisasi_dg extends CI_Controller {
	
	public function index()
	{
		echo('index');
	}
	
	public function get_imu()
	{
		$db = $this->load->database('sikda',true);
		$this->load->helper('beries_helper');
		$this->load->helper('sigit_helper');
		$this->load->helper('my_helper');
		$kdpasien = $this->input->get('kdpasien');
		$val = $db->query("select b.KD_FAMILY_FOLDER FROM pasien a join family_folder b on a.ID_FAMILY_FOLDER=b.ID_FAMILY_FOLDER where a.KD_PASIEN='".$kdpasien."'")->row();
		$namasuami = $db->query("select NAMA_LENGKAP AS NAMA_SUAMI FROM pasien a join family_folder b on a.ID_FAMILY_FOLDER=b.ID_FAMILY_FOLDER where b.KD_FAMILY_FOLDER='".$val->KD_FAMILY_FOLDER."' and b.KD_STATUS_KELUARGA=1")->row();
		$namaibu = $db->query("select NAMA_LENGKAP AS NAMA_IBU FROM pasien a join family_folder b on a.ID_FAMILY_FOLDER=b.ID_FAMILY_FOLDER where b.KD_FAMILY_FOLDER='".$val->KD_FAMILY_FOLDER."' and b.KD_STATUS_KELUARGA=2")->row();
		$data['datasuami']=$namasuami;
		$data['dataibu']=$namaibu;
		$this->load->view('t_imunisasi_dg/v_t_pelayanan_imunisasi_dg',$data);
	}

	public function processimunisasi()
	{
		$this->load->library('form_validation');
		$val = $this->form_validation;
		$val->set_rules('tanggal_periksa','Tanggal Pelayanan','trim|myvalid_date');
		$val->set_rules('jenis_pasien','Kel/Jenis Pasien','trim|required|xss_clean');
		$val->set_rules('cara_bayar','Cara Bayar','trim|required|xss_clean');
		$val->set_rules('kategoripasien','Kategori Pasien','trim|required|xss_clean');
		if($this->input->post('kategoripasien')==6){
			$val->set_rules('hpht','HPHT','trim|required|xss_clean');
			$val->set_rules('kehamilanke','Kehamilan ke','trim|required|xss_clean');
			$val->set_rules('jarakkehamilan','Jarak Kehamilan','trim|required|xss_clean');			
			$val->set_rules('namasuami','Nama Suami','trim|xss_clean');
		}if($this->input->post('kategoripasien')==5){
			$val->set_rules('namasuami','Nama Suami');
		}elseif($this->input->post('kategoripasien')==1 or $this->input->post('kategoripasien')==2 or $this->input->post('kategoripasien')==3 or $this->input->post('kategoripasien')==4){
			$val->set_rules('namaibu','Nama Ibu','trim|required|xss_clean');
		}
		
			$val->set_message('required', "Silahkan isi field \"%s\"");
			
		$arraypetugas = $this->input->post('petugasimunisasi_final')?json_decode($this->input->post('petugasimunisasi_final',TRUE)):NULL;//print_r($arraypetugas);die;
		$arrayimunisasi= $this->input->post('imunisasi_final')?json_decode($this->input->post('imunisasi_final',TRUE)):NULL; 
		
		if ($val->run() == FALSE)
		{
			$val->set_error_delimiters('<div style="color:white">', '</div>');
			die(validation_errors());
		}
		else
		{						
			$db = $this->load->database('sikda',true);
			$db->trans_begin();
			$kunjungan = $this->input->post('kd_kunjungan_hidden');
			$pasien = $this->input->post('kd_pasien_hidden');
			$maxkasir = 0;
			$maxkasir = $db->query("SELECT MAX(SUBSTR(KD_PEL_KASIR,-7)) AS total FROM pel_kasir where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
			$maxkasir = $maxkasir->total + 1;
			$kodekasir = 'KASIR'.sprintf("%07d", $maxkasir);
			
			$datainsertkasir = array(
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
			$datapelayanan = array(
				'KD_PELAYANAN' =>  $kodepelayanan,
                'TGL_PELAYANAN' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tgl_pelayanan')))),
                'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
                'KD_UNIT' => '219',
                'URUT_MASUK' => $this->input->post('kd_urutmasuk_hidden',TRUE),
                'KD_KASIR' => $kodekasir,
                'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
                'CARA_BAYAR' => $this->input->post('cara_bayar',TRUE),
                'JENIS_PASIEN' => $this->input->post('jenis_pasien',TRUE),
                'KD_USER' => $this->session->userdata('kd_petugas'),
                'UNIT_PELAYANAN' => 'RJ',
                'Created_Date' => date('Y-m-d'),
                'Created_By' => $this->session->userdata('kd_petugas'),
                'KD_DOKTER' => $this->session->userdata('kd_petugas'),
                'KEADAAN_KELUAR' => $this->input->post('status_keluar',TRUE)
			);
			$db->insert('pelayanan',$datapelayanan);
			
			$data2 = $db->query("select a.*,b.* from pasien a join family_folder b on a.ID_FAMILY_FOLDER=b.ID_FAMILY_FOLDER where KD_PASIEN='".$pasien."'")->row(); 
			$data3 = $db->query("select a.*,b.KD_PASIEN from family_folder a join pasien b on a.ID_FAMILY_FOLDER=b.ID_FAMILY_FOLDER where KD_FAMILY_FOLDER='".$data2->KD_FAMILY_FOLDER."' AND KD_STATUS_KELUARGA=1")->row(); 
			$data4 = $db->query("select a.*,b.KD_PASIEN from family_folder a join pasien b on a.ID_FAMILY_FOLDER=b.ID_FAMILY_FOLDER where KD_FAMILY_FOLDER='".$data2->KD_FAMILY_FOLDER."' AND KD_STATUS_KELUARGA=2")->row();
			if($this->input->post('namaibu') or $this->input->post('namasuami')){
				if($this->input->post('namaibu') and !empty($data4)){
					$dataexc['NAMA_LENGKAP'] = $this->input->post('namaibu');
				$db->where('KD_PASIEN',$data4->KD_PASIEN);
				$db->update('pasien', $dataexc);
				}elseif($this->input->post('namasuami') and !empty($data3)){
					$dataexc['NAMA_LENGKAP'] = $this->input->post('namasuami');	
				$db->where('KD_PASIEN',$data3->KD_PASIEN);
				$db->update('pasien', $dataexc);
				}else{
					$idfamily = array(
						'KD_FAMILY_FOLDER' => $data2->KD_FAMILY_FOLDER,
						'NO_KK' => $data2->NO_KK,
						'NAMA_KK' => $data2->KK,
						'ninput_tgl' => date("Y-m-d"),
						'ninput_oleh' => $this->session->userdata('user_name')
					);
					if($this->input->post('namaibu')){
						$idfamily['KD_STATUS_KELUARGA'] = '2';
					}else{
						$idfamily['KD_STATUS_KELUARGA'] = '1';
					}
					$db->insert('family_folder',$idfamily);
					$idfamily1 = $db->insert_id();
					$max = $db->query("SELECT MAX(SUBSTR(kd_pasien,-7)) AS total FROM pasien where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
					$max = $max->total + 1;
					$dataexc = array(
						'KD_PASIEN'=> $this->session->userdata('kd_puskesmas').sprintf("%07d", $max),
						'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
						'TGL_LAHIR' => '1980-01-01',
						'TGL_PENDAFTARAN' => date('Y-m-d'),
						'NO_PENGENAL' => $this->input->post('nik')?$this->input->post('nik',TRUE):NULL,
						'KD_AGAMA' => NULL,
						'KD_PROVINSI' => $data2->KD_PROVINSI?$data2->KD_PROVINSI:NULL,
						'KD_KABKOTA' => $data2->KD_KABKOTA?$data2->KD_KABKOTA:NULL,
						'KD_KECAMATAN' => $data2->KD_KECAMATAN?$data2->KD_KECAMATAN:NULL,
						'KD_KELURAHAN' => $data2->KD_KELURAHAN?$data2->KD_KELURAHAN:NULL,
						'KD_JENIS_KELAMIN' => $this->input->post('namaibu')?'P':'L',
						'STATUS_MARITAL' => 1,
						'NO_KK' => $this->input->post('no_kk')?$this->input->post('no_kk'):$data2->NO_KK,
						'KK' => $data2->KK?$data2->KK:NULL,
						'ALAMAT' => $data2->ALAMAT?$data2->ALAMAT:NULL,
						'ID_FAMILY_FOLDER' => $idfamily1,
						'Created_By' => $this->session->userdata('user_name'),
						'Created_Date' => date('Y-m-d H:i:s')
					);//print_r($dataexc);die;
					if($this->input->post('namaibu')){
						$dataexc['NAMA_LENGKAP'] = $this->input->post('namaibu');
					}else{
						$dataexc['NAMA_LENGKAP'] = $this->input->post('namasuami');	
					}
					$db->insert('pasien', $dataexc);
				}
			}
			
			$alamat = $db->query("select PUSKESMAS,ALAMAT from mst_puskesmas where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."'")->row();
			$datatrans = array(
				'TANGGAL' => date("Y-m-d",strtotime(str_replace('/','-',$this->input->post('tgl_pelayanan')))),
				'IMUNISASI_LUAR_GEDUNG' => NULL,
				'KD_PUSKESMAS' =>  $this->input->post('kd_puskesmas_hidden',TRUE),
				'KD_KATEGORI_IMUNISASI' => NULL,
				'KD_PELAYANAN' => $kodepelayanan,
				'KD_PASIEN' => $pasien,
				'KD_KELURAHAN' => $data2->KD_KELURAHAN,
				'KD_JENIS_PASIEN' => $this->input->post('kategoripasien'),
				'NAMA_LOKASI' => $this->input->post('kd_unitpel_hidden',true).' '.$alamat->PUSKESMAS,
				'ALAMAT' => $alamat->ALAMAT,
				'TAHUN' => date('Y'),
				'PEMERIKSAAN_FISIK' => '-',
				'HPHT' => $this->input->post('kategoripasien')==6?date("Y-m-d",strtotime(str_replace('/','-',$this->input->post('hpht')))):NULL,
				'HAMIL_KE' => $this->input->post('kehamilanke')?$this->input->post('kehamilanke'):0,
				'JARAK_KEHAMILAN' => $this->input->post('jarakkehamilan')?$this->input->post('jarakkehamilan'):NULL,
				'KONDISI_AKHIR' => '-',
				'nama_input' => $this->session->userdata('user_name'),
				'tgl_input' => date('Y-m-d')
			);
			if($this->input->post('namasuami')){
				$datatrans['KD_SUAMI_DG'] = !empty($data3->KD_PASIEN)?$data3->KD_PASIEN:$dataexc['KD_PASIEN'];
			}elseif($this->input->post('namaibu')){
				$datatrans['KD_IBU_DG'] = !empty($data4->KD_PASIEN)?$data4->KD_PASIEN:$dataexc['KD_PASIEN'];
			}
			$db->insert('trans_imunisasi',$datatrans);
			$kdtransimu = $db->insert_id();
			
			if($arraypetugas){
				foreach($arraypetugas as $rowpetugasloop){
					$datapetugastmp = json_decode($rowpetugasloop);
					$datapetugasloop[] = array(
						'KD_PELAYANAN' => $kodepelayanan,
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
						'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
						'KD_TRANS_IMUNISASI'=> $kdtransimu,
						'KD_DOKTER' => $datapetugastmp->kd_petugas,
						'STATUS_PEMBINA' => !empty($datapetugastmp->keterangan)?$datapetugastmp->keterangan:0,
						'nama_input' => $this->session->userdata('user_name'),
						'tgl_input' => date("Y-m-d")
					);
					$datapetugasinsert = $datapetugasloop;
				}
				$db->insert_batch('pel_petugas',$datapetugasinsert);
			}
			
			if($arrayimunisasi){
				$qtyobattotal=0;
				$hargaobattotal=0;
				$irow = 0;
				$a = 0;
				$maxpelayananobat = 0;
				$maxpelayananobat = $db->query("SELECT MAX(SUBSTR(KD_PELAYANAN,-7)) AS total FROM pelayanan where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
				$maxpelayananobat = $maxpelayananobat->total + 1;
				$kodepelayananobat = '6'.sprintf("%07d", $maxpelayananobat);
				$kodepelayananresep = 'R'.sprintf("%07d", $maxpelayananobat);
				foreach($arrayimunisasi as $rowimunisasi){
					$dataimunisasi= json_decode($rowimunisasi);
					//$dt = explode("-",$dataimunisasi->namavaksin);
					//$kd_obat = $dt[0];
					//$harga = $dt[1];
					$dataimunisasiloop[$a] = array(
						'KD_PELAYANAN' => $kodepelayanan,
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
						'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
						'KD_DATA_DASAR' => 0,
						'KD_TRANS_IMUNISASI' => $kdtransimu,
						'KD_JENIS_IMUNISASI' => $dataimunisasi->jenisimunisasi,
						//'KD_OBAT' => $kd_obat,
						'HARGA_DASAR' => 0,
						//'HARGA_JUAL' => $harga,
						'QTY' => $dataimunisasi->jumlah,
						'tgl_input' => date("Y-m-d"),
						'nama_input' => $this->session->userdata('user_name')
					);
					
					/*$stock = $db->query("select JUMLAH_STOK_OBAT from apt_stok_obat where KD_PKM='".$this->session->userdata('kd_puskesmas')."' AND KD_UNIT_APT='APT' AND KD_OBAT='".$kd_obat."'")->row();
					$stk = $stock->JUMLAH_STOK_OBAT - $dataimunisasi->jumlah;
					$db->where('KD_UNIT_APT=','APT');
					$db->where('KD_PKM',$this->session->userdata('kd_puskesmas'));
					$db->where('KD_OBAT',$kd_obat);
					$db->set('JUMLAH_STOK_OBAT',$stk);
					$db->update_batch('apt_stok_obat');
					*/
					$a++;
					$irow++;
					$qtyobattotal = 0;//$qtyobattotal+$dataimunisasi->jumlah;
					$hargaobattotal = 0;//$hargaobattotal+($harga*$dataimunisasi->jumlah);
					$dataimuninsert = $dataimunisasiloop; 
					$dataimunkasirinsert = array(
						'KD_PEL_KASIR' => $kodekasir,
						'KD_TARIF' =>  'AM',
						'KD_PASIEN' => $this->input->post('kd_pasien_hidden',TRUE),
						'KD_PUSKESMAS' => $this->input->post('kd_puskesmas_hidden',TRUE),
						'REFF' => $kodepelayanan,
						'KD_PRODUK' => "TRA",
						'KD_UNIT' => '6',
						'HARGA_PRODUK' => 0,
						'TGL_BERLAKU' => date('Y-m-d'),
						'QTY' => $qtyobattotal,
						'TOTAL_HARGA' => $hargaobattotal				
					);
				}
				$db->insert_batch('pel_imunisasi',$dataimuninsert);
				$db->insert('pel_kasir_detail',$dataimunkasirinsert);
			}
			
			$kdpel = $this->input->post('kd_unitpel_hidden',true);
			$datakia = array(
				'KD_PELAYANAN'=> $kodepelayanan,
				'KD_UNIT_PELAYANAN'=> $kdpel,
				'nupdate_oleh' => $this->session->userdata('user_name'),
				'nupdate_tgl' => date('Y-m-d H:i:s')
				);
			$db->where('ID_KUNJUNGAN', $kunjungan);
			$db->update('trans_kia', $datakia);
			
			$db->set('KD_PELAYANAN',$kodepelayanan);
			$db->set('STATUS','1');
			$db->where('ID_KUNJUNGAN',$kunjungan);
			$db->update('kunjungan');
			
			$data_pasien = array(
				'CARA_BAYAR' => $this->input->post('cara_bayar',TRUE),
                'KD_CUSTOMER' => $this->input->post('jenis_pasien',TRUE)
			);
			$db->where('KD_PASIEN', $this->input->post('kd_pasien_hidden'));
			$db->update('pasien',$data_pasien);
			
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
	
	public function t_imunisasixml()
	{
		$this->load->model('t_imunisasidg_model');
		
		$limit = 50;
		
		$paramstotal=array(
					'kd_pelayanan'=>$this->input->post('myid2'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$total = $this->t_imunisasidg_model->totalT_imunisasi($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'kd_pelayanan'=>$this->input->post('myid2'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$result = $this->t_imunisasidg_model->getT_imunisasi($params);
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	public function t_petugasxml()
	{
		$this->load->model('t_imunisasidg_model');
		
		$limit = 50;
		
		
		$paramstotal=array(
					'kd_pelayanan'=>$this->input->post('myid2'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$total = $this->t_imunisasidg_model->totalT_petugas($paramstotal);
		
		$total_pages = ($total >0)?ceil($total/$limit):1;
		$page = $this->input->post('page')?$this->input->post('page'):1;
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit;
		
		$params=array(
					'kd_pelayanan'=>$this->input->post('myid2'),
					'idpuskesmas'=>$this->input->post('idpuskesmas')
					);
					
		$result = $this->t_imunisasidg_model->getT_petugas($params);
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
}

/* Coba tuk tepiskan semua ttg dirinya selalu dan selalu sptnya ku blum bisa hapusnya dari ingatanku berserah pada waktu
yang seharusnya tergerus tertimpa kasih nan baru trnyata tetap bukan jawabnya tp kusadari tak mungkin memilikinya meski
hanya merengkuh bayangnya bukan utk waktu yg lama berharap amnesia yg pasti ampuh bersihkan otakku
jd kan sosok baru tanpa terjebak kisah lalu */
/* End of file t_pemeriksaan_kesehatan_anak.php */
/* Location: ./application/controllers/t_pemeriksaan_kesehatan_anak.php */
