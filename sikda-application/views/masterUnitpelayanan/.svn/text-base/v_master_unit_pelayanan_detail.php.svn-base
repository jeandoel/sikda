<script>
	$('#backlistmasterunitpelayanan').click(function(){
		$("#t35","#tabs").empty();
		$("#t35","#tabs").load('c_master_unit_pelayanan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Master Unit Pelayanan</div>
<div class="backbutton"><span class="kembali" id="backlistmasterunitpelayanan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Unit Pelayanan</label>
		<input type="text" readonly name="kode_unit_pelayanan" id="text1" value="<?=$data->KD_UNIT_LAYANAN?>" />
		<input type="hidden" name="kd" id="textid" value="<?=$data->KD_UNIT_LAYANAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Unit</label>
		<input type="text" readonly name="nama_unit" id="text1" value="<?=$data->NAMA_UNIT?>" />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Aktif</label>
		<input type="text" readonly name="aktif" id="text1" value="<?=$data->AKTIF?>" />
		</span>
	</fieldset>	
</form>
</div >