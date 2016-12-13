<script>
$(document).ready(function(){
		$('#form1ds_kiaadd').ajaxForm({
			beforeSend: function() {
				achtungShowLoader();	
			},
			uploadProgress: function(event, position, total, percentComplete) {
			},
			complete: function(xhr) {
				achtungHideLoader();
				if(xhr.responseText!=='OK'){
					$.achtung({message: xhr.responseText, timeout:5});
				}else{
					$.achtung({message: 'Proses Tambah Data Berhasil', timeout:5});
					$("#t802","#tabs").empty();
					$("#t802","#tabs").load('t_ds_kia'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$("#form1ds_kiaadd").validate({
			rules: {
				tanggal_inspeksi: {
					date:true,
					required: true
				}
			},
			messages: {
				tanggal_inspeksi: {
					required:"Silahkan Lengkapi Data"
				}
			}
		});
})

//$("#kabupaten_kotarmh_sehatadd").remoteChained("#provinsirmh_sehatadd", "<?=site_url('t_masters/getKabupatenByProvinceId2')?>");
//$("#kecamatanrmh_sehatadd").remoteChained("#kabupaten_kotarmh_sehatadd", "<?=site_url('t_masters/getKecamatanByKabupatenId2')?>");
//$("#kelurahanrmh_sehatadd").remoteChained("#kecamatanrmh_sehatadd", "<?=site_url('t_masters/getKelurahanByKecamatanId2')?>");
//$("#kec_id_combo_ds_kia").remoteChained("#kab_id_combo_ds_gigi", "<?=site_url('t_masters/getKabupatenByProvinceID3')?>");
$("#desa_kel_id_combo_ds_kia").remoteChained("#kec_id_combo_ds_kia", "<?=site_url('t_masters/getKelurahanByKecamatanId3')?>");
$("#puskesmas_id_combo_ds_kia").remoteChained("#kec_id_combo_ds_kia", "<?=site_url('t_masters/getPuskesmasByKecamatanId2')?>");

$(':text,:radio,:checkbox,select,textarea').bind("keydown", function(e) {
   var n = $(":text,:radio,:checkbox,select,textarea").length;
   if (e.which == 13) 
   {
		e.preventDefault();
		var nextIndex = $(':text,:radio,:checkbox,select,textarea').index(this) + 1;
		var thisIndex = $(':text,:radio,:checkbox,select,textarea').index(this);
		$(':text,:radio,:checkbox,select,textarea')[nextIndex].focus();
   }
});
</script>
<script>
	$('#backlistds_kia').click(function(){
		$("#t802","#tabs").empty();
		$("#t802","#tabs").load('t_ds_kia'+'?_=' + (new Date()).getTime());
	})
	$("#tahun_ds_kia").mask("9999");
</script>
<style>
input[type=text] {width: 55px!important;}
label{width:295px!important;}
</style>

<style>
.menu_jk{
	width:100%;
}
.menu_l{
	float:left;
	padding-left:335px;
	font-size:12px;
}
.menu_p{
	float:left;
	padding-left:60px;
	font-size:12px;
}
</style>

<div class="mycontent">
<div class="formtitle">Tambah Data Kia</div>
<div class="backbutton"><span class="kembali" id="backlistds_kia">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<div class="subformtitle">PELAYANAN MEDIK DASAR DI BP KIA</div>
<form name="frApps" id="form1ds_kiaadd" method="post" action="<?=site_url('t_ds_kia/addprocess')?>" enctype="multipart/form-data">		
	<fieldset>
		<span>
		<label>Propinsi</label>
		<input type="text" style="width:195px!important" name="" id="textid" value="<?=$this->session->userdata('nama_propinsi')?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kabupaten</label>
		<input type="text" style="width:195px!important" name="" id="textid" value="<?=$this->session->userdata('nama_kabupaten')?>" disabled />
		</span>
	</fieldset>
	<?=getComboKecamatanByKab($this->session->userdata('kd_kecamatan'),'KD_KECAMATAN','kec_id_combo_ds_kia','required','')?>
	<?=getComboKelurahanByKec($this->session->userdata('kd_kelurahan'),'KD_KELURAHAN','desa_kel_id_combo_ds_kia','required','')?>
	<?=getComboPuskesmasByKec('','KD_PUSKESMAS','puskesmas_id_combo_ds_kia','required','')?>
	<fieldset>
		<span>
		<label>Bulan*</label>
		<select name="BULAN" required>
			<option value="">- pilih bulan -</option>
			<option value="01">Januari</option>
			<option value="02">Februari</option>
			<option value="03">Maret</option>
			<option value="04">April</option>
			<option value="05">Mei</option>
			<option value="06">Juni</option>
			<option value="07">Juli</option>
			<option value="08">Agustus</option>
			<option value="09">September</option>
			<option value="10">Oktober</option>
			<option value="11">November</option>
			<option value="12">Desember</option>
		</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tahun*</label>
		<input type="text" name="TAHUN" id="tahun_ds_kia" value="" required />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">JUMLAH BUMIL</div>
	<fieldset>
		<span>
		<label>KUNJUNGAN K1 BUMIL</label>
		<input type="text" name="JML_KJ_K1_BUMIL" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KUNJUNGAN K4 BUMIL</label>
		<input type="text" name="JML_KJ_K4_BUMIL" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">BUMIL RESIKO</div>
	<fieldset>
		<span>
		<label>KUNJUNGAN BUMIL RESTI OLEH MASYARAKAT</label>
		<input type="text" name="JML_KJ_BR_R_MASYARAKAT" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KUNJUNGAN BUMIL RESTI OLEH NAKES</label>
		<input type="text" name="JML_KJ_BR_R_NAKES" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BUMIL DENGAN RESTI YANG DIRUJUK KE PUSKESMAS</label>
		<input type="text" name="JML_B_R_R_YD_PUSKESMAS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BUMIL DENGAN RESTI YANG DIRUJUK KE RUMAH SAKIT</label>
		<input type="text" name="JML_B_R_R_YD_RUMAH_SAKIT" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEMATIAN IBU HAMIL</label>
		<input type="text" name="JML_K_BR_I_HAMIL" value=""  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">IBU BERSALIN</div>
	<fieldset>
		<span>
		<label>PERSALINAN OLEH TENAGA KESEHATAN</label>
		<input type="text" name="JML_P_IB_T_KESEHATAN" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PERSALINAN OLEH TENAGA DUKUN</label>
		<input type="text" name="JML_P_IB_T_DUKUN" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>IBU BERSALIN DI RUJUK KE PUSKESMAS</label>
		<input type="text" name="JML_I_B_DRJ_PUSKESMAS" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>IBU BERSALIN DI RUJUK KE RUMAH SAKIT</label>
		<input type="text" name="JML_I_B_DRJ_RUMAH_SAKIT" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEMATIAN IBU BERSALIN</label>
		<input type="text" name="JML_K_I_BERSALIN" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEMATIAN IBU NIFAS</label>
		<input type="text" name="JML_K_I_NIFAS" value=""  />
		</span>
	</fieldset>
	<br />
	<div class="subformtitle1">NEONATAL</div>
	<div class="menu_jk">
	<div class="menu_l"><b>L</b></div><div class="menu_p"><b>P</b></div>
	</div>
	</br>
	<fieldset>
		<span>
		<label>KUNJUNGAN NEONATAL BARU (KN 1)</label>
		<input type="text" placeholder="L" name="JML_KJ_N_BR_0_7HARI_KN1" value=""  />
		<input type="text" placeholder="p" name="JML_KJ_N_BR_0_7HARI_KN1_p" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KUNJUNGAN NEONATAL LENGKAP (KN LENGKAP)</label>
		<input type="text" placeholder="L" name="JML_KJ_N_BR_8_28HARI_KN2" value=""  />
		<input type="text" placeholder="P" name="JML_KJ_N_BR_8_28HARI_KN2_p" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BAYI DENGAN BBL < 2500 GR</label>
		<input type="text" placeholder="L" name="JML_B_N_BBL_K_2500GR" value=""  />
		<input type="text" placeholder="P" name="JML_B_N_BBL_K_2500GR_p" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BBLR DILAYANI TENAGA KESEHATAN</label>
		<input type="text" placeholder="L" name="JML_BBLR_N_D_T_KESEHATAN" value=""  />
		<input type="text" placeholder="P" name="JML_BBLR_N_D_T_KESEHATAN_p" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BAYI DENGAN BBL 2500 - 3000 GR</label>
		<input type="text" placeholder="L" name="B_N_D_BBL_2500_3000GR" value=""  />
		<input type="text" placeholder="P" name="B_N_D_BBL_2500_3000GR_p" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BAYI DENGAN BBL > 3000 GR</label>
		<input type="text" placeholder="L" name="JML_B_N_D_BBL_L_3000GR" value=""  />
		<input type="text" placeholder="P" name="JML_B_N_D_BBL_L_3000GR_p" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BAYI LAHIR HIDUP</label>
		<input type="text" placeholder="L" name="B_N_L_HIDUP" value=""  />
		<input type="text" placeholder="P" name="B_N_L_HIDUP_p" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BAYI LAHIR MATI</label>
		<input type="text" placeholder="L" name="B_N_L_MATI" value=""  />
		<input type="text" placeholder="P" name="B_N_L_MATI_p" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEMATIAN BAYI UMUR 0-7 HARI</label>
		<input type="text" placeholder="L" name="K_B_N_UMR_0_7_HARI" value=""  />
		<input type="text" placeholder="P" name="K_B_N_UMR_0_7_HARI_p" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEMATIAN BAYI UMUR 8HR-1BL</label>
		<input type="text" placeholder="L" name="K_B_N_UMR_8HR_1BL" value=""  />
		<input type="text" placeholder="P" name="K_B_N_UMR_8HR_1BL_p" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEMATIAN BAYI UMUR 1BL-1THN</label>
		<input type="text" placeholder="L" name="K_B_N_UMR_1BL_1THN" value=""  />
		<input type="text" placeholder="P" name="K_B_N_UMR_1BL_1THN_p" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KEMATIAN BALITA</label>
		<input type="text" placeholder="L" name="K_N_BALITA" value=""  />
		<input type="text" placeholder="P" name="K_N_BALITA_p" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NEONATAL RESTI</label>
		<input type="text" placeholder="L" name="N_RESTI" value=""  />
		<input type="text" placeholder="P" name="N_RESTI_p" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NEONATAL RESTI DIRUJUK KE PUSKESMAS</label>
		<input type="text" placeholder="L" name="N_R_DRJ_PUSKESMAS" value=""  />
		<input type="text" placeholder="P" name="N_R_DRJ_PUSKESMAS_p" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NEONATAL RESTI DIRUJUK RS</label>
		<input type="text" placeholder="L" name="N_R_DRJ_RS" value=""  />
		<input type="text" placeholder="P" name="N_R_DRJ_RS_p" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BALITA YANG DIDETEKSI TUMBUH KEMBANGNYA</label>
		<input type="text" placeholder="L" name="B_N_YG_DTK_TBH_KEMBANGNYA" value=""  />
		<input type="text" placeholder="P" name="B_N_YG_DTK_TBH_KEMBANGNYA_p" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK DENGAN KELAINAN TUMBUH KEMBANG</label>
		<input type="text" placeholder="L" name="A_N_D_KLN_TBH_KEMBANG" value=""  />
		<input type="text" placeholder="P" name="A_N_D_KLN_TBH_KEMBANG_p" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH NEONATUS DENGAN KOMPLIKASI YANG DITANGANI (BARU/ULANG)</label>
		<input type="text" placeholder="L" name="NEONATUS_KOMPLIKASI_L" value=""  />
		<input type="text" placeholder="P" name="NEONATUS_KOMPLIKASI_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH NEONATUS YANG MENDAPAT PELAYANAN SKRINING HIPOTIROID KONGENITAL (SHK)</label>
		<input type="text" placeholder="L" name="NEONATUS_SHK_L" value=""  />
		<input type="text" placeholder="P" name="NEONATUS_SHK_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH BALITA YANG TELAH MENDAPATKAN PELAYANAN SDIDTK SEBANYAK 2 KALI TAHUN INI</label>
		<input type="text" placeholder="L" name="BALITA_SDIDTK_L" value=""  />
		<input type="text" placeholder="P" name="BALITA_SDIDTK_P" value=""  />
		</span>
	</fieldset>
	<div class="subformtitle1">ANAK DAN REMAJA</div>
	<fieldset>
		<span>
		<label>JUMLAH ANAK PRASEKOLAH YANG MENDAPATKAN PELAYANAN SDIDTK SEBANYAK 2 KALI TAHUN INI</label>
		<input type="text" placeholder="L" name="ANAK_PRA_SDIDTK_L" value=""  />
		<input type="text" placeholder="P" name="ANAK_PRA_SDIDTK_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH REMAJA (10-19 TAHUN) YANG MENDAPATKAN KONSELING OLEH TENAGA KESEHATAN (BARU/ULANG PADA KASUS YANG SAMA)</label>
		<input type="text" placeholder="L" name="REMAJA_KONSELING_L" value=""  />
		<input type="text" placeholder="P" name="REMAJA_KONSELING_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KELOMPOK REMAJA DILUAR SEKOLAH (KARANG TARUNA, REMAJA MESJID, GEREJA, PURA, WIHARA, DLL) YANG MENDAPATKAN KIE KESEHATAN REMAJA</label>
		<input type="text" placeholder="L" name="REMAJA_KIE_L" value=""  />
		<input type="text" placeholder="P" name="REMAJA_KIE_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANAK DAN REMAJA (UMUR KURANG DARI 20 TAHUN) DENGAN DISABILITAS YANG DITANGANI (BARU/ULANG)</label>
		<input type="text" placeholder="L" name="REMAJA_DISABILITAS_L" value=""  />
		<input type="text" placeholder="P" name="REMAJA_DISABILITAS_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANAK DAN REMAJA (UMUR KURANG DARI 20 TAHUN) KORBAN KEKERASAN (KEKERASAN SEKSUAL, FISIK, EMOSIONAL, PENELANTARAN DAN TRAFFICKING) YANG DITANGANI (PELAYANAN MEDIS, VISUM, PELAYANAN KONSELING, RUJUK, DLL) (BARU/ULANG)</label>
		<input type="text" placeholder="L" name="REMAJA_KORBAN_KEKERASAN_DITANGANI_L" value=""  />
		<input type="text" placeholder="P" name="REMAJA_KORBAN_KEKERASAN_DITANGANI_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANAK KORBAN KEKERASAN YANG DIRUJUK (MEDIS, PSIKOSOSIAL, HUKUM)</label>
		<input type="text" placeholder="L" name="REMAJA_KORBAN_KEKERASAN_DIRUJUK_L" value=""  />
		<input type="text" placeholder="P" name="REMAJA_KORBAN_KEKERASAN_DIRUJUK_P" value=""  />
		</span>
	</fieldset>
	<div class="subformtitle1">KUNJUNGAN KE TK (TAMAN KANAK-KANAK)</div>
	<fieldset>
		<span>
		<label>JUMLAH TK YANG ADA</label>
		<input type="text" placeholder="L" name="JML_KJ_TK_ADA" value=""  />
		<input type="text" placeholder="P" name="JML_KJ_TK_ADA_p" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH TK YANG DIKUNJUNGI</label>
		<input type="text" placeholder="L" name="JML_KJ_TK_DIKUNJUNGI" value=""  />
		<input type="text" placeholder="P" name="JML_KJ_TK_DIKUNJUNGI_p" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>MURID TK YANG DIPERIKSA</label>
		<input type="text" name="M_KJ_TK_DIPERIKSA" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>MURID TK YANG DIRUJUK</label>
		<input type="text" name="M_KJ_TK_DIRUJUK" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >