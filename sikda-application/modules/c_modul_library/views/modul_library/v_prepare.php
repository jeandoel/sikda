<script>
	/* $("#listmasterstore .icon-edit").live('click', function(d){
		if($(d.target).data('oneclicked')!='yes')
		{
		$("#t20","#tabs").empty();
		$("#t20","#tabs").load('c_modul_library/downloadzip'+'?folder='+this.rel);
		
		}
		$(d.target).data('oneclicked','yes');
	});
	 */
	$('#backlistmaster').click(function(){
		$("#t1007","#tabs").empty();
		$("#t1007","#tabs").load('c_modul_library');
	});
	
	$('#nextdownload').click(function(){
		$("#t1007","#tabs").empty();
		$("#t1007","#tabs").load('c_modul_library/downloadzip?folder=<?=$linkfolder?>');
	});
</script>
<div class="mycontent">
<div class="formtitle">Start Wizard Install</div>
<div class="backbutton"><span class="kembali" id="backlistmaster">kembali ke list</span></div>
</br>
<style>
.font-small{
	font-size: .73em;
}
</style>
<span id='errormsg'></span>
<form name="frApps">
	<div class="font-small">Ketika Instalasi berjalan, anda tidak boleh menutup window ini, selesaikan sampai finish.</div>
	<ol class="font-small">
		<li>Download File <?=$namefolder?> Zip</li>
		<li>Install File <?=$namefolder?> Zip</li>
		<li>Insert <?=$namefolder?> Menu</li>
		<li>Update Database <?=$namefolder?></li>
		<li>Finish</li>
	</ol>
	<div class="backbutton"><span class="kembali" id="nextdownload">Next Download</span></div>
	<br/>
</form>
</div >
