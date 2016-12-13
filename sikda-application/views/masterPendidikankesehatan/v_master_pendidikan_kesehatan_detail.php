<script>
	$('#backlistpenkes').click(function(){
		$("#t66","#tabs").empty();
		$("#t66","#tabs").load('c_master_pendidikan_kesehatan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Pendidikan Kesehatan</div>
<div class="backbutton"><span class="kembali" id="backlistpenkes">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>KODE PENDIDIKAN</label>
		<input type="text" readonly name="kd_penkes" id="text1" value="<?=$data->KD_PENDIDIKAN?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->KD_PENDIDIKAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NAMA PENDIDIKAN</label>
		<input type="text" readonly name="penkes" id="text2" value="<?=$data->PENDIDIKAN?>"  />
		</span>
	</fieldset>	
</form>
</div >