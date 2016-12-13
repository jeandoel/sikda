<script type="text/javascript" src="<?=base_url()?>assets/customjs/map_gigi_permukaan.js"></script>
<style type="text/css">
.ui-jqgrid tr.jqgrow td {vertical-align:middle !important}
</style>

<div class="mycontent">
<div id="dialog_map_gigi" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Gambar Permukaan Gigi</div>
	<form id="form_map_gigi">
		<div class="gridtitle">Daftar Gambar Permukaan Gigi<span class="tambahdata" id="_map_gigiadd">Input Gambar Permukaan Gigi</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Cari Kode Permukaan Gigi</label>
						<input type="text" name="c_map_modvl" class="c_map_modvl" id="c_map_modvl"/>
						<label>Cari Kode Status</label>
						<input type="text" name="c_map_kd_status" class="c_map_kd_status" id="c_map_kd_status" style="margin-top:5px;"/>
						<label>Cari Status</label>
						<input type="text" name="c_map_status" class="c_map_status" id="c_map_status" style="margin-top:5px;"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="cari_map_gigi"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="reset_map_gigi"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="list_map_gigi"></table>
		<div id="pager_map_gigi"></div>
		</div >
	</form>
</div>