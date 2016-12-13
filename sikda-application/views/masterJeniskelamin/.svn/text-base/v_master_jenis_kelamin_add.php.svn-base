<script>
$(document).ready(function(){
		$('#formmasterjk').ajaxForm({
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
					$("#t31","#tabs").empty();
					$("#t31","#tabs").load('c_master_jenis_kelamin'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
$('#tglmasterjk').datepicker({dateFormat: "yy-mm-dd",changeYear: true});
</script>
<script>
	$('#backlistmasterjk').click(function(){
		$("#t31","#tabs").empty();
		$("#t31","#tabs").load('c_master_jenis_kelamin'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Master Jenis Kelamin</div>
<div class="backbutton"><span class="kembali" id="backlistmasterjk">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formmasterjk" method="post" action="<?=site_url('c_master_jenis_kelamin/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Jenis Kelamin</label>
		<input type="text" name="kode_jenis_kelamin" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jenis Kelamin</label>
		<input type="text" name="jenis_kelamin" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >