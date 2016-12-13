<script>
	$('#backlist_map_gigi').click(function(){
		$("#t1005","#tabs").empty();
		$("#t1005","#tabs").load('c_map_gigi_permukaan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Gambar Permukaan Gigi</div>
<div class="backbutton"><span class="kembali" id="backlist_map_gigi">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<div id="gigi_permukaan_pop">
		<div id="dialogcari_gigi_permukaan" title="Permukaan Gigi"></div>
		<fieldset>
			<span>
				<label class="w-dialog-label">Permukaan Gigi</label>
				<input type="hidden" name="kd_gigi_permukaan" id="kd_gigi_permukaan_id" style="width:50px;font-size:12px;" value="<?php echo $data->KD_GIGI_PERMUKAAN?>" tabindex="3" />
				<input type="text" name="kode_id" id="kode_id" style="width:50px;font-size:12px;" value="<?php echo $data->KODE;?>" tabindex="3" readonly/>
				<input type="text" placeholder="Nama status gigi" name="nama_id" id="nama_id" style="font-size:12px;" readonly value="<?php echo $data->NAMA?>" tabindex="3" />
			</span>
		</fieldset>
	</div>
	<div id="gigi_status_pop">
		<div id="dialogcari_master_gigi_status_id" title="Status Gigi"></div>
		<fieldset>
			<span>
				<label class="w-dialog-label">Status Gigi</label>
				<input type="text" name="kd_status_gigi" id="master_gigi_status_id_hidden" style="width:50px;font-size:12px;" value="<?php echo $data->KD_STATUS_GIGI?>" tabindex="3" readonly/>
				<input type="text" placeholder="Nama status gigi" name="master_gigi_status_id" id="master_gigi_status_id" style="font-size:12px;" readonly value="<?php echo $data->STATUS?>" tabindex="3" />
			</span>
		</fieldset>
		<fieldset>
			<span>
			<label>Deskripsi Status Gigi</label>
			<textarea rows="6" cols="40" readonly><?php echo $data->DESKRIPSI;?></textarea>
			</span>
		</fieldset>
	</div>
	<fieldset>
		<span>
		<label>Gambar</label>
		<img src="<?php echo site_url('assets/images/map_gigi_permukaan/'.$data->map_gambar)?>" width="35px" height="60px">
		</span>
	</fieldset>
</form>
</div >