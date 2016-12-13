<script>
$('document').ready(function(){		
	$('#from').datepicker({
			  changeMonth: true,
			  changeYear: true,
			  showButtonPanel: true,
			  dateFormat: 'MM-yy'
		  }).focus(function() {
			  var thisCalendar = $(this);
			  $('.ui-datepicker-calendar').detach();
			  $('.ui-datepicker-close').click(function() {
			  var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
			  var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
			  thisCalendar.datepicker('setDate', new Date(year, month, 1));
		  });
	 });
	 
	 $('#to').datepicker({
			  changeMonth: true,
			  changeYear: true,
			  showButtonPanel: true,
			  dateFormat: 'MM-yy'
		  }).focus(function() {
			  var thisCalendar = $(this);
			  $('.ui-datepicker-calendar').detach();
			  $('.ui-datepicker-close').click(function() {
			  var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
			  var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
			  thisCalendar.datepicker('setDate', new Date(year, month, 1));
		  });
	 });
	
	$("#resethrj").click(function(event){
		event.preventDefault();
		$('#formmasterhrj').reset();
	});
	/* $("#carihrj").click(function(event){
		event.preventDefault();
		var from = $('#darihrj').val();
		var to = $('#sampaihrj').val();
		var pid = $('#idphrj').val();
		var jenislk = $('#jenislk').val();
		window.open('<?=site_url().'sikda_reports/report.php?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jenislk));
	});
	$("#excelhrj").click(function(event){
		event.preventDefault();
		var rc = $('#rc').val();
		var from = $('#darihrj').val();
		var to = $('#sampaihrj').val();
		var pid = $('#idphrj').val();
		var jenislk = $('#jenislk').val();
		window.open('<?=base_url().'report_harian/harian_diagnosa_excel_kab?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jenislk)+'&rc='+decodeURIComponent(rc));
	}); */
	
	$("#htmlhrj").click(function(event){
		event.preventDefault();
		var propinsi = $('#provinsit_pendaftaranadd').val();
		var kabupaten = $('#kabupaten_kotat_pendaftaranadd').val();
		var kecamatan = $('#kecamatant_pendaftaranadd').val();
		var puskesmas = $('#puskesmast_pendaftaranadd').val();
		var from = $('#from').val();
		var to = $('#to').val();
		
		var url = '';
		var idtab = $('.mycontent').parent().attr('id');
		achtungShowLoader();	
		url = '<?=site_url().'report_ppjk/sepuluhbesarrjrw?jenispt=html&from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&propinsi='+decodeURIComponent(propinsi)+'&kabupaten='+decodeURIComponent(kabupaten)+'&kecamatan='+decodeURIComponent(kecamatan)+'&puskesmas='+decodeURIComponent(puskesmas);
		$("#"+idtab+" #divLap","#tabs ").load(url);
		
		$.achtung({message: 'Proses Tampil Data Berhasil', timeout:5});
		achtungHideLoader();
		
		//window.open('<?=base_url().'Report_ppjk/sepuluhbesarkab_html?from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&pid='+decodeURIComponent(pid)+'&jenis='+decodeURIComponent(jenislk)+'&rc='+decodeURIComponent(rc));
	});
	
	$("#exceljmksms").click(function(event){
		event.preventDefault();
		var propinsi = $('#provinsit_pendaftaranadd').val();
		var kabupaten = $('#kabupaten_kotat_pendaftaranadd').val();
		var kecamatan = $('#kecamatant_pendaftaranadd').val();
		var puskesmas = $('#puskesmast_pendaftaranadd').val();
		var from = $('#from').val();
		var to = $('#to').val();
		
		var url = '';
		achtungShowLoader();			
		
		window.open('<?=site_url().'report_ppjk/sepuluhbesarrjrw?jenispt=excel&from='?>'+decodeURIComponent(from)+'&to='+decodeURIComponent(to)+'&propinsi='+decodeURIComponent(propinsi)+'&kabupaten='+decodeURIComponent(kabupaten)+'&kecamatan='+decodeURIComponent(kecamatan)+'&puskesmas='+decodeURIComponent(puskesmas));
				
		$.achtung({message: 'Proses Tampil Data Berhasil', timeout:5});
		achtungHideLoader();
	});
	
	$("#kabupaten_kotat_pendaftaranadd").remoteChained("#provinsit_pendaftaranadd", "<?=site_url('t_masters/getKabupatenByProvinceId')?>");
	$("#kecamatant_pendaftaranadd").remoteChained("#kabupaten_kotat_pendaftaranadd", "<?=site_url('t_masters/getKecamatanByKabupatenId')?>");
	$("#puskesmast_pendaftaranadd").remoteChained("#kecamatant_pendaftaranadd", "<?=site_url('t_masters/getPuskesmasByKecamatanId')?>");
})
</script>
<style>
/*.ui-datepicker-calendar {
    display: none;
    }*/
#formmasterhrj fieldset{
	margin:0 13px 0 13px; 
}
</style>
<div class="mycontent">
<div class="formtitle">Laporan 10 Penyakit Terbanyak Rawat Jalan Dan Rawat Inap</div>
	<form id="formmasterhrj">
		<div class="gridtitle">&nbsp;</div>		
		<fieldset>
			<?=getComboProvinsi($this->session->userdata('kd_provinsi'),'provinsi','provinsit_pendaftaranadd','','inline')?>
			<span>
			<label>Kab/Kota</label>
				<select name="kabupaten_kota" id="kabupaten_kotat_pendaftaranadd">
					<option value="">--</option>
				</select>
			</span>
		</fieldset>
		<fieldset>
			<span>
			<label>Kecamatan</label>
				<select name="kecamatan" id="kecamatant_pendaftaranadd">
					<option value="">--</option>
				</select>
			</span>
			<span>
			<label>Puskesmas</label>
				<select name="desa_kelurahan" id="puskesmast_pendaftaranadd">
					<option value="">--</option>
				</select>
			</span>
		</fieldset>
		<fieldset>
			<span>
				<label>Dari</label>
				<input type="text" name="from" class="dari" id="from" value="<?=date('F-Y')?>" /> Sampai 
				<input type="text" name="to" class="sampai" id="to" value="<?=date('F-Y')?>" />
			</span>
			<span>						
				<input type="submit" class="excel" value="&nbsp;Download&nbsp;" id="exceljmksms"/>
				<input type="submit" class="html" value="&nbsp;Submit&nbsp;" id="htmlhrj"/>
				<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetjmksms"/>
				<input type="hidden" name="idphrj" id="idphrj" value="<?=$this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas')?>" />
				<input type="hidden" name="jenislk" id="jenislk" value="<?=$this->session->userdata('group_id')=='kabupaten'?'rpt_hrj_kb':'rpt_hrj'?>" />
			</span>
		</fieldset>
		
	</form>
	<div id="divLap"></div>
</div>