<script>
	$('#backlistmasterdesa').click(function(){
		$("#t19","#tabs").empty();
		$("#t19","#tabs").load('masterdesa'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Master Desa</div>
<div class="backbutton"><span class="kembali" id="backlistmasterdesa">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Nama Desa</label>
		<input type="text" readonly name="kolom_desa" id="text1" value="<?=$data->nnama_desa?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Master Desa</label>
		<input type="text" readonly name="tglmasterdesa" id="tglmasterdesa" value="<?=$data->ntgl_master_desa?>" style="width:89px" />
		</span>
	</fieldset>
</form>
</div >