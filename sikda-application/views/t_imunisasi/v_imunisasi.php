<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_imunisasi.js"></script>

<div class="mycontent">
<div id="dialogt_pendaftaran" class="dialog" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Daftar Imunisasi Luar Gedung</div>
	<form id="formt_pendaftaran">
		<div class="gridtitle">Daftar Trans Imunisasi<span class="tambahdata" id="v_t_imunisasi_add">Input Trans Imunisasi</span></div>		
		
		<fieldset class="fieldsetpencarian" id="fieldset_t_pendaftaran_pasien_imunisasi">
			<span>
				<label>Pencarian Berdasarkan</label>
				<select id="keywordt_pendaftaran" name="keywordt_pendaftaran">
					<option value="NAMA_LENGKAP">Nama Pasien</option>
					<option value="KD_PASIEN">Rekam Medis</option>
<!-- 					<option value="NO_KK">No Kartu Keluarga</option>
					<option value="NO_PENGENAL">NIK</option>
					<option value="KK">Kepala Keluarga</option> -->
					<option value="KD_JENIS_KELAMIN">Jenis Kelamin</option>
					<option value="ALAMAT">Alamat</option>
					<option value="TGL_LAHIR">Tanggal Lahir</option>
					<option value="NAMA_IBU">Nama Ibu</option>
				</select>
				<input type="text" name="carit_pendaftaran" id="carit_pendaftaran"/>
				<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carit_pendaftaran2" />
				<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resett_pendaftaran"/>
			</span>
		</fieldset>
<!-- 			<fieldset class="fieldsetpencarian" id="fieldset_t_pendaftaran_pasien_imunisasi">
			<span>
				<label>Tanggal</label>				
				<input type="text" name="tanggal" class="dari" id="tgl_imunisasi" value="<?=date('d/m/Y')?>" />
			</span>
			<span>
				<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carit_pendaftaran2" />
				<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resett_pendaftaran"/>
			</span>
			</fieldset> -->
			
<!-- 		<fieldset class="fieldsetpencarian">	
				
		</fieldset> -->
		
		<div class="topgridradio">
		<span>
			<input type="radio" name="tampilan_data_pendaftaran" value="antrian_pasien" checked />Pasien Imunisasi
			<input type="radio" name="tampilan_data_pendaftaran" value="antrian_pasien_kipi"  />Pasien KIPI
			<input type="radio" name="tampilan_data_pendaftaran" value="antrian_kunjungan" />Semua Pasien
		</span>	</div>
		<div class="paddinggrid" id="pendaftaran_grid_pasien_imunisasi">
		<table id="listt_pendaftaran_imunisasi"></table>
		<div id="pagert_pendaftaran_imunisasi"></div>		
		</div >
		<div class="paddinggrid" id="pendaftaran_grid_pasien_imunisasi_kipi" style="display:none">
		<table id="listt_pendaftaran_imunisasi_kipi"></table>
		<div id="pagert_pendaftaran_imunisasi_kipi"></div>		
		</div >
		<div class="paddinggrid" id="semua_pasien" style="display:none">
		<table id="listt_semuapasienimunisasi"></table>
		<div id="pagert_semuapasienimunisasi"></div>
		</div >
	</form>
</div>