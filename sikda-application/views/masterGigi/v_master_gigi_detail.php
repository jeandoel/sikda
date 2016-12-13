<script>
	$('#backlistmastergigi').click(function(){
		$("#t1001","#tabs").empty();
		$("#t1001","#tabs").load('c_master_gigi'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Nomenklatur</div>
<div class="backbutton"><span class="kembali" id="backlistmastergigi">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Nomenklatur</label>
		<input type="text" readonly name="kd_gigi" id="kd_gigi" value="<?=$data->KD_GIGI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama</label>
		<input type="text" readonly name="nama" id="nama" value="<?=$data->NAMA?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Gambar</label>
		<img src="<?php echo site_url('assets/images/gigi_master/'.$data->GAMBAR)?>" width="50px" height="50px">
		</span>
	</fieldset>
</form>
</div >