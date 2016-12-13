<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_posyandu.js"></script>

<div class="mycontent">
<div id="dialogpsynd" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Data Posyandu</div>
	<form id="formpsynd">
		<div class="gridtitle">Daftar Posyandu<span class="tambahdata" id="psyndadd">Input Data Posyandu</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
			<span>
			<label>Tanggal Input (dd-mm-yyyy)</label>
			<input type="text" name="dari" class="dari" id="daripsynd"/>
			sampai
			<input type="text" name="sampai" class="sampai" id="sampaipsynd"/>
			</span>						
		</fieldset>
		<fieldset style="margin:0 13px 0 13px ">
			<span>
			<label>Cari Nama Posyandu</label>
			<input type="text" name="carinama" id="carinamapsynd"/>
			<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="caripsynd"/>
			<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetpsynd"/>
			</span>
		</fieldset>
		
		<div class="paddinggrid">
		<table id="listpsynd"></table>
		<div id="pagerpsynd"></div>
		</div >
	</form>
</div>