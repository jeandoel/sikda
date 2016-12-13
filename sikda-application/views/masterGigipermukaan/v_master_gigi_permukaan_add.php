<script>
$(document).ready(function(){
		$('#formgigimastergigipermukaanadd').ajaxForm({
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
<div class="formtitle">Tambah Permukaan Gigi</div>
<div class="backbutton"><span class="kembali" id="backlistmastergigipermukaan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formgigimastergigipermukaanadd" method="post" action="<?=site_url('c_master_gigi_permukaan/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode</label>
		<input type="text" name="kode" id="kode" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama</label>
		<input type="text" name="nama" id="nama" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >