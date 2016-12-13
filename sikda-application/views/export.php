<script>
$('document').ready(function(){	
	$("#carilb1").click(function(event){
		event.preventDefault();
		mywin = window.open('<?=site_url().'c_export_data/export_sql'?>','mywin');
		setTimeout(closewin,3000);
	});
})
function closewin(){
	mywin.close();
}
</script>
<div class="mycontent">
<div class="formtitle">Export Data</div>
	<form id="formmasterlb1">
	<div class="gridtitle">&nbsp;</div>		
		<fieldset style="margin:0 13px 0 13px ">
			<br>
			<span>						
			<input type="submit" class="cari" value="&nbsp;Export to SQL&nbsp;" id="carilb1"/>
			</span>
		</fieldset>
	</form>
</div>