<script>
	$('#backlistmastergigipermukaan').click(function(){
		$("#t1004","#tabs").empty();
		$("#t1004","#tabs").load('c_master_gigi_permukaan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Permukaan Gigi</div>
<div class="backbutton"><span class="kembali" id="backlistmastergigipermukaan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode</label>
		<input type="text" readonly name="kode" id="kode" value="<?=$data->KODE?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama</label>
		<input type="text" readonly name="nama" id="nama" value="<?=$data->NAMA?>"  />
		</span>
	</fieldset>
</form>
</div >