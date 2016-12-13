<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_jenis_pasien.js"></script>

<div class="mycontent">
<div id="dialogjenispasien_new" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Jenis Pasien</div>
	<form id="formmaster_jenis_pasien">
		<div class="gridtitle">Daftar Jenis Pasien<span class="tambahdata" id="master_jenis_pasien_add">Input Jenis Pasien</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Cari Jenis Pasien</label>
						<input type="text" name="kodejenispasien" class="kodejenispasien" id="caripasien"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimaster_jenis_pasien"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmaster_jenis_pasien"/>
						</span>	
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listmaster_jenis_pasien"></table>
		<div id="pagermaster_jenis_pasien"></div>
		</div >
	</form>
</div>
