<script type="text/javascript" src="<?=base_url()?>assets/customjs/mastervaksin.js"></script>

<div class="mycontent">
<div id="dialog" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Vaksin</div>
	<form id="formmastervaksin">
		<div class="gridtitle">Daftar Master Vaksin<span class="tambahdata" id="mastervaksinadd">Input Master Vaksin</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Tanggal Master Vaksin (dd-mm-yyyy)</label>
						<input type="text" name="dari" class="dari" id="darimastervaksin"/>
						sampai
						<input type="text" name="sampai" class="sampai" id="sampaimastervaksin"/>
						
						</span>
					</fieldset>
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Nama Vaksin</label>
						<input type="text" name="nama" class="nama" id="namamastervaksin"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimastervaksin"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmastervaksin"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listmastervaksin"></table>
		<div id="pagermastervaksin"></div>
		</div >
	</form>
</div>