<script>
jQuery().ready(function (){ 
	jQuery("#listusergrouppopup").jqGrid({ 
		url:'c_master_user_group/masterusergroupxml', 
		emptyrecords: 'Nothing to display',
		datatype: "xml", 
		colNames:['Pilih','Group Id','Group Name','Description','Action'],
		rownumbers:true,
		width: 1021,
		height: 'auto',
		mtype: 'POST',
		altRows     : true,		
		colModel:[ 
				{name:'id',index:'id', width:15,formatter:formatterAction},
				{name:'idgroup',index:'idgroup', width:75},	
				{name:'namagroup',index:'namagroup', width:100},
				{name:'deskripsi',index:'deskripsi', width:100,hidden:true},
				{name:'myid',index:'myid', width:91,align:'center',hidden:true}
			],
			rowNum:5, 
			rowList:[5,20,30], 
			pager: jQuery('#pagerusergrouppopup'), 
			viewrecords: true, 
			sortorder: "desc",
			beforeRequest:function(){
				group=$('#groupid_mastergrouppopup').val()?$('#groupid_mastergrouppopup').val():'';
				$('#listusergrouppopup').setGridParam({postData:{'group':group}})
			}
	}).navGrid('#pagerusergrouppopup',{edit:false,add:false,del:false,search:false});
	
	function formatterAction(cellvalue, options, rowObject) {
		var content = '';
		return '<input type="checkbox" class="chk" name="chk[]" id="chkkec" />';
		return content;
	}	
	
	$("#chkkec.chk").live('click', function(){		
		$("#listusergrouppopup").find('input[type=checkbox]').each(function() {
			$(this).change( function(){
				var colid = $(this).parents('tr:last').attr('id');
				if( $(this).is(':checked')) {
					$("#listusergrouppopup").jqGrid('setSelection', colid );
					$(this).prop('checked',true);
					var myCellDataId = jQuery('#listusergrouppopup').jqGrid('getCell', colid, 'myid');
					var myCellDataNamausergroup = jQuery('#listusergrouppopup').jqGrid('getCell', colid, 'namagroup');
					$('#<?=$id_caller?> #master_user_group_hidden').val(myCellDataId);
					$('#<?=$id_caller?> #master_user_group').val(myCellDataNamausergroup);
					$("#dialogcari_master_user_group_id").dialog("close");
				}
			});	
		});
	});
	
	$('form').resize(function(y) {
		if($("#listusergrouppopup").getGridParam("records")>0){
		jQuery('#listusergrouppopup').setGridWidth(($(this).width()));
		}
	});
	
	jQuery.fn.reset = function (){
	  $(this).each (function() { this.reset(); });
	}
	$("#resetusergrouppopup").live('click', function(event){
		event.preventDefault();
		$('#formusergrouppopup').reset();
		$('#listusergrouppopup').trigger("reloadGrid");
	});
	$("#carimasterusergroup").live('click', function(event){
		event.preventDefault();
		$('#listusergrouppopup').trigger("reloadGrid");
	});
	
})
</script>

<div class="mycontent">
	<form id="formusergrouppopup">
		<div class="gridtitle">Daftar Group Id</div>
		<fieldset style="margin:0 13px 0 13px ">
			<span>
				<label>Cari Group Pengguna</label>
				<input type="text" name="groupid" class="groupid" id="groupid_mastergrouppopup"/>
			</span>
			<span>
				<input type="submit" class="cari" value="&nbsp;Cari&nbsp;" id="carimasterusergroup" />
				<input type="submit" class="reset" value="&nbsp;Reset&nbsp;" id="resetusergrouppopup" />
			</span>
		</fieldset>
		<table id="listusergrouppopup"></table>
		<div id="pagerusergrouppopup"></div>
	</form>
</div>