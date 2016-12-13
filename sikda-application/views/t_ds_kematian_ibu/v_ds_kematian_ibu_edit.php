<script>
$(document).ready(function(){
		$('#form1ds_kematian_ibuedit').ajaxForm({
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
					$("#t808","#tabs").empty();
					$("#t808","#tabs").load('t_ds_kematian_ibu'+'?_=' + (new Date()).getTime());
				}
			}
		});
})

$("#desa_kel_id_combo_ds_kematian_ibu").remoteChained("#kec_id_combo_ds_kematian_ibu", "<?=site_url('t_masters/getKelurahanByKecamatanId3')?>");
$("#puskesmas_id_combo_ds_kematian_ibu").remoteChained("#kec_id_combo_ds_kematian_ibu", "<?=site_url('t_masters/getPuskesmasByKecamatanId2')?>");

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
	$('#backlistds_kematian_ibu').click(function(){
		$("#t808","#tabs").empty();
		$("#t808","#tabs").load('t_ds_kematian_ibu'+'?_=' + (new Date()).getTime());
	})
	$("#tahun_ds_kematian_ibu").mask("9999");
</script>
<style>
input[type=text] {width: 55px!important;}
label{width:295px!important;}
</style>
<div class="mycontent">
<div class="formtitle">Edit Data Kematian Ibu</div>
<div class="backbutton"><span class="kembali" id="backlistds_kematian_ibu">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1ds_kematian_ibuedit" method="post" action="<?=site_url('t_ds_kematian_ibu/editprocess')?>">	
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
	<?=getComboKecamatanByKab($data->KD_KECAMATAN,'KD_KECAMATAN','kec_id_combo_ds_kematian_ibu','required','')?>
	<?=getComboKelurahanByKec($data->KD_KELURAHAN,'KD_KELURAHAN','desa_kel_id_combo_ds_kematian_ibu','required','')?>
	<?=getComboPuskesmasByKec($data->KD_PUSKESMAS,'KD_PUSKESMAS','puskesmas_id_combo_ds_kematian_ibu','required','')?>
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
		<input type="text" name="TAHUN" id="tahun_ds_kematian_ibu" value="<?=$data->TAHUN?>" required />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">KEMATIAN IBU</div>
	<fieldset>
		<span>
		<label>JUMLAH KEMATIAN IBU</label>
		<input type="text" name="JML_K_IBU" value="<?=$data->JML_K_IBU?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IDENTITAS IBU MENGIGGAL UMUR<20TH</label>
		<input type="text" name="JML_IIYM_UMUR_K_20" value="<?=$data->JML_IIYM_UMUR_K_20?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IDENTITAS IBU MENGIGGAL UMUR20-30TH</label>
		<input type="text" name="JML_IIYM_UMUR_20_30TH" value="<?=$data->JML_IIYM_UMUR_20_30TH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IDENTITAS IBU MENGIGGAL UMUR>30TH</label>
		<input type="text" name="JML_IIYM_UMUR_L_30TH" value="<?=$data->JML_IIYM_UMUR_L_30TH?>"  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">PENDIDIKAN</div>
	<fieldset>
		<span>
		<label>JUMLAH PENDIDIKAN SD</label>
		<input type="text" name="JML_P_SD" value="<?=$data->JML_P_SD?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PENDIDIKAN SLTP</label>
		<input type="text"  name="JML_P_SLTP" value="<?=$data->JML_P_SLTP?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH PENDIDIKAN SLTA</label>
		<input type="text" name="JML_P_SLTA" value="<?=$data->JML_P_SLTA?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PERSALINAN ANAK KE<5</label>
		<input type="text" name="JML_P_PA_KE_K_5" value="<?=$data->JML_P_PA_KE_K_5?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PERSALINAN ANAK KE>5</label>
		<input type="text" name="JML_P_PA_KE_L_5" value="<?=$data->JML_P_PA_KE_L_5?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANC KE<4</label>
		<input type="text" name="JML_P_ANC_K_4" value="<?=$data->JML_P_ANC_K_4?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANC KE>4</label>
		<input type="text" name="JML_P_ANC_L_4" value="<?=$data->JML_P_ANC_L_4?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>STATUS IMUNISASI: O</label>
		<input type="text" name="JML_P_S_IMUNISASI_O" value="<?=$data->JML_P_S_IMUNISASI_O?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>STATUS IMUNISASI: TT1</label>
		<input type="text" name="JML_P_S_IMUNISASI_TT1" value="<?=$data->JML_P_S_IMUNISASI_TT1?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>STATUS IMUNISASI: TT2</label>
		<input type="text" name="JML_P_S_IMUNISASI_TT2" value="<?=$data->JML_P_S_IMUNISASI_TT2?>"  />
		</span>
	</fieldset>
	<div class="subformtitle3">SEBAB KEMATIAN</div>
	<fieldset>
		<span>
		<label>PENDARAHAN</label>
		<input type="text" name="JML_SK_PENDARAHAN" value="<?=$data->JML_SK_PENDARAHAN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>EKLAMSI</label>
		<input type="text" name="JML_SK_EKLAMSI" value="<?=$data->JML_SK_EKLAMSI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SEPSIS</label>
		<input type="text" name="JML_SK_SEPSIS" value="<?=$data->JML_SK_SEPSIS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>LAIN-LAIN</label>
		<input type="text" name="JML_SK_LAIN_LAIN" value="<?=$data->JML_SK_LAIN_LAIN?>"  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">MENINGGAL SAAT</div>
	<fieldset>
		<span>
		<label>HAMIL</label>
		<input type="text" name="JML_MS_HAMIL" value="<?=$data->JML_MS_HAMIL?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NIFAS</label>
		<input type="text" name="JML_MS_NIFAS" value="<?=$data->JML_MS_NIFAS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BERSALIN</label>
		<input type="text" name="JML_MS_BERSALIN" value="<?=$data->JML_MS_BERSALIN?>"  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">TEMPAT KEMATIAN</div>
	<fieldset>
		<span>
		<label>RUMAH</label>
		<input type="text" name="JML_TK_KI_RUMAH" value="<?=$data->JML_TK_KI_RUMAH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PUSKESMAS/RB</label>
		<input type="text" name="JML_TK_KI_PUSKESMAS_R_B" value="<?=$data->JML_TK_KI_PUSKESMAS_R_B?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>RUMAH SAKIT</label>
		<input type="text" name="JML_TK_KI_RS" value="<?=$data->JML_TK_KI_RS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PERJALANAN</label>
		<input type="text" name="JML_TK_KI_PERJALANAN" value="<?=$data->JML_TK_KI_PERJALANAN?>"  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle1">PENOLONG / PERSALINAN</div>
	<fieldset>
		<span>
		<label>DUKUN</label>
		<input type="text" name="JML_KI_PP_DUKUN" value="<?=$data->JML_KI_PP_DUKUN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BIDAN</label>
		<input type="text" name="JML_KI_PP_BIDAN" value="<?=$data->JML_KI_PP_BIDAN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>DOKTER</label>
		<input type="text" name="JML_KI_PP_DR" value="<?=$data->JML_KI_PP_DR?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >