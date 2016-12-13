<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_kategori_imunisasi.js"></script>

<div class="mycontent">
<div id="dialogkategoriimunisasi_new" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Kategori Imunisasi</div>
	<form id="formmaster_kategori_imunisasi">
		<div class="gridtitle">Daftar Kategori Imunisasi<span class="tambahdata" id="master_kategori_imunisasi_add">Input Kategori Imunisasi</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Cari Kategori Imunisasi</label>
						<input type="text" name="kodekategoriimunisasi" class="kodekategoriimunisasi" id="kategoriimunisasi"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimaster_kategori_imunisasi"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmaster_kategori_imunisasi"/>
						</span>	
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listmaster_kategori_imunisasi"></table>
		<div id="pagermaster_kategori_imunisasi"></div>
		</div >
	</form>
</div>
