<script>
$('document').ready(function(){
	$('#pilihkesling').datepicker({
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
        $('#darikesling').datepicker('setDate', firstdate);
        $('#sampaikesling').datepicker('setDate', lastdate);
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
        $('#darikesling').datepicker('setDate', firstdate);
        $('#sampaikesling').datepicker('setDate', lastdate);
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
	
	$('#darikesling').datepicker({dateFormat: "yy-mm-dd"});
	$('#sampaikesling').datepicker({dateFormat: "yy-mm-dd"});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	
	$("#resetkesling").click(function(event){
		event.preventDefault();
		$('#formmasterkesling').reset();
	});
	$("#carikesling").click(function(event){
		event.preventDefault();
		var from = $('#darikesling').val();
		var to = $('#sampaikesling').val();
		var pid = $('#idpkesling').val();
		var jeniskesling = $('#jeniskesling').val();
		window.open('<?=site_url().'report_bulanan/lapkesling_temp?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jeniskesling));
	});
})
</script>
<style>
/*.ui-datepicker-calendar {
    display: none;
    }*/
</style>
<div class="mycontent">
<div class="formtitle">Laporan Bulanan (kesling)</div>
	<form id="formmasterkesling">
		<div class="gridtitle">&nbsp;</div>		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Pilih Bulan</label>
						<input type="text" name="pilihbln" style="width:105px" readonly id="pilihkesling" value="<?=date('F Y');?>"/>
						<input type="text" style="display:none" name="dari" class="dari" id="darikesling" value="<?=date('m');?>" />
						<input type="text" style="display:none" name="sampai" class="sampai" id="sampaikesling" value="<?=date('Y');?>" />
						</span>
						<span>						
						<input type="submit" class="cari" value="&nbsp;Cetak Laporan&nbsp;" id="carikesling"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetkesling"/>
						<input type="hidden" name="idpkesling" id="idpkesling" value="<?=$this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas')?>" />
						<input type="hidden" name="jeniskesling" id="jeniskesling" value="<?=$this->session->userdata('group_id')=='kabupaten'?'rpt_kesling_kb':'rpt_kesling'?>" />
						</span>
		</fieldset>
	</form>
</div>