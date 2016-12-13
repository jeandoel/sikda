<script>
$('document').ready(function(){
	$('#pilihkematianibu').datepicker({
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
        $('#darikematianibu').datepicker('setDate', firstdate);
        $('#sampaikematianibu').datepicker('setDate', lastdate);
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
        $('#darikematianibu').datepicker('setDate', firstdate);
        $('#sampaikematianibu').datepicker('setDate', lastdate);
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
	
	$('#darikematianibu').datepicker({dateFormat: "mm"});
	$('#sampaikematianibu').datepicker({dateFormat: "yy"});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	
	$("#resetkematianibu").click(function(event){
		event.preventDefault();
		$('#formmasterkematianibu').reset();
	});
	$("#carikematianibu").click(function(event){
		event.preventDefault();
		var from = $('#darikematianibu').val();
		var to = $('#sampaikematianibu').val();
		var pid = $('#idpkematianibu').val();
		var jeniskematianibu = $('#jeniskematianibu').val();
		window.open('<?=site_url().'report_bulanan/lap_kematian_ibu_temp?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jeniskematianibu));
	});
	
	$("#carikematianibuexcel").click(function(event){
		event.preventDefault();
		var from = $('#darikematianibu').val();
		var to = $('#sampaikematianibu').val();
		var pid = $('#idpkematianibu').val();
		var jeniskematianibu = $('#jeniskematianibu').val();
		window.open('<?=site_url().'report_bulanan/lap_kematian_ibu_temp_excel?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jeniskematianibu));
	});
})
</script>
<style>
/*.ui-datepicker-calendar {
    display: none;
    }*/
</style>
<div class="mycontent">
<div class="formtitle">Laporan Bulanan (Kematian Ibu)</div>
	<form id="formmasterkematianibu">
		<div class="gridtitle">&nbsp;</div>		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Pilih Bulan</label>
						<input type="text" name="pilihbln" style="width:105px" readonly id="pilihkematianibu" value="<?=date('F Y');?>"/>
						<input type="text" style="display:none" name="dari" class="dari" id="darikematianibu" value="<?=date('m');?>" />
						<input type="text" style="display:none" name="sampai" class="sampai" id="sampaikematianibu" value="<?=date('Y');?>" />
						</span>
						<span>						
						<input type="submit" class="cari" value="&nbsp;Cetak Laporan&nbsp;" id="carikematianibu"/>
						<input type="submit" class="cari" value="&nbsp;Export&nbsp;" id="carikematianibuexcel"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetkematianibu"/>
						<input type="hidden" name="idpkematianibu" id="idpkematianibu" value="<?=$this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas')?>" />
						<input type="hidden" name="jeniskematianibu" id="jeniskematianibu" value="<?=$this->session->userdata('group_id')=='kabupaten'?'rpt_kematianibu_kb':'rpt_kematianibu'?>" />
						</span>
		</fieldset>
	</form>
</div>