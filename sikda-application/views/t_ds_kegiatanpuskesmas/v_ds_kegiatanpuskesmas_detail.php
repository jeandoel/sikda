<script>
	$('#backlistinspekhotel').click(function(){
		$("#t807","#tabs").empty();
		$("#t807","#tabs").load('t_ds_kegiatanpuskesmas'+'?_=' + (new Date()).getTime());
	})
</script>
<style>
input[type=text] {width: 55px!important;}
label{width:295px!important;}
</style>
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
<div class="formtitle">Detail Data Kegiatan Puskesmas</div>
<div class="backbutton"><span class="kembali" id="backlistinspekhotel">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Propinsi</label>
		<input type="text" readonly  style="width:195px!important" name="" id="textid" value="<?=$data->PROVINSI?>"  />
		<input type="hidden" name="ID" value="<?=$data->ID?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kabupaten</label>
		<input type="text" readonly  style="width:195px!important" name="" id="textid" value="<?=$data->KABUPATEN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kelurahan</label>
		<input type="text" readonly  style="width:195px!important" name="TAHUN" id="tahun_ds_kegiatanpuskesmas" value="<?=$data->KELURAHAN?>" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Puskesmas</label>
		<input type="text" readonly  style="width:195px!important" name="TAHUN" id="tahun_ds_kegiatanpuskesmas" value="<?=$data->PUSKESMAS?>" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Bulan</label>
		<select name="BULAN" >
			<option value="">- pilih bulan -</option>
			<option value="01" <?=$data->BULAN=='01'?'selected':'';?> >Januari</option>
			<option value="02" <?=$data->BULAN=='02'?'selected':'';?> >Februari</option>
			<option value="03" <?=$data->BULAN=='03'?'selected':'';?> >Maret</option>
			<option value="04" <?=$data->BULAN=='04'?'selected':'';?> >April</option>
			<option value="05" <?=$data->BULAN=='05'?'selected':'';?> >Mei</option>
			<option value="06" <?=$data->BULAN=='06'?'selected':'';?> >Juni</option>
			<option value="07" <?=$data->BULAN=='07'?'selected':'';?> >Juli</option>
			<option value="08" <?=$data->BULAN=='08'?'selected':'';?> >Agustus</option>
			<option value="09" <?=$data->BULAN=='09'?'selected':'';?> >September</option>
			<option value="10" <?=$data->BULAN=='10'?'selected':'';?> >Oktober</option>
			<option value="11" <?=$data->BULAN=='11'?'selected':'';?> >November</option>
			<option value="12" <?=$data->BULAN=='12'?'selected':'';?> >Desember</option>
		</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tahun</label>
		<input type="text" readonly  name="TAHUN" id="tahun_ds_kegiatanpuskesmas" value="<?=$data->TAHUN?>" required />
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
		<input type="text" readonly name="JML_KR_DARI_PUSKESMAS" value="<?=$data->JML_KR_DARI_PUSKESMAS?>"  />
		<input type="text" readonly name="JML_KR_DARI_PUSKESMAS_P" value="<?=$data->JML_KR_DARI_PUSKESMAS_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH RUJUKAN BALIK RUMAH SAKIT</label>
		<input type="text" readonly name="JML_KR_B_RUMAH_SAKIT" value="<?=$data->JML_KR_B_RUMAH_SAKIT?>"  />
		<input type="text" readonly name="JML_KR_B_RUMAH_SAKIT_P" value="<?=$data->JML_KR_B_RUMAH_SAKIT_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH RUJUKAN KADER KE PUSKESMAS</label>
		<input type="text" readonly name="JML_KR_KA_PUSKESMAS" value="<?=$data->JML_KR_KA_PUSKESMAS?>"  />
		<input type="text" readonly name="JML_KR_KA_PUSKESMAS_P" value="<?=$data->JML_KR_KA_PUSKESMAS_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH RUJUKAN POSYANDU KE PUSKESMAS</label>
		<input type="text" readonly name="JML_KR_PO_PUSKESMAS" value="<?=$data->JML_KR_PO_PUSKESMAS?>"  />
		<input type="text" readonly name="JML_KR_PO_PUSKESMAS_P" value="<?=$data->JML_KR_PO_PUSKESMAS_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH RUJUKAN PUSTU KE PUSKESMAS</label>
		<input type="text" readonly name="JML_KR_PU_PUSKESMAS" value="<?=$data->JML_KR_PU_PUSKESMAS?>"  />
		<input type="text" readonly name="JML_KR_PU_PUSKESMAS_P" value="<?=$data->JML_KR_PU_PUSKESMAS_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH RUJUKAN SEKOLAH KE PUSKESMAS</label>
		<input type="text" readonly name="JML_KR_SE_PUSKESMAS" value="<?=$data->JML_KR_SE_PUSKESMAS?>"  />
		<input type="text" readonly name="JML_KR_SE_PUSKESMAS_P" value="<?=$data->JML_KR_SE_PUSKESMAS_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH LAIN-LAIN RUJUKAN KE PUSKESMAS</label>
		<input type="text" readonly name="JML_KR_LAIN_PUSKESMAS" value="<?=$data->JML_KR_LAIN_PUSKESMAS?>"  />
		<input type="text" readonly name="JML_KR_LAIN_PUSKESMAS_P" value="<?=$data->JML_KR_LAIN_PUSKESMAS_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH RUJUKAN KE PUSKESMAS</label>
		<input type="text" readonly name="JML_KR_KE_PUSKESMAS" value="<?=$data->JML_KR_KE_PUSKESMAS?>"  />
		<input type="text" readonly name="JML_KR_KE_PUSKESMAS_P" value="<?=$data->JML_KR_KE_PUSKESMAS_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN DOKTER AHLI</label>
		<input type="text" readonly name="JML_KR_K_DOKTER_AHLI" value="<?=$data->JML_KR_K_DOKTER_AHLI?>"  />
		<input type="text" readonly name="JML_KR_K_DOKTER_AHLI_P" value="<?=$data->JML_KR_K_DOKTER_AHLI_P?>"  />
		</span>
	</fieldset>
	<br/>
	<div class="subformtitle1">B. KEGIATAN LABORATORIUM</div>
	<fieldset>
		<span>
		<label>PEMERIKSAAN SPECIMEN DARAH</label>
		<input type="text" readonly name="KL_PS_DARAH" value="<?=$data->KL_PS_DARAH?>"  />
		<input type="text" readonly name="KL_PS_DARAH_P" value="<?=$data->KL_PS_DARAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PEMERIKSAAN SPECIMEN URINE/AIR SENI :</label>
		<input type="text" readonly name="KL_PS_URINE" value="<?=$data->KL_PS_URINE?>"  />
		<input type="text" readonly name="KL_PS_URINE_P" value="<?=$data->KL_PS_URINE_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PEMERIKSAAN SPECIMEN TINJA :</label>
		<input type="text" readonly name="KL_PS_TINJA" value="<?=$data->KL_PS_TINJA?>"  />
		<input type="text" readonly name="KL_PS_TINJA_P" value="<?=$data->KL_PS_TINJA_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PEMERIKSAAN SPECIMEN LAIN :</label>
		<input type="text" readonly name="KL_PS_LAIN" value="<?=$data->KL_PS_LAIN?>"  />
		<input type="text" readonly name="KL_PS_LAIN_P" value="<?=$data->KL_PS_LAIN_P?>"  />
		</span>
	</fieldset>
	<br/>
	<div class="subformtitle1">C. KEGIATAN PERAWATAN KESEHATAN MASYARAKAT</div>
	<div class="subformtitle3">C1. PEMBINAAN KELUARGA RAWAN</div>
	<fieldset>
		<span>
		<label>JUMLAH KELUARGA RAWAN TERCATAT DIPUSKESMAS :</label>
		<input type="text" readonly name="JML_PKR_PUSKESMAS" value="<?=$data->JML_PKR_PUSKESMAS?>"  />
		<input type="text" readonly name="JML_PKR_PUSKESMAS_P" value="<?=$data->JML_PKR_PUSKESMAS_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KELUARGA RAWAN YG SELESAI DIBINA :</label>
		<input type="text" readonly name="JML_PKR_DIBINA" value="<?=$data->JML_PKR_DIBINA?>"  />
		<input type="text" readonly name="JML_PKR_DIBINA_P" value="<?=$data->JML_PKR_DIBINA_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN KE KELUARGA RAWAN YG SELESAI DIBINA :</label>
		<input type="text" readonly name="JML_PKR_KUNJUNGAN_DIBINA" value="<?=$data->JML_PKR_KUNJUNGAN_DIBINA?>"  />
		<input type="text" readonly name="JML_PKR_KUNJUNGAN_DIBINA_P" value="<?=$data->JML_PKR_KUNJUNGAN_DIBINA_P?>"  />
		</span>
	</fieldset>
	<div class="subformtitle3">C2. TINDAK LANJUT PERAWATAN YANG SELESAI DIBINA</div>
	<fieldset>
		<span>
		<label>JUMLAH KASUS TINDAK LANJUT PERAWATAN YANG SELESAI DIBINA :</label>
		<input type="text" readonly name="JML_KASUS_TLPSB" value="<?=$data->JML_KASUS_TLPSB?>"  />
		<input type="text" readonly name="JML_KASUS_TLPSB_P" value="<?=$data->JML_KASUS_TLPSB_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JML KUNJ. PEMBINAAN KASUS TINDAK LANJUT PERAWATAN YG SELESAI DIBINA :</label>
		<input type="text" readonly name="JML_KUNJ_TLPSB" value="<?=$data->JML_KUNJ_TLPSB?>"  />
		<input type="text" readonly name="JML_KUNJ_TLPSB_P" value="<?=$data->JML_KUNJ_TLPSB_P?>"  />
		</span>
	</fieldset>
	<div class="subformtitle3">C3. PEMBINAAN GOLONGAN RESIKO BUMIL DAN BALITA</div>
	<fieldset>
		<span>
		<label>JUMLAH BUMIL YANG MEMPEROLEH ASUHAN PERAWATAN :</label>
		<!--<input type="text" readonly name="JML_PGR_BUMIL_PERAWATAN" value="<?=$data->JML_PGR_BUMIL_PERAWATAN?>"  />-->
		<input type="text" readonly style="width:125px!important" name="JML_PGR_BUMIL_PERAWATAN_P" value="<?=$data->JML_PGR_BUMIL_PERAWATAN_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH BALITA YANG MEMPEROLEH ASUHAN KEPERAWATAN :</label>
		<input type="text" readonly name="JML_PGR_BALITA_PERAWATAN" value="<?=$data->JML_PGR_BALITA_PERAWATAN?>"  />
		<input type="text" name="JML_PGR_BALITA_PERAWATAN_P" value="<?=$data->JML_PGR_BALITA_PERAWATAN_P?>"  />
		</span>
	</fieldset>
	<div class="subformtitle3">C4. PEMBINAAN KELOMPOK KHUSUS/PANTI</div>
	<fieldset>
		<span>
		<label>JUMLAH KELOMPOK KHUSUS/PANTI YANG DIBINA :</label>
		<input type="text" readonly name="JML_PKKP_DIBINA" value="<?=$data->JML_PKKP_DIBINA?>"  />
		<input type="text" readonly name="JML_PKKP_DIBINA_P" value="<?=$data->JML_PKKP_DIBINA_P?>"  />
		</span>
	</fieldset>
	<br/>
	<div class="subformtitle1">D. KEGIATAN KUNJUNGAN</div>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN UMUM BAYAR :</label>
		<input type="text" readonly name="JML_KK_UMUM_BAYAR" value="<?=$data->JML_KK_UMUM_BAYAR?>"  />
		<input type="text" readonly name="JML_KK_UMUM_BAYAR_P" value="<?=$data->JML_KK_UMUM_BAYAR_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN ASKES :</label>
		<input type="text" readonly name="JML_KK_ASKES" value="<?=$data->JML_KK_ASKES?>"  />
		<input type="text" readonly name="JML_KK_ASKES_P" value="<?=$data->JML_KK_ASKES_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KUNJUNGAN JPS / KARTU SEHAT :</label>
		<input type="text" readonly name="JML_KK_JPS_K_SEHAT" value="<?=$data->JML_KK_JPS_K_SEHAT?>"  />
		<input type="text" readonly name="JML_KK_JPS_K_SEHAT_P" value="<?=$data->JML_KK_JPS_K_SEHAT_P?>"  />
		</span>
	</fieldset>
	<br/>
	<div class="subformtitle1">E. RAWAT TINGGAL</div>
	<fieldset>
		<span>
		<label>JUMLAH PENDERITA YANG DIRAWAT :</label>
		<input type="text" readonly name="JML_RT_P_DIRAWAT" value="<?=$data->JML_RT_P_DIRAWAT?>"  />
		<input type="text" readonly name="JML_RT_P_DIRAWAT_P" value="<?=$data->JML_RT_P_DIRAWAT_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH HARI PERAWATAN :</label>
		<input type="text" readonly name="JML_RT_H_PERAWATAN" value="<?=$data->JML_RT_H_PERAWATAN?>"  />
		<input type="text" readonly name="JML_RT_H_PERAWATAN_P" value="<?=$data->JML_RT_H_PERAWATAN_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH TEMPAT TIDUR :</label>
		<input type="text" readonly name="JML_RT_T_TIDUR" value="<?=$data->JML_RT_T_TIDUR?>"  />
		<input type="text" readonly name="JML_RT_T_TIDUR_P" value="<?=$data->JML_RT_T_TIDUR_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH HARI BUKA :</label>
		<input type="text" readonly name="JML_RT_H_BUKA" value="<?=$data->JML_RT_H_BUKA?>"  />
		<input type="text" readonly name="JML_RT_H_BUKA_P" value="<?=$data->JML_RT_H_BUKA_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PENDERITA KELUAR MENINGGAL < 48 JAM :</label>
		<input type="text" readonly name="JML_RT_PK_MENINGGAL_K_48" value="<?=$data->JML_RT_PK_MENINGGAL_K_48?>"  />
		<input type="text" readonly name="JML_RT_PK_MENINGGAL_K_48_P" value="<?=$data->JML_RT_PK_MENINGGAL_K_48_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PENDERITA KELUAR MENINGGAL > 48 JAM :</label>
		<input type="text" readonly name="JML_RT_PK_MENINGGAL_L_48" value="<?=$data->JML_RT_PK_MENINGGAL_L_48?>"  />
		<input type="text" readonly name="JML_RT_PK_MENINGGAL_L_48_P" value="<?=$data->JML_RT_PK_MENINGGAL_L_48_P?>"  />
		</span>
	</fieldset>
</form>
</div >