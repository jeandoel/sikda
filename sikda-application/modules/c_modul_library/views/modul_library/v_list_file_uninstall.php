<script>
	$('#nextdownload').click(function(){
		$("#t1007","#tabs").empty();
		$("#t1007","#tabs").load('c_modul_library/uninstall?namemodul=<?=$namemodul?>');
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
		<li>
			<b>Prepare List File Modul <?=$namemodul?></b>
			<p><i><?=$log;?></i></p>
		</li>
		<li>Uninstall File <?=$namemodul?></li>
		<li>Finish</li>
	</ol>
	<div class="backbutton"><span class="kembali" id="nextdownload">Next Uninstall</span></div>
	<br/>
</form>
</div >
