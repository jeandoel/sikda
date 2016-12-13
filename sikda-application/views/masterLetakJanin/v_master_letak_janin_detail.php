<script>
	$('#backlistmasterLetakJanin').click(function(){
		$("#t901","#tabs").empty();
		$("#t901","#tabs").load('c_master_letak_janin'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Letak Janin</div>
<div class="backbutton"><span class="kembali" id="backlistmasterLetakJanin">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Letak Janin</label>
		<input type="text" readonly name="id" id="textid" value="<?=$data->KD_LETAK_JANIN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Letak Janin</label>
		<input type="text" readonly name="yangditemui" id="text1" value="<?=$data->LETAK_JANIN?>" />
		</span>
	</fieldset>
</form>
</div >