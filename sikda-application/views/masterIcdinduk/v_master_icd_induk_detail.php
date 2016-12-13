<script>
	$('#backlistmaster_icd_induk').click(function(){
		$("#t57","#tabs").empty();
		$("#t57","#tabs").load('c_master_icd_induk'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail ICD Induk</div>
<div class="backbutton"><span class="kembali" id="backlistmaster_icd_induk">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode ICD Induk</label>
		<input type="text" readonly name="kodeicdinduk" id="kodeicdinduk" value="<?=$data->KD_ICD_INDUK?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ICD Induk</label>
		<textarea name="icdinduk" rows="2" cols="24" readonly><?=$data->ICD_INDUK?></textarea>
		</span>
	</fieldset>
</form>
</div >


