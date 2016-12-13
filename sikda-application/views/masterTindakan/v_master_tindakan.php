<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_tindakan.js"></script>

<div class="mycontent">
<div id="dialogtindakan" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Tindakan</div>
	<form id="formmastertindakan">
		<div class="gridtitle">Daftar Tindakan<span class="tambahdata" id="mastertindakanadd">Input Data </span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						
						
						<span>
						<label>Cari Tindakan</label>
                        <select name="keyword" id="keywordid">
							<option value="KD_PRODUK">Pilih Kategori</option>
							<option value="KD_PRODUK">Kode Produk</option>
							<option value="PRODUK">Produk</option>
						</select>
                                                Cari
						
						<input type="text" name="cari" class="cari" id="carinamamastertindakan"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimastertindakan"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmastertindakan"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listtindakan"></table>
		<div id="pagermastertindakan"></div>
		</div >
	</form>
</div>