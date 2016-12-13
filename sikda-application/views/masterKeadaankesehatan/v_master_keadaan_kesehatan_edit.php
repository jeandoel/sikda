<script>
$(document).ready(function(){
		$('#form1masterKeadaankesehatanedit').ajaxForm({
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
					$("#t24","#tabs").empty();
					$("#t24","#tabs").load('c_master_keadaan_kesehatan'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistmasterKeadaankesehatan').click(function(){
		$("#t24","#tabs").empty();
		$("#t24","#tabs").load('c_master_keadaan_kesehatan'+'?_=' + (new Date()).getTime());
	})
	$('#tglkejadianeditprop').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<div class="mycontent">
<div class="formtitle">Edit Keadaan Kesehatan</div>
<div class="backbutton"><span class="kembali" id="backlistmasterKeadaankesehatan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1masterKeadaankesehatanedit" method="post" action="<?=site_url('c_master_keadaan_kesehatan/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Keadaan Kesehatan</label>
		<input type="text" name="keadaan_kesehatan" autocomplete="off" id="textid" value="<?=$data->KEADAAN_KESEHATAN?>" />
		<input type="hidden" name="id" autocomplete="off" id="textidd" value="<?=$data->KD_KEADAAN_KESEHATAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >