<script>
	$('#backlistpuskesmas').click(function(){
		$("#t51","#tabs").empty();
		$("#t51","#tabs").load('c_master_puskesmas'+'?_=' + (new Date()).getTime());
	})
</script>

<div class="mycontent">
<div class="formtitle">Detail Puskesmas</div>
<div class="backbutton"><span class="kembali" id="backlistpuskesmas">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data" id="form1puskesmasdetail">
	<fieldset>
		<span>
		<label>Kode Kecamatan</label>
		<input type="text" name="master_kecamatan_id_hidden" id="master_kecamatan_id_hidden" value="<?=$data->KD_KECAMATAN?>" readonly />
		<input type="text" name="master_kecamatan_id" id="master_kecamatan_id" value="<?=$data->nama_kecamatan?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Puskesmas</label>
		<input type="text" readonly name="kodepuskesmas" id="kodepuskesmas" value="<?=$data->KD_PUSKESMAS?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Puskesmas</label>
		<input type="text" readonly name="namapuskesmas" id="namapuskesmas" value="<?=$data->PUSKESMAS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Alamat</label>
		<textarea name="alamat" rows="3" cols="45" readonly><?=$data->ALAMAT?></textarea>
		</span>
	</fieldset>
</form>
</div >