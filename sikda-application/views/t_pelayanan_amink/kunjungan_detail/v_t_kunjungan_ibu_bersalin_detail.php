<script>
	$('#backlisttransaksi_pemeriksaanneonatus').click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Kunjungan Ibu Bersalin</div>
<div class="backbutton"><span class="kembali" id="backlisttransaksi_pemeriksaanneonatus">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Kunjungan Ibu Bersalin</label>
		<input type="text" placeholder="Otomatis" readonly name="kodebersalin" id="kodebersalin" value="" />
		</span>
		<span>
		<label>Tanggal Kunjungan</label>
		<input type="text" readonly name="tglkunjungan" id="tglkunjungan" value="<?=$data->TANGGAL_KUNJUNGAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jam Kelahiran</label>
		<input type="text" readonly name="jam_kelahiran" id="kunjunganke" value="<?=$data->JAM_KELAHIRAN?>" />
		</span>
		<span>
		<label>Umur Kehamilan</label>
		<input type="text" readonly name="beratbadan" id="beratbadan" value="<?=$data->UMUR_KEHAMILAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Penolong Persalinan</label>
		<input type="text" readonly name="panjangbadan" id="panjangbadan" value="<?=$data->KD_DOKTER?>" />
		</span>
		<span>
		<label>Petugas Pemeriksa</label>
		<input type="text" readonly name="panjangbadan" id="panjangbadan" value="<?=$data->KD_DOKTER?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Persalinan</label>
		<input type="text" readonly name="panjangbadan" id="panjangbadan" value="<?=$data->KD_DOKTER?>" />
		</span>
		<span>
		<label>Jenis Kelahiran</label>
		<input type="text" readonly name="panjangbadan" id="panjangbadan" value="<?=$data->KD_DOKTER?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Bayi</label>
		<input type="text" readonly name="panjangbadan" id="panjangbadan" value="<?=$data->KD_DOKTER?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Keadaan Ibu</label>
		<input type="text" readonly name="panjangbadan" id="panjangbadan" value="<?=$data->KD_DOKTER?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Status Hamil</label>
	<input type="text" readonly name="panjangbadan" id="panjangbadan" value="<?=$data->KD_DOKTER?>" />
		</span>
	</fieldset>
		
<div class="subformtitle">Bayi saat Lahir</div>
        <fieldset>
		<span>
		<label>Anak Ke</label>
		<input type="text" name="anak_ke" id="tempat_lahirt_pendaftaranadd" value="" required  />		
		</span>		
	</fieldset>
	 <fieldset>
		<span>
		<label>Berat Lahir (gram)</label>
		<input type="text" name="berat_lahir" id="tempat_lahirt_pendaftaranadd" value="" required  />		
		</span>		
	</fieldset>
	  <fieldset>
		<span>
		<label>Panjang Badan(cm)</label>
		<input type="text" name="panjang_badan" id="tempat_lahirt_pendaftaranadd" value="" required  />		
		</span>		
	</fieldset>
	   <fieldset>
		<span>
		<label>Lingkar Kepala(cm)</label>
		<input type="text" name="lingkar_kepala" id="tempat_lahirt_pendaftaranadd" value="" required  />		
		</span>		
	</fieldset>
        <fieldset>
		<span>
		<label>Jenis Kelamin</label>
		<input type="radio" name="jk" value="L">Laki - Laki
		<input type="radio" name="jk" value="P">Perempuan
		</span>
	</fieldset>
	<table id="listkeadaanbayi"></table>
	<fieldset id="fieldskeadaanbayi">
		<span>
		<label>Keadaan Bayi Saat Lahir</label>
		<input type="text" name="keadaan_bayi_lahir" value="" id="keadaanbayisearch"/>
		</span>
	</fieldset>
	<br/>
	<table id="listasuhanbayi"></table>
	<fieldset id="fieldsasuhanbayi">
		<span>
		<label>Asuhan Bayi Baru Lahir</label>
		<input type="text" name="asuhan_bayi_lahir" value="" id="asuhanbayisearch"/>
		</span>	
	</fieldset>
	<fieldset>
		<span>
		<label>Keterangan Tambahan</label>
		<textarea name="ket_tambahan" rows="3" cols="45"></textarea>
		</span>	
	</fieldset>
	<div class="subformtitle">Pemberian Obat / Vitamin</div>
	<fieldset>
		<span>
		<label>Alergi Obat</label>
		<input type="text" readonly name="alergiobat" id="namaobat" value="<?=$data->ALERGI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Obat yang diberi</label>
		<input type="text" readonly name="namaobat" id="namaobat" value="<?=$data->OBAT?>" />
		</span>
	</fieldset>
	
</form>
</div >
