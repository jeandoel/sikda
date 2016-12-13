<script>
	$('#backlistmastersatuankecil').click(function(){
		$("#t72","#tabs").empty();
		$("#t72","#tabs").load('c_master_satuan_kecil'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Satuan Kecil</div>
<div class="backbutton"><span class="kembali" id="backlistmastersatuankecil">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Satuan Kecil Obat</label>
		<input type="text" readonly name="yangditemui" id="text1" value="<?=$data->KD_SAT_KCL_OBAT?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->KD_SAT_KCL_OBAT?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Satuan Kecil Obat</label>
		<input type="text" readonly name="satkclobat" id="text2" value="<?=$data->SAT_KCL_OBAT?>"  />
		</span>
	</fieldset>
</form>
</div >