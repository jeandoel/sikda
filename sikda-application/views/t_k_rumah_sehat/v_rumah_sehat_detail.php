<script>
	$('#backlistrmhsehat').click(function(){
		$("#t461","#tabs").empty();
		$("#t461","#tabs").load('t_k_rumah_sehat'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Data Inspeksi Rumah Sehat</div>
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
		<label>Nama KK</label>
		<input type="text" name="nama_kk" value="<?=$data->NAMA_KK?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Jiwa</label>
		<input type="text" name="jumlah_jiwa" value="<?=$data->JUMLAH_JIWA?>" readonly />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Pemeriksa</label>
		<input type="text" name="pemeriksa" value="<?=$data->PEMERIKSA?>" readonly />
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
		<a href="<?=base_url()?>tmp/rumahsehat/<?=$data->DOKUMEN_PEMERIKSAAN?>" style="color:blue"><?=$data->DOKUMEN_PEMERIKSAAN?></a>
		</span>
	</fieldset>
</form>
</div >