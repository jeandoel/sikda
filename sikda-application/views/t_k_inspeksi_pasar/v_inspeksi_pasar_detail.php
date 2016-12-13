<script>
	$('#backlistrmhsehat').click(function(){
		$("#t463","#tabs").empty();
		$("#t463","#tabs").load('t_k_inspeksi_pasar'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Data Inspeksi Pasar</div>
<div class="backbutton"><span class="kembali" id="backlistrmhsehat">kembali ke list</span></div>
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
		<label>Nama Pasar</label>
		<input type="text" name="nama_pasar" value="<?=$data->NAMA_PASAR?>"  required />
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
		<label>Penanggung Jawab</label>
		<input type="text" name="pic" value="<?=$data->PIC?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Kios</label>
		<input type="text" name="jumlah_kios" value="<?=$data->JUMLAH_KIOS?>" required />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Jumlah Pedagang</label>
		<input type="text" name="jumlah_pedagang" value="<?=$data->JUMLAH_PEDAGANG?>" required />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Jumlah Asosiasi</label>
		<input type="text" name="jumlah_asosiasi" value="<?=$data->JUMLAH_ASOSIASI?>" required />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Team Pemeriksa</label>
		<input type="text" name="pemeriksa" value="<?=$data->PEMERIKSA?>" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Total Nilai Pemeriksaan</label>
		<input type="text" name="total_nilai" value="<?=$data->TOTAL_NILAI?>" readonly />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Tanggal Inspeksi (dd/mm/yyyy)</label>
		<input type="text" name="tanggal_inspeksi"  value="<?=$data->TANGGAL?>" class="mydate" readonly  />		
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Dokumen Pemeriksaan</label>
		<a href="<?=base_url()?>tmp/inspeksipasar/<?=$data->DOKUMEN_PEMERIKSAAN?>" style="color:blue"><?=$data->DOKUMEN_PEMERIKSAAN?></a>
		</span>
	</fieldset>
</form>
</div >