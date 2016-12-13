<script>
$(document).ready(function(){
		$('#form1masterLetakJaninadd').ajaxForm({
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
					$("#t901","#tabs").empty();
					$("#t901","#tabs").load('c_master_letak_janin'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
$('#tglmasterLetakJanin').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<script>
	$('#backlistmasterLetakJanin').click(function(){
		$("#t901","#tabs").empty();
		$("#t901","#tabs").load('c_master_letak_janin'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Letak Janin</div>
<div class="backbutton"><span class="kembali" id="backlistmasterLetakJanin">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1masterLetakJaninadd" method="post" action="<?=site_url('c_master_letak_janin/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Letak Janin</label>
		<input type="text" name="letak_janin" autocomplete="off" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >