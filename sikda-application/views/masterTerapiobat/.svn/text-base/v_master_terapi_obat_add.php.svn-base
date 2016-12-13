	<script>
$(document).ready(function(){
		$('#form1master_terapiobat_add').ajaxForm({
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
					$("#t43","#tabs").empty();
					$("#t43","#tabs").load('c_master_terapi_obat'+'?_=' + (new Date()).getTime());
				}
			}
		});	
})
</script>
<script>
	$('#backlistmaster_terapiobat').click(function(){
		$("#t43","#tabs").empty();
		$("#t43","#tabs").load('c_master_terapi_obat'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Data Terapi Obat</div>
<div class="backbutton"><span class="kembali" id="backlistmaster_terapiobat">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1master_terapiobat_add" method="post" action="<?=site_url('c_master_terapi_obat/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Terapi Obat</label>
		<input type="text" name="kodeterapiobat" id="kodeterapiobat" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Terapi Obat</label>
		<input type="text" name="terapiobat" id="terapiobat" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >