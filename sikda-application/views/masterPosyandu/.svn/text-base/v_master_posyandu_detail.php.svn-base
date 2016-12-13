<script>
	$('#backlistposyandu').click(function(){
		$("#t8","#tabs").empty();
		$("#t8","#tabs").load('c_master_posyandu'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Posyandu</div>
<div class="backbutton"><span class="kembali" id="backlistposyandu">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Posyandu</label>
		<input type="text" readonly name="yangditemui" id="text1" value="<?=$data->nkode_posyandu?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->nid_posyandu?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Posyandu</label>
		<input type="text" readonly name="namaposyandu" id="text2" value="<?=$data->nnama_posyandu?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Alamat Posyandu</label>
		<textarea name="alamatposyandu" rows="3" cols="45"><?=$data->nalamat_posyandu?></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Kader</label>
		<input type="text" readonly name="jumlahkader" id="text4" value="<?=$data->njumlah_kader?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Posyandu</label>
		<input type="text" readonly name="tglposyandu" id="tglposyandu" value="<?=$data->ntgl_posyandu?>" style="width:89px" />
		</span>
	</fieldset>
</form>
</div >