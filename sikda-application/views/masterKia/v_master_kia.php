<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_kia.js"></script>

<div class="mycontent">
<div id="dialogmasterKia" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Kia</div>
	<form id="formmasterKia">
		<div class="gridtitle">Daftar Kia<span class="tambahdata" id="masterKiaadd">Input Kia</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Tanggal Input (dd-mm-yyyy)</label>
						<input type="text" name="dari" class="dari" id="darimasterKia"/>
						sampai
						<input type="text" name="sampai" class="sampai" id="sampaimasterKia"/>
						</span>
						<span>
						<label>Cari Berdasarkan</label>
						<select name="keyword" id="keywordmasterKia">
						<option value="VARIABEL_ID">VARIABEL ID</option>
						<option value="FORMAT_XML">FORMAT XML</option>
						<option value="PARENT_ID">PARENT ID</option>
						<option value="VARIABEL_DATA">VARIABEL DATA</option>
						<option value="DEFINISI">DEFINISI</option>
						<option value="PILIHAN_VALUE">PILIHAN VALUE</option>
						<option value="IROW">I ROW</option>
						<option value="STATUS">STATUS</option>
						<option value="PELAYANAN_ULANG">PELAYANAN ULANG</option>
						</select>
						<input type="text" name="carinama" id="carinamamasterKia"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimasterKia"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmasterKia"/>
						</span>
		</fieldset>
		
		<div class="paddinggrid">
		<table id="listmasterKia"></table>
		<div id="pagermasterKia"></div>
		</div >
	</form>
</div>