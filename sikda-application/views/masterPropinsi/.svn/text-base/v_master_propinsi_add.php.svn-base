<script>
$(document).ready(function(){
		$('#form1masterPropadd').ajaxForm({
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
					$("#t25","#tabs").empty();
					$("#t25","#tabs").load('c_master_propinsi'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
$('#tglmasterProp').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<script>
	$('#backlistmasterProp').click(function(){
		$("#t25","#tabs").empty();
		$("#t25","#tabs").load('c_master_propinsi'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Provinsi</div>
<div class="backbutton"><span class="kembali" id="backlistmasterProp">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1masterPropadd" method="post" action="<?=site_url('c_master_propinsi/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Provinsi</label>
		<input type="text" name="kode_prov" autocomplete="off" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Provinsi</label>
		<input type="text" name="prov" autocomplete="off" id="text2" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >