<script>
$('document').ready(function(){
	$('#pilihlb2').datepicker({
     changeMonth: true,
     changeYear: true,
     dateFormat: 'MM yy',
	 onClose:function(){
		setTimeout(function(){
		  $('.ui-datepicker-calendar').css('display', 'none');
	    }, 0);
		var iMonth = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
        var iYear = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
		var lastdate = new Date(iYear, parseInt(iMonth)+1, 0);
		var firstdate = new Date(iYear, iMonth, 1);
        $(this).datepicker('setDate', new Date(iYear,iMonth));
        $('#darilb2').datepicker('setDate', firstdate);
        $('#sampailb2').datepicker('setDate', lastdate);
	 },
	 onChangeMonthYear:function(){
		setTimeout(function(){
		  $('.ui-datepicker-calendar').css('display', 'none');
	    }, 0);
		var iMonth = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
        var iYear = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
		var lastdate = new Date(iYear, parseInt(iMonth)+1, 0);
		var firstdate = new Date(iYear, iMonth, 1);
		$(this).datepicker('setDate', new Date(iYear,iMonth));
        $('#darilb2').datepicker('setDate', firstdate);
        $('#sampailb2').datepicker('setDate', lastdate);
	 },
     beforeShow: function() {
       setTimeout(function(){
		  $('.ui-datepicker-calendar').css('display', 'none');
	    }, 0);
	   if ((selDate = $(this).val()).length > 0) 
       {
          iYear = selDate.substring(selDate.length - 4, selDate.length);
          iMonth = jQuery.inArray(selDate.substring(0, selDate.length - 5), 
          $(this).datepicker('option', 'monthNames'));
          $(this).datepicker('option', 'defaultDate', new Date(iYear, iMonth, 1));
          $(this).datepicker('setDate', new Date(iYear, iMonth, 1));
       }
    }
    });	
	
	$('#darilb2').datepicker({dateFormat: "yy-mm-dd"});
	$('#sampailb2').datepicker({dateFormat: "yy-mm-dd"});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	
	$("#resetlb2").click(function(event){
		event.preventDefault();
		$('#formmasterlb2').reset();
	});
	$("#carilb2").click(function(event){
		event.preventDefault();
		var from = $('#darilb2').val();
		var to = $('#sampailb2').val();
		var pid = $('#idplb2').val();
		var jenis = $('#jenislb2').val();
		var kdkabupaten = $("#kdkabupaten").val();
		NewWin = window.open('<?=site_url().'sikda_reports/report.php?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jenis)+'&kdkabupaten='+decodeURIComponent(kdkabupaten));
		//setTimeout(function(){NewWin.close()},2000);
	});
	$("#excellb2").click(function(event){
		event.preventDefault();
		var from = $('#darilb2').val();
		var to = $('#sampailb2').val();
		var pid = $('#idplb2').val();
		var jenis = $('#jenislb2').val();
		var kdkabupaten = $("#kdkabupaten").val();
		NewWin = window.open('<?=base_url().'report_bulanan/lb2_excel?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jenis)+'&kdkabupaten='+decodeURIComponent(kdkabupaten));
		//setTimeout(function(){NewWin.close()},2000);
	});
})
</script>
<style>
/*.ui-datepicker-calendar {
    display: none;
    }*/
</style>
<div class="mycontent">
<div class="formtitle">Laporan Bulanan (LB2)</div>
	<form id="formmasterlb2">
		<div class="gridtitle">&nbsp;</div>		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Pilih Bulan</label>
						<input type="text" name="pilihbln" style="width:105px" readonly id="pilihlb2" value="<?=date('F Y');?>"/>
						<input type="hidden" name="dari" class="dari" id="darilb2" value="<?=date('Y-m-01');?>" />
						<input type="hidden" name="sampai" class="sampai" id="sampailb2" value="<?=date('Y-m-t');?>" />
						</span>
						<span>						
						<input type="submit" class="cari" value="&nbsp;Cetak PDF&nbsp;" id="carilb2"/>
						<input type="submit" class="cari" value="&nbsp;Cetak Excel&nbsp;" id="excellb2"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetlb2"/>
						<input type="hidden" name="idplb2" id="idplb2" value="<?=$this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas')?>" />
						<input type="hidden" name="jenislb2" id="jenislb2" value="<?=$this->session->userdata('group_id')=='kabupaten'?'rpt_lb2_kb':'rpt_lb2'?>" />
						<input type="hidden" name="kdkabupaten" id="kdkabupaten" value="<?=$this->session->userdata('kd_kabupaten')?>" />
						</span>
		</fieldset>
	</form>
</div>