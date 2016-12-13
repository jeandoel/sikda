<script>
$(document).ready(function(){
		$('#formtransfermastertransferadd').ajaxForm({
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
					$("#t16","#tabs").empty();
					$("#t16","#tabs").load('c_master_transfer'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistmastertransfer').click(function(){
		$("#t16","#tabs").empty();
		$("#t16","#tabs").load('c_master_transfer'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Master Transfer</div>
<div class="backbutton"><span class="kembali" id="backlistmastertransfer">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formtransfermastertransferadd" method="post" action="<?=site_url('c_master_transfer/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Transfer</label>
		<input type="text" name="kode_transfer" id="kode_transfer" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Produk Transfer</label>
		<input type="text" name="produk_transfer" id="produk_transfer" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >