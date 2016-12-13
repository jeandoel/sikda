<script>
	$('#backlistmasterKeadaankesehatan').click(function(){
		$("#t24","#tabs").empty();
		$("#t24","#tabs").load('c_master_keadaan_kesehatan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Keadaan Kesehatan</div>
<div class="backbutton"><span class="kembali" id="backlistmasterKeadaankesehatan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Keadaan Kesehatan</label>
		<input type="text" readonly name="id" id="textid" value="<?=$data->KD_KEADAAN_KESEHATAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Keadaan Kesehatan</label>
		<input type="text" readonly name="yangditemui" id="text1" value="<?=$data->KEADAAN_KESEHATAN?>" />
		</span>
	</fieldset>
</form>
</div >