<script>
$(document).ready(function(){
		$('#formposisimasterposisiedit').ajaxForm({
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
					$("#t11","#tabs").empty();
					$("#t11","#tabs").load('c_master_posisi'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistmasterposisi').click(function(){
		$("#t11","#tabs").empty();
		$("#t11","#tabs").load('c_master_posisi'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Ubah Master Posisi</div>
<div class="backbutton"><span class="kembali" id="backlistmasterposisi">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formposisimasterposisiedit" method="post" action="<?=site_url('c_master_posisi/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Posisi</label>
		<input type="text" name="kode_posisi" id="kode_posisi" value="<?=$data->KD_POSISI?>" />
		<input type="hidden" name="id" id="kode_posisi" value="<?=$data->KD_POSISI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Posisi</label>
		<input type="text" name="nama_posisi" id="nama_posisi" value="<?=$data->POSISI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >