<script>
	$('#backlistmasterkamar').click(function(){
		$("#t36","#tabs").empty();
		$("#t36","#tabs").load('c_master_kamar'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Master Kamar</div>
<div class="backbutton"><span class="kembali" id="backlistmasterkamar">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Unit</label>
		<input type="text" name="kode_unit" id="text1" readonly value="<?=$data->KD_UNIT?>" />
		<input type="hidden" readonly name="id_kode_unit_hidden" id="text1" value="<?=$data->KD_UNIT?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>No Kamar</label>
		<input type="text" name="no_kamar" id="text1"readonly value="<?=$data->NO_KAMAR?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Kamar</label>
		<input type="text" name="nama_kamar" id="text1" readonly value="<?=$data->NAMA_KAMAR?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Bed</label>
		<input type="text" name="jumlah_bed" id="text1"readonly value="<?=$data->JUMLAH_BED?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Digunakan</label>
		<input type="text" name="digunakan" id="text1"readonly value="<?=$data->DIGUNAKAN?>" />
		</span>
	</fieldset>
</form>
</div >