<script>
	$('#backlistmaster_agama').click(function(){
		$("#t41","#tabs").empty();
		$("#t41","#tabs").load('c_master_agama'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Data Agama</div>
<div class="backbutton"><span class="kembali" id="backlistmaster_agama">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Agama</label>
		<input type="text" readonly name="kodeagama" id="kodeagama" value="<?=$data->KD_AGAMA?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Agama</label>
		<input type="text" readonly name="agama" id="agama" value="<?=$data->AGAMA?>" />
		</span>
	</fieldset>
</form>
</div >


