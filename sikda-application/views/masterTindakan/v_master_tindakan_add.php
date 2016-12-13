<script>
$(document).ready(function(){
		$('#mastertindakanadd').ajaxForm({
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
					$("#t70","#tabs").empty();
					$("#t70","#tabs").load('c_master_tindakan'+'?_=' + (new Date()).getTime());
				}
			}
		});
                
})
$('#tglmastertindakan').datepicker({dateFormat: "yy-mm-dd",changeYear: true});
</script>
<script>
	$('#backlistmastertindakan').click(function(){
		$("#t70","#tabs").empty();
		$("#t70","#tabs").load('c_master_tindakan'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">

<div class="formtitle">Tambah Master Tindakan</div>
<div class="backbutton"><span class="kembali" id="backlistmastertindakan">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="mastertindakanadd" method="post" action="<?=site_url('c_master_tindakan/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Golongan Produk</label>
		<select size="1" name="gol_produk" id="gol_produk">
			<option value="" selected>--Pilih Golongan Produk--</option>
		<?php foreach($gol_produk as $key=>$val):?>
			<option value="<?=$val['KD_GOL_PRODUK']?>"><?=$val['GOL_PRODUK']?></option>
		<?php endforeach;?>
			</select>
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Produk</label>
		<input type="text" name="produk" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Harga</label>
		<input type="text" name="harga" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Singkatan</label>
		<input type="text" name="singkatan" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Is Default</label>
		<input type="radio" name="is_default" value="1" />1
		<input type="radio" name="is_default" value="0" />0
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Odontogram</label>
		<input type="radio" name="is_odontogram" value="1" />Ya
		<input type="radio" name="is_odontogram" value="0" />Tidak
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>	
</form>
</div >