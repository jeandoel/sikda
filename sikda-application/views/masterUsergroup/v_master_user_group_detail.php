<script>
	$('#backlistmasterusers').click(function(){
		$("#t17","#tabs").empty();
		$("#t17","#tabs").load('c_master_user_group'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Group Pengguna</div>
<div class="backbutton"><span class="kembali" id="backlistmasterusers">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Group Id</label>
		<input type="text" readonly name="idgroup" id="text1" value="<?=$data->group_id?>" />

		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Group Name</label>
		<input type="text" readonly name="yangditemui" id="text2" value="<?=$data->group_name?>"  />
		<input type="hidden" name="id" id="textid" value="<?=$data->group_id?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Description</label>
		<input type="text" readonly name="deskripsi" id="text3" value="<?=$data->description?>"  />
		</span>
	</fieldset>
</form>
</div >