<script type="text/javascript" src="<?=base_url()?>assets/customjs/transaksi1.js"></script>

<div class="mycontent">
<div id="dialogtransaksi1" class="dialog" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Transaksi Satu</div>
	<form id="formtransaksi1">
		<div class="gridtitle">Daftar Transaksi1<span class="tambahdata" id="transaksi1add">Input Transaksi1</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Tanggal Transaksi1 (dd-mm-yyyy)</label>
						<input type="text" name="dari" class="dari" id="daritransaksi1"/>
						sampai
						<input type="text" name="sampai" class="sampai" id="sampaitransaksi1"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="caritransaksi1"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resettransaksi1"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listtransaksi1"></table>
		<div id="pagertransaksi1"></div>
		</div >
	</form>
</div>