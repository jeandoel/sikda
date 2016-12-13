<script type="text/javascript" src="<?=base_url()?>assets/c_modul_library/js/modul.js"></script>

<img style="float:right; cursor:pointer" title="Klik untuk Guide" onclick="introJs().start()" src="<?=base_url()?>assets/intro/wh32.png"/>

<div class="mycontent" data-intro="ini merupakan daftar modul yang sudah terinstall, jika ingin menghapus klik tombol <a class='icon-delete'></a>">
<div id="dialoginstalled" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
	<div class="formtitle">Installed Modul Library</div>
	<form id="formmaster_hasupdate">
		<div class="gridtitle">Daftar Modul Library</div>
		<div class="paddinggrid">
		<table id="listmaster_hasupdate"></table>
		<div id="pagermaster_hasupdate"></div>
		</div >
	</form>
</div>

<div class="mycontent" data-intro="ini merupakan daftar modul yang update, untuk update klik <a class='icon-edit'></a> dikolom action">
<div id="dialoginstalled" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
	<div class="formtitle">Update Modul Library</div>
	<form id="formmaster_installed">
		<div class="gridtitle">Daftar Modul Library</div>
		<div class="paddinggrid">
		<table id="listmaster_installed"></table>
		<div id="pagermaster_installed"></div>
		</div >
	</form>
</div>

<div class="mycontent" data-intro="ini merupakan daftar modul terbaru, click tombol <a class='icon-edit'></a> untuk menginstall">
<div id="dialog" style="color:red;font-size:.75em;display:none" title="Confirmation Required">
  Hapus Data?
</div>
	<div class="formtitle">Find Store Modul Library</div>
	<form id="formmasterstore">
		<div class="gridtitle">Daftar Modul Library</div>
		<div class="paddinggrid">
		<table id="listmasterstore"></table>
		<div id="pagermasterstore"></div>
		</div >
	</form>
	
</div>