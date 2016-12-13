<script>
$(document).ready(function(){
		$('#formmasterjkedit').ajaxForm({
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
					$("#t31","#tabs").empty();
					$("#t31","#tabs").load('c_master_jenis_kelamin'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistmastersjk').click(function(){
		$("#t31","#tabs").empty();
		$("#t31","#tabs").load('c_master_jenis_kelamin'+'?_=' + (new Date()).getTime());
	})
	$('#tglkejadianedit').datepicker({dateFormat: "yy-mm-dd",changeYear: true});
</script>
<div class="mycontent">
<div class="formtitle">Edit Jenis Kelamin</div>
<div class="backbutton"><span class="kembali" id="backlistmastersjk">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formmasterjkedit" method="post" action="<?=site_url('c_master_jenis_kelamin/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Jenis Kelamin</label>
		<input type="text" name="kode_jenis_kelamin" id="text1" value="<?=$data->KD_JENIS_KELAMIN?>" />
		<input type="hidden" name="kd" id="textid" value="<?=$data->KD_JENIS_KELAMIN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Kelamin</label>
		<input type="text" name="jenis_kelamin" id="text1" value="<?=$data->JENIS_KELAMIN?>" />
		</span>
	</fieldset>
	
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >