<script>
$(document).ready(function(){
		$('#petugasadd').ajaxForm({
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
					$("#t62","#tabs").empty();
					$("#t62","#tabs").load('c_master_petugas'+'?_=' + (new Date()).getTime());
				}
			}
		});
})

</script>
<script>
	$('#backlistpetugas').click(function(){
		$("#t62","#tabs").empty();
		$("#t62","#tabs").load('c_master_petugas'+'?_=' + (new Date()).getTime());
	})
</script>
<div class="mycontent">
<div class="formtitle">Tambah Petugas</div>
<div class="backbutton"><span class="kembali" id="backlistpetugas">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="petugasadd" method="post" action="<?=site_url('c_master_petugas/addprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>KODE PETUGAS</label>
		<input type="text" name="kdpetugas" id="text1" value="" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>NAMA PETUGAS</label>
		<input type="text" name="nmpetugas" id="text2" value=""  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>UNIT</label>
		<select size="1" name="unit" id="unit">
			<option value="" selected>--Pilih Unit--</option>
		<?php foreach($unit as $key=>$val):?>
			<option value="<?=$val['UNIT']?>"><?=$val['UNIT']?></option>
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