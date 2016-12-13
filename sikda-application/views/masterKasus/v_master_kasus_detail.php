<script>
	$('#backlistmasterKasus').click(function(){
		$("#t21","#tabs").empty();
		$("#t21","#tabs").load('c_master_kasus'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Detail Kasus</div>
<div class="backbutton"><span class="kembali" id="backlistmasterKasus">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" method="post" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Jenis Kasus</label>
		<input type="text" readonly name="id" id="textid" value="<?=$data->KD_JENIS_KASUS?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Variabel ID</label>
		<input type="text" readonly name="variabel_idd" id="text1" value="<?=$data->VARIABEL_ID?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Parent ID</label>
		<input type="text" readonly name="parent_idd" id="text2" value="<?=$data->PARENT_ID?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Variabel Name</label>
		<input type="text" readonly name="variabel_name" id="text3" value="<?=$data->VARIABEL_NAME?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Variabel Definisi</label>
		<input type="text" readonly name="variabel_defi" id="text4" value="<?=$data->VARIABEL_DEFINISI?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Keterangan</label>
		<input type="textarea" readonly name="ket" id="text5" value="<?=$data->KETERANGAN?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Pilihan Value</label>
		<input type="text" readonly name="pilihan_value" id="text6" value="<?=$data->PILIHAN_VALUE?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>I Row</label>
		<input type="text" readonly name="IRow" id="text7" value="<?=$data->IROW?>" />
		</span>
	</fieldset>
</form>
</div >