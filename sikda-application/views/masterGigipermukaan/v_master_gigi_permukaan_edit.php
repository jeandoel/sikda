<script>
$(document).ready(function(){
		$('#formgigimastergigipermukaanedit').ajaxForm({
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
					$("#t1004","#tabs").empty();
					$("#t1004","#tabs").load('c_master_gigi_permukaan'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistmastergigipermukaan').click(function(){
		$("#t1004","#tabs").empty();
		$("#t1004","#tabs").load('c_master_gigi_permukaan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Edit Permukaan Gigi</div>
<div class="backbutton"><span class="kembali" id="backlistmastergigipermukaan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formgigimastergigipermukaanedit" method="post" action="<?=site_url('c_master_gigi_permukaan/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode</label>
		<input type="hidden" name="kd" id="kd" value="<?=$data->KD_GIGI_PERMUKAAN?>" />
		<input type="text" name="kode" id="kode" value="<?=$data->KODE?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama</label>
		<input type="text" name="nama" id="nama" value="<?=$data->NAMA?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >