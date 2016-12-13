<script>
	$('#backlistinspekhotel').click(function(){
		$("#t472","#tabs").empty();
		$("#t472","#tabs").load('t_posyandu'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Data Posyandu</div>
<div class="backbutton"><span class="kembali" id="backlistinspekhotel">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Propinsi</label>
		<input type="text" readonly name="" value="<?=$data->PROVINSI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kabupaten</label>
		<input type="text" readonly name="" value="<?=$data->KABUPATEN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kecamatan</label>
		<input type="text" readonly name="" value="<?=$data->KECAMATAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kelurahan/Desa</label>
		<input type="text" readonly name="" value="<?=$data->KELURAHAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Posyandu</label>
		<input type="text" name="nama_posyandu" value="<?=$data->NAMA_POSYANDU?>" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>RW</label>
		<input type="text" name="rw" value="<?=$data->RW?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>RT</label>
		<input type="text" name="rt" value="<?=$data->RT?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Alamat</label>
		<input type="text" name="alamat" value="<?=$data->ALAMAT?>" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Kader</label>
		<input type="text" name="jumlah_kader" value="<?=$data->JUMLAH_KADER?>" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Posyandu</label>
		<input type="text" name="jumlah_kader" value="<?=$data->JENIS_POSYANDU?>" required />
		</span>
	</fieldset>
</form>
</div >