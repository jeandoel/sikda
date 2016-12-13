<script>
	$('#backlistmaster_kecamatan').click(function(){
		$("#t40","#tabs").empty();
		$("#t40","#tabs").load('c_master_kecamatan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Data Kecamatan</div>
<div class="backbutton"><span class="kembali" id="backlistmaster_kecamatan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Kecamatan</label>
		<input type="text" readonly name="kodekecamatan" id="kodekecamatan" value="<?=$data->KD_KECAMATAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Kabupaten</label>
		<input type="text" readonly name="master_kabupaten_id_column" id="master_kabupaten_id_column" value="<?=$data->KD_KABUPATEN?>" />
		<input type="text" placeholder="Nama Kabupaten" name="master_kabupaten_id" id="master_kabupaten_id" readonly value="<?=$data->KABUPATEN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kecamatan</label>
		<input type="text" readonly name="kecamatan" id="kecamatan" value="<?=$data->KECAMATAN?>" />
		</span>
	</fieldset>
</form>
</div >


