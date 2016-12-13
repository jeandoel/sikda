<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'include/xmlelement.php';
class T_pemeriksaan_kesehatan_anak extends CI_Controller {
	public function index()
	{
		$this->load->helper('pemkes_helper');
		$this->load->view('t_pemeriksaan_kesehatan_anak/v_t_pemeriksaan_kesehatan_anak');
	}
	
	public function t_pemeriksaan_kesehatan_anakxml()
	{
		$this->load->model('t_pemeriksaan_kesehatan_anak_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):10;
		
		$paramstotal=array(
					'dari'=>$this->input->post('dari'),
					'sampai'=>$this->input->post('sampai'),
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama')
					);
					
		$total = $this->t_pemeriksaan_kesehatan_anak_model->totalt_pemeriksaan_kesehatan_anak($paramstotal);
		
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
					'carinama'=>$this->input->post('carinama')
					);
					
		$result = $this->t_pemeriksaan_kesehatan_anak_model->gett_pemeriksaan_kesehatan_anak($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function add()
	{
		$this->load->helpers('pemkes_helper');
		$this->load->helpers('beries_helper');
		
		$this->load->view('t_pemeriksaan_kesehatan_anak/v_t_pemeriksaan_kesehatan_anak_add');
	}
	
	public function addprocess()
	{//print_r($_POST);die;
		$this->load->library('form_validation');

		$val = $this->form_validation;
		$val->set_rules('tgl_periksa', 'Tanggal Pemeriksaan', 'trim|required|xss_clean|myvalid_date');
		//$val->set_rules('kd_penyakit', 'Penyakit', 'trim|required|xss_clean');
		//$val->set_rules('kd_tindakan', 'Tindakan', 'trim|required|xss_clean');
		$val->set_rules('kolom_nama_pemeriksa', 'Pemeriksa', 'trim|required|xss_clean');
		$val->set_rules('kolom_nama_petugas', 'Petugas', 'trim|required|xss_clean');
				
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
			
			$datakia = array(
				'KD_DOKTER_PEMERIKSA' => $val->set_value('kolom_nama_pemeriksa'),
				'KD_DOKTER_PETUGAS' => $val->set_value('kolom_nama_petugas'),
				'KD_PELAYANAN'=> $this->input->post('kd_pelayanan')?$this->input->post('kd_pelayanan',TRUE):'-',
				'KD_KATEGORI_KIA'=> $this->input->post('kd_kategori')?$this->input->post('kd_kategori',TRUE):'-',
				'KD_KUNJUNGAN_KIA'=> $this->input->post('kd_kunjungan')?$this->input->post('kd_kunjungan',TRUE):'-',
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);//print_r($datakia);die;
			$db->insert('trans_kia', $datakia);
			
			$kodekia = $db->insert_id();
			
			$arraypenyakit = $this->input->post('penyakit_final')?json_decode($this->input->post('penyakit_final',TRUE)):NULL;
			$arraytindakan = $this->input->post('tindakan_final')?json_decode($this->input->post('tindakan_final',TRUE)):NULL;
			
			$arrayobat = $this->input->post('obat_final')?json_decode($this->input->post('obat_final',TRUE)):NULL;
			$arrayalergi = $this->input->post('alergi_final')?json_decode($this->input->post('alergi_final',TRUE)):NULL;
			
			$dataexc = array(
				'TANGGAL_KUNJUNGAN' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tgl_periksa')))),
				//'KD_PENYAKIT' => $val->set_value('kd_penyakit'),
				//'KD_PRODUK' => $val->set_value('kd_tindakan'),
				'KD_KIA' => $kodekia,
				'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);//print_r($dataexc);die;
			$db->insert('pemeriksaan_anak', $dataexc);
			
			$kdpemkes = $db->insert_id();
			
			if($arraypenyakit){
				$irow=1;
				foreach($arraypenyakit as $rowpenyakitloop){
					$datapenyakittmp = json_decode($rowpenyakitloop);
					$datapenyakitloop[] = array(
						'KD_PEMERIKSAAN_ANAK' => $kdpemkes,
						'KD_PENYAKIT' => $datapenyakittmp->kd_penyakit,
						'PENYAKIT' => $datapenyakittmp->penyakit,
						'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
						'ninput_oleh' => $this->session->userdata('user_name'),
						'ninput_tgl' => date('Y-m-d H:i:s')
					);
					//print_r($datakeadaanbayiloop);die;
					$datapenyakitinsert = $datapenyakitloop;
					$irow++;
				}
				$db->insert_batch('pem_kes_icd',$datapenyakitinsert);
			}
			
			if($arraytindakan){
				$irow2=1;
				foreach($arraytindakan as $rowtindakanloop){
					$datatindakantmp = json_decode($rowtindakanloop);
					$datatindakanloop[] = array(
						'KD_PEMERIKSAAN_ANAK' => $kdpemkes,
						'KD_PRODUK' => $datatindakantmp->kd_tindakan,
						'PRODUK' => $datatindakantmp->tindakan,
						'KD_PUSKESMAS' => $this->session->userdata('kd_puskesmas'),
						'ninput_oleh' => $this->session->userdata('user_name'),
						'ninput_tgl' => date('Y-m-d H:i:s')
					);
					$datatindakaninsert = $datatindakanloop;
					$irow2++;
				}
				$db->insert_batch('pem_kes_produk',$datatindakaninsert);
			}
			
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
						'KD_PELAYANAN' => $this->input->post('kd_pelayanan_hidden',TRUE),
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
		$val->set_rules('tgl_periksa', 'Tanggal Pemeriksaan', 'trim|required|xss_clean');
		//$val->set_rules('kd_penyakit', 'Penyakit', 'trim|required|xss_clean');
		//$val->set_rules('kd_penyakit', 'Tindakan', 'trim|required|xss_clean');
		$val->set_rules('kolom_nama_pemeriksa', 'Pemeriksa', 'trim|required|xss_clean');
		$val->set_value('kolom_nama_petugas', 'Petugas', 'trim|required|xss_clean');
		if ($val->run() == FALSE)
		{
			$val->set_error_delimiters('<div style="color:white">', '</div>');
			die(validation_errors());
		}
		else
		{						
			$db = $this->load->database('sikda', TRUE);
			$db->trans_begin();
			
			$kodekia = $db->insert_id();
			
			$dataexc = array(
				'TANGGAL_KUNJUNGAN' => date("Y-m-d", strtotime(str_replace('/', '-',$val->set_value('tgl_periksa')))),
				//'KD_PENYAKIT' => $arraypenyakit,
				//'KD_PRODUK' => $arraytindakan,
				'KD_KIA' => $kodekia,
				'ninput_oleh' => $this->session->userdata('nusername'),
				'ninput_tgl' => date('Y-m-d H:i:s')
			);			
			
			$db->where('KD_PEMERIKSAAN_ANAK',$id);
			$db->update('pemeriksaan_anak', $dataexc);
			
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
		$this->load->helpers('pemkes_helper');
		$db = $this->load->database('sikda', TRUE);
		$db->select("a.KD_PEMERIKSAAN_ANAK as kode,a.KD_PEMERIKSAAN_ANAK,DATE_FORMAT(a.TANGGAL_KUNJUNGAN,'%d-%m-%Y') as TANGGAL_KUNJUNGAN,group_concat(distinct c.PENYAKIT separator ' | ') as PENYAKIT,group_concat(distinct o.PRODUK separator ' , ') as PRODUK,concat(d.NAMA,'--',d.JABATAN) as dokter, e.NAMA as KD_DOKTER_PETUGAS, a.KD_PEMERIKSAAN_ANAK as id",false);
		$db->from('pemeriksaan_anak a');
		$db->join('pem_kes_icd c','a.KD_PEMERIKSAAN_ANAK=c.KD_PEMERIKSAAN_ANAK','left');
		$db->join('pem_kes_produk o','a.KD_PEMERIKSAAN_ANAK=o.KD_PEMERIKSAAN_ANAK','left');
		$db->join('trans_kia k','a.KD_KIA=k.KD_KIA','left');
		$db->join('mst_dokter d','k.KD_DOKTER_PEMERIKSA=d.KD_DOKTER','left');
		$db->join('mst_dokter e','k.KD_DOKTER_PETUGAS=e.KD_DOKTER','left');
		$db->group_by('a.KD_PEMERIKSAAN_ANAK','c.KD_PENYAKIT','o.KD_PRODUK','d.KD_DOKTER','e.KD_DOKTER');
		$db->where("a.KD_PEMERIKSAAN_ANAK ='$id'",null, false);
		$val = $db->get()->row();
		$data['data']=$val;		
		$this->load->view('t_pemeriksaan_kesehatan_anak/v_t_pemeriksaan_kesehatan_anak_edit',$data);
	}
	
	public function delete()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);//print_r($id);die();
		if($db->query("delete from pemeriksaan_anak where KD_PEMERIKSAAN_ANAK = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function detail()
	{
		$id=$this->input->get('id')?$this->input->get('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$db->select("a.KD_PEMERIKSAAN_ANAK as kode,a.KD_PUSKESMAS,a.KD_PEMERIKSAAN_ANAK,DATE_FORMAT(a.TANGGAL_KUNJUNGAN,'%d-%m-%Y') as TANGGAL_KUNJUNGAN,group_concat(distinct c.PENYAKIT separator ' | ') as PENYAKIT,group_concat(distinct o.PRODUK separator ' , ') as PRODUK,concat(d.NAMA,'--',d.JABATAN) as dokter, e.NAMA as KD_DOKTER_PETUGAS, a.KD_PEMERIKSAAN_ANAK as id",false);
		$db->from('pemeriksaan_anak a');
		$db->join('pem_kes_icd c','a.KD_PEMERIKSAAN_ANAK=c.KD_PEMERIKSAAN_ANAK');
		$db->join('pem_kes_produk o','a.KD_PEMERIKSAAN_ANAK=o.KD_PEMERIKSAAN_ANAK');
		$db->join('trans_kia k','a.KD_KIA=k.KD_KIA');
		$db->join('mst_dokter d','k.KD_DOKTER_PEMERIKSA=d.KD_DOKTER');
		$db->join('mst_dokter e','k.KD_DOKTER_PETUGAS=e.KD_DOKTER');
		$db->group_by('a.KD_PEMERIKSAAN_ANAK','c.KD_PENYAKIT','o.KD_PRODUK');
		$db->where("a.KD_PEMERIKSAAN_ANAK ='$id'",null, false);
		$val = $db->get()->row();
		$data['data']=$val;//print_r($data);die;
		$this->load->view('t_pemeriksaan_kesehatan_anak/v_t_pemeriksaan_kesehatan_anak_detail',$data);
	}
	
	public function icdsource()
	{
		$id=$this->input->get('term')?$this->input->get('term',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$comboicd = $db->query("SELECT icd.KD_PENYAKIT AS id,icd.PENYAKIT AS label,
								CASE WHEN induk.ICD_INDUK IS NULL THEN '' ELSE induk.ICD_INDUK END  AS category FROM mst_icd icd LEFT JOIN 
								mst_icd_induk induk ON induk.KD_ICD_INDUK = icd.KD_ICD_INDUK where icd.PENYAKIT like '%".$id."%' ")->result_array();
		die(json_encode($comboicd));//print_r($id);die();
	}
	
	public function produksource()
	{
		$id=$this->input->get('term')?$this->input->get('term',TRUE):null;
		$db = $this->load->database('sikda', TRUE);
		$comboproduk = $db->query("SELECT p.KD_PRODUK AS id,p.PRODUK AS label, 
							CASE WHEN g.GOL_PRODUK IS NULL THEN '' ELSE g.GOL_PRODUK END AS category
							FROM mst_produk p LEFT JOIN mst_gol_produk g on p.KD_GOL_PRODUK=g.KD_GOL_PRODUK where p.PRODUK like '%".$id."%' ")->result_array();
		die(json_encode($comboproduk));
	}
	
	public function t_pemeriksaan_kesehatan_anak_penyakitxml()
	{
		$this->load->model('t_pemeriksaan_kesehatan_anak_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid')
					);
					
		$total = $this->t_pemeriksaan_kesehatan_anak_model->totalt_pemeriksaan_kesehatan_anak_penyakit($paramstotal);
		
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
					
		$result = $this->t_pemeriksaan_kesehatan_anak_model->gett_pemeriksaan_kesehatan_anak_penyakit($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function delete_penyakit()
	{
		$id=$this->input->post('id')?$this->input->post('id',TRUE):null;
		$db = $this->load->database('sikda', TRUE);//print_r($id);die();
		if($db->query("delete from pem_kes_icd where KD_PENYAKIT = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
	}
	
	public function t_pemeriksaan_kesehatan_anak_tindakanxml()
	{
		$this->load->model('t_pemeriksaan_kesehatan_anak_model');
		
		$limit = $this->input->post('rows')?$this->input->post('rows'):5;
		
		$paramstotal=array(
					'keyword'=>$this->input->post('keyword'),
					'carinama'=>$this->input->post('carinama'),
					'id'=>$this->input->post('myid2')
					);
					
		$total = $this->t_pemeriksaan_kesehatan_anak_model->totalt_pemeriksaan_kesehatan_anak_tindakan($paramstotal);
		
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
					'id'=>$this->input->post('myid2')
					);
					
		$result = $this->t_pemeriksaan_kesehatan_anak_model->gett_pemeriksaan_kesehatan_anak_tindakan($params);		
		
		header("Content-type: text/xml");
		echo writeXmlElement::writeXml3('rows', $result['data'], $total,$page,$total_pages);
	}
	
	public function delete_tindakan()
	{
		$id=$this->input->post('id2')?$this->input->post('id2',TRUE):null;
		$db = $this->load->database('sikda', TRUE);//print_r($id);die();
		if($db->query("delete from pem_kes_produk where KD_PRODUK = '".$id."'")){
			die(json_encode('OK'));
		}else{
			die(json_encode('FAIL'));
		}
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
	
}

/* End of file t_pemeriksaan_kesehatan_anak.php */
/* Location: ./application/controllers/t_pemeriksaan_kesehatan_anak.php */