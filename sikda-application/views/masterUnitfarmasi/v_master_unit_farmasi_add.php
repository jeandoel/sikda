	<script>
$(document).ready(function(){
		$('#form1master_unitfarmasi_add').ajaxForm({
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
					$("#t44","#tabs").empty();
					$("#t44","#tabs").load('c_master_unit_farmasi'+'?_=' + (new Date()).getTime());
				}
			}
		});	
})
</script>
<script>
	$('#backlistmaster_unitfarmasi').click(function(){
		$("#t44","#tabs").empty();
		$("#t44","#tabs").load('c_master_unit_farmasi'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Master Unit Farmasi/Apotik	</div>
<div class="backbutton"><span class="kembali" id="backlistmaster_unitfarmasi">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1master_unitfarmasi_add" method="post" action="<?=site_url('c_master_unit_farmasi/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Unit Farmasi</label>
		<input type="text" name="kodeunitfarmasi" id="kodeunitfarmasi" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Nama Unit Farmasi</label>
		<input type="text" name="unitfarmasi" id="unitfarmasi" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Farmasi Utama</label>
		<input type="text" name="farmasiutama" id="farmasiutama" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >