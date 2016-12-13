<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_ds_gigi.js"></script>

<div class="mycontent">
<div id="dialogds_gigi" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Data Gigi</div>
	<form id="formds_gigi">
		<div class="gridtitle">Daftar Gigi<span class="tambahdata" id="ds_gigiadd">Input Data Gigi</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
			<span>
			<label>Cari Nama Puskesmas</label>
			<input type="text" name="carinama" id="carinamads_gigi"/>
			&nbsp;Tahun:&nbsp;
			<select name="crtahun" class="dari">
				<?php 
					$startyear = date('Y')-15;
					for($i=1;$i<=30;$i++){
				?>
					<option value="<?=$startyear+$i?>" <?=$startyear+$i==date('Y')?'selected':''?> ><?php echo $startyear+$i; ?></option>
				<?php } ?>
			</select>						
			<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carids_gigi"/>
			<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetds_gigi"/>
			</span>						
		</fieldset>
		
		<div class="paddinggrid">
		<table id="listds_gigi"></table>
		<div id="pagerds_gigi"></div>
		</div >
	</form>
</div>