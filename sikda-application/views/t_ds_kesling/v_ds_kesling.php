<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_ds_kesling.js"></script>

<div class="mycontent">
<div id="dialogds_kesling" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Data Kesehatan Lingkungan</div>
	<form id="formds_kesling">
		<div class="gridtitle">Daftar Kesehatan Lingkungan<span class="tambahdata" id="ds_keslingadd">Input Data Kesehatan Lingkungan</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
			<span>
			<label>Cari Nama Puskesmas</label>
			<input type="text" name="carinama" id="carinamads_kesling"/>
			&nbsp;Tahun:&nbsp;
			<select name="crtahunkesling" class="dari">
				<?php 
				$startyear = date('Y')-15;
				for($i=1;$i<=30;$i++){?>
				<option value="<?=$startyear+$i?>" <?=$startyear+$i==date('Y')?'selected':''?> ><?=$startyear+$i?></option>
				<?php } ?>
			</select>						
			<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carids_kesling"/>
			<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetds_kesling"/>
			</span>						
		</fieldset>
		
		<div class="paddinggrid">
		<table id="listds_kesling"></table>
		<div id="pagerds_kesling"></div>
		</div >
	</form>
</div>