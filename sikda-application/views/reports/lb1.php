<script>
$('document').ready(function(){
	$('#pilihlb1').datepicker({
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
        $('#darilb1').datepicker('setDate', firstdate);
        $('#sampailb1').datepicker('setDate', lastdate);
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
        $('#darilb1').datepicker('setDate', firstdate);
        $('#sampailb1').datepicker('setDate', lastdate);
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
	
	$('#darilb1').datepicker({dateFormat: "yy-mm-dd"});
	$('#sampailb1').datepicker({dateFormat: "yy-mm-dd"});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	
	$("#resetlb1").click(function(event){
		event.preventDefault();
		$('#formmasterlb1').reset();
	});
	$("#carilb1").click(function(event){
		event.preventDefault();
		var from = $('#darilb1').val();
		var to = $('#sampailb1').val();
		var pid = $('#idplb1').val();
		var jenislb1 = $('#jenislb1').val();
		NewWin = window.open('<?=site_url().'sikda_reports/report.php?idd=pdf&from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jenislb1));
		//setTimeout(function(){NewWin.close()},2000);
	});
	$("#excellb1").click(function(event){
		event.preventDefault();
		var from = $('#darilb1').val();
		var to = $('#sampailb1').val();
		var pid = $('#idplb1').val();
		var jenislb1 = $('#jenislb1').val();
		NewWin = window.open('<?=base_url().'report_bulanan/lb1_excel?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jenislb1));
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
<div class="formtitle">Laporan Bulanan (LB1)</div>
	<form id="formmasterlb1">
		<div class="gridtitle">&nbsp;</div>		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Pilih Bulan</label>
						<input type="text" name="pilihbln" style="width:105px" readonly id="pilihlb1" value="<?=date('F Y');?>"/>
						<input type="hidden" name="dari" class="dari" id="darilb1" value="<?=date('Y-m-01');?>" />
						<input type="hidden" name="sampai" class="sampai" id="sampailb1" value="<?=date('Y-m-t');?>" />
						</span>
						<span>						
						<input type="submit" class="cari" value="&nbsp;Cetak PDF&nbsp;" id="carilb1"/>
						<input type="submit" class="cari" value="&nbsp;Cetak Excel&nbsp;" id="excellb1"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetlb1"/>
						<input type="hidden" name="idplb1" id="idplb1" value="<?=$this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas')?>" />
						<input type="hidden" name="jenislb1" id="jenislb1" value="<?=$this->session->userdata('group_id')=='kabupaten'?'rpt_lb1_kb':'rpt_lb1'?>" />
						</span>
		</fieldset>
	</form>
</div>