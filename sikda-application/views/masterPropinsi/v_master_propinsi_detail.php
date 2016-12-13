<script>
	$('#backlistmasterProp').click(function(){
		$("#t25","#tabs").empty();
		$("#t25","#tabs").load('c_master_propinsi'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Provinsi</div>
<div class="backbutton"><span class="kembali" id="backlistmasterProp">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Provinsi</label>
		<input type="text" readonly name="id" id="textid" value="<?=$data->KD_PROVINSI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Provinsi</label>
		<input type="text" readonly name="yangditemui" id="text1" value="<?=$data->PROVINSI?>" />
		</span>
	</fieldset>
</form>
</div >