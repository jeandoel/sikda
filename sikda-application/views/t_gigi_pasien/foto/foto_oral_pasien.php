<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_gigi_oral_pasien.js"></script>
<script type="text/javascript">
	// TO RESIZE JQGRIB BASED ON WINDOW BROWSER RESIZE
	$(window).bind('resize', function() {
	    $("#listt_gigi").setGridWidth($(window).width()-760);
	}).trigger('resize');
</script>
<div class="mycontent">
<div id="dialogt_gigi" style="color:red;font-size:.75em;display:none" title="Update Foto Oral Gigi">
	<div id="del_dialogt_gigi">
		Hapus Data?
	</div>
	<div id="ins_dialogt_gigi">
		
	</div>
</div>
	<form id="formt_gigi">
		<div class="gridtitle">Daftar Foto Gigi Oral<span class="tambahdata" id="t_gigiadd">Input Foto Gigi</span></div>		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Cari Waktu Foto</label>
						<input type="text" name="kode" class="kode" id="kodet_gigi"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carit_gigi"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resett_gigi"/>
						</span>
					</fieldset>
		<div class="paddinggrid">
		<table id="listt_gigi"></table>
		<div id="pagert_gigi"></div>
		</div >
	</form>
</div>