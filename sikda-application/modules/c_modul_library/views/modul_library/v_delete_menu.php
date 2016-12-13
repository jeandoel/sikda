<script>
	$('#backlistmaster').click(function(){
		$("#t1007","#tabs").empty();
		//$("#t20","#tabs").load('c_modul_library');
		$("#t1007","#tabs").load('c_modul_library/list_file_uninstall?namemodul=<?=$namemodul?>');
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
		<li>
			<b>Remove List Menu <?=$namemodul?></b>
			<p><i><?=$log;?></i></p>
		</li>
		<li>Prepare List File Modul <?=$namemodul?></li>
		<li>Uninstall File <?=$namemodul?></li>
		<li>Finish</li>
	</ol>
	
	
	<div class="backbutton"><span class="kembali" id="backlistmaster">Next Prepare List File</span></div>
	<br/>
</form>
</div >
