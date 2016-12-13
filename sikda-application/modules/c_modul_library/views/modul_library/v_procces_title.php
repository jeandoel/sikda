<script>
$(document).ready(function(){
		$('#form1master').ajaxForm({
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
					$.achtung({message: 'Proses Ubah Data Berhasil', timeout:5});
					$("#t18","#tabs").empty();
					$("#t18","#tabs").load('modul_admin/edit_title?folder=<?=$_GET['folder']?>');
				}
			}
		});
		
})
</script>
<script>
	$('#backlistmaster').click(function(){
		$("#t18","#tabs").empty();
		$("#t18","#tabs").load('modul_admin');
	})
</script>
<div class="mycontent">
<div class="backbutton"><span class="kembali" id="backlistmaster">kembali ke list</span></div>
<form name="frApps" id="form1master" method="post" action="<?=site_url('modul_admin/edit_title?folder='.$_GET['folder'])?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Version</label>
		<input type="text" name="version" id="version" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Fitur</label>
		<textarea cols="80" rows="5" name="fitur" id="fitur"></textarea>		
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Bugfix</label>		
		<textarea cols="80" rows="5" name="bugfix" id="bugfix"></textarea>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Input"/>
		</span>
	</fieldset>
	
	<br/>
	<fieldset>
		<span>
		<label>Last Version</label>		
		</span>
	</fieldset>
<fieldset>	
	<table class="ui-jqgrid-labels" style="background-color:#F0F8FF" cellspacing="0" cellpadding="0" border="0">
	<?foreach($arraycell as $row){?>
	<tr style="background-color:#F0F8FF">
		<td><span><label>Version</label></span></td>
		<td><span><label><?=$row['version']?></label></span></td>
	</tr>
	<tr>
		<td><span><label>Fitur</label></span></td>
		<td><span><label><?=$row['fitur']?></label></span></td>
	</tr>
	<tr>
		<td><span><label>Bugfix</label></span></td>
		<td><span><label><?=$row['bugfix']?></label></span></td>
	</tr>
	<tr>
		<td><br/></td>
		<td></td>
	</tr>
	<?}?>
	</table>
</fieldset >
</form>

</div >
