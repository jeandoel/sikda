<script>
$(document).ready(function(){
		$('#pankesadd').ajaxForm({
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
					$("#t66","#tabs").empty();
					$("#t66","#tabs").load('c_master_pendidikan_kesehatan'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
$('#tglpankes').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<script>
	$('#backlistpenkes').click(function(){
		$("#t66","#tabs").empty();
		$("#t66","#tabs").load('c_master_pendidikan_kesehatan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Pendidikan</div>
<div class="backbutton"><span class="kembali" id="backlistpenkes">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="pankesadd" method="post" action="<?=site_url('c_master_pendidikan_kesehatan/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>KODE PENDIDIKAN</label>
		<input type="text" name="kd_penkes" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NAMA PENDIDIKAN</label>
		<input type="text" name="penkes" id="text2" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >