<script>
$(document).ready(function(){
		$('#kelpasienadd').ajaxForm({
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
					$("#t67","#tabs").empty();
					$("#t67","#tabs").load('c_master_kel_pasien'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
$('#tglkelpasien').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<script>
	$('#backlistkelpasien').click(function(){
		$("#t67","#tabs").empty();
		$("#t67","#tabs").load('c_master_kel_pasien'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Kelompok Pasien</div>
<div class="backbutton"><span class="kembali" id="backlistkelpasien">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="kelpasienadd" method="post" action="<?=site_url('c_master_kel_pasien/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>KODE KELOMPOK PASIEN</label>
		<input type="text" name="kd_cus" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>CUSTOMER</label>
		<input type="text" name="cus" id="text2" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>TELEPON</label>
		<input type="text" name="tlp1" id="text2" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >
