<script>
	$('#backlistmasterusers').click(function(){
		$("#t75","#tabs").empty();
		$("#t75","#tabs").load('c_master_users'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Pengguna</div>
<div class="backbutton"><span class="kembali" id="backlistmasterusers">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>KD USER</label>
		<input type="text" readonly name="yangditemui" id="text1" value="<?=$data->KD_USER?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->KD_USER?>" />

		</span>
	</fieldset>
	<fieldset <?=$data->LEVEL=='KABUPATEN'?"style='display:none'":''?>>
		<span>
		<label>KD PUSKESMAS</label>
		<input type="text" name="kdpuskesmas" id="nama_puskesmas_hidden" value="<?=$data->KD_PUSKESMAS?>" readonly />
		<input type="text" name="nama_puskesmas" id="nama_puskesmas" value="<?=$data->nama_puskesmas?>" readonly />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>USER NAME</label>
		<input type="text" readonly name="username" id="text3" value="<?=$data->USER_NAME?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>FULL NAME</label>
		<input type="text" readonly name="fullname" id="text3" value="<?=$data->FULL_NAME?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>PASSWORD</label>
		<input type="text" readonly name="userpassword" id="text3" value="<?=$data->USER_PASSWORD?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>EMAIL</label>
		<input type="text" readonly name="email" id="text3" value="<?=$data->EMAIL?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>GROUP ID</label>
		<input type="text" readonly name="idgroup" id="master_user_group_hidden" value="<?=$data->GROUP_ID?>"  />
		<input type="text" name="master_user_group" id="master_user_group" value="<?=$data->nama_group?>" readonly />
		</span>
	</fieldset>
</form>
</div >
