<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_asal_pasien.js"></script>

<div class="mycontent">
<div id="dialogmasterasalpasien_new" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Asal Pasien</div>
	<form id="formmasterasalpasien">
		<div class="gridtitle">Daftar Master Asal Pasien<span class="tambahdata" id="masterasalpasienadd">Input Master Asal Pasien</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Cari Asal Pasien</label>
						<input type="text" name="nama" class="nama" id="namamasterasalpasien"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimasterasalpasien"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmasterasalpasien"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listmasterasalpasien"></table>
		<div id="pagermasterasalpasien"></div>
		</div >
	</form>
</div>
