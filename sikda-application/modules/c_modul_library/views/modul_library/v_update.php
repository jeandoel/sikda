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
		$("#t1007","#tabs").load('c_modul_library');
	});
</script>
<div class="mycontent">
<div class="formtitle">Update Database <?=$namefolder?></div>
</br>
<style>
.font-small{
	font-size: .73em;
}
</style>
<span id='errormsg'></span>
<ol class="font-small">
	
	<li>Download File <?=$namefolder?> Zip</li>
	<li>Install File <?=$namefolder?> Zip</li>
	<li>Insert <?=$namefolder?> Menu</li>
	<li>
		<b>Update Database <?=$namefolder?></b>
		<p><i><?=$log;?></i></p>
	</li>
	<li>Finish</li>
</ol>

<div class="font-small">Terima kasih sudah Install <?=$namefolder?></div>

<div class="backbutton"><span class="kembali" id="nextinstall">Finish</span></div>
<br/>
</div >
