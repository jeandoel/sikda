<script type="text/javascript" src="<?=base_url()?>assets/customjs/master_sarana_posyandu.js"></script>

<div class="mycontent">
<div id="dialogsaranaposyandu" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
<div class="formtitle">Master Sarana Posyandu</div>
	<form id="formmastersaranaposyandu">
		<div class="gridtitle">Daftar Master Sarana Posyandu<span class="tambahdata" id="saranaposyanduadd">Input Master Sarana Posyandu</span></div>
		
		<fieldset style="margin:0 13px 0 13px ">
						<span>
						<label>Cari Sarana Posyandu</label>
						<input type="text" name="nama" class="nama" id="namasarana"/>
						<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimastersaranaposyandu"/>
						<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetmastersaranaposyandu"/>
						</span>
					</fieldset>
		
		<div class="paddinggrid">
		<table id="listmastersaranaposyandu"></table>
		<div id="pagermastersaranaposyandu"></div>
		</div >
	</form>
</div>