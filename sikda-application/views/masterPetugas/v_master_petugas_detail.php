<script>
	$('#backlistpetugas').click(function(){
		$("#t62","#tabs").empty();
		$("#t62","#tabs").load('c_master_petugas'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Petugas</div>
<div class="backbutton"><span class="kembali" id="backlistpetugas">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>KODE PETUGAS</label>
		<input type="text" readonly name="kdpetugas" id="text1" value="<?=$data->Kd_Petugas?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->Kd_Petugas?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NAMA PETUGAS</label>
		<input type="text" readonly name="nmpetugas" id="text2" value="<?=$data->Nm_Petugas?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>UNIT</label>
		<input type="text" readonly name="Unt" id="text2" value="<?=$data->Unit?>"  />
		</span>
	</fieldset>
	</form>
</div >