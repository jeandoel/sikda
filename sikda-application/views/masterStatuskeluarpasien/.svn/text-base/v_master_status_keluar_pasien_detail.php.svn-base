<script>
	$('#backlistmasterstatuskeluarpasien').click(function(){
		$("#t34","#tabs").empty();
		$("#t34","#tabs").load('c_master_status_keluar_pasien'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Master Status Keluar Pasien</div>
<div class="backbutton"><span class="kembali" id="backlistmasterstatuskeluarpasien">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Status</label>
		<input type="text" readonly name="kode_status" id="text1" value="<?=$data->KD_STATUS?>" />
		<input type="hidden" name="kd" id="textid" value="<?=$data->KD_STATUS?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Keterangan</label>
		<input type="text" readonly name="keterangan" id="text1" value="<?=$data->KETERANGAN?>" />
		</span>
	</fieldset>	
</form>
</div >