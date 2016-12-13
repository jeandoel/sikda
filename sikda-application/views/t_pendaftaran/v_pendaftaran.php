<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_pendaftaran.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#cetaklap_poli').click(function(){
			var pid = $('#pid').val();
			var tgl = $('#tanggalt_pendaftaran').val();
			window.open('<?=site_url().'report_harian/lap_poli?&pid='?>'+decodeURIComponent(pid)+'&tgl='+decodeURIComponent(tgl));
		});
		$('#cetaklap_diagnosa').click(function(){
			var pid = $('#pid').val();
			var tgl = $('#tanggalt_pendaftaran').val();
			window.open('<?=site_url().'report_harian/lap_diagnosa?&pid='?>'+decodeURIComponent(pid)+'&tgl='+decodeURIComponent(tgl));
		});
	})
</script>

<div class="mycontent">
<div id="dialogt_pendaftaran" class="dialog" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Pendaftaran</div>
	<form id="formt_pendaftaran">
		<div class="gridtitle_t">&nbsp;<span id="t_pendaftaranadd"><span class="tambahdata_t"></span>Pendaftaran Baru</span></div>		
		<fieldset class="fieldsetpencarian" id="fieldset_t_pendaftaran_pasien">
			<span>
				<label>Pencarian Berdasarkan</label>
				<select id="keywordt_pendaftaran" name="keywordt_pendaftaran">
					<option value="NAMA_LENGKAP">Nama Pasien</option>
					<option value="SHORT_KD_PASIEN">Rekam Medis</option>
					<option value="NO_KK">No Kartu Keluarga</option>
					<option value="NO_PENGENAL">NIK</option>
					<option value="KK">Kepala Keluarga</option>
					<option value="TEMPAT_LAHIR">Tempat Lahir</option>
					<option value="ALAMAT">Alamat</option>
				</select>
				<input type="text" name="carit_pendaftaran" id="carit_pendaftaran"/>
			</span>
		</fieldset>
					
		<fieldset  class="fieldsetpencarian" style="display:none" id="fieldset_t_pendaftaran_antrian">
			<?=getComboPoliklinik2('','poliklinik','poliklinikt_pendaftaran','','inline')?>
			<span>
				<label class="mydate">Status</label>
				<select name="status_pelayanan" id="status_pelayanant_pendaftaran">
					<option value="">Semua</option>
					<option value="SUDAH DILAYANI">Sudah Dilayani</option>
					<option value="BELUM DILAYANI">Belum Dilayani</option>
				</select>
			</span>
			<span>
				<label>Jenis Pelayanan</label>
				<select name="jenis_pelayanan" id="jenis_pelayanant_pendaftaran">
					<option value="2">Pelayanan Rawat Jalan</option>
					<option value="1">Pelayanan Rawat Inap</option>
				</select>
			</span>
			<span>
				<label class="mydate">Tanggal</label>				
				<input type="text" name="tanggal" class="dari" id="tanggalt_pendaftaran" value="<?=date('d/m/Y')?>" />
			</span>
		</fieldset>
		
		<fieldset class="fieldsetpencarian">	
			<span>
				<label>&nbsp;</label>
				<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carit_pendaftaran2" />
				<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resett_pendaftaran"/>
				<input type="hidden" name="pid" id="pid" value="<?=$this->session->userdata('group_id')=='kabupaten'?$this->session->userdata('kd_kabupaten'):$this->session->userdata('kd_puskesmas')?>" />
				<input type="button" value="Cetak Laporan POLI" id="cetaklap_poli"/>
				<input type="button" value="Cetak Laporan Diagnosa" id="cetaklap_diagnosa"/>
			</span>	
		</fieldset>
		
		<div class="topgridradio">
		<span>
			<input type="radio" name="tampilan_data_pendaftaran" value="antrian_pasien" checked />Pasien
			<input type="radio" name="tampilan_data_pendaftaran" value="antrian_kunjungan" />Antrian Kunjungan
		</span>	</div>
		<div class="paddinggrid" id="pendaftaran_grid_pasien">
		<table id="listt_pendaftaran"></table>
		<div id="pagert_pendaftaran"></div>		
		</div >
		<div class="paddinggrid" id="pendaftaran_grid_antrian" style="display:none">
		<table id="listt_pendaftaranantrian"></table>
		<div id="pagert_pendaftarananantrian"></div>
		</div >
	</form>
</div>
<!--

<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.maskedinput.js"></script>

$("#form-login").validate({
		rules: {
			username: {
				date:true,
				required: true
			},
			password:{
				required:true
			},
		},
		messages: {
			name: {
				date: "Silahkan Masukkan Tanggal Sesuai Format",
				required:"Silahkan Lengkapi Field"
			},
			password:{
				required:"Silahkan Lengkapi Field"
			},
		}
	});
$("#name").mask("99/99/9999");	


$(document).ready(function() {
$('input:text:first').focus();
    
$('input:text').bind("keydown", function(e) {
   var n = $("input:text").length;
   if (e.which == 13) 
   { //Enter key
     e.preventDefault(); //to skip default behavior of the enter key
     var nextIndex = $('input:text').index(this) + 1;
     if(nextIndex < n)
       $('input:text')[nextIndex].focus();
     else
     {
       $('input:text')[nextIndex-1].blur();
       $('#btnSubmit').click();
     }
   }
});

$('#btnSubmit').click(function() {
    alert('Form Submitted');
});
});
	-->