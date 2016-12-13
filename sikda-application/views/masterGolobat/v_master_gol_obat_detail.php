<script>
	$('#backlistmastergolobat').click(function(){
		$("#t22","#tabs").empty();
		$("#t22","#tabs").load('c_master_gol_obat'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Golongan Obat</div>
<div class="backbutton"><span class="kembali" id="backlistmastergolobat">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Golongan Obat</label>
		<input type="text" readonly name="yangditemui" id="text1" value="<?=$data->KD_GOL_OBAT?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->KD_GOL_OBAT?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Golongan Obat</label>
		<input type="text" readonly name="OBAT" id="text2" value="<?=$data->GOL_OBAT?>" />
		</span>
	</fieldset>
</form>
</div >