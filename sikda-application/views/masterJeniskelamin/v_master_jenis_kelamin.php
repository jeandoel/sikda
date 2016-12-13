<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_jenis_kelamin.js"></script>

<div class="mycontent">
<div id="dialog" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Jenis Kelamin</div>
	<form id="formmasterjk">
		<div class="gridtitle">Daftar Jenis Kelamin<span class="tambahdata" id="masterjkadd">Input Data Jenis Kelamin</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						
						
						<span>
						<label>Cari Kode Jenis Kelamin</label>
						
						<input type="text" name="jenis_kelamin" class="cari" id="carijk"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimasterjk"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmasterjk"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listmasterjk"></table>
		<div id="pagermasterjk"></div>
		</div >
	</form>
</div>