<script>
	$('#backlistmastergigiprosedur').click(function(){
		$("#t1005","#tabs").empty();
		$("#t1005","#tabs").load('c_master_gigi_prosedur'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Prosedur Gigi</div>
<div class="backbutton"><span class="kembali" id="backlistmastergigiprosedur">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode</label>
		<input type="text" readonly name="kd_prosedur_gigi" id="kd_prosedur_gigi" value="<?=$data->KD_PROSEDUR_GIGI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Prosedur</label>
		<input type="text" readonly name="prosedur" id="prosedur" value="<?=$data->PROSEDUR?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Deskripsi</label>
		<input type="text" readonly name="deskripsi" id="deskripsi" value="<?=$data->DESKRIPSI?>"  />
		</span>
	</fieldset>
</form>
</div >