<script>
$(document).ready(function(){
		$('#rasedit').ajaxForm({
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
					$("#t63","#tabs").empty();
					$("#t63","#tabs").load('c_master_ras'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistras').click(function(){
		$("#t63","#tabs").empty();
		$("#t63","#tabs").load('c_master_ras'+'?_=' + (new Date()).getTime());
	})
	$('#tglras').datepicker({dateFormat: "yy-mm-dd",changeYear: true});
</script>
<div class="mycontent">
<div class="formtitle">Edit Ras</div>
<div class="backbutton"><span class="kembali" id="backlistras">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="rasedit" method="post" action="<?=site_url('c_master_ras/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>KODE OBAT</label>
		<input type="text" name="kd_ras" id="kd_ras" value="<?=$data->KD_RAS?>" />
		<input type="hidden" name="kd_ras1" id="textid" value="<?=$data->KD_RAS?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NAMA RAS</label>
		<input type="text" name="ras" id="text2" value="<?=$data->RAS?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >