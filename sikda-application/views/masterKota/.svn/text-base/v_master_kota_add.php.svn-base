<script>
$(document).ready(function(){
		$('#form1masterKotaadd').ajaxForm({
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
					$("#t27","#tabs").empty();
					$("#t27","#tabs").load('c_master_kota'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
$('#tglmasterKota1').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<script>
	$('#backlistmasterKota').click(function(){
		$("#t27","#tabs").empty();
		$("#t27","#tabs").load('c_master_kota'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Kota</div>
<div class="backbutton"><span class="kembali" id="backlistmasterKota">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1masterKotaadd" method="post" action="<?=site_url('c_master_kota/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Nama Kota</label>
		<input type="text" name="nama_kota" autocomplete="off" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Tanggal Input</label>
		<input type="text" name="tglmasterKota" id="tglmasterKota1" value="<?=date('d-m-Y')?>" style="width:89px" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >