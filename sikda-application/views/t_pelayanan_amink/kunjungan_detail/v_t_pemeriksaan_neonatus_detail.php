<script>
	$('#backlisttransaksi_pemeriksaanneonatus').click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Pemeriksaan Neonatus</div>
<div class="backbutton"><span class="kembali" id="backlisttransaksi_pemeriksaanneonatus">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Pemeriksaan Neonatus</label>
		<input type="text" placeholder="Otomatis" readonly name="kodepemeriksaanneonatus" id="kodepemeriksaanneonatus" value="" />
		<input type="hidden" readonly name="id" id="kodepemeriksaanneonatus" value="<?=$data->KD_PEMERIKSAAN_NEONATUS?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal</label>
		<input type="text" readonly name="tglkunjungan" id="tglkunjungan" value="<?=$data->TANGGAL_KUNJUNGAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kunjungan ke</label>
		<input type="text" readonly name="kunjunganke" id="kunjunganke" value="<?=$data->KUNJUNGAN_KE?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Berat Badan (kg)</label>
		<input type="text" readonly name="beratbadan" id="beratbadan" value="<?=$data->BERAT_BADAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Panjang Badan (cm)</label>
		<input type="text" readonly name="panjangbadan" id="panjangbadan" value="<?=$data->PANJANG_BADAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Memeriksa Bayi/Anak</label>
		<textarea name="tindakananak" id="tindakananak" rows="auto" cols="27" readonly ><?=$data->TINDAKAN_ANAK?></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Keterangan</label>
		<textarea  name="keterangan" id="keterangan" rows="auto" cols="27" readonly ><?=$data->KET_TINDAKAN_ANAK?></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tindakan Ibu</label>
		<textarea name="tindakanibu" id="tindakanibu" rows="auto" cols="27" readonly ><?=$data->TINDAKAN_IBU?></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Keluhan</label>
		<input type="text" readonly name="keluhan" id="keluhan" value="<?=$data->KELUHAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Alergi Obat</label>
		<input type="text" readonly name="alergiobat" id="namaobat" value="<?=$data->ALERGI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Obat</label>
		<input type="text" readonly name="namaobat" id="namaobat" value="<?=$data->OBAT?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Pemeriksa</label>
		<input type="text" readonly name="pemeriksa" id="pemeriksa" value="<?=$data->dokter_pemeriksa?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Petugas</label>
		<input type="text" readonly name="petugas" id="petugas" value="<?=$data->dokter_petugas?>" />
		</span>
	</fieldset>
</form>
</div >
