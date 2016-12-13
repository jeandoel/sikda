<script>
$('document').ready(function(){	
	// $('#daridtdasar').datepicker({dateFormat: "yy-mm-dd"});
	// $('#sampaidtdasar').datepicker({dateFormat: "yy-mm-dd"});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	
	$("#resetdtdasar").click(function(event){
		event.preventDefault();
		$('#formmasterdtdasar').reset();
	});
	$("#caridtdasar").click(function(event){
		event.preventDefault();
		var caritahun = $('select[name=crtahun_dtdasar] option:selected').text();
		// var from = $('#daridtdasar').val();
		// var to = $('#sampaidtdasar').val();
		var pid = $('#idpdtdasar').val();
		var jenislk = $('#jenislk').val();
		window.open('<?=site_url().'report_bulanan/lap_datadasar_temp?caritahun='?>'+decodeURIComponent(caritahun)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jenislk));
	});
	$("#caridtdasar1").click(function(event){
		event.preventDefault();
		var caritahun = $('select[name=crtahun_dtdasar] option:selected').text();
		// var from = $('#daridtdasar').val();
		// var to = $('#sampaidtdasar').val();
		var pid = $('#idpdtdasar').val();
		var jenislk = $('#jenislk').val();
		window.open('<?=site_url().'report_bulanan/lap_datadasar_temp1?caritahun='?>'+decodeURIComponent(caritahun)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jenislk));
	});
})
</script>
<div class="mycontent">
<div class="formtitle">Laporan Data Dasar</div>
	<form id="formmasterdtdasar">
		<div class="gridtitle">&nbsp;</div>		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Tahun</label>
						<select name="crtahun_dtdasar" class="dari">
							<?php 
							$startyear = date('Y')-15;
							for($i=1;$i<=30;$i++){?>
							<option value="<?=$startyear+$i?>" <?=$startyear+$i==date('Y')?'selected':''?> ><?=$startyear+$i?></option>
							<?php } ?>
						</select>	
						</span>
						<span>						
						<input type="submit" class="cari" value="&nbsp;Lihat Laporan&nbsp;" id="caridtdasar"/>
						<input type="submit" class="cari" value="&nbsp;Cetak Laporan&nbsp;" id="caridtdasar1"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetdtdasar"/>
						<input type="hidden" name="idpdtdasar" id="idpdtdasar" value="<?=$this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas')?>" />
						<input type="hidden" name="jenislk" id="jenislk" value="<?=$this->session->userdata('group_id')=='kabupaten'?'rpt_dtdasar_kb':'rpt_dtdasar'?>" />
						</span>
		</fieldset>
	</form>
</div>