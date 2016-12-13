<script>
$(document).ready(function(){
		$('#formdesamasterdesaadd').ajaxForm({
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
					$("#t19","#tabs").empty();
					$("#t19","#tabs").load('masterdesa'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
$('#tglmasterdesa').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<script>
	$('#backlistmasterdesa').click(function(){
		$("#t19","#tabs").empty();
		$("#t19","#tabs").load('masterdesa'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Master Desa</div>
<div class="backbutton"><span class="kembali" id="backlistmasterdesa">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formdesamasterdesaadd" method="post" action="<?=site_url('masterdesa/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Nama Desa</label>
		<input type="text" name="kolom_desa" id="text1" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Master Desa</label>
		<input type="text" name="tglmasterdesa" id="tglmasterdesa" value="<?=date('Y-m-d')?>" style="width:89px" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >