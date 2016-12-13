	<script>
	$('#backlistmaster_ruangan').click(function(){
		$("#t45","#tabs").empty();
		$("#t45","#tabs").load('c_master_ruangan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Data Ruangan</div>
<div class="backbutton"><span class="kembali" id="backlistmaster_ruangan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Ruangan</label>
		<input type="text" readonly name="koderuangan" id="koderuangan" value="<?=$data->KD_RUANGAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Puskesmas</label>
		<input type="text" readonly name="kodepuskesmas" id="nama_puskesmas_hidden" value="<?=$data->KD_PUSKESMAS?>" />
		<input type="text" placeholder="Puskesmas" name="nama_puskesmas" id="nama_puskesmas" readonly value="<?=$data->PUSKESMAS?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Ruangan</label>
		<input type="text" readonly name="ruangan" id="ruangan" value="<?=$data->NAMA_RUANGAN?>" />
		</span>
	</fieldset>
</form>
</div >


