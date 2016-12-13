<script>
	$('#backlistras').click(function(){
		$("#t63","#tabs").empty();
		$("#t63","#tabs").load('c_master_ras'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Ras</div>
<div class="backbutton"><span class="kembali" id="backlistras">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>KODE RAS</label>
		<input type="text" readonly name="kd_ras" id="text1" value="<?=$data->KD_RAS?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->KD_RAS?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NAMA RAS</label>
		<input type="text" readonly name="ras" id="text2" value="<?=$data->RAS?>"  />
		</span>
	</fieldset>
		
</form>
</div >