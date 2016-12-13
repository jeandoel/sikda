<script>
	$('#backlistinspekhotel').click(function(){
		$("#t809","#tabs").empty();
		$("#t809","#tabs").load('t_ds_kematian_anak'+'?_=' + (new Date()).getTime());
	})
</script>
<style>
input[type=text] {width: 55px!important;}
label{width:295px!important;}
</style>
<div class="mycontent">
<div class="formtitle">Detail Data Kematian Ibu</div>
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
		<input type="text" readonly  style="width:195px!important" name="TAHUN" id="tahun_ds_kematian_anak" value="<?=$data->KELURAHAN?>" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Puskesmas</label>
		<input type="text" readonly  style="width:195px!important" name="TAHUN" id="tahun_ds_kematian_anak" value="<?=$data->PUSKESMAS?>" required />
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
		<input type="text" readonly  name="TAHUN" id="tahun_ds_kematian_anak" value="<?=$data->TAHUN?>" required />
		</span>
	</fieldset>
	</br>
		<div class="subformtitle1">KEMATIAN BAYI</div>
		<div class="subformtitle3">A. LAKI-LAKI</div>
	<fieldset>
		<span>
		<label>JUMLAH KEMATIAN BAYI LAKI-LAKI</label>
		<input type="text" readonly  name="JML_L_K_BAYI" value="<?=$data->JML_L_K_BAYI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>UMUR 0-7 HARI</label>
		<input type="text" readonly  name="JML_L_U_0_7_HARI" value="<?=$data->JML_L_U_0_7_HARI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>UMUR 8-30 HARI</label>
		<input type="text" readonly  name="JML_L_U_8_30_HARI" value="<?=$data->JML_L_U_8_30_HARI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>UMUR 1-12 BULAN</label>
		<input type="text" readonly  name="JML_L_U_1_12_BULAN" value="<?=$data->JML_L_U_1_12_BULAN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>UMUR 1-5 TAHUN</label>
		<input type="text" readonly  name="JML_L_U_1_5_TAHUN" value="<?=$data->JML_L_U_1_5_TAHUN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PERSALINAN ANAK KE <5</label>
		<input type="text" readonly name="JML_P_PA_KE_KSD_5_L" value="<?=$data->JML_P_PA_KE_KSD_5_L?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PERSALINAN ANAK KE >5</label>
		<input type="text" readonly name="JML_P_PA_KE_L_5_L" value="<?=$data->JML_P_PA_KE_L_5_L?>"  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">B. PEREMPUAN</div>
	<fieldset>
		<span>
		<label>JUMLAH KEMATIAN BAYI PEREMPUAN</label>
		<input type="text" readonly  name="JML_P_K_BAYI" value="<?=$data->JML_P_K_BAYI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>UMUR 0-7 HARI</label>
		<input type="text" readonly  name="JML_P_U_0_7_HARI" value="<?=$data->JML_P_U_0_7_HARI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>UMUR 8-30 HARI</label>
		<input type="text" readonly  name="JML_P_U_8_30_HARI" value="<?=$data->JML_P_U_8_30_HARI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>UMUR 1-12 BULAN</label>
		<input type="text" readonly  name="JML_P_U_1_12_BULAN" value="<?=$data->JML_P_U_1_12_BULAN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>UMUR 1-5 TAHUN</label>
		<input type="text" readonly  name="JML_P_U_1_5_TAHUN" value="<?=$data->JML_P_U_1_5_TAHUN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PERSALINAN ANAK KE<5</label>
		<input type="text" readonly  name="JML_P_PA_KE_KSD_5" value="<?=$data->JML_P_PA_KE_KSD_5?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PERSALINAN ANAK KE>5</label>
		<input type="text" readonly  name="JML_P_PA_KE_L_5" value="<?=$data->JML_P_PA_KE_L_5?>"  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">C. ANC</div>
	<fieldset>
		<span>
		<label>ANC KE<4</label>
		<input type="text" readonly  name="JML_ANC_KSD_4" value="<?=$data->JML_ANC_KSD_4?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ANC KE>4</label>
		<input type="text" readonly  name="JML_ANC_L_4" value="<?=$data->JML_ANC_L_4?>"  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">D. STATUS IMUNISASI</div>
	<fieldset>
		<span>
		<label>BCG</label>
		<input type="text" readonly  name="JML_SI_BCG" value="<?=$data->JML_SI_BCG?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>DPT</label>
		<input type="text" readonly  name="JML_SI_DPT" value="<?=$data->JML_SI_DPT?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>POLIO</label>
		<input type="text" readonly  name="JML_SI_POLIO" value="<?=$data->JML_SI_POLIO?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>CAMPAK</label>
		<input type="text" readonly  name="JML_SI_CAMPAK" value="<?=$data->JML_SI_CAMPAK?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>HB</label>
		<input type="text" readonly  name="JML_SI_HB" value="<?=$data->JML_SI_HB?>"  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">E. SEBAB KEMATIAN</div>
	<fieldset>
		<span>
		<label>TETANUS NEONATORIUM(TN)</label>
		<input type="text" readonly  name="JML_SK_TN" value="<?=$data->JML_SK_TN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BBLR</label>
		<input type="text" readonly  name="JML_SK_BBLR" value="<?=$data->JML_SK_BBLR?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ASFEKSIA</label>
		<input type="text" readonly  name="JML_SK_ASFEKSIA" value="<?=$data->JML_SK_ASFEKSIA?>"  />
		</span>
	</fieldset><fieldset>
		<span>
		<label>LAIN-LAIN</label>
		<input type="text" readonly  name="JML_SK_LAIN_LAIN" value="<?=$data->JML_SK_LAIN_LAIN?>"  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">F. TEMPAT KEMATIAN</div>
	<fieldset>
		<span>
		<label>RUMAH</label>
		<input type="text" readonly  name="JML_TK_RUMAH" value="<?=$data->JML_TK_RUMAH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PUSKESMAS/RB</label>
		<input type="text" readonly  name="JML_TK_PUSKESMAS_RB" value="<?=$data->JML_TK_PUSKESMAS_RB?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>RUMAH SAKIT</label>
		<input type="text" readonly  name="JML_TK_RS" value="<?=$data->JML_TK_RS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PERJALANAN</label>
		<input type="text" readonly  name="JML_TK_PERJALANAN" value="<?=$data->JML_TK_PERJALANAN?>"  />
		</span>
	</fieldset>
	</br>
	<div class="subformtitle3">G. PENOLONG / PERSALINAN</div>
	<fieldset>
		<span>
		<label>DUKUN</label>
		<input type="text" readonly  name="JML_PP_DUKUN" value="<?=$data->JML_PP_DUKUN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>BIDAN</label>
		<input type="text" readonly  name="JML_PP_BIDAN" value="<?=$data->JML_PP_BIDAN?>"  />
		</span>
	</fieldset>
	
</form>
</div >