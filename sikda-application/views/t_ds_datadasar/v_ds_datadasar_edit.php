<script>
$(document).ready(function(){
		$('#form1ds_datadasaredit').ajaxForm({
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
					$("#t801","#tabs").empty();
					$("#t801","#tabs").load('t_ds_datadasar'+'?_=' + (new Date()).getTime());
				}
			}
		});
})

$("#desa_kel_id_combo_ds_datadasar").remoteChained("#kec_id_combo_ds_datadasar", "<?=site_url('t_masters/getKelurahanByKecamatanId3')?>");
$("#puskesmas_id_combo_ds_datadasar").remoteChained("#kec_id_combo_ds_datadasar", "<?=site_url('t_masters/getPuskesmasByKecamatanId2')?>");

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
	$('#backlistds_datadasar').click(function(){
		$("#t801","#tabs").empty();
		$("#t801","#tabs").load('t_ds_datadasar'+'?_=' + (new Date()).getTime());
	})
	$("#tahun_ds_datadasar").mask("9999");
</script>
<style>
input[type=text] {width: 55px!important;}
label{width:295px!important;}
</style>
<div class="mycontent">
<div class="formtitle">Edit Data Dasar</div>
<div class="backbutton"><span class="kembali" id="backlistds_datadasar">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1ds_datadasaredit" method="post" action="<?=site_url('t_ds_datadasar/editprocess')?>">	
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
	<?=getComboKecamatanByKab($data->KD_KECAMATAN,'KD_KECAMATAN','kec_id_combo_ds_datadasar','required','')?>
	<?=getComboPuskesmasByKec($data->KD_PUSKESMAS,'KD_PUSKESMAS','puskesmas_id_combo_ds_datadasar','required','')?>
	<?=getComboKelurahanByKec($data->KD_KELURAHAN,'KD_KELURAHAN','desa_kel_id_combo_ds_datadasar','required','')?>
	<!--<fieldset>
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
	</fieldset>-->
	<fieldset>
		<span>
		<label>Tahun*</label>
		<input type="text" name="TAHUN" id="tahun_ds_datadasar" value="<?=$data->TAHUN?>" required />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">SASARAN PENDUDUK (KOORDINATOR TU)</div>
	<fieldset>
		<span>
		<label>JUMLAH DESA</label>
		<input type="text" name="JML_SP_DESA" value="<?=$data->JML_SP_DESA?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH RT</label>
		<input type="text" name="JML_SP_RT" value="<?=$data->JML_SP_RT?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH RW</label>
		<input type="text" name="JML_SP_RW" value="<?=$data->JML_SP_RW?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KK</label>
		<input type="text" name="JML_SP_KK" value="<?=$data->JML_SP_KK?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>LUAS WILAYAH</label>
		<input type="text" name="JML_SP_L_WILAYAH" value="<?=$data->JML_SP_L_WILAYAH?>"  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">LAKI-LAKI</div>
	<fieldset>
		<span>
		<label>JUMLAH KURANG DARI 1 TAHUN</label>
		<input type="text" name="JML_L_K1TH" value="<?=$data->JML_L_K1TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 1 SAMPAI 4 TAHUN</label>
		<input type="text" name="JML_L_1_4TH" value="<?=$data->JML_L_1_4TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 5 SAMPAI 9 TAHUN</label>
		<input type="text" name="JML_L_5_9TH" value="<?=$data->JML_L_5_9TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 10 SAMPAI 14 TAHUN</label>
		<input type="text" name="JML_L_10_14TH" value="<?=$data->JML_L_10_14TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 15 SAMPAI 19 TAHUN</label>
		<input type="text" name="JML_L_15_19TH" value="<?=$data->JML_L_15_19TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 20 SAMPAI 24 TAHUN</label>
		<input type="text" name="JML_L_20_24TH" value="<?=$data->JML_L_20_24TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 25 SAMPAI 29 TAHUN</label>
		<input type="text" name="JML_L_25_29TH" value="<?=$data->JML_L_25_29TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 30 SAMPAI 34 TAHUN</label>
		<input type="text" name="JML_L_30_34TH" value="<?=$data->JML_L_30_34TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 35 SAMPAI 39 TAHUN</label>
		<input type="text" name="JML_L_35_39TH" value="<?=$data->JML_L_35_39TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 40 SAMPAI 44 TAHUN</label>
		<input type="text" name="JML_L_40_44TH" value="<?=$data->JML_L_40_44TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 45 SAMPAI 49 TAHUN</label>
		<input type="text" name="JML_L_45_49TH" value="<?=$data->JML_L_45_49TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 50 SAMPAI 54 TAHUN</label>
		<input type="text" name="JML_L_50_54TH" value="<?=$data->JML_L_50_54TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 55 SAMPAI 59 TAHUN</label>
		<input type="text" name="JML_L_55_59TH" value="<?=$data->JML_L_55_59TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 60 SAMPAI 64 TAHUN</label>
		<input type="text" name="JML_L_60_64TH" value="<?=$data->JML_L_60_64TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 65 SAMPAI 69 TAHUN</label>
		<input type="text" name="JML_L_65_69TH" value="<?=$data->JML_L_65_69TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 70 SAMPAI 74 TAHUN</label>
		<input type="text" name="JML_L_70_74TH" value="<?=$data->JML_L_70_74TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH DIATAS 75 TAHUN</label>
		<input type="text" name="JML_L_L75TH" value="<?=$data->JML_L_L75TH?>"  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">PEREMPUAN</div>
	<fieldset>
		<span>
		<label>JUMLAH KURANG DARI 1 TAHUN</label>
		<input type="text" name="JML_P_K1TH" value="<?=$data->JML_P_K1TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 1 SAMPAI 4 TAHUN</label>
		<input type="text" name="JML_P_1_4TH" value="<?=$data->JML_P_1_4TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 5 SAMPAI 9 TAHUN</label>
		<input type="text" name="JML_P_5_9TH" value="<?=$data->JML_P_5_9TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 10 SAMPAI 14 TAHUN</label>
		<input type="text" name="JML_P_10_14TH" value="<?=$data->JML_P_10_14TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 15 SAMPAI 19 TAHUN</label>
		<input type="text" name="JML_P_15_19TH" value="<?=$data->JML_P_15_19TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 20 SAMPAI 24 TAHUN</label>
		<input type="text" name="JML_P_20_24TH" value="<?=$data->JML_P_20_24TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 25 SAMPAI 29 TAHUN</label>
		<input type="text" name="JML_P_25_29TH" value="<?=$data->JML_P_25_29TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 30 SAMPAI 34 TAHUN</label>
		<input type="text" name="JML_P_30_34TH" value="<?=$data->JML_P_30_34TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 35 SAMPAI 39 TAHUN</label>
		<input type="text" name="JML_P_35_39TH" value="<?=$data->JML_P_35_39TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 40 SAMPAI 44 TAHUN</label>
		<input type="text" name="JML_P_40_44TH" value="<?=$data->JML_P_40_44TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 45 SAMPAI 49 TAHUN</label>
		<input type="text" name="JML_P_45_49TH" value="<?=$data->JML_P_45_49TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 50 SAMPAI 54 TAHUN</label>
		<input type="text" name="JML_P_50_54TH" value="<?=$data->JML_P_50_54TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 55 SAMPAI 59 TAHUN</label>
		<input type="text" name="JML_P_55_59TH" value="<?=$data->JML_P_55_59TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 60 SAMPAI 64 TAHUN</label>
		<input type="text" name="JML_P_60_64TH" value="<?=$data->JML_P_60_64TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 65 SAMPAI 69 TAHUN</label>
		<input type="text" name="JML_P_65_69TH" value="<?=$data->JML_P_65_69TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH ANTARA 70 SAMPAI 74 TAHUN</label>
		<input type="text" name="JML_P_70_74TH" value="<?=$data->JML_P_70_74TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH DIATAS 75 TAHUN</label>
		<input type="text" name="JML_P_L75TH" value="<?=$data->JML_P_L75TH?>"  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">GAKIN</div>
	<fieldset>
		<span>
		<label>JUMLAH GAKIN</label>
		<input type="text" name="JML_GA_GAKIN" value="<?=$data->JML_GA_GAKIN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH LAKI-LAKI</label>
		<input type="text" name="JML_GA_LAKI" value="<?=$data->JML_GA_LAKI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PEREMPUAN</label>
		<input type="text" name="JML_GA_PEREMPUAN" value="<?=$data->JML_GA_PEREMPUAN?>"  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">SARANA AIR BERSIH (KESEHATAN LINGKUNGAN)</div>
	<fieldset>
		<span>
		<label>JUMLAH RUMAH</label>
		<input type="text" name="JML_SAB_RUMAH" value="<?=$data->JML_SAB_RUMAH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SGL</label>
		<input type="text" name="JML_SAB_SGL" value="<?=$data->JML_SAB_SGL?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SPT</label>
		<input type="text" name="JML_SAB_SPT" value="<?=$data->JML_SAB_SPT?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SR/PDAM</label>
		<input type="text" name="JML_SAB_SR_PDAM" value="<?=$data->JML_SAB_SR_PDAM?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH LAIN-LAIN</label>
		<input type="text" name="JML_SAB_LAINLAIN" value="<?=$data->JML_SAB_LAINLAIN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SPAL</label>
		<input type="text" name="JML_SAB_SPAL" value="<?=$data->JML_SAB_SPAL?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH JAMBAN KELUARGA</label>
		<input type="text" name="JML_SAB_J_KELUARGA" value="<?=$data->JML_SAB_J_KELUARGA?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH TPA</label>
		<input type="text" name="JML_SAB_TPA" value="<?=$data->JML_SAB_TPA?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH TPS</label>
		<input type="text" name="JML_SAB_TPS" value="<?=$data->JML_SAB_TPS?>"  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">TEMPAT-TEMPAT UMUM</div>
	<fieldset>
		<span>
		<label>JUMLAH TK</label>
		<input type="text" name="JML_TTU_TK" value="<?=$data->JML_TTU_TK?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SD</label>
		<input type="text" name="JML_TTU_SD" value="<?=$data->JML_TTU_SD?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MI</label>
		<input type="text" name="JML_TTU_MI" value="<?=$data->JML_TTU_MI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SLTP</label>
		<input type="text" name="JML_TTU_SLTP" value="<?=$data->JML_TTU_SLTP?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MTS</label>
		<input type="text" name="JML_TTU_MTS" value="<?=$data->JML_TTU_MTS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SLTA</label>
		<input type="text" name="JML_TTU_SLTA" value="<?=$data->JML_TTU_SLTA?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MA</label>
		<input type="text" name="JML_TTU_MA" value="<?=$data->JML_TTU_MA?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PERGURUAN TINGGI</label>
		<input type="text" name="JML_TTU_P_TINGGI" value="<?=$data->JML_TTU_P_TINGGI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KIOS</label>
		<input type="text" name="JML_TTU_KIOS" value="<?=$data->JML_TTU_KIOS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH HOTEL/MELATI/LOSMEN</label>
		<input type="text" name="JML_TTU_H_M_LOSMEN" value="<?=$data->JML_TTU_H_M_LOSMEN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SALON KECANTIKAN/PANGKAS RAMBUT</label>
		<input type="text" name="JML_TTU_SK_P_RAMBUT" value="<?=$data->JML_TTU_SK_P_RAMBUT?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH TEMPAT REKREASI</label>
		<input type="text" name="JML_TTU_T_REKREASI" value="<?=$data->JML_TTU_T_REKREASI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH GEDUNG PERTEMUAN/GEDUNG PERTUNJUKAN</label>
		<input type="text" name="JML_TTU_GP_G_PERTUNJUKAN" value="<?=$data->JML_TTU_GP_G_PERTUNJUKAN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KOLAM RENANG</label>
		<input type="text" name="JML_TTU_K_RENANG" value="<?=$data->JML_TTU_K_RENANG?>"  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">SARANA IBADAH</div>
	<fieldset>
		<span>
		<label>JUMLAH MASJID/MUSHOLA</label>
		<input type="text" name="JML_SI_MAS_MUSHOLA" value="<?=$data->JML_SI_MAS_MUSHOLA?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH GEREJA</label>
		<input type="text" name="JML_SI_GEREJA" value="<?=$data->JML_SI_GEREJA?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KLENTENG</label>
		<input type="text" name="JML_SI_KLENTENG" value="<?=$data->JML_SI_KLENTENG?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PURA</label>
		<input type="text" name="JML_SI_PURA" value="<?=$data->JML_SI_PURA?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH VIHARA</label>
		<input type="text" name="JML_SI_VIHARA" value="<?=$data->JML_SI_VIHARA?>"  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">SARANA TRANSPORTASI</div>
	<fieldset>
		<span>
		<label>JUMLAH TERMINAL</label>
		<input type="text" name="JML_STR_TERMINAL" value="<?=$data->JML_STR_TERMINAL?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH STASIUN</label>
		<input type="text" name="JML_STR_STASIUN" value="<?=$data->JML_STR_STASIUN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PELABUHAN LAUT</label>
		<input type="text" name="JML_STR_P_LAUT" value="<?=$data->JML_STR_P_LAUT?>"  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">SARANA EKONOMI DAN SOSIAL</div>
	<fieldset>
		<span>
		<label>JUMLAH PASAR</label>
		<input type="text" name="JML_SES_PASAR" value="<?=$data->JML_SES_PASAR?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH APOTIK</label>
		<input type="text" name="JML_SES_APOTIK" value="<?=$data->JML_SES_APOTIK?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH TOKO OBAT</label>
		<input type="text" name="JML_SES_T_OBAT" value="<?=$data->JML_SES_T_OBAT?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PANTI SOSIAL</label>
		<input type="text" name="JML_SES_P_SOSIAL" value="<?=$data->JML_SES_P_SOSIAL?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH SARANA KESEHATAN</label>
		<input type="text" name="JML_SES_S_KESEHATAN" value="<?=$data->JML_SES_S_KESEHATAN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PERKANTORAN</label>
		<input type="text" name="JML_SES_PERKANTORAN" value="<?=$data->JML_SES_PERKANTORAN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PONDOK PESANTREN</label>
		<input type="text" name="JML_SES_P_PESANTREN" value="<?=$data->JML_SES_P_PESANTREN?>"  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">TEMPAT PENGOLAHAN MAKANAN</div>
	<fieldset>
		<span>
		<label>JUMLAH WARUNG MAKAN</label>
		<input type="text" name="JML_TPM_W_MAKAN" value="<?=$data->JML_TPM_W_MAKAN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH RUMAH MAKAN</label>
		<input type="text" name="JML_TPM_R_MAKAN" value="<?=$data->JML_TPM_R_MAKAN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH JASA BOGA/CATERING</label>
		<input type="text" name="JML_TPM_JB_CATERING" value="<?=$data->JML_TPM_JB_CATERING?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH INDUSTRI MAKANAN DANA MINUMAN</label>
		<input type="text" name="JML_TPM_IMD_MINUMAN" value="<?=$data->JML_TPM_IMD_MINUMAN?>"  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">SASARAN (KIA)</div>
	<fieldset>
		<span>
		<label>JUMLAH PUS</label>
		<input type="text" name="JML_SASKIA_PUS" value="<?=$data->JML_SASKIA_PUS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH WUS</label>
		<input type="text" name="JML_SASKIA_WUS" value="<?=$data->JML_SASKIA_WUS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH BAYI LAKI-LAKI</label>
		<input type="text" name="JML_L_SASKIA_BAYI" value="<?=$data->JML_L_SASKIA_BAYI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH BAYI PEREMPUAN</label>
		<input type="text" name="JML_P_SASKIA_BAYI" value="<?=$data->JML_P_SASKIA_BAYI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH BALITA LAKI-LAKI</label>
		<input type="text" name="JML_L_SASKIA_BALITA" value="<?=$data->JML_L_SASKIA_BALITA?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH BALITA PEREMPUAN</label>
		<input type="text" name="JML_P_SASKIA_BALITA" value="<?=$data->JML_P_SASKIA_BALITA?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH BUMIL</label>
		<input type="text" name="JML_SASKIA_BUMIL" value="<?=$data->JML_SASKIA_BUMIL?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH BULIN</label>
		<input type="text" name="JML_SASKIA_BULIN" value="<?=$data->JML_SASKIA_BULIN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH BUFAS</label>
		<input type="text" name="JML_SASKIA_BUFAS" value="<?=$data->JML_SASKIA_BUFAS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH K1</label>
		<input type="text" name="JML_SASKIA_K1" value="<?=$data->JML_SASKIA_K1?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH K4</label>
		<input type="text" name="JML_SASKIA_K4" value="<?=$data->JML_SASKIA_K4?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KN1</label>
		<input type="text" name="JML_SASKIA_KN1" value="<?=$data->JML_SASKIA_KN1?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KN2</label>
		<input type="text" name="JML_SASKIA_KN2" value="<?=$data->JML_SASKIA_KN2?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PERSALINAN NAKES</label>
		<input type="text" name="JML_SASKIA_P_NAKES" value="<?=$data->JML_SASKIA_P_NAKES?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PERSALINAN NON NAKES</label>
		<input type="text" name="JML_SASKIA_P_NON_NAKES" value="<?=$data->JML_SASKIA_P_NON_NAKES?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH RESTI NAKES</label>
		<input type="text" name="JML_SASKIA_RES_NAKES" value="<?=$data->JML_SASKIA_RES_NAKES?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH RESTI MASYARAKAT</label>
		<input type="text" name="JML_SASKIA_RES_MASYARAKAT" value="<?=$data->JML_SASKIA_RES_MASYARAKAT?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PMPB</label>
		<input type="text" name="JML_SASKIA_PMPB" value="<?=$data->JML_SASKIA_PMPB?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH POSYANDU</label>
		<input type="text" name="JML_SASKIA_POSYANDU" value="<?=$data->JML_SASKIA_POSYANDU?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID TK</label>
		<input type="text" name="JML_SASKIA_M_TK" value="<?=$data->JML_SASKIA_M_TK?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH KADER</label>
		<input type="text" name="JML_SASKIA_KADER" value="<?=$data->JML_SASKIA_KADER?>"  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">SASARAN (DATA DASAR)</div>
	<fieldset>
		<span>
		<label>JUMLAH MURID TK LAKI-LAKI</label>
		<input type="text" name="JML_L_SAS_DD_M_TK" value="<?=$data->JML_L_SAS_DD_M_TK?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID TK PEREMPUAN</label>
		<input type="text" name="JML_P_SAS_DD_M_TK" value="<?=$data->JML_P_SAS_DD_M_TK?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID SD KELAS 1 LAKI-LAKI</label>
		<input type="text" name="JML_L_SAS_DD_MSD_KELAS1" value="<?=$data->JML_L_SAS_DD_MSD_KELAS1?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID SD KELAS 1 PEREMPUAN</label>
		<input type="text" name="JML_P_SAS_DD_MSD_KELAS1" value="<?=$data->JML_P_SAS_DD_MSD_KELAS1?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID SD KELAS 2 LAKI-LAKI</label>
		<input type="text" name="JML_L_SAS_DD_MSD_KELAS2" value="<?=$data->JML_L_SAS_DD_MSD_KELAS2?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID SD KELAS 2 PEREMPUAN</label>
		<input type="text" name="JML_P_SAS_DD_MSD_KELAS2" value="<?=$data->JML_P_SAS_DD_MSD_KELAS2?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID SD KELAS 3 LAKI-LAKI</label>
		<input type="text" name="JML_L_SAS_DD_MSD_KELAS3" value="<?=$data->JML_L_SAS_DD_MSD_KELAS3?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH MURID SD KELAS 3 PEREMPUAN</label>
		<input type="text" id="JML_P_SAS_DD_MSD_KELAS3" name="JML_P_SAS_DD_MSD_KELAS3" value="<?=$data->JML_P_SAS_DD_MSD_KELAS3?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >