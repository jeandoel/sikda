<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_harga_obat.js"></script>

<div class="mycontent">
<div id="dialogmasterhargaobat" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Harga Obat</div>
	<form id="formmasterhargaobat">
		<div class="gridtitle">Daftar Harga Obat<span class="tambahdata" id="masterhargaobatadd">Input Harga Obat</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Tanggal Input (dd-mm-yyyy)</label>
						<input type="text" name="dari" class="dari" id="darimasterhargaobat"/>
						sampai
						<input type="text" name="sampai" class="sampai" id="sampaimasterhargaobat"/>
						</span>
						<span>
						<label>Cari Berdasarkan</label>
						<select name="keyword" id="keywordmasterhargaobat">
						<option VALUE="KD_TARIF">KODE TARIF</option>
						<option VALUE="NAMA_OBAT">NAMA OBAT</option>
						<option VALUE="KD_OBAT">KODE OBAT</option>
						<option VALUE="HARGA_BELI">HARGA BELI</option>
						<option VALUE="HARGA_JUAL">HARGA JUAL</option>
						<option VALUE="KD_MILIK_OBAT">KODE MILIK OBAT</option>
						</select>
						<input type="text" name="carinama" id="carinamamasterhargaobat"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimasterhargaobat"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmasterhargaobat"/>
						</span>
		</fieldset>
		
		<div class="paddinggrid">
		<table id="listmasterhargaobat"></table>
		<div id="pagermasterhargaobat"></div>
		</div >
	</form>
</div>
