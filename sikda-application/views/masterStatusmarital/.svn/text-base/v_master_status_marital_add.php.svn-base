<script>
$(document).ready(function(){
		$('#statusmaritaladd').ajaxForm({
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
					$("#t64","#tabs").empty();
					$("#t64","#tabs").load('c_master_status_marital'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
$('#tglstatusmarital').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<script>
	$('#backliststatusmarital').click(function(){
		$("#t64","#tabs").empty();
		$("#t64","#tabs").load('c_master_status_marital'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Status Marital</div>
<div class="backbutton"><span class="kembali" id="backliststatusmarital">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="statusmaritaladd" method="post" action="<?=site_url('c_master_status_marital/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>KODE STATUS MARITAL</label>
		<input type="text" name="kd_status_marital" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NAMA STATUS</label>
		<input type="text" name="status_marital" id="text2" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >