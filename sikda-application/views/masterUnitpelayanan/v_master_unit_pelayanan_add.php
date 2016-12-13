<script>
$(document).ready(function(){
		$('#formmasterunitpelayanan').ajaxForm({
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
					$("#t35","#tabs").empty();
					$("#t35","#tabs").load('c_master_unit_pelayanan'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
$('#tglmastergd').datepicker({dateFormat: "yy-mm-dd",changeYear: true});
</script>
<script>
	$('#backlistmasterunitpelayanan').click(function(){
		$("#t35","#tabs").empty();
		$("#t35","#tabs").load('c_master_unit_pelayanan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Master Unit Pelayanan</div>
<div class="backbutton"><span class="kembali" id="backlistmasterunitpelayanan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formmasterunitpelayanan" method="post" action="<?=site_url('c_master_unit_pelayanan/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Unit Pelayanan</label>
		<input type="text" name="kode_unit_pelayanan" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Unit</label>
		<input type="text" name="nama_unit" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Aktif</label>
		<select name="aktif">
			<option value=""> -Pilih-</option>
			<option value="YA">Aktif</option>
			<option value="TIDAK">Tidak Aktif</option>
		</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >