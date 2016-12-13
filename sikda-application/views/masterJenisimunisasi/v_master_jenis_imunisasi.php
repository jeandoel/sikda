<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_jenis_imunisasi.js"></script>

<div class="mycontent">
<div id="dialogjenisimunisasi_new" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Jenis Imunisasi</div>
	<form id="formmaster_jenis_imunisasi">
		<div class="gridtitle">Daftar Jenis Imunisasi<span class="tambahdata" id="master_jenis_imunisasi_add">Input Jenis Imunisasi</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Cari Jenis Imunisasi</label>
						<input type="text" name="kodejenisimunisasi" class="kodejenisimunisasi" id="cariimunisasi"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimaster_jenis_imunisasi"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmaster_jenis_imunisasi"/>
						</span>	
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listmaster_jenis_imunisasi"></table>
		<div id="pagermaster_jenis_imunisasi"></div>
		</div >
	</form>
</div>
