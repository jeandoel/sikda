<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_pelayanan.js"></script>
<script type="text/javascript">
function message() {alert('Tidak ada data! Pasien belum melakukan pelayanan')};
</script>

<div class="mycontent">
<div id="dialogt_pelayanan" class="dialog" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div id="dialogt_pelayanancetaksk" class="dialog" style="color:red;font-size:.75em;display:none" title="Cetak Surat Keterangan Dokter" ></div>
<div class="formtitle">Pelayanan</div>
	<form id="formt_pelayanan">
		<div class="gridtitle_t">&nbsp;</div>					
		<fieldset  class="fieldsetpencarian" id="fieldset_t_pelayanan_antrian">
			<?=getComboPoliklinik2('','poliklinik','poliklinikt_pelayananantrian','','inline')?>
			<span>
				<label class="mydate">Status</label>
				<select name="status_pelayanan" id="status_pelayanant_pelayananantrian">
					<option value="">Semua</option>
					<option value="SUDAH DILAYANI">Sudah Dilayani</option>
					<option value="BELUM DILAYANI">Belum Dilayani</option>
				</select>
			</span>
			<span>
				<label>Jenis Pelayanan</label>
				<select name="jenis_pelayanan" id="jenis_pelayanant_pelayananantrian">
					<option value="2">Pelayanan Rawat Jalan</option>
					<option value="1">Pelayanan Rawat Inap</option>
				</select>
			</span>
			<span>
				<label class="mydate">Tanggal</label>				
				<input type="text" name="tanggal" class="dari" id="tanggalt_pelayananantrian" value="<?=date('d/m/Y')?>" />
			</span>
		</fieldset>
		<fieldset class="fieldsetpencarian" id="fieldset_t_pendaftaran_pasien">
			<span>
				<label>Pencarian Berdasarkan</label>
				<select id="get_key_pendaftaran" name="get_key_pendaftaran">
					<option value="NAMA_PASIEN">Nama Pasien</option>
					<option value="SHORT_KD_PASIEN">Rekam Medis</option>
					<option value="KK">No Kartu Keluarga</option>
					<option value="ALAMAT">Alamat</option>
					<option value="NAMA_UNIT">Nama Unit</option>
					<option value="KD_DOKTER">Nama Petugas</option>
					<option value="STATUS">Status Layanan</option>
				</select>
				<input type="text" name="get_cari_pendaftaran" id="get_cari_pendaftaran"/>
			</span>
		</fieldset>
		<fieldset class="fieldsetpencarian">	
			<span>
				<label>&nbsp;</label>
				<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carit_pelayanan" />
				<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resett_pelayanan"/>
			</span>	
		</fieldset>
		<div class="paddinggrid" id="pelayanan_grid_antrian">
		<table id="listt_pelayananantrian"></table>
		<div id="pagert_pelayanananantrian"></div>
		</div >
	</form>
</div>