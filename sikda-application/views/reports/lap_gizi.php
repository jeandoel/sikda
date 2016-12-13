<script>
$('document').ready(function(){
	$('#pilihgizi').datepicker({
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
        $('#darigizi').datepicker('setDate', firstdate);
        $('#sampaigizi').datepicker('setDate', lastdate);
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
        $('#darigizi').datepicker('setDate', firstdate);
        $('#sampaigizi').datepicker('setDate', lastdate);
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
	
	$('#darigizi').datepicker({dateFormat: "mm"});
	$('#sampaigizi').datepicker({dateFormat: "yy"});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetgizi").click(function(event){
		event.preventDefault();
		$("#formmastergizi").reset();
	});
	
	$("#lihatgizi").click(function(event){
		event.preventDefault();
		var from = $('#darigizi').val();
		var to = $('#sampaigizi').val();
		var pid = $('#idpgizi').val();
		var jenisgizi = $('#jenisgizi').val();
		window.open('<?=site_url().'report_bulanan/lapgizi_lihat?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jenisgizi));
	});
	
	$("#carigizi").click(function(event){
		event.preventDefault();
		var from = $('#darigizi').val();
		var to = $('#sampaigizi').val();
		var pid = $('#idpgizi').val();
		var jenisgizi = $('#jenisgizi').val();
		window.open('<?=site_url().'report_bulanan/lapgizi_temp?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jenisgizi));
	});
	
})
</script>
<style>
/*.ui-datepicker-calendar {
    display: none;
    }*/
</style>
<div class="mycontent">
<div class="formtitle">Laporan Bulanan (Gizi)</div>
	<form id="formmastergizi">
		<div class="gridtitle">&nbsp;</div>		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Pilih Bulan</label>
						<input type="text" name="pilihbln" style="width:105px" readonly id="pilihgizi" value="<?=date('F Y');?>"/>
						<input type="text" name="dari" class="dari" id="darigizi" style="display:none" value="<?=date('m');?>" />
						<input type="text" name="sampai" class="sampai" id="sampaigizi" style="display:none" value="<?=date('Y');?>" />
						</span>
						<span>						
						<input type="submit" class="cari" value="&nbsp;Lihat Laporan&nbsp;" id="lihatgizi"/>
						<input type="submit" class="cari" value="&nbsp;Export Laporan&nbsp;" id="carigizi"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetgizi"/>
						<input type="hidden" name="idpgizi" id="idpgizi" value="<?=$this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas')?>" />
						<input type="hidden" name="jenisgizi" id="jenisgizi" value="<?=$this->session->userdata('group_id')=='kabupaten'?'rpt_gizi_kb':'rpt_gizi'?>" />
						</span>
		</fieldset>
	</form>
</div>