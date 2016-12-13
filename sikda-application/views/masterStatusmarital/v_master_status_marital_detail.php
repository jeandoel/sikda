<script>
	$('#backliststatusmarital').click(function(){
		$("#t64","#tabs").empty();
		$("#t64","#tabs").load('c_master_status_marital'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Status Marital</div>
<div class="backbutton"><span class="kembali" id="backliststatusmarital">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>KODE STATUS MARITAL</label>
		<input type="text" readonly name="kd_status_marital" id="text1" value="<?=$data->KD_STATUS?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->KD_STATUS?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NAMA STATUS</label>
		<input type="text" readonly name="status_marital" id="text2" value="<?=$data->STATUS?>"  />
		</span>
	</fieldset>
		
</form>
</div >