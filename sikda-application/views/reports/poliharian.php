<script>
$('document').ready(function(){	
	$('#darihrj').datepicker({
		dateFormat: "dd-mm-yy",
		onSelect: function(date) {
            $('#sampaihrj').val(date);
            window.setTimeout($.proxy(function() {
				$("#sampaihrj").focus();
			}, this), 10);
        }
	});
	$('#sampaihrj').datepicker({dateFormat: "dd-mm-yy",onSelect: function(){$("#rc").focus();}});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	
	$("#resethrj").click(function(event){
		event.preventDefault();
		$('#formmasterhrj').reset();
	});
	$("#carihrj").click(function(event){
		event.preventDefault();
		var from = $('#darihrj').val();
		var to = $('#sampaihrj').val();
		var pid = $('#idphrj').val();
		var jenislk = $('#jenislk').val();
		window.open('<?=site_url().'sikda_reports/report.php?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jenislk));
	});
	$("#excelhrj").click(function(event){
		event.preventDefault();
		var from = $('#darihrj').val();
		var to = $('#sampaihrj').val();
		var pid = $('#idphrj').val();
		var jenislk = $('#jenislk').val();
		window.open('<?=base_url().'report_harian/lap_poli?&pid='?>'+decodeURIComponent(pid)+'&from='+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&jenis='+decodeURIComponent(jenislk));
	});
})
</script>
<style>
/*.ui-datepicker-calendar {
    display: none;
    }*/
</style>
<div class="mycontent">
<div class="formtitle">Laporan Kunjungan POLI</div>
	<form id="formmasterhrj">
		<div class="gridtitle">&nbsp;</div>		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label class="mydate">Dari</label>
						<input type="text" name="dari" class="dari" id="darihrj" value="<?=date('d-m-Y');?>" /> Sampai 
						<input type="text" name="sampai" class="sampai" id="sampaihrj" value="<?=date('d-m-Y');?>" />
						</span>
						<span>						
						<!--<input type="submit" class="cari" value="&nbsp;Cetak PDF&nbsp;" id="carihrj"/>-->
						<input type="submit" class="cari" value="&nbsp;Cetak Excel&nbsp;" id="excelhrj"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resethrj"/>
						<input type="hidden" name="idphrj" id="idphrj" value="<?=$this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas')?>" />
						<input type="hidden" name="jenislk" id="jenislk" value="<?=$this->session->userdata('group_id')=='kabupaten'?'rpt_hrj_kb':'lap2'?>" />
						</span>
		</fieldset>
	</form>
</div>