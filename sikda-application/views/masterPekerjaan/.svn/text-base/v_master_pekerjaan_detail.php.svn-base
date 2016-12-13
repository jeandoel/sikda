<script>
	$('#backlistmasterpekerjaan').click(function(){
		$("#t54","#tabs").empty();
		$("#t54","#tabs").load('c_master_pekerjaan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Master Pekerjaan</div>
<div class="backbutton"><span class="kembali" id="backlistmasterpekerjaan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Pekerjaan</label>
		<input type="text" readonly name="kodepekerjaan" id="kodepekerjaan" value="<?=$data->KD_PEKERJAAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Pekerjaan</label>
		<input type="text" readonly name="pekerjaan" id="pekerjaan" value="<?=$data->PEKERJAAN?>" />
		</span>
	</fieldset>
</form>
</div >


