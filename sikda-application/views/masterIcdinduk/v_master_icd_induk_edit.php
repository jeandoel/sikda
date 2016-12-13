<script>
$(document).ready(function(){
		$('#form1master_icd_induk_edit').ajaxForm({
			beforeSend: function() {
				achtungShowLoader();	
			},
			uploadProgress: function(event, position, total, percentComplete) {
			},
			complete: function(xhr) {
				achtungHideLoader();
				if(xhr.responseText!=='OK'){
					$.achtung({message: xhr.responseText, timeout:5});
				}else{
					$.achtung({message: 'Proses Ubah Data Berhasil', timeout:5});
					$("#t57","#tabs").empty();
					$("#t57","#tabs").load('c_master_icd_induk'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
})
</script>
<script>
	$('#backlistmaster_icd_induk').click(function(){
		$("#t57","#tabs").empty();
		$("#t57","#tabs").load('c_master_icd_induk'+'?_=' + (new Date()).getTime());
	})	
</script>
<div class="mycontent">
<div class="formtitle">Edit ICD Induk</div>
<div class="backbutton"><span class="kembali" id="backlistmaster_icd_induk">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1master_icd_induk_edit" method="post" action="<?=site_url('c_master_icd_induk/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode ICD Induk</label>
		<input type="text" name="kodeicdinduk" id="kodeicdinduk" value="<?=$data->KD_ICD_INDUK?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->KD_ICD_INDUK?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>ICD Induk</label>
		<textarea name="icdinduk" rows="2" cols="24"><?=$data->ICD_INDUK?></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >


