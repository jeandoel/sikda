<script>
$(document).ready(function(){
		$('#formgigimastergigiproseduradd').ajaxForm({
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
<div class="formtitle">Tambah Prosedur Gigi</div>
<div class="backbutton"><span class="kembali" id="backlistmastergigiprosedur">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formgigimastergigiproseduradd" method="post" action="<?=site_url('c_master_gigi_prosedur/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode</label>
		<input type="text" name="kd_prosedur_gigi" id="kd_prosedur_gigi" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Prosedur</label>
		<input type="text" name="prosedur" id="prosedur" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Deskripsi</label>
		<input type="text" name="deskripsi" id="deskripsi" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >