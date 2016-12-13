<script>
$('document').ready(function(){
	$('#pilihuks').datepicker({
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
        $('#dariuks').datepicker('setDate', firstdate);
        $('#sampaiuks').datepicker('setDate', lastdate);
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
        $('#dariuks').datepicker('setDate', firstdate);
        $('#sampaiuks').datepicker('setDate', lastdate);
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
	
	$('#dariuks').datepicker({dateFormat: "mm"});
	$('#sampaiuks').datepicker({dateFormat: "yy"});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	
	$("#resetuks").click(function(event){
		event.preventDefault();
		$('#formmasteruks').reset();
	});
	$("#cariuks").click(function(event){
		event.preventDefault();
		var from = $('#dariuks').val();
		var to = $('#sampaiuks').val();
		var pid = $('#idpuks').val();
		var jenisuks = $('#jenisuks').val();
		window.open('<?=site_url().'report_bulanan/lapuks_temp?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jenisuks));
	});
	
	$("#cariuks_excel").click(function(event){
		event.preventDefault();
		var from = $('#dariuks').val();
		var to = $('#sampaiuks').val();
		var pid = $('#idpuks').val();
		var jenisuks = $('#jenisuks').val();
		window.open('<?=site_url().'report_bulanan/lapuks_temp_excel?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jenisuks));
	});
})
</script>
<style>
/*.ui-datepicker-calendar {
    display: none;
    }*/
</style>
<div class="mycontent">
<div class="formtitle">Laporan UKS</div>
	<form id="formmasteruks">
		<div class="gridtitle">&nbsp;</div>		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Pilih Bulan</label>
						<input type="text" name="pilihbln" style="width:105px" readonly id="pilihuks" value="<?=date('F Y');?>"/>
						<input type="hidden" name="dari" class="dari" id="dariuks" value="<?=date('m');?>" />
						<input type="hidden" name="sampai" class="sampai" id="sampaiuks" value="<?=date('Y');?>" />
						</span>
						<span>						
						<input type="submit" class="cari" value="&nbsp;Cetak Laporan&nbsp;" id="cariuks"/>
						<input type="submit" class="cari" value="&nbsp;Export Laporan&nbsp;" id="cariuks_excel"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetuks"/>
						<input type="hidden" name="idpuks" id="idpuks" value="<?=$this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas')?>" />
						<input type="hidden" name="jenisuks" id="jenisuks" value="<?=$this->session->userdata('group_id')=='kabupaten'?'rpt_uks_kb':'rpt_uks'?>" />
						</span>
		</fieldset>
	</form>
</div>