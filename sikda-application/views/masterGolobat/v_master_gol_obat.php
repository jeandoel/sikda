<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_gol_obat.js"></script>

<div class="mycontent">
<div id="dialogmastergolobat" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Golongan Obat</div>
	<form id="formmastergolobat">
		<div class="gridtitle">Daftar Golongan Obat<span class="tambahdata" id="mastergolobatadd">Input Golongan Obat</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Tanggal Input (dd-mm-yyyy)</label>
						<input type="text" name="dari" class="dari" id="darimastergolobat"/>
						sampai
						<input type="text" name="sampai" class="sampai" id="sampaimastergolobat"/>
						</span>
						<span>
						<label>Cari Berdasarkan</label>
						<select name="keyword" id="keywordmastergolobat">
						<option VALUE="KD_GOL_OBAT">KODE GOL. OBAT</option>
						<option VALUE="GOL_OBAT">GOLONGAN OBAT</option>
						</select>
						<input type="text" name="carinama" id="carinamamastergolobat"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimastergolobat"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmastergolobat"/>
						</span>
		</fieldset>
		
		<div class="paddinggrid">
		<table id="listmastergolobat"></table>
		<div id="pagermastergolobat"></div>
		</div >
	</form>
</div>