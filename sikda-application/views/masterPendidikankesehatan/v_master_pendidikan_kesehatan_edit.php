<script>
$(document).ready(function(){
		$('#penkesedit').ajaxForm({
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
					$("#t66","#tabs").empty();
					$("#t66","#tabs").load('c_master_pendidikan_kesehatan'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistpenkes').click(function(){
		$("#t66","#tabs").empty();
		$("#t66","#tabs").load('c_master_pendidikan_kesehatan'+'?_=' + (new Date()).getTime());
	})
	$('#tglras').datepicker({dateFormat: "yy-mm-dd",changeYear: true});
</script>
<div class="mycontent">
<div class="formtitle">Edit Pendidikan Kesehatan</div>
<div class="backbutton"><span class="kembali" id="backlistpenkes">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="penkesedit" method="post" action="<?=site_url('c_master_pendidikan_kesehatan/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>KODE PENDIDIKAN</label>
		<input type="text" name="kd_penkes" id="kd_penkes" value="<?=$data->KD_PENDIDIKAN?>" />
		<input type="hidden" name="kd_penkes1" id="textid" value="<?=$data->KD_PENDIDIKAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NAMA PENDIDIKAN</label>
		<input type="text" name="penkes" id="text2" value="<?=$data->PENDIDIKAN?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >