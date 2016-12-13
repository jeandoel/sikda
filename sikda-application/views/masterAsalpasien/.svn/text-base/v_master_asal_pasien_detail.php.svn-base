<script>
	$('#backlistmasterasalpasien').click(function(){
		$("#t14","#tabs").empty();
		$("#t14","#tabs").load('c_master_asal_pasien'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Master Asal Pasien</div>
<div class="backbutton"><span class="kembali" id="backlistmasterasalpasien">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Asal</label>
		<input type="text" readonly name="kode_asal" id="kode_asal" value="<?=$data->KD_ASAL?>" />
		<input type="hidden" name="id" id="kode_asal" value="<?=$data->KD_ASAL?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Asal Pasien</label>
		<input type="text" readonly name="asal_pasien" id="asal_pasien" value="<?=$data->ASAL_PASIEN?>"  />
		</span>
	</fieldset>
</form>
</div >