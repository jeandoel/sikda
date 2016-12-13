<script>
	$('#backlisttransaksi1').click(function(){
		$("#t2","#tabs").empty();
		$("#t2","#tabs").load('transaksi1'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Transaksi 1</div>
<div class="backbutton"><span class="kembali" id="backlisttransaksi1">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1transaksi1detail" >
	<fieldset>
		<span>
		<label>Column Satu</label>
		<input type="text" name="column1" id="text1" value="<?=$data->ncolumn1?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Column Dua</label>
		<input type="text" name="column2" id="text2" value="<?=$data->ncolumn2?>" readonly  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Column Tiga</label>
		<textarea name="column3" rows="3" cols="45" readonly><?=$data->ncolumn3?></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Column Master 1</label>
		<input type="text" name="column_master_1" id="column_master_1" value="<?=$data->nmastercolumn1?>" readonly  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Tanggal Transaksi Satu</label>
		<input type="text" name="tgltransaksi1" id="tgltransaksi1" value="<?=$data->ntgl_transaksi1?>" style="width:89px" readonly />
		</span>
	</fieldset>
</form>
</div >