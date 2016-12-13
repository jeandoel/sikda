<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_gol_darah.js"></script>

<div class="mycontent">
<div id="dialoggoldarah" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Golongan Darah</div>
	<form id="formmastergd">
		<div class="gridtitle">Daftar Gol Darah<span class="tambahdata" id="mastergdadd">Input Data Gol Darah</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						
						
						<span>
						<label>Cari Kode Gol Darah</label>
						
						<input type="text" name="gol_darah" class="cari" id="carigd"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimastergd"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmastergd"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listgoldarah"></table>
		<div id="pagermastergd"></div>
		</div >
	</form>
</div>