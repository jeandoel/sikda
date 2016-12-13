<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_sarana.js"></script>

<div class="mycontent">
<div id="dialogt_sarana" class="dialog" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Data Sarana</div>
	<form id="formt_sarana">
		<div class="gridtitle_t">&nbsp;<span id="t_saranamasukadd"><span class="tambahdata_t"></span>Sarana Masuk</span><span id="t_saranakeluaradd"><span class="tambahdata_t"></span>Sarana Keluar</span></div>		
		<fieldset class="fieldsetpencarian" id="fieldset_t_sarana">
			<span>
				<label>Pencarian Sarana</label>
				<input type="text" name="nama_sarana" class="nama_sarana" id="carijenissarana"/>
				<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carit_sarana" />
				<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resett_sarana"/>
			</span>
		</fieldset>
		<div class="paddinggrid" id="Sarana_grid">
		<table id="listt_sarana"></table>
		<div id="pagert_sarana"></div>		
		</div >
	</form>
</div>
