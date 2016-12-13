<script>
$(document).ready(function(){
	$('#formmasterlb1').ajaxForm({
			beforeSend: function() {
				achtungShowLoader();	
			},
			uploadProgress: function(event, position, total, percentComplete) {
			},
			complete: function(xhr) {
				achtungHideLoader();
				if(xhr.responseText!=='	OK'){
					$.achtung({message: xhr.responseText, timeout:5});
				}else{
					$.achtung({message: 'Proses Import Data Berhasil', timeout:5});
					$("#t917","#tabs").empty();
					$("#t917","#tabs").load('c_import_data'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
});
</script>





<div class="mycontent">
<div class="formtitle">Import Data</div>
<div>
<?=isset($error)?$error:''?>
<?=isset($upload_data)?$upload_data:''?>
</div>
	<form id="formmasterlb1" action="<?php echo base_url()?>c_import_data/import_sql" method="post" enctype="multipart/form-data">
		<fieldset style="margin:0 13px 0 13px ">
			<span>
				<label>Silakan pilih file .zip </label>
				<input name="userfile" type="file" id="userfile">	
				<input type="submit" class="cari" value="&nbsp;Import&nbsp;" id="import1"/>		
			</span>
		</fieldset>		
	</form>
</div>
