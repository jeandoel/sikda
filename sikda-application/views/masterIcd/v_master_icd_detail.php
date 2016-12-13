<script>
	$('#backlistmastericd').click(function(){
		$("#t33","#tabs").empty();
		$("#t33","#tabs").load('c_master_icd'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Master ICD</div>
<div class="backbutton"><span class="kembali" id="backlistmastericd">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Penyakit</label>
		<input type="text" name="kode_penyakit" id="text1" readonly value="<?=$data->KD_PENYAKIT?>" />
		<input type="hidden" readonly name="kd" id="text1" value="<?=$data->KD_PENYAKIT?>" />
		</span>
	</fieldset>
        <fieldset>
		<span>
		<label>Kode ICD Induk</label>
		<input type="text" name="kode_icd_induk" readonly id="nama_icdinduk_hidden" value="<?=$data->KD_ICD_INDUK?>"  />
		<input type="text" placeholder="ICD Induk" name="nama_icdinduk" id="nama_icdinduk" readonly value="<?=$data->icd_induk?>" />
		</span>
	</fieldset>
	
	<fieldset>
		<span>
		<label>Penyakit</label>
		<input type="text" name="penyakit" id="text1" readonly value="<?=$data->PENYAKIT?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Includes</label>
		<input type="text" name="includes" id="text1" readonly value="<?=$data->INCLUDES?>"/>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Excludes</label>
		<input type="text" name="excludes" id="text1" readonly value="<?=$data->EXCLUDES?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Notes</label>
		<input type="text" name="notes" id="text1" readonly value="<?=$data->NOTES?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Status APP</label>
		<input type="text" name="status_app" id="text1"  readonly value="<?=$data->STATUS_APP?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Description</label>
		<input type="text" name="description" id="text1" readonly value="<?=$data->DESCRIPTION?>" />
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