<script>
	$('#backlistmastervaksin').click(function(){
		$("#t10","#tabs").empty();
		$("#t10","#tabs").load('c_master_vaksin'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Master Vaksin</div>
<div class="backbutton"><span class="kembali" id="backlistmastervaksin">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode</label>
		<input type="text" readonly name="yangditemui" id="text1" value="<?=$data->nkode_vaksin?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->nid_vaksin?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama</label>
		<input type="text" readonly name="kolom_nama" id="text2" value="<?=$data->nnama_vaksin?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tgl Input</label>
		<input type="text" readonly name="tglmastervaksin" id="tglmastervaksin" value="<?=$data->ntgl_master_vaksin?>" style="width:89px" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Golongan</label>
		<input type="text" readonly name="kolom_golongan" id="text3" value="<?=$data->ngolongan?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Sumber</label>
		<input type="text" readonly name="kolom_sumber" id="text4" value="<?=$data->nsumber?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Satuan</label>
		<input type="text" readonly name="kolom_satuan" id="text5" value="<?=$data->nsatuan?>"  />
		</span>
	</fieldset>
</form>
</div >