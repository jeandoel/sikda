<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_ds_kegiatanpuskesmas.js"></script>

<div class="mycontent">
<div id="dialogds_kegiatanpuskesmas" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Data Kegiatan Puskesmas</div>
	<form id="formds_kegiatanpuskesmas">
		<div class="gridtitle">Daftar Kegiatan Puskesmas<span class="tambahdata" id="ds_kegiatanpuskesmasadd">Input Data Kegiatan Puskesmas</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
			<span>
			<label>Cari Nama Puskesmas</label>
			<input type="text" name="carinama" id="carinamads_kegiatanpuskesmas"/>
			&nbsp;Tahun:&nbsp;
			<select name="crtahunkegiatanpuskesmas" class="dari">
				<?php 
				$startyear = date('Y')-15;
				for($i=1;$i<=30;$i++){?>
				<option value="<?=$startyear+$i?>" <?=$startyear+$i==date('Y')?'selected':''?> ><?=$startyear+$i?></option>
				<?php } ?>
			</select>						
			<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carids_kegiatanpuskesmas"/>
			<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetds_kegiatanpuskesmas"/>
			</span>						
		</fieldset>
		
		<div class="paddinggrid">
		<table id="listds_kegiatanpuskesmas"></table>
		<div id="pagerds_kegiatanpuskesmas"></div>
		</div >
	</form>
</div>