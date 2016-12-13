<script>
	$('#backlistmasterjenisobat').click(function(){
		$("#t73","#tabs").empty();
		$("#t73","#tabs").load('c_master_jenis_obat'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Jenis Obat</div>
<div class="backbutton"><span class="kembali" id="backlistmasterjenisobat">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Jenis Obat</label>
		<input type="text" readonly name="yangditemui" id="text1" value="<?=$data->KD_JNS_OBT?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->KD_JNS_OBT?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Obat</label>
		<input type="text" readonly name="jenisobat" id="text2" value="<?=$data->JENIS_OBAT?>"  />
		</span>
	</fieldset>
</form>
</div >