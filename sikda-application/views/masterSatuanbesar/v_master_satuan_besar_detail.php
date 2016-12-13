<script>
	$('#backlistmastersatuanbesar').click(function(){
		$("#t71","#tabs").empty();
		$("#t71","#tabs").load('c_master_satuan_besar'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Satuan Besar</div>
<div class="backbutton"><span class="kembali" id="backlistmastersatuanbesar">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Satuan Besar</label>
		<input type="text" readonly name="yangditemui" id="text1" value="<?=$data->KD_SAT_BESAR?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->KD_SAT_BESAR?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Satuan Besar Obat</label>
		<input type="text" readonly name="satbesarobat" id="text2" value="<?=$data->SAT_BESAR_OBAT?>"  />
		</span>
	</fieldset>
</form>
</div >