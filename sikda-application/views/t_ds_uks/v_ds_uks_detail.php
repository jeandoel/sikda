<script>
	$('#backlistinspekhotel').click(function(){
		$("#t806","#tabs").empty();
		$("#t806","#tabs").load('t_ds_uks'+'?_=' + (new Date()).getTime());
	})
</script>
<style>
input[type=text] {width: 55px!important;}
label{width:295px!important;}
</style>
<div class="mycontent">
<div class="formtitle">Detail Data Gigi</div>
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
		<input type="text" readonly  style="width:195px!important" name="TAHUN" id="tahun_ds_uks" value="<?=$data->KELURAHAN?>" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Puskesmas</label>
		<input type="text" readonly  style="width:195px!important" name="TAHUN" id="tahun_ds_uks" value="<?=$data->PUSKESMAS?>" required />
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
		<input type="text" readonly  name="TAHUN" id="tahun_ds_uks" value="<?=$data->TAHUN?>" required />
		</span>
	</fieldset>
	</br>
	<fieldset>
		<span>
		<label>SEKOLAH YANG MELAKSANAKAN UKS SD/MI</label>
		<input type="text" name="JML_SDMI_UKS" value="<?=$data->JML_SDMI_UKS?>" readonly  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SEKOLAH YANG DIBINA OLEH PUSKESMAS</label>
		<input type="text" name="JML_SKL_DIBINA_PUSKESMAS" value="<?=$data->JML_SKL_DIBINA_PUSKESMAS?>" readonly  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SEKOLAH YANG MELAKSANAKAN PENJARINGAN</label>
		<input type="text" name="JML_SKL_PENJARINGAN"  value="<?=$data->JML_SKL_PENJARINGAN?>" readonly   />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">A. SEKOLAH SD/MI DENGAN STANDAR SEKOLAH SEHAT</div>
	</br>
	<fieldset>
		<span>
		<label>MINIMAL</label>
		<input type="text" name="JML_SD_SKL_MINIMAL"  value="<?=$data->JML_SD_SKL_MINIMAL?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>STANDAR</label>
		<input type="text" name="JML_SD_SKL_STANDAR"  value="<?=$data->JML_SD_SKL_STANDAR?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>OPTIMAL</label>
		<input type="text" name="JML_SD_SKL_OPTIMAL"  value="<?=$data->JML_SD_SKL_OPTIMAL?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PARIPURNA</label>
		<input type="text" name="JML_SD_SKL_PARIPURNA"  value="<?=$data->JML_SD_SKL_PARIPURNA?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH GURU UKS</label>
		<input type="text" name="JML_SD_SKL_GR_UKS"  value="<?=$data->JML_SD_SKL_GR_UKS?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SEKOLAH DENGAN DANA SEHAT</label>
		<input type="text" name="JML_SD_SKL_DANA_SEHAT"  value="<?=$data->JML_SD_SKL_DANA_SEHAT?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH DOKTER KECIL YG ADA</label>
		<input type="text" name="JML_SD_SKL_DR_KECIL"  value="<?=$data->JML_SD_SKL_DR_KECIL?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SEKOLAH DENGAN PERAN AKTIF DOKTER KECIL </label>
		<input type="text" name="JML_SD_AK_DR_KECIL"  value="<?=$data->JML_SD_AK_DR_KECIL?>" readonly   />
		</span>
	</fieldset>
	<div class="subformtitle3">LAKI-LAKI</div>
	<fieldset>
		<span>
		<label>JUMLAH MURID MENDAPAT PENGOBATAN </label>
		<input type="text" name="JML_L_M_SD_PENGOBATAN" value="<?=$data->JML_L_M_SD_PENGOBATAN?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID YG DIRUJUK</label>
		<input type="text" name="JML_L_M_SD_DIRUJUK"  value="<?=$data->JML_L_M_SD_DIRUJUK?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI BURUK </label>
		<input type="text" name="JML_L_M_SD_GZ_BURUK"  value="<?=$data->JML_L_M_SD_GZ_BURUK?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI KURANG</label>
		<input type="text" name="JML_L_M_SD_GZ_KURANG"  value="<?=$data->JML_L_M_SD_GZ_KURANG?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI BAIK </label>
		<input type="text" name="JML_L_M_SD_GZ_BAIK"  value="<?=$data->JML_L_M_SD_GZ_BAIK?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI LEBIH</label>
		<input type="text" name="JML_L_M_SD_GZ_LEBIH"  value="<?=$data->JML_L_M_SD_GZ_LEBIH?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SD LUAR BIASA DI WIL. PUSKESMAS </label>
		<input type="text" name="JML_L_ALB_SD_PUSKESMAS"  value="<?=$data->JML_L_ALB_SD_PUSKESMAS?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SD LUAR BIASA YG DIPERIKSA </label>
		<input type="text" name="JML_L_ALB_SD_DIPERIKSA"  value="<?=$data->JML_L_ALB_SD_DIPERIKSA?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SD LUAR BIASA YG DIRUJUK</label>
		<input type="text" name="JML_L_ALB_SD_DIRUJUK" value="<?=$data->JML_L_ALB_SD_DIRUJUK?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SEKOLAH KLS I DENGAN BB TIDAK SEIMBANG DENGAN TB</label>
		<input type="text" name="JML_L_SD_BBTSTB"  value="<?=$data->JML_L_SD_BBTSTB?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SEKOLAH YG DIPERIKSA OLEH PUSKESMAS DI SEKOLAH</label>
		<input type="text" name="JML_L_SD_SKL_PUSKESMAS"  value="<?=$data->JML_L_SD_SKL_PUSKESMAS?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SEKOLAH YANG DIRUJUK</label>
		<input type="text" name="JML_L_SD_SKL_DIRUJUK"  value="<?=$data->JML_L_SD_SKL_DIRUJUK?>" readonly  />
		</span>
	</fieldset>
	<div class="subformtitle3">PEREMPUAN</div>
	<fieldset>
		<span>
		<label>JUMLAH MURID MENDAPAT PENGOBATAN </label>
		<input type="text" name="JML_P_M_SD_PENGOBATAN"  value="<?=$data->JML_P_M_SD_PENGOBATAN?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID YG DIRUJUK</label>
		<input type="text" name="JML_P_M_SD_DIRUJUK"  value="<?=$data->JML_P_M_SD_DIRUJUK?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI BURUK </label>
		<input type="text" name="JML_P_M_SD_GZ_BURUK"  value="<?=$data->JML_P_M_SD_GZ_BURUK?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI KURANG</label>
		<input type="text" name="JML_P_M_SD_GZ_KURANG"  value="<?=$data->JML_P_M_SD_GZ_KURANG?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI BAIK </label>
		<input type="text" name="JML_P_M_SD_GZ_BAIK"  value="<?=$data->JML_P_M_SD_GZ_BAIK?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI LEBIH</label>
		<input type="text" name="JML_P_M_SD_GZ_LEBIH" value="<?=$data->JML_P_M_SD_GZ_LEBIH?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SEKOLAH YG MELAKSANAKAN KONSELING KESEHATAN</label>
		<input type="text" name="JML_P_SD_KON_KESEHATAN"  value="<?=$data->JML_P_SD_KON_KESEHATAN?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SD LUAR BIASA DI WIL. PUSKESMAS </label>
		<input type="text" name="JML_P_ALB_SD_PUSKESMAS" value="<?=$data->JML_P_ALB_SD_PUSKESMAS?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SD LUAR BIASA YG DIPERIKSA </label>
		<input type="text" name="JML_P_ALB_SD_DIPERIKSA"  value="<?=$data->JML_P_ALB_SD_DIPERIKSA?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SD LUAR BIASA YG DIRUJUK</label>
		<input type="text" name="JML_P_ALB_SD_DIRUJUK"  value="<?=$data->JML_P_ALB_SD_DIRUJUK?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SEKOLAH YANG MELAKSANAKAN UKS</label>
		<input type="text" name="JML_P_SD_UKS"  value="<?=$data->JML_P_SD_UKS?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SEKOLAH YANG DIBINA OLEH PUSKESMAS</label>
		<input type="text" name="JML_P_SD_PUSKESMAS" value="<?=$data->JML_P_SD_PUSKESMAS?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label> SEKOLAH YANG MELAKSANAKAN PENJARINGAN </label>
		<input type="text" name="JML_P_SD_PENJARINGAN"  value="<?=$data->JML_P_SD_PENJARINGAN?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SEKOLAH KLS I DENGAN BB TIDAK SEIMBANG DENGAN TB</label>
		<input type="text" name="JML_P_SD_BBTSTB"  value="<?=$data->JML_P_SD_BBTSTB?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SEKOLAH YG DIPERIKSA OLEH PUSKESMAS DI SEKOLAH</label>
		<input type="text" name="JML_P_SD_SKL_PUSKESMAS"  value="<?=$data->JML_P_SD_SKL_PUSKESMAS?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SEKOLAH YANG DIRUJUK</label>
		<input type="text" name="JML_P_SD_SKL_DIRUJUK"  value="<?=$data->JML_P_SD_SKL_DIRUJUK?>" readonly    />
		</span>
	</fieldset>
	
	
	<div class="subformtitle1">B. SEKOLAH SLTP/MTs DENGAN STANDAR SEKOLAH SEHAT </div>
	</br>
	<fieldset>
		<span>
		<label>MINIMAL</label>
		<input type="text" name="JML_SLTP_SKL_MINIMAL"  value="<?=$data->JML_SLTP_SKL_MINIMAL?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>STANDAR</label>
		<input type="text" name="JML_SLTP_SKL_STANDAR"  value="<?=$data->JML_SLTP_SKL_STANDAR?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>OPTIMAL</label>
		<input type="text" name="JML_SLTP_SKL_OPTIMAL"  value="<?=$data->JML_SLTP_SKL_OPTIMAL?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PARIPURNA</label>
		<input type="text" name="JML_SLTP_SKL_PARIPURNA"  value="<?=$data->JML_SLTP_SKL_PARIPURNA?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH GURU UKS</label>
		<input type="text" name="JML_SLTP_SKL_GR_UKS"  value="<?=$data->JML_SLTP_SKL_GR_UKS?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SEKOLAH DENGAN DANA SEHAT</label>
		<input type="text" name="JML_SLTP_SKL_DANA_SEHAT"  value="<?=$data->JML_SLTP_SKL_DANA_SEHAT?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KADER KESEHATAN REMAJA YG ADA</label>
		<input type="text" name="JML_SLTP_SKL_KDR_KESEHATAN" value="<?=$data->JML_SLTP_SKL_KDR_KESEHATAN?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SEKOLAH DENGAN PERAN AKTIF KADER KESEHATAN </label>
		<input type="text" name="JML_SLTP_SKL_KDR_AKTF"  value="<?=$data->JML_SLTP_SKL_KDR_AKTF?>" readonly   />
		</span>
	</fieldset>
	<div class="subformtitle3">LAKI-LAKI</div>
	<fieldset>
		<span>
		<label>JUMLAH MURID MENDAPAT PENGOBATAN </label>
		<input type="text" name="JML_L_M_SLTP_PENGOBATAN"  value="<?=$data->JML_L_M_SLTP_PENGOBATAN?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID YG DIRUJUK</label>
		<input type="text" name="JML_L_M_SLTP_DIRUJUK"  value="<?=$data->JML_L_M_SLTP_DIRUJUK?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI BURUK </label>
		<input type="text" name="JML_L_M_SLTP_GZ_BURUK"  value="<?=$data->JML_L_M_SLTP_GZ_BURUK?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI KURANG</label>
		<input type="text" name="JML_L_M_SLTP_GZ_KURANG" value="<?=$data->JML_L_M_SLTP_GZ_KURANG?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI BAIK </label>
		<input type="text" name="JML_L_M_SLTP_GZ_BAIK"  value="<?=$data->JML_L_M_SLTP_GZ_BAIK?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI LEBIH</label>
		<input type="text" name="JML_L_M_SLTP_GZ_LEBIH"  value="<?=$data->JML_L_M_SLTP_GZ_LEBIH?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SLTP LUAR BIASA DI WIL. PUSKESMAS </label>
		<input type="text" name="JML_L_SLTP_ALB_PUSKESMAS"  value="<?=$data->JML_L_SLTP_ALB_PUSKESMAS?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SLTP LUAR BIASA YG DIPERIKSA </label>
		<input type="text" name="JML_L_SLTP_ALB_DIPERIKSA"  value="<?=$data->JML_L_SLTP_ALB_DIPERIKSA?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SLTP LUAR BIASA YG DIRUJUK</label>
		<input type="text" name="JML_L_SLTP_ALB_DIRUJUK" value="<?=$data->JML_L_SLTP_ALB_DIRUJUK?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SEKOLAH DENGAN BB TIDAK SEIMBANG DENGAN TB</label>
		<input type="text" name="JML_L_SLTP_BBTSTB"  value="<?=$data->JML_L_SLTP_BBTSTB?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SEKOLAH YG DIPERIKSA OLEH PUSKESMAS DI SEKOLAH</label>
		<input type="text" name="JML_L_SLTP_DP_PUS_SEKOLAH"  value="<?=$data->JML_L_SLTP_DP_PUS_SEKOLAH?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SEKOLAH YANG DIRUJUK</label>
		<input type="text" name="JML_L_SLTP_DIRUJUK"  value="<?=$data->JML_L_SLTP_DIRUJUK?>" readonly    />
		</span>
	</fieldset>
	<div class="subformtitle3">PEREMPUAN</div>
	<fieldset>
		<span>
		<label>JUMLAH MURID MENDAPAT PENGOBATAN </label>
		<input type="text" name="JML_P_M_SLTP_PENGOBATAN"  value="<?=$data->JML_P_M_SLTP_PENGOBATAN?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID YG DIRUJUK</label>
		<input type="text" name="JML_P_M_SLTP_DIRUJUK"  value="<?=$data->JML_P_M_SLTP_DIRUJUK?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI BURUK </label>
		<input type="text" name="JML_P_M_SLTP_GZ_BURUK"  value="<?=$data->JML_P_M_SLTP_GZ_BURUK?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI KURANG</label>
		<input type="text" name="JML_P_M_SLTP_GZ_KURANG"  value="<?=$data->JML_P_M_SLTP_GZ_KURANG?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI BAIK </label>
		<input type="text" name="JML_P_M_SLTP_GZ_BAIK"  value="<?=$data->JML_P_M_SLTP_GZ_BAIK?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI LEBIH</label>
		<input type="text" name="JML_P_M_SLTP_GZ_LEBIH"  value="<?=$data->JML_P_M_SLTP_GZ_LEBIH?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SEKOLAH YG MELAKSANAKAN KONSELING KESEHATAN</label>
		<input type="text" name="JML_P_SLTP_KON_KESEHATAN" value="<?=$data->JML_P_SLTP_KON_KESEHATAN?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SLTP LUAR BIASA DI WIL. PUSKESMAS </label>
		<input type="text" name="JML_P_SLTP_ALB_PUSKESMAS"  value="<?=$data->JML_P_SLTP_ALB_PUSKESMAS?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SLTP LUAR BIASA YG DIPERIKSA </label>
		<input type="text" name="JML_P_SLTP_ALB_DIPERIKSA"  value="<?=$data->JML_P_SLTP_ALB_DIPERIKSA?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SLTP LUAR BIASA YG DIRUJUK</label>
		<input type="text" name="JML_P_SLTP_ALB_DIRUJUK"  value="<?=$data->JML_P_SLTP_ALB_DIRUJUK?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SEKOLAH YANG MELAKSANAKAN UKS</label>
		<input type="text" name="JML_P_SLTP_UKS"  value="<?=$data->JML_P_SLTP_UKS?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SEKOLAH YANG DIBINA OLEH PUSKESMAS</label>
		<input type="text" name="JML_P_SLTP_DB_PUSKESMAS"  value="<?=$data->JML_P_SLTP_DB_PUSKESMAS?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label> SEKOLAH YANG MELAKSANAKAN PENJARINGAN </label>
		<input type="text" name="JML_P_SLTP_M_PENJARINGAN"  value="<?=$data->JML_P_SLTP_M_PENJARINGAN?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SEKOLAH DENGAN BB TIDAK SEIMBANG DENGAN TB</label>
		<input type="text" name="JML_P_SLTP_BBTSTB"  value="<?=$data->JML_P_SLTP_BBTSTB?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SEKOLAH YG DIPERIKSA OLEH PUSKESMAS DI SEKOLAH</label>
		<input type="text" name="JML_P_SLTP_DP_PUS_SEKOLAH"  value="<?=$data->JML_P_SLTP_DP_PUS_SEKOLAH?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SEKOLAH YANG DIRUJUK</label>
		<input type="text" name="JML_P_SLTP_DIRUJUK"  value="<?=$data->JML_P_SLTP_DIRUJUK?>" readonly   />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">C. SEKOLAH SLTA/MA DENGAN STANDAR SEKOLAH SEHAT </div>
	</br>
	<fieldset>
		<span>
		<label>MINIMAL</label>
		<input type="text" name="JML_SLTA_SKL_MINIMAL"  value="<?=$data->JML_SLTA_SKL_MINIMAL?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>STANDAR</label>
		<input type="text" name="JML_SLTA_SKL_STANDAR"  value="<?=$data->JML_SLTA_SKL_STANDAR?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>OPTIMAL</label>
		<input type="text" name="JML_SLTA_SKL_OPTIMAL"  value="<?=$data->JML_SLTA_SKL_OPTIMAL?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PARIPURNA</label>
		<input type="text" name="JML_SLTA_SKL_PARIPURNA"  value="<?=$data->JML_SLTA_SKL_PARIPURNA?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH GURU UKS</label>
		<input type="text" name="JML_SLTA_SKL_GR_UKS"  value="<?=$data->JML_SLTA_SKL_GR_UKS?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SEKOLAH DENGAN DANA SEHAT</label>
		<input type="text" name="JML_SLTA_SKL_DANA_SEHAT"  value="<?=$data->JML_SLTA_SKL_DANA_SEHAT?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KADER KESEHATAN REMAJA YG ADA</label>
		<input type="text" name="JML_SLTA_SKL_KDR_KESEHATAN"  value="<?=$data->JML_SLTA_SKL_KDR_KESEHATAN?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SEKOLAH DENGAN PERAN AKTIF KADER KESEHATAN </label>
		<input type="text" name="JML_SLTA_SKL_AK_KDR_KESEHATAN"  value="<?=$data->JML_SLTA_SKL_AK_KDR_KESEHATAN?>" readonly   />
		</span>
	</fieldset>
	
	<div class="subformtitle3">LAKI-LAKI</div>
	<fieldset>
		<span>
		<label>JUMLAH MURID MENDAPAT PENGOBATAN </label>
		<input type="text" name="JML_L_SLTA_PENGOBATAN"  value="<?=$data->JML_L_SLTA_PENGOBATAN?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID YG DIRUJUK</label>
		<input type="text" name="JML_L_SLTA_DIRUJUK"  value="<?=$data->JML_L_SLTA_DIRUJUK?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI BURUK </label>
		<input type="text" name="JML_L_SLTA_GZ_BURUK"  value="<?=$data->JML_L_SLTA_GZ_BURUK?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI KURANG</label>
		<input type="text" name="JML_L_SLTA_GZ_KURANG"  value="<?=$data->JML_L_SLTA_GZ_KURANG?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI BAIK </label>
		<input type="text" name="JML_L_SLTA_GZ_BAIK"  value="<?=$data->JML_L_SLTA_GZ_BAIK?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI LEBIH</label>
		<input type="text" name="JML_L_SLTA_GZ_LEBIH"  value="<?=$data->JML_L_SLTA_GZ_LEBIH?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SLTA LUAR BIASA DI WIL. PUSKESMAS </label>
		<input type="text" name="JML_L_SLTA_ALB_PUSKESMAS"  value="<?=$data->JML_L_SLTA_ALB_PUSKESMAS?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SLTA LUAR BIASA YG DIPERIKSA </label>
		<input type="text" name="JML_L_SLTA_ALB_DIPERIKSA" value="<?=$data->JML_L_SLTA_ALB_DIPERIKSA?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SLTA LUAR BIASA YG DIRUJUK</label>
		<input type="text" name="JML_L_SLTA_ALB_DIRUJUK"  value="<?=$data->JML_L_SLTA_ALB_DIRUJUK?>" readonly   />
		</span>
	</fieldset>
	<div class="subformtitle3">PEREMPUAN</div>
	<fieldset>
		<span>
		<label>JUMLAH MURID MENDAPAT PENGOBATAN </label>
		<input type="text" name="JML_P_SLTA_PENGOBATAN" value="<?=$data->JML_P_SLTA_PENGOBATAN?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID YG DIRUJUK</label>
		<input type="text" name="JML_P_SLTA_DIRUJUK"  value="<?=$data->JML_P_SLTA_DIRUJUK?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI BURUK </label>
		<input type="text" name="JML_P_SLTA_GZ_BURUK"  value="<?=$data->JML_P_SLTA_GZ_BURUK?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI KURANG</label>
		<input type="text" name="JML_P_SLTA_GZ_KURANG"  value="<?=$data->JML_P_SLTA_GZ_KURANG?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI BAIK </label>
		<input type="text" name="JML_P_SLTA_GZ_BAIK"  value="<?=$data->JML_P_SLTA_GZ_BAIK?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI LEBIH</label>
		<input type="text" name="JML_P_SLTA_GZ_LEBIH"  value="<?=$data->JML_P_SLTA_GZ_LEBIH?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SEKOLAH YG MELAKSANAKAN KONSELING KESEHATAN</label>
		<input type="text" name="JML_P_SLTA_KON_KESEHATAN"  value="<?=$data->JML_P_SLTA_KON_KESEHATAN?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SLTA LUAR BIASA DI WIL. PUSKESMAS </label>
		<input type="text" name="JML_P_SLTA_ALB_PUSKESMAS"  value="<?=$data->JML_P_SLTA_ALB_PUSKESMAS?>" readonly    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SLTA LUAR BIASA YG DIPERIKSA </label>
		<input type="text" name="JML_P_SLTA_ALB_DIPERIKSA"  value="<?=$data->JML_P_SLTA_ALB_DIPERIKSA?>" readonly   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SLTA LUAR BIASA YG DIRUJUK</label>
		<input type="text" name="JML_P_SLTA_ALB_DIRUJUK"  value="<?=$data->JML_P_SLTA_ALB_DIRUJUK?>" readonly   />
		</span>
	</fieldset>
</form>
</div >