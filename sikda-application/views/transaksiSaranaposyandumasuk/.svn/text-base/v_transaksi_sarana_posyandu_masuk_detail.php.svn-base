<script>
	$('#backlisttransaksisaranaposyandumasuk').click(function(){
		$("#t4","#tabs").empty();
		$("#t4","#tabs").load('c_transaksi_sarana_posyandu_masuk'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Transaksi Sarana Posyandu Masuk</div>
<div class="backbutton"><span class="kembali" id="backlisttransaksisaranaposyandumasuk">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1transaksisaranaposyandumasukdetail" >
	<fieldset>
		<span>
		<label>Asal Sarana Posyandu</label>
		<input type="text" name="asalsaranaposyandu" id="text1" value="<?=$data->nasal_sarana_posyandu?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tujuan Sarana</label>
		<input type="text" name="nama_puskesmas" id="nama_puskesmas" value="<?=$data->nnamapuskesmas?>" readonly  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Id Pegawai</label>
		<input type="text" name="idpegawai" id="text2" value="<?=$data->nid_pegawai?>" readonly  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Sarana Posyandu</label>
		<input type="text" name="nama_sarana_posyandu" id="nama_sarana_posyandu" value="<?=$data->nnamasaranaposyandu?>" readonly  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Keterangan Sarana</label>
		<textarea name="keterangansarana" rows="3" cols="45" readonly><?=$data->nketerangan_sarana?></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Transaksi</label>
		<input type="text" name="kodetransaksi" id="text4" value="<?=$data->nkode_transaksi?>" readonly  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Transaksi</label>
		<input type="text" name="tgltransaksi" id="tgltransaksi" value="<?=$data->ntgl_transaksi?>" style="width:89px" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Sarana</label>
		<input type="text" name="jumlahsarana" id="text5" value="<?=$data->njumlah_sarana?>" readonly  />
		</span>
	</fieldset>
</form>
</div >