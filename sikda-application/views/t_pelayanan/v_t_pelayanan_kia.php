<script>
	$("#form1t_pelayanankia input[name = 'batal'],#backlistt_pelayanan").click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	});
	$("#kategori_kunjungan_kia").focus();
	$("#kategori_kunjungan_kiaanak").focus();
	var id = $('#idpasien').val();
	var id2 = $('#idpusk').val();
	var id3 = $('#idkunj').val();
	$("#kategori_kunjungan_kia").on("change", function(a){
		var mykd = $('#kategori_kunjungan_kia option:selected').val();
		if($(this).val()==''){
			$('#pelayanan_kia_holder').empty();
		}else{
			$('#pelayanan_kia_holder').empty();
			$('#pelayanan_kia_holder').load('t_pelayanan/layanan_kia?mykd='+mykd+'&id='+id+'&id2='+id2+'&id3='+id3);
		}
	});
	$("#kategori_kunjungan_kiaanak").on("change", function(a){
		var mykd2 = $('#kategori_kunjungan_kiaanak option:selected').val();
		if($(this).val()==''){
			$('#pelayanan_kia_holder').empty();
		}else{
			$('#pelayanan_kia_holder').empty();
			$('#pelayanan_kia_holder').load('t_pelayanan/layanan_kia?mykd2='+mykd2+'&id='+id+'&id2='+id2+'&id3='+id3);
		}
	});
	$(':submit').closest("form").click(function(s){
		$('#form1t_pelayanankia').submit();
	});
</script>
<div class="backbutton"><span class="kembali" id="backlistt_pelayanan">kembali ke list</span></div>
<div class="formtitle">Pelayanan KIA</div>
</br>

<span id='errormsg'></span>
<div class="subformtitle">Kategori Kunjungan KIA</div>
<div>
	<input type="hidden" name="kd_pasien_hidden" id="idpasien" value="<?=$data->KD_PASIEN?>" />
	<input type="hidden" name="kd_puskesmas_hidden" id="idpusk" value="<?=$data->KD_PUSKESMAS?>" />
	<input type="hidden" name="kd_kunjungan_hidden" id="idkunj" value="<?=$data->ID_KUNJUNGAN?>" />
	<?php if($data->KUNJUNGAN==1){?>
	<fieldset>
		<span>
		<label>Pilih Kategori Kunjungan</label>
		<select name="kategori_kunjungan_kia" id="kategori_kunjungan_kia">
			<option value="">- Silahkan Pilih -</option>
			<option value="1">Pelayanan Ibu Hamil</option>
			<option value="2">Pelayanan Ibu Bersalin</option>
			<option value="3">Pelayanan Ibu Nifas</option>
			<option value="4">Pelayanan Ibu KB</option>
		</select>
		</span>
	</fieldset>
	<?php }else{?>
	<fieldset>
		<span>
		<label>Kategori Kunjungan</label>
		<select name="kategori_kunjungan_kiaanak" id="kategori_kunjungan_kiaanak">
			<option value="">- Silahkan Pilih -</option>
			<option value="1">Pelayanan Pemeriksaan Neonatus</option>
			<option value="2">Pelayanan Pemeriksaan Kesehatan Anak</option>
		</select>
		</span>
	</fieldset>
	<?php }?>
</div>	
<div id="pelayanan_kia_holder"></div>