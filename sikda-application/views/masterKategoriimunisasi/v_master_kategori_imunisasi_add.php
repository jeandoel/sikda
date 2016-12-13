	<script>
$(document).ready(function(){
		$('#form1master_kategori_imunisasi_add').ajaxForm({
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
					$.achtung({message: 'Proses Tambah Data Berhasil', timeout:5});
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
<div class="formtitle">Tambah Kategori Imunisasi</div>
<div class="backbutton"><span class="kembali" id="backlistmaster_kategori_imunisasi">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1master_kategori_imunisasi_add" method="post" action="<?=site_url('c_master_kategori_imunisasi/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Kategori Imunisasi</label>
		<input type="text" placeholder="Otomatis" name="kodekategoriimunisasi" id="kodekategoriimunisasi" value="" disabled />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kategori Imunisasi</label>
		<input type="text" name="kategoriimunisasi" id="kategoriimunisasi" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >