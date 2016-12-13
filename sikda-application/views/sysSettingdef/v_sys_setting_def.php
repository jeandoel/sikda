<script type="text/javascript" src="<?=base_url()?>assets/customjs/sys_setting_def.js"></script>

<div class="mycontent">
<div id="dialogsysSettingdef" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Setting Aplikasi</div>
	<form id="formsysSettingdef">
		<div class="gridtitle">Daftar Setting Profil Aplikasi<span class="tambahdata" id="sysSettingdefadd">Input Setting Profil Aplikasi</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Tanggal Input (dd-mm-yyyy)</label>
						<input type="text" name="dari" class="dari" id="darisysSettingdef"/>
						sampai
						<input type="text" name="sampai" class="sampai" id="sampaisysSettingdef"/>
						</span>
						<span>
						<label>Cari Berdasarkan</label>
						<select name="keyword" id="keywordsysSettingdef">
						<option VALUE="KD_SETTING">KD</option>
						<option VALUE="KD_PROV">KODE PROVINSI</option>
						<option VALUE="KD_KABKOTA">KODE KAB./KOTA</option>
						<option VALUE="KD_KEC">KODE KECAMATAN</option>
						<option VALUE="KD_PUSKESMAS">KODE PUSKESMAS</option>
						<option VALUE="NAMA_PUSKESMAS">NAMA PUSKESMAS</option>
						<option VALUE="NAMA_PIMPINAN">NAMA KEP. PUSKESMAS</option>
						<option VALUE="NIP">NIP</option>
						<option VALUE="ALAMAT">ALAMAT</option>
						<option VALUE="AGAMA">AGAMA</option>
						<option VALUE="LEVEL">LEVEL</option>
						<option VALUE="CARA_BAYAR">CARA BAYAR</option>
						<option VALUE="JENIS_PASIEN">JENIS PASIEN</option>
						<option VALUE="MARITAL">MARITAL</option>
						<option VALUE="PEKERJAAN">PEKERJAAN</option>
						<option VALUE="PENDIDIKAN">PENDIDIKAN</option>
						<option VALUE="POLI">POLI</option>
						<option VALUE="GENDER">GENDER</option>
						<option VALUE="SUKU">SUKU</option>
						<option VALUE="UNIT_PELAYANAN">UNIT PELAYANAN</option>
						<option VALUE="SERVER_KEMKES">SERVER KEMKES</option>
						<option VALUE="SERVER_DINKES_PROV">SERVER PROVINSI</option>
						<option VALUE="SERVER_DINKES_KABKOT">SERVER KAB./KOTA</option>
						</select>
						<input type="text" name="carinama" id="carinamasysSettingdef"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carisysSettingdef"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetsysSettingdef"/>
						</span>
		</fieldset>
		
		<div class="paddinggrid">
		<table id="listsysSettingdef"></table>
		<div id="pagersysSettingdef"></div>
		</div >
	</form>
</div>