<script>
	$('#backlistmasterKota').click(function(){
		$("#t27","#tabs").empty();
		$("#t27","#tabs").load('c_master_kota'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Kota</div>
<div class="backbutton"><span class="kembali" id="backlistmasterKota">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Nama Kota</label>
		<input type="text" readonly name="yangditemui" id="text1" value="<?=$data->nnama_kota?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->nid_kota?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Master</label>
		<input type="text" readonly name="tglmasterKota" id="tglmasterKota1" value="<?=$data->ntgl_master_kota?>" style="width:89px" />
		</span>
	</fieldset>
</form>
</div >