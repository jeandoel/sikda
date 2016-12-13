<script>
$(document).ready(function(){
		$('#form1masterusergroupedit').ajaxForm({
			beforeSend: function() {
				achtungShowLoader();	
			},
			uploadProgress: function(event, position, total, percentComplete) {
			},
			complete: function(xhr) {
				achtungHideLoader();
				if(xhr.responseText!=='OK'){
					$.achtung({message: xhr.responseText, timeout:5});
				}else{
					$.achtung({message: 'Proses Ubah Data Berhasil', timeout:5});
					$("#t17","#tabs").empty();
					$("#t17","#tabs").load('c_master_user_group'+'?_=' + (new Date()).getTime());
				}
			}
		});
		
		jQuery("#menu-grid").jqGrid({
			url: "C_master_user_group/menu?id=<?=$_GET['id']?>",
			datatype: "xml",
			height: "auto",
			pager: false,
			loadui: "disable",
			colNames: ["id","Menu","url","check"],
			colModel: [
				{name: "id",width:1,hidden:true, key:true},
				{name: "menu", width:100, resizable: false, sortable:false, expanded: true},			
				{name: "url",width:1,hidden:true},
				{name: 'MyCheckBox', width:50, index: 'MyCheckBox', hidden: false, editable: true, edittype: 'checkbox', editoptions: { value: "True:False" }, formatter: "checkbox", formatoptions: { disabled: false }, search: true }
			],
			treeGrid: true,
			gridview: true,
			ExpandColumn: "menu",
			autowidth: true,
			rowNum: 200,
			ExpandColClick: true,
			treeIcons: {leaf:'ui-icon-document-b'},
			beforeSelectRow: function (rowid, e) {
				achtungShowLoader();
				var state = $(e.target).prop("checked");	
				$.ajax({
					url: 'C_master_user_group/add_hak_akses_user?id=<?=$_GET['id']?>&idmenu='+rowid+'&state='+state,
					type: "GET",
					dataType: "html",
					cache:false,
					complete : function (req, err) {
						//$(st,"#tabs").append(req.responseText);
						achtungHideLoader();
					}
				}); 
			},
			onSelectRow: function(rowid) {
				/* $.ajax({
					url: treedata.url,
					type: "GET",
					dataType: "html",
					cache:false,
					complete : function (req, err) {
						$(st,"#tabs").append(req.responseText);
						//achtungHideLoader();
					}
				}); */
			}
		});
})
</script>
<script>
	$('#backlistmasterusergroup').click(function(){
		$("#t17","#tabs").empty();
		$("#t17","#tabs").load('c_master_user_group'+'?_=' + (new Date()).getTime());
	})
	$('#tglkejadianedit').datepicker({dateFormat: "yy-mm-dd",changeYear: true});
</script>
<div class="mycontent">
<div class="formtitle">Edit Group Pengguna</div>
<div class="backbutton"><span class="kembali" id="backlistmasterusergroup">kembali ke list</span></div>
</br>

<span id='errormsg'></span>
<form name="frApps" id="form1masterusergroupedit" method="post" action="<?=site_url('c_master_user_group/editprocess')?>" enctype="multipart/form-data">
	<fieldset>
		<span>
		<label>Group Id</label>
		<input type="text" name="idgroup" id="text1" value="<?=$data->group_id?>" />
		<input type="hidden" name="id" id="textid" value="<?=$data->group_id?>" />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Group Name</label>
		<input type="text" name="namagroup" id="text2" value="<?=$data->group_name?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<label>Description</label>
		<input type="text" name="deskripsi" id="text2" value="<?=$data->description?>"  />
		</span>
	</fieldset>
	<fieldset>
		<span>
		<input type="submit" name="bt1" value="Proses Data"/>
		</span>
	</fieldset>
</form>
</div >
<div class="ui-layout-west">
		<table id="menu-grid"></table>
	</ul>
</div>