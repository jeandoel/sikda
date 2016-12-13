<script>
$(document).ready(function(){
		$('#formmastergdedit').ajaxForm({
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
					$("#t32","#tabs").empty();
					$("#t32","#tabs").load('c_master_gol_darah'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistmastergd').click(function(){
		$("#t32","#tabs").empty();
		$("#t32","#tabs").load('c_master_gol_darah'+'?_=' + (new Date()).getTime());
	})
	$('#tglkejadianedit').datepicker({dateFormat: "yy-mm-dd",changeYear: true});
</script>
<div class="mycontent">
<div class="formtitle">Edit Gol Darah</div>
<div class="backbutton"><span class="kembali" id="backlistmastergd">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formmastergdedit" method="post" action="<?=site_url('c_master_gol_darah/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Gol Darah</label>
		<input type="text" name="kode_gol_darah" id="text1" value="<?=$data->KD_GOL_DARAH?>" />
		<input type="hidden" name="kd" id="textid" value="<?=$data->KD_GOL_DARAH?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Golongan Darah</label>
		<input type="text" name="gol_darah" id="text1" value="<?=$data->GOL_DARAH?>" />
		</span>
	</fieldset>
	
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >