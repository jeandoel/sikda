<script>
$(document).ready(function(){
		$('#formmastertindakandedit').ajaxForm({
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
					$("#t70","#tabs").empty();
					$("#t70","#tabs").load('c_master_tindakan'+'?_=' + (new Date()).getTime());
				}
			}
		});
                
})
</script>
<script>
	$('#backlistmastertindakan').click(function(){
		$("#t70","#tabs").empty();
		$("#t70","#tabs").load('c_master_tindakan'+'?_=' + (new Date()).getTime());
	})
	$('#tglkejadianedit').datepicker({dateFormat: "yy-mm-dd",changeYear: true});
</script>
<div class="mycontent">

<div class="formtitle">Edit Master Tindakan</div>
<div class="backbutton"><span class="kembali" id="backlistmastertindakan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="formmastertindakandedit" method="post" action="<?=site_url('c_master_tindakan/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Golongan Produk</label>
		<select size="1" name="gol_produk" id="gol_produk">
			<option value="">--Pilih Golongan Produk--</option>
		<?php foreach($gol_produk as $key=>$val):?>
			<option value="<?=$val['KD_GOL_PRODUK']?>" <?=$data->KD_GOL_PRODUK==$val['KD_GOL_PRODUK']?'selected':''?>><?=$val['GOL_PRODUK']?></option>
		<?php endforeach;?>
			</select>
			<input type="hidden" name="kd" id="textid" value="<?=$data->KD_PRODUK?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Produk</label>
		<input type="text" name="produk" id="text1" value="<?=$data->PRODUK?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Harga</label>
		<input type="text" name="harga" id="text1"  value="<?=$data->HARGA_PRODUK?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Singkatan</label>
		<input type="text" name="singkatan" id="text1"  value="<?=$data->SINGKATAN?>"/>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Is Default</label>
		<input type="radio" value="1" <?=$data->IS_DEFAULT=='1'?'checked':''?> name="is_default">1
		<input type="radio" value="0" <?=$data->IS_DEFAULT=='0'?'checked':''?> name="is_default">0
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Odontogram</label>
		<input type="radio" value="1" <?=$data->IS_ODONTOGRAM=='1'?'checked':''?> name="is_odontogram">Ya
		<input type="radio" value="0" <?=$data->IS_ODONTOGRAM=='0'?'checked':''?> name="is_odontogram">Tidak
		</span>
	</fieldset>	
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >