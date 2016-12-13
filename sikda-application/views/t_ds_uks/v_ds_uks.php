<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_ds_uks.js"></script>

<div class="mycontent">
<div id="dialogds_uks" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Data UKS</div>
	<form id="formds_uks">
		<div class="gridtitle">Daftar UKS<span class="tambahdata" id="ds_uksadd">Input Data UKS</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
			<span>
			<label>Cari Nama Puskesmas</label>
			<input type="text" name="carinama" id="carinamads_uks"/>
			&nbsp;Tahun:&nbsp;
			<select name="crtahun_uks" class="dari">
				<?php 
				$startyear = date('Y')-15;
				for($i=1;$i<=30;$i++){?>
				<option value="<?=$startyear+$i?>" <?=$startyear+$i==date('Y')?'selected':''?> ><?=$startyear+$i?></option>
				<?php } ?>
			</select>						
			<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carids_uks"/>
			<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetds_uks"/>
			</span>						
		</fieldset>
		
		<div class="paddinggrid">
		<table id="listds_uks"></table>
		<div id="pagerds_uks"></div>
		</div >
	</form>
</div>