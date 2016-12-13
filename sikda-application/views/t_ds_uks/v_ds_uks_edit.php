<script>
$(document).ready(function(){
		$('#form1ds_uksedit').ajaxForm({
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
					$.achtung({message: 'Proses Ubah Data Berhasil', timeout:5});
					$("#t806","#tabs").empty();
					$("#t806","#tabs").load('t_ds_uks'+'?_=' + (new Date()).getTime());
				}
			}
		});
})

$("#desa_kel_id_combo_ds_uks").remoteChained("#kec_id_combo_ds_uks", "<?=site_url('t_masters/getKelurahanByKecamatanId3')?>");
$("#puskesmas_id_combo_ds_uks").remoteChained("#kec_id_combo_ds_uks", "<?=site_url('t_masters/getPuskesmasByKecamatanId2')?>");

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
	$('#backlistds_uks').click(function(){
		$("#t806","#tabs").empty();
		$("#t806","#tabs").load('t_ds_uks'+'?_=' + (new Date()).getTime());
	})
	$("#tahun_ds_uks").mask("9999");
</script>
<style>
input[type=text] {width: 55px!important;}
label{width:295px!important;}
</style>
<div class="mycontent">
<div class="formtitle">Edit Data UKS</div>
<div class="backbutton"><span class="kembali" id="backlistds_uks">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1ds_uksedit" method="post" action="<?=site_url('t_ds_uks/editprocess')?>" enctype="multipart/form-data">	
	<fieldset>
		<span>
		<label>Propinsi</label>
		<input type="text" style="width:195px!important" name="" id="textid" value="<?=$data->PROVINSI?>" disabled />
		<input type="hidden" name="ID" value="<?=$data->ID?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kabupaten</label>
		<input type="text" style="width:195px!important" name="" id="textid" value="<?=$data->KABUPATEN?>" disabled />
		</span>
	</fieldset>
	<?=getComboKecamatanByKab($data->KD_KECAMATAN,'KD_KECAMATAN','kec_id_combo_ds_uks','required','')?>
	<?=getComboKelurahanByKec($data->KD_KELURAHAN,'KD_KELURAHAN','desa_kel_id_combo_ds_uks','required','')?>
	<?=getComboPuskesmasByKec($data->KD_PUSKESMAS,'KD_PUSKESMAS','puskesmas_id_combo_ds_uks','required','')?>
	<fieldset>
		<span>
		<label>Bulan*</label>
		<select name="BULAN" required>
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
		<label>Tahun*</label>
		<input type="text" name="TAHUN" id="tahun_ds_uks" value="<?=$data->TAHUN?>" required />
		</span>
	</fieldset>
	</br>
	<fieldset>
		<span>
		<label>SEKOLAH YANG MELAKSANAKAN UKS SD/MI</label>
		<input type="text" name="JML_SDMI_UKS" value="<?=$data->JML_SDMI_UKS?>"    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SEKOLAH YANG DIBINA OLEH PUSKESMAS</label>
		<input type="text" name="JML_SKL_DIBINA_PUSKESMAS" value="<?=$data->JML_SKL_DIBINA_PUSKESMAS?>"    />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SEKOLAH YANG MELAKSANAKAN PENJARINGAN</label>
		<input type="text" name="JML_SKL_PENJARINGAN"  value="<?=$data->JML_SKL_PENJARINGAN?>"     />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">A. SEKOLAH SD/MI DENGAN STANDAR SEKOLAH SEHAT</div>
	</br>
	<fieldset>
		<span>
		<label>MINIMAL</label>
		<input type="text" name="JML_SD_SKL_MINIMAL"  value="<?=$data->JML_SD_SKL_MINIMAL?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>STANDAR</label>
		<input type="text" name="JML_SD_SKL_STANDAR"  value="<?=$data->JML_SD_SKL_STANDAR?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>OPTIMAL</label>
		<input type="text" name="JML_SD_SKL_OPTIMAL"  value="<?=$data->JML_SD_SKL_OPTIMAL?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PARIPURNA</label>
		<input type="text" name="JML_SD_SKL_PARIPURNA"  value="<?=$data->JML_SD_SKL_PARIPURNA?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH GURU UKS</label>
		<input type="text" name="JML_SD_SKL_GR_UKS"  value="<?=$data->JML_SD_SKL_GR_UKS?>"   />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SEKOLAH DENGAN DANA SEHAT</label>
		<input type="text" name="JML_SD_SKL_DANA_SEHAT"  value="<?=$data->JML_SD_SKL_DANA_SEHAT?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH DOKTER KECIL YG ADA</label>
		<input type="text" name="JML_SD_SKL_DR_KECIL"  value="<?=$data->JML_SD_SKL_DR_KECIL?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SEKOLAH DENGAN PERAN AKTIF DOKTER KECIL </label>
		<input type="text" name="JML_SD_AK_DR_KECIL"  value="<?=$data->JML_SD_AK_DR_KECIL?>"     />
		</span>
	</fieldset>
	<div class="subformtitle3">LAKI-LAKI</div>
	<fieldset>
		<span>
		<label>JUMLAH MURID MENDAPAT PENGOBATAN </label>
		<input type="text" name="JML_L_M_SD_PENGOBATAN" value="<?=$data->JML_L_M_SD_PENGOBATAN?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID YG DIRUJUK</label>
		<input type="text" name="JML_L_M_SD_DIRUJUK"  value="<?=$data->JML_L_M_SD_DIRUJUK?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI BURUK </label>
		<input type="text" name="JML_L_M_SD_GZ_BURUK"  value="<?=$data->JML_L_M_SD_GZ_BURUK?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI KURANG</label>
		<input type="text" name="JML_L_M_SD_GZ_KURANG"  value="<?=$data->JML_L_M_SD_GZ_KURANG?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI BAIK </label>
		<input type="text" name="JML_L_M_SD_GZ_BAIK"  value="<?=$data->JML_L_M_SD_GZ_BAIK?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI LEBIH</label>
		<input type="text" name="JML_L_M_SD_GZ_LEBIH"  value="<?=$data->JML_L_M_SD_GZ_LEBIH?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SD LUAR BIASA DI WIL. PUSKESMAS </label>
		<input type="text" name="JML_L_ALB_SD_PUSKESMAS"  value="<?=$data->JML_L_ALB_SD_PUSKESMAS?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SD LUAR BIASA YG DIPERIKSA </label>
		<input type="text" name="JML_L_ALB_SD_DIPERIKSA"  value="<?=$data->JML_L_ALB_SD_DIPERIKSA?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SD LUAR BIASA YG DIRUJUK</label>
		<input type="text" name="JML_L_ALB_SD_DIRUJUK" value="<?=$data->JML_L_ALB_SD_DIRUJUK?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SEKOLAH KLS I DENGAN BB TIDAK SEIMBANG DENGAN TB</label>
		<input type="text" name="JML_L_SD_BBTSTB"  value="<?=$data->JML_L_SD_BBTSTB?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SEKOLAH YG DIPERIKSA OLEH PUSKESMAS DI SEKOLAH</label>
		<input type="text" name="JML_L_SD_SKL_PUSKESMAS"  value="<?=$data->JML_L_SD_SKL_PUSKESMAS?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SEKOLAH YANG DIRUJUK</label>
		<input type="text" name="JML_L_SD_SKL_DIRUJUK"  value="<?=$data->JML_L_SD_SKL_DIRUJUK?>"    />
		</span>
	</fieldset>
	<div class="subformtitle3">PEREMPUAN</div>
	<fieldset>
		<span>
		<label>JUMLAH MURID MENDAPAT PENGOBATAN </label>
		<input type="text" name="JML_P_M_SD_PENGOBATAN"  value="<?=$data->JML_P_M_SD_PENGOBATAN?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID YG DIRUJUK</label>
		<input type="text" name="JML_P_M_SD_DIRUJUK"  value="<?=$data->JML_P_M_SD_DIRUJUK?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI BURUK </label>
		<input type="text" name="JML_P_M_SD_GZ_BURUK"  value="<?=$data->JML_P_M_SD_GZ_BURUK?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI KURANG</label>
		<input type="text" name="JML_P_M_SD_GZ_KURANG"  value="<?=$data->JML_P_M_SD_GZ_KURANG?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI BAIK </label>
		<input type="text" name="JML_P_M_SD_GZ_BAIK"  value="<?=$data->JML_P_M_SD_GZ_BAIK?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI LEBIH</label>
		<input type="text" name="JML_P_M_SD_GZ_LEBIH" value="<?=$data->JML_P_M_SD_GZ_LEBIH?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SEKOLAH YG MELAKSANAKAN KONSELING KESEHATAN</label>
		<input type="text" name="JML_P_SD_KON_KESEHATAN"  value="<?=$data->JML_P_SD_KON_KESEHATAN?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SD LUAR BIASA DI WIL. PUSKESMAS </label>
		<input type="text" name="JML_P_ALB_SD_PUSKESMAS" value="<?=$data->JML_P_ALB_SD_PUSKESMAS?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SD LUAR BIASA YG DIPERIKSA </label>
		<input type="text" name="JML_P_ALB_SD_DIPERIKSA"  value="<?=$data->JML_P_ALB_SD_DIPERIKSA?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SD LUAR BIASA YG DIRUJUK</label>
		<input type="text" name="JML_P_ALB_SD_DIRUJUK"  value="<?=$data->JML_P_ALB_SD_DIRUJUK?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SEKOLAH YANG MELAKSANAKAN UKS</label>
		<input type="text" name="JML_P_SD_UKS"  value="<?=$data->JML_P_SD_UKS?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SEKOLAH YANG DIBINA OLEH PUSKESMAS</label>
		<input type="text" name="JML_P_SD_PUSKESMAS" value="<?=$data->JML_P_SD_PUSKESMAS?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label> SEKOLAH YANG MELAKSANAKAN PENJARINGAN </label>
		<input type="text" name="JML_P_SD_PENJARINGAN"  value="<?=$data->JML_P_SD_PENJARINGAN?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SEKOLAH KLS I DENGAN BB TIDAK SEIMBANG DENGAN TB</label>
		<input type="text" name="JML_P_SD_BBTSTB"  value="<?=$data->JML_P_SD_BBTSTB?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SEKOLAH YG DIPERIKSA OLEH PUSKESMAS DI SEKOLAH</label>
		<input type="text" name="JML_P_SD_SKL_PUSKESMAS"  value="<?=$data->JML_P_SD_SKL_PUSKESMAS?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SEKOLAH YANG DIRUJUK</label>
		<input type="text" name="JML_P_SD_SKL_DIRUJUK"  value="<?=$data->JML_P_SD_SKL_DIRUJUK?>"      />
		</span>
	</fieldset>
	
	
	<div class="subformtitle1">B. SEKOLAH SLTP/MTs DENGAN STANDAR SEKOLAH SEHAT </div>
	</br>
	<fieldset>
		<span>
		<label>MINIMAL</label>
		<input type="text" name="JML_SLTP_SKL_MINIMAL"  value="<?=$data->JML_SLTP_SKL_MINIMAL?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>STANDAR</label>
		<input type="text" name="JML_SLTP_SKL_STANDAR"  value="<?=$data->JML_SLTP_SKL_STANDAR?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>OPTIMAL</label>
		<input type="text" name="JML_SLTP_SKL_OPTIMAL"  value="<?=$data->JML_SLTP_SKL_OPTIMAL?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PARIPURNA</label>
		<input type="text" name="JML_SLTP_SKL_PARIPURNA"  value="<?=$data->JML_SLTP_SKL_PARIPURNA?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH GURU UKS</label>
		<input type="text" name="JML_SLTP_SKL_GR_UKS"  value="<?=$data->JML_SLTP_SKL_GR_UKS?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SEKOLAH DENGAN DANA SEHAT</label>
		<input type="text" name="JML_SLTP_SKL_DANA_SEHAT"  value="<?=$data->JML_SLTP_SKL_DANA_SEHAT?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KADER KESEHATAN REMAJA YG ADA</label>
		<input type="text" name="JML_SLTP_SKL_KDR_KESEHATAN" value="<?=$data->JML_SLTP_SKL_KDR_KESEHATAN?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SEKOLAH DENGAN PERAN AKTIF KADER KESEHATAN </label>
		<input type="text" name="JML_SLTP_SKL_KDR_AKTF"  value="<?=$data->JML_SLTP_SKL_KDR_AKTF?>"     />
		</span>
	</fieldset>
	<div class="subformtitle3">LAKI-LAKI</div>
	<fieldset>
		<span>
		<label>JUMLAH MURID MENDAPAT PENGOBATAN </label>
		<input type="text" name="JML_L_M_SLTP_PENGOBATAN"  value="<?=$data->JML_L_M_SLTP_PENGOBATAN?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID YG DIRUJUK</label>
		<input type="text" name="JML_L_M_SLTP_DIRUJUK"  value="<?=$data->JML_L_M_SLTP_DIRUJUK?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI BURUK </label>
		<input type="text" name="JML_L_M_SLTP_GZ_BURUK"  value="<?=$data->JML_L_M_SLTP_GZ_BURUK?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI KURANG</label>
		<input type="text" name="JML_L_M_SLTP_GZ_KURANG" value="<?=$data->JML_L_M_SLTP_GZ_KURANG?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI BAIK </label>
		<input type="text" name="JML_L_M_SLTP_GZ_BAIK"  value="<?=$data->JML_L_M_SLTP_GZ_BAIK?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI LEBIH</label>
		<input type="text" name="JML_L_M_SLTP_GZ_LEBIH"  value="<?=$data->JML_L_M_SLTP_GZ_LEBIH?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SLTP LUAR BIASA DI WIL. PUSKESMAS </label>
		<input type="text" name="JML_L_SLTP_ALB_PUSKESMAS"  value="<?=$data->JML_L_SLTP_ALB_PUSKESMAS?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SLTP LUAR BIASA YG DIPERIKSA </label>
		<input type="text" name="JML_L_SLTP_ALB_DIPERIKSA"  value="<?=$data->JML_L_SLTP_ALB_DIPERIKSA?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SLTP LUAR BIASA YG DIRUJUK</label>
		<input type="text" name="JML_L_SLTP_ALB_DIRUJUK" value="<?=$data->JML_L_SLTP_ALB_DIRUJUK?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SEKOLAH DENGAN BB TIDAK SEIMBANG DENGAN TB</label>
		<input type="text" name="JML_L_SLTP_BBTSTB"  value="<?=$data->JML_L_SLTP_BBTSTB?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SEKOLAH YG DIPERIKSA OLEH PUSKESMAS DI SEKOLAH</label>
		<input type="text" name="JML_L_SLTP_DP_PUS_SEKOLAH"  value="<?=$data->JML_L_SLTP_DP_PUS_SEKOLAH?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SEKOLAH YANG DIRUJUK</label>
		<input type="text" name="JML_L_SLTP_DIRUJUK"  value="<?=$data->JML_L_SLTP_DIRUJUK?>"      />
		</span>
	</fieldset>
	<div class="subformtitle3">PEREMPUAN</div>
	<fieldset>
		<span>
		<label>JUMLAH MURID MENDAPAT PENGOBATAN </label>
		<input type="text" name="JML_P_M_SLTP_PENGOBATAN"  value="<?=$data->JML_P_M_SLTP_PENGOBATAN?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID YG DIRUJUK</label>
		<input type="text" name="JML_P_M_SLTP_DIRUJUK"  value="<?=$data->JML_P_M_SLTP_DIRUJUK?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI BURUK </label>
		<input type="text" name="JML_P_M_SLTP_GZ_BURUK"  value="<?=$data->JML_P_M_SLTP_GZ_BURUK?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI KURANG</label>
		<input type="text" name="JML_P_M_SLTP_GZ_KURANG"  value="<?=$data->JML_P_M_SLTP_GZ_KURANG?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI BAIK </label>
		<input type="text" name="JML_P_M_SLTP_GZ_BAIK"  value="<?=$data->JML_P_M_SLTP_GZ_BAIK?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI LEBIH</label>
		<input type="text" name="JML_P_M_SLTP_GZ_LEBIH"  value="<?=$data->JML_P_M_SLTP_GZ_LEBIH?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SEKOLAH YG MELAKSANAKAN KONSELING KESEHATAN</label>
		<input type="text" name="JML_P_SLTP_KON_KESEHATAN" value="<?=$data->JML_P_SLTP_KON_KESEHATAN?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SLTP LUAR BIASA DI WIL. PUSKESMAS </label>
		<input type="text" name="JML_P_SLTP_ALB_PUSKESMAS"  value="<?=$data->JML_P_SLTP_ALB_PUSKESMAS?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SLTP LUAR BIASA YG DIPERIKSA </label>
		<input type="text" name="JML_P_SLTP_ALB_DIPERIKSA"  value="<?=$data->JML_P_SLTP_ALB_DIPERIKSA?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SLTP LUAR BIASA YG DIRUJUK</label>
		<input type="text" name="JML_P_SLTP_ALB_DIRUJUK"  value="<?=$data->JML_P_SLTP_ALB_DIRUJUK?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SEKOLAH YANG MELAKSANAKAN UKS</label>
		<input type="text" name="JML_P_SLTP_UKS"  value="<?=$data->JML_P_SLTP_UKS?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SEKOLAH YANG DIBINA OLEH PUSKESMAS</label>
		<input type="text" name="JML_P_SLTP_DB_PUSKESMAS"  value="<?=$data->JML_P_SLTP_DB_PUSKESMAS?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label> SEKOLAH YANG MELAKSANAKAN PENJARINGAN </label>
		<input type="text" name="JML_P_SLTP_M_PENJARINGAN"  value="<?=$data->JML_P_SLTP_M_PENJARINGAN?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SEKOLAH DENGAN BB TIDAK SEIMBANG DENGAN TB</label>
		<input type="text" name="JML_P_SLTP_BBTSTB"  value="<?=$data->JML_P_SLTP_BBTSTB?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SEKOLAH YG DIPERIKSA OLEH PUSKESMAS DI SEKOLAH</label>
		<input type="text" name="JML_P_SLTP_DP_PUS_SEKOLAH"  value="<?=$data->JML_P_SLTP_DP_PUS_SEKOLAH?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SEKOLAH YANG DIRUJUK</label>
		<input type="text" name="JML_P_SLTP_DIRUJUK"  value="<?=$data->JML_P_SLTP_DIRUJUK?>"     />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">C. SEKOLAH SLTA/MA DENGAN STANDAR SEKOLAH SEHAT </div>
	</br>
	<fieldset>
		<span>
		<label>MINIMAL</label>
		<input type="text" name="JML_SLTA_SKL_MINIMAL"  value="<?=$data->JML_SLTA_SKL_MINIMAL?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>STANDAR</label>
		<input type="text" name="JML_SLTA_SKL_STANDAR"  value="<?=$data->JML_SLTA_SKL_STANDAR?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>OPTIMAL</label>
		<input type="text" name="JML_SLTA_SKL_OPTIMAL"  value="<?=$data->JML_SLTA_SKL_OPTIMAL?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PARIPURNA</label>
		<input type="text" name="JML_SLTA_SKL_PARIPURNA"  value="<?=$data->JML_SLTA_SKL_PARIPURNA?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH GURU UKS</label>
		<input type="text" name="JML_SLTA_SKL_GR_UKS"  value="<?=$data->JML_SLTA_SKL_GR_UKS?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SEKOLAH DENGAN DANA SEHAT</label>
		<input type="text" name="JML_SLTA_SKL_DANA_SEHAT"  value="<?=$data->JML_SLTA_SKL_DANA_SEHAT?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KADER KESEHATAN REMAJA YG ADA</label>
		<input type="text" name="JML_SLTA_SKL_KDR_KESEHATAN"  value="<?=$data->JML_SLTA_SKL_KDR_KESEHATAN?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SEKOLAH DENGAN PERAN AKTIF KADER KESEHATAN </label>
		<input type="text" name="JML_SLTA_SKL_AK_KDR_KESEHATAN"  value="<?=$data->JML_SLTA_SKL_AK_KDR_KESEHATAN?>"     />
		</span>
	</fieldset>
	
	<div class="subformtitle3">LAKI-LAKI</div>
	<fieldset>
		<span>
		<label>JUMLAH MURID MENDAPAT PENGOBATAN </label>
		<input type="text" name="JML_L_SLTA_PENGOBATAN"  value="<?=$data->JML_L_SLTA_PENGOBATAN?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID YG DIRUJUK</label>
		<input type="text" name="JML_L_SLTA_DIRUJUK"  value="<?=$data->JML_L_SLTA_DIRUJUK?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI BURUK </label>
		<input type="text" name="JML_L_SLTA_GZ_BURUK"  value="<?=$data->JML_L_SLTA_GZ_BURUK?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI KURANG</label>
		<input type="text" name="JML_L_SLTA_GZ_KURANG"  value="<?=$data->JML_L_SLTA_GZ_KURANG?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI BAIK </label>
		<input type="text" name="JML_L_SLTA_GZ_BAIK"  value="<?=$data->JML_L_SLTA_GZ_BAIK?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI LEBIH</label>
		<input type="text" name="JML_L_SLTA_GZ_LEBIH"  value="<?=$data->JML_L_SLTA_GZ_LEBIH?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SLTA LUAR BIASA DI WIL. PUSKESMAS </label>
		<input type="text" name="JML_L_SLTA_ALB_PUSKESMAS"  value="<?=$data->JML_L_SLTA_ALB_PUSKESMAS?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SLTA LUAR BIASA YG DIPERIKSA </label>
		<input type="text" name="JML_L_SLTA_ALB_DIPERIKSA" value="<?=$data->JML_L_SLTA_ALB_DIPERIKSA?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SLTA LUAR BIASA YG DIRUJUK</label>
		<input type="text" name="JML_L_SLTA_ALB_DIRUJUK"  value="<?=$data->JML_L_SLTA_ALB_DIRUJUK?>"     />
		</span>
	</fieldset>
	<div class="subformtitle3">PEREMPUAN</div>
	<fieldset>
		<span>
		<label>JUMLAH MURID MENDAPAT PENGOBATAN </label>
		<input type="text" name="JML_P_SLTA_PENGOBATAN" value="<?=$data->JML_P_SLTA_PENGOBATAN?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID YG DIRUJUK</label>
		<input type="text" name="JML_P_SLTA_DIRUJUK"  value="<?=$data->JML_P_SLTA_DIRUJUK?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI BURUK </label>
		<input type="text" name="JML_P_SLTA_GZ_BURUK"  value="<?=$data->JML_P_SLTA_GZ_BURUK?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI KURANG</label>
		<input type="text" name="JML_P_SLTA_GZ_KURANG"  value="<?=$data->JML_P_SLTA_GZ_KURANG?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI BAIK </label>
		<input type="text" name="JML_P_SLTA_GZ_BAIK"  value="<?=$data->JML_P_SLTA_GZ_BAIK?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID DNG GIZI LEBIH</label>
		<input type="text" name="JML_P_SLTA_GZ_LEBIH"  value="<?=$data->JML_P_SLTA_GZ_LEBIH?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SEKOLAH YG MELAKSANAKAN KONSELING KESEHATAN</label>
		<input type="text" name="JML_P_SLTA_KON_KESEHATAN"  value="<?=$data->JML_P_SLTA_KON_KESEHATAN?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SLTA LUAR BIASA DI WIL. PUSKESMAS </label>
		<input type="text" name="JML_P_SLTA_ALB_PUSKESMAS"  value="<?=$data->JML_P_SLTA_ALB_PUSKESMAS?>"      />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SLTA LUAR BIASA YG DIPERIKSA </label>
		<input type="text" name="JML_P_SLTA_ALB_DIPERIKSA"  value="<?=$data->JML_P_SLTA_ALB_DIPERIKSA?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANAK SLTA LUAR BIASA YG DIRUJUK</label>
		<input type="text" name="JML_P_SLTA_ALB_DIRUJUK"  value="<?=$data->JML_P_SLTA_ALB_DIRUJUK?>"     />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >