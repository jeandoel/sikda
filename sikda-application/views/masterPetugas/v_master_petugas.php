<script type="text/javascript" src="<?=base_url()?>assets/customjs/petugas.js"></script>

<div class="mycontent">
<div id="dialogpetugas_new" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Petugas</div>
	<form id="form">
		<div class="gridtitle">Daftar Petugas<span class="tambahdata" id="v_master_petugas_add">Input Petugas</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Nama Petugas</label>
						<input type="text" name="nama" class="nama" id="namapetugas"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="caripetugas"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetpetugas"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listpetugas"></table>
		<div id="pagerpetugas"></div>
		</div >
	</form>
</div>
