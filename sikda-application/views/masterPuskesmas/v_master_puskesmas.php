<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_puskesmas.js"></script>

<div class="mycontent">
<div id="dialogpuskesmas" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Puskesmas</div>
	<form id="formpuskesmas">
		<div class="gridtitle">Daftar Puskesmas<span class="tambahdata" id="masterpuskesmasadd">Input Puskesmas</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Cari Kode Puskesmas</label>
						<input type="text" name="idkodepuskesmas" class="idkodepuskesmas" id="idkodepuskesmas"/>
						<label>Cari Puskesmas</label>
						<input type="text" name="nama" class="nama" id="namapuskesmas" style="margin-top:6px" />
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="caripuskesmas" />
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetpuskesmas" />
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listpuskesmas"></table>
		<div id="pagerpuskesmas"></div>
		</div >
	</form>
</div>