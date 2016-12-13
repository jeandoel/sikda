<script>
	$('#backlistmastertindakan').click(function(){
		$("#t70","#tabs").empty();
		$("#t70","#tabs").load('c_master_tindakan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Master Tindakan</div>
<div class="backbutton"><span class="kembali" id="backlistmastertindakan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Golongan Produk</label>
		<input type="text" name="gol_produk" id="text1" readonly value="<?=$data->KD_GOL_PRODUK?>" />
		<input type="hidden" readonly name="kd" id="text1" value="<?=$data->KD_PRODUK?>" />
		</span>
	</fieldset>
        <fieldset>
		<span>
		<label>Produk</label>
		<input type="text" name="produk" readonly id="text1" value="<?=$data->PRODUK?>"  />
		</span>
	</fieldset>
	
	<fieldset>
		<span>
		<label>Harga</label>
		<input type="text" name="harga" id="text1" readonly value="<?=$data->HARGA_PRODUK?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Singkatan</label>
		<input type="text" name="singkatan" id="text1" readonly value="<?=$data->SINGKATAN?>"/>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Is Default</label>
		<input type="text" name="is_default" id="text1" readonly value="<?=$data->IS_DEFAULT?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Odontogram</label>
		<input type="text" name="is_odontogram" id="text1" readonly value="<?php if($data->IS_ODONTOGRAM == 1){echo "Ya";}else{echo "Tidak";}?>" />
		</span>
	</fieldset>			
</form>
</div >