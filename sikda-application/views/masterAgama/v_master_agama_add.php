<script>
$(document).ready(function(){
		$('#form1master_agama_add').ajaxForm({
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
					$("#t41","#tabs").empty();
					$("#t41","#tabs").load('c_master_agama'+'?_=' + (new Date()).getTime());
				}
			}
		});	
})
</script>
<script>
	$('#backlistmaster_agama').click(function(){
		$("#t41","#tabs").empty();
		$("#t41","#tabs").load('c_master_agama'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Data Agama</div>
<div class="backbutton"><span class="kembali" id="backlistmaster_agama">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1master_agama_add" method="post" action="<?=site_url('c_master_agama/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Agama</label>
		<input type="text" name="kodeagama" id="kodeagama" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Agama</label>
		<input type="text" name="agama" id="agama" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >
