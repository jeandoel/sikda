<script>
$(document).ready(function(){
		$('#formgigimastergigimasalahedit').ajaxForm({
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
					$("#t1002","#tabs").empty();
					$("#t1002","#tabs").load('c_master_gigi_masalah'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistmastergigimasalah').click(function(){
		$("#t1002","#tabs").empty();
		$("#t1002","#tabs").load('c_master_gigi_masalah'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Edit Masalah Gigi</div>
<div class="backbutton"><span class="kembali" id="backlistmastergigimasalah">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formgigimastergigimasalahedit" method="post" action="<?=site_url('c_master_gigi_masalah/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Masalah</label>
		<input type="text" name="masalah" id="masalah" value="<?=$data->MASALAH?>" />
		<input type="hidden" name="id" id="id" value="<?=$data->KD_MASALAH_GIGI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Deskripsi</label>
		<input type="text" name="deskripsi" id="deskripsi" value="<?=$data->DESKRIPSI?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >