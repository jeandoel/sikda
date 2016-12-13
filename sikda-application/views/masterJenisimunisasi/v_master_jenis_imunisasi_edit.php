<script>
$(document).ready(function(){
		$('#form1master_jenis_imunisasi_edit').ajaxForm({
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
					$("#t60","#tabs").empty();
					$("#t60","#tabs").load('c_master_jenis_imunisasi'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
})
</script>
<script>
	$('#backlistmaster_jenis_imunisasi').click(function(){
		$("#t60","#tabs").empty();
		$("#t60","#tabs").load('c_master_jenis_imunisasi'+'?_=' + (new Date()).getTime());
	})	
</script>
<div class="mycontent">
<div class="formtitle">Edit Jenis Imunisasi</div>
<div class="backbutton"><span class="kembali" id="backlistmaster_jenis_imunisasi">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1master_jenis_imunisasi_edit" method="post" action="<?=site_url('c_master_jenis_imunisasi/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Jenis Imunisasi</label>
		<input type="text" name="kodejenisimunisasi" id="kodejenisimunisasi" disabled value="<?=$data->KD_JENIS_IMUNISASI?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->KD_JENIS_IMUNISASI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Imunisasi</label>
		<input type="text" name="jenisimunisasi" id="jenisimunisasi" value="<?=$data->JENIS_IMUNISASI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >


