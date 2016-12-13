<script>
$(document).ready(function(){
		$('#formspesialisasimasterspesialisasiedit').ajaxForm({
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
					$("#t13","#tabs").empty();
					$("#t13","#tabs").load('c_master_spesialisasi'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistmasterspesialisasi').click(function(){
		$("#t13","#tabs").empty();
		$("#t13","#tabs").load('c_master_spesialisasi'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Edit Master Spesialisasi</div>
<div class="backbutton"><span class="kembali" id="backlistmasterspesialisasi">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formspesialisasimasterspesialisasiedit" method="post" action="<?=site_url('c_master_spesialisasi/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Spesialisasi</label>
		<input type="text" name="kode_spesialisasi" id="kode_spesialisasi" value="<?=$data->KD_SPESIAL?>" />
		<input type="hidden" name="id" id="kode_spesialisasi" value="<?=$data->KD_SPESIAL?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Spesialisasi</label>
		<input type="text" name="kolom_spesialisasi" id="kolom_spesialisasi" value="<?=$data->SPESIALISASI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >