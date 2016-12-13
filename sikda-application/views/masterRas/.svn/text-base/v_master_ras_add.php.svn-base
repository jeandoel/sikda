<script>
$(document).ready(function(){
		$('#rasadd').ajaxForm({
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
					$("#t63","#tabs").empty();
					$("#t63","#tabs").load('c_master_ras'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
$('#tglras').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<script>
	$('#backlistras').click(function(){
		$("#t63","#tabs").empty();
		$("#t63","#tabs").load('c_master_ras'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Ras</div>
<div class="backbutton"><span class="kembali" id="backlistras">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="rasadd" method="post" action="<?=site_url('c_master_ras/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>KODE RAS</label>
		<input type="text" name="kd_ras" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NAMA RAS</label>
		<input type="text" name="ras" id="text2" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >