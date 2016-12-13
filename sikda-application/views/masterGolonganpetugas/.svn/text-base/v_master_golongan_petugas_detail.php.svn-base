<script>
	$('#backlistgolongan').click(function(){
		$("#t65","#tabs").empty();
		$("#t65","#tabs").load('c_master_golongan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Golongan</div>
<div class="backbutton"><span class="kembali" id="backlistgolongan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>KODE GOLONGAN</label>
		<input type="text" readonly name="kd_golongan" id="text1" value="<?=$data->KD_GOLONGAN?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->KD_GOLONGAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NAMA GOLONGAN</label>
		<input type="text" readonly name="nama_golongan" id="text2" value="<?=$data->NM_GOLONGAN?>"  />
		</span>
	</fieldset>
		
</form>
</div >