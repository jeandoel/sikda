<script>
	$('#backlistinspekhotel').click(function(){
		$("#t813","#tabs").empty();
		$("#t813","#tabs").load('t_ds_imunisasi'+'?_=' + (new Date()).getTime());
	})
</script>
<style>
input[type=text] {width: 55px!important;}
label{width:295px!important;}
.menu_jk{width: 100%;}
.menu_l{float: left; padding-left: 335px; font-size: 12px;}
.menu_p{float: left; padding-left: 60px; font-size: 12px;}
</style>
<div class="mycontent">
<div class="formtitle">Detail Data Imunisasi</div>
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
		<input type="text" readonly  style="width:195px!important" name="TAHUN" id="tahun_ds_imunisasi" value="<?=$data->KELURAHAN?>" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Puskesmas</label>
		<input type="text" readonly  style="width:195px!important" name="TAHUN" id="tahun_ds_imunisasi" value="<?=$data->PUSKESMAS?>" required />
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
		<input type="text" readonly  name="TAHUN" id="tahun_ds_imunisasi" value="<?=$data->TAHUN?>" required />
		</span>
	</fieldset>
	<div class="menu_jk">
	<div class="menu_l"><b>L</b></div>
	<div class="menu_p"><b>P</b></div>
	</div>
	<br>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI BCG</label>
		<input type="text" readonly  name="JML_IMUN_BCG_L" value="<?=$data->JML_IMUN_BCG_L?>"  />
		<input type="text" readonly  name="JML_IMUN_BCG_P" value="<?=$data->JML_IMUN_BCG_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI DPT 1</label>
		<input type="text" readonly  name="JML_IMUN_DPT1_L" value="<?=$data->JML_IMUN_DPT1_L?>"  />
		<input type="text" readonly  name="JML_IMUN_DPT1_P" value="<?=$data->JML_IMUN_DPT1_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI DPT 2</label>
		<input type="text" readonly  name="JML_IMUN_DPT2_L" value="<?=$data->JML_IMUN_DPT2_L?>"  />
		<input type="text" readonly  name="JML_IMUN_DPT2_P" value="<?=$data->JML_IMUN_DPT2_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI DPT 3</label>
		<input type="text" readonly  name="JML_IMUN_DPT3" value="<?=$data->JML_IMUN_DPT3_L?>"  />
		<input type="text" readonly  name="JML_IMUN_DPT3" value="<?=$data->JML_IMUN_DPT3_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI DPT HB 1</label>
		<input type="text" readonly  name="JML_IMUN_DPT_HB1_L" value="<?=$data->JML_IMUN_DPT_HB1_L?>"  />
		<input type="text" readonly  name="JML_IMUN_DPT_HB1_P" value="<?=$data->JML_IMUN_DPT_HB1_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI DPT HB 2</label>
		<input type="text" readonly  name="JML_IMUN_DPT_HB2_L" value="<?=$data->JML_IMUN_DPT_HB2_L?>"  />
		<input type="text" readonly  name="JML_IMUN_DPT_HB2_P" value="<?=$data->JML_IMUN_DPT_HB2_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI DPT HB 3</label>
		<input type="text" readonly  name="JML_IMUN_DPT_HB3_L" value="<?=$data->JML_IMUN_DPT_HB3_L?>"  />
		<input type="text" readonly  name="JML_IMUN_DPT_HB3_P" value="<?=$data->JML_IMUN_DPT_HB3_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI POLIO 1</label>
		<input type="text" readonly  name="JML_IMUN_POLIO1_L" value="<?=$data->JML_IMUN_POLIO1_L?>"  />
		<input type="text" readonly  name="JML_IMUN_POLIO1_P" value="<?=$data->JML_IMUN_POLIO1_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI POLIO 2</label>
		<input type="text" readonly  name="JML_IMUN_POLIO2_L" value="<?=$data->JML_IMUN_POLIO2_L?>"  />
		<input type="text" readonly  name="JML_IMUN_POLIO2_P" value="<?=$data->JML_IMUN_POLIO2_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI POLIO 3</label>
		<input type="text" readonly  name="JML_IMUN_POLIO3_L" value="<?=$data->JML_IMUN_POLIO3_L?>"  />
		<input type="text" readonly  name="JML_IMUN_POLIO3_P" value="<?=$data->JML_IMUN_POLIO3_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI POLIO 4</label>
		<input type="text" readonly  name="JML_IMUN_POLIO4_L" value="<?=$data->JML_IMUN_POLIO4_L?>"  />
		<input type="text" readonly  name="JML_IMUN_POLIO4_P" value="<?=$data->JML_IMUN_POLIO4_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI CAMPAK</label>
		<input type="text" readonly  name="JML_IMUN_CAMPAK_L" value="<?=$data->JML_IMUN_CAMPAK_L?>"  />
		<input type="text" readonly  name="JML_IMUN_CAMPAK_P" value="<?=$data->JML_IMUN_CAMPAK_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI HEPATITIS B UNIJECT < 7 HARI</label>
		<input type="text" readonly  name="JML_IMUN_HBU_M7_L" value="<?=$data->JML_IMUN_HBU_M7_L?>"  />
		<input type="text" readonly  name="JML_IMUN_HBU_M7_P" value="<?=$data->JML_IMUN_HBU_M7_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI HEPATITIS B UNIJECT > 7 HARI</label>
		<input type="text" readonly  name="JML_IMUN_HBU_P7_L" value="<?=$data->JML_IMUN_HBU_P7_L?>"  />
		<input type="text" readonly  name="JML_IMUN_HBU_P7_P" value="<?=$data->JML_IMUN_HBU_P7_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI HEPATITIS B UNIJECT 2</label>
		<input type="text" readonly  name="JML_IMUN_HB_UNIJECT2_L" value="<?=$data->JML_IMUN_HB_UNIJECT2_L?>"  />
		<input type="text" readonly  name="JML_IMUN_HB_UNIJECT2_P" value="<?=$data->JML_IMUN_HB_UNIJECT2_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI HEPATITIS B UNIJECT 3</label>
		<input type="text" readonly  name="JML_IMUN_HB_UNIJECT3_L" value="<?=$data->JML_IMUN_HB_UNIJECT3_L?>"  />
		<input type="text" readonly  name="JML_IMUN_HB_UNIJECT3_P" value="<?=$data->JML_IMUN_HB_UNIJECT3_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI HEPATITIS B VIAL 1</label>
		<input type="text" readonly  name="JML_IMUN_HB_VIAL1_L" value="<?=$data->JML_IMUN_HB_VIAL1_L?>"  />
		<input type="text" readonly  name="JML_IMUN_HB_VIAL1_P" value="<?=$data->JML_IMUN_HB_VIAL1_P?>"  />
		</span>
	</fieldset><fieldset>
		<span>
		<label>JUMLAH IMUNISASI HEPATITIS B VIAL 2</label>
		<input type="text" readonly  name="JML_IMUN_HB_VIAL2_L" value="<?=$data->JML_IMUN_HB_VIAL2_L?>"  />
		<input type="text" readonly  name="JML_IMUN_HB_VIAL2_P" value="<?=$data->JML_IMUN_HB_VIAL2_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI HEPATITIS B VIAL 3</label>
		<input type="text" readonly  name="JML_IMUN_HB_VIAL3_L" value="<?=$data->JML_IMUN_HB_VIAL3_L?>"  />
		<input type="text" readonly  name="JML_IMUN_HB_VIAL3_P" value="<?=$data->JML_IMUN_HB_VIAL3_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI TT 1 IBU HAMIL</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_IMUN_TT1_HAMIL_P" value="<?=$data->JML_IMUN_TT1_HAMIL_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI TT 1 WUS</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_IMUN_TT1_WUS_P" value="<?=$data->JML_IMUN_TT1_WUS_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI TT 2 IBU HAMIL</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_IMUN_TT2_HAMIL_P" value="<?=$data->JML_IMUN_TT2_HAMIL_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI TT 2 WUS</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_IMUN_TT2_WUS_P" value="<?=$data->JML_IMUN_TT2_WUS_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI TT 3 IBU HAMIL</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_IMUN_TT3_HAMIL_P" value="<?=$data->JML_IMUN_TT3_HAMIL_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI TT 3 WUS</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_IMUN_TT3_WUS_P" value="<?=$data->JML_IMUN_TT3_WUS_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI TT 4 IBU HAMIL</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_IMUN_TT4_HAMIL_P" value="<?=$data->JML_IMUN_TT4_HAMIL_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI TT 4 WUS</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_IMUN_TT4_WUS_P" value="<?=$data->JML_IMUN_TT4_WUS_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI TT 5 IBU HAMIL</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_IMUN_TT5_HAMIL_P" value="<?=$data->JML_IMUN_TT5_HAMIL_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI TT 5 WUS</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_IMUN_TT5_WUS_P" value="<?=$data->JML_IMUN_TT5_WUS_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI BCG LUAR WILAYAH/SWASTA</label>
		<input type="text" readonly  name="JML_IMUN_BCGL_WILAYAH_L" value="<?=$data->JML_IMUN_BCGL_WILAYAH_L?>"  />
		<input type="text" readonly  name="JML_IMUN_BCGL_WILAYAH_P" value="<?=$data->JML_IMUN_BCGL_WILAYAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI DPT 1 LUAR WILAYAH/SWASTA</label>
		<input type="text" readonly  name="JML_IMUN_DPT1L_WILAYAH_L" value="<?=$data->JML_IMUN_DPT1L_WILAYAH_L?>"  />
		<input type="text" readonly  name="JML_IMUN_DPT1L_WILAYAH_P" value="<?=$data->JML_IMUN_DPT1L_WILAYAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI DPT 2 LUAR WILAYAH/SWASTA</label>
		<input type="text" readonly  name="JML_IMUN_DPT2L_WILAYAH_L" value="<?=$data->JML_IMUN_DPT2L_WILAYAH_L?>"  />
		<input type="text" readonly  name="JML_IMUN_DPT2L_WILAYAH_P" value="<?=$data->JML_IMUN_DPT2L_WILAYAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI DPT 3 LUAR WILAYAH/SWASTA</label>
		<input type="text" readonly  name="JML_IMUN_DPT3L_WILAYAH_L" value="<?=$data->JML_IMUN_DPT3L_WILAYAH_L?>"  />
		<input type="text" readonly  name="JML_IMUN_DPT3L_WILAYAH_P" value="<?=$data->JML_IMUN_DPT3L_WILAYAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI DPT HB 1 LUAR WILAYAH/SWASTA</label>
		<input type="text" readonly  name="JML_IMUN_DPT_HB1L_WILAYAH_L" value="<?=$data->JML_IMUN_DPT_HB1L_WILAYAH_L?>"  />
		<input type="text" readonly  name="JML_IMUN_DPT_HB1L_WILAYAH_P" value="<?=$data->JML_IMUN_DPT_HB1L_WILAYAH_P?>"  />
		</span>
	</fieldset><fieldset>
		<span>
		<label>JUMLAH IMUNISASI DPT HB 2 LUAR WILAYAH/SWASTA</label>
		<input type="text" readonly  name="JML_IMUN_DPT_HB2L_WILAYAH_L" value="<?=$data->JML_IMUN_DPT_HB2L_WILAYAH_L?>"  />
		<input type="text" readonly  name="JML_IMUN_DPT_HB2L_WILAYAH_P" value="<?=$data->JML_IMUN_DPT_HB2L_WILAYAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI DPT HB 3 LUAR WILAYAH/SWASTA</label>
		<input type="text" readonly  name="JML_IMUN_DPT_HB3L_WILAYAH_L" value="<?=$data->JML_IMUN_DPT_HB3L_WILAYAH_L?>"  />
		<input type="text" readonly  name="JML_IMUN_DPT_HB3L_WILAYAH_P" value="<?=$data->JML_IMUN_DPT_HB3L_WILAYAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI CAMPAK LUAR WILAYAH/SWASTA</label>
		<input type="text" readonly  name="JML_IMUN_CL_WILAYAH_L" value="<?=$data->JML_IMUN_CL_WILAYAH_L?>"  />
		<input type="text" readonly  name="JML_IMUN_CL_WILAYAH_P" value="<?=$data->JML_IMUN_CL_WILAYAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI POLIO 1 LUAR WILAYAH/SWASTA</label>
		<input type="text" readonly  name="JML_IMUN_P1L_WILAYAH_L" value="<?=$data->JML_IMUN_P1L_WILAYAH_L?>"  />
		<input type="text" readonly  name="JML_IMUN_P1L_WILAYAH_P" value="<?=$data->JML_IMUN_P1L_WILAYAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI POLIO 2 LUAR WILAYAH/SWASTA</label>
		<input type="text" readonly  name="JML_IMUN_P2L_WILAYAH_L" value="<?=$data->JML_IMUN_P2L_WILAYAH_L?>"  />
		<input type="text" readonly  name="JML_IMUN_P2L_WILAYAH_P" value="<?=$data->JML_IMUN_P2L_WILAYAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI POLIO 3 LUAR WILAYAH/SWASTA</label>
		<input type="text" readonly  name="JML_IMUN_P3L_WILAYAH_L" value="<?=$data->JML_IMUN_P3L_WILAYAH_L?>"  />
		<input type="text" readonly  name="JML_IMUN_P3L_WILAYAH_P" value="<?=$data->JML_IMUN_P3L_WILAYAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI POLIO 4 LUAR WILAYAH/SWASTA</label>
		<input type="text" readonly  name="JML_IMUN_P4L_WILAYAH_L" value="<?=$data->JML_IMUN_P4L_WILAYAH_L?>"  />
		<input type="text" readonly  name="JML_IMUN_P4L_WILAYAH_P" value="<?=$data->JML_IMUN_P4L_WILAYAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI HEPATITIS B UNIJECT < 7 HARI LUAR WILAYAH/SWASTA</label>
		<input type="text" readonly  name="JML_IMUN_HBU_M7L_WILAYAH_L" value="<?=$data->JML_IMUN_HBU_M7L_WILAYAH_L?>"  />
		<input type="text" readonly  name="JML_IMUN_HBU_M7L_WILAYAH_P" value="<?=$data->JML_IMUN_HBU_M7L_WILAYAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI HEPATITIS B UNIJECT > 7 HARI LUAR WILAYAH/SWASTA</label>
		<input type="text" readonly  name="JML_IMUN_HBU_P7L_WILAYAH_L" value="<?=$data->JML_IMUN_HBU_P7L_WILAYAH_L?>"  />
		<input type="text" readonly  name="JML_IMUN_HBU_P7L_WILAYAH_P" value="<?=$data->JML_IMUN_HBU_P7L_WILAYAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI HEPATITIS B UNIJECT 2 LUAR WILAYAH/SWASTA</label>
		<input type="text" readonly  name="JML_IMUN_HBU2L_WILAYAH_L" value="<?=$data->JML_IMUN_HBU2L_WILAYAH_L?>"  />
		<input type="text" readonly  name="JML_IMUN_HBU2L_WILAYAH_P" value="<?=$data->JML_IMUN_HBU2L_WILAYAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI HEPATITIS B UNIJECT 3 LUAR WILAYAH/SWASTA</label>
		<input type="text" readonly  name="JML_IMUN_HBU3L_WILAYAH_L" value="<?=$data->JML_IMUN_HBU3L_WILAYAH_L?>"  />
		<input type="text" readonly  name="JML_IMUN_HBU3L_WILAYAH_P" value="<?=$data->JML_IMUN_HBU3L_WILAYAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI HEPATITIS B VIAL 1 LUAR WILAYAH/SWASTA</label>
		<input type="text" readonly  name="JML_IMUN_HBV1L_WILAYAH_L" value="<?=$data->JML_IMUN_HBV1L_WILAYAH_L?>"  />
		<input type="text" readonly  name="JML_IMUN_HBV1L_WILAYAH_P" value="<?=$data->JML_IMUN_HBV1L_WILAYAH_P?>"  />
		</span>
	</fieldset><fieldset>
		<span>
		<label>JUMLAH IMUNISASI HEPATITIS B VIAL 2 LUAR WILAYAH/SWASTA</label>
		<input type="text" readonly  name="JML_IMUN_HBV2L_WILAYAH_L" value="<?=$data->JML_IMUN_HBV2L_WILAYAH_L?>"  />
		<input type="text" readonly  name="JML_IMUN_HBV2L_WILAYAH_P" value="<?=$data->JML_IMUN_HBV2L_WILAYAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI HEPATITIS B VIAL 3 LUAR WILAYAH/SWASTA</label>
		<input type="text" readonly  name="JML_IMUN_HBV3L_WILAYAH_L" value="<?=$data->JML_IMUN_HBV3L_WILAYAH_L?>"  />
		<input type="text" readonly  name="JML_IMUN_HBV3L_WILAYAH_P" value="<?=$data->JML_IMUN_HBV3L_WILAYAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI TT 1 IBU HAMIL LUAR WILAYAH/SWASTA</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_IMUN_TT1IHL_WILAYAH_P" value="<?=$data->JML_IMUN_TT1IHL_WILAYAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI TT 1 WUS LUAR WILAYAH/SWASTA</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_IMUN_TT1WL_WILAYAH_P" value="<?=$data->JML_IMUN_TT1WL_WILAYAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI TT 2 IBU HAMIL LUAR WILAYAH/SWASTA</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_IMUN_TT2IHL_WILAYAH_P" value="<?=$data->JML_IMUN_TT2IHL_WILAYAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI TT 2 WUS LUAR WILAYAH/SWASTA</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_IMUN_TT2WL_WILAYAH_P" value="<?=$data->JML_IMUN_TT2WL_WILAYAH_P?>"  />
		</span>
	</fieldset><fieldset>
		<span>
		<label>JUMLAH IMUNISASI TT 3 IBU HAMIL LUAR WILAYAH/SWASTA</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_IMUN_TT3IHL_WILAYAH_P" value="<?=$data->JML_IMUN_TT3IHL_WILAYAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI TT 3 WUS LUAR WILAYAH/SWASTA</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_IMUN_TT3WL_WILAYAH_P" value="<?=$data->JML_IMUN_TT3WL_WILAYAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI TT 4 IBU HAMIL LUAR WILAYAH/SWASTA</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_IMUN_TT4IHL_WILAYAH_P" value="<?=$data->JML_IMUN_TT4IHL_WILAYAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI TT 4 WUS LUAR WILAYAH/SWASTA</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_IMUN_TT4WL_WILAYAH_P" value="<?=$data->JML_IMUN_TT4WL_WILAYAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI TT 5 IBU HAMIL LUAR WILAYAH/SWASTA</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_IMUN_TT5IHL_WILAYAH_P" value="<?=$data->JML_IMUN_TT5IHL_WILAYAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH IMUNISASI TT 5 WUS LUAR WILAYAH/SWASTA</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_IMUN_TT5WL_WILAYAH_P" value="<?=$data->JML_IMUN_TT5WL_WILAYAH_P?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH VAKSIN BCG DITERIMA BULAN INI</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_VBCG_TERIMA" value="<?=$data->JML_VBCG_TERIMA?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH VAKSIN DPT DITERIMA BULAN INI</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_VDPT_TERIMA" value="<?=$data->JML_VDPT_TERIMA?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH VAKSIN DPT HB DITERIMA BULAN INI</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_VDPTHB_TERIMA" value="<?=$data->JML_VDPTHB_TERIMA?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH VAKSIN POLIO DITERIMA BULAN INI</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_VP_TERIMA" value="<?=$data->JML_VP_TERIMA?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH VAKSIN CAMPAK DITERIMA BULAN INI</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_VC_TERIMA" value="<?=$data->JML_VC_TERIMA?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH VAKSIN HB UNIJECT DITERIMA BULAN INI</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_VHBU_TERIMA" value="<?=$data->JML_VHBU_TERIMA?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH VAKSIN HB VIAL DITERIMA BULAN INI</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_VHBV_TERIMA" value="<?=$data->JML_VHBV_TERIMA?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH VAKSIN TT DITERIMA BULAN INI</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_VTT_TERIMA" value="<?=$data->JML_VTT_TERIMA?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH VAKSIN DT DITERIMA BULAN INI</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_VDT_TERIMA" value="<?=$data->JML_VDT_TERIMA?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH VAKSIN BCG YANG DIPAKAI BULAN INI</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_VBCG_DIPAKAI" value="<?=$data->JML_VBCG_DIPAKAI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH VAKSIN DPT YANG DIPAKAI BULAN INI</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_VDPT_DIPAKAI" value="<?=$data->JML_VDPT_DIPAKAI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH VAKSIN DPT HB YANG DIPAKAI BULAN INI</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_VDPTHB_DIPAKAI" value="<?=$data->JML_VDPTHB_DIPAKAI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH VAKSIN POLIO YANG DIPAKAI BULAN INI</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_VP_DIPAKAI" value="<?=$data->JML_VP_DIPAKAI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH VAKSIN CAMPAK YANG DIPAKAI BULAN INI</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_VC_DIPAKAI" value="<?=$data->JML_VC_DIPAKAI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH VAKSIN HB UNIJECT YANG DIPAKAI BULAN INI</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_VHBU_DIPAKAI" value="<?=$data->JML_VHBU_DIPAKAI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH VAKSIN HB VIAL YANG DIPAKAI BULAN INI</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_VHBV_DIPAKAI" value="<?=$data->JML_VHBV_DIPAKAI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH VAKSIN DPT HB YANG DIPAKAI BULAN INI</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_VDPTHB_DIPAKAI" value="<?=$data->JML_VDPTHB_DIPAKAI?>"  />
		</span>
	</fieldset>
	
	<fieldset>
		<span>
		<label>JUMLAH VAKSIN TT YANG DIPAKAI BULAN INI</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_VTT_DIPAKAI" value="<?=$data->JML_VTT_DIPAKAI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH VAKSIN DT YANG DIPAKAI BULAN INI</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_VDT_DIPAKAI" value="<?=$data->JML_VDT_DIPAKAI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH VAKSIN DT1 ANAK SEKOLAH</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_VDT1_ANAKSEKOLAH" value="<?=$data->JML_VDT1_ANAKSEKOLAH?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>JUMLAH VAKSIN DT2 ANAK SEKOLAH</label>
		<input type="text" style="width: 125px!important;" readonly  name="JML_VDT2_ANAKSEKOLAH" value="<?=$data->JML_VDT2_ANAKSEKOLAH?>"  />
		</span>
	</fieldset>
</form>
</div >