<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends CI_Controller {

	public function index()
	{	
		if($this->session->userdata('logged')==false){
			redirect('/','location');exit;
		}
		
		$dateToday = date("Y-m-d");
        $lastMonth= mktime(0,0,0,date("m"),date("d")-30,date("Y"));
        $dateLastMonth = date("Y-m-d", $lastMonth);
		$lastWeek= mktime(0,0,0,date("m"),date("d")-7,date("Y"));
        $dateLastWeek = date("Y-m-d", $lastWeek);				
		$qrykab = "SUBSTRING(KD_PUSKESMAS,2,4) = '".$this->session->userdata('kd_kabupaten')."'";
		$qrypuskes = "KD_PUSKESMAS = '".$this->session->userdata('kd_puskesmas')."'";
		$kode = $this->session->userdata('level_aplikasi')=='PUSKESMAS'?$qrypuskes:$qrykab;
		$grb1 = $this->session->userdata('level_aplikasi')=='PUSKESMAS'?'p.KD_PUSKESMAS,':'';
		$grb2 = $this->session->userdata('level_aplikasi')=='PUSKESMAS'?'KD_PUSKESMAS,':'';
		
		$db = $this->load->database('sikda', TRUE);
		
		$querytop5diagnosa = "SELECT mst_icd.KD_PENYAKIT, mst_icd.PENYAKIT, COUNT(mst_icd.KD_PENYAKIT) AS BANYAK FROM pel_diagnosa 
							INNER JOIN mst_icd ON pel_diagnosa.KD_PENYAKIT = mst_icd.KD_PENYAKIT 
							WHERE TANGGAL BETWEEN '".$dateLastMonth."' AND '".$dateToday."' AND ".$kode." 
							GROUP BY mst_icd.KD_PENYAKIT, mst_icd.PENYAKIT ORDER BY banyak DESC LIMIT 0, 5";
		$top5diagnose = $db->query($querytop5diagnosa)->result_array();
		
		$querytop5unit = "SELECT mu.UNIT, COUNT(KD_PELAYANAN) AS BANYAK FROM pelayanan p JOIN mst_unit mu ON p.KD_UNIT=mu.`KD_UNIT` 
						WHERE p.TGL_PELAYANAN BETWEEN '".$dateLastMonth."' AND '".$dateToday."' AND ".$kode." 
						GROUP BY ".$grb1."p.KD_UNIT ORDER BY banyak DESC LIMIT 0, 5";
		$top5unit = $db->query($querytop5unit)->result_array();
		
		$val = $db->query("SELECT DATE_FORMAT(TGL_MASUK, '%m/%d/%Y') AS TANGGAL, COUNT(KD_PASIEN) AS TOTAL FROM kunjungan 
						WHERE ".$kode."
						AND TGL_MASUK BETWEEN '".$dateLastWeek."' AND '".$dateToday."'
						GROUP BY ".$grb2."TGL_MASUK order by TGL_MASUK  ASC")->result_array(); //KD_UNIT_LAYANAN='PUSKESMAS' and
		$kunjungantotal='';
		$n=0;
		if($val){
			foreach($val as $key=>$value){
				$total=$value['TOTAL']?$value['TOTAL']:0;
				$kunjungantotal .= ($value['TANGGAL'] and $n>0)?','."['".$value['TANGGAL']."',".$total."]":"['".$value['TANGGAL']."',".$total."]";
				$n++;
			}
		}else{
			$kunjungantotal = "['".date('m/d/Y')."',0]";
		}
		//print_r($kunjungantotal);die;
		$data['kunjungantotal']=$kunjungantotal;
		$data['top5diagnose']=$top5diagnose;
		$data['top5unit']=$top5unit;
		$this->load->view('dashboard',$data);
	}
	
	public function getKunjungan()
	{
		$dateToday = date("Y-m-d");
        $lastMonth= mktime(0,0,0,date("m"),date("d")-30,date("Y"));
        $dateLastMonth = date("Y-m-d", $lastMonth);
		$lastWeek= mktime(0,0,0,date("m"),date("d")-7,date("Y"));
        $dateLastWeek = date("Y-m-d", $lastWeek);				
		$qrykab = "SUBSTRING(KD_PUSKESMAS,2,4) = '".$this->session->userdata('kd_kabupaten')."'";
		$qrypuskes = "KD_PUSKESMAS = '".$this->session->userdata('kd_puskesmas')."'";
		$kode = $this->session->userdata('level_aplikasi')=='PUSKESMAS'?$qrypuskes:$qrykab;
		$grb1 = $this->session->userdata('level_aplikasi')=='PUSKESMAS'?'p.KD_PUSKESMAS,':'';
		$grb2 = $this->session->userdata('level_aplikasi')=='PUSKESMAS'?'KD_PUSKESMAS,':'';
		
		$db = $this->load->database('sikda', TRUE);
		
		$val = $db->query("SELECT DATE_FORMAT(TGL_MASUK, '%m/%d/%Y') AS TANGGAL, COUNT(KD_PASIEN) AS TOTAL FROM kunjungan 
						WHERE ".$kode."
						AND TGL_MASUK BETWEEN '".$dateLastWeek."' AND '".$dateToday."'
						GROUP BY ".$grb2."TGL_MASUK order by TGL_MASUK  ASC")->result_array(); //KD_UNIT_LAYANAN='PUSKESMAS' and
		$kunjungantotal='';
		$n=0;
		if($val){
			foreach($val as $key=>$value){
				$total=$value['TOTAL']?$value['TOTAL']:0;
				$kunjungantotal .= ($value['TANGGAL'] and $n>0)?','."['".$value['TANGGAL']."',".$total."]":"['".$value['TANGGAL']."',".$total."]";
				$n++;
			}
		}else{
			$kunjungantotal = "['".date('m/d/Y')."',0]";
		}
		die($kunjungantotal);
	}
	
	public function menu()
	{
		$this->load->database();
		header("Content-type: text/xml");
		echo '<rows>
				<page>1</page>
				<total>1</total>
				<records>1</records>';
		
		$query = $this->db->query('
									SELECT m.* FROM config_menu m 
									JOIN config_hak_akses a ON m.id_menu = a.id_menu 
									WHERE a.group = "'.$this->session->userdata('group_id').'" ORDER BY m.id');
		//rowid	|	title	|	kolom	|	level 	|	parent	|	isLeaf	|	is expanded
		foreach ($query->result_array() as $row){			
			echo '<row>
					<cell>'.$row['id_menu'].'</cell>
					<cell>'.$row['title'].'</cell>
					<cell>'.$row['link'].'</cell>
					<cell>'.$row['level'].'</cell>
					<cell>'.$row['parent'].'</cell>					
					<cell>'.$row['isleaf'].'</cell>';
					
			if($row['loaded'] == 'true'){
			echo '<cell>'.$row['loaded'].'</cell>
			      <cell>'.$row['expanded'].'</cell>';
			}
			
			echo '</row>';
			
			
		}
		echo '</rows>';
		// <row> 							<!--sample parent-->
			// <cell>1</cell>  				<!--id-->
			// <cell>Tabelle</cell>			<!--title-->
			// <cell>1a2</cell>				<!--link-->
			// <cell>0</cell>				<!--level-->
			// <cell>NULL</cell>			<!--parent-->
			// <cell>false</cell>			<!--isleaf-->
			// <cell>true</cell>			<!--unknow-->
			// <cell>true</cell>			<!--expanded-->
		// </row> 
	}
	
	public function menu_last()
	{
		header("Content-type: text/xml");
		$menu='';
		$menu .='
			<rows>
				<page>1</page>
				<total>1</total>
				<records>1</records>
				';
				$menu .='
				<row><cell>200</cell><cell>Transaksi</cell><cell/><cell>0</cell><cell>200</cell><cell>250</cell><cell>false</cell><cell>true</cell><cell>true</cell></row>
				';
				if($this->session->userdata('group_id')=='all' or $this->session->userdata('group_id')=='loket'){
				$menu .='
				<row><cell>202</cell><cell>Pendaftaran</cell><cell>t_pendaftaran</cell><cell>1</cell><cell>202</cell><cell>203</cell><cell>true</cell><cell>true</cell></row>
				';
				}
				if($this->session->userdata('group_id')=='all' or $this->session->userdata('group_id')=='pelayanan'){
				$menu .='
				<row><cell>203</cell><cell>Pelayanan</cell><cell>t_pelayanan</cell><cell>1</cell><cell>204</cell><cell>205</cell><cell>true</cell><cell>true</cell></row>
				';
				}
				if($this->session->userdata('group_id')=='all' or $this->session->userdata('group_id')=='apotik'){
				$menu .='
				<row><cell>204</cell><cell>Apotik</cell><cell>t_apotik</cell><cell>1</cell><cell>206</cell><cell>207</cell><cell>true</cell><cell>true</cell></row>
				';
				}
				if($this->session->userdata('group_id')=='all' or $this->session->userdata('group_id')=='kasir'){
				$menu .='
				<row><cell>205</cell><cell>Kasir</cell><cell>t_kasir</cell><cell>1</cell><cell>208</cell><cell>209</cell><cell>true</cell><cell>true</cell></row>
				
				';
				}
				
				if($this->session->userdata('group_id')=='kabupaten' or $this->session->userdata('group_id')=='all' or $this->session->userdata('group_id')=='apotik' or $this->session->userdata('group_id')=='gudang_puskesmas' ){
				$menu .='
				<row><cell>304</cell><cell>Gudang</cell><cell>t_gudang</cell><cell>1</cell><cell>210</cell><cell>211</cell><cell>true</cell><cell>true</cell></row>				
				
				';
				}
				
				if($this->session->userdata('group_id')=='all' or $this->session->userdata('group_id')=='kabupaten' or $this->session->userdata('group_id')=='puskesmas'){
				$menu .='
				<row><cell>305</cell><cell>Sarana</cell><cell>t_sarana</cell><cell>1</cell><cell>211</cell><cell>212</cell><cell>true</cell><cell>true</cell></row>				
				
				';
				}
				
				if($this->session->userdata('group_id')=='all'){
				$menu .='
				<row><cell>400</cell><cell>Kegiatan Luar Gedung</cell><cell/><cell>0</cell><cell>400</cell><cell>499</cell><cell>false</cell><cell>true</cell><cell>true</cell></row>				
				<row><cell>441</cell><cell>Kegiatan Imunisasi</cell><cell>0</cell><cell>1</cell><cell>441</cell><cell>460</cell><cell>false</cell><cell>false</cell><cell>true</cell></row>
				<row><cell>442</cell><cell>Data Dasar Target</cell><cell>t_data_dasar_target</cell><cell>2</cell><cell>442</cell><cell>443</cell><cell>true</cell><cell>true</cell></row>				
				<row><cell>215</cell><cell>Daftar Imunisasi</cell><cell>t_imunisasi</cell><cell>2</cell><cell>442</cell><cell>443</cell><cell>true</cell><cell>true</cell></row>								
				';
				}
				
				if($this->session->userdata('group_id')=='all'){
				$menu .='				
				<row><cell>460</cell><cell>Kesehatan Lingkungan</cell><cell>0</cell><cell>1</cell><cell>460</cell><cell>470</cell><cell>false</cell><cell>false</cell><cell>true</cell></row>
				<row><cell>461</cell><cell>Rumah Sehat</cell><cell>t_k_rumah_sehat</cell><cell>2</cell><cell>461</cell><cell>465</cell><cell>true</cell><cell>true</cell></row>				
				<row><cell>462</cell><cell>Sanitasi RM dan Restoran</cell><cell>t_k_rm_restoran</cell><cell>2</cell><cell>461</cell><cell>465</cell><cell>true</cell><cell>true</cell></row>								
				<row><cell>463</cell><cell>Inspeksi Pasar</cell><cell>t_k_inspeksi_pasar</cell><cell>2</cell><cell>461</cell><cell>465</cell><cell>true</cell><cell>true</cell></row>								
				<row><cell>464</cell><cell>Pemeriksaan Kesehatan Hotel</cell><cell>t_k_inspeksi_hotel</cell><cell>2</cell><cell>461</cell><cell>465</cell><cell>true</cell><cell>true</cell></row>								
				';
				}
				
				if($this->session->userdata('group_id')=='all'){
				$menu .='				
				<row><cell>471</cell><cell>Posyandu</cell><cell>0</cell><cell>1</cell><cell>471</cell><cell>480</cell><cell>false</cell><cell>false</cell><cell>true</cell></row>
				<row><cell>472</cell><cell>Data Posyandu</cell><cell>t_posyandu</cell><cell>2</cell><cell>472</cell><cell>476</cell><cell>true</cell><cell>true</cell></row>				
				';
				}
				if($this->session->userdata('group_id')=='kabupaten' || $this->session->userdata('group_id')=='all'){
				$menu .='
				<row><cell>800</cell><cell>Data Kesehatan</cell><cell/><cell>0</cell><cell>800</cell><cell>899</cell><cell>false</cell><cell>false</cell><cell>true</cell></row>				
				<row><cell>801</cell><cell>Data Dasar</cell><cell>t_ds_datadasar</cell><cell>1</cell><cell>801</cell><cell>833</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>
				<row><cell>802</cell><cell>Data KIA</cell><cell>t_ds_kia</cell><cell>1</cell><cell>801</cell><cell>833</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>
				<row><cell>803</cell><cell>Data Gizi</cell><cell>t_ds_gizi</cell><cell>1</cell><cell>801</cell><cell>833</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>
				<row><cell>804</cell><cell>Data KB</cell><cell>t_ds_kb</cell><cell>1</cell><cell>801</cell><cell>833</cell><cell>true</cell><cell>false</cell><cell>true</cell></row>
				<row><cell>813</cell><cell>Data Imunisasi</cell><cell>t_ds_imunisasi</cell><cell>1</cell><cell>801</cell><cell>833</cell><cell>true</cell><cell>false</cell><cell>true</cell></row>
				<row><cell>805</cell><cell>Data KESLING</cell><cell>t_ds_kesling</cell><cell>1</cell><cell>801</cell><cell>833</cell><cell>true</cell><cell>false</cell><cell>true</cell></row>
				<row><cell>806</cell><cell>Data UKS</cell><cell>t_ds_uks</cell><cell>1</cell><cell>801</cell><cell>833</cell><cell>true</cell><cell>false</cell><cell>true</cell></row>
				<row><cell>807</cell><cell>Data Kegiatan Puskesmas</cell><cell>t_ds_kegiatanpuskesmas</cell><cell>1</cell><cell>801</cell><cell>833</cell><cell>true</cell><cell>false</cell><cell>true</cell></row>
				<row><cell>808</cell><cell>Data Kematian Ibu</cell><cell>t_ds_kematian_ibu</cell><cell>1</cell><cell>801</cell><cell>833</cell><cell>true</cell><cell>false</cell><cell>true</cell></row>
				<row><cell>809</cell><cell>Data Kematian Bayi</cell><cell>t_ds_kematian_anak</cell><cell>1</cell><cell>801</cell><cell>833</cell><cell>true</cell><cell>false</cell><cell>true</cell></row>
				<row><cell>810</cell><cell>Data PROMKES</cell><cell>t_ds_promkes</cell><cell>1</cell><cell>801</cell><cell>833</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>
				<row><cell>811</cell><cell>Data Gigi</cell><cell>t_ds_gigi</cell><cell>1</cell><cell>801</cell><cell>833</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>
				<row><cell>812</cell><cell>Data UKGS</cell><cell>t_ds_ukgs</cell><cell>1</cell><cell>801</cell><cell>833</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>
				';
				}
				
				//<row><cell>101</cell><cell>Laporan Harian</cell><cell>0</cell><cell>1</cell><cell>101</cell><cell>120</cell><cell>false</cell><cell>false</cell><cell>true</cell></row>
				//<row><cell>102</cell><cell>Laporan Rawat Jalan</cell><cell>report_harian</cell><cell>2</cell><cell>102</cell><cell>103</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>
				if($this->session->userdata('group_id')=='all' or $this->session->userdata('group_id')=='kabupaten' or $this->session->userdata('group_id')=='loket'){
				$menu .='
				<row><cell>100</cell><cell>Laporan</cell><cell/><cell>0</cell><cell>100</cell><cell>199</cell><cell>false</cell><cell>true</cell><cell>true</cell></row>';
				
				if($this->session->userdata('group_id')=='all' or $this->session->userdata('group_id')=='loket'){
				$menu .='<row><cell>331</cell><cell>Laporan Harian</cell><cell>0</cell><cell>1</cell><cell>331</cell><cell>350</cell><cell>false</cell><cell>false</cell><cell>true</cell></row>';
				}
				if($this->session->userdata('group_id')=='all'){
				$menu .='<row><cell>332</cell><cell>Peringkat Diagnosa Penyakit</cell><cell>report_harian/diagnosarj</cell><cell>2</cell><cell>332</cell><cell>333</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>';
				}
				if($this->session->userdata('group_id')=='all' or $this->session->userdata('group_id')=='loket'){
				$menu .='<row><cell>333</cell><cell>Laporan Kunjungan POLI </cell><cell>report_harian/poliharian</cell><cell>2</cell><cell>332</cell><cell>333</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>
				<row><cell>334</cell><cell>Laporan Diagnosa Harian </cell><cell>report_harian/diagnosaharian</cell><cell>2</cell><cell>332</cell><cell>333</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>
				';
				}				
				if($this->session->userdata('group_id')=='all' or $this->session->userdata('group_id')=='kabupaten'){
				$menu .='
				<row><cell>131</cell><cell>Laporan Bulanan</cell><cell>0</cell><cell>1</cell><cell>131</cell><cell>150</cell><cell>false</cell><cell>false</cell><cell>true</cell></row>
				<row><cell>132</cell><cell>LB1</cell><cell>report_bulanan</cell><cell>2</cell><cell>132</cell><cell>133</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>
				<row><cell>133</cell><cell>LB2</cell><cell>report_bulanan/lb2</cell><cell>2</cell><cell>132</cell><cell>133</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>
				<row><cell>134</cell><cell>LB3</cell><cell>report_bulanan/lb3</cell><cell>2</cell><cell>132</cell><cell>133</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>
				<row><cell>135</cell><cell>LB4</cell><cell>report_bulanan/lb4</cell><cell>2</cell><cell>132</cell><cell>133</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>				
				<row><cell>136</cell><cell>Laporan Kunjungan</cell><cell>report_bulanan/lapkunjungan</cell><cell>2</cell><cell>132</cell><cell>133</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>				
				<row><cell>137</cell><cell>Laporan Asuransi</cell><cell>report_bulanan/lapasuransi</cell><cell>2</cell><cell>132</cell><cell>133</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>				
				<row><cell>138</cell><cell>Laporan Odontogram</cell><cell>report_bulanan/lapodontogram</cell><cell>2</cell><cell>132</cell><cell>133</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>
				<row><cell>139</cell><cell>Laporan Tindakan Odontogram</cell><cell>report_bulanan/lapodontogram/tindakan</cell><cell>2</cell><cell>132</cell><cell>133</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>

				';
				}
				if($this->session->userdata('group_id')=='kabupaten'){
				$menu .='
				<row><cell>916</cell><cell>Laporan Datadasar</cell><cell>report_bulanan/lap_datadasar</cell><cell>2</cell><cell>132</cell><cell>133</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>
				<row><cell>902</cell><cell>Laporan Kia</cell><cell>report_bulanan/lapkia</cell><cell>2</cell><cell>132</cell><cell>133</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>
				<row><cell>905</cell><cell>Laporan Kesling</cell><cell>report_bulanan/lapkesling</cell><cell>2</cell><cell>132</cell><cell>133</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>
				<row><cell>903</cell><cell>Laporan Gizi</cell><cell>report_bulanan/lapgizi</cell><cell>2</cell><cell>132</cell><cell>133</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>				
				<row><cell>907</cell><cell>Laporan Kegiatan Puskesmas</cell><cell>report_bulanan/lapkegiatanpuskesmas</cell><cell>2</cell><cell>132</cell><cell>133</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>
				<row><cell>910</cell><cell>Laporan PROMKES</cell><cell>report_bulanan/lappromkes</cell><cell>2</cell><cell>132</cell><cell>133</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>				
				<row><cell>912</cell><cell>Laporan UKGS</cell><cell>report_bulanan/lapukgs</cell><cell>2</cell><cell>132</cell><cell>133</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>
				<row><cell>913</cell><cell>Laporan KB</cell><cell>report_bulanan/lapkb</cell><cell>2</cell><cell>132</cell><cell>133</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>				
				<row><cell>914</cell><cell>Laporan Imunisasi</cell><cell>report_bulanan/lapimunisasi</cell><cell>2</cell><cell>132</cell><cell>133</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>
				<row><cell>908</cell><cell>Laporan Kematian Bayi</cell><cell>report_bulanan/lap_kematian_bayi</cell><cell>2</cell><cell>132</cell><cell>133</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>				
				<row><cell>909</cell><cell>Laporan Kematian Ibu</cell><cell>report_bulanan/lap_kematian_ibu</cell><cell>2</cell><cell>132</cell><cell>133</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>
				<row><cell>915</cell><cell>Laporan UKS</cell><cell>report_bulanan/lapuks</cell><cell>2</cell><cell>132</cell><cell>133</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>
				
				
				';				
				}
				
				}
				if($this->session->userdata('group_id')=='all' || $this->session->userdata('group_id')=='kabupaten'){
					$menu .='
					<row><cell>1</cell><cell>Pengaturan</cell><cell/><cell>0</cell><cell>5</cell><cell>99</cell><cell>false</cell><cell>true</cell><cell>true</cell></row>
					';
					if($this->session->userdata('group_id')=='all'){
					$menu .='
					<row><cell>2</cell><cell>Demografi dan Puskesmas</cell><cell>0</cell><cell>1</cell><cell>6</cell><cell>10</cell><cell>false</cell><cell>false</cell><cell>true</cell></row>
					<row><cell>25</cell><cell>Provinsi</cell><cell>c_master_propinsi</cell><cell>2</cell><cell>7</cell><cell>8</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>26</cell><cell>Kabupaten</cell><cell>c_master_kabupaten</cell><cell>2</cell><cell>7</cell><cell>8</cell><cell>true</cell><cell>true</cell></row>					
					<row><cell>40</cell><cell>Kecamatan</cell><cell>c_master_kecamatan</cell><cell>2</cell><cell>7</cell><cell>8</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>19</cell><cell>Kelurahan/Desa</cell><cell>c_master_kelurahan</cell><cell>2</cell><cell>7</cell><cell>8</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>51</cell><cell>Puskesmas</cell><cell>c_master_puskesmas</cell><cell>2</cell><cell>7</cell><cell>8</cell><cell>true</cell><cell>true</cell></row>
					
					<row><cell>3</cell><cell>Kebutuhan Pasien</cell><cell>0</cell><cell>1</cell><cell>11</cell><cell>15</cell><cell>false</cell><cell>false</cell><cell>true</cell></row>
					<row><cell>41</cell><cell>Agama</cell><cell>c_master_agama</cell><cell>2</cell><cell>12</cell><cell>13</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>53</cell><cell>Cara Bayar </cell><cell>c_master_cara_bayar</cell><cell>2</cell><cell>12</cell><cell>13</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>55</cell><cell>Cara Masuk Pasien</cell><cell>c_master_cara_masuk_pasien</cell><cell>2</cell><cell>12</cell><cell>13</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>31</cell><cell>Jenis Kelamin</cell><cell>c_master_jenis_kelamin</cell><cell>2</cell><cell>12</cell><cell>13</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>63</cell><cell>Ras/Suku</cell><cell>c_master_ras</cell><cell>2</cell><cell>12</cell><cell>13</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>64</cell><cell>Status Marital</cell><cell>c_master_status_marital</cell><cell>2</cell><cell>12</cell><cell>13</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>32</cell><cell>Gol Darah</cell><cell>c_master_gol_darah</cell><cell>2</cell><cell>12</cell><cell>13</cell><cell>true</cell><cell>true</cell></row>					
					<row><cell>42</cell><cell>Pendidikan</cell><cell>c_master_pendidikan</cell><cell>2</cell><cell>12</cell><cell>13</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>54</cell><cell>Pekerjaan</cell><cell>c_master_pekerjaan</cell><cell>2</cell><cell>12</cell><cell>13</cell><cell>true</cell><cell>true</cell></row>					
					
					<row><cell>4</cell><cell>Farmasi</cell><cell>0</cell><cell>1</cell><cell>16</cell><cell>21</cell><cell>false</cell><cell>false</cell><cell>true</cell></row>
					<row><cell>61</cell><cell>Obat</cell><cell>c_master_obat</cell><cell>2</cell><cell>19</cell><cell>20</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>22</cell><cell>Golongan Obat</cell><cell>c_master_gol_obat</cell><cell>2</cell><cell>19</cell><cell>20</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>23</cell><cell>Harga Obat</cell><cell>c_master_harga_obat</cell><cell>2</cell><cell>19</cell><cell>20</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>73</cell><cell>Jenis Obat</cell><cell>c_master_jenis_obat</cell><cell>2</cell><cell>19</cell><cell>20</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>74</cell><cell>Milik Obat</cell><cell>c_master_milik_obat</cell><cell>2</cell><cell>19</cell><cell>20</cell><cell>true</cell><cell>true</cell></row>					
					<row><cell>71</cell><cell>Satuan Besar</cell><cell>c_master_satuan_besar</cell><cell>2</cell><cell>19</cell><cell>20</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>72</cell><cell>Satuan Kecil</cell><cell>c_master_satuan_kecil</cell><cell>2</cell><cell>19</cell><cell>20</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>43</cell><cell>Data Terapi Obat</cell><cell>c_master_terapi_obat</cell><cell>2</cell><cell>19</cell><cell>20</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>44</cell><cell>Data Unit Farmasi/Apotik</cell><cell>c_master_unit_farmasi</cell><cell>2</cell><cell>19</cell><cell>20</cell><cell>true</cell><cell>true</cell></row>					
					
					<row><cell>98</cell><cell>Petugas</cell><cell>0</cell><cell>1</cell><cell>22</cell><cell>26</cell><cell>false</cell><cell>false</cell><cell>true</cell></row>
					<row><cell>65</cell><cell>Golongan Petugas</cell><cell>c_master_golongan</cell><cell>2</cell><cell>23</cell><cell>24</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>62</cell><cell>Petugas</cell><cell>c_master_petugas</cell><cell>2</cell><cell>23</cell><cell>24</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>11</cell><cell>Posisi</cell><cell>c_master_posisi</cell><cell>2</cell><cell>23</cell><cell>24</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>13</cell><cell>Spesialisasi</cell><cell>c_master_spesialisasi</cell><cell>2</cell><cell>23</cell><cell>24</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>66</cell><cell>Pendidikan Kesehatan</cell><cell>c_master_pendidikan_kesehatan</cell><cell>2</cell><cell>23</cell><cell>24</cell><cell>true</cell><cell>true</cell></row>
					
					<row><cell>5</cell><cell>Pelayanan</cell><cell>0</cell><cell>1</cell><cell>31</cell><cell>35</cell><cell>false</cell><cell>false</cell><cell>true</cell></row>					
					<row><cell>15</cell><cell>Sarana Posyandu</cell><cell>c_master_sarana_posyandu</cell><cell>2</cell><cell>32</cell><cell>34</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>16</cell><cell>Transfer</cell><cell>c_master_transfer</cell><cell>2</cell><cell>32</cell><cell>34</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>70</cell><cell>Tindakan</cell><cell>c_master_tindakan</cell><cell>2</cell><cell>32</cell><cell>34</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>14</cell><cell>Asal Pasien</cell><cell>c_master_asal_pasien</cell><cell>2</cell><cell>32</cell><cell>34</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>35</cell><cell>Unit Pelayanan</cell><cell>c_master_unit_pelayanan</cell><cell>2</cell><cell>32</cell><cell>34</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>57</cell><cell>ICD Induk</cell><cell>c_master_icd_induk</cell><cell>2</cell><cell>32</cell><cell>34</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>33</cell><cell>ICD</cell><cell>c_master_icd</cell><cell>2</cell><cell>32</cell><cell>34</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>52</cell><cell>Jenis Kasus</cell><cell>c_master_jenis_kasus</cell><cell>2</cell><cell>32</cell><cell>34</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>21</cell><cell>Kasus</cell><cell>c_master_kasus</cell><cell>2</cell><cell>32</cell><cell>34</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>27</cell><cell>Dokter dan Petugas Kesehatan</cell><cell>c_master_dokter</cell><cell>2</cell><cell>32</cell><cell>34</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>35</cell><cell>Unit Pelayanan</cell><cell>c_master_unit_pelayanan</cell><cell>2</cell><cell>32</cell><cell>34</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>29</cell><cell>KIA</cell><cell>c_master_kia</cell><cell>2</cell><cell>32</cell><cell>34</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>24</cell><cell>KIA Master Keadaan Sehat</cell><cell>c_master_keadaan_kesehatan</cell><cell>2</cell><cell>32</cell><cell>34</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>36</cell><cell>Kamar</cell><cell>c_master_kamar</cell><cell>2</cell><cell>32</cell><cell>34</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>34</cell><cell>Status Keluar Pasien</cell><cell>c_master_status_keluar_pasien</cell><cell>2</cell><cell>32</cell><cell>34</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>45</cell><cell>Ruangan</cell><cell>c_master_ruangan</cell><cell>2</cell><cell>32</cell><cell>34</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>67</cell><cell>Kelompok Pasien</cell><cell>c_master_kel_pasien</cell><cell>2</cell><cell>32</cell><cell>34</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>58</cell><cell>Kategori Imunisasi</cell><cell>c_master_kategori_imunisasi</cell><cell>2</cell><cell>32</cell><cell>34</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>59</cell><cell>Jenis Pasien</cell><cell>c_master_jenis_pasien</cell><cell>2</cell><cell>32</cell><cell>34</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>60</cell><cell>Jenis Imunisasi</cell><cell>c_master_jenis_imunisasi</cell><cell>2</cell><cell>32</cell><cell>34</cell><cell>true</cell><cell>true</cell></row>
		
					<row><cell>901</cell><cell>Letak Janin</cell><cell>c_master_letak_janin</cell><cell>2</cell><cell>32</cell><cell>34</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>900</cell><cell>Retribusi</cell><cell>c_master_retribusi</cell><cell>2</cell><cell>32</cell><cell>34</cell><cell>true</cell><cell>true</cell></row>
					
					/**
					 * Cell Gigi 
					 */
					
					<row><cell>10001</cell><cell>Odontogram</cell><cell>0</cell><cell>1</cell><cell>40</cell><cell>44</cell><cell>false</cell><cell>false</cell><cell>true</cell></row>					
					<row><cell>1001</cell><cell>Nomenklatur</cell><cell>c_master_gigi</cell><cell>2</cell><cell>41</cell><cell>43</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>1003</cell><cell>Status Gigi</cell><cell>c_master_gigi_status</cell><cell>2</cell><cell>41</cell><cell>43</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>1004</cell><cell>Permukaan Gigi</cell><cell>c_master_gigi_permukaan</cell><cell>2</cell><cell>41</cell><cell>43</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>1005</cell><cell>Gambar Permukaan Gigi</cell><cell>c_map_gigi_permukaan</cell><cell>2</cell><cell>41</cell><cell>43</cell><cell>true</cell><cell>true</cell></row>
					


					/*------------------------------------------------------ */
					
					';
					}
					if($this->session->userdata('group_id')=='all' || $this->session->userdata('group_id')=='kabupaten'){
					$menu .='
					<row><cell>6</cell><cell>Atur Aplikasi</cell><cell>0</cell><cell>1</cell><cell>27</cell><cell>30</cell><cell>false</cell><cell>false</cell><cell>true</cell></row>		
					';
					
						if($this->session->userdata('group_id')=='all'){
						$menu .='
						<row><cell>56</cell><cell>Setting Dalam Wilayah Kerja</cell><cell>c_sys_setting_def_dw</cell><cell>2</cell><cell>28</cell><cell>29</cell><cell>true</cell><cell>true</cell></row>
						<row><cell>30</cell><cell>Setting Aplikasi</cell><cell>c_sys_setting_def</cell><cell>2</cell><cell>28</cell><cell>29</cell><cell>true</cell><cell>true</cell></row>';
						}
						$menu .='	<row><cell>75</cell><cell>Pengguna</cell><cell>c_master_users</cell><cell>2</cell><cell>28</cell><cell>29</cell><cell>true</cell><cell>true</cell></row>
					<row><cell>17</cell><cell>Group Pengguna</cell><cell>c_master_user_group</cell><cell>2</cell><cell>28</cell><cell>29</cell><cell>true</cell><cell>true</cell></row>
					
					';
					}
				}				
				/*$menu .='
				<row><cell>12</cell><cell>Logout</cell><cell>login/mlogout</cell><cell>0</cell><cell>31</cell><cell>32</cell><cell>true</cell><cell>false</cell></row>				
				';	*/
				if($this->session->userdata('group_id')=='all'){
					$menu .='
					<row><cell>7</cell><cell>Export Data</cell><cell>0</cell><cell>1</cell><cell>28</cell><cell>31</cell><cell>false</cell><cell>false</cell><cell>true</cell></row>					
					<row><cell>1000</cell><cell>Export</cell><cell>c_export_data</cell><cell>2</cell><cell>29</cell><cell>30</cell><cell>true</cell><cell>true</cell></row>
					';
				}elseif($this->session->userdata('group_id')=='kabupaten'){
					$menu .='
					<row><cell>917</cell><cell>Import Data</cell><cell>c_import_data</cell><cell>0</cell><cell>101</cell><cell>200</cell><cell>true</cell><cell>true</cell><cell>true</cell></row>';
				
				}
				$menu .='
					
			</rows>
		';		
		echo $menu;exit();
	}
	
}

/* End of file dashboard.php */
/* Location: ./sikdaapplication/controllers/dashboard.php */