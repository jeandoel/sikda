<script>
$(document).ready(function(){		
		$('#showhide_pelayananlayanan').on('change', function() {
		if($(this).val()=='rawat_jalan'){
			$("#pelayananlayananid").empty();
			$("#pelayananlayananid").load('t_pelayanan/rawatjalan'+'?id='+$('#idcaller').val()+'&id2='+$('#idcaller2').val()+'&id3='+$('#idcaller3').val()+'&_=' + (new Date()).getTime());
		}else if($(this).val()=='rawat_inap'){
			$("#pelayananlayananid").empty();
			$("#pelayananlayananid").load('t_pelayanan/rawatinap'+'?id='+$('#idcaller').val()+'&id2='+$('#idcaller2').val()+'&id3='+$('#idcaller3').val()+'&_=' + (new Date()).getTime());
		}else{
			$("#pelayananlayananid").empty();
		}
	});

});
</script>
<script>
	$('#backlistt_pelayanan').click(function(){
		$("#t203","#tabs").empty();
		$("#t203","#tabs").load('t_pelayanan'+'?_=' + (new Date()).getTime());
	});
	$("#showhide_pelayananlayanan").focus();
</script>
<div class="backbutton"><span class="kembali" id="backlistt_pelayanan">kembali ke list</span></div>
<fieldset>
	<span>
	<label>Jenis Kunjungan</label>
		<select name="showhide_layanan" id="showhide_pelayananlayanan">
			<option value="">Pilih Jenis Kunjungan</option>
			<option value="rawat_jalan">Rawat Jalan</option>
			<option value="rawat_inap">Rawat Inap</option>
		</select>
	</span>
</fieldset>
<input type="hidden" name="id" id="idcaller" value="<?=$id?>" />
<input type="hidden" name="id2" id="idcaller2" value="<?=$id2?>" />
<input type="hidden" name="id3" id="idcaller3" value="<?=$id3?>" />
<br/>
<div class="mycontent" id="pelayananlayananid">
</div>