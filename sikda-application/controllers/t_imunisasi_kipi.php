<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_imunisasi_kipi extends CI_Controller {
	public function index()
	{
		$this->load->helper('beries_helper');
		$this->load->helper('my_helper');
		$this->load->view('Imunisasi/v_t_kipi_add');
	}
	
	public function addprocess()
	{
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('tgl_kipi', 'Tanggal KIPI', 'trim|required');		
		$val->set_rules('nama_lokasi_kipi', 'Nama Lokasi KIPI', 'trim|required|xss_clean');
		$val->set_rules('alamat_kipi', 'Alamat KIPI', 'trim|required|xss_clean');
		
		$val->set_message('required', "Silahkan isi field \"%s\"");
		
		$arraypetugas = $this->input->post('petugas_final')?json_decode($this->input->post('petugas_final',TRUE)):NULL;
	
	if ($val->run() == FALSE)
		{
			$val->set_error_delimiters('<div style="color:white">', '</div>');
			die(validation_errors());
		}
		else
		{						
			$db = $this->load->database('sikda', TRUE);
			$db->trans_begin();
			
			//Data Pelayanan
			$maxpelayanan = 0;
			$maxpelayanan = $db->query("SELECT MAX(SUBSTR(KD_PELAYANAN,-7)) AS total FROM pelayanan where KD_PUSKESMAS='".$this->session->userdata('kd_puskesmas')."' ")->row();
			$maxpelayanan = $maxpelayanan->total + 1;
			$kodepelayanan = $this->input->post('kd_unit_hidden',TRUE).sprintf("%07d", $maxpelayanan);
			
			$datainsert = array(
				'KD_PELAYANAN' =>  $kodepelayanan,
                'TGL_PELAYANAN' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tanggal_daftar')))),
                'KD_PASIEN' => $this->input->post('rekam_medis'),
                'KD_UNIT' => '219',
                'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
                'UNIT_PELAYANAN' => 'RJ',
                'KD_USER' => $this->session->userdata('kd_petugas'),
                'Created_Date' => date('Y-m-d'),
                'Created_By' => $this->session->userdata('kd_petugas'),
                'KD_DOKTER' => $this->session->userdata('kd_petugas')
				
            );
			$db->insert('pelayanan',$datainsert);
			
			//Insert tabel trans_kipi
			
			$dataexc = array(
				// 'KD_PELAYANAN' =>  '219'.$kodepelayanan,
				'KD_PELAYANAN' =>  $kodepelayanan,
				'KD_PASIEN' => $this->input->post('rekam_medis'),
				'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
				'KD_TRANS_IMUNISASI' => $this->input->post('kd_trans_imunisasi_hidden'),
				'TANGGAL_KIPI' => date("Y-m-d", strtotime(str_replace('/', '-',$this->input->post('tgl_kipi')))),
				'KD_KATEGORI_IMUNISASI' => $this->input->post('jenis_lokasi'),
				'NAMA_LOKASI' => $this->input->post('nama_lokasi_kipi'),
				'ALAMAT_KIPI' => $this->input->post('alamat_kipi'),
				'KD_KECAMATAN' => $this->input->post('kecamatanlokasi'),
				'KD_KELURAHAN' => $this->input->post('desalokasi'),
				'KONDISI_AKHIR' => $this->input->post('kondisiakhir'),				
				'nama_input' => $this->session->userdata('nusername'),
				'tgl_input' => date('Y-m-d H:i:s')
			);//print_r($dataexc);die;
			$db->insert('trans_kipi', $dataexc);
			
			$kdkipi = $db->insert_id();
			
			//Insert tabel pel_petugas
			
			if($arraypetugas){//print_r($_POST);die();
				foreach($arraypetugas as $rowpetugasloop){
					$datapetugastmp = json_decode($rowpetugasloop);
					$datapetugasloop[] = array(
						'KD_PELAYANAN' =>  $kodepelayanan,
						'KD_PASIEN' => $this->input->post('rekam_medis'),
						'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
						'KD_TRANS_IMUNISASI' => $this->input->post('kd_trans_imunisasi')?$this->input->post('kd_trans_imunisasi'):NULL,
						'KD_TRANS_KIPI' => $kdkipi,
						'KD_DOKTER' => $datapetugastmp->kd_petugas,
						'STATUS_PEMBINA' => $this->input->post('status_pembina')?$this->input->post('status_pembina'):NULL,
						'nama_input' => $this->session->userdata('nusername'),
						'tgl_input' => date('Y-m-d H:i:s')
					);
					$datapetugasinsert = $datapetugasloop;
				}//print_r($datapetugasloop);die;
				$db->insert_batch('pel_petugas',$datapetugasinsert);
			}
	
			//Insert tabel pel_gejala_kipi
			
			$gejala= $_POST['gejala'];//print_r($gejala);die;
			
			if(isset($gejala))
			{
				
				foreach($gejala as $deGejala){
					$strGejala = implode(" , ",$gejala);
					}
					$simpanGejala = array(
					'KD_TRANS_KIPI' => $kdkipi,
					'KD_PELAYANAN' =>  $kodepelayanan,
					'KD_PASIEN' => $this->input->post('rekam_medis'),
					'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
					'GEJALA_KIPI' => $strGejala,
					'nama_input' => $this->session->userdata('nusername'),
					'tgl_input' => date('Y-m-d H:i:s')
					);//print_r($simpanGejala);die;
					$db->insert('pel_gejala_kipi', $simpanGejala);	
					
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
	
	public function petugassource()
	{
		$id=$this->input->get('term')?$this->input->get('term',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$combopetugas = $db->query("SELECT KD_DOKTER AS id,NAMA AS label, '' as category FROM mst_dokter where NAMA like '%".$id."%' ")->result_array();
		die(json_encode($combopetugas));
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}

/* End of file t_pendaftaran.php */
/* Location: ./application/controllers/t_pendaftaran.php */