<script>
$('document').ready(function(){
	$('#pilihimun').datepicker({
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
        $('#dariimun').datepicker('setDate', firstdate);
        $('#sampaiimun').datepicker('setDate', lastdate);
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
        $('#dariimun').datepicker('setDate', firstdate);
        $('#sampaiimun').datepicker('setDate', lastdate);
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
	
	$('#dariimun').datepicker({dateFormat: "mm"});
	$('#sampaiimun').datepicker({dateFormat: "yy"});
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	
	$("#resetimun").click(function(event){
		event.preventDefault();
		$('#formmasterimun').reset();
	});
	$("#cariimun").click(function(event){
		event.preventDefault();
		var from = $('#dariimun').val();
		var to = $('#sampaiimun').val();
		var pid = $('#idpimun').val();
		var jenisimun = $('#jenisimun').val();
		window.open('<?=site_url().'report_bulanan/lapimunisasi_temp?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jenisimun));
	});
	$("#exportimun").click(function(event){
		event.preventDefault();
		var from = $('#dariimun').val();
		var to = $('#sampaiimun').val();
		var pid = $('#idpimun').val();
		var jenisimun = $('#jenisimun').val();
		window.open('<?=site_url().'report_bulanan/lapimunisasi_temp_excel?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jenisimun));
	});
})
</script>
<style>
/*.ui-datepicker-calendar {
    display: none;
    }*/
</style>
<div class="mycontent">
<div class="formtitle">Laporan Bulanan Imunisasi</div>
	<form id="formmasterimun">
		<div class="gridtitle">&nbsp;</div>		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Pilih Bulan</label>
						<input type="text" name="pilihbln" style="width:105px" readonly id="pilihimun" value="<?=date('F Y');?>"/>
						<input type="hidden" name="dari" class="dari" id="dariimun" value="<?=date('m');?>" />
						<input type="hidden" name="sampai" class="sampai" id="sampaiimun" value="<?=date('Y');?>" />
						</span>
						<span>	
						<input type="submit" class="cari" value="&nbsp;Lihat Laporan&nbsp;" id="cariimun"/>
						<input type="submit" class="cari" value="&nbsp;Export Laporan&nbsp;" id="exportimun"/>						
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetimun"/>
						<input type="hidden" name="idpimun" id="idpimun" value="<?=$this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas')?>" />
						<input type="hidden" name="jenisimun" id="jenisimun" value="<?=$this->session->userdata('group_id')=='kabupaten'?'rpt_imun':'rpt_imun'?>" />
						</span>
		</fieldset>
	</form>
</div>