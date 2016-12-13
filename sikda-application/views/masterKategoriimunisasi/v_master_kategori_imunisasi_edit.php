<script>
$(document).ready(function(){
		$('#form1master_kategori_imunisasi_edit').ajaxForm({
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
					$("#t58","#tabs").empty();
					$("#t58","#tabs").load('c_master_kategori_imunisasi'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
})
</script>
<script>
	$('#backlistmaster_kategori_imunisasi').click(function(){
		$("#t58","#tabs").empty();
		$("#t58","#tabs").load('c_master_kategori_imunisasi'+'?_=' + (new Date()).getTime());
	})	
</script>
<div class="mycontent">
<div class="formtitle">Edit Kategori Imunisasi</div>
<div class="backbutton"><span class="kembali" id="backlistmaster_kategori_imunisasi">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1master_kategori_imunisasi_edit" method="post" action="<?=site_url('c_master_kategori_imunisasi/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Kategori Imunisasi</label>
		<input type="text" name="kodekategoriimunisasi" id="kodekategoriimunisasi" disabled value="<?=$data->KD_KATEGORI_IMUNISASI?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->KD_KATEGORI_IMUNISASI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kategori Imunisasi</label>
		<input type="text" name="kategoriimunisasi" id="kategoriimunisasi" value="<?=$data->KATEGORI_IMUNISASI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >


