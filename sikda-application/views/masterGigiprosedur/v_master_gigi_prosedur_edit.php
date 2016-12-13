<script>
$(document).ready(function(){
		$('#formgigimastergigiproseduredit').ajaxForm({
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
					$("#t1005","#tabs").empty();
					$("#t1005","#tabs").load('c_master_gigi_prosedur'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistmastergigiprosedur').click(function(){
		$("#t1005","#tabs").empty();
		$("#t1005","#tabs").load('c_master_gigi_prosedur'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Edit Prosedur Gigi</div>
<div class="backbutton"><span class="kembali" id="backlistmastergigiprosedur">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formgigimastergigiproseduredit" method="post" action="<?=site_url('c_master_gigi_prosedur/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode</label>
		<input type="hidden" name="kd" id="kd" value="<?=$data->KD_PROSEDUR_GIGI?>"/>
		<input type="text" name="kd_prosedur_gigi" id="kd_prosedur_gigi" value="<?=$data->KD_PROSEDUR_GIGI?>"/>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Prosedur</label>
		<input type="text" name="prosedur" id="prosedur" value="<?=$data->PROSEDUR?>"  />
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