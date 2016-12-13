<script>
$(document).ready(function(){
		$('#form1masterKeadaankesehatanadd').ajaxForm({
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
					$("#t24","#tabs").empty();
					$("#t24","#tabs").load('c_master_keadaan_kesehatan'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
$('#tglmasterKeadaankesehatan').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<script>
	$('#backlistmasterKeadaankesehatan').click(function(){
		$("#t24","#tabs").empty();
		$("#t24","#tabs").load('c_master_keadaan_kesehatan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Keadaan Kesehatan</div>
<div class="backbutton"><span class="kembali" id="backlistmasterKeadaankesehatan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1masterKeadaankesehatanadd" method="post" action="<?=site_url('c_master_keadaan_kesehatan/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Keadaan Kesehatan</label>
		<input type="text" name="keadaan_kesehatan" autocomplete="off" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >