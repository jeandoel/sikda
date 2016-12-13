<script>
$(document).ready(function(){
		$('#form1ds_kegiatanpuskesmasadd').ajaxForm({
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
					$("#t807","#tabs").empty();
					$("#t807","#tabs").load('t_ds_kegiatanpuskesmas'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		$("#form1ds_kegiatanpuskesmasadd").validate({
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
//$("#kec_id_combo_ds_kegiatanpuskesmas").remoteChained("#kab_id_combo_ds_kegiatanpuskesmas", "<?=site_url('t_masters/getKabupatenByProvinceID3')?>");
$("#desa_kel_id_combo_ds_kegiatanpuskesmas").remoteChained("#kec_id_combo_ds_kegiatanpuskesmas", "<?=site_url('t_masters/getKelurahanByKecamatanId3')?>");
$("#puskesmas_id_combo_ds_kegiatanpuskesmas").remoteChained("#kec_id_combo_ds_kegiatanpuskesmas", "<?=site_url('t_masters/getPuskesmasByKecamatanId2')?>");

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
	$('#backlistds_kegiatanpuskesmas').click(function(){
		$("#t807","#tabs").empty();
		$("#t807","#tabs").load('t_ds_kegiatanpuskesmas'+'?_=' + (new Date()).getTime());
	})
	$("#tahun_ds_kegiatanpuskesmas").mask("9999");
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
<div class="formtitle">Tambah Data Kegiatan Puskesmas</div>
<div class="backbutton"><span class="kembali" id="backlistds_kegiatanpuskesmas">kembali ke list</span></div>
</br>

<span id='errormsg'></span>

<form name="frApps" id="form1ds_kegiatanpuskesmasadd" method="post" onsubmit="bt1.disabled = true; return true;" action="<?=site_url('t_ds_kegiatanpuskesmas/addprocess')?>" enctype="multipart/form-data">		
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
	<?=getComboKecamatanByKab($this->session->userdata('kd_kecamatan'),'KD_KECAMATAN','kec_id_combo_ds_kegiatanpuskesmas','required','')?>
	<?=getComboKelurahanByKec($this->session->userdata('kd_kelurahan'),'KD_KELURAHAN','desa_kel_id_combo_ds_kegiatanpuskesmas','required','')?>
	<?=getComboPuskesmasByKec('','KD_PUSKESMAS','puskesmas_id_combo_ds_kegiatanpuskesmas','required','')?>
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
		<input type="text" name="TAHUN" id="tahun_ds_kegiatanpuskesmas" value="" required />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">A. KEGIATAN RUJUKAN</div>
	<div class="menu_jk">
	<div class="menu_l"><b>L</b></div><div class="menu_p"><b>P</b></div>
	</div>
	<br>
	<fieldset>
		<span>
		<label>JUMLAH DIRUJUK DARI PUSKESMAS</label>
		<input type="text" placeholder="L" name="JML_KR_DARI_PUSKESMAS" value=""  />
		<input type="text" placeholder="P" name="JML_KR_DARI_PUSKESMAS_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH RUJUKAN BALIK RUMAH SAKIT</label>
		<input type="text" placeholder="L" name="JML_KR_B_RUMAH_SAKIT" value=""  />
		<input type="text" placeholder="P" name="JML_KR_B_RUMAH_SAKIT_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH RUJUKAN KADER KE PUSKESMAS</label>
		<input type="text" placeholder="L" name="JML_KR_KA_PUSKESMAS" value=""  />
		<input type="text" placeholder="P" name="JML_KR_KA_PUSKESMAS_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH RUJUKAN POSYANDU KE PUSKESMAS</label>
		<input type="text" placeholder="L" name="JML_KR_PO_PUSKESMAS" value=""  />
		<input type="text" placeholder="P" name="JML_KR_PO_PUSKESMAS_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH RUJUKAN PUSTU KE PUSKESMAS</label>
		<input type="text" placeholder="L" name="JML_KR_PU_PUSKESMAS" value=""  />
		<input type="text" placeholder="P" name="JML_KR_PU_PUSKESMAS_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH RUJUKAN SEKOLAH KE PUSKESMAS</label>
		<input type="text" placeholder="L" name="JML_KR_SE_PUSKESMAS" value=""  />
		<input type="text" placeholder="P" name="JML_KR_SE_PUSKESMAS_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH LAIN-LAIN RUJUKAN KE PUSKESMAS</label>
		<input type="text" placeholder="L" name="JML_KR_LAIN_PUSKESMAS" value=""  />
		<input type="text" placeholder="P" name="JML_KR_LAIN_PUSKESMAS_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH RUJUKAN KE PUSKESMAS</label>
		<input type="text" placeholder="L" name="JML_KR_KE_PUSKESMAS" value=""  />
		<input type="text" placeholder="P" name="JML_KR_KE_PUSKESMAS_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN DOKTER AHLI</label>
		<input type="text" placeholder="L" name="JML_KR_K_DOKTER_AHLI" value=""  />
		<input type="text" placeholder="P" name="JML_KR_K_DOKTER_AHLI_P" value=""  />
		</span>
	</fieldset>
	<br/>
	<div class="subformtitle1">B. KEGIATAN LABORATORIUM</div>
	<fieldset>
		<span>
		<label>PEMERIKSAAN SPECIMEN DARAH</label>
		<input type="text" placeholder="L" name="KL_PS_DARAH" value=""  />
		<input type="text" placeholder="P" name="KL_PS_DARAH_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PEMERIKSAAN SPECIMEN URINE/AIR SENI :</label>
		<input type="text" placeholder="L" name="KL_PS_URINE" value=""  />
		<input type="text" placeholder="P" name="KL_PS_URINE_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PEMERIKSAAN SPECIMEN TINJA :</label>
		<input type="text" placeholder="L" name="KL_PS_TINJA" value=""  />
		<input type="text" placeholder="P" name="KL_PS_TINJA_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PEMERIKSAAN SPECIMEN LAIN :</label>
		<input type="text" placeholder="L" name="KL_PS_LAIN" value=""  />
		<input type="text" placeholder="P" name="KL_PS_LAIN_P" value=""  />
		</span>
	</fieldset>
	<br/>
	<div class="subformtitle1">C. KEGIATAN PERAWATAN KESEHATAN MASYARAKAT</div>
	<div class="subformtitle3">C1. PEMBINAAN KELUARGA RAWAN</div>
	<fieldset>
		<span>
		<label>JUMLAH KELUARGA RAWAN TERCATAT DIPUSKESMAS :</label>
		<input type="text" placeholder="L" name="JML_PKR_PUSKESMAS" value=""  />
		<input type="text" placeholder="P" name="JML_PKR_PUSKESMAS_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KELUARGA RAWAN YG SELESAI DIBINA :</label>
		<input type="text" placeholder="L" name="JML_PKR_DIBINA" value=""  />
		<input type="text" placeholder="P" name="JML_PKR_DIBINA_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN KE KELUARGA RAWAN YG SELESAI DIBINA :</label>
		<input type="text" placeholder="L" name="JML_PKR_KUNJUNGAN_DIBINA" value=""  />
		<input type="text" placeholder="P" name="JML_PKR_KUNJUNGAN_DIBINA_P" value=""  />
		</span>
	</fieldset>
	<div class="subformtitle3">C2. TINDAK LANJUT PERAWATAN YANG SELESAI DIBINA</div>
	<fieldset>
		<span>
		<label>JUMLAH KASUS TINDAK LANJUT PERAWATAN YANG SELESAI DIBINA :</label>
		<input type="text" placeholder="L" name="JML_KASUS_TLPSB" value=""  />
		<input type="text" placeholder="P" name="JML_KASUS_TLPSB_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JML KUNJ. PEMBINAAN KASUS TINDAK LANJUT PERAWATAN YG SELESAI DIBINA :</label>
		<input type="text" placeholder="L" name="JML_KUNJ_TLPSB" value=""  />
		<input type="text" placeholder="P" name="JML_KUNJ_TLPSB_P" value=""  />
		</span>
	</fieldset>
	<div class="subformtitle3">C3. PEMBINAAN GOLONGAN RESIKO BUMIL DAN BALITA</div>
	<fieldset>
		<span>
		<label>JUMLAH BUMIL YANG MEMPEROLEH ASUHAN PERAWATAN :</label>
		<!--<input type="text" placeholder="L" name="JML_PGR_BUMIL_PERAWATAN" value=""  />-->
		<input type="text" style="width:125px!important"  placeholder="P" name="JML_PGR_BUMIL_PERAWATAN_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH BALITA YANG MEMPEROLEH ASUHAN KEPERAWATAN :</label>
		<input type="text" placeholder="L" name="JML_PGR_BALITA_PERAWATAN" value=""  />
		<input type="text" placeholder="P" name="JML_PGR_BALITA_PERAWATAN_P" value=""  />
		</span>
	</fieldset>
	<div class="subformtitle3">C4. PEMBINAAN KELOMPOK KHUSUS/PANTI</div>
	<fieldset>
		<span>
		<label>JUMLAH KELOMPOK KHUSUS/PANTI YANG DIBINA :</label>
		<input type="text" placeholder="L" name="JML_PKKP_DIBINA" value=""  />
		<input type="text" placeholder="P" name="JML_PKKP_DIBINA_P" value=""  />
		</span>
	</fieldset>
	<br/>
	<div class="subformtitle1">D. KEGIATAN KUNJUNGAN</div>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN UMUM BAYAR :</label>
		<input type="text" placeholder="L" name="JML_KK_UMUM_BAYAR" value=""  />
		<input type="text" placeholder="P" name="JML_KK_UMUM_BAYAR_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN ASKES :</label>
		<input type="text" placeholder="L" name="JML_KK_ASKES" value=""  />
		<input type="text" placeholder="P" name="JML_KK_ASKES_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN JPS / KARTU SEHAT :</label>
		<input type="text" placeholder="L" name="JML_KK_JPS_K_SEHAT" value=""  />
		<input type="text" placeholder="P" name="JML_KK_JPS_K_SEHAT_P" value=""  />
		</span>
	</fieldset>
	<br/>
	<div class="subformtitle1">E. RAWAT TINGGAL</div>
	<fieldset>
		<span>
		<label>JUMLAH PENDERITA YANG DIRAWAT :</label>
		<input type="text" placeholder="L" name="JML_RT_P_DIRAWAT" value=""  />
		<input type="text" placeholder="P" name="JML_RT_P_DIRAWAT_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH HARI PERAWATAN :</label>
		<input type="text" placeholder="L" name="JML_RT_H_PERAWATAN" value=""  />
		<input type="text" placeholder="P" name="JML_RT_H_PERAWATAN_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH TEMPAT TIDUR :</label>
		<input type="text" placeholder="L" name="JML_RT_T_TIDUR" value=""  />
		<input type="text" placeholder="P" name="JML_RT_T_TIDUR_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH HARI BUKA :</label>
		<input type="text" placeholder="L" name="JML_RT_H_BUKA" value=""  />
		<input type="text" placeholder="P" name="JML_RT_H_BUKA_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PENDERITA KELUAR MENINGGAL < 48 JAM :</label>
		<input type="text" placeholder="L" name="JML_RT_PK_MENINGGAL_K_48" value=""  />
		<input type="text" placeholder="P" name="JML_RT_PK_MENINGGAL_K_48_P" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PENDERITA KELUAR MENINGGAL > 48 JAM :</label>
		<input type="text" placeholder="L" name="JML_RT_PK_MENINGGAL_L_48" value=""  />
		<input type="text" placeholder="P" name="JML_RT_PK_MENINGGAL_L_48_P" value=""  />
		</span>
	</fieldset>
	
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >