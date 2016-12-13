<script>
$(document).ready(function(){
		$('#form1masterPropedit').ajaxForm({
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
					$("#t25","#tabs").empty();
					$("#t25","#tabs").load('c_master_propinsi'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistmasterProp').click(function(){
		$("#t25","#tabs").empty();
		$("#t25","#tabs").load('c_master_propinsi'+'?_=' + (new Date()).getTime());
	})
	$('#tglkejadianeditprop').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<div class="mycontent">
<div class="formtitle">Edit Provinsi</div>
<div class="backbutton"><span class="kembali" id="backlistmasterProp">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1masterPropedit" method="post" action="<?=site_url('c_master_propinsi/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Provinsi</label>
		<input type="text" name="kode_prov" autocomplete="off" id="textid" value="<?=$data->KD_PROVINSI?>" />
		<input type="hidden" name="id" autocomplete="off" id="textidd" value="<?=$data->KD_PROVINSI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Provinsi</label>
		<input type="text" name="prov" autocomplete="off" id="text1" value="<?=$data->PROVINSI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >