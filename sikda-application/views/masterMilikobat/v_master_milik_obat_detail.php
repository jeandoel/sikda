<script>
	$('#backlistmastermilikobat').click(function(){
		$("#t74","#tabs").empty();
		$("#t74","#tabs").load('c_master_milik_obat'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Milik Obat</div>
<div class="backbutton"><span class="kembali" id="backlistmastermilikobat">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Milik Obat</label>
		<input type="text" readonly name="yangditemui" id="text1" value="<?=$data->KD_MILIK_OBAT?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->KD_MILIK_OBAT?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kepemilikan</label>
		<input type="text" readonly name="kepemilikan" id="text2" value="<?=$data->KEPEMILIKAN?>"  />
		</span>
	</fieldset>
</form>
</div >