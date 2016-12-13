<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_status_keluar_pasien.js"></script>

<div class="mycontent">
<div id="dialogkeluarpasien" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Keluar Pasien</div>
	<form id="formmasterkeluarpasien">
		<div class="gridtitle">Daftar Pasien Keluar<span class="tambahdata" id="masterkeluarpasienadd">Input Data Keluar Pasien</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						
						
						<span>
						<label>Cari Kode Pasien Keluar</label>
						
						<input type="text" name="pasien" class="cari" id="carinamamasterkeluarpasien"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimasterkeluarpasien"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmasterkeluarpasien"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listkeluarpasien"></table>
		<div id="pagermasterkeluarpasien"></div>
		</div >
	</form>
</div>