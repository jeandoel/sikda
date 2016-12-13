<script>
	$('#backlistinspekhotel').click(function(){
		$("#t464","#tabs").empty();
		$("#t464","#tabs").load('t_k_inspeksi_hotel'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Data Inspeksi Inspeksi Hotel</div>
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
		<label>Nama Hotel</label>
		<input type="text" name="nama_hotel" value="<?=$data->NAMA_HOTEL?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Alamat</label>
		<input type="text" name="alamat" value="<?=$data->ALAMAT?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>No. Telepon</label>
		<input type="text" name="telp" value="<?=$data->TELP?>" required />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Karyawan</label>
		<input type="text" name="jumlah_karyawan" value="<?=$data->JUMLAH_KARYAWAN?>" required />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>No. Izin Usaha</label>
		<input type="text" name="ijin_usaha" value="<?=$data->NO_IZIN_USAHA?>" />
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
		<a href="<?=base_url()?>tmp/inspeksihotel/<?=$data->DOKUMEN_PEMERIKSAAN?>" style="color:blue"><?=$data->DOKUMEN_PEMERIKSAAN?></a>
		</span>
	</fieldset>
</form>
</div >