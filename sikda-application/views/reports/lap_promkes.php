<script>
$('document').ready(function(){
	$('#pilihpromkes').datepicker({
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
        $('#daripromkes').datepicker('setDate', firstdate);
        $('#sampaipromkes').datepicker('setDate', lastdate);
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
        $('#daripromkes').datepicker('setDate', firstdate);
        $('#sampaipromkes').datepicker('setDate', lastdate);
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
	
	$('#daripromkes').datepicker({dateFormat: "mm"});
	$('#sampaipromkes').datepicker({dateFormat: "yy"});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	
	$("#resetpromkes").click(function(event){
		event.preventDefault();
		$('#formmasterpromkes').reset();
	});
	$("#caripromkes").click(function(event){
		event.preventDefault();
		var from = $('#daripromkes').val();
		var to = $('#sampaipromkes').val();
		var pid = $('#idppromkes').val();
		var jenispromkes = $('#jenispromkes').val();
		window.open('<?=site_url().'report_bulanan/lappromkes_temp?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jenispromkes));
	});
	$("#exportpromkes").click(function(event){
		event.preventDefault();
		var from = $('#daripromkes').val();
		var to = $('#sampaipromkes').val();
		var pid = $('#idppromkes').val();
		var jenispromkes = $('#jenispromkes').val();
		window.open('<?=site_url().'report_bulanan/lappromkes_temp_excel?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jenispromkes));
	});
})
</script>
<style>
/*.ui-datepicker-calendar {
    display: none;
    }*/
</style>
<div class="mycontent">
<div class="formtitle">Laporan Bulanan Promkes</div>
	<form id="formmasterpromkes">
		<div class="gridtitle">&nbsp;</div>		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Pilih Bulan</label>
						<input type="text" name="pilihbln" style="width:105px" readonly id="pilihpromkes" value="<?=date('F Y');?>"/>
						<input type="text" name="dari" class="dari" id="daripromkes" style="display:none" value="<?=date('m');?>" />
						<input type="text" name="sampai" class="sampai" id="sampaipromkes" style="display:none" value="<?=date('Y');?>" />
						</span>
						<span>						
						<input type="submit" class="cari" value="&nbsp;Lihat Laporan&nbsp;" id="caripromkes"/>
						<input type="submit" class="cari" value="&nbsp;Export Laporan&nbsp;" id="exportpromkes"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetpromkes"/>
						<input type="hidden" name="idppromkes" id="idppromkes" value="<?=$this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas')?>" />
						<input type="hidden" name="jenispromkes" id="jenispromkes" value="<?=$this->session->userdata('group_id')=='kabupaten'?'rpt_promkes_kb':'rpt_promkes'?>" />
						</span>
		</fieldset>
	</form>
</div>