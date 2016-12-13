<script type="text/javascript" src="<?=base_url()?>assets/customjs/sys_setting_def_dw.js"></script>

<div class="mycontent">
<div id="dialog_sys_setting_def_dw" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Setting Dalam Wilayah Kerja</div>
	<form id="form_sys_setting_def_dw">
		<div class="gridtitle">Daftar Wilayah Kerja<span class="tambahdata" id="sys_setting_def_dw_add">Input Wilayah Kerja</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Cari Berdasarkan</label>
						<select name="keyword" id="carikeyword">
							<option value="PUSKESMAS">Puskesmas</option>
							<option value="KELURAHAN">Kelurahan/Desa</option>
							<option value="KECAMATAN">Kecamatan</option>
							<option value="KABUPATEN">Kabupaten/Kota</option>
						</select>
						<input type="text" name="carinama" id="carikategori"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="cari_sys_setting_def_dw" />
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="reset_sys_setting_def_dw" />
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="list_sys_setting_def_dw"></table>
		<div id="pager_sys_setting_def_dw"></div>
		</div >
	</form>
</div>