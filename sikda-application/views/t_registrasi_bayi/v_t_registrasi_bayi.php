<script type="text/javascript" src="<?=base_url()?>assets/customjs/t_registrasi_bayi.js"></script>

<div class="mycontent">
<div id="dialogt_registrasi_bayi" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Registrasi Bayi</div>
	<form id="formt_registrasi_bayi">		
		<div class="gridtitle_t">Daftar Registrasi Bayi<span id="t_registrasi_bayi_add"><span class="tambahdata_t"></span>Registrasi Baru</span></div>
		<fieldset class="fieldsetpencarian" id="fieldset_t_registrasi">
						<span>
						<label>Cari Registrasi Bayi </label>
						<input type="text" name="kd_reg_bayi" class="kd_reg_bayi" id="caribayi"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carit_registrasi_bayi"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resett_registrasi_bayi"/>
						</span>	
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listt_registrasi_bayi"></table>
		<div id="pagert_registrasi_bayi"></div>
		</div >
	</form>
</div>