<script>
	$('#backlisttranswilayah').click(function(){
		$("#t3","#tabs").empty();
		$("#t3","#tabs").load('c_transaksi_wilayah'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Master Wilayah</div>
<div class="backbutton"><span class="kembali" id="backlisttranswilayah">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Transaksi</label>
		<input type="text" name="kode_transaksi" id="text1" readonly autocomplete="off" value="<?=$data->nkode_transaksi?>" />
		<input type="hidden" name="id" id="idtext" value="<?=$data->nid_wilayah?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Propinsi</label>
		<input type="text" name="master_propinsi_id" id="master_propinsi_id" readonly value="<?=$data->nnama_propinsi?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Kabupaten</label>
		<input type="text" name="master_kabupaten_id" id="master_kabupaten_id" readonly autocomplete="off" value="<?=$data->nnama_kabupaten?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Kota</label>
		<input type="text" name="master_kota_id" id="master_kota_id" readonly autocomplete="off" value="<?=$data->nnama_kota?>"  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Nama Kecamatan</label>
		<input type="text" name="master_kecamatan_id" id="master_kecamatan_id" readonly autocomplete="off" value="<?=$data->nnama_kecamatan?>"  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>Nama Desa</label>
		<input type="text" name="master_desa_id" id="master_desa_id" readonly autocomplete="off" value="<?=$data->nnama_desa?>"  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>No RT</label>
		<input type="text" name="noRT" id="text7" readonly autocomplete="off" value="<?=$data->nno_rt?>"  />
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<label>No RW</label>
		<input type="text" name="noRW" id="text8" readonly autocomplete="off" value="<?=$data->nno_rw?>"  />
		</span>
	</fieldset>		
	<fieldset>
		<span>
		<label>Tanggal Transaksi</label>
		<input type="text" name="tgltransaksiwilayah" id="tgltransaksiwilayah" readonly value="<?=date("d-m-Y", strtotime($data->ntgl_transaksi_wilayah))?>" style="width:89px" />
		</span>
	</fieldset>
</form>
</div >