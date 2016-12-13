<script>
$('document').ready(function(){
	$('#pilihukgs').datepicker({
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
        $('#dariukgs').datepicker('setDate', firstdate);
        $('#sampaiukgs').datepicker('setDate', lastdate);
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
        $('#dariukgs').datepicker('setDate', firstdate);
        $('#sampaiukgs').datepicker('setDate', lastdate);
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
	
	$('#dariukgs').datepicker({dateFormat: "mm"});
	$('#sampaiukgs').datepicker({dateFormat: "yy"});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	
	$("#resetukgs").click(function(event){
		event.preventDefault();
		$('#formmasterukgs').reset();
	});
	$("#cariukgs").click(function(event){
		event.preventDefault();
		var from = $('#dariukgs').val();
		var to = $('#sampaiukgs').val();
		var pid = $('#idpukgs').val();
		var jenisukgs = $('#jenisukgs').val();
		window.open('<?=site_url().'report_bulanan/lapukgs_temp?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jenisukgs));
	});
	$("#exportukgs").click(function(event){
		event.preventDefault();
		var from = $('#dariukgs').val();
		var to = $('#sampaiukgs').val();
		var pid = $('#idpukgs').val();
		var jenisukgs = $('#jenisukgs').val();
		window.open('<?=site_url().'report_bulanan/lapukgs_temp_excel?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jenisukgs));
	});
})
</script>
<style>
/*.ui-datepicker-calendar {
    display: none;
    }*/
</style>
<div class="mycontent">
<div class="formtitle">Laporan Bulanan UKGS</div>
	<form id="formmasterukgs">
		<div class="gridtitle">&nbsp;</div>		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Pilih Bulan</label>
						<input type="text" name="pilihbln" style="width:105px" readonly id="pilihukgs" value="<?=date('F Y');?>"/>
						<input type="text" name="dari" class="dari" id="dariukgs" style="display:none" value="<?=date('m');?>" />
						<input type="text" name="sampai" class="sampai" id="sampaiukgs" style="display:none" value="<?=date('Y');?>" />
						</span>
						<span>						
						<input type="submit" class="cari" value="&nbsp;Lihat Laporan&nbsp;" id="cariukgs"/>
						<input type="submit" class="cari" value="&nbsp;Export Laporan&nbsp;" id="exportukgs"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetukgs"/>
						<input type="hidden" name="idpukgs" id="idpukgs" value="<?=$this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas')?>" />
						<input type="hidden" name="jenisukgs" id="jenisukgs" value="<?=$this->session->userdata('group_id')=='kabupaten'?'rpt_ukgs_kb':'rpt_ukgs'?>" />
						</span>
		</fieldset>
	</form>
</div>