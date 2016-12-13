<script>
	$('#backlistmasterKab').click(function(){
		$("#t26","#tabs").empty();
		$("#t26","#tabs").load('c_master_kabupaten'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Kabupaten</div>
<div class="backbutton"><span class="kembali" id="backlistmasterKab">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Kabupaten</label>
		<input type="text" readonly name="id" id="textid" value="<?=$data->KD_KABUPATEN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Provinsi</label>
		<input type="text" name="master_propinsi_id_column" id="master_propinsi_id_hidden" readonly value="<?=$data->KD_PROVINSI?>"  />
		<input type="text" name="master_propinsi_id" id="master_propinsi_id" readonly value="<?=$data->PROVINSI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kabupaten</label>
		<input type="text" readonly name="nama_kabupaten" id="text2" value="<?=$data->KABUPATEN?>" />
		</span>
	</fieldset>
</form>
</div >