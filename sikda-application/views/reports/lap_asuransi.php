<script>
$('document').ready(function(){	
	$('#darijmksms').datepicker({dateFormat: "yy-mm-dd"});
	$('#sampaijmksms').datepicker({dateFormat: "yy-mm-dd"});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	
	$("#resetjmksms").click(function(event){
		event.preventDefault();
		$('#formmasterjmksms').reset();
	});
	$("#carijmksms").click(function(event){
		event.preventDefault();
		var jns = $('#jnsasuransi').val();
		var from = $('#darijmksms').val();
		var to = $('#sampaijmksms').val();
		var pid = $('#idpjmksms').val();
		var jenislk = $('#jenislk').val();
		window.open('<?=site_url().'report_bulanan/lapasuransi_temp?jenispt=pdf&from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jenislk)+'&jenisasu='+decodeURIComponent(jns));
	});
	$("#exceljmksms").click(function(event){
		event.preventDefault();
		var jns = $('#jnsasuransi').val();
		var from = $('#darijmksms').val();
		var to = $('#sampaijmksms').val();
		var pid = $('#idpjmksms').val();
		var jenislk = $('#jenislk').val();
		window.open('<?=site_url().'report_bulanan/lapasuransi_temp?jenispt=exc&from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jenislk)+'&jenisasu='+decodeURIComponent(jns));
	});
})
</script>
<style>
/*.ui-datepicker-calendar {
    display: none;
    }*/
</style>
<div class="mycontent">
<div class="formtitle">Laporan Asuransi</div>
	<form id="formmasterjmksms">
		<div class="gridtitle">&nbsp;</div>		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Jenis Asuransi</label>
						<select name="jenis" id="jnsasuransi">
							<?php
								foreach($all as $kel):
							?>
								<option value="<?=$kel['CUSTOMER']?>"><?=$kel['CUSTOMER']?></option>
							<?php endforeach; ?>
						</select>
						</span>
						<span>
						<label style="width:40px">Dari</label>
						<input type="text" name="dari" class="dari" id="darijmksms" value="<?=date('Y-m-01');?>" /> Sampai 
						<input type="text" name="sampai" class="sampai" id="sampaijmksms" value="<?=date('Y-m-t');?>" />
						</span>
						<span>						
						<input type="submit" class="cari" value="&nbsp;Cetak PDF&nbsp;" id="carijmksms"/>
						<input type="submit" class="excel" value="&nbsp;Cetak Excel&nbsp;" id="exceljmksms"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetjmksms"/>
						<input type="hidden" name="idpjmksms" id="idpjmksms" value="<?=$this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas')?>" />
						<input type="hidden" name="jenislk" id="jenislk" value="<?=$this->session->userdata('group_id')=='kabupaten'?'rpt_jmksms_kb':'rpt_jmksms'?>" />
						</span>
		</fieldset>
	</form>
</div>
