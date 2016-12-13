<script type="text/javascript">
	$(function(){
		 $('#picker').on('change', function() {
		  	// alert( this.value ); // or $(this).val()
		  	var val = $("#picker").val();
		  	var puskesmas = $("#get_puskesmas_id").attr('value');
		  	var pasien = $("#get_pasien_id").attr('value');
		  	var petugas = $("#get_petugas_id").attr('value');

		  	if(val=="diagram"){
                $("#cetak_odontogram").show();
		  		$("#main-foto").load("t_gigi_pasien/diagram",{
				"pasien_id": pasien,
				"petugas_id": petugas,
				"puskesmas_id":puskesmas
				},function(){

				})
		  	}else{
                  $("#cetak_odontogram").hide();
                  $("#main-foto").load("t_gigi_pasien/foto",{
				"pasien_id": pasien,
				"petugas_id": petugas,
				"puskesmas_id":puskesmas
				},function(){

				})
		  	}
		}).change();
	})

	$('#t_gigiadd').click(function(){
		$('#formgigifotogigipasienadd').focus();
	})
</script>
<style type="text/css">
	#listt_gigi .ui-state-highlight td{
		background-color: yellow !important;
	}
	.achtung *{
		color: white;
	}
	.best_resolution_warn{
		font-size: 11px;
		padding-bottom: 10px;
	}
</style>
<div class="subformtitle">Odontogram</div>
<div>
	<input type="hidden" name="puskesmas" id="get_puskesmas_id" value="<?php echo $puskesmas_id;?>">
	<input type="hidden" name="pasien" id="get_pasien_id" value="<?php echo $pasien_id;?>">
	<input type="hidden" name="petugas" id="get_petugas_id" value="<?php echo $petugas_id;?>">
</div>
<fieldset>
	<span>
		<label class="declabel2">Diagram & Foto</label>
		<select id='picker' name="picker" >
			<option value="diagram" selected="selected">Diagram</option>
			<option value="photo">Photo</option>
		</select>
	</span>
</fieldset>
<fieldset id="cetak_odontogram">
    <span>
        <label class="declabel2">Cetak Odontogram</label>
        <input type="button" value="Print" onclick="PrintElem('#print_div')" />
    </span>
</fieldset>
<div id="main-foto"></div>