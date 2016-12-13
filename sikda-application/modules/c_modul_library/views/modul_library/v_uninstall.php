<script>
	$('#nextdownload').click(function(){
		$("#t1007","#tabs").empty();
		//$("#t20","#tabs").load('c_modul_library/delete_menu?findmenu=<?=$namemodul?>');
		$("#t1007","#tabs").load('c_modul_library');
	});
</script>
<div class="mycontent">
<div class="formtitle">Start Wizard Uninstall</div>
</br>
<style>
.font-small{
	font-size: .73em;
}
</style>
<span id='errormsg'></span>
<form name="frApps">
	<div class="font-small">Ketika Uninstalasi berjalan, anda tidak boleh menutup window ini, selesaikan sampai finish.</div>
	<ol class="font-small">
		<li>Remove List Menu <?=$namemodul?></li>
		<li>Prepare List File Modul <?=$namemodul?></li>
		<li>
			<b>Uninstall File <?=$namemodul?></b>
			<p><i><?=$log;?></i></p>
		</li>
		<li>Finish</li>
	</ol>
	<div class="font-small">Terima Kasih sudah install modul ini.</div>
	<div class="backbutton"><span class="kembali" id="nextdownload">Finish</span></div>
	<br/>
</form>
</div >
