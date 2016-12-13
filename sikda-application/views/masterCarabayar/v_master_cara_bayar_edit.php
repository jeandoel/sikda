<script>
$(document).ready(function(){
		$('#form1carabayaredit').ajaxForm({
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
					$("#t53","#tabs").empty();
					$("#t53","#tabs").load('c_master_cara_bayar'+'?_=' + (new Date()).getTime());
				}
			}
		});
})
</script>
<script>
	$('#backlistcarabayar').click(function(){
		$("#t53","#tabs").empty();
		$("#t53","#tabs").load('c_master_cara_bayar'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Edit Cara Bayar</div>
<div class="backbutton"><span class="kembali" id="backlistcarabayar">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1carabayaredit" method="post" action="<?=site_url('c_master_cara_bayar/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Kode Bayar</label>
		<input type="text" name="kodebayar" id="kodebayar" value="<?=$data->KD_BAYAR?>"  />
		<input type="hidden" name="id" id="kodebayar" value="<?=$data->KD_BAYAR?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Cara Bayar</label>
		<input type="text" name="carabayar" id="carabayar" value="<?=$data->CARA_BAYAR?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Kode Customer</label>
		<select size='1'  id="kodecustomer" name="kodecustomer">
			<option value="">--Pilih--</option>
			<?php foreach($customer as $key=>$val):?>
			<option value="<?=$val['KD_CUSTOMER']?>" <?=$data->KD_CUSTOMER==$val['KD_CUSTOMER']?'selected':''?>><?=$val['KD_CUSTOMER']?> - <?=$val['CUSTOMER']?></option>
			<?php endforeach;?>
		</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >