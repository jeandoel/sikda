<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_kunjungan_nifas.js"></script>

<div class="mycontent">
<div id="dialog" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Transaksi Kunjungan Nifas</div>
	<form id="formt_kunjungan_nifas">
		<div class="gridtitle">Kunjungan Nifas<span class="tambahdata" id="t_kunjungan_nifasadd">Tambah data</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Kode Kunjungan Nifas</label>
						<input type="text" name="kode" class="kode" id="kodet_kunjungan_nifas"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carit_kunjungan_nifas"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resett_kunjungan_nifas"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listt_kunjungan_nifas"></table>
		<div id="pagert_kunjungan_nifas"></div>
		</div >
	</form>
</div>