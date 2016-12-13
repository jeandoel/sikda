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
		$("#t1007","#tabs").load('c_modul_library/insert_menu?namefile=<?=$namefolder?>');
	});
</script>
<div class="mycontent">
<div class="formtitle">Install File <?=$namefolder?> Zip</div>
</br>
<style>
.font-small{
	font-size: .73em;
}
</style>
<span id='errormsg'></span>
<ol class="font-small">
	
	<li>Download File <?=$namefolder?> Zip</li>
	<li>
		<b>Install File <?=$namefolder?> Zip</b>
		<p><i><?=$log;?></i></p>
	</li>
	<li>Insert <?=$namefolder?> Menu</li>
	<li>Update Database <?=$namefolder?></li>
	<li>Finish</li>
</ol>

<div class="backbutton"><span class="kembali" id="nextinstall">Next Install Menu</span></div>
<br/>
</div >
