<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_ras.js"></script>

<div class="mycontent">
<div id="dialogras" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Ras</div>
	<form id="formmaster1">
		<div class="gridtitle">Daftar Ras<span class="tambahdata" id="v_master_ras_add">Input Ras</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Nama Ras</label>
						<input type="text" name="nama" class="nama" id="namaras"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="cariras"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetras"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listras"></table>
		<div id="pagerras"></div>
		</div >
	</form>
</div>