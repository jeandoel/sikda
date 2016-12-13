<script>
	$('#backlistmastergigimasalah').click(function(){
		$("#t1002","#tabs").empty();
		$("#t1002","#tabs").load('c_master_gigi_masalah'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Masalah Gigi</div>
<div class="backbutton"><span class="kembali" id="backlistmastergigimasalah">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Masalah</label>
		<input type="text" readonly name="masalah" id="masalah" value="<?=$data->MASALAH?>" />
		<input type="hidden" name="id" id="id" value="<?=$data->KD_MASALAH_GIGI?>" />
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