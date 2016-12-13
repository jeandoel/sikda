<script>
	$('#backlistmaster1').click(function(){
		$("#t6","#tabs").empty();
		$("#t6","#tabs").load('master1'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Master Satu</div>
<div class="backbutton"><span class="kembali" id="backlistmaster1">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Column Satu</label>
		<input type="text" readonly name="yangditemui" id="text1" value="<?=$data->ncolumn1?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->nid_master1?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Column Dua</label>
		<input type="text" readonly name="column2" id="text2" value="<?=$data->ncolumn2?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Master Satu</label>
		<input type="text" readonly name="tglmaster1" id="tglmaster1" value="<?=$data->ntgl_master1?>" style="width:89px" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Column Tiga</label>
		<textarea name="column3" rows="3" cols="45" readonly><?=$data->ncolumn3?></textarea>
		</span>
	</fieldset>
</form>
</div >