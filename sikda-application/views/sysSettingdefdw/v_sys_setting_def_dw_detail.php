<script>
	$('#backlist_sys_setting_def_dw').click(function(){
		$("#t56","#tabs").empty();
		$("#t56","#tabs").load('c_sys_setting_def_dw'+'?_=' + (new Date()).getTime());
	})
</script>

<div class="mycontent">
<div class="formtitle">Detail Wilayah Kerja</div>
<div class="backbutton"><span class="kembali" id="backlist_sys_setting_def_dw">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data" id="form1_sys_setting_def_dw_detail">
	<fieldset>
		<span>
		<label>Provinsi</label>
		<input type="text" name="kodeprovinsi" id="id_master_propinsi_hidden" readonly value="<?=$data->KD_PROVINSI?>"  />
		<input type="text" placeholder="Provinsi" name="master_propinsi_id" id="master_propinsi_id" readonly value="<?=$data->namaprovinsi?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kabupaten/Kota</label>
		<input type="text" name="kodekabupaten" id="id_master_kabupaten_hidden" readonly value="<?=$data->KD_KABUPATEN?>"  />
		<input type="text" placeholder="Kabupaten" name="master_kabupaten_id" id="master_kabupaten_id" readonly value="<?=$data->namakabupaten?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kecamatan</label>
		<input type="text" name="kodekecamatan" id="id_master_kecamatan_hidden" readonly value="<?=$data->KD_KECAMATAN?>"  />
		<input type="text" placeholder="Kecamatan" name="master_kecamatan_id" id="master_kecamatan_id" readonly value="<?=$data->namakecamatan?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Puskesmas</label>
		<input type="text" name="kodepuskesmas" id="nama_puskesmas_hidden" readonly value="<?=$data->KD_PUSKESMAS?>"  />
		<input type="text" placeholder="Puskesmas" name="nama_puskesmas" id="nama_puskesmas" readonly value="<?=$data->namapuskesmas?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kelurahan/Desa</label>
		<input type="text" name="kodekelurahan" id="id_master_kelurahan_hidden" readonly value="<?=$data->KD_KELURAHAN?>"  />
		<input type="text" placeholder="Kelurahan/Desa" name="master_kelurahan_id" id="master_kelurahan_id" readonly value="<?=$data->namakelurahan?>" />
		</span>
	</fieldset>
</form>
</div >