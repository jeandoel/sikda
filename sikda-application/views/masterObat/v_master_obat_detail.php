<script>
	$('#backlistobat').click(function(){
		$("#t61","#tabs").empty();
		$("#t61","#tabs").load('c_master_obat'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Obat</div>
<div class="backbutton"><span class="kembali" id="backlistobat">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>KODE OBAT</label>
		<input type="text" disabled name="kode_obat" id="text1" value="<?=$data->KD_OBAT_VAL?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->KD_OBAT?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NAMA OBAT</label>
		<input type="text" disabled name="nama_obat" id="text2" value="<?=$data->NAMA_OBAT?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KD GOL OBAT</label>
		<input type="text" name="kd_gol_obat" id="kd_gol_obat" value="<?=$data->KD_GOL_OBAT?>" disabled />
		<input type="text" name="master_gol_obat_id" id="master_gol_obat_id" value="<?=$data->namagolongan?>" disabled />
		</span>
	</fieldset>
	<div id="imunisasiplaceholder" style="<?=$data->KD_GOL_OBAT=='VAKSIN'?'':'display:none'?>" >
	<?=getComboJenisimunisasi($data->KD_JENIS_IMUNISASI,'jenis_imunisasi','imunisasi_add','disabled')?>
	</div>
	<fieldset>
		<span>
		<label>KD SAT KECIL</label>
		<input type="text" name="kd_sat_kecil" id="master_satuan_kecil_hidden" value="<?=$data->KD_SAT_KECIL?>" disabled />
		<input type="text" name="master_satuan_kecil" id="master_satuan_kecil" value="<?=$data->namasatkcl?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KD SAT BESAR</label>
		<input type="text" name="kd_sat_besar" id="master_satuan_besar_id_hidden" value="<?=$data->KD_SAT_BESAR?>" disabled />
		<input type="text" name="master_satuan_kecil" id="master_satuan_kecil" value="<?=$data->namasatbesar?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>KD TERAPI OBAT</label>
		<input type="text" name="kd_ter_obat" id="nama_terapi_hidden" value="<?=$data->KD_TERAPI_OBAT?>" disabled />
		<input type="text" name="nama_terapi" id="nama_terapi" value="<?=$data->namaterapi?>" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>GENERIK</label>
		<input type="text" disabled name="generik" id="text2" value="<?=$data->GENERIK?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>FRACTION</label>
		<input type="text" disabled name="fraction" id="text2" value="<?=$data->FRACTION?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>SINGKATAN</label>
		<input type="text" disabled name="singkatan" id="" value="<?=$data->SINGKATAN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>IS DEFAULT</label>
		<input type="text" disabled name="default" id="text2" value="<?=$data->IS_DEFAULT?>"  />
		</span>
	</fieldset>
	
	
</form>
</div >