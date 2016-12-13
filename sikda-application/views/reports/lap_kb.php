<script>
$('document').ready(function(){
	$('#pilihkb').datepicker({
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
        $('#darikb').datepicker('setDate', firstdate);
        $('#sampaikb').datepicker('setDate', lastdate);
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
        $('#darikb').datepicker('setDate', firstdate);
        $('#sampaikb').datepicker('setDate', lastdate);
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
	
	$('#darikb').datepicker({dateFormat: "mm"});
	$('#sampaikb').datepicker({dateFormat: "yy"});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	
	$("#resetkb").click(function(event){
		event.preventDefault();
		$('#formmasterkb').reset();
	});
	$("#carikb").click(function(event){
		event.preventDefault();
		var from = $('#darikb').val();
		var to = $('#sampaikb').val();
		var pid = $('#idpkb').val();
		var jeniskb = $('#jeniskb').val();
		window.open('<?=site_url().'report_bulanan/lapkb_temp?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jeniskb));
	});
	$("#exportkb").click(function(event){
		event.preventDefault();
		var from = $('#darikb').val();
		var to = $('#sampaikb').val();
		var pid = $('#idpkb').val();
		var jeniskb = $('#jeniskb').val();
		window.open('<?=site_url().'report_bulanan/lapkb_temp_excel?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jeniskb));
	});
})
</script>
<style>
/*.ui-datepicker-calendar {
    display: none;
    }*/
</style>
<div class="mycontent">
<div class="formtitle">Laporan Bulanan KB</div>
	<form id="formmasterkb">
		<div class="gridtitle">&nbsp;</div>		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Pilih Bulan</label>
						<input type="text" name="pilihbln" style="width:105px" readonly id="pilihkb" value="<?=date('F Y');?>"/>
						<input type="hidden" name="dari" class="dari" id="darikb" value="<?=date('m');?>" />
						<input type="hidden" name="sampai" class="sampai" id="sampaikb" value="<?=date('Y');?>" />
						</span>
						<span>
						<input type="submit" class="cari" value="&nbsp;Lihat Laporan&nbsp;" id="carikb"/>
						<input type="submit" class="cari" value="&nbsp;Export Laporan&nbsp;" id="exportkb"/>						
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetkb"/>
						<input type="hidden" name="idpkb" id="idpkb" value="<?=$this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas')?>" />
						<input type="hidden" name="jeniskb" id="jeniskb" value="<?=$this->session->userdata('group_id')=='kabupaten'?'rpt_kb':'rpt_kb'?>" />
						</span>
		</fieldset>
	</form>
</div>
