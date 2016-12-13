<script type="text/javascript" src="<?=base_url()?>assets/customjs/transaksi_wilayah.js"></script>

<div class="mycontent">
<div id="dialogtranswilayah" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Wilayah</div>
	<form id="formtranswilayah">
		<div class="gridtitle">Daftar Wilayah<span class="tambahdata" id="transwilayahadd">Input Wilayah</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Tanggal Input (dd-mm-yyyy)</label>
						<input type="text" name="dari" class="dari" id="daritranswilayah"/>
						sampai
						<input type="text" name="sampai" class="sampai" id="sampaitranswilayah"/>
						</span>
						<span>
						<label>Cari Berdasarkan</label>
						<select name="keyword" id="wilayahkeyword">
							<option value="nnama_kecamatan">Nama Kecamatan</option>
							<option value="nnama_desa">Nama Desa</option>
						</select>
						<input type="text" name="carinama" id="carinamatranswilayah"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="caritranswilayah"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resettranswilayah"/>
						</span>
		</fieldset>
		
		<div class="paddinggrid">
		<table id="listtranswilayah"></table>
		<div id="pagertranswilayah"></div>
		</div >
	</form>
</div>