<script>
$(document).ready(function(){
		$('#formmasterkamaredit').ajaxForm({
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
					$("#t36","#tabs").empty();
					$("#t36","#tabs").load('c_master_kamar'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistmasterkamar').click(function(){
		$("#t36","#tabs").empty();
		$("#t36","#tabs").load('c_master_kamar'+'?_=' + (new Date()).getTime());
	})
	$('#tglkejadianedit').datepicker({dateFormat: "yy-mm-dd",changeYear: true});
</script>
<div class="mycontent">
<div class="formtitle">Edit Master Kamar</div>
<div class="backbutton"><span class="kembali" id="backlistmasterkamar">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formmasterkamaredit" method="post" action="<?=site_url('c_master_kamar/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Unit</label>
		<input type="text" name="kode_unit" id="text1" value="<?=$data->KD_UNIT?>" />
		<input type="hidden" readonly name="kd" id="text1" value="<?=$data->KD_UNIT?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>No Kamar</label>
		<input type="text" name="no_kamar" id="text1" value="<?=$data->NO_KAMAR?>" />
		<input type="hidden" name="no" id="text1" value="<?=$data->NO_KAMAR?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Kamar</label>
		<input type="text" name="nama_kamar" id="text1" value="<?=$data->NAMA_KAMAR?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Jumlah Bed</label>
		<input type="text" name="jumlah_bed" id="text1" value="<?=$data->JUMLAH_BED?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Digunakan</label>
		<input type="text" name="digunakan" id="text1" value="<?=$data->DIGUNAKAN?>" />
		</span>
	</fieldset>
	
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >
