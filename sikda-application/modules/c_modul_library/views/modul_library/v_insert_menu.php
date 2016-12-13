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
	
	var id_menu = '';
	
	function change_menu(elem,param1){
		//alert();
		//elem.background.style = 'black';
		//$(this).parent().css("background-color","#cdcdcd");
		id_menu = param1;
	}
	
	$('#backlistmaster').click(function(){
		$("#t1007","#tabs").empty();
		$("#t1007","#tabs").load('c_modul_library');
	});
	
	$('#nextinstall').click(function(){
		$("#t1007","#tabs").empty();
		//$("#t20","#tabs").load('c_modul_library/update_database?namefile=<?=$namefolder?>');
		$("#t1007","#tabs").load('c_modul_library/update_database?namefile=<?=$namefolder?>&id_menu='+id_menu);
	});
</script>
<div class="mycontent">
<div class="formtitle">Choice Place <?=$namefolder?> Menu</div>
</br>
<style>
.font-small{
	font-size: .73em;
}
#menutree label{
	cursor: pointer;
	display:inline-block;
	float: none;
	text-align:left;
}

#menutree, ul{
	list-style:none;
}
</style>
<span id='errormsg'></span>

<div class="font-small">
<?
$querymenu = $this->db->query(" SELECT * FROM `config_menu` WHERE level='0'");
		
echo "<ul id='menutree'>";
foreach ($querymenu->result_array() as $row){
	$inclevel = 1;
	
	echo "<li><input onclick=\"change_menu(this,'".$row['id_menu']."')\" type=\"radio\" name=\"menu\" id='".$row['id_menu']."'/><label for='".$row['id_menu']."'>".$row['title']."</label>";
	echo "<ul>";
	//level 0
		$querymenu2 = $this->db->query(" SELECT * FROM `config_menu` WHERE level='".$inclevel."' AND parent='".$row['id_menu']."'");
		foreach ($querymenu2->result_array() as $row2){
			$inclevel++;
			
			echo "<li><input onclick=\"change_menu(this,'".$row2['id_menu']."')\" type=\"radio\" name=\"menu\" id='".$row2['id_menu']."'/><label for='".$row2['id_menu']."'>".$row2['title']."</label>";
			echo "<ul>";
			
			$querymenu3 = $this->db->query(" SELECT * FROM `config_menu` WHERE level='".$inclevel."' AND parent='".$row2['id_menu']."'");
			foreach ($querymenu3->result_array() as $row3){
				echo "<li><input onclick=\"change_menu(this,'".$row3['id_menu']."')\" type=\"radio\" name=\"menu\" id='".$row3['id_menu']."'/><label for='".$row3['id_menu']."'>".$row3['title']."</label>";
				echo "</li>";
			}
			echo "</ul>";
			echo "</li>";
		}
	echo "</ul>";
	echo "</li>";
	
}
echo "</ul>";
?>
</div>
<ol class="font-small">
	
	<li>Download File <?=$namefolder?> Zip</li>
	<li>Install File <?=$namefolder?> Zip</li>
	<li>
		<b>Insert <?=$namefolder?> Menu</b>
		<p><i><?=$log;?></i></p>
	</li>
	<li>Update Database <?=$namefolder?></li>
	<li>Finish</li>
</ol>

<div class="backbutton"><span class="kembali" id="nextinstall">Next Update Database</span></div>
<br/>
</div >
