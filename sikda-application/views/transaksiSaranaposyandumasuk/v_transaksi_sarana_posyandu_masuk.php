<script type="text/javascript" src="<?=base_url()?>assets/customjs/transaksi_sarana_posyandu_masuk.js"></script>

<div class="mycontent">
<div id="dialogtransaksisaranaposyandumasuk" class="dialog" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Transaksi Sarana Posyandu Masuk</div>
	<form id="formtransaksisaranaposyandumasuk">
		<div class="gridtitle">Daftar Sarana Posyandu<span class="tambahdata" id="v_transaksi_sarana_posyandu_masuk_add">Input Transaksi</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Tanggal (dd-mm-yyyy)</label>
						<input type="text" name="dari" class="dari" id="daritransaksisaranaposyandumasuk"/>
						sampai
						<input type="text" name="sampai" class="sampai" id="sampaitransaksisaranaposyandumasuk"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="caritransaksisaranaposyandumasuk"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resettransaksisaranaposyandumasuk"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listtransaksisaranaposyandumasuk"></table>
		<div id="pagertransaksisaranaposyandumasuk"></div>
		</div >
	</form>
</div>