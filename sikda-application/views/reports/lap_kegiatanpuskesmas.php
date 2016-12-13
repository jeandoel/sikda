<script>
$('document').ready(function(){
	$('#pilihkegiatanpuskesmas').datepicker({
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
        $('#darikegiatanpuskesmas').datepicker('setDate', firstdate);
        $('#sampaikegiatanpuskesmas').datepicker('setDate', lastdate);
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
        $('#darikegiatanpuskesmas').datepicker('setDate', firstdate);
        $('#sampaikegiatanpuskesmas').datepicker('setDate', lastdate);
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
	
	$('#darikegiatanpuskesmas').datepicker({dateFormat: "mm"});
	$('#sampaikegiatanpuskesmas').datepicker({dateFormat: "yy"});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	
	$("#resetkegiatanpuskesmas").click(function(event){
		event.preventDefault();
		$('#formmasterkegiatanpuskesmas').reset();
	});
	
	$("#lihatkegiatanpuskesmas").click(function(event){
		event.preventDefault();
		var from = $('#darikegiatanpuskesmas').val();
		var to = $('#sampaikegiatanpuskesmas').val();
		var pid = $('#idpkegiatanpuskesmas').val();
		var jeniskegiatanpuskesmas = $('#jeniskegiatanpuskesmas').val();
		window.open('<?=site_url().'report_bulanan/lapkegiatanpuskesmas_lihat?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jeniskegiatanpuskesmas));
	});
	
	$("#carikegiatanpuskesmas").click(function(event){
		event.preventDefault();
		var from = $('#darikegiatanpuskesmas').val();
		var to = $('#sampaikegiatanpuskesmas').val();
		var pid = $('#idpkegiatanpuskesmas').val();
		var jeniskegiatanpuskesmas = $('#jeniskegiatanpuskesmas').val();
		window.open('<?=site_url().'report_bulanan/lapkegiatanpuskesmas_temp?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jeniskegiatanpuskesmas));
	});
})
</script>
<style>
/*.ui-datepicker-calendar {
    display: none;
    }*/
</style>
<div class="mycontent">
<div class="formtitle">Laporan Bulanan (Kegiatan Puskesmas)</div>
	<form id="formmasterkegiatanpuskesmas">
		<div class="gridtitle">&nbsp;</div>		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Pilih Bulan</label>
						<input type="text" name="pilihbln" style="width:105px" readonly id="pilihkegiatanpuskesmas" value="<?=date('F Y');?>"/>
						<input type="text" name="dari" class="dari" id="darikegiatanpuskesmas" style="display:none" value="<?=date('m');?>" />
						<input type="text" name="sampai" class="sampai" id="sampaikegiatanpuskesmas" style="display:none" value="<?=date('Y');?>" />
						</span>
						<span>						
						<input type="submit" class="cari" value="&nbsp;Lihat Laporan&nbsp;" id="lihatkegiatanpuskesmas"/>
						<input type="submit" class="cari" value="&nbsp;Export Laporan&nbsp;" id="carikegiatanpuskesmas"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetkegiatanpuskesmas"/>
						<input type="hidden" name="idpkegiatanpuskesmas" id="idpkegiatanpuskesmas" value="<?=$this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas')?>" />
						<input type="hidden" name="jeniskegiatanpuskesmas" id="jeniskegiatanpuskesmas" value="<?=$this->session->userdata('group_id')=='kabupaten'?'rpt_kegiatanpuskesmas_kb':'rpt_kegiatanpuskesmas'?>" />
						</span>
		</fieldset>
	</form>
</div>