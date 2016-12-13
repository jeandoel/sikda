<script>
$(document).ready(function(){
		$('#form1mastersatuanbesaradd').ajaxForm({
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
					$("#t71","#tabs").empty();
					$("#t71","#tabs").load('c_master_satuan_besar'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistmastersatuanbesar').click(function(){
		$("#t71","#tabs").empty();
		$("#t71","#tabs").load('c_master_satuan_besar'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Satuan Besar</div>
<div class="backbutton"><span class="kembali" id="backlistmastersatuanbesar">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1mastersatuanbesaradd" method="post" action="<?=site_url('c_master_satuan_besar/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Satuan Besar</label>
		<input type="text" name="kdsatbesar" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Satuan Besar Obat</label>
		<input type="text" name="satbesarobat" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >