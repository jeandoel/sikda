<script>
	$('#backlistmastertempat').click(function(){
		$("#t18","#tabs").empty();
		$("#t18","#tabs").load('c_master_tempat'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Master Registrasi Tempat</div>
<div class="backbutton"><span class="kembali" id="backlistmastertempat">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode</label>
		<input type="text" readonly name="yangditemui" id="text1" value="<?=$data->nkode_tempat?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->nid_reg_tempat?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama</label>
		<input type="text" readonly name="kolom_nama_tempat" id="text2" value="<?=$data->nnama_tempat?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Master Registrasi</label>
		<input type="text" readonly name="tglmastertempat" id="tglmastertempat" value="<?=$data->ntgl_master_tempat?>" style="width:89px" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis</label>
		<input type="text" readonly name="kolom_jenis_tempat" id="text3" value="<?=$data->njenis_tempat?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>No. Telp</label>
		<input type="text" readonly name="kolom_no_telp" id="text4" value="<?=$data->nno_telp_tempat?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Pengelola</label>
		<input type="text" readonly name="kolom_pengelola_tempat" id="text5" value="<?=$data->npengelola_tempat?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ID Wilayah</label>
		<input type="text" readonly name="kolom_id_wilayah" id="text6" value="<?=$data->nid_wilayah?>"  />
		</span>
	</fieldset>
</form>
</div >