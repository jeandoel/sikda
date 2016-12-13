<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_kel_pasien.js"></script>

<div class="mycontent">
<div id="dialogkelpasien" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Kelompok Pasien</div>
	<form id="formmkelpasien">
		<div class="gridtitle">Daftar Kelompok Pasien<span class="tambahdata" id="kelpasienadd">Input Kelompok Pasien</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Customer/Kelompok Pasien</label>
						<input type="text" name="nama" class="nama" id="namakelpasien"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carikelpasien"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetkelpasien"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listkelpasien"></table>
		<div id="pagerkelpasien"></div>
		</div >
	</form>
</div>