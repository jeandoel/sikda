<script>
	$('#backlistmastersaranaposyandu').click(function(){
		$("#t15","#tabs").empty();
		$("#t15","#tabs").load('c_master_sarana_posyandu'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Sarana Posyandu</div>
<div class="backbutton"><span class="kembali" id="backlistmastersaranaposyandu">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Sarana Posyandu</label>
		<input type="text" disabled name="kodesarana" id="kodesarana" value="<?=$data->KD_SARANA_POSYANDU?>" />
		<input type="hidden" name="id" id="kodesarana" value="<?=$data->KD_SARANA_POSYANDU?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Sarana Posyandu</label>
		<input type="text" disabled name="saranaposyandu" id="saranaposyandu" value="<?=$data->NAMA_SARANA_POSYANDU?>"  />
		</span>
	</fieldset>
</form>
</div >