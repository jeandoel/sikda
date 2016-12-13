<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_ds_ukgs.js"></script>

<div class="mycontent">
<div id="dialogds_ukgs" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Data UKGS</div>
	<form id="formds_ukgs">
		<div class="gridtitle">Daftar Gigi<span class="tambahdata" id="ds_ukgsadd">Input Data UKGS</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
			<span>
			<label>Cari Nama Puskesmas</label>
			<input type="text" name="carinama" id="carinamads_ukgs"/>
			&nbsp;Tahun:&nbsp;
			<select name="crtahunukgs" class="dari">
				<?php 
				$startyear = date('Y')-15;
				for($i=1;$i<=30;$i++){?>
				<option value="<?=$startyear+$i?>" <?=$startyear+$i==date('Y')?'selected':''?> ><?=$startyear+$i?></option>
				<?php } ?>
			</select>						
			<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carids_ukgs"/>
			<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetds_ukgs"/>
			</span>						
		</fieldset>
		
		<div class="paddinggrid">
		<table id="listds_ukgs"></table>
		<div id="pagerds_ukgs"></div>
		</div >
	</form>
</div>