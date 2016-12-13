<script>
$(document).ready(function(){
		$('#form1masterusergroupadd').ajaxForm({
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
					$("#t17","#tabs").empty();
					$("#t17","#tabs").load('c_master_user_group'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
})
$('#tglgroup').datepicker({dateFormat: "dd-mm-yy",changeYear: true});
</script>
<script>
	$('#backlistmasterusergroup').click(function(){
		$("#t17","#tabs").empty();
		$("#t17","#tabs").load('c_master_user_group'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Group Pengguna</div>
<div class="backbutton"><span class="kembali" id="backlistmasterusergroup">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1masterusergroupadd" method="post" action="<?=site_url('c_master_user_group/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Group id</label>
		<input type="text" name="idgroup" id="text1" value="" />
		</span>
	</fieldset>
		<fieldset>
		<span>
		<label>Group Name</label>
		<input type="text" name="namagroup" id="text1" value="" />
		</span>
	</fieldset>
		<fieldset>
		<span>
		<label>Description</label>
		<input type="text" name="deskripsi" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >