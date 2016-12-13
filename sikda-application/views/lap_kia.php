<script>
$('document').ready(function(){
	$('#pilihkia').datepicker({
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
        $('#darikia').datepicker('setDate', firstdate);
        $('#sampaikia').datepicker('setDate', lastdate);
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
        $('#darikia').datepicker('setDate', firstdate);
        $('#sampaikia').datepicker('setDate', lastdate);
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
	
	$('#darikia').datepicker({dateFormat: "mm"});
	$('#sampaikia').datepicker({dateFormat: "yy"});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	
	$("#resetkia").click(function(event){
		event.preventDefault();
		$('#formmasterkia').reset();
	});
	$("#carikia").click(function(event){
		event.preventDefault();
		var from = $('#darikia').val();
		var to = $('#sampaikia').val();
		var pid = $('#idpkia').val();
		var jeniskia = $('#jeniskia').val();
		window.open('<?=site_url().'report_bulanan/lapkia_temp?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jeniskia));
	});
})
</script>
<style>
/*.ui-datepicker-calendar {
    display: none;
    }*/
</style>
<div class="mycontent">
<div class="formtitle">Laporan Bulanan (kia)</div>
	<form id="formmasterkia">
		<div class="gridtitle">&nbsp;</div>		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Pilih Bulan</label>
						<input type="text" name="pilihbln" style="width:105px" readonly id="pilihkia" value="<?=date('F Y');?>"/>
						<input type="text" style="display:none" name="dari" class="dari" id="darikia" value="<?=date('m');?>" />
						<input type="text" style="display:none" name="sampai" class="sampai" id="sampaikia" value="<?=date('Y');?>" />
						</span>
						<span>						
						<input type="submit" class="cari" value="&nbsp;Cetak Laporan&nbsp;" id="carikia"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetkia"/>
						<input type="hidden" name="idpkia" id="idpkia" value="<?=$this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas')?>" />
						<input type="hidden" name="jeniskia" id="jeniskia" value="<?=$this->session->userdata('group_id')=='kabupaten'?'rpt_kia_kb':'rpt_kia'?>" />
						</span>
		</fieldset>
	</form>
</div>