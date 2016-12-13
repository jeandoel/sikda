<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_kasir.js"></script>

<div class="mycontent">
<div id="dialogagama" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Kasir</div>
	<form id="formtkasir">
		<div class="gridtitle">Daftar Transaksi</div>
		<fieldset class="fieldsetpencarian" id="fieldset_t_gudang_pasien">
			<span>
				<label>Pencarian Berdasarkan</label>
				<select id="keywordid" name="keyword">
					<option value="">--Cari Berdasarkan--</option>
					<option value="KD_PEL_KASIR">Kode Transaksi</option>
					<option value="KD_PASIEN">Rekam Medis</option>
					<option value="NAMA_LENGKAP">Nama Lengkap</option>
				</select>
				<input type="text" name="cari" id="carikasir"/>
			</span>
		</fieldset>
		<fieldset style="margin:0 13px 0 13px ">
					<span>
					<label>Status</label>
					<select name="status" id="statusidx">
						<option value="">--Semua--</option>
						<option value="OPEN">Open</option>
						<option value="CLOSED">Closed</option>
					</select>
					</span>
						<span>
				<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="caritkasir" />
				<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resettkasir"/>
						</span>	
					</fieldset>
	<div class="paddinggrid">
		<table id="listtkasir"></table>
		<div id="pagertkasir"></div>
		</div >


	
</div >