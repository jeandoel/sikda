<script>
	$('#backlistmasterposisi').click(function(){
		$("#t11","#tabs").empty();
		$("#t11","#tabs").load('c_master_posisi'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Master posisi</div>
<div class="backbutton"><span class="kembali" id="backlistmasterposisi">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Posisi</label>
		<input type="text" readonly name="kode_posisi" id="kode_posisi" value="<?=$data->KD_POSISI?>" />
		<input type="hidden" name="kd" id="kode_posisi" value="<?=$data->KD_POSISI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Posisi</label>
		<input type="text" readonly name="nama_posisi" id="nama_posisi" value="<?=$data->POSISI?>"  />
		</span>
	</fieldset>
</form>
</div >