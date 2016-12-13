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
	
	$('#nextinstall').click(function(){
		$("#t1007","#tabs").empty();
		$("#t1007","#tabs").load('c_modul_library/install?namefile=<?=$namefolder?>');
	});
</script>
<div class="mycontent">
<div class="formtitle">Download <?=$namefolder?></div>
</br>
<style>
.font-small{
	font-size: .73em;
}
</style>
<span id='errormsg'></span>
<ol class="font-small">
	<li>
		<b>Download File <?=$namefolder?> Zip</b>
		<p><i><?=$log;?></i></p>
	</li>
	<li>Install File <?=$namefolder?> Zip</li>
	<li>Insert <?=$namefolder?> Menu</li>
	<li>Update Database <?=$namefolder?></li>
	<li>Finish</li>
</ol>

<div class="backbutton"><span class="kembali" id="nextinstall">Next Install file</span></div>
<br/>
</div >
