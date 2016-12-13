<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_pendidikan_kesehatan.js"></script>

<div class="mycontent">
<div id="dialogpenkes_new" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Pendidikan Kesehatan</div>
	<form id="formmaster1">
		<div class="gridtitle">Daftar Pendidikan Kesehatan<span class="tambahdata" id="master_penkes_add">Input Pendidikan Kesehatan</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Nama Pendidikan</label>
						<input type="text" name="nama" class="nama" id="namapenkes"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="caripenkes"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetpenkes"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listpenkes"></table>
		<div id="pagerpenkes"></div>
		</div >
	</form>
</div>
