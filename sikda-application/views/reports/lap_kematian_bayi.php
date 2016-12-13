<script>
$('document').ready(function(){
	$('#pilihkematianbayi').datepicker({
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
        $('#darikematianbayi').datepicker('setDate', firstdate);
        $('#sampaikematianbayi').datepicker('setDate', lastdate);
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
        $('#darikematianbayi').datepicker('setDate', firstdate);
        $('#sampaikematianbayi').datepicker('setDate', lastdate);
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
	
	$('#darikematianbayi').datepicker({dateFormat: "mm"});
	$('#sampaikematianbayi').datepicker({dateFormat: "yy"});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	
	$("#resetkematianbayi").click(function(event){
		event.preventDefault();
		$('#formmasterkematianbayi').reset();
	});
	$("#carikematianbayi").click(function(event){
		event.preventDefault();
		var from = $('#darikematianbayi').val();
		var to = $('#sampaikematianbayi').val();
		var pid = $('#idpkematianbayi').val();
		var jeniskematianbayi = $('#jeniskematianbayi').val();
		window.open('<?=site_url().'report_bulanan/lap_kematian_bayi_temp?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jeniskematianbayi));
	});
	
	$("#carikematianbayiexcel").click(function(event){
		event.preventDefault();
		var from = $('#darikematianbayi').val();
		var to = $('#sampaikematianbayi').val();
		var pid = $('#idpkematianbayi').val();
		var jeniskematianbayi = $('#jeniskematianbayi').val();
		window.open('<?=site_url().'report_bulanan/lap_kematian_bayi_temp_excel?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jeniskematianbayi));
	});
})
</script>
<style>
/*.ui-datepicker-calendar {
    display: none;
    }*/
</style>
<div class="mycontent">
<div class="formtitle">Laporan Bulanan (Kematian Bayi)</div>
	<form id="formmasterkematianbayi">
		<div class="gridtitle">&nbsp;</div>		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Pilih Bulan</label>
						<input type="text" name="pilihbln" style="width:105px" readonly id="pilihkematianbayi" value="<?=date('F Y');?>"/>
						<input type="text" style="display:none" name="dari" class="dari" id="darikematianbayi" value="<?=date('m');?>" />
						<input type="text" style="display:none" name="sampai" class="sampai" id="sampaikematianbayi" value="<?=date('Y');?>" />
						</span>
						<span>						
						<input type="submit" class="cari" value="&nbsp;Cetak Laporan&nbsp;" id="carikematianbayi"/>
						<input type="submit" class="cari" value="&nbsp;Export&nbsp;" id="carikematianbayiexcel"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetkematianbayi"/>
						<input type="hidden" name="idpkematianbayi" id="idpkematianbayi" value="<?=$this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas')?>" />
						<input type="hidden" name="jeniskematianbayi" id="jeniskematianbayi" value="<?=$this->session->userdata('group_id')=='kabupaten'?'rpt_kematianbayi_kb':'rpt_kematianbayi'?>" />
						</span>
		</fieldset>
	</form>
</div>